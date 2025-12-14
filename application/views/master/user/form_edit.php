<?= form_open('master/user/update') ?>
<input type="hidden" name="id_pengguna" value="<?= $user->id_pengguna ?>">

<div class="form-group">
    <label>Username</label>
    <input type="text" name="username" value="<?= $user->username ?>" class="form-control" required>
</div>

<div class="form-group">
    <label>Password (kosongkan jika tidak diubah)</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" value="<?= $user->nama_lengkap ?>" class="form-control" required>
</div>

<button class="btn btn-primary">Update</button>
<a href="<?= site_url('master/user') ?>" class="btn btn-default">Batal</a>

<?= form_close() ?>
