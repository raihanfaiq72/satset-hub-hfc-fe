<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatSet - Dashboard Mockup</title>
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
                        'slide-in': 'slideIn 0.5s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.95)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        },
                        slideIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(-20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
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

        /* Carousel styling */
        .carousel-container {
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
        }

        .carousel-item {
            scroll-snap-align: start;
            flex-shrink: 0;
        }

        /* Loading spinner */
        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Card hover effects */
        .service-card {
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Icon button hover */
        .icon-btn {
            transition: all 0.2s ease;
        }

        .icon-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(45, 122, 110, 0.2);
        }

        /* Bottom navigation */
        .bottom-nav {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }

        /* Activity item animation */
        .activity-item {
            animation: slideIn 0.5s ease-out backwards;
        }

        .activity-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .activity-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .activity-item:nth-child(3) {
            animation-delay: 0.3s;
        }

    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Main Container -->
    <div class="flex min-h-screen flex-col">
        <!-- Main Content -->
        <main class="flex-1 pb-24">
            <!-- Greeting Section -->
            <div class="px-5 pt-6 pb-4 animate-fade-in">
                <h2 class="text-2xl font-bold text-gray-800">Halo, User</h2>
                <p class="text-sm text-gray-500">Selamat datang kembali di SatSet</p>
            </div>

            <!-- Carousel Section -->
            <div class="px-5 pb-6">
                <div class="carousel-container flex gap-4 overflow-x-auto snap-x">
                    <!-- Promo 1 -->
                    <div class="carousel-item w-full">
                        <div class="relative rounded-xl overflow-hidden shadow-lg service-card">
                            <div class="w-full h-44 bg-white flex items-center justify-center p-6">
                                <img src="https://api.satset.co.id/asset/logo.png" alt="Logo SatSet"
                                    class="h-full object-contain">
                            </div>
                            <div class="absolute inset-0 bg-black/40 flex flex-col justify-end p-4">
                                <h3 class="text-xl md:text-2xl font-bold text-white">SatSet Diskon 10%</h3>
                                <p class="text-sm text-gray-200">Nikmati promo spesial untuk pengguna baru</p>
                                <button
                                    class="mt-2 rounded-full bg-satset-green px-4 py-2 text-white font-semibold hover:bg-satset-dark transition">
                                    Dapatkan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Promo 2 -->
                    <div class="carousel-item w-full">
                        <div class="relative rounded-xl overflow-hidden shadow-lg service-card">
                            <div class="w-full h-44 bg-white flex items-center justify-center p-6">
                                <img src="https://api.satset.co.id/asset/logo.png" alt="Logo SatSet"
                                    class="h-full object-contain">
                            </div>
                            <div class="absolute inset-0 bg-black/40 flex flex-col justify-end p-4">
                                <h3 class="text-xl md:text-2xl font-bold text-white">SatSet Diskon 10%</h3>
                                <p class="text-sm text-gray-200">Nikmati promo spesial untuk pengguna baru</p>
                                <button
                                    class="mt-2 rounded-full bg-satset-green px-4 py-2 text-white font-semibold hover:bg-satset-dark transition">
                                    Dapatkan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Services Grid -->
            <div class="px-5 pb-6">
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Layanan SatSet</h3>
                    </div>
                    <div class="grid grid-cols-4 gap-y-6">
                        <!-- Top Up -->
                        <div class="flex flex-col items-center gap-2">
                            <div
                                class="icon-btn flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm text-satset-green border border-gray-100 cursor-pointer">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">Top Up</span>
                        </div>

                        <!-- Transfer -->
                        <div class="flex flex-col items-center gap-2">
                            <div
                                class="icon-btn flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm text-satset-green border border-gray-100 cursor-pointer">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                    <polyline points="16 6 12 2 8 6"></polyline>
                                    <line x1="12" y1="2" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">Transfer</span>
                        </div>

                        <!-- History -->
                        <div class="flex flex-col items-center gap-2">
                            <div
                                class="icon-btn flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm text-satset-green border border-gray-100 cursor-pointer">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">Riwayat</span>
                        </div>

                        <!-- More -->
                        <div class="flex flex-col items-center gap-2">
                            <div
                                class="icon-btn flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-sm text-satset-green border border-gray-100 cursor-pointer">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                            </div>
                            <span class="text-xs font-semibold text-gray-600">Lainnya</span>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Main Services Grid -->
            <div class="px-5 pb-6">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Service 1 -->
                    <div class="service-card bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                        <div class="w-full h-36 bg-gray-50 flex items-center justify-center p-8">
                            <img src="https://api.satset.co.id/asset/logo.png" alt="Service Icon"
                                class="h-full object-contain opacity-80">
                        </div>
                        <div class="p-4 flex flex-col gap-2 flex-1 justify-between">
                            <div>
                                <h4 class="font-bold text-gray-800">Bayar Listrik</h4>
                                <p class="text-xs text-gray-500 mt-1">Bayar token listrik prabayar atau pascabayar
                                    dengan mudah</p>
                            </div>
                            <button
                                class="mt-2 w-full rounded-full bg-satset-green px-3 py-2 text-white font-semibold hover:bg-satset-dark transition">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="px-5 space-y-6">
                <section class="pt-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-gray-800 text-lg">Aktivitas Terakhir</h3>
                        <button class="text-xs font-bold text-satset-green hover:underline">Lihat Semua</button>
                    </div>
                    <div class="space-y-3">
                        <!-- Activity 1 -->
                        <div
                            class="activity-item bg-white rounded-xl shadow-sm border-none p-4 flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-blue-50 flex items-center justify-center text-satset-green">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Pembayaran Token Listrik</p>
                                <p class="text-xs text-gray-500">04 April 2026 • 18:30</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-red-500">- Rp20.000</p>
                            </div>
                        </div>

                        <!-- Activity 2 -->
                        <div
                            class="activity-item bg-white rounded-xl shadow-sm border-none p-4 flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-green-50 flex items-center justify-center text-satset-green">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path>
                                    <polyline points="16 6 12 2 8 6"></polyline>
                                    <line x1="12" y1="2" x2="12" y2="15"></line>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Top Up Saldo E-Wallet</p>
                                <p class="text-xs text-gray-500">04 April 2026 • 15:20</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-green-500">+ Rp100.000</p>
                            </div>
                        </div>

                        <!-- Activity 3 -->
                        <div
                            class="activity-item bg-white rounded-xl shadow-sm border-none p-4 flex items-center gap-4">
                            <div
                                class="h-12 w-12 rounded-full bg-purple-50 flex items-center justify-center text-satset-green">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-bold text-gray-800">Isi Pulsa Telkomsel</p>
                                <p class="text-xs text-gray-500">03 April 2026 • 10:15</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-red-500">- Rp50.000</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>

        <!-- Bottom Navigation -->
        <nav class="bottom-nav fixed bottom-0 left-0 right-0 border-t border-gray-200 bg-white/95">
            <div class="flex justify-around items-center py-2">
                <!-- Home -->
                <button class="flex flex-col items-center gap-1 p-2 text-satset-green">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span class="text-xs font-medium">Beranda</span>
                </button>

                <!-- Services -->
                <button
                    class="flex flex-col items-center gap-1 p-2 text-gray-400 hover:text-satset-green transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span class="text-xs font-medium">Layanan</span>
                </button>

                <!-- History -->
                <button
                    class="flex flex-col items-center gap-1 p-2 text-gray-400 hover:text-satset-green transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span class="text-xs font-medium">Riwayat</span>
                </button>

                <!-- Profile -->
                <button
                    class="flex flex-col items-center gap-1 p-2 text-gray-400 hover:text-satset-green transition-colors">
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
        // Auto-scroll carousel
        let currentSlide = 0;
        const carousel = document.querySelector('.carousel-container');
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;

        function autoScroll() {
            if (totalSlides > 0) {
                currentSlide = (currentSlide + 1) % totalSlides;
                carousel.scrollLeft = slides[currentSlide].offsetLeft;
            }
        }

        // Auto-scroll every 4 seconds
        setInterval(autoScroll, 4000);

        // Add click handlers to service cards
        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function () {
                console.log('Service card clicked');
            });
        });

        // Add click handlers to icon buttons
        document.querySelectorAll('.icon-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                console.log('Icon button clicked');
            });
        });

        // Add click handlers to bottom nav
        document.querySelectorAll('.bottom-nav button').forEach(btn => {
            btn.addEventListener('click', function () {
                // Remove active state from all buttons
                document.querySelectorAll('.bottom-nav button').forEach(b => {
                    b.classList.remove('text-satset-green');
                    b.classList.add('text-gray-400');
                });

                // Add active state to clicked button
                this.classList.remove('text-gray-400');
                this.classList.add('text-satset-green');
            });
        });

    </script>
</body>

</html>
