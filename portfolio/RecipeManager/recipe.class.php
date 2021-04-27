<?php
class Recipe {
	//properties
	public $author;
	public $name;
	public $serves;
	public $preparation;
	public $prep_unit;
	public $cooking;
	public $cook_unit;
	public $difficulty;
	public $image_path;
	public $ingredients;
	public $ingr_amount;
	public $instructions;
	//constructor
	function __construct($author, $name, $serves, $preparation, $prep_unit, $cooking, $cook_unit, $difficulty, $image_path, $ingredients, $ingr_amount, $instructions){
		$this->author = $author;
		$this->name = $name;
		$this->serves = $serves;
		$this->preparation = $preparation;
		$this->prep_unit = $prep_unit;
		$this->cooking = $cooking;
		$this->cook_unit = $cook_unit;
		$this->difficulty = $difficulty;
		$this->image_path = $image_path;
		$this->ingredients = $ingredients;
		$this->ingr_amount = $ingr_amount;
		$this->instructions = $instructions;	
	}
	function get_name(){
		return $this->name;
	}
}
//$ingredients = ["flour", "eggs", "sugar", "butter", "milk"];
//$ingr_amount = [3, 2, 1, 1, 2];
//$instructions = ["step one", "step two", "step three", "step four", "step five"];
//$cake = new Recipe("Josh Barron", "White Cake", 12, 30, "minutes", 2, "hours", "images/cake.png", $ingredients, $ingr_amount, $instructions);
//$package = json_encode($cake);
//$recipeName = $cake->get_name();
?>