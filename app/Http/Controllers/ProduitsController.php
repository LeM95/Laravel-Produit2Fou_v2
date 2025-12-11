<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produits;  // ← Import du Model

use App\Models\Image;  // ← AJOUTEZ CETTE LIGNE


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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validation des images

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


    /**
     * Display the specified resource.
     */
    public function show(Produits $produits)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produits $produits)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produits $produits)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produits $produits)
    {
        //
    }
}
