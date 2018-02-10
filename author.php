<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
                <?php 
                    if (isset($_GET['author'])) {
                        $message_authot = $_GET['author'];
                    } else {
                        $message_authot = '';
                    }
                 ?>
                <?php 
                    if (isset($_SESSION['message_success'])) {
                        $message_success = $_SESSION['message_success'];
                        echo "<p class='alert alert-success'>$message_success</p>";
                        unset($_SESSION['message_success']);
                    }
                ?>

                <h1 class="page-header">
                    All posts from <mark style="background-color: transparent;"><?php echo ucfirst($message_authot); ?></mark>
                    <small><a href="javascript: void();" class="btn btn-primary send_message" rel="<?php echo $message_authot; ?>">Contact <?php echo ucfirst($message_authot); ?></a></small>
                </h1>

                <!-- First Blog Post -->
                <?php  

                    if (isset($_GET['author'])) {
                        $author = $_GET['author'];

                    //pagination system
                    if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") { 
                        $sql = "SELECT * from posts WHERE post_author = '$author'";
                    } else {
                        $sql = "SELECT * from posts WHERE post_author = '$author' AND post_status = 'published'";
                    }
                    $result = mysqli_query($conn, $sql);
                    $page_count = mysqli_num_rows($result);
                    $page_count = ceil($page_count / 5);

                    //get request
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];

                        if ($page == "" || $page == 1) {
                            $page_result = 0;
                        } else {
                            $page_result = ($page * 5) - 5;
                        }
                    } else {
                        $page = "";
                        $page_result = 0;
                    }

                     //check if this admin
                    if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                        $sql = "SELECT * from posts where post_author = '$author' ORDER BY post_id DESC LIMIT $page_result, 5";
                    } else {
                        $sql = "SELECT * from posts where post_author = '$author' and post_status = 'published' ORDER BY post_id DESC LIMIT $page_result, 5";
                    }
                        $result = mysqli_query($conn, $sql);

                        if (!$result) {
                            die("Query Failed!" . mysqli_error($conn));
                        }

                        $count = mysqli_num_rows($result);

                        if ($count == 0) {
                            echo "No Results";
                        } else {
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                $post_title = $row['post_title'];
                                $post_db_id = $row['post_id'];
                                $post_author = $row['post_author'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = substr($row['post_content'], 0,1000);

                ?>



                <h2>
                    <a href="post.php?post_id=<?php echo $post_db_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <?php echo ucfirst($post_author);  ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive img-rounded" style="width: 900px; height: 300px;" src="images/<?php echo $post_image; ?>" alt="image">
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php  }}} ?>

                <ul class="pagination pagination-lg">
                    <?php  
                        for ($i=1; $i <= $page_count ; $i++) { 
                            if ($i == $page) {
                                echo "<li class='active'><a href='author.php?author=$author&page=$i'>$i</a></li>";
                            } else {
                                echo "<li><a href='author.php?author=$author&page=$i'>$i</a></li>";
                            }  
                        }
                    ?>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include 'includes/sidebar.php'; ?>

        </div>
        <!-- /.row -->

        <hr>

        <?php include 'includes/footer.php'; ?>

<?php include 'includes/message_modal.php'; ?>
<script>
    $(document).ready(function(){
        $(".send_message").on('click', function(){
            var author = $(this).attr("rel");
            $(".author_id").attr("value", author); 
            $("#message_modal").modal('show');
        });
    });
</script>
