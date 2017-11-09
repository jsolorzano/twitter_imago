<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Twitters</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            <li class="active">
                <strong>Twitters</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Twitters </h5>
                    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="tab_twitters" class="table table-striped table-bordered dt-responsive table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicitante</th>
                                    <th>Nombre</th>
                                    <th>URL</th>
                                    <th>Seguidores</th>
                                    <th>Amigos</th>
                                    <th>Favoritos</th>
                                    <th>Imagen</th>
                                </tr>
                            </thead>
							
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para indicar la cédula del usuario -->
<div class="modal fade" id="modal_cedula">
   <div class="modal-dialog">
	  <div class="modal-content">
		 <div class="modal-header" style="background-color:#1ab394">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" style="color:#ffffff">
			   <center>
				<span class="glyphicon glyphicon-search"></span>
				&nbsp;Indique la cédula del usuario
			   </center>
			</h4>
		 </div>
		 <div class="modal-body">
			<form id="f_cedula" name="f_cedula" action="" method="post">
			   <div class="form-group">
					<div class="col-sm-12">
						<div class="form-group">
							<label style="font-weight:bold;">Cédula</label>
							<input type="form-control" id="cedula">
							<input type="hidden" id="id">
							<input type="hidden" id="screen_name">
						</div>
					</div>
					</br></br>
					</br></br>
					<div class="col-sm-12" align="right">
						<span class="input-btn">
							<button class="btn btn-primary" type="button" id="ver">
								Inspeccionar&nbsp;<span class="glyphicon glyphicon-share-alt"></span>
							</button>
						</span>
					</div>
					</br></br>
			   </div>
			</form>
		 </div>
		 
	  </div>
   </div>
</div>
<!-- Cierre Modal para indicar la cédula del usuario -->

 <!-- Page-Level Scripts -->
<script src="<?php echo assets_url(); ?>script/twitters.js"></script>
