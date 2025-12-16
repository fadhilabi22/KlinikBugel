<style>
/* =========================
   MODE CETAK
========================= */
@media print {

    body * {
        visibility: hidden;
    }

    .print-area,
    .print-area * {
        visibility: visible;
    }

    .print-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    /* sembunyikan tombol */
    .no-print {
        display: none !important;
    }
}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-heading no-print">
                <h3 class="panel-title">
                    <i class="fa fa-bar-chart"></i> Laporan Pendapatan Harian / Bulanan
                </h3>
            </div>

            <div class="panel-body">

                <!-- ================= FORM FILTER ================= -->
                <?php echo form_open('transaksi/pembayaran/laporan_pendapatan', [
                    'method' => 'post',
                    'class'  => 'form-inline no-print'
                ]); ?>

                <div class="form-group">
                    <label>Dari Tanggal:</label>
                    <input type="date" name="tgl_awal" class="form-control"
                           value="<?= html_escape($tgl_awal); ?>" required>
                </div>

                <div class="form-group" style="margin-left:10px;">
                    <label>Sampai Tanggal:</label>
                    <input type="date" name="tgl_akhir" class="form-control"
                           value="<?= html_escape($tgl_akhir); ?>" required>
                </div>

                <div class="form-group" style="margin-left:10px;">
                    <label>Cari:</label>
                    <input type="text" name="keyword" class="form-control"
                           placeholder="Nama pasien"
                           value="<?= isset($keyword) ? html_escape($keyword) : ''; ?>">
                </div>

                <button class="btn btn-primary" style="margin-left:10px;">
                    <i class="fa fa-search"></i> Tampilkan
                </button>

                <?php echo form_close(); ?>
                <hr class="no-print">

                <!-- ================= AREA CETAK ================= -->
                <?php if (!empty($laporan)): ?>

                <div class="print-area">

                    <h3 class="text-center">
                        LAPORAN PENDAPATAN KLINIK BUGEL
                    </h3>
                    <p class="text-center">
                        Periode:
                        <?= date('d/m/Y', strtotime($tgl_awal)); ?>
                        s/d
                        <?= date('d/m/Y', strtotime($tgl_akhir)); ?>
                    </p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Bayar</th>
                                <th>Total Tagihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $grand_total = 0;
                                foreach ($laporan as $item):
                                    $grand_total += $item->total_akhir;
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $item->nama_pasien; ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($item->tgl_bayar)); ?></td>
                                <td>Rp <?= number_format($item->total_akhir,0,',','.'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">
                                    GRAND TOTAL PENDAPATAN BERSIH
                                </th>
                                <th>
                                    Rp <?= number_format($grand_total,0,',','.'); ?>
                                </th>
                            </tr>
                        </tfoot>
                    </table>

                </div>

                <!-- ================= TOMBOL ================= -->
                <?php
                    $query_params = '?tgl_awal='.$tgl_awal.'&tgl_akhir='.$tgl_akhir.'&keyword='.$keyword;
                ?>

                <div class="no-print mt-3">
                    <button class="btn btn-success" onclick="window.print()">
                        <i class="fa fa-print"></i> Cetak Laporan
                    </button>

                    <a href="<?= site_url('transaksi/pembayaran/export_excel'.$query_params); ?>"
                       class="btn btn-info">
                       <i class="fa fa-file-excel-o"></i> Export Excel
                    </a>

                    <a href="<?= site_url('transaksi/pembayaran/export_pdf'.$query_params); ?>"
                       target="_blank" class="btn btn-danger">
                       <i class="fa fa-file-pdf-o"></i> Export PDF
                    </a>
                </div>

                <?php else: ?>

                    <div class="alert alert-info">
                        Silahkan pilih rentang tanggal.
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
