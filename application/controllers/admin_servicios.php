<?php
class Admin_servicios extends CI_Controller {

    private $uploadConfig;

    /**
    * name of the folder responsible for the views 
    * which are manipulated by this controller
    * @constant string
    */
    const VIEW_FOLDER = 'admin/servicios';
 
    /**
    * Responsable for auto load the model
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('servicios_model');

        // Helpers
        $this->load->helper('file');

        // Manejo de uploads
        $this->uploadConfig = array();
        $this->uploadConfig['upload_path'] = './uploads/servicios/';
        $this->uploadConfig['allowed_types'] = 'pdf';
        $this->uploadConfig['overwrite'] = true;
        $this->load->library('upload');

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

        $config['base_url'] = base_url().'admin/servicios';
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
            $data['count_servicios']= $this->servicios_model->count_servicios($search_string, $order);
            $config['total_rows'] = $data['count_servicios'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['servicios'] = $this->servicios_model->get_servicios($search_string, $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['servicios'] = $this->servicios_model->get_servicios($search_string, '', $order_type, $config['per_page'],$limit_end);           
                }
            }else{
                if($order){
                    $data['servicios'] = $this->servicios_model->get_servicios('', $order, $order_type, $config['per_page'],$limit_end);        
                }else{
                    $data['servicios'] = $this->servicios_model->get_servicios('', '', $order_type, $config['per_page'],$limit_end);        
                }
            }

        }else{

            //clean filter data inside section
            $filter_session_data['servicio_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_servicios']= $this->servicios_model->count_servicios();
            $data['servicios'] = $this->servicios_model->get_servicios('', '', $order_type, $config['per_page'],$limit_end);        
            $config['total_rows'] = $data['count_servicios'];

        }//!isset($search_string) && !isset($order)
         
        //initializate the panination helper 
        $this->pagination->initialize($config);   

        //load the view
        $data['main_content'] = 'admin/servicios/list';
        $this->load->view('includes/template', $data);  

    }//index

    public function add()
    {
        //if save button was clicked, get the data sent via post
        if ($this->input->server('REQUEST_METHOD') === 'POST')
        {

            //form validation
            $this->form_validation->set_rules('nombre_esp', 'Nombre', 'required');
            $this->form_validation->set_rules('descripcion_esp', 'Descripción', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $nomEsp = $this->input->post('nombre_esp');
                $nomEng = $this->input->post('nombre_eng');
                $descEsp = $this->input->post('descripcion_esp');
                $descEng = $this->input->post('descripcion_eng');
                
                if(trim($nomEng) == ''){
                    $nomEng = $nomEsp;
                }

                if(trim($descEng) == ''){
                    $descEng = $descEsp;
                }

                $data_to_store = array(
                    'nombre_esp'  => $nomEsp,
                    'nombre_eng'  => $nomEng,
                    'descripcion_esp' => $descEsp,
                    'descripcion_eng' => $descEng
                );
                
                // Salvo la categoria
                $idServicio = $this->servicios_model->store_servicio($data_to_store);

                if(is_numeric($idServicio)){
                    $this->manejarUploads($idServicio, $nomEsp, $nomEng);
                    $data['flash_message'] = TRUE;
                }
                else{
                    $data['flash_message'] = FALSE; 
                }
            }
        }

        //load the view
        $data['main_content'] = 'admin/servicios/add';
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
            $this->form_validation->set_rules('descripcion_esp', 'Descripcion', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-error"><a class="close" data-dismiss="alert">×</a><strong>', '</strong></div>');
            //if the form has passed through the validation
            if ($this->form_validation->run())
            {
                $nomEsp = $this->input->post('nombre_esp');
                $nomEng = $this->input->post('nombre_eng');
                $descEsp = $this->input->post('descripcion_esp');
                $descEng = $this->input->post('descripcion_eng');
                
                if(trim($nomEng) == ''){
                    $nomEng = $nomEsp;
                }

                if(trim($descEng) == ''){
                    $descEng = $descEsp;
                }

                $data_to_store = array(
                    'nombre_esp'  => $nomEsp,
                    'nombre_eng'  => $nomEng,
                    'descripcion_esp' => $descEsp,
                    'descripcion_eng' => $descEng
                );

                //if the insert has returned true then we show the flash message
                if($this->servicios_model->update_servicio($id, $data_to_store) == TRUE){
                    $this->manejarUploads($id, $nomEsp, $nomEng);
                    $this->session->set_flashdata('flash_message', 'updated');
                }else{
                    $this->session->set_flashdata('flash_message', 'not_updated');
                }

                redirect('admin/servicios/update/' . $id);

            }//validation run
        }

        //if we are updating, and the data did not pass trough the validation
        //the code below wel reload the current data

        //servicio data 
        $data['servicio'] = $this->servicios_model->get_servicio_by_id($id);
        
        $nombres = $this->servicios_model->obtenerNombres($id);
        $nomEsp = $nombres[0]['nombre_esp'];
        $nomEng = $nombres[0]['nombre_eng'];
        $fichaEsp = url_title("$id $nomEsp esp", '-', true);
        $fichaEng = url_title("$id $nomEng eng", '-', true);
        $data['fichaEsp'] = $fichaEsp . "." . $this->uploadConfig['allowed_types'];
        $data['fichaEng'] = $fichaEng . "." . $this->uploadConfig['allowed_types'];

        //load the view
        $data['main_content'] = 'admin/servicios/edit';
        $this->load->view('includes/template', $data);            

    }//update

    private function manejarUploads($idServicio, $nomEsp, $nomEng){
        // Creo los nombres de archivo
        $fichaEsp = url_title("$idServicio $nomEsp esp", '-', true);
        $fichaEng = url_title("$idServicio $nomEng eng", '-', true);
        
        // Upload del archivo en español
        $this->uploadConfig['file_name'] = $fichaEsp;
        $this->upload->initialize($this->uploadConfig);
        if($this->upload->do_upload('file_esp')){
            $upload_data = $this->upload->data();
        } else {
            $upload_data = $this->upload->data();
            if(is_array($upload_data) && !empty($upload_data['file_name'])){
                $data['error'] = $this->upload->display_errors() . "<br>";
                log_message('error', $this->upload->display_errors());
                log_message('error', "(1) " . $this->upload->display_errors());
            }
        } 

        // Upload del archivo en inglés
        $this->uploadConfig['file_name'] = $fichaEng;
        $this->upload->initialize($this->uploadConfig);
        if($this->upload->do_upload('file_eng')){
            $upload_data = $this->upload->data();
        } else {
            $upload_data = $this->upload->data();
            if(is_array($upload_data) && !empty($upload_data['file_name'])){
                $data['error'] = $this->upload->display_errors() . "<br>";
                log_message('error', $this->upload->display_errors());
                log_message('error', "(2) " . $this->upload->display_errors());
            }
        } 
    }

    public function delete()
    {
        $id = $this->uri->segment(4);
        $nombres = $this->servicios_model->obtenerNombres($id);
        $nomEsp = $nombres[0]['nombre_esp'];
        $nomEng = $nombres[0]['nombre_eng'];
        $fichaEsp = url_title("$id $nomEsp esp", '-', true);
        $fichaEng = url_title("$id $nomEng eng", '-', true);
        $this->servicios_model->delete_servicio($id);

        // Borro las imagenes del filesystem
        @unlink($this->uploadConfig['upload_path'] . $fichaEsp . "." . $this->uploadConfig['allowed_types']);
        @unlink($this->uploadConfig['upload_path'] . $fichaEng . "." . $this->uploadConfig['allowed_types']);

        redirect('admin/servicios');
    }

}