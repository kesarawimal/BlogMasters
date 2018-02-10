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
                            Post Comments
                        </h1>
                        <?php  //delete users
                            post_com_delete();
                        ?>
                        <?php  
                            if (!isset($_GET['post_id'])) {
                                header("Location: comments.php");
                            } else {
                                $post_id = $_GET['post_id'];
                            }
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
                                    $sql = "SELECT * FROM posts WHERE post_id = $post_id";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                    $post_title = $row['post_title'];
                                    $post_id = $row['post_id'];


                                    $sql = "SELECT * FROM comments WHERE com_post_id = $post_id";
                                    $result = mysqli_query($conn, $sql);
                                    db_error($result);
                                    
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $author = $row['com_author'];
                                        $id = $row['com_id'];
                                        $comment = $row['com_content'];
                                        $email = $row['com_email'];
                                        $status = $row['com_status'];
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
                                    
                                    <td><a href="post_comments.php?com_id=<?php echo $id; ?>&status=Approve&post_id=<?php echo $post_id; ?>">Approve</a></td>
                                    <td><a href="post_comments.php?com_id=<?php echo $id; ?>&status=Unapprove&post_id=<?php echo $post_id; ?>">Unapprove</a></td>
                                    <?php post_com_status(); ?>
                                    <td><a href="post_comments.php?delete=<?php echo $id; ?>&post_id=<?php echo $post_id; ?>">Delete</a></td>
                                    <!-- <td><a href="edit_post.php?edit=<?php echo $id; ?>">Edit</a></td> -->
                                </tr>
                                <?php } ?>
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