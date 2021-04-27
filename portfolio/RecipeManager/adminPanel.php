<?php
session_start();
if($_SESSION["validUser"] != true){
	header( 'Location: login.php');
	exit();
}
if (isset($_POST["submit"])){
	
}
$user = "";
if(isset($_GET["user"])){
	$user = $_GET["user"];
}


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Panel</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel = "stylesheet" type = "text/css" href = "css/admin.css">
<script>
let recipesArray = []; //global recipe array used for populating selection
let getAppend = "";
let hidden = true;
$(document).ready(function(){
	loadRecipes(); //loads recipes into the admin drop down
});
/////////////
//FUNCTIONS//
/////////////
function selectionFocus(){
	if (adminSelect[0].text == "Select a recipe for more options"){
	var x = document.getElementById("adminSelect"); //this if statement will remove the default selection on 1st use
	firstSelection = false;
	x.remove(0);
	}
	////these next lines of code will generate and append recipe gets to the appropriate buttons
	getAppend = "?name=" + ($( "#adminSelect option:selected" ).text());
	getURL = "addRecipe.php"+getAppend;//this block of code changes the mofifying buttons
	$("#editLink").attr("href", getURL);
	getURL = "deleteRecipe.php"+getAppend;
	//$("#deleteLink").attr("href", getURL);
	
	if (hidden){
		$("#mod").css("display", "block");
		$("#confirmBox").css("display", "block");
	}
}
function loadRecipes(){
	$.ajax({
		method: 'GET',
		url: 'selectRecipe.php',
		dataType: 'json',
	}).done(function(data){
		for (let i = 0; i < data.length; i++){
			recipesArray.push(JSON.parse(data[i]));
			$("#adminSelect").append("<option name = '"+recipesArray[i].name+"'>"+recipesArray[i].name+"</option");
		}
	})
}
function enableDelete(){
	
	if ($("#confirmBox").val() == "CONFIRM"){
		getAppend = "?name=" + ($( "#adminSelect option:selected" ).text());
		getURL = "deleteRecipe.php"+getAppend;
		$("#deleteLink").attr("href", getURL);
	}
}
</script>
<style>
	#adminSelect {
		width: 225px;
		border-radius: 25px;
	}	
	#addRecipe {
		border: 2px black solid;
		border-radius: 25px;
		width: 225px;
	}
	#addRecipe:hover, #edit:hover {
		background-color:darkgray;
	}
	#delete:hover {
		background-color: lightcoral;
	}
	#mod {
		margin-right:auto;
		margin-left:auto;
		width: 225px;
		display: flex;
		flex-direction: row;
		justify-content: space-around;
		display: none;
	}
	#edit, #delete {
		border: 2px black solid;
		border-radius: 25px;
		width: 100px;
	}
	#logoff {
		margin-top: 50px;
	}
	#confirmBox {
		text-align: center;
		width: 225px;
		height 750px;
		display: none;
		margin: 5px auto 5px auto;
		border: none;
	}
	#confirmBox::placeholder {
		text-align: center;
	}
	
</style>
</head>

<body>
	<a href = "index.html"><div id = "nav">PUBLIC VIEW</div></a>
	<div id  = "container">
		<h1>Admin Panel</h1>
		<h2>Hello! <span id = "user"><?php echo $user;?></span></h2>
		<a href = "addRecipe.php"><input type = button id = "addRecipe" value = "Add New"></a>
		<div><p><select id = "adminSelect" onChange="selectionFocus()"><option value = "default">Select a recipe for more options</option></select></p></div>
		<div id = "mod">
			<a href = "addRecipe.php" id = "editLink"><input type = "button" id = "edit" value = "EDIT"></a>
			<a id = "deleteLink"><input type = "button" id = "delete" value = "DELETE"></a>
		</div>
		<input type = "text" id = "confirmBox" placeholder="type CONFIRM to enable delete" onblur="enableDelete()">
		<p><a href = "logoff.php"><input type = "button" id = "logoff" value = "Log Off"></a></p>
	</div>
</body>
</html>