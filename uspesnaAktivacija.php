<?php

require 'dbccon.inc.php';

$text = "Empty text...";	

if(isset($_GET['vkey'])){
	$key = $_GET['vkey'];

	$sql = "UPDATE uporabniki SET dostop = 1 WHERE vkey = '".$key."'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0){
		$text = "Aktivacija računa je uspela!";
	}
	else{
		$text = "Aktivacija računa ni uspela";
	}
}
else if(isset($_GET['aktivacija'])){
	if($_GET['aktivacija']=="success"){
		$text = "Preverite e-poštni naslov!";
	}
	else if($_GET['aktivacija']=="error"){
		$text = "Napaka pri registraciji!";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Aktivacija</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<h1 style="text-align:center"><?php echo $text ?></h1>
<div class="uprBaza">
<a href="index.php"><button class="buttonInp">Nazaj</button></a>
</div>
</body>
</html>