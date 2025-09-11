<?php
    include("conexion/conexion.php");
    //include("../validacion/validacion.php");
    $conn = conectate();
    //CALCULO DE DIA, MES Y AÑO
	include("datos/dias_meses_anios.php");
    session_start();
    $correo_usuario = $_SESSION['user_email_address'];
	//-------------------

    $consulta_votacion = "SELECT siete FROM USUARIO WHERE correo_usuario = '$correo_usuario'";
    $res_votacion=sqlsrv_query($conn,$consulta_votacion);	
    while($row=sqlsrv_fetch_array($res_votacion)) {
        $ya_voto = $row["siete"];
    }

    if($ya_voto == 1){
        $consulta = "SELECT * FROM MURALES_SIETE";
        $res=sqlsrv_query($conn,$consulta);
    }

    //echo $consulta_metas;

    // $consulta_familias = "SELECT * FROM MARCA ORDER BY DESCRIPCION";
    // $res_marca=sqlsrv_query($conn,$consulta_marcas);
?>

<html>
<head>

    <script>
        $('#votacion').click(function() {

        if ($('input[name="votar"]').is(':checked')) {
            var voto = $('input[name=votar]:checked', '#frm_votar').val();
             
            //alert($('input[name=votar]:checked', '#frm_votar').val());
            $.post("datos/voto2.php?voto="+voto, function(htmlexterno){
                alert("Usted voto por "+voto+", gracias!")
                location.reload();
            });

        } else {
            alert('Debe seleccionar uno.');
        }
        });
    </script>
</head>

<body>
<div class="container">

    <div class="row border-bottom bd-lightGray m-3">
        <div class="cell-md-4 d-flex flex-align-center">
            <h3 class="dashboard-section-title  text-center text-left-md w-100">Novomode CP <small>Version 1.5</small></h3>
        </div>

        <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
            <ul class="breadcrumbs bg-transparent">
                <li class="page-item"><a href="#" class="page-link"><span class="mif-checkmark"></span></a></li>
                <li class="page-item"><a href="#" class="page-link"></a>VOTACIÓN MURAL SIETE</li>
            </ul>
        </div>
    </div>

    <?php if($ya_voto == 0){ ?>

    <div class="row">

    <div class="cell-3"><button class="button primary" id="votacion"><span class="mif-checkmark"></span> VOTAR</button></div>
   
    </div>

    <?php 
        }else{ 
    ?>

        <div class="row">

        <div class="cell-6">
            <h2>USTED YA HA VOTADO. GRACIAS.</h2>
            <h4>Resultados preliminares:</h4>
            <table class="table compact table-border striped">
                <?php
                    while($row=sqlsrv_fetch_array($res)) {
                ?>
                <tr>
                    <th>
                        Quicentro: <?php echo $row["quicentro"];?>
                    </th>
                    <th>
                        Jardin: <?php echo $row["jardin"];?>
                    </th>
                    <th>
                        Cuenca: <?php echo $row["cuenca"];?>
                    </th>
                    <th>
                        Manta: <?php echo $row["manta"];?>
                    </th>
                    <th>
                        Sur: <?php echo $row["sur"];?>
                    </th>
                    <th>
                        Scala: <?php echo $row["scala"];?>
                    </th>
                    <th>
                        Mall del Sol: <?php echo $row["sol"];?>
                    </th>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>

        </div>

    <?php } ?>

    <form name="frm_votar" id="frm_votar">
    <div class="row">
        <div class="cell-6">
            <input type="radio" data-role="radio" name="votar" id="votar" value="quicentro">
            <div class="img-container rounded">
                <img src="images/MURALES/MURAL SIE7E QUICENTRO.jpeg">
                <div class="image-overlay">
                    <div class="h2">SIETE QUICENTRO</div>
                </div>
            </div>
        </div>
        <div class="cell-6">
            <input type="radio" data-role="radio" name="votar" id="votar" value="jardin">
            <div class="img-container rounded">
                <img src="images/MURALES/SIE7E JARDIN.png">
                <div class="image-overlay">
                    <div class="h2">SIETE JARDIN</div>
                </div>
            </div>
        </div>
        <div class="cell-6">
            <input type="radio" data-role="radio" name="votar" id="votar" value="cuenca">
            <div class="img-container rounded">
                <img src="images/MURALES/MJURAL SIE7E CUENCA.png">
                <div class="image-overlay">
                    <div class="h2">SIETE CUENCA</div>
                </div>
            </div>
        </div>
        <div class="cell-6">
            <input type="radio" data-role="radio" name="votar" id="votar" value="manta">
            <div class="img-container rounded">
                <img src="images/MURALES/SIE7E MANTA.png">
                <div class="image-overlay">
                    <div class="h2">SIETE MANTA</div>
                </div>
            </div>
        </div>
        <div class="cell-6">
            <input type="radio" data-role="radio" name="votar" id="votar" value="sur">
            <div class="img-container rounded">
                <img src="images/MURALES/MURAL SIE7E QUICENTRO SUR.jpeg">
                <div class="image-overlay">
                    <div class="h2">SIETE QUICENTRO SUR</div>
                </div>
            </div>
        </div>
        <div class="cell-6">
            <input type="radio" data-role="radio" name="votar" id="votar" value="scala">
            <div class="img-container rounded">
                <img src="images/MURALES/MURAL NB SCALA.jpeg">
                <div class="image-overlay">
                    <div class="h2">NEW BALANCE SCALA</div>
                </div>
            </div>
        </div>
        <div class="cell-6">
            <input type="radio" data-role="radio" name="votar" id="votar" value="sol">
            <div class="img-container rounded">
                <img src="images/MURALES/MURAL SIE7E MALL DEL SOL.jpeg">
                <div class="image-overlay">
                    <div class="h2">SIETE MALL DEL SOL</div>
                </div>
            </div>
        </div>

    </div>
    </form>

    <div class="container" id="tabla_datos"></div>
</div>
</body>