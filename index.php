<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

    <!-- Navigation -->
<?php include 'includes/navigation.php'; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <!-- <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1> -->
                <?php  //pagination system
                    if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") { 
                        $sql = "SELECT * from posts";
                    } else {
                        $sql = "SELECT * from posts WHERE post_status = 'published'";
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

                ?>
                <!-- First Blog Post -->
                <?php  
                // if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
                //     $sql = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_result, 5";
                // } else {
                // $sql = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_result, 5";

                // }
                $sql = "SELECT * FROM posts "; 
                if(isset($_SESSION['role']) && $_SESSION['role'] == "admin") { 
                    $sql .= ""; 
                } else {
                    $sql .= "WHERE post_status = 'published' ";
                } 
                $sql .= "ORDER BY post_id DESC LIMIT $page_result, 5";
                $result = mysqli_query($conn, $sql);

                $post_count = mysqli_num_rows($result);
                if ($post_count == 0) {
                    echo "<h2 class='text-center'>No posts availble!</h2>";
                } else {

                while ($row = mysqli_fetch_assoc($result)) {
                $post_title = $row['post_title'];
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0,1000);

                ?>

                <h2>
                    <a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author.php?author=<?php echo $post_author; ?>&post_id=<?php echo $post_id; ?>"><?php echo ucfirst($post_author);  ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                <hr>
                <img style="width: 900px; height: 300px;" class="img-responsive img-rounded" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <div class=""><p><?php echo $post_content; ?></p></div>
                <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                <?php }} ?>

                <ul class="pagination pagination-lg">
                    <?php  
                        for ($i=1; $i <= $page_count ; $i++) { 
                            if ($i == $page) {
                                echo "<li class='active'><a href='index.php?page=$i'>$i</a></li>";
                            } else {
                                echo "<li><a href='index.php?page=$i'>$i</a></li>";
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