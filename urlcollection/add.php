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

if (isset($_POST['url_link']) && isset($_POST['url_category'])){
	$query = "INSERT INTO urls (url_link, url_description, url_category, u_id) VALUES ('".$_POST['url_link']."','".$_POST['url_description']."','".$_POST['url_category']."',".$_SESSION['u_id'].")";
	mysqli_query($db, $query);
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
		<h3>Add new URL</h3>
		<p>URL Link</p><input type="textbox" value="" name="url_link">
		<p>URL Description</p><input type="textbox" value="" name="url_description">
		<p>URL Category</p><input type="textbox" value="" name="url_category"><br><br>
		<input type="submit" value="Save"> <a href="index.php"><input type="button" value="Return"></a>
	</form>
</body>
</html>