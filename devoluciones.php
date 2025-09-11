<?php
    include("conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    $conn = conectate2();

    $consulta = "SELECT * FROM V_DEVOLUCIONES";
    $res=sqlsrv_query($conn,$consulta);	

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
                <li class="page-item"><a href="#" class="page-link">Consulta de Devoluciones</a></li>
            </ul>
        </div>
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
                <th class="sortable-column sort-asc">ALMACEN</th>
                <th class="sortable-column sort-asc">MOTIVO</th>
                <th class="sortable-column sort-asc">COMENTARIO</th>
                <th class="sortable-column sort-asc">REFERENCIA</th>
                <th class="sortable-column sort-asc">TALLA</th>
                <th class="sortable-column sort-asc">COLOR</th>
                <th class="sortable-column sort-asc">UNIDADES</th>
                <th class="sortable-column sort-asc">FECHA ENVIO</th>
                <th class="sortable-column sort-asc">FECHA RECEPCION</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res)) { 
            ?>
            <tr>
                <td><?php echo $row["CSUPEDIDO"];?></td>
                <td><?php echo $row["NOMBREALMACEN"];?></td>
                <td><?php echo $row["MOTIVO_DEVOLUCION"];?></td>
                <td><?php echo $row["COMENTARIO"];?></td>
                <td><?php echo $row["REFPROVEEDOR"];?></td>
                <td><?php echo $row["TALLA"];?></td>
                <td><?php echo $row["COLOR"];?></td>
                <td><?php echo $row["UNIDADES"];?></td>
                <td><?php echo $row["FECHA_ENVIO"];?></td>
                <td><?php echo $row["FECHA_RECEPCION"];?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>
    </div>
</div>
</body>