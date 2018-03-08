<?php

include ('koneksi.php');
include ('function_forgotpassword.php');

$uemail = $_GET['email'];
$token = $_GET['token'];

$userID = UserID($uemail); 

$verifytoken = verifytoken($userID, $token);




if(isset($_POST['submit']))
{
	$new_password = $_POST['new_password'];
	$new_password = $new_password;
	$retype_password = $_POST['retype_password'];
	$retype_password = $retype_password;
	
	if($new_password == $retype_password)
	{
		$update_password = sqlsrv_query($conn, "UPDATE dbo.tb_users SET password = '$new_password' WHERE id = $userID",array());
		$stm = sqlsrv_rows_affected($query);
		
		if($stm > 0)
		{
				sqlsrv_query($db, "UPDATE dbo.tb_recovery_keys SET valid = 0 WHERE user_id = $userID AND token ='$token'");
				$msg = 'Your password has changed successfully. Please login with your new passowrd.';
		}
	}else
	{
		 $msg = "Password doesn't match";
	}
	
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forgot Password Recovery Script using PHP and MySQLi</title>

<!-- Bootstrap -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
</head>
<body>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
      <a class="navbar-brand" href="http://rapiertechnology.co.id/">Mandiri Taspen</a></div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="defaultNavbar1">
      <ul class="nav navbar-nav">
        <li><a href="http://rapiertechnology.co.id/mandiri/">Home</a></li>
      </ul>

    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>






<div class="container">
	<div class="row">
   
	<?php if($verifytoken == 1) { ?>
    	<div class="col-lg-4 col-lg-offset-4">
        

        	<form class="form-horizontal" role="form" method="post">
			    <h2>Reset Your Password</h2>

				<?php if(isset($msg)) { ?>
                    <div class="<?php echo $msgclass; ?>" style="padding:5px;"><?php echo $msg; ?></div>
                <?php } ?>
    
                <div class="row">
                    <div class="col-lg-12">
                    <label class="control-label">New Password</label>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-lg-12">
                        <input class="form-control" name="new_password" type="password" placeholder="New Password" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                    <label class="control-label">Re-type New Password</label>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-lg-12">
                        <input class="form-control" name="retype_password" type="password" placeholder="Re-type New Password" required>
                    </div>
                </div>
    
                <div class="row">
                    <div class="col-lg-12">
                        <button class="btn btn-success btn-block" name="submit" style="margin-top:8px;">Submit</button>
                    </div>
                </div>
			</form>
		</div>
        
        <?php }else {?>
	    	<div class="col-lg-4 col-lg-offset-4">
   		       	<h2>Invalid or Broken Token</h2>
	            <p>Opps! The link you have come with is maybe broken or already used. Please make sure that you copied the link correctly or request another token from <a href="index.php">here</a>.</p>
			</div>
        <?php }?>
           
        
            

	</div>
    
  
</div>    