<!--AVAILABLE OR INSERTED CATEGORIES-->
<div class="col-xs-12"><!--col-xs-12 will take full space of the box that contains it--> 
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Category Title</th>
            <th></th>
            <th></th>
        </tr>
        <tbody>
            <?php
                $query = "SELECT * FROM categories";
                $select_all_categories_query = mysqli_query($connection, $query);
                #fetches associtaive array from database
                while($row = mysqli_fetch_assoc($select_all_categories_query)){
                    echo "<tr>";#start of table row
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    echo "<td>$cat_id</td>";#table data i.e. id data present in db
                    echo "<td>$cat_title</td>";#table data i.e. title data present in db
                    echo "<td><a class='btn btn-danger' href='categories.php?delete=$cat_id'><span class='fa fa-times'> Delete</a></td>";
                    echo "<td><a class='btn btn-primary' href='categories.php?edit=$cat_id'><span class='fa fa-pencil'> Edit</a></td>";

                    echo "</tr>";
                }
                #actual code for deleting the row from database
                if(isset($_GET['delete'])){
                    $delete_id = $_GET['delete'];#$_GET['delete'] because it appears in nav bar of chrome
                    #storing the query in a variable
                    $query = "DELETE FROM categories WHERE cat_id=$delete_id";
                    #below line is just like executeQuery() method of java
                    $delete_query = mysqli_query($connection ,$query);
                    //below line can avoid sql injection by preventing delete data to be shown in the header
                    header("Location: categories.php");
                }
                /*if(isset($_GET['edit'])){
                    $edit_id = $_GET['edit'];
                    #storing the query in a variable
                    $query = "UPDATE categories SET cat_title=? WHERE cat_id=$edit_id";
                    #below line is just like executeQuery() method of java
                    $update_query = mysqli_query($connection ,$query);
                    //below line can avoid sql injection by preventing delete data to be shown in the header
                    header("Location: categories.php");
                }*/
            ?>
       </tbody>
   </table>
</div>