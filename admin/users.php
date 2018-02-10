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
                            Welcome Admin
                            <small>Kesara</small>
                        </h1>
                        <?php  //delete users
                            user_delete();
                        ?>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Admin</th>
                                    <th>Subscriber</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //select all posts
                                    $sql = "select * from users";
                                    $result = mysqli_query($conn, $sql);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $username = $row['username'];
                                        $id = $row['user_id'];
                                        $firstname = $row['user_firstname'];
                                        $lastname = $row['user_lastname'];
                                        $email = $row['user_email'];
                                        $role = $row['user_role'];

                                ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td><?php echo $firstname; ?></td>
                                    <td><?php echo $lastname; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo $role; ?></td>

                                    <td><a href="users.php?user=<?php echo $id; ?>&role=admin">Admin</a></td>
                                    <td><a href="users.php?user=<?php echo $id; ?>&role=subscriber">Subscriber</a></td>
                                    <?php //user role update 
                                        user_role();
                                    ?>
                                    <td><a href="users.php?delete=<?php echo $id; ?>">Delete</a></td>
                                    <td><a href="edit_user.php?edit=<?php echo $id; ?>">Edit</a></td>
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

<?php } else {
    header("Location: ../index.php");
} ?>