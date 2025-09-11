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

$desdenew = $anio_anterior."-".date("m",strtotime($hasta3))."-01T00:00:00";
$desdenew2 = $anio_anterior."-".date("m",strtotime($hasta3))."-01";

    $nuevos_quicentro = 0;
    $recuperados_quicentro = 0;
    $base_quicentro = 0;
    $nuevos_quicentro2 = 0;
    $recuperados_quicentro2 = 0;
    $base_quicentro2 = 0;
    $nuevos_quicentro3 = 0;
    $recuperados_quicentro3 = 0;
    $base_quicentro3 = 0;
    $total_facturas_quicentro = 0;
    $total_venta_quicentro = 0;
    $total_clientes_quicentro = 0;

    $nuevos_jardin = 0;
    $recuperados_jardin = 0;
    $base_jardin = 0;
    $nuevos_jardin2 = 0;
    $recuperados_jardin2 = 0;
    $base_jardin2 = 0;
    $nuevos_jardin3 = 0;
    $recuperados_jardin3 = 0;
    $base_jardin3 = 0;
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

    $nuevos_manta = 0;
    $recuperados_manta = 0;
    $base_manta = 0;
    $nuevos_manta2 = 0;
    $recuperados_manta2 = 0;
    $base_manta2 = 0;
    $total_facturas_manta = 0;
    $total_venta_manta = 0;

    $nuevos_sol = 0;
    $recuperados_sol = 0;
    $base_sol = 0;
    $nuevos_sol2 = 0;
    $recuperados_sol2 = 0;
    $base_sol2 = 0;
    $total_facturas_sol = 0;
    $total_venta_sol = 0;

    $nuevos_sur = 0;
    $recuperados_sur = 0;
    $base_sur = 0;
    $nuevos_sur2 = 0;
    $recuperados_sur2 = 0;
    $base_sur2 = 0;
    $total_facturas_sur = 0;
    $total_venta_sur = 0;

    $nuevos_eco = 0;
    $recuperados_eco = 0;
    $base_eco = 0;
    $nuevos_eco2 = 0;
    $recuperados_eco2 = 0;
    $base_eco2 = 0;
    $total_facturas_eco = 0;
    $total_venta_eco = 0;

    $nuevos_riocentro = 0;
    $recuperados_riocentro = 0;
    $base_riocentro = 0;
    $nuevos_riocentro2 = 0;
    $recuperados_riocentro2 = 0;
    $base_riocentro2 = 0;
    $total_facturas_riocentro = 0;
    $total_venta_riocentro = 0;

    $nuevos_nb = 0;
    $recuperados_nb = 0;
    $base_nb = 0;
    $nuevos_nb2 = 0;
    $recuperados_nb2 = 0;
    $base_nb2 = 0;
    $total_facturas_nb = 0;
    $total_venta_nb = 0;

