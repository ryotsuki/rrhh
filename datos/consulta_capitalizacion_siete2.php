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

$Friend_quicentro = 0;
$BestFriend_quicentro = 0;
$Partner_quicentro = 0;
$Family_quicentro = 0;
$total_facturas_quicentro = 0;
$Friend_quicentro2 = 0;
$BestFriend_quicentro2 = 0;
$Partner_quicentro2 = 0;
$Family_quicentro2 = 0;
$total_clientes_quicentro = 0;
$Friend_quicentro3 = 0;
$BestFriend_quicentro3 = 0;
$Partner_quicentro3 = 0;
$Family_quicentro3 = 0;
$total_venta_quicentro = 0;

$Friend_jardin = 0;
$BestFriend_jardin = 0;
$Partner_jardin = 0;
$Family_jardin = 0;
$total_facturas_jardin = 0;
$Friend_jardin2 = 0;
$BestFriend_jardin2 = 0;
$Partner_jardin2 = 0;
$Family_jardin2 = 0;
$total_clientes_jardin = 0;
$Friend_jardin3 = 0;
$BestFriend_jardin3 = 0;
$Partner_jardin3 = 0;
$Family_jardin3 = 0;
$total_venta_jardin = 0;

$Friend_cuenca = 0;
$BestFriend_cuenca = 0;
$Partner_cuenca = 0;
$Family_cuenca = 0;
$total_facturas_cuenca = 0;
$Friend_cuenca2 = 0;
$BestFriend_cuenca2 = 0;
$Partner_cuenca2 = 0;
$Family_cuenca2 = 0;
$total_clientes_cuenca = 0;
$Friend_cuenca3 = 0;
$BestFriend_cuenca3 = 0;
$Partner_cuenca3 = 0;
$Family_cuenca3 = 0;
$total_venta_cuenca = 0;

$Friend_manta = 0;
$BestFriend_manta = 0;
$Partner_manta = 0;
$Family_manta = 0;
$total_facturas_manta = 0;
$Friend_manta2 = 0;
$BestFriend_manta2 = 0;
$Partner_manta2 = 0;
$Family_manta2 = 0;
$total_clientes_manta = 0;
$Friend_manta3 = 0;
$BestFriend_manta3 = 0;
$Partner_manta3 = 0;
$Family_manta3 = 0;
$total_venta_manta = 0;

$Friend_sol = 0;
$BestFriend_sol = 0;
$Partner_sol = 0;
$Family_sol = 0;
$total_facturas_sol = 0;
$Friend_sol2 = 0;
$BestFriend_sol2 = 0;
$Partner_sol2 = 0;
$Family_sol2 = 0;
$total_clientes_sol = 0;
$Friend_sol3 = 0;
$BestFriend_sol3 = 0;
$Partner_sol3 = 0;
$Family_sol3 = 0;
$total_venta_sol = 0;

$Friend_sur = 0;
$BestFriend_sur = 0;
$Partner_sur = 0;
$Family_sur = 0;
$total_facturas_sur = 0;
$Friend_sur2 = 0;
$BestFriend_sur2 = 0;
$Partner_sur2 = 0;
$Family_sur2 = 0;
$total_clientes_sur = 0;
$Friend_sur3 = 0;
$BestFriend_sur3 = 0;
$Partner_sur3 = 0;
$Family_sur3 = 0;
$total_venta_sur = 0;

$Friend_eco = 0;
$BestFriend_eco = 0;
$Partner_eco = 0;
$Family_eco = 0;
$total_facturas_eco = 0;
$Friend_eco2 = 0;
$BestFriend_eco2 = 0;
$Partner_eco2 = 0;
$Family_eco2 = 0;
$total_clientes_eco = 0;
$Friend_eco3 = 0;
$BestFriend_eco3 = 0;
$Partner_eco3 = 0;
$Family_eco3 = 0;
$total_venta_eco = 0;

$Friend_riocentro = 0;
$BestFriend_riocentro = 0;
$Partner_riocentro = 0;
$Family_riocentro = 0;
$total_facturas_riocentro = 0;
$Friend_riocentro2 = 0;
$BestFriend_riocentro2 = 0;
$Partner_riocentro2 = 0;
$Family_riocentro2 = 0;
$total_clientes_riocentro = 0;
$Friend_riocentro3 = 0;
$BestFriend_riocentro3 = 0;
$Partner_riocentro3 = 0;
$Family_riocentro3 = 0;
$total_venta_riocentro = 0;

