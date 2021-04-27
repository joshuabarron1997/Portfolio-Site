<?php
//session_start();
//if($_SESSION["validUser"] != true){
//	header( 'Location: index.html');
//	exit();
//}
$addStatus = "";
$imageStatus = "";
$digitalStatus = "";
$submitDisabled = "";
$name = "";
$artist = "";
$genre = "";
$description = "";
$type = "";
$price = "";
$image_path = "";
$digital_path = "";
$buy_code = "";
$cart_code = "";
if (isset($_POST["submit"])){
	
	$validForm = "true";
	//IMAGE UPLOAD STUFF
	if (!empty($_FILES["fileToUpload"]["name"])){		
			require 'imageloader.php';
			if ($uploadOk === 0){
				$validForm = false;
				unlink($target_file);//deleting file uploaded by invalid
				//$imageStatus should already
				//have accumlated errors in the file
			}	
			else {
				$image_path = $target_file;
			}
	}
	//DIGITAL UPLOAD STUFF --I SHOULD COLSOLIDATE THIS INTO A GLOBAL UPLOAD PHP FILE AND USE GETS TO DETERMINE THE FUNCTION---
	if (!empty($_FILES["digitalUpload"]["name"])){
		//upload digital
		$target_dir = "storage/";
			$target_file = $target_dir . basename($_FILES["digitalUpload"]["name"]);
			$uploadOk = 1;
			$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if file already exists
			if (file_exists($target_file)) {
				$digitalStatus .= "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				$digitalStatus .= " | Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["digitalUpload"]["tmp_name"], $target_file)) {
					$digitalStatus .= "The file ". basename( $_FILES["digitalUpload"]["name"]). " has been uploaded.";
				} else {
					$digitalStatus .= "Sorry, there was an error uploading your file.";
				}
			}
		//after process
		if ($uploadOk === 0){
				$validForm = false;
				unlink($target_file);//deleting file uploaded by invalid
				//$digitalStatus should already
				//have accumlated errors in the file
		}
		else {
			$digital_path = $target_file;
		}
	}
	
	//NAME
	if (isset($_POST["name"])){
		$name = $_POST["name"];
	}	
	//ARTIST
	if (isset($_POST["artist"])){
		$artist = $_POST["artist"];
	}	
	//GENRE
	if (isset($_POST["genre"])){
		$genre = $_POST["genre"];
	}	
	//DESCRPTION
	if (isset($_POST["description"])){
		$description = $_POST["description"];
	}	
	//TYPE
	if (isset($_POST["type"])){
		$type = $_POST["type"];
	}	
	//PRICE
	if (isset($_POST["price"])){
		$price = $_POST["price"];
	}	
	//BUY BUTTON
	if (isset($_POST["buy_code"])){
		$buy_code = $_POST["buy_code"];
	}	
	//CART BUTTON
	if (isset($_POST["cart_code"])){
		$cart_code = $_POST["cart_code"];
	}	

	if ($validForm){
		try{
			require 'product.class.php';
			
			$newProduct = new Product($name, $artist, $genre, $description, $type, $price, $image_path, $digital_path, $buy_code, $cart_code);
			$package = json_encode($newProduct);

			$sql = "INSERT INTO products (product_name, product_artist, product_type, product_price, product_object)
			VALUES (:productName, :productArtist, :productType, :productPrice, :productObject)";
			require 'dbConnect.php';
			$stmt = $pdo->prepare($sql); //creates the prepared statement' object
			//bind parameters to the prepared statement object
			$stmt->bindParam(':productName', $name);
			$stmt->bindParam(':productArtist', $artist);
			$stmt->bindParam(':productType', $type);
			$stmt->bindParam(':productPrice', $price);
			$stmt->bindParam(':productObject', $package);
			//execute the prepared statement	
			$stmt->execute();
			$submitDisabled = "disabled";
			$addStatus = "<h1 style='text-align:center'>Product added Successfully</h1>";
		}catch(PDOException $e){
			$addStatus = "<h1>Connection failed: " . $e->getMessage()."</h1>";
		}
		
	}
}

?>
<!doctype html>
<html><head>
	<!--VIEWPORT-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--BOOTSTRAP CSS-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<!--GENERAL STYLSHEET-->
	<link rel="stylesheet" type="text/css" href="css/base.css">
	
<!--
-->
<meta charset="utf-8">
<title>Viny, Accesories, and More!</title>
<script src = "master.js"></script>
<style>
	#productForm {
		width: 50%;
		margin-left: auto;
		margin-right: auto;
	}
</style>
</head>


