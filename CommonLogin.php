<?php
	require("PasswordHash.php"); // because we are stuck on 5.2 which lacks blowfish cipher in 5.3 and native crypto in 5.5
	session_start();
	$login_success = -1;
	$hasher = new PasswordHash(8, false);
	if (isset($_POST['submit'])) {
		if (!(empty($_POST['email']) && (empty($_POST['password'])))) {
			$username = htmlentities($_POST['email']);
			$password = htmlentities($_POST['password']);
					
			$stmt = $conn->prepare("SELECT * FROM `registrationdb` WHERE username LIKE ?");
			$stmt->bind_param('s', $username);
			if (!($stmt->execute())) {
				$login_success = 0; // fail: invalid username, don't tell user
			}
			else {
				$stmt->store_result();
				$stmt->bind_result($db_username, $db_hashedpwd, $timestamp);
			}
			$stmt->fetch();
			if ($hasher->CheckPassword($password, $db_hashedpwd)) {
				$login_success = 1;
				$_SESSION['loggedIn'] = true;
				$_SESSION['username'] = $username;
			}
			else {
				$login_success = 0; // fail: bad password, don't tell user
			}
			$stmt->close();
		}
	}
	elseif (isset($_SESSION['loggedIn'])) {
		if ($_SESSION['loggedIn']) {
			$username = $_SESSION['username'];
			$login_success = 1;
		}
	}
	
?>