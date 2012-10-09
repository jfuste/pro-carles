<?
	session_start();
	// si no tenim sessió iniciada, no mostrem re
	if($_SESSION['usuari']!='') {	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Borrar</title>
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
				$id=$_GET['id'];
	
				$SERVIDOR="collectibles.db.7236524.hostedresource.com";
				$USUARIO="collectibles";
				$PASSWORD="c0ll3ct1bl3S";
				$BASEDATOS="collectibles";

				$conId = mysql_connect($SERVIDOR, $USUARIO, $PASSWORD) or die(mysql_error());

				mysql_select_db($BASEDATOS, $conId) or die(mysql_error());
	
//				$qs="DELETE FROM items WHERE itemID=$id";
//				mysql_query($qs);

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
