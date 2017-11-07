<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CBandejaEntrada extends CI_Controller {

	public function __construct() {
        parent::__construct();


       
		// Load database
        $this->load->model('MBandejaEntrada');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$this->load->view('bandejas/bandeja_entrada');
		$this->load->view('footer');
	}
	
	public function ajax_entrada()
	{
		
		$fetch_data = $this->MBandejaEntrada->make_datatables();
		//~ $consulta_ejecutada = $this->db->last_query();
		//~ echo $consulta_ejecutada;
		//~ echo count($fetch_data);
		$data = array();
		foreach($fetch_data as $row){
			
			$sub_array = array();
			
			// Proceso para la creación del combo select de asignación
			$select = "<select class='form-control' style='width:100%'>";
			$select .="<option value='Político'>Político</option>";
			$select .="<option value='Asistencial'>Asistencial</option>";
			$select .="</select>";
			
			$sub_array[] = $row->id;
			$sub_array[] = $row->screen_name;
			$sub_array[] = $row->text;
			$sub_array[] = $row->created_at;
			$sub_array[] = $select;
			$bot;
			if($row->bot == 0){$bot = "No";}else{$bot = "Sí";}
			$sub_array[] = $bot;
			
			$data[] = $sub_array;
		}
		
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->MBandejaEntrada->get_all_data(),
			"recordsFiltered" => $this->MBandejaEntrada->get_filtered_data(),
			"data" => $data
		);
		
		echo json_encode($output);
		
	}	
	
}
