var hideIngredients = false;
var hideInstructions = false;
let recipesArray = []; //global recipe array used for populating selection
let r; //global recipe object used to populate content
let quantity = 1; //modifier for various content variables
///////////////
///FUNCTIONS///
///////////////
function checkValid(){//simple php file that returns true or false whether their session is with a valid login
	$.ajax({
		method: 'GET',
		url: 'getSession.php',
		dataType: 'text',
	}).done(function(data){
		if (data == false){
			validUser = false;
		}
		else if (data == true){
			validUser = true;
			//generating content for valid session
			let navUrl = "logoff.php";
			let navHtml = "<div><p>LOG OFF</p></div>"
			let navAdmin = "<a id = 'adminBTN' href = 'adminPanel.php'><div><p>ADMIN PANEL</p></div></a>";
			$("#loginBTN").attr("href", navUrl);//sets button link to logoff.php
			$("#loginBTN").html(navHtml);//sets button text to LOG OFF
			$("#nav").append(navAdmin);
		}
	});
}
function loadRecipes(){
	$.ajax({
		method: 'GET',
		url: 'selectRecipe.php',
		dataType: 'json',
	}).done(function(data){
		for (let i = 0; i < data.length; i++){
			recipesArray.push(JSON.parse(data[i]));
			$("#recipeSelect").append("<option name = '"+recipesArray[i].name+"'>"+recipesArray[i].name+"</option");
			console.log(recipesArray[0].author);
		}
	});
}
function loadPage(name){
	let n = "selectRecipe.php?name="+name; //appending a get for a single recipe
	$.ajax({
		method: 'GET',
		url: n,
		dataType: 'json',
	}).done(function(data){
		r = data;
		//console.log(r.name);
		/////////
		//IMAGE//
		/////////
		if (r.image_path === ""){
			
		}
		else{
			$("#picture").html("<img src = '"+r.image_path+"' alt = '"+r.name+"'>");			
		}
		//////////
		//HEADER//
		//////////
		$("#recipeInfo").html(
			"<h1>"+r.name+"</h1>" + 
			"<h3>By: "+r.author+"</h2>" +
			"<p>Serves: " + quantity*r.serves + "</p>" + 
			"<p>Preparation: "+r.preparation+" "+r.prep_unit+"</p>" + 
			"<p>Cooking: "+r.cooking+" "+r.cook_unit+"</p>" +
			"<p>Dificulty: "+r.difficulty+"</p>");
		///////////////
		//INGREDIENTS//
		///////////////
		console.log(r.ingr_amount); console.log(r.ingredients);
		$("#ingredients-list ul").html("");//clearing the content so appendidng works
		for (let i = 0; i < r.ingredients.length; i++){
			$("#ingredients-list ul").append("<input type = 'checkbox'>" + quantity*r.ingr_amount[i]+" "+r.ingredients[i] +" <br>");
		}
		////////////////
		//INSTRUCTIONS//
		////////////////
		$("#instructions").html("<h3>Instructions:</h3>");//reseting the content so appendidng works
		for (let i = 0; i < r.instructions.length; i++){
			$("#instructions").append("Step "+(i+1)+"</br><p><input type = 'checkbox'>"+r.instructions[i]+"</p>");
		}
	});
}
function recipeSelection(){
	if (recipeSelect[0].text == "Select a Recipe"){
		var x = document.getElementById("recipeSelect"); //this if statement will remove the default selection on 1st use
		firstSelection = false;
		$("#picture").css("display","block");
		x.remove(0);
	}
	
	var temp = recipeSelect.selectedIndex; //grabbing the index of the dropdown and choosing what to display
	var name = recipeSelect[temp].value;
	loadPage(name);
}
function quantitySelection(){//sets the amount of ingredients per selection
	if (quantitySelect.selectedIndex == 0){//half quantity
		quantity = 0.5;
	}
	else if (quantitySelect.selectedIndex == 1){//regular quantity
		quantity = 1;
	}
	else if (quantitySelect.selectedIndex == 2){//double quantity
		quantity = 2;
	}
	if (!firstSelection){recipeSelection();}//makes sure this is not called before selection occurs
	}
function toggleIngredients(){
	if(hideIngredients == false){
		document.querySelector("#ingredientsToggle").innerHTML = "<p>Toggle Ingredients &#91;+&#93</p>";//"<p>test</p>"
		hideIngredients = true;
		$( "#ingredients-box" ).toggle();
	}
	else {
		document.querySelector("#ingredientsToggle").innerHTML = "<p>Toggle Ingredients &#91;-&#93</p>";
		hideIngredients = false;
		$( "#ingredients-box" ).toggle();
	}
}
	

function toggleInstructions(){
	if(hideInstructions == false){
		document.querySelector("#instructionsToggle").innerHTML = "<p>Toggle Instructions &#91;+&#93</p>";//"<p>test</p>"
		hideInstructions = true;
		$( "#instructions" ).toggle();
	}
	else {
		document.querySelector("#instructionsToggle").innerHTML = "<p>Toggle Instructions &#91;-&#93</p>";
		hideInstructions = false;
		$( "#instructions" ).toggle();
	}
}
///////////////////
///FUNCTIONS END///
///////////////////
$(document).ready(function(){ //ready call to fire code once the document is loaded
	//CHECKING FOR VALID SESSION TO DISPLAY CORRECT CONTENT
	let validUser = "";
	checkValid();
	//grabs recipes off database and loads them into selection box
	loadRecipes();
})	