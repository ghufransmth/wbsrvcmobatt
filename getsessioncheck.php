<?php
	include "koneksi.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
		    
			$query = sqlsrv_query($conn, "SELECT id,user_id,DATE_FORMAT(created_on, '%Y-%m-%d') AS date FROM dbo.tb_geoatt WHERE user_id='".$user_id."' and DATE(created_on) = CURDATE() and work=1",array(),array("scrollable" => 'static'));
            
            while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            		    $json[]= $row;
            }
            
			if ($json != null){
					$response = new usr();
					$response->success = 1;
					$response->message = "Anda sedang bekerja hari ini.";
					$response->data = $json;
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Anda belum masuk.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>