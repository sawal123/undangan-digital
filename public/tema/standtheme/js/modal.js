(function () {
    const modal = document.getElementById('modal');
    const closeModal = document.getElementById('closeModal');
    const musicModal = document.getElementById('mod');
    const openMusic = document.getElementById('bukaModal');
    const closeMusic = document.getElementById('tutupModal');

    function openInvitation() {
        modal?.classList.add('is-hidden');
        document.body.classList.remove('is-locked');
        window.musicPlayer?.play?.().catch?.(() => {});
        window.setTimeout(() => window.scrollTo({ top: 0, behavior: 'smooth' }), 50);
    }

    closeModal?.addEventListener('click', openInvitation);
    modal?.addEventListener('click', (event) => {
        if (event.target === modal) openInvitation();
    });

    openMusic?.addEventListener('click', () => musicModal?.classList.remove('is-hidden'));
    closeMusic?.addEventListener('click', () => musicModal?.classList.add('is-hidden'));
    musicModal?.addEventListener('click', (event) => {
        if (event.target === musicModal) musicModal.classList.add('is-hidden');
    });

    document.addEventListener('click', (event) => {
        const copyButton = event.target.closest('[data-copy]');
        if (copyButton) {
            navigator.clipboard?.writeText(copyButton.dataset.copy).then(() => {
                const originalText = copyButton.textContent;
                copyButton.textContent = 'Tersalin';
                window.setTimeout(() => { copyButton.textContent = originalText; }, 1400);
            });
        }
    });

    document.querySelectorAll('[data-stand-countdown]').forEach((countdown) => {
        const target = new Date(countdown.dataset.date).getTime();
        if (!countdown.dataset.date || Number.isNaN(target)) return;

        const update = () => {
            const distance = Math.max(0, target - Date.now());
            const values = {
                days: Math.floor(distance / 86400000),
                hours: Math.floor((distance % 86400000) / 3600000),
                minutes: Math.floor((distance % 3600000) / 60000),
                seconds: Math.floor((distance % 60000) / 1000),
            };
            Object.entries(values).forEach(([unit, value]) => {
                const element = countdown.querySelector(`[data-unit="${unit}"]`);
                if (element) element.textContent = String(value).padStart(2, '0');
            });
            return target > Date.now();
        };

        update();
        const interval = window.setInterval(() => {
            if (!update()) window.clearInterval(interval);
        }, 1000);
    });
})();

function openStandLightbox(image) {
    const lightbox = document.getElementById('standLightbox');
    const lightboxImage = document.getElementById('standLightboxImage');
    if (!lightbox || !lightboxImage || !image) return;
    lightboxImage.src = image.currentSrc || image.src;
    lightboxImage.alt = image.alt || 'Pratinjau foto';
    lightbox.classList.remove('is-hidden');
}

function closeStandLightbox() {
    document.getElementById('standLightbox')?.classList.add('is-hidden');
}

document.addEventListener('click', (event) => {
    if (event.target.id === 'standLightbox') closeStandLightbox();
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') closeStandLightbox();
});
