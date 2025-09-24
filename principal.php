<?php
    // --- Restinge la entrada a la pagina por via URL ->
	include ('restringir/restringir.ini.php');		//-->
	session_valida();								//-->
	// ------------------------------------------------->
    //session_start();
    date_default_timezone_set('America/Guayaquil');
    $nombre_usuario = trim($_SESSION["user_first_name"].' '.$_SESSION['user_last_name']);
    $correo_usuario = $_SESSION['user_email_address'];
    $id_usuario = $_SESSION['id_usuario'];
    $cedula = $_SESSION['cedula_usuario'];

    $texto1 = "";
    $texto2 = "";

    if($_SESSION['cargo'] == 5 || $_SESSION['cargo'] == 8 || $_SESSION['cargo'] == 6){
        $texto1 = "Listado de permisos";
        $texto2 = "Listado de vacaciones";
        $texto3 = "Listado de certificados";
    }
    else{
        $texto1 = "Mis permisos";
        $texto2 = "Mis vacaciones";
        $texto2 = "Mis certificados";
    }
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

    <title>Semper - Formatos de Talento Humano</title>

    <script>
        window.on_page_functions = [];

        function cambiar_clave(){
            alert("Funcion en desarrollo. Coming soon.");
            var correo = '<?php echo $correo_usuario; ?>';

            Metro.dialog.create({
                title: "Desea cambiar su clave de usuario?",
                content: "<div>Ingrese los datos para cambio de clave. <br> <input type='password' data-prepend='Nueva clave:' id='txt_clave' data-role='input'> <br> <input type='password' data-prepend='Confirma clave:' id='txt_confirma' data-role='input'> </div>",
                actions: [
                    {
                        caption: "Aceptar",
                        cls: "js-dialog-close alert",
                        onclick: function(){
                            var clave = $("txt_clave").val();
                            var confirma = $("txt_confirma").val(); 

                            if(clave != confirma){
                                alert("Las claves no coinciden. Por favor verifique.");
                                return;
                            }
                        }
                    },
                    {
                        caption: "Cancelar",
                        cls: "js-dialog-close",
                        onclick: function(){
                            return;
                        }
                    }
                ]
            });
        }
    </script>
