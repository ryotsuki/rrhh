<?php

//Include Configuration File
include('config.php');

$accion = "";
if(isset($_GET["accion"])){
	$accion = $_GET["accion"];
}

$txt_usuario = "";
if(isset($_POST["txt_usuario"])){
	$txt_usuario = $_POST["txt_usuario"];
}

$txt_password = "";
if(isset($_POST["txt_password"])){
	$txt_password = $_POST["txt_password"];
}

if($accion=="entrar"){
	//echo $txt_usuario;
	
	$usuario = $_POST["txt_usuario"];
	$clave	= $_POST["txt_password"];
	
	include("conexion/conexion.php");
	conectate();
    
    $conn2 = conectate();
    
	$login = "SELECT * FROM usuario WHERE cedula_usuario='".$usuario."' AND clave_usuario = '".$clave."' AND id_estado = 1";
	$consulta_login = $conn2->query($login);

	$numero_filas = mysqli_num_rows($consulta_login);
	
	if($numero_filas){
	
		while($row=mysqli_fetch_array($consulta_login)) {
	
			$_SESSION['user_email_address']	= $row["correo_usuario"];
            $_SESSION['user_first_name'] 	= $row["nombre_usuario"];
            $_SESSION['user_last_name']     = "";
			$_SESSION['id_status_usuario'] 	= $row["id_estado"];
            $_SESSION['clave_usuario'] 		= $row["clave_usuario"];
            $_SESSION['cedula_usuario']     = $row["cedula_usuario"];
            $_SESSION['user_image'] 		= "images/shvarcenegger.jpg";
            $_SESSION['ultimoacceso'] 		= date("Y-n-j H:i:s");
            $_SESSION['id_usuario'] 		= $row["id_usuario"];
            $_SESSION['cargo']	            = $row["id_cargo"];
			
			//echo "los valores son: ".$row[1].$row[2];
            if($_SESSION['cargo'] == 5 || $_SESSION['cargo'] == 8){
                header("location: principal");
            }
            else{
                header("location: principal#permisos");
            }
			
		}
	}
	else{
	
		$mensaje = 1;
	
	}
	
}

$login_button = '';

//This $_GET["code"] variable value received after user has login into their Google Account redirct to PHP script then this variable value has been received
if(isset($_GET["code"]))
{
 //It will Attempt to exchange a code for an valid authentication token.
 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

 //This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
 if(!isset($token['error']))
 {
  //Set the access token used for requests
  $google_client->setAccessToken($token['access_token']);

  //Store "access_token" value in $_SESSION variable for future use.
  $_SESSION['access_token'] = $token['access_token'];

  //Create Object of Google Service OAuth 2 class
  $google_service = new Google_Service_Oauth2($google_client);

  //Get user profile data from google
  $data = $google_service->userinfo->get();

  //Below you can find Get profile data and store into $_SESSION variable
  if(!empty($data['given_name']))
  {
   $_SESSION['user_first_name'] = $data['given_name'];
  }

  if(!empty($data['family_name']))
  {
   $_SESSION['user_last_name'] = $data['family_name'];
  }

  if(!empty($data['email']))
  {
   $_SESSION['user_email_address'] = $data['email'];
  }

  if(!empty($data['gender']))
  {
   $_SESSION['user_gender'] = $data['gender'];
  }

  if(!empty($data['picture']))
  {
   $_SESSION['user_image'] = $data['picture'];
  }
 }
}

