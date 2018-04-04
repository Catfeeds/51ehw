<?php
/**
 * 用户浏览记录
 */
class Customer_browsing_history_mdl extends CI_Model {

    var $id;
    var $customer_id = 0;
    var $product_id = 0;
    var $cate_id = 0;
    var $p_name = '';
    var $p_price = 0.00;
    var $created_at;
    var $goods_thumb;
    
    /**
     * 构造函数
     */
	function __construct() {
		parent::__construct ();
	}

	// --------------------------------------------------------------------

	/**
	 * 获取浏览记录列表
	 * @param number $limit
	 * @param number $offset
	 * @param unknown $select
	 */
	public function get_lists_with_condition($limit = 0, $offset = 0 ,$select = null)
	{
	    $customer_id = $this->session->userdata("user_id");
        if ($offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        if(!$select){
            $select = "c.*";
        }
        
        $this->db->select($select);
        $this->db->from('customer_browsing_history c');
        $this->db->where(array("customer_id" => $customer_id));
        $this->db->order_by('created_at desc');
        
        $query = $this->db->get();
        return $query->result_array();	    
	}

	// --------------------------------------------------------------------

	/**
	 * 获取浏览记录列表数量
	 */
	public function get_count_with_condition()
	{
	    $customer_id = $this->session->userdata("user_id");
        $this->db->select('*');
        $this->db->from('customer_browsing_history');
        $this->db->where(array("customer_id" => $customer_id));
        
        $res = $this->db->count_all_results();
        return $res;
	}

	// --------------------------------------------------------------------
	
	/**
	 * 根据product_id获取，检查是否需要插入浏览记录
	 * @param number $product_id
	 * @param string $select
	 */
	public function load_by_condition($product_id = 0 ,$select = "*")
    {
	    $customer_id = $this->session->userdata("user_id");
        $this->db->select($select);
        $this->db->from('customer_browsing_history');
        $this->db->where(array("customer_id" => $customer_id,"product_id" => $product_id));
        
        $query = $this->db->get();
        return $query->row_array();
    }

	// --------------------------------------------------------------------

    /**
     * 插入浏览记录，最多保存$keep条
     * @param number $keep
     */
	public function create( $keep = 100)
	{
	    $this->limit_delect($keep);
	    
	    $date = date("Y:m:d H-i-s");
	    $this->db->set('customer_id',$this->customer_id);
	    $this->db->set('product_id',$this->product_id);
	    $this->db->set('cate_id',$this->cate_id);
	    $this->db->set('p_name',$this->p_name);
	    $this->db->set('p_price',$this->p_price);
	    $this->db->set('goods_thumb',$this->goods_thumb);
	    $this->db->set('created_at',$date);
	    
		$this->db->insert ( 'customer_browsing_history');

		return $this->db->insert_id();
	}

	// --------------------------------------------------------------------

	/**
	 * 删除浏览记录，商品id为0则清空浏览记录
	 * @param number $product_id
	 * @return number
	 */
	public function delete($product_id=0)
	{
	    $customer_id = $this->session->userdata("user_id");
	    
	    if(!$customer_id){
	        return 0;
	    }
	    if($product_id){
	        $this->db->where_in('product_id',$product_id);
	    }
	    $this->db->where('customer_id',$customer_id);
	    
	    if($this->db->delete('customer_browsing_history')){
	        return 1;
	    }else{
	        return 0;
	    }
	}

	// --------------------------------------------------------------------
	
	/**
	 * 删除第$limit条之后的数据
	 * @param unknown $limit
	 */
	public function limit_delect( $keep )
	{
	    $customer_id = $this->session->userdata("user_id");
	    
	    $this->db->select('id');
	    $this->db->from('customer_browsing_history');
	    $this->db->where('customer_id',$customer_id);
	    $this->db->order_by('id desc');
	    $this->db->limit(1,$keep-1);
	    $query = $this->db->get();
	    $id = $query->row_array();
	    if(count($id)>0){
    	    $this->db->where('id',$id['id']);
    	    if($this->db->delete('customer_browsing_history')){
    	        return 1;
    	    }else{
    	        return 0;
    	    }
	    }
	    return 1;
	}

	// --------------------------------------------------------------------
	
    
	// --------------------------------------------------------------------


	// --------------------------------------------------------------------


	// --------------------------------------------------------------------
	
}