<?php
/**
 * 
 *
 *
 */ 
class Savings_card_mdl extends CI_Model 
{
    
	function __construct() 
	{
		parent::__construct ();
	}
	
	
	/**
	 * 创建申请卡。
	 */
	public function Create_Card_Sales( $sift = array() )
	{ 
	    if( !empty($sift['customer_id']) )
	        $this->db->set( 'customer_id', $sift['customer_id'] );
	    
        if( !empty($sift['corporation_id']) )
	        $this->db->set( 'corporation_id', $sift['corporation_id'] );
        
        if( !empty($sift['card_name']) )
	        $this->db->set( 'card_name', $sift['card_name'] );
        
	    if( !empty($sift['card_amount']) )
	    {
            $this->db->set( 'card_amount', $sift['card_amount'] );
            $this->db->set( 'card_remaining', $sift['card_amount'] );
	    }
	    
	    if( !empty($sift['start_time']) )
	        $this->db->set( 'start_time', $sift['start_time'] );
	    
	    if( !empty($sift['end_time']) )
	        $this->db->set( 'end_time', $sift['end_time'] );
	    
	    if( !empty($sift['images']) )
	        $this->db->set( 'images', $sift['images'] );
	    
        $this->db->insert('savings_card_sales');
	    return $this->db->insert_id();
	}
	
	/**
	 * 更新主卡表余额。
	 */
	public function Update_Card_Remaining( $amount,$id )
	{
	    $this->db->set ( 'card_remaining', "`card_remaining` - " . $amount, false );
	    $this->db->where ( 'id', $id );
	    $this->db->where('`card_remaining` >=',$amount,false);
	    $this->db->update ( 'savings_card_sales' );
	    $res = $this->db->affected_rows();
	    return $res;
	}
	

	/**
	 * 更新BUY表余额。
	 */
	public function Update_Buy_Remaining( $sift = array() )
	{
	    if( empty( $sift['where']['id'] ) )
	        return array();
	    
	    $this->db->set ( 'remaining_card_amount', "`remaining_card_amount` - " . $sift['set']['amount'], false );
	    
	    if( is_array( $sift['where']['id'] ) )
	    {
	        $this->db->where_in ( 'id', $sift['where']['id'] );
	        
	    }else{ 
	        $this->db->where ( 'id', $sift['where']['id'] );
	    }
	    
	    $this->db->where('`remaining_card_amount` >=',$sift['set']['amount'],false);
	    $this->db->update ( 'savings_card_buy');
	    $res = $this->db->affected_rows();
	    return $res;
	}
	
	/**
	 * 更新9thleaf_savings_card_sales表信息。
	 */
	public function Update_Card_Sales( $sift = array() )
	{ 
	    if( !empty( $sift['where']['id'] ) )
	    {
    	    $this->db->set('status',$sift['set']['status']);
    	    
    	    if( isset( $sift['set']['status'] ) )
    	       $this->db->set('check_at',date('Y-m-d H:i:s') );
    	    
    	    $this->db->where('id',$sift['where']['id']);
    	    $this->db->where('corporation_id',$sift['where']['corporation_id'] );
    	    $this->db->where('status',$sift['where']['status']);
    	    $this->db->update('savings_card_sales');
    	    return $this->db->affected_rows();
	    }
	    
	    return false;
	}

