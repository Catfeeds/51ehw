<?php
/**
 * 简易商品模块
 * @date:2018年03月16日 
 */

class Easyproduct_mdl extends CI_Model
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
     * 
     * 部落 发布产品
     * 
     */
    
    
    

    
    
    
    
    
    
    
    
}