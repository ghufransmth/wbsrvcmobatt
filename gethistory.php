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
			
		    $sql = "SELECT CONVERT(varchar, created_on,120) AS created_on, history FROM dbo.tb_history WHERE user_id=$user_id ORDER BY created_on DESC";
			$query = sqlsrv_query($conn, $sql, array(), array("scrollable" => 'static'));
			$count = sqlsrv_num_rows($query);

			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            		    $json['created_on']= date("d/m/Y", strtotime($row['created_on']));
						$json['time']= date("g:i a", strtotime($row['created_on']));  
            		    $json['history']= $row['history'];
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data History.";
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