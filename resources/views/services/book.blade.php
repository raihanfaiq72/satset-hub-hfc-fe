@extends('components.head')

@section('content')

    <body class="bg-white min-h-screen">
        <div class="flex min-h-screen flex-col">
            <header class="px-5 py-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4 flex-1">
                    <button id="backBtn" onclick="handleBack()"
                        class="h-10 w-10 flex items-center justify-center rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </button>

                    <div class="flex-1">
                        <h1 id="stepTitle" class="text-xl font-black text-gray-800">Atur Jadwal</h1>
                        <div id="progressContainer" class="h-1.5 w-full bg-gray-100 rounded-full mt-2 overflow-hidden">
                            <div id="progressBar" class="progress-bar h-full bg-satset-green" style="width: 33.33%"></div>
                        </div>
                    </div>
                </div>

                <button id="cancelBtn" onclick="showCancelModal()"
                    class="h-10 w-10 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </header>

            <main class="flex-1 px-5">
                <div id="stepContent" class="step-content">
                </div>
            </main>

            <div id="footerAction" class="p-6 border-t bg-white/80 backdrop-blur-md">
                <button onclick="nextStep()"
                    class="w-full h-16 bg-satset-green hover:bg-satset-dark text-white font-black text-lg rounded-3xl shadow-xl shadow-satset-green/20 transition-all btn-scale flex items-center justify-center">
                    LANJUTKAN
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>

            <div id="cancelModal" class="fixed inset-0 z-50 flex items-center justify-center p-6 hidden">
                <div class="modal-backdrop absolute inset-0 bg-black/50" onclick="hideCancelModal()"></div>
                <div class="relative bg-white rounded-[32px] border-none p-8 shadow-2xl max-w-md w-full">
                    <h3 class="text-2xl font-black text-gray-800 text-center mb-4">
                        Batalkan Pesanan?
                    </h3>
                    <p class="text-center text-gray-500 font-medium mb-6">
                        Semua data yang sudah kamu isi akan terhapus. Apakah kamu yakin ingin membatalkan pesanan ini secara
                        satset?
                    </p>
                    <div class="flex flex-col gap-3">
                        <button onclick="confirmCancel()"
                            class="bg-red-500 hover:bg-red-600 text-white font-black h-14 rounded-2xl w-full transition-colors">
                            YA, BATALKAN
                        </button>
                        <button onclick="hideCancelModal()"
                            class="border-2 border-gray-100 hover:bg-gray-50 font-bold h-14 rounded-2xl w-full transition-colors">
                            TIDAK, LANJUTKAN
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Templates --}}
        @include('services.partials.step1_schedule')
        @include('services.partials.step2_address')
        @include('services.partials.step3_payment')
        @include('services.partials.step4_success')

        @include('services.scriptBottomBook')
    </body>
@endsection

@push('style')
    <style>
        @-moz-document url-prefix() {

            input[type="text"],
            input[type="email"] {
                -moz-appearance: none !important;
                appearance: none !important;
                color: #000000 !important;
                background-color: #ffffff !important;
            }
        }

        input {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            color: #000000 !important;
            background-color: #ffffff !important;
        }

        .step-content {
            transition: all 0.3s ease;
        }

        .step-enter {
            opacity: 0;
            transform: translateX(20px);
        }

        .step-enter-active {
            opacity: 1;
            transform: translateX(0);
        }

        .step-exit {
            opacity: 1;
            transform: translateX(0);
        }

        .step-exit-active {
            opacity: 0;
            transform: translateX(-20px);
        }

        .progress-bar {
            transition: width 0.5s ease;
        }

        .btn-scale:active {
            transform: scale(0.95);
        }

        .radio-custom {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .radio-custom:checked {
            border-color: #2d7a6e;
            background-color: #2d7a6e;
        }

        .radio-custom:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
        }

        .success-check {
            animation: bounceIn 0.6s ease-out;
        }

        .slot-btn {
            transition: all 0.2s ease;
        }

        .slot-btn:hover {
            transform: translateY(-1px);
        }

        .slot-btn.selected {
            border-color: #2d7a6e;
            background-color: #2d7a6e;
            color: white;
        }

        .address-card {
            transition: all 0.2s ease;
        }

        .address-card:hover {
            transform: translateY(-1px);
        }

        .address-card.selected {
            border-color: #2d7a6e;
            background-color: rgba(45, 122, 110, 0.05);
        }

        .qr-container {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
@endpush

@push('script_head')
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
