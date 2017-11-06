<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Menús</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            <li class="active">
                <strong>Menús</strong>
            </li>
        </ol>
       
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <a href="<?php echo base_url() ?>menus/register">
            <button class="btn btn-outline btn-primary dim" type="button"><i class="fa fa-plus"></i> Agregar</button></a>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Listado de Menús</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table id="tab_menus" class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Ruta</th>
                        <th>Acción</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($listar as $menu) { ?>
                            <tr style="text-align: center">
                                <td>
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $menu->name; ?>
                                </td>
                                <td>
                                    <?php echo $menu->route; ?>
                                </td>
                                <td>
									<?php 
									foreach ($acciones as $accion){
										if($menu->action_id == $accion->id){
											echo $accion->name;
										}else{
											echo "";
										}
									}
									?>
                                </td>
                                <td style='text-align: center'>
                                    <a href="<?php echo base_url() ?>menus/edit/<?= $menu->id; ?>" title="Editar" style='color: #1ab394'><i class="fa fa-edit fa-2x"></i></a>
                                </td>
                                <td style='text-align: center'>
                                    
                                    <a class='borrar' id='<?php echo $menu->id; ?>' style='color: #1ab394' title='Eliminar'><i class="fa fa-trash-o fa-2x"></i></a>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        <?php } ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


 <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
             $('#tab_menus').DataTable({
                "paging": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": true,
                "info": true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ],
                "iDisplayLength": 5,
                "iDisplayStart": 0,
                "sPaginationType": "full_numbers",
                "aLengthMenu": [5, 10, 15],
                "oLanguage": {"sUrl": "<?= assets_url() ?>js/es.txt"},
                "aoColumns": [
                    {"sClass": "registro center", "sWidth": "5%"},
                    {"sClass": "registro center", "sWidth": "20%"},
                    {"sClass": "registro center", "sWidth": "20%"},
                    {"sClass": "registro center", "sWidth": "20%"},
                    {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false},
                    {"sWidth": "3%", "bSortable": false, "sClass": "center sorting_false", "bSearchable": false}
                ]
            });
             
         // Validacion para borrar
    $("table#tab_menus").on('click', 'a.borrar', function (e) {
        e.preventDefault();
        var id = this.getAttribute('id');

        swal({
            title: "Borrar registro",
            text: "¿Está seguro de borrar el registro?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Eliminar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
          },
          function(isConfirm){
            if (isConfirm) {
             
              $.post('<?php echo base_url(); ?>menus/delete/' + id + '', function (response) {

                 if (response[0] == "e") {
                    
                      swal({ 
                        title: "Disculpe,",
                         text: "No se puede eliminar se encuentra asociado a un submenú",
                          type: "warning" 
                        },
                        function(){
                          
                      });
                 }else{
                      swal({ 
                        title: "Eliminar",
                         text: "Registro eliminado con exito",
                          type: "success" 
                        },
                        function(){
                          window.location.href = '<?php echo base_url(); ?>menus';
                      });
                    
                    
                 }
            
   
             });
            } 
          });
        
    });
            
        });
        
    </script>