$Friend_nb = 0;
$BestFriend_nb = 0;
$Partner_nb = 0;
$Family_nb = 0;
$total_facturas_nb = 0;
$Friend_nb2 = 0;
$BestFriend_nb2 = 0;
$Partner_nb2 = 0;
$Family_nb2 = 0;
$total_clientes_nb = 0;
$Friend_nb3 = 0;
$BestFriend_nb3 = 0;
$Partner_nb3 = 0;
$Family_nb3 = 0;
$total_venta_nb = 0;

session_start(); 

    //echo $sql;
    
    $sql = "SELECT DISTINCT CEDULA_RUC,
            (SELECT COUNT(DISTINCT NUMERO_DOCUMENTO) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desdenew' AND '$hasta4' AND ALMACEN = a.ALMACEN) AS FACTURAS, 
            (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desdenew' AND '$hasta4' AND ALMACEN = a.ALMACEN) AS VENTA,
            a.ALMACEN,
            CASE   
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) >= 5 AND (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) <= 300.99 THEN 'Friend'
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) >= 301 AND (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) <= 500.99 THEN 'Best Friend'
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) >= 501 AND (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) <= 899.99 THEN 'Partner'
                WHEN (SELECT SUM(VTA_NETA) FROM VENTAS WHERE CEDULA_RUC = a.CEDULA_RUC AND FECHA BETWEEN '$desde4' and '$hasta4' AND ALMACEN = a.ALMACEN) > 900 THEN 'Family'
            END AS SEGMENTO
            from VENTAS a
            where FECHA between '$desde4' AND '$hasta4'
            AND
            (ALMACEN LIKE '%SIETE %' OR ALMACEN LIKE '%POP%' OR ALMACEN LIKE '%SUR%' OR ALMACEN LIKE '%ECOMMERCE%' OR ALMACEN LIKE '%NEW BALANCE%') 
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
        if($segmento == "Friend" || $segmento == ""){
            if($almacen == "SIETE QUICENTRO"){
                $Friend_quicentro+=$row["FACTURAS"];
                $Friend_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_quicentro2++;
                }
            }
            if($almacen == "SIETE JARDIN"){
                $Friend_jardin+=$row["FACTURAS"];
                $Friend_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_jardin2++;
                }
            }
            if($almacen == "SIETE MALL DEL RIO"){
                $Friend_cuenca+=$row["FACTURAS"];
                $Friend_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_cuenca2++;
                }
            }
            if($almacen == "SIETE MALL DEL PACIFICO"){
                $Friend_manta+=$row["FACTURAS"];
                $Friend_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_manta2++;
                }
            }
            if($almacen == "POP UP MALL DE LSOL"){
                $Friend_sol+=$row["FACTURAS"];
                $Friend_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_sol2++;
                }
            }
            if($almacen == "QUICENTRO SUR"){
                $Friend_sur+=$row["FACTURAS"];
                $Friend_sur3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_sur2++;
                }
            }
            if($almacen == "ECOMMERCE"){
                $Friend_eco+=$row["FACTURAS"];
                $Friend_eco3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_eco2++;
                }
            }
            if($almacen == "SIETE RIOCENTRO"){
                $Friend_riocentro+=$row["FACTURAS"];
                $Friend_riocentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_riocentro2++;
                }
            }
            if($almacen == "NEW BALANCE"){
                $Friend_nb+=$row["FACTURAS"];
                $Friend_nb3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Friend_nb2++;
                }
            }
        }

        if($segmento == "Best Friend"){
            //NUEVOS CLIENTES
            if($almacen == "SIETE QUICENTRO"){
                $BestFriend_quicentro+=$row["FACTURAS"];
                $BestFriend_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_quicentro2++;
                }
            }
            if($almacen == "SIETE JARDIN"){
                $BestFriend_jardin+=$row["FACTURAS"];
                $BestFriend_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_jardin2++;
                }
            }
            if($almacen == "SIETE MALL DEL RIO"){
                $BestFriend_cuenca+=$row["FACTURAS"];
                $BestFriend_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_cuenca2++;
                }
            }
            if($almacen == "SIETE MALL DEL PACIFICO"){
                $BestFriend_manta+=$row["FACTURAS"];
                $BestFriend_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_manta2++;
                }
            }
            if($almacen == "POP UP MALL DE LSOL"){
                $BestFriend_sol+=$row["FACTURAS"];
                $BestFriend_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_sol2++;
                }
            }
            if($almacen == "QUICENTRO SUR"){
                $BestFriend_sur+=$row["FACTURAS"];
                $BestFriend_sur3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_sur2++;
                }
            }
            if($almacen == "ECOMMERCE"){
                $BestFriend_eco+=$row["FACTURAS"];
                $BestFriend_eco3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_eco2++;
                }
            }
            if($almacen == "SIETE RIOCENTRO"){
                $BestFriend_riocentro+=$row["FACTURAS"];
                $BestFriend_riocentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_riocentro2++;
                }
            }
            if($almacen == "NEW BALANCE"){
                $BestFriend_nb+=$row["FACTURAS"];
                $BestFriend_nb3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $BestFriend_nb2++;
                }
            }
        }

        if($segmento == "Partner"){
            //NUEVOS CLIENTES
            if($almacen == "SIETE QUICENTRO"){
                $Partner_quicentro+=$row["FACTURAS"];
                $Partner_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_quicentro2++;
                }
            }
            if($almacen == "SIETE JARDIN"){
                $Partner_jardin+=$row["FACTURAS"];
                $Partner_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_jardin2++;
                }
            }
            if($almacen == "SIETE MALL DEL RIO"){
                $Partner_cuenca+=$row["FACTURAS"];
                $Partner_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_cuenca2++;
                }
            }
            if($almacen == "SIETE MALL DEL PACIFICO"){
                $Partner_manta+=$row["FACTURAS"];
                $Partner_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_manta2++;
                }
            }
            if($almacen == "POP UP MALL DE LSOL"){
                $Partner_sol+=$row["FACTURAS"];
                $Partner_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_sol2++;
                }
            }
            if($almacen == "QUICENTRO SUR"){
                $Partner_sur+=$row["FACTURAS"];
                $Partner_sur3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_sur2++;
                }
            }
            if($almacen == "ECOMMERCE"){
                $Partner_eco+=$row["FACTURAS"];
                $Partner_eco3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_eco2++;
                }
            }
            if($almacen == "SIETE RIOCENTRO"){
                $Partner_riocentro+=$row["FACTURAS"];
                $Partner_riocentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_riocentro2++;
                }
            }
            if($almacen == "SIETE RIOCENTRO"){
                $Partner_nb+=$row["FACTURAS"];
                $Partner_nb3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Partner_nb2++;
                }
            }
        }

        if($segmento == "Family"){
            //NUEVOS CLIENTES
            if($almacen == "SIETE QUICENTRO"){
                $Family_quicentro+=$row["FACTURAS"];
                $Family_quicentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_quicentro2++;
                }
            }
            if($almacen == "SIETE JARDIN"){
                $Family_jardin+=$row["FACTURAS"];
                $Family_jardin3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_jardin2++;
                }
            }
            if($almacen == "SIETE MALL DEL RIO"){
                $Family_cuenca+=$row["FACTURAS"];
                $Family_cuenca3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_cuenca2++;
                }
            }
            if($almacen == "SIETE MALL DEL PACIFICO"){
                $Family_manta+=$row["FACTURAS"];
                $Family_manta3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_manta2++;
                }
            }
            if($almacen == "POP UP MALL DE LSOL"){
                $Family_sol+=$row["FACTURAS"];
                $Family_sol3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_sol2++;
                }
            }
            if($almacen == "QUICENTRO SUR"){
                $Family_sur+=$row["FACTURAS"];
                $Family_sur3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_sur2++;
                }
            }
            if($almacen == "ECOMMERCE"){
                $Family_eco+=$row["FACTURAS"];
                $Family_eco3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_eco2++;
                }
            }
            if($almacen == "SIETE RIOCENTRO"){
                $Family_riocentro+=$row["FACTURAS"];
                $Family_riocentro3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_riocentro2++;
                }
            }
            if($almacen == "NEW BALANCE"){
                $Family_nb+=$row["FACTURAS"];
                $Family_nb3+=$row["VENTA"];
                if($row["FACTURAS"] > 0){
                    $Family_nb2++;
                }
            }
        }
    }
