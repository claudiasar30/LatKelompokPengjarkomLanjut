<div class="panel panel-default">
    <div class="panel-heading"><strong>Matriks Perbandingan Kriteria AHP</strong></div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <?php
                    //memanggil fungsi get_relkriteria
                    $matriks = get_relkriteria();
                    foreach ($matriks as $key => $value) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                <tr>
            </thead>
            <?php
            //menampilkan matriks dalam bentuk tabel
            foreach ($matriks as $key => $value) : ?>
                <tr>
                    <th><?= $key . '-' . $KRITERIA[$key] ?></th>
                    <?php foreach ($value as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><strong>Matriks Perbandingan Kriteria Fuzzy AHP</strong></div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <?php
                    $matriks_fahp = get_relkriteria_lmu($matriks); //memanggil fungsi get_relkriteria
                    $lmu = get_lmu($matriks_fahp); //memanggil fungsi get_lmu        
                    $total_lmu = get_total_lmu($lmu); //memanggil fungsi get_total_lmu 

                    foreach ($matriks as $key => $value) : ?>
                        <th colspan="3"><?= $key ?></th>
                    <?php endforeach ?>
                    <th colspan="3">Jumlah Baris</th>
                <tr>
            </thead>
            <tr>
                <td></td>
                <?php foreach ($matriks_fahp as $key => $value) : ?>
                    <th>L</th>
                    <th>M</th>
                    <th>U</th>
                <?php endforeach ?>
                <th>L</th>
                <th>M</th>
                <th>U</th>
            </tr>
            <?php
            //menampilkan matriks_fahp dalam bentuk tabel 
            foreach ($matriks_fahp as $key => $value) : ?>
                <tr>
                    <th><?= $key ?></th>
                    <?php foreach ($value as $k => $v) :
                        $class = ($key == $k) ? 'bg-success' : '';
                    ?>
                        <td class="<?= $class ?>"><?= round($v[0], 2) ?></td>
                        <td class="<?= $class ?>"><?= round($v[1], 2) ?></td>
                        <td class="<?= $class ?>"><?= round($v[2], 2) ?></td>
                    <?php endforeach ?>
                    <td><?= round($lmu[$key][0], 2) ?>
                    <td><?= round($lmu[$key][1], 2) ?>
                    <td><?= round($lmu[$key][2], 2) ?>
                </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="<?= count($matriks) * 3 + 1 ?>">Total [L, M, U]</td>
                <td><?= round($total_lmu[0], 2) ?>
                <td><?= round($total_lmu[1], 2) ?>
                <td><?= round($total_lmu[2], 2) ?>
            </tr>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><strong>Perhitungan nilai Sintesis (Si)</strong></div>
    <div class="table-responsive">
        <?php
        $Si = get_Si($lmu, $total_lmu); //memanggil fungsi get_Si            
        ?>
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th colspan="3">Jumlah Baris</th>
                    <th colspan="3">Nilai Sintesis</th>
                </tr>
                <tr>
                    <th></th>
                    <td>L</td>
                    <td>M</td>
                    <td>U</td>
                    <td>L</td>
                    <td>M</td>
                    <td>U</td>
                </tr>
            </thead>
            <?php foreach ($lmu as $key => $val) : ?>
                <tr>
                    <th><?= $key ?></th>
                    <td><?= round($val[0], 3) ?></td>
                    <td><?= round($val[1], 3) ?></td>
                    <td><?= round($val[2], 3) ?></td>
                    <td><?= round($Si[$key][0], 3) ?></td>
                    <td><?= round($Si[$key][1], 3) ?></td>
                    <td><?= round($Si[$key][2], 3) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Penentuan Nilai Vektor (V) dan Nilai Ordinat Defuzzifikasi (d')</div>
    <div class="panel-body">
        <?php
        $mins = array();
        foreach ($KRITERIA as $kode => $nama) : ?>
            <div class="panel panel-warning">
                <div class="panel-heading"><?= $nama ?></div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>a = l-u<?= $kode ?></th>
                                <th>b = m<?= $kode ?>-u<?= $kode ?></th>
                                <th>c = m-l</th>
                                <th>d = b-c</th>
                                <th>e = a/d</th>
                                <th>d'</th>
                            </tr>
                        </thead>
                        <?php
                        $d_aksen = array();
                        foreach ($Si as $key => $val) : ?>
                            <?php if ($kode != $key) :
                                $a = $val[0] - $Si[$kode][2];
                                $b = $Si[$kode][1] - $Si[$kode][2];
                                $c = $val[1] - $val[0];
                                $d = $b - $c;
                                $e = $a / $d;
                                $d_aksen[$key] = ($Si[$kode][1] >= $Si[$key][1]) ? 1 : (($Si[$key][0] >= $Si[$kode][2]) ? 0 : $e);
                            ?>
                                <tr>
                                    <td><?= $kode . '&gt;' . $key ?></td>
                                    <td><?= round($a, 3) ?></td>
                                    <td><?= round($b, 3) ?></td>
                                    <td><?= round($c, 3) ?></td>
                                    <td><?= round($d, 3) ?></td>
                                    <td><?= round($e, 3) ?></td>
                                    <td><?= round($d_aksen[$key], 3) ?></td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    </table>
                </div>
                <?php
                $mins[$kode] = min($d_aksen);
                ?>
                <div class="panel-footer">MIN : <?= round($mins[$kode], 3) ?></div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><strong>Normalisasi Bobot Vektor (W)</strong></div>
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>W</th>
                <th>W Lokal</th>
            </tr>
        </thead>
        <?php
        $sum = array_sum($mins);
        foreach ($mins as $key => $val) : ?>
            <tr>
                <th><?= $key ?></th>
                <td><?= round($val, 3) ?></td>
                <td><?= round($val / $sum, 3) ?></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><strong>Hasil Pembobotan</strong></div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th rowspan="2"></th>
                    <?php
                    $data = get_rel_alternatif($_POST['selected']);
                    $total = get_total($data, $mins);

                    foreach ($KRITERIA as $key => $val) : ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                    <?php foreach ($mins as $key => $val) : ?>
                        <th><?= round($val / $sum, 3) ?></th>
                    <?php endforeach ?>
                </tr>
            </thead>
            <?php foreach ($data as $key => $val) : ?>
                <tr>
                    <th><?= $key ?></th>
                    <?php foreach ($val as $k => $v) : ?>
                        <td><?= round($v, 3) ?></td>
                    <?php endforeach ?>
                    <td><?= round($total[$key], 3) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading"><strong>Perangkingan</strong></div>
    <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Nama</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php
            FAHP_save($total); // memanggil fungsi FAHP_save
            $rows = $db->get_results("SELECT * FROM tb_alternatif WHERE kode_alternatif IN ('" . implode("','", $selected) . "') ORDER BY total DESC");
            foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row->rank ?></td>
                    <td><?= $row->nama_alternatif ?></td>
                    <td><?= round($total[$row->kode_alternatif], 3) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="panel-body">
        <?php
        $best = $rows[0]->kode_alternatif;
        ?>
        <p>Jadi pilihan terbaik adalah <strong><?= $ALTERNATIF[$best] ?></strong> dengan nilai <strong><?= round($total[$best], 3) ?></strong> dari <strong><?= count($selected) ?></strong> alternatif.</p>
        <p><a class="btn btn-default" target="_blank" href="cetak.php?m=hitung&<?= http_build_query(array('selected' => $selected)) ?>"><span class="glyphicon glyphicon-print"></span> Cetak</a></p>
    </div>
</div>