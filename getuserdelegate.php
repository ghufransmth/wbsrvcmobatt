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
		    
			$query = sqlsrv_query($conn, "SELECT kode_jabatan FROM dbo.tb_users WHERE id='".$user_id."'",array(),array("scrollable" => 'static'));

			while ($row = sqlsrv_fetch_array($query)) {
			        $query2 = sqlsrv_query($conn, "SELECT * FROM dbo.tb_users WHERE kode_jabatan='".$row['kode_jabatan']."' AND id !='".$user_id."' ",array(),array("scrollable" => 'static'));
					$count = sqlsrv_num_rows($query2);
            }
            
			if ($count > 0){
					$response = new usr();
					$response->success = 1;
					$response->data = array();
            		while ($row2 = sqlsrv_fetch_array($query2)) {

            		    // push single puasa into final response array
			            array_push($response->data, $row2);
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