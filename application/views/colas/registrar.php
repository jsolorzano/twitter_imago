<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Servicios </h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            
            <li>
                <a href="<?php echo base_url() ?>services">Servicios</a>
            </li>
            
            <li class="active">
                <strong>Registrar Servicio</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Registrar Servicio <small></small></h5>
					
				</div>
				<div class="ibox-content">
					<form id="form_services" method="post" accept-charset="utf-8" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-2 control-label" >Nombre *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  maxlength="100" name="name" id="name">
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Descripcion *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control"  name="description" maxlength="200" id="description">
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" >Imagen *</label>
							<div class="col-sm-6">
								<input type="file" class="form-control"  name="icon" maxlength="200" id="icon">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Precio *</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" maxlength="11"  name="price" id="price">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" >Estatus *</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="status" id="status">
									<option value="1" selected="">Activo</option>
									<option value="0">Inactivo</option>

								</select>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-4 col-sm-offset-2">
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
        url = '<?php echo base_url() ?>services/';
        window.location = url;
    });

	// Validamos que el archivo sea de tipo .jpg, jpeg o png
	$("#icon").change(function (e) {
		e.preventDefault();  // Para evitar que se envíe por defecto
		
		var max_size = '';
		var archivo = $(this).val();
		
		var ext = archivo.split(".");
		ext = ext[1];
		
		if (ext != 'jpg' && ext != 'jpeg' && ext != 'png'){
			swal("Disculpe,", "sólo se admiten archivos .jpg, .jpeg y png");
			$("#icon").val('');
			$('#icon').parent('div').addClass('has-error');
		}
	});

    $("#registrar").click(function (e) {

        e.preventDefault();  // Para evitar que se envíe por defecto

        if ($('#name').val().trim() === "") {
			swal("Disculpe,", "para continuar debe ingresar nombre");
			$('#name').parent('div').addClass('has-error');
			
        } else if ($('#description').val().trim() === "") {
			swal("Disculpe,", "para continuar debe ingresar la descripción");
			$('#description').parent('div').addClass('has-error');
			
        } else if ($('#icon').val().trim() == '1' || $('#icon').val().trim() == '') {
			swal("Disculpe,", "para continuar debe seleccionar una imagen");
			$('#icon').parent('div').addClass('has-error');
			
        } else if ($('#price').val().trim() === "") {
			swal("Disculpe,", "para continuar debe ingresar el precio");
			$('#price').parent('div').addClass('has-error');
			
        }  else {

            //~ $.post('<?php echo base_url(); ?>CServices/add', $('#form_services').serialize(), function (response) {
				//~ if (response[0] == '1') {
                    //~ swal("Disculpe,", "este nombre se encuentra registrado");
                //~ }else{
					//~ swal({ 
						//~ title: "Registro",
						 //~ text: "Guardado con exito",
						  //~ type: "success" 
						//~ },
					//~ function(){
					  //~ window.location.href = '<?php echo base_url(); ?>services';
					//~ });
				//~ }
            //~ });
            
            var formData = new FormData(document.getElementById("form_services"));  // Forma de capturar todos los datos del formulario
			
			$.ajax({
				//~ method: "POST",
				type: "post",
				dataType: "html",
				url: '<?php echo base_url(); ?>CServices/add',
				data: formData,
				cache: false,
				contentType: false,
				processData: false
			})
			.done(function(data) {
				if(data.error){
					console.log(data.error);
				} else {
					if (data[0] == '1') {
						swal("Disculpe,", "este servicio se encuentra registrado");
					}else{
						swal({ 
							title: "Registro",
							 text: "Guardado con exito",
							  type: "success" 
							},
						function(){
						  window.location.href = '<?php echo base_url(); ?>services';
						});
					}
				}				
			}).fail(function() {
				console.log("error ajax");
			});
        }
    });
});

</script>
