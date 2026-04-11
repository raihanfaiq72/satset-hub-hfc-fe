<!-- Payment Step Templates -->
<template id="tpl-payment-step-1">
    <div class="space-y-8 animate-fade-in">
        <!-- Voucher Info -->
        <div class="border-none bg-gray-50 rounded-[32px] p-6 flex items-center gap-4">
            <div class="h-16 w-16 relative rounded-2xl overflow-hidden shadow-md">
                <div
                    class="w-full h-full bg-gradient-to-br from-satset-green to-satset-dark flex items-center justify-center">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9Z"></path>
                        <path d="M9 9l3 3-3 3"></path>
                        <path d="M15 9l-3 3 3 3"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h3 class="font-black text-gray-800 text-lg js-voucher-title"></h3>
                <p class="text-xs font-bold text-satset-green js-voucher-price"></p>
                <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase tracking-wider">Tersedia: <span
                        class="js-stock-text">0</span></p>
            </div>
        </div>

        <!-- Quantity Selection -->
        <div class="space-y-4">
            <h4 class="font-black text-gray-800 uppercase text-sm italic px-2">Pilih Jumlah</h4>
            <div class="flex items-center justify-center gap-8 bg-gray-50 p-6 rounded-[32px]">
                <button onclick="updateQuantity(-1)"
                    class="quantity-btn h-12 w-12 rounded-full bg-white flex items-center justify-center shadow-md">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
                <span class="text-3xl font-black text-gray-800 js-quantity-text"></span>
                <button onclick="updateQuantity(1)"
                    class="quantity-btn h-12 w-12 rounded-full bg-satset-green text-white flex items-center justify-center shadow-md">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="setQuantity(5)"
                    class="py-2 rounded-xl bg-gray-100 text-[10px] font-black hover:bg-gray-200 transition-colors">BUNDLE
                    5</button>
                <button onclick="setQuantity(10)"
                    class="py-2 rounded-xl bg-gray-100 text-[10px] font-black hover:bg-gray-200 transition-colors">BUNDLE
                    10</button>
            </div>
        </div>

        <!-- Fixed Bottom -->
        <div
            class="fixed bottom-0 left-0 right-0 p-6 bg-white border-t border-gray-100 shadow-[0_-4px_20px_rgba(0,0,0,0.05)]">
            <div class="flex justify-between items-center mb-4 px-2">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Bayar</p>
                <p class="text-2xl font-black text-satset-green js-total-price"></p>
            </div>
            <button onclick="confirmPayment()"
                class="w-full h-16 bg-satset-green rounded-3xl font-black text-lg text-white btn-scale shadow-lg shadow-satset-green/20">
                KONFIRMASI BELI
            </button>
        </div>
    </div>
</template>

<template id="tpl-payment-step-2">
    <div class="space-y-6 flex flex-col items-center animate-slide-in">
        <div class="qr-container p-5 bg-white rounded-[32px] shadow-2xl border-4 border-gray-50 mt-10">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=VOUCHER-PAY" alt="QRIS"
                class="w-52 h-52 js-qr-image" />
        </div>
        <p class="text-xs font-black text-gray-400 uppercase tracking-widest text-center leading-relaxed">
            Selesaikan Pembayaran<br />Untuk Mengaktifkan Voucher
        </p>
        <div class="w-full px-2 pt-4">
            <button onclick="simulateSuccess()"
                class="w-full h-16 bg-satset-green rounded-3xl font-black text-white btn-scale shadow-lg shadow-satset-green/20">
                BERHASIL
            </button>
        </div>
    </div>
</template>

<template id="tpl-payment-step-3">
    <div class="flex flex-col items-center justify-center py-12 text-center space-y-8 animate-zoom-in">
        <div
            class="success-check h-40 w-40 bg-satset-green rounded-full flex items-center justify-center shadow-2xl shadow-satset-green/40">
            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        </div>
        <div class="space-y-2">
            <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter italic">Voucher Berhasil!</h2>
            <p class="text-gray-400 font-bold text-sm tracking-tight px-10">Voucher otomatis ditambahkan ke koleksi
                kamu.</p>
        </div>
        <div class="w-full px-2">
            <button onclick="window.location.href='/voucher'"
                class="w-full bg-satset-green h-16 rounded-3xl font-black text-lg text-white btn-scale shadow-lg shadow-satset-green/20">
                LIHAT VOUCHER SAYA
            </button>
        </div>
    </div>
</template>
