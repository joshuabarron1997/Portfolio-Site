// JavaScript Document
//Validates recipe and returns valid boolean
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