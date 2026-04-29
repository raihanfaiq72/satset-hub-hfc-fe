<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatSet App</title>
    <link rel="icon" href="{{ asset('company-logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'satset-green': '#2d7a6e',
                        'satset-dark': '#246359'
                    }
                }
            }
        }
    </script>
    @stack('script_head')
    @stack('style')
    <style>
        .pull-to-refresh-indicator {
            transition: transform 0.2s cubic-bezier(0.17, 0.67, 0.83, 0.67);
            will-change: transform;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .ptr-spinning {
            animation: spin 0.8s linear infinite;
        }
    </style>
</head>

<body class="bg-gray-50">
    {{-- Pull to Refresh Indicator --}}
    <div id="ptr-indicator" class="fixed top-0 left-0 right-0 z-[60] flex items-center justify-center h-16 -translate-y-16 pointer-events-none pull-to-refresh-indicator">
        <div class="bg-white rounded-full p-2.5 shadow-xl border border-gray-100 text-satset-green scale-0 transition-transform duration-200" id="ptr-icon-container">
            <svg id="ptr-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <path d="M23 4v6h-6"></path>
                <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
            </svg>
        </div>
    </div>

    @include('components.loading')
    @yield('content')

    <script>
        (function() {
            let startY = 0;
            let currentY = 0;
            let isPulling = false;
            const threshold = 100;
            const indicator = document.getElementById('ptr-indicator');
            const iconContainer = document.getElementById('ptr-icon-container');
            const icon = document.getElementById('ptr-icon');

            function handleStart(e) {
                if (window.scrollY <= 5) {
                    startY = e.touches ? e.touches[0].pageY : e.pageY;
                    isPulling = true;
                }
            }

            function handleMove(e) {
                if (!isPulling) return;
                
                currentY = e.touches ? e.touches[0].pageY : e.pageY;
                const distance = currentY - startY;

                if (distance > 0 && window.scrollY <= 5) {
                    // Prevent default scrolling when pulling down
                    const dampedDistance = Math.min(distance * 0.4, threshold + 20);
                    indicator.style.transform = `translateY(${dampedDistance}px)`;
                    
                    // Show icon and scale it based on distance
                    const progress = Math.min(dampedDistance / threshold, 1);
                    iconContainer.style.transform = `scale(${progress})`;
                    icon.style.transform = `rotate(${dampedDistance * 2}deg)`;
                    
                    if (dampedDistance >= threshold) {
                        iconContainer.classList.add('bg-satset-green', 'text-white');
                    } else {
                        iconContainer.classList.remove('bg-satset-green', 'text-white');
                    }
                } else {
                    isPulling = false;
                }
            }

            function handleEnd() {
                if (!isPulling) return;
                
                const distance = currentY - startY;
                const dampedDistance = distance * 0.4;

                if (dampedDistance >= threshold) {
                    // Trigger Refresh
                    indicator.style.transform = `translateY(${threshold / 2}px)`;
                    icon.classList.add('ptr-spinning');
                    
                    // Haptic feedback if available
                    if (window.navigator && window.navigator.vibrate) {
                        window.navigator.vibrate(10);
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 600);
                } else {
                    // Reset
                    indicator.style.transform = 'translateY(-64px)';
                    iconContainer.style.transform = 'scale(0)';
                }
                
                isPulling = false;
                startY = 0;
                currentY = 0;
            }

            window.addEventListener('touchstart', handleStart, { passive: true });
            window.addEventListener('touchmove', handleMove, { passive: true });
            window.addEventListener('touchend', handleEnd);
            
            // Mouse support for desktop testing
            window.addEventListener('mousedown', handleStart);
            window.addEventListener('mousemove', handleMove);
            window.addEventListener('mouseup', handleEnd);
        })();
    </script>
</body>
</html>
