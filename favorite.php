<?php
session_start();
if(!isset($_SESSION['up_ime'])) {
    header("Location: index.php?error=nosession");
}
require 'includi/dbccon.inc.php';
require 'header.php';
?>
	<!-- End of nav -->
	<div class="public-container">
	<div class="public-home-container">
	<?php
	function showUser($idDnevnika, $conn){
		$sql = "SELECT up_ime from uporabniki where id IN (SELECT idUporabnika from dnevnik where id = ".$idDnevnika.")";
		$result = $conn -> query($sql);
		if($result){
			while($row = $result->fetch_assoc()){
				echo $row['up_ime'];
			}
		}
	}
	$sqlF = "SELECT * FROM priljubljen where idUporabnika=".$_SESSION['id']." AND stanje=1";
	$resultF = mysqli_query($conn,$sqlF);
	if(mysqli_num_rows($resultF)>0){
		while($rowF = mysqli_fetch_assoc($resultF)){
			$sql = "SELECT * FROM zapis where id=".$rowF['idZapisa'];
			$result = $conn->query($sql);
			if(mysqli_num_rows($result)>0){	
				while($row = $result->fetch_assoc()){	
					if($row['vidno']==1){
			
			?>
			<div class="zapis-container">
				<div class="zapis-header">
					<div class="z-h-naslov"><?php echo $row['imeZapisa']; ?></div>
					<form class="srck" action="includi/addFavorite.inc.php?id=<?php echo $row['id'] ?>&page=2" method="post">
						<button type="submit" name="priljubljen" class="btnPriljubljen">
							<?php
								$sqlPr = "SELECT stanje from priljubljen where idZapisa = ".$row['id']." and idUporabnika=".$_SESSION['id'];
								$resultPr = mysqli_query($conn,$sqlPr);
								if(mysqli_num_rows($resultPr)==0){
									echo '<i class="far fa-heart"></i>';
								}
								else{
									while($rowPr = mysqli_fetch_assoc($resultPr)){
										if($rowPr['stanje'] == 1){
											echo '<i class="fas fa-heart" style="color:lightcoral"></i>';
										}
										else{
											echo '<i class="far fa-heart"></i>';
										}
									}
								}
								

							?>
						</button>
					</form>
				</div>
				<div class="zapis-body">
					<?php echo $row['besedilo']; ?>

				</div>
				<div class="zapis-footer">
					<div class="z-f-user">@<?php showUser($row['idDnevnika'],$conn) ?></div>
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
							$barvaZ = 'lightgray';
							$barvaR = 'lightgray';
							$sqlChk = "SELECT ocena from ocena where idZapisa=".$row['id']." and idUporabnika=".$_SESSION['id'];
							$resultChk = $conn->query($sqlChk);
							if($resultChk){
								while($rowChk = $resultChk->fetch_assoc()){
									if($rowChk['ocena']==1){
										$barvaZ="#32CD32";
										$barvaR="lightgray";
									}
									else if($rowChk['ocena']==0){
										$barvaZ="lightgray";
										$barvaR="red";
									}
									else{
										$barvaZ = 'lightgray';
										$barvaR = 'lightgray';
									}
								}
							}
						?>

						</div>
						<form class="rate-down" action="includi/oceniZapis.inc.php?id=<?php echo $row['id']?>&page=2" method="post">
						<button class="zf-btn" type="submit" name="gor"><i style="color:<?php echo $barvaZ?>" class="fas fa-long-arrow-alt-up"></i></button>
						<button class="zf-btn" type="submit" name="dol"><i style="color:<?php echo $barvaR?>" class="fas fa-long-arrow-alt-down"></i></button>
						</form>
					</div>

				</div>
			</div>
			<?php 
					}
					else{
						?>
					<div class="zapis-container">
						<div class="zapis-header">
							<div class="zapis-remove">Zapis "<?php echo $row['imeZapisa'] ?>" je postal privaten !</div>
						</div>
						<div class="zapis-footer">
							<form class="removeFavorite" action="includi/addFavorite.inc.php?id=<?php echo $row['id'];?>&page=2" method="post">
								<button class="btn btn-danger" type="submit" name="priljubljen">Izbriši</button>
							</form>
						</div>
					</div>
					
					<?php
					}
					
				}
			}
		}
	}
	else{
	echo '<h4 style="margin-top:3%;">Shranili še niste nobenega zapisa :(</h4>';
	}
		?>
</div>
</div>
<script type="text/javascript" src="script/jquery.js"></script>
<script type="text/javascript">
	$('.nav-icons').children(":eq(2)").addClass("bgWhite");
	function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}

let urlString=window.location.href;
let url = new URL(urlString);
let update = url.searchParams.get("priljubljen");
if(parseInt(update)){
	if(parseInt(update)==1){
		Swal.fire({
		  icon: 'success',
		  title: 'Priljubljen',
		  text: 'Zapis dodan k priljubljenim!',
		  heightAuto: false
		})
	}
	else if(parseInt(update)==2){
		Swal.fire({
		  icon: 'success',
		  title: 'Odstranjeno',
		  text: 'Zapis odstranjen s priljubljenih :(',
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
}
</script>
</body>
</html>