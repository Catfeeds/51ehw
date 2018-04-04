<?php
/**
 * 省市县
 *
 *
 */
class Role_mdl extends CI_Model
{
    /**
     * 
     *
     * @return Region_mdl
     */
    function Region_mdl()
    {
        parent::__construct();
    }
    
	// --------------------------------------------------------------------

    /**
     * 
     *
     * @param integer $parent_id
     */


    // --------------------------------------------------------------------

	/**
     * 
     *
     * @return array
     */


    // --------------------------------------------------------------------

    /**
	 * 角色列表
	 *
	 *
	 */
    function getList($app_id){
        
        if(!$app_id){
            return array();
        }
        $this->db->where('app_id',$app_id);
        $query = $this->db->get('role');
        
        if($row = $query->result_array()){
            return $row;
        }
        return array();
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
        $query = $this->db->get_where('role',array('id' => $id));
        if ($row = $query->row_array()){
            return $row;
        }
		return array();
	}

}