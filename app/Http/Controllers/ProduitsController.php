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
        $produits =  Produits::all();
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

        return back()->with('success', 'Image supprimée!');
    }
}
