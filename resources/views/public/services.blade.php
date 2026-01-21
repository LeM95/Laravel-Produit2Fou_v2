<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Services - Produits2Fou</title>
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
            overflow: hidden;
            background: #000;
        }

        /* Video Background (static) */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: 0;
            overflow: hidden;
        }

        .video-background video {
            width: 100vw;
            height: 100vh;
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

        /* Container for scrollable service videos */
        .video-container {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            -webkit-overflow-scrolling: touch;
            padding-bottom: 0;
        }

        .video-slide {
            height: 100vh;
            scroll-snap-align: start;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #000;
        }

        .video-player {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
        }

        .service-video-overlay {
            position: absolute;
            bottom: var(--safe-bottom);
            left: 0;
            right: 0;
            padding: 25px 20px;
            color: white;
            z-index: 10;
            text-shadow: rgb(0, 0, 0) 2px 0 10px;
        }

        .service-name {
            font-size: 1.2em;
            font-weight: 700;
            margin-bottom: 8px;
            color: #FFD700;
        }

        .video-title {
            font-size: 1.1em;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .video-description {
            font-size: 0.95em;
            opacity: 0.9;
            line-height: 1.5;
        }

        .play-pause-btn {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: rgba(255, 215, 0, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            color: white;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 5;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 215, 0, 0.5);
        }

        .video-slide:active .play-pause-btn {
            opacity: 1;
        }

        .scroll-indicator {
            position: absolute;
            bottom: var(--safe-bottom);
            left: 50%;
            transform: translateX(-50%);
            color: white;
            font-size: 0.9em;
            opacity: 0.8;
            text-align: center;
            animation: bounce 2s infinite;
            z-index: 15;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        @keyframes bounce {
            0%, 100% { transform: translateX(-50%) translateY(0); }
            50% { transform: translateX(-50%) translateY(-10px); }
        }

        .no-videos {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            padding: 40px 20px;
            padding-bottom: var(--safe-bottom);
            position: relative;
            z-index: 1;
        }

        .no-videos-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 50px 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .no-videos-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .no-videos h3 {
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
    <!-- Static Video Background -->
    

    @php
        $allVideos = [];
        foreach($services as $service) {
            foreach($service->videos as $video) {
                $allVideos[] = [
                    'service' => $service,
                    'video' => $video
                ];
            }
        }
    @endphp

    @if(count($allVideos) > 0)
        <div class="video-container" id="videoContainer">
            @foreach($allVideos as $index => $item)
                <div class="video-slide" data-index="{{ $index }}">
                    <video
                        id="video-{{ $index }}"
                        class="video-player"
                        src="{{ asset('storage/' . $item['video']->chemin_video) }}"
                        loop
                        playsinline
                        {{ $index === 0 ? 'autoplay' : '' }}
                        muted="{{ $index === 0 ? 'true' : 'false' }}"
                        poster="{{ $item['video']->thumbnail ? asset('storage/' . $item['video']->thumbnail) : '' }}"
                    ></video>

                    <div class="play-pause-btn" onclick="togglePlay({{ $index }})">
                        <span id="playIcon-{{ $index }}">▶</span>
                    </div>

                    <div class="service-video-overlay">
                        <div class="service-name">{{ $item['video']->titre }}</div>
                    </div>

                    @if($index === 0)
                        <div class="scroll-indicator">
                            Swipe pour voir plus ↓
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <!-- Video Background when no services -->
        <div class="video-background">
            <video autoplay muted loop playsinline>
                <source src="{{ asset('img/back.mp4') }}" type="video/mp4">
            </video>
            <div class="video-overlay"></div>
        </div>
        <div class="no-videos">
            <div class="no-videos-content">
                <div class="no-videos-icon">🎬</div>
                <h3>Aucune vidéo disponible</h3>
                <p>Nos services seront bientôt présentés ici!</p>
            </div>
        </div>
    @endif

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <a href="{{ route('accueil') }}" class="nav-item">
            <i class="fa-solid fa-house fa-xl" style="color: #ffffff;"></i>
            <span>Accueil</span>
        </a>
        <a href="{{ route('produits') }}" class="nav-item">
            <i class="fa-solid fa-tag fa-xl" style="color: #ffffff;"></i>
            <span>Produits</span>
        </a>
        <a href="{{ route('services') }}" class="nav-item active">
            <i class="fa-solid fa-paint-roller fa-xl" style="color: #ffffff;"></i>
            <span>Services</span>
        </a>
        <a href="{{ route('contact') }}" class="nav-item">
            <i class="fa-solid fa-envelope fa-xl" style="color: #ffffff;"></i>
            <span>Contact</span>
        </a>
    </nav>

    <script>
        let currentVideoIndex = 0;
        const totalVideos = {{ count($allVideos) }};

        function togglePlay(index) {
            const video = document.getElementById('video-' + index);
            const icon = document.getElementById('playIcon-' + index);

            if (video.paused) {
                video.play();
                video.muted = false;
                icon.textContent = '⏸';
            } else {
                video.pause();
                icon.textContent = '▶';
            }
        }

        function handleVideoInView() {
            const container = document.getElementById('videoContainer');
            const slides = document.querySelectorAll('.video-slide');

            slides.forEach((slide, index) => {
                const rect = slide.getBoundingClientRect();
                const isInView = rect.top >= 0 && rect.top < window.innerHeight / 2;

                const video = document.getElementById('video-' + index);

                if (isInView && currentVideoIndex !== index) {
                    currentVideoIndex = index;

                    // Pause all other videos
                    for (let i = 0; i < totalVideos; i++) {
                        if (i !== index) {
                            const otherVideo = document.getElementById('video-' + i);
                            otherVideo.pause();
                            otherVideo.currentTime = 0;
                        }
                    }

                    // Play current video
                    video.play();
                    video.muted = false;
                }
            });
        }

        if (totalVideos > 0) {
            const container = document.getElementById('videoContainer');
            container.addEventListener('scroll', handleVideoInView);

            // Auto-play first video
            setTimeout(() => {
                const firstVideo = document.getElementById('video-0');
                if (firstVideo) {
                    firstVideo.play().then(() => {
                        firstVideo.muted = false;
                    }).catch(e => {
                        console.log('Autoplay prevented:', e);
                    });
                }
            }, 500);
        }
    </script>
</body>
</html>
