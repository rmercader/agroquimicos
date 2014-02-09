<?php

include_once('public_controller.php');

class Novedades extends PublicController {

	/**
    * Responsable for auto load the mode
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('novedades_model');
    }

    public function detalle($ficha, $idioma="esp"){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarDatosComunes($data);
		$this->cargarArchivosIdiomas();
		$this->cargarClassesMenuHorizontal($data);

		$data['previewWidth'] = NOVEDAD_PREVIEW_WIDTH;
		$data['previewHeight'] = NOVEDAD_PREVIEW_HEIGHT;
		$data['novedad'] = $this->novedades_model->obtener_por_ficha($ficha, $this->idioma);
		$data['main_content'] = 'publico/detalle_novedad';
		$data['bot_nov_class'] = 'bot_nov_activo';
		
		//load the view
        $this->load->view('publico/template', $data);
	}

}