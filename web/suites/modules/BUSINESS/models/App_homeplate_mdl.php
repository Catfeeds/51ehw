<?php
/**
 *  APP首页改版
 *
 *
 */
class App_homeplate_mdl extends CI_Model {
    function __construct() {
        parent::__construct ();
    }
    
    /**
     * 获取模块内容
     */
    public function getList(){
        $app_id = $this->session->userdata("app_info")["id"];
        $this->db->select("s.*,l.level_name");
        $this->db->from("app_homeplate_set as s");
        $this->db->join("app_homeplate_level as l","s.level_id = l.id");
        $this->db->where("l.app_id",$app_id);
        $this->db->where("l.is_show",1);
        $this->db->where("s.is_show",1);
        $this->db->order_by("s.id","ASC");
        $query = $this->db->get()->result_array();
        return $query;
    }
    public function get_demand_logo(){
       $this->db->select("s.*");
       $this->db->from("app_homeplate_set as s");
       $this->db->where("s.temp_id",10);//写死
       $query = $this->db->get()->row_array();
       return $query;
    }
}