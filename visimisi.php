<?php
	include "koneksi.php";
	
	class usr{}

	$query = sqlsrv_query($conn, "SELECT visi_misi FROM dbo.tb_visi_misi",array(),array("scrollable" => 'static'));
	$count = sqlsrv_num_rows($query);

			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            			
            		    $json['visi_misi']= $row['visi_misi'];
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Visi Misi.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal coba lagi.";
					die(json_encode($response));
			}

	mysqli_close($con);
?>