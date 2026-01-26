<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produits;
use App\Models\Service;

class PublicController extends Controller
{
    public function accueil()
    {
        $produits = Produits::with('images')->latest()->take(6)->get();
        $services = Service::latest()->take(3)->get();
        return view('public.accueil', compact('produits', 'services'));
    }

    public function produits()
    {
        try {
            $produits = Produits::with('images')
                ->where('visible', true)
                ->orderBy('ordre', 'asc')
                ->orderBy('id', 'desc')
                ->get();
        } catch (\Exception $e) {
            $produits = Produits::with('images')->orderBy('id', 'desc')->get();
        }
        return view('public.produits', compact('produits'));
    }

    public function produitDetail($id)
    {
        $produit = Produits::with('images')->findOrFail($id);
        return view('public.produit-detail', compact('produit'));
    }

    public function services()
    {
        $services = Service::with('videos')->get();
        return view('public.services', compact('services'));
    }

    public function contact()
    {
        return view('public.contact');
    }
}
