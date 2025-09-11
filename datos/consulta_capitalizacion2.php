<?PHP
header("Content-Type: text/html;charset=utf-8");
include("../conexion/conexion.php");
ini_set('max_execution_time', '0');
//include("../validacion/validacion.php");
$conn = conectate();

$mes_actual = date("m");
$mes_anterior = $mes_actual - 1;
$anio_actual = date("Y");
$anio_anterior = $anio_actual - 1;

$desde = $_GET["desde"];
$hasta = $_GET["hasta"];

$newDesde = date("d/m/Y", strtotime($desde)); 
$newHasta = date("d/m/Y", strtotime($hasta)); 

$desde3 = $_GET["desde3"];
$hasta3 = $_GET["hasta3"];

$newDesde2 = date("d/m/Y", strtotime($desde3)); 
$newHasta2 = date("d/m/Y", strtotime($hasta3));

$desde2 = $desde."T00:00:00";
$hasta2 = $hasta."T23:59:59";
$desde4 = $desde3."T00:00:00";
$hasta4 = $hasta3."T23:59:59";

$desdenew = $anio_actual."-".date("m",strtotime($hasta3))."-01T00:00:00";
$desdenew2 = $anio_actual."-".date("m",strtotime($hasta3))."-01";

$amateur_quicentro = 0;
$expert_quicentro = 0;
$believer_quicentro = 0;
$ambassador_quicentro = 0;
$total_facturas_quicentro = 0;
$amateur_quicentro2 = 0;
$expert_quicentro2 = 0;
$believer_quicentro2 = 0;
$ambassador_quicentro2 = 0;
$total_clientes_quicentro = 0;
$amateur_quicentro3 = 0;
$expert_quicentro3 = 0;
$believer_quicentro3 = 0;
$ambassador_quicentro3 = 0;
$total_venta_quicentro = 0;

$amateur_jardin = 0;
$expert_jardin = 0;
$believer_jardin = 0;
$ambassador_jardin = 0;
$total_facturas_jardin = 0;
$amateur_jardin2 = 0;
$expert_jardin2 = 0;
$believer_jardin2 = 0;
$ambassador_jardin2 = 0;
$total_clientes_jardin = 0;
$amateur_jardin3 = 0;
$expert_jardin3 = 0;
$believer_jardin3 = 0;
$ambassador_jardin3 = 0;
$total_venta_jardin = 0;

$amateur_cuenca = 0;
$expert_cuenca = 0;
$believer_cuenca = 0;
$ambassador_cuenca = 0;
$total_facturas_cuenca = 0;
$amateur_cuenca2 = 0;
$expert_cuenca2 = 0;
$believer_cuenca2 = 0;
$ambassador_cuenca2 = 0;
$total_clientes_cuenca = 0;
$amateur_cuenca3 = 0;
$expert_cuenca3 = 0;
$believer_cuenca3 = 0;
$ambassador_cuenca3 = 0;
$total_venta_cuenca = 0;

$amateur_manta = 0;
$expert_manta = 0;
$believer_manta = 0;
$ambassador_manta = 0;
$total_facturas_manta = 0;
$amateur_manta2 = 0;
$expert_manta2 = 0;
$believer_manta2 = 0;
$ambassador_manta2 = 0;
$total_clientes_manta = 0;
$amateur_manta3 = 0;
$expert_manta3 = 0;
$believer_manta3 = 0;
$ambassador_manta3 = 0;
$total_venta_manta = 0;

$amateur_sol = 0;
$expert_sol = 0;
$believer_sol = 0;
$ambassador_sol = 0;
$total_facturas_sol = 0;
$amateur_sol2 = 0;
$expert_sol2 = 0;
$believer_sol2 = 0;
$ambassador_sol2 = 0;
$total_clientes_sol = 0;
$amateur_sol3 = 0;
$expert_sol3 = 0;
$believer_sol3 = 0;
$ambassador_sol3 = 0;
$total_venta_sol = 0;

$amateur_marino = 0;
$expert_marino = 0;
$believer_marino = 0;
$ambassador_marino = 0;
$total_facturas_marino = 0;
$amateur_marino2 = 0;
$expert_marino2 = 0;
$believer_marino2 = 0;
$ambassador_marino2 = 0;
$total_clientes_marino = 0;
$amateur_marino3 = 0;
$expert_marino3 = 0;
$believer_marino3 = 0;
$ambassador_marino3 = 0;
$total_venta_marino = 0;

