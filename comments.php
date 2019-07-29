<!-- ROOT COMMENTS.PHP -->
   <?php
    //include_once("admin/functions.php");
    if(isset($_POST['create_comment'])){
        $comment_post_id = $_GET['p_id'];
        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];
        
        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ($comment_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now())";
        $create_comment_query = mysqli_query($connection, $query);
        confirmQuery($create_comment_query);
        $query = "UPDATE posts SET post_comment_count = post_comment_count+1 WHERE post_id = $comment_post_id";
        $increment_comment_count = mysqli_query($connection, $query);
        confirmQuery($increment_comment_count);
        header("Location: post.php?p_id=$comment_post_id");
    }
?>
<!-- Blog Comments -->
<div>
    <!-- Comments Form -->
    <div class="well">
        <h4>Leave a Comment:</h4>
        <form role="form" action="" method="POST">
           <div class="form-group">
               <label for="author">Author</label>
               <input type="text" name="comment_author" class="form-control" id="author">
           </div>
           <div class="form-group">
               <label for="email">Email</label>
               <input type="text" name="comment_email" class="form-control" id="email">
           </div>
            <div class="form-group">
                <label for="comment">Your Comment</label>
                <textarea class="form-control" rows="3" id="comment" name="comment_content"></textarea>
            </div>
            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <!-- End of Comments Form -->

    <hr>

    <!-- Posted Comments -->
    <?php
        $comment_post_id = $_GET['p_id'];
        $query = "SELECT * FROM comments WHERE comment_post_id = $comment_post_id and comment_status = 'approved' ORDER BY comment_id DESC";
        $select_all_comments_query = mysqli_query($connection, $query);
        confirmQuery($select_all_comments_query);
        while($row = mysqli_fetch_assoc($select_all_comments_query)){
            $comment_author = $row['comment_author'];
            $comment_date = $row['comment_date'];
            $comment_content = $row['comment_content'];
    ?>
    <!-- Comment -->
    <div class="media">
        <a class="pull-left" href="#">
            <img class="media-object" src="http://placehold.it/64x64" alt="">
        </a>
        <div class="media-body">
            <h4 class="media-heading"><?php echo $comment_author;?>
                <small><?php echo $comment_date;?></small>
            </h4>
            <?php echo $comment_content;?>        </div>
    </div>
    <?php
        }
    ?>
</div>