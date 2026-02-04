<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaire - Produits2Fou</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
        }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .header h1 { color: #333; font-size: 28px; }
        .header-actions { display: flex; gap: 10px; flex-wrap: wrap; }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-secondary { background: #6c757d; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-sm { padding: 8px 16px; font-size: 13px; }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        .alert-warning { background: #fff3cd; color: #856404; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .stat-card h3 { color: #666; font-size: 14px; margin-bottom: 8px; }
        .stat-card .value { font-size: 32px; font-weight: 700; color: #333; }
        .stat-card.warning .value { color: #dc3545; }

        .card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        .card-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-weight: 600; margin-bottom: 6px; color: #333; font-size: 14px; }
        .form-input, .form-select, .form-textarea {
            padding: 10px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-textarea { resize: vertical; min-height: 80px; }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table th, .items-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .items-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
        }
        .items-table tr:hover { background: #f8f9fa; }

        .item-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            background: #e0e0e0;
        }
        .item-name { font-weight: 600; color: #333; }
        .item-location { font-size: 13px; color: #666; }
        .item-category {
            background: #e0e0e0;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .stock-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
        }
        .stock-ok { background: #d4edda; color: #155724; }
        .stock-low { background: #f8d7da; color: #721c24; animation: pulse 2s infinite; }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .stock-controls {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .stock-btn {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.2s;
        }
        .stock-btn:hover { transform: scale(1.1); }
        .stock-btn.plus { background: #28a745; color: white; }
        .stock-btn.minus { background: #dc3545; color: white; }

        .actions { display: flex; gap: 8px; }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 25px;
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
        .modal-title { font-size: 22px; font-weight: 700; color: #333; }
        .modal-close {
            background: #e0e0e0;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
        }

        .history-list { max-height: 300px; overflow-y: auto; }
        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        .history-item:last-child { border-bottom: none; }
        .history-type {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .history-type.entree { background: #d4edda; color: #155724; }
        .history-type.sortie { background: #f8d7da; color: #721c24; }
        .history-date { color: #999; font-size: 13px; }

        .filter-bar {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .search-input {
            flex: 1;
            min-width: 200px;
            padding: 10px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
        }
        .search-input:focus { outline: none; border-color: #667eea; }

        @media (max-width: 768px) {
            .items-table { display: block; overflow-x: auto; }
            .form-grid { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📦 Inventaire</h1>
            <div class="header-actions">
                <button class="btn" onclick="openAddModal()">➕ Ajouter un produit</button>
                <button class="btn btn-secondary" onclick="openCategoryModal()">🏷️ Catégories</button>
                <a href="{{ route('admin.produits') }}" class="btn btn-secondary">⬅️ Retour admin</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif

        @if($lowStockCount > 0)
            <div class="alert alert-warning">
                ⚠️ <strong>Attention:</strong> {{ $lowStockCount }} produit(s) en stock bas!
            </div>
        @endif

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total produits</h3>
                <div class="value">{{ $items->count() }}</div>
            </div>
            <div class="stat-card {{ $lowStockCount > 0 ? 'warning' : '' }}">
                <h3>Stock bas</h3>
                <div class="value">{{ $lowStockCount }}</div>
            </div>
            <div class="stat-card">
                <h3>Valeur totale</h3>
                <div class="value">{{ number_format($items->sum(function($i) { return $i->prix_achat * $i->stock; }), 2) }} €</div>
            </div>
            <div class="stat-card">
                <h3>Catégories</h3>
                <div class="value">{{ $categories->count() }}</div>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">Liste des produits</h3>

            <div class="filter-bar">
                <input type="text" class="search-input" id="searchInput" placeholder="🔍 Rechercher un produit..." onkeyup="filterItems()">
                <select class="form-select" id="filterCategory" onchange="filterItems()">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                    @endforeach
                </select>
                <select class="form-select" id="filterStock" onchange="filterItems()">
                    <option value="">Tous les stocks</option>
                    <option value="low">Stock bas uniquement</option>
                    <option value="ok">Stock OK</option>
                </select>
            </div>

            <table class="items-table" id="itemsTable">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Emplacement</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr data-id="{{ $item->id }}"
                            data-name="{{ strtolower($item->nom) }}"
                            data-category="{{ $item->categorie_id }}"
                            data-low="{{ $item->isLowStock() ? '1' : '0' }}">
                            <td>
                                @if($item->photo)
                                    <img src="{{ asset('storage/' . $item->photo) }}" class="item-photo" alt="{{ $item->nom }}">
                                @else
                                    <div class="item-photo" style="display: flex; align-items: center; justify-content: center; color: #999;">📦</div>
                                @endif
                            </td>
                            <td>
                                <div class="item-name">{{ $item->nom }}</div>
                                @if($item->fournisseur)
                                    <div class="item-location">🏪 {{ $item->fournisseur }}</div>
                                @endif
                            </td>
                            <td>
                                @if($item->categorie)
                                    <span class="item-category">{{ $item->categorie->nom }}</span>
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->emplacement)
                                    <span>📍 {{ $item->emplacement }}</span>
                                @else
                                    <span style="color: #999;">-</span>
                                @endif
                            </td>
                            <td>{{ number_format($item->prix_achat, 2) }} €</td>
                            <td>
                                <div class="stock-controls">
                                    <button class="stock-btn minus" onclick="modifyStock({{ $item->id }}, 'retirer')" title="Retirer">−</button>
                                    <span class="stock-badge {{ $item->isLowStock() ? 'stock-low' : 'stock-ok' }}" id="stock-{{ $item->id }}">
                                        {{ $item->stock }}
                                    </span>
                                    <button class="stock-btn plus" onclick="modifyStock({{ $item->id }}, 'ajouter')" title="Ajouter">+</button>
                                </div>
                                <div style="font-size: 11px; color: #999; margin-top: 4px;">Min: {{ $item->stock_min }}</div>
                            </td>
                            <td>
                                <div class="actions">
                                    <button class="btn btn-sm btn-secondary" onclick="viewHistory({{ $item->id }})" title="Historique">📊</button>
                                    <button class="btn btn-sm" onclick="editItem({{ $item->id }}, '{{ addslashes($item->nom) }}', '{{ addslashes($item->description ?? '') }}', '{{ addslashes($item->emplacement ?? '') }}', {{ $item->prix_achat }}, {{ $item->stock_min }}, {{ $item->categorie_id ?? 'null' }}, '{{ addslashes($item->fournisseur ?? '') }}')" title="Modifier">✏️</button>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }}, '{{ addslashes($item->nom) }}')" title="Supprimer">🗑️</button>
                                </div>
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.inventaire.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                                <h3>📦 Aucun produit dans l'inventaire</h3>
                                <p>Cliquez sur "Ajouter un produit" pour commencer</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Ajouter Produit -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Ajouter un produit</h3>
                <button class="modal-close" onclick="closeModal('addModal')">×</button>
            </div>
            <form action="{{ route('admin.inventaire.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie_id" class="form-select">
                            <option value="">-- Choisir --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-textarea" placeholder="Description du produit..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Emplacement</label>
                        <input type="text" name="emplacement" class="form-input" placeholder="Ex: Étagère A, Tiroir 3...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fournisseur</label>
                        <input type="text" name="fournisseur" class="form-input" placeholder="Ex: Leroy Merlin, Amazon...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prix d'achat (€)</label>
                        <input type="number" name="prix_achat" step="0.01" min="0" class="form-input" value="0">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stock initial *</label>
                        <input type="number" name="stock" min="0" class="form-input" value="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stock minimum (alerte)</label>
                        <input type="number" name="stock_min" min="0" class="form-input" value="5">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Photo</label>
                        <input type="file" name="photo" accept="image/*" class="form-input">
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; gap: 10px;">
                    <button type="submit" class="btn">💾 Enregistrer</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Modifier Produit -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modifier le produit</h3>
                <button class="modal-close" onclick="closeModal('editModal')">×</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" id="edit_nom" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catégorie</label>
                        <select name="categorie_id" id="edit_categorie" class="form-select">
                            <option value="">-- Choisir --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="edit_description" class="form-textarea"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Emplacement</label>
                        <input type="text" name="emplacement" id="edit_emplacement" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Fournisseur</label>
                        <input type="text" name="fournisseur" id="edit_fournisseur" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prix d'achat (€)</label>
                        <input type="number" name="prix_achat" id="edit_prix" step="0.01" min="0" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Stock minimum</label>
                        <input type="number" name="stock_min" id="edit_stock_min" min="0" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nouvelle photo</label>
                        <input type="file" name="photo" accept="image/*" class="form-input">
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; gap: 10px;">
                    <button type="submit" class="btn">💾 Enregistrer</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Stock -->
    <div class="modal" id="stockModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h3 class="modal-title" id="stockModalTitle">Modifier le stock</h3>
                <button class="modal-close" onclick="closeModal('stockModal')">×</button>
            </div>
            <div class="form-group">
                <label class="form-label">Quantité</label>
                <input type="number" id="stockQuantite" min="1" value="1" class="form-input">
            </div>
            <div class="form-group" style="margin-top: 15px;">
                <label class="form-label">Note (optionnel)</label>
                <input type="text" id="stockNote" class="form-input" placeholder="Ex: Achat Leroy Merlin, Chantier X...">
            </div>
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button class="btn" id="stockConfirmBtn" onclick="confirmStockChange()">Confirmer</button>
                <button class="btn btn-secondary" onclick="closeModal('stockModal')">Annuler</button>
            </div>
        </div>
    </div>

    <!-- Modal Historique -->
    <div class="modal" id="historyModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">📊 Historique: <span id="historyItemName"></span></h3>
                <button class="modal-close" onclick="closeModal('historyModal')">×</button>
            </div>
            <div class="history-list" id="historyList">
                <p style="text-align: center; color: #999;">Chargement...</p>
            </div>
        </div>
    </div>

    <!-- Modal Confirmation Suppression -->
    <div class="modal" id="deleteModal">
        <div class="modal-content" style="max-width: 450px; text-align: center;">
            <div class="modal-header" style="justify-content: center; border-bottom: none;">
                <h3 class="modal-title" style="color: #dc3545;">⚠️ Supprimer le produit</h3>
            </div>
            <p style="margin-bottom: 15px;">Êtes-vous sûr de vouloir supprimer :</p>
            <p style="font-weight: 700; font-size: 18px; margin-bottom: 20px;" id="deleteItemName"></p>
            <p style="color: #666; font-size: 13px; margin-bottom: 20px;">
                Cette action supprimera également tous les mouvements de stock associés.<br>
                Cette action est irréversible.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button class="btn btn-danger" onclick="executeDelete()">🗑️ Supprimer</button>
                <button class="btn btn-secondary" onclick="closeModal('deleteModal')">Annuler</button>
            </div>
        </div>
    </div>

    <!-- Modal Catégories -->
    <div class="modal" id="categoryModal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h3 class="modal-title">🏷️ Catégories</h3>
                <button class="modal-close" onclick="closeModal('categoryModal')">×</button>
            </div>
            <form action="{{ route('admin.inventaire.categories.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nouvelle catégorie</label>
                    <input type="text" name="nom" class="form-input" placeholder="Nom de la catégorie" required>
                </div>
                <button type="submit" class="btn" style="margin-top: 15px;">➕ Ajouter</button>
            </form>
            <hr style="margin: 20px 0; border: none; border-top: 1px solid #eee;">
            <h4 style="margin-bottom: 10px;">Catégories existantes:</h4>
            <ul style="list-style: none;">
                @foreach($categories as $cat)
                    <li style="padding: 8px 0; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                        <span>{{ $cat->nom }}</span>
                        <form action="{{ route('admin.inventaire.categories.destroy', $cat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette catégorie?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; border: none; padding: 4px 10px; border-radius: 5px; cursor: pointer; font-size: 12px;">🗑️</button>
                        </form>
                    </li>
                @endforeach
            </ul>
            @if($categories->count() == 0)
                <p style="color: #999; text-align: center;">Aucune catégorie</p>
            @endif
        </div>
    </div>

    <script>
        let currentStockItemId = null;
        let currentStockAction = null;

        function openAddModal() {
            document.getElementById('addModal').classList.add('active');
        }

        function openCategoryModal() {
            document.getElementById('categoryModal').classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function editItem(id, nom, description, emplacement, prix, stockMin, categorieId, fournisseur) {
            document.getElementById('edit_nom').value = nom;
            document.getElementById('edit_description').value = description;
            document.getElementById('edit_emplacement').value = emplacement;
            document.getElementById('edit_prix').value = prix;
            document.getElementById('edit_stock_min').value = stockMin;
            document.getElementById('edit_categorie').value = categorieId || '';
            document.getElementById('edit_fournisseur').value = fournisseur;
            document.getElementById('editForm').action = '/30032006/inventaire/' + id;
            document.getElementById('editModal').classList.add('active');
        }

        function modifyStock(itemId, action) {
            currentStockItemId = itemId;
            currentStockAction = action;

            document.getElementById('stockModalTitle').textContent =
                action === 'ajouter' ? '➕ Ajouter au stock' : '➖ Retirer du stock';
            document.getElementById('stockConfirmBtn').className =
                action === 'ajouter' ? 'btn btn-success' : 'btn btn-danger';
            document.getElementById('stockConfirmBtn').textContent =
                action === 'ajouter' ? '➕ Ajouter' : '➖ Retirer';

            document.getElementById('stockQuantite').value = 1;
            document.getElementById('stockNote').value = '';
            document.getElementById('stockModal').classList.add('active');
        }

        function confirmStockChange() {
            const quantite = document.getElementById('stockQuantite').value;
            const note = document.getElementById('stockNote').value;

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('quantite', quantite);
            formData.append('note', note);

            fetch('/30032006/inventaire/' + currentStockItemId + '/' + currentStockAction, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const stockBadge = document.getElementById('stock-' + currentStockItemId);
                    stockBadge.textContent = data.new_stock;
                    stockBadge.className = 'stock-badge ' + (data.is_low ? 'stock-low' : 'stock-ok');
                    closeModal('stockModal');
                } else {
                    alert('Erreur: ' + (data.error || 'Erreur inconnue'));
                }
            })
            .catch(err => alert('Erreur: ' + err.message));
        }

        function viewHistory(itemId) {
            document.getElementById('historyList').innerHTML = '<p style="text-align: center; color: #999;">Chargement...</p>';
            document.getElementById('historyModal').classList.add('active');

            fetch('/30032006/inventaire/' + itemId + '/historique', {
                headers: { 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('historyItemName').textContent = data.item;

                    if (data.mouvements.length === 0) {
                        document.getElementById('historyList').innerHTML =
                            '<p style="text-align: center; color: #999; padding: 20px;">Aucun mouvement enregistré</p>';
                        return;
                    }

                    let html = '';
                    data.mouvements.forEach(m => {
                        html += `
                            <div class="history-item">
                                <div>
                                    <span class="history-type ${m.type}">${m.type === 'entree' ? '➕ Entrée' : '➖ Sortie'}</span>
                                    <strong style="margin-left: 10px;">${m.quantite}</strong>
                                    ${m.note ? '<div style="font-size: 13px; color: #666; margin-top: 4px;">' + m.note + '</div>' : ''}
                                </div>
                                <span class="history-date">${m.date}</span>
                            </div>
                        `;
                    });
                    document.getElementById('historyList').innerHTML = html;
                }
            })
            .catch(err => {
                document.getElementById('historyList').innerHTML =
                    '<p style="text-align: center; color: #dc3545;">Erreur de chargement</p>';
            });
        }

        function filterItems() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const category = document.getElementById('filterCategory').value;
            const stock = document.getElementById('filterStock').value;

            document.querySelectorAll('#itemsTable tbody tr[data-id]').forEach(row => {
                const name = row.dataset.name;
                const cat = row.dataset.category;
                const isLow = row.dataset.low === '1';

                let show = true;

                if (search && !name.includes(search)) show = false;
                if (category && cat !== category) show = false;
                if (stock === 'low' && !isLow) show = false;
                if (stock === 'ok' && isLow) show = false;

                row.style.display = show ? '' : 'none';
            });
        }

        // Delete confirmation
        let deleteItemId = null;

        function confirmDelete(id, name) {
            deleteItemId = id;
            document.getElementById('deleteItemName').textContent = name;
            document.getElementById('deleteModal').classList.add('active');
        }

        function executeDelete() {
            if (deleteItemId) {
                document.getElementById('delete-form-' + deleteItemId).submit();
            }
        }

        // Close modals on outside click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });
    </script>
</body>
</html>
