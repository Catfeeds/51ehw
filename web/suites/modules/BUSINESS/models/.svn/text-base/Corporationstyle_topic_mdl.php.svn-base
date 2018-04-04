<?php
/**
* @author JF
* 2017年11月10日
* 企业形象
*/

class  Corporationstyle_topic_mdl extends CI_Model {



	function __construct() 
	{
		parent::__construct ();
	}

    /**
     * 添加
     */	
	
	public function Create( $data = array() )
	{ 
	    
	    $this->db->insert('corporationstyle_topic',$data);
	    return $this->db->insert_id();
	}
	/**
	* @author JF
	* 2017年11月10日
	* 根据部落id or 用户id 查询话题
	* @param int $tribe_id 部落id
	* @param int $user_id 用户id
	*/
	public function Load($tribe_id,$customer_id,$limit=0,$offset=0) 
	{
		$this->db->select("any_value(a.member_name) as member_name,b.*,e.real_name,e.name,e.wechat_avatar,e.brief_avatar,any_value(f.organization_name) as organization_name,any_value(f.organizationl_duties) as organizationl_duties");
	    $this->db->select("any_value(g.id) as corp_id");
		$this->db->from("tribe_staff as a");
	    $this->db->join("corporationstyle_topic as b","a.customer_id = b.customer_id");
	    $this->db->join("customer as e","b.customer_id = e.id");
	    $this->db->join("customer_identity as f","e.id = f.customer_id","left");
	    $this->db->join("customer_corporation as g","g.customer_id = b.customer_id and g.approval_status = 2 and g.status = 1","left");
	    $this->db->where("a.status",2);
	    if($tribe_id){
	    	$this->db->where("a.tribe_id",$tribe_id);
	    }else{
	    	$this->db->where("b.customer_id",$customer_id);
	    }
	    $this->db->where("b.status",1);
	    $this->db->group_by("b.id");
	    $this->db->order_by("b.id","desc");
	    if($limit){
    	   $this->db->limit($limit,$offset);
	    }
	    $query = $this->db->get();
	    if($limit){
   	        return $query->result_array();
	    }else{
            return $query->num_rows();
	    }
	   
	}
	
	/**
	* @author JF
	* 2017年11月10日
 	* 获取点赞人的昵称
 	* @param array $topicids 话题id
	*/
	public function topic_upvote_member_name($topicids){
	    $this->db->select("a.id,any_value(c.customer_id) as customer_id,any_value(c.member_name) as member_name,d.real_name,d.name");
	    $this->db->from('corporationstyle_topic as a');
	    $this->db->join('corporationstyle_upvote  as b','b.obj_id = a.id');
	    $this->db->join('tribe_staff as c','b.customer_id = c.customer_id');
	    $this->db->join('customer as d','d.id = c.customer_id','left');
	    $this->db->where_in("a.id",$topicids);
	    $this->db->where('a.status',1);
	    $this->db->where('c.status',2);
	    $this->db->group_by("b.id");
	    $query = $this->db->get();
	    return $query->result_array();
	}
	/**
	 * 查询单条记录
	 * @param int $topic_id 话题id
	 */
	public function Load_Row( $topic_id ){ 
		if(!$topic_id){
	        return array();
		}
	    $this->db->from('corporationstyle_topic');
	    $this->db->where('id',$topic_id);
	    $query = $this->db->get();
	    return $query->row_array();
	}
	

	/**
	 * 更新
	 */
	public function Update($id,$custoner_id,$param)
	{
	    $this->db->set($param);
        $this->db->where('id',$id );
        $this->db->where('customer_id',$custoner_id);
        $this->db->update('corporationstyle_topic');
        return $this->db->affected_rows();
	}
	
	/**
	* @author JF
	* 2018年1月30日
	* 获取话题详情
	* @param number $topicid 话题id
	*/
	function TopicDetail($topicid) {
	    $this->db->select("any_value(a.member_name) as member_name,b.*,count(distinct(c.id)) as upvote_num,count(distinct(d.id))as comment_num,e.real_name,e.name,e.wechat_avatar,e.brief_avatar,any_value(f.organization_name) as organization_name,any_value(f.organizationl_duties) as organizationl_duties");
	    $this->db->select("any_value(g.id) as corp_id");
	    $this->db->from("tribe_staff as a");
	    $this->db->join("corporationstyle_topic as b","a.customer_id = b.customer_id");
	    $this->db->join("corporationstyle_upvote as c","b.id = c.obj_id","left");
	    $this->db->join("corporationstyle_comment as d","b.id = d.obj_id and d.is_delete = 0","left");
	    $this->db->join("customer as e","b.customer_id = e.id");
	    $this->db->join("customer_identity as f","e.id = f.customer_id","left");
	    $this->db->join("customer_corporation as g","g.customer_id = b.customer_id and g.approval_status = 2 and g.status = 1","left");
	    $this->db->where("a.status",2);
	    $this->db->where("b.id",$topicid);
	    $this->db->where("b.status",1);
	    $this->db->group_by("b.id");
	    $query = $this->db->get();
	    return $query->row_array();
	}

}
 