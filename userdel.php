<?php
	include "koneksi.php";
	$sqlm = mysqli_query($kon, "delete from user where iduser='$_GET[iduser]'");
	
	if($sqlm){
		echo "Data User berhasil dihapus";
	}else{
		echo "Gagal menyimpan";
	}
	echo "<META HTTP-EQUIV='Refresh' Content='2; URL=?p=user'>";
?>