<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits - Produits2Fou</title>
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

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 0 10px;
            width: calc(100% - 20px);
        }

        .product-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            color: white;
            display: block;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
        }

        .product-image {
            width: 100%;
            height: 280px;
            object-fit: cover;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.3) 0%, rgba(118, 75, 162, 0.3) 100%);
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-weight: 700;
            font-size: 1.2em;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 50px;
        }

        .product-description {
            font-size: 0.95em;
            opacity: 0.9;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            color: #FFD700;
            font-weight: 700;
            font-size: 1.5em;
        }

        .no-products {
            text-align: center;
            padding: 80px 20px;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 500px;
            margin: 0 auto;
        }

        .no-products-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .no-products h3 {
            font-size: 1.5em;
            margin-bottom: 10px;
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
            .product-image {
                height: 240px;
            }

            .product-info {
                padding: 15px;
            }

            .product-name {
                font-size: 1em;
                min-height: 40px;
            }

            .page-header h2 {
                font-size: 1.5em;
            }

            .nav-item {
                font-size: 0.95em;
            }

            .nav-item-icon {
                font-size: 1.3em;
            }
        }

        @media (min-width: 769px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .product-grid {
                grid-template-columns: repeat(4, 1fr);
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
            <h2>Nos Produits</h2>
            <p>Découvrez notre collection complète</p>
        </div>

        @if($produits->count() > 0)
            <div class="product-grid">
                @foreach($produits as $produit)
                    <a href="{{ route('produit.detail', $produit->id) }}" class="product-card">
                        @if($produit->images->count() > 0)
                            <img src="{{ asset('storage/' . $produit->images->first()->chemin_image) }}"
                                 alt="{{ $produit->nom }}"
                                 class="product-image"
                                 loading="lazy">
                        @else
                            <div class="product-image"></div>
                        @endif
                        <div class="product-info">
                            <div class="product-name">{{ $produit->nom }}</div>
                            <div class="product-description">{{ $produit->description }}</div>
                            <div class="product-price">{{ number_format($produit->prix, 2) }} €</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="no-products">
                <div class="no-products-icon">📦</div>
                <h3>Aucun produit disponible</h3>
                <p>Revenez bientôt pour découvrir nos nouveautés!</p>
            </div>
        @endif
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('accueil') }}" class="nav-item">
            <i class="fa-solid fa-house fa-xl" style="color: #ffffff;"></i>
            <span>Accueil</span>
        </a>
        <a href="{{ route('produits') }}" class="nav-item active">
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
</body>
</html>
