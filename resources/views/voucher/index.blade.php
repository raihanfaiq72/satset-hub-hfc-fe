@extends('components.head')

@section('content')

    <body class="bg-gray-50 min-h-screen">
        <!-- Main Voucher Page -->
        <div id="voucherPage" class="flex min-h-screen flex-col">
            <!-- Header -->
            <header class="bg-white px-5 py-8 flex items-center justify-between">
                <h1 class="text-3xl font-black text-gray-800 italic uppercase tracking-tighter">Voucher</h1>
                <div class="h-10 w-10 bg-satset-green/10 rounded-full flex items-center justify-center text-satset-green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9Z"></path>
                        <path d="M9 9l3 3-3 3"></path>
                        <path d="M15 9l-3 3 3 3"></path>
                    </svg>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 px-5 pb-24">
                <!-- Tabs -->
                <div class="w-full">
                    <!-- Tab List -->
                    <div class="grid w-full grid-cols-2 bg-gray-100 rounded-[24px] h-14 p-1.5 mb-8 shadow-inner">
                        <button onclick="switchTab('mine')" id="tab-mine"
                            class="tab-btn rounded-[20px] font-black text-[10px] uppercase tracking-widest active">
                            VOUCHER SAYA
                        </button>
                        <button onclick="switchTab('buy')" id="tab-buy"
                            class="tab-btn rounded-[20px] font-black text-[10px] uppercase tracking-widest">
                            BELI VOUCHER
                        </button>
                    </div>

                    <!-- Tab Content -->
                    <div id="tabContent" class="tab-content">
                        <!-- My Vouchers Tab -->
                        <div id="content-mine" class="space-y-4">
                            <!-- Payment Voucher -->
                            @foreach ($userPaymentVouchers as $userPaymentVoucher)
                                @include('voucher.partials.user-payment-voucher-card', [
                                    'userPaymentVoucher' => $userPaymentVoucher,
                                ])
                            @endforeach

                            <!-- Promo Voucher -->
                            <div class="voucher-card border-none shadow-md rounded-[28px] overflow-hidden bg-white">
                                <div class="p-0 flex h-28">
                                    <div
                                        class="w-28 flex flex-col items-center justify-center border-r-2 border-dashed border-gray-100">
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="text-orange-500">
                                            <path
                                                d="M2 9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9Z">
                                            </path>
                                            <path d="M9 9l3 3-3 3"></path>
                                            <path d="M15 9l-3 3 3 3"></path>
                                        </svg>
                                        <span class="text-[8px] font-black uppercase tracking-widest mt-2">promo</span>
                                    </div>
                                    <div class="flex-1 p-4 flex flex-col justify-center">
                                        <h4 class="font-black text-lg leading-none">Diskon 50rb</h4>
                                        <p class="text-[10px] mt-1 font-bold text-gray-400">Minimal transaksi 200rb</p>
                                        <div class="mt-2 inline-block">
                                            <span
                                                class="text-[10px] font-black px-2 py-0.5 rounded-full bg-orange-100 text-orange-600">
                                                EXP: 2 Hari lagi
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buy Vouchers Tab -->
                        <div id="content-buy" class="space-y-8 hidden">
                            <!-- Payment Vouchers Section -->
                            <section class="space-y-4">
                                <h3 class="text-sm font-black text-gray-800 uppercase italic px-1">Layanan (Voucher Payment)
                                </h3>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach ($voucherBatches as $batch)
                                        @include('voucher.partials.voucher-card', [
                                            'voucher' => $batch,
                                        ])
                                    @endforeach
                                </div>
                            </section>

                            <!-- Promo Vouchers Section -->
                            <section class="space-y-4">
                                <h3 class="text-sm font-black text-gray-800 uppercase italic px-1">Potongan Harga (Promo)
                                </h3>

                                <!-- Potongan 20rb -->
                                <div class="voucher-card bg-white rounded-[24px] p-4 flex items-center justify-between shadow-sm border border-gray-100"
                                    onclick="openPayment({id: 201, title: 'Potongan 20rb', price: 5000})">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-12 w-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M2 9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9Z">
                                                </path>
                                                <path d="M9 9l3 3-3 3"></path>
                                                <path d="M15 9l-3 3 3 3"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-800 text-sm">Potongan 20rb</h4>
                                            <p class="text-[10px] text-gray-400 font-bold">Berlaku semua layanan</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-black text-satset-green">Rp5.000</p>
                                        <span class="text-[8px] font-bold text-gray-300 uppercase">Per Voucher</span>
                                    </div>
                                </div>

                                <!-- Cashback 10% -->
                                <div class="voucher-card bg-white rounded-[24px] p-4 flex items-center justify-between shadow-sm border border-gray-100"
                                    onclick="openPayment({id: 202, title: 'Cashback 10%', price: 2000})">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="h-12 w-12 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M2 9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9Z">
                                                </path>
                                                <path d="M9 9l3 3-3 3"></path>
                                                <path d="M15 9l-3 3 3 3"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-black text-gray-800 text-sm">Cashback 10%</h4>
                                            <p class="text-[10px] text-gray-400 font-bold">Max 50rb saldo SatSet</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-black text-satset-green">Rp2.000</p>
                                        <span class="text-[8px] font-bold text-gray-300 uppercase">Per Voucher</span>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Bottom Navigation -->
            @include('components.bottomNav')
        </div>

        @include('voucher.partials.payment-steps')
        @include('voucher.partials.voucher-detail')

        <!-- Payment Modal -->
        <div id="paymentModal" class="fixed inset-0 z-50 flex flex-col bg-white hidden">
            <!-- Payment Header -->
            <header class="py-6 flex items-center gap-4 px-5">
                <button onclick="backFromPayment()">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </button>
                <h1 class="text-xl font-black text-gray-800 uppercase italic">Pembayaran</h1>
            </header>

            <!-- Payment Content -->
            <main class="flex-1 px-5">
                <div id="paymentContent" class="payment-step">
                    <!-- Payment content will be dynamically inserted here -->
                </div>
            </main>
        </div>

        @include('voucher.scriptBottom')
        <script>
            window.allVouchers = @json($vouchers);
            window.userPaymentVouchers = @json($userPaymentVouchers);
            window.buyVoucherRoute = "{{ route('voucher.buy') }}";
            window.csrfToken = "{{ csrf_token() }}";
        </script>
    </body>
