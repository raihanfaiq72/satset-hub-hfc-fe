<template id="tpl-step-1">
    <div class="space-y-6">
        <!-- Lama Pengerjaan -->
        <div class="space-y-4">
            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Lama Pengerjaan
            </h3>
            <div class="grid grid-cols-2 gap-3">
                <button type="button" onclick="selectDuration(3)" id="duration-3" 
                    class="duration-btn p-4 rounded-2xl border-2 font-black text-center transition-all">
                    3 Jam
                </button>
                <button type="button" onclick="selectDuration(6)" id="duration-6" 
                    class="duration-btn p-4 rounded-2xl border-2 font-black text-center transition-all">
                    6 Jam
                </button>
            </div>
        </div>

        <!-- Banyak Petugas -->
        <div class="space-y-4">
            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Banyak Petugas
            </h3>
            <div class="flex items-center justify-between bg-gray-50/50 p-4 rounded-2xl border-2 border-gray-100">
                <div class="text-gray-500 font-bold">Jumlah Personil</div>
                <div class="flex items-center gap-4">
                    <button type="button" id="staffMinus" onclick="updateStaffCount(-1)" class="h-10 w-10 flex items-center justify-center rounded-xl bg-white border-2 border-gray-100 text-gray-600 shadow-sm active:scale-95">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <span id="staffCountDisplay" class="text-xl font-black text-gray-800 w-6 text-center">1</span>
                    <button type="button" id="staffPlus" onclick="updateStaffCount(1)" class="h-10 w-10 flex items-center justify-center rounded-xl bg-satset-green text-white shadow-md active:scale-95">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Jadwal -->
        <div class="space-y-4">
            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-satset-green">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Jadwal Pengerjaan
            </h3>
            
            <button type="button" onclick="showCalendarModal()" class="w-full flex items-center justify-between bg-white p-5 rounded-2xl border-2 border-gray-100 hover:border-satset-green transition-all shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 bg-satset-green/10 rounded-xl flex items-center justify-center text-satset-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tanggal</p>
                        <p id="selectedDateDisplay" class="font-black text-gray-800">Pilih Tanggal</p>
                    </div>
                </div>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="text-gray-300">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>

            <div id="timeGrid" class="grid grid-cols-4 gap-2">
                <!-- Time slots will be injected by JS -->
            </div>
        </div>
    </div>
</template>
