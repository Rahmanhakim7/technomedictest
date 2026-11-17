const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const toggleButton = document.getElementById('sidebarToggle');
const closeButton = document.getElementById('sidebarClose');

const isDesktop = () => window.matchMedia('(min-width: 1024px)').matches;

function setSidebarAccessibility(isOpen) {
    if (!sidebar || !overlay) {
        return;
    }

    const shouldBeInert = !isDesktop() && !isOpen;

    sidebar.toggleAttribute('inert', shouldBeInert);
    overlay.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    toggleButton?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
}

function openSidebar() {
    if (!sidebar || !overlay) {
        return;
    }

    sidebar.classList.remove('-translate-x-full');
    overlay.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    setSidebarAccessibility(true);
}

function closeSidebar() {
    if (!sidebar || !overlay) {
        return;
    }

    sidebar.classList.add('-translate-x-full');
    overlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    setSidebarAccessibility(false);
}

toggleButton?.addEventListener('click', () => {
    if (sidebar?.classList.contains('-translate-x-full')) {
        openSidebar();
    } else {
        closeSidebar();
    }
});

closeButton?.addEventListener('click', closeSidebar);
overlay?.addEventListener('click', closeSidebar);

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !isDesktop()) {
        closeSidebar();
    }
});

sidebar?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
        if (!isDesktop()) {
            closeSidebar();
        }
    });
});

window.addEventListener('resize', () => {
    if (isDesktop()) {
        overlay?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        setSidebarAccessibility(true);
    } else if (sidebar?.classList.contains('-translate-x-full')) {
        setSidebarAccessibility(false);
    }
});

if (!isDesktop()) {
    setSidebarAccessibility(false);
} else {
    setSidebarAccessibility(true);
}
