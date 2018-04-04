<?php
/**
 * 
 * 部落-圈子话题。
 *
 */

class  Tribe_topic_mdl extends CI_Model {



	function __construct() 
	{
		parent::__construct ();
	}

    /**
     * 添加
     */	
	public function Create( $data = array() )
	{ 
	    
	    $this->db->insert('tribe_topic',$data);
	    return $this->db->insert_id();
	}
	/**
	 * 查询部落中的话题。
	 */
	public function Load ( $sift = array(), $not_sort = '' ) 
	{
	    $where = '';
	    $obj_id = '';
	    $order_by= '';
	    
	    if( !empty( $sift['where']['id'] ) ){
	        $where = " AND tt.id = {$sift['where']['id']}";
	        $obj_id = "and a.obj_id = {$sift['where']['id']}";
	    }
	    $limit = '';
	    if( !empty( $sift['page']['limit'] ) ){
	        $limit = "limit {$sift['page']['limit']}";
	    }
        if( !empty( $sift['page']['offset'] ) ){
            $limit = "limit {$sift['page']['offset']},{$sift['page']['limit']}";
        }
          
        
        if( is_array( $sift['where']['tribe_id'] ) )
        { 
            $trie_id_sql = ' in ('.implode($sift['where']['tribe_id'],',').')';
        }else { 
            $trie_id_sql = ' = '.$sift['where']['tribe_id'];
        }
       
        if( !$not_sort )
        {
            $order_by = '`tt`.`sort` DESC,';
        }
        
	   $query =  $this->db->query("
	        SELECT `tt`.*, `ts`.`id` as `ts_id`, `ts`.`member_name`, `cc`.`corporation_name`,`ts`.`corporation_name` as ts_corporation_name, `cc`.`id` as `corp_id`, `c`.`real_name`, `c`.`wechat_avatar`, `c`.`brief_avatar`, count( DISTINCT tu.id)+upvote_num as upvote_num, count( DISTINCT tu.customer_id = {$sift['where']['customer_id']} or null) as my_upvote, count(DISTINCT tc.id) as comment_num
            FROM `9thleaf_tribe_topic` as `tt`
            JOIN `9thleaf_tribe_staff` as `ts` ON `ts`.`tribe_id` = `tt`.`tribe_id` and `ts`.`customer_id` = `tt`.`customer_id`
            LEFT JOIN `9thleaf_customer` as `c` ON `c`.`id` = `tt`.`customer_id`
            LEFT JOIN `9thleaf_customer_corporation` as `cc` ON `cc`.`customer_id` = `tt`.`customer_id` and `tt`.`status` = 1 and cc.status = 1 and cc.approval_status = 2
            LEFT JOIN (
            	 select a.* from  `9thleaf_tribe_upvote` as a 
             	 JOIN 9thleaf_tribe_staff as b on a.customer_id = b.customer_id and b.status = 2 and b.tribe_id  {$trie_id_sql}
              	 JOIN 9thleaf_tribe_topic as c ON a.obj_id = c.id and c.tribe_id {$trie_id_sql}
              	 where a.type = 1 
            ) as `tu` ON `tu`.`obj_id` = `tt`.`id` 
            LEFT JOIN (
                    select a.* from (
                    select a.* from 9thleaf_tribe_comment as a
                    join 9thleaf_tribe_staff as b on a.customer_id = b.customer_id   and b.status =2   and a.tribe_id = b.tribe_id
                    where a.tribe_id {$trie_id_sql}  $obj_id
                    ) as a 
                    join 9thleaf_tribe_staff as b on a.to_customer_id = b.customer_id   and b.status =2  or a.to_customer_id is null
                    where a.type = 1 and a.is_delete = 0
                    group by a.id
            )as `tc` ON `tc`.`obj_id` = `tt`.`id` 
            WHERE `ts`.`status` = 2
            AND `tt`.`status` = 1
            AND `tt`.`tribe_id` {$trie_id_sql}
            $where
            GROUP BY `tt`.`id`, `ts`.`id`, `c`.`id`, `cc`.`id`
            ORDER BY {$order_by} `tt`.`id` DESC
            $limit
	        ");
        
	    if( !empty($sift['return_row'] ) )
	    {
	        return $query->row_array();
	    }
// 	    echo '<pre>';
//      echo $this->db->last_query();exit;
	    return $query->result_array();
	   
	}
	
	/**
	 * 获取点赞人的昵称
	 * @param int topic_id
	 */
	public function topic_upvote_member_name($topic_id){
	    $this->db->select("DISTINCT (tss.customer_id),ts.customer_id,ts.member_name,c.real_name");
	    $this->db->from('tribe_topic as tt');
	    $this->db->join('tribe_staff as ts','ts.tribe_id = tt.tribe_id ');
	    $this->db->join('tribe_upvote  as tu','tu.obj_id = tt.id and tu.type=1 and ts.customer_id = tu.customer_id ');
	    $this->db->join('tribe_staff  as tss',' tss.customer_id = tu.customer_id and and tss.status = 2 ');
	    $this->db->join('customer as c','c.id = ts.customer_id','left');
	    $this->db->where("tt.id",$topic_id);
	    $this->db->where('tt.status',1);
	    $query = $this->db->get();
// 	    echo '<pre>';
// 	    echo $this->db->last_query();exit;
	    return $query->result_array();
	}
	/**
	 * 查询单条记录
	 * @param array $sift
	 */
	public function Load_Row( $sift = array() )
	{ 
	    if( empty( $sift['where']['id'] ) )
	        return array();
	    
	    $this->db->from('tribe_topic');
	    $this->db->where('id',$sift['where']['id']);
	    $this->db->where('tribe_id',$sift['where']['tribe_id']);
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	/**
	 * 我在某个部落发表的话题。
	 * @param unknown $param
	 */
	public function My_Topic_List( $sift ) 
	{
	    
	    $limit = '';
	    if( !empty( $sift['page']['limit'] ) ){
	        $limit = "limit {$sift['page']['limit']}";
	    }
	    if( !empty( $sift['page']['offset'] ) ){
	        $limit = "limit {$sift['page']['offset']},{$sift['page']['limit']}";
	    }
	    $query =  $this->db->query("
	        SELECT `tt`.*, `ts`.`id` as `ts_id`, `ts`.`member_name`, `cc`.`corporation_name`, `cc`.`id` as `corp_id`, `c`.`real_name`, `c`.`wechat_avatar`, `c`.`brief_avatar`, count( DISTINCT tu.id)+upvote_num as upvote_num, count( DISTINCT tu.customer_id = {$sift['where']['customer_id']} or null) as my_upvote, count(DISTINCT tc.id) as comment_num
	        FROM `9thleaf_tribe_topic` as `tt`
	        JOIN `9thleaf_tribe_staff` as `ts` ON `ts`.`tribe_id` = `tt`.`tribe_id` and `ts`.`customer_id` = `tt`.`customer_id`
	        LEFT JOIN `9thleaf_customer` as `c` ON `c`.`id` = `tt`.`customer_id`
	        LEFT JOIN `9thleaf_customer_corporation` as `cc` ON `cc`.`customer_id` = `tt`.`customer_id` and `tt`.`status` = 1
	        LEFT JOIN (
	        select a.* from  `9thleaf_tribe_upvote` as a
	        JOIN 9thleaf_tribe_staff as b on a.customer_id = b.customer_id and b.status = 2 and b.tribe_id = {$sift['where']['tribe_id'] }
	        JOIN 9thleaf_tribe_topic as c ON a.obj_id = c.id and c.tribe_id = {$sift['where']['tribe_id'] }
	        where a.type = 1
	        ) as `tu` ON `tu`.`obj_id` = `tt`.`id`
	        LEFT JOIN (
	                select a.* from (
                    select a.* from 9thleaf_tribe_comment as a
                    join 9thleaf_tribe_staff as b on a.customer_id = b.customer_id   and b.status =2   and a.tribe_id = b.tribe_id
                    where a.tribe_id = {$sift['where']['tribe_id'] }  
                    ) as a 
                    join 9thleaf_tribe_staff as b on a.to_customer_id = b.customer_id   and b.status =2  or a.to_customer_id is null
                    where a.type = 1 and a.is_delete = 0
                    group by a.id
	        )as `tc` ON `tc`.`obj_id` = `tt`.`id`
	        WHERE `ts`.`status` = 2
	        AND `tt`.`status` = 1
	        AND `tt`.`tribe_id` = {$sift['where']['tribe_id'] }
	        AND `tt`.`customer_id` = {$sift['where']['customer_id']}
	        GROUP BY `tt`.`id`, `ts`.`id`, `c`.`id`, `cc`.`id`
	        ORDER BY `tt`.`sort` DESC, `tt`.`id` DESC
	        $limit
	        ");
	    
	    return $query->result_array();
	}
	
	
	/**
	 * 更新
	 */
	public function Update( $sift = array() )
	{
	    if( empty( $sift['where']['tribe_id'] )  )
	        return false;
	    
	    if( isset( $sift['set']['status'] ) )
            $this->db->set('status',$sift['set']['status'] );
        if( isset( $sift['set']['sort'] ) )
            $this->db->set('sort',$sift['set']['sort'] );
        
        if( isset( $sift['where']['sort'] ) )
            $this->db->where('sort',$sift['where']['sort'] );
        
        if( !empty( $sift['where']['id'] ) )
            $this->db->where('id',$sift['where']['id'] );
        
        $this->db->where('tribe_id',$sift['where']['tribe_id'] );
        
        if(  !empty( $sift['where']['customer_id'] ) )
            $this->db->where('customer_id',$sift['where']['customer_id'] );
        
        $this->db->update('tribe_topic');
        return $this->db->affected_rows();
	}
	
	// ------------------------------------------------------
	
	/**
	 * 根据部落id获取管理的圈子话题
	 * @param number $tribe_id 部落id
	 * @param number $limt 显示条数
	 * @param number $offset 页码
	 */
	function ManageTopicList($tribe_id,$limit,$offset){
	    if(!$tribe_id){
	        return array();
	    }
	    $this->db->select("a.id,a.customer_id,a.images,a.content,a.created_at,a.status,a.tribe_id");
	    $this->db->select("b.brief_avatar,b.wechat_avatar,b.name,b.real_name,b.mobile");
	    $this->db->select("any_value(c.corporation_name) as corporation_name,any_value(c.approval_status) as approval_status,any_value(c.status) as corp_status,any_value(c.id) as corp_id");
	    $this->db->select("count(d.id) as quantity");
	    $this->db->select("any_value(e.id) as staff_id,any_value(e.member_name) as member_name");
	    $this->db->from("tribe_topic as a");
	    $this->db->join("customer as b","a.customer_id = b.id");
	    $this->db->join("customer_corporation as c","c.customer_id = b.id","left");
	    $this->db->join("tribe_complaints as d","d.obj_id = a.id and d.type = 1","left");
	    $this->db->join("tribe_staff as e","b.id = e.customer_id and e.tribe_id = $tribe_id");
	    $this->db->where("a.tribe_id",$tribe_id);
	    $this->db->where("a.status",1);
	    $this->db->group_by("a.id");
	    $this->db->order_by("a.id","desc");
	    $this->db->limit($limit,$offset);
	    $query = $this->db->get();
	    return $query->result_array();
	}

	/**
     * 校验话题是否被举报
     * @param number $obj_id
     * $param number $customer_id
     */
	function topic_is_complaints($obj_id, $customer_id){
        // 校验话题是否被举报
        $this->db->where('customer_id', $customer_id);
        $this->db->where('obj_id', $obj_id);
        $res = $this->db->get('tribe_complaints');
        return $res->result_array();
    }
	
}
 