$amateur_ceibos = 0;
$expert_ceibos = 0;
$believer_ceibos = 0;
$ambassador_ceibos = 0;
$total_facturas_ceibos = 0;
$amateur_ceibos2 = 0;
$expert_ceibos2 = 0;
$believer_ceibos2 = 0;
$ambassador_ceibos2 = 0;
$total_clientes_ceibos = 0;
$amateur_ceibos3 = 0;
$expert_ceibos3 = 0;
$believer_ceibos3 = 0;
$ambassador_ceibos3 = 0;
$total_venta_ceibos = 0;

session_start(); 

    //echo $sql;
    
    $sql = "SELECT DISTINCT CEDULA_RUC,
            (SELECT COUNT(DISTINCT NUMERO_DOCUMENTO) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desdenew' AND '$hasta4' AND ALMACEN = a.ALMACEN) AS FACTURAS, 
            (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desdenew' AND '$hasta4' AND ALMACEN = a.ALMACEN) AS VENTA,
            a.ALMACEN,
            CASE   
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) >= 4 AND (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) <= 211.99 THEN 'Amateur'
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) >= 212 AND (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) <= 600.99 THEN 'Expert'
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) >= 601 AND (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) <= 1005.99 THEN 'Believer'
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) > 1006 THEN 'Ambassador'
            END AS SEGMENTO
            from VENTAS a
            where FECHA between '$desde4' AND '$hasta4'
            AND
            ALMACEN LIKE '%CH %' 
            GROUP BY CEDULA_RUC, FECHA, ALMACEN
            ORDER BY CEDULA_RUC";
    $res=sqlsrv_query($conn,$sql);
    // echo $sql;
    // return;

    while($row=sqlsrv_fetch_array($res)) { 
        $almacen = $row["ALMACEN"];
        $segmento = $row["SEGMENTO"];
        $cliente = $row["CEDULA_RUC"];
        //echo $fecha;

        //FACTURAS MISMOS CLIENTES
        if($segmento == "Amateur" || $segmento == ""){
            if($almacen == "CH QUICENTRO"){
                $amateur_quicentro+=$row["FACTURAS"];
                $amateur_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $amateur_quicentro2++;
                }
            }
            if($almacen == "CH JARDIN"){
                $amateur_jardin+=$row["FACTURAS"];
                $amateur_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $amateur_jardin2++;
                }
            }
            if($almacen == "CH MALL DEL RIO"){
                $amateur_cuenca+=$row["FACTURAS"];
                $amateur_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $amateur_cuenca2++;
                }
            }
            if($almacen == "CH MALL DEL PACIFICO"){
                $amateur_manta+=$row["FACTURAS"];
                $amateur_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $amateur_manta2++;
                }
            }
            if($almacen == "CH MALL DEL SOL"){
                $amateur_sol+=$row["FACTURAS"];
                $amateur_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $amateur_sol2++;
                }
            }
            if($almacen == "CH SAN MARINO"){
                $amateur_marino+=$row["FACTURAS"];
                $amateur_marino3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $amateur_marino2++;
                }
            }
            if($almacen == "CH CEIBOS"){
                $amateur_ceibos+=$row["FACTURAS"];
                $amateur_ceibos3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $amateur_ceibos2++;
                }
            }
        }

        if($segmento == "Expert"){
            //NUEVOS CLIENTES
            if($almacen == "CH QUICENTRO"){
                $expert_quicentro+=$row["FACTURAS"];
                $expert_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $expert_quicentro2++;
                }
            }
            if($almacen == "CH JARDIN"){
                $expert_jardin+=$row["FACTURAS"];
                $expert_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $expert_jardin2++;
                }
            }
            if($almacen == "CH MALL DEL RIO"){
                $expert_cuenca+=$row["FACTURAS"];
                $expert_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $expert_cuenca2++;
                }
            }
            if($almacen == "CH MALL DEL PACIFICO"){
                $expert_manta+=$row["FACTURAS"];
                $expert_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $expert_manta2++;
                }
            }
            if($almacen == "CH MALL DEL SOL"){
                $expert_sol+=$row["FACTURAS"];
                $expert_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $expert_sol2++;
                }
            }
            if($almacen == "CH SAN MARINO"){
                $expert_marino+=$row["FACTURAS"];
                $expert_marino3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $expert_marino2++;
                }
            }
            if($almacen == "CH CEIBOS"){
                $expert_ceibos+=$row["FACTURAS"];
                $expert_ceibos3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $expert_ceibos2++;
                }
            }
        }

        if($segmento == "Believer"){
            //NUEVOS CLIENTES
            if($almacen == "CH QUICENTRO"){
                $believer_quicentro+=$row["FACTURAS"];
                $believer_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $believer_quicentro2++;
                }
            }
            if($almacen == "CH JARDIN"){
                $believer_jardin+=$row["FACTURAS"];
                $believer_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $believer_jardin2++;
                }
            }
            if($almacen == "CH MALL DEL RIO"){
                $believer_cuenca+=$row["FACTURAS"];
                $believer_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $believer_cuenca2++;
                }
            }
            if($almacen == "CH MALL DEL PACIFICO"){
                $believer_manta+=$row["FACTURAS"];
                $believer_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $believer_manta2++;
                }
            }
            if($almacen == "CH MALL DEL SOL"){
                $believer_sol+=$row["FACTURAS"];
                $believer_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $believer_sol2++;
                }
            }
            if($almacen == "CH SAN MARINO"){
                $believer_marino+=$row["FACTURAS"];
                $believer_marino3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $believer_marino2++;
                }
            }
            if($almacen == "CH CEIBOS"){
                $believer_ceibos+=$row["FACTURAS"];
                $believer_ceibos3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $believer_ceibos2++;
                }
            }
        }

        if($segmento == "Ambassador"){
            //NUEVOS CLIENTES
            if($almacen == "CH QUICENTRO"){
                $ambassador_quicentro+=$row["FACTURAS"];
                $ambassador_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $ambassador_quicentro2++;
                }
            }
            if($almacen == "CH JARDIN"){
                $ambassador_jardin+=$row["FACTURAS"];
                $ambassador_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $ambassador_jardin2++;
                }
            }
            if($almacen == "CH MALL DEL RIO"){
                $ambassador_cuenca+=$row["FACTURAS"];
                $ambassador_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $ambassador_cuenca2++;
                }
            }
            if($almacen == "CH MALL DEL PACIFICO"){
                $ambassador_manta+=$row["FACTURAS"];
                $ambassador_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $ambassador_manta2++;
                }
            }
            if($almacen == "CH MALL DEL SOL"){
                $ambassador_sol+=$row["FACTURAS"];
                $ambassador_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $ambassador_sol2++;
                }
            }
            if($almacen == "CH SAN MARINO"){
                $ambassador_marino+=$row["FACTURAS"];
                $ambassador_marino3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $ambassador_marino2++;
                }
            }
            if($almacen == "CH CEIBOS"){
                $ambassador_ceibos+=$row["FACTURAS"];
                $ambassador_ceibos3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $ambassador_ceibos2++;
                }
            }
        }
    }
