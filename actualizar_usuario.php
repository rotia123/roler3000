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
	$consulta='select usuario from usuarios_conectados where unix_timestamp(now()) - unix_timestamp(fecha) > 3';
	$resultado = mysql_query($consulta,$conexion);
	while($fila = mysql_fetch_assoc($resultado))
	{
		$consulta='delete from usuarios_conectados where usuario='.$fila['usuario'].'';
		$resultado = mysql_query($consulta,$conexion);
	}
?>