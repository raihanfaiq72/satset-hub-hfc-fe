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
                    <h1 class="text-lg font-black text-white uppercase italic tracking-tighter leading-none">Bagi Voucher
                    </h1>
                    <p class="text-[10px] font-bold text-white/60 uppercase tracking-widest mt-1">Scan QR Penerima</p>
                </div>
                <!-- Progress Icon -->
                <div
                    class="h-10 w-10 rounded-full border-2 border-white/20 flex items-center justify-center text-[10px] font-black text-white">
                    1/2
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

        <!-- Step 3: Enter OTP (Overlay) -->
        <div id="otpOverlay" class="fixed inset-0 z-[50] bg-gray-50 flex flex-col hidden overflow-y-auto">
            <header class="bg-white px-5 py-6 flex items-center gap-4 shadow-sm">
                <button onclick="closeOtpOverlay()"
                    class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 active:scale-95 transition-all">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </button>
                <h1 class="text-xl font-black text-gray-800 uppercase italic tracking-tighter">Verifikasi</h1>
            </header>

            <main class="flex-1 px-5 pt-12 pb-10 flex flex-col">
                <div class="text-center mb-12">
                    <div
                        class="h-24 w-24 bg-satset-green/10 rounded-[32px] flex items-center justify-center text-satset-green mx-auto mb-6">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-800 uppercase italic tracking-tight">Masukkan OTP</h2>
                    <p class="text-gray-400 text-sm font-bold mt-2 px-6">Lihat kode 6 digit di layar HP penerima.</p>
                </div>

                <div class="flex justify-center gap-2 mb-12">
                    <input type="number" maxlength="1"
                        class="otp-input w-12 h-16 bg-white border-2 border-gray-100 rounded-2xl text-center text-2xl font-black text-satset-green focus:border-satset-green focus:outline-none transition-all"
                        data-index="0">
                    <input type="number" maxlength="1"
                        class="otp-input w-12 h-16 bg-white border-2 border-gray-100 rounded-2xl text-center text-2xl font-black text-satset-green focus:border-satset-green focus:outline-none transition-all"
                        data-index="1">
                    <input type="number" maxlength="1"
                        class="otp-input w-12 h-16 bg-white border-2 border-gray-100 rounded-2xl text-center text-2xl font-black text-satset-green focus:border-satset-green focus:outline-none transition-all"
                        data-index="2">
                    <input type="number" maxlength="1"
                        class="otp-input w-12 h-16 bg-white border-2 border-gray-100 rounded-2xl text-center text-2xl font-black text-satset-green focus:border-satset-green focus:outline-none transition-all"
                        data-index="3">
                    <input type="number" maxlength="1"
                        class="otp-input w-12 h-16 bg-white border-2 border-gray-100 rounded-2xl text-center text-2xl font-black text-satset-green focus:border-satset-green focus:outline-none transition-all"
                        data-index="4">
                    <input type="number" maxlength="1"
                        class="otp-input w-12 h-16 bg-white border-2 border-gray-100 rounded-2xl text-center text-2xl font-black text-satset-green focus:border-satset-green focus:outline-none transition-all"
                        data-index="5">
                </div>

                <div class="mt-auto">
                    <button id="submitGift" disabled onclick="processGift()"
                        class="w-full bg-gray-200 text-gray-400 py-6 rounded-[28px] font-black uppercase tracking-[0.2em] italic text-sm transition-all active:scale-95 disabled:cursor-not-allowed">
                        Konfirmasi Transfer
                    </button>
                </div>
            </main>
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
            <h2 class="text-3xl font-black uppercase italic tracking-tighter mb-4">Voucher Terkirim!</h2>
            <p class="font-bold opacity-80 mb-12">Yess! Voucher kamu sudah berpindah tangan dengan selamat.</p>
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

        <script src="https://unpkg.com/html5-qrcode"></script>
        <script>
            let selectedType = @json($selectedVoucherType);
            let selectedId = @json($selectedVoucherId);
            let scannedQrCode = null;
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
                        scannedQrCode = decodedText;
                        vibrate();
                        showOtpOverlay();
                    }
                ).catch(err => {
                    console.error("Camera error:", err);
                    alert("Gagal mengakses kamera. Pastikan izin kamera sudah diberikan.");
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
                    alert("Flash tidak didukung di perangkat/browser ini.");
                }
            }

            function uploadImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                document.getElementById('loadingOverlay').classList.remove('hidden');
                html5QrCode.scanFile(file, true)
                    .then(decodedText => {
                        document.getElementById('loadingOverlay').classList.add('hidden');
                        scannedQrCode = decodedText;
                        vibrate();
                        showOtpOverlay();
                    })
                    .catch(err => {
                        document.getElementById('loadingOverlay').classList.add('hidden');
                        alert("Gagal memindai QR Code dari gambar. Pastikan gambar jelas.");
                        console.error("Scan file error:", err);
                    });
            }

            function showOtpOverlay() {
                if (html5QrCode) {
                    html5QrCode.stop().catch(err => console.error(err));
                }
                document.getElementById('otpOverlay').classList.remove('hidden');
                setTimeout(() => {
                    document.querySelector('.otp-input').focus();
                }, 300);
            }

            function closeOtpOverlay() {
                document.getElementById('otpOverlay').classList.add('hidden');
                initScanner();
            }

            function vibrate() {
                if (window.navigator && window.navigator.vibrate) {
                    window.navigator.vibrate(100);
                }
            }

            // OTP Input Logic
            document.querySelectorAll('.otp-input').forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (e.target.value.length > 1) {
                        e.target.value = e.target.value.slice(0, 1);
                    }
                    if (e.target.value && index < 5) {
                        document.querySelectorAll('.otp-input')[index + 1].focus();
                    }
                    checkOtpComplete();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        document.querySelectorAll('.otp-input')[index - 1].focus();
                    }
                });
            });

            function checkOtpComplete() {
                const otp = Array.from(document.querySelectorAll('.otp-input')).map(i => i.value).join('');
                const btn = document.getElementById('submitGift');
                if (otp.length === 6) {
                    btn.disabled = false;
                    btn.classList.remove('bg-gray-200', 'text-gray-400');
                    btn.classList.add('bg-satset-green', 'text-white', 'shadow-lg', 'shadow-satset-green/20');
                } else {
                    btn.disabled = true;
                    btn.classList.add('bg-gray-200', 'text-gray-400');
                    btn.classList.remove('bg-satset-green', 'text-white', 'shadow-lg');
                }
            }

            function processGift() {
                const otp = Array.from(document.querySelectorAll('.otp-input')).map(i => i.value).join('');
                document.getElementById('loadingOverlay').classList.remove('hidden');

                fetch("{{ route('voucher.giftProcess') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            qr_code: scannedQrCode,
                            voucher_type: selectedType,
                            voucher_id: selectedId,
                            otp: otp
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loadingOverlay').classList.add('hidden');
                        if (data.success) {
                            document.getElementById('successOverlay').classList.remove('hidden');
                        } else {
                            alert(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                            document.querySelectorAll('.otp-input').forEach(i => i.value = '');
                            document.querySelector('.otp-input').focus();
                            checkOtpComplete();
                        }
                    })
                    .catch(error => {
                        document.getElementById('loadingOverlay').classList.add('hidden');
                        console.error('Error:', error);
                        alert('Terjadi kesalahan koneksi.');
                    });
            }
        </script>

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

            #reader__scan_region {
                background: black !important;
            }

            /* Hide all html5-qrcode default UI elements including the internal box */
            #reader__dashboard,
            #reader__status_span,
            #reader img,
            #reader__scan_region>div {
                display: none !important;
            }

            #reader {
                border: none !important;
            }

            /* Make video fill the container */
            #reader__scan_region video {
                object-fit: cover !important;
                width: 100vw !important;
                height: 100vh !important;
            }

            #reader__scan_region {
                background: black !important;
            }

            .otp-input::-webkit-outer-spin-button,
            .otp-input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            .otp-input {
                -moz-appearance: textfield;
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
    </body>
@endsection
