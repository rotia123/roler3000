<?php
include 'funciones.php';
session_name('sesion');
session_start(); 
if(!isset($_SESSION['nombre_usuario']))
{
	echo "<p>Registrese por favor</p>";
	echo "<a href='index.php'>Volver al inicio</a>";
	exit;	
}
if(isset($_FILES['archivo']) && !empty($_FILES['archivo'])  &&isset($_POST['nombre']) && !empty($_POST['nombre']))
{
	$extensiones = array("gif", "jpeg", "jpg", "png");
	$nombre = trim($_FILES['archivo']['name']);
	$carpeta = "./imagenes/".$nombre;
	if ((($_FILES['archivo']["type"] == "image/gif")
	|| ($_FILES['archivo']["type"] == "image/jpeg")
	|| ($_FILES['archivo']["type"] == "image/jpg")
	|| ($_FILES['archivo']["type"] == "image/pjpeg")
	|| ($_FILES['archivo']["type"] == "image/x-png")
	|| ($_FILES['archivo']["type"] == "image/png"))
	)
	{
		if (move_uploaded_file($_FILES['archivo']['tmp_name'], $carpeta)) 
		{
			$conexion = conectar();
			if(!$conexion)
			{
				echo "<p>Error al conectar a la base de datos</p>";
				echo "<a href='menu_principal.php'>Volver al menu principal</a>";
				exit;
			}
			if(!mysql_select_db('a7938968_roler',$conexion))
			{
				echo "<p>La base de datos no existe</p>";
				echo "<a href='menu_principal.php'>Volver al menu principal</a>";
				exit;	
			}
			$consulta='select nombre_personaje from personajes where nombre_personaje="'.$_POST["nombre"].'"';
			$lineas = mysql_query($consulta,$conexion);
			if(mysql_num_rows($lineas) > 0)
			{
				echo "<p>El nombre de personaje ya fue elegido, por favor escoja otro</p>";
				echo "<a href='menu_principal.php'>Volver al menu principal</a>";
				exit;
			}
			else
			{
				$consulta='select Cod_usuario from usuarios where nombre_usuario="'.$_SESSION['nombre_usuario'].'"';;
				$resultado = mysql_query($consulta,$conexion);
				while ($fila = mysql_fetch_assoc($resultado)) 
				{
					$usuario = $fila["Cod_usuario"];
				}	
				$consulta='insert into personajes(nombre_personaje,imagen_personaje,cod_usuario) values("'.$_POST["nombre"].'","'.$carpeta.'",'.$usuario.')';
				if(!mysql_query($consulta,$conexion))
				{
					echo "<p>Error al realizar la consulta</p>";
					echo "<a href='menu_principal.php'>Volver al menu principal</a>";
					exit;
				}
				else
				{
					echo "<p>El personaje ha sido añadido correctamente</p>";
					echo "<a href='menu_principal.php'>Volver al menu principal</a>";
					exit;
				}
			}
			header("Location: menu_principal.php");
		}
		else 
		{
			echo "<p>Error al subir la imagen</p>";
			echo "<a href='menu_principal.php'>Volver al menu principal</a>";
			exit;
		}
	}
	else
	{
	  echo "<p>Formato de archivo no valido</p>";
	  echo "<a href='menu_principal.php'>Volver al menu principal</a>";
	  exit;
	}
}
else
{
	echo "<p>Faltan datos por rellenar</p>";
	echo "<a href='menu_principal.php'>Volver al menu principal</a>";
	exit;
}
?> 