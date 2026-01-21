<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Produits2Fou')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            color: #333;
            overflow-x: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 24px;
            font-weight: 700;
            text-align: center;
        }

        .nav {
            display: flex;
            justify-content: space-around;
            background: white;
            padding: 10px 0;
            position: sticky;
            top: 60px;
            z-index: 999;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .nav a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 20px;
            transition: all 0.3s;
        }

        .nav a:hover, .nav a.active {
            background: #667eea;
            color: white;
        }

        .container {
            padding: 15px;
            max-width: 100%;
            margin: 0 auto;
        }

        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
            transition: transform 0.2s;
            display: inline-block;
            text-decoration: none;
            text-align: center;
        }

        .btn:active {
            transform: scale(0.95);
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        @media (min-width: 768px) {
            .container {
                max-width: 1200px;
                padding: 20px;
            }

            .header h1 {
                font-size: 32px;
            }

            .nav a {
                font-size: 16px;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    <div class="header">
        <h1>Produits2Fou</h1>
    </div>

    <nav class="nav">
        <a href="{{ route('accueil') }}" class="{{ request()->routeIs('accueil') ? 'active' : '' }}">Accueil</a>
        <a href="{{ route('produits') }}" class="{{ request()->routeIs('produits') ? 'active' : '' }}">Produits</a>
        <a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    @yield('scripts')
</body>
</html>
