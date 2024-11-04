<?php
session_start();

include 'config.php'; //memanggil file config.php
include 'includes/db.php'; //memanggil file config.php
$db = new DB($config['server'], $config['username'], $config['password'], $config['database_name']);
include 'includes/general.php'; //memanggil file general.php   

function _post($key, $val = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];
    else
        return $val;
}

function _get($key, $val = null)
{
    global $_GET;
    if (isset($_GET[$key]))
        return $_GET[$key];
    else
        return $val;
}

function _session($key, $val = null)
{
    global $_SESSION;
    if (isset($_SESSION[$key]))
        return $_SESSION[$key];
    else
        return $val;
}

$mod = _get('m');
$act = _get('act');

$nRI = array( //menyimpan nilai RATIO INDEX
    1 => 0,
    2 => 0,
    3 => 0.58,
    4 => 0.9,
    5 => 1.12,
    6 => 1.24,
    7 => 1.32,
    8 => 1.41,
    9 => 1.46,
    10 => 1.49
);

/**
 * mengambil data alternatif dari database 
 * kemudian menyimpan dalam array
 */
$ALTERNATIF = array();
$rows = $db->get_results("SELECT kode_alternatif, nama_alternatif FROM tb_alternatif ORDER BY kode_alternatif");
foreach ($rows as $row) {
    $ALTERNATIF[$row->kode_alternatif] = $row->nama_alternatif;
}

/**
 * mengambil data kriteria dari database 
 * kemudian menyimpan dalam array
 */
$KRITERIA = array();
$rows = $db->get_results("SELECT kode_kriteria, nama_kriteria FROM tb_kriteria ORDER BY kode_kriteria");
foreach ($rows as $row) {
    $KRITERIA[$row->kode_kriteria] = $row->nama_kriteria;
}

/**
 * mengambil nilai perbandingan kriteria dari database 
 * kemudian menyimpan dalam array
 */
