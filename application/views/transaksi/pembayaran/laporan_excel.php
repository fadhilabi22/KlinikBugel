<?php 
// View ini dimuat langsung oleh Controller, tanpa template.

// Ambil data laporan dari Controller
$laporan = isset($laporan) ? $laporan : [];
$tgl_awal = isset($tgl_awal) ? $tgl_awal : '';
$tgl_akhir = isset($tgl_akhir) ? $tgl_akhir : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan</title>
</head>
<body>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <td colspan="5" align="center">
                    <strong>LAPORAN PENDAPATAN KLINIK BUGEL</strong>
                </td>
            </tr>
            <tr>
                <td colspan="5" align="center">
                    Periode: <?php echo date('d/m/Y', strtotime($tgl_awal)); ?> s/d <?php echo date('d/m/Y', strtotime($tgl_akhir)); ?>
                </td>
            </tr>
            <tr>
                <th>No</th>
                <th>ID KUNJUNGAN</th>
                <th>NAMA PASIEN</th>
                <th>TANGGAL BAYAR</th>
                <th>TOTAL TAGIHAN</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $grand_total = 0;
            foreach($laporan as $item): 
                $grand_total += $item->total_akhir;
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $item->id_kunjungan; ?></td>
                <td><?php echo $item->nama_pasien; ?></td>
                <td><?php echo date('Y-m-d H:i', strtotime($item->tgl_bayar)); ?></td>
                <td>Rp&nbsp;<?php echo number_format($item->total_akhir, 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right">GRAND TOTAL PENDAPATAN BERSIH</td>
                <td>Rp&nbsp;<?php echo number_format($grand_total, 0, ',', '.'); ?></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>