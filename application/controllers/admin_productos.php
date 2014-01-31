<?php
class Admin_productos extends CI_Controller {

    private $uploadConfig;
    private $imgLibConfig;

    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    const VIEW_FOLDER = 'admin/productos';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->model('categorias_productos_model');

        // Helpers
        $this->load->helper('file');

        // Manejo de uploads
        $this->uploadConfig = array();
        $this->uploadConfig['upload_path'] = './uploads/productos/';
        $this->uploadConfig['overwrite'] = true;
        $this->load->library('upload');

        // Manejo de imagenes
        $this->imgLibConfig = array();
        $this->imgLibConfig['image_library'] = 'gd2';
        $this->imgLibConfig['create_thumb'] = TRUE;
        $this->imgLibConfig['maintain_ratio'] = FALSE;
        $this->imgLibConfig['quality'] = PRODUCTO_IMAGE_QUALITY;
        $this->load->library('image_lib');

        if(!$this->session->userdata('is_logged_in')){
            redirect('admin/login');
        }
    }
 
    /**
    * Load the main view with all the current model model's data.
    * @return void
    */
    public function index()
    {

        //all the posts sent by the view
        $search_string = $this->input->post('search_string');        
        $order = $this->input->post('order'); 
        $order_type = $this->input->post('order_type'); 

        //pagination settings
        $config['per_page'] = 10;

        $data['thumbnailWidth'] = PRODUCTO_THUMB_WIDTH;
        $data['thumbnailHeight'] = PRODUCTO_THUMB_HEIGHT;
        $data['thumbMarker'] = PRODUCTO_IMAGE_THUMB_MARKER;

        $config['base_url'] = base_url().'admin/productos';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 20;
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        //limit end
        $page = $this->uri->segment(3);

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];
        if ($limit_end < 0){
            $limit_end = 0;
        } 

        //if order type was changed
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session? 
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');    
            }else{
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';    
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;        


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated
        if($search_string !== false && $order !== false || $this->uri->segment(3) == true){ 
           
            /*
            The comments here are the same for line 79 until 99

            if post is not null, we store it in session data array
            if is null, we use the session data already stored
            we save order into the the var to load the view with the param already selected       
            */
            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;
            }else{
                $search_string = $this->session->userdata('search_string_selected');
            }
            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            if(isset($filter_session_data)){
              $this->session->set_userdata($filter_session_data);    
            }
            
            //fetch sql data into arrays
            $data['count_productos']= $this->productos_model->count_productos($search_string, $order);
            $config['total_rows'] = $data['count_productos'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['productos'] = $this->productos_model->get_productos($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['productos'] = $this->productos_model->get_productos($search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['productos'] = $this->productos_model->get_productos('', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['productos'] = $this->productos_model->get_productos('', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['producto_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_productos']= $this->productos_model->count_productos();
            $data['productos'] = $this->productos_model->get_productos('', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_productos'];

        }//!isset($search_string) && !isset($order)
         
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/productos/list';
        $this->load->view('includes/template', $data);  

    }//index

    private function abm_set_rules()
    {
        $this->form_validation->set_rules('nombre_esp', 'Nombre', 'required');
        $this->form_validation->set_rules('id_categoria_producto', 'Categoría', 'required');
        $this->form_validation->set_rules('porcentaje_en_peso', '% en peso', 'required');
        $this->form_validation->set_rules('gramos_por_litro', 'g/L', 'required');
    }

    private function get_data_to_store(){
        
        $data_to_store = array(
            'nombre_esp' => $this->input->post('nombre_esp'),
            'nombre_eng' => $this->input->post('nombre_eng'),
            'id_categoria_producto' => $this->input->post('id_categoria_producto'),
            'formulacion_esp' => $this->input->post('formulacion_esp'),
            'formulacion_eng' => $this->input->post('formulacion_eng'),
            'principio_activo_esp' => $this->input->post('principio_activo_esp'),
            'principio_activo_eng' => $this->input->post('principio_activo_eng'),
            'porcentaje_en_peso' => $this->input->post('porcentaje_en_peso'),
            'gramos_por_litro' => $this->input->post('gramos_por_litro'),
            'instrucciones_esp' => $this->input->post('instrucciones_esp'),
            'instrucciones_eng' => $this->input->post('instrucciones_eng'),
            'momento_aplicacion_esp' => $this->input->post('momento_aplicacion_esp'),
            'momento_aplicacion_eng' => $this->input->post('momento_aplicacion_eng'),
            'frecuencia_aplicacion_esp' => $this->input->post('frecuencia_aplicacion_esp'),
            'frecuencia_aplicacion_eng' => $this->input->post('frecuencia_aplicacion_eng'),
            'comp_fito_esp' => $this->input->post('comp_fito_esp'),
            'comp_fito_eng' => $this->input->post('comp_fito_eng'),
            'modo_preparacion_esp' => $this->input->post('modo_preparacion_esp'),
            'modo_preparacion_eng' => $this->input->post('modo_preparacion_eng'),
            'clase_toxicologica_esp' => $this->input->post('clase_toxicologica_esp'),
            'clase_toxicologica_eng' => $this->input->post('clase_toxicologica_eng'),
            'antidoto_esp' => $this->input->post('antidoto_esp'),
            'antidoto_eng' => $this->input->post('antidoto_eng'),
            'primeros_auxilios_esp' => $this->input->post('primeros_auxilios_esp'),
            'primeros_auxilios_eng' => $this->input->post('primeros_auxilios_eng'),
            'generalidades_esp' => $this->input->post('generalidades_esp'),
            'generalidades_eng' => $this->input->post('generalidades_eng')
        );

        return $data_to_store;
    }

    public function add()
    {
        $idCategoria = "";
        $datosProducto = array();
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->abm_set_rules();
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            $data_to_store = $this->get_data_to_store();
            $datosProducto = $data_to_store;

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $data_to_store = $this->get_data_to_store();
                $idCategoria = $this->input->post('id_categoria_producto');
                
                // Inicio transaccion
                $this->productos_model->start_transaction();
                // Salvo el producto
                $idProducto = $this->productos_model->store_producto($data_to_store);

                if(is_numeric($idProducto)){
                    $nomEsp = $this->input->post('nombre_esp');
                    $nomEng = $this->input->post('nombre_eng');
                    $catEsp = $this->categorias_productos_model->get_nombre($idCategoria, 'esp');
                    $catEng = $this->categorias_productos_model->get_nombre($idCategoria, 'eng');
                    $fichaEsp = url_title("$idProducto $catEsp $nomEsp", '-', true);
                    $fichaEng = url_title("$idProducto $catEng $nomEng", '-', true);
                    $data_to_store = array(
                        'ficha_esp' => $fichaEsp,
                        'ficha_eng' => $fichaEng
                    );                    
                    $data['flash_message'] = $this->productos_model->update_producto($idProducto, $data_to_store); 
                    $this->manejarUploads($idProducto);
                }
                
                // Completo transaccion
                $this->productos_model->complete_transaction();
                $datosProducto = array();
            }
        }

        $optionsCategorias = array();
        $categoriasRows = $this->obtenerCategorias();
        
        foreach ($categoriasRows as $row) {
            $optionsCategorias[$row["id_categoria_producto"]] = $row["nombre_esp"];
        }

        $data['producto'] = $datosProducto;
        $data["opts_categorias"] = $optionsCategorias;
        $data["id_categoria"] = $idCategoria;
        $data['main_content'] = 'admin/productos/add';
        
        //load the view 
        $this->load->view('includes/template', $data);  
    }       

    /**
    * Update item by his id
    * @return void
    */
    public function update()
    {
        $id = $this->uri->segment(4);
        $idCategoria = "";
        $datosProducto = array();
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->abm_set_rules();
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            $data_to_store = $this->get_data_to_store();
            $datosProducto = $data_to_store;

            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $idCategoria = $this->input->post('id_categoria_producto');
                
                // Inicio transaccion
                $this->productos_model->start_transaction();
                $nomEsp = $this->input->post('nombre_esp');
                $nomEng = $this->input->post('nombre_eng');
                $catEsp = $this->categorias_productos_model->get_nombre($idCategoria, 'esp');
                $catEng = $this->categorias_productos_model->get_nombre($idCategoria, 'eng');
                $data_to_store['ficha_esp'] = url_title("$id $catEsp $nomEsp", '-', true);
                $data_to_store['ficha_eng'] = url_title("$id $catEng $nomEng", '-', true);

                //if the insert has returned true then we show the flash message
                if($this->productos_model->update_producto($id, $data_to_store) == TRUE){
                    
                    $this->manejarUploads($id);
                    $data['flash_message'] = TRUE; 
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }

                // Completo transaccion
                $this->productos_model->complete_transaction();
                redirect('admin/productos/update/' . $id);

            }//validation run
        }
        else {
            $datosProducto = $this->productos_model->get_producto_by_id($id);
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['producto'] = $datosProducto;
        $data['previewWidth'] = PRODUCTO_PREVIEW_WIDTH;
        $data['previewHeight'] = PRODUCTO_PREVIEW_HEIGHT;
        $data['previewMarker'] = PRODUCTO_IMAGE_PREVIEW_MARKER;
        
        $optionsCategorias = array();
        $categoriasRows = $this->obtenerCategorias();
        
        foreach ($categoriasRows as $row) {
            $optionsCategorias[$row["id_categoria_producto"]] = $row["nombre_esp"];
        }

        $data["opts_categorias"] = $optionsCategorias;
        $data["id_categoria"] = $idCategoria;
        //load the view
        $data['main_content'] = 'admin/productos/edit';
        $this->load->view('includes/template', $data);

    }//update

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->productos_model->delete_producto($id);

        // Borro las imagenes del filesystem
        @unlink($this->uploadConfig['upload_path'] . $id . ".jpg");
        @unlink($this->uploadConfig['upload_path'] . $id . PRODUCTO_IMAGE_PREVIEW_MARKER . ".jpg");
        @unlink($this->uploadConfig['upload_path'] . $id . PRODUCTO_IMAGE_THUMB_MARKER . ".jpg");
        @unlink($this->uploadConfig['upload_path'] . $id . "-esp.pdf");
        @unlink($this->uploadConfig['upload_path'] . $id . "-eng.pdf");

        redirect('admin/productos');
    }

    private function manejarUploads($id){
        // Upload de la foto
        $this->uploadConfig['allowed_types'] = "jpg";
        $this->uploadConfig['file_name'] = $id;
        $this->upload->initialize($this->uploadConfig);
        if($this->upload->do_upload('imagen')){
            $upload_data = $this->upload->data();

            // Salvo imagen preview
            $this->imgLibConfig['source_image'] = $upload_data['full_path'];
            $this->imgLibConfig['thumb_marker'] = PRODUCTO_IMAGE_PREVIEW_MARKER;
            $this->imgLibConfig['new_image'] = $upload_data['full_path'];
            $this->imgLibConfig['width'] = PRODUCTO_PREVIEW_WIDTH;
            $this->imgLibConfig['height'] = PRODUCTO_PREVIEW_HEIGHT;
            $this->image_lib->initialize($this->imgLibConfig); 
            if(!$this->image_lib->resize())
            {
                $data['error'] = $this->image_lib->display_errors() . "<br>";
                log_message('error', "(1) " . $this->image_lib->display_errors());
                $this->session->set_flashdata('flash_message', 'not_updated');
            } else {
                // Salvo imagen thumbnail
                $this->imgLibConfig['thumb_marker'] = PRODUCTO_IMAGE_THUMB_MARKER;
                $this->imgLibConfig['width'] = PRODUCTO_THUMB_WIDTH;
                $this->imgLibConfig['height'] = PRODUCTO_THUMB_HEIGHT;
                $this->image_lib->clear();
                $this->image_lib->initialize($this->imgLibConfig); 
                if(! $this->image_lib->resize())
                {
                    $data['error'] .= $this->image_lib->display_errors() . "<br>";
                    $this->session->set_flashdata('flash_message', 'not_updated');
                    log_message('error', "(2) " . $this->image_lib->display_errors());
                }
            }
        }

        // Upload de las fichas de seguridad 
        $this->uploadConfig['allowed_types'] = "pdf";
        $this->uploadConfig['file_name'] = $id . "-esp";
        $this->upload->initialize($this->uploadConfig);
        $this->upload->do_upload('ficha_seguridad_esp');

        $this->uploadConfig['file_name'] = $id . "-eng";
        $this->upload->initialize($this->uploadConfig);
        $this->upload->do_upload('ficha_seguridad_eng');
    }

    private function obtenerCategorias(){
        return $this->categorias_productos_model->get_categorias_productos(null, 'nombre_esp');
    }

}