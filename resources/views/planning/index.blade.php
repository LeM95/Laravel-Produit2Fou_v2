<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Planning des Installations</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
        }
        .container { max-width: 1600px; margin: 0 auto; padding: 20px; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }
        .header h1 { color: #333; font-size: 28px; }
        .header-actions { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }

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
            font-size: 14px;
        }
        .btn:hover { transform: translateY(-2px); }
        .btn-secondary { background: #6c757d; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .btn-warning { background: #ffc107; color: #333; }
        .btn-sm { padding: 8px 16px; font-size: 13px; }
        .btn-icon {
            width: 45px;
            height: 45px;
            padding: 0;
            border-radius: 50%;
            font-size: 20px;
            justify-content: center;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .alert-success { background: #d4edda; color: #155724; }

        .main-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .card-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #calendar { min-height: 600px; }

        .fc-event { cursor: pointer; }
        .fc-daygrid-event { padding: 2px 5px; }

        .reservations-list { max-height: 600px; overflow-y: auto; }
        .reservation-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 12px;
            border-left: 4px solid #667eea;
        }
        .reservation-item.termine { border-left-color: #6c757d; opacity: 0.7; }
        .reservation-item.annule { border-left-color: #dc3545; opacity: 0.6; }
        .reservation-item.confirme { border-left-color: #28a745; }
        .reservation-item.en_attente { border-left-color: #ffc107; }
        .reservation-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }
        .reservation-date {
            font-weight: 700;
            color: #667eea;
            font-size: 14px;
        }
        .reservation-client {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }
        .reservation-info {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }
        .reservation-statut {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            color: white;
        }
        .reservation-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .statut-select {
            padding: 6px 10px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 12px;
            cursor: pointer;
        }

        /* Admin only elements */
        .admin-only { display: none !important; }
        body.admin-mode .admin-only { display: inline-flex !important; }
        body.admin-mode .admin-only-block { display: block !important; }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .tab {
            padding: 10px 20px;
            background: #e0e0e0;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            font-size: 13px;
        }
        .tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* Form styles */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .form-group { display: flex; flex-direction: column; }
        .form-group.full { grid-column: 1 / -1; }
        .form-label { font-weight: 600; margin-bottom: 6px; color: #333; font-size: 13px; }
        .form-input, .form-select, .form-textarea {
            padding: 10px 14px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s;
            width: 100%;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-textarea { resize: vertical; min-height: 80px; }
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .form-checkbox input { width: 18px; height: 18px; }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            z-index: 2000;
            align-items: center;
            justify-content: center;
            padding: 15px;
            overflow-y: auto;
        }
        .modal.active { display: flex; }
        .modal-content {
            background: white;
            border-radius: 15px;
            padding: 20px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            margin: auto;
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: sticky;
            top: 0;
            background: white;
            padding-bottom: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .modal-title { font-size: 20px; font-weight: 700; color: #333; }
        .modal-close {
            background: #e0e0e0;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            flex-shrink: 0;
        }

        /* Password Modal */
        .password-modal-content {
            max-width: 400px;
            text-align: center;
        }
        .password-input {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        .password-input:focus {
            outline: none;
            border-color: #667eea;
        }
        .password-error {
            color: #dc3545;
            margin-bottom: 15px;
            display: none;
        }

        /* Services/Packs */
        .service-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .service-name { font-weight: 700; color: #333; }
        .service-price { color: #667eea; font-weight: 600; }
        .service-items {
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #e0e0e0;
        }
        .service-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            font-size: 13px;
        }
        .service-item-name { color: #666; }
        .service-item-qty { font-weight: 600; }

        /* Photos & Products */
        .photos-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }
        .photo-thumb {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .photo-thumb:hover {
            transform: scale(1.05);
        }

        /* Lightbox */
        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.9);
            z-index: 3000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .lightbox.active {
            display: flex;
        }
        .lightbox-content {
            position: relative;
            max-width: 90vw;
            max-height: 90vh;
        }
        .lightbox-content img {
            max-width: 100%;
            max-height: 85vh;
            border-radius: 10px;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.5);
        }
        .lightbox-close {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 45px;
            height: 45px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: transform 0.2s;
        }
        .lightbox-close:hover {
            transform: scale(1.1);
        }
        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .lightbox-nav:hover {
            background: rgba(255, 255, 255, 0.4);
        }
        .lightbox-prev { left: -70px; }
        .lightbox-next { right: -70px; }
        @media (max-width: 768px) {
            .lightbox-prev { left: 10px; }
            .lightbox-next { right: 10px; }
            .lightbox-close {
                top: -50px;
                right: 0;
            }
        }

        /* Products selection */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
            margin-top: 10px;
            max-height: 450px;
            overflow-y: auto;
            padding: 10px;
        }
        .product-item {
            border: 3px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .product-item:hover { border-color: #667eea; transform: scale(1.02); }
        .product-item.selected { border-color: #28a745; background: #d4edda; }
        .product-item img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        .product-item-name {
            font-size: 12px;
            margin-top: 8px;
            color: #333;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .selected-products {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }
        .selected-product-tag {
            background: #667eea;
            color: white;
            padding: 6px 12px;
            border-radius: 25px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .selected-product-tag button {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }
        .selected-product-tag img {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .selected-product-tag img:hover {
            transform: scale(1.1);
        }

        /* Color selection modal */
        .color-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 15px;
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
        }
        .color-item {
            border: 3px solid #e0e0e0;
            border-radius: 12px;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .color-item:hover { border-color: #667eea; transform: scale(1.02); }
        .color-item.selected { border-color: #28a745; background: #d4edda; }
        .color-item img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }
        .color-item-name {
            font-size: 12px;
            margin-top: 8px;
            color: #333;
            font-weight: 500;
        }

        /* Admin badge */
        .admin-badge {
            background: #28a745;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Calendar toggle */
        .calendar-card {
            transition: all 0.3s ease;
        }
        .calendar-card.collapsed {
            max-height: 90px;
            overflow: hidden;
        }
        .calendar-card.collapsed #calendar {
            display: none;
        }
        .toggle-btn {
            background: #e0e0e0;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }
        .toggle-btn:hover {
            background: #667eea;
            color: white;
        }
        .toggle-btn .icon {
            transition: transform 0.3s;
        }
        .calendar-card.collapsed .toggle-btn .icon {
            transform: rotate(180deg);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .main-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .container { padding: 10px; }
            .form-grid { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: stretch; }
            .header h1 { font-size: 20px; text-align: center; }
            .header-actions {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
            }
            .btn {
                padding: 10px 15px;
                font-size: 12px;
                justify-content: center;
            }
            .btn-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
            .card { padding: 15px; border-radius: 12px; }
            .card-title { font-size: 16px; flex-direction: column; gap: 10px; }
            #calendar { min-height: 300px; }
            .fc .fc-toolbar { flex-direction: column; gap: 10px; }
            .fc .fc-toolbar-title { font-size: 14px !important; }
            .fc .fc-button { padding: 5px 8px !important; font-size: 11px !important; }
            .reservations-list { max-height: 400px; }
            .reservation-item { padding: 12px; }
            .reservation-header { flex-direction: column; gap: 8px; }
            .reservation-actions { flex-wrap: wrap; }
            .modal { padding: 10px; }
            .modal-content {
                padding: 15px;
                max-height: 95vh;
                border-radius: 12px;
            }
            .modal-title { font-size: 16px; }
            .tabs { gap: 5px; }
            .tab { padding: 8px 12px; font-size: 12px; }
            .service-header { flex-direction: column; align-items: flex-start; }
            .products-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 480px) {
            .products-grid { grid-template-columns: repeat(2, 1fr); }
            .form-grid { gap: 10px; }
            .modal-content { padding: 12px; }
        }
    </style>
</head>
<body class="{{ $isAdmin ? 'admin-mode' : '' }}">
    <div class="container">
        <div class="header">
            <h1>Planning des Installations</h1>
            <div class="header-actions">
                @if($isAdmin)
                    <span class="admin-badge">Admin</span>
                    <button class="btn admin-only" onclick="openModal('addReservationModal')">+ Reservation</button>
                    <button class="btn btn-secondary admin-only" onclick="openModal('servicesModal')">Packs</button>
                @endif
                <a href="{{ route('reservations.public') }}" class="btn btn-secondary">Vue equipe</a>
                <a href="{{ route('admin.produits') }}" class="btn btn-secondary">Admin</a>
                @if($isAdmin)
                    <a href="{{ route('planning.logout') }}" class="btn btn-danger btn-icon" title="Deconnexion">X</a>
                @else
                    <button class="btn btn-icon" onclick="openModal('passwordModal')" title="Mode admin">&#9881;</button>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="main-grid">
            <!-- Calendar -->
            <div class="card calendar-card" id="calendarCard">
                <h3 class="card-title">
                    Calendrier
                    <button class="toggle-btn" onclick="toggleCalendar()" title="Réduire/Agrandir">
                        <span class="icon">▲</span>
                    </button>
                </h3>
                <div id="calendar"></div>
            </div>

            <!-- Reservations List -->
            <div class="card">
                <h3 class="card-title">
                    Reservations
                    <span style="font-size: 14px; color: #666; font-weight: normal;">{{ $reservations->count() }} total</span>
                </h3>

                <div class="tabs">
                    <button class="tab active" onclick="filterReservations('all')">Toutes</button>
                    <button class="tab" onclick="filterReservations('upcoming')">A venir</button>
                    <button class="tab" onclick="filterReservations('termine')">Terminees</button>
                </div>

                <div class="reservations-list" id="reservationsList">
                    @forelse($reservations->sortByDesc('date_reservation') as $r)
                        <div class="reservation-item {{ $r->statut }}"
                             data-date="{{ $r->date_reservation->format('Y-m-d') }}"
                             data-statut="{{ $r->statut }}">
                            <div class="reservation-header">
                                <div>
                                    <div class="reservation-date">{{ $r->date_reservation->format('d/m/Y') }}</div>
                                    <div class="reservation-client">{{ $r->client_nom }}</div>
                                    <div class="reservation-info">
                                        {{ $r->ville }} {{ $r->adresse ? '- ' . $r->adresse : '' }}
                                    </div>
                                    @if($r->client_telephone)
                                        <div class="reservation-info">Tel: {{ $r->client_telephone }}</div>
                                    @endif
                                    @if($r->service)
                                        <div class="reservation-info">Pack: {{ $r->service->nom }}</div>
                                    @endif
                                    @if($r->type_mur)
                                        <div class="reservation-info">Mur: {{ $r->type_mur }}</div>
                                    @endif
                                    @if($r->prix)
                                        <div class="reservation-info" style="color: #28a745; font-weight: 600;">{{ number_format($r->prix, 2) }} EUR</div>
                                    @endif
                                    @if($r->acompte)
                                        <div class="reservation-info" style="color: #28a745;">Acompte verse</div>
                                    @endif
                                    @if($r->produits && $r->produits->count() > 0)
                                        <div class="reservation-info" style="display: flex; flex-wrap: wrap; gap: 5px; align-items: center;">
                                            <span>Produits:</span>
                                            @foreach($r->produits as $prod)
                                                @php
                                                    $notes = $prod->pivot->notes ?? '';
                                                    $parts = explode('|', $notes);
                                                    $colorName = $parts[0] ?? '';
                                                    $colorImage = $parts[1] ?? null;
                                                    if (!$colorImage && $prod->images->first()) {
                                                        $colorImage = asset('storage/' . $prod->images->first()->chemin_image);
                                                    }
                                                @endphp
                                                <span style="display: inline-flex; align-items: center; gap: 6px; background: #e9ecef; padding: 4px 10px; border-radius: 20px; font-size: 12px;">
                                                    @if($colorImage)
                                                        <img src="{{ $colorImage }}" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover; cursor: pointer;" onclick="openLightbox('{{ $colorImage }}')">
                                                    @endif
                                                    {{ $prod->nom }}{{ $colorName ? ' - ' . $colorName : '' }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <span class="reservation-statut" style="background: {{ $r->statut_color }}">
                                    {{ $r->statut_label }}
                                </span>
                            </div>

                            @if($r->photos->count() > 0)
                                <div class="photos-grid">
                                    @foreach($r->photos as $photo)
                                        <img src="{{ asset('storage/' . $photo->chemin_photo) }}"
                                             class="photo-thumb"
                                             onclick="openLightbox('{{ asset('storage/' . $photo->chemin_photo) }}')">
                                    @endforeach
                                </div>
                            @endif

                            <div class="reservation-actions">
                                @if($isAdmin)
                                    <select class="statut-select admin-only" onchange="updateStatut({{ $r->id }}, this.value)">
                                        <option value="en_attente" {{ $r->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="confirme" {{ $r->statut == 'confirme' ? 'selected' : '' }}>Confirme</option>
                                        <option value="termine" {{ $r->statut == 'termine' ? 'selected' : '' }}>Termine</option>
                                        <option value="annule" {{ $r->statut == 'annule' ? 'selected' : '' }}>Annule</option>
                                    </select>
                                    <button class="btn btn-sm admin-only" onclick="editReservation({{ $r->id }})">Modifier</button>
                                    <form action="{{ route('planning.reservations.destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette reservation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger admin-only">Supprimer</button>
                                    </form>
                                @endif
                                @if($r->client_telephone)
                                    <a href="tel:{{ $r->client_telephone }}" class="btn btn-sm btn-success">Appeler</a>
                                @endif
                                @if($r->adresse && $r->ville)
                                    <a href="https://waze.com/ul?q={{ urlencode($r->adresse . ', ' . $r->ville) }}&navigate=yes" target="_blank" class="btn btn-sm btn-secondary">GPS</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p style="text-align: center; color: #999; padding: 40px;">Aucune reservation</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Password -->
    <div class="modal" id="passwordModal">
        <div class="modal-content password-modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Mode Admin</h3>
                <button class="modal-close" onclick="closeModal('passwordModal')">x</button>
            </div>
            <p>Entrez le mot de passe pour acceder aux fonctions d'administration.</p>
            <p class="password-error" id="passwordError">Mot de passe incorrect</p>
            <input type="password" id="adminPassword" class="password-input" placeholder="Mot de passe">
            <button class="btn" onclick="verifyPassword()" style="width: 100%;">Valider</button>
        </div>
    </div>

    <!-- Modal Nouvelle Reservation -->
    <div class="modal" id="addReservationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Nouvelle reservation</h3>
                <button class="modal-close" onclick="closeModal('addReservationModal')">x</button>
            </div>
            <form action="{{ route('planning.reservations.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Date *</label>
                        <input type="date" name="date_reservation" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pack/Service</label>
                        <select name="service_id" class="form-select">
                            <option value="">-- Aucun --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->nom }} ({{ number_format($s->prix, 2) }} EUR)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom du client *</label>
                        <input type="text" name="client_nom" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telephone</label>
                        <input type="text" name="client_telephone" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ville</label>
                        <input type="text" name="ville" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type de mur</label>
                        <input type="text" name="type_mur" class="form-input" placeholder="Ex: Placo, Beton, Brique...">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Adresse complete</label>
                        <input type="text" name="adresse" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prix (EUR)</label>
                        <input type="number" name="prix" step="0.01" min="0" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Statut</label>
                        <select name="statut" class="form-select">
                            <option value="en_attente">En attente</option>
                            <option value="confirme">Confirme</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Description / Notes</label>
                        <textarea name="description" class="form-textarea" placeholder="Informations supplementaires..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox">
                            <input type="checkbox" name="acompte" value="1">
                            <span>Acompte verse</span>
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Photos du mur</label>
                        <input type="file" name="photos[]" multiple accept="image/*" class="form-input">
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="submit" class="btn">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('addReservationModal')">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Modifier Reservation -->
    <div class="modal" id="editReservationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Modifier la reservation</h3>
                <button class="modal-close" onclick="closeModal('editReservationModal')">x</button>
            </div>
            <form id="editReservationForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_reservation_id">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Date *</label>
                        <input type="date" name="date_reservation" id="edit_date" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pack/Service</label>
                        <select name="service_id" id="edit_service" class="form-select">
                            <option value="">-- Aucun --</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nom du client *</label>
                        <input type="text" name="client_nom" id="edit_client_nom" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Telephone</label>
                        <input type="text" name="client_telephone" id="edit_telephone" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ville</label>
                        <input type="text" name="ville" id="edit_ville" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type de mur</label>
                        <input type="text" name="type_mur" id="edit_type_mur" class="form-input">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Adresse complete</label>
                        <input type="text" name="adresse" id="edit_adresse" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prix (EUR)</label>
                        <input type="number" name="prix" id="edit_prix" step="0.01" min="0" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Statut</label>
                        <select name="statut" id="edit_statut" class="form-select">
                            <option value="en_attente">En attente</option>
                            <option value="confirme">Confirme</option>
                            <option value="termine">Termine</option>
                            <option value="annule">Annule</option>
                        </select>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Description / Notes</label>
                        <textarea name="description" id="edit_description" class="form-textarea"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-checkbox">
                            <input type="checkbox" name="acompte" id="edit_acompte" value="1">
                            <span>Acompte verse</span>
                        </label>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Photos actuelles</label>
                        <div id="edit_photos" class="photos-grid"></div>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Ajouter des photos</label>
                        <input type="file" name="photos[]" multiple accept="image/*" class="form-input">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Produits/Coloris selectionnes</label>
                        <div id="edit_selected_products" class="selected-products"></div>
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Ajouter un produit (coloris/plaque) <small style="color: #999; font-weight: normal;">(double-clic pour agrandir)</small></label>
                        <div class="products-grid" id="edit_products_grid">
                            @foreach($produits as $prod)
                                <div class="product-item"
                                     data-id="{{ $prod->id }}"
                                     data-name="{{ $prod->nom }}"
                                     data-images='@json($prod->images->map(fn($img) => ["id" => $img->id, "url" => asset("storage/" . $img->chemin_image)]))'
                                     onclick="openColorSelection(this)">
                                    @if($prod->images->first())
                                        <img src="{{ asset('storage/' . $prod->images->first()->chemin_image) }}" alt="{{ $prod->nom }}" ondblclick="event.stopPropagation(); openLightbox('{{ asset('storage/' . $prod->images->first()->chemin_image) }}')">
                                    @else
                                        <div style="width: 60px; height: 60px; background: #e0e0e0; border-radius: 6px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">?</div>
                                    @endif
                                    <div class="product-item-name">{{ $prod->nom }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="submit" class="btn">Enregistrer</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('editReservationModal')">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Services/Packs -->
    <div class="modal" id="servicesModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Gerer les Packs/Services</h3>
                <button class="modal-close" onclick="closeModal('servicesModal')">x</button>
            </div>

            <!-- Add new service -->
            <form action="{{ route('planning.services.store') }}" method="POST" style="margin-bottom: 25px;">
                @csrf
                <h4 style="margin-bottom: 15px;">Creer un nouveau pack</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <input type="text" name="nom" class="form-input" placeholder="Nom du pack *" required>
                    </div>
                    <div class="form-group">
                        <input type="number" name="prix" step="0.01" class="form-input" placeholder="Prix (EUR)">
                    </div>
                    <div class="form-group full">
                        <textarea name="description" class="form-textarea" placeholder="Description..."></textarea>
                    </div>
                </div>
                <button type="submit" class="btn" style="margin-top: 10px;">Creer le pack</button>
            </form>

            <hr style="border: none; border-top: 1px solid #e0e0e0; margin: 20px 0;">

            <h4 style="margin-bottom: 15px;">Packs existants</h4>
            @forelse($services as $service)
                <div class="service-card">
                    <div class="service-header">
                        <div>
                            <span class="service-name">{{ $service->nom }}</span>
                            <span class="service-price">{{ number_format($service->prix, 2) }} EUR</span>
                        </div>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <button class="btn btn-sm" onclick="toggleServiceItems({{ $service->id }})">Produits</button>
                            <form action="{{ route('planning.services.destroy', $service->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce pack?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </div>
                    </div>
                    @if($service->description)
                        <p style="font-size: 13px; color: #666; margin-top: 8px;">{{ $service->description }}</p>
                    @endif

                    <!-- Service Items -->
                    <div class="service-items" id="service-items-{{ $service->id }}" style="display: none;">
                        <form action="{{ route('planning.services.items.store', $service->id) }}" method="POST" style="display: flex; gap: 10px; margin-bottom: 15px; flex-wrap: wrap;">
                            @csrf
                            <select name="inventaire_id" class="form-select" style="flex: 1; min-width: 150px;" required>
                                <option value="">-- Choisir un produit --</option>
                                @foreach($inventaire as $inv)
                                    <option value="{{ $inv->id }}">{{ $inv->nom }} (Stock: {{ $inv->stock }})</option>
                                @endforeach
                            </select>
                            <input type="number" name="quantite" min="1" value="1" class="form-input" style="width: 70px;" required>
                            <button type="submit" class="btn btn-sm btn-success">+</button>
                        </form>

                        @if($service->items->count() > 0)
                            @foreach($service->items as $item)
                                <div class="service-item">
                                    <span class="service-item-name">{{ $item->inventaire->nom ?? 'Produit supprime' }}</span>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <span class="service-item-qty">x{{ $item->quantite }}</span>
                                        <button onclick="removeServiceItem({{ $item->id }})" style="background: #dc3545; color: white; border: none; padding: 2px 8px; border-radius: 4px; cursor: pointer;">x</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p style="color: #999; font-size: 13px;">Aucun produit dans ce pack</p>
                        @endif
                    </div>
                </div>
            @empty
                <p style="color: #999; text-align: center;">Aucun pack cree</p>
            @endforelse
        </div>
    </div>

    <!-- Lightbox pour photos -->
    <div class="lightbox" id="photoLightbox" onclick="closeLightbox(event)">
        <div class="lightbox-content" onclick="event.stopPropagation()">
            <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
            <img id="lightboxImage" src="" alt="Photo agrandie">
        </div>
    </div>

    <!-- Modal Selection Coloris -->
    <div class="modal" id="colorSelectionModal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3 class="modal-title" id="colorModalTitle">Choisir un coloris</h3>
                <button class="modal-close" onclick="closeModal('colorSelectionModal')">x</button>
            </div>
            <p style="color: #666; margin-bottom: 10px;">Selectionnez le coloris souhaite pour ce produit: <small style="color: #999;">(double-clic pour agrandir)</small></p>
            <div class="color-grid" id="colorGrid"></div>
            <div style="margin-top: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                <button class="btn btn-secondary" onclick="closeModal('colorSelectionModal')">Annuler</button>
            </div>
        </div>
    </div>

    <script>
        let isAdmin = {{ $isAdmin ? 'true' : 'false' }};
        let currentReservationId = null;
        let selectedProducts = [];

        // Initialize FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,listWeek'
                },
                events: '{{ route("planning.events") }}',
                eventClick: function(info) {
                    const props = info.event.extendedProps;

                    // Check if it's a blocked date
                    if (props.type === 'blocked') {
                        if (isAdmin && confirm('Date bloquee: ' + (props.raison || 'Aucune raison') + '\n\nVoulez-vous debloquer cette date?')) {
                            debloquerDate(props.blockedId, info.event);
                        }
                        return;
                    }

                    alert(
                        'Client: ' + info.event.title + '\n' +
                        'Statut: ' + props.statut + '\n' +
                        'Adresse: ' + (props.adresse || 'Non renseignee') + '\n' +
                        'Telephone: ' + (props.telephone || 'Non renseigne') + '\n' +
                        'Service: ' + (props.service || 'Aucun')
                    );
                },
                dateClick: function(info) {
                    if (isAdmin) {
                        const action = prompt('Que voulez-vous faire pour le ' + info.dateStr + '?\n\n1 = Ajouter une reservation\n2 = Bloquer cette date');
                        if (action === '1') {
                            document.querySelector('#addReservationModal input[name="date_reservation"]').value = info.dateStr;
                            openModal('addReservationModal');
                        } else if (action === '2') {
                            const raison = prompt('Raison du blocage (optionnel):');
                            bloquerDate(info.dateStr, raison);
                        }
                    }
                }
            });
            calendar.render();
        });

        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
            if (id === 'passwordModal') {
                document.getElementById('adminPassword').value = '';
                document.getElementById('passwordError').style.display = 'none';
            }
        }

        function verifyPassword() {
            const password = document.getElementById('adminPassword').value;

            fetch('{{ route("planning.login.post") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ password: password })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    document.getElementById('passwordError').style.display = 'block';
                }
            })
            .catch(() => {
                document.getElementById('passwordError').style.display = 'block';
            });
        }

        // Enter key for password
        document.getElementById('adminPassword').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                verifyPassword();
            }
        });

        // Bloquer une date
        function bloquerDate(date, raison) {
            fetch('{{ route("planning.dates-bloquees.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ date: date, raison: raison || null })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Date bloquee avec succes!');
                    location.reload();
                } else {
                    alert('Erreur: ' + (data.error || 'Impossible de bloquer cette date'));
                }
            })
            .catch(() => {
                alert('Erreur de connexion');
            });
        }

        // Debloquer une date
        function debloquerDate(id, event) {
            fetch('/30032006/reservations/dates-bloquees/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Date debloquee!');
                    event.remove();
                } else {
                    alert('Erreur: ' + (data.error || 'Impossible de debloquer'));
                }
            })
            .catch(() => {
                alert('Erreur de connexion');
            });
        }

        function filterReservations(filter) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');

            const today = new Date().toISOString().split('T')[0];
            document.querySelectorAll('.reservation-item').forEach(item => {
                const date = item.dataset.date;
                const statut = item.dataset.statut;

                let show = true;
                if (filter === 'upcoming') {
                    show = date >= today && statut !== 'termine' && statut !== 'annule';
                } else if (filter === 'termine') {
                    show = statut === 'termine';
                }

                item.style.display = show ? '' : 'none';
            });
        }

        function updateStatut(id, statut) {
            fetch('/30032006/reservations/' + id + '/statut', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ statut: statut })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }

        function editReservation(id) {
            currentReservationId = id;
            selectedProducts = [];

            fetch('/30032006/reservations/' + id, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const r = data.reservation;
                    document.getElementById('edit_reservation_id').value = id;
                    document.getElementById('edit_date').value = r.date_reservation.split('T')[0];
                    document.getElementById('edit_client_nom').value = r.client_nom || '';
                    document.getElementById('edit_telephone').value = r.client_telephone || '';
                    document.getElementById('edit_ville').value = r.ville || '';
                    document.getElementById('edit_adresse').value = r.adresse || '';
                    document.getElementById('edit_type_mur').value = r.type_mur || '';
                    document.getElementById('edit_prix').value = r.prix || '';
                    document.getElementById('edit_description').value = r.description || '';
                    document.getElementById('edit_statut').value = r.statut;
                    document.getElementById('edit_service').value = r.service_id || '';
                    document.getElementById('edit_acompte').checked = r.acompte;

                    // Photos
                    const photosDiv = document.getElementById('edit_photos');
                    photosDiv.innerHTML = '';
                    data.photos.forEach(p => {
                        photosDiv.innerHTML += `
                            <div style="position: relative; display: inline-block;">
                                <img src="${p.url}" class="photo-thumb" onclick="openLightbox('${p.url}')">
                                <button type="button" onclick="deletePhoto(${p.id}, this)" style="position: absolute; top: -5px; right: -5px; background: #dc3545; color: white; border: none; border-radius: 50%; width: 20px; height: 20px; cursor: pointer; font-size: 12px;">x</button>
                            </div>
                        `;
                    });

                    // Products with color info
                    if (data.produits) {
                        selectedProducts = data.produits.map(p => ({
                            id: p.id,
                            nom: p.nom,
                            colorImage: p.image,
                            colorName: p.notes || ''
                        }));
                    }
                    updateSelectedProductsUI();

                    // Reset product grid selection
                    document.querySelectorAll('#edit_products_grid .product-item').forEach(el => {
                        el.classList.remove('selected');
                        if (selectedProducts.find(sp => sp.id == el.dataset.id)) {
                            el.classList.add('selected');
                        }
                    });

                    document.getElementById('editReservationForm').action = '/30032006/reservations/' + id;
                    openModal('editReservationModal');
                }
            });
        }

        let currentProductElement = null;

        function openColorSelection(el) {
            const id = parseInt(el.dataset.id);
            const name = el.dataset.name;
            let images = [];

            try {
                images = JSON.parse(el.dataset.images || '[]');
            } catch(e) {
                images = [];
            }

            // If already selected, remove it
            if (el.classList.contains('selected')) {
                el.classList.remove('selected');
                selectedProducts = selectedProducts.filter(p => p.id !== id);
                removeProductFromReservation(id);
                updateSelectedProductsUI();
                return;
            }

            // If no images or only one image, add directly
            if (images.length <= 1) {
                el.classList.add('selected');
                const colorImg = images.length > 0 ? images[0].url : null;
                selectedProducts.push({ id: id, nom: name, colorImage: colorImg, colorName: 'Default' });
                addProductToReservation(id, 'Default', colorImg);
                updateSelectedProductsUI();
                return;
            }

            // Multiple images - show color selection modal
            currentProductElement = el;
            document.getElementById('colorModalTitle').textContent = 'Coloris - ' + name;

            const colorGrid = document.getElementById('colorGrid');
            colorGrid.innerHTML = images.map((img, index) => `
                <div class="color-item" onclick="selectColor(${id}, '${name}', 'Coloris ${index + 1}', '${img.url}')">
                    <img src="${img.url}" alt="Coloris ${index + 1}" ondblclick="event.stopPropagation(); openLightbox('${img.url}')">
                    <div class="color-item-name">Coloris ${index + 1}</div>
                </div>
            `).join('');

            openModal('colorSelectionModal');
        }

        function selectColor(productId, productName, colorName, colorImage) {
            // Close color modal
            closeModal('colorSelectionModal');

            // Mark product as selected
            if (currentProductElement) {
                currentProductElement.classList.add('selected');
            }

            // Add to selected products with color info
            selectedProducts.push({
                id: productId,
                nom: productName,
                colorImage: colorImage,
                colorName: colorName
            });

            addProductToReservation(productId, colorName, colorImage);
            updateSelectedProductsUI();
        }

        function updateSelectedProductsUI() {
            const container = document.getElementById('edit_selected_products');
            container.innerHTML = selectedProducts.map(p => `
                <span class="selected-product-tag">
                    ${p.colorImage ? `<img src="${p.colorImage}" alt="" onclick="openLightbox('${p.colorImage}')" style="cursor: pointer;">` : ''}
                    ${p.nom}${p.colorName ? ' - ' + p.colorName : ''}
                    <button type="button" onclick="removeSelectedProduct(${p.id})">x</button>
                </span>
            `).join('');
        }

        function removeSelectedProduct(id) {
            selectedProducts = selectedProducts.filter(p => p.id !== id);
            document.querySelectorAll('#edit_products_grid .product-item').forEach(el => {
                if (parseInt(el.dataset.id) === id) {
                    el.classList.remove('selected');
                }
            });
            removeProductFromReservation(id);
            updateSelectedProductsUI();
        }

        function addProductToReservation(produitId, colorName, colorImage) {
            if (!currentReservationId) return;

            fetch('/30032006/reservations/' + currentReservationId + '/produits', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    produit_id: produitId,
                    notes: colorName + '|' + (colorImage || '')
                })
            });
        }

        function removeProductFromReservation(produitId) {
            if (!currentReservationId) return;

            fetch('/30032006/reservations/' + currentReservationId + '/produits/' + produitId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
        }

        function deletePhoto(id, btn) {
            if (confirm('Supprimer cette photo?')) {
                fetch('/30032006/reservations/photos/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        btn.parentElement.remove();
                    }
                });
            }
        }

        function toggleServiceItems(id) {
            const el = document.getElementById('service-items-' + id);
            el.style.display = el.style.display === 'none' ? 'block' : 'none';
        }

        function removeServiceItem(id) {
            if (confirm('Retirer ce produit du pack?')) {
                fetch('/30032006/reservations/services/items/' + id, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                });
            }
        }

        // Close modals on outside click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) closeModal(this.id);
            });
        });

        // Lightbox functions
        function openLightbox(src) {
            document.getElementById('lightboxImage').src = src;
            document.getElementById('photoLightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox(event) {
            // If called from background click, only close if clicked on background
            if (event && event.target && event.target.id !== 'photoLightbox') return;
            document.getElementById('photoLightbox').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close lightbox with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
        });

        // Toggle calendar visibility
        function toggleCalendar() {
            const card = document.getElementById('calendarCard');
            card.classList.toggle('collapsed');

            // Save preference in localStorage
            localStorage.setItem('calendarCollapsed', card.classList.contains('collapsed'));
        }

        // Restore calendar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const isCollapsed = localStorage.getItem('calendarCollapsed') === 'true';
            if (isCollapsed) {
                document.getElementById('calendarCard').classList.add('collapsed');
            }
        });
    </script>
</body>
</html>
