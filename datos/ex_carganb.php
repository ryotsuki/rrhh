<?PHP
header("Pragma: public");
header("Expires: 0");
$filename = "carganb.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0'); 
//include("../validacion/validacion.php");
$conn = conectate2();
   
$sql = "SELECT 
            V.REFERENCIA AS Handle,
            V.REFERENCIA AS VariantSKU,
            'MERGE' AS VariantCommand,
            'Talla' AS Option1Name,
            V.TALLA AS Option1Value,
            (V.PVP*1.15) AS VariantPrice,
            (V.PVP*1.15) AS VariantCompareAtPrice,
            (SELECT SUM(STOCK) FROM V_STOCK_CON_DETALLE WHERE MARCA = 'NEW BALANCE' AND CODIGO_ALMACEN = 'N1' AND V.REFERENCIA = REFERENCIA AND V.TALLA = TALLA) AS STOCK_SCALA,
            (SELECT SUM(STOCK) FROM V_STOCK_CON_DETALLE WHERE MARCA = 'NEW BALANCE' AND CODIGO_ALMACEN = 'N2' AND V.REFERENCIA = REFERENCIA AND V.TALLA = TALLA) AS STOCK_QUICENTRO,
            (SELECT SUM(STOCK) FROM V_STOCK_CON_DETALLE WHERE MARCA = 'NEW BALANCE' AND CODIGO_ALMACEN = 'N3' AND V.REFERENCIA = REFERENCIA AND V.TALLA = TALLA) AS STOCK_CUENCA,
            'True' AS VariantRequiresShipping,
            'shopify' AS VariantInventoryTracker
        FROM 
            V_STOCK_CON_DETALLE V
        WHERE
            CODIGO_ALMACEN IN('N1','N2','N3')
            AND CODMARCA = 10
        GROUP BY
            REFERENCIA, TALLA, PVP
        HAVING SUM(STOCK) > 0 ";

$res=sqlsrv_query($conn,$sql);	

    //echo $sql;

?>

<table class="table striped table-border mt-4 compact" data-role="table"
        id="tabla"
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
        <th class="sortable-column">Handle</th>
        <th class="sortable-column">VariantSKU</th>
        <th class="sortable-column">VariantCommand</th>
        <th class="sortable-column">Option1Name</th>
        <th class="sortable-column">Option1Value</th>
        <th class="sortable-column">VariantPrice</th>
        <th class="sortable-column">VariantCompareAtPrice</th>
        <th class="sortable-column">STOCK_SCALA</th>
        <th class="sortable-column">STOCK_QUICENTRO</th>
        <th class="sortable-column">STOCK_CUENCA</th>
        <th class="sortable-column">VariantRequiresShipping</th>
        <th class="sortable-column">VariantInventoryTracker</th>
    </tr>
    </thead>

    <tbody>
    <?php
        while($row=sqlsrv_fetch_array($res)) { 
    ?>
    <tr>
        <td><?php echo trim($row["Handle"])?></td>
        <td><?php echo $row["VariantSKU"]?></td>
        <td><?php echo $row["VariantCommand"]?></td>
        <td><?php echo $row["Option1Name"]?></td>
        <td><?php echo $row["Option1Value"]?></td>
        <td><?php echo number_format($row["VariantPrice"],2,',','.')?></td>
        <td><?php echo number_format($row["VariantCompareAtPrice"],2,',','.')?></td>
        <td><?php echo $row["STOCK_SCALA"]?></td>
        <td><?php echo $row["STOCK_QUICENTRO"]?></td>
        <td><?php echo $row["STOCK_CUENCA"]?></td>
        <td><?php echo $row["VariantRequiresShipping"]?></td>
        <td><?php echo $row["VariantInventoryTracker"]?></td>
    </tr>
    <?php
        }//}
    ?>
    </tbody>
</table>