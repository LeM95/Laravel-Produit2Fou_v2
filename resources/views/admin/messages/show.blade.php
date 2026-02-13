<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message de {{ $message->nom }} - Admin Produits2Fou</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar-header h1 {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .sidebar-header p {
            font-size: 13px;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.2s;
            border-left: 3px solid transparent;
            text-decoration: none;
            color: white;
        }

        .menu-item:hover {
            background: rgba(255,255,255,0.1);
        }

        .menu-item.active {
            background: rgba(255,255,255,0.2);
            border-left-color: white;
        }

        .menu-icon {
            font-size: 20px;
            width: 25px;
        }

        .menu-text {
            font-weight: 500;
            font-size: 15px;
        }

        .badge-notif {
            background: #dc3545;
            color: white;
            font-size: 12px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 50px;
            margin-left: auto;
            min-width: 22px;
            text-align: center;
        }

        /* MOBILE TOGGLE */
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            z-index: 1001;
            background: #667eea;
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 10px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 25px;
            padding: 10px 15px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }

        .back-link:hover {
            transform: translateX(-5px);
        }

        /* MESSAGE DETAIL */
        .message-detail {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .sender-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .sender-avatar {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 28px;
        }

        .sender-details h2 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .sender-details p {
            font-size: 15px;
            color: #666;
            margin-bottom: 5px;
        }

        .message-date {
            text-align: right;
        }

        .message-date .date {
            font-size: 14px;
            color: #999;
            margin-bottom: 5px;
        }

        .message-date .time {
            font-size: 13px;
            color: #bbb;
        }

        /* CONTACT ACTIONS */
        .contact-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 25px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            transition: transform 0.2s;
        }

        .action-btn:hover {
            transform: scale(1.05);
        }

        .btn-call {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .btn-email {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
            border: none;
            cursor: pointer;
        }

        /* MESSAGE CONTENT */
        .message-content {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .message-content h3 {
            font-size: 16px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .message-content p {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
            white-space: pre-wrap;
        }

        /* INFO GRID */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .info-card {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
        }

        .info-card h4 {
            font-size: 12px;
            font-weight: 700;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .info-card p {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .info-card a {
            color: #667eea;
            text-decoration: none;
        }

        .logout-btn {
            margin: 20px;
            padding: 12px 20px;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            width: calc(100% - 40px);
            text-align: center;
            text-decoration: none;
            display: block;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                padding: 80px 15px 20px;
            }

            .sidebar {
                width: 250px;
            }

            .message-header {
                flex-direction: column;
                gap: 20px;
            }

            .message-date {
                text-align: left;
            }

            .contact-actions {
                flex-direction: column;
            }

            .action-btn {
                justify-content: center;
            }

            .sender-info {
                flex-direction: column;
                text-align: center;
            }
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>
<body>
    <button class="mobile-toggle" onclick="toggleSidebar()">☰</button>
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <div class="admin-container">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1>🎨 Admin Panel</h1>
                <p>Produits2Fou</p>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('admin.produits') }}" class="menu-item">
                    <span class="menu-icon">📦</span>
                    <span class="menu-text">Produits</span>
                </a>
                <a href="{{ route('admin.produits') }}" class="menu-item">
                    <span class="menu-icon">🎬</span>
                    <span class="menu-text">Services</span>
                </a>
                <a href="{{ route('admin.messages.index') }}" class="menu-item active">
                    <span class="menu-icon">💬</span>
                    <span class="menu-text">Messagerie</span>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="badge-notif">{{ $unreadCount }}</span>
                    @endif
                </a>
                <a href="{{ route('accueil') }}" class="menu-item">
                    <span class="menu-icon">🌐</span>
                    <span class="menu-text">Voir le site</span>
                </a>
            </nav>

            <a href="{{ route('accueil') }}" class="logout-btn">
                🚪 Quitter l'admin
            </a>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">
            <a href="{{ route('admin.messages.index') }}" class="back-link">
                ← Retour a la messagerie
            </a>

            <div class="message-detail">
                <div class="message-header">
                    <div class="sender-info">
                        <div class="sender-avatar">
                            {{ strtoupper(substr($message->nom, 0, 1)) }}
                        </div>
                        <div class="sender-details">
                            <h2>{{ $message->nom }}</h2>
                            @if($message->telephone)
                                <p>📞 {{ $message->telephone }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="message-date">
                        <div class="date">{{ $message->created_at->format('d/m/Y') }}</div>
                        <div class="time">{{ $message->created_at->format('H:i') }}</div>
                    </div>
                </div>

                <div class="contact-actions">
                    @if($message->telephone)
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $message->telephone) }}" class="action-btn btn-call">
                            📞 Appeler {{ $message->nom }}
                        </a>
                    @endif
                    <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer ce message ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn btn-delete">
                            🗑️ Supprimer
                        </button>
                    </form>
                </div>

                <div class="message-content">
                    <h3>Message</h3>
                    <p>{{ $message->message }}</p>
                </div>

                <div class="info-grid">
                    @if($message->telephone)
                        <div class="info-card">
                            <h4>Telephone</h4>
                            <p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $message->telephone) }}">{{ $message->telephone }}</a></p>
                        </div>
                    @endif
                    <div class="info-card">
                        <h4>Date de reception</h4>
                        <p>{{ $message->created_at->format('d/m/Y a H:i') }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');

            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }
    </script>
</body>
</html>