//This is for check user has login into system by using Google account, if User not login into system then it will execute if block of code and make code for display Login link for Login using Google account.
if(!isset($_SESSION['access_token']))
{
 //Create a URL to obtain user authorization
// $login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="sign-in-with-google.png" /></a>';
$login_button = '<div class="form-group">
        <a href="'.$google_client->createAuthUrl().'"><button class="image-button w-100 mt-1 bg-gitlab fg-white" type="button">
            <span class="mif-google icon"></span>
            <span class="caption">Iniciar sesión con Google</span>
        </button>
        </a>
    </div>';

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Metro 4 -->
    <link rel="stylesheet" href="vendors/metro4/css/metro-all.min.css">
    <link rel="stylesheet" href="css/index.css">

    <title>Semper :: Vacaciones y permisos</title>

    <script>
        function login(){

            document.frm_login.action ="login?accion=entrar";
			document.frm_login.submit();
        }

        function registro(){
            //var notify = Metro.notify;
            //notify.create("Funcion en desarrollo.", "Informacion", {
            //    cls: "alert"
            //});
            //return;
            alert("Registro");
            window.location.href = "http://m1.sempersa.com:8080/registro";
        }
    </script>
</head>
<body class="m4-cloak h-vh-100 d-flex flex-justify-center flex-align-center">

    <div class="login-box">
        <form class="bg-white p-4"
              action="javascript:"
              data-role="validator"
              data-clear-invalid="2000"
              data-on-error-form="invalidForm"
              id="frm_login"
              name="frm_login"
              method = "post"
        >
            <br>
            <img src="images/logos/crocs_logo.png" class="mt-4-minus mr-6-minus">
            <div class="text-muted mb-4 place-center">Ingrese sus datos para el registro</div>
            <div class="form-group">
                <input type="text" id="txt_usuario" name="txt_usuario" data-role="input" placeholder="Cedula" data-append="<span class='mif-envelop'>" data-validate="required">
                <span class="invalid_feedback">Por favor, ingrese su correo</span>
            </div>
            <div class="form-group">
                <input type="password" id="txt_password" name="txt_password" data-role="input" placeholder="Contraseña" data-append="<span class='mif-key'>" data-validate="required">
                <span class="invalid_feedback">Por favor, ingrese su cedula</span>
            </div>
            <div class="form-group">
                <input type="text" id="txt_usuario" name="txt_usuario" data-role="input" placeholder="Cedula" data-append="<span class='mif-envelop'>" data-validate="required">
                <span class="invalid_feedback">Por favor, ingrese su correo</span>
            </div>
            <div class="form-group">
                <input type="text" id="txt_usuario" name="txt_usuario" data-role="input" placeholder="Cedula" data-append="<span class='mif-envelop'>" data-validate="required">
                <span class="invalid_feedback">Por favor, ingrese su correo</span>
            </div>
            <div class="form-group d-flex flex-align-center flex-justify-between">
                <a href="#" onclick="login()"><button class="button primary">Entrar</button></a>
            <!--<div class="text-center m-4">- O -</div>-->
            <?php
            if($login_button == '')
            {
                echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
                echo '<img src="'.$_SESSION["user_image"].'" class="img-responsive img-circle img-thumbnail" />';
                echo '<h3><b>Name :</b> '.$_SESSION['user_first_name'].' '.$_SESSION['user_last_name'].'</h3>';
                echo '<h3><b>Email :</b> '.$_SESSION['user_email_address'].'</h3>';
                echo '<h3><a href="logout.php">Logout</h3></div>';

                $nombre_usuario = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
                $foto_usuario = $_SESSION["user_image"];
                $correo_usuario = $_SESSION['user_email_address'];
                $_SESSION['ultimoacceso'] 		= date("Y-n-j H:i:s");
                header('Location: principal');
            }
            else
            {
                //echo '<div align="center">'.$login_button . '</div>';
            }
            ?>
        </form>
        <a href="#" onclick="registro()"><button class="button success">Registrarse</button></a>
        </div>
    </div>


    <script src="vendors/jquery/jquery-3.4.1.min.js"></script>
    <script src="vendors/metro4/js/metro.min.js"></script>
    <script>
        function invalidForm(){
            var form  = $(this);
            form.addClass("ani-ring");
            setTimeout(function(){
                form.removeClass("ani-ring");
            }, 1000);
        }
    </script>
</body>
</html>