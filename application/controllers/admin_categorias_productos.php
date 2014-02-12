<?php
class Admin_categorias_productos extends CI_Controller {

    private $uploadConfig;
    private $imgLibConfig;

    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    const VIEW_FOLDER = 'admin/categorias_productos';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('categorias_productos_model');

        // Helpers
        $this->load->helper('file');

        // Manejo de uploads
        $this->uploadConfig = array();
        $this->uploadConfig['upload_path'] = './uploads/categorias-productos/';
        $this->uploadConfig['allowed_types'] = 'jpg';
        $this->uploadConfig['overwrite'] = true;
        $this->load->library('upload');

        // Manejo de imagenes
        $this->imgLibConfig = array();
        $this->imgLibConfig['image_library'] = 'gd2';
        $this->imgLibConfig['create_thumb'] = TRUE;
        $this->imgLibConfig['maintain_ratio'] = FALSE;
        $this->imgLibConfig['quality'] = CATEGORIA_PRODUCTO_IMAGE_QUALITY;
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

        $data['thumbnailWidth'] = CATEGORIA_PRODUCTO_THUMB_WIDTH;
        $data['thumbnailHeight'] = CATEGORIA_PRODUCTO_THUMB_HEIGHT;
        $data['thumbMarker'] = CATEGORIA_PRODUCTO_IMAGE_THUMB_MARKER;

