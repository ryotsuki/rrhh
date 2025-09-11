<?php
    header("Content-Type: text/html;charset=utf-8");
    include("../conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    session_start();
    $correo_usuario = $_SESSION['user_email_address'];
    $conn = conectate();

    $voto = $_GET["voto"];

    $sql="SELECT $voto AS numero FROM MURALES_CHEVIGNON";
    //echo $sql;
    $res=sqlsrv_query($conn,$sql);
    while($row=sqlsrv_fetch_array($res)) {
        $numero = $row["numero"];
    }

    $new_numero = $numero + 1;

    $sql2="UPDATE MURALES_CHEVIGNON SET $voto = $new_numero";
    $res2=sqlsrv_query($conn,$sql2);

    $sql3="UPDATE USUARIO SET ch = 1 WHERE correo_usuario = '$correo_usuario'";
    $res3=sqlsrv_query($conn,$sql3);

    $sql4="UPDATE USUARIO SET ch2 = '$voto' WHERE correo_usuario = '$correo_usuario'";
    $res4=sqlsrv_query($conn,$sql4);
?>