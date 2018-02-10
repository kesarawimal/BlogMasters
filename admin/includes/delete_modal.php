<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Confirm Delete</h3>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Are you sure you want to delete this?</h4>
      </div>
      <div class="modal-footer">
        <form action="" method="POST">
          <input type="hidden" name="delete" value="" class="modal_delete_link">
          <input type="submit" name="submit_delete" class="btn btn-danger" value="Delete">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </form>
        <!-- <a href="" class="btn btn-danger modal_delete_link">Delete</a> -->
      </div>
    </div>

  </div>
</div>


<!-- Modal -->
<div id="view_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">View Message</h3>
      </div>
      <div class="modal-body">
        <form action="">
          <div class="form-group">
              <label for="username">Sender Name</label>
              <input type="text" name="name" class="form-control sender_name" value="" readonly>
          </div>
          <div class="form-group">
              <label for="username">Sender Email</label>
              <input type="text" name="name" class="form-control sender_email" value="" readonly>
          </div>
          <div class="form-group">
              <label for="username">Message</label>
              <textarea class="form-control sender_message" cols="30" rows="10" readonly></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>

  </div>
</div>



<!-- Modal -->
<div id="reply_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Send Reply Message</h3>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <div class="form-group">
              <label for="To">To</label>
              <input type="text" name="email" class="form-control sender_email" value="" readonly>
          </div>
          <div class="form-group">
              <label for="Message">Message</label>
              <textarea name="message" class="form-control" cols="30" rows="10" autocomplete="Off"></textarea>
          </div>
      </div>
      <div class="modal-footer">
          <input type="submit" name="submit_reply" class="btn btn-primary" value="Send Reply">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </form>
      </div>
    </div>

  </div>
</div>

<?php  //message to author
    if (isset($_POST['submit_reply']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $message = $_POST['message'];
        $author = $_SESSION['username'];

        $result = mail($email,$author,$message);

        if ($result) {
            $_SESSION['relpy_message_success'] = 'Your message successfully send.';
            header("Location: inbox.php");
        }
    }
?>