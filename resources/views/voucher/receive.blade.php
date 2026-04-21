@extends('components.head')

@section('content')
<body class="bg-gray-50 min-h-screen">
    <!-- Main Receive Page -->
    <div class="flex min-h-screen flex-col">
        <!-- Header -->
        <header class="bg-white px-5 py-6 flex items-center gap-4 sticky top-0 z-40 shadow-sm transition-shadow duration-300">
            <a href="{{ route('voucher.index') }}" class="h-10 w-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 active:scale-95 transition-all">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </a>
            <h1 class="text-xl font-black text-gray-800 uppercase italic tracking-tighter">Terima Voucher</h1>
        </header>

        <!-- Main Content -->
        <main class="flex-1 px-5 pt-10 pb-20 flex flex-col items-center">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-black text-gray-800 uppercase italic tracking-tight">QR Code Anda</h2>
                <p class="text-gray-400 text-sm font-bold mt-1">Tunjukkan ke teman untuk menerima voucher</p>
            </div>

            <!-- QR Container -->
            <div class="bg-white p-8 rounded-[48px] shadow-2xl shadow-gray-200 border border-gray-100 mb-10 relative group">
                <div id="qrContainer" class="w-64 h-64 bg-gray-50 rounded-3xl flex items-center justify-center overflow-hidden border-4 border-gray-50">
                    <!-- Loading pulse while fetching -->
                    <div class="animate-pulse flex flex-col items-center">
                        <div class="w-16 h-16 bg-gray-200 rounded-full mb-4"></div>
                        <div class="h-3 w-32 bg-gray-200 rounded-full"></div>
                    </div>
                </div>
                
                <!-- Corner Accents -->
                <div class="absolute -top-2 -left-2 w-12 h-12 border-t-4 border-l-4 border-satset-green rounded-tl-[24px]"></div>
                <div class="absolute -top-2 -right-2 w-12 h-12 border-t-4 border-r-4 border-satset-green rounded-tr-[24px]"></div>
                <div class="absolute -bottom-2 -left-2 w-12 h-12 border-b-4 border-l-4 border-satset-green rounded-bl-[24px]"></div>
                <div class="absolute -bottom-2 -right-2 w-12 h-12 border-b-4 border-r-4 border-satset-green rounded-br-[24px]"></div>
            </div>

            <!-- OTP Card -->
            <div class="bg-satset-green p-8 rounded-[40px] w-full max-w-sm shadow-xl shadow-satset-green/20 text-center relative overflow-hidden">
                <!-- Abstract background pattern -->
                <div class="absolute top-0 right-0 -mr-10 -mt-10 h-32 w-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 -ml-10 -mb-10 h-32 w-32 bg-white/10 rounded-full blur-2xl"></div>

                <p class="text-[10px] font-black text-white/80 uppercase tracking-[0.3em] mb-3">Kode Verifikasi (OTP)</p>
                <div class="flex justify-center items-center gap-1">
                    <h3 id="otpValue" class="text-5xl font-black text-white tracking-[0.2em] font-mono">------</h3>
                </div>
                <div class="mt-6 inline-flex items-center gap-2 bg-black/10 px-4 py-2 rounded-full border border-white/10">
                    <div class="h-2 w-2 bg-white rounded-full animate-pulse"></div>
                    <p class="text-[10px] font-bold text-white uppercase tracking-widest italic">Berlaku selama 5 menit</p>
                </div>
            </div>

            <div class="mt-12 text-center max-w-xs">
                <div class="h-12 w-12 bg-orange-500/10 rounded-2xl flex items-center justify-center text-orange-500 mx-auto mb-4">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
                </div>
                <p class="text-xs font-bold text-gray-500 leading-relaxed uppercase tracking-wider">Berikan kode OTP kepada pengirim setelah mereka memindai QR Code Anda.</p>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchQrData();
        });

        function fetchQrData() {
            const qrContainer = document.getElementById('qrContainer');
            const otpText = document.getElementById('otpValue');

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
                    const qrCode = data.data.qr_code;
                    const otp = data.data.otp;

                    // Generate QR Image using external service
                    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=${encodeURIComponent(qrCode)}`;
                    qrContainer.innerHTML = `<img src="${qrUrl}" alt="QR Code" class="w-full h-full object-contain p-2 animate-fade-in">`;
                    otpText.textContent = otp;
                } else {
                    alert(data.message || 'Gagal membuat QR Code.');
                    window.location.href = "{{ route('voucher.index') }}";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan koneksi.');
                window.location.href = "{{ route('voucher.index') }}";
            });
        }
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</body>
@endsection
