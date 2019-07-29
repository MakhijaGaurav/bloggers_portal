<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Change Password</title>

		<!-- Bootstrap CSS -->
    <link rel="stylesheet" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn t work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<?php
        session_start();
        $session = session_id();
        $title = "Change Password";
        $username = $_SESSION['username'];
        include_once("../includes/db.php");
        include_once("../includes/header.php");
        include_once("../admin/functions.php");
        /*include_once("includes/navigation.php");*/
        $posts_per_page = 3;
        $check_user = checkUser();

        if(isset($_POST['change_password'])){
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_new_password'];

            //cleaning all inputs

            $current_password = mysqli_real_escape_string($connection, $current_password);
            $new_password = mysqli_real_escape_string($connection, $new_password);
            $confirm_password = mysqli_real_escape_string($connection, $confirm_password);

            $query = "SELECT * FROM users WHERE username = '$username'";
            $username_check_query = mysqli_query($connection, $query);
            if($row = mysqli_fetch_assoc($username_check_query)){
                $current_user_password = $row['user_password'];
                if(password_verify($current_password, $current_user_password)){
                    if($new_password === $confirm_password){
                        $hashedpass = password_hash($new_password, PASSWORD_BCRYPT);
                        $query = "UPDATE users SET user_password = '$hashedpass' WHERE username = '$username'";
                        $update_password_query = mysqli_query($connection, $query);
                        confirmQuery($update_password_query);
                    }
                }
            }
        }
    ?>
	<body>
		<h1 class="text-center">Change Your Password</h1>
    
    	<div class="container">

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                    <!-- Blog Entries Column -->
                        <form action="" id="changePassword" method="POST" role="form">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" placeholder="Enter your current password" name="current_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" placeholder="Enter New Password" name="new_password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_password">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_new_password" placeholder="Confirm Password" name="confirm_new_password">
                            </div>
                            <div class="form-group">
                                <div class="col-md-9 col-md-offset-3">
                                    <div id="messages"></div>
                                </div>
                            </div>
                           <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary" name="change_password">Submit</button>
                           </div>
						</form>
					</div>
            </div>
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
    <script src="../admin/js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</body>
</html>