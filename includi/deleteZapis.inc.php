<?php

if(isset($_POST['zbrisiZapis'])){
	if(isset($_GET['id'])){
		require 'dbccon.inc.php';
	   $sql = "DELETE FROM zapis WHERE id = ".$_GET['id'];
	   $result = $conn->query($sql);
	   if($result){
	   	header("Location: ../dnevnik.php?message=1");
	   	exit();
	   }
	   else{
	   	header("Location: ../dnevnik.php?message=0");
	   	exit();
	   }
	}
}

?>