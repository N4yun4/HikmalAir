document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;
    const mainNavbar = document.querySelector('.main-navbar-custom');
    const secondaryNavbar = document.querySelector('.secondary-navbar-custom');
    let mainNavbarHeight = 0;

    function updateNavbarPositions() {
        if (mainNavbar) {
            mainNavbarHeight = mainNavbar.offsetHeight;
        }
        if (secondaryNavbar) {
            secondaryNavbar.style.top = mainNavbarHeight + 'px';
        }
    }

    updateNavbarPositions();
    window.addEventListener('resize', updateNavbarPositions);

    const scrollThreshold = mainNavbarHeight > 0 ? mainNavbarHeight / 3 : 20;

    window.addEventListener('scroll', function() {
        if (window.scrollY > scrollThreshold) {
            body.classList.add('navbar-scrolled');
        } else {
            body.classList.remove('navbar-scrolled');
        }
    });
});
