            <div class="col-md-4">

                <!-- Side Widget Well -->
                    <?php include 'includes/widget.php'; ?>

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>

                    <form action="search.php" method="POST">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" name="submit" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    </form>
                    <!-- /.input-group -->
                </div>



                <!-- Blog Login Well -->
                <?php  
                    if (isset($_SESSION['role'])) {
                        $role = $_SESSION['role'];
                        $username = $_SESSION['username'];
                ?>
                <div class="well">
                    <h4 class="text-center">
                        You are logged in as <?php echo ucfirst($username); ?>
                    </h4>
                    <div class="text-center">
                        <a href="includes/logout.php" class="btn btn-danger"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </div>
                </div>

                <?php } else { ?>
                <div class="well">
                    <h4>Login</h4>

                    <!-- login failed message -->
                    <?php if (isset($_SESSION['failed_login'])) {
                        unset($_SESSION['failed_login']);
                    ?>
                    <div class="alert alert-danger">
                        <strong>Login Failed!</strong> Incorrect credentials. Try again
                    </div>
                    <?php } ?>


                    <form action="includes/login.php" method="POST" autocomplete="off">
                    <div class="form-group">
                        <input name="username" placeholder="Enter Username" type="text" class="form-control">
                    </div>

                    <div class="input-group">
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" name="login" value="submit">Submit</button>
                        </span>
                    </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                <?php } ?>



                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">

                                <?php 
                                    $sql = "select * from categories";
                                    $result = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($result);
                                    for ($i=0; $i <= $count; $i=$i+2) { 
                                        $sql = "SELECT * from categories LIMIT $i,1";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $title = $row['cat_title'];
                                            $id = $row['cat_id'];
                                            echo "<li><a href='category.php?category=$id'>{$title}</a></li>";

                                        }
                                    }
                                ?>

                            </ul>
                        </div>

                        <div class="col-md-6">
                            <ul class="list-unstyled">

			                    <?php 
			                        for ($i=1; $i <= $count; $i=$i+2) { 
                                        $sql = "SELECT * from categories LIMIT $i,1";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $title = $row['cat_title'];
                                            $id = $row['cat_id'];
                                            echo "<li><a href='category.php?category=$id'>{$title}</a></li>";

                                        }
                                    }
			                    ?>

                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

            </div>