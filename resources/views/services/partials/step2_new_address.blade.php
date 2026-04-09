<template id="tpl-step-21">
    <div class="space-y-6 pb-20">
        <form id="newAddressForm" method="POST" action="{{ route('services.book.location', $kode) }}" class="space-y-6">
            @csrf
            <input type="hidden" name="date" id="formDate">
            <input type="hidden" name="time" id="formTime">

            <!-- Nama Lokasi -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Nama Lokasi (Contoh: Rumah, Kantor) <span
                        class="text-red-500">*</span></label>
                <input type="text" name="NamaLokasi" id="locNameInput" placeholder="Masukkan nama lokasi..."
                    class="h-14 rounded-[20px] border-gray-100 focus:ring-satset-green w-full px-5 border-2 bg-gray-50/50 font-bold text-gray-800"
                    required oninput="updateNewAddressData('title', this.value)" />
            </div>

            <!-- Pencarian Alamat -->
            {{-- <div class="space-y-2 relative">
                <label class="text-sm font-bold text-gray-700 ml-1">Cari Alamat</label>
                <div class="relative flex gap-2">
                    <div class="relative flex-1">
                        <input type="text" id="locSearchInput" placeholder="Ketik alamat atau nama tempat..."
                            class="h-14 rounded-[20px] border-gray-100 focus:ring-satset-green w-full px-5 border-2 bg-gray-50/50 font-bold text-gray-800"
                            onkeydown="if(event.key === 'Enter') { event.preventDefault(); searchAddress(this.value); }" />
                    </div>
                    <button type="button" onclick="searchAddress(document.getElementById('locSearchInput').value)"
                        class="h-14 w-14 flex items-center justify-center rounded-[20px] bg-satset-green text-white shadow-lg hover:bg-satset-dark transition-all flex-shrink-0">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="3">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>
                <!-- Search Results Dropdown -->
                <div id="searchSuggestions"
                    class="absolute z-[100] left-0 right-0 mt-1 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hidden">
                </div>
            </div> --}}

            <!-- Pin Lokasi (Map) -->
            {{-- <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Pin Lokasi</label>
                <div id="newAddressMap" class="h-64 rounded-[20px] shadow-inner border-2 border-gray-100 overflow-hidden"></div>
                <p class="text-[10px] text-gray-400 mt-1 ml-1 font-medium italic">*Geser pin untuk menyesuaikan lokasi tepatnya secara satset!</p>
            </div>

            <hr class="border-gray-100" /> --}}

            <!-- RT / RW -->
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">RT <span class="text-red-500">*</span></label>
                    <input type="number" name="RT" id="locRTInput" placeholder="001"
                        class="h-12 rounded-xl border-gray-100 w-full px-4 border-2 bg-gray-50/50 font-bold text-gray-800"
                        required oninput="updateNewAddressData('rt', this.value)" />
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">RW <span class="text-red-500">*</span></label>
                    <input type="number" name="RW" id="locRWInput" placeholder="001"
                        class="h-12 rounded-xl border-gray-100 w-full px-4 border-2 bg-gray-50/50 font-bold text-gray-800"
                        required oninput="updateNewAddressData('rw', this.value)" />
                </div>
            </div>

            <!-- Nama PIC / No HP PIC -->
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Nama PIC <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="namaPIC" id="picNameInput" placeholder="Nama penerima..."
                        class="h-12 rounded-xl border-gray-100 w-full px-4 border-2 bg-gray-50/50 font-bold text-gray-800"
                        required oninput="updateNewAddressData('namaPIC', this.value)" />
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">No HP PIC <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="noHpPIC" id="picPhoneInput" placeholder="0812..."
                        class="h-12 rounded-xl border-gray-100 w-full px-4 border-2 bg-gray-50/50 font-bold text-gray-800"
                        required oninput="updateNewAddressData('noHpPIC', this.value)" />
                </div>
            </div>

            <!-- Jenis Bangunan -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Jenis Bangunan <span
                        class="text-red-500">*</span></label>
                <input type="text" name="jenisBangunan" id="buildingTypeInput"
                    placeholder="Contoh: Rumah Tinggal, Ruko, dll"
                    class="h-12 rounded-xl border-gray-100 w-full px-4 border-2 bg-gray-50/50 font-bold text-gray-800"
                    required oninput="updateNewAddressData('jenisBangunan', this.value)" />
            </div>

            <!-- Detail Wilayah -->
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1 text-uppercase">Provinsi <span
                            class="text-red-500">*</span></label>
                    <select name="idProvince" id="provSelect" class="w-full" required></select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Kota/Kabupaten <span
                            class="text-red-500">*</span></label>
                    <select name="idRegencies" id="regSelect" class="w-full" required></select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Kecamatan <span
                            class="text-red-500">*</span></label>
                    <select name="idDistricts" id="distSelect" class="w-full" required></select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-500 ml-1">Kelurahan <span
                            class="text-red-500">*</span></label>
                    <select name="idVillages" id="villSelect" class="w-full" required></select>
                </div>
            </div>

            <!-- Full Address Area -->
            <div class="space-y-2">
                <label class="text-sm font-bold text-gray-700 ml-1">Alamat Lengkap <span
                        class="text-red-500">*</span></label>
                <textarea name="alamat" id="fullAddressArea" placeholder="Jl. Nama Jalan, No. Rumah, Patokan..."
                    class="min-h-[100px] rounded-[20px] border-gray-100 focus:ring-satset-green w-full p-5 border-2 bg-white font-medium text-gray-800 text-sm"
                    required oninput="updateNewAddressData('address', this.value)"></textarea>
            </div>

            <button type="submit" id="submitNewAddress" class="hidden"></button>
        </form>
    </div>
</template>
