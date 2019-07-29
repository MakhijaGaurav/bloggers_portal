<?php
    #below function will check for the query is working properly, if not it should display the mysqli error
    function confirmQuery($result){
        global $connection;
        if(!$result){
            die("Query Failed:".mysqli_error($connection));
        }
    }
    
    if(isset($_GET['onlineusers'])){
        session_start();
        include_once("../includes/db.php");
        checkUserSession();
    }
    
    function checkUserSession(){
        global $connection;
        $session = session_id();
        $user_id = $_SESSION['user_id'];
        $time_out_in_seconds = 60;//time out duration of inactive users
        $time = time();//current time
        $time_out = $time - $time_out_in_seconds;//current time minus (60 secs)
        $query = "SELECT * FROM users_online WHERE session = '$session'";
        //$query = "UPDATE users_online SET time = $time WHERE session = '$session'";
        $user_exists = mysqli_query($connection, $query);
        
        if(mysqli_num_rows($user_exists) == 0){
            $query = "INSERT INTO users_online(session, time, user_id) VALUES ('$session', '$time', $user_id)";
            $insert_query = mysqli_query($connection,$query);//insert the newly logged in user to users_online table
        }/*else{
            //making provision to auto logout if no activity conducted
            $query = "UPDATE users_online SET time = '$time' WHERE session = '$session'";
            $update_query = mysqli_query($connection, $query);
            
        }*/
        $pageRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) &&($_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' || $_SERVER['HTTP_CACHE_CONTROL'] == 'no-cache'); 
        if($pageRefreshed == 1 && $time>$time_out){
            //making provision to auto logout if no activity conducted
            $query = "UPDATE users_online SET time = '$time' WHERE session = '$session'";
            $update_query = mysqli_query($connection, $query);
        }
        $query = "SELECT * FROM users_online WHERE time > $time_out";
        $online_user_query = mysqli_query($connection, $query);//executing the above query
        $online_user_count = mysqli_num_rows($online_user_query);//counting the number of rows returned from the above query 
        echo $online_user_count;//we need to echo this count and not return since it is needed by ajax call in scripts
    }


    function checkUser(){
        if(!isset($_SESSION['username'])){
            die("<h2 style='color:#999'>You have not logged in, please login from <a href='../index.php'>here</a></h2>");
        }else{
            $username = $_SESSION['username'];
            return $username;
        }
    }
    #update/edit the category present in the db
    function editCategory(){
        global $connection;#we need to tell the function that $connection is global i.e. coming from another file
        if(isset($_POST['edit_submit'])){
            $input_cat_title = $_POST['cat_title'];
            $input_cat_id = $_GET['edit'];#$_GET['edit'] because it appears in chrome nav bar
            if($input_cat_title == "" || empty($input_cat_title)){
                echo "Please insert category title and then try!";   
            }else{//write some code to check if that category is already present or not
                $query = "UPDATE categories SET cat_title='$input_cat_title' WHERE
                cat_id = '$input_cat_id'";#updating id which was clicked
                $update_cat_query = mysqli_query($connection, $query);#executed the query of updation

                if(!$update_cat_query){
                    die('QUERY FAILED'.mysqli_error($connection));#if error occurs then show the error from db
                }
                header("Location: categories.php");#refresh page header
            }
        }
    }
    
    #refactored code for adding a category in the "categories" dbms
    function addCategory(){
        if(isset($_POST['submit'])){
            global $connection;
            $input_cat_title = $_POST['cat_title'];
            if($input_cat_title == "" || empty($input_cat_title)){
                echo "<p css:float:left>Please insert category title and then try!</p>";   
            }else{//write some code to check if that category is already present or not
                $query = "SELECT cat_title FROM categories WHERE cat_title='$input_cat_title'";#query placed
                $check_query = mysqli_query($connection, $query);#query executed
                if(mysqli_num_rows($check_query)>0){
                    echo "<p css:float:left>Category already present!</p>";
                }else{
                    $query = "INSERT INTO categories(cat_title) ";
                    $query .= "VALUE('$input_cat_title')";
                    $add_cat_query = mysqli_query($connection, $query);

                    if(!$add_cat_query){
                        die('QUERY FAILED'.mysqli_error($connection));
                    }
                    header("Location: categories.php");
                }
            }
        }
    }
    
    #func below determines the category which was clicked for updation
    function fetchCategoryForEdit(){
        global $connection;
        #used to fetch category title acc to the edit get request
        if(isset($_GET['edit'])){
            $edit_cat_id = $_GET['edit'];#when we click on edit we get the id(primary key)
            $query = "SELECT * FROM categories WHERE cat_id = $edit_cat_id";
            $edit_category_title_query = mysqli_query($connection, $query);
            if($row = mysqli_fetch_assoc($edit_category_title_query)){
                return $row['cat_title'];#bring the cat_title when we have the cat_id
            }

        }
    }
?>