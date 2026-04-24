@php
    $isUsed = !empty($userPaymentVoucher['used_at']);
    $validUntil = !empty($userPaymentVoucher['batch_info']['valid_until']) ? \Carbon\Carbon::parse($userPaymentVoucher['batch_info']['valid_until']) : null;
    $isExpired = $validUntil && $validUntil->isPast();
    $isInactive = $isUsed || $isExpired;
@endphp

<div class="voucher-card border-none shadow-md rounded-[28px] overflow-hidden {{ $isInactive ? 'bg-gray-400 grayscale' : 'bg-satset-green' }} text-white"
    onclick="openVoucherDetail({{ $userPaymentVoucher['id'] }})">
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
            <div class="flex items-center justify-between">
                <p class="text-[10px] text-white/70 mb-1 font-bold">{{ $userPaymentVoucher['voucher_code'] }}</p>
                @if ($isUsed)
                    <span class="text-[8px] font-black px-2 py-0.5 rounded-full bg-white text-gray-500 mb-1">TERPAKAI</span>
                @elseif($isExpired)
                    <span class="text-[8px] font-black px-2 py-0.5 rounded-full bg-red-500 text-white mb-1">EXPIRED</span>
                @endif
            </div>
            <h4 class="font-black text-lg leading-none">{{ $userPaymentVoucher['batch_info']['voucher_name'] }}</h4>
            <div class="mt-1 inline-block">
                <span onclick="openVoucherDetail({{ $userPaymentVoucher['id'] }})"
                    class="text-[10px] font-black px-2 py-0.5 rounded-full bg-white {{ $isInactive ? 'text-gray-500' : 'text-satset-green' }} cursor-pointer active:scale-95 transition-transform inline-block">
                    Detail
                </span>
            </div>
        </div>
    </div>
</div>
