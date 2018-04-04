<?php

/**
* @author JF
* 2017年11月10日
* 企业形象话题消息
*/
class Corporationstyle_message_mdl extends CI_Model
{
    function __construct()
    { 
        parent::__construct ();
    }
    
    /**
     * 添加
     */
    public function Create ( $data = array() )
    { 
        $this->db->insert('corporationstyle_message',$data );
        return $this->db->insert_id();
    }
    
    
    
    /**
     * 列表
     * @param number $customer_id 用户id
     */
    public function Load($customer_id,$limit=null,$offset=null)
    { 
	   $this->db->select("a.*,b.wechat_avatar,b.brief_avatar,b.real_name,b.name,c.images,any_value(d.member_name) as member_name");
       $this->db->from("corporationstyle_message as a");
       $this->db->join("customer as b","a.form_customer_id = b.id");
       $this->db->join("corporationstyle_topic as c","a.obj_id = c.id");
       $this->db->join("tribe_staff as d","d.customer_id = b.id","left");
       $this->db->where("a.to_customer_id",$customer_id);
       $this->db->where("a.is_read",1);
       $this->db->group_by("a.id");
       $this->db->order_by("a.id","desc");
       if($limit){
           $this->db->limit($limit,$offset);
       }
       $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * 统计未读消息条数
     * @param number $to_customer_id 接收人id
     */
public function Not_Read_Num( $to_customer_id ) 
    {
    	if( !$to_customer_id ){
            return array();
    	}
        
        $this->db->from('corporationstyle_message');
        $this->db->where('to_customer_id',$to_customer_id);
        $this->db->where('is_read',1);
        
        $query = $this->db->get();
        
        return $query->num_rows();
    }
    
    
    
    /**
     * 更新消息
     * @param number $customer_id 用户id
     */
    public function Update($customer_id)
    { 
        $this->db->where('to_customer_id',$customer_id );
        $this->db->where('is_read',1);
        $this->db->set("is_read",2);
        $this->db->update('corporationstyle_message');
        return $this->db->affected_rows();
        
    }
    
    
//    /**
//     * 清空已读消息
//     */
//     public function Delete( $sift = array() ) 
//     {
//         if( empty($sift['where']['tribe_id']) ||  empty( $sift['where']['to_customer_id']) )
//             return array();
        
//         $this->db->where('to_customer_id',$sift['where']['to_customer_id'] );
//         $this->db->where('tribe_id',$sift['where']['tribe_id'] );
//         $this->db->where('is_read',$sift['where']['is_read'] );
//         $this->db->delete('tribe_message');
//         return $this->db->affected_rows();
//     }
   
    
}