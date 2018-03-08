<?php
	include "koneksi.php";
	
	class usr{}

	$query = sqlsrv_query($conn, "SELECT nama_file FROM dbo.tb_struktur_organisasi",array(),array("scrollable" => 'static'));
	$count = sqlsrv_num_rows($query);
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            			$path = "http://rapiertechnology.co.id/mandiri/upload/upload_struktur/".$row['nama_file']."";
            		    $json['struktur_org']= $path;
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Struktur Org.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal coba lagi.";
					die(json_encode($response));
			}

	mysqli_close($con);
?>