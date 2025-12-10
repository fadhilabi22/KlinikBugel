<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-print"></i> Daftar Kunjungan Selesai (Cetak Ulang Struk)</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Kunjungan</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Bayar</th>
                                <th>Total Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            // Variabel $list_selesai dikirim dari Controller Pembayaran::daftar_struk_selesai()
                            if(isset($list_selesai) && is_array($list_selesai)):
                                foreach($list_selesai as $item):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $item->id_kunjungan; ?></td>
                                <td><?php echo $item->nama_pasien; ?></td>
                                <td><?php echo date('d-m-Y H:i', strtotime($item->tgl_bayar)); ?></td>
                                <td>Rp <?php echo number_format($item->total_akhir, 0, ',', '.'); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('transaksi/pembayaran/cetak_struk/'.$item->id_kunjungan); ?>" 
                                       target="_blank" class="btn btn-sm btn-info" title="Cetak Ulang Struk">
                                        <i class="fa fa-print"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>