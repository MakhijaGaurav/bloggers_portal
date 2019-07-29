<?php
    include_once("db.php");
    include_once("../admin/functions.php");
    session_start();//this method automatically will generate a unique session id for the session
    if(isset($_POST['login'])){//if button is clicked then....
        $user_id = $_POST['user_id'];//take the user id using post since form method is post
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $username = mysqli_real_escape_string($connection, $username);//prevent sql injection by escaping the comment and special chars 
        $password = mysqli_real_escape_string($connection, $password);
        $query = "SELECT * FROM users WHERE username = '$username' and token=''";
        $select_user_details = mysqli_query($connection, $query);
        confirmQuery($select_user_details);//check if query has no errors in it
        if(mysqli_num_rows($select_user_details>1)){
            header("Location: ../index.php");
        }
        if($row = mysqli_fetch_assoc($select_user_details)){
            $user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_hashed_password = $row['user_password'];
            $db_role = $row['user_role'];
        }else{
            $db_hashed_password ="";
        }
            
            if(password_verify($password, $db_hashed_password) && $username === $db_username){//password_verify method is php defined method for decrypting the hashed password using the correct algo
                $_SESSION['username'] = $db_username;//if username and password are correct then enter into session with foll credentials
                $_SESSION['user_role'] = $db_role;
                $_SESSION['user_id'] = $user_id;
                header("Location: ../admin/");
            }else{
                header("Location: ../index.php");
            }
    }
?>