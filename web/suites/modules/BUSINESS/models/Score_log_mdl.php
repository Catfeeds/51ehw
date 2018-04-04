<?php
/**
 * 常见问题
 *
 *
 */
class Score_log_mdl extends CI_Model
{


    
	function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    /**
	 * load by id
	 *
	 *
	 */	
    function load($id)
    {
        if (!$id){
            return array();
        }

        $query = $this->db->get_where('score_log',array('id' => $id));

        if ($row = $query->row_array()){
            return $row;
        }

        return array();
    }

    // --------------------------------------------------------------------
    /**
	 * get list
	 *
	 *
	 */	
    function get_list($customer_id = 0, $type = 1)
    {

        $query = $this->db->get_where('score_log',array('customer_id' => $customer_id, 'type' => $type));

        if ($row = $query->result_array()){
            return $row;
        }

        return array();
    }

    // --------------------------------------------------------------------
}
?>