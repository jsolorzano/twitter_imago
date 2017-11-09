<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Twitter details</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            <li>
                <a href="<?php echo base_url().$ruta_origen; ?>">Atrás</a>
            </li>
            <li class="active">
                <strong>Twitter details</strong>
            </li>
        </ol>
    </div>
</div>

<!-- Campo oculto que almacena el url base del proyecto -->
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">

<!-- Cuerpo de la sección de perfil de twitter -->
<div class="wrapper wrapper-content animated fadeInUp">
	<div class="row">
		<div class="col-lg-12">
			<div class="contact-box">				
				<div class="col-sm-2">
					<div class="text-center">
						<a href="profile.html">
							<img alt="image" class="img-circle m-t-xs img-responsive" src="<?php echo $profile_image_url; ?>">
						</a>
						<!--<div class="m-t-xs font-bold">xxxxxxx</div>-->
					</div>
				</div>
				<div class="col-sm-10">
					<h3><strong><?php echo $screen_name; ?></strong></h3>
					<p><?php echo $name; ?></p>
					<p><?php echo $location; ?></p>
					<p><strong><?php echo $url; ?></strong></p>
					<p><?php echo $description; ?></p>
				</div>
				<div class="clearfix"></div>
				
				<div class="contact-box-footer">
					<div>
						<div class="col-md-2 forum-info">
							<span class="views-number">
								<?php echo $statuses_count; ?>
							</span>
							<div>
								<small>statuses_count</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number">
								<?php echo $favorites_count; ?>
							</span>
							<div>
								<small>Favorites</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number">
								<?php echo $listed_count; ?>
							</span>
							<div>
								<small>Listed</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number">
								<?php echo $friends_count; ?>
							</span>
							<div>
								<small>Friends</small>
							</div>
						</div>
						<div class="col-md-2 forum-info">
							<span class="views-number">
								<?php echo $followers_count; ?>
							</span>
							<div>
								<small>Followers</small>
							</div>
						</div>
					</div>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Cierre del cuerpo de la sección de perfil de twitter -->

<div class="wrapper wrapper-content animated fadeInUp">

	<div class="ibox">
		<div class="ibox-title">
			<h5>All profiles assigned to this account</h5>
			<div class="ibox-tools">
				<a class="btn btn-primary btn-xs" ng-click="crearNuevo()">Create new social profile</a>
			</div>
		</div>
		<div class="ibox-content">
			<!--<div class="row m-b-sm m-t-sm">
				<div class="col-md-1">
					<button type="button" id="loading-example-btn" class="btn btn-white btn-sm" ><i class="fa fa-refresh"></i> Refresh</button>
				</div>
				<div class="col-md-11">
					<div class="input-group">
						<input type="text" placeholder="Search" class="input-sm form-control" ng-model="busqueda">
						<span class="input-group-btn">
						<button type="button" class="btn btn-sm btn-primary"> Go!</button> 
						</span>
					</div>
				</div>
				<div class="col-md-1">
					<smal> Buscando: {{busqueda}}</smal>
				</div>
			</div>-->

			<div class="project-list">

				<table class="table table-hover">
					<tbody>
						<tr ng-repeat="empleado in empleados | filter: busqueda">
							<td class="project-status">
								<a href=""><img alt="image" class="img-circle" ng-src="{{config.carpeta_imagenes + empleado.imagen}}"></a>
							</td>
							<td class="project-title">
								<a href="project_detail.html">{{empleado.nombre}}</a>
								<br/>
								<small>{{empleado.descripcion}}</small>
							</td>
							<td class="project-completion">
								<small>Completion with: 48%</small>
								<div class="progress progress-mini">
									<div style="width: 48%;" class="progress-bar"></div>
								</div>
							</td>
							<td class="project-people">
								<span class="label label-primary">Active</span>
							</td>
							<td class="project-actions">
								<a class="btn btn-white btn-sm" ng-click="verDetalles(empleado.id)"><i class="fa fa-folder"></i> View </a>
								<a class="btn btn-white btn-sm" ng-click="editarDetalles(empleado.id)"><i class="fa fa-pencil"></i> Edit </a>
								<a class="btn btn-danger btn-sm" ng-click="borrarEmpleado(empleado.id)"><i class="fa fa-trash"></i> Delete </a>
							</td>
						</tr>
					</tbody>
				</table>
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
<script src="<?php echo assets_url(); ?>script/twitter_view.js"></script>
