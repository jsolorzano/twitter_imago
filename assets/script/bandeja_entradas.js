$(document).ready(function(){
	// Capturamos la base_url
    var base_url = $("#base_url").val();
	
	var tabEntradas = $('#tab_entradas').DataTable({
        //~ "paging": true,
        //~ "lengthChange": false,
        "autoWidth": false,
        //~ "searching": true,
        //~ "ordering": true,
        //~ "info": true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
			"method":"POST",
			"url": base_url+"entrada_json"
		},
		"columnDefs": [
			{
				//~ "target": [0, 3, 4],
				"orderable":false,
			}
		],
        //~ "iDisplayLength": 50,
        //~ "iDisplayStart": 0,
        //~ "sPaginationType": "full_numbers",
        //~ "aLengthMenu": [50, 100, 150],
        "oLanguage": {"sUrl": base_url+"assets/js/es.txt"},
        "aoColumns": [
            {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sClass": "registro center", "sWidth": "20%"},
            {"sClass": "registro center", "sWidth": "20%"},
            {"sClass": "registro center", "sWidth": "10%"},
            {"sWidth": "9%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "3%", "sClass": "registro center"}
        ]
    });
    
	// Función para cambiar un twitter a otra bandeja según la opción seleccionada en su respectivo combo
	$("table#tab_entradas").on('change', 'select.cambiar', function (e) {
		
		e.preventDefault();
		
		var id = this.getAttribute('id');
		id = id.split(";");
		id = id[0];  // Id de la cola
		var estatus_actual = this.getAttribute('id');
		estatus_actual = estatus_actual.split(";");
		estatus_actual = estatus_actual[1];  // Estatus actual de la cola
		var select_actual = $(this);  // Combo actualmente seleccionado
		var nueva_bandeja = $(this).val();  // Bandeja nueva para el tweet
		
		//~ alert("Id: "+id+" | Nueva bandeja: "+nueva_bandeja);
		
		swal({
            title: "Cambiar de bandeja",
            text: "¿Está seguro de asignar el twit a otra bandeja?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Asignar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: true,
            closeOnCancel: true
        },
        function(isConfirm){
            if (isConfirm) {
             
                $("#modal_detalles").modal('show');
                $("#id_tweet").val(id);
                $("#nueva_bandeja").val(nueva_bandeja);
                
            }else{
				
				// Si cancelamos el cambio de estatus, fijamos el select al estatus inicial
				select_actual.val('0');
			
			} 
        });
		
	});
	
	// Función para cambiar un twitter a otra bandeja según la opción seleccionada en su respectivo combo
	$("#asignar").on('click', function (e) {
		
		if($("#detalles").val().trim() == ''){
			
			swal("Disculpe,", "debe indicar los detalles de la asignación");
			$("#detalles").focus();
			
		}else{
			
			$.post(base_url+'entrada/cambiar_bandeja', {'id':$("#id_tweet").val(), 'nueva_bandeja':$("#nueva_bandeja").val(), 'mensaje':$("#detalles").val()}, function (response) {

				if (response['response'] == "error") {
				   
					swal({
						title: "Disculpe,",
						text: "Ha ocurrido un error durante la asignación, por favor contacte con su administrador.",
						type: "warning" 
					},
					function(){
						// Si hay algún error, fijamos el select al estatus inicial
						select_actual.val('0');
					});
					
				}else{
					 swal({ 
					   title: "Asignación a nueva bandeja",
						text: "Asignación realizada con éxito",
						 type: "success" 
					   },
					   function(){
						 window.location.href = base_url+'bandeja_entrada';
					 });
				}
			}, 'json');
		
		}
	
		
		
	});
	
});
