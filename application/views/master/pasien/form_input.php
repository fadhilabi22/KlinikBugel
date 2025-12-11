<div class="row">
    <div class="col-md-7">
        <div class="panel panel-default panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">Input Data Pasien Baru</h3>
            </div>
            <div class="panel-body">

                <!-- ALERT ERROR DUPLIKAT / VALIDASI -->
                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- ALERT SUCCESS -->
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- VALIDATION ERRORS CI -->
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open('master/pasien/simpan'); ?>

                    <div class="form-group">
                        <label for="nama_pasien">
                            <i class="fa fa-user"></i> Nama Lengkap Pasien
                        </label>
                        <input type="text" 
                               class="form-control" 
                               name="nama_pasien" 
                               id="nama_pasien"
                               value="<?php echo set_value('nama_pasien'); ?>" 
                               placeholder="Masukkan nama pasien sesuai KTP" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="tgl_lahir">
                            <i class="fa fa-calendar"></i> Tanggal Lahir
                        </label>
                        <input type="date" 
                               class="form-control" 
                               name="tgl_lahir" 
                               id="tgl_lahir"
                               value="<?php echo set_value('tgl_lahir'); ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="no_telp">
                            <i class="fa fa-phone"></i> Nomor Telepon/HP
                        </label>
                        <input type="text" 
                               class="form-control" 
                               name="no_telp" 
                               id="no_telp"
                               value="<?php echo set_value('no_telp'); ?>" 
                               placeholder="Contoh: 0812xxxx" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="alamat">
                            <i class="fa fa-home"></i> Alamat Lengkap
                        </label>
                        <textarea class="form-control" 
                                  name="alamat" 
                                  id="alamat" 
                                  rows="4" 
                                  required><?php echo set_value('alamat'); ?></textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Data Pasien
                        </button>

                        <a href="<?php echo site_url('master/pasien'); ?>" class="btn btn-default">
                            Batal
                        </a>
                    </div>

                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>
