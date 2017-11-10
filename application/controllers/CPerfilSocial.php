<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CPerfilSocial extends CI_Controller {

	public function __construct() {
        parent::__construct();


       
		// Load database
        $this->load->model('MPerfilSocial');
		
    }
	
	public function index()
	{
		$this->load->view('base');
		$data['listar'] = $this->MPerfilSocial->obtener();
		$this->load->view('perfiles_sociales/lista', $data);
		$this->load->view('footer');
	}
	
	public function register()
	{
		$this->load->view('base');
		$this->load->view('perfiles_sociales/registrar');
		$this->load->view('footer');
	}
	
	// Método para guardar un nuevo registro
    public function add() {
		
		$datos = array(
            'cedula' => $this->input->post('cedula'),
            'genero' => $this->input->post('genero'),
            'nombre' => $this->input->post('nombre'),
            'apellido' => $this->input->post('apellido'),
            'fecha_nac' => $this->input->post('fecha_nac'),
            'direccion_nac' => $this->input->post('direccion_nac'),
            'direccion_viv' => $this->input->post('direccion_viv'),
            'telefono' => $this->input->post('telefono'),
            'celular' => $this->input->post('celular'),
            'correo' => $this->input->post('correo'),
            'centro_votacion' => $this->input->post('centro_votacion'),
            'direccion_centro_votacion' => $this->input->post('direccion_centro_votacion'),
            'facebook' => $this->input->post('facebook')
        );
        
        $result = $this->MPerfilSocial->insert($datos);
        
        echo $result;  // No comentar, esta impresión es necesaria para que se ejecute el método insert()
        
        if ($result != 'existe') {

			// Registramos la asociación del perfil con la cuenta de twitter
			$data_asoc = array(
				'perfil_id' => $result,
				'twitter_id' => $this->input->post('id_twitter'),
				'd_create' => date('Y-m-d')
			);
			
			$insert_asoc = $this->MPerfilSocial->insert_asoc($data_asoc);
       
        }
        
    }
	
	// Método para editar
    public function ver() {
		
		$this->load->view('base');
        $data['id_perfil'] = $this->input->get('id_perfil');
        $data['id_twitter'] = $this->input->get('id_twitter');
        $data['ver'] = $this->MPerfilSocial->obtenerPerfil($data['id_perfil']);
        $this->load->view('perfiles_sociales/ver', $data);
		$this->load->view('footer');
    }
	
	// Método para editar
    public function edit() {
		
		$this->load->view('base');
        $data['id'] = $this->input->get('id_perfil');
        $data['editar'] = $this->MPerfilSocial->obtenerPerfil($data['id']);
        $this->load->view('perfiles_sociales/editar', $data);
		$this->load->view('footer');
    }
	
	// Método para actualizar
    public function update() {
		if($_FILES['icon']['name'] != ''){
			$datos = array(
				'id' => $_POST['id'],
				'name' => $_POST['name'],
				'description' => $_POST['description'],
				'icon' => $_FILES['icon']['name'],
				'price' => $_POST['price'],
				'status' => $_POST['status'],
			);
		}else{
			$datos = array(
				'id' => $_POST['id'],
				'name' => $_POST['name'],
				'description' => $_POST['description'],
				'price' => $_POST['price'],
				'status' => $_POST['status'],
			);
		}
        $result = $this->MPerfilSocial->update($datos);
        if ($result) {
			// Sección para el registro del archivo en la ruta establecida para tal fin (assets/public/img/demos/medical)
			$ruta = getcwd();  // Obtiene el directorio actual en donde se esta trabajando
			if($_FILES['icon']['name'] != ''){
				if (move_uploaded_file($_FILES['icon']['tmp_name'], $ruta."/assets/public/img/demos/medical/".$_FILES['icon']['name'])) {
					echo "El fichero es válido y se subió con éxito.\n";
				} else {
					echo "¡Posible ataque de subida de ficheros!\n";
				}
			}     
        }
    }
    
	// Método para eliminar
	function delete($id) {
		
        $result = $this->MPerfilSocial->delete($id);
        if ($result) {
          /*  $this->libreria->generateActivity('Eliminado País', $this->session->userdata['logged_in']['id']);*/
        }
    }
	
	public function ajax_service()
    {                                          #Campo         #Tabla                #ID
        $result = $this->MPerfilSocial->obtener();
        echo json_encode($result);
    }
	
	
}
