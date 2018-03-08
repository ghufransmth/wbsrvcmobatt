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
		    
		    $query = sqlsrv_query($conn, "SELECT A.id, A.user_id, A.start_date, A.end_date, A.keterangan, A.image, A.lat, A.lang, A.status_approv, A.created_on, B.username FROM dbo.tb_geoatt AS A LEFT JOIN dbo.tb_users AS B ON A.user_id = B.id WHERE A.approve_by = '".$user_id."' AND A.status_approv = 0");
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
            		    
            		    if($row['status_approv'] == 1)
            		    $row['status_approv'] = 'Menunggu Persetujuan';
            		    else if($row['status_approv'] == 2)
            		    $row['status_approv'] = 'Tidak Disetujui';
            		    else
            		    $row['status_approv'] = 'Disetujui';
            		    $json['status']= $row['status_approv'];
            		    
            		    if($row['work'] == 1)
            		    $row['work'] = 'Sedang Bekerja';
            		    else
            		    $row['work'] = 'Telah Selesai Bekerja';
            		    $json['work']= $row['work'];
            		    
            		    $path = "http://rapiertechnology.co.id/mantap/images/".$row['image']."";
            		    $json['image']= $path;
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
            		
					$response->message = "Data Report.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Tidak ada data.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>