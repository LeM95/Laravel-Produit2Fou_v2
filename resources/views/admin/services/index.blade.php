<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Services - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 24px;
        }

        .btn {
            background: white;
            color: #667eea;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .service-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .service-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .service-name {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }

        .service-actions {
            display: flex;
            gap: 10px;
        }

        .btn-small {
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }

        .btn-edit {
            background: #667eea;
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }

        .video-count {
            color: #666;
            font-size: 14px;
            margin-top: 10px;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .no-services {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Gestion des Services</h1>
        <div>
            <a href="{{ route('services.create') }}" class="btn btn-primary">+ Nouveau Service</a>
            <a href="/30032006" class="btn">← Retour Produits</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($services->count() > 0)
        @foreach($services as $service)
            <div class="service-card">
                <div class="service-header">
                    <div class="service-name">{{ $service->nom }}</div>
                    <div class="service-actions">
                        <a href="{{ route('services.edit', $service->id) }}" class="btn-small btn-edit">Modifier</a>
                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ce service?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-small btn-delete">Supprimer</button>
                        </form>
                    </div>
                </div>
                <p style="color: #666; margin-top: 10px;">{{ $service->description }}</p>
                <div class="video-count">
                    🎬 {{ $service->videos->count() }} vidéo(s)
                </div>
            </div>
        @endforeach
    @else
        <div class="no-services">
            <h3>Aucun service</h3>
            <p>Créez votre premier service!</p>
        </div>
    @endif
</body>
</html>
