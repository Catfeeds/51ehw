<?php
/**
 * 
 *Request_guarantee && guarantee 表 共用MDL
 *
 */
class Guarantee_request_mdl extends CI_Model {
     
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * 添加
	 */
	public function Batch_Add( $data )
	{ 
	    return $this->db->insert_batch('guarantee_request',$data);
	    
	}
	
	/**
	 * 验证用户是否被录入担保记录中-条件=生效中的
	 */
	public function is_effect( $customer_id )
	{ 
	    
	    $date = date('Y-m-d');
	    $this->db->select('sum(guarantee_total) as total');
	    $this->db->from('guarantee as g');
	    $this->db->where('g.customer_id',$customer_id);
	    $this->db->where('g.is_effective',1);
	    $this->db->where('g.end_time >=', "{$date}" );
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	/**
	 * 查询有效期内总共被担保了多少钱-和被谁担保
	 * @$customer_id 被担保人ID
	 * @$status = true;//查询被担保总额
	 */
	public function guarantee_detail( $customer_id, $status = false )
	{   
	    $date = date('Y-m-d');
	    $sql = ' gd.* ';
	    if( $status )
	    { 
	        $sql = ' sum(guarantee_money) as total  ';
	    }
	    $this->db->select("$sql");
	    $this->db->from('guarantee as g');
	    $this->db->join('guarantee_detail as gd','gd.guarantee_id = g.id');
	    $this->db->where('g.customer_id',$customer_id);
	    $this->db->where('g.is_effective',1);
	    $this->db->where("g.end_time >=","{$date}");
	    $query = $this->db->get();
	    
	    if( $status )
	    { 
	        return $query->row_array();
	    }
	    
	    return $query->result_array();
	}
	
	/**
	 * 部落内担保别人的用户-排行榜
	 */
	public function Ranking_list( $tribe_id,$customer_id=null,$limit=null, $offset=null, $time=null )
	{ 
	    $sql = "";
	    $where = "";
	    
	    if( !empty($time['start_at']) && !empty($time['ent_at']) )
	    {
	        $where = "  AND g.begin_time  >= '{$time['start_at']}' and g.begin_time <= '{$time['ent_at']}' ";
	    }
	    
	    if( $customer_id )
	    { 
	       $sql .= " select * from ( ";
    	   $sql .= " select  (@a := @a + 1) as position,a.*  from ( ";
	    }
	    $sql .=" select ts.id,ts.customer_id,ts.member_name,c.mobile,c.real_name,ts.tribe_id,sum(gd.guarantee_money ) as total ,cc.corporation_name";
	    $sql .=" from 9thleaf_guarantee as g ";
	    $sql .=" join 9thleaf_guarantee_detail as gd on g.id = gd.guarantee_id ";
	    $sql .=" left join 9thleaf_tribe_staff as ts on ts.customer_id = gd.customer_id and g.tribe_id = ts.tribe_id ";
	    $sql .=" left join 9thleaf_customer_corporation as cc on cc.customer_id = ts.customer_id";
	    $sql .=" left join 9thleaf_customer as c on c.id = ts.customer_id";
	    $sql .=" where ts.tribe_id={$tribe_id} and ts.status = 2 $where ";
	    //
	    $sql .=" group by ts.id,cc.id ORDER BY `total` DESC";
	    
	    if( $customer_id )
	    {
	        $sql .= " ) as a ,(select @a := 0) as b ";
	    }
	    
	    if ($limit)
	        $sql .= " limit $limit ";
	    
	    if ($offset)
	        $sql .= " offset $offset";
	    
	    if( $customer_id )
	    {
	    
	        $sql .= " ) as c where c.customer_id = {$customer_id} ";
	    
	    }
	    
	    $query = $this->db->query($sql);
	    
	    if( $customer_id )
	    {
	        return $query->row_array();
	    }
	    
	    return $query->result_array();
	} 
}