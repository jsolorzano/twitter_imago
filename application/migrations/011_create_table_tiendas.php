<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_tiendas extends CI_Migration
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
				"rif" => array(
					"type" => "VARCHAR",
					"constraint" => 20
				),
				"name" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"address" => array(
					"type" => "VARCHAR",
					"constraint" => 250
				),
				"referencia" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"bd_externa" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"cp_externo" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"phone" => array(
					"type" => "VARCHAR",
					"constraint" => 20
				),
				"status" => array(
					"type" => "INT",
					"constraint" => 11
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
		
		$this->dbforge->create_table('tiendas', TRUE);
		
	}
	
	public function down(){
		
		// Eliminamos la tabla 'tiendas'
		$this->dbforge->drop_table('tiendas', TRUE);
		
	}
	
}
