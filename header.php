<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<ul class="nav navbar-nav">
			<li><a href="dashboard.php">Home</a></li>
			<li><a href="#">Profile</a></li>
			<li><a href="upload.php">Upload</a></li>
		</ul>
		
		<?php
			if(isset($_SESSION["userid"])) {
				
				include 'dbconn.php';
				
				$uid = $_SESSION["userid"];
				
				$sql = "select first_name, last_name from users where userid = $uid";
				
				$results = $conn->query($sql);
				
				while($row = $results->fetch_assoc()) {
					
					$fn = $row['first_name'];
					$ln = $row['last_name'];
				}
				
				echo '<a href="#" class="btn navbar-btn navbar-right"><strong>'.$fn.' '.$ln.'</strong></a>';
				echo '<a href="logout.php" class="btn navbar-btn navbar-right"><strong>Log Out</strong></a>';
			}
		?>
	</div>
</nav>