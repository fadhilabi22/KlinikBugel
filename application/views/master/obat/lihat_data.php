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

        <form method="GET" action="<?php echo site_url('master/obat'); ?>" class="form-inline mb-3">

            <input type="text" name="keyword" 
                class="form-control mr-2" 
                placeholder="Cari nama obat..."
                value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">

            <button type="submit" class="btn btn-success">
                <i class="fa fa-search"></i> Cari
            </button>

            <?php if (!empty($_GET['keyword'])): ?>
                <a href="<?php echo site_url('master/obat'); ?>" 
                class="btn btn-secondary ml-2">
                    Reset
                </a>
            <?php endif; ?>

        </form>
        
        <a href="<?php echo site_url('master/obat/input'); ?>" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Tambah Data Obat
        </a>

        <div class="panel panel-default panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">Manajemen Stok dan Harga Obat</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat / Satuan</th>
                                <th>Harga Jual (Rp)</th>
                                <th>Stok Saat Ini</th>
                                <th>Status Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;

                            if (isset($obat) && is_array($obat)):
                                foreach ($obat as $row): 

                                    $stok_warning = ($row->stok <= 10) ? 'danger' : 'success';
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $no++; ?></td>

                                <!-- FIXED: gunakan nama_obat dan satuan -->
                                <td>
                                    <i class="fa fa-medkit"></i> 
                                    <?php echo $row->nama_obat . ' (' . $row->satuan . ')'; ?>
                                </td>

                                <td>Rp <?php echo number_format($row->harga_jual, 0, ',', '.'); ?></td>
                                <td><?php echo number_format($row->stok, 0, ',', '.'); ?></td>

                                <td>
                                    <span class="label label-<?php echo $stok_warning; ?>">
                                        <?php echo ($row->stok <= 10) ? 'Menipis' : 'Cukup'; ?>
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="<?php echo site_url('master/obat/edit/' . $row->id_obat); ?>" 
                                       class="btn btn-sm btn-warning" title="Edit Data">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <a href="<?php echo site_url('master/obat/hapus/' . $row->id_obat); ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Hapus Obat: <?php echo $row->nama_obat; ?>?')" 
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
                                <td colspan="6" class="text-center">Belum ada data obat atau stok ditemukan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
</div>
