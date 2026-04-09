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

    function renderNewAddressForm() {
        const template = document.getElementById('tpl-step-21').content.cloneNode(true);

        // Populate inputs from existing orderData if any
        template.getElementById('locNameInput').value = orderData.newAddress.title;
        template.getElementById('locRTInput').value = orderData.newAddress.rt;
        template.getElementById('locRWInput').value = orderData.newAddress.rw;
        template.getElementById('picNameInput').value = orderData.newAddress.namaPIC;
        template.getElementById('picPhoneInput').value = orderData.newAddress.noHpPIC;
        template.getElementById('buildingTypeInput').value = orderData.newAddress.jenisBangunan;
        template.getElementById('fullAddressArea').value = orderData.newAddress.address;

        template.getElementById('formDate').value = orderData.date;
        template.getElementById('formTime').value = orderData.time;

        // Delay map and TomSelect initialization until after it's in the DOM
        setTimeout(() => {
            initTomSelects();
            fetchProvinces();
        }, 300);

        return template;
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
            // Trigger standard form submission (Non-AJAX)
            const form = document.getElementById('newAddressForm');
            if (form) {
                // Ensure date/time are latest
                document.getElementById('formDate').value = orderData.date;
                document.getElementById('formTime').value = orderData.time;

                // Validation check before submit
                if (form.checkValidity()) {
                    document.getElementById('submitNewAddress').click();
                } else {
                    form.reportValidity();
                }
            }
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
