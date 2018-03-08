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
		    
			$query = sqlsrv_query($conn, "SELECT CONVERT(varchar, created_on,120) AS created_on,CONVERT(varchar, start_hour, 120) AS start_hour,CONVERT(varchar, end_hour, 120) AS end_hour,CONVERT(varchar, date, 120) AS date,status_approv FROM dbo.tb_overtime WHERE user_id='".$user_id."' ORDER BY created_on DESC", array(),array("scrollable" => 'static'));
			$count = sqlsrv_num_rows($query);
			
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            		    $json['created_on']= date("F j, Y", strtotime($row['created_on']));
            		    $json['time']= date("g:i a", strtotime($row['created_on'])); 
            		    $json['start_hour']= $row['start_hour'];
            		    $json['end_hour']= $row['end_hour'];
            		    $json['date']= date("F j, Y", strtotime($row['date']));
            		    if($row['status_approv'] == 1)
            		    $row['status_approv'] = 'Not yet approved';
            		    else if($row['status_approv'] == 2)
            		    $row['status_approv'] = 'Decline submission';
            		    else
            		    $row['status_approv'] = 'Approved';
            		    $json['status']= $row['status_approv'];  
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Report.";
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