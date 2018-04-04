<?php
/**
 * 
 * 
 *
 */
class Order_rebate_mdl extends CI_Model {
	
    public $id;
    
    function __construct() {
		parent::__construct ();
	}
    
	function getList( $condition, $customer_id,$num = false,$limit='',$offset='' ){

	    $sql ='';
	    $where = '';
	     
	    //根据条件进行搜索
	    if(isset($condition["select_id"])&&$condition["select_id"]!=null)
	    {
	        switch ($condition["select_id"])
	        {
	            case 1 :
	                if(isset($condition["customer_id"]) && $condition["customer_id"]!=null)
	    
	                    $where .= "where a.customer_id = '{$condition['customer_id']}'";
	                    break;
	            case 2 :
	                if(isset($condition["corporation_name"]) && $condition["corporation_name"]!=null)
	                     
	                    $where .= " where a.corporation_name like '%{$condition["corporation_name"]}%'";
	                    break;
	            case 3 :
	                if(isset($condition["name"])&&$condition["name"]!=null)
	                    $where .= " where c.name = '{$condition["name"]}'";
	                    break;
	        }
	    }
	     
	    if(isset($condition["start_time"])&&$condition["start_time"]!=null)
	    {
	         
	        if( $where != null )
	        {
	            $where.= 'and ';
	        }else{
	            $where .= 'where';
	        }
	        $where .= " c.last_login_at >= '{$condition["start_time"]} 00:00:00'";
	    }
	     
	    if(isset($condition["end_time"])&&$condition["end_time"]!=null)
	    {
	        if( $where != null )
	        {
	            $where.= 'and ';
	        }else{
	            $where .= 'where';
	        }
	         
	        $where .= " c.last_login_at <= '{$condition["end_time"]} 00:00:00'";
	    }
	    
	     
	    if( $num ) //统计总条数和总分成金额
	    {
	        $sql .= 'select count(a.customer_id) as count, sum(a.rebate) as total_rebate from (';
	    }else{
	        $sql .= 'select a.*,c.name,c.last_login_at,c.registry_at from (';
	    }
	     
	    //下线SQL
	    $sql .= " select o_r.customer_id,sum(o_r.rebate_1) as rebate, 1 as relationship, any_value(cc.`corporation_name`) as corporation_name
	    from 9thleaf_order_rebate as o_r left join 9thleaf_customer_corporation as cc on cc.customer_id = o_r.customer_id
	    where o_r.rebate_1_id = '{$customer_id}' group by o_r.customer_id";
	    //union
	    $sql .=' union ';
	    //下下线SQL
	    $sql .= " select o_r.customer_id,sum(o_r.rebate_2) as rebate, 2 as relationship, any_value(cc.`corporation_name`) as corporation_name  from
	    9thleaf_order_rebate as o_r left join 9thleaf_customer_corporation as cc on cc.customer_id = o_r.customer_id
	    where o_r.rebate_2_id = '{$customer_id}' group by o_r.customer_id ";
	    
	     
	     
	    $sql .=" ) as a left join 9thleaf_customer as c on c.id = a.customer_id {$where}";
	     
	    //分页
	    if($limit!=null||$offset!=null)
	        $sql .= 'limit '.$offset.','.$limit;
	        $query = $this->db->query($sql);
	        // 	    echo $this->db->last_query();
	        if( $num )
	        {
	            return $query->row_array();
	        }
	         
	        return $query->result_array();
	    
	         
	}
	
	
	//下线分成明细
	function rebate_detail($condition,$customer_id,$num = false,$limit='',$offset='')
	{
	    //         echo '<pre>';
	    //         var_Dump($condition);
	    $sql = '';
	    $where = '';
	
	
	    //根据条件进行搜索
	    if(isset($condition["select_id"])&&$condition["select_id"]!=null)
	    {
	        switch ($condition["select_id"])
	        {
	            case 1 :
	                if(isset($condition["customer_id"]) && $condition["customer_id"]!=null)
	
	                    $where .= "where a.order_sn = '{$condition['order_sn']}'";
	                    break;
	            case 2 :
	                if(isset($condition["corporation_name"]) && $condition["corporation_name"]!=null)
	
	                    $where .= " where a.corporation_name like '%{$condition["corporation_name"]}%'";
	                    break;
	        }
	    }
	
	    if(isset($condition["start_time"])&&$condition["start_time"]!=null)
	    {
	        // 	        $this->db->where("create_date >= '".$condition["start_time"]." 00:00:00'");
	         
	        if( $where != null )
	        {
	            $where.= 'and ';
	        }else{
	            $where .= 'where';
	        }
	        $where .= " a.place_at >= '{$condition["start_time"]} 00:00:00'";
	    }
	     
	    if(isset($condition["end_time"])&&$condition["end_time"]!=null)
	    {
	        if( $where != null )
	        {
	            $where.= 'and ';
	        }else{
	            $where .= 'where';
	        }
	         
	        $where .= " a.place_at <= '{$condition["end_time"]} 00:00:00'";
	    }
	     
	
	    if( $num )
	    { //统计总条数和总分成金额
	        $sql .= 'select count(customer_id) as row_num,sum(total_price) as order_total_price,sum(a.total_rebate) as total_rebate, sum(a.rebate) as rebate from (';
	
	    }else{
	        $sql .= 'select a.* from (';
	    }
	    
	    //下线
	    $sql .= "
	    select o.id,o_r.customer_id,o.order_sn,o.total_price,o_r.total_price as total_rebate,o_r.rebate_1 as rebate, 1 as relationship,cc.`corporation_name` ,o.place_at from 9thleaf_order_rebate as o_r left join 9thleaf_order as o on o.id = o_r.orderid
	    left join 9thleaf_customer_corporation as cc on cc.customer_id = o_r.customer_id
	    where o_r.rebate_1_id = '{$customer_id}'
	    ";
	    $sql .= 'union ';
	
	    $sql .="
	    select  o.id,o_r.customer_id,o.order_sn,o.total_price,o_r.total_price as total_rebate,o_r.rebate_2 as rebate, 2 as relationship,cc.`corporation_name` ,o.place_at from 9thleaf_order_rebate as o_r left join 9thleaf_order as o on o.id = o_r.orderid
	    left join 9thleaf_customer_corporation as cc on cc.customer_id = o_r.customer_id
	    where o_r.rebate_2_id = '{$customer_id}'
	    ";
	
	    $sql .=" ) as a  order by a.id desc $where ";
	
	    //分页
	    if($limit!=null||$offset!=null)
	        $sql .= 'limit '.$offset.','.$limit;
	
	        $query = $this->db->query($sql);
	
	        if( $num )
	        {
	            return $query->row_array();
	        }
	        return $query->result_array();
	}
	
