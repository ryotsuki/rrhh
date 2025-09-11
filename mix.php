<?php
    include("conexion/conexion.php");
    ini_set('max_execution_time', '0');
    //include("../validacion/validacion.php");
    $conn = conectate2();

    $consulta = "SELECT * FROM V_MIX_AND_MATCH";
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
                <li class="page-item"><a href="#" class="page-link">Consulta de Mix</a></li>
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
                <th class="sortable-column sort-asc">ID</th>
                <th class="sortable-column sort-asc">PROMO</th>
                <th class="sortable-column sort-asc">INICIO</th>
                <th class="sortable-column sort-asc">FINAL</th>
                <th class="sortable-column sort-asc">CUPON</th>
                <th class="sortable-column sort-asc">GRUPO ART.</th>
                <th class="sortable-column sort-asc">CONDICION</th>
                <th class="sortable-column sort-asc">OPERADOR</th>
                <th class="sortable-column sort-asc">VALOR</th>
            </tr>
            </thead>

            <tbody>
            <?php 
                while($row=sqlsrv_fetch_array($res)) { 
            ?>
            <tr>
                <td><?php echo $row["IDPROMOCION"];?></td>
                <td><?php echo utf8_encode($row["PROMO"]);?></td>
                <td><?php echo $row["FECHAINICIAL"];?></td>
                <td><?php echo $row["FECHAFINAL"];?></td>
                <td><?php echo $row["EANCUPON"];?></td>
                <td><?php echo utf8_encode($row["GRUPO_ARTICULOS"]);?></td>
                <td><?php echo $row["CONDICION1"];?></td>
                <td><?php echo $row["OPERADOR"];?></td>
                <td><?php echo $row["CONDICION2"];?></td>
            </tr>
            <?php
                }
            ?>
            </tbody>
            
        </table>
    </div>
</div>
</body>