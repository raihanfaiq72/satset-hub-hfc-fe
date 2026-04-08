<!-- Voucher Detail Overaly -->
<div id="voucherDetailPage" class="fixed inset-0 z-[60] flex flex-col bg-gray-50 hidden overflow-y-auto">
    <!-- Header -->
    <header class="bg-white px-5 py-6 flex items-center gap-4 sticky top-0 z-10 shadow-sm">
        <button onclick="closeVoucherDetail()"
            class="h-10 w-10 flex items-center justify-center rounded-full active:bg-gray-100 transition-colors">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
        </button>
        <h1 class="text-xl font-black text-gray-800 italic uppercase tracking-tighter">Detail Voucher</h1>
    </header>

    <!-- Content -->
    <main class="flex-1 pb-32">
        <!-- Hero Visual -->
        <div class="px-5 pt-8 pb-4">
            <div class="relative w-full aspect-[4/3] rounded-[40px] overflow-hidden shadow-2xl group">
                <!-- Fallback Gradient -->
                <div class="absolute inset-0 bg-gradient-to-br from-satset-green to-satset-dark js-detail-gradient"></div>

                <!-- Voucher Image Background -->
                <img src="" alt="Voucher" class="absolute inset-0 w-full h-full object-cover hidden js-detail-image-bg">
                <div class="absolute inset-0 bg-black/40 hidden js-detail-image-overlay"></div>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-white p-8 z-10">
                    <div
                        class="h-24 w-24 bg-white/20 rounded-[32px] backdrop-blur-md flex items-center justify-center mb-6 js-detail-icon-container">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                            </rect>
                            <line x1="1" y1="10" x2="23" y2="10"></line>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-center leading-tight js-detail-name">---</h2>
                    <p class="text-white/60 text-xs font-bold mt-2 tracking-widest uppercase js-detail-type">---</p>
                </div>
                <!-- Gloss Effect -->
                <div
                    class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-white/10 to-transparent opacity-50">
                </div>
            </div>
        </div>

        <!-- Info Sections -->
        <div class="px-5 space-y-6 animate-fade-in">
            <!-- Voucher Code & Status -->
            <div class="flex gap-4">
                <div
                    class="flex-1 bg-white p-5 rounded-[32px] shadow-sm flex flex-col justify-center border border-gray-100/50">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Kode Voucher</p>
                    <p class="text-lg font-black text-gray-800 js-detail-code">---</p>
                </div>
                <div
                    class="bg-white p-5 rounded-[32px] shadow-sm flex flex-col items-center justify-center border border-gray-100/50 min-w-[100px]">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 text-center">Status
                    </p>
                    <span
                        class="text-[10px] font-black px-3 py-1 rounded-full bg-green-100 text-satset-green uppercase js-detail-status">Owned</span>
                </div>
            </div>

            <!-- Value & Expiry -->
            <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100/50 space-y-6">
                <div class="flex items-center gap-4">
                    <div
                        class="h-12 w-12 rounded-2xl bg-satset-green/10 flex items-center justify-center text-satset-green text-xl">
                        <i class="fa fa-money"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nilai Voucher</p>
                        <p class="text-xl font-black text-gray-800 js-detail-value">---</p>
                    </div>
                </div>

                <div class="h-px bg-gray-50"></div>

                <div class="flex items-center gap-4">
                    <div
                        class="h-12 w-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 text-xl">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Masa Berlaku</p>
                        <p class="text-sm font-black text-gray-800 js-detail-validity">---</p>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100/50">
                <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Deskripsi & Syarat</h4>
                <p class="text-sm font-bold text-gray-600 leading-relaxed js-detail-description">
                    ---
                </p>
            </div>
        </div>
    </main>

    <!-- Fixed Footer -->
    <div class="fixed bottom-0 left-0 right-0 p-6 bg-white/80 backdrop-blur-xl border-t border-gray-100 z-20">
        <button
            class="w-full h-16 bg-satset-green rounded-3xl font-black text-white btn-scale shadow-lg shadow-satset-green/20 flex items-center justify-center gap-3">
            GUNAKAN VOUCHER SEKARANG
        </button>
    </div>
</div>
