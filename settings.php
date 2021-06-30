<?php
session_start();
if(!isset($_SESSION['up_ime'])) {
    header("Location: index.php?error=nosession");
}
require 'includi/dbccon.inc.php';
require 'header.php';
?>

	<div class="settings-container">
	<?php
	$sql = "SELECT * FROM uporabniki where id=".$_SESSION['id'];
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)>0){
		while($row = mysqli_fetch_assoc($result)){
	?>
		<h1 class="home-side-text settings-header">Uredite svoje podatke</h1>
			<form class="home-form form-inline" action="includi/settings.inc.php" method="post">
				  <div class="form-groupI">
				    <label for="up_ime">Uporabniško ime: </label>
				    <div class="input-group mb-2">
				        <div class="input-group-prepend">
				          <div class="input-group-text">@</div>
				        </div>
				    	<input required type="text" class="form-control" value="<?php echo $row['up_ime'] ?>" name="up_ime" id="up_ime">
				    </div>
				  </div>
				  <div class="form-groupI">
				    <label for="ime">Ime: </label>
				    <input required type="text" class="form-control" value="<?php echo $row['ime'] ?>" name="ime" id="ime">
				  </div>
				  <div class="form-groupI">
				  	<label for="priimek">Priimek: </label>
				  	<input required type="text" class="form-control" value="<?php echo $row['priimek'] ?>" name="priimek">
				  </div>
				  <div class="form-groupI">
				  	<label for="email">E-naslov: </label>
				  	<input required type="text" class="form-control" value="<?php echo $row['email'] ?>" name="email">
				  </div>
				  <div class="form-groupI form-group6">
				  	<button class="btn btn-outline-info btn-home-form" type="submit" name="chngData">Posodobi</button>
				  </div>
				</form>
				  <form class="home-form form-inline form-groupSplit" action="includi/settings.inc.php" method="post">
				  <div class="form-groupI">
				  	<h3>Spremeni geslo</h3>
				  </div>
				  <div class="form-groupI">
				  	<label for="pswOld">Staro geslo: </label>
				  	<input type="password" class="form-control" name="pswOld">
				  </div>
				  <div class="form-groupI">
				  	<label for="psw">Novo geslo: </label>
				  	<input type="password" class="form-control" name="psw">
				  </div>
				  <div class="form-groupI">
				  	<label for="psw2">Ponovi geslo: </label>
				  	<input type="password" class="form-control" name="psw2">
				  </div>
				  <div class="form-groupI form-group6">
				  	<button class="btn btn-outline-primary btn-home-form" type="submit" name="chngPsw">Posodobi geslo</button>
				  </div>
			</form>
			<?php
		}
	}
			 ?>
	</div>

<script type="text/javascript" src="script/jquery.js"></script>
<script type="text/javascript">
	
$('.side-settings').children(":eq(0)").addClass("bgWhite");
let urlString=window.location.href;
let url = new URL(urlString);
let update = url.searchParams.get("message");
if(parseInt(update)){
	if(parseInt(update)==1){
		Swal.fire({
		  icon: 'success',
		  title: 'Posodobljeno',
		  text: 'Vaš profil je bil posodobljen!',
		  heightAuto: false
		})
	}
	else if(parseInt(update)==0){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Prišlo je do napake pri posodabljanju!',
		  heightAuto: false
		})
	}
	else if(parseInt(update)==3){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Novo uporabniško ime je prekratko!',
		  heightAuto: false
		})
	}
	else if(parseInt(update)==4){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Uporabnik že obstaja!',
		  heightAuto: false
		})
	}
	else if(parseInt(update)==5){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Vaše staro geslo je nepravilno!',
		  heightAuto: false
		})
	}
	else if(parseInt(update)==6){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Novi gesli se ne ujemata!',
		  heightAuto: false
		})
	}
	else if(parseInt(update)==7){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Novo geslo nesme biti enako staremu !',
		  heightAuto: false
		})
	}
}
</script>
</body>
</html>