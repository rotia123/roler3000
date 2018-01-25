<?php

	session_name('sesion');
	session_start(); 

	if(!isset($_SESSION['nombre_usuario']))
	{
		echo "<p>Registrese por favor</p>";
		exit(0);	
	}

	if(file_exists("log.html") && filesize("log.html") > 0){  
		$handle = fopen("log.html", "r");  
		$contents = fread($handle, filesize("log.html"));  
		fclose($handle);  				  
		echo $contents;  
	}
?>