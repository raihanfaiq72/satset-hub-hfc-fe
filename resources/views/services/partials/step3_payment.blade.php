<template id="tpl-step-3">
    <div class="space-y-6">
        <div class="border-none bg-gray-50 rounded-[32px] overflow-hidden shadow-inner">
            <div class="p-6 space-y-4">
                <h3 class="font-black text-gray-800 text-lg">Ringkasan Pesanan</h3>
                <div class="space-y-3 border-b border-dashed border-gray-300 pb-5">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Layanan</span>
                        <span class="font-bold text-gray-800">Token Listrik</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Waktu</span>
                        <span id="summaryTime" class="font-bold text-gray-800 text-right"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400 font-medium">Lokasi</span>
                        <span id="summaryLocation" class="font-bold text-gray-800 text-right truncate max-w-[150px]"></span>
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-2">
                    <span class="font-bold text-gray-800">Total Bayar</span>
                    <span class="text-2xl font-black text-satset-green">Rp52.500</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col items-center gap-4 py-4">
            <div class="qr-container p-5 bg-white rounded-[32px] border-4 border-gray-50">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=SATSET-PAY" alt="QRIS" class="w-52 h-52" />
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">
                Silakan Scan QRIS Di Atas<br/>Untuk Menyelesaikan Pembayaran
            </p>
        </div>
    </div>
</template>
