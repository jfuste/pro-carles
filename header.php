<div id="header">
	<div id="title">
		<a href="http://collectibles.joanfuste.com"><h1>Collectibles</h1></a>
	</div>
	<div id="connexio">
		<?
			if($_SESSION['usuari']!='') {
		?>		<form id="fLogout" name="fLogout" action="logout.php" method="post">
					<input type="submit" name="fSubmit" id="fSubmit" value="Desconectar">
				</form>
		<? }
		?>
	</div>
</div>
