<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SatSet - Service Booking Mockup</title>
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
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideIn: {
                            '0%': { opacity: '0', transform: 'translateX(20px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        slideOut: {
                            '0%': { opacity: '1', transform: 'translateX(0)' },
                            '100%': { opacity: '0', transform: 'translateX(-20px)' }
                        },
                        zoomIn: {
                            '0%': { opacity: '0', transform: 'scale(0.95)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
                        },
                        bounceIn: {
                            '0%': { opacity: '0', transform: 'scale(0.3)' },
                            '50%': { opacity: '1', transform: 'scale(1.05)' },
                            '70%': { transform: 'scale(0.9)' },
                            '100%': { opacity: '1', transform: 'scale(1)' }
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
                <button id="backBtn" onclick="handleBack()" class="h-10 w-10 flex items-center justify-center rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
            
            <button id="cancelBtn" onclick="showCancelModal()" class="h-10 w-10 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
            <button onclick="nextStep()" class="w-full h-16 bg-satset-green hover:bg-satset-dark text-white font-black text-lg rounded-3xl shadow-xl shadow-satset-green/20 transition-all btn-scale flex items-center justify-center">
                LANJUTKAN
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ml-2">
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
                    Semua data yang sudah kamu isi akan terhapus. Apakah kamu yakin ingin membatalkan pesanan ini secara satset?
                </p>
                <div class="flex flex-col gap-3">
                    <button onclick="confirmCancel()" class="bg-red-500 hover:bg-red-600 text-white font-black h-14 rounded-2xl w-full transition-colors">
                        YA, BATALKAN
                    </button>
                    <button onclick="hideCancelModal()" class="border-2 border-gray-100 hover:bg-gray-50 font-bold h-14 rounded-2xl w-full transition-colors">
                        TIDAK, LANJUTKAN
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let viewMonth = 3;
        let viewYear = 2026;
        
        const orderData = {
            date: "2026-04-05",
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
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            return `${parseInt(parts[2])} ${monthNames[parseInt(parts[1]) - 1]} ${parts[0]}`;
        }

        function renderSchedule() {
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const dayNames = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
            
            const firstDay = new Date(viewYear, viewMonth, 1).getDay();
            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
            
            const headerHTML = dayNames.map(day => `<div class="text-center text-xs font-bold text-gray-400 py-1">${day}</div>`).join('');
            
            let daysHTML = '';
            for(let i = 0; i < firstDay; i++) {
                daysHTML += `<div></div>`;
            }
            
            for(let d = 1; d <= daysInMonth; d++) {
                const dateStr = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                const isSelected = orderData.date === dateStr;
                
                daysHTML += `
                    <button
                        onclick="selectDate('${dateStr}')"
                        class="slot-btn aspect-square w-full rounded-xl border-2 flex items-center justify-center p-0 ${
                            isSelected
                             ? "selected shadow-md border-satset-green"
                             : "border-gray-100 bg-white shadow-sm hover:border-satset-green/50"
                        }"
                    >
                        <span class="text-sm font-black ${isSelected ? 'text-white' : 'text-gray-800'}">${d}</span>
                    </button>
                `;
            }

            return `
                <div class="space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Pilih Tanggal
                            </h3>
                            <div class="flex items-center gap-3">
                                <button onclick="changeMonth(-1)" class="p-1.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                </button>
                                <span class="font-bold text-gray-800 text-sm w-24 text-center">${monthNames[viewMonth]} ${viewYear}</span>
                                <button onclick="changeMonth(1)" class="p-1.5 rounded-full bg-gray-50 text-gray-600 hover:bg-gray-100 transition-colors">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </button>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50/50 p-4 rounded-[24px] border-2 border-gray-100">
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                ${headerHTML}
                            </div>
                            <div class="grid grid-cols-7 gap-1.5">
                                ${daysHTML}
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2 text-lg">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Pilih Jam
                        </h3>
                        <div class="grid grid-cols-2 gap-3">
                            ${["08:00", "10:00", "14:00", "18:00"].map(time => `
                                <button
                                    onclick="selectTime('${time}')"
                                    class="slot-btn p-4 rounded-2xl border-2 font-black ${
                                        orderData.time === time
                                         ? "selected shadow-lg border-satset-green"
                                         : "border-gray-100 bg-white text-gray-600 shadow-sm"
                                    }"
                                >
                                    ${time} WIB
                                </button>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
        }

        function renderAddress() {
            return `
                <div class="space-y-6">
                    <div class="space-y-4">
                        ${[
                            { value: "default", title: "Rumah (Default)", desc: "Jl. Mawar No. 123, Semarang Tengah", icon: 'home' },
                            { value: "new", title: "Gunakan Alamat Baru", desc: "", icon: 'plus' }
                        ].map(addr => `
                            <label class="address-card flex items-center gap-4 p-5 rounded-2xl border-2 cursor-pointer ${
                                orderData.addressType === addr.value ? "selected" : "border-gray-100 bg-white shadow-sm"
                            }">
                                <input 
                                    type="radio" 
                                    name="address" 
                                    value="${addr.value}"
                                    ${orderData.addressType === addr.value ? 'checked' : ''}
                                    onchange="selectAddress('${addr.value}')"
                                    class="radio-custom"
                                />
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        ${addr.icon === 'home' ? `
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                            </svg>
                                        ` : `
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-satset-green">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                        `}
                                        <span class="font-bold text-gray-800">${addr.title}</span>
                                    </div>
                                    ${addr.desc ? `<p class="text-xs text-gray-500">${addr.desc}</p>` : ''}
                                </div>
                            </label>
                        `).join('')}
                    </div>

                    ${orderData.addressType === "new" ? `
                        <div class="space-y-2">
                            <input 
                                type="text" 
                                placeholder="Masukkan alamat lengkap pengiriman..."
                                class="h-14 rounded-2xl border-gray-200 focus:ring-satset-green w-full px-4 border-2"
                                onchange="updateCustomAddress(this.value)"
                            />
                        </div>
                    ` : ''}
                </div>
            `;
        }

        function renderPayment() {
            return `
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
                                    <span class="font-bold text-gray-800 text-right">${formatDate(orderData.date)},<br/>${orderData.time} WIB</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400 font-medium">Lokasi</span>
                                    <span class="font-bold text-gray-800 text-right truncate max-w-[150px]">
                                        ${orderData.addressType === "default" ? "Rumah" : orderData.customAddress || "Alamat Baru"}
                                    </span>
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
            `;
        }

        function renderSuccess() {
            return `
                <div class="flex flex-col items-center justify-center py-12 text-center space-y-6">
                    <div class="success-check h-40 w-40 bg-satset-green rounded-full flex items-center justify-center shadow-2xl shadow-satset-green/40">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    </div>
                    
                    <div>
                        <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Pembayaran Berhasil!</h2>
                        <p class="text-gray-500 mt-2 font-medium">Pesananmu sedang diproses secara satset dan aman.</p>
                    </div>

                    <button onclick="window.location.href='dashboard-mockup.html'" class="w-full bg-satset-green h-16 rounded-3xl font-black text-lg shadow-xl shadow-satset-green/20 transition-colors hover:bg-satset-dark">
                        KEMBALI KE BERANDA
                    </button>
                </div>
            `;
        }

        function nextStep() {
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
                content.innerHTML = stepContents[currentStep]();
                content.style.opacity = '1';
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
            window.location.href = '{{ url()->previous() }}';
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateStep();
        });
    </script>
</body>
</html>