<script>
    let currentStep = 1;
    let viewMonth = new Date().getMonth();
    let viewYear = new Date().getFullYear();

    const today = new Date();
    const todayStr =
        `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

    const orderData = {
        date: todayStr,
        time: "10:00",
        addressType: "default",
        customAddress: "",
        newAddress: {
            title: "",
            address: "",
            lat: -7.008310559652935, // Default to Jakarta
            lng: 110.41789795132465,
            province: "",
            regency: "",
            district: "",
            village: ""
        }
    };

    const stepContents = {
        1: renderSchedule,
        2: renderAddress,
        21: renderNewAddressForm,
        3: renderPayment,
        4: renderSuccess
    };

    function formatDate(dateStr) {
        if (!dateStr) return "";
        const parts = dateStr.split('-');
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
            "Oktober", "November", "Desember"
        ];
        return `${parseInt(parts[2])} ${monthNames[parseInt(parts[1]) - 1]} ${parts[0]}`;
    }

    function renderSchedule() {
        const template = document.getElementById('tpl-step-1').content.cloneNode(true);
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
            "Oktober", "November", "Desember"
        ];
        const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

        template.getElementById('calendarMonth').textContent = `${monthNames[viewMonth]} ${viewYear}`;

        const header = template.getElementById('calendarHeader');
        header.innerHTML = dayNames.map(day =>
            `<div class="text-center text-xs font-bold text-gray-400 py-1">${day}</div>`).join('');

        const daysContainer = template.getElementById('calendarDays');
        const firstDay = new Date(viewYear, viewMonth, 1).getDay();
        const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            daysContainer.appendChild(document.createElement('div'));
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const isSelected = orderData.date === dateStr;
            const isPast = dateStr < todayStr;

            const btn = document.createElement('button');
            btn.type = "button";
            if (!isPast) {
                btn.onclick = () => selectDate(dateStr);
            } else {
                btn.disabled = true;
            }

            btn.className =
                `slot-btn aspect-square w-full rounded-xl border-2 flex items-center justify-center p-0 ${isSelected ? "selected shadow-md border-satset-green" : "border-gray-100 bg-white shadow-sm hover:border-satset-green/50"}`;
            btn.innerHTML =
                `<span class="text-sm font-black ${isSelected ? 'text-white' : (isPast ? 'text-gray-300' : 'text-gray-800')}">${d}</span>`;
            daysContainer.appendChild(btn);
        }

        const prevBtn = template.getElementById('prevMonthBtn');
        if (viewYear === today.getFullYear() && viewMonth === today.getMonth()) {
            prevBtn.disabled = true;
            prevBtn.classList.add('opacity-30', 'cursor-not-allowed');
            prevBtn.onclick = null;
        }

        const timeGrid = template.getElementById('timeGrid');
        const isToday = orderData.date === todayStr;
        const now = new Date();
        const currentTimeStr =
            `${String(now.getHours()).padStart(2, '0')}:${String(now.getMinutes()).padStart(2, '0')}`;

        ["06:00", "10:00", "14:00", "18:00"].forEach(time => {
            const isDisabled = isToday && time < currentTimeStr;
            const isSelected = orderData.time === time && !isDisabled;

            const btn = document.createElement('button');
            btn.type = "button";
            if (!isDisabled) {
                btn.onclick = () => selectTime(time);
            } else {
                btn.disabled = true;
            }
            btn.className =
                `slot-btn p-4 rounded-2xl border-2 font-black ${isSelected ? "selected shadow-lg border-satset-green" : "border-gray-100 bg-white text-gray-600 shadow-sm"}`;
            btn.textContent = `${time} WIB`;
            timeGrid.appendChild(btn);
        });

        return template;
    }

    function renderAddress() {
        const template = document.getElementById('tpl-step-2').content.cloneNode(true);
        const list = template.getElementById('addressList');
        const addresses = [{
                value: "default",
                title: "Rumah (Default)",
                desc: "Jl. Mawar No. 123, Semarang Tengah",
                icon: 'home'
            },
            {
                value: "new",
                title: "Gunakan Alamat Baru",
                desc: "",
                icon: 'plus'
            }
        ];

        addresses.forEach(addr => {
            const cardTmpl = document.getElementById('tpl-address-card').content.cloneNode(true);
            const card = cardTmpl.querySelector('.address-card');
            const input = cardTmpl.querySelector('input');

            if (orderData.addressType === addr.value) {
                card.classList.add('selected', 'border-satset-green', 'bg-satset-green/5');
                input.checked = true;
            } else {
                card.classList.add('border-gray-100', 'bg-white', 'shadow-sm', 'hover:border-satset-green/30');
            }

            input.value = addr.value;
            input.onchange = () => selectAddress(addr.value);

            cardTmpl.querySelector('.addr-title').textContent = addr.title;
            cardTmpl.querySelector('.addr-desc').textContent = addr.desc;

            const iconContainer = cardTmpl.querySelector('.addr-icon');
            if (addr.icon === 'home') {
                iconContainer.innerHTML =
                    `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>`;
            } else {
                iconContainer.innerHTML =
                    `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>`;
            }

            list.appendChild(cardTmpl);
        });

        return template;
    }

    let mapInstance = null;
    let markerInstance = null;

    function renderNewAddressForm() {
        const template = document.getElementById('tpl-step-21').content.cloneNode(true);

        // Populate inputs from existing orderData if any
        template.getElementById('locNameInput').value = orderData.newAddress.title;
        template.getElementById('fullAddressArea').value = orderData.newAddress.address;

        // Fetch Provinces immediately
        fetchProvinces();

        // Delay map initialization until after it's in the DOM
        setTimeout(() => {
            initNewAddressMap();
        }, 300);

        return template;
    }

    function initNewAddressMap() {
        const container = document.getElementById('newAddressMap');
        if (!container) return;

        if (mapInstance) {
            mapInstance.remove();
        }

        mapInstance = L.map('newAddressMap').setView([orderData.newAddress.lat, orderData.newAddress.lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(mapInstance);

        markerInstance = L.marker([orderData.newAddress.lat, orderData.newAddress.lng], {
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
        const suggestionsBox = document.getElementById('searchSuggestions');
        if (!query || query.length < 3) {
            suggestionsBox.innerHTML = '';
            suggestionsBox.classList.add('hidden');
            return;
        }

        try {
            const response = await fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=5`
            );
            const data = await response.json();

            if (data.length > 0) {
                suggestionsBox.innerHTML = data.map(item => `
                    <div class="px-5 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-50 last:border-0" onclick="onSelectSuggestion('${item.display_name}', ${item.lat}, ${item.lon})">
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

        input.value = display_name;
        suggestionsBox.classList.add('hidden');

        orderData.newAddress.address = display_name;
        orderData.newAddress.lat = lat;
        orderData.newAddress.lng = lon;

        document.getElementById('fullAddressArea').value = display_name;

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
                `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await response.json();
            if (data && data.display_name) {
                document.getElementById('fullAddressArea').value = data.display_name;
                orderData.newAddress.address = data.display_name;

                // Try to auto-set administrative dropdowns if info available
                // Note: Nominatim data structure varies, we'll try our best
                console.log('Reverse geocode data:', data.address);
            }
        } catch (error) {
            console.error('Reverse geocode error:', error);
        }
    }

    function updateNewAddressData(key, value) {
        orderData.newAddress[key] = value;
    }

    // Administrative Dropdowns Implementation
    async function fetchProvinces() {
        const res = await fetch('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json');
        const data = await res.json();
        const select = document.getElementById('provSelect');
        if (!select) return;
        select.innerHTML = '<option value="">Pilih Provinsi</option>' +
            data.map(p => `<option value="${p.id}">${p.name}</option>`).join('');
    }

    async function onProvinceChange(id) {
        orderData.newAddress.province = id;
        const reg = document.getElementById('regSelect');
        const dist = document.getElementById('distSelect');
        const vill = document.getElementById('villSelect');

        reg.disabled = false;
        reg.innerHTML = '<option value="">Memuat...</option>';
        dist.disabled = true;
        vill.disabled = true;

        const res = await fetch(`https://emsifa.github.io/api-wilayah-indonesia/api/regencies/${id}.json`);
        const data = await res.json();
        reg.innerHTML = '<option value="">Pilih Kota</option>' +
            data.map(r => `<option value="${r.id}">${r.name}</option>`).join('');
    }

    async function onRegencyChange(id) {
        orderData.newAddress.regency = id;
        const dist = document.getElementById('distSelect');
        const vill = document.getElementById('villSelect');

        dist.disabled = false;
        dist.innerHTML = '<option value="">Memuat...</option>';
        vill.disabled = true;

        const res = await fetch(`https://emsifa.github.io/api-wilayah-indonesia/api/districts/${id}.json`);
        const data = await res.json();
        dist.innerHTML = '<option value="">Pilih Kecamatan</option>' +
            data.map(d => `<option value="${d.id}">${d.name}</option>`).join('');
    }

    async function onDistrictChange(id) {
        orderData.newAddress.district = id;
        const vill = document.getElementById('villSelect');

        vill.disabled = false;
        vill.innerHTML = '<option value="">Memuat...</option>';

        const res = await fetch(`https://emsifa.github.io/api-wilayah-indonesia/api/villages/${id}.json`);
        const data = await res.json();
        vill.innerHTML = '<option value="">Pilih Kelurahan</option>' +
            data.map(v => `<option value="${v.id}">${v.name}</option>`).join('');
    }

    function onVillageChange(id) {
        orderData.newAddress.village = id;
    }

    function renderPayment() {
        const template = document.getElementById('tpl-step-3').content.cloneNode(true);
        template.getElementById('summaryTime').innerHTML = `${formatDate(orderData.date)},<br/>${orderData.time} WIB`;

        let locText = "Rumah";
        if (orderData.addressType === "new") {
            locText = orderData.newAddress.title || orderData.newAddress.address || "Alamat Baru";
        }

        template.getElementById('summaryLocation').textContent = locText;
        return template;
    }

    function renderSuccess() {
        return document.getElementById('tpl-step-4').content.cloneNode(true);
    }

    function nextStep() {
        if (currentStep === 1 && !orderData.date) {
            alert("Silakan pilih tanggal terlebih dahulu secara satset!");
            return;
        }
        if (currentStep === 2) {
            if (orderData.addressType === 'new') {
                currentStep = 21;
                updateStep();
                return;
            }
        }
        if (currentStep === 21) {
            if (!orderData.newAddress.address) {
                alert("Silakan lengkapi alamat baru kamu!");
                return;
            }
            currentStep = 3;
            updateStep();
            return;
        }
        if (currentStep < 4) {
            if (currentStep === 2) currentStep = 3;
            else currentStep++;
            updateStep();
        }
    }

    function prevStep() {
        if (currentStep === 21) {
            currentStep = 2;
        } else if (currentStep === 3 && orderData.addressType === 'new') {
            currentStep = 21;
        } else if (currentStep > 1) {
            currentStep--;
        }
        updateStep();
    }

    function handleBack() {
        if (currentStep === 1) {
            window.location.href = '{{ url()->previous() }}';
        } else {
            prevStep();
        }
    }

    function updateStep() {
        const content = document.getElementById('stepContent');
        const title = document.getElementById('stepTitle');
        const progressBar = document.getElementById('progressBar');
        const footerAction = document.getElementById('footerAction');
        const cancelBtn = document.getElementById('cancelBtn');
        const backBtn = document.getElementById('backBtn');

        content.style.opacity = '0';

        setTimeout(() => {
            content.replaceChildren(stepContents[currentStep]());
            content.style.opacity = '1';

            // Focus on input if it's the new address field
            if (currentStep === 21) {
                document.getElementById('locNameInput')?.focus();
            }
        }, 150);

        const titles = {
            1: "Atur Jadwal",
            2: "Lokasi Layanan",
            21: "Alamat Baru",
            3: "Pembayaran",
            4: "Selesai"
        };
        title.textContent = titles[currentStep];

        if (currentStep < 4 || currentStep === 21) {
            const progress = currentStep === 21 ? 2.5 : currentStep;
            progressBar.style.width = `${(progress / 3) * 100}%`;
            document.getElementById('progressContainer').style.display = 'block';
        } else {
            document.getElementById('progressContainer').style.display = 'none';
        }

        if (currentStep < 4 || currentStep === 21) {
            footerAction.style.display = 'block';
            const btnText = currentStep === 3 ? "KONFIRMASI PEMBAYARAN" : "LANJUTKAN";
            footerAction.querySelector('button').innerHTML = `
                    ${btnText}
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                `;
        } else {
            footerAction.style.display = 'none';
        }

        cancelBtn.style.display = (currentStep < 4 || currentStep === 21) ? 'flex' : 'none';
        backBtn.style.display = (currentStep === 4 || currentStep === 1) ? 'none' : 'flex';
    }

    function selectDate(dateStr) {
        orderData.date = dateStr;
        updateStep();
    }

    function changeMonth(delta) {
        let newMonth = viewMonth + delta;
        let newYear = viewYear;

        if (newMonth > 11) {
            newMonth = 0;
            newYear++;
        } else if (newMonth < 0) {
            newMonth = 11;
            newYear--;
        }

        // Restriction logic: don't go back past current month
        const t = new Date();
        const minYear = t.getFullYear();
        const minMonth = t.getMonth();

        if (newYear < minYear || (newYear === minYear && newMonth < minMonth)) {
            return;
        }

        viewMonth = newMonth;
        viewYear = newYear;
        updateStep();
    }

    function selectTime(time) {
        orderData.time = time;
        updateStep();
    }

    function selectAddress(type) {
        orderData.addressType = type;
        updateStep();
    }

    function updateCustomAddress(address) {
        orderData.customAddress = address;
    }

    function showCancelModal() {
        document.getElementById('cancelModal').classList.remove('hidden');
    }

    function hideCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
    }

    function confirmCancel() {
        window.location.href = '{{ route('dashboard') }}';
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateStep();
    });
</script>
