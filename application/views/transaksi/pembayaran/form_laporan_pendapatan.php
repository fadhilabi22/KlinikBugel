<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-bar-chart"></i> Laporan Pendapatan Harian/Bulanan</h3>
            </div>
            <div class="panel-body">
                
                <?php echo form_open('transaksi/pembayaran/laporan_pendapatan', ['method' => 'post', 'class' => 'form-inline']); ?>
                
                <div class="form-group">
                    <label for="tgl_awal">Dari Tanggal:</label>
                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" value="<?php echo html_escape($tgl_awal); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="tgl_akhir">Sampai Tanggal:</label>
                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" value="<?php echo html_escape($tgl_akhir); ?>" required>
                </div>
                
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Tampilkan Laporan</button>
                <?php echo form_close(); ?>

                <hr>

                <?php if (!empty($laporan)): ?>
                    <h4>Hasil Laporan Pendapatan (<?php echo date('d M Y', strtotime($tgl_awal)); ?> s/d <?php echo date('d M Y', strtotime($tgl_akhir)); ?>)</h4>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Kunjungan</th>
                                    <th>Nama Pasien</th>
                                    <th>Tanggal Bayar</th>
                                    <th>Total Tagihan</th>
                                    </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1; 
                                $grand_total = 0;
                                foreach($laporan as $item): 
                                    $grand_total += $item->total_akhir;
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $item->id_kunjungan; ?></td>
                                    <td><?php echo $item->nama_pasien; ?></td>
                                    <td><?php echo date('d-m-Y H:i', strtotime($item->tgl_bayar)); ?></td>
                                    <td>Rp <?php echo number_format($item->total_akhir, 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">GRAND TOTAL PENDAPATAN BERSIH</th>
                                    <th>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <?php 
                            // Buat parameter GET untuk URL export
                            $query_params = '?tgl_awal=' . urlencode($tgl_awal) . '&tgl_akhir=' . urlencode($tgl_akhir);
                        ?>

                        <button class="btn btn-success" onclick="window.print()"><i class="fa fa-print"></i> Cetak Laporan (Print)</button>
                        
                        <a href="<?php echo site_url('transaksi/pembayaran/export_excel' . $query_params); ?>" 
                           class="btn btn-info">
                           <i class="fa fa-file-excel-o"></i> Export Excel
                        </a>

                        <a href="<?php echo site_url('transaksi/pembayaran/export_pdf' . $query_params); ?>" 
                           class="btn btn-danger" target="_blank">
                           <i class="fa fa-file-pdf-o"></i> Export PDF
                        </a>
                    </div>
                
                <?php elseif ($this->input->post()): ?>
                    <div class="alert alert-warning">Tidak ada data pembayaran pada rentang tanggal tersebut.</div>
                <?php else: ?>
                     <div class="alert alert-info">Silahkan pilih rentang tanggal untuk menampilkan laporan.</div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
</div>