<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_table_twitter extends CI_Migration
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
				"name" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				),
				"location" => array(
					"type" => "VARCHAR",
					"constraint" => 200
				),
				"url" => array(
					"type" => "VARCHAR",
					"constraint" => 200
				),
				"description" => array(
					"type" => "VARCHAR",
					"constraint" => 250
				),
				"followers_count" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"friends_count" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"listed_count" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"favorites_count" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"statuses_count" => array(
					"type" => "INT",
					"constraint" => 11
				),
				"profile_image_url" => array(
					"type" => "VARCHAR",
					"constraint" => 100
				)
			)
		);
		
		$this->dbforge->add_key('id', TRUE);  // Establecemos el id como primary_key
		
		$this->dbforge->create_table('twitter', TRUE);
		
	}
	
	public function down(){
		
		// Eliminamos la tabla 'twitter'
		$this->dbforge->drop_table('twitter', TRUE);
		
	}
	
}
