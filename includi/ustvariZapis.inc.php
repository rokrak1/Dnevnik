<?php

	require 'dbccon.inc.php';
	session_start();

if(isset($_POST['objavi'])){
	$datum = mysqli_real_escape_string($conn, $_POST['date']);
	$naslov = mysqli_real_escape_string($conn, $_POST['naslov']);
	$zgodba = mysqli_real_escape_string($conn, $_POST['zapis']);
	$stanje = !empty(mysqli_real_escape_string($conn, $_POST['stanje'])) ? 1 : 0 ;
	
	$sql = "INSERT INTO zapis (imeZapisa,datum,besedilo,idDnevnika,vidno) VALUES ('".$naslov."','".$datum."','".$zgodba."',(SELECT id FROM dnevnik where idUporabnika = ".$_SESSION['id']."),".$stanje.")";
	echo $sql;
	$result = $conn->query($sql);
	if($result){
		header("Location: ../dnevnik.php?message=taleSuccess");
		exit();
	}
	else{
		header("Location: ../dnevnik.php?checkupdate=3");
		exit();
	}
}
else{
	header("Location: ../index.php?message=notPermitted");
	exit();
}


?>