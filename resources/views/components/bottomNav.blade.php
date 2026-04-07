<nav class="bottom-nav fixed bottom-0 left-0 right-0 border-t border-gray-200 bg-white/95">
    <div class="flex justify-around items-center py-2">

        <!-- Home -->
        <a href="{{ url('/dashboard') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('dashboard') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ request()->is('/dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span class="text-xs font-medium">Beranda</span>
        </a>

        <!-- Services -->
        <a href="{{ url('/services') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('services*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="3" width="7" height="7"></rect>
                <rect x="14" y="3" width="7" height="7"></rect>
                <rect x="14" y="14" width="7" height="7"></rect>
                <rect x="3" y="14" width="7" height="7"></rect>
            </svg>
            <span class="text-xs font-medium">Layanan</span>
        </a>

        <!-- History -->
        <a href="{{ url('/history') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('history*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <polyline points="12 6 12 12 16 14"></polyline>
            </svg>
            <span class="text-xs font-medium">Riwayat</span>
        </a>

        <!-- Profile -->
        <a href="{{ url('/profile') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('profile*') ? 'text-satset-green' : 'text-gray-400 hover:text-satset-green' }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span class="text-xs font-medium">Profil</span>
        </a>

    </div>
</nav>