<div id="globalModal" class="fixed inset-0 z-[100] flex items-center justify-center p-6 hidden">
    <div class="modal-backdrop absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
        onclick="closeGlobalModal()"></div>
    <div class="relative bg-white rounded-[40px] border-none p-10 shadow-2xl max-w-sm w-full animate-slide-up">

        <!-- Icon Container -->
        <div id="modalIconContainer"
            class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-8 transition-colors">
            <!-- Icon will be injected here via JS -->
            <div id="modalIcon"></div>
        </div>

        <!-- Content -->
        <div class="text-center space-y-3 mb-10">
            <h3 id="modalTitle" class="text-3xl font-black text-gray-800 italic uppercase tracking-tighter">
                <!-- Title via JS -->
            </h3>
            <p id="modalMessage" class="text-center text-sm font-medium text-gray-400 leading-relaxed px-2">
                <!-- Message via JS -->
            </p>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-3">
            <button id="modalPrimaryBtn"
                class="w-full h-16 text-white font-black rounded-2xl transition-all uppercase tracking-widest active:scale-[0.98]">
                <!-- Action Text -->
            </button>
            <button id="modalSecondaryBtn" onclick="closeGlobalModal()"
                class="w-full h-14 bg-gray-100 hover:bg-gray-200 text-gray-600 font-black rounded-2xl transition-all uppercase tracking-widest active:scale-[0.98]">
                Batal
            </button>
        </div>
    </div>
</div>

<script>
    function showGlobalModal({
        title,
        message,
        type = 'warning',
        actionText,
        onAction
    }) {
        const modal = document.getElementById('globalModal');
        const iconContainer = document.getElementById('modalIconContainer');
        const icon = document.getElementById('modalIcon');
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const primaryBtn = document.getElementById('modalPrimaryBtn');

        // Set Content
        titleEl.textContent = title;
        messageEl.textContent = message;
        primaryBtn.textContent = actionText;

        // Reset Primary Button Classes
        primaryBtn.className = "w-full h-16 text-white font-black rounded-2xl transition-all uppercase tracking-widest active:scale-[0.98]";

        // Set Styles based on Type
        if (type === 'warning') {
            iconContainer.className =
                'w-24 h-24 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-8';
            icon.innerHTML =
                `<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="text-amber-500"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>`;
            primaryBtn.classList.add('bg-amber-500', 'hover:bg-amber-600', 'shadow-lg', 'shadow-amber-500/20');
        } else if (type === 'danger') {
            iconContainer.className = 'w-24 h-24 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-8';
            icon.innerHTML =
                `<svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor" class="text-red-500"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>`;
            primaryBtn.classList.add('bg-red-500', 'hover:bg-red-600', 'shadow-lg', 'shadow-red-500/20');
        } else {
            // Default success or other
            iconContainer.className = 'w-24 h-24 rounded-full bg-satset-green/10 flex items-center justify-center mx-auto mb-8';
            icon.innerHTML = `<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" class="text-satset-green"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
            primaryBtn.classList.add('bg-satset-green', 'hover:bg-satset-dark', 'shadow-lg', 'shadow-satset-green/20');
        }

        // Action binding
        primaryBtn.onclick = () => {
            if (onAction) onAction();
            closeGlobalModal();
        };

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeGlobalModal() {
        const modal = document.getElementById('globalModal');
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Wrapper to maintain compatibility with existing showAlert calls
    function showAlert(title, message, type = 'warning', actionText = 'OKE, SIAP!') {
        showGlobalModal({
            title: title,
            message: message,
            type: type === 'error' ? 'danger' : type,
            actionText: actionText
        });
    }
</script>
