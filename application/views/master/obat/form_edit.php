<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Data Obat: <?php echo htmlspecialchars($obat->nama_obat . ' (' . $obat->satuan . ')'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
                
                <?php if ($this->session->flashdata('error_upload')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error_upload'); ?></div>
                <?php endif; ?>

                <?php echo form_open_multipart('master/obat/update'); ?>

                    <input type="hidden" name="id_obat" value="<?php echo $obat->id_obat; ?>">

                    <div class="form-group">
                        <label for="nama_obat"><i class="fa fa-info-circle"></i> Nama Obat</label>
                        <input type="text"
                               class="form-control"
                               name="nama_obat"
                               id="nama_obat"
                               value="<?php echo set_value('nama_obat', $obat->nama_obat); ?>"
                               placeholder="Contoh: Paracetamol 500mg"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="satuan"><i class="fa fa-tag"></i> Satuan</label>
                        <input type="text"
                               class="form-control"
                               name="satuan"
                               id="satuan"
                               value="<?php echo set_value('satuan', $obat->satuan); ?>"
                               placeholder="Contoh: Tablet / Strip / Botol"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="harga_jual"><i class="fa fa-tag"></i> Harga Jual (Rp)</label>
                        <input type="number"
                               class="form-control"
                               name="harga_jual"
                               id="harga_jual"
                               value="<?php echo set_value('harga_jual', $obat->harga_jual); ?>"
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="stok"><i class="fa fa-cubes"></i> Stok Saat Ini</label>
                        <input type="number"
                               class="form-control"
                               name="stok"
                               id="stok"
                               value="<?php echo set_value('stok', $obat->stok); ?>"
                               required>
                    </div>

                    <hr>
                    
                    <div class="form-group">
                        <label>Foto Obat Saat Ini</label>
                        <?php if ($obat->foto_obat): ?>
                            <div class="mb-2">
                                <img src="<?php echo base_url('assets/images/obat/' . $obat->foto_obat); ?>" 
                                     alt="Foto <?php echo $obat->nama_obat; ?>" 
                                     style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px;">
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Belum ada foto obat.</p>
                        <?php endif; ?>

                        <label for="foto_obat"><i class="fa fa-upload"></i> Ganti Foto Obat (Opsional)</label>
                        <input type="file"
                               class="form-control"
                               name="foto_obat"
                               id="foto_obat">
                        <p class="help-block text-muted">Abaikan jika tidak ingin mengganti foto. Maksimal 2MB. Format: JPG, PNG, GIF.</p>
                    </div>


                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-pencil"></i> Update Data</button>
                        <a href="<?php echo site_url('master/obat'); ?>" class="btn btn-default">Batal</a>
                    </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>