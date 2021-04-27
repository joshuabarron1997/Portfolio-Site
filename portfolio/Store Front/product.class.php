<?php
class Product {
	//properties
	public $name; //string
	public $artist; //string
	public $genre; //string
	public $description; //string
	public $type; //string (decides whether vinyl, digital, accesorie, etc)
	public $price; //float
	public $image_path; //string
	public $digital_path; //string
	public $buy_button; //string
	public $cart_button; //string
	//constructor
	function __construct($name, $artist, $genre, $description, $type, $price, $image_path, $digital_path, $buy_button, $cart_button){
		$this->name = $name;
		$this->artist = $artist;
		$this->genre = $genre;
		$this->description = $description;
		$this->type = $type;
		$this->price = $price;
		$this->image_path = $image_path;
		$this->digital_path = $digital_path;
		$this->buy_button = $buy_button;
		$this->cart_button = $cart_button;
	}
	function get_name(){
		return $this->name;
	}
}
//EXAMPLE PRODUCT
//$description = "Paramores sophmore album bla bla bla, tracklist 1 2 3 4";
//$buy = '<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
//				<input type="hidden" name="cmd" value="_s-xclick">
//				<input type="hidden" name="hosted_button_id" value="6JGHHA6WNDKS4">
//				<table>
//				<tr><td><input type="hidden" name="on0" value="Vinyl Design">Vinyl Design</td></tr><tr><td><select name="os0">
//					<option value="Black">Black $19.99 USD</option>
//					<option value="Teal">Teal $21.99 USD</option>
//					<option value="Neon Red">Neon Red $29.99 USD</option>
//				</select> </td></tr>
//				</table>
//				<input type="hidden" name="currency_code" value="USD">
//				<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
//				<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
//		</form>';
//$cart = '<form target="paypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
//<input type="hidden" name="cmd" value="_s-xclick">
//<input type="hidden" name="hosted_button_id" value="6WHJMHGG2R8WY">
//<table>
//<tr><td><input type="hidden" name="on0" value="Vinyl Design">Vinyl Design</td></tr><tr><td><select name="os0">
//	<option value="Black">Black $19.99 USD</option>
//	<option value="Teal">Teal $21.99 USD</option>
//	<option value="Neon Red">Neon Red $29.99 USD</option>
//</select> </td></tr>
//</table>
//<input type="hidden" name="currency_code" value="USD">
//<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_cart_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
//<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
//</form>
//';
//$item = new Product("paramore", "riot", "alternative", $description, "vinyl", "19.99", "images/riot.gif", "storage/riot.zip", $buy, $cart);
//$package = json_encode($item);
//echo $package;
?>