<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Pernikahan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            max-width: 420px; /* lebar layar mobile */
            margin: 0 auto;
            background-color: #f8f9fa;
        }

        #cover {
            height: 100vh;
            background: url('cover-image.jpg') no-repeat center center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            text-align: center;
            cursor: pointer;
        }

        #mainContent {
            display: none;
        }

        #gallery img {
            width: 100%;
            height: auto;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<!-- Cover Section -->
<div id="cover" onclick="hideCover()" style="color: black;"> 
    <h1>Selamat Datang di Undangan Pernikahan Kami</h1>
</div>

<!-- Main Content -->
<div id="mainContent" class="shadow">
    <!-- Nama Pengantin -->
    <section id="nama-pengantin" class="py-5 text-center">
        <div class="container">
            <h2>Pengantin</h2>
            <p>Nama Pengantin Pria & Nama Pengantin Wanita</p>
        </div>
    </section>

    <!-- Acara Resepsi dan Pernikahan -->
    <section id="acara" class="py-5 bg-light text-center">
        <div class="container">
            <h2>Acara Resepsi & Pernikahan</h2>
            <p>Resepsi: 1 Januari 2024, 10:00 AM - 12:00 PM</p>
            <p>Pernikahan: 1 Januari 2024, 12:00 PM - 02:00 PM</p>
            <p>Alamat: Jalan Kebahagiaan No. 123, Jakarta</p>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-5 text-center">
        <div class="container">
            <h2>Galeri</h2>
            <div class="row">
                <div class="col-md-4">
                    <img src="image1.jpg" alt="Gallery Image 1">
                </div>
                <div class="col-md-4">
                    <img src="image2.jpg" alt="Gallery Image 2">
                </div>
                <div class="col-md-4">
                    <img src="image3.jpg" alt="Gallery Image 3">
                </div>
            </div>
        </div>
    </section>

    <!-- Gift Section -->
    <section id="gift" class="py-5 bg-light text-center">
        <div class="container">
            <h2>Gift</h2>
            <p>Jika Anda ingin memberikan hadiah, silakan transfer ke rekening berikut:</p>
            <p>Bank ABC - 1234567890</p>
        </div>
    </section>

    <!-- Ucapan dan Doa -->
    <section id="ucapan" class="py-5 text-center">
        <div class="container">
            <h2>Ucapan dan Doa</h2>
            <form>
                <div class="mb-3">
                    <textarea class="form-control" rows="3" placeholder="Tulis ucapan atau doa di sini..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </section>
</div>

<script>
    function hideCover() {
        document.getElementById('cover').style.display = 'none';
        document.getElementById('mainContent').style.display = 'block';
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
