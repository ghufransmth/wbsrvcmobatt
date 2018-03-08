<?php
	include "koneksi.php";
	
	include "url_attendance.php";
	
	class usr{}

	$user_id    = $_POST["user_id"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
		    
			$sql = "SELECT A.id, A.user_id, CONVERT(varchar, A.start_date,120) AS start_date, CONVERT(varchar, A.end_date,120) AS end_date, A.keterangan, A.image, A.lat, A.lang, A.status_approv, CONVERT(varchar, A.created_on,120) AS created_on, B.username FROM dbo.tb_geoatt AS A LEFT JOIN dbo.tb_users AS B ON A.user_id = B.id WHERE A.status_approv = 1 AND (A.user_id = '".$user_id."' OR B.atasan_1 = '".$user_id."' OR B.atasan_2 = '".$user_id."') ORDER BY A.start_date DESC";
		    $query = sqlsrv_query($conn, $sql, array(), array("scrollable" => 'static'));
			$count = sqlsrv_num_rows($query);
		    
			$sql2 = "SELECT A.id, A.user_id, CONVERT(varchar, A.date,120) AS date, CONVERT(varchar, A.start_hour,120) AS start_hour,  CONVERT(varchar, A.end_hour,120) AS end_hour, A.status_approv, CONVERT(varchar, A.created_on,120) AS created_on, CONVERT(varchar, A.modified_on,120) AS modified_on, B.username FROM dbo.tb_overtime AS A LEFT JOIN dbo.tb_users AS B ON A.user_id = B.id WHERE A.status_approv = 1 AND (A.user_id = '".$user_id."' OR B.atasan_1 = '".$user_id."' OR B.atasan_2 = '".$user_id."') ORDER BY A.created_on DESC";
			$query2 = sqlsrv_query($conn, $sql2, array(), array("scrollable" => 'static'));
			$count2 = sqlsrv_num_rows($query2);
			
			$sql3 = "SELECT A.id, A.user_id, CONVERT(varchar, A.start_date,120) AS start_date, CONVERT(varchar, A.end_date,120) AS end_date, A.reason, A.status_approv, CONVERT(varchar, A.created_on,120) AS created_on, CONVERT(varchar, A.modified_on,120) AS modified_on, B.username FROM dbo.tb_timeoff AS A LEFT JOIN dbo.tb_users AS B ON A.user_id = B.id WHERE A.status_approv = 1 AND (A.user_id = '".$user_id."' OR B.atasan_1 = '".$user_id."' OR B.atasan_2 = '".$user_id."') ORDER BY A.created_on DESC";
			$query3 = sqlsrv_query($conn, $sql3, array(), array("scrollable" => 'static'));
			$count3 = sqlsrv_num_rows($query3);
			

			if ($count > 0 || $count2 > 0 || $count3 > 0){
					$response = new usr();
					$response->success = 1;
					$response->dataatt = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            		    $json = array();
            		    $json['id']= $row[0];
            		    $json['user_id']= $row['user_id'];
            		    $json['start_date']= $row['start_date'];
            		    $json['end_date']= $row['end_date'];
            		    $json['keterangan']= $row['keterangan'];
            		    $path = $url_attendance."images/".$row['image']."";
            		    $json['image']= $path;
            		    $json['lat']= $row['lat'];
            		    $json['lang']= $row['lang'];
            		    $json['status_approv']= $row['status_approv'];
            		    $json['created_on']= date("F j, Y", strtotime($row['start_date']));
            		    $json['time']= date("g:i a", strtotime($row['start_date']));
            		    $json['username']= $row['username'];
            		    // push single puasa into final response array
            		    // push single puasa into final response array
			            array_push($response->dataatt, $json);
            		}
            		$response->dataovertime = array();
            		while ($row = sqlsrv_fetch_array($query2)) {
            		    $json = array();
            		    $json['id']= $row[0];
            		    $json['user_id']= $row['user_id'];
            		    $json['date']= $row['date'];
            		    $json['start_hour']= $row['start_hour'];
            		    $json['end_hour']= $row['end_hour'];
            		    $json['status_approv']= $row['status_approv'];
            		    $json['created_on']= date("F j, Y", strtotime($row['created_on']));
            		    $json['time']= date("g:i a", strtotime($row['created_on']));
            		    $json['modified_on']= $row['modified_on'];
            		    $json['username']= $row['username'];
            		    // push single puasa into final response array
			            array_push($response->dataovertime, $json);
            		}
            		$response->datatimeoff = array();
            		while ($row = sqlsrv_fetch_array($query3)) {
            		    $json = array();
            		    $json['id']= $row[0];
            		    $json['user_id']= $row['user_id'];
            		    $json['start_date']= $row['start_date'];
            		    $json['end_date']= $row['end_date'];
            		    $json['reason']= $row['reason'];
            		    $json['status_approv']= $row['status_approv'];
            		    $json['created_on']= date("F j, Y", strtotime($row['created_on']));
            		    $json['time']= date("g:i a", strtotime($row['created_on']));
            		    $json['modified_on']= $row['modified_on'];
            		    $json['username']= $row['username'];
            		    // push single puasa into final response array
			            array_push($response->datatimeoff, $json);
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