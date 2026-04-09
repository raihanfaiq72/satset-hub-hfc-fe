<script>
    let mapInstance = null;
    let markerInstance = null;
    let tsProv, tsReg, tsDist, tsVill;
    let searchTimer = null;

    function updateNewAddressData(key, value) {
        orderData.newAddress[key] = value;
        console.log('Updated newAddress:', key, value);
    }

    function initNewAddressMap() {
        const container = document.getElementById('newAddressMap');
        if (!container) return;

        if (mapInstance) {
            mapInstance.remove();
        }

        // Initialize map centered on current marker position or default
        const lat = orderData.newAddress.lat || -7.0083;
        const lng = orderData.newAddress.lng || 110.4179;

        mapInstance = L.map('newAddressMap').setView([lat, lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mapInstance);

        markerInstance = L.marker([lat, lng], {
            draggable: true
        }).addTo(mapInstance);

        markerInstance.on('dragend', function(e) {
            const pos = markerInstance.getLatLng();
            orderData.newAddress.lat = pos.lat;
            orderData.newAddress.lng = pos.lng;
            reverseGeocode(pos.lat, pos.lng);
        });
    }

    async function searchAddress(query) {
        if (!query) return;
        const suggestionsBox = document.getElementById('searchSuggestions');
        if (!suggestionsBox) return;

        try {
            // Using backend proxy to comply with policy and set User-Agent
            const response = await fetch(
                `http://127.0.0.1:8000/api/proxy/search?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'Authorization': 'Bearer ' + '{{ $api_token }}'
                    }
                }
            );
            const data = await response.json();

            if (data && data.length > 0) {
                suggestionsBox.innerHTML = data.map(item => `
                    <div class="px-5 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0" onclick="onSelectSuggestion('${item.display_name.replace(/'/g, "\\'")}', ${item.lat}, ${item.lon})">
                        <p class="text-sm font-bold text-gray-800 line-clamp-1">${item.display_name.split(',')[0]}</p>
                        <p class="text-[10px] text-gray-400 line-clamp-1">${item.display_name}</p>
                    </div>
                `).join('');
                suggestionsBox.classList.remove('hidden');
            } else {
                suggestionsBox.innerHTML =
                    '<div class="px-5 py-3 text-sm text-gray-400">Tidak ada hasil ditemukan</div>';
                suggestionsBox.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Search error:', error);
        }
    }

    function onSelectSuggestion(display_name, lat, lon) {
        const input = document.getElementById('locSearchInput');
        const suggestionsBox = document.getElementById('searchSuggestions');

        if (input) input.value = display_name;
        if (suggestionsBox) suggestionsBox.classList.add('hidden');

        orderData.newAddress.address = display_name;
        orderData.newAddress.lat = lat;
        orderData.newAddress.lng = lon;

        const fullAddr = document.getElementById('fullAddressArea');
        if (fullAddr) fullAddr.value = display_name;

        if (mapInstance && markerInstance) {
            const newPos = [lat, lon];
            mapInstance.setView(newPos, 16);
            markerInstance.setLatLng(newPos);
        }

        reverseGeocode(lat, lon);
    }

    async function reverseGeocode(lat, lng) {
        try {
            const response = await fetch(
                `http://127.0.0.1:8000/api/proxy/reverse?lat=${lat}&lon=${lng}`, {
                    headers: {
                        'Authorization': 'Bearer ' + '{{ $api_token }}'
                    }
                }
            );
            const data = await response.json();
            if (data && data.display_name) {
                const area = document.getElementById('fullAddressArea');
                if (area) area.value = data.display_name;
                updateNewAddressData('address', data.display_name);
            }
        } catch (error) {
            console.error('Reverse geocode error:', error);
        }
    }

    function initTomSelects() {
        const provEl = document.getElementById('provSelect');
        const regEl = document.getElementById('regSelect');
        const distEl = document.getElementById('distSelect');
        const villEl = document.getElementById('villSelect');

        if (provEl) {
            tsProv = new TomSelect('#provSelect', {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                onChange: (val) => {
                    updateNewAddressData('idProvince', val);
                    fetchRegencies(val);
                }
            });
        }

        if (regEl) {
            tsReg = new TomSelect('#regSelect', {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                onChange: (val) => {
                    updateNewAddressData('idRegencies', val);
                    fetchDistricts(val);
                }
            });
        }

        if (distEl) {
            tsDist = new TomSelect('#distSelect', {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                onChange: (val) => {
                    updateNewAddressData('idDistricts', val);
                    fetchVillages(val);
                }
            });
        }

        if (villEl) {
            tsVill = new TomSelect('#villSelect', {
                valueField: 'id',
                labelField: 'name',
                searchField: 'name',
                onChange: (val) => {
                    updateNewAddressData('idVillages', val);
                }
            });
        }
    }

    async function fetchProvinces() {
        if (!tsProv) return;
        try {
            const res = await fetch('http://127.0.0.1:8000/api/provinces', {
                headers: {
                    'Authorization': 'Bearer ' + '{{ $api_token }}'
                }
            });
            const json = await res.json();
            tsProv.clearOptions();
            tsProv.addOptions(json.data);
            if (orderData.newAddress.idProvince) tsProv.setValue(orderData.newAddress.idProvince);
        } catch (e) {
            console.error('Error fetching provinces:', e);
        }
    }

    async function fetchRegencies(id) {
        if (!tsReg) return;
        if (!id) {
            resetAdminLevels('regency');
            return;
        }
        try {
            const res = await fetch('http://127.0.0.1:8000/api/regencies/' + id, {
                headers: {
                    'Authorization': 'Bearer ' + '{{ $api_token }}'
                }
            });
            const json = await res.json();
            tsReg.clearOptions();
            tsReg.addOptions(json.data);
            tsReg.enable();
            if (orderData.newAddress.idRegencies) tsReg.setValue(orderData.newAddress.idRegencies);
        } catch (e) {
            console.error('Error fetching regencies:', e);
        }
    }

    async function fetchDistricts(id) {
        if (!tsDist) return;
        if (!id) {
            resetAdminLevels('district');
            return;
        }
        try {
            const res = await fetch('http://127.0.0.1:8000/api/districts/' + id, {
                headers: {
                    'Authorization': 'Bearer ' + '{{ $api_token }}'
                }
            });
            const json = await res.json();
            tsDist.clearOptions();
            tsDist.addOptions(json.data);
            tsDist.enable();
            if (orderData.newAddress.idDistricts) tsDist.setValue(orderData.newAddress.idDistricts);
        } catch (e) {
            console.error('Error fetching districts:', e);
        }
    }

    async function fetchVillages(id) {
        if (!tsVill) return;
        if (!id) {
            resetAdminLevels('village');
            return;
        }
        try {
            const res = await fetch('http://127.0.0.1:8000/api/villages/' + id, {
                headers: {
                    'Authorization': 'Bearer ' + '{{ $api_token }}'
                }
            });
            const json = await res.json();
            tsVill.clearOptions();
            tsVill.addOptions(json.data);
            tsVill.enable();
            if (orderData.newAddress.idVillages) tsVill.setValue(orderData.newAddress.idVillages);
        } catch (e) {
            console.error('Error fetching villages:', e);
        }
    }

    function resetAdminLevels(level) {
        if (level === 'regency') {
            orderData.newAddress.idRegencies = "";
            if (tsReg) {
                tsReg.clear();
                tsReg.clearOptions();
                tsReg.disable();
            }
            resetAdminLevels('district');
        } else if (level === 'district') {
            orderData.newAddress.idDistricts = "";
            if (tsDist) {
                tsDist.clear();
                tsDist.clearOptions();
                tsDist.disable();
            }
            resetAdminLevels('village');
        } else if (level === 'village') {
            orderData.newAddress.idVillages = "";
            if (tsVill) {
                tsVill.clear();
                tsVill.clearOptions();
                tsVill.disable();
            }
        }
    }
</script>
