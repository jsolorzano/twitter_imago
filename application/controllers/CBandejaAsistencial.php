<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CBandejaAsistencial extends CI_Controller {

	public function __construct() {
        parent::__construct();
       
		// Load database
        $this->load->model('MBandejaAsistencial');
        $this->load->model('MBandejaEntrada');
		
    }
	
	public function index(){
		$this->load->view('base');
		$this->load->view('bandejas/bandeja_asistencial');
		$this->load->view('footer');
	}
	
	public function ajax_asistencial(){
		
		$fetch_data = $this->MBandejaAsistencial->make_datatables();
		//~ $consulta_ejecutada = $this->db->last_query();
		//~ echo $consulta_ejecutada;
		//~ echo count($fetch_data);
		$data = array();
		foreach($fetch_data as $row){
			
			$sub_array = array();
			
			// Proceso para la creación del combo select de asignación
			$select = "<select class='form-control cambiar' style='width:100%' id='".$row->id.";".$row->status."'>";
			$select .="<option value='0'>Seleccione</option>";
			$select .="<option value='Individual'>Individual</option>";
			$select .="<option value='Colectivo'>Colectivo</option>";
			$select .="</select>";
			
			$sub_array[] = $row->id;
			$sub_array[] = $row->screen_name;
			$sub_array[] = $row->text;
			$sub_array[] = $row->created_at;
			$sub_array[] = $select;
			$bot;
			if($row->bot == 0){$bot = "No";}else{$bot = "<span style='color:#D33333;'>Sí</span>";}
			$sub_array[] = $bot;
			
			$data[] = $sub_array;
		}
		
		$output = array(
			"draw" => intval($_POST["draw"]),
			"recordsTotal" => $this->MBandejaAsistencial->get_all_data(),
			"recordsFiltered" => $this->MBandejaAsistencial->get_filtered_data(),
			"data" => $data
		);
		
		echo json_encode($output);
		
	}
	
	// Método para cambiar un tweet a una determinada nueva bandeja
	public function cambio_bandeja(){
		
		$id_tweet = $this->input->post('id');
		$nueva_bandeja = $this->input->post('nueva_bandeja');
		$mensaje = $this->input->post('mensaje');
		
		// Comprobamos a qué tabla será movido el tweet
		if($nueva_bandeja == "Individual"){
			$tabla = "bandeja_individuales";
			$accion = "Asignado a bandeja individuales";
		}else if($nueva_bandeja == "Colectivo"){
			$tabla = "bandeja_colectivos";
			$accion = "Asignado a bandeja colectivos";
		}
		
		// Consultamos los datos del tweet correspondiente al id dado
		$datos_tweet = $this->MBandejaAsistencial->obtenerTweet($id_tweet);
		
		// Armamos los datos a registrar del tweet
		$data = array(
			'screen_name' => $datos_tweet[0]->screen_name,
			'id_str' => $datos_tweet[0]->id_str,
			'text' => $datos_tweet[0]->text,
			'created_at' => date('Y-m-d'),
			'status' => 1,
		);
		
		// Registramos el tweet
		$insert = $this->MBandejaEntrada->insert($tabla, $data);
		
		if($insert){
			
			// Actualizamos el status del tweet en la tabla 'bandeja_asistencial'
			$data2 = array(
				'id' => $id_tweet,
				'asignacion' => $nueva_bandeja,
				'status' => 0
			);
			
			$update = $this->MBandejaEntrada->update_status('bandeja_asistencial', $data2);
			
			
			// Registramos la acción en la tabla 'time_line'
			$data_bitacora = array(
				'fecha' => date('Y-m-d'),
				'usuario' => $this->session->userdata('logged_in')['id'],
				'mensaje' => $mensaje,
				'accion' => $accion,
				'tweet_id' => $id_tweet
			);
			
			$time_line = $this->MBandejaEntrada->insert('time_line', $data_bitacora);
			
			
			if($update && $time_line){
				
				echo '{"response":"ok"}';
				
			}
			
		}else{
			
			echo '{"response":"error"}';
			
		}
	}
	
}
