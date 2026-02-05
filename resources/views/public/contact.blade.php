<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Produits2Fou</title>
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
            background: rgba(0, 0, 0, 0.5);
        }

        /* Container */
        .container {
            position: relative;
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 100px;
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

        .page-header h2 {
            font-size: 2em;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .page-header p {
            font-size: 1.1em;
            opacity: 0.95;
        }

        /* Phone Display */
        .phone-display {
            background: rgba(255, 215, 0, 0.2);
            backdrop-filter: blur(15px);
            border: 2px solid rgba(255, 215, 0, 0.5);
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            margin-bottom: 30px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .phone-display .icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .phone-number {
            font-size: 2em;
            font-weight: 700;
            color: #FFD700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .call-btn {
            display: inline-block;
            background: #FFD700;
            color: #000;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1em;
            transition: transform 0.3s;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }

        .call-btn:hover {
            transform: scale(1.05);
        }

        /* Store Grid */
        .store-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 0 10px 30px 10px;
            width: calc(100% - 20px);
        }

        .store-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .store-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .store-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            flex-shrink: 0;
        }

        .store-name {
            font-size: 1.3em;
            font-weight: 700;
        }

        .info-row {
            display: flex;
            gap: 12px;
            margin-bottom: 15px;
            align-items: flex-start;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.85em;
            color: #FFD700;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 1em;
            line-height: 1.5;
        }

        .info-value a {
            color: white;
            text-decoration: none;
            font-weight: 600;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .action-btn {
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95em;
            transition: transform 0.2s;
        }

        .action-btn:active {
            transform: scale(0.95);
        }

        .action-btn-call {
            background: #FFD700;
            color: #000;
        }

        .action-btn-map {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Contact Form */
        .contact-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            margin: 0 10px;
            color: white;
        }

        .form-title {
            font-size: 1.5em;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.95em;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 1em;
            font-family: inherit;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: border-color 0.3s;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #FFD700;
            background: rgba(255, 255, 255, 0.15);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            width: 100%;
            padding: 15px;
            font-size: 1.1em;
            background: #FFD700;
            color: #000;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .submit-btn:hover {
            transform: scale(1.02);
        }

        /* Bottom Navigation */
        .bottom-nav {
            position: fixed;
            bottom: 10px;
            left: 10px;
            width: calc(100% - 20px);
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(20px);
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            border-top-left-radius: 25px;
            border-top-right-radius: 25px;
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
            z-index: 1000;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #fff;
            font-size: 0.9em;
            transition: color 0.3s;
            flex: 1;
            max-width: 100px;
        }

        .nav-item:hover,
        .nav-item.active {
            color: #FFD700;
        }

        i {
            font-size: 1.5em;
            
            padding: 15px;
        }

        @media (max-width: 768px) {
            .page-header h2 {
                font-size: 1.5em;
            }

            .phone-number {
                font-size: 1.5em;
            }

            .store-grid {
                grid-template-columns: 1fr;
            }

            .contact-form {
                margin: 0 auto;
                max-width: calc(100% - 20px);
            }

            .nav-item {
                font-size: 0.95em;
            }

            .nav-item-icon {
                font-size: 1.3em;
            }
        }

        @media (min-width: 769px) {
            .contact-form {
                margin: 0 auto;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/06b6a43379.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay muted loop playsinline preload="metadata">
            <source src="{{ asset('img/back.mp4') }}" type="video/mp4">
        </video>
        <div class="video-overlay"></div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="page-header">
            <h2>Contactez-nous</h2>
            <p>Nous sommes à votre écoute</p>
        </div>

        <!-- Phone Display -->
        <div class="phone-display">
            <div class="icon">📞</div>
            <div class="phone-number">06 29 72 64 98</div>
            <a href="tel:0629726498" class="call-btn">Appeler Maintenant</a>
        </div>

        <!-- Store Information -->
        <div class="store-grid">
            <div class="store-card">
                <div class="store-header">
                    <div class="store-icon">📍</div>
                    <div class="store-name">Magasin Pierrelaye</div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <div class="info-label">Adresse</div>
                        <div class="info-value">178 allée du poirier saint jean<br>95480 Pierrelaye, France</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📞</div>
                    <div class="info-content">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">
                            <a href="tel:0629726498">06 29 72 64 98</a>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">🕐</div>
                    <div class="info-content">
                        <div class="info-label">Horaires</div>
                        <div class="info-value">
                            Lun-Dim: 10h-18h
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="tel:0629726498" class="action-btn action-btn-call">📞 Appeler</a>
                    <a href="https://maps.google.com/?q=178+allée+du+poirier+saint+jean+95480+Pierrelaye" target="_blank" class="action-btn action-btn-map">🗺️ Itinéraire</a>
                </div>
            </div>

            <div class="store-card">
                <div class="store-header">
                    <div class="store-icon">📍</div>
                    <div class="store-name">Magasin Tarascon</div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📍</div>
                    <div class="info-content">
                        <div class="info-label">Adresse</div>
                        <div class="info-value">Rue des Forgerons<br>13150 Tarascon, France</div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">📞</div>
                    <div class="info-content">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">
                            <a href="tel:0984181142">09 84 18 11 42</a>
                        </div>
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-icon">🕐</div>
                    <div class="info-content">
                        <div class="info-label">Horaires</div>
                        <div class="info-value">
                            Lun-Dim: 10h-18h
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="tel:0984181142" class="action-btn action-btn-call">📞 Appeler</a>
                    <a href="https://maps.google.com/?q=Rue+des+Forgerons+13150+Tarascon" target="_blank" class="action-btn action-btn-map">🗺️ Itinéraire</a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="contact-form">
            @if(session('success'))
                <div style="background: rgba(76, 175, 80, 0.3); backdrop-filter: blur(10px); border: 1px solid rgba(76, 175, 80, 0.5); border-radius: 12px; padding: 15px; margin-bottom: 20px; text-align: center;">
                    {{ session('success') }}
                </div>
            @endif
            <h3 class="form-title">Envoyez-nous un message</h3>
            @if(session('error'))
                <div style="background: rgba(220, 53, 69, 0.3); backdrop-filter: blur(10px); border: 1px solid rgba(220, 53, 69, 0.5); border-radius: 12px; padding: 15px; margin-bottom: 20px; text-align: center;">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                @csrf
                {{-- Honeypot field - hidden from humans, bots will fill it --}}
                <div style="position: absolute; left: -9999px; opacity: 0; height: 0; overflow: hidden;">
                    <label for="website">Website</label>
                    <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                </div>

                {{-- Timestamp to detect fast submissions --}}
                <input type="hidden" name="form_time" value="{{ time() }}">

                <div class="form-group">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="nom" class="form-input" placeholder="Votre nom" required value="{{ old('nom') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="votre@email.com" required value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="tel" name="telephone" class="form-input" placeholder="06 XX XX XX XX" value="{{ old('telephone') }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-textarea" placeholder="Votre message..." required>{{ old('message') }}</textarea>
                </div>

                {{-- Anti-bot math question --}}
                @php
                    $num1 = rand(1, 10);
                    $num2 = rand(1, 10);
                    $answer = $num1 + $num2;
                @endphp
                <div class="form-group">
                    <label class="form-label">🔒 Vérification anti-robot : {{ $num1 }} + {{ $num2 }} = ?</label>
                    <input type="number" name="captcha_answer" class="form-input" placeholder="Votre réponse" required style="max-width: 150px;">
                    <input type="hidden" name="captcha_expected" value="{{ base64_encode($answer . '_' . time()) }}">
                </div>

                <button type="submit" class="submit-btn">Envoyer le message</button>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('accueil') }}" class="nav-item ">
            <i class="fa-solid fa-house fa-xl" style="color: #ffffff;"></i>
            <span>Accueil</span>
        </a>
        <a href="{{ route('produits') }}" class="nav-item">
            <i class="fa-solid fa-tag fa-xl" style="color: #ffffff;"></i>
            <span>Produits</span>
        </a>
        <a href="{{ route('services') }}" class="nav-item">
            <i class="fa-solid fa-paint-roller fa-xl" style="color: #ffffff;"></i>
            <span>Services</span>
        </a>
        <a href="{{ route('contact') }}" class="nav-item active">
            <i class="fa-solid fa-envelope fa-xl" style="color: #ffffff;"></i>
            <span>Contact</span>
        </a>
    </nav>
</body>
</html>
