<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" href="style.css">
<title>Latihan Pengjarkom Lanjut</title>
</head>

<body>
<h2>Data Kelompok </h2>
<?php
 	include "koneksi.php";
	if($_GET["p"] == "useradd"){
		include "useradd.php";
	}else if($_GET["p"] == "useredit"){
		include "useredit.php";
	}else if($_GET["p"] == "userdel"){
		include "userdel.php";
	}else{
		include "user.php";
	}
?>
</body>
</html>
