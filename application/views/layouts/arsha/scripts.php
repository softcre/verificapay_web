<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!-- Vendor JS -->
<script src="<?= arsha_asset('vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<script src="<?= arsha_asset('vendor/php-email-form/validate.js') ?>"></script>

<script src="<?= arsha_asset('vendor/aos/aos.js') ?>"></script>

<script src="<?= arsha_asset('vendor/glightbox/js/glightbox.min.js') ?>"></script>

<script src="<?= arsha_asset('vendor/swiper/swiper-bundle.min.js') ?>"></script>

<script src="<?= arsha_asset('vendor/waypoints/noframework.waypoints.js') ?>"></script>

<script src="<?= arsha_asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') ?>"></script>

<script src="<?= arsha_asset('vendor/isotope-layout/isotope.pkgd.min.js') ?>"></script>

<!-- Main JS -->
<script src="<?= arsha_asset('js/main.js') ?>"></script>

<script>
    document.querySelectorAll('[data-screenshot-carousel]').forEach((carousel) => {
        const slides = Array.from(carousel.querySelectorAll('.vp-screenshot'));
        const buttons = Array.from(carousel.querySelectorAll('[data-screenshot-target]'));
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let activeIndex = 0;
        let rotationTimer;

        const showSlide = (index) => {
            activeIndex = index;
            slides.forEach((slide, slideIndex) => {
                const isActive = slideIndex === activeIndex;
                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-hidden', String(!isActive));
            });
            buttons.forEach((button, buttonIndex) => {
                button.setAttribute('aria-pressed', String(buttonIndex === activeIndex));
            });
        };

        const stopRotation = () => {
            window.clearInterval(rotationTimer);
        };

        const startRotation = () => {
            stopRotation();
            if (!prefersReducedMotion && !document.hidden && slides.length > 1) {
                rotationTimer = window.setInterval(() => {
                    showSlide((activeIndex + 1) % slides.length);
                }, 6000);
            }
        };

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                showSlide(Number(button.dataset.screenshotTarget));
            });
        });

        carousel.addEventListener('mouseenter', stopRotation);
        carousel.addEventListener('mouseleave', startRotation);
        carousel.addEventListener('focusin', stopRotation);
        carousel.addEventListener('focusout', (event) => {
            if (!carousel.contains(event.relatedTarget)) {
                startRotation();
            }
        });
        document.addEventListener('visibilitychange', startRotation);

        startRotation();
    });
</script>

</body>
</html>