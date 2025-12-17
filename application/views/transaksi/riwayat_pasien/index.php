<div class="panel panel-default">
    <div class="panel-heading">
        <h3><i class="fa fa-history"></i> Riwayat Pasien</h3>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="40">No</th>
                        <th>ID Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Bayar</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php if(!empty($riwayat)): ?>
                    <?php $no=1; foreach($riwayat as $r): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $r->id_kunjungan ?></td>
                        <td><?= $r->nama_pasien ?></td>
                        <td>
                            <?= $r->tgl_bayar 
                                ? date('d-m-Y H:i', strtotime($r->tgl_bayar)) 
                                : '-' ?>
                        </td>
                        <td>Rp <?= number_format($r->total_akhir,0,',','.') ?></td>
                        <td>
                            <span class="label label-success">
                                <?= $r->status_bayar ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            <i class="fa fa-info-circle"></i> Data riwayat belum ada
                        </td>
                    </tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
