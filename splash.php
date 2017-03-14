<?php
	
	session_start();
?>

<!DOCTYPE html>

<?php

	include 'connection.php';
	
	$error = false;
	$email = $pass = $errorText = "";

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($_POST["email"])) {
			
			$errorText = "Enter your email address";
			$error = true;
		} else {
			
			$email = test_input($_POST["email"]);
		}
		
		if(empty($_POST["password"])) {
			
			$errorText = "Enter your password";
			$error = true;
		} else {
			
			$pass = test_input($_POST["password"]);
		}
		
		if($userid = userExists(getConn(), $email, $pass)) {
			
			$_SESSION["userid"] = $userid;
			header("Location: dashboard.php");
		} else {
			
			$errorText = "Wrong email or password!";
			$error = true;
		}
	}
	
	if(isset($_SESSION["userid"])) {
		
		header("location: dashboard.php");
	}
?>

<html lang="en-US">

	<head>
		<title>PhotoApp</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<script src="bootstrap/css/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>

		<div class="login-container">
			
			<form action="splash.php" method="post" />
			
				<input type="email" class="email-login" name="email" size="20" maxlength="30" placeholder="E-mail" required /><br />
				<input type="password" class="pass-login" name="password" size="20" maxlength="30" placeholder="Password" required /><br />
				<button class="btn btn-primary btn-block" type="submit">Submit</button>
			</form>
		</div>
		
		<p class="account-link">Don't have an account? <a href="signup.php"><strong>Create one!</strong></a></p>
		
		<?php 
			if($error) {
							
				echo '<div class="alert-login alert alert-danger fade in">';
				echo $errorText;
				echo '</div>';
			}
		?>
	</body>
</html>