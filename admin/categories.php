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
                            All Categories
                        </h1>

                        <div class="col-xs-6">

                            <?php  // insert categories
                                cat_insert();
                            ?>

                            <form action="" method="POST">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input name="cat_title" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="submit" value="Add Category">
                            </div>
                            </form>
                            <?php  //delete categories
                                cat_delete();   
                            ?>

                            <?php  // edit categories
                                if (isset($_POST['submit_edit'])) {
                                        $user_id = $_SESSION['id'];
                                        $cat_id = escape($_POST['edit']);
                                        $sql = "SELECT * FROM categories WHERE cat_id = $cat_id AND cat_user_id = $user_id";
                                        $result = mysqli_query($conn, $sql);
                                        $row = mysqli_fetch_assoc($result);
                            ?>
                                <form action="" method="POST">
                                <div class="form-group">
                                    <label for="cat-title">Update Category</label>
                                    <input name="edit_cat_title" type="text" class="form-control" value="<?php echo $row['cat_title'] ?>">
                                    <input type="hidden" name="id" value="<?php echo $cat_id; ?>">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="edit_submit" value="Update Category">
                                </div>
                                </form>
                            <?php } ?>

                            <?php  // edit submit categories
                                cat_edit();
                            ?>
                        </div>
                        <div class="col-xs-6">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Title</th>
                                        <th>View</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //select all categories
                                        $id = $_SESSION['id'];
                                        $sql = "SELECT * from categories WHERE cat_user_id = $id";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $title = $row['cat_title'];
                                            $id = $row['cat_id'];
                                    ?>
                                    <tr>
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td><a class="btn btn-info" href="../category.php?category=<?php echo $id; ?>">View</a></td>
                                        <td>
                                            <form action="" method="POST">
                                                <input type="hidden" name="edit" value="<?php echo $id; ?>">
                                                <input type="submit" value="Edit" class="btn btn-warning" name="submit_edit">
                                            </form>
                                        </td>
                                        <td><a href="javascript: void(0);" class="btn btn-danger delete_link" rel="<?php echo $id; ?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                                
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
