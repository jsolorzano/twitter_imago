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
				// Primero verificamos que el usuario no sea administrador
				//if($query->row()->admin == 0){
					//~ echo "Pasó 3";
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
							//~ // Buscamos los datos de los servicios asociados a la(s) tienda(s)
							//~ $query_tienda_services = $this->CI->db->get_where('tiendas_services', array('franchise_id'=>$query_tienda->row()->id));
							//~ if($query_tienda_services->num_rows() > 0){
								//~ // Listamos los servicios asociados
								//~ foreach($query_tienda_services->result() as $services){
									//~ $query_servicio = $this->CI->db->get_where('services', array('id'=>$services->service_id));
									//~ if(!in_array($query_servicio->row()->id, $ids_serv)){
										//~ $servicios[] = $query_servicio->result();
									//~ }
									//~ $ids_serv[] = $query_servicio->row()->id;  // Vamos almacenando los ids de los servicios ya cargados
								//~ }
							//~ }
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
				/*}else{
					// Consultamos los datos de todas las acciones 
					// (en este caso, el formato de captura de datos de acciones en sesión será diferente en el hook de acceso y el helper de menú, para lo cual habrá que hacer una validación en dichos archivos)
					$acciones = array();
					$query_actions = $this->CI->db->get('actions');
					foreach($query_actions->result() as $action){
						$acciones[] = $action;
					}
					// Carga de menús y submenús para usuarios administradores
					// Menús
					$query_menus = $this->CI->db->get('menus');
					$menus[] = $query_menus->result();
					// Submenús
					$query_submenus = $this->CI->db->get('submenus');
					$submenus[] = $query_submenus->result();
				}*/
				//~ exit();
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
					'menus' => $menus
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
