<?php

function checkUser($email)
{
	global $con;
	
	$sql = "SELECT id FROM dbo.tb_users WHERE email = '$email'";
	$query = sqlsrv_query($conn, $sql, array(),array("scrollable" => 'static'));
	$stmt = sqlsrv_num_rows($query);
	
	if($stmt > 0)
	{
		return 'true';
	}else
	{
		return 'false';
	}
}

function UserID($email)
{
	global $con;
	
	$sql = "SELECT id FROM dbo.tb_users WHERE email = '$email'";
	$query = sqlsrv_query($conn, $sql, array(),array("scrollable" => 'static'));
	$row = sqlsrv_fetch_assoc($query);
	
	return $row['id'];
}


function generateRandomString($length = 20) {
	// This function has taken from stackoverflow.com
    
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return md5($randomString);
}

function send_mail($to, $token)
{
	require 'PHPMailer/PHPMailerAutoload.php';
	
	$mail = new PHPMailer;
	
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'mandiritaspen2017@gmail.com';
	$mail->Password = 'P@ssword123rapierte';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	
	$mail->From = 'mandiritaspen2017@gmail.com';
	$mail->FromName = 'Mandiri Taspen';
	$mail->addAddress($to);
	$mail->addReplyTo('mandiritaspen2017@gmail.com', 'Reply');
	
	$mail->isHTML(true);
	
	$mail->Subject = 'Mandiri Taspen: Password Recovery Instruction';
	$link = 'http://rapiertechnology.co.id/mantap/getrecovery.php?email='.$to.'&token='.$token;
	$mail->Body    = "<b>Hello</b><br><br>You have requested for your password recovery. <a href='$link' target='_blank'>Click here</a> to reset your password. If you are unable to click the link then copy the below link and paste in your browser to reset your password.<br><i>". $link."</i>";
    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
	//send the message, check for errors
    if(!$mail->send()) {
		return 'fail';
	} else {
		return 'success';
	}
}

function verifytoken($userID, $token)
{	
	global $con;
	
	$sql = "SELECT valid FROM dbo.tb_recovery_keys WHERE user_id = $userID AND token = '$token'";
	$query = sqlsrv_query($conn, $sql, array(),array("scrollable" => 'static'));
	$row = sqlsrv_fetch_assoc($query);
	$num = sqlsrv_num_rows($query);
	
	if($num > 0)
	{
		if($row['valid'] == 1)
		{
			return 1;
		}else
		{
			return 0;
		}
	}else
	{
		return 0;
	}
	
}
?>