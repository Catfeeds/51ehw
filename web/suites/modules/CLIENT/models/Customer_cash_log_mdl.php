<?php
/**
 * 
 *
 *
 */
class Customer_cash_log_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	
	function getListByIdfrom($userid)
	{
	    if(!$userid)
	        return array();
	    $this->db->from("customer_cash_log as cl");
	    $this->db->join("datadictionary as d","cl.id_event = d.id","left");
	    $this->db->where("id_from",$userid);
	    $this->db->or_where("id_to",$userid);
	    $this->db->order_by("created_at","desc");
	    //$this->db->limit(10,0);
	    $query = $this->db->get();
// 	    echo $this->db->last_query();exit;
	    if($row = $query->result_array()){
	        return $row;
	    }
	    return array();
	}
	
}