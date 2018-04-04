<?php
/**
 * 
 * 部落-圈子话题。
 *
 */

class  Tribe_upvote_mdl extends CI_Model {



	function __construct() 
	{
		parent::__construct ();
	}

	
    public function Create( $data = array() )
    { 
        if( !$data )
            return array();
        
        $this->db->insert('tribe_upvote',$data);
        return $this->db->insert_id();
    }
    
    public function Load( $sift = array() )
    { 
        $this->db->from('tribe_upvote');
        $this->db->where('customer_id',$sift['where']['customer_id']);
        $this->db->where('obj_id',$sift['where']['obj_id']);
        $this->db->where('type',$sift['where']['type']);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function Del( $sift = array() )
    { 
        if( empty( $sift['where']['obj_id'] ) || empty( $sift['where']['type'] ) || empty( $sift['where']['customer_id'] ) )
            return array();
        $this->db->where('customer_id',$sift['where']['customer_id']);
        $this->db->where('obj_id',$sift['where']['obj_id']);
        $this->db->where('type',$sift['where']['type']);
        $this->db->delete('tribe_upvote');
        return $this->db->affected_rows();
    }
    
}
 