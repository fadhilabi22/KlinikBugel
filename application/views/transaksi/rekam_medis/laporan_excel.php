<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Dokter</th>
            <th>Keluhan</th>
            <th>Diagnosa</th>
            <th>Catatan Medis</th>
        </tr>
    </thead>
    <tbody>
        <?php $no=1; foreach($laporan as $r): ?>
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
