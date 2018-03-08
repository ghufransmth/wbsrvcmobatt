<?php
	include "koneksi.php";
	
	include "url_mantap.php";
	
	class usr{}
	
	$sql = "SELECT nama_file FROM dbo.tb_tutorial";
	$query = sqlsrv_query($conn, $sql, array(), array("scrollable" => 'static'));
	$stmt = sqlsrv_num_rows($query);
	/* echo json_encode($stmt); */
	
			if ($stmt > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            			
            			$path = $path_url.$row['nama_file']."";
            		    $json['nama_file']= $path;
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Tutorial.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal coba lagi.";
					die(json_encode($response));
			}

	mysqli_close($con);
?>