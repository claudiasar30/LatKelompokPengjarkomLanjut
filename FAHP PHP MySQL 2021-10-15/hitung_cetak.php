<h1>Perhitungan</h1>
<table>
    <thead>
        <tr>
            <th>Ranking</th>
            <th>Nama</th>
            <th>Total</th>
        </tr>
    </thead>
    <?php
    $selected = (array) $_GET['selected'];

    $rows = $db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif IN ('" . implode("','", $selected) . "') ORDER BY total DESC");
    foreach ($rows as $row) : ?>
        <tr>
            <td><?= $row->rank ?></td>
            <td><?= $row->nama_alternatif ?></td>
            <td><?= round($row->total, 3) ?></td>
        </tr>
    <?php endforeach ?>
</table>
<p>Jadi pilihan terbaik adalah <strong><?= $rows[0]->nama_alternatif ?></strong> dengan nilai <strong><?= round($rows[0]->total, 3) ?></strong> dari <strong><?= count($selected) ?></strong> alternatif.</p>