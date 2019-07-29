<!--ROOT SEARCH PAGE -->

<!DOCTYPE html>
<html lang="en">

<?php
 $title = "Study Link | Search";
    include_once("includes/header.php");
    include_once("includes/db.php");
?>

    <body>

        <?php
            
        ?>
            <!-- Blog Sidebar Widgets Column -->>

            <!-- Page Content -->
            <div class="container">

                <div class="row">

                    <!-- Blog Entries Column -->
                    <div class="col-md-8">

                        <h1 class="page-header">
                            Search Results
                            <!--                                    <small>About TP.....</small>-->
                        </h1>
                        <?php
                            if(isset($_POST['submit'])){  
                                $search = $_POST['search'];
                                $query = "SELECT * FROM posts WHERE post_tags like '%$search%' AND post_status = 'published'";
                                $search_query = mysqli_query($connection, $query);
                                  if(!$search_query){
                                      //there was some error in processing the function
                                      die("Query Failed:".mysqli_error($connection)); //just like return of programming where it won't proceed the page further
                                  }
                                  $count = mysqli_num_rows($search_query);
                                  if($count == 0){
                                      echo "<h2>NO RESULT FOUND!</h2>";
                                  }else{
                                      while($row = mysqli_fetch_assoc($search_query)){
                                        $post_id = $row['post_id'];
                                        $post_title = $row['post_title'];
                                        $post_author = $row['post_author'];
                                        $post_date = $row['post_date'];
                                        $post_image = $row['post_image'];
                                        $post_content = substr($row['post_content'], 0 ,200)."...";
                            
                        ?>


                            <!-- Start of Blog Posts -->
                            <h2>
                                <a href="#">
                                    <?php echo $post_title; ?>
                                </a>
                            </h2>
                            <p class="lead">
                                by
                                <a href="index.php">
                                    <?php echo $post_author; ?>
                                </a>
                            </p>
                            <p><span class="glyphicon glyphicon-time"></span> Posted on
                                <?php echo $post_date ?>
                            </p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="
                            <?php echo $post_title; ?>" width="500px">
                            <hr>
                            <p><?php echo $post_content; ?></p>
                            <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                            <hr>
                            <!--END of Blog Posts-->
                            <?php
                                }//end of while
                            }//end of else
                        }//end of ISSET
                            
                            
?>

                    </div>

                    <?php
                        include_once("includes/sidebar.php");
                    ?>

                </div>
                <!-- /.row -->

                <hr>

                <?php
                include_once("includes/footer.php");
            ?>

            </div>
            <!-- /.container -->

            <!-- jQuery -->
            <script src="js/jquery.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>

    </body>

</html>
