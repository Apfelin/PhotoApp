<?php

	session_start();
?>

<!DOCTYPE html>

<?php

	include 'connection.php';
	
	$uploadErr = "";
	$uploadOk = 1;
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$target_dir = "userPhotos/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		
		if($check !== false) {
			
			$uploadOk = 1;
		} else {
			
			$uploadOk = 0;
			$uploadErr = "File is not an image";
		}
		
		if(file_exists($target_file)) {
		
		$uploadOk = 0;
		}
	
		if($_FILES["fileToUpload"]["size"] > 25000000) {
			
			$uploadOk = 0;
			$uploadErr = "File is too big (max. 25MB)";
		}
	
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			
			$uploadOk = 0;
			$uploadErr = "File type should be .jpg, .jpeg, or .png";
		}
	
		if($uploadOk == 1) {
			
			if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) && insertFile(getConn(), $_SESSION["userid"], $target_file)) {
				
				$uploadErr = "File uploaded succesfully";
				
			} else {
				
				$uploadErr = "Failed to upload file";
				echo $_SESSION["userid"];
			}
		}
	}
	
	if(!isset($_SESSION["userid"])) {
		
		header("location: splash.php");
	}
?>

<html lang="en-US">

	<head>
		<title>PhotoApp - Upload</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<script src="bootstrap/css/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
		
		<?php include 'header.php' ?>
			
		<div class="up-container">
			<form action="upload.php" method="POST" enctype="multipart/form-data">
				
				<input name="fileToUpload" class="up-file" type="file" />
				<button class="btn btn-primary btn-block" type="submit">Upload</button>
			</form>
		</div>
		
		<?php if(!$uploadOk) {
						
			echo '<div class="alert alert-danger up-alert">';
			echo $uploadErr;
			echo '</div>';
		} else {
			
			echo '<div class="alert alert-success up-alert">';
			echo $uploadErr;
			echo '</div>';
		}
		?>
	</body>
</html>