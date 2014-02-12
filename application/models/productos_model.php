<?php
class Productos_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

    public function start_transaction(){
        $this->db->trans_start();
    }

    public function complete_transaction(){
        $this->db->trans_complete();
    }

    /**
    * Get product by his is
    * @param int $product_id 
    * @return array
    */
    public function get_producto_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('producto');
		$this->db->where('id_producto', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch producto data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_productos($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('producto.id_producto, producto.nombre_esp, categoria_producto.nombre_esp AS nombre_categoria');
		$this->db->from('producto');
        $this->db->join('categoria_producto', 'categoria_producto.id_categoria_producto = producto.id_categoria_producto', 'inner');

		if($search_string){
			$this->db->like('producto.nombre_esp', $search_string);
            $this->db->like('categoria_producto.nombre_esp', $search_string);
		}

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id_producto', $order_type);
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
    function count_productos($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('producto');
		if($search_string){
			$this->db->like('nombre_esp', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id_producto', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_producto($data)
    {
		$insert = $this->db->insert('producto', $data);
	    return $this->db->insert_id();
	}

    /**
    * Update producto
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_producto($id, $data)
    {
		$this->db->where('id_producto', $id);
		$this->db->update('producto', $data);
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
    * Delete productor
    * @param int $id - producto id
    * @return boolean
    */
	function delete_producto($id){
		$this->db->where('id_producto', $id);
		$this->db->delete('producto'); 
	}
    
    function productos_por_categoria($idCategoria, $idioma){
        $this->db->select("id_producto, nombre_{$idioma} AS nombre, ficha_{$idioma} AS ficha, formulacion_{$idioma} AS formulacion, principio_activo_{$idioma} AS principio_activo");
        $this->db->from('producto');
        $this->db->where('id_categoria_producto', $idCategoria);
        $query = $this->db->get();
        
        return $query->result_array(); 
    }
}
?>