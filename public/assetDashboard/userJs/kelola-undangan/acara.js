document.addEventListener("DOMContentLoaded", function () {
    const removeBackdrop = () => {
        const backdrop = document.querySelector(".modal-backdrop");
        if (backdrop) {
            backdrop.remove();
        }
        document.body.classList.remove("modal-open"); // Menghilangkan class `modal-open` dari body
    };

    // Event untuk membuka modal EditAcara
    window.addEventListener("openEditModal", () => {
        const editModal = new bootstrap.Modal(
            document.getElementById("EditAcara")
        );
        editModal.show();
    });
    window.addEventListener("openDeleteModal", () => {
        const editModal = new bootstrap.Modal(
            document.getElementById("hapusAcara")
        );
        editModal.show();
    });

    // Event untuk menutup modal AddAcara
    window.addEventListener("close-modal", () => {
        const addModalElement = document.getElementById("AddAcara");
        const addModalInstance = bootstrap.Modal.getInstance(addModalElement);
        if (addModalInstance) {
            addModalInstance.hide();
        }
        removeBackdrop();
    });

    // Event untuk menutup modal EditAcara
    window.addEventListener("tutup-modal", () => {
        const editModalElement = document.getElementById("EditAcara");
        const editModalInstance = bootstrap.Modal.getInstance(editModalElement);
        if (editModalInstance) {
            editModalInstance.hide();
        }
        removeBackdrop();
    });
    window.addEventListener("close-hapus", () => {
        const editModalElement = document.getElementById("hapusAcara");
        const editModalInstance = bootstrap.Modal.getInstance(editModalElement);
        if (editModalInstance) {
            editModalInstance.hide();
        }
        removeBackdrop();
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Close the modal after the deletion
    window.livewire.on('close-modal', () => {
        $('#deleteModal').modal('hide');
    });

    // Confirm delete button click event
    document.getElementById('confirmDelete').addEventListener('click', function() {
        window.livewire.emit('delete'); // Call the delete method
    });
});
