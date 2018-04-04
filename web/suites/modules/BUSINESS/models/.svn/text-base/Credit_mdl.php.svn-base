<?php
/**
 * 
 * 授信申请操作表
 *
 */
class Credit_mdl extends CI_Model {
     
    
    public $customer_id;
    public $credit;
    public $status;
    public $is_effective;
    
    
	function __construct() {
		parent::__construct ();
	}
	
	
	public function Add()
	{ 
	    if(!empty( $this->customer_id ) )
	        $this->db->set('customer_id',$this->customer_id);
	    
        if(!empty( $this->credit ) )
            $this->db->set('credit',$this->credit);
        
        if(!empty( $this->status ) )
            $this->db->set('status',$this->status);
        
        if(!empty( $this->is_effective ) )
            $this->db->set('is_effective',$this->is_effective);
            
        $this->db->set('created_at',date('Y-m-d H:i:s') );
        
        $this->db->insert('credit');
        
        return $this->db->insert_id();
	    
	}
	
	/**
	 * 统计授信排行榜
	 * $customer_id = true;获取自己的排名
	 */
	public function Ranking_list( $tribe_id, $limit, $offset, $time, $customer_id = false )
	{ 
	    $sql = '';
	    $where = '';
	    
	    if( !empty($time['start_at']) && !empty($time['ent_at']) )
	    {
	        $where = "  AND c.effective_at  >= '{$time['start_at']}' and c.effective_at <= '{$time['ent_at']}' ";
	    }
	    
	    if( $customer_id )
	    {
    	   
    	   $sql .= " select * from ( ";
    	   $sql .= " select  (@a := @a + 1) as position,a.*  from ( ";
    	}
    	
    	
    	$sql .= " select sum(c.actual_credit ) as total, ts.customer_id,ts.member_name,cc.corporation_name,cu.real_name,cu.mobile";
    	$sql .= " FROM `9thleaf_tribe_staff` as `ts` ";
    	$sql .= " JOIN `9thleaf_credit` as `c` ON `ts`.`customer_id` = `c`.`customer_id` ";
    	$sql .= " left join 9thleaf_customer_corporation as cc on cc.customer_id = ts.customer_id";
    	$sql .= " left join 9thleaf_customer as cu on cu.id = ts.customer_id";
    	$sql .= " WHERE `ts`.`tribe_id` = {$tribe_id} AND `c`.`status` = 2 AND `ts`.`status` = 2 ";
    	$sql .= $where;
    	$sql .= " GROUP BY `ts`.`id`,cc.id ORDER BY `total` DESC ";
    	
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
    	   
            $sql .= " )as c where c.customer_id = {$customer_id} ";

    	}
    	
    	$query = $this->db->query( $sql );
        
        if( $customer_id )
        { 
            return $query->row_array();
    	}
	    return $query->result_array();
	    
	}
}