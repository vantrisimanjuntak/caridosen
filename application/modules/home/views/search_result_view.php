<div class="row">
    <div class="col-lg-12 mt-3">
        <button class="btn btn-success pull-right text-white" style="border-radius: 28px;" data-toggle="modal" data-target="#hasil">Lihat Perhitungan</button>
    </div>
</div>
<?php
$no = 1;
foreach ($get_result->result_array() as $row) : ?>
    <div class="modal fade bd-example-modal-lg" id="hasil" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold">Hasil Perhitungan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"> &times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Hasil perhitungan kata kunci <code style="background-color: #eee; border-radius:3px; font-family:'Courier New', Courier, monospace"><?= $row['keyword'] ?></code> memiliki kesamaan dengan beberapa judul, yakni:
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Skor</th>
                                <th scope="col">Dosen 1</th>
                                <th scope="col">Dosen 2</th>
                            </tr>
                        </thead>
                        <?php
                        $no = 1;
                        foreach ($get_result->result_array() as $row) : ?>

                            <tbody>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $row['judul'] ?></td>
                                    <td><?= round($row['skor'], 3)  ?></td>
                                    <td><?= $row['nama_dosen_1'] ?></td>
                                    <td><?= $row['nama_dosen_2'] ?></td>
                                </tr>
                            </tbody>
                        <?php endforeach; ?>
                    </table>
                    Lalu mengelompokkan setiap dosen yang sama untuk mengetahui skor setiap dosen. Hasil skor dapat dilihat diawal halaman pencarian.
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<div class="row">
    <?php foreach ($hasil as $key => $data) : ?>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 pt-2">
            <div class="card">
                <img class=" card-img-top" src="<?= base_url('assets/images/dosen_profile/' . $data['foto']); ?>" alt="Card image">
                <div class="card-body">
                    <h6 class="card-title font-weight-bold d-flex justify-content-center align-items-center" style="font-family: 'Source Sans Pro', sans-serif; height:46px;"><?= $data['nama'] ?></h6>
                    <h6 class="font-weight-bold">NIP</h6>
                    <p style="margin-top: -9px;"><?= $data['nip'] ?></p>
                    <h6 class="mt-3 font-weight-bold">Dosen Program Studi</h6>
                    <p style="margin-top:-9px"><?= $data['program_studi'] ?></p>
                    <h6 class="mt-3 font-weight-bold">Skor Pencarian</h6>
                    <p style="margin-top: -9px;"><?= $data['skor']; ?></p>
                    <!-- <h6 class="mt-3 font-weight-bold">Skor Pencarian (Persen)</h6> -->
                    <!-- <p style="margin-top: -9px;"><?= $data['skorPersen']; ?>%</p> -->
                    <a href="<?= base_url('dashboard/home/showSkripsiByNip/' . $data['nip']) ?>" target="_blank">
                        <button class="btn btn-primary">Lihat Profil</button>
                    </a>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>