function get_relkriteria()
{
    global $db;
    $data = array();
    $rows = $db->get_results("SELECT k.nama_kriteria, rk.ID1, rk.ID2, nilai 
        FROM tb_rel_kriteria rk INNER JOIN tb_kriteria k ON k.kode_kriteria=rk.ID1 
        ORDER BY ID1, ID2");
    foreach ($rows as $row) {
        $data[$row->ID1][$row->ID2] = $row->nilai;
    }
    return $data;
}

/**
 * mengambil nilai triangular FUZZY AHP
 */
function get_triangular($nilai)
{
    $fahp_triangular = array(
        '1' => array(
            'name' => 'Sama penting dengan',
            'tfn' => array(1, 1, 1),
            'rec' => array(1, 1, 1),
        ),
        '2' => array(
            'name' => 'Mendekati sedikit lebih penting dari',
            'tfn' => array(1 / 2, 1, 3 / 2),
            'rec' => array(2 / 3, 1, 2),
        ),
        '3' => array(
            'name' => 'Sedikit lebih penting dari',
            'tfn' => array(1, 3 / 2, 2),
            'rec' => array(1 / 2, 2 / 3, 1),
        ),
        '4' => array(
            'name' => 'Mendekati lebih penting dari',
            'tfn' => array(3 / 2, 2, 5 / 2),
            'rec' => array(2 / 5, 1 / 2, 2 / 3),
        ),
        '5' => array(
            'name' => 'Lebih penting dari',
            'tfn' => array(2, 5 / 2, 3),
            'rec' => array(1 / 3, 2 / 5, 1 / 2),
        ),
        '6' => array(
            'name' => 'Mendekati sangat penting dari',
            'tfn' => array(5 / 2, 3, 7 / 2),
            'rec' => array(2 / 7, 1 / 3, 2 / 5),
        ),
        '7' => array(
            'name' => 'Sangat penting dari',
            'tfn' => array(3, 7 / 2, 4),
            'rec' => array(1 / 4, 2 / 7, 1 / 3),
        ),
        '8' => array(
            'name' => 'Mendekati mutlak dari',
            'tfn' => array(7 / 2, 4, 9 / 2),
            'rec' => array(2 / 9, 1 / 4, 2 / 7),
        ),
        '9' => array(
            'name' => 'Mutlak sangat penting dari',
            'tfn' => array(4, 9 / 2, 9 / 2),
            'rec' => array(2 / 9, 2 / 9, 1 / 4),
        ),
    );

    $keys = array_keys($fahp_triangular);
    $arr = array();
    foreach ($keys as $key) {
        $arr[round(1 / $key, 5) . ""] = $key;
    }

    if (array_key_exists($nilai, $fahp_triangular)) {
        return $fahp_triangular[$nilai]['tfn'];
    } else {
        return $fahp_triangular[$arr[round($nilai, 5) . ""]]['rec'];
    }
}

/**
 * mengambil nilai triangular berdasarkan nilai perbandingan kriteria
 */
function get_relkriteria_lmu($matriks = array())
{
    $arr = array();
    foreach ($matriks as $key => $val) {
        foreach ($val as $k => $v) {
            $arr[$key][$k] = get_triangular($v);
        }
    }
    return $arr;
}

/**
 * mencari nilai l, m, u
 */
function get_lmu($matriks = array())
{
    $arr = array();
    foreach ($matriks as $key => $val) {
        $arr[$key][0] = 0;
        $arr[$key][1] = 0;
        $arr[$key][2] = 0;
        foreach ($val as $k => $v) {
            $arr[$key][0] += $v[0];
            $arr[$key][1] += $v[1];
            $arr[$key][2] += $v[2];
        }
    }
    //print_r($arr);
    return $arr;
}

/**
 * mencari total nilai lmu
 */
function get_total_lmu($total_baris = array())
{
    $arr = array();
    foreach ($total_baris as $val) {
        if (!isset($arr[0]))
            $arr[0] = 0;
        $arr[0] += $val[0];
        if (!isset($arr[1]))
            $arr[1] = 0;
        $arr[1] += $val[1];
        if (!isset($arr[2]))
            $arr[2] = 0;
        $arr[2] += $val[2];
    }
    return $arr;
}

/**
 * mencari nilai sintesis
 */
function get_Si($lmu, $total_lmu)
{

    $arr = array();
    foreach ($lmu as $key => $val) {
        $arr[$key][0] = $val[0] / $total_lmu[2];
        $arr[$key][1] = $val[1] / $total_lmu[1];
        $arr[$key][2] = $val[2] / $total_lmu[0];
    }
    return $arr;
}

/**
 * mengambil nilai alternatif dari database 
 * kemudian menyimpan dalam array
 */
function get_rel_alternatif($selected = array())
{
    global $db;

    $where = $selected ? " AND kode_alternatif IN ('" . implode("','", $selected) . "')" : "";
    $rows = $db->get_results("SELECT * FROM tb_rel_alternatif 
        WHERE 1 $where ORDER BY kode_alternatif, kode_kriteria");
    $matriks = array();
    foreach ($rows as $row) {
        $matriks[$row->kode_alternatif][$row->kode_kriteria] = $row->nilai;
    }
    return $matriks;
}

/**
 * menghitung nilai total
 */
function get_total($data = array(), $mins = array())
{
    $arr = array();
    $sum = array_sum($mins);

    foreach ($data as $key => $val) {
        foreach ($val as $k => $v) {
            $arr[$key][$k] = $v * $mins[$k] / $sum;
        }
    }

    $result = array();
    foreach ($arr as $key => $val) {
        foreach ($val as $k => $v) {
            if (!isset($result[$key]))
                $result[$key] = 0;
            $result[$key] += $v;
        }
    }
    return $result;
}

/**
 * menyimpan hasil fuzzy ahp
 */
function FAHP_save($total = array())
{
    global $db;

    arsort($total);
    $no = 1;
    foreach ($total as $key => $val) {
        $db->query("UPDATE tb_alternatif SET total='$val', rank='$no' WHERE kode_alternatif='$key'");
        $no++;
    }
}
/** ============================== */

/**
 * option untuk nilai kriteria
 */
function get_nilai_option($selected = '')
{
    $nilai = array(
        '1' => 'Sama penting dengan',
        '2' => 'Mendekati sedikit lebih penting dari',
        '3' => 'Sedikit lebih penting dari',
        '4' => 'Mendekati lebih penting dari',
        '5' => 'Lebih penting dari',
        '6' => 'Mendekati sangat penting dari',
        '7' => 'Sangat penting dari',
        '8' => 'Mendekati mutlak dari',
        '9' => 'Mutlak sangat penting dari',
    );
    $a = '';
    foreach ($nilai as $key => $value) {
        if ($selected == $key)
            $a .= "<option value='$key' selected>$key - $value</option>";
        else
            $a .= "<option value='$key'>$key - $value</option>";
    }
    return $a;
}

/**
 * mencari total kolom dari matriks
 */
function get_total_kolom($matriks = array())
{
    $total = array();
    foreach ($matriks as $key => $value) {
        foreach ($value as $k => $v) {
            if (!isset($total[$k]))
                $total[$k] = 0;
            $total[$k] += $v;
        }
    }
    return $total;
}

/**
 * menormalkan matriks
 */
function AHP_normalize($matriks = array(), $total = array())
{

    foreach ($matriks as $key => $value) {
        foreach ($value as $k => $v) {
            $matriks[$key][$k] = $matriks[$key][$k] / $total[$k];
        }
    }
    return $matriks;
}

/**
 * mencari nilai rata-rata matriks
 */
function get_rata($normal)
{
    $rata = array();
    foreach ($normal as $key => $value) {
        $rata[$key] = array_sum($value) / count($value);
    }
    return $rata;
}

/**
 * perkalian matriks
 */
function AHP_mmult($matriks = array(), $rata = array())
{
    $data = array();

    $rata = array_values($rata);

    foreach ($matriks as $key => $value) {
        $no = 0;
        $data[$key] = 0;
        foreach ($value as $k => $v) {
            $data[$key] += $v * $rata[$no];
            $no++;
        }
    }

    return $data;
}

/**
 * mengambil nilai konsistensi
 */
function AHP_consistency_measure($matriks, $rata)
{
    $matriks = AHP_mmult($matriks, $rata);
    foreach ($matriks as $key => $value) {
        $data[$key] = $value / $rata[$key];
    }
    return $data;
}
/**
 * option untuk kriteria
 */
function get_kriteria_option($selected = '')
{
    global $db;
    $rows = $db->get_results("SELECT kode_kriteria, nama_kriteria FROM tb_kriteria ORDER BY kode_kriteria");
    $a = '';
    foreach ($rows as $row) {
        if ($row->kode_kriteria == $selected)
            $a .= "<option value='$row->kode_kriteria' selected>$row->kode_kriteria - $row->nama_kriteria</option>";
        else
            $a .= "<option value='$row->kode_kriteria'>$row->kode_kriteria - $row->nama_kriteria</option>";
    }
    return $a;
}
function set_value($key = null, $default = null)
{
    global $_POST;
    if (isset($_POST[$key]))
        return $_POST[$key];

    if (isset($_GET[$key]))
        return $_GET[$key];

    return $default;
}