//echo $sql;

$total_facturas_quicentro = $amateur_quicentro + $expert_quicentro + $believer_quicentro + $ambassador_quicentro;
$total_clientes_quicentro = $amateur_quicentro2 + $expert_quicentro2 + $believer_quicentro2 + $ambassador_quicentro2;
$total_venta_quicentro = $amateur_quicentro3 + $expert_quicentro3 + $believer_quicentro3 + $ambassador_quicentro3;

$total_facturas_jardin = $amateur_jardin + $expert_jardin + $believer_jardin + $ambassador_jardin;
$total_clientes_jardin = $amateur_jardin2 + $expert_jardin2 + $believer_jardin2 + $ambassador_jardin2;
$total_venta_jardin = $amateur_jardin3 + $expert_jardin3 + $believer_jardin3 + $ambassador_jardin3;

$total_facturas_cuenca = $amateur_cuenca + $expert_cuenca + $believer_cuenca + $ambassador_cuenca;
$total_clientes_cuenca = $amateur_cuenca2 + $expert_cuenca2 + $believer_cuenca2 + $ambassador_cuenca2;
$total_venta_cuenca = $amateur_cuenca3 + $expert_cuenca3 + $believer_cuenca3 + $ambassador_cuenca3;

$total_facturas_manta = $amateur_manta + $expert_manta + $believer_manta + $ambassador_manta;
$total_clientes_manta = $amateur_manta2 + $expert_manta2 + $believer_manta2 + $ambassador_manta2;
$total_venta_manta = $amateur_manta3 + $expert_manta3 + $believer_manta3 + $ambassador_manta3;

$total_facturas_sol = $amateur_sol + $expert_sol + $believer_sol + $ambassador_sol;
$total_clientes_sol = $amateur_sol2 + $expert_sol2 + $believer_sol2 + $ambassador_sol2;
$total_venta_sol = $amateur_sol3 + $expert_sol3 + $believer_sol3 + $ambassador_sol3;

