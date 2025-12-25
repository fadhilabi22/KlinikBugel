<div class="row">
    <div class="col-md-6">
        <div class="panel panel-warning panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-heartbeat"></i> Pencatatan Tanda-Tanda Vital (Vital Sign)
                </h3>
            </div>

            <div class="panel-body">
                <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

                <?php echo form_open('transaksi/pemeriksaan/simpan_vital_sign'); ?>

                <!-- ================= DATA PASIEN ================= -->
                <h4 style="color:#0A3D62;">
                    Data Pasien: 
                    <strong>
                        <?php echo isset($kunjungan) ? $kunjungan->nama_pasien : '-'; ?>
                    </strong>
                </h4>
                <hr>

               
                <input type="hidden" name="id_kunjungan" 
                       value="<?php echo isset($id_kunjungan) ? $id_kunjungan : ''; ?>">

               
                <div class="form-group">
                    <label for="tensi">
                        <i class="fa fa-heartbeat"></i> Tekanan Darah (Tensi)
                    </label>
                    <input type="text" class="form-control" name="tensi" id="tensi"
                           value="<?php echo set_value('tensi'); ?>"
                           placeholder="Contoh: 120/80 mmHg" required>
                </div>

                
                <div class="form-group">
                    <label for="suhu">
                        <i class="fa fa-thermometer-half"></i> Suhu Tubuh (°C)
                    </label>
                    <input type="number" step="0.1" class="form-control" name="suhu" id="suhu"
                           value="<?php echo set_value('suhu'); ?>"
                           placeholder="Contoh: 36.5" required>
                </div>

                
                <div class="form-group">
                    <label for="bb">
                        <i class="fa fa-balance-scale"></i> Berat Badan (kg)
                    </label>
                    <input type="number" class="form-control" name="bb" id="bb"
                           value="<?php echo set_value('bb'); ?>"
                           placeholder="Contoh: 65" required>
                </div>

               
                <div class="form-group">
                    <label for="keluhan">
                        <i class="fa fa-plus-square"></i> Keluhan Utama
                    </label>
                    <textarea class="form-control" name="keluhan" id="keluhan"
                              rows="3" required><?php echo set_value('keluhan'); ?></textarea>
                </div>

                
                <div class="mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="fa fa-save"></i> Simpan & Lanjut ke Dokter
                    </button>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
