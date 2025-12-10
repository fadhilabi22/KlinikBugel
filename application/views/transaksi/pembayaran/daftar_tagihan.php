<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary panel-elegant">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-money"></i> Daftar Pasien Menunggu Pembayaran</h3>
            </div>
            <div class="panel-body">
                
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Kunjungan</th>
                                <th>Nama Pasien</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if(isset($list_tagihan) && is_array($list_tagihan)):
                                foreach($list_tagihan as $tagihan):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $tagihan->id_kunjungan; ?></td>
                                <td><?php echo $tagihan->nama_pasien; ?></td>
                                <td><span class="label label-warning"><?php echo $tagihan->status_kunjungan; ?></span></td>
                                <td class="text-center">
                                    <a href="<?php echo site_url('transaksi/pembayaran/form_tagihan/'.$tagihan->id_kunjungan); ?>" 
                                       class="btn btn-sm btn-info" title="Proses Pembayaran">
                                        <i class="fa fa-shopping-cart"></i> Proses Bayar
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