<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-user-md"></i> Pemeriksaan Pasien: <?php echo $kunjungan->nama_pasien; ?> 
                    <small>| RM#<?php echo $rekam_medis->id_rm; ?> | Kunjungan#<?php echo $kunjungan->id_kunjungan; ?></small>
                </h3>
            </div>
            
            <?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>

            <?php echo form_open('transaksi/pemeriksaan/simpan_diagnosis_final'); ?>
            <input type="hidden" name="id_rekam_medis" value="<?php echo $rekam_medis->id_rm; ?>">
            <input type="hidden" name="id_kunjungan" value="<?php echo $kunjungan->id_kunjungan; ?>">

            <div class="panel-body">
                
                <div class="well well-sm">
                    <h4>Data Awal:</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Dokter:</strong> <?php echo $kunjungan->nama_dokter; ?><br>
                            <strong>Poli:</strong> <?php echo $kunjungan->nama_poli; ?><br>
                            <strong>Keluhan Utama:</strong> <?php echo $rekam_medis->keluhan; ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Data Tanda Vital (VS):</strong>
                            <pre style="margin-top: 5px; background-color: #f9f9f9; border: 1px solid #eee; padding: 5px;">
                            <?php 
                            // Kita tampilkan data Vital Sign dari kolom catatan_medis yang sudah digabungkan
                            echo isset($rekam_medis->catatan_medis) ? $rekam_medis->catatan_medis : 'Data VS belum tercatat.'; 
                            ?>
                            </pre>
                        </div>
                    </div>
                </div>
                
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab-diagnosis" data-toggle="tab">Diagnosis & Anamnesis</a></li>
                    <li><a href="#tab-tindakan" data-toggle="tab">Tindakan Medis</a></li>
                    <li><a href="#tab-resep" data-toggle="tab">Resep Obat</a></li>
                </ul>

                <div class="tab-content">
                    
                    <div class="tab-pane fade in active" id="tab-diagnosis">
                        <br>
                        <div class="form-group">
                            <label for="anamnesis">Anamnesis / Pemeriksaan Fisik Lanjutan:</label>
                            <textarea name="anamnesis" id="anamnesis" class="form-control" rows="4" placeholder="Catatan pemeriksaan fisik, riwayat alergi, dll."><?php echo set_value('anamnesis', $rekam_medis->catatan_medis); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="diagnosa">Diagnosis (Final):</label>
                            <textarea name="diagnosa" id="diagnosa" class="form-control" rows="2" required placeholder="Contoh: Common Cold (Rhinopharyngitis)"><?php echo set_value('diagnosa', $rekam_medis->diagnosa); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="tab-pane fade" id="tab-tindakan">
                        <br>
                        <h4>Pilih Tindakan:</h4>
                        <div id="tindakan-list">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Tindakan</th>
                                        <th>Biaya</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" class="text-center">Belum ada tindakan yang ditambahkan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalTindakan">
                            <i class="fa fa-plus"></i> Tambah Tindakan
                        </button>
                    </div>

                    <div class="tab-pane fade" id="tab-resep">
                        <br>
                        <h4>Resep Obat:</h4>
                        <div id="resep-list">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Jumlah</th>
                                        <th>Aturan Pakai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada obat yang diresepkan.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modalResep">
                            <i class="fa fa-plus"></i> Tambah Resep
                        </button>
                    </div>

                </div>
                </div>
            
            <div class="panel-footer text-right">
                <button type="submit" class="btn btn-info btn-lg">
                    <i class="fa fa-check-square-o"></i> Selesaikan Pemeriksaan
                </button>
                <a href="<?php echo site_url('transaksi/pendaftaran'); ?>" class="btn btn-default btn-lg">Batal / Kembali</a>
            </div>
            
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<?php $this->load->view('transaksi/pemeriksaan/modal_resep'); ?>
<?php $this->load->view('transaksi/pemeriksaan/modal_tindakan'); ?>