<body>
	<!--HEADER-->
	<div class = "container-fluid" id = "header">
		<div id = "top">

			<div class = "filler"></div>
			<div id = "logoArea"><h2>
				<img src = "images/logolarge.gif" alt = "Vinyl, Accessories, and More" class = "logoLarge">
				<img src = "images/logomedium.gif" alt = "Vinyl, Accessories, and More" class= "logoMedium">
				<h2 class = "logoSmall">VINYL, ACCESSORIES, AND MORE</h2>
				</h2></div>
			<div id = "profileArea">
				<a href = "login.php" class = "loginBTN">Login</a>
				<a href = "signup.php" class = "signupBTN">Sign Up</a>
			</div>
			<div id = "mobileSandwich" onClick="mobileNav()">
				<div></div>
				<div></div>
				<div></div>
			</div>
		</div>
		<div id = "nav" class = "container-fluid">
			<div></div>
			<a href =  "index.html" class = "navBTN">Home</a>
			<a href = "store.html" class = "navBTN">Store</a>
			<a href = "about.html" class = "navBTN">About</a>
			<a href = "contact.html" class = "navBTN">Contact</a>
			<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" style="justify-self:start; height: 75px; width:100%">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
			<input type="submit" border="0" class = "navBTN cart" name="submit" alt="PayPal - The safer, easier way to pay online!" value = "View Cart">
			<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
			</form>
			<div></div>
		</div>
	</div>
	<!--MOBILE NAV-->
	<div id = "mobileNav" class = "container-fluid">
		<div id = "mobileProfileArea">
			<a href = "login.php" class = "navBTN">Login</a>
			<a href = "signup.php" class = "navBTN">Sign Up</a>
		</div>
		<a href =  "index.html" class = "navBTN">Home</a>
		<a href = "store.html" class = "navBTN">Store</a>
		<a href ="about.html" class = "navBTN">About</a>
		<a href = "contact.html" class = "navBTN">Contact</a>
		<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
			<input type="submit" border="0" name="submit" class = "navBTN cartMobile" alt="PayPal - The safer, easier way to pay online!" value = "View Cart">
			<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form>

		<a href = "#" class = "navBTN backBTN">Back</a>
		<script>document.querySelector(".backBTN").href = window.location.href;</script>
	</div>
	<!--CONTENT-->
	<div id = "main" class = "container-fluid">
		<h1 style="text-align: center">ADD A PRODUCT</h1>
		<?php echo $addStatus?>
		<form action = "add.php" id = "productForm" method = "post" enctype="multipart/form-data">
			<table>
				<tr>
					<!--NAME TEXT INPUT-->
					<td>Name: </td>
					<td><input type = "text" name = "name" id = "name" required></td>
				</tr>
				<tr>
					<!--ARTIST TEXT INPUT-->
					<td>Artist: </td>
					<td><input type = "text" name = "artist" id = "artist" placeholder="empty if none"></td>
				</tr>
				<tr>
					<!--GENRE TEXT INPUT-->
					<td>Genre: </td>
					<td><input type = "text" name = "genre" id = "genre"></td>
				</tr>
				<tr>
					<!--DESCRIPTION TEXTAREA INPUT-->
					<td>Description: </td>
					<td colspan = '1'><textarea name = "description" required rows = "5" cols = "60"></textarea></td>
				</tr>
				<tr>
					<!--TYPE SELECT INPUT-->
					<td>Type of Product: </td>
					<td>
						<select name = "type">
							<option value = "vinyl">Vinyl</option>
							<option value = "used vinyl">Used Vinyl</option>
							<option value = "digital">Digital</option>
							<option value = "accessories">Accessories</option>
							<option value = "turn table">Turn Table</option>
						</select>
					</td>
				</tr>
				<tr>
					<!--PRICE NUMBER INPUT-->
					<td>Price: </td>
					<td><input type = "number" name = "price" ></td>
				</tr>
				<tr>
					<!--IMAGE FILE INPUT-->
					<td>Image: </td>
					<td><input type="file" name="fileToUpload" id="fileToUpload"></td>
				</tr>
				<tr>
					<td colspan="1"></td><td colspan="1"><?php echo $imageStatus?></td>
				</tr>
				<tr>
					<!--DIGITAL FILE INPUT-->
					<td>Digital Files(optional): </td>
					<td><input type="file" name="digitalUpload" id="digitalUpload"></td>
				</tr>
				<tr>
					<td colspan="1"></td><td colspan="1"><?php echo $digitalStatus?></td>
				</tr>
				<tr>
					<!--BUY BUTTON TEXTAREA INPUT-->
					<td>Buy Button Code: </td>
					<td colspan = '1'><textarea name = "buy_code" required rows = "15" cols = "100"></textarea></td>
				</tr>
				<tr>
					<!--CART BUTTON TEXTAREA INPUT-->
					<td>Cart Button Code: </td>
					<td colspan = '1'><textarea name = "cart_code" required rows = "15" cols = "100"></textarea></td>
				</tr>
			</table>
			<div style="text-align: center"><input type = "submit" name = "submit" <?php echo $submitDisabled?></input><input type = "reset"</div>
		</form>
		
	</div>
	<!--FOOOTER-->
	<div id = "footer" class = "container-fluid">
		<p style = "align-self:end">Follow us on our Social Media!</p>
		<div class = "socialMedia">
			<a href = "#"></a>
			<a href = "#"></a>
			<a href = "#"></a>
		</div>
		<div class = "copyright"><p>&#169; 2020, VINYL, ACCESORIE, AND MORE</p></div>
	</div>
	<!--BOOTSTRAP JS-->
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>
