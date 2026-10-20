function openModalImg(image) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    if (!modal || !modalImage || !image) return;

    modalImage.src = image.currentSrc || image.src;
    modalImage.alt = image.alt || 'Pratinjau foto';
    modal.classList.remove('is-hidden');
}

function closeModalImg() {
    document.getElementById('imageModal')?.classList.add('is-hidden');
}

document.addEventListener('click', function (event) {
    if (event.target.id === 'imageModal') closeModalImg();
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') closeModalImg();
});
