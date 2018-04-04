<?php
/**
 * 
 *
 *
 */
class Charge_set_mdl extends CI_Model {
	/**
	 * 构造函数
	 */
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 获取可充值金额列表
	 */
	public function get_charge_set() {
		$this->db->from ( "charge_set" );
		$this->db->order_by ( "charge_unit", "ASC" );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	// -----------------------------------------------------
	
	/**
	 * 充值后获取奖励
	 *
	 * @param unknown $amount        	
	 */
	public function get_charge_amount($amount) {
		$query = $this->db->get_where ( "charge_set", array (
				"charge_unit" => $amount 
		) );
		if ($row = $query->row_array ()) {
			return $row ['charge_unit'] + $row ['charge_plus'];
		} else {
			return $amount;
		}
	}
	
	/**
	 * 充值奖励产品
	 * 
	 * @param unknown $amount        	
	 */
	public function get_charge_product($amount) {
		$this->db->from("charge_set");
		$this->db->where ( "charge_unit <", $amount );
		$this->db->order_by ( "charge_unit", "DESC" );
		$this->db->limit ( 1 );
		$query = $this->db->get ();
		if ($row = $query->row_array ()) {
			return $row ['plus_product_id'];
		} else {
			return 0;
		}
	}
}
?>