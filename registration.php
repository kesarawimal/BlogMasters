<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
    <?php  //form submision
        $error = array('username' => '', 'email' => '','password' => '','firstname' => '','lastname' => '');

        if (isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];

            if ($username == '') {
                $error['username'] = 'Username cannot be empty';
            } elseif (strlen($username) <= 4) {
                $error['username'] = 'Username too short';
            } elseif (username_exists($username) !== 0) {
                $error['username'] = 'Username already exists';
            }

            if ($email == '') {
                $error['email'] = 'Email cannot be empty';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'Invalid email format';
            } elseif (email_exists($email) !== 0) {
                $error['email'] = 'Email already exists';
            }

            if ($password == '') {
                $error['password'] = 'Password cannot be empty';
            }

            if ($firstname == '') {
                $error['firstname'] = 'FirstName cannot be empty';
            }

            if ($lastname == '') {
                $error['lastname'] = 'LastName cannot be empty';
            }

            //check if there are no errors
            foreach ($error as $key => $value) {
                if (empty($value)) {
                    unset($error[$key]);
                }
            }
            if (empty($error)) {
                if (user_register($username,$email,$password,$firstname,$lastname) == true) {
                    $message = 'You are successfully registered';
                } else {
                    $message = 'Somethin went wrong. Please try again...';
                }
            }
        }
    ?>
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h5 class="text-center bg-success" id="message"><?php if (isset($message)) {
                            echo $message; 
                        }?></h5>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">Firstname</label>
                            <input type="text" class="form-control" name="firstname" placeholder="Enter your FirstName" onautocomplete="on" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
                            <p class="bg-danger"><?php echo isset($error['firstname']) ? $error['firstname'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Lastname</label>
                            <input type="text" class="form-control" name="lastname" placeholder="Enter your LastName" onautocomplete="on" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
                            <p class="bg-danger"><?php echo isset($error['lastname']) ? $error['lastname'] : '' ?></p>
                        </div>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" onkeyup="check_username(this.value)" autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>" required>
                            <p class="bg-danger" id="user_p"><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email" onkeyup="check_email(this.value)" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>" required>
                            <p class="bg-danger" id="email_p"><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" autocomplete="off" required>
                            <p class="bg-danger"><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

        <hr>

<?php include "includes/footer.php";?>

<script>
    function check_username(username) {
        if (username == 0) {
            document.getElementById("user_p").innerHTML = "";
        }
        else {
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("user_p").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","includes/ajax_validation.php?username="+username,true);
            xmlhttp.send();
        }
    }

    function check_email(email) {
        if (username == 0) {
            document.getElementById("email_p").innerHTML = "";
        }
        else {
            if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("email_p").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","includes/ajax_validation.php?email="+email,true);
            xmlhttp.send();
        }
    }
</script>
