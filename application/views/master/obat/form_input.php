<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">Form Tambah Data Obat Baru</h3>
            </div>
            <div class="panel-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <?php echo form_open_multipart('master/obat/simpan'); ?>

                    <div class="form-group">
                        <label for="nama_obat"><i class="fa fa-info-circle"></i> Nama Obat</label>
                        <input type="text"
                               class="form-control"
                               name="nama_obat"
                               id="nama_obat"
                               value="<?php echo set_value('nama_obat'); ?>"
                               placeholder="Contoh: Paracetamol 500mg"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="satuan"><i class="fa fa-tag"></i> Satuan</label>
                        <input type="text"
                               class="form-control"
                               name="satuan"
                               id="satuan"
                               value="<?php echo set_value('satuan'); ?>"
                               placeholder="Contoh: Tablet / Strip / Botol"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual"><i class="fa fa-money"></i> Harga Jual (Rp)</label>
                        <input type="number"
                               class="form-control"
                               name="harga_jual"
                               id="harga_jual"
                               value="<?php echo set_value('harga_jual'); ?>"
                               placeholder="Masukkan harga jual"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stok"><i class="fa fa-cubes"></i> Stok Awal</label>
                        <input type="number"
                               class="form-control"
                               name="stok"
                               id="stok"
                               value="<?php echo set_value('stok'); ?>"
                               placeholder="Jumlah stok awal"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="foto_obat"><i class="fa fa-camera"></i> Foto Obat (Opsional)</label>
                        <input type="file"
                               class="form-control"
                               name="foto_obat"
                               id="foto_obat">
                        <p class="help-block text-muted">Maksimal 2MB. Format: JPG, PNG, GIF.</p>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Data Obat</button>
                        <a href="<?php echo site_url('master/obat'); ?>" class="btn btn-default">Batal</a>
                    </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>