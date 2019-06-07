<?php
require "db_connect.php";
session_start();
if (!isset($_SESSION) || empty($_SESSION['u_id'])){
	header("Location: ./login.php");
}

if (isset($_POST['logout'])) {
	session_destroy();
	header("Location: ./login.php");
}

$url_link = "";
$url_description = "";
$url_category = "";

if (isset($_POST['url_link']) && isset($_POST['url_category'])){
	$query = "UPDATE urls SET url_link = '".$_POST['url_link']."', url_description='".$_POST['url_description']."', url_category='".$_POST['url_category']."', u_id=".$_SESSION['u_id']." WHERE url_id='".$_GET['url_id']."'";
	mysqli_query($db, $query);
	header("location: index.php");
}
else if (isset($_GET['url_id'])){
	if(isset($_POST['DeleteBTN'])){
		$query = "DELETE FROM urls WHERE url_id=".$_GET['url_id'];
		mysqli_query($db, $query);
		header("location: index.php");
	}
	else {
		$query = "SELECT * FROM urls WHERE url_id=".$_GET['url_id'];
		$result = mysqli_query($db,$query);
		$count = mysqli_num_rows($result);

		if($count == 1) {
			$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
			$url_link = $row['url_link'];
			$url_description = $row['url_description'];
			$url_category = $row['url_category'];
		}
	}
}
else {
	header("location: index.php");
}
?>
<html>
<head>
	<title>URL Collection</title>
	<script src="jquery-3.3.1.min.js"></script> 
</head>
<body>
	Logged as user ID: <?php echo $_SESSION['u_id']; ?> <form action="#" method="POST"><input type="submit" name="logout" value="Logout"></form>
	<br><br>
	<form action="#" method="POST">
		<h3>Edit URL</h3>
		<p>URL Link</p><input type="textbox" value="<?php echo $url_link; ?>" name="url_link">
		<p>URL Description</p><input type="textbox" value="<?php echo $url_description; ?>" name="url_description">
		<p>URL Category</p><input type="textbox" value="<?php echo $url_category; ?>" name="url_category"><br><br>
		<input type="submit" value="Save">
	</form><form action="#" method="POST"><input type="submit" value="Delete" name="DeleteBTN"></form><a href="index.php"><input type="button" value="Return"></a>
	
</body>
</html>