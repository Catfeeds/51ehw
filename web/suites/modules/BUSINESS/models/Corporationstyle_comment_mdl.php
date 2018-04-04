<?php

/**
 * 圈子评论
 *
 *
 */
class Corporationstyle_comment_mdl extends CI_Model
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
        $this->db->insert('corporationstyle_comment',$data );
        return $this->db->insert_id();
        
    }
    
    /**
     * 查询某个对象的评论
     * @param array $id  帖子id 
     * @param number $trieb_id 部落id
     */
    public function Load ($id,$trieb_id = 5)
    { 
       	$this->db->select("a.*,any_value(c.member_name) as member_name,any_value(e.member_name) as to_member_name");
       	$this->db->select("b.real_name,b.name,b.wechat_avatar,b.brief_avatar");
       	$this->db->select("d.real_name as to_real_name,d.name as to_name,d.wechat_avatar as to_wechat_avatar,d.brief_avatar as to_brief_avatar");
       	$this->db->from("corporationstyle_comment as a");
       	$this->db->join("customer as b","a.customer_id = b.id");
       	$this->db->join("tribe_staff as c","b.id = c.customer_id ".($trieb_id?" and c.tribe_id = $trieb_id": null),"left");
       	$this->db->join("customer as d","a.to_customer_id = d.id","left");
       	$this->db->join("tribe_staff as e","d.id = e.customer_id ".($trieb_id?" and e.tribe_id = $trieb_id": null),"left");
       	$this->db->where_in("a.obj_id",$id);
       	$this->db->where("is_delete",0);
       	$this->db->group_by("a.id");
       	$query = $this->db->get();
        return $query->result_array();
        
    }
    
    /**
     * 
     * @param array $sift
     * 删除评论
     * @param number $id 评论id
     * @param number $customer_id 用户id
     */
    public function DeleteComment($id,$customer_id)
    { 
        $this->db->set('is_delete',1);
        $this->db->where('id',$id);
        $this->db->where('customer_id',$customer_id);
        $this->db->update('corporationstyle_comment');
        return $this->db->affected_rows();
    }
    
	/**
	* @author JF
	* 2017年11月14日
	* 根据id查询评论
	* @param number $id 评论id
	* @param number $obj_id 对象id
	*/
public function Load_Row( $id = 0 , $obj_id = 0)
    { 
		$this->db->where("obj_id",$obj_id);
        return $this->db->get_where('corporationstyle_comment',array('id'=>$id) )->row_array();
    }
    
    
}