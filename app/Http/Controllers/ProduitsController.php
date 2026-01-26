<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produits;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;


class ProduitsController extends Controller
{
    public function index()
    {
        try {
            $produits = Produits::orderBy('ordre', 'asc')->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            // Si la colonne ordre n'existe pas, on trie par id
            $produits = Produits::orderBy('id', 'desc')->get();
        }
        return view('parametre', compact('produits'));
    }


    public function create(Request $request)
    {
        $validateddata = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required|max:1500',
            'prix' => 'required|numeric|min:0',
            'images.*' => 'nullable|file|max:10240', // Validation des images (10MB max) - accepte tous les formats

        ]);

        $produit = Produits::create($validateddata);

        // 2. Upload des images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Stocker l'image dans storage/app/public/products
                $path = $image->store('products', 'public');

                // Créer l'entrée dans la table images
                Image::create([
                    'produit_id' => $produit->id,  // ← CLÉ ÉTRANGÈRE!
                    'chemin_image' => $path,
                    'ordre' => $index,
                ]);
            }
        }
        return redirect('/30032006')->with('success', 'Produit ajouté!'); // ← Retour vers parametre    
    }


    public function edit($id)
    {
        $produit = Produits::with('images')->findOrFail($id);
        $produits = Produits::all();
        return view('parametre', compact('produits', 'produit'));
    }

    public function update(Request $request, $id)
    {
        $produit = Produits::findOrFail($id);

        $validateddata = $request->validate([
            'nom' => 'required|max:255',
            'description' => 'required|max:1500',
            'prix' => 'required|numeric|min:0',
            'images.*' => 'nullable|file|max:10240',
        ]);

        $produit->update($validateddata);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                Image::create([
                    'produit_id' => $produit->id,
                    'chemin_image' => $path,
                    'ordre' => $produit->images->count() + $index,
                ]);
            }
        }

        return redirect('/30032006')->with('success', 'Produit mis à jour!');
    }

    public function destroy($id)
    {
        $produit = Produits::findOrFail($id);

        foreach ($produit->images as $image) {
            Storage::disk('public')->delete($image->chemin_image);
            $image->delete();
        }

        $produit->delete();

        return redirect('/30032006')->with('success', 'Produit supprimé!');
    }

    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        Storage::disk('public')->delete($image->chemin_image);
        $image->delete();

        // Return JSON for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Image supprimée!');
    }

    public function updateOrdre(Request $request)
    {
        try {
            // Get produits - could be JSON string or array
            $produits = $request->input('produits', []);

            // If it's a JSON string, decode it
            if (is_string($produits)) {
                $produits = json_decode($produits, true);
            }

            if (empty($produits) || !is_array($produits)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Aucun produit reçu'
                ], 400);
            }

            $updated = 0;
            foreach ($produits as $item) {
                $id = $item['id'] ?? null;
                $ordre = $item['ordre'] ?? null;

                if ($id !== null && $ordre !== null) {
                    Produits::where('id', (int)$id)->update(['ordre' => (int)$ordre]);
                    $updated++;
                }
            }

            return response()->json(['success' => true, 'updated' => $updated]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Exception: ' . $e->getMessage()], 500);
        }
    }

    public function toggleVisibility($id)
    {
        try {
            $produit = Produits::findOrFail($id);
            $produit->visible = !$produit->visible;
            $produit->save();

            return response()->json([
                'success' => true,
                'visible' => $produit->visible
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
