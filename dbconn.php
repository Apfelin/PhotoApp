<?php
		
	$servername = "localhost";
	$dbname = "photoapp";
	$user = "root";
	$pass = "";
			
	$conn = new mysqli($servername, $user, $pass, $dbname);
		
	if($conn->connect_error) {
			
		die("Connection failed: " . $conn->connect_error);
	}
?>