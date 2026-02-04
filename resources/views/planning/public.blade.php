<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Planning Installations</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            padding-bottom: 80px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 15px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header h1 {
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header-date {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .tabs {
            display: flex;
            background: white;
            border-bottom: 1px solid #e0e0e0;
            position: sticky;
            top: 70px;
            z-index: 99;
        }
        .tab {
            flex: 1;
            padding: 15px 10px;
            text-align: center;
            border: none;
            background: none;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            font-size: 14px;
            border-bottom: 3px solid transparent;
        }
        .tab.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .container { padding: 15px; }

        .reservation-card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border-left: 5px solid #667eea;
        }
        .reservation-card.termine {
            border-left-color: #6c757d;
            opacity: 0.7;
        }
        .reservation-card.confirme {
            border-left-color: #28a745;
        }
        .reservation-card.en_attente {
            border-left-color: #ffc107;
        }

        .reservation-date {
            font-size: 13px;
            color: #667eea;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .reservation-client {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .reservation-info {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #666;
            margin: 8px 0;
        }
        .reservation-info a {
            color: #667eea;
            text-decoration: none;
        }

        .reservation-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            color: white;
            margin-top: 10px;
        }

        .photos-row {
            display: flex;
            gap: 12px;
            margin-top: 12px;
            overflow-x: auto;
            padding-bottom: 8px;
        }
        .photo-thumb {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            flex-shrink: 0;
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
            background: rgba(0, 0, 0, 0.95);
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
            max-width: 95vw;
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
            top: -50px;
            right: 0;
            width: 50px;
            height: 50px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 28px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* Products display */
        .products-row {
            display: flex;
            gap: 10px;
            margin-top: 8px;
            overflow-x: auto;
            padding-bottom: 5px;
        }
        .product-thumb-card {
            flex-shrink: 0;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 8px;
            text-align: center;
            cursor: pointer;
            border: 2px solid #e0e0e0;
            transition: all 0.2s;
            min-width: 100px;
            max-width: 120px;
        }
        .product-thumb-card:hover {
            border-color: #667eea;
            transform: scale(1.02);
        }
        .product-thumb-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            display: block;
            margin: 0 auto;
        }
        .product-thumb-name {
            display: block;
            font-size: 11px;
            color: #333;
            margin-top: 6px;
            font-weight: 500;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .status-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            margin-top: 15px;
        }
        .status-btn {
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .status-btn:active { transform: scale(0.95); }
        .status-btn.attente { background: #fff3cd; color: #856404; }
        .status-btn.confirme { background: #d4edda; color: #155724; }
        .status-btn.termine { background: #e2e3e5; color: #383d41; }
        .status-btn.selected {
            box-shadow: 0 0 0 3px #667eea;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state h3 { margin-bottom: 10px; }

        .call-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
        }

        .maps-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #4285f4;
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
            margin-left: 8px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin: 20px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .today-highlight {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .acompte-badge {
            background: #28a745;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            margin-left: 10px;
        }

        .refresh-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
            cursor: pointer;
            z-index: 100;
        }

        .admin-btn {
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1>📅 Planning Installations</h1>
            <a href="{{ route('planning.index') }}" class="admin-btn">⚙️</a>
        </div>
        <div class="header-date">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</div>
    </div>

    <div class="tabs">
        <button class="tab active" onclick="filterTab('upcoming')">À venir</button>
        <button class="tab" onclick="filterTab('today')">Aujourd'hui</button>
        <button class="tab" onclick="filterTab('all')">Toutes</button>
    </div>

    <div class="container">
        @php
            $today = now()->format('Y-m-d');
            $upcoming = $reservations->filter(fn($r) => $r->date_reservation->format('Y-m-d') >= $today && $r->statut != 'termine');
            $todayRes = $reservations->filter(fn($r) => $r->date_reservation->format('Y-m-d') == $today);
        @endphp

        <div id="content-upcoming" class="tab-content">
            @if($upcoming->count() > 0)
                @foreach($upcoming->sortBy('date_reservation') as $r)
                    @include('planning.partials.card', ['r' => $r, 'today' => $today])
                @endforeach
            @else
                <div class="empty-state">
                    <h3>🎉 Aucune réservation à venir</h3>
                    <p>Profitez du temps libre !</p>
                </div>
            @endif
        </div>

        <div id="content-today" class="tab-content" style="display: none;">
            @if($todayRes->count() > 0)
                @foreach($todayRes as $r)
                    @include('planning.partials.card', ['r' => $r, 'today' => $today])
                @endforeach
            @else
                <div class="empty-state">
                    <h3>📅 Rien pour aujourd'hui</h3>
                    <p>Pas de réservation prévue</p>
                </div>
            @endif
        </div>

        <div id="content-all" class="tab-content" style="display: none;">
            @if($reservations->count() > 0)
                @foreach($reservations->sortByDesc('date_reservation') as $r)
                    @include('planning.partials.card', ['r' => $r, 'today' => $today])
                @endforeach
            @else
                <div class="empty-state">
                    <h3>📋 Aucune réservation</h3>
                </div>
            @endif
        </div>
    </div>

    <button class="refresh-btn" onclick="location.reload()">🔄</button>

    <!-- Lightbox pour photos -->
    <div class="lightbox" id="photoLightbox" onclick="closeLightbox(event)">
        <div class="lightbox-content" onclick="event.stopPropagation()">
            <button class="lightbox-close" onclick="closeLightbox()">&times;</button>
            <img id="lightboxImage" src="" alt="Photo agrandie">
        </div>
    </div>

    <script>
        function filterTab(tab) {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            event.target.classList.add('active');

            document.querySelectorAll('.tab-content').forEach(c => c.style.display = 'none');
            document.getElementById('content-' + tab).style.display = 'block';
        }

        function updateStatus(id, status, btn) {
            // Visual feedback
            const card = btn.closest('.reservation-card');
            card.querySelectorAll('.status-btn').forEach(b => b.classList.remove('selected'));
            btn.classList.add('selected');

            fetch('/reservations/' + id + '/statut', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ statut: status })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    // Update badge
                    const badge = card.querySelector('.reservation-badge');
                    badge.textContent = data.statut_label;
                    badge.style.background = data.statut_color;

                    // Update card style
                    card.className = 'reservation-card ' + status;

                    // Reload after short delay if marked as done
                    if (status === 'termine') {
                        setTimeout(() => location.reload(), 1000);
                    }
                }
            });
        }

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
    </script>
</body>
</html>
