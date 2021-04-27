<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
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
		@media only screen and (max-width: 991px){
			#portfolio-container {
				width: 100%;
				border-radius: 0px;
			}
			#about {
				width: 70%;
			}
			#about img {
				width: 300px;
				height: 240px;
			}
			#resume {
				width: 100%;
			}
		}
		@media only screen and (max-width: 500px){
			#about {
				width: 100%;
			}
			#resume iframe {
				width: 100%;
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
					<a class="nav-link" href = "portfolioindex.html">Home</a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href = "portfolioindex.html#about">About Me</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "projects.html">Portfolio</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "portfolioindex.html#resume">Resume</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "contact.php">Contact</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href = "https://github.com/joshuabarron1997">Github</a>
					</li>
				</ul>
			</div>
		</div>
	  </nav>
	<div id = "contact">
		<form>
			<h1>Contact Me!</h1>
			<table>
				<tr>
					<td><lable name = "name">Name:</lable></td>
					<td><input type = "text" name = "name"></td>
				</tr>
				<tr>
					<td><label name =  "email">Email:</label></td>
					<td><input type = "email" name = "email"></td>
				</tr>
				<tr>
					<td><label name = "reason">Reason for Contact:</label></td>
					<td>
						<select name = "reason">
							<option value = "Employment">Employment</option>
							<option value = "Issue with the site">Issue with Site</option>
							<option value = "general message">General Message</option>
							<option value = "Other">Other</option>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2"><label name = "message">Message:</label><br><textarea name = "message" rows="5"></textarea></td>
				</tr>
				<tr>
					<td><input type = "submit" value = "submit"><input type = "reset" value = "reset"></td>
				</tr>
			</table>
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
