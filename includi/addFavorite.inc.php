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


if(isset($_POST['priljubljen'])){
	$id = $_GET['id'];
	$idUser = $_SESSION['id'];
	$sql = "SELECT * FROM priljubljen where idZapisa=".$id." AND idUporabnika=".$idUser;
	$result = $conn->query($sql);
	if(mysqli_num_rows($result)>0){
		while($row = $result->fetch_assoc()){
			$sql2 = "UPDATE priljubljen SET stanje= NOT stanje WHERE id=".$row['id'];
			$result2 = $conn->query($sql2);
			if($result2){
				if($row['stanje']==1){
					header($location."?priljubljen=2");
					exit();
				}
				else{
					setcookie("priljubljen", "1", time() + (86400 * 30), "/");
					header($location."?priljubljen=1");
					exit();				}
			}
			else{
				header($location."?priljubljen=0");
				exit();
			}
		}
	}
	else{
		$sql = "INSERT INTO priljubljen (idZapisa,idUporabnika,stanje) VALUES (".$id.",".$idUser.",1)";
		$result = $conn->query($sql);
		if($result){
			setcookie("priljubljen", "1", time() + (86400 * 30), "/");
			header($location."?priljubljen=1");
			exit();
		}
		else{
			header($location."?message=errorp");
			exit();
		}
	}
}

?>