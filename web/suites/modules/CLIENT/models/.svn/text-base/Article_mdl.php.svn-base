<?php
/**
 *
 *
 *
 */
class Article_mdl extends CI_Model {

    function __construct() {
        parent::__construct ();
    }
    
    
    /**
     * 获取好文内容
     */
    function get_article($id){
       $this->db->select("*");
       $this->db->from("article");
       $this->db->where("id",$id);
       $query = $this->db->get()->row_array();
       return $query;
    }
    
    /** 获取好文列表
     * share_times  为好文分享次数
     * read_times   为好文阅读次数
     * status     取阅读ID 判断当前用户是否阅读
     */
    
    function get_list($keyword = NULL,$limit = 0, $offset = 0){
        $user_id = $this->session->userdata("user_id");
     
        $limitstr = '';
        if($offset){
            $limitstr = "limit $offset,$limit" ;
        }else{
            //默认获取12条数据
            $limitstr = "limit ".$limit ;
        }
       
        if($keyword){
            $query = $this->db->query("
            select a.*, count(sr.communal_id) as read_times,count(sr.customer_id = $user_id or null )  as status from (
            select a.*, count(ss.communal_id) as share_times from 9thleaf_article as a left join 9thleaf_shop_share as ss on ss.communal_id = a.id group by a.id
            ) as a left join 9thleaf_shop_read as sr on a.id = sr.communal_id where  a.title like '%$keyword%'  group by a.id Order by a.create_at DESC $limitstr 
                ");
        }else{
            $query = $this->db->query("
            select a.*,count(sr.communal_id) as read_times , count(sr.customer_id = $user_id or null )  as status from (
            select a.*, count(ss.communal_id) as share_times from 9thleaf_article as a left join 9thleaf_shop_share as ss on ss.communal_id = a.id group by a.id
            ) as a left join 9thleaf_shop_read as sr on a.id = sr.communal_id  group by a.id   Order by a.create_at DESC $limitstr    
            ");
        }
        return $query->result_array();
    }
    
    
    /**
     * 获取好文列表数量
     */
    function get_listcount($keyword = NULL){
        $user_id = $this->session->userdata("user_id");
        
        if($keyword){
            $query = $this->db->query("
            select a.*,count(sr.communal_id) as read_times, count(sr.customer_id = $user_id or null )  as status from (
            select a.*, count(ss.communal_id) as share_times from 9thleaf_article as a left join 9thleaf_shop_share as ss on ss.communal_id = a.id group by a.id
            ) as a left join 9thleaf_shop_read as sr on a.id = sr.communal_id where  a.title like '%$keyword%' group by a.id   
            ");
        }else{
            $query = $this->db->query("
             select a.*,count(sr.communal_id) as read_times, count(sr.customer_id = $user_id or null )  as status from (
            select a.*, count(ss.communal_id) as share_times from 9thleaf_article as a left join 9thleaf_shop_share as ss on ss.communal_id = a.id group by a.id
            ) as a left join 9thleaf_shop_read as sr on a.id = sr.communal_id  group by a.id   
            ");
        }
        return $query->result_array();
    }
    
    /**
     * 检查是否已阅
     */
    
    function check_read($type,$communal){
        $user_id = $this->session->userdata("user_id");
        $this->db->select('*');
        $this->db->from('shop_read');
        $this->db->where('type',$type);
        $this->db->where('communal_id',$communal);
        $this->db->where('customer_id',$user_id);
        $query = $this->db->get()->row_array();
        return  $query;
    }
    
    /**
     * 写入数据阅读记录
     */
    
    function add_read($parent = 0,$type,$communal,$share_time =NULL){
        $user_id = $this->session->userdata("user_id");
        $time = date('Y-m-d H:i:s');
        $this->db->set("parent_id",$parent);
        $this->db->set("type",$type);
        $this->db->set("communal_id",$communal);
        $this->db->set("customer_id",$user_id);
        $this->db->set("read_at",$time);
        if($share_time){
            $this->db->set("share_at",$share_time);
        }
        $this->db->insert('shop_read');
        return $this->db->insert_id();
    }
    
   
    
    /**
     * 写入分享记录
     */
    
    function add_share($parent,$type,$communal,$time = NULL){
        if(!$time){
            $time = date('Y-m-d H:i:s');
        }
        $user_id = $this->session->userdata("user_id");
        $this->db->set("parent_id",$parent);
        $this->db->set("type",$type);
        $this->db->set("communal_id",$communal);
        $this->db->set("customer_id",$user_id);
        $this->db->set("created_at",$time);
        
        $this->db->insert('shop_share');
        return $this->db->insert_id();
    }
    
   
    
    /**
     * 获取分享好文ID
     */
     function get_shareID(){
           $user_id = $this->session->userdata("user_id");
           $this->db->select("*");
           $this->db->from('shop_share');
           $this->db->where("customer_id",$user_id);
           $this->db->where("type",1);
     }

     /**
      * 获取分享好文或商品的分享时间
      */
     function get_sharetime($id,$type){
         $this->db->select("*");
         $this->db->from('shop_share');
         $this->db->where("id",$id);
         $this->db->where("type",$type);
         $query = $this->db->get()->row_array();
         return $query;
     }
    
}