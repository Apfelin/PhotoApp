<?php
	
	session_start();
	
	include 'connection.php';
	
	if(!isset($_SESSION["userid"])) {
		
		header("location: splash.php");
	}
			
	$results_photos = getFiles(getConn(), $_SESSION['userid']);
	$i = 0;
			
	while($row_photos = $results_photos->fetch_assoc()) {
		
		$results_comments = getComm(getConn(), $row_photos['photoid']);
		$comments = false;
		
		if($results_comments) {
			
			unset($comments);
			$comments = array();
			
			while($row_comments = $results_comments->fetch_assoc()) {
					
				$comments[] = $row_comments;
			}
		}
		
		$row_photos['comments'] = $comments;
		$photoarr[$i] = $row_photos;
		$i++;
	}
?>

<!DOCTYPE html>

<html lang="en-US">

	<head>
		<title>PhotoApp - Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
		<script src="bootstrap/css/bootstrap.min.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
	
		<?php include 'header.php'; ?>
		
		<div class="photos-container center-block">
			
			<?php for($i = 0; $i < count($photoarr); $i++) { ?>
				
				<div class="row">
					
					<div class="row img-container">
						
						<a href="<?php echo $photoarr[$i]['photouri']; ?>">
							<div class="image col-md-8" style="background-image: url(<?php echo $photoarr[$i]['photouri']; ?>);"></div>
						</a>
						
						<div class="user-info col-md-4">
							
							<h4 class="col-md-2 user-name"><?php echo $photoarr[$i]['first_name'], ' ', $photoarr[$i]['last_name']; ?></h4>
							<h4 class="col-md-2 user-likes">
								
								<?php if(!$photoarr[$i]['liked']) { ?>
									
									<a class="col-md-2 glyphicon glyphicon-thumbs-up" href="like.php?photo=<?php echo $photoarr[$i]['photoid']; ?>&user=<?php echo $_SESSION['userid']; ?>"></a>
								<?php } else { ?>
								
									<a class="col-md-2 glyphicon glyphicon-thumbs-down" href="like.php?photo=<?php echo $photoarr[$i]['photoid']; ?>&user=<?php echo $_SESSION['userid']; ?>"></a>
								<?php } ?>
							</h4>
							<h4 class="col-md-2"><?php echo $photoarr[$i]['likes'] ?> Likes</h4>
							<h4 class="col-md-2">
								
								<?php if($photoarr[$i]['userid'] == $_SESSION['userid']) { ?>
									
									<a href="delete.php?photo=<?php echo $photoarr[$i]['photoid']; ?>" class="glyphicon glyphicon-remove clik-dreapta-delet"></a>
								<?php } ?>
							</h4>
						</div>
						
						<div class="comments col-md-4">
								
							<?php for($j = 0; $j < count($photoarr[$i]['comments']); $j++) { ?>
											
										<div class="row">
											
											<p class="user col-md-3"><?php echo $photoarr[$i]['comments'][$j]['first_name'], ' ', $photoarr[$i]['comments'][$j]['last_name']; ?></p>
											<p class="comment col-md-9"><?php echo $photoarr[$i]['comments'][$j]['text']; ?></p>
										</div>
							<?php } ?>
						</div>
						
						<div class="row comm-container">
							
							<form action="comment.php" method="POST" class="add-comm">
								
								<input type="text" name="comment" class="form-inline col-md-3 comm-text" placeholder="Leave a comment!" />
								<input type="hidden" name="photoid" value="<?php echo $photoarr[$i]['photoid']; ?>" />
								<input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>" />
								<input type="submit" value="Post" class="form-inline btn btn-primary col-md-1 comm-btn" />
							</form>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		</div>
	</body>
</html>