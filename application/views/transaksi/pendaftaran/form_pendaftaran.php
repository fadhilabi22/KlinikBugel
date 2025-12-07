<div class="row">
    <div class="col-md-7">
        <div class="panel panel-primary panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">Form Pendaftaran Kunjungan Baru</h3>
            </div>
            <div class="panel-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open('transaksi/pendaftaran/simpan'); ?>

                    <h4 style="color:#0A3D62;">Informasi Pasien</h4>
                    <hr>
                    
                    <div class="form-group">
                        <label for="id_pasien"><i class="fa fa-search"></i> Pilih Pasien Lama</label>
                        <select class="form-control" name="id_pasien" id="id_pasien" required>
                            <option value="">-- Pilih Pasien --</option>
                            <?php 
                            if(isset($list_pasien)):
                                foreach($list_pasien as $pasien):
                                    $selected = set_select('id_pasien', $pasien->id_pasien);
                                    echo '<option value="'.$pasien->id_pasien.'" '.$selected.'>'.$pasien->id_pasien.' - '.$pasien->nama_pasien.' ('.$pasien->no_telp.')</option>';
                                endforeach;
                            endif;
                            ?>
                        </select>
                        <p class="help-block"><a href="<?php echo site_url('master/pasien/input'); ?>">+ Daftarkan Pasien Baru</a> jika belum terdaftar.</p>
                    </div>

                    <h4 style="color:#0A3D62; margin-top:30px;">Tujuan Kunjungan</h4>
                    <hr>
                    
                    <div class="form-group">
                        <label for="id_poli"><i class="fa fa-hospital-o"></i> Poli Tujuan</label>
                        <select class="form-control" name="id_poli" id="id_poli" required>
                            <option value="">-- Pilih Poli --</option>
                            <?php 
                            if(isset($list_poli)):
                                foreach($list_poli as $poli):
                                    $selected = set_select('id_poli', $poli->id_poli);
                                    echo '<option value="'.$poli->id_poli.'" '.$selected.'>'.$poli->nama_poli.'</option>';
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="id_dokter"><i class="fa fa-user-md"></i> Dokter Tujuan</label>
                        <select class="form-control" name="id_dokter" id="id_dokter" required>
                            <option value="">-- Pilih Dokter --</option>
                            <?php 
                            if(isset($list_dokter)):
                                foreach($list_dokter as $dokter):
                                    $selected = set_select('id_dokter', $dokter->id_dokter);
                                    echo '<option value="'.$dokter->id_dokter.'" '.$selected.'>'.$dokter->nama_dokter.'</option>';
                                endforeach;
                            endif;
                            ?>
                        </select>
                        <p class="help-block">Pastikan dokter yang dipilih praktik hari ini.</p>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-ticket"></i> Masukkan ke Antrian</button>
                        <a href="<?php echo site_url('transaksi/pendaftaran'); ?>" class="btn btn-default">Batal</a>
                    </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>