document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const navBackdrop = document.querySelector('.nav-backdrop');
    const menuClose = document.querySelector('.menu-close');
    const menuItems = document.querySelectorAll('.menu-item');
    
    // Toggle menu function
    function toggleMenu(show = null) {
        const isActive = show ?? !mobileMenu.classList.contains('is-active');
        
        hamburger.classList.toggle('is-active', isActive);
        mobileMenu.classList.toggle('is-active', isActive);
        navBackdrop.classList.toggle('is-active', isActive);
        
        // Update ARIA attributes
        hamburger.setAttribute('aria-expanded', isActive);
        
        // Toggle body scroll
        document.body.style.overflow = isActive ? 'hidden' : '';
    }
    
    // Event Listeners
    hamburger?.addEventListener('click', () => toggleMenu());
    menuClose?.addEventListener('click', () => toggleMenu(false));
    navBackdrop?.addEventListener('click', () => toggleMenu(false));
    
    // Close menu on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && mobileMenu.classList.contains('is-active')) {
            toggleMenu(false);
        }
    });
    
    // Handle menu items with submenu
    menuItems.forEach(item => {
        const arrow = item.querySelector('.menu-arrow');
        if (arrow) {
            item.addEventListener('click', (e) => {
                if (e.target.closest('.menu-arrow')) {
                    e.preventDefault();
                    const isExpanded = arrow.style.transform === 'rotate(90deg)';
                    arrow.style.transform = isExpanded ? '' : 'rotate(90deg)';
                }
            });
        }
    });
    
    // Handle touch swipe
    let touchStartX = 0;
    let touchEndX = 0;
    
    mobileMenu?.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });
    
    mobileMenu?.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        const swipeDistance = touchEndX - touchStartX;
        
        // Close menu on swipe right
        if (swipeDistance > 50 && mobileMenu.classList.contains('is-active')) {
            toggleMenu(false);
        }
    }, { passive: true });
    
    // Close menu on window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024 && mobileMenu.classList.contains('is-active')) {
            toggleMenu(false);
        }
    });
});