<?php
/**
 * 
 *
 */
class Attribute_set_mdl extends CI_Model
{

    var $name;
    
	function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('product_attr_set',array('id' => $id));//, 'app_id' => $this->session->userdata('app_info')['id']));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

	// --------------------------------------------------------------------

    /**
	 * 创建
	 *
	 *
	 */	
    function create()
    { 
        $this->db->set('name', $this->name);
        //$this->db->set('app_id', $this->session->userdata('app_info')['id']);
              
        $this->db->insert('product_attr_set');
        
        return $this->db->insert_id();
    }

	// --------------------------------------------------------------------

    /**
	 * 结果集
	 *
	 *
	 */	
    function find_attribute_sets()
	{
        $this->db->select("pas.*, COUNT(DISTINCT(pa.id)) as attr_count");
        $this->db->from('9thleaf_product_attr_set pas');
        $this->db->join('9thleaf_product_attr pa','pa.attr_set_id = pas.id', 'left');
        $this->db->group_by('pas.id');
        $query = $this->db->get();
        return $query->result_array();
	}


	 function find_all_attribute_sets()
	{
        $this->db->from('9thleaf_product_attr_set');
        $query = $this->db->get();
        return $query->result_array();
	}

    // --------------------------------------------------------------------

    /**
	 * 更新
	 *
	 *
	 */	
    function update($id)
    {
        $this->db->set('name', $this->name);
       
        $this->db->where('id', $id);
        return $this->db->update('product_attr_set');
    }
    
	// --------------------------------------------------------------------

    /**
	 * 删除
	 * 
	 *
	 */		
    function delete($id)
    {        
		$this->db->where('id', $id);

        return $this->db->delete('product_attr_set'); 
    }

    // --------------------------------------------------------------------

    /**
	 * 获取最新添加的数据
	 *
	 *
	 */
	function get_newly_one()
    {
        $this->db->from('product_attr_set');
        //$this->db->where('app_id', $this->session->userdata('app_info')['id']);
        $this->db->order_by("id", "desc");
        $this->db->limit('1');
        $query =  $this->db->get();
        return $query->row_array();
    }
    
    
}