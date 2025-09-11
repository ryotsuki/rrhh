

<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    //echo "Username: ".$username;

    //CALCULO DE DIA, MES Y AÑO
    include("datos/dias_meses_anios.php");
    //-------------------


    $mes = "";
    $anio = "";
    
    $conn = conectate();
    $conn2 = conectate2();


    $consulta_tarjeta = "SELECT MAX(IDTARJETA) AS NUMERO FROM TARJETAS";
    $res_tarjeta=sqlsrv_query($conn2,$consulta_tarjeta);
    while($row=sqlsrv_fetch_array($res_tarjeta)) {
        $codigo = $row["NUMERO"]+1;
    }

    //echo $codigoalmacen;
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------

    $correo_usuario = $_SESSION['user_email_address'];

$an = date("Y");
$me = date("m");
$di = date("d");

$filtro_tienda = ""; 

if(strpos($username, "CH") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "SIE") !== false || strpos($username, "SUR") !== false) {
    $filtro_tienda = "AND ALMACEN = '$username'";
}
if(strpos($username, "NEW") !== false) {
    $filtro_tienda = "AND ALMACEN LIKE 'NEW%'";
}

$consulta = "SELECT 
            T.IDTARJETA,
            T.OBSERVACIONES AS ADICIONAL,
            TE.IMPORTE,
            T.SALDOTARJETA,
            CONVERT(VARCHAR,F.FECHACREACION,103) AS FECHA,
            F.NUMSERIE,
            F.NUMFACTURA,
            C.NOMBRECLIENTE,
            T.ALIAS
            FROM
            TARJETAS T LEFT JOIN TESORERIA TE ON SUBSTRING(TE.SUDOCUMENTO,1,8) = CAST(T.IDTARJETA AS VARCHAR) LEFT JOIN
            FACTURASVENTA F ON TE.SERIE = F.NUMSERIE AND TE.NUMERO = F.NUMFACTURA LEFT JOIN
            CLIENTES C ON F.CODCLIENTE = C.CODCLIENTE
            WHERE
            T.IDTIPOTARJETA = 2
            ORDER BY 
            T.IDTARJETA";

?>

<script>
    function guardar_tarjeta(){
        let txt_id = $("#txt_id").val();
        //alert(txt_id);
        //return;
        let txt_monto = $("#txt_monto").val();
        let txt_cedula = $("#txt_cedula").val();
        let txt_obs = $("#txt_obs").val();

        if(txt_monto == '' || txt_monto <= 0){
             Metro.infobox.create("<p><strong><h3>Debe colocar un monto valido.</h3></strong></p>", "alert");
             $("#txt_monto").val('');
             $("#txt_monto").focus();
             return;
         }

        if(txt_cedula == '' || txt_cedula <= 0){
            Metro.infobox.create("<p><strong><h3>Debe colocar una cedula valida.</h3></strong></p>", "alert");
            $("#txt_cedula").val('');
            $("#txt_cedula").focus();
            return;
        }

        if(txt_obs == '' || txt_obs <= 0){
            Metro.infobox.create("<p><strong><h3>Debe colocar una observacion (numero de pedido).</h3></strong></p>", "alert");
            $("#txt_obs").val('');
            $("#txt_obs").focus();
            return;
        }
        //alert("Todo bien.")
        //window.open("datos/guarda_nc.php?txt_id="+txt_id+"&txt_monto="+txt_monto+"&txt_cedula="+txt_cedula+"&txt_obs="+txt_obs, "_blank");
        $.post("datos/guarda_nc.php?txt_id="+txt_id+"&txt_monto="+txt_monto+"&txt_cedula="+txt_cedula+"&txt_obs="+txt_obs, function(htmlexterno){
            $('#datos_metas').fadeOut('slow');
            $('#datos_metas').fadeIn('slow');
            $("#datos_metas").html(htmlexterno);
        });
    }

    function excel(){ 

        window.open('datos/ex_nc.php', '_blank');
    }

</script>