//echo $sql;

$total_facturas_quicentro = $Friend_quicentro + $BestFriend_quicentro + $Partner_quicentro + $Family_quicentro;
$total_clientes_quicentro = $Friend_quicentro2 + $BestFriend_quicentro2 + $Partner_quicentro2 + $Family_quicentro2 ;
$total_venta_quicentro = $Friend_quicentro3 + $BestFriend_quicentro3 + $Partner_quicentro3 + $Family_quicentro3;

$total_facturas_jardin = $Friend_jardin + $BestFriend_jardin + $Partner_jardin + $Family_jardin;
$total_clientes_jardin = $Friend_jardin2 + $BestFriend_jardin2 + $Partner_jardin2 + $Family_jardin2;
$total_venta_jardin = $Friend_jardin3 + $BestFriend_jardin3 + $Partner_jardin3 + $Family_jardin3;

$total_facturas_cuenca = $Friend_cuenca + $BestFriend_cuenca + $Partner_cuenca + $Family_cuenca;
$total_clientes_cuenca = $Friend_cuenca2 + $BestFriend_cuenca2 + $Partner_cuenca2 + $Family_cuenca2;
$total_venta_cuenca = $Friend_cuenca3 + $BestFriend_cuenca3 + $Partner_cuenca3 + $Family_cuenca3;

