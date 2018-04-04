<?php
/**
 * 省市县
 *
 */
class Region_mdl extends CI_Model
{
    /**
     * 
     * 
     * @return Region_mdl
     */
    function __construct()
    {
        parent::__construct();
    }
    
	// --------------------------------------------------------------------

    /**
     * 
     *
     * @param integer $parent_id
     */
    function children_of($parent_id, $select="*")
    {
        error_log('进来选择城市');
        $parent_id = (int)$parent_id;
        
        $regions = array();
        $this->db->select($select);
        $this->db->where('parent_id', $parent_id);
        if ($query = $this->db->get('region')){
            return $query->result_array(); 
		}
		return array();       
    }

    // 获取城市信息
    function get_city($province_id)
    {
        return $this->children_of($province_id);
    }

    // --------------------------------------------------------------------
    function get_info_ByName($provice_name){
        $regions = array();
       
        $this->db->where('region_name', $provice_name);
        if ($query = $this->db->get('region')){
            return $query->row_array();
        }
        return array();
    }
    
    // --------------------------------------------------------------------

	/**
     * 
     *
     * @return array
     */
    function provinces()
    {
        return $this->children_of(1);
    }

 
    
    //--------------------------------------------------------------------
    /**
	 * 区域名
	 *
	 *
	 */	
    function get_name($id)
	{
		if (!$id){
            return NULL;
        }
		$this->db->select('region_name');
        $query = $this->db->get_where('region',array('region_id' => $id));

        if ($row = $query->row_array()){
            return $row['region_name'];
        }
		return NULL;
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
        $query = $this->db->get_where('region',array('region_id' => $id));
        if ($row = $query->row_array()){
            return $row;
        }
		return array();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 根据级别查询地区
	 * @param array $level 级别
	 */
	function second_level($level){
	    $this->db->from("region");
	    $this->db->where_in("region_type",$level);
	    $query = $this->db->get();
	    return $query->result_array();
	}

}