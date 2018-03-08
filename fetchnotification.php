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
		    
			$sql = "SELECT CONVERT(varchar,a.start_date,120) as tanggal, 'Absensi Kehadiran' as keterangan, a.status_approv, b.first_name as approve_by FROM tb_geoatt as a LEFT JOIN tb_users as b ON (a.approve_by = b.id) WHERE a.user_id = '".$user_id."' AND a.seen = 1
                UNION 
                SELECT CONVERT(varchar,c.date,120) as tanggal, c.keterangan as keterangan, c.status_approv, d.first_name as approve_by FROM tb_overtime as c LEFT JOIN tb_users as d ON (c.approve_by = d.id) WHERE c.user_id = '".$user_id."' AND c.seen = 1
                UNION 
                SELECT CONVERT(varchar,e.start_date,120) as tanggal, e.reason as keterangan, e.status_approv, f.first_name as approve_by FROM tb_timeoff as e LEFT JOIN tb_users as f ON (e.approve_by = f.id) WHERE e.user_id = '".$user_id."' AND e.seen = 1
                ORDER BY tanggal DESC";
			$query = sqlsrv_query($conn, $sql, array(),array("scrollable" => 'static'));
            $count = sqlsrv_num_rows($query);

			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row = sqlsrv_fetch_array($query)) {
            			// temp user array
            			$json = array();
            		    $json['tanggal']= date("F j, Y", strtotime($row['tanggal']));
            		    
            		    $json['waktu']= date("g:i a", strtotime($row['tanggal']));
            		    
            		    $json['keterangan'] = $row['keterangan'];
            		    
            		    if($row['status_approv'] == 1)
            		    $row['status_approv'] = 'Menunggu Persetujuan';
            		    else if($row['status_approv'] == 2)
            		    $row['status_approv'] = 'Tidak Disetujui';
            		    else
            		    $row['status_approv'] = 'Disetujui';
            		    $json['status']= $row['status_approv'];
            		    
            		    $json['approve_by'] = $row['approve_by'];
            		    
            		    // push single puasa into final response array
			            array_push($response->data, $json);
            		}
					$response->message = "Data Notifikasi.";
					$response->counts = $count;
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal data notif.";
					die(json_encode($response));
			}
				

		
		}
	}

	mysqli_close($con);
?>