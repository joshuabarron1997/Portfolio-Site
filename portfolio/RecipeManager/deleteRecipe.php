<?php
session_start();
if($_SESSION["validUser"] != true){
	header( 'Location: login.php');
	exit();
}
if (!isset($_GET["name"])){
	header( 'Location: adminPanel.php');
	exit();
}
$name = $_GET["name"];
try {
	require 'dbConnect.php';
	$sql = 'SELECT * FROM recipes WHERE recipe_name = :n';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam('n', $name);
	$stmt->execute();
	$success = $stmt->rowCount();
	if ($success == 1){
		try{
			$sql = 'DELETE FROM recipes WHERE recipe_name = :n';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam('n', $name);
			$stmt->execute();
			$msg = "deletion of item named " . $name . " successful";
			header( "Location: adminPanel.php?msg=".$msg);
			exit();	
		}
		catch(PDOException $e){
			$msg = "There was an error deleting the item " . $e;
			header( "Location: adminPanel.php?msg=".$msg);
			exit();
		}
	}
	else{
		$msg = "an item of that Name does not exist";
		header( "Location: adminPanel.php?msg=".$msg);
		exit();
	}
}
catch(PDOException $e){
	$msg = "Connection failed: " . $e->getMessage();
	header( "Location: adminPanel.php?msg=".$msg);
	exit();
}



?>