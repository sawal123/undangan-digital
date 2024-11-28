
window.addEventListener("close-hapus", () => {
    const editModalElement = document.getElementById("hapusGalery");
    const editModalInstance = bootstrap.Modal.getInstance(editModalElement);
    if (editModalInstance) {
        editModalInstance.hide();
    }
    removeBackdrop();
});
const removeBackdrop = () => {
    const backdrop = document.querySelector(".modal-backdrop");
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove("modal-open"); // Menghilangkan class `modal-open` dari body
    document.body.style.overflow = "auto";
};
window.addEventListener("closeAdd", () => {
    const editModalElement = document.getElementById("AddVideo");
    const editModalInstance = bootstrap.Modal.getInstance(editModalElement);
    if (editModalInstance) {
        editModalInstance.hide();
    }
    removeBackdrop();
});
window.addEventListener("closeAddPoto", () => {
    const editModalElement = document.getElementById("AddPoto");
    const editModalInstance = bootstrap.Modal.getInstance(editModalElement);
    if (editModalInstance) {
        editModalInstance.hide();
    }
    removeBackdrop();
});
