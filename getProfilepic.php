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
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            		    $json['id']= $row['id'];
            		    $json['username']= $row['username'];
            		    $json['first_name']= $row['first_name'];
            		    $json['email']= $row['email'];
            		    $json['phone']= $row['phone'];
            		    $json['nama_jabatan']= $row['nama_jabatan'];
            		    $json['atasan_1']= $row['atasan_1'];
            		    $json['atasan_2']= $row['atasan_2'];
            		    $path = "http://rapiertechnology.co.id/mandiri/upload/foto_user/".$row['profile_image']."";
            		    $json['profile_image']= $path;
            		    $json['user_level']= $row['user_level'];
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Users.";
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