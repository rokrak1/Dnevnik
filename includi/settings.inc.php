<?php
session_start();
 require 'dbccon.inc.php';

if(isset($_POST['chngData'])){
	$up_ime = mysqli_real_escape_string($conn, $_POST['up_ime']);
	$ime = mysqli_real_escape_string($conn, $_POST['ime']);
	$priimek = mysqli_real_escape_string($conn, $_POST['priimek']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	if(strlen($up_ime)<6){
		header("Location: ../settings.php?message=3");
		exit();
	}
	$chkUser = '';
	$sqlUp = "SELECT up_ime FROM uporabniki where id=".$_SESSION['id'];
	$resultUp = mysqli_query($conn,$sqlUp);

	if(mysqli_num_rows($resultUp)>0){
		while ($rowUp = mysqli_fetch_assoc($resultUp)){
			$chkUser = $rowUp['up_ime'];
		}
	}
		$sql = "SELECT up_ime FROM uporabniki WHERE up_ime = '".$up_ime."'";
		$result = mysqli_query($conn,$sql);
		if(mysqli_num_rows($result)>0 && $chkUser != $up_ime){
			header("Location: ../settings.php?message=4");
			exit();
		}
		else{
			$sql2 = "UPDATE uporabniki SET up_ime = '".$up_ime."', ime = '".$ime."', priimek = '".$priimek."', email = '".$email."' WHERE id=".$_SESSION['id'];
			$result2 = $conn->query($sql2);
			if($result2){
				$_SESSION['up_ime']=$up_ime;
				$_SESSION['ime']=$ime;
				$_SESSION['priimek']=$priimek;
				header("Location: ../settings.php?message=1");
				exit();
			}
			else{
				header("Location: ../settings.php?message=0");
				exit();
			}
		}

}
else if(isset($_POST['chngPsw'])){
	$pswOld = $_POST['pswOld'];	
	$psw = $_POST['psw'];	
	$psw2 = $_POST['psw2'];	

	$sql = "SELECT geslo FROM uporabniki WHERE id=".$_SESSION['id'];
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)){
			$pwdCheck = password_verify($pswOld, $row['geslo']);
			if(!$pwdCheck){
				header("Location: ../settings.php?message=5");
				exit();
			}
			else if($pwdCheck && $psw == $psw2){
				header("Location: ../settings.php?message=7");
				exit();
			}
			else if($psw == $psw2){
				$sql2 = "UPDATE uporabniki SET geslo = '".password_hash($psw, PASSWORD_DEFAULT)."' WHERE id=".$_SESSION['id'];
				$result2 = $conn -> query($sql2);
				if($result){
					header("Location: ../settings.php?message=1");
					exit();
				}
				else{
					header("Location: ../settings.php?message=0");
					exit();
				}
			}
			else{
				header("Location: ../settings.php?message=6");
				exit();
			}
		}
	}
	else{
		header("Location: ../settings.php?message=0");
		exit();
	}
}


?>
