<!DOCTYPE html>
<html>
<head>
	<title>Dnevnik</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/modal.css">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="body-main maxheight">

	<main>

		<h1 class="animate__animated animate__fadeInDown mainadr">Dnevnik</h1>
		<div class="main-buttons">
			<button id="open" type="button" class="btn btn-outline-primary animate__animated animate__fadeInBottomLeft btnPrijava btnMain">Prijava</button>
			<button id="open2" type="button" class="btn btn-outline-secondary animate__animated animate__fadeInBottomRight btnMain">Registracija</button>
		</div>

	</main>


<!-- Modul za registracijo in prijavo-->
	<div id="id01" class="modal">
	  <form class="modal-content animate" action="includi/login.inc.php" method="post">
	    <div class="imgcontainer">
	      <span class="close" id="close" title="Zapri okno">&times;</span>
	      <label class="formText"> Prijava</label>
	    </div>

	    <div class="container">
	      <label for="email"><b>Uporabniško ime</b></label>
	      <input class="modalInp" type="text" placeholder="Vnesite uporabniško ime..." name="up_ime" required>

	      <label for="geslo"><b>Geslo</b></label>
	      <input class="modalInp" type="password" placeholder="Vnesite geslo..." name="geslo" required>
	      
	      <div class="regPri">
	      	<button class="btn btn-primary" type="submit" name="prijava">Prijava</button>
	      	<?php
	      		if(isset($_GET['error'])){
	      			if($_GET['error']=='wrongpwd'){
	      				echo '<p class="FormError">Geslo, ki ste ga vnesli je napačno!</p>';
	      			}
	      			else if($_GET['error']=='nouser'){
	      				echo '<p class="FormError">Ta uporanik ne obstaja!</p>';
	      			}	
	      			else if($_GET['error']=='emptyfields'){
	      				echo '<p class="FormError">Prosimo izpolnite polja!</p>';
	      			}
	      		}
	      	?>
		  </div>
		</div>
	    <div class="container" style="background-color:#f1f1f1">
	      <button type="button" id="cancelbtn" class="btn btn-danger">Prekliči</button>
	    </div>
	  </form>
	</div>
	<!--Registracija novega uporabnika -->
	<div id="id02" class="modal">                             
		<form class="modal-content animate" action="includi/registracija.inc.php?registracija=0" method="post">
			<div class="imgcontainer">
		      <span class="close" id="close" title="Zapri okno">&times;</span>
		      <label class="formText">Registracija</label>
		    </div>

		    <div class="container">
		      <label for="ime"><b>Uporabniško ime</b></label>
		      <input class="modalInp" type="text" placeholder="upIme1234" name="upime" required>

		      <label for="ime"><b>Ime</b></label>
		      <input class="modalInp" type="text" placeholder="Janez" name="ime" required>

		      <label for="priimek"><b>Priimek</b></label>
		      <input class="modalInp" type="text" placeholder="Novak" name="priimek" required>

		      <label for="email"><b>E-mail</b></label>
		      <input class="modalInp" type="email" placeholder="Vnesite e-mail naslov..." name="email" required>

		      <label for="psw"><b>Geslo</b></label>
		      <input class="modalInp" type="password" placeholder="Vnesite geslo..." name="psw" required>
		      
		      <label for="psw2"><b>Ponovitev gesla</b></label>
		      <input class="modalInp" type="password" placeholder="Ponovite geslo..." name="psw2" required>

		      <div class="regPri">
		      <button class="btn btn-secondary" type="submit" name="registracija">Registracija</button>
		      <?php
	      		if(isset($_GET['message'])){
	      			if($_GET['message']=='passErr'){
	      				echo '<p class="FormError">Gesli se ne ujemata!</p>';
	      			}
	      			else if($_GET['message']=='emailErr'){
	      				echo '<p class="FormError">Uporaniški račun za ta e-poštni naslov je bil že ustvarjen!</p>';
	      			}
	      			else if($_GET['message']=='upimeErr'){
	      				echo '<p class="FormError">Uporabniško ime je že zasedeno!</p>';
	      			}
	      		}
	  			?>
		      </div>
		    </div>

		    <div class="container" style="background-color:#f1f1f1">
		      <button type="button" id="cancelbtn" class="btn btn-danger">Prekliči</button>
		    </div>
		</form>
	</div>

<script>
	var okno = document.getElementById('id01');
	var okno2 = document.getElementById('id02');
	window.onclick =(event)=>{
		if(event.target.id == 'close' || event.target.id == 'cancelbtn'){
			okno.style.display="none";
			okno2.style.display="none";
		}
		else if(event.target.id=='open'){
			okno.style.display='block';
		}
		else if(event.target.id=='open2'){
			okno2.style.display="block";
		}

	}
	if(document.getElementsByClassName("maxheight")[0]){
		document.getElementsByClassName("maxheight")[0].style.height=window.innerHeight+"px";
	}

	<?php
	if(isset($_GET['message'])){
		if($_GET['message']=="success"){
	?>
			Swal.fire({
			  icon: 'success',
			  title: 'Registracija je uspela!',
			  text: 'Preverite e-poštni predal',
			  heightAuto: false
			})
	<?php
		}
	}
	?>
</script>

</body>
</html>