<?php
	include "koneksi.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];
	$user_to    = $_POST["id"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else if ((empty($user_to))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom user delegate tidak boleh kosong";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
		    
			$query = sqlsrv_query($conn, "INSERT INTO dbo.tb_delegate (delegate_by, delegate_for) VALUES('".$user_id."','".$user_to."')",array());
			$stm = sqlsrv_rows_affected($query);
			
			                    if ($stm > 0){
                					$response = new usr();
                					$response->success = 1;
                					$response->message = "Data delegasi telah dimasukkan.";
                					die(json_encode($response));
                
                				} else {
                					$response = new usr();
                					$response->success = 0;
                					$response->message = "Gagal memasukkan data delegasi.";
                					die(json_encode($response));
                				}
				

		
		}
	}

	mysqli_close($con);
?>