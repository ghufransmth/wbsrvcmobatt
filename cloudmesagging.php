<?php
    
    include "koneksi.php";
    
    // Enabling error reporting
    error_reporting(-1);
    ini_set('display_errors', 'On');
 
    require_once __DIR__ . '/firebase/firebase.php';
    require_once __DIR__ . '/firebase/push.php';
	
	class usr{}
 
    $firebase = new Firebase();
    $push = new Push();
 
    // optional payload
    $payload = array();
    $payload['team'] = 'India';
    $payload['score'] = '5.6';
        
    $title = $_POST['title'];
    $message = $_POST['message'];
    $push_type = 'individual';
    $include_image = FALSE;
 
    // notification title
    $title = isset($title) ? $title : '';
         
    // notification message
    $message = isset($message) ? $message : '';
         
    // push type - single user / topic
    $push_type = isset($push_type) ? $push_type : '';
         
    // whether to include to image or not
    $include_image = isset($include_image) ? TRUE : FALSE;
 
 
    $push->setTitle($title);
    $push->setMessage($message);
    if ($include_image) {
        $push->setImage('https://api.androidhive.info/images/minion.jpg');
    } else {
        $push->setImage('');
    }
    $push->setIsBackground(FALSE);
    $push->setPayload($payload);
 
 
    $json = '';
    $response = '';
        

	$user_id    = $_POST["user_id"];

	if ((empty($user_id))) {
		$response = new usr();
		$response->success = 0;
		$response->message = "Login terlebih dahulu";
		die(json_encode($response));
	} else {
		if (!empty($user_id)){
		    
			$query = mysqli_query($con, "SELECT a.start_date as tanggal, 'Absensi Kehadiran' as keterangan, a.status_approv, b.first_name as approve_by FROM tb_geoatt as a LEFT JOIN tb_users as b ON (a.approve_by = b.id) WHERE a.user_id = '".$user_id."' AND a.seen = 1
                UNION 
                SELECT c.date as tanggal, c.keterangan as keterangan, c.status_approv, d.first_name as approve_by FROM tb_overtime as c LEFT JOIN tb_users as d ON (c.approve_by = d.id) WHERE c.user_id = '".$user_id."' AND c.seen = 1
                UNION 
                SELECT e.start_date as tanggal, e.reason as keterangan, e.status_approv, f.first_name as approve_by FROM tb_timeoff as e LEFT JOIN tb_users as f ON (e.approve_by = f.id) WHERE e.user_id = '".$user_id."' AND e.seen = 1
                ORDER BY tanggal DESC");
            $count = mysqli_num_rows($query);
            
            if ($count > 0){
                $json = $push->getPush();
                $regId = isset($_POST['regId']) ? $_POST['regId'] : '';
                $response = $firebase->send($regId, $json);
                echo json_encode($response);
            }

// 			if ($query){
// 					$response = new usr();
// 					$response->success = 1;
// 					$response->data = array();
//             		while ($row = mysqli_fetch_array($query)) {
//             			// temp user array
//             			$json = array();
//             		    $json['tanggal']= date("F j, Y", strtotime($row['tanggal']));
            		    
//             		    $json['waktu']= date("g:i a", strtotime($row['created_on']));
            		    
//             		    $json['keterangan'] = $row['keterangan'];
            		    
//             		    if($row['status_approv'] == 1)
//             		    $row['status_approv'] = 'Menunggu Persetujuan';
//             		    else if($row['status_approv'] == 2)
//             		    $row['status_approv'] = 'Tidak Disetujui';
//             		    else
//             		    $row['status_approv'] = 'Disetujui';
//             		    $json['status']= $row['status_approv'];
            		    
//             		    $json['approve_by'] = $row['approve_by'];
            		    
//             		    // push single puasa into final response array
// 			            array_push($response->data, $json);
//             		}
// 					$response->message = "Data Notifikasi.";
// 					$response->counts = $count;
// 					die(json_encode($response));

// 			} else {
// 					$response = new usr();
// 					$response->success = 0;
// 					$response->message = "Gagal data notif.";
// 					die(json_encode($response));
// 			}
				

		
		}
	}

	mysqli_close($con);
	
 
        // if ($push_type == 'topic') {
        //     $json = $push->getPush();
        //     $response = $firebase->sendToTopic('global', $json);
        //     echo json_encode($response);
        // } else if ($push_type == 'individual') {
        //     $json = $push->getPush();
        //     $regId = isset($_POST['regId']) ? $_POST['regId'] : '';
        //     $response = $firebase->send($regId, $json);
        //     echo json_encode($response);
        // }
?>