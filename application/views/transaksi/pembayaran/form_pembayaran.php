<?php 
// Pastikan variabel $tagihan dan $total_biaya tersedia dari Controller
if (!isset($tagihan) || !isset($total_biaya)) {
    echo '<div class="alert alert-danger">Data tagihan tidak ditemukan.</div>';
    return;
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-calculator"></i> Pembayaran Tagihan Pasien</h3>
            </div>
            
            <?php echo form_open('transaksi/pembayaran/simpan_pembayaran'); ?>
            <input type="hidden" name="id_kunjungan" value="<?php echo $tagihan->id_kunjungan; ?>">
            <input type="hidden" name="id_rekam_medis" value="<?php echo $tagihan->id_rm; ?>">
            <input type="hidden" name="total_tagihan" id="total_tagihan_hidden" value="<?php echo $total_biaya; ?>">
            
            <div class="panel-body">
                
                <div class="alert alert-info">
                    <strong>Pasien:</strong> <?php echo $tagihan->nama_pasien; ?><br>
                    <strong>Diagnosis:</strong> <?php echo $tagihan->diagnosa; ?>
                </div>

                <h4>Detail Tagihan:</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fa fa-stethoscope"></i> Tindakan Medis</h5>
                        <ul class="list-group">
                        <?php 
                        $total_tindakan = 0;
                        if (!empty($tagihan->tindakan)):
                            foreach($tagihan->tindakan as $t):
                                $subtotal = $t->biaya;
                                $total_tindakan += $subtotal;
                        ?>
                            <li class="list-group-item">
                                <?php echo $t->nama_tindakan; ?> 
                                <span class="badge">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                            </li>
                        <?php
                            endforeach;
                        else:
                            echo '<li class="list-group-item text-muted">Tidak ada tindakan.</li>';
                        endif;
                        ?>
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <h5><i class="fa fa-pills"></i> Resep Obat</h5>
                        <ul class="list-group">
                        <?php 
                        $total_resep = 0;
                        if (!empty($tagihan->resep)):
                            foreach($tagihan->resep as $r):
                                $subtotal = $r->jumlah * $r->harga_jual;
                                $total_resep += $subtotal;
                        ?>
                            <li class="list-group-item">
                                <?php echo $r->nama_obat; ?> (<?php echo $r->jumlah; ?> x @<?php echo number_format($r->harga_jual, 0, ',', '.'); ?>)
                                <span class="badge">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                            </li>
                        <?php
                            endforeach;
                        else:
                            echo '<li class="list-group-item text-muted">Tidak ada resep.</li>';
                        endif;
                        ?>
                        </ul>
                    </div>
                </div>
                
                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <div class="alert alert-warning text-center">
                            <h4>TOTAL TAGIHAN:</h4>
                            <h2 style="margin-top: 5px;">Rp <span id="display_total"><?php echo number_format($total_biaya, 0, ',', '.'); ?></span></h2>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jumlah_bayar">Jumlah Uang yang Dibayarkan (Kasir)</label>
                            <input type="number" class="form-control input-lg" name="jumlah_bayar" id="jumlah_bayar" min="<?php echo $total_biaya; ?>" required placeholder="Masukkan jumlah bayar">
                        </div>
                        
                        <div class="form-group">
                            <label>Kembalian:</label>
                            <input type="text" class="form-control" id="kembalian_display" readonly value="Rp 0">
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="panel-footer text-right">
                <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Proses Pembayaran</button>
            </div>
            
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function() {
    var totalTagihan = <?php echo $total_biaya; ?>;
    
    jQuery('#jumlah_bayar').on('input', function() {
        var jumlahBayar = parseInt(jQuery(this).val()) || 0;
        var kembalian = jumlahBayar - totalTagihan;
        
        // Format kembalian ke Rupiah
        var kembalianRupiah = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(kembalian);
        
        jQuery('#kembalian_display').val(kembalianRupiah);
    });
});
</script>