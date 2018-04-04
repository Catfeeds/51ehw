<?php
/**
 * 投票模块
 * vote，vote_option，vote_staff 三个表的SQL
 */
class Vote_mdl extends CI_Model {
     
	public function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 投票活动列表查询
	 * @date:2018年2月28日 下午2:30:57
	 * @author: fxm
	 * @param: $siftp['where'][] = 条件。
	 * @return: array
	 */
	public function Load( $sift = array() )
	{ 
	    if( empty( $sift['where']['tribe_id'] ) )
	    {
	        return array();
	    }
	    
	    if( is_array( $sift['where']['tribe_id'] ) )
	    { 
	        $this->db->where_in('tribe_id',$sift['where']['tribe_id']);
	        
	    }else{ 
	        
	        $this->db->where('tribe_id',$sift['where']['tribe_id']);
	    }
	    
	    $query = $this->db->get('vote');
	    $result = $query->result_array();
	    
	    return $this->TribeInfo($result);
	}
	
	/**
	 * 投票项+部落信息-整合。
	 * @date:2018年3月6日 下午5:04:31
	 * @author: fxm
	 * @param: variable
	 * @return: array();
	 */
	private function TribeInfo( $vote_list )
	{ 
	    if( !$vote_list )
	    {
	        return array();
	    }
	    
	   
	    $tribe_ids = array_unique(array_column($vote_list,'tribe_id'));
	    
	    $this->db->select('id as tribe_id,name as tribe_name,logo');
	    $this->db->where_in('id',$tribe_ids);
	    $this->db->from('tribe');
	    $query = $this->db->get();
	    $result = $query->result_array();
	    
	    if( $result )
	    { 
	        $tribe_list = array_column($result,null,'tribe_id');
	        
	        foreach ( $vote_list as $k=> $v )
	        {
	            if( !empty( $tribe_list[$v['tribe_id']] ) )
	            { 
	                $vote_list[$k]['logo'] = $tribe_list[$v['tribe_id']]['logo'];
	                $vote_list[$k]['tribe_name'] = $tribe_list[$v['tribe_id']]['tribe_name'];
	            }
	        }
	        
	    }
	    
	    return $vote_list;
	    
	}
	
	/**
	 * 投票活动详细
	 * @date:2018年2月28日 下午2:30:57
	 * @author: fxm
	 * @param: $siftp['where'][] = 条件。
	 * @return: array
	 */
	public function Detaile( $sift = array() )
	{
	    if( !empty( $sift['where']['id'] ) )
	    {
	        $this->db->where('id',$sift['where']['id']);
	    }
	     
	    $query = $this->db->get('vote');
	    return $query->row_array();
	}
	
	/**
	 * 查询某个活动下的子选项列表和投票次数
	 * @date:2018年2月28日 下午4:02:38
	 * @author: fxm
	 * @param: $siftp['where'][] = 条件。
	 * @return: array
	 */
	public function VoteOptionList( $sift = array() ) 
	{
	    
	    if( empty( $sift['where']['vote_id'] ) )
	    {
	        return array();
	    }
	   
	    if( !empty( $sift['sql_status'] ) && $sift['sql_status'] == 'votes_num_ordeby' )
	    {
	        //需要显示排名使用sql.
    	    $this->db->query('(select @vote_position := 0)');
    	    
    	    $sql = "
                (select vo_position.*,(@vote_position := @vote_position + 1) as position from (
                
                    select `vo`.*, count(vs.id) as votes_num from `9thleaf_vote_option` as `vo`
                    LEFT JOIN `9thleaf_vote_staff` as `vs` ON `vo`.`id` = `vs`.`option_id` 
                    WHERE `vo`.`vote_id` = '{$sift['where']['vote_id']}'
                    GROUP BY `vo`.`id` ORDER BY votes_num desc ) as vo_position 
                
                ) as vo ";
    	    
    	    $this->db->select('*');
    	    $this->db->from($sql,false);
    	    
	    }else{ 
	        
	        $this->db->select('vo.*,count(vs.id) as votes_num');
    	    $this->db->from('vote_option as vo');
    	    $this->db->join('vote_staff as vs','vo.id = vs.option_id','left');
    	    $this->db->where('vo.vote_id',$sift['where']['vote_id']);
    	    $this->db->group_by('vo.id');
	    }
// 	   
	    
	    if( !empty( $sift['like']['option_tile_id'] ) )
	    {   //关键词模糊搜索
	        $this->db->like ( "concat(vo.option_title,'||',vo.id)", $sift['like']['option_tile_id'] );

	    }
	    
	    if( !empty( $sift['page']['limit'] ) )
        {
            $this->db->limit($sift['page']['limit'],$sift['page']['offset'] );
        }
        
	    $query = $this->db->get();
	  
	    return $query->result_array();
	}
	
