<?php
	include 'funciones.php';
	session_name('sesion');
	session_start();
	if(!isset($_SESSION['nombre_usuario']))
	{
		echo "<p>Registrese por favor</p>";
		exit(0);	
	}
?>
<html>
	<head>
		<style>
			body
			{
				font-family:Arial;
			}
			div#cabecera
			{
				width:100%;
				background-color:black;
				height:5%;
				color:white;
				margin-bottom:10px;
			}
			span#izquierdo
			{
				float:left;
				margin-top:10px;
				margin-left:10px;
			}
			a#derecho
			{
				float:right;
				margin-top:10px;
				margin-right:10px;
				color:white;
				font-family:Arial;
				text-decoration:none;
			}
			div#personajes
			{
				width:43%;
				height:90%;
				border:1px solid black;
				float:left;
			}
			div#nuevo
			{
				width:43%;
				height:90%;
				border:1px solid black;
				float:right;
				padding:10px;
			}
			img.fotoperfil
			{
				width:50px;
				height:50px;
				clear:none;
				float:left;
			}
			span.nombrepersonaje
			{
				clear:none;
				margin-left:30px;
				position:relative;
				top:15px;
			}
			div.personaje
			{
				height:50px;
				border-bottom:1px solid black;
			}
		</style>
		<script>

		</script>
	</head>
	<body>
		<div id="cabecera">
			<span id="izquierdo">Hola <?php echo $_SESSION['nombre_usuario']?></span>
			<a id="derecho" href="cerrar_sesion.php">Salir de la sesion</a>
		</div>
		<div id="personajes">
			<?php
				$conexion = conectar();
				mysql_select_db('a7938968_roler',$conexion);
				$consulta='select Cod_usuario from usuarios where nombre_usuario="'.$_SESSION['nombre_usuario'].'"';
				$resultado = mysql_query($consulta,$conexion);
				while ($fila = mysql_fetch_assoc($resultado)) 
				{
					$usuario = $fila["Cod_usuario"];
				}
				$consulta='select cod_personaje,nombre_personaje,imagen_personaje from personajes where cod_usuario="'.$usuario.'"';
				$resultado = mysql_query($consulta,$conexion);
				while ($fila = mysql_fetch_assoc($resultado)) 
				{
					echo '<div class="personaje"><img class="fotoperfil" src="'.$fila["imagen_personaje"].'"/><span class="nombrepersonaje">'.$fila["nombre_personaje"].'  <a href="borrar.php?personaje='.$fila["cod_personaje"].'">Borrar personaje</a></span></div>';
				}
			?>
			<a href="roler3000.php">Ir al chat</a>
		</div>
		<div id="nuevo">
			<form action="subir.php" method="post" enctype="multipart/form-data">
				<table>
					<tr><td><label for="nombre">Introduce un nombre de personaje</td><td><input type="text" name="nombre"/></td></tr>
					<tr><td><label for="imagen">Introduce una imagen de personaje</label></td><td><input type="file" id="archivo" name="archivo"/></td></tr>
					<tr><td><input type="submit" value="enviar"/></td></tr>
				</table>
			</form>
		</div>
	</body>
</html>