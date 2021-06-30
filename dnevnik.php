<?php
session_start();
if(!isset($_SESSION['up_ime'])) {
    header("Location: index.php?error=nosession");
}
require 'includi/dbccon.inc.php';

require 'header.php';
?>

	<?php 
	function createZapis($row,$conn){
	?>
	<div class="zapis-container">
				<div class="zapis-header <?php if($row['vidno']==1) echo 'zh-public'; else echo 'zh-priv'?>";>
					<div class="z-h-naslov"><?php echo $row['imeZapisa']; ?></div>
					<?php if($row['vidno']==1) {
						?>
						<form class="form-vidno" action="includi/updtVisibility.inc.php?id=<?php echo $row['id'] ?>" method="post">
							<button type="submit" style="color:green" class="butVisibility" name="posodobi"><i class="fas fa-globe-americas"></i></button>
						</form>

					<?php
					}
					else{
						?>
						<form class="form-vidno" action="includi/updtVisibility.inc.php?id=<?php echo $row['id'] ?>" method="post">
							<button type="submit" style="color:gray" class="butVisibility" name="posodobi"><i class="fas fa-globe-americas"></i></button>
						</form>
						<?php
					}
					?>


				</div>
				<div class="zapis-body">
					<?php echo $row['besedilo']; ?>

				</div>
				<div class="zapis-footer">
					<div class="z-f-user">@<?php echo $_SESSION['up_ime']; ?></div>
					<div class="z-f-upDown">
						<div class="zf-stOcen">
					<?php
						$sqlPoz = "SELECT ocena from ocena where ocena=1 and idZapisa=".$row['id'];
						$resultPoz = $conn->query($sqlPoz);
						if(mysqli_num_rows($resultPoz)>0){
							$resultPoz = mysqli_num_rows($resultPoz);
						}
						else{
							$resultPoz=0;
						}
						$sqlNeg = "SELECT ocena from ocena where ocena=0 and idZapisa=".$row['id'];
						$resultNeg = $conn->query($sqlNeg);
						if(mysqli_num_rows($resultNeg)>0){
							$resultNeg = mysqli_num_rows($resultNeg);
						}
						else{
							$resultNeg=0;
						}
						$resultFin = $resultPoz-$resultNeg;
						if($resultFin>0){
							echo '<div class="zf-poz">+'.$resultFin.'</div>';
						}
						else if($resultFin<0){
							echo '<div class="zf-neg">'.$resultFin.'</div>';
						}
						else{
							echo '<div>0</div>';
						}
					?>

				</div>
						<form action="includi/deleteZapis.inc.php?id=<?php echo $row['id'] ?>" method="post">
							<button type="submit" class="btn btn-danger btn-delZapis" name="zbrisiZapis">Izbriši</button>
						</form>
					</div>
				</div>
			</div>

		<?php 
			}
	$imeDnevnika = '';
	$sql = "SELECT imeDnevnika FROM dnevnik where idUporabnika IN (SELECT id from uporabniki WHERE up_ime = '".$_SESSION['up_ime']."')";
	$result = $conn->query($sql);
		if(mysqli_num_rows($result)>0){	
			while($row = $result->fetch_assoc()){
				$imeDnevnika = $row['imeDnevnika'];
			}
	?>

	<!-- Home page -->
	<h1 class="diaryName">Tale of <?php echo $imeDnevnika ?></h1>
	<div class="home-container">
		<div class="home-left">
			<h1 class="home-side-text">Tvoji zapisi</h1>

			<!--TODO: Bere zapise uporabnika iz baze -->
			<?php
			$sql = "SELECT * FROM zapis WHERE idDnevnika IN (SELECT id FROM dnevnik WHERE idUporabnika = ".$_SESSION['id'].") AND vidno=1 ORDER BY id desc";
			$result = $conn->query($sql);
			$sql2 = "SELECT * FROM zapis WHERE idDnevnika IN (SELECT id FROM dnevnik WHERE idUporabnika = ".$_SESSION['id'].") AND vidno=0 ORDER BY id desc";
			$result2 = $conn->query($sql2);
			if(mysqli_num_rows($result)>0 || mysqli_num_rows($result2)>0){
				echo '<div class="home-left-container">';
				if(mysqli_num_rows($result)>0){	
					echo '<div class="home-left-public">';
					echo '<h3 style="color:lightgreen">Javno</h3>';
					while($row = $result->fetch_assoc()){	
						createZapis($row,$conn);
					}	
					echo '</div>';
				}
				if(mysqli_num_rows($result2)>0){
					echo '<div class="home-left-private">';
					echo '<h3 style="color:gray">Privatno</h3>';
					while($row2 = $result2->fetch_assoc()){
						createZapis($row2,$conn);
					}
					echo '</div>';
				}
				echo '</div>';
			}
			else if(mysqli_num_rows($result)<1 && mysqli_num_rows($result2)<1){
			echo '<h4 style="margin-top:3%;">V dnevniku še nimate nobenega zapisa :(</h4>';
			}
		?>
		</div>
		<!-- end of left side -->
		<div class="home-right">
			<h1 class="home-side-text">Ustvari nov zapis</h1>
			<form class="home-form" action="includi/ustvariZapis.inc.php" method="post">
				  <div class="form-group form-group1">
				    <label for="date">Datum</label>
				    <input type="date" class="form-control datepicker" name="date" id="datepicker">
				  </div>
				  <div class="form-group form-group2">
				    <label for="naslov">Ime Zapisa</label>
				    <input type="text" class="form-control" name="naslov" id="naslov">
				  </div>
				  <div class="form-group form-group3">
				  	<label for="zapis">Povej svojo zgodbo</label>
				  	<textarea class="form-control rounded-0" id="zapis" name="zapis" rows="10"></textarea>
				  </div>
				  <label style="margin-top:4%;">Deli z drugimi</label>
				  <div class="form-group form-group4">
				  	<label  class="switch">
					  <input type="checkbox" name="stanje" id="chngState">
					  <span class="slider round"></span>
				  	</label>
				  	<label id="stanje"><span>Ne</span> <span class="stateType" >(Zapis bo viden samo vam)</span></label>
				  </div>
				  <div class="form-group form-group5">
				  	<button class="btn btn-outline-primary btn-home-form" type="submit" name="objavi">Objavi</button>
				  </div>
			</form>
		</div>
	</div>
	<?php
		}
		else{

	?>
		<h1 class="diaryName">Ustvarite svoj dnevnik :)</h1>
		<form action="includi/ustvariDnevnik.inc.php" method="post" class="form-groupUstvari">
			<div class="form-group form-groupName">
				<label for="dName">Naslov</label>
				<input type="text" name="dName" class="form-control createDiary" required>
			</div>
			<div class="form-group">
				<button class="btn btn-outline-primary btn-home-form" type="submit" name="ustvari">Ustvari</button>
			</div>
		</form>



	<?php } ?>



