<?php
/**
 * 
 *
 *
 */
class Wechat_menu_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 获取列表
     * @param number $app_id
     * @return multitype:|unknown
     */
    function get_list($app_id = 0)
    {
    	
        if ($app_id == 0){
            return array();
        }
		
        $query = $this->db->get_where('wechat_menu', array('app_id' => $app_id));

        if ($row = $query->result_array()){
            return $row;
        }

        return array();
    }
    
    /**
     * 根据Key获取菜单所选
     * @param unknown $key
     * @param number $app_id
     */
    function get_menu_by_key($key, $app_id = 0){
    	$query = $this->db->get_where('wechat_menu', array('app_id' => $app_id, 'clickkey' => $key));
    	return $query->result_array();
    }
}