<div class="row">
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        
        <a href="<?php echo site_url('transaksi/pendaftaran/input'); ?>" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Pendaftaran Baru
        </a>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Antrian Kunjungan Hari Ini</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu Daftar</th>
                                <th>Nama Pasien</th>
                                <th>Dokter Tujuan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (isset($antrian)):
                                foreach ($antrian as $row): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('H:i', strtotime($row->tanggal_kunjungan)); ?></td>
                                <td><?php echo $row->nama_pasien; ?></td>
                                
                                <td><?php echo $row->nama_dokter; ?></td> 
                                
                                <td><span class="label label-info"><?php echo $row->status_kunjungan; ?></span></td>
                                <td class="text-center">
                                    <?php if ($row->status_kunjungan == 'Menunggu'): ?>
                                        <a href="<?php echo site_url('transaksi/pendaftaran/update_status/' . $row->id_kunjungan . '/Diperiksa'); ?>" 
                                            class="btn btn-sm btn-success" title="Panggil Pasien">
                                            <i class="fa fa-phone"></i> Panggil
                                        </a>
                                    <?php elseif ($row->status_kunjungan == 'Diperiksa'): ?>
                                        <a href="<?php echo site_url('transaksi/pemeriksaan/input_vitalsign/' . $row->id_kunjungan); ?>" 
                                            class="btn btn-sm btn-warning" title="Input Vital Sign">
                                            <i class="fa fa-stethoscope"></i> Vital Sign
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>