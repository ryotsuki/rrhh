<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
$conn = conectate();

$desde = $_GET["desde"];
$hasta = $_GET["hasta"];
$coleccion = $_GET["coleccion"];

$new_coleccion = "'";
$new_coleccion.= str_replace(",", "','", $coleccion);
$new_coleccion.= "'";

//echo $new_marca;
//exit;

session_start();
$username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
$chevignon = "";
$siete = "";

if(strpos($username, "CH") !== false) {
    $chevignon = "AND ALMACEN LIKE '%CH%'";
}
if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
    $siete = "AND ALMACEN LIKE '%SIE%' OR ALMACEN LIKE '%SUR%'";
}

if($desde != "" && $hasta != ""){
    $consulta_fecha = "AND FECHA BETWEEN '".$desde."T00:00:00' AND '".$hasta."T23:59:59'";
}
else{
    $consulta_fecha = "";
}

 if($coleccion != ""){
     $consulta_coleccion = "AND COLECCION IN ($new_coleccion)";
 }
 else{
     $consulta_coleccion = "";
 }

    $sql="SELECT sum(VTA_NETA) AS VENTA_NETA, sum(CANTIDAD_VTA) AS UNIDADES,MARCA,ALMACEN,VENDEDOR,COLECCION  from ventas where
            VENDEDOR IS NOT NULL AND ALMACEN IS NOT NULL
            $consulta_fecha
            $consulta_coleccion
            $chevignon
            $siete
            GROUP BY MARCA,ALMACEN,VENDEDOR,COLECCION";
    $res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 

?>

<table class="table striped table-border mt-4" data-role="table"
        data-rownum="true"
        data-search-min-length="3"
        data-rows-steps="5,10,20,50,100,200"
        data-table-rows-count-title="Mostrar:"
        data-table-search-title="Buscar:"
        data-table-info-title="Mostrando de $1 a $2 de $3 resultados"
        data-pagination-prev-title="Ant"
        data-pagination-next-title="Sig"
>
        <thead>
        <tr>
            <th class="sortable-column sort-asc">ALMACEN</th>
            <th class="sortable-column sort-asc">VENDEDOR</th>
            <th class="sortable-column sort-asc">MARCA</th>
            <th class="sortable-column sort-asc">LINEA</th>
            <th class="sortable-column sort-asc">VENTA NETA</th>
            <th class="sortable-column sort-asc">UNIDADES</th>
        </tr>
        </thead>

        <tbody>
        <?php 
            while($row=sqlsrv_fetch_array($res)) { 
        ?>
        <tr>
            <td><?php echo $row["ALMACEN"]?></td>
            <td><?php echo utf8_encode($row["VENDEDOR"])?></td>
            <td><?php echo $row["MARCA"]?></td>
            <td><?php echo $row["COLECCION"]?></td>
            <td><?php echo number_format($row["VENTA_NETA"],2,',','.')?></td>
            <td><?php echo number_format($row["UNIDADES"],0,',','.')?></td>
        </tr>
        <?php
            }
        ?>
        </tbody>
    
</table>