<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;
    $conn = conectate();

	include("datos/dias_meses_anios.php");
    include("datos/buscar_usuarios.php");
    include("datos/buscar_permisos.php");
    include("datos/buscar_vacaciones.php");
?>

<hr>
<br>

<input id="txt_ubicacion" type="text" data-role="materialinput"
    data-label="Ubicacion"
    placeholder="Ingrese nombre de ubicacion">