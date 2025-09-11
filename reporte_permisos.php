<?php
    //ini_set('display_errors', 'Off');
    include("conexion/conexion.php");
    
    session_start();
    $username = $_SESSION["user_first_name"].' '.$_SESSION['user_last_name'];
    $id_usuario = $_SESSION['id_usuario'];

    //echo "Username: ".$username;
    $conn = conectate();

    $consulta = "SELECT id_cargo FROM usuario WHERE id_usuario = $id_usuario";
    $res2 = $conn->query($consulta);
    while($row=mysqli_fetch_array($res2)) {
        $id_cargo = $row["id_cargo"];
    }

    if($id_cargo == 8 || $id_cargo == 5){
        $sql="SELECT * FROM v_permiso";
    }
    else{
        $sql="SELECT * FROM v_permiso WHERE id_usuario = $id_usuario";
    }

    
    $res = $conn->query($sql);
    //$res=sqlsrv_query($conn,$sql);	

    //echo $sql; 
    //$consulta_descripcion 
?>

<script>

    function actualizar(id_permiso){
        //alert(id_permiso);
        //return;
        let numero_permiso = id_permiso;

        Metro.dialog.create({
            title: "Modificacion de estado de solicitud",
            content: "<div>Desea revisar, aprobar o denegar la solicitud?</div>",
            actions: [
                {
                    caption: "Revisar",
                    cls: "js-dialog-close warning",
                    onclick: function(){
                        //alert(id_permiso);
                        revisar(numero_permiso);
                    }
                },
                {
                    caption: "Aprobar",
                    cls: "js-dialog-close primary",
                    onclick: function(){
                        //alert(id_permiso);
                        aprobar(numero_permiso);
                    }
                },
                {
                    caption: "Denegar",
                    cls: "js-dialog-close alert",
                    onclick: function(){
                        //alert(id_permiso);
                        denegar(numero_permiso);
                    }
                }
            ]
        });

    }

    function revisar(id_permiso){
        //alert(id_permiso);
        //return;
        let id_usuario = $("#txt_id_usuario").val();

            //alert(id_usuario+"-"+id_permiso);
            //return;

			$.ajax({
			type: "POST",
			dataType:"html",
			url: "datos/guarda_estado_permiso",	
			data: "id_usuario="+id_usuario+
					"&id_permiso="+id_permiso+
                    "&id_estado=2",
			cache: false,			
			success: function(result) {	
				//alert(result);
				resultado=result.split("/");
				if(resultado[0] == 1){
					var notify = Metro.notify;
                    notify.create("El permiso fue actualizado a revision.", "Informacion", {
                        cls: "primary"
                    });
				}
				else{
                    var notify = Metro.notify;
                    notify.create("No se pudo guardar.", "Informacion", {
                        cls: "warning"
                    });
				}
		
				
			},			
			error: function(error) {				
				alert("	jquery - Algunos problemas han ocurrido. Por favor, inténtelo de nuevo más tarde: " + error);			
			}
		
			});
    }

    function aprobar(id_permiso){
            let id_usuario = $("#txt_id_usuario").val();

            //alert(id_usuario+"-"+id_permiso);
            //return;

			$.ajax({
			type: "POST",
			dataType:"html",
			url: "datos/guarda_estado_permiso",	
			data: "id_usuario="+id_usuario+
					"&id_permiso="+id_permiso+
                    "&id_estado=3",
			cache: false,			
			success: function(result) {	
				//alert(result);
				resultado=result.split("/");
				if(resultado[0] == 1){
					var notify = Metro.notify;
                    notify.create("El permiso fue aprobado exitosamente.", "Informacion", {
                        cls: "primary"
                    });
				}
				else{
                    var notify = Metro.notify;
                    notify.create("No se pudo guardar.", "Informacion", {
                        cls: "warning"
                    });
				}
		
				
			},			
			error: function(error) {				
				alert("	jquery - Algunos problemas han ocurrido. Por favor, inténtelo de nuevo más tarde: " + error);			
			}
		
			});
    }

    function denegar(id_permiso){
        //alert("Negado");
        let id_usuario = $("#txt_id_usuario").val();

            //alert(id_usuario+"-"+id_permiso);
            //return;

			$.ajax({
			type: "POST",
			dataType:"html",
			url: "datos/guarda_estado_permiso",	
			data: "id_usuario="+id_usuario+
					"&id_permiso="+id_permiso+
                    "&id_estado=4",
			cache: false,			
			success: function(result) {	
				//alert(result);
				resultado=result.split("/");
				if(resultado[0] == 1){
					var notify = Metro.notify;
                    notify.create("El permiso fue negado exitosamente.", "Informacion", {
                        cls: "primary"
                    });
				}
				else{
                    var notify = Metro.notify;
                    notify.create("No se pudo guardar.", "Informacion", {
                        cls: "warning"
                    });
				}
		
				
			},			
			error: function(error) {				
				alert("	jquery - Algunos problemas han ocurrido. Por favor, inténtelo de nuevo más tarde: " + error);			
			}
		
			});
    }