	/**
	 * 创建授权记录。
	 */
	public function Create_Card_Buy( $sift = array() )
	{
	    if( !empty($sift['savings_card_sales_id']) )
	        $this->db->set( 'savings_card_sales_id', $sift['savings_card_sales_id'] );
	         
        if( !empty($sift['customer_id']) )
            $this->db->set( 'customer_id', $sift['customer_id'] );
        
        if( !empty($sift['level']) )
            $this->db->set( 'level', $sift['level'] );
       
        if( !empty($sift['card_amount']) )
        {
            $this->db->set( 'card_amount', $sift['card_amount'] );
            $this->db->set( 'remaining_card_amount', $sift['card_amount'] );
        }
         
        if( !empty($sift['start_time']) )
            $this->db->set( 'start_time', $sift['start_time'] );
	                     
        if( !empty($sift['end_time']) )
            $this->db->set( 'end_time', $sift['end_time'] );
        
        if( !empty($sift['parent_id']) )
            $this->db->set( 'parent_id', $sift['parent_id'] );
                                 
        $this->db->insert('savings_card_buy');
        return $this->db->insert_id();
	}	
	
	
	/**
	 * 查询申请销售的卡列表。
	 */
	public function Load_Card_Sales( $sift = array() )
	{ 
	    
	    if( empty( $sift['where']['customer_id'] )  )
	        return array();
	    
        
	    $this->db->select('scs.*,cc.corporation_name');
	    $this->db->from('savings_card_sales as scs');
	    $this->db->join('customer_corporation as  cc','cc.id = scs.corporation_id','left');
	    
	    //用户ID=申请者。条件
	    if( !empty( $sift['where']['customer_id'] ) )
	    {
	       $this->db->where( 'scs.customer_id', $sift['where']['customer_id'] );
	    }
	    
// 	    //卡状态
// 	    if( isset( $sift['where']['status'] ) )
// 	    {
// 	        $this->db->where( 'scs.status', $sift['where']['status'] );
// 	    }
	    
	    //分页。
        if( !empty($sift['page']['limit']) )
        {
            $this->db->limit( $sift['page']['limit'] );
        }
        if( !empty($sift['page']['offset']) )
        {
            $this->db->offset( $sift['page']['offset'] );
        }
        
        $this->db->order_by('scs.id','desc');
       
	    $query = $this->db->get();
	    
	    if( !empty( $sift['return_rows'] ) )
	       return  $query->num_rows();
	   
	    return $query->result_array();
	    
	}
	
	/**
	 * 承兑商查看信息。
	 */
	public function Load_Card_Sales_Corp( $sift = array() )
	{ 

	    if( empty( $sift['where']['corporation_id'] )  )
	        return array();
	    
	        $this->db->select('scs.*,cc.corporation_name,c.name,c.nick_name');
	        $this->db->from('savings_card_sales as scs');
	        $this->db->join('customer_corporation as  cc','cc.customer_id = scs.customer_id','left');
	        $this->db->join('customer as c','c.id = scs.customer_id','left');
	        
	        //店铺ID=承兑方。条件
	        if( !empty( $sift['where']['corporation_id'] ) )
	        {
	            $this->db->where( 'scs.corporation_id', $sift['where']['corporation_id'] );
	        }
	         
	        //卡状态
    	    if( isset( $sift['where']['status'] ) )
    	    {
    	        $this->db->where( 'scs.status', $sift['where']['status'] );
    	    }
	             
            //分页。
            if( !empty($sift['page']['limit']) )
            {
                $this->db->limit( $sift['page']['limit'] );
            }
            if( !empty($sift['page']['offset']) )
            {
                $this->db->offset( $sift['page']['offset'] );
            }
    
            $this->db->order_by('scs.id','desc');
             
            $query = $this->db->get();
             
            //返回数量。
            if( !empty( $sift['return_rows'] ) )
            {
                return  $query->num_rows();
            }
    
            return $query->result_array();
	}

