<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
    </div>

    <div class="card-body">
        <form action="<?= site_url('master/dokter/simpan') ?>" method="post"> 

            <div class="form-group">
                <label>Nama Dokter</label>
                <input type="text" name="nama_dokter" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nomor Izin Praktik</label>
                <input type="text" name="no_izin" class="form-control" required>
            </div>

            <?php 
            /*
            <div class="form-group">
                <label>Pilih Poli / Spesialisasi</label>
                <select name="id_poli" class="form-control" required>
                    <option value="">-- Pilih Poli --</option>
                    <?php foreach ($poli as $p): ?>
                        <option value="<?= $p->id_poli ?>">
                            <?= $p->nama_poli ?> (Rp <?= number_format($p->biaya_pendaftaran,0,',','.'); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            */
            ?>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= site_url('master/dokter') ?>" class="btn btn-secondary">Batal</a>

        </form>
    </div>
</div>