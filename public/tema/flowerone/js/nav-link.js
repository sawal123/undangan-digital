document.addEventListener('DOMContentLoaded', () => {
    const links = [...document.querySelectorAll('#navbar .nav-link')];
    const sections = links
        .map(link => document.querySelector(link.getAttribute('href')))
        .filter(Boolean);
    if (!links.length || !sections.length) return;

    const activate = id => {
        links.forEach(link => link.classList.toggle('active', link.getAttribute('href') === `#${id}`));
    };

    const observer = new IntersectionObserver(entries => {
        const visible = entries.filter(entry => entry.isIntersecting).sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
        if (visible) activate(visible.target.id);
    }, { rootMargin: '-42% 0px -48% 0px', threshold: [0, .25, .6] });

    sections.forEach(section => observer.observe(section));
    activate(sections[0].id);
});
