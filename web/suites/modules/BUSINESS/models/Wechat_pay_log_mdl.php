<?php
/**
 * 微信支付日志
 *
 *
 */
class Wechat_pay_log_mdl extends CI_Model {
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
	public function create($data){
		$this->db->insert("wechat_pay_log", $data);
	}
}
?>