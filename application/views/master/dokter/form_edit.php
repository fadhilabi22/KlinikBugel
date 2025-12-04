<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Form Edit Data Dokter: <?php echo $dokter->nama_dokter; ?></h3>
            </div>
            <div class="panel-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open('master/dokter/update'); ?>

                    <input type="hidden" name="id_dokter" value="<?php echo $dokter->id_dokter; ?>">

                    <div class="form-group">
                        <label for="nama_dokter">Nama Dokter</label>
                        <input type="text" class="form-control" name="nama_dokter" id="nama_dokter" 
                               value="<?php echo set_value('nama_dokter', $dokter->nama_dokter); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="spesialisasi">Spesialisasi/Poli</label>
                        <select class="form-control" name="spesialisasi" id="spesialisasi" required>
                            <?php 
                                $spesialisasi_selected = set_value('spesialisasi', $dokter->spesialisasi);
                                $options = ['Umum', 'Gigi', 'Anak', 'Lainnya'];
                            ?>
                            <option value="">-- Pilih Spesialisasi --</option>
                            <?php foreach ($options as $opt): ?>
                                <option value="<?php echo $opt; ?>" <?php echo ($spesialisasi_selected == $opt) ? 'selected' : ''; ?>>
                                    <?php echo $opt; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="no_izin">Nomor Izin Praktik (No. Izin)</label>
                        <input type="text" class="form-control" name="no_izin" id="no_izin" 
                               value="<?php echo set_value('no_izin', $dokter->no_izin); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tarif">Tarif Konsultasi (Rp)</label>
                        <input type="number" class="form-control" name="tarif" id="tarif" 
                               value="<?php echo set_value('tarif', $dokter->tarif); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-warning"><i class="fa fa-pencil"></i> Update Data</button>
                    <a href="<?php echo site_url('master/dokter'); ?>" class="btn btn-default">Batal</a>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>