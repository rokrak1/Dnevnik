
<?php

$server = "localhost";
$username = "root";
$password = "";
$dBName = "dnevnik";

$conn = mysqli_connect($server,$username,$password,$dBName);

if(!$conn){
	die("Povezava v bazo ni bila vzpostavljena:".mysqli_connect_error());
}