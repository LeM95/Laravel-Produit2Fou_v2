<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Produits2Fou</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar-header h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 13px;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
            border-left-color: white;
        }

        .menu-icon {
            font-size: 20px;
            width: 25px;
        }

        .menu-text {
            font-weight: 500;
            font-size: 15px;
        }

        /* MOBILE TOGGLE */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: #667eea;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .content-section {
            display: none;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .content-section.active {
            display: block;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }

        /* FORMS */
        .form-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            font-size: 14px;
        }

        .form-input,
        .form-textarea {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        /* PRODUCT/SERVICE CARDS */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .item-card {
            background: #f8f9fa;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .item-card:hover {
            transform: translateY(-5px);
        }

        .item-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
        }

        .item-content {
            padding: 20px;
        }

        .item-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .item-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .item-price {
            font-size: 22px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
        }

        .item-actions {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            padding: 8px 15px;
            font-size: 13px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-small:hover {
            transform: scale(1.05);
        }

        .btn-edit {
            background: #667eea;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .images-preview {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .image-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e0e0e0;
        }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 600px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .modal-close {
            background: #e0e0e0;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 80px 15px 20px;
            }

            .items-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                width: 250px;
            }

            .modal-content {
                padding: 20px;
            }
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }

        .logout-btn {
            margin: 20px;
            padding: 12px 20px;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            width: calc(100% - 40px);
        }

        .no-items {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .badge-notif {
            background: #dc3545;
            color: white;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 50px;
            margin-left: auto;
            min-width: 22px;
            text-align: center;
        }

        .ordre-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            z-index: 10;
        }

        .ordre-btn {
            width: 28px;
            height: 28px;
            background: rgba(102, 126, 234, 0.9);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .ordre-btn:hover {
            background: #764ba2;
        }

        .ordre-num {
            background: #333;
            color: white;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
        }

        .item-card {
            position: relative;
        }

        .item-card.hidden-product {
            opacity: 0.5;
            filter: grayscale(70%);
        }

        .visibility-btn {
            width: 28px;
            height: 28px;
            background: rgba(40, 167, 69, 0.9);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
            margin-top: 4px;
        }

        .visibility-btn:hover {
            background: #1e7e34;
        }

        .visibility-btn.hidden {
            background: rgba(220, 53, 69, 0.9);
        }

        .visibility-btn.hidden:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <div class="admin-container">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1>🎨 Admin Panel</h1>
                <p>Produits2Fou</p>
            </div>

            <nav class="sidebar-menu">
                <div class="menu-item active" onclick="showSection('produits')">
                    <span class="menu-icon">📦</span>
                    <span class="menu-text">Produits</span>
                </div>
                <div class="menu-item" onclick="showSection('services')">
                    <span class="menu-icon">🎬</span>
                    <span class="menu-text">Services</span>
                </div>
                <div class="menu-item" onclick="window.location.href='{{ route('admin.inventaire.index') }}'">
                    <span class="menu-icon">📦</span>
                    <span class="menu-text">Inventaire</span>
                    @php
                        try {
                            $lowStock = \App\Models\Inventaire::whereRaw('stock <= stock_min')->count();
                        } catch (\Exception $e) {
                            $lowStock = 0;
                        }
                    @endphp
                    @if($lowStock > 0)
                        <span class="badge-notif">{{ $lowStock }}</span>
                    @endif
                </div>
                <div class="menu-item" onclick="window.location.href='{{ route('admin.messages.index') }}'">
                    <span class="menu-icon">💬</span>
                    <span class="menu-text">Messagerie</span>
                    @php
                        try {
                            $unreadMessages = \App\Models\Message::where('lu', false)->count();
                        } catch (\Exception $e) {
                            $unreadMessages = 0;
                        }
                    @endphp
                    @if($unreadMessages > 0)
                        <span class="badge-notif">{{ $unreadMessages }}</span>
                    @endif
                </div>
                <div class="menu-item" onclick="showSection('contact')">
                    <span class="menu-icon">📞</span>
                    <span class="menu-text">Contact</span>
                </div>
                <div class="menu-item" onclick="window.location.href='{{ route('planning.index') }}'">
                    <span class="menu-icon">📅</span>
                    <span class="menu-text">Planning</span>
                </div>
                <div class="menu-item" onclick="window.location.href='{{ route('accueil') }}'">
                    <span class="menu-icon">🌐</span>
                    <span class="menu-text">Voir le site</span>
                </div>
            </nav>

            <button class="logout-btn" onclick="window.location.href='{{ route('accueil') }}'">
                🚪 Quitter l'admin
            </button>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <!-- SECTION PRODUITS -->
            <section id="produits" class="content-section active">
                <h2 class="section-title">Gestion des Produits</h2>

                <form action="/30032006/create" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom du produit *</label>
                            <input type="text" name="nom" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-textarea" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Prix (€) *</label>
                            <input type="number" name="prix" step="0.01" min="0" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Photos (plusieurs autorisées)</label>
                            <input type="file" name="images[]" multiple accept="image/*" class="form-input">
                        </div>
                    </div>

                    <button type="submit" class="btn">➕ Ajouter le produit</button>
                </form>

                <div class="items-grid" id="produitsGrid">
                    @forelse($produits as $index => $produit)
                        <div class="item-card {{ ($produit->visible ?? true) ? '' : 'hidden-product' }}" data-id="{{ $produit->id }}" data-ordre="{{ $produit->ordre ?? 0 }}" data-visible="{{ ($produit->visible ?? true) ? '1' : '0' }}">
                            <div class="ordre-controls">
                                <button type="button" class="ordre-btn" onclick="moveProduct({{ $produit->id }}, 'up')" title="Monter">▲</button>
                                <span class="ordre-num">{{ $index + 1 }}</span>
                                <button type="button" class="ordre-btn" onclick="moveProduct({{ $produit->id }}, 'down')" title="Descendre">▼</button>
                                <button type="button" class="visibility-btn {{ ($produit->visible ?? true) ? '' : 'hidden' }}" onclick="toggleVisibility({{ $produit->id }}, this)" title="{{ ($produit->visible ?? true) ? 'Masquer' : 'Afficher' }}">
                                    {{ ($produit->visible ?? true) ? '👁️' : '🚫' }}
                                </button>
                            </div>
                            @if($produit->images->count() > 0)
                                <img src="{{ asset('storage/' . $produit->images->first()->chemin_image) }}"
                                     alt="{{ $produit->nom }}"
                                     class="item-image">
                            @else
                                <div class="item-image"></div>
                            @endif

                            <div class="item-content">
                                <div class="item-title">{{ $produit->nom }}</div>
                                <div class="item-description">{{ $produit->description }}</div>
                                <div class="item-price">{{ number_format($produit->prix, 2) }} €</div>

                                @if($produit->images->count() > 1)
                                    <div class="images-preview">
                                        @foreach($produit->images as $image)
                                            <img src="{{ asset('storage/' . $image->chemin_image) }}"
                                                 class="image-thumb"
                                                 alt="{{ $produit->nom }}">
                                        @endforeach
                                    </div>
                                @endif

                                <div class="item-actions" style="margin-top: 15px;">
                                    <button class="btn-small btn-edit"
                                            data-id="{{ $produit->id }}"
                                            data-nom="{{ $produit->nom }}"
                                            data-description="{{ $produit->description }}"
                                            data-prix="{{ $produit->prix }}"
                                            data-images="{{ json_encode($produit->images->map(function($img) { return ['id' => $img->id, 'chemin' => asset('storage/' . $img->chemin_image)]; })) }}"
                                            onclick="editProduct(this)">
                                        ✏️ Modifier
                                    </button>
                                    <form action="{{ route('admin.produits.destroy', $produit->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Supprimer ce produit?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-small btn-delete">🗑️ Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-items">
                            <h3>📦 Aucun produit</h3>
                            <p>Créez votre premier produit ci-dessus!</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- SECTION SERVICES -->
            <section id="services" class="content-section">
                <h2 class="section-title">Gestion des Services</h2>

                <!-- Formulaire de création -->
                <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Nom du service *</label>
                            <input type="text" name="nom" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description *</label>
                            <textarea name="description" class="form-textarea" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Image de couverture</label>
                            <input type="file" name="image" accept="image/*" class="form-input">
                        </div>
                    </div>

                    <button type="submit" class="btn">➕ Créer le service</button>
                </form>

                <div class="items-grid">
                    @php
                        $services = \App\Models\Service::with('videos')->get();
                    @endphp

                    @forelse($services as $service)
                        <div class="item-card">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}"
                                     alt="{{ $service->nom }}"
                                     class="item-image">
                            @else
                                <div class="item-image"></div>
                            @endif

                            <div class="item-content">
                                <div class="item-title">{{ $service->nom }}</div>
                                <div class="item-description">{{ $service->description }}</div>
                                <p style="color: #666; font-size: 14px; margin: 10px 0;">
                                    🎬 {{ $service->videos->count() }} vidéo(s)
                                </p>

                                <div class="item-actions">
                                    <button class="btn-small btn-edit"
                                            onclick="window.open('/30032006/services/{{ $service->id }}/edit', '_blank')">
                                        ✏️ Gérer vidéos
                                    </button>
                                    <button class="btn-small btn-edit"
                                            onclick='editService({{ $service->id }}, "{{ str_replace('"', '&quot;', $service->nom) }}", "{{ str_replace('"', '&quot;', $service->description) }}")'>
                                        ✏️ Modifier
                                    </button>
                                    <form action="{{ route('services.destroy', $service->id) }}"
                                          method="POST"
                                          style="display: inline;"
                                          onsubmit="return confirm('Supprimer ce service et toutes ses vidéos?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-small btn-delete">🗑️ Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="no-items">
                            <h3>🎬 Aucun service</h3>
                            <p>Créez votre premier service ci-dessus!</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- SECTION CONTACT -->
            <section id="contact" class="content-section">
                <h2 class="section-title">Paramètres de Contact</h2>

                <div style="background: #fff3cd; padding: 20px; border-radius: 10px; border: 1px solid #ffc107; margin-bottom: 20px;">
                    <strong>ℹ️ Info:</strong> Pour modifier les informations de contact, éditez le fichier
                    <code>resources/views/public/contact.blade.php</code>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Magasin Principal - Adresse</label>
                        <input type="text" class="form-input" value="123 Rue de la Paix, 75001 Paris" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Téléphone Principal</label>
                        <input type="text" class="form-input" value="+33 1 23 45 67 89" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Magasin 2 - Adresse</label>
                        <input type="text" class="form-input" value="456 Avenue des Champs, 69002 Lyon" readonly>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Téléphone Magasin 2</label>
                        <input type="text" class="form-input" value="+33 4 98 76 54 32" readonly>
                    </div>
                </div>

                <p style="color: #666; font-size: 14px; margin-top: 20px;">
                    💡 Pour modifier ces informations, ouvrez le fichier contact.blade.php et changez les valeurs directement dans le code.
                </p>
            </section>
        </main>
    </div>

    <!-- MODAL EDIT PRODUCT -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modifier le produit</h3>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nom du produit *</label>
                        <input type="text" name="nom" id="edit_nom" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description *</label>
                        <textarea name="description" id="edit_description" class="form-textarea" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Prix (€) *</label>
                        <input type="number" name="prix" id="edit_prix" step="0.01" min="0" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Photos actuelles</label>
                        <div id="current_images" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 10px;"></div>
                        <p style="font-size: 12px; color: #999;">Cliquez sur le X rouge pour supprimer une photo</p>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ajouter des photos supplementaires</label>
                        <input type="file" name="images[]" multiple accept="image/*" class="form-input">
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn">💾 Enregistrer</button>
                    <button type="button" class="btn" style="background: #6c757d;" onclick="closeEditModal()">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT SERVICE -->
    <div class="modal" id="editServiceModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modifier le service</h3>
                <button class="modal-close" onclick="closeEditServiceModal()">×</button>
            </div>

            <form id="editServiceForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nom du service *</label>
                        <input type="text" name="nom" id="edit_service_nom" class="form-input" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Description *</label>
                        <textarea name="description" id="edit_service_description" class="form-textarea" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Changer l'image de couverture</label>
                        <input type="file" name="image" accept="image/*" class="form-input">
                    </div>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn">💾 Enregistrer</button>
                    <button type="button" class="btn" style="background: #6c757d;" onclick="closeEditServiceModal()">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });

            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });

            document.getElementById(sectionId).classList.add('active');
            event.currentTarget.classList.add('active');

            if (window.innerWidth <= 768) {
                toggleSidebar();
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        function editProduct(btn) {
            const id = btn.dataset.id;
            const nom = btn.dataset.nom;
            const description = btn.dataset.description;
            const prix = btn.dataset.prix;
            let images = [];

            try {
                images = JSON.parse(btn.dataset.images);
            } catch(e) {
                images = [];
            }

            document.getElementById('edit_nom').value = nom;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_prix').value = prix;
            document.getElementById('editForm').action = '/30032006/produit/' + id;

            // Afficher les images actuelles
            const imagesContainer = document.getElementById('current_images');
            imagesContainer.innerHTML = '';

            if (images && images.length > 0) {
                images.forEach(function(img) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.style.cssText = 'position: relative; display: inline-block;';
                    imgWrapper.innerHTML = `
                        <img src="${img.chemin}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 2px solid #e0e0e0;">
                        <button type="button" onclick="deleteImage(${img.id}, this)" style="position: absolute; top: -8px; right: -8px; width: 24px; height: 24px; background: #dc3545; color: white; border: none; border-radius: 50%; cursor: pointer; font-size: 14px; font-weight: bold;">×</button>
                    `;
                    imagesContainer.appendChild(imgWrapper);
                });
            } else {
                imagesContainer.innerHTML = '<p style="color: #999; font-size: 14px;">Aucune photo</p>';
            }

            document.getElementById('editModal').classList.add('active');
        }

        function deleteImage(imageId, btn) {
            if (confirm('Supprimer cette photo ?')) {
                fetch('/30032006/image/' + imageId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        btn.parentElement.remove();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                }).catch(err => {
                    alert('Erreur: ' + err);
                });
            }
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.remove('active');
        }

        function editService(id, nom, description) {
            document.getElementById('edit_service_nom').value = nom;
            document.getElementById('edit_service_description').value = description;
            document.getElementById('editServiceForm').action = '/30032006/services/' + id;
            document.getElementById('editServiceModal').classList.add('active');
        }

        function closeEditServiceModal() {
            document.getElementById('editServiceModal').classList.remove('active');
        }

        // Close modals on outside click
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('editServiceModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditServiceModal();
            }
        });

        function moveProduct(productId, direction) {
            const grid = document.getElementById('produitsGrid');
            const cards = Array.from(grid.querySelectorAll('.item-card[data-id]'));
            const currentIndex = cards.findIndex(card => card.dataset.id == productId);

            if (currentIndex === -1) return;

            let newIndex;
            if (direction === 'up' && currentIndex > 0) {
                newIndex = currentIndex - 1;
            } else if (direction === 'down' && currentIndex < cards.length - 1) {
                newIndex = currentIndex + 1;
            } else {
                return;
            }

            // Swap DOM elements
            const currentCard = cards[currentIndex];
            const targetCard = cards[newIndex];

            if (direction === 'up') {
                grid.insertBefore(currentCard, targetCard);
            } else {
                grid.insertBefore(targetCard, currentCard);
            }

            // Update order numbers and save
            saveProductOrder();
        }

        function saveProductOrder() {
            const grid = document.getElementById('produitsGrid');
            const cards = Array.from(grid.querySelectorAll('.item-card[data-id]'));

            const produits = cards.map((card, index) => {
                // Update visual order number
                const numEl = card.querySelector('.ordre-num');
                if (numEl) numEl.textContent = index + 1;

                return {
                    id: parseInt(card.dataset.id),
                    ordre: index
                };
            });

            // Use FormData for better Laravel compatibility
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('produits', JSON.stringify(produits));

            fetch('/30032006/produits/ordre', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            }).then(response => {
                return response.json().then(data => {
                    if (data.success) {
                        // Show brief success indicator on all buttons
                        document.querySelectorAll('.ordre-btn').forEach(btn => {
                            btn.style.background = '#28a745';
                            setTimeout(() => { btn.style.background = ''; }, 800);
                        });
                    } else {
                        alert('Erreur: ' + (data.error || 'Ordre non sauvegardé'));
                    }
                });
            }).catch(err => {
                alert('Erreur de connexion: ' + err.message);
            });
        }

        function toggleVisibility(productId, btn) {
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');

            fetch('/30032006/produit/' + productId + '/visibility', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            }).then(response => response.json())
            .then(data => {
                if (data.success) {
                    const card = btn.closest('.item-card');
                    if (data.visible) {
                        card.classList.remove('hidden-product');
                        btn.classList.remove('hidden');
                        btn.innerHTML = '👁️';
                        btn.title = 'Masquer';
                    } else {
                        card.classList.add('hidden-product');
                        btn.classList.add('hidden');
                        btn.innerHTML = '🚫';
                        btn.title = 'Afficher';
                    }
                } else {
                    alert('Erreur: ' + (data.error || 'Erreur de visibilité'));
                }
            }).catch(err => {
                alert('Erreur: ' + err.message);
            });
        }
    </script>
</body>
</html>
