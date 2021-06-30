<?php
	require 'dbccon.inc.php';
if(isset($_POST['posodobi'])){

	$id = $_GET['id'];
	$sql = "SELECT imeZapisa from zapis where id=".$id;
	$result = $conn -> query($sql);
	if($result){
		while($row = $result->fetch_assoc()){
			$imeZapisa = $row['imeZapisa'];
			setcookie("imeZapisa", $imeZapisa, time() + (86400 * 30), "/");
			$sql2 = "UPDATE zapis SET vidno = NOT vidno where id=".$id;
			$result2 = $conn -> query($sql2);
			if($result2){
				$sql3 = "SELECT vidno from zapis where id=".$id;
				$result3 = $conn ->query($sql3);
				if($result3){
					while($row = $result3->fetch_assoc()){
						$pos = $row['vidno'] + 1;
						header("Location: ../dnevnik.php?checkupdate=".$pos);
						exit();
					}
			}
			else{
				header("Location: ../dnevnik.php?checkupdate=0");
				exit();
			}
			}
			else{
				header("Location: ../dnevnik.php?checkupdate=0&err=sql");
				exit();
			}
		}
	}
	else{
		setcookie("imeZapisa", "error", time() + (86400 * 30), "/");
		header("Location: ../dnevnik.php?checkupdate=0");
		exit();
	}
}
?>