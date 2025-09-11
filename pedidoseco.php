<?php
    include("conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    $conn = conectate2();

    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
	//-------------------

    $otromes = $mes_actual - 3;

    $consulta = "SELECT DISTINCT
                NUMPEDIDO,
                NUMSERIE,
                SUPEDIDO,
                NOMBRECLIENTE,
                SERIEALBARAN,
                NUMEROALBARAN,
                CONVERT(VARCHAR,FECHAPEDIDO,103) AS FECHAPEDIDO,
                TOTBRUTO,
                TOTIMPUESTOS,
                TOTNETO  
                FROM 
                V_PEDIDOS_ECO
                WHERE
                FECHAPEDIDO BETWEEN '".$anio_actual."-0".$otromes."-".$dia_actual."T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59'
                ORDER BY 
                NUMPEDIDO";
    $res=sqlsrv_query($conn,$consulta);	
    //echo $consulta;

    $consulta2 = "SELECT DISTINCT
                NUMPEDIDO,
                NUMSERIE,
                SUPEDIDO,
                NOMBRECLIENTE,
                SERIEALBARAN,
                NUMEROALBARAN,
                CONVERT(VARCHAR,FECHAPEDIDO,103) AS FECHAPEDIDO,
                TOTBRUTO,
                TOTIMPUESTOS,
                TOTNETO  
                FROM 
                V_PEDIDOS_ECO
                WHERE
                FECHAPEDIDO BETWEEN '".$anio_actual."-".$mes_actual."-01T00:00:00' AND '".$anio_actual."-".$mes_actual."-".$dia_actual."T23:59:59'
                ORDER BY 
                NUMPEDIDO";
    $res2=sqlsrv_query($conn,$consulta2);
    
    $facturados = 0;
    $pendientes = 0;
    $tbrutof = 0;
    $tbrutop = 0;

    while($row=sqlsrv_fetch_array($res2)) { 
        $albaran = $row["NUMEROALBARAN"];
        $bruto = $row["TOTBRUTO"];
        if($albaran != "" && $albaran != -1){
            $facturados++;
            $tbrutof+=$bruto;
        }
        else{
            $pendientes++;
            $tbrutop+=$bruto;
        }
    }

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);}
?>

<html>
<head>
</head>

<body>
<div class="container">

    <div class="row border-bottom bd-lightGray m-3">
        <div class="cell-md-4 d-flex flex-align-center">
            <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.5</small></h3>
        </div>

        <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
            <ul class="breadcrumbs bg-transparent">
                <li class="page-item"><a href="#" class="page-link"><span class="mif-replay"></span></a></li>
                <li class="page-item"><a href="#" class="page-link">Consulta de pedidos Ecommerce</a></li>
            </ul>
        </div>
    </div>

    <div class="remark primary">
        Facturados del mes: <strong><?php echo $facturados;?> - $<?php echo number_format($tbrutof,2,',','.'); ?></strong>
    </div>
    <div class="remark alert">
        Pendientes del mes: <strong><?php echo $pendientes;?> - $<?php echo number_format($tbrutop,2,',','.'); ?></strong>
    </div>

    <div class="container" id="tabla_datos">
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
                <th class="sortable-column sort-asc">PEDIDO</th>
                <th class="sortable-column sort-asc">VTEX</th>
                <th class="sortable-column sort-asc">CLIENTE</th>
                <th class="sortable-column sort-asc">FECHA</th>
                <th class="sortable-column sort-asc">T. BRUTO</th>
                <th class="sortable-column sort-asc">T. IMP.</th>
                <th class="sortable-column sort-asc">T. NETO</th>
                <th class="sortable-column sort-asc">ESTADO</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res)) { 
                    $albaran = $row["NUMEROALBARAN"];
                    $clave = "";
                    
                    $estado = "";
                    if($albaran != "" && $albaran != -1){
                        $consulta_factura = "SELECT NUMFAC, NUMSERIEFAC FROM ALBVENTACAB WHERE NUMSERIE = 'E11R' AND NUMALBARAN = $albaran";
                        $res_factura=sqlsrv_query($conn,$consulta_factura);	
                        while($row2=sqlsrv_fetch_array($res_factura)){
                            $factura = $row2["NUMSERIEFAC"]."-".$row2["NUMFAC"];
                            $seriefac = $row2["NUMSERIEFAC"];
                            $numfac = $row2["NUMFAC"];
                        }
                        $consulta_pdf = "SELECT CLAVEACCESO FROM FACTURASVENTAFIRMA WHERE SERIE = '$seriefac' AND NUMERO = '$numfac'";
                        $res_pdf=sqlsrv_query($conn,$consulta_pdf);	
                        while($row3=sqlsrv_fetch_array($res_pdf)){
                            $clave = $row3["CLAVEACCESO"];
                        }

                        $estado = "<a href='https://1792636299001.apps-join.com/downloads/cabeceraDocumentoElectronica/pdf/$clave'><div class='clear' data-role='hint' data-hint-text='$factura' data-cls-hint='bg-green fg-white drop-shadow' data-hint-hide='50000'>FACTURADO</div><a>";
                    }
                    else{
                        $supedido = $row['SUPEDIDO'];
                        $consulta_detalles = "SELECT REFERENCIA, TALLA, COLOR, UNIDADESTOTAL FROM V_PEDIDOS_ECO WHERE SUPEDIDO = '$supedido'";
                        $res_detalles=sqlsrv_query($conn,$consulta_detalles);	
                        $detalle = "";
                        while($row2=sqlsrv_fetch_array($res_detalles)){
                            $ref = $row2["REFERENCIA"];
                            $tal = $row2["TALLA"];
                            $col = $row2["COLOR"];
                            $stock_maximo = "";
                            $almacen_maximo = "";

                            $consulta_stock = "SELECT MAX(STOCK) AS STOCK, ALMACEN FROM V_STOCK_CON_DETALLE WHERE REFERENCIA = '$ref' AND TALLA = '$tal' AND COLOR = '$col' AND STOCK > 0 GROUP BY ALMACEN";
                            //echo $consulta_stock;
                            $res_stock=sqlsrv_query($conn,$consulta_stock);
                            while($row3=sqlsrv_fetch_array($res_stock)){
                                $stock_maximo = $row3["STOCK"];
                                $almacen_maximo = $row3["ALMACEN"];
                            }
                            

                            $detalle.= $row2["REFERENCIA"]."/".$row2["TALLA"]."/".$row2["COLOR"]."/".$row2["UNIDADESTOTAL"]."// <strong>".$stock_maximo." UND(S) -".$almacen_maximo."</strong><br>";
                        }

                        $estado = "<div class='clear' data-role='hint' data-hint-text='$detalle' data-cls-hint='bg-red fg-white drop-shadow' data-hint-hide='100000'>PENDIENTE</div>";

                    }
            ?>


            <tr>
                <td><?php echo $row["NUMSERIE"]."-".$row["NUMPEDIDO"];?></td>
                <td><?php echo $row["SUPEDIDO"];?></td>
                <td><?php echo utf8_encode($row["NOMBRECLIENTE"]);?></td>
                <td><?php echo $row["FECHAPEDIDO"];?></td>
                <td><?php echo number_format($row["TOTBRUTO"],2,',','.');?></td>
                <td><?php echo number_format($row["TOTIMPUESTOS"],2,',','.');?></td>
                <td><?php echo number_format($row["TOTNETO"],2,',','.');?></td>
                <td><?php echo $estado;?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>
    </div>
</div>
</body>