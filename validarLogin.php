<?
	session_start();

	$SERVIDOR="collectibles.db.7236524.hostedresource.com";
	$USUARIO="collectibles";
	$PASSWORD="c0ll3ct1bl3S";
	$BASEDATOS="collectibles";

	$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());

	mysql_select_db($BASEDATOS, $conId) or die(mysql_error());

	$qString = "SELECT * FROM logins WHERE logName='".$_POST['fUsuari']."' AND logPassword='".$_POST['fPasswd']."'";

	$results = mysql_query($qString, $conId);
	
	$n=0;
	if(mysql_num_rows($results)>0) {
		while ($row = mysql_fetch_array($results)) {
			$_SESSION['usuari']=$row["logName"];
			$_SESSION['nivell']=$row["logLevel"];
			$n++;
		}
	}
	else {
		unset($_SESSION['usuari']);
		unset($_SESSION['nivell']);
		$_SESSION['errorUsuario']=1;
	}
	mysql_free_result($results);
?>	
	<script>
		document.location.href="index.php";
	</script>