<template id="tpl-step-3">
    <div class="space-y-6 pb-20">
        {{-- Summary Section --}}
        <div class="border-none bg-gray-50 rounded-[32px] overflow-hidden shadow-inner">
            <div class="p-6 space-y-4">
                <h3 class="font-black text-gray-800 text-lg italic uppercase tracking-tighter">Ringkasan Pesanan</h3>
                <div class="space-y-3 border-b border-dashed border-gray-300 pb-5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Layanan</span>
                        <span id="summaryServiceName" class="font-bold text-gray-800"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Waktu</span>
                        <span id="summaryTime" class="font-bold text-gray-800 text-right"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Lokasi</span>
                        <span id="summaryLocation"
                            class="font-bold text-gray-800 text-right truncate max-w-[150px]"></span>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <span class="font-bold text-gray-800">Total Bayar</span>
                    <span id="summaryTotalPay" class="text-2xl font-black text-satset-green"></span>
                </div>
            </div>
        </div>

        {{-- Promo Section --}}
        <div class="space-y-3">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Makin Hemat</h4>
            <div id="promoContainer"
                class="bg-white border-2 border-gray-100 rounded-[24px] p-4 flex items-center justify-between group active:scale-95 transition-all cursor-pointer hover:border-satset-green"
                onclick="showPromoModal()">
                <div class="flex items-center gap-3">
                    <div
                        class="h-10 w-10 bg-satset-green/10 rounded-xl flex items-center justify-center text-satset-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z">
                            </path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                    </div>
                    <div>
                        <p id="selectedPromoLabel" class="text-sm font-black text-gray-800">Pakai Promo</p>
                        <p id="selectedPromoSub" class="text-[10px] text-gray-400 font-bold uppercase">Diskon atau
                            voucher</p>
                    </div>
                </div>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                    class="text-gray-300 group-hover:text-satset-green transition-colors">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </div>

        {{-- Payment Methods --}}
        <div class="space-y-3">
            <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Bayar Dengan</h4>

            <div class="grid grid-cols-1 gap-3">
                <!-- Voucher Pembayaran -->
                <div class="payment-method-card bg-white border-2 border-gray-100 rounded-[28px] p-4 flex items-center gap-4 cursor-pointer transition-all hover:border-satset-green"
                    onclick="selectPaymentMethod('voucher')">
                    <div
                        class="h-12 w-12 bg-satset-green rounded-2xl flex items-center justify-center text-white shrink-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h5 class="text-sm font-black text-gray-800">Voucher Pembayaran</h5>
                        <p id="voucherBalanceText"
                            class="text-[10px] text-satset-green font-black uppercase tracking-tighter loading-text">
                            Mengecek voucher...</p>
                        <p id="selectedVoucherName"
                            class="text-[11px] text-gray-400 font-bold hidden mt-0.5 line-clamp-1"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="btnPickVoucher" onclick="event.stopPropagation(); showPaymentVoucherModal();"
                            class="hidden px-3 py-1.5 bg-satset-green/10 text-satset-green text-[10px] font-black rounded-lg hover:bg-satset-green/20 transition-all">PILIH</button>
                        {{-- <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                            class="text-gray-300 transition-colors" id="voucherArrow">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg> --}}
                        <input type="radio" name="payment_method" value="voucher"
                            class="radio-custom pointer-events-none" id="radio-voucher">
                    </div>
                </div>

                <!-- QRIS -->
                <div class="payment-method-card bg-white border-2 border-gray-100 rounded-[28px] p-4 flex items-center gap-4 cursor-pointer transition-all hover:border-satset-green"
                    onclick="selectPaymentMethod('qris')">
                    <div
                        class="h-12 w-12 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-800 shrink-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            <line x1="17" y1="7" x2="17.01" y2="7"></line>
                            <line x1="17" y1="17" x2="17.01" y2="17"></line>
                            <line x1="7" y1="17" x2="7.01" y2="17"></line>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h5 class="text-sm font-black text-gray-800">QRIS</h5>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Gopay, OVO,
                            ShopeePay, Dana</p>
                    </div>
                    <input type="radio" name="payment_method" value="qris"
                        class="radio-custom pointer-events-none" id="radio-qris">
                </div>
            </div>
        </div>
    </div>

    {{-- Promo Modal --}}
    <div id="promoModal" class="fixed inset-0 z-50 flex items-end justify-center hidden">
        <div class="modal-backdrop absolute inset-0 bg-black/40" onclick="hidePromoModal()"></div>
        <div class="relative bg-white rounded-t-[40px] w-full max-w-lg p-6 pb-12 shadow-2xl transition-transform transform translate-y-full"
            id="promoModalContent">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black text-gray-800 italic uppercase">Pilih Promo</h3>
                <button onclick="hidePromoModal()" class="text-gray-400 hover:text-gray-600">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div id="promoList" class="space-y-3 max-h-[60vh] overflow-y-auto">
                <div class="text-center py-10 text-gray-400 font-bold">
                    Mencari promo...
                </div>
            </div>

            <div id="unselectPromoBtn" class="mt-6 hidden">
                <button onclick="unselectPromo()"
                    class="w-full h-14 border-2 border-red-100 text-red-500 font-black rounded-2xl hover:bg-red-50 transition-colors">
                    BATAL GUNAKAN PROMO
                </button>
            </div>
        </div>
    </div>

    {{-- Payment Voucher Modal --}}
    <div id="paymentVoucherModal" class="fixed inset-0 z-50 flex items-end justify-center hidden">
        <div class="modal-backdrop absolute inset-0 bg-black/40" onclick="hidePaymentVoucherModal()"></div>
        <div class="relative bg-white rounded-t-[40px] w-full max-w-lg p-6 pb-12 shadow-2xl transition-transform transform translate-y-full"
            id="paymentVoucherModalContent">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black text-gray-800 italic uppercase">Pilih Voucher</h3>
                <button onclick="hidePaymentVoucherModal()" class="text-gray-400 hover:text-gray-600">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <div id="paymentVoucherList" class="space-y-3 max-h-[60vh] overflow-y-auto">
                <div class="text-center py-10 text-gray-400 font-bold">
                    Mencari voucher...
                </div>
            </div>

            <div id="unselectVoucherBtn" class="mt-6 hidden">
                <button onclick="unselectPaymentVoucher()"
                    class="w-full h-14 border-2 border-red-100 text-red-500 font-black rounded-2xl hover:bg-red-50 transition-colors">
                    BATAL GUNAKAN VOUCHER
                </button>
            </div>
        </div>
    </div>
</template>
