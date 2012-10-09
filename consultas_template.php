<?
	session_start();
	//si no tenim sessió iniciada, no mostrem re
	if($_SESSION['usuari']!='') {
		$SERVIDOR="collectibles.db.7236524.hostedresource.com";
		$USUARIO="collectibles";
		$PASSWORD="c0ll3ct1bl3S";
		$BASEDATOS="collectibles";

		$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
		mysql_select_db($BASEDATOS, $conId) or die(mysql_error());
	
		if(isset($_POST['fItems'])) { // lista modificada de campos
			$qs="DELETE FROM fields_templates WHERE fitID_templates='".$_POST['fTemp']."'";
			mysql_query($qs);
			foreach ($_POST['fItems'] as $key=>$item) {
				$qs="INSERT INTO fields_templates (fitID_templates,fitID_fields) VALUES ('".$_POST['fTemp']."','".$item."')";
				mysql_query($qs);
			}
		}
		
		// ID Template
		unset($fTemp);
		if(isset($_GET['fTemp'])) {
			$fTemp=$_GET['fTemp'];
		}	
		if(isset($_POST['fTemp'])) {
			$fTemp=$_POST['fTemp'];
		}	
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
	<script>
	function leer() {
		var tpl = document.getElementById('fTemp').value;
		document.location.href="consultas_template.php?fTemp="+tpl;
	}
	</script>
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
				<p><b>Definici&oacute;n de plantillas</b></p>
			<?
				// plantilla
				$qString = "SELECT * FROM templates	ORDER BY temDescription";
				$results = mysql_query($qString, $conId);
			?>
				<form id="formItem" name="formItem" method="post">
					<label for="fTemp">Plantilla</label>
					<select id="fTemp" name="fTemp" class="rounded" onChange="leer()">
						<?
							while ($row = mysql_fetch_array($results)) {
								$selected="";
								if($row['temID']==$fTemp) {
									$selected="selected";
								}
								echo '<option value="'.$row['temID'].'" '.$selected.'>'.utf8_encode($row['temDescription']).'</option>';
							}
						?>
					</select>
					<?
						if(isset($fTemp)) { 
							// campos
							$qString2 = "SELECT fieID, fieDescription, sum(selected) as field_selected
									FROM (	
											SELECT fieID, fieDescription, '1' as selected FROM fields 
											LEFT JOIN fields_templates ON fieID=fitID_fields 
												WHERE fitID_templates='".$fTemp."'
										UNION
											SELECT fieID, fieDescription, '0' as selected FROM fields 
										) AS tempTable
										GROUP BY fieID
										ORDER BY fieDescription";
							$results2 = mysql_query($qString2, $conId);	
					
							echo '<label for="fItems">Campos</label>';
							echo '<select multiple="multiple" size="15" id="fItems" name="fItems[]" class="rounded">';
								while ($row2 = mysql_fetch_array($results2)) {
									$selected='';		// el marquem com seleccionat
									if($row2['field_selected']==1) {
										$selected="selected";
									}
									echo '<option value="'.$row2['fieID'].'" '.$selected.'>'.utf8_encode($row2['fieDescription']).'</option>';
								}	
							echo '</select>';
							echo '<input type="hidden" value="<? echo $fTemp ?>" id="varTemp" name="varTemp">';
							echo '<input type="submit" value="Enviar" id="fSubmit" name="fSubmit" class="button">';
							echo '<input type="reset" value="Restaurar lista" id="fReset" name="fReset" class="button">';
						}
					?>
				</form>
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