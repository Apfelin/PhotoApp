<?php
	
	function getConn() {
		
		$servername = "localhost";
		$dbname = "photoapp";
		$user = "root";
		$pass = "";
				
		$conn = new mysqli($servername, $user, $pass, $dbname);
			
		if($conn->connect_error) {
				
			die("Connection failed: " . $conn->connect_error);
		}
		
		return $conn;
	}
	
	function test_input($data) {
		
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		
		return $data;
	}
	
	function userExists($conn, $email, $pass) {
		
		$sql = "select userid " .
		 "from users " .
		 "where email like '$email' and password like '$pass';";
		 
		$result = $conn->query($sql);
		
		if($result->num_rows == 1) {
			
			while($row = $result->fetch_assoc()) {
				
				$userid = $row["userid"];
			}
			
			return $userid;
		} else {
			
			return 0;
		}
	}
	
	function insertFile($conn, $userid, $fileURI) {
		
		$sql = "insert into photos (userid, photouri) " .
			"values('$userid', '$fileURI');";
			
		return $conn->query($sql);
	}
	
	function getFiles($conn, $userid) {
		
		$sql = "select u.userid, u.first_name, u.last_name, p.photouri, p.photoid, count(l.photoid) as likes, count(ld.photoid) as liked
			from photos p join users u on p.userid = u.userid
						left join likes l on p.photoid = l.photoid
						left join (select ls.photoid
									from likes ls join users us on ls.userid = us.userid and ls.userid = $userid) ld on p.photoid = ld.photoid
			group by p.photoid
			order by likes desc, p.postdate desc
			limit 30";
		
		$results = $conn->query($sql);
		
		return $results;
	}
	
	function insertUser($conn, $fn, $ln, $pass, $email) {
		
		$sql = "insert into users (password, first_name, last_name, email) " .
			"values ('$pass', '$fn', '$ln', '$email')";
			
		$results = $conn->query($sql);	
		
		return $results;
	}
	
	function getComm($conn, $photoid) {
		
		$sql = "select u.first_name, u.last_name, c.text
			from users u join comments c on u.userid = c.userid
						join photos p on c.photoid = p.photoid
			where p.photoid = '$photoid'
			order by c.date";
		
		$results = $conn->query($sql);
		
		return $results;
	}
?>