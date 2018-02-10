<!-- Modal -->
<div id="message_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Send a message to Author</h3>
      </div>
      <div class="modal-body">
        <div class="form-wrap">
          <form action="" method="POST">
          <div class="form-group">
              <label for="username">Your Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required>
          </div>
           <div class="form-group">
              <label for="email">Your Email</label>
              <input type="email" name="email" class="form-control" placeholder="Enter Your Email" required>
          </div>
           <div class="form-group">
              <label for="message">Your Message</label>
              <textarea name="message" class="form-control" cols="30" rows="10" required></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <input type="hidden" name="author" value="" class="author_id">
          <input type="submit" name="submit_message" class="btn btn-info" value="Send Message">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </form>
      </div>
        <!-- <a href="" class="btn btn-danger modal_delete_link">Delete</a> -->
      </div>
    </div>

  </div>
</div>



<?php  //message to author
    if (isset($_POST['submit_message']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $author = $_POST['author'];

        $sql = "INSERT INTO messages(mgs_send_name,mgs_send_email,mgs_content,mgs_author) VALUES('$name','$email','$message','$author')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $_SESSION['message_success'] = 'Your message successfully send to Author';
            header("Location: author.php?author=$author");
        }
    }
?>