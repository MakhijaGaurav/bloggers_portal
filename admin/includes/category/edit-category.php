<!--EDIT CATEGORY-->
<?php 
    editCategory();
    $edit_cat_title = fetchCategoryForEdit(); 
?>
<div class="col-xs-6">
    <?php
        if(isset($edit_cat_title)){#if loop is kept here to keep the div space even when it isn't present there  
    ?>
    <h3>Edit Category</h3>
    <form action="" method="POST">
        <div class="form-group">
            <label for="cat_title">Category Title</label>
            <input id="cat_title" class="form-control" type="text" name="cat_title" 
            value="<?php echo $edit_cat_title; ?>"><!--keep this name same as $_POST['name']-->
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="edit_submit" value="Edit Category">
        </div>
    </form>
    <?php
        }
    ?>
</div>
<!--END OF EDIT CATEGORY FORM-->