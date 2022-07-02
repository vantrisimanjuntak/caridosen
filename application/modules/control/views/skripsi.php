<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title; ?></title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= base_url('assets/images/wp/stta.png') ?>" type="image/x-icon">

    <script src="<?= base_url('assets/javascript/jquery-3.5.1.js') ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?= base_url('assets/javascript/main.js'); ?>"></script>
    <script type="javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/datatables.net-bs4/css/dataTables.bootstrap4.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/bootstrap/dist/css/bootstrap.min.css'); ?> ">
    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/themify-icons/css/themify-icons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/flag-icon-css/css/flag-icon.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/selectFX/css/cs-skin-elastic.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/control_template/vendors/jqvmap/dist/jqvmap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/control_template/assets/css/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/sweetalert2/package/dist/sweetalert2.min.css'); ?>">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>


</head>

<body>


    <!-- Left Panel -->

    <?php $this->load->view('control/side'); ?>

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?= strtoupper($session_access_user); ?>
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i> My Profile</a>
                            <a class="nav-link" href="<?= base_url('control/logout'); ?>"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>


                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->
        <div class="flash-data-for-skripsi" data-flashdata="<?= $this->session->flashdata('flash'); ?>"></div>

        <div class="card">
            <div class="card-header">
                <strong class="card-title">SKRIPSI</strong>
            </div>
            <br><br>
            <div class="container-fluid mb-4 mt-3" style="font-family: 'PT Serif', serif; ">
                <form action="<?= base_url('control/submitSkripsi'); ?>" method="POST" enctype="multipart/form-data" id="submitSkripsi">
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-lg-2 col-form-label">No. Reg</label>
                        <div class="col-md-2 col-lg-2">
                            <?php $no_reg = bin2hex(random_bytes(4)); ?>
                            <input type="text" name="no_reg" readonly autocomplete="off" id="" class="form-control" value="<?= $no_reg ?>">
                        </div>
                        <h4 class="mt-2" style="color:red" id="nip_result"></h4>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">NIM</label>
                        <div class="col-md-3">
                            <input type="text" name="nim" autocomplete="off" id="nim" class="form-control">
                        </div>
                        <div class="col-sm-5" style="color: red">
                            <small id="nim_result"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-lg-2 col-form-label">Judul Skripsi</label>
                        <div class="col-md-9">
                            <input type="text" name="judul_skripsi" autocomplete="off" id="judulskripsi" class="form-control" id="judul_skripsi">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Abstrak</label>
                        <div class="col-md-9">
                            <textarea name="abstrak" class="form-control" id="abstrak" cols="30" rows="20"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Dosen Pembimbing I</label>
                        <div class="col-md-5">
                            <select name="dp_satu" class="custom-select dosen_pembimbing" id="dp_satu">
                                <option value="">--PILIH DOSEN--</option>
                                <?php foreach ($allDosen as $row) : ?>
                                    <option value="<?= $row['nip'] ?>"><?= $row['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Dosen Pembimbing II</label>
                        <div class="col-md-5">
                            <select name="dp_dua" class="custom-select dosen_pembimbing" id="dp_dua">
                                <option value="">--PILIH DOSEN--</option>
                                <?php foreach ($allDosen as $row) : ?>
                                    <option value="<?= $row['nip'] ?>"><?= $row['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-md-2 col-form-label">Program Studi</label>
                        <div class="col-md-5">
                            <select name="program_studi" class="custom-select" id="program_studi">
                                <option value="">--PILIH PROGRAM STUDI--</option>
                                <?php foreach ($program_studi as $row) : ?>
                                    <option value="<?= $row['kd_program_studi'] ?>"><?= $row['program_studi']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary float-right" id="btnSubmit"><i class="fa fa-plus-square" aria-hidden="true"></i>&nbsp;&nbsp;Tambah</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
            <div class="card-body">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Mahasiswa</th>
                            <th>Judul Skripsi</th>
                            <th>Abstrak</th>
                            <th>DP 1</th>
                            <th>DP 2</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($allSkripsi as $data) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $data['mahasiswa']; ?></td>
                                <td><?= $data['judul_skripsi']; ?></td>
                                <td><?= substr($data['abstrak'], 0, 100); ?> ...
                                    <br><br><a href="" data-toggle="modal" data-target="#review<?= $data['no_reg']; ?>"><i>lihat selengkapnya</i></a>
                                </td>
                                <td><?= $data['dp_satu']; ?></td>
                                <td><?= $data['dp_dua']; ?></td>

                            </tr>

                            <div class="fade"></div>
                            <div class="modal fade" id="review<?= $data['no_reg']; ?>" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollabel">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Full Text</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body ">
                                            <div class="row mb-1">
                                                <div class="col-sm-3">Judul</div>
                                                <div class="col-sm-9"><b><?= $data['judul_skripsi'] ?></b></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-sm-3">NIM</div>
                                                <div class="col-sm-9"><?= $data['mahasiswa'] ?></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-sm-3">Dosen Pembimbing I</div>
                                                <div class="col-sm-9"><?= $data['dp_satu']; ?></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-sm-3">Dosen Pembimbing II</div>
                                                <div class="col-sm-9"><?= $data['dp_dua']; ?></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-sm-3">Program Studi</div>
                                                <div class="col-sm-9"><?= $data['prodi']; ?></div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-sm-3">Abstrak</div>
                                                <div class="col-sm-9"><?= $data['abstrak']; ?></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div><!-- /#right-panel -->

    <!-- Right Panel -->



    <script src="<?= base_url('assets/control_template/vendors/popper.js/dist/umd/popper.min.js') ?> "></script>
    <script src="<?= base_url('assets/control_template/vendors/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/chart.js/dist/Chart.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/assets/js/dashboard.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/assets/js/widgets.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/jqvmap/dist/jquery.vmap.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>

    <!-- DataTables JS -->
    <script src="<?= base_url('assets/control_template/vendors/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/jszip/dist/jszip.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/pdfmake/build/pdfmake.min.js'); ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/pdfmake/build/vfs_fonts.js'); ?>"></script>

    <script src="<?= base_url('assets/control_template/vendors/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/vendors/datatables.net-buttons/js/buttons.colVis.min.js') ?>"></script>
    <script src="<?= base_url('assets/control_template/assets/js/init-scripts/data-table/datatables-init.js') ?>"></script>
    <script src="<?= base_url('assets/sweetalert2/package/dist/sweetalert2.min.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        (function($) {
            "use strict";

            jQuery('#vmap').vectorMap({
                map: 'world_en',
                backgroundColor: null,
                color: '#ffffff',
                hoverOpacity: 0.7,
                selectedColor: '#1de9b6',
                enableZoom: true,
                showTooltip: true,
                values: sample_data,
                scaleColors: ['#1de9b6', '#03a9f5'],
                normalizeFunction: 'polynomial'
            });
        })(jQuery);
    </script>



</body>

</html>