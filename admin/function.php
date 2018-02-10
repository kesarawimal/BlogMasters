<?php  
if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
} else {
    if ($_SESSION['role'] !== "admin") {
        header("Location: ../index.php");
    } else {
?>
<?php  

function db_error($result)
{
	global $conn;
	if (!$result) {
        die("Query Failed" . mysqli_error($conn));
    }
}

function escape($value)
{
    global $conn;
    $value = mysqli_real_escape_string($conn,trim($value));
    return $value;
}

function cat_insert()
{
	global $conn;
    if (isset($_POST['submit'])) {
    $cat_title = escape($_POST['cat_title']);
	    if ($cat_title == "" || empty($cat_title)) {
	        echo "This field should not be empty";
	    } else {
            $id = $_SESSION['id'];
	        $sql = "insert into categories(cat_title,cat_user_id) values ('$cat_title',$id)";
	        $result = mysqli_query($conn, $sql);

	        if (!$result) {
	            die("Query Failed!" . mysqli_error($conn));
	        }                                    
	    }
	}
}


function cat_delete()
{
    global $conn;
    if (isset($_POST['submit_delete'])) {
        $cat_id = escape($_POST['delete']);
        $sql = "DELETE FROM categories WHERE cat_id = $cat_id";
        $result = mysqli_query($conn, $sql);
        header("Location: categories.php");
    } 
}


function user_delete()
{
    global $conn;
    if (isset($_GET['delete'])) {
        $user_id = escape($_GET['delete']);
        $sql = "DELETE FROM users WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        header("Location: users.php");
    } 
}


function com_delete()
{
    global $conn;
    if (isset($_POST['submit_delete'])) {
        $com_id = escape($_POST['delete']);
        $sql = "DELETE FROM comments WHERE com_id = $com_id";
        $result = mysqli_query($conn, $sql);
        header("Location: comments.php");
    } 
}


function post_com_delete()
{
	global $conn;
    if (isset($_GET['delete'])) {
        $com_id = escape($_GET['delete']);
        $post_id = $_GET['post_id'];
        $sql = "DELETE FROM comments WHERE com_id = $com_id";
        $result = mysqli_query($conn, $sql);
        header("Location: post_comments.php?post_id=$post_id");
    } 
}


function user_role()
{
    global $conn;
    if (isset($_GET['user'],$_GET['role'])) {
        $user = escape($_GET['user']);
        $role = escape($_GET['role']);
        $sql = "UPDATE users SET user_role = '$role' WHERE user_id = $user";
        $result = mysqli_query($conn, $sql);
        db_error($result);
        header("Location: users.php");
    } 
}


function com_status()
{
    global $conn;
    if (isset($_POST['submit_aprv'])) {
        $com_id = escape($_POST['com_id']);
        $status = escape($_POST['status']);
        $sql = "UPDATE comments SET com_status = '$status' WHERE com_id = $com_id";
        $result = mysqli_query($conn, $sql);
        db_error($result);
        header("Location: comments.php");
    } 
}


function post_com_status()
{
    global $conn;
    if (isset($_GET['com_id'],$_GET['status'])) {
        $com_id = escape($_GET['com_id']);
        $post_id = escape($_GET['post_id']);
        $status = $_GET['status'];
        $sql = "UPDATE comments SET com_status = '$status' WHERE com_id = $com_id";
        $result = mysqli_query($conn, $sql);
        db_error($result);
        header("Location: post_comments.php?post_id=$post_id");
    } 
}


function cat_edit()
{
	global $conn;
    if (isset($_POST['edit_submit'])) {
        $edit_title = escape($_POST['edit_cat_title']);
        $cat_id = escape($_POST['id']);

        $sql = "UPDATE categories SET cat_title = '$edit_title' WHERE cat_id = $cat_id";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query Failed" . mysqli_error($conn));
        } else {
            header("Location: categories.php");
        }

    }
}


function post_delete()
{
    global $conn;
    if (isset($_POST['submit_delete'])) {
        $post_id = escape($_POST['delete']);
        $sql = "DELETE FROM posts WHERE post_id = $post_id";
        $result = mysqli_query($conn, $sql);
        header("Location: posts.php");
    } 
}


function post_view_reset()
{
	global $conn;
    if (isset($_GET['reset'])) {
        $post_id = escape($_GET['reset']);
        $sql = "UPDATE posts SET post_view_count = 0 WHERE post_id = $post_id";
        $result = mysqli_query($conn, $sql);
        header("Location: posts.php");
    } 
}


function post_edit()
{
    global $conn;
    if (isset($_POST['post_submit'])) {
        $title = escape($_POST['title']);
        $caterory_id = escape($_POST['caterory_id']);
        $status = escape($_POST['status']);
        $tags = escape($_POST['tags']);
        $content = mysqli_real_escape_string($conn,trim($_POST['content']));
        $id = escape($_POST['id']);
        $old_image = escape($_POST['old_image']);

        $image = $_FILES['image']['name'];
        $image_temp = $_FILES['image']['tmp_name'];

        if ($image == "" || empty($image)) {
            $image = $old_image;
        } else {
            move_uploaded_file($image_temp, "../images/$image");
        }

        if (!empty($title) && !empty($content)) {
            $sql = "UPDATE posts SET post_category_id = '$caterory_id', post_title = '$title', post_image = '$image', post_content = '$content', post_tags = '$tags', post_status = '$status' WHERE post_id = $id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['edit_post'] = $id;
            } else {
                db_error($result);
            } 
        } else {
            $_SESSION['edit_post'] = "error";
        }
        
    }
}


function user_edit()
{
	global $conn;
	if (isset($_POST['post_submit'])) {
        $firstname = escape($_POST['firstname']);
        $lastname = escape($_POST['lastname']);
        $password = escape($_POST['password']);
        $id = escape($_POST['id']);
 
        if ($password == '') {
            $password = escape($_POST['old_password']);
        } else {
            $password = password_hash("$password", PASSWORD_BCRYPT, ["cost" => 12]);
        }

        $sql = "UPDATE users SET user_password = '$password', user_firstname = '$firstname', user_lastname = '$lastname' WHERE user_id = $id";
        $results = mysqli_query($conn, $sql);
        //header("Location: users.php");
        
        db_error($results);
    }
}


function cat_select($category)
{
	global $conn;
    $category = escape($category);
	$sql = "SELECT * FROM categories WHERE cat_id = $category";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['cat_title'];
}

?>


<?php  
function users_online_now()
{
    global $conn;
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 120;
    $time_out = $time - $time_out_in_seconds;

    $sql = "SELECT * FROM users_online WHERE session = '$session'";
    $result = mysqli_query($conn, $sql);
    db_error($result);
    $count = mysqli_num_rows($result);

    if ($count == 0 || $count == NULL) {
        $sql = "INSERT INTO users_online(session,time) VALUES('$session','$time')";
        $result = mysqli_query($conn, $sql);
    } else {
        $sql = "UPDATE users_online SET time = '$time' WHERE session = '$session'";
        $result = mysqli_query($conn, $sql);
    }

    $sql = "SELECT * FROM users_online WHERE time > '$time_out'";
    $result = mysqli_query($conn, $sql);
    db_error($result);
    $users_online_count = mysqli_num_rows($result);
    return $users_online_count;
}
?>


<?php  
function get_count($table_name)
{
    global $conn;
    $sql = "select * from $table_name";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    return $count;
}
?>


<?php  
    function get_condition_count($table,$colum,$value)
    {
        global $conn;
        $sql = "select * from $table where $colum = '$value'";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        return $count;
    }
?>
<?php         
    }
}
?>
