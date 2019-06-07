<?php
require('db_connect.php');
session_start();
$error = "";
if (isset($_SESSION) && !empty($_SESSION['u_id'])){
	header("Location: ./index.php");
}
else if (isset($_POST['username']) && isset($_POST['password'])){
	$username = mysqli_real_escape_string($db,$_POST['username']);
    $password = mysqli_real_escape_string($db,$_POST['password']);
	
	$sql = "SELECT u_id FROM Users WHERE u_username = '$username' and  u_password = '$password'";
	$result = mysqli_query($db,$sql);

	$count = mysqli_num_rows($result);

	if($count == 1) {
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		$_SESSION['u_id'] = $row['u_id'];
		header("location: index.php");
	}else {
		$error = "Your Login Name or Password is invalid";
	}
}
?>
<html>
<head>
	<title>URL Collection</title>
</head>
<body>
	<div>
	<form action="#" method="POST">
	<p>User Login</p>
	<p>Username:</p>
	<input type="textbox" name="username">
	<p>Password:</p>
	<input type="password" name="password">
	<p><input type="submit" id="loginbtn" value="Login"></p>
	</form>
	</div>
	<div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
</body>
</html>