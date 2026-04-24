@extends('components.head')

@section('content')

    <body class="bg-black min-h-screen overflow-hidden">
        <!-- Camera Scanner View -->
        <div id="scannerContainer" class="fixed inset-0 z-0 bg-black">
            <div id="reader" class="w-full h-full"></div>
        </div>

        <!-- Overlay UI -->
        <div class="fixed inset-0 z-10 flex flex-col pointer-events-none">
            <!-- Top Bar -->
            <header
                class="bg-black/40 backdrop-blur-md px-5 py-6 flex items-center gap-4 pointer-events-auto transition-all duration-300">
                <a href="{{ route('voucher.index') }}"
                    class="h-10 w-10 bg-white/20 rounded-full flex items-center justify-center text-white backdrop-blur-md active:scale-95 transition-transform">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-lg font-black text-white uppercase italic tracking-tighter leading-none">Terima Voucher
                    </h1>
                    <p class="text-[10px] font-bold text-white/60 uppercase tracking-widest mt-1">Scan QR Pengirim</p>
                </div>
            </header>

            <!-- Scanning Frame Overlay -->
            <div class="flex-1 flex flex-col items-center pt-20">
                <div class="relative w-72 h-72 border-2 border-white/10 rounded-[48px] bg-white/5">
                    <!-- Corner Accents -->
                    <div class="absolute -top-1 -left-1 w-12 h-12 border-t-4 border-l-4 border-white rounded-tl-[24px]">
                    </div>
                    <div class="absolute -top-1 -right-1 w-12 h-12 border-t-4 border-r-4 border-white rounded-tr-[24px]">
                    </div>
                    <div class="absolute -bottom-1 -left-1 w-12 h-12 border-b-4 border-l-4 border-white rounded-bl-[24px]">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-12 h-12 border-b-4 border-r-4 border-white rounded-br-[24px]">
                    </div>

                    <!-- Scanning Line -->
                    <div
                        class="absolute left-6 right-6 h-1 bg-satset-green shadow-[0_0_20px_#21ada8] animate-scan-line z-20">
                    </div>
                </div>
                <p
                    class="mt-10 text-white/90 text-sm font-black bg-white/10 px-6 py-3 rounded-full backdrop-blur-md uppercase tracking-widest italic border border-white/10">
                    Scanning...</p>
            </div>

            <!-- Bottom Controls -->
            <div class="bg-gradient-to-t from-black/80 to-transparent p-10 pointer-events-auto">
                <div class="flex items-center justify-center gap-12">
                    <!-- Flash Button -->
                    <button id="toggleFlash" onclick="toggleFlash()" class="flex flex-col items-center gap-2 group">
                        <div
                            class="h-16 w-16 bg-white/10 rounded-full flex items-center justify-center text-white border border-white/10 backdrop-blur-md group-active:scale-90 transition-all">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-white uppercase tracking-widest">Senter</span>
                    </button>

                    <!-- Upload Button -->
                    <button onclick="document.getElementById('qr-input-file').click()"
                        class="flex flex-col items-center gap-2 group">
                        <div
                            class="h-16 w-16 bg-white/10 rounded-full flex items-center justify-center text-white border border-white/10 backdrop-blur-md group-active:scale-90 transition-all">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                        </div>
                        <span class="text-[10px] font-black text-white uppercase tracking-widest">Galeri</span>
                    </button>

                    <!-- Hidden File Input -->
                    <input type="file" id="qr-input-file" accept="image/*" class="hidden" onchange="uploadImage(event)">
                </div>
            </div>
        </div>

        <!-- Success Overlay -->
        <div id="successOverlay"
            class="fixed inset-0 bg-satset-green z-[100] hidden flex flex-col items-center justify-center p-10 text-center text-white">
            <div class="success-check mb-8">
                <div
                    class="h-32 w-32 bg-white rounded-[48px] flex items-center justify-center text-satset-green shadow-2xl">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
            </div>
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-4">Berhasil Scan!</h2>
            <p class="font-bold opacity-80 mb-12">Berhasil memindai QR code. Silakan tunggu pengirim mengonfirmasi.</p>
            <a href="{{ route('voucher.index') }}"
                class="w-full bg-white text-satset-green py-5 rounded-[24px] font-black uppercase tracking-[0.2em] italic text-sm shadow-xl">Kembali
                ke Voucher</a>
        </div>

        <!-- Loading State -->
        <div id="loadingOverlay"
            class="fixed inset-0 bg-white/90 backdrop-blur-sm z-[90] hidden flex flex-col items-center justify-center p-10 text-center text-black">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-satset-green mb-6"></div>
            <p class="font-black uppercase italic tracking-widest text-xs">Sedang Memproses</p>
        </div>

        @include('services.partials.alert_modal')
    </body>

    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode = null;
        let isFlashOn = false;

        document.addEventListener('DOMContentLoaded', function() {
            initScanner();
        });

        function initScanner() {
            html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 25,
                aspectRatio: window.innerWidth / window.innerHeight
            };

            html5QrCode.start({
                    facingMode: "environment"
                },
                config,
                (decodedText, decodedResult) => {
                    vibrate();
                    sendOtpAndShowSuccess(decodedText);
                }
            ).catch(err => {
                console.error("Camera error:", err);
                showAlert("Kamera Error", "Gagal mengakses kamera. Pastikan izin kamera sudah diberikan.", "error");
            });
        }

        async function toggleFlash() {
            if (!html5QrCode) return;
            try {
                isFlashOn = !isFlashOn;
                await html5QrCode.applyVideoConstraints({
                    advanced: [{
                        torch: isFlashOn
                    }]
                });
                document.getElementById('toggleFlash').querySelector('div').classList.toggle('bg-satset-green',
                    isFlashOn);
                document.getElementById('toggleFlash').querySelector('div').classList.toggle('text-white', !isFlashOn);
                document.getElementById('toggleFlash').querySelector('div').classList.toggle('text-black', isFlashOn);
            } catch (err) {
                console.error("Flash error:", err);
                showAlert("Flash Error", "Flash tidak didukung di perangkat/browser ini.", "warning");
            }
        }

        async function uploadImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            document.getElementById('loadingOverlay').classList.remove('hidden');

            try {
                if (html5QrCode && html5QrCode.getState() === 2) {
                    try {
                        await html5QrCode.stop();
                    } catch (e) {
                        console.warn("Camera stop failed:", e);
                    }
                }

                const decodedText = await html5QrCode.scanFile(file, false);
                document.getElementById('loadingOverlay').classList.add('hidden');
                vibrate();
                sendOtpAndShowSuccess(decodedText);
            } catch (err) {
                document.getElementById('loadingOverlay').classList.add('hidden');
                console.error("Scan error:", err);
                let errorMsg = "Gagal memindai QR Code.";
                if (err.includes("not found") || err.includes("No MultiFormat Readers")) {
                    errorMsg = "QR Code tidak terdeteksi dalam gambar.";
                }
                showAlert("Scan Gagal", errorMsg, "error");
                if (html5QrCode && html5QrCode.getState() !== 2) {
                    initScanner();
                }
            } finally {
                event.target.value = '';
            }
        }

        function sendOtpAndShowSuccess(qrCode) {
            if (html5QrCode && html5QrCode.getState() === 2) {
                html5QrCode.stop().catch(err => console.warn("Camera stop failed:", err));
            }
            document.getElementById('loadingOverlay').classList.remove('hidden');

            fetch("{{ route('voucher.giftSendOtp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        qr_code: qrCode
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingOverlay').classList.add('hidden');
                    if (data.success) {
                        if (data.message) {
                            document.querySelector('#successOverlay h2').textContent = 'Scan Berhasil';
                            document.querySelector('#successOverlay p').textContent = data.message;
                        }
                        document.getElementById('successOverlay').classList.remove('hidden');
                    } else {
                        showAlert("Gagal", data.message || 'Gagal mengirim OTP ke pengirim. Silakan coba lagi.',
                            "error");
                        initScanner();
                    }
                })
                .catch(error => {
                    document.getElementById('loadingOverlay').classList.add('hidden');
                    console.error('Error:', error);
                    showAlert("Kesalahan", 'Terjadi kesalahan koneksi.', "error");
                    initScanner();
                });
        }

        function vibrate() {
            if (window.navigator && window.navigator.vibrate) {
                window.navigator.vibrate(100);
            }
        }
    </script>
@endsection

@push('style')
    <style>
        @keyframes scan-line {
            0% {
                top: 5%;
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            50% {
                top: 95%;
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                top: 5%;
                opacity: 0;
            }
        }

        .animate-scan-line {
            animation: scan-line 3s linear infinite;
        }

        #reader__dashboard,
        #reader__status_span,
        #reader img,
        #reader__scan_region>div {
            display: none !important;
        }

        #reader {
            border: none !important;
        }

        #reader__scan_region video {
            object-fit: cover !important;
            width: 100vw !important;
            height: 100vh !important;
        }

        #reader__scan_region {
            background: black !important;
        }

        .success-check {
            animation: bounceIn 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            70% {
                transform: scale(0.95);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endpush