	function count_list($condition){
	    
	    $this->db->select('orr.*,o.order_sn,c.last_login_at,c.nick_name,c.registry_at,cc.corporation_name,cc.id as corporation_id');
	     
	    $this->rebate($condition);
	   
	    $res = $this->db->count_all_results();
	    return $res;
	}
	
	function rebate($condition){
	    
	    $this->db->from('customer as c');    
	    $this->db->join('customer_corporation as cc', 'c.id = cc.customer_id','left outer');
	    $this->db->join('order as o','o.corporation_id = cc.id','left outer');
	    $this->db->join('order_rebate as orr','o.id = orr.orderid','left outer');	
	    $this->db->where('c.parent_id',$condition['customer_id']);
	    $this->db->where("cc.id is not null");
	    
	    //根据条件进行搜索
	    if(isset($condition["select_id"])&&$condition["select_id"]!=null)
	    {
	        switch ($condition["select_id"])
	        {
	            case 1 :
	                if(isset($condition["order_sn"])&&$condition["order_sn"]!=null)
	                    $this->db->where("o.order_sn",$condition["order_sn"]);
	                break;
	            case 2 :
	                if(isset($condition["corporation_name"])&&$condition["corporation_name"]!=null)
	                    $this->db->where("cc.corporation_name",$condition["corporation_name"]);
	                break;
	            case 3 :
	                if(isset($condition["nick_name"])&&$condition["nick_name"]!=null)
	                    $this->db->where("c.name",$condition["nick_name"]);
	                break;
	        }
	    }
	    if(isset($condition["start_time"])&&$condition["start_time"]!=null)
	    {
	        $this->db->where("create_date >= '".$condition["start_time"]." 00:00:00'");
	    }
	    if(isset($condition["end_time"])&&$condition["end_time"]!=null)
	    {
	        $this->db->where("create_date <= '".$condition["end_time"]." 00:00:00'");
	    }
	    if(isset($condition["is_notrebate"])&&$condition["is_notrebate"])
	    {
	        $this->db->where("orr.id is not null");
	    }
	   
// 	    	    echo $this->db->last_query();exit;	    
	    
	}
    

