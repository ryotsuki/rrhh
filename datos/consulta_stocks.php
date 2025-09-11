<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
$conn = conectate2();

$referencia = strtoupper($_GET["referencia"]);
$barras = $_GET["barras"];
//$familia = $_GET["familia"];
//$marca = $_GET["marca"];

session_start();
$username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
$chevignon = "";
$siete = "";

if(strpos($username, "CH") !== false) {
    $chevignon = "AND NOMBREALMACEN LIKE '%CH%'";
}
if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
    $siete = "AND NOMBREALMACEN LIKE '%SIE%' OR NOMBREALMACEN LIKE '%SUR%'";
}

if($referencia != ""){
    $consulta_referencia = "AND REFPROVEEDOR LIKE '%$referencia%'";
}
else{
    $consulta_referencia = "";
}

if($barras != ""){
    $consulta_barras = "AND CODBARRAS = '$barras'";
}
else{
    $consulta_barras = "";
}

/*if($familia != ""){
    $consulta_dfamilia = "AND FAMILIA LIKE '%$familia%'";
}
else{
    $consulta_familia = "";
}

 if($marca != ""){
     $consulta_marca = "AND CODMARCA IN ($marca)";
 }
 else{
     $consulta_marca = "";
 }*/

//  $query_alm = "SELECT CODALMACEN, NOMBREALMACEN FROM ALMACEN WHERE CODALMACEN IN('B1','B2','B3','B4','B5','B6','C1','C2','C3','C4','C5','C6','E1','N1')";
//  $res_alm=sqlsrv_query($conn,$query_alm);
//  while($row=sqlsrv_fetch_array($res_alm)) {

//  }

    /*$sql="SELECT * FROM V_STOCK_DASHBOARD WHERE 1=1
            $consulta_barras
            $consulta_referencia
            $consulta_marca
            $chevignon
            $siete
        ORDER BY CODBARRAS";*/
        $sql="SELECT * FROM V_STOCK_DASHBOARD WHERE 1=1
        $consulta_barras
        $consulta_referencia
        and STOCK > 0
    ORDER BY CODBARRAS";
    $res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 

?>

<table class="table compact striped table-border mt-4" data-role="table"
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
        <th class="sortable-column sort-asc">EAN</th>
        <th class="sortable-column sort-asc">REF</th>
        <th class="sortable-column sort-asc">MARCA</th>
        <th class="sortable-column sort-asc">DESCRIP.</th>
        <th class="sortable-column sort-asc">TALLA</th>
        <th class="sortable-column sort-asc">COLOR</th>
        <th class="sortable-column sort-asc">PVP</th>
        <!--<th class="sortable-column sort-asc">SALE</th>-->
        <th class="sortable-column sort-asc">ALMACEN</th>
        <th class="sortable-column sort-asc">STOCK</th>
        <th class="sortable-column sort-asc">VTEX</th>
        <th class="sortable-column sort-asc">VTEXCH</th>
    </tr>
    </thead>

    <tbody>
    <?php while($row=sqlsrv_fetch_array($res)) { ?>
    <tr>
        <td><?php echo $row["CODBARRAS"]?></td>
        <td><?php echo $row["REFPROVEEDOR"]?></td>
        <td><?php echo $row["MARCA"]?></td>
        <td><?php echo $row["ARTICULO"]?></td>
        <td><?php echo $row["TALLA"]?></td>
        <td><?php echo $row["COLOR"]?></td>
        <td><?php echo number_format($row["PVP"],2,',','.')?></td>
        <!--<td><?php echo $row["SALE"]?></td>-->
        <td><?php echo $row["NOMBREALMACEN"]?></td>
        <td><?php echo $row["STOCK"]?></td>
        <td><?php echo $row["VTEX"]?></td>
        <td><?php echo $row["VTEX_CH"]?></td>
    </tr>
    <?php
        }
    ?>
    </tbody>
    
</table>