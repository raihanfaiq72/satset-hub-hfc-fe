<!-- JavaScript -->
<script>
    // State management
    let currentTab = 'mine';
    let showPayment = false;
    let paymentStep = 1;
    let selectedVoucher = null;
    let quantity = 1;
    let availableVouchers = [];

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
        
        // Filter available vouchers for this batch
        if (window.allVouchers) {
            availableVouchers = window.allVouchers.filter(v => v.batch_id === voucher.id && v.status === 'available');
        } else {
            availableVouchers = [];
        }

        if (availableVouchers.length === 0) {
            alert('Stok voucher ini sedang kosong.');
            return;
        }

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
        const template = document.getElementById(`tpl-payment-step-${paymentStep}`);

        if (!template) {
            console.error(`Template tpl-payment-step-${paymentStep} not found`);
            return;
        }

        const clone = template.content.cloneNode(true);

        // Update dynamic content based on step
        if (paymentStep === 1) {
            const titleEl = clone.querySelector('.js-voucher-title');
            const priceEl = clone.querySelector('.js-voucher-price');
            const stockEl = clone.querySelector('.js-stock-text');
            const quantityEl = clone.querySelector('.js-quantity-text');
            const totalEl = clone.querySelector('.js-total-price');

            if (titleEl) titleEl.textContent = selectedVoucher.title;
            if (priceEl) priceEl.textContent = `Rp${selectedVoucher.price.toLocaleString('id-ID')}`;
            if (stockEl) stockEl.textContent = availableVouchers.length;
            if (quantityEl) quantityEl.textContent = quantity;
            if (totalEl) totalEl.textContent = `Rp${(selectedVoucher.price * quantity).toLocaleString('id-ID')}`;
        }

        content.innerHTML = '';
        content.appendChild(clone);
    }

    function updateQuantity(change) {
        const nextQuantity = quantity + change;
        if (nextQuantity >= 1 && nextQuantity <= availableVouchers.length) {
            quantity = nextQuantity;
            renderPaymentStep();
        }
    }

    function setQuantity(value) {
        if (value <= availableVouchers.length) {
            quantity = value;
        } else {
            quantity = availableVouchers.length;
        }
        renderPaymentStep();
    }

    function confirmPayment() {
        paymentStep = 2;
        renderPaymentStep();
    }

    async function simulateSuccess() {
        // Pick IDs to buy
        const idsToBuy = availableVouchers.slice(0, quantity).map(v => v.id);

        try {
            const response = await fetch(window.buyVoucherRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify({
                    voucher_ids: idsToBuy
                })
            });

            const result = await response.json();

            if (result.success) {
                paymentStep = 3;
                renderPaymentStep();
            } else {
                alert('Gagal membeli voucher: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error buying voucher:', error);
            alert('Terjadi kesalahan saat menghubungi server.');
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('mine');
    });
</script>
