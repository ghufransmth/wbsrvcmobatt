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
		    
			$query = sqlsrv_query($conn, "SELECT * FROM dbo.tb_users WHERE id='".$user_id."'",array(),array("scrollable" => 'static'));
			$count = sqlsrv_num_rows($query);
			if ($count){
					$response = new usr();
					$response->success = 1;
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            		    $json = array();
            		    $json['id']= $row['id'];
            		    $json['username']= $row['username'];
            		    $json['password']= $row['password'];
            		    $json['email']= $row['email'];
            		}
					$response->message = "Data user profile.";
					$response->data = $json;
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