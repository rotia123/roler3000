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
	$consulta='select Cod_usuario from usuarios where nombre_usuario="'.$_SESSION['nombre_usuario'].'"';
	$resultado = mysql_query($consulta,$conexion);
	$fila = mysql_fetch_assoc($resultado); 
	$usuario = $fila["Cod_usuario"];	
	$consulta='insert into usuarios_conectados(usuario) values('.$usuario.') ON DUPLICATE KEY UPDATE fecha = NOW()';
	mysql_query($consulta,$conexion);
?>