<?php
/**
 *
 *
 *
 */

class Config_mdl extends CI_Model {
    
    /**
     * 构造函数
     */
    function __construct() {
        parent::__construct ();
    }
    
    
    function get_ByName($name){
        $this->db->select("*");
        $this->db->where("name",$name);
        $this->db->from('config');
        $query = $this->db->get()->row_array();
        return  $query;
    }
    
   /**
     * 查询事件
     */
    public function load($id){
        return $this->db->get_where("config",array("id"=>$id))->row_array();
    }
    
}