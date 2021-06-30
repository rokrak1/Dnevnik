<?php
session_start();
require 'dbccon.inc.php';
$location = "";
if($_GET['page']==1){
$location="Location: ../publicTales.php";
}
else{
$location="Location: ../favorite.php";
}
if(isset($_SESSION['id'])){
	if(isset($_POST['gor']) || isset($_POST['dol'])){
		$id = $_GET['id'];
		$idUser = $_SESSION['id'];
		$ocena = 0;
		if(isset($_POST['gor'])){
			$ocena = 1;
		}

		$sql = "SELECT * FROM ocena WHERE idZapisa = ".$id." AND idUporabnika=".$idUser;
		$result = $conn -> query($sql);
		if(mysqli_num_rows($result)>0){
			while($row = $result -> fetch_assoc()){
					$sql2 = "UPDATE ocena SET ocena = ".$ocena." WHERE idZapisa = ".$id." AND idUporabnika = ".$idUser;
					$result2 = $conn->query($sql2);
					if($result2){
						header($location."?message=success");
						exit();
					}
					else{
						header($location."?message=updateError");
						exit();
					}
				}
			}
			else{
				$sql2 = "INSERT INTO ocena (idZapisa,idUporabnika,ocena) VALUES (".$id.",".$idUser.",".$ocena.")";
				$result2 = $conn->query($sql2);
				if($result2){
					header($location."?message=success");
					exit();
				}
				else{
					header($location."?message=insertError");
					exit();
				}
			}
	}
	else{
		header($location."?message=sqlError");
		exit();
	}
}
else{
	header("Location: ../index.php?message=nosession");
	exit();
}