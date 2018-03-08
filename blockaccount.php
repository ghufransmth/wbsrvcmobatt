<?php
	include "koneksi.php";
	
	class usr{}

	$username    = $_POST["username"];
	
	$sql = "SELECT * FROM dbo.tb_users WHERE username='".$username."'";
	$query = sqlsrv_query($conn,$sql,array(),array("scrollable" => 'static'));

			if ($query){
			    
			     $query2 = sqlsrv_query($conn, "UPDATE dbo.tb_users SET blocked=0 WHERE username='".$username."'",array(),array("scrollable" => 'static'));
			     
			     if($query2){
			        $response = new usr();
					$response->success = 1;
					$response->message = "Account profile blocked.";
					die(json_encode($response));
			     }else{
			        $response = new usr();
					$response->success = 1;
					$response->message = "Failed to block.";
					die(json_encode($response));
			     }
					

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Anda bukan user.";
					die(json_encode($response));
			}

	mysqli_close($con);
?>