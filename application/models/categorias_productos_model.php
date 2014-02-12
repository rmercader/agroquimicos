<?php
class Categorias_productos_model extends CI_Model {
 
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
    public function get_categoria_producto_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('categoria_producto');
		$this->db->where('id_categoria_producto', $id);
		$query = $this->db->get();
		return $query->result_array(); 
    }    

    /**
    * Fetch categoria_producto data from the database
    * possibility to mix search, filter and order
    * @param string $search_string 
    * @param strong $order
    * @param string $order_type 
    * @param int $limit_start
    * @param int $limit_end
    * @return array
    */
    public function get_categorias_productos($search_string=null, $order=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
	    
		$this->db->select('*');
		$this->db->from('categoria_producto');

		if($search_string){
			$this->db->like('nombre_esp', $search_string);
		}

		if($order){
			$this->db->order_by($order, $order_type);
		}else{
		    $this->db->order_by('id_categoria_producto', $order_type);
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

    public function get_categorias_con_productos($search_string=null, $order=null, $order_type='Asc'){
        $this->db->select('c.*');
        $this->db->from('categoria_producto c');
        $this->db->where("EXISTS(SELECT o.id_producto FROM producto o WHERE o.id_categoria_producto = c.id_categoria_producto)");

        if($search_string){
            $this->db->like('nombre_esp', $search_string);
        }
        $this->db->group_by('id_categoria_producto');

        if($order){
            $this->db->order_by($order, $order_type);
        }else{
            $this->db->order_by('id_categoria_producto', $order_type);
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
    function count_categorias_productos($search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('categoria_producto');
		if($search_string){
			$this->db->like('nombre_esp', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('id_categoria_producto', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();        
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean 
    */
    function store_categoria_producto($data)
    {
		$insert = $this->db->insert('categoria_producto', $data);
	    return $this->db->insert_id();
	}

    /**
    * Update categoria_producto
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_categoria_producto($id, $data)
    {
		$this->db->where('id_categoria_producto', $id);
		$this->db->update('categoria_producto', $data);
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
    * Delete categoria_productor
    * @param int $id - categoria_producto id
    * @return boolean
    */
	function delete_categoria_producto($id){
		$this->db->where('id_categoria_producto', $id);
		$this->db->delete('categoria_producto'); 
	}

    /**
    * Obtener nombre
    * @param int $id - categoria_producto id
    * @return string
    */
    function get_nombre($id, $idioma="esp"){
        $this->db->select("nombre_{$idioma}");
        $this->db->from('categoria_producto');
        $this->db->where('id_categoria_producto', $id);
        $query = $this->db->get();
        $row_array = $query->row_array();
        
        return $row_array["nombre_{$idioma}"];
    }

    function obtener_categorias($idioma='esp'){
        $this->db->select("id_categoria_producto, nombre_{$idioma} AS nombre, ficha_{$idioma} AS ficha");
        $this->db->from('categoria_producto');

        $query = $this->db->get();
        
        return $query->result_array(); 
    }

    function obtener_por_ficha($ficha, $idioma='esp'){
        $this->db->select("id_categoria_producto, nombre_{$idioma} AS nombre");
        $this->db->from('categoria_producto');
        $this->db->where('ficha_' . $idioma, $ficha);
        $query = $this->db->get();

        return $query->row_array();
    }
}
?>