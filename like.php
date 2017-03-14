<?php

	include 'dbconn.php';
	
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		
		$userid = $_GET['user'];
		$photoid = $_GET['photo'];
		
		$sql = "insert into likes (userid, photoid)
				values ($userid, $photoid)";
				
		$results = $conn->query($sql);
		
		if($results) {
			
			header("location: dashboard.php");
		} else {
			
			if($conn->errno == 1062) {
				
				$sql = "delete from likes
						where userid = $userid and photoid = $photoid";
						
				$results = $conn->query($sql);
				
				header("location: dashboard.php");
			}
		}
	}
?>