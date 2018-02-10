<?php include 'includes/header.php'; ?>

    <div id="wrapper">

        <!-- Navigation -->
            <?php include 'includes/navigation.php'; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php 
                            if (isset($_SESSION['relpy_message_success'])) {
                                $message_success = $_SESSION['relpy_message_success'];
                                echo "<p class='alert alert-success'>$message_success</p>";
                                unset($_SESSION['relpy_message_success']);
                            }
                        ?>
                        <h1 class="page-header">
                            Inbox Messages
                        </h1>
                        <?php  //delete inbox
                            if (isset($_POST['submit_delete'])) {
                                $mgs_id = escape($_POST['delete']);
                                $sql = "DELETE FROM messages WHERE mgs_id = $mgs_id";
                                $result = mysqli_query($conn, $sql);
                                header("Location: inbox.php");
                            }
                        ?>
                        <div class="table-responsive">  
                        <table class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>Sender</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>View</th>
                                    <th>Reply</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //select all messages
                                $username = $_SESSION['username'];

                                    $sql = "SELECT * FROM messages WHERE mgs_author = '$username' ORDER BY mgs_id DESC";
                                    $results = mysqli_query($conn, $sql);
                                    db_error($results);
                                    
                                    while ($row = mysqli_fetch_assoc($results)) {
                                        $id = $row['mgs_id'];
                                        $message = $row['mgs_content'];
                                        $email = $row['mgs_send_email'];
                                        $sender = $row['mgs_send_name'];
                                        $date = $row['mgs_date'];

                                ?>
                                <tr>
                                    <td><?php echo $sender; ?></td>
                                    <td><?php echo $email; ?></td>
                                    <td><?php echo substr($message, 0,25); ?></td>
                                    <td><?php echo $date; ?></td>
                                    <td><a href="javascript: void(0);" class="btn btn-info view_link" rel="<?php echo $sender; ?>" name="<?php echo $message; ?>" rev="<?php echo $email; ?>">View</a></td>
                                    <td><a href="javascript: void(0);" class="btn btn-primary reply_link" rel="<?php echo $email; ?>">Reply</a></td>
                                    <td><a href="javascript: void(0);" class="btn btn-danger delete_link" rel="<?php echo $id; ?>">Delete</a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include 'includes/footer.php'; ?>

<?php include 'includes/delete_modal.php'; ?>       
<script>
    $(document).ready(function(){
        $(".view_link").on('click', function(){
            var sender = $(this).attr("rel");
            var email = $(this).attr("rev");
            var message = $(this).attr("name");

            $(".sender_name").attr("value", sender); 
            $(".sender_email").attr("value", email); 
            $(".sender_message").html(message);

            $("#view_modal").modal('show');
        });
    });


    $(document).ready(function(){
        $(".reply_link").on('click', function(){
            var email = $(this).attr("rel");
            $(".sender_email").attr("value", email); 
            $("#reply_modal").modal('show');
        });
    });


    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var post_id = $(this).attr("rel");
            $(".modal_delete_link").attr("value", post_id); 
            $("#myModal").modal('show');
        });
    });
</script>