<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_icons extends CI_Migration
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
				"class" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"name" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"category" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"d_create" => array(
					"type" => "TIMESTAMP"
				),
				"d_update" => array(
					"type" => "TIMESTAMP"
				)
			)
		);
		
		$this->dbforge->add_key('id', TRUE);  // Establecemos el id como primary_key
		
		$this->dbforge->create_table('icons', TRUE);
		
	}
	
	public function down(){
		
		// Eliminamos la tabla 'icons'
		$this->dbforge->drop_table('icons', TRUE);
		
	}
	
}
