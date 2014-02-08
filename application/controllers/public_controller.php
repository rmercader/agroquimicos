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

    protected function etiquetasMenu($idioma){
        $this->lang->load('menu', $idioma);
        return array(
            'menu_inicio' => $this->lang->line('menu_inicio'),
            'menu_empresa' => $this->lang->line('menu_empresa'),
            'menu_productos' => $this->lang->line('menu_productos'),
            'menu_servicios' => $this->lang->line('menu_servicios'),
            'menu_novedades' => $this->lang->line('menu_novedades'),
            'menu_contacto' => $this->lang->line('menu_contacto')
        );
    }

    protected function etiquetasUris($idioma){
        $this->lang->load('uri', $idioma);
        return array(
            'uri_quines_somos' => $this->lang->line('uri_quines_somos'),
            'uri_mision_y_vision' => $this->lang->line('uri_mision_y_vision'),
            'uri_politica_ambiental' => $this->lang->line('uri_politica_ambiental'),
            'uri_politica_calidad' => $this->lang->line('uri_politica_calidad'),
            'uri_politica_seguridad' => $this->lang->line('uri_politica_seguridad'),
            'uri_planta_industrial' => $this->lang->line('uri_planta_industrial'),
            'uri_contacto' => $this->lang->line('uri_contacto')
        );
    }
}