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
    <title>Actualizar item</title>
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
			<?
				// Validació de dades
				$errorItems=0;
				$errorMessages = array();
				
				// Validar titol: valor obligatori
				if(trim($_GET['fitemTitle'])=='') {
					$errorItems++;
					$errorMessages[]="T&iacute;tulo requerido.";
				}
				
				$id=$_GET['fitemID'];	//ID del item
				
				if($errorItems>0) {
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
							$qs = "UPDATE items SET itemTitle='".$_GET['fitemTitle']."', itemSubtitle='".$_GET['fitemSubtitle']."', itemEpoch='".$_GET['fitemEpoch']."', itemID_countries='".$_GET['fselcouName']."', itemID_templates='".$_GET['fitemID_templates']."' WHERE itemID='".$id."'";
							mysql_query($qs);
							$numRows=mysql_affected_rows();
							if($numRows>0) {
								// guardarDatos($id,$_GET['fitemID_templates']);	// campos especificos de cada plantilla
								echo "Registro modificado<br>";
								$errordb=0;
							}
							else {
								echo "No se ha podido modificar el registro<br>";
								$errordb=1;
							}
							$returnID=$id;
							break;
					}	
				}
			?>
				<form id="formReturn" name="formReturn" method="post" action="<? echo ($errordb>0 ? "editar_item.php" : "consultas_item.php"); ?>">
					<input type="hidden" id="fError" name="fError" value="<? echo $errordb ?>">
					<input type="hidden" id="fAction" name="fAction" value="1">
					<input type="hidden" id="rfitemID" name="rfitemID" value="<? echo ($errorItems>0 ? $id : $returnID); ?>">
					<input type="hidden" id="rfitemID_templates" name="rfitemID_templates" value="<? echo $_GET['fitemID_templates'] ?>">
					<input type="hidden" id="rfitemTitle" name="rfitemTitle" value="<? echo $_GET['fitemTitle'] ?>">
					<input type="hidden" id="rfitemSubtitle" name="rfitemSubtitle" value="<? echo $_GET['fitemSubtitle'] ?>">
					<input type="hidden" id="rfitemEpoch" name="rfitemEpoch" value="<? echo $_GET['fitemEpoch'] ?>">
					<input type="hidden" id="rfselcouName" name="rfselcouName" value="<? echo $_GET['fselcouName'] ?>">					
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