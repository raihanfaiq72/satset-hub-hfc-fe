<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatSet - Service Booking Mockup</title>
    <link rel="icon" href="{{ asset('company-logo.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'satset-green': '#2d7a6e',
                        'satset-dark': '#246359'
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.7s ease-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-out': 'slideOut 0.3s ease-out',
                        'zoom-in': 'zoomIn 0.5s ease-out',
                        'bounce-in': 'bounceIn 0.6s ease-out'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            }
                        },
                        slideIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateX(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            }
                        },
                        slideOut: {
                            '0%': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            },
                            '100%': {
                                opacity: '0',
                                transform: 'translateX(-20px)'
                            }
                        },
                        zoomIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.95)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        },
                        bounceIn: {
                            '0%': {
                                opacity: '0',
                                transform: 'scale(0.3)'
                            },
                            '50%': {
                                opacity: '1',
                                transform: 'scale(1.05)'
                            },
                            '70%': {
                                transform: 'scale(0.9)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'scale(1)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @-moz-document url-prefix() {

            input[type="text"],
            input[type="email"] {
                -moz-appearance: none !important;
                appearance: none !important;
                color: #000000 !important;
                background-color: #ffffff !important;
            }
        }

        input {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            color: #000000 !important;
            background-color: #ffffff !important;
        }

        .step-content {
            transition: all 0.3s ease;
        }

        .step-enter {
            opacity: 0;
            transform: translateX(20px);
        }

        .step-enter-active {
            opacity: 1;
            transform: translateX(0);
        }

        .step-exit {
            opacity: 1;
            transform: translateX(0);
        }

        .step-exit-active {
            opacity: 0;
            transform: translateX(-20px);
        }

        .progress-bar {
            transition: width 0.5s ease;
        }

        .btn-scale:active {
            transform: scale(0.95);
        }

        .radio-custom {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .radio-custom:checked {
            border-color: #2d7a6e;
            background-color: #2d7a6e;
        }

        .radio-custom:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 8px;
            height: 8px;
            background-color: white;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .modal-backdrop {
            backdrop-filter: blur(8px);
        }

        .success-check {
            animation: bounceIn 0.6s ease-out;
        }

        .slot-btn {
            transition: all 0.2s ease;
        }

        .slot-btn:hover {
            transform: translateY(-1px);
        }

        .slot-btn.selected {
            border-color: #2d7a6e;
            background-color: #2d7a6e;
            color: white;
        }

        .address-card {
            transition: all 0.2s ease;
        }

        .address-card:hover {
            transform: translateY(-1px);
        }

        .address-card.selected {
            border-color: #2d7a6e;
            background-color: rgba(45, 122, 110, 0.05);
        }

        .qr-container {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-white min-h-screen">
    <div class="flex min-h-screen flex-col">
        <header class="px-5 py-6 flex items-center justify-between gap-4">
            <div class="flex items-center gap-4 flex-1">
                <button id="backBtn" onclick="handleBack()"
                    class="h-10 w-10 flex items-center justify-center rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                    </svg>
                </button>

                <div class="flex-1">
                    <h1 id="stepTitle" class="text-xl font-black text-gray-800">Atur Jadwal</h1>
                    <div id="progressContainer" class="h-1.5 w-full bg-gray-100 rounded-full mt-2 overflow-hidden">
                        <div id="progressBar" class="progress-bar h-full bg-satset-green" style="width: 33.33%"></div>
                    </div>
                </div>
            </div>

            <button id="cancelBtn" onclick="showCancelModal()"
                class="h-10 w-10 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </header>

        <main class="flex-1 px-5">
            <div id="stepContent" class="step-content">
            </div>
        </main>

        <div id="footerAction" class="p-6 border-t bg-white/80 backdrop-blur-md">
            <button onclick="nextStep()"
                class="w-full h-16 bg-satset-green hover:bg-satset-dark text-white font-black text-lg rounded-3xl shadow-xl shadow-satset-green/20 transition-all btn-scale flex items-center justify-center">
                LANJUTKAN
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>

        <div id="cancelModal" class="fixed inset-0 z-50 flex items-center justify-center p-6 hidden">
            <div class="modal-backdrop absolute inset-0 bg-black/50" onclick="hideCancelModal()"></div>
            <div class="relative bg-white rounded-[32px] border-none p-8 shadow-2xl max-w-md w-full">
                <h3 class="text-2xl font-black text-gray-800 text-center mb-4">
                    Batalkan Pesanan?
                </h3>
                <p class="text-center text-gray-500 font-medium mb-6">
                    Semua data yang sudah kamu isi akan terhapus. Apakah kamu yakin ingin membatalkan pesanan ini secara
                    satset?
                </p>
                <div class="flex flex-col gap-3">
                    <button onclick="confirmCancel()"
                        class="bg-red-500 hover:bg-red-600 text-white font-black h-14 rounded-2xl w-full transition-colors">
                        YA, BATALKAN
                    </button>
                    <button onclick="hideCancelModal()"
                        class="border-2 border-gray-100 hover:bg-gray-50 font-bold h-14 rounded-2xl w-full transition-colors">
                        TIDAK, LANJUTKAN
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Templates --}}
    @include('services.partials.step1_schedule')
    @include('services.partials.step2_address')
    @include('services.partials.step3_payment')
    @include('services.partials.step4_success')

    <script>
        let currentStep = 1;
        let viewMonth = new Date().getMonth();
        let viewYear = new Date().getFullYear();

        const orderData = {
            date: "",
            time: "10:00",
            addressType: "default",
            customAddress: ""
        };

        const stepContents = {
            1: renderSchedule,
            2: renderAddress,
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
                const btn = document.createElement('button');
                btn.type = "button";
                btn.onclick = () => selectDate(dateStr);
                btn.className =
                    `slot-btn aspect-square w-full rounded-xl border-2 flex items-center justify-center p-0 ${isSelected ? "selected shadow-md border-satset-green" : "border-gray-100 bg-white shadow-sm hover:border-satset-green/50"}`;
                btn.innerHTML =
                    `<span class="text-sm font-black ${isSelected ? 'text-white' : 'text-gray-800'}">${d}</span>`;
                daysContainer.appendChild(btn);
            }

            const timeGrid = template.getElementById('timeGrid');
            ["08:00", "10:00", "14:00", "18:00"].forEach(time => {
                const btn = document.createElement('button');
                btn.type = "button";
                btn.onclick = () => selectTime(time);
                btn.className =
                    `slot-btn p-4 rounded-2xl border-2 font-black ${orderData.time === time ? "selected shadow-lg border-satset-green" : "border-gray-100 bg-white text-gray-600 shadow-sm"}`;
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

            if (orderData.addressType === "new") {
                const inputContainer = template.getElementById('newAddressInputContainer');
                inputContainer.classList.remove('hidden');
                const input = template.getElementById('customAddressInput');
                input.value = orderData.customAddress;
            }

            return template;
        }

        function renderPayment() {
            const template = document.getElementById('tpl-step-3').content.cloneNode(true);
            template.getElementById('summaryTime').innerHTML = `${formatDate(orderData.date)},<br/>${orderData.time} WIB`;
            template.getElementById('summaryLocation').textContent = orderData.addressType === "default" ? "Rumah" : (
                orderData.customAddress || "Alamat Baru");
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
            if (currentStep < 4) {
                currentStep++;
                updateStep();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
            }
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
                if (currentStep === 2 && orderData.addressType === 'new') {
                    document.getElementById('customAddressInput')?.focus();
                }
            }, 150);

            const titles = {
                1: "Atur Jadwal",
                2: "Lokasi Layanan",
                3: "Pembayaran",
                4: "Selesai"
            };
            title.textContent = titles[currentStep];

            if (currentStep < 4) {
                progressBar.style.width = `${(currentStep / 3) * 100}%`;
                document.getElementById('progressContainer').style.display = 'block';
            } else {
                document.getElementById('progressContainer').style.display = 'none';
            }

            if (currentStep < 4) {
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

            cancelBtn.style.display = currentStep < 4 ? 'flex' : 'none';
            backBtn.style.display = currentStep === 4 ? 'none' : 'flex';
        }

        function selectDate(dateStr) {
            orderData.date = dateStr;
            updateStep();
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
</body>

</html>
