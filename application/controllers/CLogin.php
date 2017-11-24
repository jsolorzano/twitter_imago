<?php
//~ defined('BASEPATH') OR exit('No direct script access allowed');

Class CLogin extends CI_Controller {

    public function __construct() {
        @parent::__construct();

// Load database
        $this->load->model('MLogin');
        $this->load->model('MUser');
        $this->load->model('MPerfil');
        $this->load->model('MAcciones');
        $this->load->model('MMenus');
        $this->load->model('MSubMenus');
        $this->load->model('MGruposBandejas');
        //~ $this->load->model('auditoria/ModelsAuditoria');
        //~ $this->load->model('busquedas_ajax/ModelsBusqueda');
    }

	// Show login page
    public function login() {
		
		// Validamos la base de datos
		$exists = $this->exists_database();
		if($exists == "existe"){
			
			$this->migrations();  // Ejecutamos las migraciones
			
		}
		
		$data = array();
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		
		if($this->form_validation->run()==FALSE){
			$this->load->view('login_form', $data);
		}else{
			//~ echo "usuario: ".$this->input->post('username');
			//~ echo "contraseña: ".$this->input->post('password');
			$usuario = $this->input->post('username');
			$password = 'pbkdf2_sha256$12000$'.hash( "sha256", $this->input->post('password') );
			
			$respuesta = $this->basicauth->login($usuario, $password);
			
			if(!isset($respuesta['error'])){
				redirect('home');
			}else{
				$data['error'] = $respuesta['error'];
				$this->load->view('login_form', $data);
			}
		}
		
    }

	// Logout from admin page
    public function logout() {
		// Removing session data
        $this->basicauth->logout();
        redirect('login');
    }
    
	// Show login page
    public function login_public() {
		$data = array();
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        
        if($this->form_validation->run()!=FALSE){
			$usuario = $this->input->post('username');
			$password = 'pbkdf2_sha256$12000$'.hash( "sha256", $this->input->post('password') );
			
			$respuesta = $this->basicauthpublic->login($usuario, $password);
			
			if(!isset($respuesta['error'])){
				if($this->input->post('location') !== null){
					redirect('solicitud');
				}else{
					redirect('public_perfil');
				}
			}else{
				$data['error'] = $respuesta['error'];
				$this->load->view('public', $data);
				if($data['error'] == 'Usuario o contraseña incorrectos'){
					redirect('public?error=1');
				}else{
					redirect('public?error=2');
				}
				
			}
		}else{
			echo "No pasó";
		}
    }

	// Logout from profile page
    public function logout_public() {
		
		// Removing session data
        $this->basicauthpublic->logout();
        redirect('public');
        
    }
    
    // Método para verificar si la base de datos existe
    public function exists_database(){
		
		$this->load->dbutil();
		
		if ($this->dbutil->database_exists('twitter_imago'))
		{
			
			return "existe";
			
		}else{
			
			return "no existe";
			
		}
		
	}
	
	// Método que realiza las migraciones correspondientes
	public function migrations(){
		
		// Carga de la librería
		$this->load->library('migration');
		
		// Ejecutamos la migración
		if(!$this->migration->latest()){
			
			echo "error";
			show_error($this->migration->error_string());
			
		}else{
		
			//~ echo "success";
			
			// Precarga de datos necesarios
			
			// Verificamos si existe la tabla de usuarios 'users'
			$exists_users = $this->db->table_exists('users');
			
			if($exists_users){
				
				$usuario = $this->MUser->obtener();
				// Creamos el usuario admin si éste no existe
				if(count($usuario) == 0){
					
					$data_admin = array(
						'username' => 'admin@gmail.com',
						'name' => 'admin',
						'lastname' => 'admin',
						'profile_id' => 1,
						'admin' => 1,
						'password' => 'pbkdf2_sha256$12000$a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3',
						'status' => 1,
						'd_create' => date('Y-m-d H:i:s'),
						'd_update' => date('Y-m-d H:i:s')
					);
					
					$insert_admin = $this->MUser->insert($data_admin);
					
				}
				
			}
			
			// Verificamos si existe la tabla de perfiles 'profile'
			$exists_profile = $this->db->table_exists('profile');
			
			if($exists_profile){
			
				$perfil = $this->MPerfil->obtener();
				// Creamos el perfil ADMINISTRADOR si éste no existe
				if(count($perfil) == 0){
				
					$data_administrador = array(
						'name' => 'ADMINISTRADOR',
						'd_create' => date('Y-m-d H:i:s'),
						'd_update' => date('Y-m-d H:i:s')
					);
					
					$insert_administrador = $this->MPerfil->insert($data_administrador);
				
				}
			
			}
			
			// Verificamos si existe la tabla de acciones 'actions'
			$exists_actions = $this->db->table_exists('actions');
			
			if($exists_actions){
			
				$accion = $this->MAcciones->obtener();
				// Creamos la acción HOME si ésta no existe
				if(count($accion) == 0){
				
					// Importamos las acciones básicas
					$this->import_actions();
					
					// Asociamos la acción 1 (HOME) al perfil ADMINISTRADOR
					$data_assoc = array(
						'profile_id' => 1,
						'action_id' => 1,
						'parameter_permit' => '777',
						'd_create' => date('Y-m-d H:i:s'),
						'd_update' => date('Y-m-d H:i:s')
					);
					
					$insert_assoc = $this->MPerfil->insert_action($data_assoc);
					
					// Asociamos las acciones diferentes a 1 (HOME) al usuario 1 (admin@gmail.com).
					// Primero verificamos si existe la tabla 'permissions'
					$exists_permissions = $this->db->table_exists('permissions');
					
					if($exists_permissions){
						
						// Listamos las acciones
						$acciones = $this->MAcciones->obtener();
						
						if(count($acciones) > 0){
							
							foreach($acciones as $accion){
								
								if($accion->id != 1){
									
									$data_assoc2 = array(
										'user_id' => 1,
										'action_id' => $accion->id,
										'parameter_permit' => '777',
										'd_create' => date('Y-m-d H:i:s'),
										'd_update' => date('Y-m-d H:i:s')
									);
							
									$insert_assoc2 = $this->MUser->insert_action($data_assoc2);
									
								}
								
							}
							
						}
						
					}
				
				}
			
			}
			
			// Verificamos si existe la tabla de menús 'menus'
			$exists_menus = $this->db->table_exists('menus');
			
			if($exists_menus){
			
				$menu = $this->MMenus->obtener();
				// Creamos los menús básicos si éstos no existen
				if(count($menu) == 0){
					
					// Importamos los menús básicos
					$this->import_menus();
				
				}
			
			}
			
			// Verificamos si existe la tabla de submenús 'submenus'
			$exists_submenus = $this->db->table_exists('submenus');
			
			if($exists_submenus){
			
				$submenu = $this->MSubMenus->obtener();
				// Creamos los submenús básicos si éstos no existen
				if(count($submenu) == 0){
					
					// Importamos los submenús básicos
					$this->import_submenus();
				
				}
			
			}
			
			// Verificamos si existe la tabla de íconos 'icons'
			$exists_icons = $this->db->table_exists('icons');
			
			if($exists_icons){
			
				$icono = $this->MMenus->search_icons();
				// Creamos los íconos básicos si éstos no existen
				if($icono == 0){
					
					// Importamos los íconos básicos
					$this->import_icons();
				
				}
			
			}
			
			// Verificamos si existe la tabla de grupos de bandejas 'grupos_bandejas'
			$exists_groups = $this->db->table_exists('grupos_bandejas');
			
			if($exists_groups){
			
				$group = $this->MGruposBandejas->obtener();
				// Creamos los grupos básicos si éstos no existen ('Político' y 'Asistencial')
				if(count($group) == 0){
					
					// Importamos los grupos básicos
					$this->import_grupos();
				
				}
			
			}
		
		}
		
	}
	
	// Método que importa las acciones básicas desde un csv
    public function import_actions() {
        
        $ruta = getcwd();  // Obtiene el directorio actual en donde se está trabajando
        
        $fp = fopen ($ruta."/application/migrations/actions.csv","r");
        
        while ($data = fgetcsv ($fp, 1000, ",")) {
			
			$data_accion2 = array(
				'name' => $data[1],
				'class' => $data[2],
				'route' => $data[3],
				'assigned' => $data[4],
				'd_create' => date('Y-m-d H:i:s'),
				'd_update' => date('Y-m-d H:i:s')
			);
			
			$insert_accion = $this->MAcciones->insert($data_accion2);
			
		}
		
		fclose ($fp);
        
    }
    
    // Método que importa los menús básicos desde un csv
    public function import_menus() {
        
        $ruta = getcwd();  // Obtiene el directorio actual en donde se está trabajando
        
        $fp = fopen ($ruta."/application/migrations/menus.csv","r");
        
        while ($data = fgetcsv ($fp, 1000, ",")) {
			
			$data_menu = array(
				'name' => $data[1],
				'description' => $data[2],
				'logo' => $data[3],
				'route' => $data[4],
				'action_id' => $data[5],
				'd_create' => date('Y-m-d H:i:s'),
				'd_update' => date('Y-m-d H:i:s')
			);
			
			$insert_menu = $this->MMenus->insert($data_menu);
			
		}
		
		fclose ($fp);
        
    }
    
    // Método que importa los submenús básicos desde un csv
    public function import_submenus() {
        
        $ruta = getcwd();  // Obtiene el directorio actual en donde se está trabajando
        
        $fp = fopen ($ruta."/application/migrations/submenus.csv","r");
        
        while ($data = fgetcsv ($fp, 1000, ",")) {
			
			$data_submenu = array(
				'name' => $data[1],
				'description' => $data[2],
				'logo' => $data[3],
				'route' => $data[4],
				'menu_id' => $data[5],
				'action_id' => $data[6],
				'd_create' => date('Y-m-d H:i:s'),
				'd_update' => date('Y-m-d H:i:s')
			);
			
			$insert_submenu = $this->MSubMenus->insert($data_submenu);
			
		}
		
		fclose ($fp);
        
    }
    
    // Método que importa los iconos desde un csv
    public function import_icons() {
        
        $ruta = getcwd();  // Obtiene el directorio actual en donde se está trabajando
        
        $fp = fopen ($ruta."/application/migrations/icons.csv","r");
        
        while ($data = fgetcsv ($fp, 1000, ",")) {
			
			$data_icon = array(
				'class' => $data[1],
				'name' => $data[2],
				'category' => $data[3],
				'd_create' => date('Y-m-d H:i:s'),
				'd_update' => date('Y-m-d H:i:s')
			);
			
			$insert_icon = $this->MMenus->insert_icons($data_icon);
			
		}
		
		fclose ($fp);
        
    }
    
    // Método que importa los grupos de bandejas desde un csv
    public function import_grupos() {
        
        $ruta = getcwd();  // Obtiene el directorio actual en donde se está trabajando
        
        $fp = fopen ($ruta."/application/migrations/grupos_bandejas.csv","r");
        
        while ($data = fgetcsv ($fp, 1000, ",")) {
			
			$data_group = array(
				'nombre' => $data[1],
				'status' => $data[2],
				'd_create' => date('Y-m-d H:i:s'),
				'd_update' => date('Y-m-d H:i:s')
			);
			
			$insert_group = $this->MGruposBandejas->insert($data_group);
			
		}
		
		fclose ($fp);
        
    }

}
