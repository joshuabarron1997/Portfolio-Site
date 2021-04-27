<?php
session_start();
session_unset();
session_destroy();
header( 'Location: index.html');
exit();
//if (isset($_SESSION["validUser"])){
//	if ($_SESSION["validUser"] == true){
//		session_unset();
//		session_destroy();
//		header( 'Location: index.html');
//		exit();
//	}
//}else {
//	session_unset();
//	session_destroy();
//	header( 'Location: index.html');
//	exit();	
//}
?>