$total_facturas_manta = $Friend_manta + $BestFriend_manta + $Partner_manta + $Family_manta;
$total_clientes_manta = $Friend_manta2 + $BestFriend_manta2 + $Partner_manta2 + $Family_manta2;
$total_venta_manta = $Friend_manta3 + $BestFriend_manta3 + $Partner_manta3 + $Family_manta3;

$total_facturas_sol = $Friend_sol + $BestFriend_sol + $Partner_sol + $Family_sol;
$total_clientes_sol = $Friend_sol2 + $BestFriend_sol2 + $Partner_sol2 + $Family_sol2;
$total_venta_sol = $Friend_sol3 + $BestFriend_sol3 + $Partner_sol3 + $Family_sol3;

$total_facturas_sur = $Friend_sur + $BestFriend_sur + $Partner_sur + $Family_sur;
$total_clientes_sur = $Friend_sur2 + $BestFriend_sur2 + $Partner_sur2 + $Family_sur2;
$total_venta_sur = $Friend_sur3 + $BestFriend_sur3 + $Partner_sur3 + $Family_sur3;

$total_facturas_eco = $Friend_eco + $BestFriend_eco + $Partner_eco + $Family_eco;
$total_clientes_eco = $Friend_eco2 + $BestFriend_eco2 + $Partner_eco2 + $Family_eco2;
$total_venta_eco = $Friend_eco3 + $BestFriend_eco3 + $Partner_eco3 + $Family_eco3;

$total_facturas_riocentro = $Friend_riocentro + $BestFriend_riocentro + $Partner_riocentro + $Family_riocentro;
$total_clientes_riocentro = $Friend_riocentro2 + $BestFriend_riocentro2 + $Partner_riocentro2 + $Family_riocentro2;
$total_venta_riocentro = $Friend_riocentro3 + $BestFriend_riocentro3 + $Partner_riocentro3 + $Family_riocentro3;

$total_facturas_nb = $Friend_nb + $BestFriend_nb + $Partner_nb + $Family_nb;
$total_clientes_nb = $Friend_nb2 + $BestFriend_nb2 + $Partner_nb2 + $Family_nb2;
$total_venta_nb = $Friend_nb3 + $BestFriend_nb3 + $Partner_nb3 + $Family_nb3;
?>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="9">CANTIDAD DE FACTURAS POR SEGMENTO DE CLIENTES <?php echo "Periodo: ".$desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">SEGMENTO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">POP UP</th>
        <th class="sortable-column sort-asc">QUICENTRO SUR</th>
        <th class="sortable-column sort-asc">RIOCENTRO</th>
        <th class="sortable-column sort-asc">ECOMMERCE</th>
        <th class="sortable-column sort-asc">NEW BALANCE</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Friend</td>
        <td><?php echo $Friend_quicentro?></td>
        <td><?php echo $Friend_jardin?></td>
        <td><?php echo $Friend_cuenca?></td>
        <td><?php echo $Friend_manta?></td>
        <td><?php echo $Friend_sol?></td>
        <td><?php echo $Friend_sur?></td>
        <td><?php echo $Friend_riocentro?></td>
        <td><?php echo $Friend_eco?></td>
        <td><?php echo $Friend_nb?></td>
    </tr>
    <tr>
        <td>Best Friend</td>
        <td><?php echo $BestFriend_quicentro?></td>
        <td><?php echo $BestFriend_jardin?></td>
        <td><?php echo $BestFriend_cuenca?></td>
        <td><?php echo $BestFriend_manta?></td>
        <td><?php echo $BestFriend_sol?></td> 
        <td><?php echo $BestFriend_sur?></td>
        <td><?php echo $BestFriend_riocentro?></td>
        <td><?php echo $BestFriend_eco?></td>
        <td><?php echo $BestFriend_nb?></td>
    </tr>
    <tr>
        <td>Partner</td>
        <td><?php echo $Partner_quicentro?></td>
        <td><?php echo $Partner_jardin?></td>
        <td><?php echo $Partner_cuenca?></td>
        <td><?php echo $Partner_manta?></td>
        <td><?php echo $Partner_sol?></td>
        <td><?php echo $Partner_sur?></td>
        <td><?php echo $Partner_riocentro?></td>
        <td><?php echo $Partner_eco?></td>
        <td><?php echo $Partner_nb?></td>
    </tr>
    <tr>
        <td>Family</td>
        <td><?php echo $Family_quicentro?></td>
        <td><?php echo $Family_jardin?></td>
        <td><?php echo $Family_cuenca?></td>
        <td><?php echo $Family_manta?></td>
        <td><?php echo $Family_sol?></td>
        <td><?php echo $Family_sur?></td>
        <td><?php echo $Family_riocentro?></td>
        <td><?php echo $Family_eco?></td>
        <td><?php echo $Family_nb?></td>
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
        <th><?php echo $total_facturas_riocentro ?></th>
        <th><?php echo $total_facturas_eco ?></th>
        <th><?php echo $total_facturas_nb ?></th>
    </tfoot>
    
