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

        
   <form method="GET" action="<?php echo site_url('master/pasien'); ?>" class="form-inline mb-3">
        <input type="text" name="keyword" class="form-control mr-2" 
            placeholder="Cari nama pasien..." 
            value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">

        <button type="submit" class="btn btn-info">
            <i class="fa fa-search"></i> Cari
        </button>

        <?php if (isset($_GET['keyword']) && $_GET['keyword'] != ''): ?>
            <a href="<?php echo site_url('master/pasien'); ?>" class="btn btn-secondary ml-2">
                Reset
            </a>
        <?php endif; ?>
    </form>

        <a href="<?php echo site_url('master/pasien/input'); ?>" class="btn btn-primary mb-3">
            <i class="fa fa-user-plus"></i> Tambah Pasien Baru
        </a>

        <div class="panel panel-default panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">Daftar Pasien Terdaftar</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Tgl. Lahir</th>
                                <th>No. Telepon</th>
                                <th>Alamat</th>
                                <th>Tgl. Registrasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            // Pastikan Controller mengirimkan $pasien
                            if (isset($pasien) && is_array($pasien)):
                                foreach ($pasien as $row): 
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $no++; ?></td>
                                <td><i class="fa fa-user"></i> <?php echo $row->nama_pasien; ?></td>
                                <td><?php echo date('d-m-Y', strtotime($row->tgl_lahir)); ?></td>
                                <td><?php echo $row->no_telp; ?></td>
                                <td><?php echo substr($row->alamat, 0, 30); ?>...</td> <td><?php echo date('d/M/Y', strtotime($row->tgl_dibuat)); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('master/pasien/edit/' . $row->id_pasien); ?>" 
                                       class="btn btn-sm btn-warning" title="Edit Data">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    
                                    <a href="<?php echo site_url('master/pasien/hapus/' . $row->id_pasien); ?>" 
                                       class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Hapus Pasien: <?php echo $row->nama_pasien; ?>?')" 
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
                                <td colspan="7" class="text-center">Tidak ada data pasien ditemukan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
</div>