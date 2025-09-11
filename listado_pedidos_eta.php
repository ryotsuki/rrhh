<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    $conn = conectate(); 
    // --- Restinge la entrada a la pagina por via URL ->
    include ('restringir/restringir.ini.php');		//-->
    session_valida();								//-->
    // ------------------------------------------------->
    //session_start();
    $empresa = trim($_SESSION["user_first_name"]);
    $nombre_usuario = trim($_SESSION['user_last_name']);
    //$foto_usuario = $_SESSION["user_image"];
    $correo_usuario = $_SESSION['user_email_address'];
    $id_usuario = $_SESSION['id_usuario'];

    $consulta_gender = "SELECT DISTINCT gender FROM DATOS_ARTICULOS_NB_ETA ORDER BY gender";
    $res_gender=sqlsrv_query($conn,$consulta_gender);	

    $consulta_line = "SELECT DISTINCT line_plan FROM DATOS_ARTICULOS_NB_ETA ORDER BY line_plan";
    $res_line=sqlsrv_query($conn,$consulta_line);

    $consulta_ref = "SELECT DISTINCT ref FROM DATOS_ARTICULOS_NB_ETA ORDER BY ref";
    $res_ref=sqlsrv_query($conn,$consulta_ref);

    $consulta_pedido = "SELECT DISTINCT id_pedido,empresa,comprador,correo,valor_pedido FROM V_PEDIDO_ETA WHERE empresa = '$empresa' AND estado_pedido = 1";
    $res_pedido=sqlsrv_query($conn,$consulta_pedido);
    //echo $consulta_pedido;

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<html>
<head>

    <script>

        function mayusculas(e) {
            e.value = e.value.toUpperCase();
        }

        function imprimir_pedido(pedido){

            //alert(pedido);
			
            $.post("imprime_pedido_pdf_eta.php?pedido="+pedido, function(htmlexterno){
                $('#tabla_datos').fadeOut('slow');
                $('#tabla_datos').fadeIn('slow');
                $("#tabla_datos").html(htmlexterno);
            });
 
        }
    </script>
</head>

<body>
<div class="container">

    <h2><strong>Impresión Pedidos Finalizados</strong></h2>
    <hr>

    <div class="row">
        
        <table class="table compact table-border striped">
            <tr>
                <th>ID</th>
                <th>EMPRESA</th>
                <th>COMPRADOR</th>
                <th>CORREO</th>
                <th>VALOR</th>
            </tr>
            
            <?php 
                while($row=sqlsrv_fetch_array($res_pedido)) {  
                    $id = $row["id_pedido"];
            ?>
            <tr style="text-align:center;">
                <td><a href="imprime_pedido_pdf_eta.php?pedido=<?php echo $id?>" target="_blanc"><?php echo $row["id_pedido"]?></td>
                <td><?php echo $row["empresa"]?></td>
                <td><?php echo $row["comprador"]?></td>
                <td><?php echo $row["correo"]?></td>
                <td><?php echo $row["valor_pedido"]?></td>
            </tr>
            <?php } ?>
        </table>
        <!--<div class="cell-3"><div>
            <button class="button primary" onclick="continuar();">Continuar</button>
        </div></div>-->
    </div>

    <div id="tabla_datos"></div>
</div>
</body>