</head>
<body class="m4-cloak h-vh-100">
<div data-role="navview" data-toggle="#paneToggle" data-expand="xl" data-compact="lg" data-active-state="true">
    <div class="navview-pane">
        <div class="bg-green d-flex flex-align-center">
            <button class="pull-button m-0 bg-darkCyan-hover">
                <span class="mif-menu fg-white"></span>
            </button>
            <h2 class="text-light m-0 fg-white pl-7" style="line-height: 52px">Semper</h2>
        </div>

        <div class="suggest-box">
            <div class="data-box">
                <img src="<?php echo $foto_usuario;?>" class="avatar">
                <div class="ml-4 avatar-title flex-column">
                    <a href="#" class="d-block fg-white text-medium no-decor"><span class="reduce-1"><?php $nombre_usuario;?></span></a>
                    <p class="m-0"><span class="fg-green mr-2">&#x25cf;</span><span class="text-small">online</span></p>
                </div>
            </div>
            <img src="<?php echo $foto_usuario;?>" class="avatar holder ml-2">
        </div>

        <div class="suggest-box">
            <input type="text" data-role="input" data-clear-button="false" data-search-button="true">
            <button class="holder">
                <span class="mif-search fg-white"></span>
            </button>
        </div>

        <ul class="navview-menu mt-4" id="side-menu">
            <li class="item-header">MENU PRINCIPAL</li>
            <?php if($_SESSION['cargo'] == 5 || $_SESSION['cargo'] == 8 || $_SESSION['cargo'] == 6){ ?>
            <li>
                <a href="#dashboard">
                    <span class="icon"><span class="mif-meter"></span></span>
                    <span class="caption">Dashboard General</span>
                </a>
            </li>
            <?php } ?>
            <li>
                <a href="#" class="dropdown-toggle" id="dd_permisos">
                    <span class="icon"><span class="mif-assignment"></span></span>
                    <span class="caption">Permisos</span>
                </a>
                <ul class="navview-menu" data-role="dropdown">
                    <li>
                        <a href="#permisos">
                            <span class="icon"><span class="mif-plus"></span></span>
                            <span class="caption">Solicitar</span>
                        </a>
                    </li>
                    <li>
                        <a href="#reporte_permisos?<?php echo $id_usuario?>">
                            <span class="icon"><span class="mif-list"></span></span>
                            <span class="caption"><?php echo $texto1;?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" id="dd_vacaciones">
                    <span class="icon"><span class="mif-airplane"></span></span>
                    <span class="caption">Vacaciones</span>
                </a>
                <ul class="navview-menu" data-role="dropdown">
                    <li>
                        <a href="#vacaciones">
                            <span class="icon"><span class="mif-plus"></span></span>
                            <span class="caption">Solicitar</span>
                        </a>
                    </li>
                    <li>
                        <a href="#reporte_vacaciones?<?php echo $id_usuario?>">
                            <span class="icon"><span class="mif-list"></span></span>
                            <span class="caption"><?php echo $texto2;?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#rolesdepago">
                    <span class="icon"><span class="mif-dollar2"></span></span>
                    <span class="caption">Roles de pago</span>
                </a>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" id="dd_vacaciones">
                    <span class="icon"><span class="mif-libreoffice"></span></span>
                    <span class="caption">Certificados laborales</span>
                </a>
                <ul class="navview-menu" data-role="dropdown">
                    <li>
                        <a href="#certificado">
                            <span class="icon"><span class="mif-plus"></span></span>
                            <span class="caption">Solicitar</span>
                        </a>
                    </li>
                    <li>
                        <a href="#reporte_certificados?<?php echo $id_usuario?>">
                            <span class="icon"><span class="mif-list"></span></span>
                            <span class="caption"><?php echo $texto3;?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php if($_SESSION['cargo'] == 5 || $_SESSION['cargo'] == 8 || $_SESSION['cargo'] == 6){ ?>
            <li>
                <a href="#configuraciones">
                    <span class="icon"><span class="mif-tools"></span></span>
                    <span class="caption">Configuraciones</span>
                </a>
            </li>
            <?php } ?>
        </ul>

        <div class="w-100 text-center text-small data-box p-2 border-top bd-grayMouse" style="position: absolute; bottom: 0">
            <div>&copy; 2025-<?php echo date("Y")?> <a href="mailto:angel_aguiar@yahoo.es" class="text-muted fg-white-hover no-decor">Angel Aguiar</a></div>
            <div>Creado para <a href="https://www.crocs.ec" class="text-muted fg-white-hover no-decor">Semper</a></div>
        </div>
    </div>

    <div class="navview-content h-100">
        <div data-role="appbar" class="pos-absolute bg-darkGreen fg-white">

            <a href="#" class="app-bar-item d-block d-none-lg" id="paneToggle"><span class="mif-menu"></span></a>

            <div class="app-bar-container ml-auto">
                <!--<a href="#" class="app-bar-item">
                    <span class="mif-envelop"></span>
                    <span class="badge bg-green fg-white mt-2 mr-1">4</span>
                </a>
                <a href="#" class="app-bar-item">
                    <span class="mif-bell"></span>
                    <span class="badge bg-orange fg-white mt-2 mr-1">10</span>
                </a>
                <a href="#" class="app-bar-item">
                    <span class="mif-flag"></span>
                    <span class="badge bg-red fg-white mt-2 mr-1">9</span>
                </a>-->
                <div class="app-bar-container">
                    <a href="#" class="app-bar-item">
                        <img src="<?php echo $foto_usuario;?>" class="avatar">
                        <span class="ml-2 app-bar-name"><?php echo $nombre_usuario;?></span>
                    </a>
                    <div class="user-block shadow-1" data-role="collapse" data-collapsed="true">
                        <div class="bg-darkGreen fg-white p-2 text-center">
                            <img src="<?php echo $foto_usuario;?>" class="avatar">
                            <div class="h4 mb-0"><?php echo $nombre_usuario;?></div>
                            <div><?php echo $correo_usuario;?></div>
                        </div>
                        <div class="bg-white d-flex flex-justify-between flex-equal-items p-2">
                            <button class="button flat-button">Followers</button>
                            <button class="button flat-button">Sales</button>
                            <button class="button flat-button">Friends</button>
                        </div>
                        <div class="bg-white d-flex flex-justify-between flex-equal-items p-2 bg-light">
                            <a href="#" onclick="cambiar_clave()"><button class="button mr-1">Cambiar clave</button></a>
                            <a href="logout.php"><button class="button ml-1">Cerrar Sesión</button></a>
                        </div>
                    </div>
                </div>
                <a href="#configuraciones" class="app-bar-item">
                    <span class="mif-cogs"></span>
                </a>
            </div>
        </div>

        <div id="content-wrapper" class="content-inner h-100" style="overflow-y: auto"></div>
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
</html>