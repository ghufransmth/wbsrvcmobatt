<?php
	include "koneksi.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];
	$start_date = $_POST["start_date"];
	$end_date   = $_POST["end_date"];
	$reason     = $_POST["reason"];
	$created_on = $_POST["created_on"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else if ((empty($start_date))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom awal tanggal tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($end_date))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom akhir tanggal tidak boleh kosong";
		die(json_encode($response));
	} else if ((empty($reason))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Kolom reason tidak boleh kosong";
		die(json_encode($response));
	} else {
		if (!empty($user_id) && !empty($start_date) && !empty($end_date) && !empty($reason)){
		    
		    if(validateDate($start_date) == true){
    
        		if(validateDate($end_date) == true){
        		    
					$query = sqlsrv_query($conn, "SELECT * FROM dbo.tb_users WHERE id='".$user_id."'",array(),array("scrollable" => 'static'));
        			$num_rows = sqlsrv_num_rows($query);
        
        			if ($num_rows > 0){
						$sql = "INSERT INTO dbo.tb_timeoff (user_id, start_date, end_date, reason, created_on) VALUES('".$user_id."',CONVERT(datetime,'".$start_date."'),CONVERT(datetime,'".$end_date."'), '".$reason."', '".$created_on."')";
        				$query2 = sqlsrv_query($conn, $sql,array());
						$num_rows2 = sqlsrv_rows_affected($query2);
						//echo $sql;
						//echo json_encode($num_rows2); 
						
        				if ($num_rows2 > 0){
        					$response = new usr();
        					$response->success = 1;
        					$response->message = "Data timeoff telah dimasukkan.";
        					die(json_encode($response));
        
        				} else {
        					$response = new usr();
        					$response->success = 0;
        					$response->message = "Gagal memasukkan data timeoff.";
        					die(json_encode($response));
        				}
        			} else {
        				$response = new usr();
        				$response->success = 0;
        				$response->message = "Anda bukan user";
        				die(json_encode($response));
        			}
        			
    		    } else{
    		        $response = new usr();
        			$response->success = 0;
        			$response->message = "Invalid end date";
        			die(json_encode($response));
    		    }
    		    
		    } else{
		        $response = new usr();
    			$response->success = 0;
    			$response->message = "Invalid start date";
    			die(json_encode($response));
		    }
		}
	}
	
	function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    

	//mysqli_close($con);
?>