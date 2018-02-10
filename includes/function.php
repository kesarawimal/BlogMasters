<?php  
    function escape_str($value)
    {
        global $conn;
        $value = mysqli_real_escape_string($conn,trim($value));
        return $value;
    }
?>
<?php  
    function user_register($username,$email,$password,$firstname,$lastname)
    {
        global $conn;
        $username = escape_str($username);
        $email = escape_str($email);
        $password = escape_str($password);
        $firstname = escape_str($firstname);
        $lastname = escape_str($lastname);

            $password = password_hash("$password", PASSWORD_BCRYPT, ["cost" => 12]);
            $sql = "INSERT INTO users(username,user_password,user_email,user_role,user_firstname,user_lastname) VALUES('$username','$password','$email','admin','$firstname','$lastname')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("Location: admin/index.php");
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['id'] = mysqli_insert_id($conn);
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['role'] = 'admin';
                return true;
            } else {
                return false;
            }
    }
?>
<?php  
    function username_exists($username)
    {
        global $conn;
        $username = escape_str($username);
        $sql = "SELECT * from users where username = '$username'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        return $count;
    }
    function email_exists($email)
    {
        global $conn;
        $email = escape_str($email);
        $sql = "SELECT * from users where user_email = '$email'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        return $count;
    }
?>