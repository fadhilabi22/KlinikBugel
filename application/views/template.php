<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Sistem Klinik Bugel | <?= isset($title) ? $title : 'Dashboard'; ?></title>

    <link href="<?= base_url('assets/css/bootstrap.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/font-awesome.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/custom-styles.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/js/dataTables/dataTables.bootstrap.css') ?>" rel="stylesheet" />
</head>

<body>
    <div id="wrapper">

        <!-- TOP NAVBAR -->
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= base_url('dashboard') ?>">KLINIK BUGEL</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= base_url('auth/logout')?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <!-- SIDEBAR -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">

                    <li><a href="<?= base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>

                    <li>
                        <a href="#"><i class="fa fa-database"></i> Master Data <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('master/pasien') ?>"><i class="fa fa-users"></i> Data Pasien</a></li>
                            <li><a href="<?= base_url('master/dokter') ?>"><i class="fa fa-user-md"></i> Data Dokter</a></li>
                            <li><a href="<?= base_url('master/obat') ?>"><i class="fa fa-medkit"></i> Data Obat/Stok</a></li>
                            <li><a href="<?= base_url('master/poli') ?>"><i class="fa fa-hospital-o"></i> Data Poli</a></li>
                            <li><a href="<?= base_url('master/user') ?>"><i class="fa fa-key"></i> Manajemen User</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-stethoscope"></i> Transaksi Layanan <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('transaksi/pendaftaran') ?>"><i class="fa fa-edit"></i> Pendaftaran Pasien</a></li>
                            <li><a href="<?= base_url('transaksi/pemeriksaan') ?>"><i class="fa fa-clipboard"></i> Antrian & Pemeriksaan</a></li>
                            <li><a href="<?= base_url('transaksi/pembayaran') ?>"><i class="fa fa-money"></i> Pembayaran Kasir</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-file-text-o"></i> Laporan & Export <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('laporan/harian') ?>">Laporan Harian/Bulanan</a></li>
                            <li><a href="<?= base_url('laporan/excel') ?>">Export Excel</a></li>
                            <li><a href="<?= base_url('laporan/pdf') ?>" target="_blank">Export PDF</a></li>
                            <li><a href="<?= base_url('transaksi/pembayaran/struk_cetak') ?>"><i class="fa fa-print"></i> Cetak Ulang Struk</a></li>
                        </ul>
                    </li>

                    <li><a href="<?= base_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> Keluar</a></li>
                </ul>
            </div>
        </nav>

        <!-- CONTENT -->
        <div id="page-wrapper">
            <div id="page-inner">

                <!-- FLASHDATA SUCCESS -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= $this->session->flashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- FLASHDATA ERROR -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?= $contents; ?>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url('assets/js/jquery-1.10.2.js') ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jquery.metisMenu.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables/jquery.dataTables.js') ?>"></script>
    <script src="<?= base_url('assets/js/dataTables/dataTables.bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/js/morris/raphael-2.1.0.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/morris/morris.js') ?>"></script>
    <script src="<?= base_url('assets/js/custom-scripts.js') ?>"></script>

</body>
</html>
