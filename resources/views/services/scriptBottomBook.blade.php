<script>
    let currentStep = {{ session('p_step', 1) }};
    let viewMonth = new Date().getMonth();
    let viewYear = new Date().getFullYear();

    const today = new Date();
    const todayStr =
        `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

    const orderData = {
        date: "{{ session('p_date') }}" || todayStr,
        time: "{{ session('p_time') }}" || null,
        duration: {{ (int) request('duration', 3) }},
        staffCount: {{ (int) request('staffCount', 1) }},
        serviceName: "{{ $service['keterangan'] ?? 'Layanan' }}",
        price: {{ $service['harga'] ?? 150000 }},
        idLayanan: {{ $service['id_layanan'] ?? '1' }},
        idSubLayanan: {{ $service['id'] ?? '6' }},
        idCustomer: {{ session('user_data')['id'] ?? 'null' }},
        idLokasi: "{{ session('new_address_id') }}" || null,
        addressType: "{{ session('new_address_id', 'default') }}",
        addressName: "{{ session('new_address_name', 'Alamat Default') }}",
        payment_method: null,
        selected_voucher_ids: [],
        selected_promo_id: null,
        availableVouchers: [],
        availablePromos: [],
        customAddress: "",
        newAddress: {
            title: "",
            address: "",
            rt: "",
            rw: "",
            namaPIC: "",
            noHpPIC: "",
            jenisBangunan: "",
            idProvince: "",
            idRegencies: "",
            idDistricts: "",
            idVillages: ""
        }
    };

    const stepContents = {
        1: renderSchedule,
        2: renderAddress,
        21: renderNewAddressForm,
        3: renderPayment,
        31: renderWaitingPayment,
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

        // Render Duration Selection
        const duration3 = template.getElementById('duration-3');
        const duration6 = template.getElementById('duration-6');

        [duration3, duration6].forEach(btn => {
            const d = parseInt(btn.id.split('-')[1]);
            if (orderData.duration === d) {
                btn.classList.add('border-satset-green', 'bg-satset-green/5', 'text-satset-green');
            } else {
                btn.classList.add('border-gray-100', 'bg-white', 'text-gray-400');
            }
        });

        // Render Staff Count
        template.getElementById('staffCountDisplay').textContent = orderData.staffCount;

        const staffMinus = template.getElementById('staffMinus');
        const staffPlus = template.getElementById('staffPlus');

        if (orderData.staffCount > 1) {
            staffMinus.classList.remove('bg-white', 'border-gray-100', 'text-gray-600');
            staffMinus.classList.add('bg-satset-green', 'text-white', 'shadow-md');
        } else {
            staffMinus.classList.add('bg-white', 'border-gray-100', 'text-gray-600');
            staffMinus.classList.remove('bg-satset-green', 'text-white', 'shadow-md');
        }

        // Ensure staffPlus is always green
        staffPlus.classList.add('bg-satset-green', 'text-white', 'shadow-md');
        staffPlus.classList.remove('bg-white', 'border-2', 'border-satset-green', 'text-satset-green');

        // Render Date Display
        template.getElementById('selectedDateDisplay').textContent = formatDate(orderData.date) || "Pilih Tanggal";

        // Render Time Grid
        const timeGrid = template.getElementById('timeGrid');
        const isToday = orderData.date === todayStr;
        const now = new Date();
        const muteTime = new Date(now.getTime() + 60 * 60 * 1000); // 1 hour buffer
        const muteTimeStr =
            `${String(muteTime.getHours()).padStart(2, '0')}:${String(muteTime.getMinutes()).padStart(2, '0')}`;

        ["06:00", "10:00", "14:00", "18:00"].forEach(time => {
            const isDisabled = isToday && time <= muteTimeStr;
            const isSelected = orderData.time === time && !isDisabled;

            const btn = document.createElement('button');
            btn.type = "button";
            if (!isDisabled) {
                btn.onclick = () => selectTime(time);
            } else {
                btn.disabled = true;
            }
            btn.className =
                `slot-btn py-3 px-1 rounded-xl border-2 font-black text-xs ${isSelected ? "selected shadow-md border-satset-green" : "border-gray-100 bg-white text-gray-400 shadow-sm"}`;
            btn.textContent = `${time} WIB`;
            timeGrid.appendChild(btn);
        });

        return template;
    }

    function selectDuration(d) {
        orderData.duration = d;
        updateStep();
    }

    function updateStaffCount(delta) {
        const newVal = orderData.staffCount + delta;
        if (newVal >= 1 && newVal <= 10) {
            orderData.staffCount = newVal;
            updateStep();
        }
    }

    function showCalendarModal() {
        const modal = document.getElementById('calendarModal');
        modal.classList.remove('hidden');
        renderCalendarModal();
    }

    function hideCalendarModal() {
        const modal = document.getElementById('calendarModal');
        modal.classList.add('hidden');
    }

    function renderCalendarModal() {
        const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
            "Oktober", "November", "Desember"
        ];
        const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];

        document.getElementById('modalCalendarMonth').textContent = `${monthNames[viewMonth]} ${viewYear}`;

        const header = document.getElementById('modalCalendarHeader');
        header.innerHTML = dayNames.map(day =>
            `<div class="text-center text-xs font-bold text-gray-400 py-1">${day}</div>`).join('');

        const daysContainer = document.getElementById('modalCalendarDays');
        daysContainer.innerHTML = '';

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
                btn.onclick = () => {
                    selectDate(dateStr);
                    hideCalendarModal();
                };
            } else {
                btn.disabled = true;
            }

            btn.className =
                `slot-btn aspect-square w-full rounded-2xl border-2 flex items-center justify-center p-0 transition-all ${isSelected ? "selected shadow-md border-satset-green" : "border-gray-50 bg-white shadow-sm hover:border-satset-green/50"}`;
            btn.innerHTML =
                `<span class="text-sm font-black ${isSelected ? 'text-white' : (isPast ? 'text-gray-200' : 'text-gray-800')}">${d}</span>`;
            daysContainer.appendChild(btn);
        }

        const prevBtn = document.getElementById('modalPrevMonthBtn');
        if (viewYear === today.getFullYear() && viewMonth === today.getMonth()) {
            prevBtn.disabled = true;
            prevBtn.classList.add('opacity-30', 'cursor-not-allowed');
            prevBtn.onclick = null;
        } else {
            prevBtn.disabled = false;
            prevBtn.classList.remove('opacity-30', 'cursor-not-allowed');
            prevBtn.onclick = () => changeMonth(-1);
        }
    }

    function changeMonth(delta) {
        viewMonth += delta;
        if (viewMonth > 11) {
            viewMonth = 0;
            viewYear++;
        } else if (viewMonth < 0) {
            viewMonth = 11;
            viewYear--;
        }
        renderCalendarModal();
    }

    function renderAddress() {
        const template = document.getElementById('tpl-step-2').content.cloneNode(true);
        const radioGroup = template.querySelectorAll('input[name="addressSelection"]');

        radioGroup.forEach(radio => {
            if (radio.value == orderData.addressType) {
                radio.checked = true;
            }
        });

        return template;
    }

    function renderNewAddressForm() {
        const template = document.getElementById('tpl-step-21').content.cloneNode(true);

        template.getElementById('locNameInput').value = orderData.newAddress.title;
        template.getElementById('locRTInput').value = orderData.newAddress.rt;
        template.getElementById('locRWInput').value = orderData.newAddress.rw;
        template.getElementById('picNameInput').value = orderData.newAddress.namaPIC;
        template.getElementById('picPhoneInput').value = orderData.newAddress.noHpPIC;
        template.getElementById('buildingTypeInput').value = orderData.newAddress.jenisBangunan;
        template.getElementById('fullAddressArea').value = orderData.newAddress.address;

        template.getElementById('formDate').value = orderData.date;
        template.getElementById('formTime').value = orderData.time;

        setTimeout(() => {
            initTomSelects();
            fetchProvinces();
        }, 300);

        return template;
    }

    function renderPayment() {
        const template = document.getElementById('tpl-step-3').content.cloneNode(true);
        template.getElementById('summaryTime').innerHTML = `${formatDate(orderData.date)},<br/>${orderData.time} WIB`;

        let locText = orderData.addressName || "Lokasi";
        if (orderData.addressType === "new") {
            locText = orderData.newAddress.title || orderData.newAddress.address || "Alamat Baru";
        }

        template.getElementById('summaryLocation').textContent = locText;
        template.getElementById('summaryServiceName').textContent = orderData.serviceName;
        const totalPrice = (orderData.price * orderData.staffCount) + 5000;
        template.getElementById('summaryTotalPay').textContent =
            `Rp${Number(totalPrice).toLocaleString('id-ID')}`;

        setTimeout(() => {
            selectPaymentMethod(orderData.payment_method);
            if (orderData.payment_method === 'Voucher') autoSelectVouchers();
            fetchVoucherBalance();
            fetchAvailablePromos();
        }, 50);

        return template;
    }

    function renderWaitingPayment() {
        const template = document.getElementById('tpl-step-3-1').content.cloneNode(true);
        template.getElementById('summaryTime').innerHTML = `${formatDate(orderData.date)},<br/>${orderData.time} WIB`;

        let locText = orderData.addressName || "Lokasi";
        if (orderData.addressType === "new") {
            locText = orderData.newAddress.title || orderData.newAddress.address || "Alamat Baru";
        }
        template.getElementById('summaryLocation').textContent = locText;
        template.getElementById('summaryServiceName').textContent = orderData.serviceName;
        const totalPrice = (orderData.price * orderData.staffCount) + 5000;
        template.getElementById('summaryTotalPay').textContent =
            `Rp${Number(totalPrice).toLocaleString('id-ID')}`;

        return template;
    }

    function renderSuccess() {
        return document.getElementById('tpl-step-4').content.cloneNode(true);
    }

    async function fetchVoucherBalance() {
        try {
            const response = await fetch("{{ route('voucher.index') }}", {
                headers: {
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();

            // Process and tag vouchers
            const now = new Date();
            orderData.availableVouchers = (data.vouchers || []).map(v => {
                const validUntil = v.batch_info?.valid_until ? new Date(v.batch_info.valid_until) : null;
                v.isExpired = validUntil && validUntil < now;
                v.isUsed = v.used_at !== null;
                v.isValidService = v.batch_info && parseInt(v.batch_info.id_layanan) === parseInt(orderData
                    .idLayanan);
                v.isUsable = !v.isUsed && !v.isExpired && v.isValidService;
                return v;
            });

            const usableVouchers = orderData.availableVouchers.filter(v => v.isUsable);
            const voucherCount = usableVouchers.length;

            const balanceText = document.getElementById('voucherBalanceText');
            if (balanceText) {
                balanceText.textContent = `Tersisa: ${voucherCount} Voucher`;
                balanceText.classList.remove('loading-text');

                if (voucherCount <= 0) {
                    balanceText.classList.remove('text-satset-green');
                    balanceText.classList.add('text-red-500');
                } else {
                    balanceText.classList.add('text-satset-green');
                    balanceText.classList.remove('text-red-500');
                }
            }
        } catch (error) {
            console.error("Fetch balance error:", error);
        }
    }

    async function fetchAvailablePromos() {
        orderData.availablePromos = [{
                id: 1,
                name: 'DISKON SATSET',
                desc: 'Potongan Rp 10.000',
                value: 10000
            },
            {
                id: 2,
                name: 'PROMO RANGER',
                desc: 'Potongan Rp 5.000',
                value: 5000
            }
        ];
    }



    function showPromoModal() {
        if (orderData.payment_method === 'Voucher') {
            showAlert("Promo Tidak Tersedia", "Voucher Pembayaran tidak dapat digabung dengan promo lainnya.");
            return;
        }
        const modal = document.getElementById('promoModal');
        const content = document.getElementById('promoModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => content.classList.remove('translate-y-full'), 10);
        renderPromoList();
    }

    function hidePromoModal() {
        const modal = document.getElementById('promoModal');
        const content = document.getElementById('promoModalContent');
        content.classList.add('translate-y-full');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function renderPromoList() {
        const list = document.getElementById('promoList');
        list.innerHTML = orderData.availablePromos.map(promo => `
            <div class="border-2 ${orderData.selected_promo_id === promo.id ? 'border-satset-green bg-satset-green/5' : 'border-gray-100'} rounded-[28px] p-5 flex items-center justify-between cursor-pointer hover:border-satset-green transition-all" onclick="selectPromo(${promo.id})">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                    </div>
                    <div>
                        <h5 class="font-black text-gray-800">${promo.name}</h5>
                        <p class="text-xs text-gray-500 font-medium">${promo.desc}</p>
                    </div>
                </div>
                <div class="w-6 h-6 border-2 ${orderData.selected_promo_id === promo.id ? 'border-satset-green' : 'border-gray-200'} rounded-full flex items-center justify-center">
                    <div class="w-3 h-3 bg-satset-green rounded-full ${orderData.selected_promo_id === promo.id ? '' : 'hidden'}"></div>
                </div>
            </div>
        `).join('');
    }

    function selectPromo(id) {
        if (orderData.selected_promo_id === id) {
            unselectPromo();
            return;
        }
        orderData.selected_promo_id = id;
        const promo = orderData.availablePromos.find(p => p.id === id);
        document.getElementById('selectedPromoLabel').textContent = promo.name;
        document.getElementById('selectedPromoSub').textContent = promo.desc;
        document.getElementById('promoContainer').classList.add('border-satset-green', 'bg-satset-green/5');
        document.getElementById('unselectPromoBtn').classList.remove('hidden');
        hidePromoModal();
    }

    function unselectPromo() {
        orderData.selected_promo_id = null;
        document.getElementById('selectedPromoLabel').textContent = "Pakai Promo";
        document.getElementById('selectedPromoSub').textContent = "Diskon atau voucher";
        document.getElementById('promoContainer').classList.remove('border-satset-green', 'bg-satset-green/5');
        document.getElementById('unselectPromoBtn').classList.add('hidden');
        hidePromoModal();
    }

    function showPaymentVoucherModal() {
        const modal = document.getElementById('paymentVoucherModal');
        const content = document.getElementById('paymentVoucherModalContent');
        modal.classList.remove('hidden');
        setTimeout(() => content.classList.remove('translate-y-full'), 10);
        renderPaymentVoucherList();
    }

    function hidePaymentVoucherModal() {
        const modal = document.getElementById('paymentVoucherModal');
        const content = document.getElementById('paymentVoucherModalContent');
        content.classList.add('translate-y-full');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    function renderPaymentVoucherList() {
        const list = document.getElementById('paymentVoucherList');
        if (orderData.availableVouchers.length === 0) {
            list.innerHTML =
                '<div class="text-center py-10 text-gray-400 font-bold">Kamu tidak memiliki voucher pembayaran</div>';
            return;
        }

        // Sort: Usable first, then Used/Expired
        const sortedVouchers = [...orderData.availableVouchers].sort((a, b) => {
            if (a.isUsable && !b.isUsable) return -1;
            if (!a.isUsable && b.isUsable) return 1;
            return 0;
        });

        list.innerHTML = sortedVouchers.map(v => {
            const isSelected = orderData.selected_voucher_ids.includes(v.id);
            const cardClass = v.isUsable ?
                (isSelected ? 'border-satset-green bg-satset-green/5' :
                    'border-gray-100 hover:border-satset-green') :
                'border-gray-50 bg-gray-50/50 opacity-60 grayscale cursor-not-allowed';

            let badge = '';
            if (v.isUsed) badge =
                '<span class="px-2 py-0.5 bg-gray-200 text-gray-500 text-[8px] font-black rounded-full ml-2">TERPAKAI</span>';
            else if (v.isExpired) badge =
                '<span class="px-2 py-0.5 bg-red-100 text-red-500 text-[8px] font-black rounded-full ml-2">EXPIRED</span>';
            else if (!v.isValidService) badge =
                '<span class="px-2 py-0.5 bg-amber-100 text-amber-600 text-[8px] font-black rounded-full ml-2">BEDA LAYANAN</span>';

            return `
                <div class="border-2 ${cardClass} rounded-[28px] p-5 flex items-center justify-between transition-all" 
                     ${v.isUsable ? `onclick="selectPaymentVoucher(${v.id}, '${v.batch_info?.batch_name || 'Voucher HFC'}')"` : ''}>
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 ${v.isUsable ? 'bg-satset-green/10 text-satset-green' : 'bg-gray-200 text-gray-400'} rounded-2xl flex items-center justify-center">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                                <line x1="2" y1="10" x2="22" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center">
                                <h5 class="font-black ${v.isUsable ? 'text-gray-800' : 'text-gray-400'}">${v.batch_info?.batch_name || 'Voucher HFC'}</h5>
                                ${badge}
                            </div>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Kode: ${v.voucher_code}</p>
                        </div>
                    </div>
                    ${v.isUsable ? `
                        <div class="w-6 h-6 border-2 ${orderData.selected_voucher_ids.includes(v.id) ? 'border-satset-green' : 'border-gray-200'} rounded-full flex items-center justify-center">
                            <div class="w-3 h-3 bg-satset-green rounded-full ${orderData.selected_voucher_ids.includes(v.id) ? '' : 'hidden'}"></div>
                        </div>
                    ` : ''}
                </div>
            `;
        }).join('');
    }

    function autoSelectVouchers() {
        const required = (orderData.duration / 3) * orderData.staffCount;
        const usable = orderData.availableVouchers.filter(v => v.isUsable);

        orderData.selected_voucher_ids = usable.slice(0, required).map(v => v.id);

        const nameEl = document.getElementById('selectedVoucherName');
        if (nameEl) {
            if (orderData.selected_voucher_ids.length > 0) {
                nameEl.textContent = `Terpilih: ${orderData.selected_voucher_ids.length} Voucher`;
                nameEl.classList.remove('hidden');
                document.getElementById('unselectVoucherBtn')?.classList.remove('hidden');

                if (orderData.selected_voucher_ids.length < required) {
                    nameEl.textContent += ` (Butuh ${required})`;
                    nameEl.classList.add('text-red-500');
                } else {
                    nameEl.classList.remove('text-red-500');
                }
            } else {
                nameEl.textContent = "";
                nameEl.classList.add('hidden');
                document.getElementById('unselectVoucherBtn')?.classList.add('hidden');
            }
        }
    }

    function selectPaymentVoucher(id, name) {
        if (orderData.selected_voucher_ids.includes(id)) {
            orderData.selected_voucher_ids = orderData.selected_voucher_ids.filter(vId => vId !== id);
        } else {
            orderData.selected_voucher_ids.push(id);
        }

        const nameEl = document.getElementById('selectedVoucherName');
        if (nameEl) {
            nameEl.textContent = orderData.selected_voucher_ids.length > 0 ?
                `Terpilih: ${orderData.selected_voucher_ids.length} Voucher` :
                "";
            nameEl.classList.toggle('hidden', orderData.selected_voucher_ids.length === 0);
        }
        document.getElementById('unselectVoucherBtn')?.classList.toggle('hidden', orderData.selected_voucher_ids
            .length === 0);

        // If no vouchers selected, unselect payment method
        if (orderData.selected_voucher_ids.length === 0) {
            selectPaymentMethod(null);
        }

        // Update list UI
        renderPaymentVoucherList();
    }

    function unselectPaymentVoucher() {
        orderData.selected_voucher_ids = [];
        const nameEl = document.getElementById('selectedVoucherName');
        if (nameEl) {
            nameEl.textContent = "";
            nameEl.classList.add('hidden');
        }
        const btnUnselect = document.getElementById('unselectVoucherBtn');
        if (btnUnselect) btnUnselect.classList.add('hidden');

        selectPaymentMethod(null);
        hidePaymentVoucherModal();
    }

    function selectPaymentMethod(method) {
        orderData.payment_method = method;
        const cards = document.querySelectorAll('.payment-method-card');
        const btnPick = document.getElementById('btnPickVoucher');
        const arrow = document.getElementById('voucherArrow');

        cards.forEach(card => {
            card.classList.remove('border-satset-green', 'bg-satset-green/5');
            const radio = card.querySelector('input[type="radio"]');
            if (radio) {
                if (method && radio.value === method) {
                    card.classList.add('border-satset-green', 'bg-satset-green/5');
                    radio.checked = true;
                } else {
                    radio.checked = false;
                }
            }
        });

        // Enable/Disable "Bayar Sekarang" button
        const footerBtn = document.querySelector('#footerAction button');
        if (currentStep === 3 && footerBtn) {
            footerBtn.disabled = !method;
            footerBtn.style.opacity = method ? '1' : '0.5';
        }

        if (method === 'Voucher') {
            if (btnPick) btnPick.classList.remove('hidden');
            if (arrow) arrow.classList.add('text-satset-green');

            // Disable Promo
            unselectPromo();
            const promoContainer = document.getElementById('promoContainer');
            if (promoContainer) {
                promoContainer.classList.add('opacity-40');
                promoContainer.classList.remove('hover:border-satset-green');
            }

            if (!orderData.selected_voucher_ids.length && orderData.availableVouchers.length > 0) {
                autoSelectVouchers();
            }
        } else {
            if (btnPick) btnPick.classList.add('hidden');
            if (arrow) arrow.classList.remove('text-satset-green');

            // Clear voucher selection when switching away from 'voucher'
            orderData.selected_voucher_ids = [];
            const nameEl = document.getElementById('selectedVoucherName');
            if (nameEl) {
                nameEl.textContent = "";
                nameEl.classList.add('hidden');
            }
            const btnUnselect = document.getElementById('unselectVoucherBtn');
            if (btnUnselect) btnUnselect.classList.add('hidden');

            // Re-enable Promo
            const promoContainer = document.getElementById('promoContainer');
            if (promoContainer) {
                promoContainer.classList.remove('opacity-40');
                promoContainer.classList.add('hover:border-satset-green');
            }
        }
    }

    async function nextStep() {
        if (currentStep === 1) {
            if (!orderData.date || !orderData.time) {
                showAlert("Pilih Jadwal", "Silakan pilih Tanggal dan Jam pengerjaan terlebih dahulu agar satset!");
                return;
            }

            const btn = document.querySelector('#footerAction button');
            const originalContent = btn.innerHTML;

            try {
                btn.disabled = true;
                btn.innerHTML =
                    `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MENCARI RANGER...`;

                const response = await fetch("{{ route('services.checkRanger') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        tgl: orderData.date,
                        jam: orderData.time
                    })
                });
                const result = await response.json();
                if (!result.success || !result.data || result.data.available_ranger < orderData.staffCount) {
                    showRangerModal();
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    return;
                }
                currentStep = 2;
                updateStep();
            } catch (error) {
                showAlert("Gagal", "Gagal mengecek ketersediaan ranger. Silakan coba lagi.", 'error');
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
            return;
        }

        if (currentStep === 2) {
            if (!orderData.idLokasi && orderData.addressType !== 'new') {
                showAlert("Pilih Alamat", "Silakan pilih Lokasi Layanan kamu terlebih dahulu!");
                return;
            }
            if (orderData.addressType === 'new') {
                currentStep = 21;
                updateStep();
                return;
            }
            currentStep = 3;
            updateStep();
            return;
        }

        if (currentStep === 21) {
            const form = document.getElementById('newAddressForm');
            if (form) {
                document.getElementById('formDate').value = orderData.date;
                document.getElementById('formTime').value = orderData.time;
                if (form.checkValidity()) document.getElementById('submitNewAddress').click();
                else form.reportValidity();
            }
            return;
        }

        if (currentStep === 3) {
            confirmPayment();
            return;
        }

        if (currentStep === 31) {
            currentStep = 4;
            updateStep();
            return;
        }

        if (currentStep < 4) {
            currentStep++;
            updateStep();
        }
    }

    async function confirmPayment() {
        const btn = document.querySelector('#footerAction button');
        const originalContent = btn.innerHTML;

        showLoading();
        try {
            btn.disabled = true;
            btn.innerHTML =
                `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline shadow-inner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> MEMPROSES...`;

            // 1. Create Order
            const tglPekerjaan = `${orderData.date} ${orderData.time}:00`;
            const payload = {
                idCustomer: orderData.idCustomer,
                idLayanan: orderData.idLayanan,
                tglPekerjaan: tglPekerjaan,
                idSubLayanan: orderData.idSubLayanan,
                idLokasi: orderData.idLokasi,
                staffCount: orderData.staffCount,
                duration: orderData.duration,
                payment_method: orderData.payment_method,
                metodePembayaran: orderData.payment_method === 'Voucher' ? 'Voucher Pembayaran' : 'Non Tunai'
            };

            // Add voucher info if strictly paying with voucher
            if (orderData.payment_method === 'Voucher') {
                if (orderData.selected_voucher_ids.length > 0) {
                    payload.payment_voucher_ids = orderData.selected_voucher_ids;

                    // Map IDs to Codes
                    payload.payment_voucher_codes = orderData.selected_voucher_ids.map(id => {
                        const v = orderData.availableVouchers.find(av => av.id === id);
                        return v ? v.voucher_code : '';
                    });

                    payload.voucher_type = 1; // 1 for Payment Voucher
                } else {
                    hideLoading();
                    showAlert("Voucher Tidak Ada", "Kamu tidak memiliki voucher pembayaran aktif.", 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    return;
                }
            }

            if (orderData.selected_promo_id) {
                payload.promo_id = orderData.selected_promo_id;
            }

            const orderResponse = await fetch("{{ route('services.createNewOrder', $kode) }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            });

            const orderResult = await orderResponse.json();
            if (!orderResult.success) {
                hideLoading();
                let errorTitle = "Gagal";
                let errorMsg = orderResult.message || "Gagal membuat pesanan.";

                if (orderData.payment_method === 'Voucher') {
                    errorTitle = "Voucher Gagal";
                    errorMsg = "Voucher tidak bisa digunakan";
                }

                showAlert(errorTitle, errorMsg, 'error');
                btn.disabled = false;
                btn.innerHTML = originalContent;
                return;
            }

            // Success will lead to step change or redirect
            hideLoading();

            // 2. Handle Navigation
            if (orderData.payment_method === 'Voucher') {
                currentStep = 4;
                updateStep();
            } else {
                currentStep = 31;
                updateStep();
            }
        } catch (error) {
            hideLoading();
            console.error("Payment error:", error);
            showAlert("Kesalahan", "Terjadi kesalahan saat memproses pembayaran.", 'error');
            btn.disabled = false;
            btn.innerHTML = originalContent;
        }
    }

    function prevStep() {
        if (currentStep === 21) currentStep = 2;
        else if (currentStep === 31) currentStep = 3;
        else if (currentStep === 3 && orderData.addressType === 'new') currentStep = 21;
        else if (currentStep > 1) currentStep--;
        updateStep();
    }

    function handleBack() {
        if (currentStep === 1) window.location.href = '{{ url()->previous() }}';
        else prevStep();
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
            if (currentStep === 21) document.getElementById('locNameInput')?.focus();
        }, 150);

        const titles = {
            1: "Pilih Waktu Pengerjaan",
            2: "Lokasi Layanan",
            21: "Alamat Baru",
            3: "Pembayaran",
            31: "Menunggu Pembayaran",
            4: "Selesai"
        };
        title.textContent = titles[currentStep];

        if (currentStep < 4) {
            let progress = currentStep;
            if (currentStep === 21) progress = 2.5;
            if (currentStep === 31) progress = 3;
            progressBar.style.width = `${(progress / 3) * 100}%`;
            document.getElementById('progressContainer').style.display = 'block';
        } else {
            document.getElementById('progressContainer').style.display = 'none';
        }

        if (currentStep !== 4) {
            footerAction.style.display = 'block';
            const btn = footerAction.querySelector('button');
            btn.disabled = false;

            let btnText = "LANJUTKAN";
            if (currentStep === 21) btnText = "SIMPAN ALAMAT";
            if (currentStep === 3) {
                btnText = "BAYAR SEKARANG";
                btn.disabled = !orderData.payment_method;
                btn.style.opacity = orderData.payment_method ? '1' : '0.5';
            }
            if (currentStep === 31) btnText = "KONFIRMASI PEMBAYARAN BERHASIL";

            btn.innerHTML =
                `${btnText} <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><polyline points="9 18 15 12 9 6"></polyline></svg>`;
        } else {
            footerAction.style.display = 'none';
        }

        cancelBtn.style.display = (currentStep !== 4) ? 'flex' : 'none';
        backBtn.style.display = (currentStep === 4 || currentStep === 1) ? 'none' : 'flex';
    }

    function selectDate(dateStr) {
        orderData.date = dateStr;
        updateStep();
    }

    function selectTime(time) {
        orderData.time = time;
        updateStep();
    }

    function selectAddress(type, name = "Alamat") {
        orderData.addressType = type;
        orderData.addressName = name;
        if (type !== 'new') orderData.idLokasi = type;
        updateStep();
    }

    function showCancelModal() {
        showGlobalModal({
            title: 'Batalkan Pesanan?',
            message: 'Yakin ingin membatalkan pesanan ini?',
            type: 'danger',
            actionText: 'YA, BATALKAN',
            onAction: () => {
                window.location.href = '{{ route('dashboard') }}';
            }
        });
    }

    function showRangerModal() {
        showGlobalModal({
            title: 'Ranger Tidak Tersedia',
            message: 'Tidak ada ranger yang tersedia untuk jadwal yang kamu pilih. Silakan pilih tanggal atau jam lain ya!',
            type: 'warning',
            actionText: 'PILIH JADWAL LAIN',
            onAction: () => {
                currentStep = 1;
                updateStep();
            }
        });
    }

    function confirmCancel() {
        window.location.href = '{{ route('dashboard') }}';
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateStep();
    });
</script>
