<?php

class PublicController extends CI_Controller {

	protected $idioma = "esp";

	public function __construct()
    {
        parent::__construct();

        // Models
        $this->load->model('categorias_productos_model');
        $this->load->model('novedades_model');
    }

    protected function novedadesMenu(){
    	$novedades = $this->novedades_model->obtener_visibles_ordenadas(10, $this->idioma);
    	return $novedades;
    }

    protected function categoriasMenu(){
    	$novedades = $this->categorias_productos_model->obtener_categorias($this->idioma);
    	return $novedades;
    }
}