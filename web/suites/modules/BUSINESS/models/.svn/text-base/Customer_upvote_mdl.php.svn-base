<?php
/**
 * 
 *
 *
 */
class Customer_upvote_mdl extends CI_Model {
     
	function __construct() {
		parent::__construct ();
	}
	
	
	/**
	 * 
	 * @param unknown $from_customer_id 点赞用户
	 * @param unknown $customer_id 被点赞用户
	 */
	public function Detaile($from_customer_id = 0 , $customer_id = 0 ) 
	{
	    $query = $this->db->get_where('customer_upvote',array('from_customer_id'=>$from_customer_id,'to_customer_id'=>$customer_id) );
	    return $query->row_array();
	}
	
	/**
	 * 统计该用户被点赞了多少次+判断A用户是否点赞了B用户。
	 * @param number $customer_id 用户ID
	 */
	public function Count_Customer_Upvote( $from_customer_id = 0, $customer_id = 0 )
	{ 
	    $this->db->select('count(id) as num');
	    $this->db->from('customer_upvote');
	    $this->db->where('to_customer_id',$customer_id);
	    $query = $this->db->get();
	    return $query->row_array();
	    
	}
	
	
    /**
	 * 创建
	 * @param unknown $data
	 */
	public function Create( $data )
	{ 
	    if( !empty( $data ) )
	    {
    	    $this->db->insert('customer_upvote',$data);
    	    return $this->db->insert_id();
	    }
	    
	    return array();
	}
	
	/**
	 * 删除
	 */
	public function Delete( $sift = array() )
	{ 

	    if( !empty( $sift['where']['id'] ) && !empty( $sift['where']['from_customer_id'] ) )
	    {
	    
	        $this->db->where('from_customer_id',$sift['where']['from_customer_id']);
	        $this->db->where('id',$sift['where']['id']);
	        $this->db->delete('customer_upvote');
	        return $this->db->affected_rows();
	    }
	    
	    return false;
	}
}