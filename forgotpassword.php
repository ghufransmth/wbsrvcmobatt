<?php
include ('koneksi.php');
include ('function_forgotpassword.php');
	
	class usr{}

	$uemail = $_POST['email'];
	$uemail = sqlsrv_real_escape_string($conn, $uemail);
	
	if(checkUser($uemail) == "true")
	{
		$userID = UserID($uemail);
		$token = generateRandomString();
		
		$sql = "INSERT INTO dbo.tb_recovery_keys (user_id, token) VALUES ($userID, '$token')";
		$query = sqlsrv_query($conn, $sql, array(),array("scrollable" => 'static') );
		$count = sqlsrv_num_rows($query);
		if($count > 0)
		{
			
			$send_mail = send_mail($uemail, $token);
			if($send_mail === 'success')
			{       
			    $response = new usr();
				$response->success = 1;
				$response->message = "A mail with recovery instruction has sent to your email.";
				die(json_encode($response));
			}else{
			    $response = new usr();
				$response->success = 0;
				$response->message = "There is something wrong.";
				die(json_encode($response));
			}



		}else
		{
		        $response = new usr();
				$response->success = 0;
				$response->message = "There is something wrong.";
				die(json_encode($response));
		}
		
	}else
	{
	    $response = new usr();
		$response->success = 0;
		$response->message = "This email doesn't exist in our database.";
		die(json_encode($response));
	}


?>