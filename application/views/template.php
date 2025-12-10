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

    <script>
// Menggunakan jQuery() untuk memastikan kompatibilitas
jQuery(document).ready(function() {

    // --- FUNGSI PENDUKUNG: Hapus Baris ---
    function bindHapusResepEvent() {
        // Menggunakan delegasi event pada elemen induk yang statis
        jQuery('#resep-list').off('click', '.btn-hapus-resep').on('click', '.btn-hapus-resep', function() {
            jQuery(this).closest('tr').remove();
            if (jQuery('#resep-list tbody tr').length === 0) {
                jQuery('#resep-list tbody').append('<tr><td colspan="4" class="text-center">Belum ada obat yang diresepkan.</td></tr>');
            }
        });
    }

    // --- LOGIKA UTAMA: Menangani Tombol "Tambah ke Resep" ---
    function setupResepButton() {
        // 🛑 Pastikan tombol lama dimatikan sebelum memasang yang baru
        jQuery(document).off('click', '#btnTambahResep'); 
        
        // ✅ PASANG EVENT BARU
        jQuery(document).on('click', '#btnTambahResep', function() {
            
            // alert("Tombol Ditekan!"); // <--- COBA TAMBAHKAN INI UNTUK DEBUGGING!
            
            var id_obat = jQuery('#id_obat_select').val();
            var selected_option = jQuery('#id_obat_select option:selected');
            var nama_obat_full = selected_option.text();
            var jumlah = jQuery('#jumlah_obat').val();
            var aturan_pakai = jQuery('#aturan_pakai').val();

            // 1. Validasi
            if (!id_obat || !jumlah || !aturan_pakai || parseInt(jumlah) <= 0) {
                alert('Mohon lengkapi data Resep dengan benar.'); return;
            }

            var nama_obat = nama_obat_full.split(' - Stok:')[0]; 
            var newRow = '<tr>' +
                            '<td><input type="hidden" name="id_obat[]" value="' + id_obat + '">' + nama_obat + '</td>' +
                            '<td><input type="hidden" name="jumlah[]" value="' + jumlah + '">' + jumlah + '</td>' +
                            '<td><input type="hidden" name="aturan_pakai[]" value="' + aturan_pakai + '">' + aturan_pakai + '</td>' +
                            '<td><button type="button" class="btn btn-xs btn-danger btn-hapus-resep"><i class="fa fa-times"></i> Hapus</button></td>' +
                         '</tr>';

            // 2. Update Tabel di Form Utama
            if (jQuery('#resep-list tbody tr td[colspan="4"]').length) { jQuery('#resep-list tbody').empty(); }
            jQuery('#resep-list tbody').append(newRow);
            bindHapusResepEvent(); // Bind fungsi hapus pada baris baru

            // 3. Reset dan Tutup Modal
            jQuery('#form-tambah-resep')[0].reset();
            // Karena class select2 dihapus, ini mungkin tidak berfungsi dengan baik
            jQuery('#id_obat_select').val('').trigger('change'); 
            jQuery('#modalResep').modal('hide');
        });
    }

    // WAJIB: JALANKAN SETELAH DOKUMEN SIAP
    // Jika masih gagal, coba bungkus setupResepButton() di setTimeout(..., 500)
    setupResepButton(); 

    // Jika Anda ingin Select2 berfungsi untuk element lain di modal:
    jQuery('#modalResep').on('shown.bs.modal', function () {
        // Jika ada elemen SELECT yang ingin diinisialisasi Select2
        // jQuery('.select2-lain').select2({ dropdownParent: jQuery('#modalResep') });
        setupResepButton(); // Pastikan event diikat ulang jika modal dibuka
    });
    // DI template.php (di dalam jQuery(document).ready(function() { ... });)

// --- FUNGSI PENDUKUNG: Hapus Baris Tindakan ---
function bindHapusTindakanEvent() {
    // Delegated event untuk tombol hapus di tabel utama
    jQuery('#tindakan-list').off('click', '.btn-hapus-tindakan').on('click', '.btn-hapus-tindakan', function() {
        jQuery(this).closest('tr').remove();
        if (jQuery('#tindakan-list tbody tr').length === 0) {
            jQuery('#tindakan-list tbody').append('<tr><td colspan="3" class="text-center">Belum ada tindakan yang ditambahkan.</td></tr>');
        }
    });
}

// --- LOGIKA UTAMA: Menangani Tombol "Tambah ke Tindakan" ---
// Menggunakan Delegated Event pada document sebagai fallback terkuat
jQuery(document).on('click', '#btnTambahTindakan', function() {
    
    var id_tindakan = jQuery('#id_tindakan_select').val(); 
    var selected_option = jQuery('#id_tindakan_select option:selected');
    
    var nama_tindakan = selected_option.text().split(' (Rp ')[0];
    
    var biaya = selected_option.data('biaya'); 
    var catatan = jQuery('#catatan_tindakan').val(); // Ambil catatan

    // 1. Validasi
    if (!id_tindakan || !biaya) {
        alert('Mohon pilih Tindakan Medis.'); return;
    }

    var biaya_formatted = new Intl.NumberFormat('id-ID').format(biaya);
    var catatan_display = catatan ? ' (' + catatan + ')' : ''; 

    // 2. Buat Baris Baru (Row)
    var newRow = '<tr>' +
                    // Input ID Tindakan
                    '<td><input type="hidden" name="id_tindakan[]" value="' + id_tindakan + '">' + 
                    
                    // ✅ FIX 1: Tambahkan input hidden untuk JUMLAH (nilai default 1)
                    '<input type="hidden" name="jumlah[]" value="1">' + 

                    // ✅ FIX 2: Tambahkan input hidden untuk CATATAN (Jika Anda mau menyimpannya di DB)
                    '<input type="hidden" name="catatan_tindakan[]" value="' + catatan + '">' + 
                    
                    nama_tindakan + '<small class="text-muted">' + catatan_display + '</small></td>' +
                    
                    // Input Biaya
                    '<td><input type="hidden" name="biaya_tindakan[]" value="' + biaya + '">Rp ' + biaya_formatted + '</td>' +
                    '<td><button type="button" class="btn btn-xs btn-danger btn-hapus-tindakan"><i class="fa fa-times"></i> Hapus</button></td>' +
                 '</tr>';

    // 3. Update Tabel di Form Utama
    if (jQuery('#tindakan-list tbody tr td[colspan="3"]').length) { jQuery('#tindakan-list tbody').empty(); }
    jQuery('#tindakan-list tbody').append(newRow);
    bindHapusTindakanEvent(); 

    // 4. Reset dan Tutup Modal
    jQuery('#form-tambah-tindakan')[0].reset(); 
    jQuery('#id_tindakan_select').val('').trigger('change');
    jQuery('#modalTindakan').modal('hide');
    });
});
</script>
</body>
</html>