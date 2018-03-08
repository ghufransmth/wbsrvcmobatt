<?php
	include "koneksi.php";
	
	class usr{}

	$id    		= $_POST["id"];
	$user_id    = $_POST["user_id"];

	if ((empty($id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "No Value Post";
		die(json_encode($response));
	} else {
		if (!empty($id)){
		    
			$query = sqlsrv_query($conn, "UPDATE dbo.tb_geoatt SET status_approv = 0 , approve_by = '".$user_id."' WHERE id = '".$id."'",array());
			$stm = sqlsrv_rows_affected($query);
			
			if ($stm > 0){
					$response = new usr();
					$response->success = 1;
					$response->message = "Data Geo Att telah diapprove.";
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