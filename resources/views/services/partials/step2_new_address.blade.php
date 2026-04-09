<template id="tpl-step-21">
    <div class="space-y-6 pb-20">
        <!-- Nama Lokasi -->
        <div class="space-y-2">
            <label class="text-sm font-bold text-gray-700 ml-1">Nama Lokasi (Contoh: Rumah, Kantor)</label>
            <input 
                type="text" 
                id="locNameInput"
                placeholder="Masukkan nama lokasi..."
                class="h-14 rounded-[20px] border-gray-100 focus:ring-satset-green w-full px-5 border-2 bg-gray-50/50 font-bold text-gray-800"
                oninput="updateNewAddressData('title', this.value)"
            />
        </div>

        <!-- Pencarian Alamat -->
        <div class="space-y-2 relative">
            <label class="text-sm font-bold text-gray-700 ml-1">Cari Alamat</label>
            <div class="relative">
                <input 
                    type="text" 
                    id="locSearchInput"
                    placeholder="Ketik alamat atau nama tempat..."
                    class="h-14 rounded-[20px] border-gray-100 focus:ring-satset-green w-full px-5 pr-12 border-2 bg-gray-50/50 font-bold text-gray-800"
                    oninput="searchAddress(this.value)"
                />
                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>
            </div>
            <!-- Search Results Dropdown -->
            <div id="searchSuggestions" class="absolute z-[100] left-0 right-0 mt-1 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden hidden">
                <!-- Suggestions will be injected here -->
            </div>
        </div>

        <!-- Pin Lokasi (Map) -->
        <div class="space-y-2">
            <label class="text-sm font-bold text-gray-700 ml-1">Pin Lokasi</label>
            <div id="newAddressMap" class="shadow-inner border-2 border-gray-100"></div>
            <p class="text-[10px] text-gray-400 mt-1 ml-1 font-medium italic">*Geser pin untuk menyesuaikan lokasi tepatnya secara satset!</p>
        </div>

        <hr class="border-gray-100 italic" />

        <!-- Detail Wilayah -->
        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 ml-1 text-uppercase">Provinsi</label>
                <select id="provSelect" onchange="onProvinceChange(this.value)" class="h-12 rounded-xl border-gray-100 w-full px-3 border-2 bg-white text-sm font-bold text-gray-800">
                    <option value="">Pilih Provinsi</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 ml-1">Kota/Kabupaten</label>
                <select id="regSelect" onchange="onRegencyChange(this.value)" class="h-12 rounded-xl border-gray-100 w-full px-3 border-2 bg-white text-sm font-bold text-gray-800 disabled:opacity-50" disabled>
                    <option value="">Pilih Kota</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 ml-1">Kecamatan</label>
                <select id="distSelect" onchange="onDistrictChange(this.value)" class="h-12 rounded-xl border-gray-100 w-full px-3 border-2 bg-white text-sm font-bold text-gray-800 disabled:opacity-50" disabled>
                    <option value="">Pilih Kecamatan</option>
                </select>
            </div>
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-500 ml-1">Kelurahan</label>
                <select id="villSelect" onchange="onVillageChange(this.value)" class="h-12 rounded-xl border-gray-100 w-full px-3 border-2 bg-white text-sm font-bold text-gray-800 disabled:opacity-50" disabled>
                    <option value="">Pilih Kelurahan</option>
                </select>
            </div>
        </div>

        <!-- Full Address Area -->
        <div class="space-y-2">
            <label class="text-sm font-bold text-gray-700 ml-1">Alamat Lengkap</label>
            <textarea 
                id="fullAddressArea"
                placeholder="Jl. Nama Jalan, No. Rumah, Patokan..."
                class="min-h-[100px] rounded-[20px] border-gray-100 focus:ring-satset-green w-full p-5 border-2 bg-gray-50/50 font-medium text-gray-800 text-sm"
                oninput="updateNewAddressData('address', this.value)"
            ></textarea>
        </div>
    </div>
</template>
