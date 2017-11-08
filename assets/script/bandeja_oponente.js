$(document).ready(function(){
	// Capturamos la base_url
    var base_url = $("#base_url").val();
	
	var tabOponentes = $('#tab_oponentes').DataTable({
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
			"url": base_url+"oponentes_json"
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
            //~ {"sWidth": "9%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
            {"sWidth": "3%", "sClass": "registro center"}
        ]
    });
	
});
