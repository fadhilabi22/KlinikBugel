<div class="card">
    <div class="card-header">
        <h4><?= $title ?></h4>
    </div>

    <div class="card-body">

        <!-- ALERT VALIDASI -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('master/dokter/simpan') ?>" method="post"> 

            <div class="form-group">
                <label>Nama Dokter</label>
                <input 
                    type="text" 
                    name="nama_dokter" 
                    class="form-control" 
                    value="<?= set_value('nama_dokter'); ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label>Nomor Izin Praktik</label>
                <input 
                    type="text" 
                    name="no_izin" 
                    class="form-control" 
                    value="<?= set_value('no_izin'); ?>"
                    required
                >
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="<?= site_url('master/dokter') ?>" class="btn btn-secondary">Batal</a>

        </form>
    </div>
</div>
