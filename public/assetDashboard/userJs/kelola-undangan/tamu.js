document.addEventListener("DOMContentLoaded", function () {
    const removeBackdrop = () => {
        const backdrop = document.querySelector(".modal-backdrop");
        if (backdrop) {
            backdrop.remove();
        }
        document.body.classList.remove("modal-open"); // Menghilangkan class `modal-open` dari body
        document.body.style.overflow = "auto";
    };

    window.addEventListener("closeDelModal", () => {
        const editModal = bootstrap.Modal.getInstance(
            document.getElementById("AddTamu")
        );
        if (editModal) {
            editModal.hide();
        }
    });
    window.addEventListener("closeEditModal", () => {
        const editModal = bootstrap.Modal.getInstance(
            document.getElementById("EditTamu")
        );
        if (editModal) {
            editModal.hide();
        }
        removeBackdrop()
    });

    window.addEventListener("openModalShare", () => {
        const editModal = new bootstrap.Modal(
            document.getElementById("shareTamu")
        );
        editModal.show();
    });
    window.addEventListener("openModalEdit", () => {
        const editModal = new bootstrap.Modal(
            document.getElementById("EditTamu")
        );
        editModal.show();
    });

   
});
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('open-new-tab', event => {
        window.open(event.detail[0].url, '_blank');
    });
});
