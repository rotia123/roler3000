<?php
	include 'funciones.php';
	session_name('sesion');
	session_start();
	if(isset($_SESSION['nombre_usuario']))
	{
		header("Location: menu_principal.php");	
	}
	if(isset($_POST) && !empty($_POST))
	{
		if(empty($_POST['nombre']) || empty($_POST['nombre']))
		{
			echo "<p>Error: falta el nombre de usuario</p>";
		}
		else if(!isset($_POST['clave']) || empty($_POST['clave']))
		{
			echo "<p>Error: falta la contraseña</p>";
		}
		else
		{
			$conexion = conectar();
			if(!$conexion)
			{
				echo "Error al conectar";
				exit;
			}
			if(!mysql_select_db('a7938968_roler',$conexion))
			{
				echo "La base de datos no existe";
				exit;	
			}
			$nombre = $_POST['nombre'];
			$clave = $_POST['clave'];
			$consulta = 'select * from usuarios where nombre_usuario="'.$nombre.'" and clave_usuario="'.$clave.'"';
			$lineas = mysql_query($consulta,$conexion);
			if(mysql_num_rows($lineas) == 0)
			{
				echo "<p>El usuario o la contraseña son incorrectos</p>";
			}
			else
			{
				$_SESSION['nombre_usuario'] = $nombre;
				header('Location:menu_principal.php');
			}
		}
	}
?>
<html>
	<head>
		<meta charset="UTF-8">
		<style>
			div#formulario
			{
				width:33%;
				border:1px black solid;
			}
		</style>
	</head>
	<body>
		<center>
		<p>Formulario de acceso para Roler 3000</p>
		<div id="formulario">
			<form action="index.php" method="post">
				<table>
					<tr><td><label for="nombre">Nombre</label></td><td><input name="nombre" id="nombre" type="text"></td></tr>
					<tr><td><label for="clave">Contraseña</label></td><td><input name="clave" id="clave" type="password"></td></tr>
					<tr><td><input type="submit" value="Enviar"></td><td><a href="formulario_inscripcion.html">Registro</a></td></tr>
				</table>
			</form>
		</div>
		</center>
	</body>
</html>