<?php
session_start();
if($_SESSION["validUser"] != true){
	header( 'Location: index.html');
	exit();
}
$addStatus = "";
$author = "";
$name = "";
$serves = "";
$preparation = "";
$prep_unit = "";
$cooking = "";
$cook_unit = "";
$difficulty = "";
$image_path = "";
$ingredients = [];
$ingr_amount = [];
$instructions = [];
$ingredients_content = "<script>addIngredient();</script>";
$instructions_content = "<script>addInstruction();</script>";

$authorERR = "";
$nameERR = "";
$servesERR = "";
$preparationERR = "";
$cookingERR = "";
$difficultyERR = "";
$imageStatus = "";
$ingredientsERR = "";
$ingr_amountERR = "";
$instructionsERR = "";
$submitDisabled = "";
if (isset($_POST["submit"])){
	//GENERTING AND POPULATING DYNAMIC FIELDS//
//	if(isset($_POST["ingredients"])){
//		$x = $_POST["ingredients"];
//		foreach($x as $eachInput){
//		array_push($ingredients, $eachInput);
//		}
//	}
	///////////////////////////////////////////
	///VALIDATION TIME///boolean that determines end result
	$validForm = true; //
	////////AUTHOR//////////author should validate empty, null, odd characters, and length
	if (isset($_POST["author"])){ 
		$author = $_POST["author"];
	}
	////////NAME//////////name should validate empty, null, odd characters, length, and repeated recipe names from database
	if (isset($_POST["name"])){
		$name = $_POST["name"];
		if($name !== null && $name !== ""){
			$regex = '/[!@#$%^&*(),.?":{}|<>]/';
			if (!preg_match($regex, $name)){
				if(strlen($name) <= 50){
					require 'dbConnect.php';
						$sql = 'SELECT * FROM recipes WHERE recipe_name = :n';
						$stmt = $pdo->prepare($sql);
						$stmt->bindParam(':n', $name);
						$stmt->execute();
						$x = $stmt->rowCount();
						if($x === 1){
							$nameERR = "<div class ='error'>no two recipes may have the same name</div>";
							$validForm = false;
						}
				}
				else{
					$nameERR = "<div class = 'error'>invalid characters in name</div>";
					$validForm = false;
				}
			}
			else{
				$nameERR = "<div class = 'error'>invalid characters in name</div>";
				$validForm = false;
			}
		}
		else{
			$nameERR = "<div class = 'error'>null or empty name</div>";
			$validForm = false;
		}	
	}
	////////SERVES////////serves should validate empty, null, non numeric and negatives
	if (isset($_POST["serves"])){
		$serves = $_POST["serves"];
	}	
	////////PREPARATION////////preparation should validate empty, null, none numeric and negatives
	if (isset($_POST["preparation"])){
		$preparation = $_POST["preparation"];
	}	
	////////PREP_UNIT////////prep unit is a select handle and should always have a valid default of minutes
	if (isset($_POST["prep_unit"])){
		$prep_unit = $_POST["prep_unit"];
	}
	////////COOKING////////cooking should validate empty, null, none numeric and negatives
	if (isset($_POST["cooking"])){
		$cooking = $_POST["cooking"];
	}
	////////COOK_UNIT////////cook unit is a select handle and should always have a valid default of minutes
	if (isset($_POST["cook_unit"])){
		$cooking_unit = $_POST["cook_unit"];
	}
	////////DIFFICULTY////////dificulty is a select handle and should always have a valid default of easy
	if (isset($_POST["difficulty"])){
		$difficulty = $_POST["difficulty"];
	}
	////////IMAGE////////image system will mostly handle itself only outputing 0 or 1 and status'
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
	////////INGREDIENTS////////ingredients should validate the whole array for empty, and length
	if (isset($_POST["ingredients"]) && isset($_POST["ingr_amount"])){
		$i = 0;//incrementer
		$x = $_POST["ingredients"];
		$ingredients_content = ""; //clearing for future append
		foreach($x as $eachInput){
			//PUTTING INGREDIENTS BACK INTO THE FIELDS START
			$ingredients_content .= 
			"<tr>
				<td colspan = '1' id = 'ing_".$i."'></td>
				<td><input type = 'text' name = 'ingredients[]' value = '".$eachInput."'required onBlur = 'valIngredient(this)'></td>
				<td><input type = 'number' class = 'num' step = '1' name = 'ingr_amount[]' value = '".$_POST["ingr_amount"][$i]."'required onBlur = 'valIng_Amount(this)'></td>
				<td><input type = 'button' value = 'X' onClick = 'deleteIngredient(this)'</td>
			</tr>";
			$i++;
			//PUTTING INGREDIENTS BACK INTO THE FIELDS END
			
			//VALIDATION
			array_push($ingredients, $eachInput);
		}
	}
	////////INGR_AMOUNT////////ingredient amounts should validate the entire array for empty, null, non numeric and negatives
	if (isset($_POST["ingr_amount"])){
		$x = $_POST["ingr_amount"];
		foreach($x as $eachInput){
			//VALIDATION
			array_push($ingr_amount, $eachInput);
		}
	}
	////////INSTRUCTIONS////////instructions is very loose validation wise and will only be validated for empty null and possibly length
	if (isset($_POST["instructions"])){
		$i = 0; //incrementer
		$x = $_POST["instructions"];
		$instructions_content = ""; //clearing for future append
		foreach($x as $eachInput){
			//PUTTING INSTRUCTIONS BACK INTO FIELDS START
			$instructions_content .=
				"<tr>
				<td colspan = '1' id = 'instruction_".$i."'></td>
				<td colspan = '1'><textarea name = 'instructions[]' required rows = '5' cols = '40' onBlur = 'valInstruction(this)'>".$eachInput."</textarea></td>
				<td><input type = 'button' value = 'X' onClick = 'deleteInstruction(this)'</td>
				</tr>";
				$i++;
			//PUTTING INSTRUCTIONS BACK INTO FIELDS END
			//VALIDATION
			array_push($instructions, $eachInput);
		}
	}
	//////FIRE INTO DATABASE////////
	//$validForm = "false";
	if ($validForm){
		try{
			require 'recipe.class.php';
			require 'dbConnect.php';
			$newRecipe = new Recipe($author, $name, $serves, $preparation, $prep_unit, $cooking, $cooking_unit, $difficulty, $image_path, $ingredients, $ingr_amount, $instructions);
			$package = json_encode($newRecipe);

			$sql = "INSERT INTO recipes (recipe_name, recipe_object)
			VALUES (:recipeName, :recipeObject)";

			$stmt = $pdo->prepare($sql); //creates the prepared statement' object
			//bind parameters to the prepared statement object
			$stmt->bindParam(':recipeName', $name);
			$stmt->bindParam(':recipeObject', $package);
			//execute the prepared statement	
			$stmt->execute();
			
			$submitDisabled = "disabled";
			$addStatus = "<h1>Recipe added Successfully</h1><p><a href = 'index.html'>Check it out</a></p>";
		}catch(PDOException $e){
			$addStatus = "<h1>Connection failed: " . $e->getMessage()."</h1>";
		}
		
	}
}
///////////////////
/////FUNCTIONS/////
///////////////////
function selectdCheck($value1,$value2){
	if ($value1 == $value2){
		echo 'selected="selected"';
	}
	return '';
}
///////////////////
///FUNCTIONS END///
///////////////////
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add Recipe</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src = "validateRecipe.js"></script>
<link rel = "stylesheet" type = "text/css" href = "css/admin.css">
<script>
$(document).ready(function(){
	$("#recipeForm").submit(function(){//this block of code fires when the form is submited. It will not submit on false return
		//validation start
		let validForm = true;
		if (valAuthor()){} else {validForm = false;}
		if (valName()){} else {validForm = false;}
		if (valServes()){} else {validForm = false;}
		if (valPreparation()){} else {validForm = false;}
		if (valCooking()){} else {validForm = false;}

		return validForm;
	});
});
//VALIDATION FUNCTIONS
function valAuthor(){
	let inValue = $("#author").val();
	inValue = inValue.trim();
	if (inValue === "" || inValue === null){
		$("#authorERR").html("No Null or Empty");
		$("#author").css("border", "2px solid red");
		return false;
	}
	else{
		if(inValue.length > 75){
			$("#authorERR").html("Less than 75 characters");
			$("#author").css("border", "2px solid red");
			return false;			
		}
		else{
			const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
			if(!regex.test(inValue)){
				$("#authorERR").html("No Special Characters");
				$("#author").css("border", "2px solid red");
				return false;
			}
			else{
				$("#authorERR").html("");
				$("#author").css("border", "2px solid green");
				return true;
			}			
		}
	}
}
function valName(){
	let inValue = $("#name").val();
	inValue = inValue.trim();
	if (inValue === "" || inValue === null){
		$("#nameERR").html("No Null or Empty");
		$("#name").css("border", "2px solid red");
		return false;
	}
	else{
		if(inValue.length > 75){
			$("#nameERR").html("Less than 75 characters");
			$("#name").css("border", "2px solid red");
			return false;			
		}
		else{
			const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
			if(!regex.test(inValue)){
				$("#nameERR").html("No Special Characters");
				$("#name").css("border", "2px solid red");
				return false;
			}
			else{
				$("#nameERR").html("");
				$("#name").css("border", "2px solid green");
				return true;
			}			
		}
	}	
}
function valServes(){
	let inValue = $("#serves").val();
	inValue = inValue.trim();
	if(inValue === "" || inValue == null){
		$("#servesERR").html("No Null or Empty");
		$("#serves").css("border", "2px solid red");
		return false;
	}
	else{
		if(inValue.length > 5){
			$("#servesERR").html("5 Digits Max");
			$("#serves").css("border", "2px solid red");
			return false;
		}
		else{
			if(Number(inValue) < 0){
				$("#servesERR").html("No Negatives");
				$("#serves").css("border", "2px solid red");
				return false;
			}
			else{
				$("#servesERR").html("");
				$("#serves").css("border", "2px solid green");
				return true;
			}	
		}

	}
}
function valPreparation(){
	let inValue = $("#preparation").val();
	inValue = inValue.trim();
	if(inValue === "" || inValue == null){
		$("#preparationERR").html("No Null or Empty");
		$("#preparation").css("border", "2px solid red");
		return false;
	}
	else{
		if(inValue.length > 5){
			$("#preparationERR").html("5 Digits Max");
			$("#preparation").css("border", "2px solid red");
			return false;
		}
		else{
			if(Number(inValue) < 0){
				$("#preparationERR").html("No Negatives");
				$("#preparation").css("border", "2px solid red");
				return false;
			}
			else{
				$("#preparationERR").html("");
				$("#preparation").css("border", "2px solid green");
				return true;
			}	
		}

	}	
}
function valCooking(){
	let inValue = $("#cooking").val();
	inValue = inValue.trim();
	if(inValue === "" || inValue == null){
		$("#cookingERR").html("No Null or Empty");
		$("#cooking").css("border", "2px solid red");
		return false;
	}
	else{
		if(inValue.length > 5){
			$("#cookingERR").html("5 Digits Max");
			$("#cooking").css("border", "2px solid red");
			return false;
		}
		else{
			if(Number(inValue) < 0){
				$("#cookingERR").html("No Negatives");
				$("#cooking").css("border", "2px solid red");
				return false;
			}
			else{
				$("#cookingERR").html("");
				$("#cooking").css("border", "2px solid green");
				return true;
			}	
		}

	}		
}
function valIngredient(field){
	let inValue = $(field).val();
	inValue = inValue.trim();
	if (inValue === "" || inValue === null){
		$(field).css("border", "2px solid red");
		return false;
	}
	else{
		const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
		if(!regex.test(inValue)){
			$(field).css("border", "2px solid red");
			return false;
		}
		else{
			$(field).css("border", "2px solid green");
			return true;
		}				
	}
}
function valIng_Amount(field){
	let inValue = $(field).val();
	inValue = inValue.trim();
	if(inValue === "" || inValue == null){
		$(field).css("border", "2px solid red");
		return false;
	}
	else{
		if(inValue.length > 5){
			$(field).css("border", "2px solid red");
			return false;
		}
		else{
			if(Number(inValue) < 0){
				$(field).css("border", "2px solid red");
				return false;
			}
			else{
				$(field).css("border", "2px solid green");
				return true;
			}	
		}

	}	
}
function valInstruction(field){
	let inValue = $(field).val();
	inValue = inValue.trim();
	if (inValue === "" || inValue === null){
		$(field).css("border", "2px solid red");
		return false;
	}
	else{
		const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
		if(!regex.test(inValue)){
			$(field).css("border", "2px solid red");
			return false;
		}
		else{
			$(field).css("border", "2px solid green");
			return true;
		}				
	}	
}
//VALIDATION FUNCTIONS END
var counterInstructions = 0;
var counterIngredients = 0;
function resetPage(){
	$("#authorERR").html("");
	$("#author").css("border", "1px solid gray");
	
	$("#nameERR").html("");
	$("#name").css("border", "1px solid gray");
	
	$("#servesERR").html("");
	$("#serves").css("border", "1px solid gray");
	
	$("#preparationERR").html("");
	$("#preparation").css("border", "1px solid gray");
	
	$("#cookingERR").html("");
	$("#cooking").css("border", "1px solid gray");
}
function addIngredient(){
	var x = document.createElement('tr');
	counterIngredients++; 
	x.innerHTML = 
		"<td colspan = '1' id = 'ing_"+counterIngredients+"'></td><td><input type = 'text' name = 'ingredients[]' required onBlur = 'valIngredient(this)'></td><td><input type = 'number' class = 'num' name = 'ingr_amount[]' step = '1' required onBlur = 'valIng_Amount(this)'></td><td><input type = 'button' value = 'X' onClick = 'deleteIngredient(this)'</td>";
	$("#ingredients").append(x);
}
function addInstruction(){
	var x = document.createElement('tr');
	counterInstructions++;
	x.innerHTML = 
		"<td colspan = '1' id = 'instruction_"+counterInstructions+"'></td><td colspan = '1'><textarea name = 'instructions[]' required rows = '5' cols = '40' onBlur = 'valInstruction(this)'></textarea></td><td><input type = 'button' value = 'X' onClick = 'deleteInstruction(this)'</td>";
	$("#instructions").append(x);
}
function deleteIngredient(r){
	var i = r.parentNode.parentNode.rowIndex;
	document.getElementById("ingredients").deleteRow(i);
}
function deleteInstruction(r){
	var i = r.parentNode.parentNode.rowIndex;
	document.getElementById("instructions").deleteRow(i);
}
</script>
<style>
	#container {
		width: 500px;
		height: auto;
		padding: 0px 15px 15px 15px;
	}
	#header {
		width:500x;
		height: auto;
		padding: 15px;
	}
	#ingredients, #instructions {
		height: auto;
		padding: 15px;
	}
	#formBTN {
		display: flex;
		flex-direction: row;
		width: 125px;
		justify-content: space-around;
		margin: 15px auto 15px auto;
	}
	.num {
		width: 55px;
	}
	.error {
		color: red;
		font-size: .75em;
	}
	table {
		margin-left:auto;
		margin-right:auto;
	}
	td {
		text-align: left;
	}
	#return {
		font-size: 1.75em;
		margin: 0px auto 0px auto;
		height: 35px;
		vertical-align:middle;
		width:300px;
		border: 3px solid black;
		border-top: none;
		border-bottom-left-radius: 25px;
		border-bottom-right-radius: 25px;
		background-color: antiquewhite;
	}
	#return:hover {
		background-color: coral;
	}
	
