<?php include 'db.php'; ?>
<?php  
    if (isset($_GET['username'])) {
    	$username = $_GET['username'];

        if (username_exists($username) == 0) {
        	echo "";
        } else {
        	echo "Username already exists";
        }
    }
?>

<?php  
    if (isset($_GET['email'])) {
    	$email = $_GET['email'];

        if (email_exists($email) == 0) {
        	echo "";
        } else {
        	echo "Email already exists";
        }
    }
?>