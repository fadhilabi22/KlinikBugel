<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>"> 
<link rel="stylesheet" href="<?php echo base_url('assets/css/custom-styles.css'); ?>">

<style>
@media print {
    .no-print,
    .bukti-bayar {
        display: none;
    }
}
</style>

<div class="struk-container">

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="text-center header-info">
                <h4>KLINIK BUGEL</h4>
                <p style="margin:0;">Jl. Bugel mas indah, Kota Tangerang</p>
                <p style="margin:0;">Telp: (021) 0938203</p>
            </div>

            <p style="font-size:9pt;margin:5px 0;">
                Tgl: <?= date('d-m-Y H:i:s', strtotime($struk->tgl_bayar)); ?><br>
                Kasir: <?= $struk->nama_kasir ?? 'Admin'; ?><br>
                No. Kunjungan: <?= $struk->id_kunjungan; ?><br>
                Pasien: <?= $struk->nama_pasien; ?>
            </p>

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th colspan="2" style="border-bottom:1px dashed #000;">DETAIL TAGIHAN</th>
                        <th class="text-right" style="border-bottom:1px dashed #000;">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                $total_tagihan = 0;

                if (!empty($struk->tindakan)):
                    echo '<tr><td colspan="3"><b>Tindakan:</b></td></tr>';
                    foreach ($struk->tindakan as $t):
                        $subtotal = $t->biaya_tindakan * $t->jumlah;
                        $total_tagihan += $subtotal;
                ?>
                    <tr>
                        <td>-</td>
                        <td><?= $t->nama_tindakan ?> (<?= $t->jumlah ?>x)</td>
                        <td class="text-right"><?= number_format($subtotal,0,',','.') ?></td>
                    </tr>
                <?php endforeach; endif; ?>

                <?php
                if (!empty($struk->resep)):
                    echo '<tr><td colspan="3"><b>Resep Obat:</b></td></tr>';
                    foreach ($struk->resep as $r):
                        $subtotal = $r->jumlah * $r->harga_jual;
                        $total_tagihan += $subtotal;
                ?>
                    <tr>
                        <td>-</td>
                        <td><?= $r->nama_obat ?> (<?= $r->jumlah ?>x)</td>
                        <td class="text-right"><?= number_format($subtotal,0,',','.') ?></td>
                    </tr>
                <?php endforeach; endif; ?>

                <tr>
                    <td colspan="3" style="border-top:1px dashed #000;"></td>
                </tr>
                <tr>
                    <td colspan="2">TOTAL TAGIHAN</td>
                    <td class="text-right">Rp <?= number_format($struk->total_akhir,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="2">UANG DIBAYAR</td>
                    <td class="text-right">Rp <?= number_format($struk->jumlah_bayar ?? $struk->total_akhir,0,',','.') ?></td>
                </tr>
                <tr>
                    <td colspan="2">KEMBALIAN</td>
                    <td class="text-right">Rp <?= number_format($struk->kembalian ?? 0,0,',','.') ?></td>
                </tr>

                </tbody>
            </table>

            <!--  BUKTI BAYAR -->
            <?php if (!empty($struk->bukti_bayar)) : ?>
                <div class="bukti-bayar" style="margin-top:15px;border-top:1px dashed #000;padding-top:10px;">
                    <strong style="font-size:9pt;">Bukti Pembayaran:</strong><br>
                    <a href="<?= base_url('assets/img/buktibayar/'.$struk->bukti_bayar) ?>" target="_blank">
                        <img src="<?= base_url('assets/img/buktibayar/'.$struk->bukti_bayar) ?>"
                             style="max-width:200px;margin-top:6px;border:1px solid #ccc;padding:4px;border-radius:4px;">
                    </a>
                    <div style="font-size:8pt;color:#666;">Klik gambar untuk memperbesar</div>
                </div>
            <?php endif; ?>

            <div class="text-center" style="margin-top:15px;">
                <p style="font-size:8pt;margin:0;">Terima kasih atas kunjungan Anda.</p>
                <p style="font-size:8pt;">Simpan struk ini sebagai bukti pembayaran.</p>
            </div>

        </div>
    </div>
</div>

<div class="text-center no-print" style="margin-top:20px;">
    <a href="<?= site_url('transaksi/pembayaran/daftar_struk_selesai') ?>" class="btn btn-default">
        <i class="fa fa-chevron-left"></i> Kembali
    </a>
    <button class="btn btn-success" onclick="window.print()">
        <i class="fa fa-print"></i> Cetak Struk
    </button>
</div>

<script>
window.onload = function () {
    window.print();
};
</script>