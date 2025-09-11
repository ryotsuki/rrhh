<?PHP
header("Content-Type: text/html;charset=utf-8");
//include("../conexion/conexion.php");
//include("../validacion/validacion.php");
$conn = conectate();

//$ref = strtoupper($_GET["ref"]);

    $sql="SELECT COUNT(id_vacacion) AS CONTEO FROM vacacion WHERE id_estado_solicitud < 3";
    $res = $conn->query($sql);
    //$res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 
    while($row=mysqli_fetch_array($res)) {
        $cantidad_vacaciones = $row["CONTEO"];
    }
?>