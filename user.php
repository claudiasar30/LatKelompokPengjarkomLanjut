<?php
	echo "<a href='?p=useradd'>Tambah Data</a>";
	echo "<table width='100%' border='1' cellspacing='5' cellpadding='5'>";
	echo "<tr>
			<th>NO</th>
			<th>FOTO</th>
			<th>USER</th>
			<th>DATA PERSONAL</th>
			<th>KONTAK</th>
			<th>AKSI</th>
		  </tr>";
	$sqlm = mysqli_query($kon, "select *from user order by tgldaftar desc");
	$no =1;
	while($rm = mysqli_fetch_array($sqlm)){
		echo "<tr>
			<td>$no</td>
			<td><img src='foto/$rm[foto]' width ='100px'></td>
			<td>
				Id. User :<b>$rm[iduser]</b> <br>
				Username :<b>$rm[username]</b> <br>
				Nama :<b>$rm[nama]</b> <br>
				Password :<b>$rm[password]</b> <br>
				Data didaftar pada : <b>$rm[tgldaftar] WIB</b>
			</td>
			<td>
				Tempat / Tanggal Lahir : <br>
				<b>$rm[tmplahir] / $rm[tgllahir]</b> <br>
				Jenis Kelamin : <b>$rm[jk]</b>
			</td>
			<td>
				Email : <b>$rm[email]</b> <br>
			</td>
			<td><button class='btn2'><i class='fa-solid fa-pen-to-square'></i><a href='?p=useredit&iduser=$rm[iduser]'>Ubah </a></button>|
		<button><i class='fa-solid fa-trash-can'></i><a href='?p=userdel&iduser=$rm[iduser]'>Hapus</a></button></td>
		  </tr>";
		  $no++;
	}
	echo "</table>";
?>