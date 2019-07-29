<!--ADD CATEGORY FORM-->
<?php addCategory(); ?>
<div class="col-xs-6">
    <h3>Add Category</h3>
    <form action="" method="POST"><!--form will use post method to communicate with server-->
        <div class="form-group">
            <label for="cat_title">Category Title</label>
            <input class="form-control" type="text" name="cat_title">
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
        </div>
    </form>
</div>
<!--END OF ADD CATEGORY FORM-->