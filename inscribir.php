<?php
		include 'funciones.php';
		if(empty($_POST['nombre']) || empty($_POST['nombre']))
		{
			echo "<p>Error: falta el nombre de usuario</p>";
		}
		else if(!isset($_POST['contrasena']) || empty($_POST['contrasena']))
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
			$consulta='select nombre_usuario from usuarios where nombre_usuario="'.$_POST["nombre"].'"';
			$lineas = mysql_query($consulta,$conexion);
			if(mysql_num_rows($lineas) > 0)
			{
				echo "<p>El nombre de usuario ya fue elegido, por favor escoja otro</p>";
			}
			else
			{
				$consulta='insert into usuarios(nombre_usuario,clave_usuario) values("'.$_POST["nombre"].'","'.$_POST["contrasena"].'")';
				if(!mysql_query($consulta,$conexion))
				{
					echo "<p>Error al realizar la consulta</p>";
				}
				else
				{
					echo "<p>La consulta se ha ejecutado correctamente</p>";
					header('Location:index.php');
				}
			}
		}
?>