</style>
</head>

<body>
	<div id = "container">
		<a href = "adminPanel.php" ><div id = "return">Admin Panel</div></a>
		<?php echo $addStatus;?>
		<h1>Add Recipe</h1>
		<form action "addRecipe.php" id = "recipeForm" method="post" enctype="multipart/form-data"> <!--onSubmit="return jsValidation()"-->
			<div id = "header">
				<table>
					<!--AUTHOR ROW-->
					<tr>
						<td>Author: </td>
						<td><input type = "text" name = "author" id = "author" value = "<?php echo $author?>"required onBlur="valAuthor()"> <span id = "authorERR" class = "error"><?php echo $authorERR?></span></td>
					</tr>
					<!--RECIPE NAME ROW-->
					<tr>
						<td>Recipe Name: </td>
						<td><input type = "text" name = "name" id = "name" value = "<?php echo $name?>" required onBlur="valName()"> <span id = "nameERR" class = "error"><?php echo $nameERR?></span></td>
					</tr>
					<!--SERVES ROW-->
					<tr>
						<td>Serves: </td>
						<td><input type = "number" step = "1" class = "num" name = "serves" id = "serves" value = "<?php echo $serves?>" onBlur="valServes()"> <span id = "servesERR" class = "error"><?php echo $servesERR?></span></td>
					</tr>
					<!--PREPARATION ROW-->
					<tr>
						<td>Preparation Time: </td>
						<td>
							<input type = "number" step = "1"  class = "num" name = "preparation" id = "preparation" value = "<?php echo $preparation?>" onBlur="valPreparation()">
							<select name = "prep_unit">
								<option value = "minutes"<?php selectdCheck("minutes", $prep_unit)?>>Minutes</option>
								<option value = "hours"<?php selectdCheck("hours", $prep_unit)?>>Hours</option>
							</select>
							 <span id = "preparationERR" class = "error"><?php echo $preparationERR?></span>
						</td>
					</tr>
					<!--COOKING ROW-->
					<tr>
						<td>Cooking Time: </td>
						<td>
							<input type = "number" step = "1"  class = "num" name = "cooking" id = "cooking" value = "<?php echo $cooking?>" onBlur="valCooking()">
							<select name = "cook_unit">
								<option value = "minutes"<?php selectdCheck("minutes", $cook_unit)?>>Minutes</option>
								<option value = "hours"<?php selectdCheck("hours", $cook_unit)?>>Hours</option>
							</select>
							 <span id = "cookingERR" class = "error"><?php echo $cookingERR?></span> 
						</td>
					</tr>
					<!--DIFFICULTY ROW-->
					<tr>
						<td>Difficulty: </td>
						<td>
							<select name = "difficulty">
								<option value = "Easy"<?php selectdCheck("Easy", $difficulty)?>>Easy</option>
								<option value = "Medium"<?php selectdCheck("Medium", $difficulty)?>>Medium</option>
								<option value = "Hard"<?php selectdCheck("Hard", $difficulty)?>>Hard</option>
							</select>						
						</td>
					</tr>
					<!--IMAGE ROW-->
					<tr>
						<td>Image: </td>
						<td><input type="file" name="fileToUpload" id="fileToUpload"></td>
					</tr>
					<tr><td colspan="1"></td><td colspan="1"><?php echo $imageStatus?></td></tr>
				</table>
			</div>
			<div>
				<table id = "ingredients">
					<tr><th colspan="2">Ingredients:</th><th colspan="1">Amt:</th><th colspan="1"></th></tr>
					<?php echo $ingredients_content;?>
				</table>
			</div>
			<input type = "button" onClick="addIngredient()" value = "Add a Ingredient">
			<div>
				<table id = "instructions">
					<tr><th colspan="1"></th><th colspan="1">Instructions:</th></tr>
					<?php echo $instructions_content;?>
				</table>
			</div>
			<input type = "button" onClick="addInstruction()" value = "Add a Instruction">
			<div id = "formBTN"><input type = "submit" name = "submit" <?php echo $submitDisabled?></input><input type = "reset" onClick = "resetPage()"</div>
		</form>
	</div>
</body>
</html>