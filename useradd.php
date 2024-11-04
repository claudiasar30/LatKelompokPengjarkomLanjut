<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style.css">
<title>Untitled Document</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="" enctype="multipart/form-data">
    <table width="100%" border="2">
      <tr>
        <td width="45%">Id User</td>
        <td width="55%"><input name="iduser" type="text" id="iduser" /></td>
      </tr>
      <tr>
        <td>Username</td>
        <td><input name="username" type="text" id="username" /></td>
      </tr>
      <tr>
        <td>Password</td>
        <td><input name="password" type="password" id="password" /></td>
      </tr>
	  <tr>
        <td>Email</td>
        <td><input name="email" type="text" id="email" /></td>
      </tr>
	  <tr>
        <td>Nama</td>
        <td><input name="nama" type="text" id="nama" /></td>
      </tr>
      <tr>
        <td>Tempat / Tanggal Lahir</td>
        <td><input name="tmplahir" type="text" id="tmplahir" />
/
  <input name="tgllahir" type="date" id="tgllahir" /></td>
      </tr>
      <tr>
        <td>Jenis Kelamin</td>
        <td><input name="jk" type="radio" value="L" />
Laki-Laki
  <input name="jk" type="radio" value="P" />
Perempuan </td>
      </tr>
        <td>Foto</td>
        <td><input name="foto" type="file" id="foto" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input name="simpan" type="submit" id="simpan" value="Simpan Data User" /></td>
      </tr>
    </table>
  <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
  <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</form>

<?php
if($_POST["simpan"]){
	include "koneksi.php";
	$nmfoto  = $_FILES["foto"]["name"];
	$lokfoto = $_FILES["foto"]["tmp_name"];
	if(!empty($lokfoto)){
		move_uploaded_file($lokfoto, "foto/$nmfoto");
	}
	
	$sqlm = mysqli_query($kon, "insert into user (iduser, username, password, email, nama, tmplahir, tgllahir, jk, foto, tgldaftar) values ('$_POST[iduser]', '$_POST[username]', '$_POST[password]', '$_POST[email]', '$_POST[nama]', '$_POST[tmplahir]', '$_POST[tgllahir]', '$_POST[jk]', '$nmfoto', NOW())");
	
	if($sqlm){
		echo "Data User berhasil disimpan";
	}else{
		echo "Gagal menyimpan";
	}
	echo "<META HTTP-EQUIV='Refresh' Content='2; URL=?p=user'>";
}
?>

</body>
</html>


