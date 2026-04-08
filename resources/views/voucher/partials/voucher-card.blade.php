<div class="voucher-card border-none shadow-sm rounded-[32px] overflow-hidden bg-white"
    onclick="openPayment({id: {{ $voucher['id'] }}, title: '{{ $voucher['batch_name'] }}', price: {{ $voucher['selling_price'] }}})">
    <div class="relative h-28 w-full bg-gray-100">
        <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
            </svg>
        </div>
        <div
            class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded-full shadow-sm text-[8px] font-black text-satset-green">
            BEST SELLER
        </div>
    </div>
    <div class="p-4 space-y-2">
        <h4 class="font-black text-gray-800 text-xs leading-tight">{{ $voucher['batch_name'] }}</h4>
        <p class="text-sm font-black text-satset-green">Rp{{ number_format($voucher['selling_price'], 0, ',', '.') }}
        </p>
        <button
            class="w-full py-2 rounded-xl text-[9px] text-white font-bold bg-satset-green hover:bg-gray-300 hover:text-black transition-all uppercase">Beli
        </button>
    </div>
</div>
