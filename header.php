<!DOCTYPE html>
<html>
<head>
	<title>Dnevnik</title>
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<!--pisave-->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
	<!--mycss-->
	<link rel="stylesheet" type="text/css" href="style.css">
	<!--fa-->
	<link href="fa/css/fontawesome.css" rel="stylesheet">
    <link href="fa/css/brands.css" rel="stylesheet">
    <link href="fa/css/solid.css" rel="stylesheet">
    <link href="fa/css/regular.min.css" rel="stylesheet">
	<!--sweetalert-->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
	<nav>
		<a href="dnevnik.php" class="nav">
			<img src="slike/logo.png">
			<span>Dnevnik</span>
		</a>
		<div class="nav-icons">
			<a href="publicTales.php" style="color:lightblue"><i class="fas fa-globe-americas"></i></a>
			<a href="dnevnik.php" style="color:gray;"><i class="fas fa-book"></i></a>
			<a href="favorite.php" style="color:lightcoral"><i class="fas fa-heart"></i></a>
		</div>
		<div class="nav-right">
			<div class="nav-user"><?php echo $_SESSION['ime']." ".$_SESSION['priimek']?></div>
			<div class="side-settings">
			<a href="settings.php" style="color:gray"><i class="fas fa-cog"></i></a>
			<form action="includi/logout.inc.php" method="post"><button class="btnOdjava" type="submit"><i class="fas fa-sign-out-alt"></i></button></form>
			</div>
		</div>
	</nav>