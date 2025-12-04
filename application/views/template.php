<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Klinik Bugel</title>

    <link href="<?php echo base_url() ?>/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/css/custom-styles.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/assets/css/style.css" rel="stylesheet" /> 
    
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    
    <link href="<?php echo base_url() ?>/assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url('dashboard/index.php') ?>">Klinik Bugel</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="<?php echo base_url().'auth/logout'?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    
                    <li>
                        <a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    
                    <li> 
                        <a href="#"><i class="fa fa-database"></i> Master Data<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url('master/pasien') ?>"><i class="fa fa-users"></i> Data Pasien</a></li>
                            <li><a href="<?php echo base_url('master/dokter') ?>"><i class="fa fa-user-md"></i> Data Dokter</a></li>
                            <li><a href="<?php echo base_url('master/obat') ?>"><i class="fa fa-medkit"></i> Data Obat/Stok</a></li>
                            <li><a href="<?php echo base_url('master/poli') ?>"><i class="fa fa-hospital-o"></i> Data Poli</a></li>
                            <li><a href="<?php echo base_url('master/user') ?>"><i class="fa fa-key"></i> Manajemen User</a></li>
                        </ul>
                    </li>

                    <li> 
                        <a href="#"><i class="fa fa-stethoscope"></i> Transaksi Layanan<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url('transaksi/pendaftaran') ?>"><i class="fa fa-edit"></i> Pendaftaran Pasien</a></li>
                            <li><a href="<?php echo base_url('transaksi/pemeriksaan') ?>"><i class="fa fa-clipboard"></i> Antrian & Pemeriksaan</a></li>
                            <li><a href="<?php echo base_url('transaksi/pembayaran') ?>"><i class="fa fa-money"></i> Pembayaran Kasir</a></li>
                        </ul>
                    </li>

                    <li> 
                        <a href="#"><i class="fa fa-file-text-o"></i> Laporan & Export<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url('laporan/harian') ?>">Laporan Harian/Bulanan</a></li>
                            <li><a href="<?php echo base_url('laporan/excel') ?>">Export Excel</a></li>
                            <li><a href="<?php echo base_url('laporan/pdf') ?>" target="_blank">Export PDF</a></li>
                            <li><a href="<?php echo base_url('transaksi/pembayaran/struk_cetak') ?>"><i class="fa fa-print"></i> Cetak Ulang Struk</a></li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> Keluar</a> 
                    </li>
                </ul>
            </div>
        </nav>
        
        <div id="page-wrapper" >
            <div id="page-inner">
                <?php echo $contents; ?> </div>
            <footer></footer>
        </div>
        </div>
    <script src="<?php echo base_url() ?>/assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script>
        $(document).ready(function () {
            $('#dataTables-example').dataTable();
        });
    </script>
    <script src="<?php echo base_url() ?>/assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/morris/morris.js"></script>
    <script src="<?php echo base_url() ?>/assets/js/custom-scripts.js"></script>
    
</body>
</html>