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

    $nuevos_quicentro = 0;
    $recuperados_quicentro = 0;
    $base_quicentro = 0;
    $nuevos_quicentro2 = 0;
    $recuperados_quicentro2 = 0;
    $base_quicentro2 = 0;
    $total_facturas_quicentro = 0;
    $total_venta_quicentro = 0;
    $total_clientes_quicentro = 0;

    $nuevos_jardin = 0;
    $recuperados_jardin = 0;
    $base_jardin = 0;
    $nuevos_jardin2 = 0;
    $recuperados_jardin2 = 0;
    $base_jardin2 = 0;
    $total_facturas_jardin = 0;
    $total_venta_jardin = 0;
    $total_clientes_jardin = 0;

    $nuevos_cuenca = 0;
    $recuperados_cuenca = 0;
    $base_cuenca = 0;
    $nuevos_cuenca2 = 0;
    $recuperados_cuenca2 = 0;
    $base_cuenca2 = 0;
    $total_facturas_cuenca = 0;
    $total_venta_cuenca = 0;
    $total_clientes_cuenca = 0;

    $nuevos_manta = 0;
    $recuperados_manta = 0;
    $base_manta = 0;
    $nuevos_manta2 = 0;
    $recuperados_manta2 = 0;
    $base_manta2 = 0;
    $total_facturas_manta = 0;
    $total_venta_manta = 0;
    $total_clientes_manta = 0;

    $nuevos_sol = 0;
    $recuperados_sol = 0;
    $base_sol = 0;
    $nuevos_sol2 = 0;
    $recuperados_sol2 = 0;
    $base_sol2 = 0;
    $total_facturas_sol = 0;
    $total_venta_sol = 0;
    $total_clientes_sol = 0;

    $nuevos_marino = 0;
    $recuperados_marino = 0;
    $base_marino = 0;
    $nuevos_marino2 = 0;
    $recuperados_marino2 = 0;
    $base_marino2 = 0;
    $total_facturas_marino = 0;
    $total_venta_marino = 0;
    $total_clientes_marino = 0;

    $nuevos_ceibos = 0;
    $recuperados_ceibos = 0;
    $base_ceibos = 0;
    $nuevos_ceibos2 = 0;
    $recuperados_ceibos2 = 0;
    $base_ceibos2 = 0;
    $total_facturas_ceibos = 0;
    $total_venta_ceibos = 0;
    $total_clientes_ceibos = 0;