</table>

<hr>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="9">CANTIDAD DE CLIENTES POR SEGMENTO <?php echo "Periodo: ".$desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">SEGMENTO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">POP UP</th>
        <th class="sortable-column sort-asc">QUICENTRO SUR</th>
        <th class="sortable-column sort-asc">RIOCENTRO</th>
        <th class="sortable-column sort-asc">ECOMMERCE</th>
        <th class="sortable-column sort-asc">NEW BALANCE</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Friend</td>
        <td><?php echo $Friend_quicentro2?></td>
        <td><?php echo $Friend_jardin2?></td>
        <td><?php echo $Friend_cuenca2?></td>
        <td><?php echo $Friend_manta2?></td>
        <td><?php echo $Friend_sol2?></td>
        <td><?php echo $Friend_sur2?></td>
        <td><?php echo $Friend_riocentro2?></td>
        <td><?php echo $Friend_eco2?></td>
        <td><?php echo $Friend_nb2?></td>
    </tr>
    <tr>
        <td>Best Friend</td>
        <td><?php echo $BestFriend_quicentro2?></td>
        <td><?php echo $BestFriend_jardin2?></td>
        <td><?php echo $BestFriend_cuenca2?></td>
        <td><?php echo $BestFriend_manta2?></td>
        <td><?php echo $BestFriend_sol2?></td> 
        <td><?php echo $BestFriend_sur2?></td>
        <td><?php echo $BestFriend_riocentro2?></td>
        <td><?php echo $BestFriend_eco2?></td>
        <td><?php echo $BestFriend_nb2?></td>
    </tr>
    <tr>
        <td>Partner</td>
        <td><?php echo $Partner_quicentro2?></td>
        <td><?php echo $Partner_jardin2?></td>
        <td><?php echo $Partner_cuenca2?></td>
        <td><?php echo $Partner_manta2?></td>
        <td><?php echo $Partner_sol2?></td>
        <td><?php echo $Partner_sur2?></td>
        <td><?php echo $Partner_riocentro2?></td>
        <td><?php echo $Partner_eco2?></td>
        <td><?php echo $Partner_nb2?></td>
    </tr>
    <tr>
        <td>Family</td>
        <td><?php echo $Family_quicentro2?></td>
        <td><?php echo $Family_jardin2?></td>
        <td><?php echo $Family_cuenca2?></td>
        <td><?php echo $Family_manta2?></td>
        <td><?php echo $Family_sol2?></td>
        <td><?php echo $Family_sur2?></td>
        <td><?php echo $Family_riocentro2?></td>
        <td><?php echo $Family_eco2?></td>
        <td><?php echo $Family_nb2?></td>
    </tr>
    </tbody>

    <tfoot>
        <th>Total</th>
        <th><?php echo $total_clientes_quicentro ?></th>
        <th><?php echo $total_clientes_jardin ?></th>
        <th><?php echo $total_clientes_cuenca ?></th>
        <th><?php echo $total_clientes_manta ?></th>
        <th><?php echo $total_clientes_sol ?></th>
        <th><?php echo $total_clientes_sur ?></th>
        <th><?php echo $total_clientes_riocentro ?></th>
        <th><?php echo $total_clientes_eco ?></th>
        <th><?php echo $total_clientes_nb ?></th>
    </tfoot>
    
