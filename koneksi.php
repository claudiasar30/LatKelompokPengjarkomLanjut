<?php
	$host = "localhost";	// berisi ip address dari server
	$user = "root";			// username masuk MySQL dari web hosting
	$pass = "";				// password masuk MySQL dari web hosting
	$db   = "latwebprog";		// nama database yang diakses
	
	$kon = mysqli_connect($host, $user, $pass, $db);
	
	// Cuma buat ngetes doank
	/*
	if($kon){
		echo "Terkoneksi dengan MySQL Server<br>";
		echo "Database $db bisa diakses";
	}else{
		echo "Maaf, Gagal Koneksi";
	}
	*/
?>