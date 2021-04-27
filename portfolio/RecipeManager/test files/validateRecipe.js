// JavaScript Document
//Validates recipe and returns valid boolean
console.log("works");
module.exports =  {
	validAuthor: function(inValue){
		inValue = inValue.trim;
		if (inValue === "" || inValue === null || inValue.length > 75){
			return false;
		}
		else{
			const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
			if(regex.test(inValue)){
				return false;
			}
			else{
				return true;
			}
		}
	},
	validName: function(inValue){
		inValue = inValue.trim;
		if (inValue === "" || inValue === null || inValue.length > 75){
			return false;
		}
		else{
			const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
			if(regex.test(inValue)){
				return false;
			}
			else{
				return true;
			}
		}
	},
	validNum: function(inValue){
		inValue = inValue.trim();
		if(inValue === "" || inValue == null | inValue.length > 5){
			return false;
		}
		else{
			if(Number(inValue) < 0){
				return false;
			}
			else{
				return true;
			}
		}
	},
	validIngredient: function(inValue){
		inValue = inValue.trim;
		if (inValue === "" || inValue === null){
			return false;
		}
		else{
			const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
			if(regex.test(inValue)){
				return false;
			}
			else{
				return true;
			}
		}
	},
	validInstruction: function(inValue){
		inValue = inValue.trim;
		if (inValue === "" || inValue === null || inValue.length > 75){
			return false;
		}
		else{
			const regex = /[^!@#$%^&*(),.?":{}|<>]/g;
			if(regex.test(inValue)){
				return false;
			}
			else{
				return true;
			}
		}
	}
};
//TESTING PLAN
//AUTHOR --- NOT EMPTY OR NULL ---NO ODD CHARACTERS --- NO LONGER THAN 75 CHAR
//NAME --- NOT EMPTY OR NULL --- NO ODD CHARACTERS --- NO LONGER THAN 75 CHARACTERS
//SERVES --- NOT EMPTY OR NULL --- NO NEGATIVES --- 5 CHAR MAX
//PREPARATION --- NOT EMPTY OR NULL --- NO NEGATIVES --- 5 CHAR MAX
//COOKING --- NOT EMPTY OR NULL --- NO NEGATIVES --- 5 CHAR MAX
//INGREDIENTS --- NOT EMPTY OR NULL --- NO ODD CHARACTERS
//ING_AMOUNT --- NOT EMPTY OR NULL --- NO NEGATIVES --- 5 CHAR MAX
//INSTRUCTIONS --- NOT EMPTY OR NULL --- NO ODD CHARACTERS