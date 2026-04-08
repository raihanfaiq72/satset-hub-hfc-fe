<div class="voucher-card border-none shadow-md rounded-[28px] overflow-hidden bg-satset-green text-white">
    <div class="p-0 flex h-28">
        <div class="w-28 flex flex-col items-center justify-center border-r-2 border-dashed border-white/20">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2">
                </rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span class="text-[8px] font-black uppercase tracking-widest mt-2">payment</span>
        </div>
        <div class="flex-1 p-4 flex flex-col justify-center">
            <p class="text-[10px] text-white/70 mb-1 font-bold">{{ $userPaymentVoucher['voucher_code'] }}</p>
            <h4 class="font-black text-lg leading-none">{{ $userPaymentVoucher['batch_info']['voucher_name'] }}</h4>
            <div class="mt-1 inline-block">
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-white text-satset-green">
                    Detail
                </span>
            </div>
        </div>
    </div>
</div>
