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

                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <input type="text" class="form-control" 
                               name="nama_dokter"
                               value="<?= set_value('nama_dokter', $dokter->nama_dokter) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Nomor Izin Praktik</label>
                        <input type="text" class="form-control"
                               name="no_izin"
                               value="<?= set_value('no_izin', $dokter->no_izin) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Tarif Konsultasi (Rp)</label>
                        <input type="number" class="form-control"
                               name="tarif" id="tarif"
                               value="<?= set_value('tarif', $dokter->tarif) ?>"
                               required> <small class="text-muted">Tarif diisi manual atau sesuai ketentuan klinik.</small>
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

