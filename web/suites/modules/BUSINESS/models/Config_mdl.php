<?php
/**
 * 
 * 配置
 *
 */

class  Config_mdl extends CI_Model {


    function __construct() {
        parent::__construct ();
    }
    
    //---------------------------------------------------
    
    /**
     * 查询事件
     */
    public function get_config($name){
        return $this->db->get_where("config",array("name"=>$name))->row_array();
    }


}