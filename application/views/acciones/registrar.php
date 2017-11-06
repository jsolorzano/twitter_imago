<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Acciones</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>acciones">Acciones</a>
            </li>

            <li class="active">
                <strong>Registrar Acción</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Registrar Acción<small></small></h5>
					
				</div>
				<div class="ibox-content">
					<form id="form_acciones" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group"><label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10"><input type="text" class="form-control" style="text-transform:uppercase;" maxlength="100" name="name" id="name"></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Clase</label>
							<div class="col-sm-10">
								<select name="class" id="class" class="form-control">
									<option value="0">Seleccione</option>
									<?php
									foreach ($controladores as $controlador) {
										?>
										<option value="<?php echo $controlador ?>"><?php echo $controlador ?></option>
										<?php
									}
									?>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Ruta</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" maxlength="100" name="route" id="route">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
								<input class="form-control"  type='hidden' id="id" name="id" value=""/>
								<button class="btn btn-white" id="volver" type="button">Volver</button>
								<button class="btn btn-primary" id="registrar" type="submit">Guardar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){

    $('input').on({
        keypress: function () {
            $(this).parent('div').removeClass('has-error');
        }
    });

    $('#volver').click(function () {
        url = '<?php echo base_url() ?>acciones/';
        window.location = url;
    });


    $("#registrar").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {
			
			swal("Disculpe,", "para continuar debe ingresar el nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#class').val().trim() === "0") {
			
			swal("Disculpe,", "para continuar debe ingresar la clase");
			$('#class').parent('div').addClass('has-error');
			$('#class').focus();
			
        } else if ($('#route').val().trim() === "") {
			
			swal("Disculpe,", "para continuar debe ingresar la ruta");
			$('#route').parent('div').addClass('has-error');
			$('#route').focus();
			
        } else {
			
            $.post('<?php echo base_url(); ?>CAcciones/add', $('#form_acciones').serialize(), function (response) {

				if (response[0] == '1') {
                    swal("Disculpe,", "este nombre se encuentra registrado");
                }else{
					swal({ 
						title: "Registro",
						 text: "Guardado con exito",
						  type: "success" 
						},
					function(){
					  window.location.href = '<?php echo base_url(); ?>acciones';
					});
				

				}

            });
        }

    });
});

</script>
