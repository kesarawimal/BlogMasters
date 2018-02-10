
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">BLOG MASTERS</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                    <?php 



                        $sql = "SELECT * from categories LIMIT 7";
                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_assoc($result)) {
                            $title = $row['cat_title'];
                            $id = $row['cat_id'];


                            //make link active
                            $class_active = '';
                            $reg_class_active = '';
                            $page = basename($_SERVER['PHP_SELF']);
                            if (isset($_GET['category'])) {
                                $parm_cat_id = $_GET['category'];
                            } else {
                                $parm_cat_id = '';
                            }
                            if ($page == 'registration.php') {
                                $reg_class_active = 'active';
                            } elseif ($parm_cat_id == $id) {
                                $class_active = 'active';
                            } else {
                                $class_active = '';
                            }
                            $title = strtoupper($title); 
                            echo "<li class='$class_active'><a href='category.php?category=$id'>{$title}</a></li>";
                        }
                    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <!-- <li>
                        <a class="fa fa-user-circle-o fa-2x" href="admin/index.php"></a>
                    </li> -->

                    <?php  
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                            if (isset($_GET['post_id']) && $_SERVER['PHP_SELF'] == '/blog/post.php') {
                                $post_id = $_GET['post_id'];

                        //validation        
                        $username = $_SESSION['username'];
                        $sql = "SELECT * from posts WHERE post_author = '$username' AND post_id = $post_id";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) !== 0) {
                    ?>            
                                <li>
                                    <a class="fa fa-pencil-square-o fa-lg" href="admin/edit_post.php?edit=<?php echo $post_id; ?>"> Edit Post</a>
                                </li>
                    <?php }}} ?>

                    <?php  
                        if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                        
                    ?>            
                        <li>
                            <a class="fa fa-user-circle-o fa-2x" href="admin/index.php"></a>
                        </li>
                    <?php } ?>

                    <li class="<?php echo $reg_class_active; ?>">
                        <a href="registration.php">REGISTER</a>
                    </li>
                    <li>
                        <a href="contact.php">CONTACT</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>