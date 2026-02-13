<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messagerie - Admin Produits2Fou</title>
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

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .unread-badge {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        /* MESSAGES LIST */
        .messages-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .message-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: inherit;
            display: block;
            border-left: 4px solid transparent;
        }

        .message-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .message-card.unread {
            border-left-color: #667eea;
            background: linear-gradient(to right, rgba(102, 126, 234, 0.05), white);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .message-sender {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sender-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 18px;
        }

        .sender-info h4 {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 3px;
        }

        .sender-info p {
            font-size: 13px;
            color: #666;
        }

        .message-date {
            font-size: 12px;
            color: #999;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .unread-dot {
            width: 10px;
            height: 10px;
            background: #667eea;
            border-radius: 50%;
        }

        .message-preview {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .message-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #eee;
        }

        .message-phone {
            font-size: 13px;
            color: #667eea;
            font-weight: 600;
        }

        .no-messages {
            text-align: center;
            padding: 80px 20px;
            color: #999;
        }

        .no-messages h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #666;
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

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
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
                <a href="{{ route('admin.produits') }}" class="menu-item" onclick="localStorage.setItem('adminSection', 'services')">
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
            @if(session('success'))
                <div class="alert alert-success">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="page-header">
                <h1 class="page-title">💬 Messagerie</h1>
                @if($unreadCount > 0)
                    <span class="unread-badge">{{ $unreadCount }} non lu(s)</span>
                @endif
            </div>

            @if($messages->count() > 0)
                <div class="messages-list">
                    @foreach($messages as $message)
                        <a href="{{ route('admin.messages.show', $message->id) }}" class="message-card {{ !$message->lu ? 'unread' : '' }}">
                            <div class="message-header">
                                <div class="message-sender">
                                    <div class="sender-avatar">
                                        {{ strtoupper(substr($message->nom, 0, 1)) }}
                                    </div>
                                    <div class="sender-info">
                                        <h4>{{ $message->nom }}</h4>
                                        @if($message->telephone)
                                            <p>📞 {{ $message->telephone }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="message-date">
                                    @if(!$message->lu)
                                        <span class="unread-dot"></span>
                                    @endif
                                    {{ $message->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            <div class="message-preview">
                                {{ $message->message }}
                            </div>
                            @if($message->telephone)
                                <div class="message-footer">
                                    <span class="message-phone">📞 {{ $message->telephone }}</span>
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div class="no-messages">
                    <h3>📭 Aucun message</h3>
                    <p>Les messages des visiteurs apparaitront ici.</p>
                </div>
            @endif
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
