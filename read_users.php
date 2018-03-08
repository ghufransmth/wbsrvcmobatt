<?php

/*
 * Berikut adalah kelas untuk membaca data mahasiswa
 */

// array for JSON response
$response = array();
 

 error_reporting(E_ALL ^ E_DEPRECATED);
// include db connect class
//require_once '../simple_crud/db_connect.php';
 
// connecting to db
//$db = new DB_CONNECT();
 
include "koneksi.php";

$sql = "SELECT * FROM dbo.tb_users";
//$mhs_result = mysql_query ($sql) or die(mysql_error()); //run the query
$users_result = sqlsrv_query($conn,$sql,array(),array("scrollable" => 'static')) or die( print_r( sqlsrv_errors(), true));
	
	/* $stmt = sqlsrv_num_rows($users_result);

	echo json_encode($stmt); */
	

	$response["tb_users"] = array();
 
	while ($row = sqlsrv_fetch_array($users_result)) {
			// temp user array
			$tb_users = array();
			$tb_users["id"] = $row["id"];
			$tb_users["username"] = $row["username"];
			$tb_users["password"] = $row["password"];
			$tb_users["first_name"] = $row["first_name"];
 
			// push single puasa into final response array
			array_push($response["tb_users"], $tb_users);
	}
	// success
	$response["success"] = 1;
 
	// echoing JSON response
	echo json_encode($response);
	
?>