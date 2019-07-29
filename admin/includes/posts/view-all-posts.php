<?php
    $posts_per_page = 3;
    if(isset($_POST['checkBoxArray'])){
        $bulk_options = $_POST['bulk_options'];
        foreach($_POST['checkBoxArray'] as $postValueId){
            switch($bulk_options){
                case 'published':
                case 'draft':
                    $query = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = $postValueId";
                    $update_status = mysqli_query($connection, $query);
                    header("Location: posts.php");
                    break;
                case 'delete':
                    $query = "DELETE FROM posts WHERE post_id=$postValueId";
                    mysqli_query($connection, $query);
                    header("Location: posts.php");
                    break;
            }
        }
    }
?>




<!--(ADMIN) VIEW ALL POSTS SECTION-->
<div class="col-xs-12"><!--col-xs-12 will take full space of the box that contains it--> 
   <form action="" method="POST">
    <table class="table table-bordered table-hover">
       <div class="col-xs-4" id="bulkOptionsContainer">
           <select class="form-control" name="bulk_options">
               <option value="">Select Option</option>
               <option value="published">Publish</option>
               <option value="draft">Draft</option>
               <option value="delete">Delete</option>
           </select>
       </div>
       <div class="col-xs-4">
           <input type="submit" name="submit_bulk_option" class="btn btn-primary" value="Apply">
           <a class="btn btn-warning" href="posts.php?source=add_post">Add New</a>
       </div>
        <tr>
            <th><input class="form-control" type="checkbox" id="selectAllBoxes"></th>
            <th>ID</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th></th>
            <th></th>
        </tr>
        <tbody>
            <?php
                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }else{
                    $page=1;
                }
                if($page=="" || $page == 1){
                    $limit_start = 0;
                }else{
                    $limit_start = ($page * $posts_per_page) - $posts_per_page;
                }
                $user_role = $_SESSION['user_role'];
            if($user_role == "admin"){
                $query = "SELECT * FROM posts, users WHERE posts.post_author = users.user_id ORDER BY posts.post_date DESC";#bring everything from posts table
                $total_post_query = mysqli_query($connection, $query);
				$total_post_count = mysqli_num_rows($total_post_query);
                $query = "SELECT * FROM posts, users WHERE posts.post_author = users.user_id ORDER BY posts.post_date DESC LIMIT $limit_start, $posts_per_page";
            }else{
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM posts, users WHERE posts.post_author = users.user_id and posts.post_author = $user_id ORDER BY posts.post_date DESC";#bring everything from posts table of the particular user
                $total_post_query = mysqli_query($connection, $query);
				$total_post_count = mysqli_num_rows($total_post_query);
                $query = "SELECT * FROM posts, users WHERE posts.post_author = users.user_id and posts.post_author = $user_id ORDER BY posts.post_date DESC LIMIT $limit_start, $posts_per_page";
            }
                
                $select_all_posts_query = mysqli_query($connection, $query);#query executed
                #fetches associtaive array from database
                $count = ceil($total_post_count/$posts_per_page);
                while($row = mysqli_fetch_assoc($select_all_posts_query)){
                    $post_id = $row['post_id'];#store post_id from db into $post_id
                    $post_author = $row['user_firstname']. " " . $row['user_lastname'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];

                    echo "<tr>";#start of table row; show everything in table from db using variables created above
                        echo "<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='$post_id'></td>";
                        echo "<td>$post_id</td>";#table data i.e. id data present in db
                        echo "<td>$post_author</td>";
                        echo "<td>$post_title</td>";#table data i.e. title data present in db
                    
                        $query = "SELECT * FROM categories WHERE cat_id=$post_category_id";
                        $select_all_categories_query = mysqli_query($connection, $query);
                        confirmQuery($select_all_categories_query);
                        if($row = mysqli_fetch_assoc($select_all_categories_query)){
                            $post_category_title = $row['cat_title'];
                        }
                        echo "<td>$post_category_title</td>";
                    
                    
                        echo "<td>$post_status</td>";
                        echo "<td><img src='../images/$post_image' class='img-responsive' height='100px' alt='post_image'></td>";
                        echo "<td>$post_tags</td>";
                        echo "<td>$post_comment_count</td>";
                        echo "<td>$post_date</td>";
                        echo "<td><a class='btn btn-danger' href='posts.php?delete=$post_id'><span class='fa fa-times'> Delete</a></td>";
                        echo "<td><a class='btn btn-primary' href='posts.php?source=edit_post&p_id=$post_id'><span class='fa fa-times'> Edit</a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <ul class="pager">
        <?php
            for($i=1;$i<=$count;$i++){
            if($i == $page)
                echo "<li><a class='active-page' href='posts.php?page=$i'>$i</a></li>";
            else
                echo "<li><a href='posts.php?page=$i'>$i</a></li>";
            }
        ?>
    </ul>
    </form>
    <?php
        if(isset($_GET['delete'])){
            $delete_post_id = $_GET['delete'];
            $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
            $delete_query = mysqli_query($connection, $query);
            confirmQuery($delete_query);
            header("Location: posts.php");
        }
    ?>
</div>
<!--END OF VIEW ALL POSTS SECTION-->