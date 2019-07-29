<!-- ROOT INDEX PAGE -->
<!DOCTYPE html>
<html lang="en">

<?php
    $title = "Register Yourself";
    include_once("includes/db.php");
    include_once("includes/header.php");
    include_once("admin/functions.php");
    /*include_once("includes/navigation.php");*/
    $posts_per_page = 3;
    
    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $firstname = $_POST['user_firstname'];
        $lastname = $_POST['user_lastname'];
        $password = $_POST['password'];
        $email = $_POST['emailid'];
        
        //cleaning all inputs
        
        $username = mysqli_real_escape_string($connection, $username);
        $firstname = mysqli_real_escape_string($connection, $firstname);
        $lastname = mysqli_real_escape_string($connection, $lastname);
        $password = mysqli_real_escape_string($connection, $password);
        $email = mysqli_real_escape_string($connection, $email);
        
        $query = "SELECT * FROM users WHERE username = '$username'";
        $username_check_query = mysqli_query($connection, $query);
        if($row = mysqli_fetch_assoc($username_check_query)){
            echo "Username already exists";
        }else{
            echo "Username valid";
            /*$options = [
                'cost' => 11,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
            ];*/
            $hashedpass = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO users(username, user_firstname, user_lastname, user_email, user_role, user_image, user_password) VALUES ('$username', '$firstname', '$lastname', '$email', 'subscriber', '', '$hashedpass')";
            
            $insert_user_query = mysqli_query($connection, $query);
            confirmQuery($insert_user_query);
            echo "User registered successfully!";
        }
    }
?>

    <body>

        <?php
            
        ?>

            <!-- Page Content -->
            <div class="container">

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                    <!-- Blog Entries Column -->
                        <form action="" method="POST" role="form">
                            <legend>Register</legend>
                            <div class="form-group">
                                <label for="user_firstname">First Name</label>
                                <input type="text" class="form-control" id="user_firstname" placeholder="Enter your first name" name="user_firstname">
                            </div>
                            <div class="form-group">
                                <label for="user_lastname">Last Name</label>
                                <input type="text" class="form-control" id="user_lastname" placeholder="Enter your last name" name="user_lastname">
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" placeholder="Enter your desired username" name="username">
                            </div>
                            <div class="form-group">
                                <label for="emailid">Email</label>
                                <input type="text" class="form-control" id="emailid" placeholder="someone@example.com" name="emailid">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-primary" name="register">Submit</button>
                            </div>
                        </form>
                    </div>


                    <?php
                        #include_once("includes/sidebar.php");
                    ?>

                </div>
                <!-- /.row -->

                <hr>
                <?php
                include_once("includes/footer.php");
            ?>

            </div>
            <!-- /.container -->

            <!-- jQuery -->
            <script src="js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>

    </body>

</html>