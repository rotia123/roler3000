<?php
  include 'funciones.php';
  session_name('sesion');
  session_start();
  $conexion = conectar();
  mysql_select_db('u467391080_roler',$conexion);
  $consulta='select Cod_usuario from usuarios where nombre_usuario="'.$_SESSION['nombre_usuario'].'"';
  $resultado = mysql_query($consulta,$conexion);
  $fila = mysql_fetch_assoc($resultado); 
  $usuario = $fila["Cod_usuario"];
  $consulta='delete from usuarios_conectados where usuario='.$usuario.'';
  mysql_query($consulta,$conexion);
  unset($_SESSION["nombre_usuario"]); 
  session_destroy();
  header("Location: index.php");
?>