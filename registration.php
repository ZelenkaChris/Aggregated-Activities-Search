<?php
	include("dbconnect.php");
	require("PasswordHash.php"); // because we are stuck on 5.2 which lacks blowfish cipher in 5.3 and native crypto in 5.5
	$reg_success = -1;

	if (isset($_POST['submit'])) {
		$hasher = new PasswordHash(8, false);
		$username = htmlentities($_POST['email']);
		$password = htmlentities($_POST['password']);
	
		$hashed_pwd = $hasher->HashPassword($password);
		if (strlen($hashed_pwd) >= 20) {
			// begin sql insertion
			if (!($stmt = $conn->prepare("INSERT INTO `registrationdb` (username, password, timestamp) VALUES (?, ?, ?)"))) {
				// echo "Preperation failed " . $stmt->error;
			}
			// bind variables
			if (!($stmt->bind_param("ssi", $username, $hashed_pwd, time()))) {
				// echo "Binding failed " . $stmt->error;
			}
			// execute sql statement
			if (!($stmt->execute())) {
				$reg_success = 0;
			}
			else
				$reg_success = 1;
			// close query
			$stmt->close();
			$reg_succecss = 1;
		}
		else
			$reg_success = 0;
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
    <link rel="icon" href="../../favicon.ico">

    <title>Register to Our Educational Mashup</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
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
        </div><!--/.navbar-collapse -->
      </div>
	  </div>
    </nav>
  
    <div class="container">
      <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Account Registration</h2>
		<?php
		$form = "<label for=\"inputEmail\" class=\"sr-only\">Email address</label>
        <input type=\"email\" name=\"email\" id=\"inputEmail\" class=\"form-control\" placeholder=\"Email address\" required autofocus>
        <label for=\"inputPassword\" class=\"sr-only\">Password</label>
        <input type=\"password\" name=\"password\" id=\"inputPassword\" class=\"form-control\" placeholder=\"Password - 6 characters min\" pattern=\".{6,72}\" required>
        <input class=\"btn btn-lg btn-primary btn-block\" id=\"submit\" type=\"submit\" name=\"submit\" value=\"Register\"></input>";
			if ($reg_success == -1) {
				echo $form;
			}
			elseif ($reg_success == 0) {
				echo "<div class=\"alert alert-danger\" role=\"alert\"><strong>Uh oh!</strong> The username you have chosen is already taken: $username</div>";
				echo $form;
			}
			else {
				echo "<div class=\"alert alert-success\" role=\"alert\"><strong>Awesome!</strong> You are now registered!</div>";
			}
		?>
      </form>

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
