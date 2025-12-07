<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
    </div>

    <div class="card-body">
        <form action="<?= site_url('master/poli/update') ?>" method="post">

            <input type="hidden" name="id_poli" value="<?= $poli->id_poli ?>">

            <div class="form-group">
                <label>Nama Poli</label>
                <input type="text" name="nama_poli" value="<?= $poli->nama_poli ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Biaya Pendaftaran</label>
                <input type="number" name="biaya_pendaftaran" value="<?= $poli->biaya_pendaftaran ?>" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="<?= site_url('master/poli') ?>" class="btn btn-secondary">Batal</a>

        </form>
    </div>
</div>
