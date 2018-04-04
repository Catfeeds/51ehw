<?php

/**
 * 圈子评论
 *
 *
 */
class Tribe_comment_mdl extends CI_Model
{
    function __construct()
    { 
        parent::__construct ();
    }
    
    /**
     * 添加评论表
     */
    public function Create ( $data = array() )
    { 
        if( !$data )
            return array();
        $this->db->insert('tribe_comment',$data );
        return $this->db->insert_id();
        
    }
    
    /**
     * 查询某个对象的评论
     */
    public function Load ( $sift = array () )
    { 
        
        $limit = '';
        if( !empty( $sift['page']['limit'] ) ){
            $limit = "limit {$sift['page']['limit']}";
        }
        if( !empty( $sift['page']['offset'] ) ){
            $limit = "limit {$sift['page']['offset']},{$sift['page']['limit']}";
        }
        $query = $this->db->query("
            select tc.* ,any_value(ts.id) as ts_id,any_value(ts.member_name) as member_name, any_value(c.mobile) as mobile , any_value(c.wechat_avatar) as wechat_avatar, 
            any_value(c.brief_avatar) as brief_avatar,any_value(tss.member_name) as to_member_name , any_value(cc.corporation_name) as corporation_name,any_value(ts.corporation_name) as ts_corporation_name, any_value(cc.id) as corp_id,any_value(cc.status) as cc_status,
            any_value(c.real_name) as real_name from (
            select a.* from 9thleaf_tribe_comment as a
            join 9thleaf_tribe_staff as b on a.customer_id = b.customer_id   and b.status =2   and a.tribe_id = b.tribe_id
            where a.tribe_id = {$sift['where']['tribe_id']} and a.obj_id = {$sift['where']['obj_id']}
            ) as tc 
            join 9thleaf_tribe_staff as tss on tc.to_customer_id = tss.customer_id   and tss.status =2  or tc.to_customer_id is null
            join 9thleaf_tribe_staff as ts  on tc.customer_id = ts.customer_id and ts.status =2 
            JOIN 9thleaf_customer as c ON c.id = tc.customer_id
            LEFT JOIN 9thleaf_customer_corporation as cc ON cc.customer_id = tc.customer_id
            WHERE tc.obj_id =  {$sift['where']['obj_id']}
            AND tc.type = 1
            AND ts.tribe_id = {$sift['where']['tribe_id']}
            AND tc.is_delete =0
            group by tc.id
            ORDER BY tc.id
            $limit
            
            ");
       
//         echo '<pre>';
//         echo $this->db->last_query();exit;
        return $query->result_array();
        
    }
    
    /**
     * 
     * @param array $sift
     * 更新
     */
    public function Update( $sift = array() )
    { 
        
        if( empty( $sift['where']['id'] ) || empty( $sift['where']['customer_id'] ) )
            return false;
            
        if( !empty( $sift['set']['is_delete'] ) )
            $this->db->set('is_delete',$sift['set']['is_delete']);
        
        $this->db->where('id',$sift['where']['id']);
        $this->db->where('customer_id',$sift['where']['customer_id']);
        $this->db->update('tribe_comment');
        return $this->db->affected_rows();
    }
    
    public function Load_Row( $id = 0 )
    { 
        
        return $this->db->get_where('tribe_comment',array('id'=>$id) )->row_array();;
        
    }
    
    
}