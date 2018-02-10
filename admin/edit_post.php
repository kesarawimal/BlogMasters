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
                            Edit Post
                        </h1>
                            <?php  //update edit data
                                post_edit();
                            ?>
                        <?php // show edit data
                            if (isset($_GET['edit'])) {
                                $post_id = $_GET['edit'];

                                //validation        
                                $username = $_SESSION['username'];
                                $sql = "SELECT * from posts WHERE post_author = '$username' AND post_id = $post_id";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) !== 0) {
                            
                                    $sql = "select * from posts where post_id = $post_id";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);
                                        $title = $row['post_title'];
                                        $id = $row['post_id'];
                                        $category = $row['post_category_id'];
                                        $status = $row['post_status'];
                                        $image = $row['post_image'];
                                        $tags = $row['post_tags'];
                                        $content = $row['post_content'];
                                } else {
                                    header("Location: index.php");
                                }
                            }

                        ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <?php if (isset($_SESSION['edit_post']) && $_SESSION['edit_post'] == 'error') {
                                echo '<div class="alert alert-danger"><strong>Failed!</strong> Fields cannot be empty.</div>';
                                unset($_SESSION['edit_post']);
                            } elseif (isset($_SESSION['edit_post'])) {
                                $id = $_SESSION['edit_post'];
                                echo "<p class='alert alert-success'>Post Updated Successfully. <a href='../post.php?post_id=$id'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
                                unset($_SESSION['edit_post']);
                            }
                            ?>
                                <div class="form-group">
                                    <label for="title">Post Title</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo $title; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Category</label>
                                    <div>
                                        <select name="caterory_id" class="form-control">
                                        <?php //select all categories
                                        $sql = "select * from categories";
                                        $result = mysqli_query($conn, $sql);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $cat_title = $row['cat_title'];
                                            $cat_id = $row['cat_id'];
                                            if ($category == $cat_id) {
                                                echo "<option selected='selected' value='$category'>$cat_title</option>";
                                            } else {
                                        ?>
                                        <option value="<?php echo $cat_id; ?>"><?php echo $cat_title; ?></option>
                                        <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Status</label>
                                    <select name="status" class="form-control">
                                            <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                            <?php  
                                                if ($status === "published") {
                                                    echo "<option value='draft'>Draft</option>";
                                                } else {
                                                    echo "<option value='published'>Published</option>";
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Image</label>
                                    <img width="100" src="../images/<?php echo $image; ?>" alt="image">
                                    <input type="hidden" name="old_image" value="<?php echo $image; ?>">
                                    <input type="file" name="image">
                                </div>
                                <div class="form-group">
                                    <label for="title">Post Tags</label>
                                    <input type="text" class="form-control" name="tags" value="<?php echo $tags; ?>">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                </div><div class="form-group">
                                    <label for="title">Post Content</label>
                                    <textarea name="content" id="" cols="30" rows="10" class="form-control"><?php echo str_replace('\r\n', '</br>', $content); ?></textarea>
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