	/**
	 * C端分成系统
	 * @$order_detaile = 订单详情;
	 */
	public function order_rebate( $order_detaile ){
	     
	    $this->load->model('rebate_mdl');
	    $this->load->model('customer_mdl');
	    $this->load->model('customer_corporation_mdl');
	    $this->load->model('Customer_shop_mdl');
	    
	    if( $order_detaile )
	    {
	        $retio_price = $order_detaile['commission']; //分成金额
	
	        if($retio_price < 0.01) //可分成金额小于0.01时不分成
	            return 1;
	
	        //订单的用户。
	        $customer_id = $order_detaile['customer_id']; 
	        
	        //卖家的企业信息
	        $corp_detaile = $this->customer_corporation_mdl->corp_load( $order_detaile['corporation_id'] );
	
	        //订单商品总价
	        $total_price = $order_detaile['total_price'];
            
	        //订单ID
	        $order_id = $order_detaile['id'];
	
	        //店主分站id
	        $app_id = $corp_detaile['app_id'];
	        
	        //获取收货人的上级ID
	        $parent_id = $this->customer_mdl->load($customer_id)['parent_id'];
	
	        //判断使用哪一种比率
	        
	        $sort = 2; //默认无互助店
	        
	        $is_shop = $this->Customer_shop_mdl->load($customer_id);
	        
	        //（有互助店 无 互助店）
	        if( $is_shop && $is_shop['status'] == 1 )
	        { 
	            $sort = 3; //有互助店
	            
	            $rebate_data["rebate_3_id"] = $customer_id;
	        }
	         
	        //查询比率出来；
	        $ratio = $this->rebate_mdl->load($sort);
            
	        //构造分成资料信息
	        $rebate_data['order_id'] = $order_id;
	        $rebate_data['total_price'] = $retio_price;
	        $rebate_data['customer_id'] = $order_detaile['customer_id'];
	        
	        $this->load->model('Config_mdl');
	        $ehw_info = $this->Config_mdl->load(3);
	        //避免后台没有配置比例-；全部会分给易货网！
	        $rebate_data['rebate_5_id'] = !empty($ehw_info['value']) ? $ehw_info['value'] : '-1';//对象易货网ID
	        $rebate_data['rebaterate_5'] = 1;//百分百比率
	        $rebate_data['rebate_5'] = !$ratio ? $retio_price : 0 ; //全部分成
	        
	        if(!$ratio)
	        {   
	            $rebate_data["rebate_3_id"] = 0;
	            $order_rebate_id = $this->add($rebate_data);
	            
	            if( $order_rebate_id )
	                return 1;
	             
	        }else{
	            
	            if( $sort == 2 )
	            { 
	                //不是互助店-删除互助店比率。
	                $ratio['rebate3'] = 0;
	            }
	            
	            if( $parent_id )
    	        {
    	            //查询上上级的信息
    	            $parent_parent = $this->customer_mdl->load($parent_id);
    	
    	            if( !empty( $parent_parent['parent_id'] ) )
    	            {
    	                //上上级ID
    	                $parent_parent_id = $parent_parent['parent_id'];
    	                
    	                $rebate_data["rebate_2_id"] = $parent_parent_id;
    	                
    	            }else{ 
    	                
    	                //无上上级删除比率。
    	                $ratio['rebate2'] = 0;
    	            }
    	            
    	            $rebate_data["rebate_1_id"] = $parent_id;
    	            
    	        }else{ 
    	            
    	            //无上级时将 一级比率删除二级比率删除
    	            $ratio['rebate1'] = 0;
    	            $ratio['rebate2'] = 0;
    	        }
    	
    	        $zong_ratio = 0;//占总比例的多少。
    	        $new_ratio = array();
    	        
    	        for( $i = 1; $i<6; $i++)
    	        { 
    	            if( $ratio['rebate'.$i]  )
    	            {
    	                $new_ratio[$i] = $ratio['rebate'.$i];
    	            }
    	            //统计百分之几;
    	            $zong_ratio += $ratio['rebate'.$i];
    	        }
    	        
    	        
    	        $total_price = 0;//初始化总共分了多少钱；
    	        $total_rabate = 0;//初始化总共分了多少百分比；
    	        
    	        //计算分成
    	        foreach ( $new_ratio as $k => $v )
    	        { 
    	            
    	            //精确分到的比率
    	            $rebaterate = strpos($v/$zong_ratio,'.') ? substr_replace($v/$zong_ratio, '', strpos($v/$zong_ratio, '.') + 3) : $v/$zong_ratio;
    	            
    	            //精确分到的金额
    	            $commission = strpos($rebaterate*$retio_price,'.') ? substr_replace($rebaterate*$retio_price, '', strpos($rebaterate*$retio_price, '.') + 3) : $rebaterate*$retio_price;

    	            //大于0才insert值进去。
    	            if( $commission > 0 )
    	            {
        	            $rebate_data["rebaterate_$k"] = $rebaterate;
        	            $rebate_data["rebate_$k"] = $commission; 
    	            
    	            }else{ 
    	                
    	                $rebate_data["rebate_{$k}_id"] = 0;
    	            }
    	            $total_price += $commission;
    	            $total_rabate += $rebaterate;
    	            
    	        }
    	        
    	        //分成对象ID
    	        //查询分站点所属的用户ID
    	        $this->load->model('App_info_mdl');
    	        $app_info = $this->App_info_mdl->load( $app_id );
    	        $rebate_data['rebate_4_id'] =  !empty($app_info['customer_id']) ? $app_info['customer_id'] : $rebate_data['rebate_5_id'];//分站点用户ID；

    	        
    	        //有剩余的全部给易货网
    	        $rebate_data['rebate_5'] += $retio_price - $total_price;
    	        $rebate_data['rebaterate_5'] += 1 - $total_rabate;
                
    	       
	        }

	        $order_rebate_id = $this->add($rebate_data);
	         
	        if( $order_rebate_id )
	        {
	            return 1;
	        }
	            
	    }
	    
	    return false;
	}
	
