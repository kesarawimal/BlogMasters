<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
 
    <!-- Page Content -->
	
	<div class="container">
	    <div class="row">
	        <div class="col-xs-12">
	            <div class="error-template">
	                <h1>
	                    Oops!</h1>
	                <h2>
	                    404 Not Found</h2>
	                <div class="error-details">
	                    Sorry, an error has occured, Requested page not found!
	                </div>
	                <div class="error-actions">
	                    <a href="index.php" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
	                        Take Me Home </a><a href="contact.php" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

        <hr>

<?php include "includes/footer.php";?>
