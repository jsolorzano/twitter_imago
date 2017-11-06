<?php
//~ defined('BASEPATH') OR exit('No direct script access allowed');

Class CLogin extends CI_Controller {

    public function __construct() {
        @parent::__construct();

// Load database
        $this->load->model('MLogin');
        //~ $this->load->model('auditoria/ModelsAuditoria');
        //~ $this->load->model('busquedas_ajax/ModelsBusqueda');
    }

	// Show login page
    public function login() {
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

}
