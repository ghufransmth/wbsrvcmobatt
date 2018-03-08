<?php
    
    include "koneksi.php";
	
	class usr{}
	
    $user_id    = $_POST['user_id'];
    $image      = $_FILES['image']['name'];
	$lat        = $_POST['lat'];
	$lang       = $_POST['lang'];
	$start      = $_POST['start'];
	
	$datestart    = date("Y-m-d H:i:s");
	
	if (empty($user_id)) { 
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu."; 
		die(json_encode($response));
	} else if ((empty($lat))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom lattitude tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($lang))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom longitude tidak boleh kosong";
		die(json_encode($response));
	} else {
		
		$users = sqlsrv_query($conn, "SELECT first_name FROM dbo.tb_users WHERE id='".$user_id."'",array(),array("scrollable" => 'static'));
        while ($row = sqlsrv_fetch_array($users)) {
            $name = $row['first_name'];
        }
        $num_rows = sqlsrv_num_rows($users);
		
		/* echo json_encode($num_rows); */ 
		
			if ($num_rows > 0){
            
                                              
				$random = random_word(20);
				
				$path = "images/".$image;
				
				// sesuiakan ip address laptop/pc atau URL server
				$actualpath = $_SERVER["DOCUMENT_ROOT"]."/mantap/$path";
				
				$query = sqlsrv_query($conn, "INSERT INTO dbo.tb_geoatt (user_id,start_date,end_date,keterangan,image,lat,lang,created_on) VALUES ('$user_id',CONVERT(datetime,'$start'),'','nope','$image','$lat','$lang',GETDATE())", array());
				
				$stm = sqlsrv_rows_affected($query);

				if ($stm > 0){
		// 			file_put_contents($path,base64_decode($image));
					$title = $name;
					$message = "Absensi hadir";
											
					// Enabling error reporting
					error_reporting(-1);
					ini_set('display_errors', 'On');
										 
					require_once __DIR__ . '/firebase/firebase.php';
					require_once __DIR__ . '/firebase/push.php';
											
										 
					$firebase = new Firebase();
					$push = new Push();
										 
					// optional payload
					$payload = array();
					$payload['team'] = 'India';
					$payload['score'] = '5.6';
												
					// $title = $_POST['title'];
					// $message = $_POST['message'];
					$push_type = 'individual';
					$include_image = FALSE;
										 
					// notification title
					$title = isset($title) ? $title : '';
												 
					// notification message
					$message = isset($message) ? $message : '';
												 
					// push type - single user / topic
					$push_type = isset($push_type) ? $push_type : '';
												 
					// whether to include to image or not
					$include_image = isset($include_image) ? TRUE : FALSE;
										 
										 
					$push->setTitle($title);
					$push->setMessage($message);
					if ($include_image) {
						$push->setImage('https://rapiertechnology.co.id/mantap/images/mantap.png');
					} else {
						$push->setImage('');
					}
					$push->setIsBackground(FALSE);
					$push->setPayload($payload);
										 
										 
					$json = '';
					$response = '';
					
					$query = sqlsrv_query($conn, "SELECT b.regId FROM dbo.tb_users a INNER JOIN dbo.tb_users b ON a.atasan_1 = b.id OR a.atasan_2 = b.id WHERE a.id = '".$user_id."'",array(),array("scrollable" => 'static'));
					
					
					move_uploaded_file($_FILES['image']['tmp_name'], $actualpath);
					$response = new usr();
					$response->success = 1;
					$response->message = "Successfully Uploaded";
					$response->data = array();
					while ($row = sqlsrv_fetch_array($query)) {
						$json = $push->getPush();
						$regId = $row['regId'];
						$response = $firebase->send($regId,$json);
					}
					die(json_encode($response));
				} else{ 
					$response = new usr();
					$response->success = 0;
					$response->message = "Error Upload image";
					die(json_encode($response)); 
				}
			
			} else {
				$response = new usr();
				$response->success = 0;
				$response->message = "Anda bukan user";
				die(json_encode($response));
			}
		
		
		/* $random = random_word(20);
		
		$path = "images/".$image."";
		
		// sesuiakan ip address laptop/pc atau URL server
		$actualpath = $_SERVER["DOCUMENT_ROOT"]."/mantap/$path";
		
		$query = mssql_query("INSERT INTO dbo.tb_geoatt (user_id,start_date,end_date,keterangan,image,lat,lang) VALUES ('$user_id','$start','','nope','$image','$lat','$lang')");
		
		if ($query){
// 			file_put_contents($path,base64_decode($image));
			move_uploaded_file($_FILES['image']['tmp_name'], $actualpath);
			$response = new usr();
			$response->success = 1;
			$response->message = "Successfully Uploaded";
			die(json_encode($response));
		} else{ 
			$response = new usr();
			$response->success = 0;
			$response->message = "Error Upload image";
			die(json_encode($response)); 
		} */
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