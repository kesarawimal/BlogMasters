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
                            All Comments
                        </h1>
                        <?php  //delete users
                            com_delete();
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In Response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                    <!-- <th>Edit</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php //select all posts
                                $username = $_SESSION['username'];
                                $sql = "SELECT post_id FROM posts where post_author = '$username'";
                                $result = mysqli_query($conn, $sql);
                                db_error($result);
                                while ($rows = mysqli_fetch_assoc($result)) {
                                    $post_id = $rows['post_id'];

                                    $sql = "SELECT c.com_author,c.com_id,c.com_content,c.com_email,c.com_status,c.com_date,c.com_post_id,p.post_title,p.post_id FROM comments c LEFT JOIN posts p ON c.com_post_id = p.post_id WHERE c.com_post_id = $post_id";
                                    $results = mysqli_query($conn, $sql);
                                    db_error($results);
                                    
                                    while ($row = mysqli_fetch_assoc($results)) {
                                        $author = $row['com_author'];
                                        $id = $row['com_id'];
                                        $comment = $row['com_content'];
                                        $email = $row['com_email'];
                                        $status = $row['com_status'];
                                        $post_title = $row['post_title'];
                                        $post_id = $row['post_id'];
                                        $date = $row['com_date'];

                                ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $author; ?></td>
                                    <td><?php echo $comment; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td><a href="../post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></td>
                                    <td><?php echo $date; ?></td>
                                    
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="com_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="status" value="Approve">
                                            <input type="submit" value="Approve" class="btn btn-info" name="submit_aprv">
                                        </form>
                                    </td>
                                    <td>
                                        <form action="" method="POST">
                                            <input type="hidden" name="com_id" value="<?php echo $id; ?>">
                                            <input type="hidden" name="status" value="Unapprove">
                                            <input type="submit" value="Unapprove" class="btn btn-warning" name="submit_aprv">
                                        </form>
                                    </td>
                                    <?php com_status(); ?>
                                    <td><a href="javascript: void(0);" class="btn btn-danger delete_link" rel="<?php echo $id; ?>">Delete</a></td>
                                    <!-- <td><a href="edit_post.php?edit=<?php echo $id; ?>">Edit</a></td> -->
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
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