<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-user-md"></i> Daftar Pasien Siap Periksa (Vital Sign OK)</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-dokter">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Waktu VS</th>
                                <th>Nama Pasien</th>
                                <th>Keluhan Utama</th>
                                <th>Status</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (isset($antrian_dokter) && is_array($antrian_dokter)):
                                foreach ($antrian_dokter as $row): 
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo date('H:i', strtotime($row->tgl_vitalsign)); // Asumsi ada kolom tgl_vitalsign ?></td>
                                <td><?php echo $row->nama_pasien; ?></td>
                                <td><?php echo $row->keluhan; ?></td>
                                <td><span class="label label-warning"><?php echo $row->status_kunjungan; ?></span></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('transaksi/pemeriksaan/input_diagnosis/' . $row->id_rm); ?>" 
                                        class="btn btn-sm btn-primary" title="Mulai Pemeriksaan">
                                        <i class="fa fa-stethoscope"></i> Mulai RM
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            else:
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pasien yang siap diperiksa saat ini.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>