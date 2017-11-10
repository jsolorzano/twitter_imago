$(document).ready(function(){
	
	$('.footable').footable();  // Aplicamos el plugin footable
	
	// Capturamos la base_url
    var base_url = $("#base_url").val();
	
	
	// Función para ver el perfil de twitter
	$("#boton_vincular").on('click', function (e) {
		
		swal({
            title: "Crear y vincular perfil",
            text: "¿Está seguro de crear un nuevo perfil y vincularlo a esta cuenta?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Crear",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm){
            if (isConfirm) {
             
                $("#modal_cedula").modal('show');
                
            }
        });
		
	});
	
	// Función para ver el perfil de twitter
	$("#vincular").on('click', function (e) {
		
		if($("#cedula").val().trim() == ''){
			
			swal("Disculpe,", "debe indicar la cédula del usuario");
			$("#cedula").focus();
			
		}else{
			
			window.location.href = base_url+'social_profile/register?id_twitter='+$("#id_twitter").val()+'&cedula='+$("#cedula").val().trim()+'&ruta='+$("#ruta_origen").val();
		
		}
		
	});
	
});
