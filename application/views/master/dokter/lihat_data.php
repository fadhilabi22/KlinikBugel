<div class="row">
    <div class="col-md-12">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('error'); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <a href="<?php echo site_url('master/dokter/input'); ?>" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Tambah Dokter Baru
        </a>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Data Dokter Klinik</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dokter</th>
                                <th>Spesialisasi</th>
                                <th>No. Izin</th>
                                <th>Tarif Konsultasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (isset($dokter) && is_array($dokter)):
                                foreach ($dokter as $row): 
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $row->nama_dokter; ?></td>
                                <td><?php echo $row->spesialisasi; ?></td>
                                <td><?php echo $row->no_izin; ?></td>
                                <td>Rp <?php echo number_format($row->tarif, 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('master/dokter/edit/' . $row->id_dokter); ?>" 
                                       class="btn btn-sm btn-warning" title="Edit Data">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <a href="<?php echo site_url('master/dokter/hapus/' . $row->id_dokter); ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Anda yakin ingin menghapus data Dokter: <?php echo $row->nama_dokter; ?>?')" 
                                       title="Hapus Data">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endforeach; 
                            else:
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data dokter ditemukan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>