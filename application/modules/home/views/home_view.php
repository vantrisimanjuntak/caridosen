<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/images/wp/fav.png') ?>">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap-4.0.0/css/bootstrap.min.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/font-awesome-4.7.0/css/font-awesome.min.css') ?>">
    <!-- SweetAlert 2 CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/sweetalert2/package/dist/sweetalert2.min.css'); ?>">
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Esteban&family=Laila:wght@300&family=Lato&family=Lora&family=Playfair+Display&family=Zilla+Slab&display=swap" rel="stylesheet">
    <script src="<?= base_url('assets/javascript/jquery-3.5.1.min.js') ?>"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Catamaran&family=Crimson+Text:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mukta:wght@500&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">
    <!-- Another CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/style.css') ?>">
    <!-- Main JS -->
    <script src="<?= base_url('assets/javascript/main.js') ?>" type="text/javascript" language="javascript"></script>
    <script src="<?= base_url('assets/javascript/nav-scroll.js') ?>" type="text/javascript"></script>
    <!-- SweetAlert 2 JS -->
    <script src="<?= base_url('assets/sweetalert2/package/dist/sweetalert2.min.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="<?= base_url('assets/bootstrap-4.0.0/js/bootstrap.min.js'); ?>"></script>
    <style>
        .swal2-popup {
            font-size: 0.9rem !important;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="#">
                    <img src="<?= base_url('assets/images/wp/fav.png') ?>" width="30" height="30" class="d-inline-block align-top" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-lg-auto">
                        <li class="nav-item active ">
                            <a class="nav-link text-white" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">FAKULTAS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">TENTANG</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <section class="banner">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Cari Dosen Pembimbing Tugas Akhir? </h2>
                    <p>Ketik topikmu dikolom pencarian, dan biarkan kami mencoba untuk mencarikannya untukmu</p>
                    <!-- <button type="button" id="toWrapper" class="btnD1">Baca Disini</button> -->
                    <a href="#readmore" class="btnD1">Baca Disini</a>
                </div>
            </div>
        </div>
    </section>
    <hr style="width: 30vw;">
    <div class="container-fluid pt-4" id="readmore" style="background-color: #f6d7d1;">
        <div class="row">
            <div class="col-sm-6 col-md-4 p-4">
                <img src="<?= base_url('assets/images/wp/keyboard.png') ?>" class="mx-auto d-block" width="100px;" alt="">
                <h4 class="text-center font-weight-bold mt-3">Ketik</h4>
                <p class="text-center">Ketik tema atau topik tugas akhirmu di kolom pencarian</p>
            </div>
            <div class="col-sm-6 col-md-4 p-4">
                <img src="<?= base_url('assets/images/wp/find-my-friend.png') ?>" class="mx-auto d-block" width="100px" alt="">
                <h4 class="text-center font-weight-bold mt-3">Temukan</h4>
                <p class="text-center">Temukan dosen pembimbing pada hasil pencarian</p>
            </div>
            <div class="col-sm-12 col-md-4 p-4">
                <img src="<?= base_url('assets/images/wp/conversation.png') ?>" class="mx-auto d-block" width="100px;" alt="">
                <h4 class="text-center font-weight-bold mt-3">Hubungi</h4>
                <p class="text-center">Hubungi secara langsung dosen pembimbing yang kamu pilih</p>
            </div>
        </div>
    </div>
    <hr style="width: 30vw;">
    <div class="container mt-5" id="wrapper" style="height:400px">
        <h6 class="text-left font-weight-bold mb-1 mb-3" style="font-family: 'Roboto', sans-serif;">Topik apa yang sedang kamu pikirkan?</h6>
        <div class="input-group input-group-lg pt-1 mb-5">
            <input type="text" name="judul_skripsi" id="keyword" class="form-control" autocomplete="off" placeholder="" style="font-family: 'Times New Roman', Times, serif">
            <div class=" input-group-append">
                <button class="btn btn-outline-secondary search" type="button" id="btnSearch"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="d-flex justify-content-center text-center">
            <div id="overlay" style="display: none;">
                <img src="<?= base_url('assets/images/wp/35.gif'); ?>" alt="Loading" /><br />
                Sedang mencari ....
            </div>
        </div>
        <div class="container-fluid mb-3" id="result"></div>
    </div>
    <?php $this->load->view('footer') ?>
</body>

</html>