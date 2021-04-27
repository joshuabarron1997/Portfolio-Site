<?php
session_start();
if (isset($_SESSION["validUser"])){
	if ($_SESSION["validUser"] == true){
		header( 'Location: adminPanel.php');
		exit();
	}
}else {
	$_SESSION["validUser"] = false;
}
$in_username = "";
$in_password = "";
$loginERR = "";
if (isset($_POST["submit"])){
	require 'dbConnect.php';
	
	try{
		$in_username = $_POST["username"];
		$in_password = $_POST["password"];
		$usernameReal = "";
		$passwordReal = "";
		$sql = 'SELECT * FROM event_user WHERE event_user_name = :u AND event_user_password = :p';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam('u', $in_username);
		$stmt->bindParam('p', $in_password);
		$stmt->execute();
		$succ = $stmt->rowCount();
		if ($succ == 1){
			while ($row = $stmt->fetch()){
				$usernameReal = $row["event_user_name"];
				$passwordReal = $row["event_user_password"];
			}
			if ($in_username == $usernameReal && $in_password == $passwordReal){

				$_SESSION["validUser"] = true;
				header( 'Location: adminPanel.php?user='.$in_username);
				echo "success";
			}else{
				$loginERR = "wrong username or password";
			}
		}else{
			$loginERR = "wrong username or password";
		}	
	}catch(PDOException $e){
		$loginERR = "Connection failed: " . $e->getMessage();
	}
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Log In</title>
<link rel = "stylesheet" type = "text/css" href = "css/login.css">
</head>

<body>
	<a href = "index.html"><div id = "nav">Go Back</div></a>
	<div id = "allContent">	
		<div id = "container">
			<form action = "login.php" method = "post">
				<h1>Login</h1>
				<p>Username <input type = "text" name = "username" value = "<?php echo $in_username;?>" ></p>
				<p>Password <input type = "text" name = "password" value = "<?php echo $in_password;?>" ></p>
				<p class = "btn"><input type = "submit" value = "submit" name = "submit"><input type = "reset" value = "reset"></p>
				<p id = "msg"> <?php echo $loginERR;?></p>
			</form>
		</div>
	</div>
</body>
</html>