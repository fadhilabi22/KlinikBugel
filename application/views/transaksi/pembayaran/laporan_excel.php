<?php 
$laporan   = isset($laporan) ? $laporan : [];
$tgl_awal  = isset($tgl_awal) ? $tgl_awal : '';
$tgl_akhir = isset($tgl_akhir) ? $tgl_akhir : '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan</title>
</head>
<body>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <td colspan="4" align="center">
                <strong>LAPORAN PENDAPATAN KLINIK BUGEL</strong>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                Periode: <?= date('d/m/Y', strtotime($tgl_awal)); ?> 
                s/d <?= date('d/m/Y', strtotime($tgl_akhir)); ?>
            </td>
        </tr>
        <tr>
            <th>No</th>
            <th>NAMA PASIEN</th>
            <th>TANGGAL BAYAR</th>
            <th>TOTAL TAGIHAN</th>
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
            <td>Rp <?= number_format($item->total_akhir, 0, ',', '.'); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="3" align="right">
                <strong>GRAND TOTAL PENDAPATAN BERSIH</strong>
            </td>
            <td>
                <strong>Rp <?= number_format($grand_total, 0, ',', '.'); ?></strong>
            </td>
        </tr>
    </tfoot>
</table>

</body>
</html>