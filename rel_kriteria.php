<div class="page-header">
    <h1>Nilai Bobot Kriteria</h1>
</div>
<?php
if ($_POST) include 'aksi.php';

$rows = $db->get_results("SELECT k.nama_kriteria, rk.ID1, rk.ID2, nilai 
    FROM tb_rel_kriteria rk INNER JOIN tb_kriteria k ON k.kode_kriteria=rk.ID1 
    ORDER BY ID1, ID2");
$criterias = array();
$data = array();
foreach ($rows as $row) {
    $criterias[$row->ID1] = $row->nama_kriteria;
    $data[$row->ID1][$row->ID2] = $row->nilai;
}
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline" action="?m=rel_kriteria" method="post">
            <div class="form-group">
                <select class="form-control" name="ID1">
                    <?= get_kriteria_option($_POST['ID1']) ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="nilai">
                    <?= get_nilai_option($_POST['nilai']) ?>
                </select>
            </div>
            <div class="form-group">
                <select class="form-control" name="ID2">
                    <?= get_kriteria_option($_POST['ID2']) ?>
                </select>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Ubah</a>
            </div>
        </form>
    </div>
    <?php
    $baris_total = get_total_kolom($data);
    $normal = AHP_normalize($data, $baris_total);
    $rata = get_rata($normal);

    $cm = AHP_consistency_measure($data, $rata);
    $CI = ((array_sum($cm) / count($cm)) - count($cm)) / (count($cm) - 1);
    $RI = $nRI[count($data)];
    $CR = ($RI == 0) ? 0 : $CI / $RI;
    if ($CR > 0.1) : ?>
        <div class="panel-body">
            <?= print_msg('Perbandingan yang anda inputkan tidak konsisten. Pastikan mengisi perbandingan dengan sesuai supaya maksimal nilai CR 0.1.') ?>
        </div>
    <?php endif ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr class="text-primary">
                    <th>Kode</th>
                    <?php foreach ($data as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($data as $key => $val) : ?>
                <tr>
                    <th class="text-primary"><?= $key ?></th>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="panel-body">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>Kode</th>
                    <?php foreach ($data as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                    <th>Bobot</th>
                    <th>CM</th>
                </tr>
            </thead>
            <?php foreach ($normal as $key => $val) : ?>
                <tr>
                    <th><?= $key ?></th>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                    <td><?= round($rata[$key], 3) ?></td>
                    <td><?= round($cm[$key], 3) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="panel-body">
        <?php
        echo "<p>Consistency Index: " . round($CI, 3) . "<br />";
        echo "Ratio Index: " . round($RI, 3) . "<br />";
        echo "Consistency Ratio: " . round($CR, 3);
        if ($CR > 0.10) {
            echo " (Tidak konsisten)<br />";
        } else {
            echo " (Konsisten)<br />";
        }
        ?>
    </div>
</div>