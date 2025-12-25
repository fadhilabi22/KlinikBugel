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

    .no-print {
        display: none !important;
    }
}
</style>

<div class="panel panel-default">
    <div class="panel-heading no-print">
        <h3><i class="fa fa-file-text-o"></i> Laporan Rekam Medis</h3>
    </div>

    <div class="panel-body">

        <!-- FILTER -->
        <?= form_open('', ['method'=>'post','class'=>'form-inline no-print']); ?>

        <label>Dari:</label>
        <input type="date" name="tgl_awal" class="form-control"
               value="<?= $tgl_awal ?>">

        <label style="margin-left:10px;">Sampai:</label>
        <input type="date" name="tgl_akhir" class="form-control"
               value="<?= $tgl_akhir ?>">

        <label style="margin-left:10px;">Pasien:</label>
        <select name="id_pasien" class="form-control">
            <option value="">Semua Pasien</option>
            <?php foreach($pasien as $p): ?>
                <option value="<?= $p->id_pasien ?>"
                    <?= $id_pasien==$p->id_pasien?'selected':'' ?>>
                    <?= $p->nama_pasien ?>
                </option>
            <?php endforeach ?>
        </select>

        <button class="btn btn-primary" style="margin-left:10px;">
            <i class="fa fa-search"></i> Tampilkan
        </button>

        <?= form_close(); ?>
        <hr>

        <!-- HASIL -->
        <?php if (!empty($rekam_medis)): ?>

        <?php
            $query_params = '?tgl_awal='.$tgl_awal.
                            '&tgl_akhir='.$tgl_akhir.
                            '&id_pasien='.$id_pasien;
        ?>

        <div class="print-area">

            <h3 class="text-center">LAPORAN REKAM MEDIS PASIEN</h3>
            <p class="text-center">
                Periode <?= date('d/m/Y',strtotime($tgl_awal)) ?>
                s/d <?= date('d/m/Y',strtotime($tgl_akhir)) ?>
            </p>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Nama Pasien</th>
                        <th width="15%">Dokter</th>
                        <th width="20%">Keluhan</th>
                        <th width="15%">Diagnosa</th>
                        <th width="20%">Catatan Medis</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($rekam_medis as $r): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $r->nama_pasien ?></td>
                        <td><?= $r->nama_dokter ?></td>
                        <td><?= $r->keluhan ?></td>
                        <td><?= $r->diagnosa ?></td>
                        <td><?= $r->catatan_medis ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

     
        <div class="no-print mt-3">
            <button class="btn btn-success" onclick="window.print()">
                <i class="fa fa-print"></i> Cetak
            </button>

        <a href="<?= site_url('transaksi/laporan_rekam_medis/export_excel'.$query_params); ?>"
            class="btn btn-success">
            <i class="fa fa-file-excel-o"></i> Export Excel
        </a>

        <a href="<?= site_url('transaksi/laporan_rekam_medis/export_pdf'.$query_params); ?>"
            target="_blank" class="btn btn-danger">
            <i class="fa fa-file-pdf-o"></i> Export PDF
        </a>

        </div>

        <?php else: ?>
            <div class="alert alert-info">
                Data tidak ditemukan
            </div>
        <?php endif ?>

    </div>
</div>
