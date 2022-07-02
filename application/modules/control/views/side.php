<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="./"><b>DASHBOARD</b>Control</a>
            <!-- <a class="navbar-brand hidden" href="./"><img src="<?= base_url('assets/control_template/images/logo2.png'); ?>" alt="Logo"></a> -->
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="<?= base_url('control'); ?>"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                <h3 class="menu-title">KAMPUS</h3><!-- /.menu-title -->
                <li class="">
                    <a href="<?= base_url('control/lecture'); ?>" class="dropdown-toggle"> <i class="menu-icon fa fa-users"></i>Dosen</a>
                </li>
                <li class="">
                    <a href="<?= base_url('control/mahasiswa') ?>"> <i class="menu-icon fa fa-users"></i>Mahasiswa</a>
                </li>
                <li class="">
                    <a href="<?= base_url('control/skripsi') ?>"> <i class="menu-icon fa fa-file-text"></i>Skripsi</a>
                </li>

                <h3 class="menu-title">Utilitas</h3><!-- /.menu-title -->
                <li>
                    <a href="<?= base_url('control/stopword'); ?>"> <i class="menu-icon fa fa-font"></i>Stopwords</a>
                </li>
                <li class="">
                    <a href="<?= base_url('control/imbuhan'); ?>"> <i class="menu-icon fa fa-text-width"></i>Kata Imbuhan</a>
                </li>


            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->