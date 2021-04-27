<?php
session_start();
if (isset($_SESSION["validUser"])){
	echo true;
	exit();
}
else{
	echo false;
	exit();
}
//else if (!isset($_SESSION['validUser'])){
//	header('Location: index.html');
//	exit();
//}

?>