</script>

<div class="row border-bottom bd-lightGray m-3">
    <div class="cell-md-4 d-flex flex-align-center">
        <?php //if($logo ==""){ ?>
        <h3 class="dashboard-section-title  text-center text-left-md w-100">Semper CP <small>Version 1.0</small></h3>
        <?php //}else{ ?>
        <!--<img src="<?php echo $logo;?>" width="300" height="80"/>-->
        <?php //} ?>
    </div>

    <div class="cell-md-8 d-flex flex-justify-center flex-justify-end-md flex-align-center">
        <ul class="breadcrumbs bg-transparent">
            <li class="page-item"><a href="#" class="page-link"><span class="mif-assignment"></span></a></li>
            <li class="page-item"><a href="#" class="page-link">Permisos</a></li>
            <input type="hidden" value="<?php echo $id_usuario?>" id="txt_id_usuario">
        </ul>
    </div>
</div>

<div class="m-3" id="">

<div id="tabla_datos">

</div>

    <table class="table striped table-border mt-4 compact"
       data-role="table"
       data-rows="5"
       data-rows-steps="5, 10"
       data-show-activity="false"
       data-rownum="true"
>

<thead>
    <th>ID</th>
    <th>Usuario</th>
    <th>Identificacion</th>
    <th>Cargo</th>
    <th>Ubicacion</th>
    <th>Fecha permiso</th>
    <th>Desde</th>
    <th>Hasta</th>
    <th>Tiempo total</th>
    <th>Tipo</th>
    <th>Observaciones</th>
    <th>Fecha elaborado</th>
    <th>Estado</th>
    <th>Aprobado por</th>
</thead>

<tbody>
    <?php 
        while($row=mysqli_fetch_array($res)) {
            $id_permiso = 0;
            $id_permiso = $row["id_permiso"];
            $color = "";
            $estado = $row["descripcion_estado_solicitud"];
            if($estado == "APROBADA"){
                $color = "fg-blue";
            }
            if($estado == "INGRESADA"){
                $color = "fg-warning";
            }
            if($estado == "DENEGADA"){
                $color = "fg-red";
            }
    ?>
    <tr>
        <td><a href="datos/permiso_pdf?id_permiso=<?php echo $row["id_permiso"]?>" target="_blank"><?php echo $row["id_permiso"];?></a></td>
        <td><?php echo $row["nombre_usuario"];?></td>
        <td><?php echo $row["cedula_usuario"];?></td>
        <td><?php echo $row["descripcion_cargo"];?></td>
        <td><?php echo $row["descripcion_ubicacion"];?></td>
        <td><?php echo $row["fecha_solicitud"];?></td>
        <td><?php echo $row["hora_inicio"];?></td>
        <td><?php echo $row["hora_fin"];?></td>
        <td><?php echo $row["total_tiempo"];?></td>
        <td><?php echo $row["tipo_permiso"];?></td>
        <td><?php echo $row["observaciones"];?></td>
        <td><?php echo $row["fecha_registro"];?></td>
        <td class="<?php echo $color;?>"><a href="#" onclick="actualizar(<?php echo $id_permiso?>)" ><?php echo $estado;?></a></td>
        <td><?php echo $row["usuario_aprobador"];?></td>
    </tr>
    <?php 
        }
    ?>
</tbody>

</table>

</div>

</div>

<script src="./js/charts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>