<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $produit->nom }} - Produits2Fou</title>
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
            background: rgba(0, 0, 0, 0.4);
        }

        /* Container */
        .container {
            position: relative;
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 120px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Back Button */
        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 600;
            color: white;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Image Gallery */
        .image-gallery {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .main-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            background: rgba(0, 0, 0, 0.3);
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            padding: 15px;
            overflow-x: auto;
            background: rgba(0, 0, 0, 0.3);
        }

        .thumbnail {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            cursor: pointer;
            border: 2px solid transparent;
            transition: all 0.3s;
            flex-shrink: 0;
        }

        .thumbnail.active {
            border-color: #FFD700;
            transform: scale(1.05);
        }

        /* Product Details */
        .product-details {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .product-title {
            font-size: 1.8em;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .product-price {
            font-size: 2em;
            font-weight: 700;
            color: #FFD700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .section-title {
            font-size: 1.2em;
            font-weight: 600;
            color: #FFD700;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .product-description {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.7;
            font-size: 1em;
        }

        .contact-btn {
            width: 100%;
            margin-top: 25px;
            padding: 18px;
            font-size: 1.1em;
            background: #FFD700;
            color: #000;
            border: none;
            border-radius: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s;
            display: block;
            text-align: center;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }

        .contact-btn:hover {
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

        @media (min-width: 768px) {
            .main-image {
                height: 400px;
            }

            .thumbnail {
                width: 90px;
                height: 90px;
            }

            .container {
                max-width: 700px;
            }
        }

        @media (max-width: 768px) {
            .nav-item {
                font-size: 0.95em;
            }

            .product-title {
                font-size: 1.5em;
            }

            .product-price {
                font-size: 1.6em;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/06b6a43379.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Video Background -->
    <div class="video-background">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('img/back.mp4') }}" type="video/mp4">
        </video>
        <div class="video-overlay"></div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <a href="{{ route('produits') }}" class="back-btn">← Retour aux produits</a>

        <div class="image-gallery">
            @if($produit->images->count() > 0)
                <img src="{{ asset('storage/' . $produit->images->first()->chemin_image) }}"
                     alt="{{ $produit->nom }}"
                     class="main-image"
                     id="mainImage">

                @if($produit->images->count() > 1)
                    <div class="thumbnail-container">
                        @foreach($produit->images as $index => $image)
                            <img src="{{ asset('storage/' . $image->chemin_image) }}"
                                 alt="{{ $produit->nom }}"
                                 class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                                 data-src="{{ asset('storage/' . $image->chemin_image) }}"
                                 onclick="changeImage(this.dataset.src, this)">
                        @endforeach
                    </div>
                @endif
            @else
                <div class="main-image"></div>
            @endif
        </div>

        <div class="product-details">
            <h1 class="product-title">{{ $produit->nom }}</h1>
            <div class="product-price">{{ number_format($produit->prix, 2) }} €</div>

            <div class="section-title">Description</div>
            <p class="product-description">{{ $produit->description }}</p>

            <a href="{{ route('contact') }}" class="contact-btn">Commander maintenant</a>
        </div>
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

    <script>
        function changeImage(src, element) {
            document.getElementById('mainImage').src = src;

            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });

            element.classList.add('active');
        }
    </script>
</body>
</html>
