<?php

	include 'dbconn.php';
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$userid = $_POST["userid"];
		$photoid = $_POST["photoid"];
		$comment_text = $_POST["comment"];
		
		$sql = "insert into comments (userid, photoid, text)
				values ('$userid', '$photoid', '$comment_text')";
		
		$result = $conn->query($sql);
		
		header("location: dashboard.php");
	}				
?>