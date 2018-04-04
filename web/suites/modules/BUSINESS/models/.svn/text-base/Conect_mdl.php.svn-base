<?php
/**
 * 短连接处理
 */
class Conect_mdl extends CI_Model {
    function __construct() {
        parent::__construct ();
    }
    
    
    public function load($url_key){
        $this->db->where("url_key",$url_key);
        $this->db->from("conect");
        $query = $this->db->get()->row_array();
        return $query;
    }
   public function create($data){
       $this->db->set("customer_id",$data['customer_id']);
       $this->db->set("url_long",$data['url_long']);
       $this->db->set("url_short",$data['url_short']);
       $this->db->set("url_key",$data['url_key']);
       $this->db->set("type",$data['type']);
        
       $datetime = date('Y-m-d H:i:s');
       $this->db->set("created_at",$datetime);
       
       $res = $this->db->insert('conect');
       return $this->db->insert_id();
       
   } 
   
   //处理部落二维码邀请失效的连接
   public function Del_CodeLink($key){
       $customer_id = $this->session->userdata("user_id");//用户id
       $this->db->where("customer_id",$customer_id);
       $this->db->where("url_key !=",$key);
       $this->db->where("type",2);
       $this->db->delete("conect");
       return $this->db->affected_rows();
   }
   
   
}