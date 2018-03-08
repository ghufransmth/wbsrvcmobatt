<?php
    
    include "koneksi.php";
	
	class usr{}
	
    $user_id    = $_POST['user_id'];
    $image      = $_FILES['image']['name'];
	$username   = $_POST['username'];
	$email      = $_POST['email'];
	$password   = $_POST['password'];
	
	$datestart    = date("Y-m-d H:i:s");
	
	$picture = ($image=="") ? "" : "profile_image = '$image'";
	
	if (empty($user_id)) { 
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu."; 
		die(json_encode($response));
	} else {
		$random = random_word(20);
		
		
		
		$path = "foto_user/".$image."";
		
		// sesuiakan ip address laptop/pc atau URL server
		$actualpath = $_SERVER["DOCUMENT_ROOT"]."/mandiri/upload/$path";
		
		$query = mysqli_query($con, "UPDATE tb_users SET username='$username',email='$email',password='$password',$picture WHERE id='$user_id'");
		
		if ($query){
// 			file_put_contents($path,base64_decode($image));
			move_uploaded_file($_FILES['image']['tmp_name'], $actualpath);
			$response = new usr();
			$response->success = 1;
			$response->message = "Successfully Edit";
			die(json_encode($response));
		} else{ 
			$response = new usr();
			$response->success = 0;
			$response->message = "Error Upload image";
			die(json_encode($response)); 
		}
	}	
	
	// fungsi random string pada gambar untuk menghindari nama file yang sama
	function random_word($id = 20){
		$pool = '1234567890abcdefghijkmnpqrstuvwxyz';
		
		$word = '';
		for ($i = 0; $i < $id; $i++){
			$word .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		return $word; 
	}

?>