</body>
<script type="text/javascript" src="script/jquery.js"></script>
<script>
$('.nav-icons').children(":eq(1)").addClass("bgWhite");

document.getElementById("datepicker").valueAsDate = new Date();
$('#chngState').on("click",function(){
	let stanje=$('#stanje');
	if($(this).is(":checked")){
		stanje.children(":eq(0)").text("Da ");
		stanje.children(":eq(1)").text("(Zapis bo viden vsem)");
	}
	else{
		stanje.children(":eq(0)").text("Ne ");
		stanje.children(":eq(1)").text("(Zapis bo viden samo vam)")
	}
	
});
/*updateVisibility*/
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

let urlString=window.location.href;
let url = new URL(urlString);
let update = parseInt(url.searchParams.get("checkupdate"));
let del = parseInt(url.searchParams.get("message"));
if(update>=0){
	if(update==0){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Prišlo je do napake pri posodabljanju!',
		  heightAuto: false
		})
	}
	else if(update==1){
		Swal.fire({
		  icon: 'success',
		  title: 'Privatno',
		  text: 'Zapis "'+getCookie("imeZapisa")+'" je viden samo vam :)',
		  heightAuto: false
		})
	}
	else if(update==2){
		Swal.fire({
		  icon: 'success',
		  title: 'Javno',
		  text: 'Zapis "'+getCookie("imeZapisa")+'" je viden vsem :)',
		  heightAuto: false
		})
	}
	else if(update==3){
		Swal.fire({
		  icon: 'error',
		  title: 'Napaka',
		  text: 'Prišlo je do napake pri ustvarjanju zapisa!',
		  heightAuto: false
		})
	}
}
else if(del>=0){
	if(del==1){
		Swal.fire({
		  icon: 'success',
		  title: 'Izbrisano',
		  text: 'Zapis je bil izbrisan :)',
		  heightAuto: false
		})
	}
	else if(del==0){
		Swal.fire({
		  icon: 'success',
		  title: 'Napaka',
		  text: 'Prišlo je do napake pri brisanju zapisa !',
		  heightAuto: false
		})
	}	
}

</script>
</html>