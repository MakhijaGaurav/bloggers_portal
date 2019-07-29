<!--ADMIN ADD POST PAGE -->
   <?php 
    if(isset($_POST['create_post'])){
        $post_title = $_POST['title'];
        $post_author = $_SESSION['user_id'];
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
        $post_date = date('d-m-y');
        $post_comment_count = 0;
        
        $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status) VALUES ($post_category_id, '$post_title', '$post_author', now(), '$post_image', '$post_content', '$post_tags', $post_comment_count, '$post_status')";
        
        $create_post_query = mysqli_query($connection, $query);
        
        confirmQuery($create_post_query);#checks if the query has failed if so then throw the query error
    }
?>
   <form action = "" id="addPost" method="POST" enctype="multipart/form-data"><!--enc type is multipart/form-data for uploading data (too)-->
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="title" id="post_title">
    </div>
    <div class="form-group">
        <label for="post_category">Post Category</label>
        <select class="form-control" name="post_category_id" id="post_category">
            <?php
                $query = "SELECT * FROM categories";#bring everything from posts table
                $select_all_categories_query = mysqli_query($connection, $query);#query executed
                #fetches associtaive array from database
                confirmQuery($select_all_categories_query);
                
                while($row = mysqli_fetch_assoc($select_all_categories_query)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    if($post_category_id == $cat_id){
                        echo "<option value='$cat_id' selected>$cat_title</option>";
                    }else{
                        echo "<option value='$cat_id'>$cat_title</option>";
                    }
                }
            ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="status" id="post_status" class="form-control">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image" id="post_image">
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" id="post_tags">
    </div>
    
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="post_content" cols="30" rows="10"></textarea>
    </div>
    <div class="form-group">
        <div class="col-md-9 col-md-offset-3">
            <div id="messages"></div>
        </div>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
    </div>
</form>