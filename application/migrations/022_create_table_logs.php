<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_logs extends CI_Migration
{
	public function up(){
		
		// Creamos la estructura de la nueva tabla usando la clase dbforge de Codeigniter
		$this->dbforge->add_field(
			array(
				"id" => array(
					"type" => "INT",
					"constraint" => 11,
					"unsigned" => TRUE,
					"auto_increment" => TRUE,
					"null" => FALSE
				),
				"user_id" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"detail" => array(
					"type" => "VARCHAR",
					"constraint" => 250
				),
				"date" => array(
					"type" => "TIMESTAMP"
				),
				"ip" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"d_create" => array(
					"type" => "TIMESTAMP"
				),
				"d_update" => array(
					"type" => "TIMESTAMP"
				),
			)
		);
		
		$this->dbforge->add_key('id', TRUE);  // Establecemos el id como primary_key
		
		$this->dbforge->add_key('user_id');  // Establecemos el user_id como key
		
		$this->dbforge->create_table('logs', TRUE);
		
	}
	
	public function down(){
		
		// Eliminamos la tabla 'logs'
		$this->dbforge->drop_table('logs', TRUE);
		
	}
	
}
