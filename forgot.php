<html>
<!--   <title>Contact Us</title>-->
    <?php
        include_once("includes/db.php");
        include_once("admin/functions.php");
        $title = "Forgot Password";
    ?>
    <?php
    if(!isset($_GET['forgot'])){
        header("Location: index.php");
    }
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $length = 50; #length for the random code that will be egenrated for the specific user
            $token = bin2hex(openssl_random_pseudo_bytes($length));# this method will generate the pseudo random code
            
            #check wheteher the email exists or not
            $query = "SELECT * FROM users WHERE user_email = '$email'";
            $user = mysqli_query($connection, $query);
            if(mysqli_num_rows($user) == 1){
                //if code enters here that means the email exists
                //update the token of the user
                $query = "UPDATE users SET token = '$token' WHERE user_email = '$email'";
                $updateToken = mysqli_query($connection, $query);
                confirmQuery($updateToken);
                
                $headers = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'From: piyush kukreja <piyushkukreja06@gmail.com>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $to = $email;
                $subject = "Blog Change Password";
                $body = "Please Click the link below to reset your password:<br/>    
                <a href='http://localhost/blog/reset.php?email=$email&token=$token>http://localhost/cms/reset.php?email=$email&token=$token</a>";
                
                $sentStatus = mail($to, $subject, $body, $headers);
                if(!$sentStatus){
                    echo error_get_last()['message'];
                }else{
                    echo "Sent";
                }
                
            }else{
                echo "Some issue with emai id!!";
            }
        }
    }
    ?>
    
    
    
    
    
    
    <?php include_once("includes/header.php"); ?>
    <body>
        <?php include_once("includes/navigation.php"); ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                           <div class="text-center">
                               <h3><i class="fa fa-lock fa-4x"></i></h3>
                               <h2 class='text-center'>Forgot Password?</h2>
                               <p>You can reset your password here!</p>
                               <div class="panel-body">
                                   <form method="POST" action="" role="form" id="forgot-password">
                                       <div class="form-group">
                                           <div class="input-group">
                                               <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                               <input class="form-control" type="email" id="email" name="email" placeholder="Please Enter your Email">
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <input type="submit" class="btn btn-lg btn-primary btn-block" name="reset-submit" value="submit">
                                       </div>
                                   </form>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>