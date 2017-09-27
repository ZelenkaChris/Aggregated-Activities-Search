<?php
	include("dbconnect.php");
	include("CommonLogin.php");

	$status = -1;
	
	if ($login_success == 1)
		$username = $_SESSION['username'];
	
	if (isset($_GET["search"]) && (!(empty($_GET["search"])))) {
		$name = htmlentities($_GET["search"]);
		$status = 1;
	}
	elseif (isset($_GET["category"]) && (!(empty($_GET["category"])))) {
		$categorytype = htmlentities($_GET["category"]);
		$searchterms = $categorytype;
		$status = 1;
	}
		
	
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

    <title>CS160 | Search Educational Tools</title>

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
        <h1>Search Activities</h1>
	<div class="row">
		<div class="col-md-12">
        <form role="form" method = "get" >
            <div class="input-group" id="adv-search">
                <input type="text" class="form-control" name="search"
				<?php if($status == 1) { echo "placeholder=\"$searchterms\""; } else { echo "placeholder=\"Search for activities\""; }  ?>/>
                <div class="input-group-btn">
                    <div class="btn-group" role="group">
                        <div class="dropdown dropdown-lg">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <form class="form-horizontal" role="form" method="get" action="search.php?detailSearch">
                                  <div class="form-group">
                                    <label for="filter">Filter by</label>
                                    <select class="form-control">
                                        <option value="0" selected>All Snippets</option>
                                        <option value="1">Featured</option>
                                        <option value="2">Most popular</option>
                                        <option value="3">Top rated</option>
                                        <option value="4">Most commented</option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="contain">Author</label>
                                    <input class="form-control" type="text" />
                                  </div>
                                  <div class="form-group">
                                    <label for="contain">Contains the words</label>
                                    <input class="form-control" type="text" />
                                  </div>
                                  <input type="button"  class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></input>
                                </form>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                       </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
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
		$name;
		$dname;
		//search submitted  //			

		// CHECK PAGE LIMIT //
		$currPage = $page;
		$pageLimit = floor($num_rows/$limit);
		$prevPage = $page-1;
		$loop = 0;
		if ($status == 1) {
			if ($currPage > $pageLimit) {
				echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Uh oh!</strong> We couldn't find any more activities!</div>";
			}
			else {	
				// SQL prepared statements //
				if(!(empty($categorytype))){
					$categorysearch = "%$categorytype%";
					$stmt = $conn->prepare("SELECT title, description, lesson_link, lesson_image, category, student_grades, author, content_type, rating FROM education WHERE category LIKE ? ORDER BY category LIMIT ? OFFSET ?");
					$stmt->bind_param('sii', $categorysearch ,$limit, $offset);
				}
				elseif (!(empty($name))){
					$dname = "%$name%";
					$stmt = $conn->prepare("SELECT title, description, lesson_link, lesson_image, category, student_grades, author, content_type, rating FROM education WHERE title LIKE ? OR  description LIKE ? OR category LIKE ? OR author LIKE ? OR content_type LIKE ? ORDER BY title LIMIT ?  OFFSET ?");
					$stmt->bind_param('sssssii' , $dname , $dname, $dname, $dname, $dname, $limit, $offset);
				}
				if (!($stmt->execute())) {
					echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Uh oh!</strong> We couldn't find any activities!</div>";
				}
				else {
					$stmt->store_result();
					$stmt->bind_result($title, $description, $lesson_link, $lesson_image, $category, $student_grades, $author, $content_type, $rating);
					// DATA ROWS //
				echo "<table class=\"tablesorter\">
						<thead><tr>
							<th></th>
						<th>Title</th>
						<th>Description</th>
						<th>Category</th>
						<th>Type</th>
					</tr></thead>
					<tbody>";
					$count = 1;
					while ($stmt->fetch()) {
						if ($lesson_image == null)
							$lesson_image = "img/noimage.png";

							
					echo	"<tr><td><a href=\"$lesson_link\" target=\"_blank\"><img data-holder-rendered=\"true\" src=\"$lesson_image\" style=\"width: 200px; height: 200px;\" class=\"img-thumbnail\"></a></td>
						<td>$title</td>
						<td>$description</td>
						<td>$category</td>
						<td>$content_type</td>
						</tr>";
						$count++;
					}
					echo "</tbody></table>";
					$stmt->close();
					// END DATA ROWS //
				}
					///PAGINATION //
					if ($count >= $limit) {
						if ($currPage == 1) { $page; }
						elseif ($currPage == 2) { $page=$page-1; }
						else { $page = $page-2; }
						$nextPage = $currPage+1;
						echo "<ul class =\"pagination\">";
						if ($currPage != 1) {
							echo "<li><a href=\"search.php?page=$prevPage&limit=$limit&"; if (isset($name)) { echo "search=$name"; } else { echo "$categorytype=$categorytype"; } echo "\">←</a></li>";
						}
						while ($loop < 5) {
							if ($currPage == $page) {
								echo "<li class=\"active\"><a href=\"search.php?page=$page&"; if (isset($name)) { echo "search=$name"; } else { echo "category=$categorytype"; } echo "\">$page</a></li>"; 
							}
							else {
								echo "<li><a href=\"search.php?page=$page&limit=$limit&"; if (isset($name)) { echo "search=$name"; } else { echo "category=$categorytype"; } echo "\">$page</a></li>";
							}
							$page++;
							$loop++;
						}
						echo "<li><a href=\"search.php?page=$nextPage&limit=$limit&"; if (isset($name)) { echo "search=$name"; } else { echo "category=$categorytype"; } echo "\">→</a></li></ul>";
						// END PAGINATION //
					}
				}		
			// END LIMIT CHECK //
		}
		elseif ($status == 0)
			echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Uh oh!</strong> We couldn't find any activities!</div>";
	
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
