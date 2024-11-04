<?php
// Konfigurasi koneksi
$config["server"] = 'localhost';
$config["username"] = 'root';
$config["password"] = '';
$config["database_name"] = 'fahp';

try {
    // Membuat koneksi PDO
    $dsn = "mysql:host={$config['server']};dbname={$config['database_name']};charset=utf8mb4";
    $koneksi = new PDO($dsn, $config['username'], $config['password']);

    // Set atribut untuk menampilkan error PDO
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil kode alternatif terakhir dari database
    $query_kode_terakhir = "SELECT MAX(CAST(SUBSTRING(kode_alternatif, 2) AS SIGNED)) as max_kode FROM tb_alternatif";
    $result_kode_terakhir = $koneksi->query($query_kode_terakhir);

    if ($result_kode_terakhir->rowCount() > 0) {
        $row = $result_kode_terakhir->fetch(PDO::FETCH_ASSOC);
        $nomor_terakhir = $row['max_kode'];
    } else {
        $nomor_terakhir = 1; // Jika tidak ada data, dimulai dari 0
    }

    // Tambah 1 ke nomor terakhir untuk mendapatkan nomor baru yang unik
    $nomor_terakhir++;

    // Formatkan nomor terakhir sesuai dengan kebutuhan (contoh: "A34")
    $nomor_format = 'A' . str_pad($nomor_terakhir, 2, '0', STR_PAD_LEFT);

} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Tutup koneksi PDO
$koneksi = null;
?>

<div class="page-header">
    <h1>Tambah Alternatif</h1>
</div>
<div class="row">
    <div class="col-sm-6">
    <?php if ($_POST) include 'aksi.php' ?>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Kode <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="kode" value="<?= $nomor_format ?>" readonly />
            </div>
            <div class="form-group">
                <label>Nama Alternatif <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="nama" value="<?= set_value('nama') ?>" />
            </div>
            <div class="form-group">
                <label>Keterangan </label>
                <textarea class="form-control editor" name="keterangan"><?= set_value('keterangan') ?></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                <a class="btn btn-danger" href="?m=alternatif"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </form>
    </div>
</div>