	/**
	 * insert 分成记录
	 *
	 */
	public function add($data){
	     
	    $this->db->set('orderid',$data['order_id']);
	    $this->db->set('create_date',date('Y-m-d H:i:s'));
	     
	    if(!empty($data['rebate_1']) )
	        $this->db->set('rebate_1',$data['rebate_1']);
	    if(!empty($data['rebate_2']) )
	        $this->db->set('rebate_2',$data['rebate_2']);
	    if(!empty($data['rebate_3']) )
	        $this->db->set('rebate_3',$data['rebate_3']);
	    if(!empty($data['rebate_4']) )
	        $this->db->set('rebate_4',$data['rebate_4']);
	    if(!empty($data['rebate_5']) )
	        $this->db->set('rebate_5',$data['rebate_5']);
	  
	     
	
	    if(!empty($data['rebate_1_id']) )
	        $this->db->set('rebate_1_id',$data['rebate_1_id']);
	    if(!empty($data['rebate_2_id']) )
	        $this->db->set('rebate_2_id',$data['rebate_2_id']);
	    if(!empty($data['rebate_3_id']) )
	        $this->db->set('rebate_3_id',$data['rebate_3_id']);
	    if(!empty($data['rebate_4_id']) )
	        $this->db->set('rebate_4_id',$data['rebate_4_id']);
	    if(!empty($data['rebate_5_id']) )
	        $this->db->set('rebate_5_id',$data['rebate_5_id']);
	    
	
	    if(!empty($data['rebaterate_1']) )
	        $this->db->set('rebaterate_1',$data['rebaterate_1']);
	    if(!empty($data['rebaterate_2']) )
	        $this->db->set('rebaterate_2',$data['rebaterate_2']);
	    if(!empty($data['rebaterate_3']) )
	        $this->db->set('rebaterate_3',$data['rebaterate_3']);
	    if(!empty($data['rebaterate_4']) )
	        $this->db->set('rebaterate_4',$data['rebaterate_4']);
	    if(!empty($data['rebaterate_5']) )
	        $this->db->set('rebaterate_5',$data['rebaterate_5']);
	    
	
	    $this->db->set('total_price',$data['total_price']);
	    $this->db->set('customer_id',$data['customer_id']);
	    $this->db->insert('order_rebate');
	    return $this->db->insert_id();
	}
	

	
	//添加互助店分成记录
	public function add_shop_rebate($data){
	    $this->db->set('create_date',date('Y-m-d H:i:s'));
	    $this->db->set('chargeid', $data['chargeid']);
	    $this->db->set('rebate_1', $data['rebate_1']);
	    $this->db->set('rebate_2', $data['rebate_2']);
	    $this->db->set('rebate_3', $data['rebate_3']);
	    $this->db->set('rebate_4', $data['rebate_4']);
	    $this->db->set('rebate_5', $data['rebate_5']);
	    $this->db->set('orderid', NULL);
	    $this->db->set('rebate_type', $data['rebate_type']);
	    $this->db->set('customer_id', $data['customer_id']);
	    $this->db->set('total_price', $data['total_price']);
	    $this->db->set('rebate_1_id', $data['rebate_1_id']);
	    $this->db->set('rebate_2_id', $data['rebate_2_id']);
	    $this->db->set('rebate_3_id', $data['rebate_3_id']);
	    $this->db->set('rebate_4_id', $data['rebate_4_id']);
	    $this->db->set('rebate_5_id', $data['rebate_5_id']);
	    
	    $this->db->insert('order_rebate');
	    return $this->db->insert_id();
	    
	}


	
	/**
	 * 我的分销-订单SQL
	 */
	public function my_retail($rebate,$rebaterate,$status,$customer_id_array,$sql_status=null,$limit=null,$offset=null)
	{ 
	    
	    $sql = '';
	    
	    if( $sql_status )
	    { 
	        $sql .="select sum(b.total_price) as order_total_price,count(id) as total_num,sum(rebaterate) as total_rebaterate  from ( ";
	    }
	    
	    $sql .= "select o_r.$rebaterate as rebaterate, r.$rebate as rebate,o.id,o.order_sn,any_value(product_name) as product_name ,sum(oi.quantity) as product_num,o.total_price,o.commission ,o.status ";
	    
	    //表
	    $sql .= " from 9thleaf_order as o";
	    $sql .=" left join 9thleaf_order_item as oi on oi.order_id = o.id ";
	    $sql .=" left join 9thleaf_customer_corporation as cc on o.corporation_id = cc.id ";
	    $sql .=" left join 9thleaf_rebate as r on r.app_id = cc.app_id and r.sort = 3 ";
	    $sql .=" left join 9thleaf_order_rebate as o_r on o_r.orderid = o.id";
	    $sql .=" where o.customer_id in ({$customer_id_array})";
	    
	    
// 	    $this->db->select("o_r.$rebaterate as rebaterate, r.$rebate as rebate,o.id,o.order_sn,any_value(product_name) as product_name ,sum(oi.quantity) as product_num,o.total_price,o.commission ,o.status");
// 	    $this->db->from('order as o ');
// 	    $this->db->join('order_item as oi','oi.order_id = o.id','left');
// 	    $this->db->join('customer_corporation as cc','o.corporation_id = cc.id','left');
// 	    $this->db->join('rebate as r','r.app_id = cc.app_id and r.sort = 3 ','left');
// 	    $this->db->join('order_rebate as o_r','o_r.orderid = o.id','left');
// 	    $this->db->where_in('o.customer_id',$customer_id_array );
	    
	    if( !empty($status ) )
	    { 
// 	        $this->db->where('o.status', $status );
	        $sql .=" and o.status in ({$status}) ";
	    }
	    
	    $sql .= " group by o.id,r.id,o_r.id";
	    if ($limit)
	        $sql .= " limit $limit ";
	    // 	        $this->db->limit ( $limit );
	    if ($offset)
	        $sql .= " offset $offset";
// 	    $this->db->group_by('o.id,r.id,o_r.id');
// 	    $query = $this->db->get();
	    
	    if( $sql_status )
	    {
	        $sql .=" ) as b ";
	    }
	    
	    $query = $this->db->query($sql);
	    
	    if( $sql_status )
	    {
	        return $query->row_array();
	    }
	    
	    return $query->result_array();
	    
	}
	
	
	/**
	 * 未收货的佣金
	 */
	public function not_receive_commission( $customer )
	{ 
	    $sql = '';
	    $i = 1;
	    foreach ($customer as $key => $val )
	    { 
	        
	        if( $i > 1)
	        { 
	            $sql .=" union ";
	        }
	        $sql.= " select $key as level, sum(b.rebaterate) as rebaterate from ( ";
	        $sql.= " select if(r.rebate{$key} and o.commission,r.rebate{$key}/100*o.commission,0) as rebaterate,o.id,o.order_sn,o.total_price,o.commission"; 
            $sql.= " from 9thleaf_order as o";
            $sql.= " left join 9thleaf_customer_corporation as cc on o.corporation_id = cc.id";
            $sql.= " left join 9thleaf_rebate as r on r.app_id = cc.app_id and r.sort = 3";
            $sql.= " where o.customer_id in ({$val}) and o.status in (4,6) group by o.id,r.id ) as b";
            
            $i++;
	    }
	    
	    $query = $this->db->query($sql);
	    
	    return $query->result_array();
    
	    
	    
	}
	
