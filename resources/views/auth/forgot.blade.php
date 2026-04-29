@extends('components.head')

@section('content')

    <body class="bg-white min-h-screen flex items-center justify-center p-6">

        <div class="w-full max-w-[400px] px-10 space-y-8">

            <!-- Header -->
            <div class="flex flex-col items-center space-y-2">
                <div class="mb-4 flex justify-center">
                    <img src="https://api.satset.co.id/asset/logo.png" alt="Logo SatSet" class="w-32 h-32 object-contain" />
                </div>
                @include('components.errorAlert')
                <h2 class="text-2xl font-bold text-gray-800">
                    Halo, Lupa Password?
                </h2>
                <p class="text-center text-sm font-medium text-satset-green">
                    Silahkan Masukkan No Handphone Anda
                </p>
            </div>

            <!-- Form -->
            <form class="space-y-6" action="{{ route('password.noHp') }}" method="POST">
                @csrf

                <div class="space-y-2">
                    <label for="noHp" class="font-bold text-gray-700 block">
                        No Handphone
                    </label>
                    <input id="noHp" name="noHp" type="text" placeholder="Type No Handphone Here"
                        value="{{ old('noHp') }}"
                        class="h-12 w-full rounded-xl border border-gray-300 px-4 py-3 text-base text-black placeholder:text-gray-500 focus:border-satset-green focus:outline-none focus:ring-2 focus:ring-satset-green"
                        required />
                </div>

                <!-- Submit Button (FIXED) -->
                <button type="submit"
                    class="h-12 w-full bg-satset-green hover:bg-satset-dark text-white font-bold text-lg rounded-xl transition-colors">
                    Submit
                </button>
            </form>

            <!-- Back Button -->
            <div class="pt-4">
                <a href="/login"
                    class="h-12 w-full border-2 border-satset-green text-satset-green font-bold hover:bg-satset-green/10 rounded-xl transition-colors flex items-center justify-center text-lg no-underline">
                    Kembali ke halaman Login
                </a>
            </div>

        </div>

    </body>
@endsection

@push('style')
    <style>
        /* Firefox compatibility fixes */
        @-moz-document url-prefix() {

            input[type="text"],
            input[type="password"] {
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
    </style>
@endpush