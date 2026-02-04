<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use App\Models\InventaireCategorie;
use App\Models\InventaireMouvement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventaireController extends Controller
{
    public function index()
    {
        $items = Inventaire::with('categorie')->orderBy('nom')->get();
        $categories = InventaireCategorie::orderBy('nom')->get();
        $lowStockCount = Inventaire::whereRaw('stock <= stock_min')->count();

        return view('inventaire', compact('items', 'categories', 'lowStockCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $data = $request->only([
            'nom', 'description', 'emplacement', 'prix_achat',
            'stock', 'stock_min', 'categorie_id', 'fournisseur'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('inventaire', 'public');
            $data['photo'] = $path;
        }

        $item = Inventaire::create($data);

        // Record initial stock movement
        if ($item->stock > 0) {
            InventaireMouvement::create([
                'inventaire_id' => $item->id,
                'type' => 'entree',
                'quantite' => $item->stock,
                'note' => 'Stock initial'
            ]);
        }

        return redirect()->back()->with('success', 'Produit ajouté à l\'inventaire!');
    }

    public function update(Request $request, $id)
    {
        $item = Inventaire::findOrFail($id);

        $data = $request->only([
            'nom', 'description', 'emplacement', 'prix_achat',
            'stock_min', 'categorie_id', 'fournisseur'
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($item->photo) {
                Storage::disk('public')->delete($item->photo);
            }
            $path = $request->file('photo')->store('inventaire', 'public');
            $data['photo'] = $path;
        }

        $item->update($data);

        return redirect()->back()->with('success', 'Produit mis à jour!');
    }

    public function destroy($id)
    {
        $item = Inventaire::findOrFail($id);

        // Delete photo if exists
        if ($item->photo) {
            Storage::disk('public')->delete($item->photo);
        }

        // Delete all stock movements related to this item
        InventaireMouvement::where('inventaire_id', $id)->delete();

        // Remove from service packs (set inventaire_id to null or delete the items)
        \App\Models\ReservationServiceItem::where('inventaire_id', $id)->delete();

        $item->delete();

        return redirect()->back()->with('success', 'Produit supprimé de l\'inventaire!');
    }

    public function ajouterStock(Request $request, $id)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $item = Inventaire::findOrFail($id);
        $quantite = (int) $request->quantite;

        $item->stock += $quantite;
        $item->save();

        InventaireMouvement::create([
            'inventaire_id' => $item->id,
            'type' => 'entree',
            'quantite' => $quantite,
            'note' => $request->note ?? null
        ]);

        return response()->json([
            'success' => true,
            'new_stock' => $item->stock,
            'is_low' => $item->isLowStock()
        ]);
    }

    public function retirerStock(Request $request, $id)
    {
        $request->validate([
            'quantite' => 'required|integer|min:1',
        ]);

        $item = Inventaire::findOrFail($id);
        $quantite = (int) $request->quantite;

        if ($quantite > $item->stock) {
            return response()->json([
                'success' => false,
                'error' => 'Stock insuffisant'
            ], 400);
        }

        $item->stock -= $quantite;
        $item->save();

        InventaireMouvement::create([
            'inventaire_id' => $item->id,
            'type' => 'sortie',
            'quantite' => $quantite,
            'note' => $request->note ?? null
        ]);

        return response()->json([
            'success' => true,
            'new_stock' => $item->stock,
            'is_low' => $item->isLowStock()
        ]);
    }

    public function historique($id)
    {
        $item = Inventaire::with('mouvements')->findOrFail($id);

        return response()->json([
            'success' => true,
            'item' => $item->nom,
            'mouvements' => $item->mouvements->map(function($m) {
                return [
                    'type' => $m->type,
                    'quantite' => $m->quantite,
                    'note' => $m->note,
                    'date' => $m->created_at->format('d/m/Y H:i')
                ];
            })
        ]);
    }

    public function storeCategorie(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:255']);

        InventaireCategorie::create(['nom' => $request->nom]);

        return redirect()->back()->with('success', 'Catégorie ajoutée!');
    }

    public function destroyCategorie($id)
    {
        $categorie = InventaireCategorie::findOrFail($id);

        // Set category to null for all items using this category
        Inventaire::where('categorie_id', $id)->update(['categorie_id' => null]);

        $categorie->delete();

        return redirect()->back()->with('success', 'Catégorie supprimée!');
    }
}
