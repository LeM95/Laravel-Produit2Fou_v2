<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation confirmee - Produits2Fou</title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Success Card */
        .success-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 50px 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 50px;
            color: white;
            animation: scaleIn 0.5s ease-out;
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-card h1 {
            color: #28a745;
            font-size: 2em;
            margin-bottom: 15px;
        }

        .success-card p {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        /* Reservation Details */
        .reservation-details {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: left;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        /* Date highlight */
        .date-highlight {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .date-highlight .label {
            font-size: 0.9em;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .date-highlight .date {
            font-size: 1.5em;
            font-weight: 700;
        }

        /* Button */
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background: linear-gradient(135deg, #333, #555);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }

        /* Info note */
        .info-note {
            background: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 0.9em;
            color: #856404;
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
        <div class="success-card">
            <div class="success-icon">&#10003;</div>
            <h1>Reservation confirmee !</h1>
            <p>Votre paiement a ete accepte et votre creneau est reserve.</p>

            <div class="date-highlight">
                <div class="label">Date de votre reservation</div>
                <div class="date">{{ $date }}</div>
            </div>

            <div class="reservation-details">
                <div class="detail-row">
                    <span class="detail-label">Nom</span>
                    <span class="detail-value">{{ $reservation->client_nom }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Telephone</span>
                    <span class="detail-value">{{ $reservation->client_telephone }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Adresse</span>
                    <span class="detail-value">{{ $reservation->adresse }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Ville</span>
                    <span class="detail-value">{{ $reservation->ville }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Acompte paye</span>
                    <span class="detail-value">100,00 &#8364;</span>
                </div>
            </div>

            <div class="info-note">
                Nous vous contacterons tres prochainement pour confirmer les details de l'intervention.
            </div>

            <a href="/" class="btn-home">
                <span>&#8592;</span>
                Retour au site
            </a>
        </div>
    </div>
</body>
</html>
