<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bandeja individuales</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>home">Inicio</a>
            </li>
            <li class="active">
                <strong>Bandeja individuales</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Bandeja individuales </h5>
                    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="tab_individuales" class="table table-striped table-bordered dt-responsive table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Solicitante</th>
                                    <th>Mensaje</th>
                                    <th>Fecha</th>
                                    <th>Bot</th>
                                </tr>
                            </thead>
							
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Page-Level Scripts -->
<script src="<?php echo assets_url(); ?>script/bandeja_individual.js"></script>
