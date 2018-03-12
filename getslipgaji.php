<?php
	include "koneksi.php";
	
	include "url_mantap.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
		    
			$query = sqlsrv_query($conn, "SELECT * FROM dbo.tb_slip_gaji WHERE user_id='".$user_id."' and deleted = 0", array(),array("scrollable" => 'static'));
			$count = sqlsrv_num_rows($query);
			
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            		    // temp user array
            			$json = array();
            			$path = $path_url.$row['file_slip_gaji']."";
            		    $json['file_slip_gaji']= $path;
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Slip Gaji.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Tidak ada data.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>