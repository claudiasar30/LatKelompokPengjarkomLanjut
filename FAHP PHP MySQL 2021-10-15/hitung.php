<style>
    .text-primary {
        font-weight: bold;
    }
</style>
<div class="page-header">
    <h1>Perhitungan</h1>
</div>
<?php
//menyimpan alternati yang dicentang ke vaiabel
$selected = (is_array(_post('selected'))) ? _post('selected') : array();
?>
<div>
    <form action="?m=hitung" method="post">
        <input type="hidden" name="m" value="hitung" />
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Pilih alternatif yang ingin dihitung</h3>
            </div>
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll" /></th>
                        <th>Nama Alternatif</th>
                    </tr>
                </thead>
                <?php
                //mengambil data alternatif di database  
                $rows = $db->get_results("SELECT * FROM tb_alternatif ORDER BY kode_alternatif");
                $no = 1;
                foreach ($rows as $row) : ?>
                    <tr>
                        <td><input type="checkbox" name="selected[]" value="<?= $row->kode_alternatif ?>" <?= (in_array($row->kode_alternatif, $selected)) ? 'checked' : '' ?> /></td>
                        <td><?= $row->nama_alternatif ?></td>
                    </tr>
                <?php endforeach;
                ?>
            </table>
            <div class="panel-footer">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> Hitung</button>
            </div>
        </div>
    </form>
</div>
<?php
//jika submit pada form
if ($_POST) {
    $c = $db->get_results("SELECT * FROM tb_rel_alternatif WHERE nilai>0");
    if (!$ALTERNATIF || !$KRITERIA) : // jika belum ada data kriteria atau alternatif
        echo "Tampaknya anda belum mengatur alternatif dan kriteria. Silahkan tambahkan minimal 3 alternatif dan 3 kriteria.";
    elseif (!$c) : //jika belum mengatur nilai alternatif (default nilai alternatif adalah -1)
        echo "Tampaknya anda belum mengatur nilai alternatif. Silahkan atur pada menu <strong>Nilai Bobot</strong> > <strong>Nilai Bobot Alternatif</strong>.";
    elseif (count($selected) < 2) : //jika memilih alternatif kuranf dari 2
        print_msg("Pilih minimal 2 alternatif");
    else :
        //jika sukses akan memanggil hasil.php
        include 'hitung_hasil.php';
    endif;
}
?>

<script>
    //fungsi untuk mencentang (pilih) semua alternatif
    $(function() {
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    });
</script>