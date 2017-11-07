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
    
	
});

// Función para referenciar del precio en bolívares al cambiar el precio en dólares de algún producto
function referenciar(id_input_dl){
	var precio_dolar = $("#precio_dolar").val();  // Capturamos el precio del dólar previamente cargado en el campo oculto 'precio_dolar'
	//~ var precio_dolar = 22938.23;  // Prueba con valor estático
	
	var input_dolar = $("#"+id_input_dl).val();  // Capturamos el precio en dólares del producto modificado
	// Preparamos el input del precio en bolívares
	var id_input_bolivar = id_input_dl.replace("_dl","");
	var input_bolivar = $("#"+id_input_bolivar);
	
	// Calculamos el nuevo precio y lo asinamos al input de monto en bolívares correspondiente al producto
	var valor_referencial = parseFloat(input_dolar) * precio_dolar;
	input_bolivar.val(valor_referencial.toFixed(2));
}