	/**
	 * 收货了的佣金 || 审核通过的佣金
	 */
	public function receive_commission( $customer,$status, $rebate_type )
	{ 
	    $sql = '';
	    $i = 1;
	    foreach ($customer as $key => $val )
	    {
	         
	        if( $i > 1)
	        {
	            $sql .=" union ";
	        }
	        $sql.= " select {$key} as level, sum(o_r.rebate_{$key}) as rebaterate ";
	        
	        if( $rebate_type == 2){ //货豆需要关联订单-收货-未收货的。
                $sql.= " from 9thleaf_order as o";
                $sql.= " join 9thleaf_order_rebate as o_r on o.id = o_r.orderid and o.customer_id = o_r.customer_id";
                $sql.= " where o.customer_id in ({$val}) and o_r.rebate_{$key}_id = {$customer[3]}";
	        }else{ 
	            $sql .=" from 9thleaf_order_rebate as o_r";
	            $sql .= " where o_r.customer_id in ({$val}) and o_r.rebate_{$key}_id = {$customer[3]} "; 
	        }
            
            if( !empty($status) )
                $sql.=" and o_r.status = 1";
            if( !empty($rebate_type) )
                $sql.=" and o_r.rebate_type = {$rebate_type} ";
            
            $i++;
	    }
	     
	    $query = $this->db->query($sql);
	     
	    return $query->result_array();
	}
	
	
	/**
	 * 全平台收益排行榜
	 */
	public function profit_ranking_list( $customer,$time, $limit=null,$offset=null,$customer_id = null)
	{ 
	    $sql = '';
	    $where = '';
	    $i = 1;
	    
	    if( $customer_id )
	    { 
	        $sql .=" select * from ( select @s:=@s+1 as ranking,a.* from ( ";
	    
	    }
	    if( !empty($time['start_at']) && !empty($time['ent_at']) )
	    {
	        $where = " where create_date  >= '{$time['start_at']}' and create_date <= '{$time['ent_at']}' ";
	        
	    }
	    
	    $sql .=" select a.customer_id,c.name,c.nick_name,c.wechat_nickname,sum(a.rebate) as rebate from ( ";
	    
	    foreach ( $customer as $v)
	    { 
	        if( $i > 1)
	        {
	            $sql .=" union ";
	        }
	        
	        $sql .=" select rebate_{$v}_id as customer_id,sum(rebate_{$v}) as rebate from 9thleaf_order_rebate as ora {$where} group by ora.rebate_{$v}_id ";
	        
	        $i++; 
	    }
	    $sql .=" ) as a  join 9thleaf_customer as  c on c.id = a.customer_id group by customer_id order by rebate desc";
	    
	    if ($limit)
	        $sql .= " limit $limit ";
	   
	    if ($offset)
	        $sql .= " offset $offset";
	    
	    if( $customer_id )
	    { 
	        $sql .= ") as a, (select @s:=0) b ) as c  where c.customer_id = {$customer_id}";
	    }
        $query = $this->db->query($sql);
        
        if( $customer_id )
        { 
            return $query->row_array();
        }
//         echo $this->db->last_query();exit;
	    return $query->result_array();
	}
	


