<!-- Global Loading Overlay -->
<div id="globalLoadingOverlay" class="fixed inset-0 bg-white/90 backdrop-blur-sm z-[9999] hidden flex flex-col items-center justify-center p-10 text-center text-black">
    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-satset-green mb-6"></div>
    <p class="font-black uppercase italic tracking-widest text-xs">Sedang Memproses</p>
</div>

<script>
    function showLoading() {
        document.getElementById('globalLoadingOverlay').classList.remove('hidden');
    }

    function hideLoading() {
        document.getElementById('globalLoadingOverlay').classList.add('hidden');
    }

    // Auto show loading on page transitions (links, forms)
    window.addEventListener('beforeunload', function() {
        showLoading();
    });

    // Specific handle for links that are not just anchors
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && 
            link.href && 
            !link.href.includes('#') && 
            !link.target && 
            link.hostname === window.location.hostname &&
            !e.metaKey && !e.ctrlKey && !e.shiftKey && !e.altKey) {
            // Optional: can show loading here too if beforeunload is too late
        }
    });

    // Handle forms
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('form');
        if (form && !form.target) {
            showLoading();
        }
    });
</script>
