<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
    <?php  //form submision
        $error = array('name' => '', 'email' => '','message' => '');

        if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            if ($name == '') {
                $error['name'] = 'Name cannot be empty';
            }

            if ($email == '') {
                $error['email'] = 'Email cannot be empty';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'Invalid email format';
            }

            if ($message == '') {
                $error['message'] = 'Message cannot be empty';
            }

            //check if there are no errors
            foreach ($error as $key => $value) {
                if (empty($value)) {
                    unset($error[$key]);
                }
            }
            if (empty($error)) {
                $to = "kesarawimal9@gmail.com";
                $subject = $name;
                $txt = $message;
                $headers = "From: " . $email;

                if (mail($to,$subject,$txt,$headers)) {
                    $mgs = 'Your form successfully submited';
                } else {
                    $mgs = 'Somethin went wrong. Please try again...';
                }
            }
        }
    ?>
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Us</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                        <h5 class="text-center bg-success" id="message"><?php if (isset($mgs)) {
                            echo $mgs; 
                        }?></h5>
                        <div class="form-group">
                            <label for="username">Your Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Your Name"  autocomplete="on" value="<?php echo isset($name) ? $name : '' ?>" required>
                            <p class="bg-danger" id="user_p"><?php echo isset($error['name']) ? $error['name'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>" required>
                            <p class="bg-danger" id="email_p"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea name="message" class="form-control" cols="30" rows="10" required><?php echo isset($message) ? $message : '' ?></textarea>
                            <p class="bg-danger"><?php echo isset($error['message']) ? $error['message'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>