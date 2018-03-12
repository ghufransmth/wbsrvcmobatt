<?php
	include "koneksi.php";
	
	include "url_public.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
		    
			$query = sqlsrv_query($conn, "SELECT created_on,status_approv,image,work,CONVERT(varchar, start_date,120) AS start_date FROM dbo.tb_geoatt WHERE user_id='".$user_id."' ORDER BY start_date DESC",array(),array("scrollable" => 'static'));
			$count = sqlsrv_num_rows($query);
			
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            		    /* $json['created_on']= date("F j, Y", strtotime($row['start_date']));
            		    $json['time']= date("g:i a", strtotime($row['start_date']));  */
						
						/* $rows = array();
						for ($i = 0; $i < count($row["start_date"]); $i++) {
							 $rows["date"] = $row["start_date"];
						} 

						$json['created_on'] = $rows;  */
					    $json['created_on']= date("F j, Y", strtotime($row['start_date']));
            		    $json['time']= date("g:i a", strtotime($row['start_date']));  
            		    
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
            		    
            		    $path = $url_public."/images/".$row['image']."";
            		    $json['image']= $path; 
            		    
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