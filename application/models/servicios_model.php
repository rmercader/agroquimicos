<?php
class Servicios_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_servicio_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('servicio');
		$this->db->where('id_servicio', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch servicio data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_servicios($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('servicio');

		if($search_string){
			$this->db->like('nombre_esp', $search_string);
		}

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id_servicio', $order_type);
		}

        if($limit_start && $limit_end){
          $this->db->limit($limit_start, $limit_end);	
        }

        if($limit_start != null){
          $this->db->limit($limit_start, $limit_end);    
        }
        
		$query = $this->db->get();
		
		return $query->result_array(); 	
    }

    /**
    * Count the number of rows
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_servicios($search_string=null, $order=null)
    {
		$this->db->select('id_servicio');
		$this->db->from('servicio');
		if($search_string){
			$this->db->like('nombre_esp', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id_servicio', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_servicio($data)
    {
		$insert = $this->db->insert('servicio', $data);
	    return $this->db->insert_id();
	}

    /**
    * Update servicio
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_servicio($id, $data)
    {
		$this->db->where('id_servicio', $id);
		$this->db->update('servicio', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}

    /**
    * Delete servicior
    * @param int $id - servicio id
    * @return boolean
    */
	function delete_servicio($id){
		$this->db->where('id_servicio', $id);
		$this->db->delete('servicio'); 
	}

    function obtenerNombres($id){
        $this->db->select('nombre_esp, nombre_eng');
        $this->db->from('servicio');
        $this->db->where('id_servicio', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>