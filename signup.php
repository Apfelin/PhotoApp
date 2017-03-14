<?php
	
	include 'connection.php';
	
	session_start();
	
	$error = false;
	$succ = false;
	$errorText = $succText = $first_name = $last_name = $email = $password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(empty($_POST["first_name"])) {
			
			$error = true;
			$errorText = "Fill in your first name";
		} else {
			
			$first_name = test_input($_POST["first_name"]);
		}
		
		if(empty($_POST["last_name"])) {
			
			$error = true;
			$errorText = "Fill in your last name";
		} else {
			
			$last_name = test_input($_POST["last_name"]);
		}
		
		if(empty($_POST["email"])) {
			
			$errorText = "Enter your email address";
			$error = true;
		} else {
			
			$email = test_input($_POST["email"]);
		}
		
		if(empty($_POST["password"])) {
			
			$errorText = "Enter a password";
			$error = true;
		} else {
			
			$password = test_input($_POST["password"]);
		}
		
		if($userid = userExists(getConn(), $email, $password)) {
			
			$errorText = "User already exists!";
			$error = true;
		} else {
			
			$check = insertUser(getConn(), $first_name, $last_name, $password, $email);
			
			if($check) {
				
				$error = false;
				$succ = true;
				$succText = 'Account created succesfully! <a href="splash.php">Return to splash page</a>';
			} else {
				
				$error = true;
				$errorText = "User already exists!";
			}
		}
	}	
?>

<html>
	
	<head>
		<title>PhotoApp - Register</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<script src="bootstrap/css/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<div class="container-fluid register-container">
		
		<form action="signup.php" method="post">
		
			<div class="row">
					
				<input type="text" name="first_name" class="form-control" placeholder="First name" required />
			</div>
			
			<div class="row">
					
				<input type="text" name="last_name" class="form-control" placeholder="Last name" required />
			</div>
			
			<div class="row">
							
				<input type="email" name="email" class="form-control" placeholder="Email" required />
			</div>
			
			<div class="row">
				
				<input type="password" name="password" class="form-control" placeholder="Password" required />
			</div>
			
			<div class="row">

				<button type="submit" class="btn btn-primary btn-block">Create Account</button>
			</div>
			
			<div class="row">
				
				<?php
					if($error) {
						
						echo '<div class="col-md-4 danger-register">
							<div class="alert alert-danger">';
						echo $errorText;
						echo '</div>
							</div>';
					} else {
						
						if($succ) {
							
							echo '<div class="col-md-4 succ-register">
							<div class="alert alert-success">';
							echo $succText;
							echo '</div>
							</div>';
						}
					}
				?>
			</div>
		</form>