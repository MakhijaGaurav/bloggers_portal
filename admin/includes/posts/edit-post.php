<!--ADMIN EDIT POST PAGE -->
   <?php
    if(isset($_POST['edit_post'])){
        if(isset($_GET['p_id'])){   #to prevent url injection we use this if loop
            $post_id = $_GET['p_id'];
            $post_title = $_POST['title'];
            $post_category_id = $_POST['post_category_id'];
            $post_status = $_POST['status'];
            if($post_status == "" || !isset($post_status)){
                $post_status = "draft"; #it won't take default value unless this
            }
            $post_image = $_FILES['image']['name'];#$_FILES[][] is a super global multidimensional array 
            $post_temp_image = $_FILES['image']['tmp_name'];
            
            move_uploaded_file($post_temp_image, "../images/$post_image");

            $post_tags = $_POST['post_tags'];
            $post_content = $_POST['post_content'];
            
            if(empty($post_image)){
                $query = "SELECT post_image FROM posts where post_id=$post_id";
                $selected_image_query = mysqli_query($connection, $query);
                confirmQuery($selected_image_query);
                if($row = mysqli_fetch_assoc($selected_image_query)){
                    $post_image = $row['post_image'];
                }
            }
            
            
            $query = "UPDATE posts SET ";
            $query .= "post_title = '$post_title', ";
            $query .= "post_category_id = '$post_category_id', ";
            $query .= "post_image = '$post_image', ";
            $query .= "post_content = '$post_content', ";
            $query .= "post_tags = '$post_tags', ";
            $query .= "post_status = '$post_status' ";
            $query .= "WHERE post_id=$post_id";

            $update_post_query = mysqli_query($connection, $query);

            confirmQuery($update_post_query);#checks if the query has failed if so then throw the query error   
        }
    }


    if(isset($_GET['p_id'])){   #check if p_id is set
        $edit_post_id = $_GET['p_id'];  #store the p_id in $edit_post_id
        $query = "SELECT * FROM posts WHERE post_id = $edit_post_id";   #select the data of the stored p_id
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
    <?php
        if(isset($_GET['modal_close'])){
            mysqli_query($connection, "DELETE FROM temp WHERE post_id=$post_id");
        }
    ?>
<form action = "" id="editPost" method="POST" enctype="multipart/form-data"><!--enc type is multipart/form-data for uploading data (too)-->
    <!-- Following code will bring the data from db to the fields in the form-->
    <?php
        include_once("bring-post-data.php");
    ?>   
    <div class="form-group" id="editPost">
        <input type="submit" class="btn btn-primary" name="edit_post" value="Edit Post">
    </div>
    <!----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------PREVIEW POST-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
    
    <!-- Preview Post -->
    <div class="form-group" id="previewPost">
        <input type="button" class="btn btn-primary" data-toggle="modal" data-target="#previewPostModal" name="preview_post_btn" value="Preview Post">
    </div>
    <div id="previewPostModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Post Preview</h4>
                </div>
                <div class="modal-body">
                    <?php include_once("preview-post.php"); ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default" data-dismiss="modal" name="modal_close">Close</button>
                </div>
            </div>

        </div>
    </div>
    
    
    
    
    
</form>