<?php
    if(isset($_POST['preview_post'])){
        if(isset($_GET['p_id'])){   #to prevent url injection we use this if loop
            $post_id = $_GET['p_id'];
            $post_title = $_POST['preview_title'];
            $post_category_id = $_POST['preview_post_category_id'];
            $post_status = $_POST['preview_status'];
            if($post_status == "" || !isset($post_status)){
                $post_status = "draft"; #it won't take default value unless this
            }
            $post_image = $_FILES['preview_image']['name'];#$_FILES[][] is a super global multidimensional array 
            $post_temp_image = $_FILES['preview_image']['tmp_name'];
            
            move_uploaded_file($post_temp_image, "../images/$post_image");

            $post_tags = $_POST['preview_post_tags'];
            $post_content = $_POST['preview_post_content'];
            
            if(empty($post_image)){
                $query = "SELECT post_image FROM temp where post_id=$post_id";
                $selected_image_query = mysqli_query($connection, $query);
                confirmQuery($selected_image_query);
                if($row = mysqli_fetch_assoc($selected_image_query)){
                    $post_image = $row['post_image'];
                }
            }
            
            
            $query = "INSERT INTO temp (post_id, post_title, post_category_id, post_image, post_content, post_tags, post_status) VALUES ($post_id, '$post_title', '$post_category_id', '$post_image', '$post_content', '$post_tags', '$post_status')";
            /*$query .= "post_id = '$post_id', ";
            $query .= "post_title = '$post_title', ";
            $query .= "post_category_id = '$post_category_id', ";
            $query .= "post_image = '$post_image', ";
            $query .= "post_content = '$post_content', ";
            $query .= "post_tags = '$post_tags', ";
            $query .= "post_status = '$post_status' ";
            $query .= "WHERE post_id=$post_id";*/

            $update_post_query = mysqli_query($connection, $query);

            confirmQuery($update_post_query);#checks if the query has failed if so then throw the query error   
        }
    }


    if(isset($_GET['p_id'])){   #check if p_id is set
        $edit_post_id = $_GET['p_id'];  #store the p_id in $edit_post_id
        $query = "SELECT * FROM temp WHERE post_id = $edit_post_id";   #select the data of the stored p_id
        $edit_post_query = mysqli_query($connection, $query);   #execute the query
        if($row = mysqli_fetch_assoc($edit_post_query)){    #fetch the row using associative array
            $post_title = $row['post_title'];   #get post_title from dbms and so on
            $post_category_id = $row['post_category_id'];
            $post_author = $row['post_author'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_content = $row['post_content'];
        }
    }
    ?>
    
<form action = "" method="POST" enctype="multipart/form-data"><!--enc type is multipart/form-data for uploading data (too)-->
    <!-- Following code will bring the data from db to the fields in the form-->
    <?php
        include_once("bring-temp-data.php");
    ?>   
    <div class="form-group" id="previewPost">
        <input type="submit" class="btn btn-primary" name="preview_post" value="Preview Post">
    </div>
</form>