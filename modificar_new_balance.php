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
    $foto_usuario = $_SESSION["user_image"];
    $correo_usuario = $_SESSION['user_email_address'];
    $id_usuario = $_SESSION['id_usuario'];

    $consulta_gender = "SELECT DISTINCT gender FROM DATOS_ARTICULOS_NB ORDER BY gender";
    $res_gender=sqlsrv_query($conn,$consulta_gender);	

    $consulta_line = "SELECT DISTINCT line_plan FROM DATOS_ARTICULOS_NB ORDER BY line_plan";
    $res_line=sqlsrv_query($conn,$consulta_line);

    $consulta_ref = "SELECT DISTINCT ref FROM DATOS_ARTICULOS_NB ORDER BY ref";
    $res_ref=sqlsrv_query($conn,$consulta_ref);

    $consulta_pedido = "SELECT DISTINCT id_pedido,empresa,comprador,correo,valor_pedido FROM V_PEDIDO WHERE empresa = '$empresa'";
    $res_pedido=sqlsrv_query($conn,$consulta_pedido);
    echo $consulta_pedido;

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<html>
<head>

    <script>

        function mayusculas(e) {
            e.value = e.value.toUpperCase();
        }

        function continuar(){
            var empresa = $("#txt_empresa").val();
            var comprador = $("#txt_comprador").val();
            var correo = $("#txt_correo").val();

            if(empresa == "" || comprador == "" || correo == ""){
                Metro.infobox.create("<p><h2><b>Debe ingresar los datos solicitados.</b></h2></p>", "alert");
                return;
            }
            else{
                $("#div_filtros").show();
                $("#tit").show();
                $("#txt_empresa").prop("disabled", true);
                $("#txt_comprador").prop("disabled", true);
                $("#txt_correo").prop("disabled", true);
            }

        }

        function busca_pedido(pedido){

            var gender = $("#cbo_gender").val();
            var line = $("#cbo_line").val();
            var ref = $("#cbo_ref").val();

            //alert(pedido);
			
            $.post("datos/buscar_new_balance.php?gender="+gender+"&line="+line+"&ref="+ref+"&pedido="+pedido, function(htmlexterno){
                $('#tabla_datos').fadeOut('slow');
                $('#tabla_datos').fadeIn('slow');
                $("#tabla_datos").html(htmlexterno);
            });
 
        }
    </script>
</head>

<body>
<div class="container">

    <h2><strong>Datos de Pedido</strong></h2>
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
                <td><a href="#" onclick="busca_pedido(<?php echo $id?>)"><?php echo $row["id_pedido"]?></td>
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

    <h2 style="display:none;" id="tit"><strong>Selección de Productos</strong></h2>
        <hr>

    <div class="row" style="display:none;" id="div_filtros">
        
        <div class="cell-3"><div>
            <select data-prepend="Gender:" data-role="select" id="cbo_gender">
            <option value="TODOS">TODOS</option>
            <?php while($row=sqlsrv_fetch_array($res_gender)) { ?>
            <option value="<?php echo $row["gender"]?>"><?php echo $row["gender"]?></option>
            <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <select data-prepend="Line Plan:" data-role="select" id="cbo_line">
                <option value="TODOS">TODOS</option>
                <?php while($row=sqlsrv_fetch_array($res_line)) { ?>
                <option value="<?php echo $row["line_plan"]?>"><?php echo $row["line_plan"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <select data-prepend="Silueta:" data-role="select" id="cbo_ref">
                <option value="TODOS">TODOS</option>
                <?php while($row=sqlsrv_fetch_array($res_ref)) { ?>
                <option value="<?php echo $row["ref"]?>"><?php echo $row["ref"]?></option>
                <?php } ?>
            </select>
        </div></div>
        <div class="cell-3"><div>
            <button class="button primary cycle" onclick="buscar();"><span class="mif-search"></span></button>
        </div></div>
    </div>

    <div class="info-box" data-role="infobox" data-type="alert">
        <span class="button square closer"></span>
        <div class="info-box-content">
            <h3>What is Lorem Ipsum?</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
        </div>
    </div>

    <div class="container" id="tabla_datos"></div>
</div>
</body>