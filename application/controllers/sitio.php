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

	public function index($idioma="esp"){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarDatosComunes($data);
		$this->cargarArchivosIdiomas();
		$this->cargarClassesMenuHorizontal($data);

		$data['previewWidth'] = NOVEDAD_PREVIEW_WIDTH;
		$data['previewHeight'] = NOVEDAD_PREVIEW_HEIGHT;
		$data['novedades'] = $this->novedades_model->obtener_visibles_ordenadas(0, $this->idioma);
		$data['main_content'] = 'publico/index';
		$data['bot_inicio_class'] = 'bot_inicio_activo';
		
		//load the view
        $this->load->view('publico/template', $data);
	}

	public function quienes_somos($idioma){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarArchivosIdiomas();
		$this->cargarDatosComunes($data);
		$this->cargarClassesMenuHorizontal($data);

		$data['main_content'] = 'publico/index';
		$data['bot_empresa_class'] = 'bot_empresa_activo';

		//load the view
        $this->load->view('publico/template', $data);
	}

	public function mision_y_vision($idioma){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarArchivosIdiomas();
		$this->cargarDatosComunes($data);
		$this->cargarClassesMenuHorizontal($data);

		$data['main_content'] = 'publico/index';
		$data['bot_empresa_class'] = 'bot_empresa_activo';

		//load the view
        $this->load->view('publico/template', $data);
	}

	public function politica_ambiental($idioma){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarArchivosIdiomas();
		$this->cargarDatosComunes($data);
		$this->cargarClassesMenuHorizontal($data);

		$data['main_content'] = 'publico/index';
		$data['bot_empresa_class'] = 'bot_empresa_activo';

		//load the view
        $this->load->view('publico/template', $data);
	}

	public function politica_calidad($idioma){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarArchivosIdiomas();
		$this->cargarDatosComunes($data);
		$this->cargarClassesMenuHorizontal($data);
		
		$data['main_content'] = 'publico/index';
		$data['bot_empresa_class'] = 'bot_empresa_activo';

		//load the view
        $this->load->view('publico/template', $data);
	}

	public function politica_seguridad($idioma){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarArchivosIdiomas();
		$this->cargarDatosComunes($data);
		$this->cargarClassesMenuHorizontal($data);
		
		$data['main_content'] = 'publico/index';
		$data['bot_empresa_class'] = 'bot_empresa_activo';

		//load the view
        $this->load->view('publico/template', $data);
	}

	public function planta_industrial($idioma){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarArchivosIdiomas();
		$this->cargarDatosComunes($data);
		$this->cargarClassesMenuHorizontal($data);
		
		$data['main_content'] = 'publico/index';
		$data['bot_empresa_class'] = 'bot_empresa_activo';

		//load the view
        $this->load->view('publico/template', $data);
	}

	public function contacto($idioma){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarArchivosIdiomas();
		$this->cargarClassesMenuHorizontal($data);

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

		$data['main_content'] = 'publico/contacto';
		$data['bot_empresa_class'] = 'bot_empresa_activo';

		//load the view
        $this->load->view('publico/template', $data);
	}

}