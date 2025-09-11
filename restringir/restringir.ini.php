<?PHP
function session_valida()
{
	session_start(); 	
	$valido = true;	

	
	if(!isset($_SESSION['user_email_address']))
		{
			$valido = false;
     		  session_destroy(); // destruyo la sesi�n 
		      session_unset();

		}

		if ($valido == false)
		{

			header("location:../");
		}
		
		else
		{
			$fechaGuardada = $_SESSION['ultimoacceso'];
			$ahora = date("Y-n-j H:i:s");
			$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));
			
			 //comparo el tiempo transcurrido 
			 if($tiempo_transcurrido >= 40000)
			 { 
				 //si pasaron 20 minutos o m�s 
				  session_destroy(); // destruyo la sesi�n 
				  session_unset();
				  header("location:../source/index"); //env�o al usuario a la pag. de autenticaci�n 
				 //sino, actualizo la fecha de la sesi�n 
			 }
			 else
			 { 
				$_SESSION["ultimoAcceso"] = $ahora; 
			 } 		
		}		
		//fin validacion para no violar las paginas por el url	
	
}
?>