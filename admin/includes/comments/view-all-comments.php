<!--(ADMIN) VIEW ALL COMMENTS SECTION-->
<div class="col-xs-12"><!--col-xs-12 will take full space of the box that contains it--> 
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response To</th>
            <th>Date</th>
            <th>Approve</th>
            <th>UnApprove</th>
            <th>Delete</th>
            <!--<th></th>-->
        </tr>
        <tbody>
            <?php
                $user_role = $_SESSION['user_role'];
            if($user_role == "admin"){
                $query = "SELECT * FROM comments";#bring everything from posts table
            }else{
                $user_id = $_SESSION['user_id'];
                /*$query = "SELECT * FROM comments,posts WHERE comment_post_id = posts.post_id and post_author = $user_id";*/
                $query = "SELECT * FROM comments WHERE comment_post_id in (SELECT posts.post_id FROM posts WHERE post_author = $user_id)"; 
            }
                
                $select_all_comments_query = mysqli_query($connection, $query);#query executed
                #fetches associtaive array from database
                while($row = mysqli_fetch_assoc($select_all_comments_query)){
                    $comment_id = $row['comment_id'];#store post_id from db into $post_id
                    $comment_author = $row['comment_author'];
                    $comment_post_id = $row['comment_post_id'];
                    $comment_email = $row['comment_email'];
                    $comment_status = $row['comment_status'];
                    $comment_content = $row['comment_content'];
                    $comment_date = $row['comment_date'];

                    echo "<tr>";#start of table row; show everything in table from db using variables created above
                        echo "<td>$comment_id</td>";#table data i.e. id data present in db
                        echo "<td>$comment_author</td>";
                        echo "<td>$comment_content</td>";#table data i.e. title data present in db
                        echo "<td>$comment_email</td>";
                        echo "<td>$comment_status</td>";
                    
                        $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
                        $select_comment_post_query = mysqli_query($connection, $query);
                        confirmQuery($select_comment_post_query);
                        if($row = mysqli_fetch_assoc($select_comment_post_query)){
                            $comment_post_title = $row['post_title'];
                        }
                        echo "<td><a href='../post.php?p_id=$comment_post_id'>$comment_post_title</a></td>";
                    
                    
                        echo "<td>$comment_date</td>";
                        echo "<td><a class='btn btn-success' href='comments.php?approve=$comment_id'><span class='fa fa-check'> Approve</a></td>";
                        echo "<td><a class='btn btn-warning' href='comments.php?unapprove=$comment_id'><span class='fa fa-times'> UnApprove</a></td>";
                        echo "<td><a class='btn btn-danger' href='comments.php?delete=$comment_id'><span class='fa fa-trash'> Delete</a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <?php
        
        if(isset($_GET['approve'])){
            $approve_comment_id = $_GET['approve'];
            $query = "UPDATE comments SET comment_status='approved' WHERE comment_id = {$approve_comment_id}";
            $approve_query = mysqli_query($connection, $query);
            confirmQuery($approve_query);
            header("Location: comments.php");
        }
        
        if(isset($_GET['unapprove'])){
            $unapprove_comment_id = $_GET['unapprove'];
            $query = "UPDATE comments SET comment_status='unapproved' WHERE comment_id = {$unapprove_comment_id}";
            $unapprove_query = mysqli_query($connection, $query);
            confirmQuery($unapprove_query);
            header("Location: comments.php");
        }
    
    
        if(isset($_GET['delete'])){
            $delete_comment_id = $_GET['delete'];
            $query = "UPDATE posts SET post_comment_count = post_comment_count-1 WHERE post_id = (SELECT comment_post_id FROM comments WHERE comment_id = $delete_comment_id)";
            $update_comment_count = mysqli_query($connection, $query);
            $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
            $delete_query = mysqli_query($connection, $query);
            confirmQuery($delete_query);
            header("Location: comments.php");
        }
    ?>
</div>
<!--END OF VIEW ALL COMMENTS SECTION-->