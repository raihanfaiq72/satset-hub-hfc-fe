@extends('components.head')

@section('content')
    <body class="bg-gray-50 min-h-screen">
        <div id="historyPage" class="flex min-h-screen flex-col">
            <header class="bg-white px-5 py-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-gray-800 italic uppercase tracking-tighter">Riwayat Pesanan</h1>
                    <p class="text-sm text-gray-500 mt-1">Lihat pesanan lampau dan pesanan yang sedang berjalan.</p>
                </div>
                <div class="h-10 w-10 bg-satset-green/10 rounded-full flex items-center justify-center text-satset-green">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
            </header>

            <main class="flex-1 px-5 pb-24">
                <div class="w-full">
                    <div class="grid w-full grid-cols-2 bg-gray-100 rounded-[24px] h-14 p-1.5 mb-8 shadow-inner">
                        <button onclick="switchTab('past')" id="tab-past"
                            class="tab-btn rounded-[20px] font-black text-[10px] uppercase tracking-widest active">
                            Pesanan Lampau
                        </button>
                        <button onclick="switchTab('current')" id="tab-current"
                            class="tab-btn rounded-[20px] font-black text-[10px] uppercase tracking-widest">
                            Sekarang
                        </button>
                    </div>

                    <div id="tabContent" class="tab-content">
                        <div id="content-past" class="space-y-4">
                            @forelse ($pastOrders as $order)
                                <div class="history-card bg-white rounded-[28px] border border-gray-100 shadow-sm overflow-hidden">
                                    <div class="p-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="min-w-0">
                                                <p class="text-[10px] uppercase tracking-[0.2em] font-black text-satset-green">{{ $order['code'] }}</p>
                                                <h3 class="text-xl font-black text-gray-800 mt-2">{{ $order['service'] }}</h3>
                                                <p class="text-sm text-gray-500 mt-1">{{ $order['vendor'] }}</p>
                                            </div>
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-bold {{ $order['status'] === 'Selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ $order['status'] }}
                                            </span>
                                        </div>

                                        <div class="mt-5 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                            <div>
                                                <p class="font-bold text-gray-800">Tanggal</p>
                                                <p class="mt-1">{{ $order['date'] }}</p>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">Total</p>
                                                <p class="mt-1">Rp{{ number_format($order['price'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500">Belum ada pesanan lampau.</p>
                            @endforelse
                        </div>

                        <div id="content-current" class="space-y-4 hidden">
                            @forelse ($currentOrders as $order)
                                <div class="history-card bg-white rounded-[28px] border border-gray-100 shadow-sm overflow-hidden">
                                    <div class="p-5">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="min-w-0">
                                                <p class="text-[10px] uppercase tracking-[0.2em] font-black text-satset-green">{{ $order['code'] }}</p>
                                                <h3 class="text-xl font-black text-gray-800 mt-2">{{ $order['service'] }}</h3>
                                                <p class="text-sm text-gray-500 mt-1">{{ $order['vendor'] }}</p>
                                            </div>
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[11px] font-bold {{ $order['status'] === 'Dalam Proses' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                                {{ $order['status'] }}
                                            </span>
                                        </div>

                                        <div class="mt-5 grid grid-cols-2 gap-4 text-sm text-gray-600">
                                            <div>
                                                <p class="font-bold text-gray-800">Tanggal</p>
                                                <p class="mt-1">{{ $order['date'] }}</p>
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-800">Total</p>
                                                <p class="mt-1">Rp{{ number_format($order['price'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-gray-500">Tidak ada pesanan aktif saat ini.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </main>

            @include('components.bottomNav')
        </div>

        <script>
            function switchTab(tab) {
                const past = document.getElementById('content-past');
                const current = document.getElementById('content-current');
                const tabPast = document.getElementById('tab-past');
                const tabCurrent = document.getElementById('tab-current');

                if (tab === 'current') {
                    past.classList.add('hidden');
                    current.classList.remove('hidden');
                    tabPast.classList.remove('active');
                    tabCurrent.classList.add('active');
                } else {
                    current.classList.add('hidden');
                    past.classList.remove('hidden');
                    tabCurrent.classList.remove('active');
                    tabPast.classList.add('active');
                }
            }
        </script>

        <style>
            .tab-btn {
                transition: all 0.25s ease;
                background: transparent;
                color: #9ca3af;
            }

            .tab-btn.active {
                background: white;
                color: #14532d;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            }

            .history-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .history-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
            }
        </style>
    </body>
@endsection
