<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_users extends CI_Migration
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
				"username" => array(
					"type" => "VARCHAR",
					"constraint" => 50,
					"null" => FALSE
				),
				"password" => array(
					"type" => "VARCHAR",
					"constraint" => 200
				),
				"name" => array(
					"type" => "VARCHAR",
					"constraint" => 50
				),
				"lastname" => array(
					"type" => "VARCHAR",
					"constraint" => 50
				),
				"profile_id" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"admin" => array(
					"type" => "INT",
					"constraint" => 11
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
		
		$this->dbforge->add_key('profile_id');  // Establecemos el profile_id como key
		
		$this->dbforge->create_table('users', TRUE);
		
	}
	
	public function down(){
		
		// Eliminamos la tabla 'prueba3'
		$this->dbforge->drop_table('users', TRUE);
		
	}
	
}
