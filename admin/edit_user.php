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
                            Edit User
                        </h1>
                        <?php // show edit data
                            if (isset($_GET['edit'])) {
                                $user_id = $_GET['edit'];
                            
                            $sql = "select * from users where user_id = $user_id";
                            $result = mysqli_query($conn, $sql);

                            $row = mysqli_fetch_assoc($result);
                                $username = $row['username'];
                                $id = $row['user_id'];
                                $firstname = $row['user_firstname'];
                                $lastname = $row['user_lastname'];
                                $email = $row['user_email'];
                                $role = $row['user_role'];
                                $password = $row['user_password'];
                              }  
                        ?>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <label for="title">Firstname</label>
                                    <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Lastname</label>
                                    <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">User Role</label>
                                    <div>
                                        <select name="role" class="form-control">
                                            <option value="<?php echo $role; ?>"><?php echo $role; ?></option>
                                            <?php  
                                                if ($role === "admin") {
                                                    echo "<option value='subscriber'>Subscriber</option>";
                                                } else {
                                                    echo "<option value='admin'>Admin</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Username</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Email ID</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $email; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Password</label>
                                    <input type="password" class="form-control" name="password"  value="<?php echo $password; ?>">
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="post_submit" value="Update User">
                                </div>
                            </form>
                            <?php  //update edit data
                                user_edit();
                            ?>
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