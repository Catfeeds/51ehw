<?php
/**
 * 商品
 *
 *
 */
class Customer_menu_mdl extends CI_Model {

	var $orderitem_id;
	var $product_score;
	var $service_score;
	var $content;


	function __construct() {
		parent::__construct ();
	}
	
	// --------------------------------------------------------------------
	
    /**
     * 查询我的店铺
     */
	function load($id){
	    
	    if(!$id){
	        return array();
	    }
	    $query = $this->db->get_where('customer_menu',array('id' => $id));
	    if ($row = $query->row_array()){
	        return $row;
	    }
	    return array();
	    
	}

	// --------------------------------------------------------------------
	
	/**
	 * 更新数据
	 */
	function save($id){
	    
	    $this->db->set('menu_name',$this->menu_name);
	    $this->db->set('sequence',$this->sequence);
	    $this->db->set('url',$this->url);
	    
	    $this->db->where('id',$id);
	    $res = $this->db->update('customer_menu');
	    if($res){
	        return $res;
	    }
	    else{
	        return 0;
	    }
	}
	
	/**
	 * 加数据
	 */
	function create(){
	     
	    $this->db->set('menu_name',$this->menu_name);
	    $this->db->set('sequence',$this->sequence);
	    $this->db->set('url',$this->url);
	    $this->db->set('customer_id',$this->customer_id);
	    $this->db->set('app_id',$this->app_id);
	     
	    $res = $this->db->insert('customer_menu');

	    if($res){
	        return $this->db->insert_id();
	    }
	    else{
	        return 0;
	    }
	}

	
	// --------------------------------------------------------------------
	
	/**
	 * 更新图片
	 */
    function getList($customer_id){
        if(!$customer_id){
            return array();
        } 
        $this->db->where('customer_id',$customer_id);
        
        $res = $this->db->get('customer_menu');
        if($r=$res->result_array()){
            return $r;
        }
        return array();
    }
	
	// --------------------------------------------------------------------
	
    /**
     * 删除
     */
    function deleted(){
        
        $this->db->where('id',$this->id);
        
        $res = $this->db->delete('customer_menu');
        if($res){
            return 1;
        }else{
            return 0;
        }
        
    }
	
	// --------------------------------------------------------------------
	
    /**
     * 个人中心-我的评论
     */

	// --------------------------------------------------------------------
	
	/**
	 * 统计评论条数
	 */

	// --------------------------------------------------------------------
	/**
	 * 增加商品评论
	 */


	
	// --------------------------------------------------------------------
	/**
	 * 统计已经评价的条数
	 */


	
	// --------------------------------------------------------------------
	/**
	 * 统计未评价的条数
	 */

    
    /**
     * 统计全部评价
     */

	
	// --------------------------------------------------------------------
	
    /**
     * 私有崡数
     */
	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

}