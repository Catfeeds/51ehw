<?php
/**
 *API 
 *Token
 *
 */
class Token_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
    
    public function getBySign($sign)
    {
    	
        if (!$sign){
            return array();
        }
        
		$this->db->select('ad_info.*,ad_position.po_sign');
		$this->db->from('ad_info');
		$this->db->join('ad_position',' ad_info.po_id = ad_position.po_id');
		
        $query = $this->db->where('po_sign',$sign)->get();

        if ($row = $query->result_array()){
            return $row;
        }

        return array();
    }
 
}