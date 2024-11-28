window.addEventListener("closeAddTamu", () => {
    const editModal = bootstrap.Modal.getInstance(
        document.getElementById("AddTamu")
    );
    if (editModal) {
        editModal.hide();
    }
    const backdrop = document.querySelector(".modal-backdrop");
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove("modal-open");
    document.body.style.overflow = "auto";
});
window.addEventListener("closeEditTamu", () => {
    const editModal = bootstrap.Modal.getInstance(
        document.getElementById("EditTamu")
    );
    if (editModal) {
        editModal.hide();
    }
    const backdrop = document.querySelector(".modal-backdrop");
    if (backdrop) {
        backdrop.remove();
    }
    document.body.classList.remove("modal-open");
    document.body.style.overflow = "auto";
});

window.addEventListener("open-new-tab", (event) => {
    window.open(event.detail[0].url, "_blank");
});

function copyToClipboard() {
    const input = document.getElementById('slugInput');
    const button = document.getElementById('copyButton');

    if (!input || !button) {
        console.error("Elemen input atau tombol tidak ditemukan!");
        return;
    }

    // Salin teks dari input ke clipboard
    navigator.clipboard.writeText(input.value).then(() => {
        // Ubah teks tombol dan tambahkan kelas sukses
        button.textContent = "Copied!";
        button.classList.remove("btn-danger");
        button.classList.add("btn-success");

        // Kembalikan tombol ke teks dan kelas semula setelah 2 detik
        setTimeout(() => {
            button.textContent = "Copy Link";
            button.classList.remove("btn-success");
            button.classList.add("btn-danger");
        }, 2000);
    }).catch(err => {
        console.error('Gagal menyalin teks:', err);
    });
}