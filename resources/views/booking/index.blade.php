<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reserver votre creneau - Produits2Fou</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            background: #000;
        }

        /* Video Background */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .video-background video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }

        /* Container */
        .container {
            position: relative;
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 100px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Page Header */
        .page-header {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-header h1 {
            font-size: 2em;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .page-header p {
            font-size: 1.1em;
            opacity: 0.95;
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Cards */
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .card-title {
            font-size: 1.4em;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        /* Calendar Styles */
        #calendar {
            background: white;
            border-radius: 10px;
        }

        .fc {
            font-family: inherit;
        }

        .fc-toolbar-title {
            font-size: 1.2em !important;
        }

        .fc-button {
            background-color: #333 !important;
            border-color: #333 !important;
        }

        .fc-button:hover {
            background-color: #555 !important;
        }

        .fc-button-active {
            background-color: #000 !important;
        }

        .fc-daygrid-day {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .fc-daygrid-day:hover {
            background-color: #f0f0f0;
        }

        .fc-day-today {
            background-color: rgba(255, 215, 0, 0.2) !important;
        }

        .fc-day-past {
            background-color: #f5f5f5 !important;
            cursor: not-allowed;
        }

        .unavailable-date {
            opacity: 0.9;
        }

        .selected-date {
            background-color: rgba(40, 167, 69, 0.3) !important;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1em;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #333;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }

        .form-group input:disabled {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        .form-group select {
            background-color: white;
            cursor: pointer;
        }

        /* Photo Upload Styles */
        .photo-upload {
            border: 2px dashed #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: border-color 0.3s, background-color 0.3s;
            cursor: pointer;
        }

        .photo-upload:hover {
            border-color: #333;
            background-color: #f8f9fa;
        }

        .photo-upload.has-file {
            border-color: #28a745;
            background-color: rgba(40, 167, 69, 0.1);
        }

        .photo-upload input[type="file"] {
            display: none;
        }

        .photo-upload-icon {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .photo-upload-text {
            color: #666;
            font-size: 0.95em;
        }

        .photo-upload-text strong {
            color: #333;
        }

        .photo-preview {
            max-width: 100%;
            max-height: 150px;
            margin-top: 10px;
            border-radius: 8px;
            display: none;
        }

        .photo-preview.visible {
            display: block;
        }

        /* Selected Date Display */
        .selected-date-display {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: none;
            align-items: center;
            gap: 10px;
        }

        .selected-date-display.active {
            display: flex;
        }

        .selected-date-display .icon {
            font-size: 1.5em;
        }

        .selected-date-display .date-text {
            font-size: 1.1em;
            font-weight: 600;
        }

        /* Price Display */
        .price-display {
            background: rgba(255, 215, 0, 0.2);
            border: 2px solid rgba(255, 215, 0, 0.5);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .price-display .amount {
            font-size: 2.5em;
            font-weight: 700;
            color: #333;
        }

        .price-display .label {
            color: #666;
            font-size: 0.95em;
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 15px 30px;
            background: linear-gradient(135deg, #333, #555);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        /* Alert Messages */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        /* Legend */
        .calendar-legend {
            display: flex;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9em;
            color: #666;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
        }

        .legend-color.unavailable {
            background: #dc3545;
        }

        .legend-color.pending {
            background: #ffc107;
        }

        .legend-color.available {
            background: #28a745;
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 20px;
            text-align: center;
        }

        .footer a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: opacity 0.3s;
        }

        .footer a:hover {
            opacity: 0.8;
        }

        /* Instructions */
        .instructions {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .instructions h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .instructions ol {
            margin-left: 20px;
            color: #666;
        }

        .instructions li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('videos/background.mp4') }}" type="video/mp4">
        </video>
        <div class="video-overlay"></div>
    </div>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Reserver votre creneau</h1>
            <p>Selectionnez une date disponible et remplissez vos informations</p>
        </div>

        <!-- Alert Messages -->
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">{{ session('info') }}</div>
        @endif

        <div class="content-grid">
            <!-- Calendar Section -->
            <div class="card">
                <h2 class="card-title">Calendrier des disponibilites</h2>
                <div id="calendar"></div>
                <div class="calendar-legend">
                    <div class="legend-item">
                        <div class="legend-color available"></div>
                        <span>Disponible</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color pending"></div>
                        <span>En attente</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color unavailable"></div>
                        <span>Indisponible</span>
                    </div>
                </div>
            </div>

            <!-- Booking Form Section -->
            <div class="card">
                <h2 class="card-title">Vos informations</h2>

                <div class="instructions">
                    <h4>Comment reserver ?</h4>
                    <ol>
                        <li>Cliquez sur une date verte dans le calendrier</li>
                        <li>Remplissez vos coordonnees</li>
                        <li>Cliquez sur "Payer et reserver"</li>
                        <li>Effectuez le paiement securise</li>
                    </ol>
                </div>

                <div class="selected-date-display" id="selectedDateDisplay">
                    <span class="icon">&#128197;</span>
                    <span class="date-text" id="selectedDateText"></span>
                </div>

                <form action="{{ route('booking.checkout') }}" method="POST" id="bookingForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="date" id="selectedDate" value="{{ old('date') }}">

                    <div class="form-group">
                        <label for="nom">Nom complet *</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required placeholder="Votre nom et prenom">
                    </div>

                    <div class="form-group">
                        <label for="telephone">Telephone *</label>
                        <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" required placeholder="06 12 34 56 78">
                    </div>

                    <div class="form-group">
                        <label for="adresse">Adresse complete *</label>
                        <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" required placeholder="Numero et nom de rue">
                    </div>

                    <div class="form-group">
                        <label for="ville">Ville *</label>
                        <input type="text" id="ville" name="ville" value="{{ old('ville') }}" required placeholder="Votre ville">
                    </div>

                    <div class="form-group">
                        <label for="type_mur">Type de mur *</label>
                        <select id="type_mur" name="type_mur" required>
                            <option value="">-- Selectionnez le type de mur --</option>
                            <option value="platre" {{ old('type_mur') == 'platre' ? 'selected' : '' }}>Platre</option>
                            <option value="beton" {{ old('type_mur') == 'beton' ? 'selected' : '' }}>Beton</option>
                            <option value="brique" {{ old('type_mur') == 'brique' ? 'selected' : '' }}>Brique</option>
                            <option value="parpaing" {{ old('type_mur') == 'parpaing' ? 'selected' : '' }}>Parpaing</option>
                            <option value="placo" {{ old('type_mur') == 'placo' ? 'selected' : '' }}>Placo / BA13</option>
                            <option value="pierre" {{ old('type_mur') == 'pierre' ? 'selected' : '' }}>Pierre</option>
                            <option value="autre" {{ old('type_mur') == 'autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Photo du mur (vue de loin) *</label>
                        <div class="photo-upload" onclick="document.getElementById('photo_mur').click()">
                            <div class="photo-upload-icon">📷</div>
                            <div class="photo-upload-text">
                                <strong>Cliquez pour ajouter une photo</strong><br>
                                Photo du mur prise de loin
                            </div>
                            <input type="file" id="photo_mur" name="photo_mur" accept="image/*" required onchange="previewImage(this, 'preview_mur')">
                            <img id="preview_mur" class="photo-preview" alt="Apercu">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Photo des prises electriques *</label>
                        <div class="photo-upload" onclick="document.getElementById('photo_prises').click()">
                            <div class="photo-upload-icon">🔌</div>
                            <div class="photo-upload-text">
                                <strong>Cliquez pour ajouter une photo</strong><br>
                                Photo montrant l'emplacement des prises
                            </div>
                            <input type="file" id="photo_prises" name="photo_prises" accept="image/*" required onchange="previewImage(this, 'preview_prises')">
                            <img id="preview_prises" class="photo-preview" alt="Apercu">
                        </div>
                    </div>

                    <div class="price-display">
                        <div class="amount">100,00 &#8364;</div>
                        <div class="label">Acompte de reservation (frais de paiement inclus)</div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                        <span>&#128179;</span>
                        Payer et reserver
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <a href="/">&#8592; Retour au site</a>
    </div>

    <script>
        let calendar;
        let selectedDate = null;
        const unavailableDates = new Set();

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                firstDay: 1,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                buttonText: {
                    today: "Aujourd'hui"
                },
                height: 'auto',
                selectable: false,
                events: function(info, successCallback, failureCallback) {
                    fetch('{{ route("booking.dates") }}')
                        .then(response => response.json())
                        .then(data => {
                            // Store unavailable dates
                            unavailableDates.clear();
                            data.forEach(event => {
                                unavailableDates.add(event.start);
                            });
                            successCallback(data);
                        })
                        .catch(error => {
                            console.error('Error fetching dates:', error);
                            failureCallback(error);
                        });
                },
                dateClick: function(info) {
                    const clickedDate = info.dateStr;
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    const clicked = new Date(clickedDate);

                    // Check if date is in the past
                    if (clicked < today) {
                        alert('Vous ne pouvez pas selectionner une date passee.');
                        return;
                    }

                    // Check if date is unavailable
                    if (unavailableDates.has(clickedDate)) {
                        alert('Cette date est deja reservee. Veuillez en choisir une autre.');
                        return;
                    }

                    // Remove previous selection
                    document.querySelectorAll('.selected-date').forEach(el => {
                        el.classList.remove('selected-date');
                    });

                    // Add selection to clicked date
                    info.dayEl.classList.add('selected-date');
                    selectedDate = clickedDate;

                    // Update form
                    document.getElementById('selectedDate').value = clickedDate;

                    // Format date for display
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const formattedDate = clicked.toLocaleDateString('fr-FR', options);

                    // Show selected date
                    document.getElementById('selectedDateText').textContent = formattedDate;
                    document.getElementById('selectedDateDisplay').classList.add('active');

                    // Enable submit button
                    document.getElementById('submitBtn').disabled = false;
                }
            });

            calendar.render();

// Image preview function
        window.previewImage = function(input, previewId) {
            const preview = document.getElementById(previewId);
            const uploadDiv = input.closest('.photo-upload');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('visible');
                    uploadDiv.classList.add('has-file');
                    uploadDiv.querySelector('.photo-upload-text').innerHTML = '<strong>Photo selectionnee ✓</strong><br>Cliquez pour changer';
                };

                reader.readAsDataURL(input.files[0]);
            }
        };

            // Form validation
            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                if (!selectedDate) {
                    e.preventDefault();
                    alert('Veuillez selectionner une date dans le calendrier.');
                    return false;
                }

                const nom = document.getElementById('nom').value.trim();
                const telephone = document.getElementById('telephone').value.trim();
                const adresse = document.getElementById('adresse').value.trim();
                const ville = document.getElementById('ville').value.trim();
                const typeMur = document.getElementById('type_mur').value;
                const photoMur = document.getElementById('photo_mur').files.length;
                const photoPrises = document.getElementById('photo_prises').files.length;

                if (!nom || !telephone || !adresse || !ville || !typeMur) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                    return false;
                }

                if (!photoMur || !photoPrises) {
                    e.preventDefault();
                    alert('Veuillez ajouter les deux photos requises (mur et prises).');
                    return false;
                }

                // Disable button to prevent double submission
                document.getElementById('submitBtn').disabled = true;
                document.getElementById('submitBtn').innerHTML = '<span>&#8987;</span> Redirection vers le paiement...';
            });
        });
    </script>
</body>
</html>
