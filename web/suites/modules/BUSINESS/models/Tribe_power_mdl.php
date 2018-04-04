<?php
/**
 * 部落权限模型
 */
class Tribe_power_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	/**
	* @author JF
	* 2017年12月27日
	* 查询角色权限
	* @param number 角色id $id
	*/
	function TribePower($id){
	   $this->db->select("b.module_name,b.url");
	   $this->db->from("tribe_manager as a");
	   $this->db->join("tribe_module as b","FIND_IN_SET(b.id,a.module_id)<>0");
	   $this->db->where("a.id",$id);
	   return $query = $this->db->get()->result_array();
	}
	
	
	/**
	* @author JF
	* 2017年12月27日
	* 权限列表
	*/
    function PowerList(){
        $this->db->select("module_name,url");
        return $this->db->get("tribe_module")->result_array();
    }
}