	/**
	 * 购买方查询获得卡的列表信息。
	 */
	public function Load_Card_Buy( $sift )
	{
	    if( empty( $sift['where']['customer_id'] ) )
	        return array();
	
	        $this->db->select('scb_a.remaining_card_amount as level_two_show_card_amount,scs.card_name,scb.*,cc.corporation_name as sales_name,ccc.corporation_name as convert_name');
	        $this->db->from('savings_card_buy as scb');
	        $this->db->join('savings_card_sales as scs','scb.savings_card_sales_id = scs.id');
	        $this->db->join('savings_card_buy as scb_a','scb_a.id = scb.parent_id','left');
	        $this->db->join('customer_corporation as cc','scs.customer_id = cc.customer_id','left');
	        $this->db->join('customer_corporation as ccc','ccc.id = scs.corporation_id','left');
	        $this->db->where('scb.customer_id ',$sift['where']['customer_id'] );
	       
	        if( !empty( $sift['where']['corporation_id'] ) )
	        { 
	            $this->db->where('scs.corporation_id ',$sift['where']['corporation_id'] );
	        }
	        
	        //分页。
	        if( !empty($sift['page']['limit']) )
	        {
	            $this->db->limit( $sift['page']['limit'] );
	        }
	        if( !empty($sift['page']['offset']) )
	        {
	            $this->db->offset( $sift['page']['offset'] );
	        }
	        
	        $this->db->order_by('scb.id','desc');
	        $query = $this->db->get();
	
	        if( !empty( $sift['return_rows'] ) )
	            return $query->num_rows();
	
	            return $query->result_array();
	}
	
	
	/**
	 * 销售商查询已授权卡的列表信息。
	 */
	public function Load_Card_Buy_Corp( $sift )
	{
	    if( empty( $sift['where']['savings_card_sales_id'] ) )
	        return array();
	         
	        $this->db->select('scb.*,c.name,c.nick_name');
	        $this->db->from('savings_card_buy as scb');
	        $this->db->join('customer as  c','c.id = scb.customer_id','left');
	        $this->db->where('scb.savings_card_sales_id',$sift['where']['savings_card_sales_id'] );
	        $this->db->where('scb.parent_id',0);
	        //分页。
	        if( !empty($sift['page']['limit']) )
	        {
	            $this->db->limit( $sift['page']['limit'] );
	        }
	        if( !empty($sift['page']['offset']) )
	        {
	            $this->db->offset( $sift['page']['offset'] );
	        }
	        $this->db->order_by('scb.id','desc');
	        $query = $this->db->get();
	         
	        if( !empty( $sift['return_rows'] ) )
	            return $query->num_rows();
	        
            return $query->result_array();
	}
	
	/**
	 * 购买方查询某个卡的使用授权记录。
	 */
	public function Load_Card_Buy_Authorize( $sift )
	{
	   if( !empty( $sift['where']['parent_id'] ) )
	   {
	       if( !empty( $sift['return_rows'] ) )
	       {
	           //单独统计。
	           $this->db->select('count(scb.id) as total_rows,sum(scb.card_amount) as authorize_amount');
	       }else{
    	       $this->db->select('scb.*,c.name,c.nick_name');
	       }
    	   $this->db->from('savings_card_buy as scb');
    	   $this->db->join('customer as c','c.id = scb.customer_id','left');
    	   $this->db->where('scb.parent_id',$sift['where']['parent_id']);
    	   
    	   //分页。
    	   if( !empty($sift['page']['limit']) )
    	   {
    	       $this->db->limit( $sift['page']['limit'] );
    	   }
    	   if( !empty($sift['page']['offset']) )
    	   {
    	       $this->db->offset( $sift['page']['offset'] );
    	   }
    	   
    	   
    	   $query = $this->db->get();
    	   
	       if( !empty( $sift['return_rows'] ) )
	       { 
	           return $query->row_array();
	       }
	      
    	   return $query->result_array();
	   }
	   
	   return array();
	   
	}
	
	/**
	 * 查询单个销售卡信息。
	 */
	public function Card_Sales_Detaile( $sift = array() )
	{ 
	    if( empty( $sift['where']['id'] ) )
	        return array();
	    
	    if( isset( $sift['where']['status'] ) )
	        $this->db->where('status',$sift['where']['status']);
	    
	    if( !empty( $sift['where']['customer_id']  ) )
	        $this->db->where('customer_id',$sift['where']['customer_id']);
	    
        if( !empty( $sift['where']['corporation_id']  ) )
            $this->db->where('corporation_id',$sift['where']['corporation_id']);
        
	    $query = $this->db->get_where('savings_card_sales',array('id'=>$sift['where']['id'] ) );
	    return $query->row_array();
	    
	    
	}
	
