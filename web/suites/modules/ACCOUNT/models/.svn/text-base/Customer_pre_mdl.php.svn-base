<?php
/**
 * 预注册模块
 *
 *
 */
class Customer_pre_mdl extends CI_Model {
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
	}

	// -----------------------------------------------------------------
	
	/**
	 * 预注册
	 */
	public function add($data){
	    $this->db->insert('pre_customer', $data);
	    return $this->db->insert_id();
	}
	
	// -----------------------------------------------------------------
	
	/**
	 * 检查是否预注册
	 * @param int 用户id
	 */
	public function check_customer($customer_id){
	    return $this->db->get_where("pre_customer",array("customer_id"=>$customer_id))->row_array();
	}
	
	// -----------------------------------------------------------------
	
	/**
	 * 更新
	 * @param int $customer_id 用户id
	 * @param $data 更改数据
	 */
	public function update($customer_id,$data){
	    $this->db->set($data);
	    $this->db->where("customer_id",$customer_id);
	    $this->db->update("pre_customer");
	    return $this->db->affected_rows();
	}
	
	

}
?>