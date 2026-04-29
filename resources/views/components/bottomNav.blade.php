<nav class="bottom-nav fixed bottom-0 left-0 right-0 border-t border-gray-200 bg-white/95 z-50">
    <div class="flex justify-around items-center py-2">

        <a href="{{ url('/dashboard') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('dashboard') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ request()->is('dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22" stroke="{{ request()->is('dashboard') ? 'white' : 'currentColor' }}" fill="none"></polyline>
            </svg>
            <span class="text-[10px] font-black uppercase tracking-tighter {{ request()->is('dashboard') ? '' : 'opacity-60' }}">Beranda</span>
        </a>

        <a href="{{ url('/services') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('services*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ request()->is('services*') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span class="text-[10px] font-black uppercase tracking-tighter {{ request()->is('services*') ? '' : 'opacity-60' }}">Layanan</span>
        </a>

        <a href="{{ url('/history') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('history*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ request()->is('history*') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14" stroke="{{ request()->is('history*') ? 'white' : 'currentColor' }}" fill="none"></polyline>
            </svg>
            <span class="text-[10px] font-black uppercase tracking-tighter {{ request()->is('history*') ? '' : 'opacity-60' }}">Riwayat</span>
        </a>

        <div class="relative flex flex-col items-center gap-1 p-2">
            <button id="profileBtn" class="flex flex-col items-center gap-1 focus:outline-none {{ request()->is('profile*') || request()->is('voucher*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
                @if(request()->is('voucher*'))
                    <svg width="24" height="24" viewBox="0 0 32 32" fill="none" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xmlns="http://www.w3.org/2000/svg">
                        <g transform="matrix(1,0,0,1,-48,-240)">
                            <path d="M77,253C75.344,253 74,254.344 74,256C74,257.656 75.344,259 77,259L77,263C77,264.105 76.105,265 75,265C70.157,265 57.843,265 53,265C51.895,265 51,264.105 51,263C51,261.255 51,259 51,259C52.656,259 54,257.656 54,256C54,254.344 52.656,253 51,253L51,249C51,247.895 51.895,247 53,247C57.843,247 70.157,247 75,247C76.105,247 77,247.895 77,249C77,250.745 77,253 77,253Z" fill="currentColor"></path>
                            <path d="M77,254C77.552,254 78,253.552 78,253L78,249C78,247.343 76.657,246 75,246L53,246C51.343,246 50,247.343 50,249L50,253C50,253.552 50.448,254 51,254C52.104,254 53,254.896 53,256C53,257.104 52.104,258 51,258C50.448,258 50,258.448 50,259L50,263C50,264.657 51.343,266 53,266L75,266C76.657,266 78,264.657 78,263L78,259C77.99,258.412 77.628,258.103 77,258C75.896,258 75,257.104 75,256C75,254.896 75.896,254 77,254ZM70,248L70,250C70,250.552 69.552,251 69,251C68.448,251 68,250.552 68,250L68,248L53,248C52.448,248 52,248.448 52,249C52,249 52,252.126 52,252.126C53.724,252.571 55,254.137 55,256C55,257.863 53.724,259.429 52,259.874C52,259.874 52,263 52,263C52,263.552 52.448,264 53,264L68,264L68,262C68,261.448 68.448,261 69,261C69.552,261 70,261.448 70,262L70,264C70,264 75,264 75,264C75.552,264 76,263.552 76,263L76,259.874C74.276,259.429 73,257.862 73,256C73,254.137 74.276,252.571 76,252.126L76,249C76,248.448 75.552,248 75,248L70,248ZM68,254L68,258C68,258.552 68.448,259 69,259C69.552,259 70,258.552 70,258L70,254C70,253.448 69.552,253 69,253C68.448,253 68,253.448 68,254Z" fill="white"></path>
                        </g>
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-tighter">Voucher</span>
                @else
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ request()->is('profile*') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4" fill="{{ request()->is('profile*') ? 'white' : 'none' }}" stroke="{{ request()->is('profile*') ? 'white' : 'currentColor' }}" stroke-width="2"></circle>
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-tighter {{ request()->is('profile*') ? '' : 'opacity-60' }}">Profil</span>
                @endif
            </button>

            <div id="profileMenu" class="absolute bottom-14 flex flex-col w-40 bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden hidden">
                <a href="{{ url('/profile') }}" class="px-4 py-3 hover:bg-gray-100 text-gray-700 text-sm font-medium">Profil</a>
                <a href="{{ url('/voucher') }}" class="px-4 py-3 hover:bg-gray-100 text-gray-700 text-sm font-medium">Voucher</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 hover:bg-gray-100 text-gray-700 text-sm font-medium">Logout</button>
                </form>
            </div>
        </div>

    </div>
</nav>

<script>
    const profileBtn = document.getElementById('profileBtn');
    const profileMenu = document.getElementById('profileMenu');

    profileBtn.addEventListener('click', () => {
        profileMenu.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
            profileMenu.classList.add('hidden');
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            profileMenu.classList.add('hidden');
        }
    });
</script>