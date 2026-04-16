<div id="statusAlertModal" class="fixed inset-0 z-50 flex items-center justify-center p-6 hidden">
    <div class="modal-backdrop absolute inset-0 bg-black/50" onclick="hideStatusAlert()"></div>
    <div class="relative bg-white rounded-[32px] border-none p-8 shadow-2xl max-w-md w-full animate-zoom-in">
        <div id="alertIconContainer" class="w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg id="alertIcon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                class="text-amber-500">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                </path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </div>

        <h3 id="alertTitle" class="text-2xl font-black text-gray-800 text-center mb-4">
            Perhatian
        </h3>

        <p id="alertMessage" class="text-center text-gray-500 font-medium mb-8 leading-relaxed">
            Silakan lengkapi data terlebih dahulu.
        </p>

        <button onclick="hideStatusAlert()" id="alertBtn"
            class="bg-satset-green hover:bg-satset-dark text-white font-black h-16 rounded-2xl w-full transition-all shadow-lg shadow-satset-green/20 btn-scale flex items-center justify-center uppercase tracking-widest">
            OKE, SIAP!
        </button>
    </div>
</div>

<script>
    function showAlert(title, message, type = 'warning', btnText = 'OKE, SIAP!') {
        const modal = document.getElementById('statusAlertModal');
        const titleEl = document.getElementById('alertTitle');
        const messageEl = document.getElementById('alertMessage');
        const btnEl = document.getElementById('alertBtn');
        const iconContainer = document.getElementById('alertIconContainer');
        const icon = document.getElementById('alertIcon');

        titleEl.textContent = title;
        messageEl.innerHTML = message;
        btnEl.textContent = btnText;

        if (type === 'error') {
            iconContainer.className = "w-20 h-20 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6";
            icon.className.baseVal = "text-red-500";
        } else if (type === 'success') {
            iconContainer.className = "w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6";
            icon.className.baseVal = "text-green-500";
            icon.innerHTML = '<polyline points="20 6 9 17 4 12"></polyline>';
        } else {
            iconContainer.className = "w-20 h-20 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-6";
            icon.className.baseVal = "text-amber-500";
        }

        modal.classList.remove('hidden');
    }

    function hideStatusAlert() {
        document.getElementById('statusAlertModal').classList.add('hidden');
    }
</script>
