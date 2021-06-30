<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['registracija'])){
	require 'dbccon.inc.php';
	$upime = $_POST['upime'];
	$ime = $_POST['ime'];
	$priimek = $_POST['priimek'];
	$email = $_POST['email'];
	$geslo = $_POST['psw'];
	$geslo2 = $_POST['psw2'];
	$dostop = 0;
	$vkey = md5(time().$email);
	if(isset($_POST['dostop'])){
		$dostop = $_POST['dostop'];
	}
	else if(isset($_GET['novuporabnik'])){
		if($_GET['novuporabnik']==1){
			$dostop = 1;
		}
	}

	if($geslo2 !== $geslo){
		header("Location: ../index.php?signup=passErr");
		exit();
	}
	else{
		$sql = "SELECT email FROM Uporabniki WHERE email=?";
		$stmt = mysqli_stmt_init($conn);
		if(!mysqli_stmt_prepare($stmt,$sql)){
			header("Location: ../index.php?error=passwordcheck=sqlerror");
		exit();
		}
		else{
			mysqli_stmt_bind_param($stmt,"s",$email);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rezultat = mysqli_stmt_num_rows($stmt);
			if($rezultat>0){
				header("Location: ../index.php?message=emailErr");
				exit();
			}
			$sql2 = "SELECT up_ime FROM Uporabniki WHERE up_ime = '".$upime."'";
			mysqli_stmt_prepare($stmt,$sql2);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			$rezultat = mysqli_stmt_num_rows($stmt);
			if($rezultat>0){
				header("Location: ../index.php?message=upimeErr");
				exit();
			}
			else{

				$sql = "INSERT INTO Uporabniki (up_ime,ime,priimek,email,geslo,dostop,vkey) VALUES (?,?,?,?,?,?,?)";
				$stmt = mysqli_stmt_init($conn);
				if(!mysqli_stmt_prepare($stmt,$sql)){
					header("Location: ../index.php?error=sqlerrorInput");
					exit();
				}
				else{
					$hashpsw=password_hash($geslo, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($stmt,"sssssss",$upime,$ime,$priimek,$email,$hashpsw,$dostop,$vkey);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_store_result($stmt);
					if(isset($_GET['registracija'])){
						if($_GET['registracija']==0){

							//Load Composer's autoloader
							require './PHPMailer/PHPMailerAutoload.php';

							//Instantiation and passing `true` enables exceptions
							$mail = new PHPMailer(true);
							try {
							    //Server settings
							    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
							    $mail->isSMTP();                                            //Send using SMTP
							    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
							    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
							    $mail->Username   = 'email';                     //SMTP username
							    $mail->Password   = 'pass';                               //SMTP password
							    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
							    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

							    //Recipients
							    $mail->setFrom('registracija@dnevnik.com', 'Registracija');
							    $mail->addAddress($email);     //Add a recipient 

							    //Content
							    $mail->isHTML(true);                                  //Set email format to HTML
							    $mail->Subject = 'Potrditev registracije';
							    $mail->Body    = 'Za potrditev registracije pritisnite <a href="localhost/dnevnik/uspesnaAktivacija.php?vkey='.$vkey.'">tukaj</a>.';

							    $mail->send();
							    echo 'Message has been sent';
							    header("Location: ../uspesnaAktivacija.php?aktivacija=success");
								exit();
							} catch (Exception $e) {
							    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
							    header("Location: ../uspesnaAktivacija.php?aktivacija=error");
							    exit();
							}
						}
					}
					
					if($result>0){
						header("Location: ../index.php?message=success");
						exit();
					}
					
				}
			}
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
else{
	header("Location: ../index.php");
	exit();
}