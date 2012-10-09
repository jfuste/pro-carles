<?
	session_start()
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Collectibles</title>
    <?
		require_once("css/style.css");
	?>
	<script>
		function clean(q) {
			q.value='';
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
				<?
					if($_SESSION['usuari']=='') {	// si no tenim usuari
				?>
						<div id="login">
							<form id="fLogin" name="fLogin" method="post" action="validarLogin.php">
								<fieldset id="fsLogin" name="fsLogin" class="rounded">
									<label for="fUsuari">Usuari</label>
									<input type="text" id="fUsuari" name="fUsuari" onFocus="clean(this)">
									<label for="fPasswd">Password</label>
									<input type="password" id="fPasswd" name="fPasswd" onFocus="clean(this)">
									<input type="submit" id="fSubmit" name="fSubmit" value="Login" class="button">
								</fieldset>
							</form>
						</div>
						<?
							if($_SESSION['errorUsuario']==1) {
								echo '<p>Usuario incorrecto!</p>';
								$_SESSION['errorUsuario']=0;
							}
						?>
				<?	}
					else {	// un cop entrades les dades
						if(isset($_SESSION['usuari'])) {
							echo '<p>Usuario correcto!</p>';
						}
					}
				?>
			</div>
		</div>
	</div>
	<?
		require_once("footer.php");
	?>
</div>
</body>
</html>
