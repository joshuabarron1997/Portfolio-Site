<?php
	require_once("email.class.php");
	$status = "";
	//self posting variables
	$name = "";
	$email = "";
	$reason = "";
	$message = "";
	//self posting errors
	$nameERR = "";
	$emailERR = "";
	$messageERR = "";
if (isset($_POST['submit'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$reason = $_POST['reason'];
	$message = $_POST['message'];
	
	//validation
	$validPost = true;
	
	//name
	$name = filter_var($name);
	if (!empty($name)){
		if (!is_numeric($name)){
			//success
			$nameERR = "";
		}
		else {
			//failure to validate
			$nameERR = "Please use non-numerics";
			$validPost = false;
		}
	}
	else {
		$nameERR = "Please enter a name";
	}
	//email
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	if (!empty($email)){
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			//success
			$emailERR = "";
		}
		else {
			//failure to validate
			$emailERR = "Invalid E-mail Address";
			$validPost = false;
		}
	}
	else {
		//failure to validate
		$emailERR = "Please Enter a E-mail Address";
		$validPost = false;
	}
	//message
	$message = filter_var($message);
	if (!empty($message)){
		if (filter_var($message)){
			//success
			$messageERR = "";
		}
		else{
			//failure to validate
			$messageERR = "Invalid characters in message";
			$validPost = false;
		}
	}
	else {
		//failure to validate
		$messageERR = "Please Enter a Message";
		$validPost = false;
	}
	//honeypot check
	$honeypot = $_POST['nameLast'];
	if(!empty($honeypot)){
		$validPost = false;
	}
	//delivery
	if($validPost){
		$mail = new ContactForm();
		$mail->setName($name);
		$mail->setEmail($email);
		$mail->setReason($reason);
		$mail->setMessage($message);
		
		if ($mail->sendContact()){
			$mail->sendConfirmation();
			$status = "success";
		}
		else {
			$status = "failure";
		}	
	}
	else {
		$status = "failure";
	}
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Contact</title>
</head>

<body>
</body>
</html><!doctype html>
<html>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
<meta charset="utf-8">
<title>Portfolio</title>
	<script src = "js/main.js"></script>
	<link href = "css/main.css" rel = "stylesheet" type = "text/css"/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<style>
		#contact form {
			margin: 0px auto 0px auto;
			padding: 25px;
			width: 80%;
			text-align: left;
		}
		#contact form table {
			margin: 0 auto 0 auto;
			width: 75%;
		}
		#contact {
			margin: 15px auto 15px auto;
			width: 70%;
			background-color: #d3d6cd;
		}
		.form-buttons {
			width: 40%;
			margin: 0 auto 0 auto;
			display: flex;
			flex-direction: row;
			justify-content: space-around;
		}
		.successMessage {
			margin: 10px auto 10px auto;
			text-align: center;
			width: 50%;
			background-color: lightgreen;
			color: black;
			border: black solid 2px;
		}
		.failureMessage {
			margin: 10px auto 10px auto;
			text-align: center;
			width: 50%;
			background-color: pink;
			color: black;
			border: black solid 2px;
		}
		.error {
			color: red;
			font-weight: bold;
		}
		.hide {
			display: none;
		}
		input {
			margin: 5px 0px 5px 0px;
		}
		@media only screen and (max-width: 991px){
			#contact {
				width: 100%;
				background-color: #d3d6cd;
			}
		}
		@media only screen and (max-width: 500px){
			.form-buttons {
				flex-direction: column;
			} 
		}
		
	</style>
	<script>
	function bodyInit(){
		$("#card1").flip()
		$("#card2").flip()
		$("#card3").flip()
	}
	</script>
</head>
<body id = "top" onLoad="bodyInit()">
	<nav class="nav navbar navbar-expand-lg navbar-light bg-light">
		<div class = "nav-margin">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
		
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
					<a class="nav-link" href = "index.html">Home</a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href = "index.html#about">About Me</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "projects.html">Portfolio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "index.html#resume">Resume</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "contact.php">Contact</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "https://github.com/joshuabarron1997" target="_blank">Github</a>
					</li>
				</ul>
			</div>
		</div>
	  </nav>
	<div id = "contact">
	<?php if ($status == "success"){ ?>
		<div class = "successMessage">
			<p>Contact Sent Successfully. I will reach out to you as soon as I can.</p>.
		</div>
	<?php } else if ($status == "failure"){ ?>
		<div class = "failureMessage">
			<p>Failure, there was an issue processing the form.</p>.
		</div>
	<?php } ?>
		<form action = "contact.php" method="post">
			<h1>Contact Me! </h1>
			<table>
				<tr>
					<td><lable name = "name">Name:</lable></td>
					<td>
						<div class = "error"><?php echo $nameERR ?></div>	
						<input type = "text" name = "name" value = "<?php echo $name?>">
						<label for = "nameLast" aria-hidden = "true" class = "hide">Last Name</label> <input type = "text" name = "nameLast" id = "nameLast" class = "hide">
					</td>
				</tr>
				<tr>
					<td><label name =  "email">Email:</label></td>
					<td>
						<div class = "error"><?php echo $emailERR ?></div>
						<input type = "email" name = "email" value = "<?php echo $email?>">
					</td>
				</tr>
				<tr>
					<td><label name = "reason">Reason for Contact:</label></td>
					<td>
						<select name = "reason">
							<option value = "Employment">Employment</option>
							<option value = "Issue with the site">Issue with Site</option>
							<option value = "General Message">General Message</option>
							<option value = "Other">Other</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><label name = "message">Message: <span class = "error"><?php echo $messageERR?></span></label><textarea name = "message" rows="5"><?php echo $message?></textarea></td>
				</tr>
			</table>
				<div class = "form-buttons"><input type = "submit" value = "submit" name = "submit"><input type = "reset" value = "reset"></div>
		</form>
	</div>
	
	<footer>
		<div></div>
		<p>Website Created by Josh Barron ©2021</p>
	</footer>
	
	
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
