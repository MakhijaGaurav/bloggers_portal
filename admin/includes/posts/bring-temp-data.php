<div class="form-group">
                        <label for="post_title">Post Title</label>
                        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="preview_title" id="preview_post_title">
                    </div>
                    <div class="form-group">
                        <label for="post_category">Post Category ID</label>
                        <select class="form-control" name="preview_post_category_id" id="post_category">
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
                        <select name="preview_status" id="post_status" class="form-control">
                            <option value="draft" <?php if($post_status == "draft") echo "selected"; ?>>Draft</option>
                            <option value="published" <?php if($post_status == "published") echo "selected"; ?>>Published</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Current Image</label>
                        <img class="img-responsive" src="../images/<?php echo $post_image; ?>" width="100px" alt=""><!--shows the post_image related to it-->
                    </div>
                    <div>
                        <label for="post_image">Post Image</label>
                        <input class="form-control" type="file" name="preview_image" id="post_image">
                    </div>

                    <div class="form-group">
                        <label for="post_tags">Post Tags</label>
                        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="preview_post_tags" id="post_tags">
                    </div>

                    <div class="form-group">
                        <label for="post_content">Post Content</label>
                        <textarea class="form-control" name="preview_post_content" id="post_content" cols="30" rows="10"><?php echo $post_content; ?></textarea>
                    </div>
                    <!--<div class="form-group" id="previewPost">
                        <input type="submit" class="btn btn-primary" name="preview_post" value="Preview Post">
                    </div>-->