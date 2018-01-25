<?php

	session_name('sesion');
	session_start(); 

	if(!isset($_SESSION['nombre_usuario']))
	{
		echo "<p>Registrese por favor</p>";
		exit(0);	
	}
 
    $mensaje = $_GET['mensaje']; 
	$mensaje = htmlentities($mensaje,ENT_QUOTES,'UTF-8');
    $fp = fopen("log.html", 'a');  
    fwrite($fp, "<p>".$mensaje."</p>");  
    fclose($fp);  
  
?>