	//------------------------------------------------------
	
	/**
	 * 根据用户id查询收益合计
	 * @param int $customer_id 用户id
	 * @param int $limit
	 * @param int $offset
	 * @param string $start_at 开始时间
	 * @param string $ent_at 结束时间
	 */
	public function profit($customer_id,$limit=NULL,$offset=NULL,$start_at=NULL,$ent_at=NULL){
        $where = "";
	    if($start_at && $ent_at){
            $where = "and b.create_date >='$start_at' and  b.create_date <='$ent_at'";
	    }

	    //思路；第一个子查询查处我的下线用户，第二个子查询用case区分现金还是货豆收入并合计，第三个子查询合计货豆和现金的总和并且实现排序
	    $query = $this->db->query("
	        select *,(cash+m_price) as total from 
            (select a.id,any_value(a.name) as name,sum(case when a.level=1 and b.rebate_type=1 then b.rebate_1 when a.level=2 and b.rebate_type=1 then b.rebate_2 else 0.00 end) as cash ,sum(case when a.level=1 and b.rebate_type=2 then b.rebate_1 when a.level=2 and b.rebate_type=2 then b.rebate_2 else 0.00 end) as m_price,any_value(level) as level from 
	        (select id,name,1 as level from 9thleaf_customer 
            where parent_id = '$customer_id' 
            union
            select id,name,2 as level from 9thleaf_customer
            where parent_id in (select id from 9thleaf_customer where parent_id = '$customer_id') 
	        ) as a 
            join 9thleaf_order_rebate as b on a.id = b.customer_id $where
            group by a.id ) as c order by total desc limit $offset,$limit
	        ");
	    return $query->result_array();
	}
	
	//----------------------------------------------------
	
	/**
	 * 收入统计
	 */
	public function income($customer_id,$limit=null,$offset=null,$start_at=NULL,$ent_at=NULL){
	    $where = "";
	    if($start_at && $ent_at){
	        $where = "and a.create_date >='$start_at' and  a.create_date <='$ent_at'";
	    }
	    
	    $query = $this->db->query("
	     select a.*,b.wechat_nickname,b.nick_name from (
        	select customer_id,rebate_1 as total,rebate_type,create_date,1 as level from 9thleaf_order_rebate
            where rebate_1_id = '$customer_id' 
            union all
            select customer_id,rebate_2 as total,rebate_type,create_date,2 as level from 9thleaf_order_rebate
            where rebate_2_id = '$customer_id' 
            union all
            select customer_id,rebate_3 as total,rebate_type,create_date,3 as level from 9thleaf_order_rebate
            where rebate_3_id = '$customer_id' 
         ) as a 
         join 9thleaf_customer as b on a.customer_id = b.id 
	        
         where b.is_active = 1 $where order by a.create_date desc limit $offset,$limit
	        ");
	    return $query->result_array();
	}

	public function load( )
	{ 
	    if( $this->id )
	    { 
	        $query = $this->db->get_where('order_rebate',array('id'=>$this->id ) );
	        return $query->row_array();
	    }
	    
	    return array();
	}
}