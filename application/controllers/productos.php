<?php

include_once('public_controller.php');

class Productos extends PublicController {

	/**
    * Responsable for auto load the mode
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->model('categorias_productos_model');
    }

    public function index($idioma="esp"){
    	$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarDatosComunes($data);
		$this->cargarArchivosIdiomas();
		$this->cargarClassesMenuHorizontal($data);

		$categorias = $this->categorias_productos_model->obtener_categorias($idioma);
		$data['categorias'] = $categorias;
		$data['prvW'] = CATEGORIA_PRODUCTO_PREVIEW_WIDTH;
		$data['prvH'] = CATEGORIA_PRODUCTO_PREVIEW_HEIGHT;
		$data['main_content'] = 'publico/productos';
		$data['bot_productos_class'] = 'bot_productos_activo';

		//load the view
        $this->load->view('publico/template', $data);
    }

    public function categoria($ficha, $idioma="esp"){
    	$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarDatosComunes($data);
		$this->cargarArchivosIdiomas();
		$this->cargarClassesMenuHorizontal($data);

		// Obtengo los datos
		$categoria = $this->categorias_productos_model->obtener_por_ficha($ficha, $idioma);
		if($categoria){
			$data['nombreCategoria'] = $categoria['nombre'];
			$data['idCategoria'] = $categoria['id_categoria_producto'];
			$productos = $this->productos_model->productos_por_categoria($categoria['id_categoria_producto'], $idioma);
			$data['productos'] = $productos;
		}
		
		$data['catPrvW'] = CATEGORIA_PRODUCTO_PREVIEW_WIDTH;
		$data['catPrvH'] = CATEGORIA_PRODUCTO_PREVIEW_HEIGHT;
		$data['prvW'] = PRODUCTO_PREVIEW_WIDTH;
		$data['prvH'] = PRODUCTO_PREVIEW_HEIGHT;
		$data['main_content'] = 'publico/categoria_productos';
		$data['bot_productos_class'] = 'bot_productos_activo';

		//load the view
        $this->load->view('publico/template', $data);
    }

    public function detalle($ficha, $idioma="esp"){
		$data['idioma'] = $idioma;
		$this->idioma = $idioma;
		$this->cargarDatosComunes($data);
		$this->cargarArchivosIdiomas();
		$this->cargarClassesMenuHorizontal($data);

		$data['previewWidth'] = PRODUCTO_PREVIEW_WIDTH;
		$data['previewHeight'] = PRODUCTO_PREVIEW_HEIGHT;
		$data['producto'] = $this->productos_model->obtener_por_ficha($ficha, $this->idioma);
		$data['main_content'] = 'publico/detalle_producto';
		$data['bot_productos_class'] = 'bot_productos_activo';
		
		//load the view
        $this->load->view('publico/template', $data);
	}

}