function actualizar(id_certificado){
        //alert(id_permiso);
        //return;
        let numero_certificado = id_certificado;

        Metro.dialog.create({
            title: "Modificacion de estado de solicitud",
            content: "<div>Desea aprobar o denegar la solicitud?</div>",
            actions: [
                {
                    caption: "Aprobar",
                    cls: "js-dialog-close primary",
                    onclick: function(){
                        //alert(id_permiso);
                        aprobar(numero_certificado);
                    }
                },
                {
                    caption: "Denegar",
                    cls: "js-dialog-close alert",
                    onclick: function(){
                        //alert(id_permiso);
                        denegar(numero_certificado);
                    }
                }
            ]
        });

    }

    function aprobar(id_certificado){
            let id_usuario = $("#txt_id_usuario").val();

            //alert(id_usuario+"-"+id_permiso);
            //return;

			$.ajax({
			type: "POST",
			dataType:"html",
			url: "datos/guarda_estado_certificado",	
			data: "id_usuario="+id_usuario+
					"&id_certificado="+id_certificado+
                    "&id_estado=3",
			cache: false,			
			success: function(result) {	
				//alert(result);
				resultado=result.split("/");
				if(resultado[0] == 1){
					var notify = Metro.notify;
                    notify.create("El certificado fue aprobado exitosamente.", "Informacion", {
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

    function denegar(id_certificado){
        //alert("Negado");
        let id_usuario = $("#txt_id_usuario").val();

            //alert(id_usuario+"-"+id_permiso);
            //return;

			$.ajax({
			type: "POST",
			dataType:"html",
			url: "datos/guarda_estado_certificado",	
			data: "id_usuario="+id_usuario+
					"&id_certificado="+id_certificado+
                    "&id_estado=4",
			cache: false,			
			success: function(result) {	
				//alert(result);
				resultado=result.split("/");
				if(resultado[0] == 1){
					var notify = Metro.notify;
                    notify.create("El certificado fue negado exitosamente.", "Informacion", {
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