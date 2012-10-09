<?
	session_start();
	// si no tenim sessió iniciada, no mostrem re
	if($_SESSION['usuari']!='') {
		print_r($_POST);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Edici&oacute;n de item</title>
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
				$SERVIDOR="collectibles.db.7236524.hostedresource.com";
				$USUARIO="collectibles";
				$PASSWORD="c0ll3ct1bl3S";
				$BASEDATOS="collectibles";
	
				$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
				mysql_select_db($BASEDATOS, $conId) or die(mysql_error());			
				
				if(isset($_POST['fAction'])) {
					$fitemID_templates=$_POST['rfitemID_templates'];
					$fitemID=$_POST['rfitemID'];
					$fitemTitle=$_POST['rfitemTitle'];
					$fitemSubtitle=$_POST['rfitemSubtitle'];
					$fitemEpoch=$_POST['rfitemEpoch'];
					$fitemID_countries=$_POST['rfselcouName'];
				}
				else {
					// Item
					$qString =  "SELECT * FROM items
									LEFT JOIN fields_templates ON itemID_templates=fitID_templates
									LEFT JOIN fields ON fitID_fields=fieID
									LEFT JOIN valdata ON itemID=valID_items AND valID_fields=fieID
										WHERE itemID='".$_GET['id']."'";
	
					$results = mysql_query($qString, $conId);
	
					$n=0;
					$fFields = array();
	
					while ($row = mysql_fetch_array($results)) {
						if($n==0) {	// Camps generals, només calen un cop
							$fitemID_templates=$row["itemID_templates"];
							$fitemID=$row["itemID"];
							$fitemTitle=$row["itemTitle"];
							$fitemSubTitle=$row["itemSubTitle"];
							$fitemEpoch=$row["itemEpoch"];
							$fitemID_countries=$row["itemID_countries"];
						}
	
						// Camps de template (no savem quants n'hi haurà)
						$item = array(
							"valID" => $row['valID'],
							"valID_items" => $row['valID_items'],
							"valID_fields" => $row['valID_fields'],
							"valNum" => $row['valNum'],
							"valBool" => $row['valBool'],
							"valVarchar" => $row['valVarchar'],
							"valText" => $row['valText'],
							"valDate" => $row['valDate'],
							"valFloat" => $row['valFloat'],
							"valList" => $row['valList'],
							"valMultipleList" => $row['valMultipleList'],
							"fieID" => $row['fieID'],
							"fieDescription" => utf8_encode($row['fieDescription']),
							"fieValue" => $row['fieValue'],
							"fieLong" => $row['fieLong'],
							"fieTable" => $row['fieTable'],
							"fieField" => $row['fieField']
							);
						array_push($fFields,$item);
	
					}
				}	
					// Paisos
					$qString = "SELECT * FROM aux_countries ORDER BY couName";
					$results2 = mysql_query($qString, $conId);
					$aux_countries=array();
					// Ens quedem els paisos a partir dels ID de la forma: "index de l'array countries[couID]" = couName
					while ($row2 = mysql_fetch_array($results2)) {
						$aux_countries[$row2["couID"]] = $row2["couName"];
					}
	
					// Encuadernaciones
					$qString = "SELECT * FROM aux_bindings ORDER BY binDescription";
					$results3 = mysql_query($qString, $conId);
					$aux_bindings=array();
					while ($row3 = mysql_fetch_array($results3)) {
						$aux_bindings[$row3["binID"]] = $row3["binDescription"];
					}
	
					// Editoriales
					$qString = "SELECT * FROM aux_editorials ORDER BY edName";
					$results4 = mysql_query($qString, $conId);
					$aux_editorials=array();
					while ($row4 = mysql_fetch_array($results4)) {
						$aux_editorials[$row4["edID"]] = $row4["edName"];
					}

			?>

				<form id="formItem" name="formItem" action="actualizar_item.php" method="get">
					<label for="fitemID_templates">ID plantilla</label>
					<input type="text" value="<? echo $fitemID_templates; ?>" id="fitemID_templates" name="fitemID_templates" readonly>
					<label for="fitemID">ID item</label>
					<input type="text" value="<? echo $fitemID; ?>" id="fitemID" name="fitemID" readonly>
					<label for="fitemTitle">T&iacute;tulo</label>
					<input type="text" value="<? echo utf8_encode($fitemTitle); ?>" id="fitemTitle" name="fitemTitle">
					<label for="fitemSubtitle">Subt&iacute;tulo</label>
					<input type="text" value="<? echo utf8_encode($fitemSubtitle); ?>" id="fitemSubtitle" name="fitemSubtitle">
					<label for="fitemEpoch">&Eacute;poca</label>
					<input type="text" value="<? echo $fitemEpoch; ?>" id="fitemEpoch" name="fitemEpoch" maxlength="4" size="4">
					<label for="fcouName">Pa&iacute;s</label>
					<select id="fselcouName" name="fselcouName" class="rounded">
						<?
							// per cada element, agafem el seu index i el valor
							foreach($aux_countries as $key=>$item) {
								$selected='';
								if($key==$fitemID_countries) {	// si l'index es el mateix que la BD
									$selected='selected';		// el marquem com seleccionat
								}
								echo '<option value="'.$key.'" '.$selected.'>'.utf8_encode($item).'</option>';
							}
						?>
					</select>
				<?
					// Pintem cada camp que hem carregat a $fFields
					foreach($fFields as $fields) {
						// Para controlar si existe el campo y no salga valores raros
						if($fields['fieID']==$fields['valID_fields']) {
							$validData=true;
						}
						else {
							$validData=false;
						}
						echo '<label for="ffield'.$fields['fieID'].'">'.$fields['fieDescription'].'</label>';
						// Segons el valor que tinguem, pintem el que toqui
						switch($fields['fieValue']) {
							case 'N':	// numeric
							case 'V':	// varchar
							case 'D':	// data
							case 'F':	// float
								switch($fields['fieValue']) {
									case 'N':
										$tempValue=($validData ? $fields['valNum'] : 0);
										break;
									case 'V':
										$tempValue=($validData ? utf8_encode($fields['valVarchar']) : '');
										break;
									case 'D':
										$tempValue=($validData ? $fields['valDate'] : '0000-00-00');
										break;
									case 'F':
										$tempValue=($validData ? $fields['valFloat'] : 0);
										break;
								}
								$sized='';
								if($fields['fieLong']>0) {
									$sized=' size="'.$fields['fieLong'].'" maxlength="'.$fields['fieLong'].'"';
								}
								echo '<input type="text" value="'.$tempValue.'" id="ffield'.$fields['fieID'].'" name="ffield'.$fields['fieID'].'"  '.$sized.'>';
								break;
							case 'B':	// bool
								$tempValue=($validData ? $fields['valBool'] : 0);
								$tempChecked=($tempValue==1 ? 'checked' : '');

								echo '<input type="checkbox" value="'.$tempValue.'" '.$tempChecked.'
										id="ffield'.$fields['fieID'].'" name="ffield'.$fields['fieID'].'">';
								break;
							case 'T':	// text
								$tempValue=($validData ? utf8_encode($fields['valText']) : '');

								echo '<textarea class="rounded" id="ffield'.$fields['fieID'].'" name="ffield'.$fields['fieID'].'">'.$tempValue.'</textarea>';
								break;
							case 'L':	// list
								$tempValue=($validData ? trim($fields['valList']) : 0);
								$tname=$fields['fieTable'];	//nom de la taula
								echo '<select id="fsel'.$fields['fieID'].'" name="fsel'.$fields['fieID'].'" class="rounded">';
								// per cada element, agafem el seu index i el valor
								foreach($$tname as $key=>$item) {
									$selected='';
									if($key==$tempValue) {	// si l'index es el mateix que la BD
										$selected='selected';		// el marquem com seleccionat
									}
									echo '<option value="'.$key.'" '.$selected.'>'.utf8_encode($item).'</option>';
								}
								echo '</select>';
								break;
							case 'ML':	// multiple list
								$tempValue=($validData ? trim($fields['valMultipleList']) : '');
								$tempArray=explode(",",$tempValue);
								$tname=$fields['fieTable'];	//nom de la taula

								echo '<select multiple="multiple" id="fsel'.$fields['fieID'].'" name="fsel'.$fields['fieID'].'" class="rounded">';
								// per cada element, agafem el seu index i el valor
								foreach($$tname as $key=>$item) {
									$selected='';
									if(in_array($key,$tempArray)) {	// si l'index es el mateix que la BD
										$selected='selected';		// el marquem com seleccionat
									}
									echo '<option value="'.$key.'" '.$selected.'>'.utf8_encode($item).'</option>';
								}
								echo '</select>';
								break;
						}
					}
				?>
					<input type="submit" value="Enviar" id="fSubmit" name="fSubmit" class="button">
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
