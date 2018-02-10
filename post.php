<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <!-- First Blog Post -->
                <?php  
                if (isset($_GET['post_id'])) {
                    $post_id = $_GET['post_id'];

                    $sql = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $post_id";
                    $result = mysqli_query($conn, $sql);
                    if (!$result) {
                        die("Query Failed" . mysqli_error($conn));
                    }
                    $sql = "SELECT * from posts WHERE post_id = $post_id";
                    $result = mysqli_query($conn, $sql);

                    $row = mysqli_fetch_assoc($result);
                    $post_title = $row['post_title'];
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = $row['post_content'];
                } else {
                    header("Location: index.php");
                }
                ?>

                <!-- Blog Post -->

                <!-- Title -->
                <h1><?php echo $post_title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="author.php?author=<?php echo $post_author; ?>&post_id=<?php echo $post_id; ?>"><?php echo ucfirst($post_author);  ?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>

                <hr>

                <!-- Preview Image -->
                <img class="img-responsive img-rounded" style="width: 900px; height: 500px;" src="images/<?php echo $post_image; ?>" alt="image">

                <hr>

                <!-- Post Content -->
                <p class="lead"><?php echo $post_content; ?></p>

                <hr>

                <!-- Blog Comments -->
                <?php  
                    $error = array('name' => '', 'email' => '','comment' => '' );

                    if (isset($_POST['submit'])) {
                        $name = escape_str($_POST['name']);
                        $email = escape_str($_POST['email']);
                        $comment = escape_str($_POST['comment']);
                        
                        if ($name == '') {
                            $error['name'] = 'Username cannot be empty';
                        }
                        if ($email == '') {
                            $error['email'] = 'Email cannot be empty';
                        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $error['email'] = 'Invalid email format';
                        }
                        if ($comment == '') {
                            $error['comment'] = 'Comment cannot be empty';
                        }

                        //check if there are no errors
                        foreach ($error as $key => $value) {
                            if (empty($value)) {
                                unset($error[$key]);
                            }
                        }
                        if (empty($error)) {
                            $sql = "INSERT INTO comments(com_post_id,com_author,com_email,com_content) values($post_id,'$name','$email','$comment')";
                            $result = mysqli_query($conn, $sql);

                            if ($result) {
                                $sql = "UPDATE posts SET post_comment_count = (SELECT COUNT(*) FROM comments WHERE com_post_id=posts.post_id);";
                                $result = mysqli_query($conn, $sql);
                                $message = 'Your comment successfully submited! Comment is waiting for the approval'; 
                            } else {
                                $message = 'Somethin went wrong. Please try again...'; 
                            }     
                        }
                    }
                ?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="POST" action="">
                        <h5 class="text-center bg-success" id="message"><?php if (isset($message)) {
                            echo $message; 
                        }?></h5>
                        <div class="form-group">
                            <label for="title">Your Name</label>
                            <input type="text" class="form-control" name="name" value="<?php echo isset($name) ? $name : ''; echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>">
                            <p class="bg-danger"><?php echo isset($error['name']) ? $error['name'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="title">Your Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo isset($email) ? $email : ''; echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
                            <p class="bg-danger"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="title">Your Comment</label>
                            <textarea class="form-control" rows="5" name="comment"><?php echo isset($comment) ? str_replace('\r\n', '&#13;&#10;', $comment) : '' ?></textarea>
                            <p class="bg-danger"><?php echo isset($error['comment']) ? $error['comment'] : '' ?></p>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <!-- Comment -->
                <?php  
                    $sql = "SELECT * FROM comments WHERE com_post_id = $post_id AND com_status = 'Approve'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        $author = $row['com_author'];
                        $content = $row['com_content'];
                        $com_date = $row['com_date'];
                ?>
                <div class="media">
                    <a class="pull-left" href="#">
                        <img width="64px" height="64px" class="media-object" src="images/user.jpg" alt="user">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $author; ?>
                            <small><?php echo $com_date; ?></small>
                        </h4>
                        <?php echo $content; ?>
                    </div>
                </div>
                <?php } ?>
                <!-- Comment -->
                <!-- <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Start Bootstrap
                            <small>August 25, 2014 at 9:30 PM</small>
                        </h4>
                        Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus. -->
                        <!-- Nested Comment -->
                        <!-- <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div> -->
                        <!-- End Nested Comment -->
                   <!--  </div>
                </div> -->

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include 'includes/footer.php'; ?>