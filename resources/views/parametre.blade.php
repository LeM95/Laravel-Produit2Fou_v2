<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    {{-- Formulaire d'ajout --}}
<form action="/30032006/create" method="POST" enctype="multipart/form-data">
    @csrf
    
    <label>Nom:</label>
    <input type="text" name="nom" required>
    
    <label>Description:</label>
    <textarea name="description" required></textarea>
    
    <label>Prix (€):</label>
    <input type="number" name="prix" step="0.01" min="0" required>
    
    <label>Photos (plusieurs autorisées):</label>
    <input type="file" name="images[]" multiple accept="image/*">
    
    <button type="submit">Ajouter</button>
</form>

@foreach($produits as $produit)
    <div style="border: 1px solid #ccc; padding: 10px; margin: 10px 0;">
        <h3>{{ $produit->nom }}</h3>
        <p>{{ $produit->description }}</p>
        <p><strong>Prix: {{ $produit->prix }} €</strong></p>
        
        {{-- Afficher les images --}}
        @foreach($produit->images as $image)
            <img src="{{ asset('storage/' . $image->chemin_image) }}" 
                 alt="{{ $produit->nom }}" 
                 style="width: 100px; height: 100px; object-fit: cover; margin: 5px;">
        @endforeach
    </div>
@endforeach
    
</body>
</html>