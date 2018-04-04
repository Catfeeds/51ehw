<?php
/**
 * 
 *
 *
 */
class Customer_identity_mdl extends CI_Model {
     
	function __construct() {
		parent::__construct ();
	}
	
	
	/**
	 * 查看用户身份列表。
	 * @param number $customer_id
	 */
	public function Load( $customer_id = 0 )
	{ 
	    $query = $this->db->get_where('customer_identity',array('customer_id'=>$customer_id) );
	    return $query->result_array();
	}
	
	/**
	 * 创建
	 * @param unknown $data
	 */
	public function Create( $data )
	{ 
	    if( !empty( $data ) )
	    {
	        $this->db->insert_batch('customer_identity',$data);
    	    return $this->db->insert_id();
	    }
	    
	    return array();
	}
	
	/**
	 * 更新
	 */
	public function Update( $sift = array() )
	{ 
	    if( !empty( $sift['where']['id'] ) )
	    { 
	        $this->db->set('organization_name',$sift['set']['organization_name']);
	        $this->db->set('organizationl_duties',$sift['set']['organizationl_duties']);
	        $this->db->set('update_at',date('Y-m-d H:i:s') );
	        $this->db->where('id',$sift['where']['id']);
	        
	        if( !empty( $sift['where']['customer_id'] ) )
	        {
	            $this->db->where('customer_id',$sift['where']['customer_id']);
	        }
	        
	        $this->db->update('customer_identity');
	        return $this->db->affected_rows();
	    }
	}
	
	public function Detaile( $id = 0, $customer_id = 0 )
	{ 
	    if( $customer_id )
	        $this->db->where('customer_id', $customer_id);
	    
	    $query = $this->db->get_where('customer_identity',array('id'=>$id) );
	    return $query->row_array();
	}
	
	/**
	 * 用户信息-单个身份。
	 */
	public function Customer_Info_Identity( $customer_id = 0 ,$tribe_id = 0)
	{ 
	    $this->db->select('c.id,c.name,c.wechat_avatar,c.brief_avatar,c.real_name,c.mobile,any_value(ci.organization_name) as organization_name ,any_value(ci.organizationl_duties) as organizationl_duties');
	    $this->db->from('customer as c');
	    $this->db->join('customer_identity as ci','ci.customer_id = c.id','left');
	    if($tribe_id){
	        $this->db->select("any_value(ts.member_name) as member_name");
	        $this->db->join("tribe_staff as ts","ts.customer_id = c.id and ts.tribe_id = $tribe_id ","left");
	    }
	    $this->db->where('c.id',$customer_id);
	    $this->db->group_by('ci.customer_id');
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	
	
	/**
	 * 预录入用户同步多个身份
	 */
	public function add_idenity_batch($data){
	    $this->db->insert_batch('customer_identity',$data);
	    $affected_rows = $this->db->affected_rows();
	}
}