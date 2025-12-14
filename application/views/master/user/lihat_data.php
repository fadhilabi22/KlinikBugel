<a href="<?= site_url('master/user/input') ?>" class="btn btn-primary mb-3">
    <i class="fa fa-user-plus"></i> Tambah User
</a>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama Lengkap</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach ($user as $u): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $u->username ?></td>
            <td><?= $u->nama_lengkap ?></td>
            <td>
                <a href="<?= site_url('master/user/edit/'.$u->id_pengguna) ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="<?= site_url('master/user/hapus/'.$u->id_pengguna) ?>"
                   onclick="return confirm('Hapus user ini?')"
                   class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>