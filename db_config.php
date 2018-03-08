<?php
 
/*
 * All database connection variables
 */
 
    $server		= "localhost"; // sesuaikan alamat server anda
	$user		= "zzxqdmac_mantap"; // sesuaikan user web server anda
	$password	= "P@ssword123"; // sesuaikan password web server anda
	$database	= "zzxqdmac_mantap"; // sesuaikan database web server anda
	
	$connect = mysqli_connect($server, $user, $password) or die ("Koneksi gagal!");
	mysqli_select_db($database) or die ("Database belum siap!");

?>