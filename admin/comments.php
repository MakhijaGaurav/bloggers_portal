    <!--ADMIN COMMENTS.PHP -->
    <!DOCTYPE html>
    <?php
        ob_start();#(output buffering is on)to prevent sending output; to prevent insertion of new record on refresh page
                    #ob_start() should be the first method to be called in the page or else it doesn't work!
    ?>
    <html lang="en">
    <?php
        $page = "comments";
        include_once("includes/header.php");#refactoring of the code into other files
        include_once("functions.php");
        $username = checkUser();
        
        $time_out = time() - 60;
        $session = session_id();
        $query = "SELECT * FROM users_online WHERE time > $time_out and session = '$session'";
        $check_active_session = mysqli_query($connection, $query);
        if(mysqli_num_rows($check_active_session) == 0){
            mysqli_query($connection, "DELETE FROM users_online WHERE session = '$session'");
            include_once("../includes/logout.php");
            die("You have been logged out!!");
        }
    ?>
    <body>
        <?php
            if($connection)#checking if connection is established or not
                echo "hello";
        ?>
        <div id="wrapper">
            <!-- Navigation -->
            <?php
                include_once("includes/navigation.php");#refactoring of code
            ?>
            <div id="page-wrapper">
                <div class="container-fluid"><!--container-fluid bootstrap class -->
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Welcome to CPanel
                                <small><?php echo "$username"; ?></small>
                            </h1>
                            <?php
                                #conditional routing; acc to the request made(get/post)
                                $source = "";
                                if(isset($_GET['source'])){
                                    $source = $_GET['source'];
                                }
                                switch($source){
                                    case 'add_post':
                                        include_once("includes/posts/add-post.php");
                                        break;
                                    case 'edit_post':
                                        include_once("includes/posts/edit-post.php");
                                        break;
                                        
                                    default:
                                        include_once("includes/comments/view-all-comments.php");
                                        break;
                                }
                            ?>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->

        <!-- jQuery -->
        <script src="js/jquery.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
    </body>
    </html>
