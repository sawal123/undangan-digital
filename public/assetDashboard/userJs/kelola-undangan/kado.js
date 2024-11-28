const removeBackdrop = () => {
    const backdrop = document.querySelector(".modal-backdrop");
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove("modal-open"); // Menghilangkan class `modal-open` dari body
    document.body.style.overflow = "auto";
};

window.addEventListener("closeAddKado", () => {
    const editModal = bootstrap.Modal.getInstance(
        document.getElementById("AddKado")
    );
    if (editModal) {
        editModal.hide();
    }
    removeBackdrop();
});
