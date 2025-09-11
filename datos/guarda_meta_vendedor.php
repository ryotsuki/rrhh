<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
session_start();
$conn = conectate();

//CALCULO DE DIA, MES Y AÑO
include("dias_meses_anios.php");
//-------------------

$anio = $_GET["anio"];
$mes = $_GET["mes"];
$almacen = $_GET["almacen"];
$vendedor = $_GET["vendedor"];
$monto = $_GET["monto"];

$username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
$filtro_tienda = ""; 

$new_almacen = "'";
$new_almacen.= str_replace(",", "','", $almacen);
$new_almacen.= "'";

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}

if($almacen != ""){
    $consulta_almacen = "AND ALMACEN IN ($new_almacen)";
    $filtro_tienda = "";
}
else{
    $consulta_almacen = "";
}

    $consulta = "SELECT COUNT(almacen_vendedor) AS SIHAY FROM METAS_VENDEDOR WHERE almacen_vendedor = '".$almacen."' AND nombre_vendedor = '".$vendedor."' AND mes_meta_vendedor = $mes AND anio_meta_vendedor = $anio";
    $ejecutar = sqlsrv_query($conn,$consulta);
    while($row=sqlsrv_fetch_array($ejecutar)) {
        $sihay = $row["SIHAY"];

        if($sihay > 0){
            $sql = "UPDATE METAS_VENDEDOR SET monto_meta_vendedor = $monto WHERE almacen_vendedor = '".$almacen."' AND nombre_vendedor = '".$vendedor."' AND mes_meta_vendedor = $mes AND anio_meta_vendedor = $anio";
            $res = sqlsrv_query($conn,$sql);
        }
        else{
            $sql = "INSERT INTO METAS_VENDEDOR(almacen_vendedor, nombre_vendedor, monto_meta_vendedor, mes_meta_vendedor, anio_meta_vendedor) 
            VALUES('".$almacen."','".$vendedor."',$monto,$mes,$anio)";
            $res = sqlsrv_query($conn,$sql);
        }
    }

    //echo $sql;

    if($res){
        $consulta_metas = "SELECT * FROM METAS_VENDEDOR WHERE almacen_vendedor = '".trim($username)."' AND mes_meta_vendedor = $mes_actual AND anio_meta_vendedor = $anio_actual";
        $res_metas = sqlsrv_query($conn,$consulta_metas);
    }

    //echo $sql_uno; 
    //$consulta_descripcion 

?>

<div class="row">
        <table class="table compact table-border striped">
            <tr class="bg-cyan fg-white" style="text-align:center;">
                <th colspan="2">Metas cargadas del mes - <?php echo $mes_letras;?></th>
            </tr>
            <?php 
                while($row=sqlsrv_fetch_array($res_metas)) { 
                    $vendedor = $row["nombre_vendedor"];
            ?>
            <tr>
                <th><?php echo $vendedor?></th>
                <td><input type="number" disabled style="text-align:right;" value="<?php echo $row["monto_meta_vendedor"]?>" id="txt_<?php echo $vendedor?>" size="10"><td>
            </tr>
            <?php } ?>
        </table>
        </div>