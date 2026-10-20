const sections = [
    { id: 'couple', className: 'couple' },
    { id: 'date', className: 'date' },
    { id: 'location', className: 'location' },
    { id: 'gallery', className: 'gallery' },
    { id: 'wishes', className: 'wishes' },
];

if (!document.getElementById('gallery')) {
    document.querySelectorAll('.nav-link.gallery').forEach((link) => link.remove());
}

function setActive(className) {
    document.querySelectorAll('.nav-link').forEach((link) => {
        const isActive = link.classList.contains(className);

        link.classList.toggle('bg-orange-200', isActive);
        link.classList.toggle('text-black', isActive);
        link.classList.toggle('rounded-full', isActive);
        link.classList.toggle('text-orange-200', !isActive);
        link.classList.toggle('is-active', isActive);
    });
}

const observer = new IntersectionObserver((entries) => {
    const visibleEntry = entries
        .filter((entry) => entry.isIntersecting)
        .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

    if (!visibleEntry) return;

    const activeSection = sections.find((section) => section.id === visibleEntry.target.id);
    if (activeSection) setActive(activeSection.className);
}, {
    rootMargin: '-35% 0px -55% 0px',
    threshold: [0.1, 0.35, 0.7],
});

sections.forEach(({ id }) => {
    const element = document.getElementById(id);
    if (element) observer.observe(element);
});

document.querySelectorAll('.nav-link').forEach((link) => {
    link.addEventListener('click', () => {
        const activeSection = sections.find((section) => link.classList.contains(section.className));
        if (activeSection) setActive(activeSection.className);
    });
});
