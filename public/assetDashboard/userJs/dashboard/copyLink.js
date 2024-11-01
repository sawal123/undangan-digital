function copyToClipboard() {
    // Ambil elemen teks yang akan disalin
    var copyText = document.getElementById("copyText").innerText;

    // Buat elemen input temporer untuk menyalin teks
    var tempInput = document.createElement("input");
    tempInput.value = copyText;
    document.body.appendChild(tempInput);

    // Pilih dan salin teks dari input temporer
    tempInput.select();
    tempInput.setSelectionRange(0, 99999); // Untuk perangkat mobile
    document.execCommand("copy");

    // Hapus elemen input temporer
    document.body.removeChild(tempInput);

    // Tampilkan pesan bahwa teks telah disalin
    // alert("Teks telah disalin ke clipboard!");
    $("#copyButton").removeClass("btn-dark").addClass("btn-secondary");
    $('#text').text('Paste')

}
