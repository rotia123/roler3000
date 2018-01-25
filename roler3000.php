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
	$consulta = "select * from personajes where cod_usuario = '".$usuario."'";
	$lineas = mysql_query($consulta,$conexion);
	if(mysql_num_rows($lineas) == 0)
	{
		echo "<p>Debes de tener al menos un personaje creado para continuar</p>";
		echo "<a href='menu_principal.php'>Volver a menú de personajes</a>";
		exit(0);
	}
	$consulta='select usuario from usuarios_conectados where usuario='.$usuario.'';
	$lineas = mysql_query($consulta,$conexion);
	if(mysql_num_rows($lineas) == 0)
	{
		$consulta='insert into usuarios_conectados values('.$usuario.')';
		mysql_query($consulta,$conexion);
	}
	
?>
<html>
	<head>
		<meta charset="UTF-8"/>
		<style>
			body {background-image:url('imagenes/fondo.jpg');color:black;background-attachment:fixed;font-family:Arial} 
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
		</style>
		<script type="text/javascript" src="jQuery/jquery.js"></script>  
		<script type="text/javascript"> 
			var personaje='';
			var valor_dado=100;
			function usuarios_conectados()
			{
				peticion_http = new XMLHttpRequest();
				peticion_http.onreadystatechange=function()
				{
				 if (peticion_http.readyState==4 && peticion_http.status==200)
				 {
				  document.getElementById("dentro").innerHTML=peticion_http.responseText;
				  setTimeout (usuarios_conectados,1000);
				 }
				}
				peticion_http.open("GET","ver_contactos.php",true);
				peticion_http.send();
			}
			function actualizar()
			{
				actualizacion = new XMLHttpRequest();
				actualizacion.onreadystatechange=function()
				{
				 if (actualizacion.readyState==4 && actualizacion.status==200)
				 {
				  setTimeout (actualizar,1000);
				 }
				}
				actualizacion.open("GET","actualizar.php",true);
				actualizacion.send();
			}
			function borrar()
			{
				borrado = new XMLHttpRequest();
				borrado.onreadystatechange=function()
				{
				 if (borrado.readyState==4 && borrado.status==200)
				 {
				  setTimeout (borrar,1000);
				 }
				}
				borrado.open("GET","actualizar_usuario.php",true);
				borrado.send();
			}
			function cambiar_personaje(id,nombre)
			{
				personaje = nombre;
				document.getElementById("personaje").innerHTML="Tu personaje actual es "+personaje;
			}
			function envia_mensaje()
			{
				mensaje=document.getElementById("mensaje").value;
				if(personaje == '')
				{
					alert("Debes seleccionar primero un personaje");
				}
				else
				{
					mensaje=personaje+" dice: "+encodeURIComponent(mensaje);
					document.getElementById("mensaje").value='';
					escribe_log = new XMLHttpRequest();
					/*escribe_log.onreadystatechange=function()
					{
					}*/
					escribe_log.open("GET","escribir_log.php?mensaje="+mensaje+"",true);
					escribe_log.send();
				}
				return false;
			}
			function actualizar_chat()
			{
				actualiza_chat = new XMLHttpRequest();
				actualiza_chat.onreadystatechange=function()
				{
				 if (actualiza_chat.readyState==4 && actualiza_chat.status==200)
				 {
				  document.getElementById("chat").innerHTML=actualiza_chat.responseText;
				  setTimeout (actualizar_chat,200);
				 }
				}
				actualiza_chat.open("GET","actualizar_chat.php",true);
				actualiza_chat.send();				
			}
			function tirar()
			{
				aleatorio = Math.floor((Math.random()*valor_dado+1)); 
				document.getElementById("tirada").innerHTML = "Has sacado "+aleatorio;
			}
			function cambiar_dado()
			{
				indice = document.getElementById("dados").selectedIndex;
				seleccionado = document.getElementById("dados").options[indice].value;
				dado = document.getElementById("dado");
				switch(seleccionado)
				{
					case '3':
					dado.src = "dado3.jpg";
					valor_dado = 3;
					break;
					case '6':
					dado.src = "dado6.jpg";
					valor_dado = 6;					
					break;
					case '8':
					dado.src = "dado8.jpg";
					valor_dado = 8;					
					break;
					case '10':
					dado.src = "dado10.jpg";
					valor_dado = 10;					
					break;
					case '12':
					dado.src = "dado12.jpg";
					valor_dado = 12;					
					break;
					case '20':
					dado.src = "dado20.jpg";
					valor_dado = 20;
					break;
					case '100':
					dado.src = "dado100.jpg";
					valor_dado = 100;					
					break;					
				}
			}
			usuarios_conectados();
			actualizar();
			borrar();
			actualizar_chat();
		</script>
	</head>
	<body >
			<div id="cabecera">
				<span id="izquierdo">Hola <?php echo $_SESSION['nombre_usuario']?></span>
				<a id="derecho" href="cerrar_sesion.php">Salir de la sesion</a>
			</div>
		<div id="contactos" style="float:left;width:200px;height:80%;background-color:white;overflow:hidden">
			<p>Contactos</p>
			<div id="dentro">
			</div>
		</div>
		<div id="contenedor" style="width100%;float:right;">
			<div id="ficha" style="float:left;width:100px;">
				<?php
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
						echo '<img src="'.$fila["imagen_personaje"].'" onclick=cambiar_personaje("'.$fila["cod_personaje"].'","'.$fila["nombre_personaje"].'") id='.$fila["cod_personaje"].' width="80px" height="80px" style="margin-bottom:10px;"/>';
					}
				?>
				<select id="dados" onchange="cambiar_dado()">
					<option value="3">Dado de 3</option>
					<option value="6">Dado de 6</option>
					<option value="8">Dado de 8</option>
					<option value="10">Dado de 10</option>
					<option value="12">Dado de 12</option>
					<option value="20">Dado de 20</option>
					<option value="100" selected>Dado de 100</option>
				</select>
				<img src="dado100.jpg" id="dado" onclick="tirar()" width="80px" height="80px"/>
			</div>
			<div id="derecha" style="float:right;width:550px;background-color:white;">
				<div id="chat" style="width:500px;height:300px;border-width:3px;border-color:black;border-style:solid;overflow:scroll;margin-left:25px;margin-top:25px;" >

				</div>
				<p id="personaje" style="margin-left:25px;">Tu personaje actual es</p>
				<form style="margin-left:25px;" name="formulario_mensaje" onsubmit="return envia_mensaje();">
					<label for="mensaje" >Enviar mensaje </label><input type="text" name="mensaje" id="mensaje"/>
					<input type="button" name="boton" id="boton" value="Enviar" onclick="envia_mensaje()"/>
				</form>
				<p id="tirada" style="margin-left:25px;"></p>
			</div>
		</div>
	</body>
</html>