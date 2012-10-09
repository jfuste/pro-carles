<?
	session_start();
	// si no tenim sessió iniciada, no mostrem re
	if($_SESSION['usuari']!='') {	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Borrar tablas auxiliares</title>
    <?
		require_once("css/style.css");
	?>
</head>

<body>
<div id="wrapper">
	<div id="main">
		<?
			require_once("header.php");
		?>
		<div id="body">
			<?
				require_once("menu.php");
			?>
			<div id="content">
			<?
				$id=$_GET['i'];
				$des=$_GET['d'];
				$val=$_GET['v'];
				$long=$_GET['l'];
				$tab=$_GET['t'];
				
				$SERVIDOR="collectibles.db.7236524.hostedresource.com";
				$USUARIO="collectibles";
				$PASSWORD="c0ll3ct1bl3S";
				$BASEDATOS="collectibles";

				$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
				mysql_select_db($BASEDATOS, $conId) or die(mysql_error());
			?>
				<table>
					<tr>
						<th>ID</th>
						<th>Descripci&oacute;n</th>
						<th>Tipo de valor</th>
						<th>Longitud</th>
						<th>Tabla asociada</th>
					</tr>
					<tr>
						<td>
							<? echo $id; ?>
						</td>
						<td>
							<? echo utf8_encode($des); ?>
						</td>
						<td>
							<? echo $val; ?>
						</td>
						<td>
							<? echo $long; ?>
						</td>
						<td>
							<? echo $tab; ?>
						</td>
					</tr>
				</table>
				<p>Seguro que quiere borrar el registro?</p>
				<form id="formDelete" name="formDelete" method="post" action="">
					<input type="submit" id="fYes" name="fYes" value="Si" class="button">
					<input type="submit" id="fNo" name="fNo" value="No" class="button">
				</form>
			<?	if($_POST['fYes']=="Si") {
					$qs="DELETE FROM fields WHERE fieID=$id";
					mysql_query($qs);
					echo '<script>';
					echo 'document.location.href="consultas_field.php';
					echo '</script>';
			
				}
				elseif($_POST['fNo']=="No") {
					echo '<script>';
					echo 'document.location.href="consultas_field.php"';
					echo '</script>';	
				}
			?>
			</div>
		</div>
	</div>
	<?
		require_once("footer.php");
	}	// if inicial
	?>
</div>
</body>
</html>
