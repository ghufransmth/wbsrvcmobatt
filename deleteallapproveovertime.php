<?php
	include "koneksi.php";
	
	class usr{}

	$id    = $_POST["id"];
    
	if ((empty($id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Data yang dihapus kosong";
		die(json_encode($response));
	} else {
		    
			$sql = "DELETE FROM dbo.tb_overtime WHERE id='".$id."'";
			$query = sqlsrv_query($conn, $sql, array());
			$stm = sqlsrv_rows_affected($query);

			if ($stm > 0){
					$response = new usr();
					$response->success = 1;
					$response->message = "Berhasil menghapus data.";
					die(json_encode($response));

			} else {
					$response = new usr();
					$response->success = 0;
					$response->message = "Gagal menghapus data.";
					die(json_encode($response));
			}
				

		
		
	}

	mysqli_close($con);
?>