                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php
                            $username = $_SESSION['username'];
                            $sql = "SELECT * from posts WHERE post_author = '$username'";
                            $result = mysqli_query($conn, $sql); 
                            $post_count = mysqli_num_rows($result);
                        ?>
                  <div class='huge'><?php echo $post_count; ?></div>
                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php  
                            $com_count = 0;
                            $username = $_SESSION['username'];
                            $sql = "SELECT post_id FROM posts where post_author = '$username'";
                            $result = mysqli_query($conn, $sql);
                            db_error($result);
                            while ($rows = mysqli_fetch_assoc($result)) {
                                $post_id = $rows['post_id'];
                                $sql = "SELECT * FROM comments WHERE com_post_id = $post_id";
                                $results = mysqli_query($conn, $sql);
                                db_error($results);
                                $com_count = $com_count + mysqli_num_rows($results);
                            }
                        ?>
                     <div class='huge'><?php echo $com_count; ?></div>
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-inbox fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                      <?php  
                           $username = $_SESSION['username'];
                            $sql = "SELECT * FROM messages where mgs_author = '$username'";
                            $result = mysqli_query($conn, $sql); 
                            $count_messages = mysqli_num_rows($result);
                      ?>  
                    <div class='huge'><?php echo $count_messages; ?></div>
                        <div> Messages</div>
                    </div>
                </div>
            </div>
            <a href="inbox.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <?php  
                            $id = $_SESSION['id'];
                            $sql = "SELECT * from categories WHERE cat_user_id = $id";
                            $result = mysqli_query($conn, $sql);  
                            $cat_count = mysqli_num_rows($result);
                        ?>
                        <div class='huge'><?php echo $cat_count; ?></div>
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->

                        <?php  //post view count
                            $post_view = 0;
                            $username = $_SESSION['username'];
                            $sql = "SELECT post_view_count FROM posts where post_author = '$username'";
                            $result = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $post_view = $post_view + $row['post_view_count'];
                            }
                        ?>
                        <?php  
                        // draft post count
                            $sql = "SELECT * from posts WHERE post_author = '$username' AND post_status = 'draft'";
                            $result_draft = mysqli_query($conn, $sql); 
                            $post_draft_count = mysqli_num_rows($result_draft);

                        // draft post count
                            $sql = "SELECT * from posts WHERE post_author = '$username' AND post_status = 'published'";
                            $result_published = mysqli_query($conn, $sql); 
                            $post_published_count = mysqli_num_rows($result_published);

                        // unapproved comment count
                            $com_unapprove_count = 0;
                            $username = $_SESSION['username'];
                            $sql = "SELECT post_id FROM posts where post_author = '$username'";
                            $result_unaprv = mysqli_query($conn, $sql);
                            db_error($result_unaprv);
                            while ($rows = mysqli_fetch_assoc($result_unaprv)) {
                                $post_id = $rows['post_id'];
                                $sql = "SELECT * FROM comments WHERE com_post_id = $post_id AND com_status = 'Unapproved'";
                                $results_unaprv = mysqli_query($conn, $sql);
                                db_error($results_unaprv);
                                $com_unapprove_count = $com_unapprove_count + mysqli_num_rows($results_unaprv);
                            }

                        // approved comment count
                            $com_approve_count = 0;
                            $username = $_SESSION['username'];
                            $sql = "SELECT post_id FROM posts where post_author = '$username'";
                            $result_aprv = mysqli_query($conn, $sql);
                            db_error($result_aprv);
                            while ($rows = mysqli_fetch_assoc($result_aprv)) {
                                $post_id = $rows['post_id'];
                                $sql = "SELECT * FROM comments WHERE com_post_id = $post_id AND com_status = 'Approve'";
                                $results_aprv = mysqli_query($conn, $sql);
                                db_error($results_aprv);
                                $com_approve_count = $com_approve_count + mysqli_num_rows($results_aprv);
                            }
                        ?>

                <!-- google chart -->

                <div class="row">
                      <script type="text/javascript">
                      google.charts.load('current', {'packages':['bar']});
                      google.charts.setOnLoadCallback(drawChart);

                      function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Data', 'Count'],
                          <?php  
                            $data = ['All Posts', 'Published Posts', 'Draft Posts', 'Comments', 'Unapproved Comments' ,'Messages', 'Post Views','Categories'];
                            $count = [$post_count,$post_published_count,$post_draft_count,$com_count,$com_unapprove_count,$count_messages,$post_view,$cat_count];
                            for ($i=0; $i < 8 ; $i++) { 
                                echo "['{$data[$i]}'" . "," . "{$count[$i]}],";
                            }
                          ?>
                           //['2014', 1000]
                        ]);

                         var options = {
                      chart: {
                        title: '',
                        subtitle: '',
                        }
                            };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                      }
                      </script>
                    <div id="columnchart_material" style="width: auto; height: 500px; overflow-x:scroll; overflow-y: hidden; padding-bottom:20px;"></div>
                </div>
