<script>
    document.querySelectorAll('.service-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('a')) {
                console.log('Service card clicked');
            }
        });
    });

    document.querySelectorAll('.bottom-nav button, .bottom-nav a').forEach(item => {
        item.addEventListener('click', function(e) {
            if (this.tagName === 'BUTTON') {
                e.preventDefault();
                
                document.querySelectorAll('.bottom-nav button').forEach(btn => {
                    btn.classList.remove('text-satset-green');
                    btn.classList.add('text-gray-400');
                });
                
                this.classList.remove('text-gray-400');
                this.classList.add('text-satset-green');
            }
        });
    });

    document.documentElement.style.scrollBehavior = 'smooth';
</script>