</table>

<hr>

<table class="table compact striped table-border mt-4">
    <thead>
    <tr>
        <th colspan="9">CANTIDAD DE DINERO POR SEGMENTO <?php echo "Periodo: ".$desdenew2." ".$hasta3?></th>
    </tr>
    <tr>
        <th class="sortable-column sort-asc">SEGMENTO</th>
        <th class="sortable-column sort-asc">QUICENTRO</th>
        <th class="sortable-column sort-asc">JARDIN</th>
        <th class="sortable-column sort-asc">CUENCA</th>
        <th class="sortable-column sort-asc">MANTA</th>
        <th class="sortable-column sort-asc">POP UP</th>
        <th class="sortable-column sort-asc">QUICENTRO SUR</th>
        <th class="sortable-column sort-asc">RIOCENTRO</th>
        <th class="sortable-column sort-asc">ECOMMERCE</th>
        <th class="sortable-column sort-asc">NEW BALANCE</th>
    </tr>
    </thead>

    <tbody>
    <tr>
        <td>Friend</td>
        <td><?php echo number_format($Friend_quicentro3,2,',','')?></td>
        <td><?php echo number_format($Friend_jardin3,2,',','')?></td>
        <td><?php echo number_format($Friend_cuenca3,2,',','')?></td>
        <td><?php echo number_format($Friend_manta3,2,',','')?></td>
        <td><?php echo number_format($Friend_sol3,2,',','')?></td>
        <td><?php echo number_format($Friend_sur3,2,',','')?></td>
        <td><?php echo number_format($Friend_riocentro3,2,',','')?></td>
        <td><?php echo number_format($Friend_eco3,2,',','')?></td>
        <td><?php echo number_format($Friend_nb3,2,',','')?></td>
    </tr>
    <tr>
        <td>Best Friend</td>
        <td><?php echo number_format($BestFriend_quicentro3,2,',','')?></td>
        <td><?php echo number_format($BestFriend_jardin3,2,',','')?></td>
        <td><?php echo number_format($BestFriend_cuenca3,2,',','')?></td>
        <td><?php echo number_format($BestFriend_manta3,2,',','')?></td>
        <td><?php echo number_format($BestFriend_sol3,2,',','')?></td> 
        <td><?php echo number_format($BestFriend_sur3,2,',','')?></td>
        <td><?php echo number_format($BestFriend_riocentro3,2,',','')?></td>
        <td><?php echo number_format($BestFriend_eco3,2,',','')?></td>
        <td><?php echo number_format($BestFriend_nb3,2,',','')?></td>
    </tr>
    <tr>
        <td>Partner</td>
        <td><?php echo number_format($Partner_quicentro3,2,',','')?></td>
        <td><?php echo number_format($Partner_jardin3,2,',','')?></td>
        <td><?php echo number_format($Partner_cuenca3,2,',','')?></td>
        <td><?php echo number_format($Partner_manta3,2,',','')?></td>
        <td><?php echo number_format($Partner_sol3,2,',','')?></td>
        <td><?php echo number_format($Partner_sur3,2,',','')?></td>
        <td><?php echo number_format($Partner_riocentro3,2,',','')?></td>
        <td><?php echo number_format($Partner_eco3,2,',','')?></td>
        <td><?php echo number_format($Partner_nb3,2,',','')?></td>
    </tr>
    <tr>
        <td>Family</td>
        <td><?php echo number_format($Family_quicentro3,2,',','')?></td>
        <td><?php echo number_format($Family_jardin3,2,',','')?></td>
        <td><?php echo number_format($Family_cuenca3,2,',','')?></td>
        <td><?php echo number_format($Family_manta3,2,',','')?></td>
        <td><?php echo number_format($Family_sol3,2,',','')?></td>
        <td><?php echo number_format($Family_sur3,2,',','')?></td>
        <td><?php echo number_format($Family_riocentro3,2,',','')?></td>
        <td><?php echo number_format($Family_eco3,2,',','')?></td>
        <td><?php echo number_format($Family_nb3,2,',','')?></td>
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
        <th><?php echo number_format($total_venta_riocentro,2,',','') ?></th>
        <th><?php echo number_format($total_venta_eco,2,',','') ?></th>
        <th><?php echo number_format($total_venta_nb,2,',','') ?></th>
    </tfoot>
    
</table>