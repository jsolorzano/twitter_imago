<?php

defined('BASEPATH') OR exit('No direct script access allowed');


class MBandejaIndividuales extends CI_Model {
	
	var $table = "bandeja_individuales b_i";
	
	var $select_column = array(
		"b_i.id", 
		"b_i.screen_name", 
		"b_i.id_str", 
		"b_i.text", 
		"b_i.created_at", 
		"b_i.asignacion",
		"b_i.bot",
		"b_i.status"
	);
	
	var $order_column = array(
		"b_i.screen_name", 
		"b_i.id_str", 
		"b_i.text", 
		"b_i.created_at", 
		"b_i.asignacion",
		"b_i.bot"
	);


    public function __construct() {
       
        parent::__construct();
        $this->load->database();
    }

    // Public method to obtain the twitters
    public function obtener() {
        $query = $this->db->get('bandeja_individuales');

        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

    // Método público para construir la consulta
    public function make_query() {
        $this->db->select($this->select_column);
        //~ $this->db->distinct();
		$this->db->from($this->table);
        $this->db->where('b_i.status =', 1);
		if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != ""){
			$condicionales_like = "(b_i.screen_name LIKE '%".$_POST["search"]["value"]."%' OR ";
			$condicionales_like .= "b_i.id_str LIKE '%".$_POST["search"]["value"]."%' OR ";
			$condicionales_like .= "b_i.text LIKE '%".$_POST["search"]["value"]."%' OR ";
			$condicionales_like .= "b_i.created_at LIKE '%".$_POST["search"]["value"]."%' OR ";
			$condicionales_like .= "b_i.asignacion LIKE '%".$_POST["search"]["value"]."%' OR ";
			$condicionales_like .= "b_i.bot LIKE '%".$_POST["search"]["value"]."%')";
			$this->db->where($condicionales_like);
		}
		if(isset($_POST["order"])){
			$this->db->order_by($this->order_column[$_POST["order"]["0"]["column"]], $_POST["order"]["0"]["dir"]);
		}else{
			$this->db->order_by("id", "DESC");
		}
    }
    
    // Método público para ejecutar la consulta
    public function make_datatables(){
		$this->make_query();
		if($_POST["length"] != -1){
			$this->db->limit($_POST["length"], $_POST["start"]);
		}
		$query = $this->db->get();
		return $query->result();		
	}
	
	// Método público para obtener el número de registros resultantes de make_query()
	public function get_filtered_data(){
		$this->make_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	// Método público para obtener el número total de registros de la bandeja de entrada en estatus 1
	public function get_all_data(){
		$this->db->select($this->select_column);
		$this->db->from($this->table);
		$this->db->where('b_i.status =', 1);
		return $this->db->count_all_results();
	}
	
	// Método público para consultar los datos de un tweet según su id
    public function obtenerTweet($tweet_id) {
        $this->db->where('id', $tweet_id);
        $query = $this->db->get('bandeja_individuales');
        if ($query->num_rows() > 0)
            return $query->result();
        else
            return $query->result();
    }

}
?>