@endsection
@push('script_head')
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
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-out': 'slideOut 0.3s ease-out',
                        'zoom-in': 'zoomIn 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        slideIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                        slideOut: {
                            '0%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                opacity: '0',
                                transform: 'translateX(-20px)'
                            }
                        },
                        zoomIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.95)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        },
                        bounceIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.3)'
                            },
                            '50%': {
                                opacity: '1',
                                transform: 'scale(1.05)'
                            },
                            '70%': {
                                transform: 'scale(0.9)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        }
                    }
                }
            }
        }
    </script>
@endpush

@push('style')
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

        /* Tab transitions */
        .tab-content {
            transition: all 0.3s ease;
        }

        .tab-enter {
            opacity: 0;
            transform: translateY(10px);
        }

        .tab-enter-active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Payment step transitions */
        .payment-step {
            transition: all 0.3s ease;
        }

        .payment-step-enter {
            opacity: 0;
            transform: translateX(20px);
        }

        .payment-step-enter-active {
            opacity: 1;
            transform: translateX(0);
        }

        .payment-step-exit {
            opacity: 1;
            transform: translateX(0);
        }

        .payment-step-exit-active {
            opacity: 0;
            transform: translateX(-20px);
        }

        /* Card hover effects */
        .voucher-card {
            transition: all 0.3s ease;
        }

        .voucher-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        /* Button animations */
        .btn-scale:active {
            transform: scale(0.95);
        }

        /* Success animation */
        .success-check {
            animation: bounceIn 0.6s ease-out;
        }

        /* Tab button styles */
        .tab-btn {
            transition: all 0.2s ease;
        }

        .tab-btn.active {
            background-color: white;
            color: #2d7a6e;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Quantity button */
        .quantity-btn {
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            transform: scale(1.05);
        }

        /* QR Code container */
        .qr-container {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Bottom navigation */
        .bottom-nav {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
        }
    </style>
@endpush
