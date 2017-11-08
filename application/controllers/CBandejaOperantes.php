<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CBandejaOperantes extends CI_Controller {

	public function __construct() {
        parent::__construct();
       
		// Load database
        $this->load->model('MBandejaOperantes');
        $this->load->model('MBandejaEntrada');
		
    }
	
	public function index(){
		$this->load->view('base');
		$this->load->view('bandejas/bandeja_operante');
		$this->load->view('footer');
	}
	
	public function ajax_operantes(){
		
		$fetch_data = $this->MBandejaOperantes->make_datatables();
		//~ $consulta_ejecutada = $this->db->last_query();
		//~ echo $consulta_ejecutada;
		//~ echo count($fetch_data);
		$data = array();
		foreach($fetch_data as $row){
			
			$sub_array = array();
			
			// Proceso para la creación del combo select de asignación
			//~ $select = "<select class='form-control cambiar' style='width:100%' id='".$row->id.";".$row->status."'>";
			//~ $select .="<option value='0'>Seleccione</option>";
			//~ $select .="<option value='Individual'>Individual</option>";
			//~ $select .="<option value='Colectivo'>Colectivo</option>";
			//~ $select .="</select>";
			
			$sub_array[] = $row->id;
			$sub_array[] = $row->screen_name;
			$sub_array[] = $row->text;
			$sub_array[] = $row->created_at;
			//~ $sub_array[] = $select;
			$bot;
			if($row->bot == 0){$bot = "No";}else{$bot = "<span style='color:#D33333;'>Sí</span>";}
			$sub_array[] = $bot;
			
			$data[] = $sub_array;
		}
		
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->MBandejaOperantes->get_all_data(),
			"recordsFiltered" => $this->MBandejaOperantes->get_filtered_data(),
			"data" => $data
		);
		
		echo json_encode($output);
		
	}
	
}
