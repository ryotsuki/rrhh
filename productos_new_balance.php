<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    // --- Restinge la entrada a la pagina por via URL ->
	include ('restringir/restringir.ini.php');		//-->
	session_valida();								//-->
	// ------------------------------------------------->
    $conn = conectate(); 
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

        function buscar(){

            var gender = $("#cbo_gender").val();
            var line = $("#cbo_line").val();
            var ref = $("#cbo_ref").val();
            var pedido = "";
			
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

    <h2><strong>Datos de Cliente</strong></h2>
    <hr>

    <div class="row">
        
        <div class="cell-3"><div>
            <input type="input" data-role="material-input" data-label="Nombre de la Empresa" data-informer="Ingrese el nombre de la Empresa" placeholder="Ingrese Empresa" id="txt_empresa" value="<?php echo $empresa?>" onkeyup="mayusculas(this);">
        </div></div>
        <div class="cell-3"><div>
            <input type="input" data-role="material-input" data-label="Nombre del Comprador" data-informer="Ingrese el nombre del comprador" placeholder="Ingrese Comprador" id="txt_comprador" onkeyup="mayusculas(this);">
        </div></div>
        <div class="cell-3"><div>
            <input type="input" data-role="material-input" data-label="Correo Electronico" data-informer="Ingrese el correo de notificaciones" placeholder="Ingrese Correo"  id="txt_correo">
        </div></div>
        <div class="cell-3"><div>
            <button class="button primary" onclick="continuar();">Continuar</button>
        </div></div>
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