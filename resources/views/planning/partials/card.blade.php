<div class="reservation-card {{ $r->statut }} {{ $r->date_reservation->format('Y-m-d') == $today ? 'today-highlight' : '' }}" data-id="{{ $r->id }}">
    <div class="reservation-date">
        📅 {{ $r->date_reservation->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
        @if($r->date_reservation->format('Y-m-d') == $today)
            <span style="background: #667eea; color: white; padding: 2px 8px; border-radius: 10px; font-size: 11px; margin-left: 5px;">AUJOURD'HUI</span>
        @endif
    </div>

    <div class="reservation-client">
        {{ $r->client_nom }}
        @if($r->acompte)
            <span class="acompte-badge">💰 Acompte OK</span>
        @endif
    </div>

    @if($r->ville || $r->adresse)
        <div class="reservation-info">
            📍 {{ $r->ville }}{{ $r->adresse ? ' - ' . $r->adresse : '' }}
        </div>
    @endif

    @if($r->client_telephone)
        <div class="reservation-info">
            📞 <a href="tel:{{ $r->client_telephone }}">{{ $r->client_telephone }}</a>
        </div>
    @endif

    @if($r->type_mur)
        <div class="reservation-info">
            🧱 {{ $r->type_mur }}
        </div>
    @endif

    @if($r->service)
        <div class="reservation-info">
            📦 {{ $r->service->nom }}
        </div>
    @endif

    @if($r->description)
        <div class="reservation-info" style="font-style: italic;">
            📝 {{ $r->description }}
        </div>
    @endif

    @if($r->prix)
        <div class="reservation-info" style="font-weight: 700; color: #28a745;">
            💶 {{ number_format($r->prix, 2) }} €
        </div>
    @endif

    @if($r->produits && $r->produits->count() > 0)
        <div class="reservation-info" style="margin-top: 10px;">
            <span style="font-weight: 600;">🎨 Produits:</span>
        </div>
        <div class="products-row">
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
                <div class="product-thumb-card" onclick="openLightbox('{{ $colorImage }}')">
                    @if($colorImage)
                        <img src="{{ $colorImage }}" alt="{{ $prod->nom }}">
                    @endif
                    <span class="product-thumb-name">{{ $prod->nom }}{{ $colorName && $colorName != 'Default' ? ' - ' . $colorName : '' }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <span class="reservation-badge" style="background: {{ $r->statut_color }}">
        {{ $r->statut_label }}
    </span>

    @if($r->photos->count() > 0)
        <div class="photos-row">
            @foreach($r->photos as $photo)
                <img src="{{ asset('storage/' . $photo->chemin_photo) }}"
                     class="photo-thumb"
                     onclick="openLightbox('{{ asset('storage/' . $photo->chemin_photo) }}')">
            @endforeach
        </div>
    @endif

    <div style="margin-top: 15px;">
        @if($r->client_telephone)
            <a href="tel:{{ $r->client_telephone }}" class="call-btn">📞 Appeler</a>
        @endif
        @if($r->adresse && $r->ville)
            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($r->adresse . ', ' . $r->ville) }}" target="_blank" class="maps-btn">🗺️ GPS</a>
        @endif
    </div>

    <div class="status-buttons">
        <button class="status-btn attente {{ $r->statut == 'en_attente' ? 'selected' : '' }}" onclick="updateStatus({{ $r->id }}, 'en_attente', this)">⏳ En attente</button>
        <button class="status-btn confirme {{ $r->statut == 'confirme' ? 'selected' : '' }}" onclick="updateStatus({{ $r->id }}, 'confirme', this)">✅ Confirmé</button>
        <button class="status-btn termine {{ $r->statut == 'termine' ? 'selected' : '' }}" onclick="updateStatus({{ $r->id }}, 'termine', this)">✔️ Terminé</button>
    </div>
</div>
