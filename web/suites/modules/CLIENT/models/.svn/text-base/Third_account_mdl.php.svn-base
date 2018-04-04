<?php
/**
 * 
 *
 *
 */
class Third_account_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 获取接入信息
	 * 
	 * @param number $app_id        	
	 */
	function get_info($third_name, $app_id = 0) {
		$query = $this->db->get_where ( 'third_account', array (
				'app_id' => $app_id,
				'third_name' => $third_name 
		) );
		
		return $query->row_array();
	}
	
	// --------------------------------------------------------------------
}