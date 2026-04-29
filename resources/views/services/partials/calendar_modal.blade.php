<div id="calendarModal" class="fixed inset-0 z-[60] flex items-center justify-center p-6 hidden">
    <div class="modal-backdrop absolute inset-0 bg-black/60" onclick="hideCalendarModal()"></div>
    <div class="relative bg-white rounded-[32px] border-none p-6 shadow-2xl max-w-md w-full animate-zoom-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-black text-gray-800">Pilih Tanggal</h3>
            <button onclick="hideCalendarModal()" class="h-8 w-8 flex items-center justify-center rounded-full bg-gray-50 text-gray-400">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="space-y-4">
            <div class="flex items-center justify-between px-2">
                <span id="modalCalendarMonth" class="font-black text-gray-800 text-lg"></span>
                <div class="flex items-center gap-2">
                    <button id="modalPrevMonthBtn" onclick="changeMonth(-1)" class="p-2 rounded-xl bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <button onclick="changeMonth(1)" class="p-2 rounded-xl bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
            </div>
            
            <div class="bg-gray-50/50 p-4 rounded-[28px] border-2 border-gray-100">
                <div id="modalCalendarHeader" class="grid grid-cols-7 gap-1 mb-3">
                    <!-- Days names will be injected by JS -->
                </div>
                <div id="modalCalendarDays" class="grid grid-cols-7 gap-2">
                    <!-- Days buttons will be injected by JS -->
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button onclick="hideCalendarModal()" class="w-full h-14 bg-satset-green text-white font-black rounded-2xl shadow-lg shadow-satset-green/20">
                PILIH TANGGAL INI
            </button>
        </div>
    </div>
</div>
