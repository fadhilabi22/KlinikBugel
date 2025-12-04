<div class="row">
    <div class="col-md-7">
        <div class="panel panel-default panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Data Pasien: <?php echo $pasien->nama_pasien; ?></h3>
            </div>
            <div class="panel-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open('master/pasien/update'); ?>

                    <input type="hidden" name="id_pasien" value="<?php echo $pasien->id_pasien; ?>">

                    <div class="form-group">
                        <label for="nama_pasien"><i class="fa fa-user"></i> Nama Lengkap Pasien</label>
                        <input type="text" class="form-control" name="nama_pasien" id="nama_pasien" 
                               value="<?php echo set_value('nama_pasien', $pasien->nama_pasien); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="tgl_lahir"><i class="fa fa-calendar"></i> Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" id="tgl_lahir" 
                               value="<?php echo set_value('tgl_lahir', $pasien->tgl_lahir); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="no_telp"><i class="fa fa-phone"></i> Nomor Telepon/HP</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" 
                               value="<?php echo set_value('no_telp', $pasien->no_telp); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat"><i class="fa fa-home"></i> Alamat Lengkap</label>
                        <textarea class="form-control" name="alamat" id="alamat" rows="4" required><?php echo set_value('alamat', $pasien->alamat); ?></textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-warning"><i class="fa fa-pencil"></i> Update Data</button>
                        <a href="<?php echo site_url('master/pasien'); ?>" class="btn btn-default">Batal</a>
                    </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>