	/**
	 * 查询单个销售卡&&申请方企业信息。
	 */
	public function Card_Sales_Detaile_Corp( $sift = array() )
	{
	    if( empty( $sift['where']['id'] ) )
	        return array();
         
        if( !empty( $sift['where']['status'] ) )
            $this->db->where('scs.status',$sift['where']['status']);
	                 
        if( !empty( $sift['where']['corporation_id']  ) )
            $this->db->where('scs.corporation_id',$sift['where']['corporation_id']);
        
            
        $this->db->select('scs.*,c.id as customer_id, cc.corporation_name,c.name,c.nick_name');
        $this->db->from('savings_card_sales as scs');
        $this->db->join('customer_corporation as  cc','cc.customer_id = scs.customer_id','left');
        $this->db->join('customer as c','c.id = scs.customer_id','left');
        $this->db->where('scs.id',$sift['where']['id']);
        $query = $this->db->get();
        
        return $query->row_array();
	                     
	                     
	}
	
	/**
	 * 购买方查询单个授权卡的信息。
	 */
	public function Card_Buy_Detaile( $sift = array() )
	{ 
	    if( !empty( $sift['where']['id'] ) && ( $sift['where']['customer_id'] ) )
	    {
    	    $this->db->select('scs.card_name,scb.*');
    	    $this->db->from('savings_card_buy scb');
    	    $this->db->join('savings_card_sales as scs','scb.savings_card_sales_id = scs.id');
    	    $this->db->where('scb.id',$sift['where']['id']);
    	    $this->db->where('scb.customer_id',$sift['where']['customer_id']);
    	    if( isset( $sift['where']['parent_id'] ) )
    	    {
    	       $this->db->where('scb.parent_id',$sift['where']['parent_id'] );
    	    }
    	    $query = $this->db->get();
    	    
    	    return $query->row_array();
	    }
	    
	    return array();
	}
		
	
	
	/**
	 * 查询一二级授权卡的信息。
	 */
	public function Card_Buy_All_Detaile( $sift = array() )
	{
	    if( !empty( $sift['where']['id'] )  )
	    {
	        $this->db->select('scb_a.remaining_card_amount as level_two_show_card_amount,scs.card_name,scb.*');
	        $this->db->from('savings_card_buy scb');
	        $this->db->join('savings_card_sales as scs','scb.savings_card_sales_id = scs.id');
	        $this->db->join('savings_card_buy as scb_a','scb_a.id = scb.parent_id','left');
	        $this->db->where('scb.id',$sift['where']['id']);
	        
	        if( !empty( $sift['where']['customer_id'] ) )
	        {
	            $this->db->where('scb.customer_id',$sift['where']['customer_id']);
	        }
	        
	        if( !empty( $sift['where']['corporation_id'] ) )
	        {
	            $this->db->where('scs.corporation_id',$sift['where']['corporation_id']);
	        }
	        
	        if( !empty( $sift['where']['scs.customer_id'] ) )
	        {
	            $this->db->where('scs.customer_id',$sift['where']['scs.customer_id']);
	        }
	        
	        if( !empty( $sift['where']['scb_a.customer_id'] ) )
	        {
	            $this->db->where('scb_a.customer_id',$sift['where']['scb_a.customer_id']);
	        }
	        
	        
	        $query = $this->db->get();
	        	
	        return $query->row_array();
	    }
	     
	    return array();
	}
	
	
	//-----9thleaf_savings_card_consumption MDL
	
