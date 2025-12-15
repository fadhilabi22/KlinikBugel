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
                        <a href="#"><i class="fa fa-database"></i> Data <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('master/pasien') ?>"><i class="fa fa-users"></i> Data Pasien</a></li>
                            <li><a href="<?= base_url('master/dokter') ?>"><i class="fa fa-user-md"></i> Data Dokter</a></li>
                            <li><a href="<?= base_url('master/obat') ?>"><i class="fa fa-medkit"></i> Data Obat/Stok</a></li>
                            <li><a href="<?= base_url('master/user') ?>"><i class="fa fa-key"></i> Manajemen User</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-stethoscope"></i> Transaksi Layanan <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?= base_url('transaksi/pendaftaran') ?>"><i class="fa fa-edit"></i> Pendaftaran Pasien</a></li>
                            <li><a href="<?= base_url('transaksi/pemeriksaan') ?>"><i class="fa fa-clipboard"></i> Antrian & Pemeriksaan</a></li>
                            <li><a href="<?= base_url('transaksi/pembayaran') ?>"><i class="fa fa-money"></i> Pembayaran Kasir</a></li>
                            <li><a href="<?= base_url('transaksi/riwayat_pasien') ?>"><i class="fa fa-history"></i> Riwayat Pasien</a></li>
                        </ul>
                    </li>


                    <li>
                        <a href="#"><i class="fa fa-file-text-o"></i> Laporan & Export <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="<?php echo site_url('transaksi/pembayaran/laporan_pendapatan'); ?>">
                                    <i class="fa fa-calendar"></i> Laporan Harian/Bulanan
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('transaksi/pembayaran/daftar_struk_selesai'); ?>">
                                    <i class="fa fa-print"></i> Cetak Ulang Struk
                                </a>
                            </li>
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

```javascript
<script>
jQuery(document).ready(function() {

    /* ======================================================
       1. EVENT HAPUS RESEP
    ====================================================== */
    function bindHapusResep() {
        jQuery('#resep-list').off('click', '.btn-hapus-resep')
        .on('click', '.btn-hapus-resep', function() {
            jQuery(this).closest('tr').remove();

            if (jQuery('#resep-list tbody tr').length === 0) {
                jQuery('#resep-list tbody').html(
                    '<tr><td colspan="4" class="text-center">Belum ada obat yang diresepkan.</td></tr>'
                );
            }
        });
    }
    bindHapusResep();


    /* ======================================================
       2. TAMBAH RESEP (FIX TOTALLL)
    ====================================================== */
    jQuery(document).on('click', '#btnTambahResep', function() {

        let id_obat = jQuery('#id_obat_select').val();
        let opt = jQuery('#id_obat_select option:selected');
        let nama_full = opt.text();

        let jumlah = parseInt(jQuery('#jumlah_obat').val());
        let aturan = jQuery('#aturan_pakai').val();

        // Validasi
        if (!id_obat || isNaN(jumlah) || jumlah <= 0 || !aturan) {
            alert('Mohon isi data resep dengan lengkap.');
            return;
        }

        // Ambil nama obat saja (tanpa stok)
        let nama_obat = nama_full.split(' - Stok:')[0];

        let row = `
            <tr>
                <td>
                    <input type="hidden" name="id_obat[]" value="${id_obat}">
                    ${nama_obat}
                </td>
                <td>
                    <input type="hidden" name="jumlah[]" value="${jumlah}">
                    ${jumlah}
                </td>
                <td>
                    <input type="hidden" name="aturan_pakai[]" value="${aturan}">
                    ${aturan}
                </td>
                <td>
                    <button type="button" class="btn btn-xs btn-danger btn-hapus-resep">
                        <i class="fa fa-times"></i> Hapus
                    </button>
                </td>
            </tr>
        `;

        // Hapus row "Belum ada"
        if (jQuery('#resep-list tbody tr td[colspan="4"]').length) {
            jQuery('#resep-list tbody').empty();
        }

        jQuery('#resep-list tbody').append(row);

        // Reset form modal
        jQuery('#form-tambah-resep')[0].reset();
        jQuery('#id_obat_select').val('').trigger('change');
        jQuery('#modalResep').modal('hide');

        bindHapusResep();
    });



    /* ======================================================
       3. EVENT HAPUS TINDAKAN
    ====================================================== */
    function bindHapusTindakan() {
        jQuery('#tindakan-list').off('click', '.btn-hapus-tindakan')
        .on('click', '.btn-hapus-tindakan', function() {
            jQuery(this).closest('tr').remove();

            if (jQuery('#tindakan-list tbody tr').length === 0) {
                jQuery('#tindakan-list tbody').html(
                    '<tr><td colspan="3" class="text-center">Belum ada tindakan yang ditambahkan.</td></tr>'
                );
            }
        });
    }
    bindHapusTindakan();


    /* ======================================================
       4. TAMBAH TINDAKAN
    ====================================================== */
    jQuery(document).on('click', '#btnTambahTindakan', function() {

        let id_tindakan = jQuery('#id_tindakan_select').val();
        let opt = jQuery('#id_tindakan_select option:selected');

        let nama = opt.text().split(' (Rp ')[0];
        let biaya = opt.data('biaya');
        let catatan = jQuery('#catatan_tindakan').val();

        if (!id_tindakan || !biaya) {
            alert('Mohon pilih tindakan medis.');
            return;
        }

        let biaya_format = new Intl.NumberFormat('id-ID').format(biaya);
        let cat_display = catatan ? ` (${catatan})` : '';

        let row = `
            <tr>
                <td>
                    <input type="hidden" name="id_tindakan[]" value="${id_tindakan}">
                    <input type="hidden" name="jumlah_tindakan[]" value="1">
                    <input type="hidden" name="catatan_tindakan[]" value="${catatan}">
                    ${nama} <small class="text-muted">${cat_display}</small>
                </td>
                <td>
                    <input type="hidden" name="biaya_tindakan[]" value="${biaya}">
                    Rp ${biaya_format}
                </td>
                <td>
                    <button type="button" class="btn btn-xs btn-danger btn-hapus-tindakan">
                        <i class="fa fa-times"></i> Hapus
                    </button>
                </td>
            </tr>
        `;

        if (jQuery('#tindakan-list tbody tr td[colspan="3"]').length) {
            jQuery('#tindakan-list tbody').empty();
        }

        jQuery('#tindakan-list tbody').append(row);

        // Reset modal
        jQuery('#form-tambah-tindakan')[0].reset();
        jQuery('#id_tindakan_select').val('').trigger('change');
        jQuery('#modalTindakan').modal('hide');

        bindHapusTindakan();
    });

});
</script>
</body>
</html>