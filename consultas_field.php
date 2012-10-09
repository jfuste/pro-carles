<?
	session_start();
	//si no tenim sessió iniciada, no mostrem re
	if($_SESSION['usuari']!='') {	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Fields</title>
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
			<p><b>Definici&oacute;n de campos</b></p>			
			<?
				$SERVIDOR="collectibles.db.7236524.hostedresource.com";
				$USUARIO="collectibles";
				$PASSWORD="c0ll3ct1bl3S";
				$BASEDATOS="collectibles";
				
				$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
				mysql_select_db($BASEDATOS, $conId) or die(mysql_error());
				
				// Item
				$qString = "SELECT * FROM fields";
				$results = mysql_query($qString, $conId);
			?>
				<form id="fnew" name="fnew" method="post" action="editar_field.php">
					<input type="submit" id="fsubmitNew" name="fsubmitNew" value="New" class="button">
				</form>	
				
				<table>
					<tr>
						<th>ID</th>
						<th>Descripci&oacute;n</th>
						<th>Tipo de valor</th>
						<th>Longitud</th>
						<th>Tabla</th>
						<th colspan="2">Operaciones</th>
					</tr>
			<?
				while ($row = mysql_fetch_array($results)) {
			?>		<tr>
						<td>
							<? echo $row["fieID"]; ?>
						</td>
						<td>
							<? echo utf8_encode($row["fieDescription"]); ?>
						</td>
						<td>
							<? echo $row["fieValue"]; ?>
						</td>
						<td>
							<? echo $row["fieLong"]; ?>
						</td>
						<td>
							<? echo $row["fieTable"]; ?>
						</td>
						<td>
							<a href="editar_field.php?id=<? echo $row['fieID'];?>">Editar</a>
						</td>
						<td>
							<a href="borrar_field.php?i=<? echo $row['fieID'];?>&d=<? echo $row['fieDescription'];?>&v=<? echo $row['fieValue'];?>&l=<? echo $row['fieLong'];?>&t=<? echo $row['fieTable'];?>">Borrar</a>
						</td>
					</tr>
		<?		}
		?>		</table>
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
