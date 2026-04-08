<template id="tpl-step-4">
    <div class="flex flex-col items-center justify-center py-12 text-center space-y-6">
        <div
            class="success-check h-40 w-40 bg-satset-green rounded-full flex items-center justify-center shadow-2xl shadow-satset-green/40">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>

        <div>
            <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Pembayaran Berhasil!</h2>
            <p class="text-gray-500 mt-2 font-medium">Pesananmu sedang diproses secara satset dan aman.</p>
        </div>

        <button onclick="window.location.href='{{ route('dashboard') }}'"
            class="w-full bg-satset-green h-16 rounded-3xl text-white font-bold text-lg shadow-xl shadow-satset-green/20 transition-colors hover:bg-satset-dark">
            KEMBALI KE BERANDA
        </button>
    </div>
</template>
