<?= form_open('master/user/simpan') ?>

<div class="form-group">
    <label>Username</label>
    <input type="text" name="username" class="form-control" required>
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
</div>

<div class="form-group">
    <label>Nama Lengkap</label>
    <input type="text" name="nama_lengkap" class="form-control" required>
</div>

<button class="btn btn-primary">Simpan</button>
<a href="<?= site_url('master/user') ?>" class="btn btn-default">Batal</a>

<?= form_close() ?>
