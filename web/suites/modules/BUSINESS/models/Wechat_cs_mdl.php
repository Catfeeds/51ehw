<?php
/**
 * 
 *
 *
 */
class Wechat_cs_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
    
    function create($data){
    	$data['create_time'] = date('Y-m-d h:i:s');
    	$this->db->insert('wechat_cs', $data);
    	error_log($this->db->last_query());
    }

}