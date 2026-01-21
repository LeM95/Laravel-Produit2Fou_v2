<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Service - Admin</title>
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
        }

        .header h1 {
            font-size: 24px;
        }

        .form-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .form-input,
        .form-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
        }

        .form-input:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .video-list {
            margin-top: 30px;
        }

        .video-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .video-info h4 {
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }

        .video-info p {
            font-size: 14px;
            color: #666;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
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

        .no-videos {
            text-align: center;
            padding: 40px;
            color: #999;
        }
    </style>
</head>
<body>
    <a href="{{ url('/30032006') }}" class="back-btn" style="margin: 20px;">← Retour à l'admin</a>

    <div class="header">
        <h1>Modifier le service: {{ $service->nom }}</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="form-container">
        <h2 class="section-title">Informations du service</h2>
        <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Nom du service *</label>
                <input type="text" name="nom" class="form-input" value="{{ old('nom', $service->nom) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Description *</label>
                <textarea name="description" class="form-textarea" required>{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Image de couverture</label>
                <input type="file" name="image" class="form-input" accept="image/*">
                @if($service->image)
                    <p style="margin-top: 10px; color: #666;">Image actuelle: {{ basename($service->image) }}</p>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('services.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </form>
    </div>

    <div class="form-container">
        <h2 class="section-title">Ajouter une vidéo</h2>
        <form action="{{ route('services.videos.store', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Titre de la vidéo *</label>
                <input type="text" name="titre" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-textarea"></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Fichier vidéo * (MP4, MOV, AVI - Max 50MB)</label>
                <input type="file" name="video" class="form-input" accept="video/*" required>
            </div>

            <div class="form-group">
                <label class="form-label">Miniature (thumbnail)</label>
                <input type="file" name="thumbnail" class="form-input" accept="image/*">
            </div>

            <div class="form-group">
                <label class="form-label">Ordre d'affichage</label>
                <input type="number" name="ordre" class="form-input" value="0" min="0">
            </div>

            <button type="submit" class="btn btn-primary">Ajouter la vidéo</button>
        </form>

        <div class="video-list">
            <h3 style="font-size: 18px; margin-bottom: 15px;">Vidéos du service ({{ $service->videos->count() }})</h3>

            @if($service->videos->count() > 0)
                @foreach($service->videos as $video)
                    <div class="video-card">
                        <div class="video-info">
                            <h4>{{ $video->titre }}</h4>
                            <p>{{ $video->description ?? 'Pas de description' }} - Ordre: {{ $video->ordre }}</p>
                        </div>
                        <form action="{{ route('services.videos.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Supprimer cette vidéo?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Supprimer</button>
                        </form>
                    </div>
                @endforeach
            @else
                <div class="no-videos">
                    <p>Aucune vidéo pour ce service</p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
