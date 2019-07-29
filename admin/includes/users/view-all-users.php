<!--(ADMIN) VIEW ALL USERS SECTION-->
<div class="col-xs-12"><!--col-xs-12 will take full space of the box that contains it--> 
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Image</th>
            <th>Make Admin</th>
            <th>Make Subscriber</th>
            <th>Edit User</th>
            <th>Delete</th>
            
        </tr>
        <tbody>
            <?php
                $query = "SELECT * FROM users";#bring everything from posts table
                $select_all_users_query = mysqli_query($connection, $query);#query executed
                #fetches associtaive array from database
                while($row = mysqli_fetch_assoc($select_all_users_query)){
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_role = $row['user_role'];
                    $user_image = $row['user_image'];

                    echo "<tr>";#start of table row; show everything in table from db using variables created above
                        echo "<td>$user_id</td>";#table data i.e. id data present in db
                        echo "<td>$username</td>";
                        echo "<td>$user_firstname</td>";#table data i.e. title data present in db
                        echo "<td>$user_lastname</td>";
                        echo "<td>$user_email</td>";
                        echo "<td>$user_role</td>";
                        echo "<td><img src='images/$user_image' class='img-rounded img-responsive' width='150px'></td>";
                    
                        echo "<td><a class='btn btn-success' href='users.php?make_admin=$user_id'><span class='fa fa-check'> Make Admin</a></td>";
                        echo "<td><a class='btn btn-warning' href='users.php?make_subscriber=$user_id'><span class='fa fa-times'> Make Subscriber</a></td>";
                        echo "<td><a class='btn btn-primary' href='users.php?source=edit_user&edit_id=$user_id'><span class='fa fa-trash'> Edit</a></td>";
                        echo "<td><a class='btn btn-danger' href='users.php?delete=$user_id'><span class='fa fa-trash'> Delete</a></td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
    <?php
        
        if(isset($_GET['make_admin'])){
            $make_admin_user_id = $_GET['make_admin'];
            $query = "UPDATE users SET user_role='admin' WHERE user_id = {$make_admin_user_id}";
            $make_admin_query = mysqli_query($connection, $query);
            confirmQuery($make_admin_query);
            header("Location: users.php");
        }
        
        if(isset($_GET['make_subscriber'])){
            $make_subscriber_user_id = $_GET['make_subscriber'];
            $query = "UPDATE users SET user_role='subscriber' WHERE user_id = {$make_subscriber_user_id}";
            $make_subscriber_query = mysqli_query($connection, $query);
            confirmQuery(make_subscriber_query);
            header("Location: users.php");
        }
    
    
        if(isset($_GET['delete'])){
            $delete_user_id = $_GET['delete'];
            $query = "DELETE FROM users WHERE user_id = {$delete_user_id}";
            $delete_query = mysqli_query($connection, $query);
            confirmQuery($delete_query);
            header("Location: users.php");
        }
    ?>
</div>
<!--END OF VIEW ALL COMMENTS SECTION-->