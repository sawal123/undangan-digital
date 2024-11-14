document.addEventListener("DOMContentLoaded", function () {

    const removeBackdrop = () => {
        const backdrop = document.querySelector(".modal-backdrop");
        if (backdrop) {
            backdrop.remove();
        }
        document.body.classList.remove("modal-open"); // Menghilangkan class `modal-open` dari body
        document.body.style.overflow = "auto";
    };
    window.addEventListener("openDelModal", () => {
        const editModal = new bootstrap.Modal(document.getElementById("hapusUcapan"));
        editModal.show();
    });

    window.addEventListener("closeDelModal", () => {
        const editModal = bootstrap.Modal.getInstance(document.getElementById("AddKado"));
        if (editModal) {
            editModal.hide();
        }
        removeBackdrop()
    });

    
});

document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('openModalCode', function () {
        var myModal = new bootstrap.Modal(document.getElementById('openModalCode')); 
        myModal.show();
    });

   
});

Livewire.on('refreshModal', () => {
    var myModal = new bootstrap.Modal(document.getElementById('openModalCode'));
    myModal.show();
});
