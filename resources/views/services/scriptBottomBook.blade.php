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
        serviceName: "{{ $service['keterangan'] ?? 'Layanan' }}",
        price: {{ $service['harga'] ?? 150000 }},
        idLayanan: {{ $service['id_layanan'] ?? '1' }},
        idSubLayanan: {{ $service['id'] ?? '6' }},
        idCustomer: {{ session('user_data')['id'] ?? 'null' }},
        idLokasi: "{{ session('new_address_id') }}" || null,
        addressType: "{{ session('new_address_id', 'default') }}",
        addressName: "{{ session('new_address_name', 'Alamat Default') }}",
        payment_method: 'voucher',
        selected_voucher_id: null,
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
        template.getElementById('summaryTotalPay').textContent =
            `Rp${Number(orderData.price + 5000).toLocaleString('id-ID')}`;

        setTimeout(() => {
            selectPaymentMethod(orderData.payment_method);
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
        template.getElementById('summaryTotalPay').textContent =
            `Rp${Number(orderData.price + 5000).toLocaleString('id-ID')}`;

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

            // Filter only unused vouchers (used_at === null)
            orderData.availableVouchers = (data.vouchers || []).filter(v => v.used_at === null);

            const voucherCount = orderData.availableVouchers.length;
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

    function selectPaymentMethod(method) {
        orderData.payment_method = method;
        const cards = document.querySelectorAll('.payment-method-card');
        cards.forEach(card => {
            card.classList.remove('border-satset-green', 'bg-satset-green/5');
            const radio = card.querySelector('input[type="radio"]');
            if (radio.value === method) {
                card.classList.add('border-satset-green', 'bg-satset-green/5');
                radio.checked = true;
            }
        });
    }

    function showPromoModal() {
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
            <div class="border-2 border-gray-100 rounded-[28px] p-5 flex items-center justify-between cursor-pointer hover:border-satset-green transition-all" onclick="selectPromo(${promo.id})">
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
                <div class="w-6 h-6 border-2 border-gray-200 rounded-full flex items-center justify-center">
                    <div class="w-3 h-3 bg-satset-green rounded-full ${orderData.selected_promo_id === promo.id ? '' : 'hidden'}"></div>
                </div>
            </div>
        `).join('');
    }

    function selectPromo(id) {
        orderData.selected_promo_id = id;
        const promo = orderData.availablePromos.find(p => p.id === id);
        document.getElementById('selectedPromoLabel').textContent = promo.name;
        document.getElementById('selectedPromoSub').textContent = promo.desc;
        document.getElementById('promoContainer').classList.add('border-satset-green', 'bg-satset-green/5');
        hidePromoModal();
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
                    `<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> CHECKING RANGER...`;

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
                if (!result.success || !result.data || result.data.available_ranger <= 0) {
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
                idLokasi: orderData.idLokasi
            };

            // Add voucher info if strictly paying with voucher
            if (orderData.payment_method === 'voucher') {
                if (orderData.availableVouchers.length > 0) {
                    payload.voucher_id = orderData.availableVouchers[0].id;
                } else {
                    showAlert("Saldo Tidak Cukup", "Voucher Pembayaran kamu tidak mencukupi.", 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalContent;
                    return;
                }
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
                showAlert("Gagal", orderResult.message || "Gagal membuat pesanan.", 'error');
                btn.disabled = false;
                btn.innerHTML = originalContent;
                return;
            }

            // 2. Handle Navigation
            if (orderData.payment_method === 'voucher') {
                currentStep = 4;
                updateStep();
            } else {
                currentStep = 31;
                updateStep();
            }
        } catch (error) {
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

        if (currentStep < 4) {
            footerAction.style.display = 'block';
            const btn = footerAction.querySelector('button');
            btn.disabled = false;

            let btnText = "LANJUTKAN";
            if (currentStep === 3) btnText = "BAYAR SEKARANG";
            if (currentStep === 31) btnText = "KONFIRMASI PEMBAYARAN BERHASIL";

            btn.innerHTML =
                `${btnText} <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2"><polyline points="9 18 15 12 9 6"></polyline></svg>`;
        } else {
            footerAction.style.display = 'none';
        }

        cancelBtn.style.display = (currentStep < 4) ? 'flex' : 'none';
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
        document.getElementById('cancelModal').classList.remove('hidden');
    }

    function hideCancelModal() {
        document.getElementById('cancelModal').classList.add('hidden');
    }

    function showRangerModal() {
        document.getElementById('rangerNotAvailableModal').classList.remove('hidden');
    }

    function hideRangerModal() {
        document.getElementById('rangerNotAvailableModal').classList.add('hidden');
    }

    function confirmCancel() {
        window.location.href = '{{ route('dashboard') }}';
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateStep();
    });
</script>
