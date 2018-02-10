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
                            Add Post
                        </h1>

                        <?php  
                        $error = array('title' => '', 'content' => '');

                            if (isset($_POST['post_submit'])) {
                                $title = escape($_POST['title']);
                                $caterory_id = escape($_POST['caterory_id']);
                                $author = $_SESSION['username'];
                                $status = escape($_POST['status']);
                                $tags = escape($_POST['tags']);
                                $content = escape($_POST['content']);
                                
                                $image = $_FILES['image']['name'];
                                $image_temp = $_FILES['image']['tmp_name'];

                                move_uploaded_file($image_temp, "../images/$image");

                                if ($image == '') {
                                    $image = rand(0, 1) ? 'placeholder1.jpg' : 'placeholder2.jpg';
                                }
                                // validate inputs
                                if ($title == '') {
                                    $error['title'] = 'Title cannot be empty';
                                }

                                if ($content == '') {
                                    $error['content'] = 'Content cannot be empty';
                                }

                                //check if there are no errors
                                foreach ($error as $key => $value) {
                                    if (empty($value)) {
                                        unset($error[$key]);
                                    }
                                }

                                if (empty($error)) {
                                    $sql = "INSERT INTO posts(post_category_id,post_title,post_author,post_image,post_content,post_tags,post_status) VALUES('$caterory_id','$title','$author','$image','$content','$tags','$status')";
                                    $result = mysqli_query($conn, $sql);

                                    if ($result) {
                                        $id = mysqli_insert_id($conn);
                                        echo "<p class='bg-success'>Post Created Successfully. <a href='../post.php?post_id=$id'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
                                    } else {
                                        db_error($result);
                                    } 
                                }
                            }

                        ?>

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">Post Title</label>
                                    <p class="bg-danger"><?php echo isset($error['title']) ? $error['title'] : '' ?></p>
                                    <input type="text" class="form-control" name="title" value="<?php echo isset($title) ? $title : '' ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Category</label>
                                    <div>
                                        <select name="caterory_id" class="form-control">
                                        <?php //select all categories
                                        $sql = "select * from categories";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $title = $row['cat_title'];
                                            $id = $row['cat_id'];
                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="title">Post Author</label>
                                    <div>
                                        <select name="author" class="form-control">
                                        <?php //select all users
                                        $sql = "select * from users";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $username = $row['username'];
                                            $user_id = $row['user_id'];
                                        ?>
                                        <option value="<?php echo $username; ?>"><?php echo $username; ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="title">Post Status</label>
                                    <select name="status" class="form-control">
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Image</label>
                                    <input type="file" name="image">
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Tags</label>
                                    <input type="text" class="form-control" name="tags" value="<?php echo isset($tags) ? $tags : '' ?>">
                                </div><div class="form-group">
                                    <label for="title">Post Content</label>
                                    <p class="bg-danger"><?php echo isset($error['content']) ? $error['content'] : '' ?></p>
                                    <textarea name="content" id="" cols="30" rows="10" class="form-control"><?php echo isset($content) ? str_replace('\r\n', '</br>', $content) : '' ?></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="post_submit" value="Publish Post">
                                </div>
                            </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include 'includes/footer.php'; ?>

        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script src="https://cloud.tinymce.com/stable/plugins.min.js?apiKey=b905c5lx8qyvok2kahbma6rrroolx58xkrm9ex0owfoj9e11"></script>
        <script>tinymce.init({
        selector: 'textarea',
        height: 500,
        theme: 'modern',
        plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat',
        image_advtab: true,
        templates: [
        { title: 'Test template 1', content: 'Test 1' },
        { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'
        ]
        });</script>