$total_facturas_marino = $amateur_marino + $expert_marino + $believer_marino + $ambassador_marino;
$total_clientes_marino = $amateur_marino2 + $expert_marino2 + $believer_marino2 + $ambassador_marino2;
$total_venta_marino = $amateur_marino3 + $expert_marino3 + $believer_marino3 + $ambassador_marino3;

$total_facturas_ceibos = $amateur_ceibos + $expert_ceibos + $believer_ceibos + $ambassador_ceibos;
$total_clientes_ceibos = $amateur_ceibos2 + $expert_ceibos2 + $believer_ceibos2 + $ambassador_ceibos2;
$total_venta_ceibos = $amateur_ceibos3 + $expert_ceibos3 + $believer_ceibos3 + $ambassador_ceibos3;
?>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="8">CANTIDAD DE FACTURAS POR SEGMENTO DE CLIENTES <?php echo "Periodo: ".$desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">SEGMENTO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">MALL DEL SOL</th>
        <th class="sortable-column sort-asc">SAN MARINO</th>
        <th class="sortable-column sort-asc">CEIBOS</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Amateur</td>
        <td><?php echo $amateur_quicentro?></td>
        <td><?php echo $amateur_jardin?></td>
        <td><?php echo $amateur_cuenca?></td>
        <td><?php echo $amateur_manta?></td>
        <td><?php echo $amateur_sol?></td>
        <td><?php echo $amateur_marino?></td>
        <td><?php echo $amateur_ceibos?></td>
    </tr>
    <tr>
        <td>Expert</td>
        <td><?php echo $expert_quicentro?></td>
        <td><?php echo $expert_jardin?></td>
        <td><?php echo $expert_cuenca?></td>
        <td><?php echo $expert_manta?></td>
        <td><?php echo $expert_sol?></td> 
        <td><?php echo $expert_marino?></td>
        <td><?php echo $expert_ceibos?></td>
    </tr>
    <tr>
        <td>Believer</td>
        <td><?php echo $believer_quicentro?></td>
        <td><?php echo $believer_jardin?></td>
        <td><?php echo $believer_cuenca?></td>
        <td><?php echo $believer_manta?></td>
        <td><?php echo $believer_sol?></td>
        <td><?php echo $believer_marino?></td>
        <td><?php echo $believer_ceibos?></td>
    </tr>
    <tr>
        <td>Ambassador</td>
        <td><?php echo $ambassador_quicentro?></td>
        <td><?php echo $ambassador_jardin?></td>
        <td><?php echo $ambassador_cuenca?></td>
        <td><?php echo $ambassador_manta?></td>
        <td><?php echo $ambassador_sol?></td>
        <td><?php echo $ambassador_marino?></td>
        <td><?php echo $ambassador_ceibos?></td>
    </tr>
    </tbody>

    <tfoot>
        <th>Total</th>
        <th><?php echo $total_facturas_quicentro ?></th>
        <th><?php echo $total_facturas_jardin ?></th>
        <th><?php echo $total_facturas_cuenca ?></th>
        <th><?php echo $total_facturas_manta ?></th>
        <th><?php echo $total_facturas_sol ?></th>
        <th><?php echo $total_facturas_marino ?></th>
        <th><?php echo $total_facturas_ceibos ?></th>
    </tfoot>
    
</table>

<hr>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="8">CANTIDAD DE CLIENTES POR SEGMENTO <?php echo "Periodo: ".$desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">SEGMENTO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">MALL DEL SOL</th>
        <th class="sortable-column sort-asc">SAN MARINO</th>
        <th class="sortable-column sort-asc">CEIBOS</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Amateur</td>
        <td><?php echo $amateur_quicentro2?></td>
        <td><?php echo $amateur_jardin2?></td>
        <td><?php echo $amateur_cuenca2?></td>
        <td><?php echo $amateur_manta2?></td>
        <td><?php echo $amateur_sol2?></td>
        <td><?php echo $amateur_marino2?></td>
        <td><?php echo $amateur_ceibos2?></td>
    </tr>
    <tr>
        <td>Expert</td>
        <td><?php echo $expert_quicentro2?></td>
        <td><?php echo $expert_jardin2?></td>
        <td><?php echo $expert_cuenca2?></td>
        <td><?php echo $expert_manta2?></td>
        <td><?php echo $expert_sol2?></td> 
        <td><?php echo $expert_marino2?></td>
        <td><?php echo $expert_ceibos2?></td>
    </tr>
    <tr>
        <td>Believer</td>
        <td><?php echo $believer_quicentro2?></td>
        <td><?php echo $believer_jardin2?></td>
        <td><?php echo $believer_cuenca2?></td>
        <td><?php echo $believer_manta2?></td>
        <td><?php echo $believer_sol2?></td>
        <td><?php echo $believer_marino2?></td>
        <td><?php echo $believer_ceibos2?></td>
    </tr>
    <tr>
        <td>Ambassador</td>
        <td><?php echo $ambassador_quicentro2?></td>
        <td><?php echo $ambassador_jardin2?></td>
        <td><?php echo $ambassador_cuenca2?></td>
        <td><?php echo $ambassador_manta2?></td>
        <td><?php echo $ambassador_sol2?></td>
        <td><?php echo $ambassador_marino2?></td>
        <td><?php echo $ambassador_ceibos2?></td>
    </tr>
    </tbody>

    <tfoot>
        <th>Total</th>
        <th><?php echo $total_clientes_quicentro ?></th>
        <th><?php echo $total_clientes_jardin ?></th>
        <th><?php echo $total_clientes_cuenca ?></th>
        <th><?php echo $total_clientes_manta ?></th>
        <th><?php echo $total_clientes_sol ?></th>
        <th><?php echo $total_clientes_marino ?></th>
        <th><?php echo $total_clientes_ceibos ?></th>
    </tfoot>
    
