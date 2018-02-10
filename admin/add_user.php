<?php  
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'super admin') {
?>
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
                            Add User
                        </h1>

                        <?php  
                            if (isset($_POST['post_submit'])) {
                                $firstname = escape($_POST['firstname']);
                                $lastname = escape($_POST['lastname']);
                                $role = escape($_POST['role']);
                                $username = escape($_POST['username']);
                                $email = escape($_POST['email']);
                                $password = escape($_POST['password']);

                                $password = password_hash("$password", PASSWORD_BCRYPT, ["cost" => 12]);

                                $sql = "INSERT INTO users(username,user_password,user_firstname,user_lastname,user_email,user_role) VALUES('$username','$password','$firstname','$lastname','$email','$role')";
                                $result = mysqli_query($conn, $sql);
                                header("Location: users.php");
                                db_error($result);
                            }

                        ?>

                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="title">Firstname</label>
                                    <input type="text" class="form-control" name="firstname">
                                </div>
                                <div class="form-group">
                                    <label for="title">Lastname</label>
                                    <input type="text" class="form-control" name="lastname">
                                </div>
                                <div class="form-group">
                                    <label for="title">User Role</label>
                                    <div>
                                        <select name="role" class="form-control">
                                            <option value="admin">Admin</option>
                                            <option value="subscriber">Subscriber</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Username</label>
                                    <input type="text" class="form-control" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="title">Email ID</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label for="title">Password</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="post_submit" value="Add User">
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

<?php } else {
    header("Location: ../index.php");
} ?>