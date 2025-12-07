<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Form Edit Data Dokter: <?= $dokter->nama_dokter ?></h3>
            </div>

            <div class="panel-body">

                <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <form action="<?= site_url('master/dokter/update') ?>" method="post">

                    <input type="hidden" name="id_dokter" value="<?= $dokter->id_dokter ?>">

                    <!-- Nama Dokter -->
                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <input type="text" class="form-control" 
                               name="nama_dokter"
                               value="<?= set_value('nama_dokter', $dokter->nama_dokter) ?>" required>
                    </div>

                    <!-- PILIH POLI -->
                    <div class="form-group">
                        <label>Pilih Poli / Spesialisasi</label>
                        <select name="id_poli" id="id_poli" class="form-control" required>
                            <option value="">-- Pilih Poli --</option>

                            <?php foreach ($poli as $p): ?>
                                <option value="<?= $p->id_poli ?>"
                                    <?= ($p->id_poli == $dokter->id_poli ? 'selected' : '') ?>>
                                    <?= $p->nama_poli ?> (Rp <?= number_format($p->biaya_pendaftaran,0,',','.') ?>)
                                </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <!-- NOMOR IZIN -->
                    <div class="form-group">
                        <label>Nomor Izin Praktik</label>
                        <input type="text" class="form-control"
                               name="no_izin"
                               value="<?= set_value('no_izin', $dokter->no_izin) ?>" required>
                    </div>

                    <!-- TARIF (OTOMATIS DARI POLI) -->
                    <div class="form-group">
                        <label>Tarif Konsultasi (Rp)</label>
                        <input type="number" class="form-control"
                               name="tarif" id="tarif"
                               value="<?= set_value('tarif', $dokter->tarif) ?>"
                               readonly>
                        <small class="text-muted">Tarif mengikuti biaya pendaftaran poli.</small>
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-pencil"></i> Update Data
                    </button>

                    <a href="<?= site_url('master/dokter') ?>" class="btn btn-default">Batal</a>

                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Auto update tarif kalau poli diganti
document.getElementById('id_poli').addEventListener('change', function() {

    const poli = <?= json_encode($poli) ?>;
    const id = this.value;

    const selected = poli.find(p => p.id_poli === id);

    if (selected) {
        document.getElementById('tarif').value = selected.biaya_pendaftaran;
    }
});
</script>
