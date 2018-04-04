<?php
/**
 * 日志表模块
 *
 *
 */
class Action_log_mdl extends CI_Model {

	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
	}

	// --------------------------------------------------------------------

	public function create($data){
	    $this->db->insert('action_log', $data);
        return $this->db->insert_id();
	}
}