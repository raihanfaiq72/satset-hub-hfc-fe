@extends('components.head')

@section('content')

    <body class="bg-white min-h-screen flex items-center justify-center p-4">

        <div class="w-full max-w-sm space-y-6 text-center">

            <!-- Title -->
            <h2 class="text-2xl font-bold text-gray-800">
                Masukkan Kode OTP
            </h2>

            @include('components.errorAlert')
            <p class="text-gray-500 text-sm">
                Kami telah mengirim kode ke nomor Anda
                @if (session('noHp'))
                    <span class="font-semibold">{{ session('noHp') }}</span>
                @endif
            </p>

            <!-- OTP Form -->
            <form id="otpForm" class="space-y-6" action="{{ route('otp.verify') }}" method="POST">
                @csrf

                <!-- OTP Inputs -->
                <div class="flex justify-between gap-2">
                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*"
                        autocomplete="one-time-code" />
                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" />
                    <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]*" />
                </div>

                <!-- Hidden inputs -->
                <input type="hidden" name="otp" id="otpValue">
                <input type="hidden" name="noHp" id="noHp" value="{{ old('noHp', session('noHp')) }}">

                <!-- Submit -->
                <button type="submit" class="w-full h-12 bg-satset-green hover:bg-satset-dark text-white font-bold rounded-xl">
                    Verifikasi
                </button>
            </form>

            <!-- Resend -->
            <p class="text-sm text-gray-500">
                Tidak menerima kode?
                <a href="#" class="text-satset-green font-semibold">Kirim ulang</a>
            </p>

        </div>

    </body>
@endsection

@push('style')
    <style>
        .otp-input {
            width: 48px;
            height: 56px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            outline: none;
        }

        .otp-input:focus {
            border-color: #2d7a6e;
            box-shadow: 0 0 0 2px rgba(45, 122, 110, 0.2);
        }
    </style>
@endpush

@push('script_head')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            const otpValue = document.getElementById('otpValue');

            inputs.forEach((input, index) => {

                // Input angka saja
                input.addEventListener('input', (e) => {
                    input.value = input.value.replace(/[^0-9]/g, '');

                    if (input.value && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }

                    updateOTP();
                });

                // Backspace pindah ke kiri
                input.addEventListener('keydown', (e) => {
                    if (e.key === "Backspace" && !input.value && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Paste full OTP
                input.addEventListener('paste', (e) => {
                    const paste = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                    if (paste.length === 6) {
                        inputs.forEach((inp, i) => {
                            inp.value = paste[i];
                        });
                        updateOTP();
                    }
                    e.preventDefault();
                });
            });

            function updateOTP() {
                otpValue.value = Array.from(inputs).map(i => i.value).join('');
            }

            document.getElementById('otpForm').addEventListener('submit', function(e) {
                updateOTP();
                console.log("OTP:", otpValue.value);
            });
        });
    </script>
@endpush