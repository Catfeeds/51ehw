<?php
/**
 * 商品
 *
 *
 */
class Customer_corporation_mdl extends CI_Model {

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
	    $query = $this->db->get_where('customer_corporation',array('customer_id' => $id));
	    if ($row = $query->row_array()){
	        return $row;
	    }
	    return array();
	    
	}
	
	/**
	 * 查询我的店铺
	 */
	function corp_load($id){
	     
	    if(!$id){
	        return array();
	    }
	    $query = $this->db->get_where('customer_corporation',array('id' => $id));
	    if ($row = $query->row_array()){
	        return $row;
	    }
	    return array();
	     
	}

	/**
	 * 根据店铺ID查询用户信息和商家信息。 
	 */
	function coro_customer_info($id)
	{ 
	    if(!$id){
	        return array();
	    }
	    
	    $this->db->select('c.name,c.mobile,cc.*');
	    $this->db->from('customer_corporation as cc');
	    $this->db->join('customer as c','c.id = cc.customer_id');
	    $this->db->where('cc.id',$id);
	    $query = $this->db->get();
	    return $query->row_array();
	   
	}
	
	/**
     * ID查询
     */
	function getById($id){
	    
	    if(!$id){
	        return array();
	    }
	    //$query = $this->db->get_where('customer_corporation',array('id' => $id));
	    $this->db->select('a.*,b.region_name as province,c.region_name as city,d.region_name as district');
	    $this->db->from('customer_corporation as a');
	    $this->db->join('region as b','a.province_id = b.region_id','left outer');
	    $this->db->join('region as c','a.city_id = c.region_id','left outer');
	    $this->db->join('region as d','a.district_id = d.region_id','left outer');
	    $this->db->where('a.id',$id);
	    $query = $this->db->get();
	    if ($row = $query->row_array()){
	        return $row;
	    }
	    return array();
	    
	}

	// --------------------------------------------------------------------
	
	/**
	 * 更新数据
	 */
    public function save(){
        
        $this->db->set('corporation_name',$this->corporation_name);
        $this->db->set('corporation_area',$this->corporation_area);
        $this->db->set('address',$this->address);
        $this->db->set('postcode',$this->postcode);
        $this->db->set('email',$this->email);
        //$this->db->set('contact_name',$this->contact_name);
        $this->db->set('contact_mobile',$this->contact_mobile);
        
        $this->db->where('id',$this->id);
        $res = $this->db->update('customer_corporation');
        if($res){
            return 1;
        }else{
            return 0;
        }
        
    }
	
	// --------------------------------------------------------------------
	
	/**
	 * 更新图片
	 */
    function save_img($id){
        if(!$id){
            return array();
        } 
        $this->db->set('img_url',$this->img_url);
        $this->db->where('customer_id',$id);
        
        $res = $this->db->update('customer_corporation');
        if($res){
             return 1;
        }else{
             return 0;
        }
    }

	/**
	 * 更新模板
	 */
    function updateTemplate($id,$template_type,$template_url){
        if(!$id){
            return array();
        } 
        $this->db->set('template_type',$template_type);
		$this->db->set('template_url',$template_url);
        $this->db->where('id',$id);
        
        $res = $this->db->update('customer_corporation');
        if($res){
             return 1;
        }else{
             return 0;
        }
    }
	
	// --------------------------------------------------------------------
	
    /**
     * 店铺一个月内营业额
     */
    function turnover($corp_id){
        $this->db->select("sum(total_price) as total_price");
        $this->db->from('order');
        $this->db->where('corporation_id',$corp_id);
        $this->db->where_in('status',array(9,14));
        $this->db->where("TO_DAYS(NOW()) - TO_DAYS(place_at) <= 30");
        $query = $this->db->get();
        return $query->row_array();
        
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 店铺销售金额
     * @param int $corp_id
     * @param string $status
     */
    function corp_amount($corp_id,$status=0){
        $this->db->select('sum(total_price) as total_price');
        $this->db->from('order');
        $this->db->where_in('status',array(9,14));
        $this->db->where('corporation_id',$corp_id);
        if($status){
            $this->db->where("place_at > DATE_SUB(CURDATE(), INTERVAL 30 DAY) ");
        }
        $query = $this->db->get();
        return $query->row_array();
    }
	
    /**
     * 审核
     */

	
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