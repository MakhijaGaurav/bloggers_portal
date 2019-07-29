<!--ADMIN EDIT USER PAGE -->
   <?php
    if(isset($_POST['edit_user'])){
        $user_id = $_GET['edit_id'];
        $username = $_POST['username'];
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_email = $_POST['user_email'];
        $user_role = $_POST['user_role'];
        if(empty($user_image)){
                $query = "SELECT user_image FROM users where user_id=$user_id";
                $selected_image_query = mysqli_query($connection, $query);
                confirmQuery($selected_image_query);
                if($row = mysqli_fetch_assoc($selected_image_query)){
                    $user_image = $row['user_image'];
                }
            }
            $user_image = $_FILES['user_image']['name'];#$_FILES[][] is a super global multidimensional array 
            $user_tmp_image = $_FILES['user_image']['tmp_name'];

            move_uploaded_file($user_tmp_image, "images/$user_image");

            $query = "UPDATE users SET ";
            $query .= "username = '$username', ";
            $query .= "user_firstname = '$user_firstname', ";
            $query .= "user_lastname = '$user_lastname', ";
            $query .= "user_email = '$user_email', ";
            $query .= "user_role = '$user_role', ";
            $query .= "user_image = '$user_image' ";
            $query .= "WHERE user_id=$user_id";

            $update_user_query = mysqli_query($connection, $query);

            confirmQuery($update_user_query);
            if($user_firstname && user_email){
                $edit_user_query = mysqli_query($connection, $query);
                confirmQuery($edit_user_query);#checks if the query has failed if so then throw the query error
                header("Location: users.php");
            }else{
                echo "No blank entries allowed";
            }
        }

    if(isset($_GET['edit_id'])){   #check if p_id is set
        $edit_user_id = $_GET['edit_id'];  #store the p_id in $edit_post_id
        $query = "SELECT * FROM users WHERE user_id = $edit_user_id";   #select the data of the stored p_id
        $edit_user_query = mysqli_query($connection, $query);   #execute the query
        if($row = mysqli_fetch_assoc($edit_user_query)){    #fetch the row using associative array
            $user_id = $row['user_id'];
            $username = $row['username'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_role = $row['user_role'];
            $user_image = $row['user_image'];
        }
    }
?>
   <form action = "" method="POST" enctype="multipart/form-data"><!--enc type is multipart/form-data for uploading data (too)-->
   <!-- Following code will bring the data from db to the fields in the form-->
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input value="<?php echo $user_firstname; ?>" type="text" class="form-control" name="user_firstname" id="last_name">
    </div>
    <div class="form-group">
        <label for="post_category">Last Name</label>
        <input value="<?php echo $user_lastname; ?>" type="text" class="form-control" name="user_lastname" id="last_name">
    </div>
    
    <div class="form-group">
        <label for="user_email">Email</label>
        <input value="<?php echo $user_email; ?>" type="text" class="form-control" name="user_email" id="user_email">
    </div>
    
    <div class="form-group">
        <label for="role">Role</label>
        <select name="user_role" id="role" class="form-control">
            <option value="admin" <?php if($user_role == "admin") echo "selected"; ?>>Admin</option>
            <option value="subscriber" <?php if($user_role == "subscriber") echo "selected"; ?>>Subscriber</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="username">Username</label>
        <input value="<?php echo $username; ?>" type="text" class="form-control" name="username" id="username">
    </div>
    
    <div class="form-group">
        <label for="image">User Image</label>
        <input type="file" src="<?php echo $user_image; ?>" class="form-control" name="user_image" id="image">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
</form>