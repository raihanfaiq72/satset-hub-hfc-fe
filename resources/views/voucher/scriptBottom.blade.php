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
            showAlert("Stok Habis", "Maaf, stok voucher ini sedang kosong.", 'warning');
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

        showLoading();
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
            hideLoading();

            if (result.success) {
                paymentStep = 3;
                renderPaymentStep();
            } else {
                showAlert("Gagal", result.message || "Gagal membeli voucher.", 'error');
            }
        } catch (error) {
            hideLoading();
            console.error('Error buying voucher:', error);
            showAlert("Kesalahan", "Terjadi kesalahan saat menghubungi server.", 'error');
        }
    }

    // Voucher Detail Logic
    function openVoucherDetail(id) {
        if (!window.userPaymentVouchers) return;

        const voucher = window.userPaymentVouchers.find(v => v.id === id);
        if (!voucher) {
            console.error('Voucher not found with ID:', id);
            return;
        }

        const page = document.getElementById('voucherDetailPage');
        if (!page) return;

        // Data Binding (No HTML in JS)
        const nameEl = page.querySelector('.js-detail-name');
        const typeEl = page.querySelector('.js-detail-type');
        const codeEl = page.querySelector('.js-detail-code');
        const statusEl = page.querySelector('.js-detail-status');
        const valueEl = page.querySelector('.js-detail-value');
        const validityEl = page.querySelector('.js-detail-validity');
        const descEl = page.querySelector('.js-detail-description');

        // Hero Components
        const gradientEl = page.querySelector('.js-detail-gradient');
        const imageBgEl = page.querySelector('.js-detail-image-bg');
        const imageOverlayEl = page.querySelector('.js-detail-image-overlay');
        const iconContainerEl = page.querySelector('.js-detail-icon-container');

        // Handle Background & Icon Visibility
        const hasImage = voucher.batch_info.voucher_image && voucher.batch_info.voucher_image !== '';

        if (hasImage) {
            if (imageBgEl) {
                imageBgEl.src = voucher.batch_info.voucher_image;
                imageBgEl.classList.remove('hidden');
            }
            if (imageOverlayEl) imageOverlayEl.classList.remove('hidden');
            if (gradientEl) gradientEl.classList.add('hidden');
            if (iconContainerEl) iconContainerEl.classList.add('hidden');
        } else {
            if (imageBgEl) {
                imageBgEl.src = '';
                imageBgEl.classList.add('hidden');
            }
            if (imageOverlayEl) imageOverlayEl.classList.add('hidden');
            if (gradientEl) gradientEl.classList.remove('hidden');
            if (iconContainerEl) iconContainerEl.classList.remove('hidden');
        }

        if (nameEl) nameEl.textContent = voucher.batch_info.voucher_name;
        if (typeEl) typeEl.textContent = voucher.batch_info.type;
        if (codeEl) codeEl.textContent = voucher.voucher_code;

        // Calculate Status
        const now = new Date();
        const validUntil = voucher.batch_info.valid_until ? new Date(voucher.batch_info.valid_until) : null;
        const isExpired = validUntil && validUntil < now;
        const isUsed = voucher.used_at !== null;

        let statusText = "Tersedia";
        let statusClass = "bg-green-100 text-satset-green";

        if (isUsed) {
            statusText = "Sudah Terpakai";
            statusClass = "bg-gray-100 text-gray-500";
        } else if (isExpired) {
            statusText = "Sudah Kadaluarsa";
            statusClass = "bg-red-100 text-red-500";
        }

        if (statusEl) {
            statusEl.textContent = statusText;
            statusEl.className =
                `text-[10px] font-black px-3 py-1 rounded-full uppercase js-detail-status ${statusClass}`;
        }

        if (valueEl) {
            const value = parseFloat(voucher.face_value);
            valueEl.textContent = `Rp${value.toLocaleString('id-ID')}`;
        }

        if (validityEl) {
            const from = new Date(voucher.batch_info.valid_from).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            const until = new Date(voucher.batch_info.valid_until).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            validityEl.textContent = `${from} - ${until}`;
        }

        if (descEl) descEl.textContent = voucher.batch_info.voucher_description;

        // Setup Buttons based on status
        const btnGift = page.querySelector('#btn-gift-voucher');
        const btnUse = page.querySelector('#btn-use-voucher');

        if (isUsed || isExpired) {
            // Disable and style buttons for inactive status
            const inactiveText = isUsed ? "Voucher Sudah Digunakan" : "Voucher Sudah Kadaluarsa";

            if (btnUse) {
                btnUse.textContent = inactiveText;
                btnUse.classList.add('bg-gray-300', 'cursor-not-allowed', 'opacity-50');
                btnUse.classList.remove('bg-satset-green', 'shadow-satset-green/20');
                btnUse.disabled = true;
                btnUse.onclick = null;
            }

            if (btnGift) {
                btnGift.classList.add('hidden'); // Hide gift button if used/expired
            }
        } else {
            // Reset to active state
            if (btnUse) {
                btnUse.textContent = "Gunakan Sekarang";
                btnUse.classList.remove('bg-gray-300', 'cursor-not-allowed', 'opacity-50');
                btnUse.classList.add('bg-satset-green', 'shadow-satset-green/20');
                btnUse.disabled = false;
                btnUse.onclick = () => {
                    showAlert("Coming Soon", "Fungsi gunakan voucher sedang dikembangkan secara satset!",
                    "success");
                };
            }

            if (btnGift) {
                btnGift.classList.remove('hidden');
                btnGift.onclick = () => {
                    const voucherType = voucher.voucher_type || 'payment';
                    window.location.href =
                        `{{ route('voucher.giftScan') }}?voucher_id=${voucher.id}&voucher_type=${voucherType}`;
                };
            }
        }

        // Transitions
        document.getElementById('voucherPage').classList.add('hidden');
        page.classList.remove('hidden');
    }

    function closeVoucherDetail() {
        document.getElementById('voucherDetailPage').classList.add('hidden');
        document.getElementById('voucherPage').classList.remove('hidden');
        document.body.style.overflow = 'auto';
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        switchTab('mine');

        // Header shadow on scroll
        // const header = document.getElementById('mainHeader');
        // window.addEventListener('scroll', () => {
        //     if (window.scrollY > 10) {
        //         header.classList.add('shadow-md');
        //         header.classList.remove('shadow-sm/0');
        //     } else {
        //         header.classList.remove('shadow-md');
        //         header.classList.add('shadow-sm/0');
        //     }
        // });
    });
</script>
