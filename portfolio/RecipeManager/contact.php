<?php
//functions
function selectdCheck($value1,$value2){
	if ($value1 == $value2){
		echo 'selected="selected"';
	}
	return '';
}
function validPost(){//final function that sends the email after validations
	require 'Emailer.php'; //access the emailer php file
	$emailTest = new Emailer(); //instantiating a new Emailer object
	$emailTest->set_senderEmail("webformtr18@joshbarron.info"); //sets the properties
	$emailTest->set_message($_POST["message"]);
	$emailTest->set_subject($_POST["reason"]);
	$emailTest->set_recieverEmail("joshthejaunty@gmail.com");
	if ($emailTest->sendEmail()){
		$emailResult = "<h1 class = 'success'>Contact Email Sent Successfully!</h1>"; //"Contact Email Sent Successfully!";
	}
	else {
		$emailResult = "<h1>An error occured processing this Email.</h1>"; //An error occured processing this Email";
	}
	
	//confirmation email for sender
	$emailTest = new Emailer(); //instantiating a new Emailer object
	$emailTest->set_senderEmail("webformtr18@joshbarron.info"); //sets the properties
	$emailTest->set_message("Josh Barrons Recipe Manager has recieved your email, Thank you.");
	$emailTest->set_subject("Contact confirmation");
	$emailTest->set_recieverEmail($_POST["email"]);
	if ($emailTest->sendEmail()){
		//echo "Confirmation Email Sent Successfully!";
	}
	else {
		//echo "An error occured processing this Email";
	}
}
//setting selfposting variables
$emailResult = "";
$email = "";
$reason = "default";
$message = "";
$emailERR = "";
$reasonERR = "";
$messageERR = "";
$captchaERR = "";
if (isset($_POST["submit"])){
	$email = $_POST["email"];
	$reason = $_POST["reason"];
	$message = $_POST["message"];
	//captcha
	$siteKey = "6LevS_AUAAAAAIAFUPdQx_Vo-tPmlp7e0PHWDEFY";//SERVER
	$secretKey = "6LevS_AUAAAAABvsOAsUAktj83gzEFQlA6mCiVl9"; //SERVER
	$response = $_POST['g-recaptcha-response'];
	$url = "https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$response";
	$captcha = json_decode(file_get_contents($url));
	//captcha end
	if ($captcha->success == true){
		validPost();
	} else {
		$captchaERR = "CAPTCHA FAILED!";
	}
	

}


?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Contact</title>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
function validateForm(){
	let validity = 0;
	let email = document.querySelector("#email").value;
	let message = document.querySelector("#message").value;
	let reason = document.querySelector("#reason").value;
	let regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if (!regex.test(email)){
		document.querySelector("#emailERR").innerHTML = "Please enter a valid email";
		validity += 1;
	}
	if (message == "" || message == null){
		document.querySelector("#messageERR").innerHTML = "Please enter a message";
		validity += 1;
	}
	if (reason == "default"){
		document.querySelector("#reasonERR").innerHTML = "Please select a reason"
		validity += 1;
	}
	console.log(validity);
	if (validity == 0){
		console.log("Success");
		return true;
	}
	else {
		console.log("Failure");
		return false;
	}
}
function resetForm(){
	$("#emailerERR").html("");
	$("#messageERR").html("");
	$("#reasonERR").html("");
	$("#captchaERR").html("");}
</script>
<link rel = "stylesheet" type = "text/css" href = "css/public.css">
<style>
	#email {
		width: 300px;
	}
	.error {
		color: red;
	}
	#container {
		border-radius: 0px 0px 45px 45px;
		text-align: center;
		height: auto;
		width: 350px;
		padding: 10px 35px 35px 35px;
	}
	#message {
		height 100px
		width: 200px;
	}
	#container form {
		
	}
	#nav div {
	padding-top: 15px;
	width: 420px;
	height: 35px;
	border: black solid 10px;
	border-bottom: none;
	border-top-left-radius: 45px;
	border-top-right-radius: 45px;
	background-color: lightcyan;;
	text-align: center;
	}
	#nav a div:hover {
		background-color: aqua;
	}
	#nav a:link, #nav a:visited {
		text-decoration: none;
		color: black;
	}
	#nav {
		width: 420px;
		margin-top: 75px;
	}
	.success {
		font-weight: bold;
		color: green;
	}
</style>
</head>

<body>
	<div id = "nav">
	<a href = "index.html"><div>Go Back</div></a>
	</div>
	<div id = "container">
		<form action = "contact.php" onSubmit="return validateForm()"method = "post">
			<div><?php echo $emailResult;?></div>
			<h1>Contact Me</h1>
			<p><input id = "email" type = "text" name = "email" placeholder = "johndoe1987@hotmail.com" required><span id = "emailERR" class = "error"><?php echo $emailERR?></span></p>
			<p><select id = "reason" name = "reason">
				<option value = "default" <?php selectdCheck("default", $reason)?>>Select a Reason</option>
				<option value = "complaint"<?php selectdCheck("complaint", $reason)?>>Site Complaint</option>
				<option value = "suggestion"<?php selectdCheck("suggestion", $reason)?>>Site Suggestion</option>
				<option value = "request admin"<?php selectdCheck("request admin", $reason)?>>Request Admin</option>
				<option value = "other"<?php selectdCheck("other", $reason)?>>Other</option>
			</select><span id = "reasonERR" class = "error"><?php echo $reasonERR?></span></p>
			<p><textarea id = "message" name = "message" placeholder = "Your message here..." rows = "10" cols = "50" required></textarea><br>
				<span id = "messageERR" class = "error"><?php echo $messageERR?></span>
			</p>
			<div id= "row"><div class="g-recaptcha" data-sitekey="6LevS_AUAAAAAIAFUPdQx_Vo-tPmlp7e0PHWDEFY"></div><div id = "captchaERR" class = "error"><?php echo $captchaERR;?></div></div>
			
			<p><input type = "submit" name = "submit" value = "Submit"><input type = "reset" onClick="resetForm()"></p>
			
		</form>
	</div>
</body>
</html>