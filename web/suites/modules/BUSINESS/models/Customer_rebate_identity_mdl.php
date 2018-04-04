<?php
/**
 * 分成身份模块操作。
 * @author fxm
 *
 */
class Customer_rebate_identity_mdl extends CI_Model {
     
	function __construct() 
	{
		parent::__construct ();
	}
	
	
	/**
	 * 查询当前用户的身份.
	 */
	public function Load_Customer_Identity( $customer_id = 0 )
	{ 
	    $this->db->select('cri.identity_id,ri.identity_name,ri.level,ri.rebaterate_description');
	    $this->db->from('customer_rebate_identity as cri');
	    $this->db->join('rebate_identity as ri','cri.identity_id = ri.identity_id');
	    $this->db->where('cri.customer_id',$customer_id);
	    $query = $this->db->get();
	    
	    return $query->row_array();
	}
	
	/**
	 * 查询身份列表。
	 */
	public function Load_Identity()
	{ 
	    $query = $this->db->get('rebate_identity');
	    return $query->result_array();
	}
	
	/**
	 * 查询某个身份并且查询申请记录。
	 */
	public function Identity_Info( $identity = 0,$customer_id = 0 )
	{
	    $this->db->select('ri.*,ari.identity_id as is_apply');
	    $this->db->from('rebate_identity as ri');
	    $this->db->join('apply_rebate_identity as ari','ari.customer_id = '.$customer_id.' and ari.identity_id = ri.identity_id','left');
	    $this->db->where('ri.identity_id',$identity );
	    $this->db->group_by('ri.identity_id');
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	
	/**
	 * 添加身份申请的升级记录。
	 */
	public function Create_Apply_Rebate_Identity( $data )
	{ 
	    if( !is_array( $data ) )
	    { 
	        return false;
	    }
	    
	    $this->db->insert('apply_rebate_identity',$data);
	    return $this->db->insert_id();
	    
	}
	
	
	
	
	
	
}