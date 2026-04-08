<nav class="bottom-nav fixed bottom-0 left-0 right-0 border-t border-gray-200 bg-white/95 z-50">
    <div class="flex justify-around items-center py-2">

        <a href="{{ url('/dashboard') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('dashboard') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ request()->is('dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span class="text-xs font-medium">Beranda</span>
        </a>

        <a href="{{ url('/services') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('services*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span class="text-xs font-medium">Layanan</span>
        </a>

        <a href="{{ url('/history') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('history*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span class="text-xs font-medium">Riwayat</span>
        </a>

        <div class="relative flex flex-col items-center gap-1 p-2">
            <button id="profileBtn" class="flex flex-col items-center gap-1 focus:outline-none text-gray-400 hover:text-satset-green {{ request()->is('profile*') ? 'text-satset-green' : '' }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span class="text-xs font-medium">Profil</span>
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