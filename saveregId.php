<?php
	include "koneksi.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];
	$id         = $_POST["id"];
    
    $date = date('Y-m-d H:i:s');
    
	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
			
		    $sql = "UPDATE dbo.tb_users SET regId = '".$id."' WHERE id=$user_id";
			$query = sqlsrv_query($conn, $sql, array());
			$stm = sqlsrv_rows_affected($query);
			
			if ($stm > 0){
					$response = new usr();
					$response->success = 1;
					$response->message = "regId berhasil disimpan.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal disimpan regId.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>