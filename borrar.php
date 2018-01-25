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
	$conexion = conectar();
	mysql_select_db('a7938968_roler',$conexion);
	$borrar = $_GET['personaje'];
	$consulta='delete from personajes where cod_personaje = '.$borrar.'';
	$resultado = mysql_query($consulta,$conexion);
	echo "<p>El personaje ha sido borrado con exito</p>";
	echo "<a href='menu_principal.php'>Volver al menu principal</a>";
	exit;
?>