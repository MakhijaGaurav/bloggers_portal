<!--ADMIN ADD USER PAGE -->
   <?php 
    if(isset($_POST['create_user'])){
        $username = $_POST['username'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];
        $user_password = $_POST['user_password'];
        $user_password_confirm = $_POST['user_password_confirm'];
        
        $user_password = mysqli_real_escape_string($connection, $user_password);
        if(empty($user_password) || empty($user_password_confirm)){
            echo "Password field cannot be empty";
        }
        if($user_password === $user_password_confirm){
            $user_image = $_FILES['user_image']['name'];#$_FILES[][] is a super global multidimensional array 
            $user_tmp_image = $_FILES['user_image']['tmp_name'];

            move_uploaded_file($user_tmp_image, "images/$user_image");
            
            $hashedpass = password_hash($user_password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, user_firstname, user_lastname, user_email, user_role, user_image, user_password) VALUES ('$username', '$user_firstname', '$user_lastname', '$user_email', '$user_role', '$user_image', '$hashedpass')";
            if($user_firstname && $user_email){
                $add_user_query = mysqli_query($connection, $query);
                confirmQuery($add_user_query);#checks if the query has failed if so then throw the query error
                header("Location: users.php");
            }else{
                echo "No blank entries allowed";
            }
            
        }else{
            echo "Passwords do not match!!";
        }
    }
?>
   <form action = "" method="POST" enctype="multipart/form-data"><!--enc type is multipart/form-data for uploading data (too)-->
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" class="form-control" name="user_firstname" id="last_name">
    </div>
    <div class="form-group">
        <label for="post_category">Last Name</label>
        <input type="text" class="form-control" name="user_lastname" id="last_name">
    </div>
    
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" class="form-control" name="user_email" id="user_email">
    </div>
    
    <div class="form-group">
        <label for="role">Role</label>
        <select name="user_role" id="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" id="username">
    </div>
    
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="user_password" id="password">
    </div>
    <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" class="form-control" name="user_password_confirm" id="confirm_password">
    </div>
    
    <div class="form-group">
        <label for="image">User Image</label>
        <input type="file" class="form-control" name="user_image" id="image">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
    </div>
</form>