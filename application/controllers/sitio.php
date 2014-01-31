<?php

include_once('public_controller.php');

class Sitio extends PublicController {

	/**
    * Responsable for auto load the mode
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mensajes_model');

        // Libraries
		$this->load->library('email');

		// Helpers
		$this->load->helper('email');
    }

    private function cargarDatosComunes(&$data){
    	$data['categorias_menu'] = $this->categoriasMenu();
		$data['novedades_menu'] = $this->novedadesMenu();
    }

	public function index(){
		
		$data['previewWidth'] = PRODUCTO_PREVIEW_WIDTH;
		$data['previewHeight'] = PRODUCTO_PREVIEW_HEIGHT;
		$data['novedades'] = $this->novedades_model->obtener_visibles_ordenadas(0, $this->idioma);
		$this->cargarDatosComunes($data);
		$data['main_content'] = 'publico/index';
		
		//load the view
        $this->load->view('publico/template', $data);
	}

	public function quienes_somos($idioma){
		$data['idioma'] = $idioma;
		$this->cargarDatosComunes($data);
		$data['main_content'] = 'publico/index';

		//load the view
        $this->load->view('publico/template', $data);
	}

	public function mision_y_vision(){
		//load the view
		$data['main_content'] = 'publico/index';
		$this->cargarDatosComunes($data);
        $this->load->view('publico/template', $data);
	}

	public function politica_ambiental(){
		//load the view
		$data['main_content'] = 'publico/index';
		$this->cargarDatosComunes($data);
        $this->load->view('publico/template', $data);
	}

	public function politica_calidad(){
		//load the view
		$data['main_content'] = 'publico/index';
		$this->cargarDatosComunes($data);
        $this->load->view('publico/template', $data);
	}

	public function politica_seguridad(){
		//load the view
		$data['main_content'] = 'publico/index';
		$this->cargarDatosComunes($data);
        $this->load->view('publico/template', $data);
	}

	public function planta_industrial(){
		//load the view
		$data['main_content'] = 'publico/index';
		$this->cargarDatosComunes($data);
        $this->load->view('publico/template', $data);
	}

	public function contacto(){
		$error = "";
		$nombre = "";
		$email = "";
		$consulta = "";

		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$nombre = trim($this->input->post('nombre'));
			$email = trim($this->input->post('email'));
			$consulta = trim($this->input->post('mensaje'));
			$mensaje = array(
				'nombre'=>$nombre,
				'email'=>$email,
				'mensaje'=>$consulta,
				'fecha'=>date("Y-m-d H:i:00")
			);

			if($nombre == "" || $consulta == "" || $email == ""){
				$error .= "Todos los campos son requeridos.";
			} else if ($email != "" && !valid_email($email)){
				$error .= "Ingrese una dirección de email válida.";
			} else {
				$idMensaje = $this->mensajes_model->store_mensaje($mensaje);
				if($idMensaje){
					$nombre = "";
					$email = "";
					$consulta = "";
					/*
					// Notifico con email
					$dataMail = $mensaje;
					$mensajeMail = $this->load->view('publico/mensaje-detalle-mail', $dataMail, true);
					$this->email->initialize(array("mailtype"=>"html"));
					$this->email->from('noreply@dianasaravia.com.uy', 'Diana Saravia - Sitio Galeria');
					$this->email->to('arte@dianasaravia.com.uy');
					$this->email->bcc('rodrigomercader@gmail.com'); 
					$this->email->subject("Nueva consulta desde el sitio web de la galeria (Id: {$idMensaje})");
					$this->email->message($mensajeMail);
					$this->email->send();*/
					
					$error = "Tu consulta fue recibida correctamente. Nos comunicaremos contigo a la brevedad. Muchas gracias.";
				}
			}
		}

		$data["nombre"] = $nombre;
		$data["email"] = $email;
		$data["mensaje"] = $consulta;
		$data["error"] = $error;

		//load the view
		$data['main_content'] = 'publico/contacto';
        $this->load->view('publico/template', $data);
	}

}