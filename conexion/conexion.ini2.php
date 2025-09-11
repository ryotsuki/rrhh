<?php
function conectate_mysql()
{
	$Bd    = "127.0.0.1";
	$Usu   = "sa";
	$Clave = "T3mPoral00";
	
	$link=mysql_connect($Bd,$Usu,$Clave );
	mysql_select_db("BOLIPUERTOS_CCS",$link);		
	return $link;
}
?>