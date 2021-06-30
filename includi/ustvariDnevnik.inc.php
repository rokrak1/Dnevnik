<?php
session_start();
require 'dbccon.inc.php';
if(isset($_POST['ustvari'])){
	$naslov = mysqli_real_escape_string($conn, $_POST['dName']);

	$sql = "INSERT INTO dnevnik (imeDnevnika,idUporabnika) VALUES ('".$naslov."',(SELECT id from uporabniki WHERE up_ime = '".$_SESSION['up_ime']."'))";
	$result = $conn -> query($sql);
	if($result){
		header("Location: ../dnevnik.php?message=createSuccess");
		exit();
	}
	else{
		header("Location: ../dnevnik.php?message=createError");
		exit();
	}
}
else{
	header("Location: ../index.php?message=notPermitted");
	exit();
}	

?>