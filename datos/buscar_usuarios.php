<?PHP
header("Content-Type: text/html;charset=utf-8");
//include("../conexion/conexion.php");
//include("../validacion/validacion.php");
$conn = conectate();

//$ref = strtoupper($_GET["ref"]);

    $sql="SELECT COUNT(id_usuario) AS CONTEO FROM usuario";
    $res = $conn->query($sql);
    //$res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 
    while($row=mysqli_fetch_array($res)) {
        $usuarios_totales = $row["CONTEO"];
    }
?>