<?php
    include("conexion/conexion.php");
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
    $conn = conectate2();

    $consulta_marcas = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    $res_marca=sqlsrv_query($conn,$consulta_marcas);	

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<!DOCTYPE html>
<html lang="en" class=" scrollbar-type-1 sb-cyan">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <!-- Metro 4 -->
    <link rel="stylesheet" href="vendors/metro4/css/metro-all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <title>Novomode - Pedidos</title>

    <script> 
        window.on_page_functions = [];

        // function cargar_pagina(enlace){
        //     $.post(enlace+".php", function(htmlexterno){
        //         $('#content-wrapper').fadeOut('slow');
        //         $('#content-wrapper').fadeIn('slow');
        //         $("#content-wrapper").html(htmlexterno);
        //     });
        // }

        function new_balance(){ 
            //alert("Hola");
            $.post("productos_new_balance.php", function(htmlexterno){
                $('#mostrar_contenido').fadeOut('slow');
                $('#mostrar_contenido').fadeIn('slow');
                $("#mostrar_contenido").html(htmlexterno);
            });
        }

        function modificar_new_balance(){
            //alert("Hola");
            $.post("modificar_new_balance.php", function(htmlexterno){
                $('#mostrar_contenido').fadeOut('slow');
                $('#mostrar_contenido').fadeIn('slow');
                $("#mostrar_contenido").html(htmlexterno);
            });
        }

        function cards(){
            //alert("Hola");
            $.post("prueba_cards.php", function(htmlexterno){
                $('#mostrar_contenido').fadeOut('slow');
                $('#mostrar_contenido').fadeIn('slow');
                $("#mostrar_contenido").html(htmlexterno);
            });
        }
    </script>
</head>

<body class="m4-cloak h-vh-100">

<aside class="sidebar pos-absolute z-2"
       data-role="sidebar"
       data-toggle="#sidebar-toggle-3"
       id="sb3"
       data-shift=".shifted-content">
    <div class="sidebar-header" data-image="images/nbback.jpg">
        <div class="avatar">
            <img data-role="gravatar" data-email="a@b.com" data-default="mp">
        </div>
        <span class="title fg-white">Novomode</span>
        <span class="subtitle fg-white"> <?php echo date("Y")?> © Dpto. de Tecnología</span>
    </div>
    <ul class="sidebar-menu">
        <li><a onclick="new_balance();" href="#"><span class="mif-checkmark icon"></span>Nuevo Pedido NB</a></li>
        <li><a onclick="modificar_new_balance();" href="#"><span class="mif-floppy-disk icon"></span>Modificar Pedido NB</a></li>
        <li><a href="login_pedidos"><span class="mif-exit icon"></span>Cerrar Sesión</a></li>
        <!--<li><a onclick="cards();" href="#"><span class="mif-checkmark icon"></span>Prueba Cards</a></li>-->
        <!--<li><a><span class="mif-books icon"></span>Guide</a></li>
        <li><a><span class="mif-files-empty icon"></span>Examples</a></li>
        <li class="divider"></li>
        <li><a><span class="mif-images icon"></span>Icons</a></li>-->
    </ul>
</aside>
<div class="shifted-content h-100 p-ab">
    <div class="app-bar pos-absolute bg-red z-1" data-role="appbar">
        <button class="app-bar-item c-pointer" id="sidebar-toggle-3">
            <span class="mif-menu fg-white"></span>
        </button>
    </div>

    <div class="h-100 p-4" id="mostrar_contenido" name="mostrar_contenido">
        <p class="h1">Aplicativo para pedidos online</p>
        <p>
           Bienvenido(a) <strong><?php echo $nombre_usuario?></strong> de <strong><?php echo $empresa?></strong> al portal para pedidos online de Novomode - New Balance.
           Para desplegar el menú, click en la esquina superior izquierda en la hamburguesa.
        </p>
    </div>
</div>

<!-- jQuery first, then Metro UI JS -->
<script src="vendors/jquery/jquery-3.4.1.min.js"></script>
<script src="vendors/chartjs/Chart.bundle.min.js"></script>
<script src="vendors/qrcode/qrcode.min.js"></script>
<script src="vendors/jsbarcode/JsBarcode.all.min.js"></script>
<!--<script src="vendors/ckeditor/ckeditor.js"></script>-->
<script src="vendors/metro4/js/metro.min.js"></script>
<script src="js/index.js"></script>

</body>