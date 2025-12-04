<div class="row">
    <div class="col-md-12">
        <h2 class="page-header">
            Dashboard Klinik <small><i>Sistem Informasi Klinik Mini.</i></small>
        </h2>
    </div>
</div> 
<div class="row">
    
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-green">
            <div class="panel-body">
                <i class="fa fa-users fa-5x"></i>
                <h3><?php echo $total_pasien; ?></h3>
            </div>
            <div class="panel-footer back-footer-green">
                Total Pasien Terdaftar
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-blue">
            <div class="panel-body">
                <i class="fa fa-user-md fa-5x"></i>
                <h3><?php echo $total_dokter; ?></h3>
            </div>
            <div class="panel-footer back-footer-blue">
                Total Dokter Aktif
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-red">
            <div class="panel-body">
                <i class="fa fa-medkit fa-5x"></i>
                <h3><?php echo $total_obat; ?> </h3>
            </div>
            <div class="panel-footer back-footer-red">
                Jenis Obat Tersedia
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-primary text-center no-boder bg-color-brown">
            <div class="panel-body">
                <i class="fa fa-pencil-square-o fa-5x"></i>
                <h3><?php echo $total_pendaftaran; ?> </h3>
            </div>
            <div class="panel-footer back-footer-brown">
                Pendaftaran Hari Ini
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Bar Chart (Statistik Kunjungan Bulanan)
            </div>
            <div class="panel-body">
                <div id="morris-bar-chart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Donut Chart (Persentase Poli)
            </div>
            <div class="panel-body">
                <div id="morris-donut-chart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tasks Panel (Aktivitas Terkini)
            </div>
            <div class="panel-body">
                <div class="list-group">

                    <a href="#" class="list-group-item">
                        <span class="badge">7 minutes ago</span>
                        <i class="fa fa-fw fa-user-plus"></i> Pasien baru terdaftar
                    </a>

                    <a href="#" class="list-group-item">
                        <span class="badge">16 minutes ago</span>
                        <i class="fa fa-fw fa-stethoscope"></i> Pasien no. 005 selesai diperiksa
                    </a>

                    <a href="#" class="list-group-item">
                        <span class="badge">36 minutes ago</span>
                        <i class="fa fa-fw fa-money"></i> Pembayaran tagihan (Kasir)
                    </a>
                    
                    <a href="#" class="list-group-item">
                        <span class="badge">1 hour ago</span>
                        <i class="fa fa-fw fa-medkit"></i> Stok obat 'Paracetamol' habis
                    </a>
                    
                    <a href="#" class="list-group-item">
                        <span class="badge">1.23 hour ago</span>
                        <i class="fa fa-fw fa-calendar"></i> Jadwal dokter diubah
                    </a>
                    
                    <a href="#" class="list-group-item">
                        <span class="badge">yesterday</span>
                        <i class="fa fa-fw fa-user-times"></i> Akun operator dinonaktifkan
                    </a>

                </div>
                <div class="text-right">
                    <a href="#">More Tasks <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Tabel Pendaftaran Pasien Terbaru
            </div> 
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No Antrian</th>
                                <th>Nama Pasien</th>
                                <th>Poli Tujuan</th>
                                <th>Dokter</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>A001</td>
                                <td>John Doe</td>
                                <td>Umum</td>
                                <td>dr. Andi</td>
                                <td>Menunggu</td>
                            </tr>
                            <tr>
                                <td>A002</td>
                                <td>Kimsila Marriye</td>
                                <td>Gigi</td>
                                <td>dr. Rika</td>
                                <td>Sedang Diperiksa</td>
                            </tr>
                            <tr>
                                <td>A003</td>
                                <td>Rossye Nermal</td>
                                <td>Anak</td>
                                <td>dr. Joko</td>
                                <td>Selesai</td>
                            </tr>
                            <tr>
                                <td>A004</td>
                                <td>Richard Orieal</td>
                                <td>Umum</td>
                                <td>dr. Andi</td>
                                <td>Menunggu</td>
                            </tr>
                            <tr>
                                <td>A005</td>
                                <td>Jacob Hielsar</td>
                                <td>Gigi</td>
                                <td>dr. Rika</td>
                                <td>Selesai</td>
                            </tr>
                            <tr>
                                <td>A006</td>
                                <td>Wrapel Dere</td>
                                <td>Anak</td>
                                <td>dr. Joko</td>
                                <td>Menunggu</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>