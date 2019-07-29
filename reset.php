<html>
<!--   <title>Contact Us</title>-->
    <?php
        include_once("includes/db.php");
        include_once("admin/functions.php");
        $title = "Reset Password";
    ?>
    <?php
        if(!isset($_GET['token']) || !isset($_GET['email'])){
            header("Location: index.php");
        }else{
            $token = $_GET['token'];
            $email = $_GET['email'];
            $query = "SELECT * FROM users WHERE token='$token'";
            $updatePasswordUser = mysqli_query($connection, $query);
            if(mysqli_num_rows($updatePasswordUser) == 0){
                header("Location: index.php");
            }
        }
        if(isset($_POST['submit'])){
            if(isset($_POST['password']) && isset($_POST['confirm_password'])){
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                if($password === $confirm_password){
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                    $query = "UPDATE users SET token='',user_password='$hashedPassword' WHERE token='$token' and user_email = '$email'";
                    $updatePassword = mysqli_query($connection, $query);
                    confirmQuery($updatePassword);
                    echo "Password changed successfully!!, Please Log In and verify";
                }else{
                    echo "Passwords don't match";
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
                               <h3><i class="fa fa-unlock fa-4x"></i></h3>
                               <h2 class='text-center'>Reset Password</h2>
                               <!--<p>You can reset your password here!</p>-->
                               <div class="panel-body">
                                   <form method="POST" action="" role="form" id="forgot-password">
                                       <div class="form-group">
                                           <div class="input-group">
                                               <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                               <input class="form-control" type="password" id="password" name="password" placeholder="Please Enter New Password">
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <div class="input-group">
                                               <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                               <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                           </div>
                                       </div>
                                       <div class="form-group">
                                           <input type="submit" class="btn btn-lg btn-primary btn-block" name="submit" value="Reset">
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