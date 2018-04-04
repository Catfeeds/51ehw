<?php

/**
 * 圈子消息
 *
 *
 */
class Tribe_message_mdl extends CI_Model
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
        if( !$data )
            return array();
        
        $this->db->insert('tribe_message',$data );
        return $this->db->insert_id();
        
    }
    
    
    
    /**
     * 列表
     */
    public function Load( $sift = array() )
    { 
//         $this->db->select('tm.*,ts.member_name,c.wechat_avatar,tt.images');
        $this->db->select('if( tm.type=2,concat(tm.form_customer_id,tm.to_customer_id,tm.tribe_id,tm.obj_id) ,tm.id) as test, any_value(c.real_name) as real_name,any_value(c.mobile) as mobile,
any_value(ts.member_name) as member_name, any_value(tm.created_at) as created_at,any_value(tm.form_customer_id) as form_customer_id,any_value(tm.content_obj_id) as content_obj_id,any_value(c.wechat_avatar) as wechat_avatar,any_value(c.brief_avatar) as brief_avatar, any_value(tt.images) as images,any_value(tm.id) as id , any_value(tm.obj_id) as obj_id ,any_value(tm.content) as content,any_value(tm.type) as type,any_value(cc.id) as corp_id,any_value(cc.corporation_name) as corporation_name,any_value(tt.content) as topic_content');
        $this->db->from('tribe_message as tm');
        $this->db->join('tribe_staff as ts','ts.customer_id = tm.form_customer_id and ts.tribe_id = tm.tribe_id','left');
        $this->db->join('customer as c','c.id = tm.form_customer_id','left');
        $this->db->join('customer_corporation as cc','cc.customer_id = tm.form_customer_id','left');
        $this->db->join('tribe_topic as tt','tt.id = tm.obj_id','left');
        $this->db->where('tm.tribe_id',$sift['where']['tribe_id']);
        $this->db->where('tm.to_customer_id',$sift['where']['to_customer_id']);
        
        if( !empty( $sift['where']['is_read'] ) )
            $this->db->where('tm.is_read', $sift['where']['is_read']);
        if( !empty( $sift['page']['limit'] ) )
            $this->db->limit( $sift['page']['limit'] );
        if( !empty( $sift['page']['offset'] ) )
            $this->db->offset( $sift['page']['offset'] );
        
        $this->db->group_by('test');
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * 统计未读消息条数
     */
    public function Not_Read_Num( $sift = array() ) 
    {
        if( empty($sift['where']['tribe_id']) ||  empty( $sift['where']['to_customer_id']) )
            return array();
        
        $this->db->select('count( distinct if( type=2, concat(form_customer_id, to_customer_id, tribe_id, obj_id,type), id)  ) as not_read_num');
        $this->db->from('tribe_message');
        $this->db->where('tribe_id',$sift['where']['tribe_id']);
        $this->db->where('to_customer_id',$sift['where']['to_customer_id']);
        $this->db->where('is_read',1);
        
        $query = $this->db->get();
        
        return $query->row_array();
    }
    
    
    
    /**
     * 更新消息
     */
    public function Update( $sift = array() )
    { 
        if( !empty( $sift['set']['is_read'] ) )
            $this->db->set('is_read',$sift['set']['is_read'] );
        
         
        $this->db->where('to_customer_id',$sift['where']['to_customer_id'] );
        $this->db->where('tribe_id',$sift['where']['tribe_id'] );
        $this->db->where('is_read',$sift['where']['is_read'] );
        
        $this->db->update('tribe_message');
        return $this->db->affected_rows();
        
    }
    
    
   /**
    * 清空已读消息
    */
    public function Delete( $sift = array() ) 
    {
        if( empty($sift['where']['tribe_id']) ||  empty( $sift['where']['to_customer_id']) )
            return array();
        
        $this->db->where('to_customer_id',$sift['where']['to_customer_id'] );
        $this->db->where('tribe_id',$sift['where']['tribe_id'] );
        $this->db->where('is_read',$sift['where']['is_read'] );
        $this->db->delete('tribe_message');
        return $this->db->affected_rows();
    }
   
    
}