	/**
	 * 储值卡消费记录。
	 */
    public function Load_Card_Consumption( $sift = array() )
    { 
        if( !empty( $sift['where']['savings_card_buy_id'] ) || !empty( $sift['where']['savings_card_buy_praent_id'] ) )
        {
            $this->db->select('c.name,c.nick_name,cb.branch_name,scc.*');
            $this->db->from('savings_card_consumption as scc');
            $this->db->join('order as o','o.id = scc.order_id','left');
            $this->db->join('customer as c','c.id = o.customer_id','left');
            $this->db->join('corporation_branch as cb','cb.id = o.corporation_branch_id','left');
            
            if( !empty( $sift['where']['savings_card_buy_id']  ) )
            {
                $this->db->where('scc.savings_card_buy_id',$sift['where']['savings_card_buy_id']);
            }
            
            if( !empty( $sift['where']['savings_card_buy_praent_id']  ) )
            {
                $this->db->where('scc.savings_card_buy_praent_id',$sift['where']['savings_card_buy_praent_id']);
            }
            
            //分页。
            if( !empty($sift['page']['limit']) )
            {
                $this->db->limit( $sift['page']['limit'] );
            }
            if( !empty($sift['page']['offset']) )
            {
                $this->db->offset( $sift['page']['offset'] );
            }
            
            $this->db->order_by('scc.id','desc');
            $query = $this->db->get();
            
            if( !empty( $sift['return_rows'] ) )
            {
                return $query->num_rows();
            }
            

        
            return $query->result_array();
        }
        
        return array();
    }
	
    
    /**
     * 查询用户可用的储值卡包括一二级。
     * 下单流程用到-.
     */
    public function Load_Customer_Card( $sift = array() )
    { 
        if( !empty( $sift['where']['customer_id'] )  )
	    {
	        $this->db->select('scb_a.remaining_card_amount as level_two_show_card_amount,scs.corporation_id,scs.card_name,scb.*');
	        $this->db->from('savings_card_buy scb');
	        $this->db->join('savings_card_sales as scs','scb.savings_card_sales_id = scs.id');
	        $this->db->join('savings_card_buy as scb_a','scb_a.id = scb.parent_id','left');
	        $this->db->where('scb.customer_id',$sift['where']['customer_id']);
	        $this->db->where('scb.start_time <=',date('Y-m-d') );
	        $this->db->where('scb.end_time >=',date('Y-m-d') );
	        
	        if( !empty( $sift['where']['corporation_id'] ) )
	        {
	            if( is_array( $sift['where']['corporation_id'] ) )
	            {
	                $this->db->where_in('scs.corporation_id',$sift['where']['corporation_id']);
	            }else{ 
	                $this->db->where('scs.corporation_id',$sift['where']['corporation_id']);
	            }
	        }
	        
	        $this->db->order_by('scb.end_time');
	        $query = $this->db->get();
	        	
	        return $query->result_array();
	    }
	     
	    return array();
    }
	
    //9thleaf_savings_card_log 表
    //----------------------------------------------------------------------------------
    //添加日志
    public function Create_Card_Log( $data = array() )
    { 
        $this->db->insert('savings_card_log',$data);
        return $this->db->insert_id();
        
    }
    
    //查询日志
    public function Load_Card_Log( $sift = array() )
    { 
        $this->db->select('*');
        $this->db->from('savings_card_log');
        $this->db->where('customer_id',$sift['where']['customer_id']);
       
        
        //分页。
        if( !empty($sift['page']['limit']) )
        {
            $this->db->limit( $sift['page']['limit'] );
        }
        if( !empty($sift['page']['offset']) )
        {
            $this->db->offset( $sift['page']['offset'] );
        }
        $this->db->order_by('id','desc');
        $query = $this->db->get();
        
        if( !empty( $sift['return_rows'] ) )
        {
            return $query->num_rows();
        }
        
        return $query->result_array();
    }
    
