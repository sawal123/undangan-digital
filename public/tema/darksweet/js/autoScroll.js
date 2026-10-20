(function () {
    const cover = document.getElementById('cover');
    const content = document.getElementById('content');
    const openCoverButton = document.getElementById('openCover');
    const scrollButton = document.getElementById('scrollButton');
    let animationFrameId = null;
    let scrolling = false;

    function revealInvitation() {
        cover?.classList.add('is-hidden');
        content?.classList.remove('is-locked');
        document.body.classList.remove('darksweet-locked');
        window.musicPlayer?.play?.().catch?.(() => {});
    }

    function stopAutoScroll() {
        scrolling = false;
        if (animationFrameId) cancelAnimationFrame(animationFrameId);
        scrollButton?.classList.remove('is-active');
    }

    function startAutoScroll() {
        if (scrolling) return;
        scrolling = true;
        scrollButton?.classList.add('is-active');
        const endY = Math.max(0, document.documentElement.scrollHeight - window.innerHeight);
        const step = Math.max(0.08, endY / 12000);

        function tick() {
            if (!scrolling) return;
            if (window.scrollY >= endY) {
                stopAutoScroll();
                return;
            }
            window.scrollTo(0, window.scrollY + step);
            animationFrameId = requestAnimationFrame(tick);
        }

        animationFrameId = requestAnimationFrame(tick);
    }

    openCoverButton?.addEventListener('click', function () {
        revealInvitation();
        window.setTimeout(() => window.scrollTo({ top: 0, behavior: 'smooth' }), 50);
    });

    scrollButton?.addEventListener('click', function () {
        scrolling ? stopAutoScroll() : startAutoScroll();
    });

    window.addEventListener('wheel', stopAutoScroll, { passive: true });
    window.addEventListener('touchmove', stopAutoScroll, { passive: true });
})();
