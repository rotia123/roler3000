<?php

	include 'funciones.php';
	session_name('sesion');
	session_start();	
	
	if(!isset($_SESSION['nombre_usuario']))
	{
		echo "<p>Registrese por favor</p>";
		exit(0);	
	}
	$conexion = conectar();
	mysql_select_db('a7938968_roler',$conexion);
	$nombres_usuario ='';
	$consulta = "select * from usuarios_conectados";
	$resultado = mysql_query($consulta,$conexion);
	while ($fila = mysql_fetch_assoc($resultado)) 
	{
		$usuario = $fila["usuario"];
		/*$usuarios[$i] = $usuario;
		$i++;*/
		//echo $usuario;
		$consulta = 'select * from usuarios where cod_usuario='.$usuario.'';
		$resultado2 = mysql_query($consulta,$conexion);
		$fila2 = mysql_fetch_assoc($resultado2);
		$nombre_usuario = $fila2["Nombre_usuario"];
		$nombres_usuario = $nombres_usuario.'<p>'.$nombre_usuario.'</p>';
	}
	echo $nombres_usuario;
?>