<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatSet - Semua Layanan Mockup</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'satset-green': '#2d7a6e',
                        'satset-dark': '#246359'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.7s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Firefox compatibility fixes */
        @-moz-document url-prefix() {
            input[type="text"],
            input[type="email"] {
                -moz-appearance: none !important;
                appearance: none !important;
                color: #000000 !important;
                background-color: #ffffff !important;
            }
        }

        /* General input fixes */
        input {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            color: #000000 !important;
            background-color: #ffffff !important;
        }

        /* Service card hover effects */
        .service-card {
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Category section animation */
        .category-section {
            animation: slideUp 0.5s ease-out backwards;
        }

        .category-section:nth-child(1) { animation-delay: 0.1s; }
        .category-section:nth-child(2) { animation-delay: 0.2s; }

        /* Service item animation */
        .service-item {
            animation: fadeIn 0.7s ease-out backwards;
        }

        .service-item:nth-child(1) { animation-delay: 0.3s; }
        .service-item:nth-child(2) { animation-delay: 0.4s; }
        .service-item:nth-child(3) { animation-delay: 0.5s; }
        .service-item:nth-child(4) { animation-delay: 0.6s; }

        /* Bottom navigation */
        .bottom-nav {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        /* Header shadow */
        .header-shadow {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
        }

        /* Text clamp for description */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen flex-col">
        <!-- Header -->
        <header class="sticky top-0 z-20 bg-white px-5 py-4 header-shadow flex items-center gap-4">
            <a href="dashboard-mockup.html" class="text-gray-800 hover:text-satset-green transition-colors">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-xl font-bold text-gray-800">Semua Layanan</h1>
        </header>

        <!-- Main Content -->
        <main class="flex-1 pb-24 pt-4">
            <!-- Kebutuhan Harian Section -->
            <div class="category-section px-5 pb-8">
                <h3 class="font-bold text-gray-800 text-lg mb-4 italic">
                    Kebutuhan Harian
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Token Listrik -->
                    <div class="service-item">
                        <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden border-none">
                            <div class="w-full h-28 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-2 p-3 flex-1 justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-800 leading-tight">
                                        Token Listrik
                                    </h4>
                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-2">
                                        Beli token atau bayar tagihan PLN
                                    </p>
                                </div>
                                <a href="#" class="mt-2 w-full block text-center rounded-full bg-satset-green px-2 py-2 text-xs text-white font-semibold hover:bg-satset-dark transition">
                                    Beli
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Pulsa & Data -->
                    <div class="service-item">
                        <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden border-none">
                            <div class="w-full h-28 bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-2 p-3 flex-1 justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-800 leading-tight">
                                        Pulsa & Data
                                    </h4>
                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-2">
                                        Isi pulsa ke semua operator
                                    </p>
                                </div>
                                <a href="#" class="mt-2 w-full block text-center rounded-full bg-satset-green px-2 py-2 text-xs text-white font-semibold hover:bg-satset-dark transition">
                                    Isi
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Air PDAM -->
                    <div class="service-item">
                        <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden border-none">
                            <div class="w-full h-28 bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-2 p-3 flex-1 justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-800 leading-tight">
                                        Air PDAM
                                    </h4>
                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-2">
                                        Bayar tagihan air bulanan
                                    </p>
                                </div>
                                <a href="#" class="mt-2 w-full block text-center rounded-full bg-satset-green px-2 py-2 text-xs text-white font-semibold hover:bg-satset-dark transition">
                                    Bayar
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Internet & TV -->
                    <div class="service-item">
                        <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden border-none">
                            <div class="w-full h-28 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M2 12h20"></path>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-2 p-3 flex-1 justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-800 leading-tight">
                                        Internet & TV
                                    </h4>
                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-2">
                                        Langganan wifi dan tv kabel
                                    </p>
                                </div>
                                <a href="#" class="mt-2 w-full block text-center rounded-full bg-satset-green px-2 py-2 text-xs text-white font-semibold hover:bg-satset-dark transition">
                                    Cek
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hiburan & Game Section -->
            <div class="category-section px-5 pb-8">
                <h3 class="font-bold text-gray-800 text-lg mb-4 italic">
                    Hiburan & Game
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Voucher Game -->
                    <div class="service-item">
                        <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden border-none">
                            <div class="w-full h-28 bg-gradient-to-br from-red-400 to-rose-500 flex items-center justify-center">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                                    <path d="M6 12h4l2-2 2 2h4"></path>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-2 p-3 flex-1 justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-800 leading-tight">
                                        Voucher Game
                                    </h4>
                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-2">
                                        Top up game favoritmu di sini
                                    </p>
                                </div>
                                <a href="#" class="mt-2 w-full block text-center rounded-full bg-satset-green px-2 py-2 text-xs text-white font-semibold hover:bg-satset-dark transition">
                                    Top Up
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Streaming -->
                    <div class="service-item">
                        <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden border-none">
                            <div class="w-full h-28 bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polygon points="23 7 16 12 23 17 23 7"></polygon>
                                    <rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect>
                                </svg>
                            </div>
                            <div class="flex flex-col gap-2 p-3 flex-1 justify-between">
                                <div>
                                    <h4 class="font-bold text-sm text-gray-800 leading-tight">
                                        Streaming
                                    </h4>
                                    <p class="text-[10px] text-gray-500 mt-1 line-clamp-2">
                                        Langganan Netflix atau Disney+
                                    </p>
                                </div>
                                <a href="#" class="mt-2 w-full block text-center rounded-full bg-satset-green px-2 py-2 text-xs text-white font-semibold hover:bg-satset-dark transition">
                                    Beli
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Bottom Navigation -->
        <nav class="bottom-nav fixed bottom-0 left-0 right-0 border-t border-gray-200 bg-white/95">
            <div class="flex justify-around items-center py-2">
                <!-- Home -->
                <a href="dashboard-mockup.html" class="flex flex-col items-center gap-1 p-2 text-gray-400 hover:text-satset-green transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="text-xs font-medium">Beranda</span>
                </a>

                <!-- Services -->
                <button class="flex flex-col items-center gap-1 p-2 text-satset-green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span class="text-xs font-medium">Layanan</span>
                </button>

                <!-- History -->
                <button class="flex flex-col items-center gap-1 p-2 text-gray-400 hover:text-satset-green transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span class="text-xs font-medium">Riwayat</span>
                </button>

                <!-- Profile -->
                <button class="flex flex-col items-center gap-1 p-2 text-gray-400 hover:text-satset-green transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span class="text-xs font-medium">Profil</span>
                </button>
            </div>
        </nav>
    </div>

    <!-- Minimal JavaScript for interactions -->
    <script>
        // Add click handlers to service cards
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on the CTA button
                if (!e.target.closest('a')) {
                    console.log('Service card clicked');
                }
            });
        });

        // Add click handlers to CTA buttons
        document.querySelectorAll('.service-card a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Service CTA clicked:', this.textContent);
            });
        });

        // Add click handlers to bottom nav
        document.querySelectorAll('.bottom-nav button, .bottom-nav a').forEach(item => {
            item.addEventListener('click', function(e) {
                if (this.tagName === 'BUTTON') {
                    e.preventDefault();
                    
                    // Remove active state from all buttons
                    document.querySelectorAll('.bottom-nav button').forEach(btn => {
                        btn.classList.remove('text-satset-green');
                        btn.classList.add('text-gray-400');
                    });
                    
                    // Add active state to clicked button
                    this.classList.remove('text-gray-400');
                    this.classList.add('text-satset-green');
                }
            });
        });

        // Smooth scroll behavior for better UX
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>
</body>
</html>