</table>

<hr>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="8">CANTIDAD DE VENTA POR SEGMENTO <?php echo "Periodo: ".$desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">SEGMENTO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">MALL DEL SOL</th>
        <th class="sortable-column sort-asc">SAN MARINO</th>
        <th class="sortable-column sort-asc">CEIBOS</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Amateur</td>
        <td><?php echo number_format($amateur_quicentro3,2,',','')?></td>
        <td><?php echo number_format($amateur_jardin3,2,',','')?></td>
        <td><?php echo number_format($amateur_cuenca3,2,',','')?></td>
        <td><?php echo number_format($amateur_manta3,2,',','')?></td>
        <td><?php echo number_format($amateur_sol3,2,',','')?></td>
        <td><?php echo number_format($amateur_marino3,2,',','')?></td>
        <td><?php echo number_format($amateur_ceibos3,2,',','')?></td>
    </tr>
    <tr>
        <td>Expert</td>
        <td><?php echo number_format($expert_quicentro3,2,',','')?></td>
        <td><?php echo number_format($expert_jardin3,2,',','')?></td>
        <td><?php echo number_format($expert_cuenca3,2,',','')?></td>
        <td><?php echo number_format($expert_manta3,2,',','')?></td>
        <td><?php echo number_format($expert_sol3,2,',','')?></td> 
        <td><?php echo number_format($expert_marino3,2,',','')?></td>
        <td><?php echo number_format($expert_ceibos3,2,',','')?></td>
    </tr>
    <tr>
        <td>Believer</td>
        <td><?php echo number_format($believer_quicentro3,2,',','')?></td>
        <td><?php echo number_format($believer_jardin3,2,',','')?></td>
        <td><?php echo number_format($believer_cuenca3,2,',','')?></td>
        <td><?php echo number_format($believer_manta3,2,',','')?></td>
        <td><?php echo number_format($believer_sol3,2,',','')?></td>
        <td><?php echo number_format($believer_marino3,2,',','')?></td>
        <td><?php echo number_format($believer_ceibos3,2,',','')?></td>
    </tr>
    <tr>
        <td>Ambassador</td>
        <td><?php echo number_format($ambassador_quicentro3,2,',','')?></td>
        <td><?php echo number_format($ambassador_jardin3,2,',','')?></td>
        <td><?php echo number_format($ambassador_cuenca3,2,',','')?></td>
        <td><?php echo number_format($ambassador_manta3,2,',','')?></td>
        <td><?php echo number_format($ambassador_sol3,2,',','')?></td>
        <td><?php echo number_format($ambassador_marino3,2,',','')?></td>
        <td><?php echo number_format($ambassador_ceibos3,2,',','')?></td>
    </tr>
    </tbody>

    <tfoot>
        <th>Total</th>
        <th><?php echo number_format($total_venta_quicentro,2,',','') ?></th>
        <th><?php echo number_format($total_venta_jardin,2,',','') ?></th>
        <th><?php echo number_format($total_venta_cuenca,2,',','') ?></th>
        <th><?php echo number_format($total_venta_manta,2,',','') ?></th>
        <th><?php echo number_format($total_venta_sol,2,',','') ?></th>
        <th><?php echo number_format($total_venta_marino,2,',','') ?></th>
        <th><?php echo number_format($total_venta_ceibos,2,',','') ?></th>
    </tfoot>
    
</table>