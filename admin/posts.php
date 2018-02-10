<?php include 'includes/header.php'; ?>

    <div id="wrapper">

        <!-- Navigation -->
            <?php include 'includes/navigation.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            All Posts
                        </h1>
                        <?php // delete post
                            post_delete();

                            //reset post view count
                            post_view_reset();
                        ?>
                        <?php  
                            if (isset($_POST['checkboxArray']) && isset($_POST['submit'])) {
                                foreach ($_POST['checkboxArray'] as $post_id_array) {
                                   $bulkoption = $_POST['bulkoption'];

                                   switch ($bulkoption) {
                                        case 'published':
                                            $sql = "UPDATE posts SET post_status = '$bulkoption' WHERE post_id = $post_id_array";
                                            $result = mysqli_query($conn, $sql);
                                            break;

                                        case 'draft':
                                            $sql = "UPDATE posts SET post_status = '$bulkoption' WHERE post_id = $post_id_array";
                                            $result = mysqli_query($conn, $sql);
                                            break;

                                        case 'delete':
                                            $sql = "DELETE FROM posts WHERE post_id = $post_id_array";
                                            $result = mysqli_query($conn, $sql);
                                            break;

                                        case 'clone':
                                            $sql = "select * from posts where post_id = $post_id_array";
                                            $result = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $title = $row['post_title'];
                                                $id = $row['post_id'];
                                                $author = $row['post_author'];
                                                $category = $row['post_category_id'];
                                                $status = $row['post_status'];
                                                $image = $row['post_image'];
                                                $tags = $row['post_tags'];
                                                $content = $row['post_content'];
                                                $comment_count = $row['post_comment_count'];
                                                $date = $row['post_date'];
                                            }

                                            $sql = "INSERT INTO posts(post_category_id,post_title,post_author,post_image,post_content,post_tags,post_comment_count,post_status) VALUES('$category','$title','$author','$image','$content','$tags','$comment_count','$status')";
                                            $result = mysqli_query($conn, $sql);
                                            db_error($result);
                                            break;
                                        
                                        default:
                                            # code...
                                            break;
                                    } 
                                }
                            }
                        ?>
                        <form action="" method="POST">
                            <div id="bulkmenu" class="col-xs-4">
                                <select name="bulkoption" id="" class="form-control">
                                    <option value="">Select Option</option>
                                    <option value="published">Publish</option>
                                    <option value="draft">Draft</option>
                                    <option value="delete">Delete</option>
                                    <option value="clone">Clone</option>
                                </select>
                            </div>
                            <div class="col-xs-8">
                                <input type="submit" name="submit" class="btn btn-success" value="Apply">
                                <a href="add_post.php" class="btn btn-primary">Add New</a>
                            </div>
                        <div class="table-responsive col-xs-12">  
                        <table class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllBoxes"></th>
                                    <th>ID</th>
                                    <!-- <th>Author</th> -->
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <!-- <th>Tags</th> -->
                                    <th>Comments Count</th>
                                    <th>Views Count</th>
                                    <th>Date</th>
                                    <th>View</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //select all posts
                                    $username = $_SESSION['username'];
                                    $sql = "SELECT * from posts WHERE post_author = '$username' order by post_id desc";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $title = $row['post_title'];
                                        $id = $row['post_id'];
                                        $author = $row['post_author'];
                                        $category = $row['post_category_id'];
                                        $status = $row['post_status'];
                                        $image = $row['post_image'];
                                        $tags = $row['post_tags'];
                                        $comments = $row['post_comment_count'];
                                        $view_count = $row['post_view_count'];
                                        $date = $row['post_date'];

                                ?>
                                <tr>
                                    <td><input type="checkbox" class="checkbox" name="checkboxArray[]" value="<?php echo $id; ?>"></td>
                                    <td><?php echo $id; ?></td>
                                    <!-- <td><?php echo $author; ?></td> -->
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo cat_select($category); ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td><img width="100" src="../images/<?php echo $image; ?>" alt="image"></td>
                                    <!-- <td><?php echo $tags; ?></td> -->
                                    <td><a href="post_comments.php?post_id=<?php echo $id; ?>"><?php echo $comments; ?></a></td>
                                    <td><a class="label label-default" href="posts.php?reset=<?php echo $id; ?>"><?php echo $view_count; ?></a></td>
                                    <td><?php echo $date; ?></td>
                                    <td><a class="btn btn-info" href="../post.php?post_id=<?php echo $id; ?>">View</a></td>
                                    <td><a class="btn btn-warning" href="edit_post.php?edit=<?php echo $id; ?>">Edit</a></td>
                                    <td><a href="javascript: void(0);" class="btn btn-danger delete_link" rel="<?php echo $id; ?>">Delete</a></td>
                                    <!-- <td><a onClick="javascript: return confirm('Are you sure you want to delete');" href="posts.php?delete=<?php echo $id; ?>">Delete</a></td> -->
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include 'includes/footer.php'; ?>

<?php include 'includes/delete_modal.php'; ?>
<script>
    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var post_id = $(this).attr("rel");
            $(".modal_delete_link").attr("value", post_id); 
            $("#myModal").modal('show');
        });
    });
</script>