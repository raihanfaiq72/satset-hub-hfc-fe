<script>
    let currentStep = {{ session('p_step', 1) }};
    let viewMonth = new Date().getMonth();
    let viewYear = new Date().getFullYear();

    const today = new Date();
    const todayStr =
        `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;

    const orderData = {
        date: "{{ session('p_date') }}" || todayStr,
        time: "{{ session('p_time') }}" || "10:00",
        addressType: "{{ session('new_address_id', 'default') }}",
        addressName: "Alamat Default",
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

        let locText = orderData.addressName || "Lokasi";
        if (orderData.addressType === "new") {
            locText = orderData.newAddress.title || orderData.newAddress.address || "Alamat Baru";
        }

        template.getElementById('summaryLocation').textContent = locText;
        return template;
    }

    function renderSuccess() {
        return document.getElementById('tpl-step-4').content.cloneNode(true);
    }

    async function nextStep() {
        if (currentStep === 1) {
            if (!orderData.date) {
                alert("Silakan pilih tanggal terlebih dahulu secara satset!");
                return;
            }

            const btn = document.querySelector('#footerAction button');
            const originalContent = btn.innerHTML;

            try {
                // Show loading state
                btn.disabled = true;
                btn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    MENGECEK RANGER...
                `;

                const response = await fetch("{{ route('services.checkRanger') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
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

                // Success, move to step 2
                currentStep = 2;
                updateStep();
            } catch (error) {
                console.error("Check ranger error:", error);
                alert("Gagal mengecek ketersediaan ranger. Silakan coba lagi.");
                btn.disabled = false;
                btn.innerHTML = originalContent;
            }
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
            const btn = footerAction.querySelector('button');
            btn.disabled = false;
            const btnText = currentStep === 3 ? "KONFIRMASI PEMBAYARAN" : "LANJUTKAN";
            btn.innerHTML = `
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

    function selectAddress(type, name = "Alamat") {
        orderData.addressType = type;
        orderData.addressName = name;
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
