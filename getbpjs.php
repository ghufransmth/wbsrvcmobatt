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
		    
			$query = sqlsrv_query($conn, "SELECT * FROM dbo.tb_bpjs WHERE id_pegawai='".$user_id."' and deleted = 0", array(),array("scrollable" => 'static'));
			$count = sqlsrv_num_rows($query);
			
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            		    // temp user array
            			$json = array();
            			$path = $path_url.$row['file_bpjs']."";
            		    $json['file_bpjs']= $path;
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Bpjs.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Anda bukan user.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>