	/**
	 * 查询X个子选项中的某个用户的最新的投票记录。
	 * @date:2018年2月28日 下午4:51:21
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function VoteStaffNew( $sift = array() )
	{ 
	    $this->db->select('option_id,max(create_at)  as create_at');
	    $this->db->from('vote_staff');
	    $this->db->where('customer_id',$sift['where']['customer_id']);
	    
	    if( !empty( $sift['where']['option_id'] ) )
	    { 
	        if( is_array( $sift['where']['option_id'] ) )
	        {
	            $this->db->where_in('option_id',$sift['where']['option_id']);
	            
	        }else{ 
	            
	            $this->db->where('option_id',$sift['where']['option_id']);
	        }
	    }
	    
	    $this->db->group_by('option_id,customer_id');
	    $query = $this->db->get();
	    
	    if( is_array( $sift['where']['option_id'] ) )
        {
	       return $query->result_array();
	    }
	    
	    return $query->row_array();
	}
	
	
	/**
	 * 更新X表的访问次数。
	 * @date:2018年3月1日 上午9:34:47
	 * @author: fxm
	 * @param: variable
	 * @return: array
	 */
	public function  VoteUpdate( $sift = array() ) 
	{
	    if( empty( $sift['where']['id'] ) || empty( $sift['sql_status']['table'] ) )
	        return array();
	    
	    $this->db->set ( 'visits', "`visits`+1", false );
	    $this->db->where ( 'id', $sift['where']['id'] );
	    $this->db->update ( $sift['sql_status']['table'] );
	    return $this->db->affected_rows();
	}
	
	
	/**
	 * 更新X表总数。
	 * @date:2018年3月1日 上午9:34:47
	 * @author: fxm
	 * @param: variable
	 * @return: array
	 */
	public function VoteCount( $sift = array() )
	{
	    
	    if( empty( $sift['where']['vote_id'] ) && empty($sift['where']['option_id'] ) )
	        return array();
	         
	        $this->db->select('count(id) as total_num');
	        
	        if( !empty( $sift['where']['vote_id'] ) )
	        {
	           $this->db->where ( 'vote_id', $sift['where']['vote_id'] );
	        }
	        
	        if( !empty( $sift['where']['option_id'] ) )
	        { 
	            $this->db->where ( 'option_id', $sift['where']['option_id'] );
	        }
	        
	        $this->db->from ( $sift['sql_status']['table'] );
	        $query = $this->db->get();
	        return $query->row_array();
	}
	
	
	/**
	 * 子选项and主项目信息。
	 * @date:2018年3月1日 上午10:54:33
	 * @author: fxm
	 * @param: variable
	 * @return: array
	 */
	public function VoteOptionDetaile( $sift = array() )
	{ 
	    if( empty( $sift['where']['id'] ) )
	    {
	        return array();
	    }
	    $this->db->select('v.multi_nums,v.vote_platform');
	    $this->db->select('v.title,v.banner,v.start_time,v.end_time,v.tribe_id,v.authority,v.vote_time,v.rule,v.abstract,v.result,v.vote_type,vo.*');
	    $this->db->from('vote_option as vo');
	    $this->db->join('vote as v','v.id=vo.vote_id');
	    $this->db->where('vo.id',$sift['where']['id']);
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	/**
	 * 查询用户当天在这个活动中一个投了多少票（所有子项目总和）
	 * @date:2018年3月2日 下午4:14:40
	 * @author: fxm
	 * @param: variable
	 * @return: array
	 */
	public function CustomerVoteNum( $sift = array() )
	{ 
	    if( empty( $sift['where']['vote_id'] ) || empty($sift['where']['customer_id'] ) )
	        return array();
	    
	    $this->db->select('count(id) as num');
	    $this->db->from('vote_staff');
	    $this->db->where('customer_id',$sift['where']['customer_id']);
	    $this->db->where('vote_id',$sift['where']['vote_id']);
	    $this->db->where("DATE_FORMAT(create_at,'%Y%m%d') = '".date('Ymd')."'");//时间
	    $query = $this->db->get();
	    return $query->row_array();
	    
	}
	
	
	/**
	 * 添加投票记录。
	 * @date:2018年3月4日 下午9:50:36
	 * @author: fxm
	 * @param: variable
	 * @return: array
	 */
	public function CreateVoteStaff($data = array() )
	{ 
	    if( !is_array( $data ) )
	    {
	        return array();
	    }
	    
	    $this->db->insert('vote_staff',$data);
	    return $this->db->insert_id();
	}
	
	
	/**
	 * 查询用户最后在那个主项目中的投票时间.
	 * @date:2018年3月5日 上午11:37:55
	 * @author: fxm
	 * @param: variable
	 * @return: array()
	 */
	public function VoteNewStaffTime( $sift = array() )
	{ 
	    $this->db->select('max(create_at) as create_at');
	    $this->db->from('vote_staff');
	    $this->db->where('vote_id',$sift['where']['vote_id']);
	    $this->db->where('customer_id',$sift['where']['customer_id']);
	    $this->db->limit(1);
	    $query = $this->db->get();
	    return $query->row_array();
	    
	    
	}
	
}