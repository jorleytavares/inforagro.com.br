/**
 * InfoRagro.com.br - JavaScript Principal
 */

document.addEventListener('DOMContentLoaded', function () {
    // Mobile Menu Toggle
    const btnMenu = document.getElementById('btn-menu');
    const navMenu = document.getElementById('nav-menu');

    if (btnMenu && navMenu) {
        btnMenu.addEventListener('click', function () {
            navMenu.classList.toggle('active');
            btnMenu.classList.toggle('active');
        });
    }

    // Close menu on link click (mobile)
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('active');
            btnMenu.classList.remove('active');
        });
    });

    // ===========================================
    // Search Dropdown (abaixo do header)
    // ===========================================
    const btnSearchToggle = document.getElementById('btn-search-toggle');
    const btnSearchClose = document.getElementById('btn-search-close');
    const searchDropdown = document.getElementById('search-dropdown');
    const searchInput = document.getElementById('search-dropdown-input');

    // Abrir dropdown
    if (btnSearchToggle && searchDropdown) {
        btnSearchToggle.addEventListener('click', function (e) {
            e.preventDefault();
            searchDropdown.classList.toggle('active');

            // Focar no input quando abrir
            if (searchDropdown.classList.contains('active')) {
                setTimeout(() => {
                    searchInput.focus();
                }, 300);
            }
        });
    }

    // Fechar dropdown
    if (btnSearchClose && searchDropdown) {
        btnSearchClose.addEventListener('click', function (e) {
            e.preventDefault();
            searchDropdown.classList.remove('active');
            searchInput.value = '';
        });
    }

    // Fechar com ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && searchDropdown && searchDropdown.classList.contains('active')) {
            searchDropdown.classList.remove('active');
            searchInput.value = '';
        }
    });

    // Atalho Ctrl+K / Cmd+K para abrir busca
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchDropdown) {
                searchDropdown.classList.add('active');
                setTimeout(() => {
                    searchInput.focus();
                }, 300);
            }
        }
    });

    // ===========================================
    // Newsletter form
    // ===========================================
    const newsletterForms = document.querySelectorAll('.newsletter-form, .newsletter-form-inline');
    newsletterForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            // Permitir submit real
        });
    });

    // ===========================================
    // Smooth scroll for anchor links
    // ===========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // ===========================================
    // Header scroll effect
    // ===========================================
    const header = document.getElementById('header');

    window.addEventListener('scroll', function () {
        const currentScroll = window.pageYOffset;

        if (header) {
            if (currentScroll > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
    });
});
