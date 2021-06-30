<?php

if (isset($_POST['prijava'])){

	require 'dbccon.inc.php';

	$up_ime = mysqli_real_escape_string($conn, $_POST['up_ime']);
	$geslo = mysqli_real_escape_string($conn, $_POST['geslo']);

	if(empty($geslo) || empty($up_ime)){
		header("Location: ../index.php?error=emptyfields");
		exit();
	}
	else{
		$sql = "SELECT * FROM uporabniki WHERE up_ime=?";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../index.php?error=sqlerror");
			exit();
		}
		else{
			mysqli_stmt_bind_param($stmt,"s",$up_ime);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
			if($row = mysqli_fetch_assoc($result)){
				$pwdCheck = password_verify($geslo, $row['geslo']);
				if(!$pwdCheck){
					header("Location: ../index.php?error=wrongpwd");
				}
				else if($pwdCheck){
					session_start();
					$_SESSION['id'] = $row['id'];
					$_SESSION['up_ime'] = $row['up_ime'];
					$_SESSION['ime'] = $row['ime'];
					$_SESSION['priimek'] = $row['priimek'];
					$_SESSION['dostop'] = $row['dostop'];

					header("Location: ../dnevnik.php");
					exit();
				}
			}
			else{
				header("Location: ../index.php?error=nouser");
				exit();
			}
		}
	}
}
else{
	header("Location: ../index.php?test");
}