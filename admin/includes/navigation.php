<?php  
$sql = "UPDATE posts SET post_comment_count = (SELECT COUNT(*) FROM comments WHERE com_post_id=posts.post_id);";
$result = mysqli_query($conn, $sql);
?>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Master Panel</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">

                <li><a class="topnav-icons fa fa-home fa-2x" href="../index.php"></a></li>
                <li><a href="javascript: void();">Users Online <span class="badge"><?php echo users_online_now(); ?></span></a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user fa-lg"></i>  <?php echo ucfirst($_SESSION['firstname']); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li>
                            <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-file-text"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="posts_dropdown" class="collapse">
                                <li>
                                    <a href="posts.php">View All Posts</a>
                                </li>
                                <li>
                                    <a href="add_post.php">Add Post</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="categories.php"><i class="fa fa-list"></i> Categories</a>
                        </li>
                        <li>
                            <a href="comments.php"><i class="fa fa-comments"></i> Comments</a>
                        </li>
                        <?php  
                            if (isset($_SESSION['role']) && $_SESSION['role'] == 'super admin') {
                        ?>            
                            <li>
                                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                                    <ul id="demo" class="collapse">
                                        <li>
                                            <a href="users.php">View All Users</a>
                                        </li>
                                        <li>
                                            <a href="add_user.php">Add User</a>
                                        </li>
                                    </ul>
                                </li>
                        <?php } ?>      
                        <li>
                            <a href="inbox.php"><i class="fa fa-inbox"></i> Inbox</a>
                        </li>

                        <li>
                            <a href="profile.php"><i class="fa fa-user"></i> Profile</a>
                        </li>
                    </ul>
                </div>
            <!-- /.navbar-collapse -->
        </nav>