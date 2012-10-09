<?
	session_start();
	//si no tenim sessió iniciada, no mostrem re
	if($_SESSION['usuari']!='') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Templates</title>
    <?
		require_once("css/style.css");
		require_once("funciones.php");
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
			<p><b>Consulta de items</b></p>
			<?
				$SERVIDOR="collectibles.db.7236524.hostedresource.com";
				$USUARIO="collectibles";
				$PASSWORD="c0ll3ct1bl3S";
				$BASEDATOS="collectibles";

				$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
				mysql_select_db($BASEDATOS, $conId) or die(mysql_error());

				// Item
				$qString = "SELECT * FROM templates	ORDER BY temDescription";
				$results = mysql_query($qString, $conId);

			?>
				<form id="formItem" name="formItem" method="post">
					<label for="fTemp">Tipo de plantilla</label>
					<select id="fTemp" name="fTemp" class="rounded">
						<?
							while ($row = mysql_fetch_array($results)) {
								$selected='';
								if($row['temID']==$_POST['fTemp']) {
									$selected='selected';
								}
								echo '<option '.$selected.' value="'.$row['temID'].'">'.utf8_encode($row['temDescription']).'</option>';
							}
						?>
					</select>
					<input type="submit" value="Enviar" id="fSubmit" name="fSubmit" class="button">
				</form>
			<?
				if(isset($_POST['fTemp'])) {
					$SERVIDOR="collectibles.db.7236524.hostedresource.com";
					$USUARIO="collectibles";
					$PASSWORD="c0ll3ct1bl3S";
					$BASEDATOS="collectibles";

					$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());

					mysql_select_db($BASEDATOS, $conId) or die(mysql_error());

					$qString = "SELECT * FROM items LEFT JOIN aux_countries ON itemID_countries=couID
								WHERE '".$_POST['fTemp']."'=itemID_templates ORDER BY itemID";
					$results = mysql_query($qString, $conId);
				?>
					<table>
						<tr>
							<th>ID</th>
							<th>T&iacute;tulo</th>
							<th>Subt&iacute;tulo</th>
							<th>&Eacute;poca</th>
							<th>Pa&iacute;s</th>
							<?
								// guardamos las cabeceras para saber que valores pintar
								$resultats=cargarPlantilla($_POST['fTemp'],0,0,0); // plantilla, tipoCargar, ID, cabeceras
                            ?>
							<th colspan="2">Operaciones</th>
						</tr>
				<?
					while ($row = mysql_fetch_array($results)) {
				?>		<tr>
							<td>
								<? echo $row["itemID"]; ?>
							</td>
							<td>
								<? echo utf8_encode($row["itemTitle"]); ?>
							</td>
							<td>
								<? echo utf8_encode($row["itemSubtitle"]); ?>
							</td>
							<td>
								<? echo $row["itemEpoch"]; ?>
							</td>
							<td>
								<? echo utf8_encode($row["couName"]); ?>
							</td>
							<? cargarPlantilla($_POST['fTemp'],1,$row["itemID"],$resultats); ?>
							<td>
								<a href="editar_item.php?id=<? echo $row['itemID'];?>&temp=<? echo $_POST['fTemp'];?>">Editar</a>
							</td>
							<td>
								<a href="borrar_item.php?id=<? echo $row['itemID'];?>&temp=<? echo $_POST['fTemp'];?>">Borrar</a>
							</td>
						</tr>
			<?		}
					echo '</table>';
				}
		?>
			</div>
		</div>
	</div>
	<?
		require_once("footer.php");
	}	//if inicial
	?>
</div>
</body>
</html>