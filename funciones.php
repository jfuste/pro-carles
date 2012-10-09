<?
function cargarPlantilla($plantilla,$seccion,$itemID,$aValFie) {
	$SERVIDOR="collectibles.db.7236524.hostedresource.com";
					$USUARIO="collectibles";
					$PASSWORD="c0ll3ct1bl3S";
					$BASEDATOS="collectibles";

					$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());
					mysql_select_db($BASEDATOS, $conId) or die(mysql_error());

	switch ($itemID) {
		case 0:	// cabeceras
			$qs="SELECT * FROM fields_templates
			LEFT JOIN fields ON fieID=fitID_fields
			WHERE fitID_templates='".$plantilla."'
			ORDER BY fieID";
			break;
		default:	// valores
			$qs="SELECT * FROM fields_templates
			LEFT JOIN fields ON fieID=fitID_fields
			LEFT JOIN valdata ON valID_fields=fitID_fields
			WHERE fitID_templates='".$plantilla."' AND valID_items='".$itemID."'
			ORDER BY fieID";
			break;
	}

	$results = mysql_query($qs, $conId);

	$aValueFields=array();
    // contador para los campos pintados
	$n=0;

	while ($row = mysql_fetch_array($results)) {
		switch($seccion) {
			case 0:
				echo '<th>'; echo utf8_encode($row['fieDescription']); echo '</th>';
				$aValueFields[]=$row['fieID']; // guardamos las cabeceras pintadas, para saber que campos pintar
				break;
			case 1:
				$findkey=array_keys($aValFie,$row['valID_fields']); // cogemos el ID del campo a pintar
				$m=0;   // nos dirá cuantos campos de diferencia hay entre el actual y el anterior
				if($n<$findkey[0]) {	// si llevamos menos campos que el ID, debemos pintar en blanco
					for($k=0;$k<($findkey[0]-$n);$k++) {
						echo '<td></td>';
						$m++;
					}
				}

				$m++;
				echo '<td>';
				switch($row['fieValue']) {
					case 'N':
						echo $row['valNum'];
						break;
					case 'B':
						echo $row['valBool'];
						break;
					case 'V':
						echo $row['valVarchar'];
						break;
					case 'T':
						echo $row['valText'];
						break;
					case 'D':
						echo $row['valDate'];
						break;
					case 'H':
						echo $row['valHour'];
						break;
					case 'F':
						echo $row['valFloat'];
						break;
					case 'L':
						echo $row['valList'];
						break;
					case 'ML':
						echo $row['valMultipleList'];
						break;
				}
				echo '</td>';
		}
		$n+=$m;
	}
	// si no hay ningun valor, debemos pintar todos los campos en blanco segun las cabeceras
	if($n<count($aValFie) and $seccion==1) {
		for($k=0;$k<(count($aValFie)-$n);$k++) {
			echo '<td></td>';
		}
	}
    // cabeceras pintadas
	return $aValueFields;
}

/*

function guardarDatos($id,$temp) {
	switch ($temp) {
		case 1:
	}
}

*/

?>