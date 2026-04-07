<script>
        let currentSlide = 0;
        const carousel = document.querySelector('.carousel-container');
        const slides = document.querySelectorAll('.carousel-item');
        const totalSlides = slides.length;

        function autoScroll() {
            if (totalSlides > 0) {
                currentSlide = (currentSlide + 1) % totalSlides;
                carousel.scrollLeft = slides[currentSlide].offsetLeft;
            }
        }

        setInterval(autoScroll, 4000);

        document.querySelectorAll('.service-card').forEach(card => {
            card.addEventListener('click', function () {
                console.log('Service card clicked');
            });
        });

        document.querySelectorAll('.icon-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                console.log('Icon button clicked');
            });
        });

        document.querySelectorAll('.bottom-nav button').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.bottom-nav button').forEach(b => {
                    b.classList.remove('text-satset-green');
                    b.classList.add('text-gray-400');
                });

                this.classList.remove('text-gray-400');
                this.classList.add('text-satset-green');
            });
        });

    </script>