$(document).ready(function(){
	// Capturamos la base_url
    var base_url = $("#base_url").val();
	
	
	// Función para ver el perfil de twitter
	$("#vincular").on('click', function (e) {
		
		if($("#cedula").val().trim() == ''){
			
			swal("Disculpe,", "debe indicar la cédula del usuario");
			$("#cedula").focus();
			
		}else{
			
			window.location.href = base_url+'twitters/view?id='+$("#id").val()+'&screen_name='+$("#screen_name").val();
		
		}
		
	});
	
});
