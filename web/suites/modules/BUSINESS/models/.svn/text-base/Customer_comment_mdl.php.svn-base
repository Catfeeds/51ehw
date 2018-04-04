<?php
/**
 * 用户对用户的评价。
 */
class Customer_comment_mdl extends CI_Model
{

    
	function __construct()
    {
        parent::__construct();
    }
    
    public function Create( $data = array() )
    { 
        if( !empty( $data ) )
	    {
    	    $this->db->insert('customer_comment',$data);
    	    return $this->db->insert_id();
	    }
	    
	    return array();
    }
    
  
    
    /**
     *
     * @param number $customer_id 用户收到的评价列表。
     * @param  type  1:商业机构 2:非商业机构 3:社会组织
     */
    public function Load_List( $customer_id = 0 ,$limit = 0 ,$offset = 0 ,$type = 0)
    {
        $this->db->select("cc.id,c.name,c.wechat_avatar,any_value(cc.from_customer_id) as from_customer_id,c.brief_avatar,c.real_name, any_value(cc.content) as content, any_value(ci.organization_name) as organization_name, any_value(ci.organizationl_duties) as organizationl_duties, any_value(ci.created_at) as ci_created_at");
        $this->db->from("customer_comment as cc ");
        $this->db->join("customer as c","c.id = cc.from_customer_id");
        if($type){
            $this->db->join("customer_identity as ci","ci.customer_id = cc.from_customer_id",'left');
            $this->db->order_by('ci_created_at',"ASC");
        }else{
            $this->db->join("customer_identity as ci","ci.customer_id = cc.from_customer_id",'left');
        }
       
        
        $this->db->where("cc.to_customer_id",$customer_id);
        $this->db->group_by('cc.id');
        
        if($offset){
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }
        
        $query = $this->db->get()->result_array();
       
        return $query;
    }
    
    //查询一条。
    public function Detail( $sift = array() )
    { 
        if( !empty( $sift['where']['id'] ) )
            $this->db->where('id',$sift['where']['id']);
        
        if( !empty( $sift['where']['from_customer_id'] ) )
            $this->db->where('from_customer_id',$sift['where']['from_customer_id']);
        
        if( !empty( $sift['where']['to_customer_id'] ) )
            $this->db->where('to_customer_id',$sift['where']['to_customer_id']);
        
        $this->db->from('customer_comment');
        
        return $this->db->get()->row_array();
    }

    /**
     * 更新评论
     */
    public  function  del_comment($sift = array()){
        $this->db->where("id",$sift['where']['id']);
        $this->db->delete('customer_comment');
        return $this->db->affected_rows();
    } 
    
    
    
}