<body>
<div class="container">

    <div class="row border-bottom bd-lightGray m-3">
        <div class="cell-md-4 d-flex flex-align-center">
            <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.5</small></h3>
        </div>

        <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
            <ul class="breadcrumbs bg-transparent">
                <li class="page-item"><a href="#" class="page-link"><span class="mif-replay"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Generar NC</a></li>
            </ul>
        </div>
    </div> 

    <?php //if($correo_usuario == "programacion@novomode.ec" || $correo_usuario == "operaciones@novomode.ec"){?>
                    <div class="row">
                        <div class="cell">
                            <input type="number" disabled="true" style="text-align:right;" data-prepend="ID:" id="txt_id" name="txt_id" size="7" value="<?php echo $codigo;?>" placeholder = "10000">
                        </div>
                        <div class="cell"> 
                        <input type="number" style="text-align:right;" data-prepend="Monto:" id="txt_monto" name="txt_monto" size="7" placeholder = "Monto">
                        </div>   
                        <div class="cell">
                        <input type="text" style="text-align:right;" data-prepend="Cedula:" id="txt_cedula" name="txt_cedula" size="7" placeholder = "Cedula">
                        </div>
                        <div class="cell">
                        <input type="text" style="text-align:right;" data-prepend="Obs:" id="txt_obs" name="txt_obs" size="7" placeholder = "Observacion">
                        </div>
                        <div class="cell">
                        <button class="button primary cycle shadowed" onclick="guardar_tarjeta();"><span class="mif-checkmark"></span></button>
                        </div>
                    </div>
                <?php //} ?>

    <hr>
    <br>

    <button class="image-button success shadowed" onclick="excel();">
        <span class="mif-file-excel icon"></span>
        <span class="caption"><b>Excel</b></span>
    </button>
    <br>

    <div class="container" id="datos_metas">

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
            <th class="sortable-column sort-asc">TARJETA</th>
            <th class="sortable-column sort-asc">ADICIONAL</th>
            <th class="sortable-column sort-asc">OBS.</th>
            <th class="sortable-column sort-asc">IMPORTE</th>
            <th class="sortable-column sort-asc">SALDO</th>
            <th class="sortable-column sort-asc">FECHA</th>
            <th class="sortable-column sort-asc">FACTURA</th>
            <th class="sortable-column sort-asc">ALMACEN</th>
            <th class="sortable-column sort-asc">CLIENTE</th>
        </tr>
        </thead>

        <tbody>

        <?php
        $almacen = "";

        $res_consulta=sqlsrv_query($conn2,$consulta);
        while($row=sqlsrv_fetch_array($res_consulta)) { 
            $fac = $row["NUMSERIE"];
            $almacen = "";
            if($fac == 'C11F'){
                $almacen = 'CH QUICENTRO';
            }
            if($fac == 'C21F'){
                $almacen = 'CH JARDIN';
            }
            if($fac == 'C31F'){
                $almacen = 'CH MALL DEL RIO';
            }
            if($fac == 'C41F'){
                $almacen = 'CH SAN MARINO';
            }
            if($fac == 'C51F'){
                $almacen = 'CH MALL DEL SOL';
            }
            if($fac == 'C61F'){
                $almacen = 'CH MALL DEL PACIFICO';
            }
            if($fac == 'C71F'){
                $almacen = 'CH CEIBOS';
            }
            if($fac == 'B11F'){
                $almacen = 'SIETE QUICENTRO';
            }
            if($fac == 'B21F'){
                $almacen = 'SIETE JARDIN';
            }
            if($fac == 'B31F'){
                $almacen = 'QUICENTRO SUR';
            }
            if($fac == 'B41F'){
                $almacen = 'SIETE MALL DEL PACIFICO';
            }
            if($fac == 'B51F'){
                $almacen = 'SIETE MALL DEL RIO';
            }
            if($fac == 'B71F'){
                $almacen = 'SIETE RIOCENTRO';
            }
            if($fac == 'B81F'){
                $almacen = 'SIETE MALL DEL SOL';
            }
            if($fac == 'BA1F'){
                $almacen = 'OUTLET CHILLOS';
            }
            if($fac == 'BB1F'){
                $almacen = 'OUTLET MALL DEL NORTE';
            }
            if($fac == 'N11F'){
                $almacen = 'NB SCALA';
            }
            if($fac == 'N21F'){
                $almacen = 'NB QUICENTRO';
            }
            if($fac == 'N31F'){
                $almacen = 'NB MALL DEL RIO';
            }
            if($fac == 'E11F'){
                $almacen = 'ECOMMERCE';
            }

        ?>
            <tr>
            <td><?php echo $row["IDTARJETA"]?></td>
            <td><?php echo $row["ADICIONAL"]?></td>
            <td><?php echo $row["ALIAS"]?></td>
            <td><?php echo $row["IMPORTE"]?></td>
            <td><?php echo number_format($row["SALDOTARJETA"],2,',','.')?></td>
            <td><?php echo $row["FECHA"]?></td>
            <td><?php echo $row["NUMSERIE"]."-".$row["NUMFACTURA"]?></td>
            <td><?php echo $almacen;?></td>
            <td><?php echo $row["NOMBRECLIENTE"]?></td>
        </tr>
        <?php
            }
        ?>
    </tbody>
    </table>
    </div>
</body>