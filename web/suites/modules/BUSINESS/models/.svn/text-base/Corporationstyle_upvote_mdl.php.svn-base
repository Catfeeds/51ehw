<?php
/**
* @author JF
* 2017年11月10日
* 企业形象 - 点赞
*/
class  Corporationstyle_upvote_mdl extends CI_Model {



	function __construct() 
	{
		parent::__construct ();
	}

	/**
	* @author JF
	* 2017年11月10日
	* 话题点赞
	*/
    public function Create( $data = array() )
    { 
        if( !$data )
            return array();
        
        $this->db->insert('corporationstyle_upvote',$data);
        return $this->db->insert_id();
    }
    
    /**
    * @author JF
    * 2017年11月10日
    * 根据用户id查询话题是否点赞
    * @param int $customer_id 用户id
    * @param int $obj_id 对象id 
    */
    public function Load( $customer_id , $obj_id )
    { 
        $this->db->from('corporationstyle_upvote');
        $this->db->where('customer_id',$customer_id);
        $this->db->where('obj_id',$obj_id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
    * @author JF
    * 2017年11月10日
    * 根据用户id删除点赞
    * @param int $customer_id 用户id
    * @param int $obj_id 对象id 
    */
    public function Del( $customer_id , $obj_id )
    { 
        
    	$this->db->where('customer_id',$customer_id);
    	$this->db->where('obj_id',$obj_id);
        $this->db->delete('corporationstyle_upvote');
        return $this->db->affected_rows();
    }
    
}
 