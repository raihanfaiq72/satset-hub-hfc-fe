<!-- JavaScript -->
<script>
    // State management
    let currentTab = 'mine';
    let showPayment = false;
    let paymentStep = 1;
    let selectedVoucher = null;
    let quantity = 1;

    // Tab switching
    function switchTab(tab) {
        currentTab = tab;

        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.getElementById(`tab-${tab}`).classList.add('active');

        // Update tab content
        document.querySelectorAll('#tabContent > div').forEach(content => {
            content.classList.add('hidden');
        });
        document.getElementById(`content-${tab}`).classList.remove('hidden');
    }

    // Payment functions
    function openPayment(voucher) {
        selectedVoucher = voucher;
        showPayment = true;
        paymentStep = 1;
        quantity = 1;

        // Show payment modal
        document.getElementById('voucherPage').classList.add('hidden');
        document.getElementById('paymentModal').classList.remove('hidden');

        renderPaymentStep();
    }

    function backFromPayment() {
        if (paymentStep === 1) {
            closePayment();
        } else {
            paymentStep = 1;
            renderPaymentStep();
        }
    }

    function closePayment() {
        showPayment = false;
        document.getElementById('voucherPage').classList.remove('hidden');
        document.getElementById('paymentModal').classList.add('hidden');
    }

    function renderPaymentStep() {
        const content = document.getElementById('paymentContent');

        if (paymentStep === 1) {
            content.innerHTML = `
                    <div class="space-y-8">
                        <!-- Voucher Info -->
                        <div class="border-none bg-gray-50 rounded-[32px] p-6 flex items-center gap-4">
                            <div class="h-16 w-16 relative rounded-2xl overflow-hidden shadow-md">
                                <div class="w-full h-full bg-gradient-to-br from-satset-green to-satset-dark flex items-center justify-center">
                                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 9a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9Z"></path>
                                        <path d="M9 9l3 3-3 3"></path>
                                        <path d="M15 9l-3 3 3 3"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="font-black text-gray-800 text-lg">${selectedVoucher.title}</h3>
                                <p class="text-xs font-bold text-satset-green">Rp${selectedVoucher.price.toLocaleString()}</p>
                            </div>
                        </div>

                        <!-- Quantity Selection -->
                        <div class="space-y-4">
                            <h4 class="font-black text-gray-800 uppercase text-sm italic">Pilih Jumlah</h4>
                            <div class="flex items-center justify-center gap-8 bg-gray-50 p-6 rounded-[32px]">
                                <button onclick="updateQuantity(-1)" class="quantity-btn h-12 w-12 rounded-full bg-white flex items-center justify-center shadow-md">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                                <span class="text-3xl font-black text-gray-800">${quantity}</span>
                                <button onclick="updateQuantity(1)" class="quantity-btn h-12 w-12 rounded-full bg-satset-green text-white flex items-center justify-center shadow-md">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <button onclick="setQuantity(5)" class="py-2 rounded-xl bg-gray-100 text-[10px] font-black">BUNDLE 5</button>
                                <button onclick="setQuantity(10)" class="py-2 rounded-xl bg-gray-100 text-[10px] font-black">BUNDLE 10</button>
                            </div>
                        </div>

                        <!-- Fixed Bottom -->
                        <div class="fixed bottom-0 left-0 right-0 p-6 bg-white border-t">
                            <div class="flex justify-between items-center mb-4 px-2">
                                <p class="text-sm font-bold text-gray-400 uppercase">Total Bayar</p>
                                <p class="text-2xl font-black text-satset-green">Rp${(selectedVoucher.price * quantity).toLocaleString()}</p>
                            </div>
                            <button onclick="confirmPayment()" class="w-full h-16 bg-satset-green rounded-3xl font-black text-lg text-white btn-scale">
                                KONFIRMASI BELI
                            </button>
                        </div>
                    </div>
                `;
        } else if (paymentStep === 2) {
            content.innerHTML = `
                    <div class="space-y-6 flex flex-col items-center">
                        <div class="qr-container p-5 bg-white rounded-[32px] shadow-2xl border-4 border-gray-50 mt-10">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=VOUCHER-PAY" alt="QRIS" class="w-52 h-52" />
                        </div>
                        <p class="text-xs font-black text-gray-400 uppercase tracking-widest text-center leading-relaxed">
                            Selesaikan Pembayaran<br/>Untuk Mengaktifkan Voucher
                        </p>
                        <button onclick="simulateSuccess()" class="w-full h-16 bg-satset-green rounded-3xl font-black mt-10 text-white btn-scale">
                            SIMULASI BERHASIL
                        </button>
                    </div>
                `;
        } else if (paymentStep === 3) {
            content.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-12 text-center space-y-6">
                        <div class="success-check h-40 w-40 bg-satset-green rounded-full flex items-center justify-center shadow-2xl shadow-satset-green/40">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Voucher Berhasil Dibeli!</h2>
                            <p class="text-gray-500 mt-2 font-medium">Voucher otomatis ditambahkan ke koleksi kamu.</p>
                        </div>
                        <button onclick="closePayment()" class="w-full bg-satset-green h-16 rounded-3xl font-black text-lg text-white btn-scale">
                            LIHAT VOUCHER SAYA
                        </button>
                    </div>
                `;
        }
    }

    function updateQuantity(change) {
        quantity = Math.max(1, quantity + change);
        renderPaymentStep();
    }

    function setQuantity(value) {
        quantity = value;
        renderPaymentStep();
    }

    function confirmPayment() {
        paymentStep = 2;
        renderPaymentStep();
    }

    function simulateSuccess() {
        paymentStep = 3;
        renderPaymentStep();
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function () {
        switchTab('mine');
    });

</script>
