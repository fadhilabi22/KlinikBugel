<?php 
if (!isset($tagihan) || !isset($total_biaya)) {
    echo '<div class="alert alert-danger">Data tagihan tidak ditemukan.</div>';
    return;
}
?>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-calculator"></i> Pembayaran Tagihan Pasien
                </h3>
            </div>

            <?php echo form_open_multipart('transaksi/pembayaran/simpan_pembayaran'); ?>

            <input type="hidden" name="id_kunjungan" value="<?= $tagihan->id_kunjungan; ?>">
            <input type="hidden" name="total_tagihan" value="<?= $total_biaya; ?>">

            <div class="panel-body">

                <div class="alert alert-info">
                    <strong>Pasien:</strong> <?= $tagihan->nama_pasien; ?><br>
                    <strong>Diagnosis:</strong> <?= $tagihan->diagnosa; ?>
                </div>

                <hr>

                <div class="row">
                    <!-- TOTAL -->
                    <div class="col-md-6">
                        <div class="alert alert-warning text-center">
                            <h4>TOTAL TAGIHAN</h4>
                            <h2>Rp <?= number_format($total_biaya, 0, ',', '.'); ?></h2>
                        </div>
                    </div>

                    <!-- PEMBAYARAN -->
                    <div class="col-md-6">

                        <!-- METODE BAYAR -->
                        <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran"
                                    class="form-control" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="cash">Cash</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>

                        <!-- JUMLAH BAYAR -->
                        <div class="form-group" id="group_jumlah_bayar">
                            <label>Jumlah Uang Dibayarkan (Kasir)</label>
                            <input type="number"
                                   class="form-control input-lg"
                                   name="jumlah_bayar"
                                   id="jumlah_bayar"
                                   min="<?= $total_biaya; ?>">
                        </div>

                        <!-- KEMBALIAN -->
                        <div class="form-group" id="group_kembalian">
                            <label>Kembalian</label>
                            <input type="text"
                                   class="form-control"
                                   id="kembalian_display"
                                   readonly
                                   value="Rp 0">
                        </div>

                        <!-- BUKTI -->
                        <div class="form-group">
                            <label>Bukti Pembayaran</label>
                            <input type="file"
                                   name="bukti_bayar"
                                   id="bukti_bayar"
                                   class="form-control"
                                   accept="image/*">
                            <small class="text-muted">
                                JPG / PNG / JPEG • Maks 2MB <br>
                                <span class="text-danger" id="info_transfer" style="display:none">
                                    *Wajib upload untuk pembayaran transfer
                                </span>
                            </small>
                        </div>

                    </div>
                </div>

            </div>

            <div class="panel-footer text-right">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="fa fa-save"></i> Proses Pembayaran
                </button>
            </div>

            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<script>
jQuery(document).ready(function () {
    var total = <?= $total_biaya; ?>;

    $('#metode_pembayaran').change(function () {
        var metode = $(this).val();

        if (metode === 'cash') {
            $('#group_jumlah_bayar').show();
            $('#group_kembalian').show();
            $('#jumlah_bayar').prop('required', true).val('');
            $('#bukti_bayar').prop('required', false);
            $('#info_transfer').hide();
            $('#kembalian_display').val('Rp 0');
        }

        if (metode === 'transfer') {
            $('#group_jumlah_bayar').hide();
            $('#group_kembalian').hide();
            $('#jumlah_bayar').val(total);
            $('#bukti_bayar').prop('required', true);
            $('#info_transfer').show();
        }
    });

    $('#jumlah_bayar').on('input', function () {
        var bayar = parseInt($(this).val()) || 0;
        var kembali = bayar - total;

        $('#kembalian_display').val(
            new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(kembali)
        );
    });
});
</script>
