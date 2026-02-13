<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Magasin de decoration Préferer - Décoration Murale Élégante</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --nav-height: 80px;
            --nav-margin: 10px;
            --content-gap: 30px;
            --safe-bottom: calc(var(--nav-height) + var(--nav-margin) + var(--content-gap));
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            overflow-x: hidden;
            
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
            background: rgba(0, 0, 0, 0);
        }

        /* Main Content */
        .container {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 40px 20px;
            padding-bottom: var(--safe-bottom);
        }

        /* Hero Section */
        .hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }

        .hero-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 600px;
            width: 100%;
        }

        .hero h1 {
            font-size: 2.5em;
            color: white;
            margin-bottom: 10px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .contact-btn {
            display: inline-block;
            background: #FFD700;
            color: #000;
            padding: 15px 40px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.1em;
            margin-bottom: 20px;
            transition: transform 0.3s;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }

        .contact-btn:hover {
            transform: scale(1.05);
        }

        .phone {
            color: white;
            font-size: 1.2em;
            font-weight: 600;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Cards Grid */
        .cards-grid {
            display: flex;
            gap: 10px;
            margin: 0 10px;
            width: calc(100% - 20px);
        }

        .card {
            flex: 1;
            background: #00000099;
            backdrop-filter: blur(20px);
            border-radius: 15px;
            
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        #gauche{
            border-bottom-right-radius: 0px;
            border-top-right-radius: 0px;
        }
        #droite{
            border-bottom-left-radius: 0px;
            border-top-left-radius: 0px;
        }

        

        .card-icon {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .card h2 {
            color: white;
            font-size: 1.5em;
            font-weight: 700;
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
            .hero h1 {
                font-size: 2.2em;
            }
            .container {
                padding: 10px;
                padding-bottom: var(--safe-bottom);
            }
            .cards-grid {
                flex-direction: row;
                width: 100%;
                margin: 0px;
            }
            .card{
                flex:1;
                padding: 40px 0px;
            }
            .hero-content {
                padding: 50px 10px;
                background-color: #00000099;
            }

            .nav-item {
                font-size: 0.95em;
            }

            .nav-item-icon {
                font-size: 1.3em;
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
        <!-- Hero Section -->
        <div class="hero">
            <div class="hero-content">
                <h1>Décoration Murale Élégante</h1>
                <p style=" font-size: 18px; color: white;padding: 20px;text-align: center;letter-spacing: 1px;font-weight: 600;">Découvrez nos produits haut de gamme et notre service d'installation professionnelle.</p>
                <a href="#" class="contact-btn" id="contactBtn">Nous Contacter</a>
            </div>
        </div>
 
        <!-- Cards Grid -->
        <div class="cards-grid">
            <a href="{{ route('produits') }}" class="card" id="gauche">
                <i class="fa-solid fa-tag fa-xl" style="color: #ffffff;"></i>
                <h2>Nos Produits</h2>
            </a>
            <a href="{{ route('services') }}" class="card" id="droite">
                <i class="fa-solid fa-paint-roller fa-xl" style="color: #ffffff;"></i>
                <h2>Nos Services</h2>
            </a>
        </div>
    </div>
    <!-- Popup de contact -->
    <div id="contactPopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 1000; justify-content: center; align-items: center;">
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(8px);" id="popupOverlay"></div>
        <div style="position: relative; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border-radius: 25px; padding: 40px; max-width: 500px; width: 90%; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3); border: 1px solid rgba(255, 255, 255, 0.2);">
            <h2 style="color: white; text-align: center; margin-bottom: 30px; font-size: 24px;">Que souhaitez-vous ?</h2>
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <a href="tel:+33629726498" style="display: block; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(5px); color: white; text-decoration: none; padding: 20px; border-radius: 15px; text-align: center; font-size: 18px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'">
                    <i class="fa-solid fa-tag" style="margin-right: 10px;"></i>
                    Acheter le matériel
                    <div style="font-size: 14px; margin-top: 8px; opacity: 0.9;">06 29 72 64 98</div>
                </a>
                <a href="tel:+33767301511" style="display: block; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(5px); color: white; text-decoration: none; padding: 20px; border-radius: 15px; text-align: center; font-size: 18px; font-weight: 600; border: 1px solid rgba(255, 255, 255, 0.3); transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'">
                    <i class="fa-solid fa-paint-roller" style="margin-right: 10px;"></i>
                    Réalisation d'une décoration murale
                    <div style="font-size: 14px; margin-top: 8px; opacity: 0.9;">07 67 30 15 11</div>
                </a>
            </div>
            <button id="closePopup" style="position: absolute; top: 15px; right: 15px; background: rgba(255, 255, 255, 0.2); border: none; color: white; font-size: 24px; cursor: pointer; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)'">&times;</button>
        </div>
    </div>
    
    
    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('accueil') }}" class="nav-item active">
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
        <a href="{{ route('contact') }}" class="nav-item">
            <i class="fa-solid fa-envelope fa-xl" style="color: #ffffff;"></i>
            <span>Contact</span>
        </a>
    </nav>
    <script>
        const contactBtn = document.getElementById('contactBtn')
        const contactPopup = document.getElementById('contactPopup')
        const closePopup = document.getElementById('closePopup')
        const popupOverlay = document.getElementById('popupOverlay')


        // Ouvrir la popup
        contactBtn.addEventListener('click', () => {
            contactPopup.style.display = 'flex';
        })

        // Fermer la popup avec le bouton X
        closePopup.addEventListener('click', () => {
            contactPopup.style.display = 'none';
        })

        // Fermer la popup en cliquant sur l'overlay
        popupOverlay.addEventListener('click', () => {
            contactPopup.style.display = 'none';
        })

        // Fermer la popup avec la touche Échap
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && contactPopup.style.display === 'flex') {
                contactPopup.style.display = 'none';
            }
        })
        
    </script>
</body>
</html>
