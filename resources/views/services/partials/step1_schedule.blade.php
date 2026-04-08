<template id="tpl-step-1">
    <div class="space-y-6">
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Pilih Tanggal
                </h3>
                <div class="flex items-center gap-3">
                    <button onclick="changeMonth(-1)" class="p-1.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <span id="calendarMonth" class="font-bold text-gray-800 text-sm w-24 text-center"></span>
                    <button onclick="changeMonth(1)" class="p-1.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
            </div>
            
            <div class="bg-gray-50/50 p-4 rounded-[24px] border-2 border-gray-100">
                <div id="calendarHeader" class="grid grid-cols-7 gap-1 mb-2">
                    <!-- Days names will be injected by JS -->
                </div>
                <div id="calendarDays" class="grid grid-cols-7 gap-1.5">
                    <!-- Days buttons will be injected by JS -->
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                Pilih Jam
            </h3>
            <div id="timeGrid" class="grid grid-cols-2 gap-3">
                <!-- Time slots will be injected by JS -->
            </div>
        </div>
    </div>
</template>
