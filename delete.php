<?php
	
	include 'dbconn.php';
	
	if($_SERVER["REQUEST_METHOD"] == "GET") {
		
		$photoid = $_GET['photo'];
		
		$sql = "select photouri
					from photos
					where photoid = $photoid";
			
		$results = $conn->query($sql);
			
		while($row = $results->fetch_assoc()) {
				
			$photouri = $row['photouri'];
		}
		
		$sql = "delete from photos
				where photoid = $photoid";
		
		$results2 = $conn->query($sql);
		
		if($results2) {
			
			unlink(getcwd()."/".$photouri);
			header("location: dashboard.php");
		}
	}
?>