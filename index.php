<?php
require('back.php');
$fin;
$keys;

session_start();
$tictac = new tictac();
$tictac->pasar_turno();

if (isset($_POST['reset'])) {
	session_unset();
	session_destroy();
	header("location: index.php");
}

if (isset($_GET['casilla'])) {
	$keys = array_keys($_GET['casilla']);
	$_SESSION['marcados'][$keys[0]] = $_SESSION['jugador'];
	$tictac->cambio_jugador();
}

$ganador = $tictac->verificar_ganador();

if ($ganador) {
	$fin = 1;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>TIC TAC</title>
		<style>
			.container{
				text-align: center;
			}

			.margin_auto{
				margin: 0 auto;
			}

			.width_50{
				width: 50%;
			}

			table{
				border-collapse: collapse;
			}
			td{
				border: 1px solid black;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<h3>Bienvenidos al tic tac toe</h3>
			<div class="margin_auto width_50">
				<form action="index.php" method="GET" class="margin_auto width_50">
					<table class="margin_auto width_50">
						<?php
						for ($i=0; $i < 3; $i++) { 
							echo '<tr>';

							for ($j=0; $j < 3; $j++) { 
								if ($i == 0) {
									$z = $j + 1;

									if (isset($_SESSION['marcados'][$z])) {
										if (!empty($fin) && ($z == $ganador[0] || $z == $ganador[1] || $z == $ganador[2])){
											echo "<td><input disabled type='submit' style='font-weight: bold;' name='"."casilla[$z]"."' value=".$_SESSION['marcados'][$z]."></td>";
										} else {
											echo "<td><input disabled type='submit' name='"."casilla[$z]"."' value=".$_SESSION['marcados'][$z]."></td>";
										}
										
									} else if (!empty($fin)) {
										echo "<td><input disabled type='submit' name='"."casilla[$z]"."' value=''></td>";
									} else {
										echo "<td><input type='submit' name='"."casilla[$z]"."' value=''></td>";
									}
								} else if ($i == 1) {
									$x = $j + 4;

									if (isset($_SESSION['marcados'][$x])) {
										if (!empty($fin) && ($x == $ganador[0] || $x == $ganador[1] || $x == $ganador[2])){
											echo "<td><input disabled type='submit' style='font-weight: bold;' name='"."casilla[$x]"."' value=".$_SESSION['marcados'][$x]."></td>";
										} else {
											echo "<td><input disabled type='submit' name='"."casilla[$x]"."' value=".$_SESSION['marcados'][$x]."></td>";
										}
									} else if (!empty($fin)) {
										echo "<td><input disabled type='submit' name='"."casilla[$x]"."' value=''></td>";
									} else {
										echo "<td><input type='submit' name='"."casilla[$x]"."' value=''></td>";
									}
								} else {
									$y = $j + 7;

									if (isset($_SESSION['marcados'][$y])){
										if (!empty($fin) && ($y == $ganador[0] || $y == $ganador[1] || $y == $ganador[2])){
											echo "<td><input disabled type='submit' style='font-weight: bold;' name='"."casilla[$y]"."' value=".$_SESSION['marcados'][$y]."></td>";
										} else {
											echo "<td><input disabled type='submit' name='"."casilla[$y]"."' value=".$_SESSION['marcados'][$y]."></td>";
										}
									} else if (!empty($fin)) {
										echo "<td><input disabled type='submit' name='"."casilla[$y]"."' value=''></td>";
									} else {
										echo "<td><input type='submit' name='"."casilla[$y]"."' value=''></td>";
									}
								}
							}

							echo '</tr>';
						}
						?>
					</table>
				</form>
			</div>
			<div class="margin_auto width_50">
				<div class="margin_auto width_50" style="<?php if(isset($_GET['casilla'])){ echo 'display: none'; }?>">
					<h4>Decide quien juega primero: </h4>
					<form action="index.php" method="POST">
						<div>
							<?php
								if(isset($_POST['dado'])){
									$adivinar = $tictac->lanzar_dado($_POST['adivinar']);
									$dado = $tictac->get_dado();
									echo "<h4>$dado</h4>";
									if($adivinar === TRUE){
										echo "El jugador que ha lanzado el dado juega primero";
									} else {
										echo "El otro jugador juega primero";
									}
								}
							?>
							<div>
								<label for="par">Par</label>
								<input <?php if(isset($_POST['adivinar'])&&$_POST['adivinar']=='par'){echo "checked ";} ?>id="par" type="radio" name="adivinar" value="par">
							</div>
							<div>
								<label for="impar">Impar</label>
								<input <?php if(isset($_POST['adivinar'])&&$_POST['adivinar']=='impar'){echo "checked ";} ?> id="impar" type="radio" name="adivinar" value="impar">
							</div>
							<div>
								<?php
								if (isset($_POST['dado'])) {
									echo "<input disabled type='submit' name='dado' value='lanzar dado'>";
								} else {
									echo "<input type='submit' name='dado' value='lanzar dado'>";
								}
								?>
							</div>
						</div>
					</form>
				</div>
				<div>
					<form action="index.php" method="POST">
						<input type="submit" name='reset' value='reiniciar partida'>
					</form>
				</div>
				<div>
					<?php
					if (!empty($fin)) {
						$tictac->cambio_jugador();
						echo "<h4>El jugador ".$_SESSION['jugador']." ha ganado</h4>";
					} else if ($_SESSION['turno'] == 9) {
						echo "<h3>EMPATE</h3>";
					}
					?>
				</div>
			</div>
		</div>
	</body>
</html>