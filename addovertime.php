<?php
	include "koneksi.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];
	$date       = $_POST["date"];
	$start_hour = $_POST["start_hour"];
	$end_hour   = $_POST["end_hour"];
	$keterangan = $_POST["keterangan"];
    $created_on = $_POST["created_on"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else if ((empty($date))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom tanggal tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($start_hour))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom awal jam tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($end_hour))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom akhir jam tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($keterangan))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom Keterangan tidak boleh kosong";
		die(json_encode($response));
	} else {
		if (!empty($user_id) && !empty($date) && !empty($start_hour) && !empty($end_hour) && !empty($keterangan)){
		    
		    if(validateDate($date) == true){
		        
		        if(validateTime($start_hour) == true){
		            
    		            if(validateTime($end_hour) == true){
							
							$sql = "SELECT first_name FROM dbo.tb_users WHERE id='".$user_id."'";
    		                $users = sqlsrv_query($conn, $sql, array(),array("scrollable" => 'static'));
                		    while ($row = sqlsrv_fetch_array($users)) {
                                $name = $row['first_name'];
                            }
                			$stmt = sqlsrv_num_rows($users);
							
							if ($stmt > 0){
								$sql = "INSERT INTO dbo.tb_overtime (user_id, date, start_hour, end_hour,created_on, keterangan) VALUES('".$user_id."',CONVERT(datetime,'".$date."'),'".$start_hour."','".$end_hour."','".$created_on."','".$keterangan."')";
                				$queries = sqlsrv_query($conn, $sql, array());
								$stm = sqlsrv_rows_affected($queries);
								//echo $sql;
								//echo json_encode($stm);

                				    
                				    $title = $name;
                				    $message = "Pengajuan Lembur: ".$keterangan."";
                				    
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
                                        $push->setImage('http://172.18.8.20:9111/mantap/images/mantap.png');
                                    } else {
                                        $push->setImage('');
                                    }
                                    $push->setIsBackground(FALSE);
                                    $push->setPayload($payload);
                                 
                                 
                                    $json = '';
                                    $response = '';
                                        
                                    $query = sqlsrv_query($conn, "SELECT b.regId FROM dbo.tb_users a INNER JOIN dbo.tb_users b ON a.atasan_1 = b.id OR a.atasan_2 = b.id WHERE a.id = '".$user_id."'",array(),array("scrollable" => 'static'));
                                    $count = sqlsrv_num_rows($query);
									
                                    /* if($query){
                                        $response = new usr();
                                		$response->success = 1;
                                		$response->data = array();
                                        while ($row = sqlsrv_fetch_array($query)) {
                                            $json = $push->getPush();
                                            $regId = $row['regId'];
                                            $response = $firebase->send($regId, $json);
                       
                                        }
                                        die(json_encode($response));
                                    }else{
                                        $response = new usr();
                                		$response->success = 0;
                                		$response->message = "Gagal Send Notif.";
                                		die(json_encode($response));
                                    }*/
                            
                					$response = new usr();
                					$response->success = 1;
                					$response->message = "Data overtime telah dimasukkan.";
                					die(json_encode($response)); 
                
                				
                			} else {
                				$response = new usr();
                				$response->success = 0;
                				$response->message = "Anda bukan user";
                				die(json_encode($response));
                			}
							
                			/* $num_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_users WHERE id='".$user_id."'"));
                
                			if ($num_rows > 0){
                				$query = mysqli_query($con, "INSERT INTO tb_overtime (user_id, date, start_hour, end_hour) VALUES('".$user_id."','".$date."', '".$start_hour."', '".$end_hour."')");
                
                				if ($query){
                					$response = new usr();
                					$response->success = 1;
                					$response->message = "Data overtime telah dimasukkan.";
                					die(json_encode($response));
                
                				} else {
                					$response = new usr();
                					$response->success = 0;
                					$response->message = "Gagal memasukkan data overtime.";
                					die(json_encode($response));
                				}
                			} else {
                				$response = new usr();
                				$response->success = 0;
                				$response->message = "Anda bukan user";
                				die(json_encode($response));
                			} */
        			
    		        } else {
    		            $response = new usr();
            			$response->success = 0;
            			$response->message = "Jam tidak valid";
            			die(json_encode($response));
    		        }
    			
		        } else {
		            $response = new usr();
        			$response->success = 0;
        			$response->message = "Jam tidak valid";
        			die(json_encode($response));
		        }
			
		    } else {
		        $response = new usr();
    			$response->success = 0;
    			$response->message = "Tanggal tidak valid";
    			die(json_encode($response));
		    }
		}
	}
	
	function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
    function validateTime($hour, $format = 'H:i')
    {
        $d = DateTime::createFromFormat($format, $hour);
        return $d && $d->format($format) == $hour;
    }

	//mysqli_close($con);
?>