<?php
/**
 * 
 * 购物车模型
 *
 */
class Agent_mdl extends CI_Model {
	
    var $agent_name;
    var $password;
	

	function __construct() {
		parent::__construct ();
		
	}
	
	//-------------------------------------------------
	
    function check_agent(){
        
        $query = $this->db->get_where("agent",array(
            "agent_name" => $this->agent_name,
            "password" => md5( $this->password )
        ))->result_array();
//         print_r($query);exit;
        if(count($query)>0){
            return $query[0];
        }
        
        return array();
    }
    

}