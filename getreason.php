<?php
	include "koneksi.php";
	
	class usr{}

	$query = sqlsrv_query($conn, "SELECT id,reason_desc FROM dbo.tb_reason_timeoff_picklist",array(),array("scrollable" => 'static'));
	$count = sqlsrv_num_rows($query);
	
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            			$json['id']= $row['id'];
            		    $json['reason_desc']= $row['reason_desc'];
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Reason.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal coba lagi.";
					die(json_encode($response));
			}

	mysqli_close($con);
?>