<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
        <a href="<?= site_url('master/poli/tambah') ?>" class="btn btn-primary btn-sm float-right">Tambah Poli</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Poli</th>
                    <th>Biaya Pendaftaran</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($poli as $row) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row->nama_poli ?></td>
                        <td>Rp <?= number_format($row->biaya_pendaftaran, 0, ',', '.'); ?></td>
                        <td>
                            <a href="<?= site_url('master/poli/edit/'.$row->id_poli) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= site_url('master/poli/hapus/'.$row->id_poli) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
