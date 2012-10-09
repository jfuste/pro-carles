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
    <title>Actualizar campo</title>
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
				// Validació de dades
				$errorFields=0;
				$errorMessages = array();
				
				// Validar descripcio: valor obligatori
				if(trim($_POST['ffieDescription'])=='') {
					$errorFields++;
					$errorMessages[]="Descripci&oacute;n requerida.";
				}
				
				// Validar value
				switch($_POST['fselfieValue']) {
					case 'N':
					case 'F': 
						if(($_POST['ffieLong']<1) || ($_POST['ffieLong']>11)) {
								$errorFields++;
								$errorMessages[]="La longitud debe estar entre 1 y 11.";
						}		
						break;
					case 'V': 
						if(($_POST['ffieLong']<1) || ($_POST['ffieLong']>256)) {
								$errorFields++;
								$errorMessages[]="La longitud debe estar entre 1 y 256.";
						}	
						break;
					case 'D': 
						if(($_POST['ffieLong']<1) || ($_POST['ffieLong']>10)) {
								$errorFields++;
								$errorMessages[]="La longitud debe estar entre 1 y 10.";
						}	
						break;
					case 'H': 
						if(($_POST['ffieLong']<1) || ($_POST['ffieLong']>8)) {
								$errorFields++;
								$errorMessages[]="La longitud debe estar entre 1 y 8.";
						}	
						break;
				}
				
				$id=$_POST['ffieID'];	//ID del field
				
				if($errorFields>0) {
					// Tornem al formulari
					$errordb=1;
					$errorMessagesText=implode("<br>",$errorMessages);
				} else {
					$SERVIDOR="collectibles.db.7236524.hostedresource.com";
					$USUARIO="collectibles";
					$PASSWORD="c0ll3ct1bl3S";
					$BASEDATOS="collectibles";
	
					$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
					mysql_select_db($BASEDATOS, $conId) or die(mysql_error());
	
					switch($id) {
						// Nuevo field
						case 0:
							$qs = "INSERT INTO fields (fieDescription, fieValue, fieTable, fieLong) VALUES ('".$_POST['ffieDescription']."','".$_POST['fselfieValue']."', '".$_POST['fselfieTable']."', '".$_POST['ffieLong']."')";
							mysql_query($qs, $conId);
							$newID=mysql_insert_id();
							if($newID>0) {
								echo "Registro insertado<br>";
								$errordb=0;
								$returnID=$newID;
							}
							else {
								echo "Error en inserci&oacute;n<br>";
								$errordb=1;
								$returnID=0;
							}
							break;
						// Editar field	
						default:
							$qs = "UPDATE fields SET fieDescription='".$_POST['ffieDescription']."', fieValue='".$_POST['fselfieValue']."', fieTable='".$_POST['fselfieTable']."', fieLong='".$_POST['ffieLong']."' WHERE fieID='".$id."'";
							mysql_query($qs);
							$numRows=mysql_affected_rows();
							if($numRows>0) {
								echo "Registro modificado<br>";
								$errordb=0;
							}
							else {
								echo "Error en modificaci&oacute;n<br>";
								$errordb=1;
							}
							$returnID=$id;
							break;
					}	
				}
						
			?>
				<form id="formReturn" name="formReturn" method="post" action="<? echo ($errordb>0 ? "editar_field.php" : "consultas_field.php"); ?>">
					<input type="hidden" id="fError" name="fError" value="<? echo $errordb ?>">
					<input type="hidden" id="fAction" name="fAction" value="1">
					<input type="hidden" id="rfieID" name="rfieID" value="<? echo ($errorFields>0 ? $id : $returnID); ?>">
					<input type="hidden" id="rfieDescription" name="rfieDescription" value="<? echo $_POST['ffieDescription'] ?>">
					<input type="hidden" id="rfieValue" name="rfieValue" value="<? echo $_POST['fselfieValue'] ?>">
					<input type="hidden" id="rfieTable" name="rfieTable" value="<? echo $_POST['fselfieTable'] ?>">
					<input type="hidden" id="rfieLong" name="rfieLong" value="<? echo $_POST['ffieLong'] ?>">
					<input type="hidden" id="rErrorMessages" name="rErrorMessages" value="<? echo $errorMessagesText; ?>">
					<input type="submit" id="fSubmit" name="fSubmit" value="Volver">
				</form>

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
