// animation.js - Kích hoạt animation khi cuộn trang (AOS-like)
document.addEventListener('DOMContentLoaded', function() {
    function animateOnScroll() {
        document.querySelectorAll('[data-animate]').forEach(function(el) {
            var rect = el.getBoundingClientRect();
            if (rect.top < window.innerHeight - 40) {
                el.classList.add('animated');
            }
        });
    }
    animateOnScroll();
    window.addEventListener('scroll', animateOnScroll);
});