<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.css'); ?>"> 
<link rel="stylesheet" href="<?php echo base_url('assets/css/custom-styles.css'); ?>">

<div class="struk-container">

    <div class="panel panel-default">
        <div class="panel-body">
            
            <div class="text-center header-info">
                <h4>KLINIK BUGEL</h4>
                <p style="margin: 0;">Jl. Bugel mas indah, Kota Tangerang</p>
                <p style="margin: 0;">Telp: (021) 0938203</p>
            </div>

            <p style="font-size: 9pt; margin: 5px 0;">
                Tgl: <?php echo date('d-m-Y H:i:s'); ?><br>
                Kasir: Admin<br>
                No. Kunjungan: <?php echo $struk->id_kunjungan; ?><br>
                Pasien: <?php echo $struk->nama_pasien; ?>
            </p>

            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th colspan="2" style="border-bottom: 1px dashed #000;">DETAIL TAGIHAN</th>
                        <th class="text-right" style="border-bottom: 1px dashed #000;">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php 
                    $total_tagihan = 0;
                    if (!empty($struk->tindakan)):
                        echo '<tr><td colspan="3"><b>Tindakan:</b></td></tr>';
                        foreach($struk->tindakan as $t):
                            // Kita asumsikan $t->biaya_tindakan dan $t->jumlah sudah ada
                            $subtotal = $t->biaya_tindakan * $t->jumlah; 
                            $total_tagihan += $subtotal;
                    ?>
                        <tr>
                            <td>-</td>
                            <td><?php echo $t->nama_tindakan; ?> (<?php echo $t->jumlah; ?>x)</td>
                            <td class="text-right"><?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php
                        endforeach;
                    endif;
                    ?>

                    <?php 
                    if (!empty($struk->resep)):
                        echo '<tr><td colspan="3"><b>Resep Obat:</b></td></tr>';
                        foreach($struk->resep as $r):
                            $subtotal = $r->jumlah * $r->harga_jual;
                            $total_tagihan += $subtotal;
                    ?>
                        <tr>
                            <td>-</td>
                            <td><?php echo $r->nama_obat; ?> (<?php echo $r->jumlah; ?>x)</td>
                            <td class="text-right"><?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php
                        endforeach;
                    endif;
                    ?>
                
                    <tr>
                        <td colspan="3" style="border-top: 1px dashed #000;"></td>
                    </tr>
                    <tr>
                        <td colspan="2">TOTAL TAGIHAN</td>
                        <td class="text-right">Rp <?php echo number_format($total_tagihan, 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">UANG DIBAYAR</td>
                        <td class="text-right">Rp <?php echo number_format($this->session->flashdata('jumlah_bayar'), 0, ',', '.'); ?></td> 
                    </tr>
                    <tr>
                        <td colspan="2">KEMBALIAN</td>
                        <td class="text-right">Rp <?php echo number_format($this->session->flashdata('kembalian'), 0, ',', '.'); ?></td> 
                    </tr>
                </tbody>
            </table>

            <div class="text-center" style="margin-top: 15px;">
                <p style="margin-bottom: 0; font-size: 8pt;">Terima kasih atas kunjungan Anda.</p>
                <p style="font-size: 8pt;">Simpan struk ini sebagai bukti pembayaran.</p>
            </div>

        </div>
    </div>
</div>

<div class="text-center" style="margin-top: 20px;">
    <a href="<?php echo site_url('transaksi/pembayaran'); ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali ke Daftar Tagihan</a>
    <button class="btn btn-success btn-print" onclick="window.print()"><i class="fa fa-print"></i> Cetak Struk</button>
</div>

<script>
    // Langsung tampilkan dialog cetak setelah halaman dimuat
    window.onload = function() {
        // Cek apakah mode cetak diperlukan (misal dari URL parameter jika ada)
        window.print();
    }
</script>