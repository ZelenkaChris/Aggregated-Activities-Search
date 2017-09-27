<?php
	include("dbconnect.php");
	include("CommonLogin.php");

	if ($login_success == 1)
		$username = $_SESSION['username'];
	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>CS160 | Educational Tools</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">CS160S2G4</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="forums"/>Forums</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Discover Activities<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="browse.php">Browse</a></li>
						<li><a href="search.php">Search</a></li>
						<li><a href="#">On-Track Learning</a></li>
                        <li class="divider"></li>
						<li class="dropdown-header">Topic Specific</li>
                        <li><a href="search.php?category=Physics">Physics</a></li>
						<li><a href="search.php?category=Biology">Biology</a></li>
                        <li><a href="search.php?category=Chemistry">Chemistry</a></li>
						<li><a href="search.php?category=Earth Science">Earth Science</a></li>
                        <li><a href="search.php?category=Math">Math</a></li>
					</ul>
				</li>
				<li><a href="about.php">About</a></li>
			</ul>
						<?php
							if ($login_success == 1) {
								echo "<ul class=\"nav navbar-nav\"><li class=\"dropdown\"><a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-expanded=\"false\">My Stuff<span class=\"caret\"></span></a><ul class=\"dropdown-menu\" role=\"menu\"><li class=\"dropdown-header\">$username</li>
								<li><a href=\"profile.php\">Your Profile</a></li>
								<li><a href=\"logout.php\">Logout</a></li>
								</ul></li></ul>";
							}
							elseif ($login_success == 0) {
								$_SESSION["fail"] = true;
								echo "<meta http-equiv=\"refresh\" content=\"1;url=login.php\">
								<script type=\"text/javascript\">
								window.location.href = \"login.php\"
								</script>";
							}
						?>
			<?php
          $form = "<form class=\"navbar-form navbar-right\" method=\"post\">
            <div class=\"form-group\">
              <input type=\"email\" placeholder=\"Email\" name=\"email\" class=\"form-control\">
            </div>
            <div class=\"form-group\">
              <input type=\"password\" placeholder=\"Password\" name=\"password\" class=\"form-control\">
            </div>
            <button type=\"submit\" name=\"submit\" class=\"btn btn-danger\">Sign in</button>
			<a href=\"registration.php\"><button type=\"button\" class=\"btn btn-primary\">Register</button></a>
          </form>";
		  
			if ($login_success == 1) {
				echo "<form class=\"navbar navbar-right\"><h3><a href=\"logout.php\"><span class=\"label label-default\">Not $username?</span></a></h3></form>";
			}
			else
				echo $form;
		  ?>
        </div><!--/.navbar-collapse -->
      </div>
	  </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Discover the Educational Power!</h1>
        <p>Free Internet based lessons and activities for K-12 teachers, students and families looking to bring exciting new content into their education! Browse hundreds of free lessons and tools.</p>
        <p><a class="btn btn-primary btn-lg" href="browse.php" role="button">Browse content &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
	  <h2>Activity Samples</h2>
      <div class="row">
		<?php
			$i = 0;
			// GET # ROWS //
			$results = mysqli_query($conn, "SELECT * FROM education");
			$num_rows = mysqli_num_rows($results);
			while ($i < 9) {
				$index = rand(1, $num_rows-1);
				$query = "SELECT * FROM education WHERE id LIKE $index";
				$results = mysqli_query($conn, $query);
				$row = $results->fetch_assoc();
				if ($row["lesson_image"] == null)
					$img = "img/noimage.png";
				else
					$img = $row["lesson_image"];

				echo "<div class=\"col-md-4\"><h2><a href=\"".$row["lesson_link"] ."\" target=\"_blank\"></h2><div class=\"thumbnail\"><img data-holder-rendered=\"true\" src=\"$img\" style=\"width: 260px; height: 200px;\" class=\"img-thumbnail\"></a><div class=\"caption\"><h3><a href=\"".$row["lesson_link"] ."\" target=\"_blank\">". $row["title"]."</h3></a><p>".$row["description"]."</p></div></div></div>";
				$i = $i + 1;
				if ($i%3 == 0)
					echo "</div><div class=\"row\">";
			}
			echo "</div>";
		?>
      <hr>

      <footer>
        <p>&copy; EduPower 2014 - <?php echo date("Y") ?></p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
