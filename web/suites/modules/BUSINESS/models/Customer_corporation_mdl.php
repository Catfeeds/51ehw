<?php
/**
 * 商品
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
     * 查询所有店铺(活动测试需求)
     * 
     */
    function getallcorp(){
        $this->db->select('id,corporation_name');
        $this->db->from('customer_corporation');
        $this->db->limit(10,0);
        $array = $this->db->get()->result_array();
        return $array;
    }
    
    /**
     * 企业关联用户
     */
    function load_corp_customer_info( $customer_id )
    { 
        $this->db->select('c.id as customer_id,cc.id as corporation_id , cc.app_id, cc.agent_id,c.parent_id');
        $this->db->from('customer as c');
        $this->db->join('customer_corporation as cc','cc.customer_id = c.id','left');
        $this->db->where('c.id',$customer_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 审核
     */

    /**
	* 新增或更新店铺
	* @param $customer_id 管理员id
	* @param $$grade 
    */
    function add_customer_corporation($customer_id, $grade,$deposit)
    {	
    	if($customer_id && $grade){

    		// 先判断用户是否已经注册了店铺
    		$this->db->select('id');
    		$this->db->where('customer_id',$customer_id);
    		$info = $this->db->get('customer_corporation')->row_array();
    		// $info = false;
    		if($info){
    			$this->db->where('customer_id',$customer_id);
                $this->db->set('grade',$grade);
                $this->db->set('deposit',$deposit);
                $this->db->update('customer_corporation');
                return $info['id'];
    		}else{
    			$this->db->set('customer_id',$customer_id);
                $this->db->set('grade',$grade);
    			$this->db->set('deposit',$deposit);
    			$this->db->insert('customer_corporation');
    			return $this->db->insert_id();
    		}
    	}
    	
    }

        /**
    	* 保存店铺第二步信息
    	* @param $customer_id 管理员id
    	* @param $$grade 
        */
    function update_customer_corporation($array, $corporation_id)
    {
    	if($array && $corporation_id){
    		$this->db->where('id',$corporation_id);
    		$this->db->set($array);
    		$this->db->update('customer_corporation');
    		return $this->db->affected_rows();
    	}
    }
	

	function get_customer_status($corporation_id,$customer_id)
	{
		if($corporation_id && $customer_id){
            $this->db->where('id', $corporation_id);
			$this->db->where('customer_id', $customer_id);
			$res = $this->db->get('customer_corporation')->row_array();
            // var_dump($res);
			return $res;
		}
	}

    // 支付成功后修改状态
    public function customer_corporation_update( $corporation_id = 0  )
    {
        if( !$corporation_id )
        { 
            return false;
        }
        
        $this->db->set('status', 1);
        $this->db->set('is_paied', 1);
        $this->db->where('id', $corporation_id);
        $this->db->update('customer_corporation');
        return $this->db->affected_rows();
    }


    /**
    * 根据用户id查询店铺id
    * @param $customer_id
    * @return array
    */
    public function get_corporation_by_uid($customer_id)
    {
        if($customer_id){
            $this->db->where('customer_id', $customer_id);
            return $this->db->get('customer_corporation')->row_array();
        }
    }
	// --------------------------------------------------------------------
	/**
	 * 创建店铺
	 * @date:2017年12月8日 下午5:07:18
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
    public function create( $data = array() ) 
    {
        if( !empty( $data )  && is_array( $data ) )
        { 
            $this->db->insert('customer_corporation',$data);
            return $this->db->insert_id();
        }
        
        return false;
    }
	

}