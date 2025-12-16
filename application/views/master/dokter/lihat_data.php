<div class="row">
    <div class="col-md-12">

        <!-- Flashdata -->
        <?php if (!empty($success)): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= $success; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= $error; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        <?php endif; ?>

        <!-- Search -->
        <form method="GET" action="<?php echo site_url('master/dokter'); ?>" class="form-inline mb-3">
    
            <input type="text" 
                name="q" 
                class="form-control mr-2" 
                placeholder="Cari nama dokter..." 
                value="<?php echo isset($_GET['q']) ? $_GET['q'] : ''; ?>">

            <button type="submit" class="btn btn-info">
                <i class="fa fa-search"></i> Cari
            </button>

            <?php if (isset($_GET['q']) && $_GET['q'] != ''): ?>
                <a href="<?php echo site_url('master/dokter'); ?>" 
                class="btn btn-secondary ml-2">
                    Reset
                </a>
            <?php endif; ?>

        </form>


        <a href="<?= site_url('master/dokter/input'); ?>" class="btn btn-primary mb-3">
            <i class="fa fa-plus"></i> Tambah Dokter Baru
        </a>

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Data Dokter</h3></div>

            <div class="panel-body">
                <div class="table-responsive">

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Dokter</th>
                                <th>No Izin</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($dokter)): ?>
                                <?php $no = 1; foreach ($dokter as $row): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row->nama_dokter; ?></td>
                                        <td><?= $row->no_izin; ?></td>
                                        <td class="text-center">
                                            <a href="<?= site_url('master/dokter/edit/'.$row->id_dokter); ?>"
                                               class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></a>

                                            <a href="<?= site_url('master/dokter/hapus/'.$row->id_dokter); ?>"
                                               onclick="return confirm('Hapus dokter ini?');"
                                               class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada data dokter ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
</div>