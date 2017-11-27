<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_colectivos extends CI_Migration
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
				"screen_name" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"id_str" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"text" => array(
					"type" => "VARCHAR",
					"constraint" => 250,
					"null" => TRUE
				),
				"created_at" => array(
					"type" => "VARCHAR",
					"constraint" => 20,
					"null" => TRUE
				),
				"asignacion" => array(
					"type" => "VARCHAR",
					"constraint" => 100,
					"null" => TRUE
				),
				"bot" => array(
					"type" => "INT",
					"constraint" => 11,
					"null" => TRUE
				),
				"status" => array(
					"type" => "INT",
					"constraint" => 11,
					"null" => TRUE
				)
			)
		);
		
		$this->dbforge->add_key('id', TRUE);  // Establecemos el id como primary_key
		
		$this->dbforge->add_key('id_str');  // Establecemos el id_str como key
		
		$this->dbforge->create_table('bandeja_colectivos', TRUE);
		
	}
	
	public function down(){
		
		// Eliminamos la tabla 'bandeja_colectivos'
		$this->dbforge->drop_table('bandeja_colectivos', TRUE);
		
	}
	
}
