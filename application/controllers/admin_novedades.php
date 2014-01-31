<?php
class Admin_novedades extends CI_Controller {

    private $uploadConfig;
    private $imgLibConfig;

    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    const VIEW_FOLDER = 'admin/novedades';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('novedades_model');

        // Helpers
        $this->load->helper('file');

        // Manejo de uploads
        $this->uploadConfig = array();
        $this->uploadConfig['upload_path'] = './uploads/novedades/';
        $this->uploadConfig['allowed_types'] = 'jpg';
        $this->uploadConfig['overwrite'] = true;
        $this->load->library('upload');

        // Manejo de imagenes
        $this->imgLibConfig = array();
        $this->imgLibConfig['image_library'] = 'gd2';
        $this->imgLibConfig['create_thumb'] = TRUE;
        $this->imgLibConfig['maintain_ratio'] = FALSE;
        $this->imgLibConfig['quality'] = NOVEDAD_IMAGE_QUALITY;
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

        $data['thumbnailWidth'] = NOVEDAD_THUMB_WIDTH;
        $data['thumbnailHeight'] = NOVEDAD_THUMB_HEIGHT;
        $data['thumbMarker'] = NOVEDAD_IMAGE_THUMB_MARKER;

        $config['base_url'] = base_url().'admin/novedades';
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
            $data['count_novedades']= $this->novedades_model->count_novedades($search_string, $order);
            $config['total_rows'] = $data['count_novedades'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['novedades'] = $this->novedades_model->get_novedades($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['novedades'] = $this->novedades_model->get_novedades($search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['novedades'] = $this->novedades_model->get_novedades('', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['novedades'] = $this->novedades_model->get_novedades('', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['novedad_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_novedades']= $this->novedades_model->count_novedades();
            $data['novedades'] = $this->novedades_model->get_novedades('', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_novedades'];

        }//!isset($search_string) && !isset($order)
         
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/novedades/list';
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('titulo_esp', 'Titulo', 'required');
            $this->form_validation->set_rules('cabezal_esp', 'Cabezal', 'required');
            $this->form_validation->set_rules('texto_esp', 'Texto', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $titEsp = $this->input->post('titulo_esp');
                $titEng = $this->input->post('titulo_eng');
                $cabEsp = $this->input->post('cabezal_esp');
                $cabEng = $this->input->post('cabezal_eng');
                $txtEsp = $this->input->post('texto_esp');
                $txtEng = $this->input->post('texto_eng');
                
                if(trim($titEng) == ''){
                    $titEng = $titEsp;
                }

                if(trim($cabEng) == ''){
                    $cabEng = $cabEsp;
                }

                if(trim($txtEng) == ''){
                    $txtEng = $txtEsp;
                }

                $data_to_store = array(
                    'titulo_esp'  => $titEsp,
                    'titulo_eng'  => $titEng,
                    'cabezal_esp' => $cabEsp,
                    'cabezal_eng' => $cabEng,
                    'texto_esp'   => $txtEsp,
                    'texto_eng'   => $txtEng,
                    'orden'       => $this->input->post('orden'),
                    'visible'     => (bool)$this->input->post('visible')
                );
                
                // Salvo la categoria
                $idNovedad = $this->novedades_model->store_novedad($data_to_store);

                if(is_numeric($idNovedad)){
                    $data_to_store = array(
                        'ficha_esp' => url_title("$idNovedad $titEsp", '-', true),
                        'ficha_eng' => url_title("$idNovedad $titEng", '-', true)
                    );                    
                    $data['flash_message'] = $this->novedades_model->update_novedad($idNovedad, $data_to_store); 
                    $this->manejarUploads($idNovedad);
                    
                } else {
                    $data['flash_message'] = FALSE; 
                }

            }

        }

        //load the view
        $data['main_content'] = 'admin/novedades/add';
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
            $this->form_validation->set_rules('titulo_esp', 'Titulo', 'required');
            $this->form_validation->set_rules('cabezal_esp', 'Cabezal', 'required');
            $this->form_validation->set_rules('texto_esp', 'Texto', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $titEsp = $this->input->post('titulo_esp');
                $titEng = $this->input->post('titulo_eng');
                $cabEsp = $this->input->post('cabezal_esp');
                $cabEng = $this->input->post('cabezal_eng');
                $txtEsp = $this->input->post('texto_esp');
                $txtEng = $this->input->post('texto_eng');
                
                if(trim($titEng) == ''){
                    $titEng = $titEsp;
                }

                if(trim($cabEng) == ''){
                    $cabEng = $cabEsp;
                }

                if(trim($txtEng) == ''){
                    $txtEng = $txtEsp;
                }

                $data_to_store = array(
                    'titulo_esp'  => $titEsp,
                    'titulo_eng'  => $titEng,
                    'cabezal_esp' => $cabEsp,
                    'cabezal_eng' => $cabEng,
                    'texto_esp'   => $txtEsp,
                    'texto_eng'   => $txtEng,
                    'orden'       => $this->input->post('orden'),
                    'visible'     => (bool) $this->input->post('visible')
                );

                //if the insert has returned true then we show the flash message
                if($this->novedades_model->update_novedad($id, $data_to_store) == TRUE){
                    $data_to_store = array(
                        'ficha_esp' => url_title("$id $titEsp", '-', true),
                        'ficha_eng' => url_title("$id $titEng", '-', true)
                    );                    
                    $data['flash_message'] = $this->novedades_model->update_novedad($id, $data_to_store);  
                    $this->manejarUploads($id);
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }

                redirect('admin/novedades/update/' . $id);

            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //product data 
        $data['novedad'] = $this->novedades_model->get_novedad_by_id($id);
        $data['previewWidth'] = NOVEDAD_PREVIEW_WIDTH;
        $data['previewHeight'] = NOVEDAD_PREVIEW_HEIGHT;
        $data['previewMarker'] = NOVEDAD_IMAGE_PREVIEW_MARKER;
        
        //load the view
        $data['main_content'] = 'admin/novedades/edit';
        $this->load->view('includes/template', $data);            

    }//update

    public function delete()
    {
        $id = $this->uri->segment(4);
        $this->novedades_model->delete_novedad($id);

        // Borro las imagenes del filesystem
        @unlink($this->uploadConfig['upload_path'] . $id . "-esp." . $this->uploadConfig['allowed_types']);
        @unlink($this->uploadConfig['upload_path'] . $id . "-esp" . NOVEDAD_IMAGE_PREVIEW_MARKER . "." . $this->uploadConfig['allowed_types']);
        @unlink($this->uploadConfig['upload_path'] . $id . "-esp" . NOVEDAD_IMAGE_THUMB_MARKER . "." . $this->uploadConfig['allowed_types']);

        redirect('admin/novedades');
    }

    private function manejarUploads($idNovedad){
        $this->uploadConfig['file_name'] = $idNovedad;
        $this->upload->initialize($this->uploadConfig);
        if($this->upload->do_upload('imagen')){
            $upload_data = $this->upload->data();

            // Salvo imagen preview
            $this->imgLibConfig['source_image'] = $upload_data['full_path'];
            $this->imgLibConfig['thumb_marker'] = NOVEDAD_IMAGE_PREVIEW_MARKER;
            $this->imgLibConfig['new_image'] = $upload_data['full_path'];
            $this->imgLibConfig['width'] = NOVEDAD_PREVIEW_WIDTH;
            $this->imgLibConfig['height'] = NOVEDAD_PREVIEW_HEIGHT;
            $this->image_lib->initialize($this->imgLibConfig); 
            if(!$this->image_lib->resize())
            {
                $data['error'] = $this->image_lib->display_errors() . "<br>";
                log_message('error', "(2) " . $this->image_lib->display_errors());
            } else {
                // Salvo imagen thumbnail
                $this->imgLibConfig['thumb_marker'] = NOVEDAD_IMAGE_THUMB_MARKER;
                $this->imgLibConfig['width'] = NOVEDAD_THUMB_WIDTH;
                $this->imgLibConfig['height'] = NOVEDAD_THUMB_HEIGHT;
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

    public function portitulo(){
        $term = $_GET['term'];
        $cats = $this->novedades_model->get_novedades($term, 'titulo_esp');
        $catsArr = array();
        foreach ($cats as $catRow) {
            array_push($catsArr, array('id'=>$catRow['id_novedad'], 'value'=>$catRow['titulo_esp']));
        }

        $data['json_content'] = json_encode($catsArr);
        $this->load->view('includes/jsoncontent', $data);
    }

    // Ordenacion de destacadas
    public function ordenar()
    {
        ini_set('display_errors', 'on');
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {
            //form validation
            $this->form_validation->set_rules('ids_ordenados', 'Ordenacion', 'required');
            $this->form_validation->set_message('required', 'No se ha recibido una ordenación correcta.');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $jsonIds = $this->input->post('ids_ordenados');
                $ids = json_decode($jsonIds);
                $booleanResult = true;
                $indice = 1;
                foreach ($ids as $id) {
                    $data_to_store = array(
                        'orden' => $indice
                    );
                    $booleanResult = $booleanResult && $this->novedades_model->update_novedad($id, $data_to_store);
                    $indice++;
                }
                
                if($booleanResult){
                    $data['flash_message'] = TRUE; 
                }else{
                    $data['flash_message'] = FALSE; 
                }
            }

        }
        
        //load the view
        $data['visibles'] = $this->novedades_model->obtener_visibles_ordenadas();
        $data['main_content'] = 'admin/novedades/ordenar_visibles';
        $this->load->view('includes/template', $data);  
    }

}