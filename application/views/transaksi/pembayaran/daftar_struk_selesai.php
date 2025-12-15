<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left">
                    <i class="fa fa-print"></i> Daftar Kunjungan Selesai (Cetak Ulang Struk)
                </h3>

                <!-- 🔍 SEARCH FORM -->
                <form action="<?= site_url('transaksi/pembayaran/daftar_struk_selesai') ?>" 
                      method="get" class="pull-right" style="width:300px;">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control"
                               placeholder="Cari ID / Nama Pasien"
                               value="<?= $this->input->get('q') ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </form>
            </div>

            <div class="panel-body">
                <div class="table-responsive">

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="40">No</th>
                                <th>ID Kunjungan</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Bayar</th>
                                <th>Total Bayar</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if(!empty($list_selesai)): ?>
                            <?php $no = 1; foreach($list_selesai as $item): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $item->id_kunjungan ?></td>
                                <td><?= $item->nama_pasien ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($item->tgl_bayar)) ?></td>
                                <td>Rp <?= number_format($item->total_akhir, 0, ',', '.') ?></td>
                                <td class="text-center">
                                    <a href="<?= site_url('transaksi/pembayaran/cetak_struk/'.$item->id_kunjungan) ?>" 
                                       target="_blank"
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-print"></i> Cetak
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fa fa-info-circle"></i> Data tidak ditemukan
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>