    //----------------------------------------------------------------------------------
	/**
	 * 处理逻辑使用。
	 * 前面验证好订单信息。
	 * 共用的订单支付使用储蓄卡。
	 */
    public function Card_Pay_Order( $order_info = array() )
    { 
        
        //查询卡信息进行信息验证->写储值卡的消费记录->
        //如果是二级授权的卡->（更新本卡余额，更新主卡余额）
        //如果是一级的卡->(更新卡余额就可以了。)
        
        $sift['where']['customer_id'] = $order_info['customer_id'];
        $sift['where']['id'] = $order_info['savings_card_buy_id'];
        
        $card_info = $this->Card_Buy_All_Detaile($sift);
        
        if( $card_info )
        { 
            //默认一级卡。
            $remaining_card_amount = $card_info['remaining_card_amount'];
            $buy_id = $card_info['id'];
            
            //二级卡
            if( $card_info['level'] == 2  )
            { 
                //如果主卡余额小于二级卡余额的话就使用主卡的余额。
                if( $card_info['level_two_show_card_amount'] <  $card_info['remaining_card_amount'] )
                {
                    $remaining_card_amount = $card_info['level_two_show_card_amount'];
                }
                
                $buy_id = array($card_info['id'],$card_info['parent_id']);
                
            }
            
            //该订单需要卡支付的金额   如果余额不足以支付则返回支付失败。
            if( $remaining_card_amount >= $order_info['card_pay_amount']  )
            {
                //更新卡余额
                $sift['where']['id'] = $buy_id;
                $sift['set']['amount'] = $order_info['card_pay_amount'];
                $row = $this->Update_Buy_Remaining( $sift );
                
                //返回的行数和等级一样。
                if( $row == $card_info['level'] )
                { 
                   
                    //写消费记录
                   $add_data['savings_card_buy_id'] =  is_array( $buy_id ) ? $buy_id[0] : $buy_id;
                   $add_data['savings_card_buy_praent_id'] =  is_array( $buy_id ) ? $buy_id[1] : $buy_id;
                   $add_data['order_id'] = $order_info['id'];
                   $add_data['savings_card_name'] = $card_info['card_name'];
                   $add_data['card_amount'] = $order_info['card_pay_amount'];
                   $add_data['card_remaining'] = $card_info['remaining_card_amount'] - $order_info['card_pay_amount'];
                   //默认写主卡余额。
                   $add_data['parent_card_remaining'] = $add_data['card_remaining'];
                   $add_data['level'] = $card_info['level'];
                   
                   if( $card_info['level'] == 2 )
                   {
                       //如果是二级卡，则一级卡减去消费金额，得到一级卡消费后余额。
                       $add_data['parent_card_remaining'] = $card_info['level_two_show_card_amount'] - $order_info['card_pay_amount'];
                   }
                   
                   //添加使用记录。
                   if( $this->db->insert('savings_card_consumption', $add_data) )
                   { 
                       $log_data['card_amount'] = $order_info['card_pay_amount'];
                       $log_data['type'] = 2;//支出
                       $log_data['obj_id'] = $order_info['id'];
                       $log_data['remarks'] = '购物支出订单号：'.$order_info['order_sn'];
                       $log_data['event'] = 1;//订单事件。
                       $log_data['customer_id'] = $order_info['customer_id'];
                       
                       //添加消费日志。
                       $row = $this->Create_Card_Log($log_data);
                       
                       if( in_array($order_info['status'],array( 9, 14 ) ) )
                       {
                           //店主储值卡收入日志。
                           $log_data['card_amount'] = $order_info['card_pay_amount'];
                           $log_data['type'] = 1;//收入出
                           $log_data['obj_id'] = $order_info['id'];
                           $log_data['remarks'] = '销售收入订单号：'.$order_info['order_sn'];
                           $log_data['event'] = 1;//订单事件。
                           $log_data['customer_id'] =  $order_info['corp_customer_id'];//收入用户。
                       
                           //添加收入日志。
                           $row = $this->Create_Card_Log($log_data);
                       }
                       
                       if( $row )
                       {
                           return true;
                       }
                   }
                
                }
                
            } //else{ 
                
                //卡余额不足以支付。
            //}
            
        } //else{ 
            //卡不存在。
        //}
        
        return false;
       
    }
	
	
	
	
    
    
    
    
    
    
    
    
}