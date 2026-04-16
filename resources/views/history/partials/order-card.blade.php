@php
    $type = $order['type'] ?? 'Past'; // Past, Present, Future
    $id = $order['code'] ?? 'ORD-000';
    $service = $order['service'] ?? 'Layanan';
    $jobType = $order['job_type'] ?? 'Jenis Pekerjaan';
    
    $statusConfig = [
        'Past' => [
            'icon' => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>',
            'bg' => 'bg-green-50',
            'text' => 'text-green-600',
            'label' => 'Past'
        ],
        'Present' => [
            'icon' => '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>',
            'bg' => 'bg-amber-50',
            'text' => 'text-amber-600',
            'label' => 'Present'
        ],
        'Future' => [
            'icon' => '<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>',
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-600',
            'label' => 'Future'
        ]
    ];
    
    $config = $statusConfig[$type] ?? $statusConfig['Past'];
@endphp

<div class="history-card bg-white rounded-[28px] border border-gray-100 shadow-sm p-4 flex items-center gap-4 transition-all hover:shadow-md active:scale-[0.98]">
    <!-- Icon Left -->
    <div class="h-14 w-14 rounded-2xl {{ $config['bg'] }} flex items-center justify-center {{ $config['text'] }} shrink-0">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            {!! $config['icon'] !!}
        </svg>
    </div>

    <!-- Content Center -->
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 mb-0.5">
            <span class="text-[7px] font-black uppercase tracking-widest text-gray-400">#{{ $id }}</span>
            <span class="px-2 py-0.5 rounded-full text-[8px] font-bold uppercase tracking-tighter {{ $config['bg'] }} {{ $config['text'] }}">
                {{ $config['label'] }}
            </span>
        </div>
        <h4 class="text-base font-bold text-gray-800 truncate leading-tight">{{ $service }}</h4>
        <p class="text-[11px] text-gray-500 font-medium truncate mt-0.5">{{ $jobType }}</p>
    </div>

    <!-- Action Right -->
    <div class="shrink-0">
        <a href="{{ route('history.show') }}">
            <button
                class="bg-satset-green text-white text-[10px] font-black uppercase tracking-widest px-4 py-2.5 rounded-xl shadow-lg shadow-satset-green/20 active:scale-95 transition-transform">
                Detail
            </button>
        </a>
    </div>
</div>
