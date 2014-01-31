<?php
class Novedades_model extends CI_Model {
 
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
    public function get_novedad_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('novedad');
		$this->db->where('id_novedad', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch novedad data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_novedades($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('novedad');

		if($search_string){
			$this->db->like('titulo_esp', $search_string);
		}

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id_novedad', $order_type);
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
    function count_novedades($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('novedad');
		if($search_string){
			$this->db->like('titulo_esp', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id_novedad', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_novedad($data)
    {
		$insert = $this->db->insert('novedad', $data);
	    return $this->db->insert_id();
	}

    /**
    * Update novedad
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_novedad($id, $data)
    {
		$this->db->where('id_novedad', $id);
		$this->db->update('novedad', $data);
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
    * Delete novedadr
    * @param int $id - novedad id
    * @return boolean
    */
	function delete_novedad($id){
		$this->db->where('id_novedad', $id);
		$this->db->delete('novedad'); 
	}

    function obtener_visibles_ordenadas(){
        $this->db->select('novedad.id_novedad, novedad.titulo_esp');
        $this->db->from('novedad');
        $this->db->where('visible', 1);
        $this->db->order_by('orden', 'ASC');
        $query = $this->db->get();
        
        return $query->result_array(); 
    }
}
?>