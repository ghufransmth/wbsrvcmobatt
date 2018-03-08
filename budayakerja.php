<?php
	include "koneksi.php";
	
	class usr{}
	
	$sql = "SELECT budaya_kerja FROM dbo.tb_budaya_kerja";
	$query = sqlsrv_query($conn, $sql, array(),array("scrollable" => 'static'));
	$count = sqlsrv_num_rows($query);
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            			
            		    $json['budaya_kerja']= $row['budaya_kerja'];
            		    
            		    // push single puasa into final response arrays
			            array_push($response->data, $json);
            		}
					$response->message = "Data Budaya Kerja.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Tidak ada data.";
					die(json_encode($response));
			}

	mysqli_close($con);
?>