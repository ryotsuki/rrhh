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