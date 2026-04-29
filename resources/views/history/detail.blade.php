@extends('components.head')

@section('content')

    <body class="bg-gray-50 min-h-screen">
        <div class="flex min-h-screen flex-col">

            <!-- Header -->
            <header class="fixed top-0 z-30 w-full bg-white/80 backdrop-blur-md px-5 py-4 flex items-center shadow-sm">
                <a href="{{ route('history.index') }}" class="mr-4">
                    <button
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-800 hover:bg-gray-200 transition-all">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </button>
                </a>
                <h1 class="text-lg font-black text-gray-800 uppercase tracking-tight italic">Detail Pesanan</h1>
            </header>

            <main class="flex-1 pt-24 pb-32 px-5">

                <!-- Status Banner -->
                <div
                    class="bg-satset-green rounded-[30px] p-6 mb-6 text-white shadow-xl shadow-satset-green/20 relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">Status Saat Ini</p>
                        <h2 class="text-2xl font-black italic">{{ $order['status'] }}</h2>
                        <div class="mt-4 flex items-center gap-2">
                            <div class="h-2 flex-1 bg-white/20 rounded-full overflow-hidden">
                                <div class="h-full bg-white rounded-full w-[65%] shadow-[0_0_10px_rgba(255,255,255,0.5)]">
                                </div>
                            </div>
                            <span class="text-[10px] font-bold">65%</span>
                        </div>
                    </div>
                    <!-- Decoration -->
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                </div>

                <!-- Order Info -->
                <div class="bg-white rounded-[28px] p-6 mb-6 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span
                                class="text-[7px] font-black uppercase tracking-widest text-gray-400 block mb-1">#{{ $order['code'] }}</span>
                            <h3 class="text-xl font-black text-gray-800">{{ $order['service'] }}</h3>
                            <p class="text-xs text-gray-500 font-medium">{{ $order['job_type'] ?? 'Layanan SatSet' }} •
                                {{ $order['staff_count'] ?? 1 }} Personel</p>
                        </div>
                        <div class="h-12 w-12 bg-gray-50 rounded-2xl flex items-center justify-center text-satset-green">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                </path>
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-dashed border-gray-100">
                        <div>
                            <p class="text-[10px] uppercase font-black text-gray-400 tracking-wider">Tanggal & Waktu</p>
                            <p class="text-sm font-bold text-gray-800 mt-1">{{ $order['date'] }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-black text-gray-400 tracking-wider">Metode Bayar</p>
                            <p class="text-sm font-bold text-gray-800 mt-1 truncate">{{ $order['payment_method'] ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <div>
                            <p class="text-[10px] uppercase font-black text-gray-400 tracking-wider">Lokasi
                                Pengerjaan</p>
                            <p class="text-sm font-bold text-gray-800 mt-1">
                                {{ $order['location'] ?? 'Jalan Telomoyo' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Ranger Profile -->
                @if (isset($order['ranger']))
                    <div class="bg-white rounded-[28px] p-5 mb-6 shadow-sm border border-gray-100 flex items-center gap-4">
                        <div
                            class="h-14 w-14 rounded-full bg-gray-100 flex items-center justify-center text-2xl shadow-inner">
                            {{ $order['ranger']['photo'] }}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-black text-gray-800">{{ $order['ranger']['name'] }}</h4>
                            <div class="flex items-center gap-1 text-xs text-amber-500 font-black">
                                <span>⭐</span> {{ $order['ranger']['rating'] }} <span
                                    class="text-gray-400 font-medium font-sans">• SatSet Ranger</span>
                            </div>
                        </div>
                        <button
                            class="bg-gray-100 p-3 rounded-2xl text-satset-green hover:bg-satset-green hover:text-white transition-colors">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </button>
                    </div>
                @else
                    <div class="bg-amber-50 rounded-[28px] p-5 mb-6 border border-amber-100 flex items-center gap-4">
                        <div class="h-14 w-14 rounded-full bg-white flex items-center justify-center text-2xl shadow-sm">
                            🕵️
                        </div>
                        <div class="flex-1">
                            <h4 class="font-black text-amber-800">Mencari Ranger...</h4>
                            <p class="text-[10px] text-amber-600 font-bold uppercase tracking-widest">Sistem sedang
                                mencarikan Ranger terbaik untukmu</p>
                        </div>
                    </div>
                @endif

                <!-- Timeline -->
                <div class="mb-6">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest mb-4 px-1">Lini Masa Pesanan</h3>
                    <div class="bg-white rounded-[28px] p-6 shadow-sm border border-gray-100 space-y-6">
                        @foreach ($order['timeline'] as $step)
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center">
                                    <div
                                        class="h-5 w-5 rounded-full {{ $step['done'] ? 'bg-satset-green' : 'bg-gray-200' }} flex items-center justify-center">
                                        @if ($step['done'])
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                stroke="white" stroke-width="4" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        @endif
                                    </div>
                                    @if (!$loop->last)
                                        <div
                                            class="w-0.5 flex-1 {{ $step['done'] ? 'bg-satset-green/30' : 'bg-gray-100' }} my-1">
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 pb-2">
                                    <p class="text-[10px] font-black text-gray-400">{{ $step['time'] }}</p>
                                    <p class="text-sm font-bold {{ $step['done'] ? 'text-gray-800' : 'text-gray-400' }}">
                                        {{ $step['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pricing -->
                <div
                    class="bg-white rounded-[28px] p-6 mb-6 shadow-md border border-gray-100 border-t-4 border-t-satset-green">
                    <h3 class="text-xs font-black text-gray-800 uppercase tracking-widest mb-4">Rincian Pembayaran</h3>
                    <div class="space-y-3">
                        @foreach ($order['price_details'] as $detail)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">{{ $detail['label'] }}</span>
                                <span class="font-bold {{ $detail['value'] < 0 ? 'text-red-500' : 'text-gray-800' }}">
                                    {{ $detail['value'] < 0 ? '-' : '' }}Rp{{ number_format(abs($detail['value'] ?? 0), 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                        <div class="pt-4 mt-2 border-t border-dashed border-gray-200 flex justify-between items-center">
                            <span class="font-black text-gray-800 italic uppercase">Total Bayar</span>
                            <span
                                class="text-xl font-black text-satset-green">Rp{{ number_format($order['total_price'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

            </main>

            <!-- Footer Action -->
            <div
                class="fixed bottom-0 left-0 right-0 bg-white/80 backdrop-blur-md p-5 border-t border-gray-100 flex gap-3">
                <button
                    class="flex-1 h-14 bg-gray-100 text-gray-800 font-black uppercase tracking-widest text-[10px] rounded-2xl active:scale-95 transition-transform">
                    Butuh Bantuan?
                </button>
                <a href="{{ route('services.book', $order['service_code']) }}?duration={{ $order['duration'] }}&staffCount={{ $order['staff_count'] }}" class="flex-1">
                    <button
                        class="w-full h-14 bg-satset-green text-white font-black uppercase tracking-widest text-[10px] rounded-2xl shadow-lg shadow-satset-green/30 active:scale-95 transition-transform">
                        Pesan Lagi
                    </button>
                </a>
            </div>

        </div>
    </body>
@endsection
