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

    <title>CS160 | Browse Educational Tools</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/grid.css" rel="stylesheet">
	<link href="css/bluetable.css" rel="stylesheet">
	<link href="css/search.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="js/jquery.tablesorter.js"></script>
	
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script>
		$(document).ready(function() { 
			// call the tablesorter plugin 
			$("table").tablesorter({
				widgets: ['zebra'],
				headers: {
					0: { sorter: false }
				}
			}); 
			}
		);
	</script>
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
				<li class="dropdown active">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Discover Activities<span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li class="active"><a href="browse.php">Browse</a></li>
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
        <h1>Browse Activities</h1>

            <form id="custom-search-form" class="form-search form-horizontal pull-right" action="search.php" method="GET">
                <div class="input-append span12">
                    <input type="text" class="search-query mac-style" name="search" placeholder="Search">
                    <button type="submit" class="btn"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </div>
            </form>
	</div>
      </div>

    <div class="container"> 
	  <?php
		// USER INPUT CHECKING //
		if (isset($_GET["limit"]) && is_numeric($_GET["limit"]))
			$limit = htmlentities($_GET["limit"]);
		else
			$limit = 10;
		
		if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
			$page = htmlentities($_GET["page"]);
			if ($page == 1)
				$offset = 0;
			else
				$offset = $page*$limit;
		}
		else {
			$page = 1;
			$offset = 0;
		}
		// //
		// GET # ROWS //
		$results = mysqli_query($conn, "SELECT * FROM education");
		$num_rows = mysqli_num_rows($results);
		
		// CHECK PAGE LIMIT //
		$page = abs($page);
		$currPage = $page;
		$pageLimit = floor($num_rows/$limit);
		$prevPage = $page-1;
		$loop = 0;
		if ($currPage > $pageLimit) {
			echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Uh oh!</strong> We couldn't find any more activities!</div>";
			$page = floor($pageLimit-4);
			echo "<ul class =\"pagination\"><li><a href=\"browse.php?page=$prevPage&limit=$limit\">←</a></li>";
			while ($loop < 5) {
				if ($currPage == $page)
					echo "<li class=\"active\"><a href=\"browse.php?page=$page&limit=$limit\">$page</a></li>";
				else
					echo "<li><a href=\"browse.php?page=$page&limit=$limit\">$page</a></li>";
				$page++;
				$loop++;
			}
			echo "</ul>"; 
		}
		else {	
			// SQL prepared statements //		
			$stmt = $conn->prepare("SELECT title, description, lesson_link, lesson_image, category, student_grades, author, content_type, rating FROM education LIMIT ? OFFSET ?");
			$stmt->bind_param('ii', $limit, $offset);
			if (!($stmt->execute())) {
				echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Uh oh!</strong> We couldn't find any activities!</div>";
			}
			else {
				$stmt->store_result();
				$stmt->bind_result($title, $description, $lesson_link, $lesson_image, $category, $student_grades, $author, $content_type, $rating);
				// DATA ROWS //
				echo "<table class=\"tablesorter\">
					<thead><tr>
						<th><div class=\"dropup\">
  <button class=\"btn btn-default dropdown-toggle\" type=\"button\" id=\"dropdownMenu2\" data-toggle=\"dropdown\" aria-expanded=\"true\">
    # of Results: $limit
    <span class=\"caret\"></span>
  </button>
  <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"dropdownMenu2\">
    <li "; if ($limit == 10) { echo "class=\"active\" ";} echo "role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"browse.php?page=1&limit=10\">10</a></li>
    <li "; if ($limit == 25) { echo "class=\"active\" ";} echo "role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"browse.php?page=1&limit=25\">25</a></li>
    <li "; if ($limit == 50) { echo "class=\"active\" ";}  echo "role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"browse.php?page=1&limit=50\">50</a></li>
    <li "; if ($limit == 100) { echo "class=\"active\" ";} echo "role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"browse.php?page=1&limit=100\">100</a></li>
  </ul>
</div></th>
						<th>Title</th>
						<th>Description</th>
						<th>Category</th>
						<th>Type</th>
					</tr></thead>
					<tbody>";
				while ($stmt->fetch()) {
					if ($lesson_image == null)
						$lesson_image = "img/noimage.png";

						
					echo	"<tr><td><a href=\"$lesson_link\" target=\"_blank\"><img data-holder-rendered=\"true\" src=\"$lesson_image\" style=\"width: 200px; height: 200px;\" class=\"img-thumbnail\"></a></td>
						<td>$title</td>
						<td>$description</td>
						<td>$category</td>
						<td>$content_type</td>
						</tr>";
				}
				echo "</tbody></table>";
				$stmt->close();
				// END DATA ROWS //
			}
				// PAGINATION //
				if ($currPage == 1) { $page = abs($page); }
				elseif ($currPage == 2) { $page=abs($page-1); }
				else { $page = abs($page-2); }
				$nextPage = $currPage+1;
				echo "<ul class =\"pagination\">";
				if ($currPage != 1) {
					echo "<li><a href=\"browse.php?page=1&limit=$limit\">←</a></li>";
				}
				while ($loop < 5) {
					if ($currPage == $page)
						echo "<li class=\"active\"><a href=\"browse.php?page=$page&limit=$limit\">$page</a></li>";
					elseif ($page <= $pageLimit)
						echo "<li><a href=\"browse.php?page=$page&limit=$limit\">$page</a></li>";
					$page++;
					$loop++;
				}
				if ($currPage != $pageLimit)
					echo "<li><a href=\"browse.php?page=$pageLimit&limit=$limit\">→</a></li>";
				echo "</ul>";
				// END PAGINATION //
			}		
		// END LIMIT CHECK //
	  ?>
	  
      <footer>
        <p>&copy; EduPower 2014 - <?php echo date("Y") ?></p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