        $config['base_url'] = base_url().'admin/categorias_productos';
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
            $data['count_products']= $this->categorias_productos_model->count_categorias_productos($search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['categorias_productos'] = $this->categorias_productos_model->get_categorias_productos($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['categorias_productos'] = $this->categorias_productos_model->get_categorias_productos($search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['categorias_productos'] = $this->categorias_productos_model->get_categorias_productos('', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['categorias_productos'] = $this->categorias_productos_model->get_categorias_productos('', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['categoria_producto_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_categorias_productos']= $this->categorias_productos_model->count_categorias_productos();
            $data['categorias_productos'] = $this->categorias_productos_model->get_categorias_productos('', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_categorias_productos'];

        }//!isset($search_string) && !isset($order)
         
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/categorias_productos/list';
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('nombre_esp', 'Nombre', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $nomEsp = $this->input->post('nombre_esp');
                $nomEng = $this->input->post('nombre_eng');
                if(trim($nomEng) == ''){
                    $nomEng = $nomEsp;
                }
                $data_to_store = array(
                    'nombre_esp' => $nomEsp,
                    'nombre_eng' => $nomEng,
                );
                
                // Salvo la categoria
                $idCategoria = $this->categorias_productos_model->store_categoria_producto($data_to_store);

                if(is_numeric($idCategoria)){
                    $data_to_store = array(
                        'ficha_esp' => url_title("$idCategoria $nomEsp", '-', true),
                        'ficha_eng' => url_title("$idCategoria $nomEng", '-', true)
                    );                    
                    $data['flash_message'] = $this->categorias_productos_model->update_categoria_producto($idCategoria, $data_to_store); 
                    $this->manejarUploads($idCategoria); 
                }else{
                    $data['flash_message'] = FALSE; 
                }

            }

        }

        //load the view
        $data['main_content'] = 'admin/categorias_productos/add';
        $this->load->view('includes/template', $data);  
    }       

    /**
    * Update item by his id
    * @return void
    */
    public function update()
    {
        $id = $this->uri->segment(4);
  
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('nombre_esp', 'Nombre', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $nomEsp = $this->input->post('nombre_esp');
                $nomEng = $this->input->post('nombre_eng');
                if(trim($nomEng) == ''){
                    $nomEng = $nomEsp;
                }
                $data_to_store = array(
                    'nombre_esp' => $nomEsp,
                    'nombre_eng' => $nomEng,
                );
                //if the insert has returned true then we show the flash message
                if($this->categorias_productos_model->update_categoria_producto($id, $data_to_store) == TRUE){
                    $data_to_store = array(
                        'ficha_esp' => url_title("$id $nomEsp", '-', true),
                        'ficha_eng' => url_title("$id $nomEng", '-', true)
                    );            

                    if($this->categorias_productos_model->update_categoria_producto($id, $data_to_store)){
                        $data['flash_message'] = TRUE; 
                        $this->manejarUploads($id);
                        $this->session->set_flashdata('flash_message', 'updated');
                    }
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }

                redirect('admin/categorias_productos/update/' . $id);

            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['categoria_producto'] = $this->categorias_productos_model->get_categoria_producto_by_id($id);
        $data['previewWidth'] = CATEGORIA_PRODUCTO_PREVIEW_WIDTH;
        $data['previewHeight'] = CATEGORIA_PRODUCTO_PREVIEW_HEIGHT;
        $data['previewMarker'] = CATEGORIA_PRODUCTO_IMAGE_PREVIEW_MARKER;
        
        //load the view
        $data['main_content'] = 'admin/categorias_productos/edit';
        $this->load->view('includes/template', $data);            

    }//update

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->categorias_productos_model->delete_categoria_producto($id);
        
        // Borro las imagenes del filesystem
        @unlink($this->uploadConfig['upload_path'] . $id . "." . $this->uploadConfig['allowed_types']);
        @unlink($this->uploadConfig['upload_path'] . $id . CATEGORIA_PRODUCTO_IMAGE_PREVIEW_MARKER . "." . $this->uploadConfig['allowed_types']);
        @unlink($this->uploadConfig['upload_path'] . $id . CATEGORIA_PRODUCTO_IMAGE_THUMB_MARKER . "." . $this->uploadConfig['allowed_types']);
        
        redirect('admin/categorias_productos');
    }

    private function manejarUploads($idCategoria){
        $this->uploadConfig['file_name'] = $idCategoria;
        $this->upload->initialize($this->uploadConfig);
        if($this->upload->do_upload('imagen')){
            $upload_data = $this->upload->data();

            // Salvo imagen preview
            $this->imgLibConfig['source_image'] = $upload_data['full_path'];
            $this->imgLibConfig['thumb_marker'] = CATEGORIA_PRODUCTO_IMAGE_PREVIEW_MARKER;
            $this->imgLibConfig['new_image'] = $upload_data['full_path'];
            $this->imgLibConfig['width'] = CATEGORIA_PRODUCTO_PREVIEW_WIDTH;
            $this->imgLibConfig['height'] = CATEGORIA_PRODUCTO_PREVIEW_HEIGHT;
            $this->image_lib->initialize($this->imgLibConfig); 
            if(!$this->image_lib->resize())
            {
                $data['error'] = $this->image_lib->display_errors() . "<br>";
                log_message('error', "(2) " . $this->image_lib->display_errors());
            } else {
                // Salvo imagen thumbnail
                $this->imgLibConfig['thumb_marker'] = CATEGORIA_PRODUCTO_IMAGE_THUMB_MARKER;
                $this->imgLibConfig['width'] = CATEGORIA_PRODUCTO_THUMB_WIDTH;
                $this->imgLibConfig['height'] = CATEGORIA_PRODUCTO_THUMB_HEIGHT;
                $this->image_lib->clear();
                $this->image_lib->initialize($this->imgLibConfig); 
                if(! $this->image_lib->resize())
                {
                    $data['error'] .= $this->image_lib->display_errors() . "<br>";
                    log_message('error', "(3) " . $this->image_lib->display_errors());
                }
            }

        } else {
            $upload_data = $this->upload->data();
            if(is_array($upload_data) && !empty($upload_data['file_name'])){
                $data['error'] = $this->upload->display_errors() . "<br>";
                log_message('error', $this->upload->display_errors());
                log_message('error', "(1) " . $this->upload->display_errors());
            }
        }
    }

    public function pornombre(){
        $term = $_GET['term'];
        $cats = $this->categorias_productos_model->get_categorias_productos($term, 'nombre_esp');
        $catsArr = array();
        foreach ($cats as $catRow) {
            array_push($catsArr, array('id'=>$catRow['id_categoria_producto'], 'value'=>$catRow['nombre_esp']));
        }

        $data['json_content'] = json_encode($catsArr);
        $this->load->view('includes/jsoncontent', $data);
    }

}