session_start(); 
    
    $sql = "SELECT 
                (SELECT COUNT(DISTINCT NUMERO_DOCUMENTO) WHERE FECHA BETWEEN '$desdenew' AND '$hasta4') AS FACTURAS, 
                (SELECT SUM(VTA_NETA) WHERE FECHA BETWEEN '$desdenew' AND '$hasta4') AS VENTA,
                (SELECT COUNT(DISTINCT NUMERO_DOCUMENTO) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desdenew' AND '$hasta4' AND ALMACEN = a.ALMACEN) AS CLIENTES, 
                --(SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desdenew' AND '$hasta4' AND ALMACEN = a.ALMACEN) AS VENTA,
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
                (ALMACEN LIKE '%SIETE %' OR ALMACEN LIKE '%POP%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%NEW BALANCE%')
                GROUP BY CEDULA_RUC,FECHA,FECHA_MODIFICACION, ALMACEN";
    $res=sqlsrv_query($conn,$sql);

    //echo $sql;

    while($row=sqlsrv_fetch_array($res)) { 
        $almacen = $row["ALMACEN"];
        $estado = $row["ESTADO"];
        $fecha = date_format($row["FECHA_MODIFICACION"],"Y-m-d");
        //echo $fecha;

        //FACTURAS MISMOS CLIENTES
        if($estado == "Mismo Cliente"){
            if($almacen == "SIETE QUICENTRO"){
                $base_quicentro+=$row["FACTURAS"];
                $base_quicentro2+=$row["VENTA"];
                if($row["CLIENTES"] > 0){
                    $base_quicentro3++;
                }
            }
            if($almacen == "SIETE JARDIN"){
                $base_jardin+=$row["FACTURAS"];
                $base_jardin2+=$row["VENTA"];
                if($row["CLIENTES"] > 0){
                    $base_jardin3++;
                }
            }
            if($almacen == "SIETE MALL DEL RIO"){
                $base_cuenca+=$row["FACTURAS"];
                $base_cuenca2+=$row["VENTA"];
            }
            if($almacen == "SIETE MALL DEL PACIFICO"){
                $base_manta+=$row["FACTURAS"];
                $base_manta2+=$row["VENTA"];
            }
            if($almacen == "POP UP MALL DE LSOL"){
                $base_sol+=$row["FACTURAS"];
                $base_sol2+=$row["VENTA"];
            }
            if($almacen == "QUICENTRO SUR"){
                $base_sur+=$row["FACTURAS"];
                $base_sur2+=$row["VENTA"];
            }

            if($almacen == "ECOMMERCE"){
                $base_eco+=$row["FACTURAS"];
                $base_eco2+=$row["VENTA"];
            }

            if($almacen == "SIETE RIOCENTRO"){
                $base_riocentro+=$row["FACTURAS"];
                $base_riocentro2+=$row["VENTA"];
            }

            if($almacen == "NEW BALANCE"){
                $base_nb+=$row["FACTURAS"];
                $base_nb2+=$row["VENTA"];
            }
        }

        if($estado == "Nuevo o Recuperado"){

            //NUEVOS CLIENTES
            if($fecha >= $desdenew2 && $fecha <= $hasta3){
                if($almacen == "SIETE QUICENTRO"){
                    $nuevos_quicentro+=$row["FACTURAS"];
                    $nuevos_quicentro2+=$row["VENTA"];
                    if($row["CLIENTES"] > 0){
                        $nuevos_quicentro3++;
                    }
                }
                if($almacen == "SIETE JARDIN"){
                    $nuevos_jardin+=$row["FACTURAS"];
                    $nuevos_jardin2+=$row["VENTA"];
                    if($row["CLIENTES"] > 0){
                        $nuevos_jardin3++;
                    }
                }
                if($almacen == "SIETE MALL DEL RIO"){
                    $nuevos_cuenca+=$row["FACTURAS"];
                    $nuevos_cuenca2+=$row["VENTA"];
                }
                if($almacen == "SIETE MALL DEL PACIFICO"){
                    $nuevos_manta+=$row["FACTURAS"];
                    $nuevos_manta2+=$row["VENTA"];
                }
                if($almacen == "POP UP MALL DE LSOL"){
                    $nuevos_sol+=$row["FACTURAS"];
                    $nuevos_sol2+=$row["VENTA"];
                }
                if($almacen == "QUICENTRO SUR"){
                    $nuevos_sur+=$row["FACTURAS"];
                    $nuevos_sur2+=$row["VENTA"];
                }
                if($almacen == "ECOMMERCE"){
                    $nuevos_eco+=$row["FACTURAS"];
                    $nuevos_eco2+=$row["VENTA"];
                }
                if($almacen == "SIETE RIOCENTRO"){
                    $nuevos_riocentro+=$row["FACTURAS"];
                    $nuevos_riocentro2+=$row["VENTA"];
                }
                if($almacen == "NEW BALANCE"){
                    $nuevos_nb+=$row["FACTURAS"];
                    $nuevos_nb2+=$row["VENTA"];
                }
            }

            //CLIENTES RECUPERADOS
            else{
                if($almacen == "SIETE QUICENTRO"){
                    $recuperados_quicentro+=$row["FACTURAS"];
                    $recuperados_quicentro2+=$row["VENTA"];
                    if($row["CLIENTES"] > 0){
                        $recuperados_quicentro3++;
                    }
                }
                if($almacen == "SIETE JARDIN"){
                    $recuperados_jardin+=$row["FACTURAS"];
                    $recuperados_jardin2+=$row["VENTA"];
                    if($row["CLIENTES"] > 0){
                        $recuperados_jardin3++;
                    }
                }
                if($almacen == "SIETE MALL DEL RIO"){
                    $recuperados_cuenca+=$row["FACTURAS"];
                    $recuperados_cuenca2+=$row["VENTA"];
                }
                if($almacen == "SIETE MALL DEL PACIFICO"){
                    $recuperados_manta+=$row["FACTURAS"];
                    $recuperados_manta2+=$row["VENTA"];
                }
                if($almacen == "POP UP MALL DE LSOL"){
                    $recuperados_sol+=$row["FACTURAS"];
                    $recuperados_sol2+=$row["VENTA"];
                }
                if($almacen == "QUICENTRO SUR"){
                    $recuperados_sur+=$row["FACTURAS"];
                    $recuperados_sur2+=$row["VENTA"];
                }
                if($almacen == "ECOMMERCE"){
                    $recuperados_eco+=$row["FACTURAS"];
                    $recuperados_eco2+=$row["VENTA"];
                }
                if($almacen == "SIETE RIOCENTRO"){
                    $recuperados_riocentro+=$row["FACTURAS"];
                    $recuperados_riocentro2+=$row["VENTA"];
                }
                if($almacen == "NEW BALANCE"){
                    $recuperados_nb+=$row["FACTURAS"];
                    $recuperados_nb2+=$row["VENTA"];
                }
            }
        }
    }
//echo $sql;

$total_facturas_quicentro = $base_quicentro + $nuevos_quicentro + $recuperados_quicentro;
$total_venta_quicentro = $base_quicentro2 + $nuevos_quicentro2 + $recuperados_quicentro2;
$total_clientes_quicentro = $base_quicentro3 + $nuevos_quicentro3 + $recuperados_quicentro3;

// $sql_jardin1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE QUICENTRO', $base_jardin, $base_jardin2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_jardin1=sqlsrv_query($conn,$sql_jardin1);

// $sql_jardin2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE QUICENTRO', $nuevos_jardin, $nuevos_jardin2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_jardin2=sqlsrv_query($conn,$sql_jardin2);

// $sql_jardin3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE QUICENTRO', $recuperados_jardin, $recuperados_jardin2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_jardin3=sqlsrv_query($conn,$sql_jardin3);

//-------------------------

$total_facturas_jardin = $base_jardin + $nuevos_jardin + $recuperados_jardin;
$total_venta_jardin = $base_jardin2 + $nuevos_jardin2 + $recuperados_jardin2;
$total_clientes_jardin = $base_jardin3 + $nuevos_jardin3 + $recuperados_jardin3;

// $sql_jardin1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE JARDIN', $base_jardin, $base_jardin2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_jardin1=sqlsrv_query($conn,$sql_jardin1);

// $sql_jardin2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE JARDIN', $nuevos_jardin, $nuevos_jardin2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_jardin2=sqlsrv_query($conn,$sql_jardin2);

// $sql_jardin3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE JARDIN', $recuperados_jardin, $recuperados_jardin2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_jardin3=sqlsrv_query($conn,$sql_jardin3);

//-------------------------

$total_facturas_cuenca = $base_cuenca + $nuevos_cuenca + $recuperados_cuenca;
$total_venta_cuenca = $base_cuenca2 + $nuevos_cuenca2 + $recuperados_cuenca2;

// $sql_cuenca1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE MALL DEL RIO', $base_cuenca, $base_cuenca2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_cuenca1=sqlsrv_query($conn,$sql_cuenca1);

// $sql_cuenca2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE MALL DEL RIO', $nuevos_cuenca, $nuevos_cuenca2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_cuenca2=sqlsrv_query($conn,$sql_cuenca2);

// $sql_cuenca3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE MALL DEL RIO', $recuperados_cuenca, $recuperados_cuenca2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_cuenca3=sqlsrv_query($conn,$sql_cuenca3);

//-------------------------

$total_facturas_manta = $base_manta + $nuevos_manta + $recuperados_manta;
$total_venta_manta = $base_manta2 + $nuevos_manta2 + $recuperados_manta2;

// $sql_manta1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE MALL DEL PACIFICO', $base_manta, $base_manta2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_manta1=sqlsrv_query($conn,$sql_manta1);

// $sql_manta2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE MALL DEL PACIFICO', $nuevos_manta, $nuevos_manta2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_manta2=sqlsrv_query($conn,$sql_manta2);

// $sql_manta3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('SIETE MALL DEL PACIFICO', $recuperados_manta, $recuperados_manta2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_manta3=sqlsrv_query($conn,$sql_manta3);

//-------------------------

$total_facturas_sol = $base_sol + $nuevos_sol + $recuperados_sol;
$total_venta_sol = $base_sol2 + $nuevos_sol2 + $recuperados_sol2;

// $sql_sol1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('POP UP', $base_sol, $base_sol2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_sol1=sqlsrv_query($conn,$sql_sol1);

// $sql_sol2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('POP UP', $nuevos_sol, $nuevos_sol2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_sol2=sqlsrv_query($conn,$sql_sol2);

// $sql_sol3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('POP UP', $recuperados_sol, $recuperados_sol2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_sol3=sqlsrv_query($conn,$sql_sol3);

//-------------------------

$total_facturas_sur = $base_sur + $nuevos_sur + $recuperados_sur;
$total_venta_sur = $base_sur2 + $nuevos_sur2 + $recuperados_sur2;

// $sql_sur1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('QUICENTRO SUR', $base_sur, $base_sur2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_sur1=sqlsrv_query($conn,$sql_sur1);

// $sql_sur2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('QUICENTRO SUR', $nuevos_sur, $nuevos_sur2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_sur2=sqlsrv_query($conn,$sql_sur2);

// $sql_sur3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('QUICENTRO SUR', $recuperados_sur, $recuperados_sur2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_sur3=sqlsrv_query($conn,$sql_sur3);

//-------------------------

$total_facturas_eco = $base_eco + $nuevos_eco + $recuperados_eco;
$total_venta_eco = $base_eco2 + $nuevos_eco2 + $recuperados_eco2;

// $sql_eco1 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('ECOMMERCE', $base_eco, $base_eco2, 'MISMOS CLIENTES', '$desdenew', '$hasta4')";
// $res_eco1=sqlsrv_query($conn,$sql_eco1);

// $sql_eco2 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('ECOMMERCE', $nuevos_eco, $nuevos_eco2, 'NUEVOS', '$desdenew', '$hasta4')";
// $res_eco2=sqlsrv_query($conn,$sql_eco2);

// $sql_eco3 = "INSERT INTO CAP_FACT_ESTADO(tienda,facturas,dinero,estado,desde,hasta) 
// VALUES('ECOMMERCE', $recuperados_eco, $recuperados_eco2, 'RECUPERADOS', '$desdenew', '$hasta4')";
// $res_eco3=sqlsrv_query($conn,$sql_eco3);

$total_facturas_riocentro = $base_riocentro + $nuevos_riocentro + $recuperados_riocentro;
$total_venta_riocentro = $base_riocentro2 + $nuevos_riocentro2 + $recuperados_riocentro2;

$total_facturas_nb = $base_nb + $nuevos_nb + $recuperados_nb;
$total_venta_nb = $base_nb2 + $nuevos_nb2 + $recuperados_nb2;

//-------------------------
?>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="9">CANTIDAD DE FACTURAS POR ESTADO DE CLIENTES <?php //echo $desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">ESTADO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">POP UP</th>
        <th class="sortable-column sort-asc">QUICENTRO SUR</th>
        <th class="sortable-column sort-asc">ECOMMERCE</th>
        <th class="sortable-column sort-asc">RIOCENTRO</th>
        <th class="sortable-column sort-asc">NEW BALANCE</th>
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
        <td><?php echo $base_sur?></td>
        <td><?php echo $base_eco?></td>
        <td><?php echo $base_riocentro?></td>
        <td><?php echo $base_nb?></td>
    </tr>
    <tr>
        <td>Nuevos</td>
        <td><?php echo $nuevos_quicentro?></td>
        <td><?php echo $nuevos_jardin?></td>
        <td><?php echo $nuevos_cuenca?></td>
        <td><?php echo $nuevos_manta?></td>
        <td><?php echo $nuevos_sol?></td>
        <td><?php echo $nuevos_sur?></td>
        <td><?php echo $nuevos_eco?></td>
        <td><?php echo $nuevos_riocentro?></td>
        <td><?php echo $nuevos_nb?></td>
    </tr>
    <tr>
        <td>Recuperados</td>
        <td><?php echo $recuperados_quicentro?></td>
        <td><?php echo $recuperados_jardin?></td>
        <td><?php echo $recuperados_cuenca?></td>
        <td><?php echo $recuperados_manta?></td>
        <td><?php echo $recuperados_sol?></td>
        <td><?php echo $recuperados_sur?></td>
        <td><?php echo $recuperados_eco?></td>
        <td><?php echo $recuperados_riocentro?></td>
        <td><?php echo $recuperados_nb?></td>
    </tr>
    </tbody>

    <tfoot>
        <th>Total</th>
        <th><?php echo $total_facturas_quicentro ?></th>
        <th><?php echo $total_facturas_jardin ?></th>
        <th><?php echo $total_facturas_cuenca ?></th>
        <th><?php echo $total_facturas_manta ?></th>
        <th><?php echo $total_facturas_sol ?></th>
        <th><?php echo $total_facturas_sur ?></th>
        <th><?php echo $total_facturas_eco ?></th>
        <th><?php echo $total_facturas_riocentro ?></th>
        <th><?php echo $total_facturas_nb ?></th>
    </tfoot>
    
</table>

<hr>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="9">VENTA POR ESTADO DE CLIENTES <?php //echo $desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">ESTADO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">POP UP</th>
        <th class="sortable-column sort-asc">QUICENTRO SUR</th>
        <th class="sortable-column sort-asc">ECOMMERCE</th>
        <th class="sortable-column sort-asc">RIOCENTRO</th>
        <th class="sortable-column sort-asc">NEW BALANCE</th>
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
        <td><?php echo number_format($base_sur2,2,',','')?></td>
        <td><?php echo number_format($base_eco2,2,',','')?></td>
        <td><?php echo number_format($base_riocentro2,2,',','')?></td>
        <td><?php echo number_format($base_nb2,2,',','')?></td>
    </tr>
    <tr>
        <td>Nuevos</td>
        <td><?php echo number_format($nuevos_quicentro2,2,',','')?></td>
        <td><?php echo number_format($nuevos_jardin2,2,',','')?></td>
        <td><?php echo number_format($nuevos_cuenca2,2,',','')?></td>
        <td><?php echo number_format($nuevos_manta2,2,',','')?></td>
        <td><?php echo number_format($nuevos_sol2,2,',','')?></td>
        <td><?php echo number_format($nuevos_sur2,2,',','')?></td>
        <td><?php echo number_format($nuevos_eco2,2,',','')?></td>
        <td><?php echo number_format($nuevos_riocentro2,2,',','')?></td>
        <td><?php echo number_format($nuevos_nb2,2,',','')?></td>
    </tr>
    <tr>
        <td>Recuperados</td>
        <td><?php echo number_format($recuperados_quicentro2,2,',','')?></td>
        <td><?php echo number_format($recuperados_jardin2,2,',','')?></td>
        <td><?php echo number_format($recuperados_cuenca2,2,',','')?></td>
        <td><?php echo number_format($recuperados_manta2,2,',','')?></td>
        <td><?php echo number_format($recuperados_sol2,2,',','')?></td>
        <td><?php echo number_format($recuperados_sur2,2,',','')?></td>
        <td><?php echo number_format($recuperados_eco2,2,',','')?></td>
        <td><?php echo number_format($recuperados_riocentro2,2,',','')?></td>
        <td><?php echo number_format($recuperados_nb2,2,',','')?></td>
    </tr>
    </tbody>

    <tfoot>
        <th>Total</th>
        <th><?php echo number_format($total_venta_quicentro,2,',','') ?></th>
        <th><?php echo number_format($total_venta_jardin,2,',','') ?></th>
        <th><?php echo number_format($total_venta_cuenca,2,',','') ?></th>
        <th><?php echo number_format($total_venta_manta,2,',','') ?></th>
        <th><?php echo number_format($total_venta_sol,2,',','') ?></th>
        <th><?php echo number_format($total_venta_sur,2,',','') ?></th>
        <th><?php echo number_format($total_venta_eco,2,',','') ?></th>
        <th><?php echo number_format($total_venta_riocentro,2,',','') ?></th>
        <th><?php echo number_format($total_venta_nb,2,',','') ?></th>
    </tfoot>
    
</table>

<hr>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="8">CANTIDAD DE CLIENTES POR ESTADO <?php //echo $desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">ESTADO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">POP UP</th>
        <th class="sortable-column sort-asc">QUICENTRO SUR</th>
        <th class="sortable-column sort-asc">ECOMMERCE</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Mismos clientes</td>
        <td><?php echo $base_quicentro3?></td>
        <td><?php echo $base_jardin3?></td>
        <td><?php echo $base_cuenca2?></td>
        <td><?php echo $base_manta2?></td>
        <td><?php echo $base_sol2?></td>
        <td><?php echo $base_sur2?></td>
        <td><?php echo $base_eco2?></td>
    </tr>
    <tr>
        <td>Nuevos</td>
        <td><?php echo $nuevos_quicentro3?></td>
        <td><?php echo $nuevos_jardin3?></td>
        <td><?php echo $nuevos_cuenca2?></td>
        <td><?php echo $nuevos_manta2?></td>
        <td><?php echo $nuevos_sol2?></td>
        <td><?php echo $nuevos_sur2?></td>
        <td><?php echo $nuevos_eco2?></td>
    </tr>
    <tr>
        <td>Recuperados</td>
        <td><?php echo $recuperados_quicentro3?></td>
        <td><?php echo $recuperados_jardin3?></td>
        <td><?php echo $recuperados_cuenca2?></td>
        <td><?php echo $recuperados_manta2?></td>
        <td><?php echo $recuperados_sol2?></td>
        <td><?php echo $recuperados_sur2?></td>
        <td><?php echo $recuperados_eco2?></td>
    </tr>
    </tbody>

    <tfoot>
        <th>Total</th>
        <th><?php echo $total_clientes_quicentro ?></th>
        <th><?php echo $total_clientes_jardin ?></th>
        <th><?php echo $total_venta_cuenca ?></th>
        <th><?php echo $total_venta_manta ?></th>
        <th><?php echo $total_venta_sol ?></th>
        <th><?php echo $total_venta_sur ?></th>
        <th><?php echo $total_venta_eco ?></th>
    </tfoot>
    
</table>