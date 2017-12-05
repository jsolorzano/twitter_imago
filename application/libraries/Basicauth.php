<?php

Class Basicauth
{
	function __construct()
	{
		$this->CI = & get_instance();
	}
	
	function login($usuario, $password)
	{
		$data = array();
		$query = $this->CI->db->get_where('users', array('username'=>$usuario, 'password'=>$password));
		
		if($query->num_rows() > 0){
			//~ echo "Pasó 1";
			$query = $this->CI->db->get_where('users', array('username'=>$usuario, 'password'=>$password, 'status'=>1));
			if($query->num_rows() > 0){
				//~ echo "Pasó 2";
				// Consultamos los datos de perfil del usuario
				$query_profile = $this->CI->db->get_where('profile', array('id'=>$query->row()->profile_id));
				// Consultamos los datos de acciones del perfil
				$query_profile_actions = $this->CI->db->get_where('profile_actions', array('profile_id'=>$query_profile->row()->id));
				$acciones = array();
				foreach($query_profile_actions->result() as $profile_action){
					$query_actions = $this->CI->db->get_where('actions', array('id'=>$profile_action->action_id));
					$acciones[] = $query_actions->result();
				}
				// Consultamos los datos de permisos del usuario
				$query_permissions = $this->CI->db->get_where('permissions', array('user_id'=>$query->row()->id));
				$permisos = array();
				foreach($query_permissions->result() as $permissions){
					$query_actions2 = $this->CI->db->get_where('actions', array('id'=>$permissions->action_id));
					$permisos[] = $query_actions2->result();
				}
				// Buscamos los datos de la tienda con sus servicios, los menús y submenús asociados al usuario
				$tiendas = array();
				//~ $servicios = array();
				$menus = array();
				$submenus = array();
				
				// Buscamos si hay tiendas asociadas al usuario
				$query_user_tienda = $this->CI->db->get_where('users_tiendas', array('user_id'=>$query->row()->id));
				if($query_user_tienda->num_rows() > 0){
					// Listamos las tiendas asociadas
					$ids_serv = array();  // Variable para almacenar los ids de los servicios y filtrar los repetidos
					foreach($query_user_tienda->result() as $tienda){
						//~ print $tienda->tienda_id;
						$query_tienda = $this->CI->db->get_where('tiendas', array('id'=>$tienda->tienda_id));
						//~ print_r($query_tienda->result());
						$tiendas[] = $query_tienda->result();
					}
				}
				
				// Carga de menús y submenús para usuarios no administradores
				$ids_acciones = array();  // Lista de ids de acciones para buscar en submenús
				// Buscamos los submenús (acciones y permisos) asociados al usuario para armar la lista de acciones
				foreach($acciones as $accion){
					//~ print_r($accion);
					$ids_acciones[] = $accion[0]->id;
				}
				foreach($permisos as $permiso){
					//~ print_r($permiso);
					$ids_acciones[] = $permiso[0]->id;
				}
				//~ print_r($ids_acciones);
				// Buscamos los menús y submenús correspondientes a los ids de acciones
				foreach($ids_acciones as $id_accion){
					//~ echo $id_accion;
					$query_submenus = $this->CI->db->get_where('submenus', array('action_id'=>$id_accion));
					if($query_submenus->num_rows() > 0){
						$submenus[] = $query_submenus->result();
					}
					$query_menus = $this->CI->db->get_where('menus', array('action_id'=>$id_accion));
					if($query_menus->num_rows() > 0){
						$menus[] = $query_menus->result();
					}
				}
				// Buscamos los menús correspondientes a los menu_id de la lista de submenús
				$menu_names = array();  // Variable de apoyo para validar que no se repitan los menús
				foreach($submenus as $submenu){
					//~ echo $submenu[0]->menu_id;
					$query_menus = $this->CI->db->get_where('menus', array('id'=>$submenu[0]->menu_id));
					if($query_menus->num_rows() > 0){
						if(!in_array($query_menus->result()[0]->name, $menu_names)){
							$menu_names[] = $query_menus->result()[0]->name;
							$menus[] = $query_menus->result();
						}
					}
				}
				
				// Variable para indicar si el perfil del usuario logueado pertenece a algún grupo de bandejas
				$group = 0;
				
				$query_group = $this->CI->db->get_where('grupos_bandejas_perfiles', array('perfil_id'=>$query->row()->profile_id));
				
				if($query_group->num_rows() > 0){
					$group = $query_group->row()->grupo_bandeja_id;
				}
				
				// Creamos la sesión y le cargamos los datos de usuario
				$session_data = array(
					'id' => $query->row()->id,
					'username' => $usuario,
					'admin' => $query->row()->admin,
					'profile_id' => $query_profile->row()->id,
					'profile_name' => $query_profile->row()->name,
					'acciones' => $acciones,
					'permisos' => $permisos,
					'tiendas' => $tiendas,
					//~ 'servicios' => $servicios,
					'submenus' => $submenus,
					'menus' => $menus,
					'group' => $group
				);
				$this->CI->session->set_userdata('logged_in',$session_data);
				
			}else{
				$data['error'] = 'Disculpe, el usuario no tiene acceso, consulte con el administrador del sistema';
			}
		}else{
			$data['error'] = 'Usuario o contraseña incorrectos';
		}
		
		return $data;
	}
	
	function logout()
	{
		$this->CI->session->sess_destroy();
	}
}
