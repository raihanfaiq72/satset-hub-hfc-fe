@extends('components.head')

@section('content')

    <body class="bg-gray-50 min-h-screen">
        <div id="giverContainer" class="flex min-h-screen flex-col transition-all duration-500">
            <!-- Header -->
            <header
                class="bg-white px-5 py-6 flex items-center gap-4 sticky top-0 z-40 shadow-sm transition-shadow duration-300">
                <a href="{{ route('voucher.index') }}"
                    class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 active:scale-95 transition-all">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </a>
                <h1 id="pageTitle" class="text-xl font-black text-gray-800 uppercase italic tracking-tighter">Bagi Voucher
                </h1>
            </header>

            <!-- Step 1: Generate QR -->
            <main id="qrSection" class="flex-1 px-5 pt-10 pb-20 flex flex-col items-center">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-black text-gray-800 uppercase italic tracking-tight">QR Code Transfer</h2>
                    <p class="text-gray-400 text-sm font-bold mt-1">Berikan ke penerima untuk dipindai</p>
                </div>

                <!-- QR Container -->
                <div class="bg-white p-8 rounded-[48px] shadow-2xl shadow-gray-200 border border-gray-100 mb-10 relative group transition-all duration-500"
                    id="qrContainerWrapper">
                    <div id="qrContainer"
                        class="w-64 h-64 bg-gray-50 rounded-3xl flex items-center justify-center overflow-hidden border-4 border-gray-50">
                        <div class="animate-pulse flex flex-col items-center">
                            <div class="w-16 h-16 bg-gray-200 rounded-full mb-4"></div>
                            <div class="h-3 w-32 bg-gray-200 rounded-full"></div>
                        </div>
                    </div>

                    <div
                        class="absolute -top-2 -left-2 w-12 h-12 border-t-4 border-l-4 border-satset-green rounded-tl-[24px]">
                    </div>
                    <div
                        class="absolute -top-2 -right-2 w-12 h-12 border-t-4 border-r-4 border-satset-green rounded-tr-[24px]">
                    </div>
                    <div
                        class="absolute -bottom-2 -left-2 w-12 h-12 border-b-4 border-l-4 border-satset-green rounded-bl-[24px]">
                    </div>
                    <div
                        class="absolute -bottom-2 -right-2 w-12 h-12 border-b-4 border-r-4 border-satset-green rounded-br-[24px]">
                    </div>
                </div>

                <div class="mt-8 text-center max-w-xs">
                    <div
                        class="animate-bounce h-12 w-12 bg-satset-green/10 rounded-2xl flex items-center justify-center text-satset-green mx-auto mb-4">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <p class="text-xs font-bold text-gray-500 leading-relaxed uppercase tracking-wider">Halaman ini akan
                        otomatis berubah setelah penerima memindai kode di atas.</p>
                </div>
            </main>

            <!-- Step 2: Enter OTP -->
            <main id="otpSection" class="flex-1 px-5 pt-12 pb-10 flex flex-col hidden animate-fade-in">
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
                    <p id="otpInstruction" class="text-gray-400 text-sm font-bold mt-2 px-6">Lihat kode 6 digit yang dikirim
                        ke WhatsApp Anda.</p>
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



        @include('services.partials.alert_modal')
    </body>

    <script>
        let selectedType = @json($selectedVoucherType);
        let selectedId = @json($selectedVoucherId);
        let generatedQrCode = null;
        let pollingInterval = null;

        document.addEventListener('DOMContentLoaded', function() {
            generateQr();
        });

        function generateQr() {
            const qrContainer = document.getElementById('qrContainer');

            fetch("{{ route('voucher.generateReceiveQr') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        generatedQrCode = data.data.qr_code;
                        const qrUrl =
                            `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodeURIComponent(generatedQrCode)}`;
                        qrContainer.innerHTML =
                            `<img src="${qrUrl}" alt="QR Code" class="w-full h-full object-contain p-2 animate-fade-in">`;

                        // Start Polling
                        startPolling();
                    } else {
                        showAlert("Gagal", data.message || 'Gagal membuat QR Code.', 'error');
                        setTimeout(() => window.location.href = "{{ route('voucher.index') }}", 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert("Kesalahan", 'Terjadi kesalahan koneksi.', 'error');
                    setTimeout(() => window.location.href = "{{ route('voucher.index') }}", 2000);
                });
        }

        function startPolling() {
            pollingInterval = setInterval(() => {
                fetch("{{ route('voucher.checkOtpStatus') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.scanned) {
                            clearInterval(pollingInterval);
                            showOtpInput(data.data.target_phone);
                        } else if (data.status === 'error') {
                            console.error('Polling error:', data.message);
                            // Optional: show error message if it's not a common timeout
                        }
                    })
                    .catch(error => console.warn('Polling error:', error));
            }, 3000);
        }

        function showOtpInput(phone) {
            vibrate();
            document.getElementById('qrSection').classList.add('hidden');
            document.getElementById('otpSection').classList.remove('hidden');
            document.getElementById('pageTitle').textContent = 'Verifikasi';

            if (phone) {
                document.getElementById('otpInstruction').innerHTML =
                    `OTP telah dikirim ke WhatsApp Anda <br> <span class="text-satset-green font-black">${phone}</span>`;
            }

            setTimeout(() => {
                document.querySelector('.otp-input').focus();
            }, 300);
        }

        function processGift() {
            const otp = Array.from(document.querySelectorAll('.otp-input')).map(i => i.value).join('');
            showLoading();

            fetch("{{ route('voucher.giftProcess') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        qr_code: generatedQrCode,
                        voucher_type: selectedType,
                        voucher_id: selectedId,
                        otp: otp
                    })
                })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        document.getElementById('successOverlay').classList.remove('hidden');
                    } else {
                        showAlert("Gagal", data.message || 'OTP salah atau sudah kadaluwarsa.', 'error');
                        document.querySelectorAll('.otp-input').forEach(i => i.value = '');
                        document.querySelector('.otp-input').focus();
                        checkOtpComplete();
                    }
                })
                .catch(error => {
                    hideLoading();
                    console.error('Error:', error);
                    showAlert("Kesalahan", 'Terjadi kesalahan koneksi.', 'error');
                });
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
                btn.classList.add('bg-satset-green', 'text-white', 'shadow-lg');
            } else {
                btn.disabled = true;
                btn.classList.add('bg-gray-200', 'text-gray-400');
                btn.classList.remove('bg-satset-green', 'text-white', 'shadow-lg');
            }
        }
    </script>
@endsection

@push('style')
    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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
@endpush
