<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/bootstrap-4.0.0/css/bootstrap.min.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/images/wp/fav.png') ?>" type="image/x-icon">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <title>Data Dosen</title>
</head>

<body style="background-color:#d5b9a6">

    <?php foreach ($data as $key => $value) : ?>
    <?php endforeach; ?>
    <div class="container mt-4 mb-3 bg-white pb-3" style="border-radius: 3px; max-width:680px;">

        <div class="row">
            <div class="col-lg-12">
                <img class="mx-auto d-flex pt-3 pb-3" src="<?= base_url('assets/images/dosen_profile/' . $data['foto']); ?>" width="170px;" alt="">
            </div>
            <div class="col-lg-12">
                <hr>
            </div>
            <div class="col-lg-12">
                <h3 class="text-center font-weight-bold" style="font-family: 'Playfair Display', serif;"><?= $data['nama'] ?></h3>
            </div>
            <div class="col-lg-12">
                <h6 class="text-center">Nomor Induk Pegawai (NIP): <?= $data['nip'] ?></h6>
            </div>
            <div class="col-lg-12 container-fluid mt-4">
                <h5 style="font-weight: 600;">INFORMASI</h5>
                <p>Dosen Program Studi: <?= $data['prodi']; ?></p>
                <p>Judul skripsi yang pernah diampu:</p>
                <ul>
                    <?php foreach ($value as $row) : ?>

                        <li><?= $row; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>





    <!-- jQuery -->
    <script src="<?= base_url('assets/javascript/jquery-3.5.1.js') ?>" type="text/javascript"></script>
    <script src="<?= base_url('assets/bootstrap-4.0.0/js/bootstrap.min.js') ?>" type="text/javascript"></script>


</body>

</html>