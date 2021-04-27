// JavaScript Document

var assert = require('chai').assert;	//Chai assertion library
//var validInput = require('../app/validateRequiredField').validInput;
//var validPhone = require('../app/validatePhoneNumber').validPhone;
var app =  require("../app/validateRecipe.js");

describe("Valid Author", function(){
	
	it("Input is required", function(){
		assert.isFalse(app.validAuthor(""));
	});
	it("No Odd Characters", function(){
		assert.isFalse(app.validAuthor("$%^&#"));
	});
});
describe("Valid Name", function(){
	it("Input is required", function(){
		assert.isFalse(app.validName(""));
	});
	it("No Odd Characters", function(){
		assert.isFalse(app.validName("$%^&#"));
	});
});
describe("Valid Serves", function(){
	it("Input is required", function(){
		assert.isFalse(app.validNum(""));
	});
	it("No Negatives", function(){
		assert.isFalse(app.validNum("-5"));
	});	
});
describe("Valid Preparation", function(){
	it("Input is required", function(){
		assert.isFalse(app.validNum(""));
	});
	it("No Negatives", function(){
		assert.isFalse(app.validNum("-5"));
	});	
});
describe("Valid Cooking", function(){
	it("Input is required", function(){
		assert.isFalse(app.validNum(""));
	});
	it("No Negatives", function(){
		assert.isFalse(app.validNum("-5"));
	});	
});
describe("Valid Ingredient", function(){
	it("Input is required", function(){
		assert.isFalse(app.validIngredient(""));
	});
	it("No Odd Characters", function(){
		assert.isFalse(app.validIngredient("$%^&#"));
	});
});
describe("Valid Ing_Amount", function(){
	it("Input is required", function(){
		assert.isFalse(app.validNum(""));
	});
	it("No Negatives", function(){
		assert.isFalse(app.validNum("-5"));
	});	
});
describe("Valid Instruction", function(){
	it("Input is required", function(){
		assert.isFalse(app.validInstruction(""));
	});
	it("No Odd Characters", function(){
		assert.isFalse(app.validInstruction("$%^&#"));
	});
});