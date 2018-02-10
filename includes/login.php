<?php include 'db.php'; ?>
<?php ob_start(); ?>
<?php session_start(); ?>
<?php  
if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "select * from users where username = '$username'";
    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);
    $db_username = $row['username'];
    $db_id = $row['user_id'];
    $db_email = $row['user_email'];
    $db_password = $row['user_password'];
    $db_firstname = $row['user_firstname'];
    $db_lastname = $row['user_lastname'];
    $db_role = $row['user_role'];


    if (!password_verify($password , $db_password)) {
        $_SESSION['failed_login'] = 'Try again';
    	header("Location: ../index.php");
    }
    else {
    	header("Location: ../admin/index.php");
    	$_SESSION['username'] = $db_username;
        $_SESSION['id'] = $db_id;
    	$_SESSION['email'] = $db_email;
    	$_SESSION['firstname'] = $db_firstname;
    	$_SESSION['lastname'] = $db_lastname;
    	$_SESSION['role'] = $db_role;
    }

}
?>