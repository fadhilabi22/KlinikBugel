<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Form Tambah Data Dokter</h3>
            </div>
            <div class="panel-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open('master/dokter/simpan'); ?>

                    <div class="form-group">
                        <label for="nama_dokter">Nama Dokter</label>
                        <input type="text" class="form-control" name="nama_dokter" id="nama_dokter" 
                               value="<?php echo set_value('nama_dokter'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="spesialisasi">Spesialisasi/Poli</label>
                        <select class="form-control" name="spesialisasi" id="spesialisasi" required>
                            <option value="">-- Pilih Spesialisasi --</option>
                            <option value="Umum" <?php echo set_select('spesialisasi', 'Umum'); ?>>Umum</option>
                            <option value="Gigi" <?php echo set_select('spesialisasi', 'Gigi'); ?>>Gigi</option>
                            <option value="Anak" <?php echo set_select('spesialisasi', 'Anak'); ?>>Anak</option>
                            <option value="Lainnya" <?php echo set_select('spesialisasi', 'Lainnya'); ?>>Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="no_izin">Nomor Izin Praktik (No. Izin)</label>
                        <input type="text" class="form-control" name="no_izin" id="no_izin" 
                               value="<?php echo set_value('no_izin'); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tarif">Tarif Konsultasi (Rp)</label>
                        <input type="number" class="form-control" name="tarif" id="tarif" 
                               value="<?php echo set_value('tarif'); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data</button>
                    <a href="<?php echo site_url('master/dokter'); ?>" class="btn btn-default">Batal</a>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>