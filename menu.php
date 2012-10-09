<div id="left">
	<?	if($_SESSION['usuari']!='') {	//si hem estat validats
	?>    	<div id="menu">
				<ul>
					<li>
						<a href="consultas_item.php" class="rounded">Items</a>
					</li>
					<li>
						<b>T. Auxiliares</b>
					</li>
					<li>
						<a href="consultas_field.php" class="rounded">Def. Campos</a>
					</li>
						<li>
						<a href="consultas_template.php" class="rounded">Def. Plantillas</a>
					</li>
				</ul>
			</div>
	<?
		}
	?>
</div>