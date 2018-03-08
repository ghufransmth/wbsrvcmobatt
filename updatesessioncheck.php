<?php
	include "koneksi.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];
    
    $date = date('Y-m-d H:i:s');
    
	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
		    
			$query = sqlsrv_query($conn, "UPDATE dbo.tb_geoatt SET work = 0, end_date ='".$date."' WHERE user_id='".$user_id."' and DATE(created_on) = CURDATE()",array());
			$stm = sqlsrv_rows_affected($query);
			
			if ($stm > 0){
					$response = new usr();
					$response->success = 1;
					$response->message = "Anda telah selesai hari ini.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Anda belum bekerja hari ini.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>