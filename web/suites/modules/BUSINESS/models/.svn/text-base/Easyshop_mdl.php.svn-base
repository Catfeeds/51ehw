<?php
/**
 * 
 * 简易店模块
 * @date:2018年03月16日 
 */

class Easyshop_mdl extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
 
    
    /**
     * 创建简易店
     */
    public function Create($data){
        $this->db->insert('easy_corporation',$data);
        return $this->db->insert_id ();
    }
    
    /**
     * 获取简易店
     */
    public function Load($customer_id){
        $this->db->where("customer_id",$customer_id);
        $this->db->from('easy_corporation');
        return $this->db->get()->row_array();
    }
    
    /**
     * 插入上传的图片
     */
    public  function create_img($data){
        
        if(!$data){
            echo false;
        }
        if(count($data)  == 1){
            
            $this->db->set("product_id",$data['0']['product_id']);
            $this->db->set("pic_rank",$data['0']['pic_rank']);
            $this->db->set("path",$data['0']['path']);
            $this->db->set("type",$data['0']['type']);
            $this->db->insert('easy_product_img');
            return $this->db->insert_id();
        }else{
            $this->db->insert_batch('easy_product_img',$data);
            $affected_rows = $this->db->affected_rows();
            return $affected_rows;
        }
        
    }
    
    /**
     * 插入数据
     */
    public  function create_easy_product($data){
        
        $this->db->set("easy_corp_id",$data['easy_corp_id']);
        $this->db->set("tribe_id",$data['tribe_id']);
        $this->db->set("product_name",$data['product_name']);
        $this->db->set("price",$data['price']);
        $this->db->set("desc",$data['desc']);
        $this->db->set("stock",$data['stock']);
        $this->db->set("is_on_sale",$data['is_on_sale']);
        $this->db->set("remarks",$data['remarks']);
        $this->db->set("created_at",$data['created_at']);
        $this->db->set("update_at",$data['update_at']);
        $this->db->set("sort",$data['sort']);
        $this->db->insert('easy_product');
        return $this->db->insert_id();
    }
    
    /*
     * 
     * 查询个人发布商品
     */
    public function personal_product_select ($easy_corp_id,$tribe_id,$count = '', $offset = '') {
        $this->db->where("easy_corp_id",$easy_corp_id);
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("is_on_sale !=",'3');
        $this->db->from('easy_product');
        $this->db->order_by('id','desc');
        if(!empty($count) )
        {
            $this->db->limit((int) $count, (int) $offset);
        }
        return $this->db->get()->result_array();
    }
    
    /*
     * 
     * 查询简易店商品图片地址
     */
    public  function img_data ($product_id) {
        $this->db->where("product_id",$product_id);
        $this->db->from('easy_product_img');
        return $this->db->get()->result_array();
    }
    
    /*
     * 
     * 查询商品详情
     */
    public function producy_detail ($product_id) {
        $this->db->where('id',$product_id);
        $this->db->from('easy_product');
        return $this->db->get()->row_array();
    }
    
    
    
    
    
}