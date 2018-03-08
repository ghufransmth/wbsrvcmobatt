<?php
	include "koneksi.php";
	
	class usr{}

	$id    = $_POST["id"];

	if ((empty($id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "No Value Post";
		die(json_encode($response));
	} else {
		if (!empty($id)){
		    
			$query = sqlsrv_query($conn, "UPDATE dbo.tb_timeoff SET status_approv = 2 WHERE id = '".$id."'",array());
			$stm = sqlsrv_rows_affected($query);
			
			if ($stm > 0){
					$response = new usr();
					$response->success = 1;
					$response->message = "Data Overtime telah diapprove.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal mengupdate.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>