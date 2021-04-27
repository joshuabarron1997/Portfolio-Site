<?php
//require 'product.class.php';
require 'dbConnect.php';
//if(isset($_GET["name"])){
//	$n = $_GET["name"];
//	$sql = 'SELECT * FROM recipes WHERE recipe_name = :n';
//	$stmt = $pdo->prepare($sql);
//	$stmt->bindParam(':n', $n);
//	$stmt->execute();
//	$x = $stmt->rowCount();
//	if($x == 1){
//		$row = $stmt->fetch();
//		echo $row["recipe_object"];
//	}
//}
//else{
//	$array = [];
//	$sql = 'SELECT * FROM recipes';
//			$stmt = $pdo->prepare($sql);
//			$stmt->execute();
//			$count = $stmt->rowCount();
//			while ($row = $stmt->fetch()){
//				array_push($array,$row["recipe_object"]);
//			}
//	$package = json_encode($array);
//	echo $package;
//}

//echo "<h1>message from php</h1>";

	$array = [];
	$sql = 'SELECT * FROM products';
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$count = $stmt->rowCount();
			while ($row = $stmt->fetch()){
				array_push($array,$row["product_object"]);
			}
	$package = json_encode($array);
	echo $package;
?>