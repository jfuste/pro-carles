<?
	session_start();
	require_once("config.php");
	// si no tenim sessió iniciada, no mostrem re
	if($_SESSION['usuari']!='') {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Edici&oacute;n de campo</title>
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
				if(isset($_POST['fAction'])) {
					$fields = array(
								"fieID" => $_POST['rfieID'],
								"fieDescription" => $_POST['rfieDescription'],
								"fieValue" => $_POST['rfieValue'],
								"fieLong" => $_POST['rfieLong'],
								"fieTable" => $_POST['rfieTable'],
								"fieField" => ''
								);
				} else {
					// Lectura DB
					$SERVIDOR="collectibles.db.7236524.hostedresource.com";
					$USUARIO="collectibles";
					$PASSWORD="c0ll3ct1bl3S";
					$BASEDATOS="collectibles";
	
					$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
					mysql_select_db($BASEDATOS, $conId) or die(mysql_error());
	
					$fields = array(
								"fieID" => 0,
								"fieDescription" => '',
								"fieValue" => '',
								"fieLong" => 0,
								"fieTable" => '',
								"fieField" => ''
								);

				}
				if(isset($_GET['id'])) {
					// Field
					$qString =  "SELECT * FROM fields WHERE fieID='".$_GET['id']."'";

					$results = mysql_query($qString, $conId);

					while ($row = mysql_fetch_array($results)) {
						$fields = array(
							"fieID" => $row['fieID'],
							"fieDescription" => utf8_encode($row['fieDescription']),
							"fieValue" => $row['fieValue'],
							"fieLong" => $row['fieLong'],
							"fieTable" => $row['fieTable'],
							"fieField" => $row['fieField']
							);
					}
				}
			?>

				<form id="formFields" name="formFields" action="actualizar_field.php" method="post">
					<label for="ffieID">ID Field</label>
					<input type="text" value="<? echo $fields["fieID"]; ?>" id="ffieID" name="ffieID" readonly>
					<label for="ffieDescription">Descripci&oacute;n</label>
					<input type="text" value="<? echo $fields["fieDescription"]; ?>" id="ffieDescription" name="ffieDescription" maxsize="50">
					<label for="fselfieValue">Tipo de campo</label>
					<select id="fselfieValue" name="fselfieValue" class="rounded">
						<?
							// per cada element, agafem el seu index i el valor
							foreach($fieldTypes as $key=>$item) {
								$selected='';
								if($key==$fields["fieValue"]) {	// si l'index es el mateix que la BD
									$selected='selected';		// el marquem com seleccionat
								}
								echo '<option value="'.$key.'" '.$selected.'>'.utf8_encode($item[0]).'</option>';
							}
						?>
					</select>
					<label for="fselfieTable">Tabla asociada</label>
					<select id="fselfieTable" name="fselfieTable" class="rounded">
     					<?
     						foreach($auxTableNames as $key) {
     							$selected='';
     							if($key==$fields["fieTable"]) {
     								$selected='selected';
     							}
     							echo '<option value="'.$key.'" '.$selected.'>'.$key.'</option>';

     						}
           				?>
					</select>
					<label for="ffieLong" >Longitud</label>
					<input type="text" value="<? echo $fields["fieLong"];?>" maxsize="4" id="ffieLong" name="ffieLong">
					<input type="submit" value="Enviar" id="fSubmit" name="fSubmit" class="button">
				</form>
				<div id="errorBox" style="float:left">
					<?
						echo $_POST['rErrorMessages'];
					?>
				</div>	
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