session_start(); 
    
    $sql = "SELECT 
                (SELECT COUNT(DISTINCT NUMERO_DOCUMENTO) WHERE FECHA BETWEEN '$desdenew' AND '$hasta4') AS FACTURAS, 
                (SELECT SUM(VTA_NETA) WHERE FECHA BETWEEN '$desdenew' AND '$hasta4') AS VENTA,
                FECHA_MODIFICACION,
                ALMACEN,
                (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde2' and '$hasta2'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) as PeSOLdo1,

                (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde4' and '$hasta4'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) as PeSOLdo2,
                case
                when (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde2' and '$hasta2'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) is not NULL and (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde4' and '$hasta4'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) is not NULL then 'Mismo Cliente'
                when (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde2' and '$hasta2'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) is NULL and (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde4' and '$hasta4'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) is not NULL then 'Nuevo o Recuperado'
                when (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde2' and '$hasta2'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) is not NULL and (select COUNT(distincT (NUMERO_DOCUMENTO))
                from VENTAS
                where FECHA between '$desde4' and '$hasta4'
                and CEDULA_RUC = a.CEDULA_RUC
                group by CEDULA_RUC) is NULL then 'Inactivo' end AS ESTADO
                from VENTAS a
                where FECHA between '$desde2' and '$hasta4'
                AND
                ALMACEN LIKE '%CH %'
                GROUP BY CEDULA_RUC,FECHA,FECHA_MODIFICACION, ALMACEN";
    $res=sqlsrv_query($conn,$sql);

    //echo $sql;
    //exit;

    while($row=sqlsrv_fetch_array($res)) { 
        $almacen = $row["ALMACEN"];
        $estado = $row["ESTADO"];
        $fecha = date_format($row["FECHA_MODIFICACION"],"Y-m-d");
        //echo $fecha;

        //FACTURAS MISMOS CLIENTES
        if($estado == "Mismo Cliente"){
            if($almacen == "CH QUICENTRO"){
                $base_quicentro+=$row["FACTURAS"];
                $base_quicentro2+=$row["VENTA"];
            }
            if($almacen == "CH JARDIN"){
                $base_jardin+=$row["FACTURAS"];
                $base_jardin2+=$row["VENTA"];
            }
            if($almacen == "CH MALL DEL RIO"){
                $base_cuenca+=$row["FACTURAS"];
                $base_cuenca2+=$row["VENTA"];
            }
            if($almacen == "CH MALL DEL PACIFICO"){
                $base_manta+=$row["FACTURAS"];
                $base_manta2+=$row["VENTA"];
            }
            if($almacen == "CH MALL DEL SOL"){
                $base_sol+=$row["FACTURAS"];
                $base_sol2+=$row["VENTA"];
            }
            if($almacen == "CH SAN MARINO"){
                $base_marino+=$row["FACTURAS"];
                $base_marino2+=$row["VENTA"];
            }
            if($almacen == "CH CEIBOS"){
                $base_ceibos+=$row["FACTURAS"];
                $base_ceibos2+=$row["VENTA"];
            }
        }

        if($estado == "Nuevo o Recuperado"){

            //NUEVOS CLIENTES
            if($fecha >= $desdenew2 && $fecha <= $hasta3){
                if($almacen == "CH QUICENTRO"){
                    $nuevos_quicentro+=$row["FACTURAS"];
                    $nuevos_quicentro2+=$row["VENTA"];
                }
                if($almacen == "CH JARDIN"){
                    $nuevos_jardin+=$row["FACTURAS"];
                    $nuevos_jardin2+=$row["VENTA"];
                }
                if($almacen == "CH MALL DEL RIO"){
                    $nuevos_cuenca+=$row["FACTURAS"];
                    $nuevos_cuenca2+=$row["VENTA"];
                }
                if($almacen == "CH MALL DEL PACIFICO"){
                    $nuevos_manta+=$row["FACTURAS"];
                    $nuevos_manta2+=$row["VENTA"];
                }
                if($almacen == "CH MALL DEL SOL"){
                    $nuevos_sol+=$row["FACTURAS"];
                    $nuevos_sol2+=$row["VENTA"];
                }
                if($almacen == "CH SAN MARINO"){
                    $nuevos_marino+=$row["FACTURAS"];
                    $nuevos_marino2+=$row["VENTA"];
                }
                if($almacen == "CH CEIBOS"){
                    $nuevos_ceibos+=$row["FACTURAS"];
                    $nuevos_ceibos2+=$row["VENTA"];
                }
            }

            //CLIENTES RECUPERADOS
            else{
                if($almacen == "CH QUICENTRO"){
                    $recuperados_quicentro+=$row["FACTURAS"];
                    $recuperados_quicentro2+=$row["VENTA"];
                }
                if($almacen == "CH JARDIN"){
                    $recuperados_jardin+=$row["FACTURAS"];
                    $recuperados_jardin2+=$row["VENTA"];
                }
                if($almacen == "CH MALL DEL RIO"){
                    $recuperados_cuenca+=$row["FACTURAS"];
                    $recuperados_cuenca2+=$row["VENTA"];
                }
                if($almacen == "CH MALL DEL PACIFICO"){
                    $recuperados_manta+=$row["FACTURAS"];
                    $recuperados_manta2+=$row["VENTA"];
                }
                if($almacen == "CH MALL DEL SOL"){
                    $recuperados_sol+=$row["FACTURAS"];
                    $recuperados_sol2+=$row["VENTA"];
                }
                if($almacen == "CH SAN MARINO"){
                    $recuperados_marino+=$row["FACTURAS"];
                    $recuperados_marino2+=$row["VENTA"];
                }
                if($almacen == "CH CEIBOS"){
                    $recuperados_ceibos+=$row["FACTURAS"];
                    $recuperados_ceibos2+=$row["VENTA"];
                }
            }
        }
    }
//echo $sql;

$total_facturas_quicentro = $base_quicentro + $nuevos_quicentro + $recuperados_quicentro;
$total_venta_quicentro = $base_quicentro2 + $nuevos_quicentro2 + $recuperados_quicentro2;

// $sql_quicentro1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH QUICENTRO', $base_quicentro, $base_quicentro2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_quicentro1=sqlsrv_query($conn,$sql_quicentro1);

// $sql_quicentro2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH QUICENTRO', $nuevos_quicentro, $nuevos_quicentro2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_quicentro2=sqlsrv_query($conn,$sql_quicentro2);

// $sql_quicentro3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH QUICENTRO', $recuperados_quicentro, $recuperados_quicentro2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_quicentro3=sqlsrv_query($conn,$sql_quicentro3);

//-------------------------

$total_facturas_jardin = $base_jardin + $nuevos_jardin + $recuperados_jardin;
$total_venta_jardin = $base_jardin2 + $nuevos_jardin2 + $recuperados_jardin2;

// $sql_jardin1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH JARDIN', $base_jardin, $base_jardin2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_jardin1=sqlsrv_query($conn,$sql_jardin1);

// $sql_jardin2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH JARDIN', $nuevos_jardin, $nuevos_jardin2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_jardin2=sqlsrv_query($conn,$sql_jardin2);

// $sql_jardin3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH JARDIN', $recuperados_jardin, $recuperados_jardin2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_jardin3=sqlsrv_query($conn,$sql_jardin3);

//-----------------------------

$total_facturas_cuenca = $base_cuenca + $nuevos_cuenca + $recuperados_cuenca;
$total_venta_cuenca = $base_cuenca2 + $nuevos_cuenca2 + $recuperados_cuenca2;

// $sql_cuenca1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL RIO', $base_cuenca, $base_cuenca2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_cuenca1=sqlsrv_query($conn,$sql_cuenca1);

// $sql_cuenca2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL RIO', $nuevos_cuenca, $nuevos_cuenca2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_cuenca2=sqlsrv_query($conn,$sql_cuenca2);

// $sql_cuenca3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL RIO', $recuperados_cuenca, $recuperados_cuenca2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_cuenca3=sqlsrv_query($conn,$sql_cuenca3);

//-------------------------------

$total_facturas_manta = $base_manta + $nuevos_manta + $recuperados_manta;
$total_venta_manta = $base_manta2 + $nuevos_manta2 + $recuperados_manta2;

// $sql_manta1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL PACIFICO', $base_manta, $base_manta2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_manta1=sqlsrv_query($conn,$sql_manta1);

// $sql_manta2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL PACIFICO', $nuevos_manta, $nuevos_manta2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_manta2=sqlsrv_query($conn,$sql_manta2);

// $sql_manta3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL PACIFICO', $recuperados_manta, $recuperados_manta2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_manta3=sqlsrv_query($conn,$sql_manta3);

//----------------------------------

$total_facturas_sol = $base_sol + $nuevos_sol + $recuperados_sol;
$total_venta_sol = $base_sol2 + $nuevos_sol2 + $recuperados_sol2;

// $sql_sol1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL SOL', $base_sol, $base_sol2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_sol1=sqlsrv_query($conn,$sql_sol1);

// $sql_sol2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL SOL', $nuevos_sol, $nuevos_sol2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_sol2=sqlsrv_query($conn,$sql_sol2);

// $sql_sol3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH MALL DEL SOL', $recuperados_sol, $recuperados_sol2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_sol3=sqlsrv_query($conn,$sql_sol3);

//-----------------------------------

$total_facturas_marino = $base_marino + $nuevos_marino + $recuperados_marino;
$total_venta_marino = $base_marino2 + $nuevos_marino2 + $recuperados_marino2;

// $sql_marino1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH SAN MARINO', $base_marino, $base_marino2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_marino1=sqlsrv_query($conn,$sql_marino1);

// $sql_marino2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH SAN MARINO', $nuevos_marino, $nuevos_marino2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_marino2=sqlsrv_query($conn,$sql_marino2);

// $sql_marino3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('CH SAN MARINO', $recuperados_marino, $recuperados_marino2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_marino3=sqlsrv_query($conn,$sql_marino3);

//-------------------------------------

$total_facturas_ceibos = $base_ceibos + $nuevos_ceibos + $recuperados_ceibos;
$total_venta_ceibos = $base_ceibos2 + $nuevos_ceibos2 + $recuperados_ceibos2;

?>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="8">CANTIDAD DE FACTURAS POR ESTADO DE CLIENTES <?php echo "Periodo: ".$desdenew2." AL ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">ESTADO</th>
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
        <td>Mismos clientes</td>
        <td><?php echo $base_quicentro?></td>
        <td><?php echo $base_jardin?></td>
        <td><?php echo $base_cuenca?></td>
        <td><?php echo $base_manta?></td>
        <td><?php echo $base_sol?></td>
        <td><?php echo $base_marino?></td>
        <td><?php echo $base_ceibos?></td>
    </tr>
    <tr>
        <td>Nuevos</td>
        <td><?php echo $nuevos_quicentro?></td>
        <td><?php echo $nuevos_jardin?></td>
        <td><?php echo $nuevos_cuenca?></td>
        <td><?php echo $nuevos_manta?></td>
        <td><?php echo $nuevos_sol?></td>
        <td><?php echo $nuevos_marino?></td>
        <td><?php echo $nuevos_ceibos?></td>
    </tr>
    <tr>
        <td>Recuperados</td>
        <td><?php echo $recuperados_quicentro?></td>
        <td><?php echo $recuperados_jardin?></td>
        <td><?php echo $recuperados_cuenca?></td>
        <td><?php echo $recuperados_manta?></td>
        <td><?php echo $recuperados_sol?></td>
        <td><?php echo $recuperados_marino?></td>
        <td><?php echo $recuperados_ceibos?></td>
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
        <th colspan="8">VENTA POR ESTADO DE CLIENTES <?php echo "Periodo: ".$desdenew2." AL ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">ESTADO</th>
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
        <td>Mismos clientes</td>
        <td><?php echo number_format($base_quicentro2,2,',','')?></td>
        <td><?php echo number_format($base_jardin2,2,',','')?></td>
        <td><?php echo number_format($base_cuenca2,2,',','')?></td>
        <td><?php echo number_format($base_manta2,2,',','')?></td>
        <td><?php echo number_format($base_sol2,2,',','')?></td>
        <td><?php echo number_format($base_marino2,2,',','')?></td>
        <td><?php echo number_format($base_ceibos2,2,',','')?></td>
    </tr>
    <tr>
        <td>Nuevos</td>
        <td><?php echo number_format($nuevos_quicentro2,2,',','')?></td>
        <td><?php echo number_format($nuevos_jardin2,2,',','')?></td>
        <td><?php echo number_format($nuevos_cuenca2,2,',','')?></td>
        <td><?php echo number_format($nuevos_manta2,2,',','')?></td>
        <td><?php echo number_format($nuevos_sol2,2,',','')?></td>
        <td><?php echo number_format($nuevos_marino2,2,',','')?></td>
        <td><?php echo number_format($nuevos_ceibos2,2,',','')?></td>
    </tr>
    <tr>
        <td>Recuperados</td>
        <td><?php echo number_format($recuperados_quicentro2,2,',','')?></td>
        <td><?php echo number_format($recuperados_jardin2,2,',','')?></td>
        <td><?php echo number_format($recuperados_cuenca2,2,',','')?></td>
        <td><?php echo number_format($recuperados_manta2,2,',','')?></td>
        <td><?php echo number_format($recuperados_sol2,2,',','')?></td>
        <td><?php echo number_format($recuperados_marino2,2,',','')?></td>
        <td><?php echo number_format($recuperados_ceibos2,2,',','')?></td>
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