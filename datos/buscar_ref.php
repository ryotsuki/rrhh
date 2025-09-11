<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
//include("../validacion/validacion.php");
$conn = conectate2();

$ref = strtoupper($_GET["ref"]);

    $sql="SELECT * FROM V_STOCK_CON_DETALLE WHERE CODIGO_BARRAS = '$ref' AND STOCK > 0 ORDER BY TALLA, STOCK";
    $res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 
    while($row=sqlsrv_fetch_array($res)) {
?>

<div class="row">
    <div class="cell-md-5">
        <label>
            Articulo: <?php echo $row["ARTICULO"]?> <br>
            Referencia: <?php echo $row["REFERENCIA"]?> <br>
            Talla: <?php echo $row["TALLA"]?> <br>
            Color: <?php echo $row["COLOR"]?> <br>
            Almacen: <?php echo $row["ALMACEN"]?> <br>
            Stock: <?php echo $row["STOCK"]?> <br><br>
        </label>
    </div>
</div>

<?php } ?>