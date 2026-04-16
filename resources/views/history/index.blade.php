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
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
            </header>

            <main class="flex-1 px-5 pb-24">
                <div class="w-full">
                    <div class="grid w-full grid-cols-2 bg-gray-100 rounded-[24px] h-14 p-1.5 mt-3 mb-5 shadow-inner">
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
                        <!-- Past Tab -->
                        <div id="content-past" class="space-y-4">
                            @forelse ($pastOrders as $order)
                                @include('history.partials.order-card', ['order' => $order])
                            @empty
                                <div class="py-20 text-center">
                                    <div class="text-4xl mb-4">📭</div>
                                    <p class="text-gray-500 font-bold">Belum ada pesanan lampau.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Current & Future Tab -->
                        <div id="content-current" class="space-y-4 hidden">
                            @forelse ($currentOrders as $order)
                                @include('history.partials.order-card', ['order' => $order])
                            @empty
                                <div class="py-20 text-center">
                                    <div class="text-4xl mb-4">🚀</div>
                                    <p class="text-gray-500 font-bold">Tidak ada pesanan aktif saat ini.</p>
                                </div>
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
                color: #2d7a6e;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            }
        </style>
    </body>
@endsection
