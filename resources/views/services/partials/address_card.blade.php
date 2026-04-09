<label
    class="address-card flex items-center gap-4 p-5 rounded-2xl border-2 cursor-pointer transition-all border-gray-100 bg-white shadow-sm hover:border-satset-green/30 has-[:checked]:border-satset-green has-[:checked]:bg-satset-green/5">
    <input type="radio" name="addressSelection" value="{{ $value }}" class="radio-custom"
        {{ $isSelected ?? false ? 'checked' : '' }} onchange="selectAddress('{{ $value }}')">

    <div class="flex-1">
        <div class="flex items-center gap-2 mb-1">
            <span class="addr-icon p-1.5 rounded-lg bg-satset-green/10 flex items-center justify-center">
                @if (($icon ?? '') == 'home')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" class="text-satset-green">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                @elseif(($icon ?? '') == 'plus')
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" class="text-satset-green">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                @else
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5" class="text-satset-green">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                @endif
            </span>
            <span class="addr-title font-bold text-gray-800 text-sm">{{ $title }}</span>
        </div>
        @if (isset($desc) && $desc)
            <p class="addr-desc text-[11px] text-gray-500 line-clamp-2 leading-tight">
                {{ $desc }}
            </p>
        @endif
    </div>
</label>

<style>
    .address-card input:checked~.flex-shrink-0 .selection-indicator {
        border-color: #10b981;
    }

    .address-card input:checked~.flex-shrink-0 .selection-dot {
        opacity: 1;
    }
</style>
