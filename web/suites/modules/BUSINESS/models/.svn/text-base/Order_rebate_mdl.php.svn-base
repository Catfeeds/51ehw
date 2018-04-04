<?php
/**
 * 
 */
class Order_rebate_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
    
	//重写getList
	function getList($condition,$customer_id,$num = false,$limit='',$offset=''){
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

	                    $where .= " o.order_sn = '{$condition['order_sn']}'";
	                    break;
	            case 2 :
	                if(isset($condition["corporation_name"]) && $condition["corporation_name"]!=null)
 
	                    $where .= "  cc.corporation_name like '%{$condition["corporation_name"]}%'";
	                    break;
	        }
	    }

        if(isset($condition["start_time"])&&$condition["start_time"]!=null)
	    {
// 	        $this->db->where("create_date >= '".$condition["start_time"]." 00:00:00'");
	        
	        if( $where != null )
	        { 
	            $where.= 'and ';
	        }
	        $where .= " o.place_at >= '{$condition["start_time"]} 00:00:00'";
	    }
	    
	    if(isset($condition["end_time"])&&$condition["end_time"]!=null)
	    {
	        if( $where != null )
	        {
	            $where.= 'and ';
	        }
	        
	        $where .= " o.place_at <= '{$condition["end_time"]} 00:00:00'";
	    }
	    
        
	    if( $num ){ //统计总条数和总分成金额
// 	        $sql .= 'select count(customer_id) as row_num,sum(total_price) as order_total_price,sum(a.total_rebate) as total_rebate, sum(a.rebate) as rebate from (';
            $this->db->select(' count(*) as row_num ,sum(o.total_price) as order_total_price,sum(o_r.total_price) as total_rebate, sum(rd.rebate) as rebate ');
	    }else{ 
	        $this->db->select(' o.order_sn,cc.corporation_name,rd.role_id,o.total_price,o_r.total_price as total_rebate ,rd.rebate,o.place_at ');
	    }
//         //下线
//         $sql .= "
//             select o.id,o_r.customer_id,o.order_sn,o.total_price,o_r.total_price as total_rebate,o_r.rebate_1 as rebate, 1 as relationship,cc.`corporation_name` ,o.place_at from 9thleaf_order_rebate as o_r left join 9thleaf_order as o on o.id = o_r.orderid 
//             left join 9thleaf_customer_corporation as cc on cc.customer_id = o_r.customer_id 
//             where o_r.rebate_1_id = '{$customer_id}' 
//             ";
//         $sql .= 'union ';
        
//         $sql .=" 
//             select  o.id,o_r.customer_id,o.order_sn,o.total_price,o_r.total_price as total_rebate,o_r.rebate_2 as rebate, 2 as relationship,cc.`corporation_name` ,o.place_at from 9thleaf_order_rebate as o_r left join 9thleaf_order as o on o.id = o_r.orderid 
//             left join 9thleaf_customer_corporation as cc on cc.customer_id = o_r.customer_id
//             where o_r.rebate_2_id = '{$customer_id}' 
//             ";
        
//         $sql .=" ) as a  order by a.id desc $where ";
        $this->db->from('order_rebate_new as o_r');
        $this->db->join('order_rebate_detail as rd','o_r.id = rd.order_rebate_new_id');
        $this->db->join('order as o','o.id = o_r.orderid','left');
        $this->db->join('customer as c','o_r.customer_id = c.id','left');
        $this->db->join('customer_corporation as cc','o_r.customer_id = cc.customer_id','left');
        $this->db->where('rd.obj_id',$customer_id );
        $this->db->where_in('rd.role_id',array(1,2) );
        if( $where )
            $this->db->where( $where );
        
        
	    //分页
// 	    if($limit!=null || $offset!=null)
        $this->db->limit( $limit,$offset );
//     	    $sql .= 'limit '.$offset.','.$limit;
            
//         $query = $this->db->query($sql);
        $query = $this->db->get();
        
        if( $num )
	    {
	        return $query->row_array();
	    }
        return $query->result_array();
    }
    

	
// 	function count_list($condition){
	    
// 	    $this->db->select('orr.*,o.order_sn,c.last_login_at,c.nick_name,c.registry_at,cc.corporation_name,cc.id as corporation_id');
	     
// 	    $this->rebate($condition);
	   
// 	    $res = $this->db->count_all_results();
// 	    return $res;
// 	}
	
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
	 * insert 分成记录
	 * 
	 */
	public function add( $data )
	{ 
	    //动态添加。
	    $data['create_date'] = date('Y-m-d H:i:s');
	    $this->db->insert('order_rebate_new',$data);
	    return $this->db->insert_id();

	}
	
	/**
	 * 分成系统
	 * @$order_detaile = 订单详情;
	 */
	public function order_rebate( $order_detaile )
	{
	    
	   if( $order_detaile )
	   {
	        $this->load->model('Customer_rebate_mdl');
	        $this->load->model('customer_mdl');
	        $this->load->model('customer_corporation_mdl');
	        
	        $retio_price = $order_detaile['commission']; //分成金额
	         
	        if( $retio_price < 0.01 ) //可分成金额小于0.01时不分成
	            return 1;
	         
	        //收货人的用户&企业信息
	        $customer_info = $this->customer_corporation_mdl->load_corp_customer_info( $order_detaile['customer_id'] );
	         
	        //获取收货人的上级ID
	        $parent_id = $customer_info['parent_id'];
	         
	        //收货人的企业分站点ID
	        $app_id = $customer_info['app_id'];
	        
	        //查询需要分成的百分比
            $sift['where']['customer_id'] = $order_detaile['customer_id'];
            $ratio_info = $this->Customer_rebate_mdl->Load( $sift );
           
            //添加进分成主表表
            $order_rebate_data['orderid'] = $order_detaile['id'];
            $order_rebate_data['order_sn'] = $order_detaile['order_sn'];
            $order_rebate_data['total_price'] = $retio_price;
            $order_rebate_data['template_id'] = isset( $ratio_info['template_id'] ) ? $ratio_info['template_id'] : 0;
            $order_rebate_data['customer_id'] = $order_detaile['customer_id'];
            $order_rebate_data['app_id'] = $customer_info['app_id'];
            
            //添加进分成主表表
            $order_rebate_id = $this->add( $order_rebate_data );
            
            if( $order_rebate_id )
            {
                if( $ratio_info && !empty( $ratio_info['config'] ) )
                { 
                    //将模板比率JSON转成数组。
                    $role_ratio = array_column( json_decode( htmlspecialchars_decode( $ratio_info['config'] ),true ),NULL,'role_id' );
                    
                    //角色对应对象的数据。key=角色ID
                    $role_obj= json_decode( $ratio_info['config_data'] ,true );
                   
                    $this->order_rebate_id = $order_rebate_id;
                    $this->app_id = $customer_info['app_id'];;
                    $this->customer_id = $order_detaile['customer_id'];
                    $this->parent_id = $parent_id;
                    
                    //调用递归处理分成方法。
                    $result = $this->Rebate_Obj( $role_ratio, $role_obj ,$retio_price );
    
                    if( !empty( $result ) && !empty( $result[8] ) )
                    { 
                        //处理担保人分成。
                        $guarantee_data = $this->Guarantee_Rebate( $order_rebate_id, $result[8] );
                         
                        //角色担保人分配完毕-删除。
                        unset($result[8] );
                        
                        if( !empty( $guarantee_data['data'] ) )
                        {
                            //返回合伙人分成列表+原来的。合并。
                            $result =  array_merge( $result, $guarantee_data['data'] );
                        }
                        
                    }
                    //转成金额对应比率，方便后台显示。
                    $result = $this->Computational_Ratio( $result, $order_detaile['commission'] );
                    
                    //添加详细分成。
                    if( $this->db->insert_batch( 'order_rebate_detail',$result ) )
                    {
                        return 1;
                    }
                    
                    
                }else{ 
                    
                    //没设置比率，则将钱给易货网。
                    
                    //添加详细分成。
                    $this->load->model('Config_mdl');
                    $ehw_info = $this->Config_mdl->get_config('ehw_id');
                     
                    if( $ehw_info['value'] )
                    {
                        $result['order_rebate_new_id'] = $order_rebate_id;
                        $result['role_id'] = 5;//易货网固定是5
                        $result['obj_id'] = $ehw_info['value'];//易货网对象。
                        $result['rebate'] = $retio_price;//金额
                        $result['rebaterate'] = 1;//比率
                        $result['level'] = 1;//等级
                        
                        if( $this->db->insert( 'order_rebate_detail',$result ) )
                        {
                            return 1;
                        }
                    }
                }
            }
	    }
	    
        return false;
	}
	
	
	/**
	 * 无限层分成-将 （角色+对象+比率） 合并起来，最终调用计算方法，返回完整结果。
	 * @$role_ratio = 角色，比率。
	 * @$role_obj =  角色，对象。
	 * 
	 */
	private function Rebate_Obj( $role_ratio = array(), $role_obj = array(), $retio_price, &$result=array() )
	{ 
	    
	    if( $role_ratio )
	    {
	        $zongbilv = 0;
	        
	        //查看是否有下级,如果下级存在就是虚拟角色.
	        foreach ( $role_ratio as $key => $val )
	        {
	            $k = $val['role_id'];//角色ID。
	            
	            if( $k == 8 )//如果担保人角色存在。
	            {
	                //判断是否有担保人
	                $this->load->model('Guarantee_request_mdl');
	                 
	                $guarantee_total = $this->Guarantee_request_mdl->guarantee_detail( $this->customer_id,true )['total'];
	                 
	                //有担保人
	                if( $guarantee_total > 0 )
	                {
	                    //担保人列表
	                    $guarantee_list = $this->Guarantee_request_mdl->guarantee_detail( $this->customer_id );
	                
	                     $role_obj[$k]['obj_id'] = 0;
	                }
	            }
	            
	            //一级不可更换角色数据处理开始----
	            if( $k == 1  && !empty( $this->parent_id ) )//1上级角色ID
	            {
	                $parent_info = $this->customer_mdl->load( $this->parent_id );
	                $role_obj[1]['obj_id'] = $this->parent_id;
	                 
	                //上上级ID
	                $parent_parent_id = $parent_info['parent_id'];
	            }
	            
	            //2 = 上级角色ID
	            if(  $k == 2  && !empty( $parent_parent_id ) )
	            {   
    	            $role_obj[2]['obj_id'] = $parent_parent_id;
	            }
	            
	            //分站点
	            if( $k == 4 )
	            {
	                $this->load->model('App_info_mdl');
	                $app_info = $this->App_info_mdl->load( $this->app_id );
	            
	                if( $app_info['customer_id'] )
	                {
	                    $role_obj[4]['obj_id'] = $app_info['customer_id'];
	                }
	            }
	            
	            //总公司 -- 一定有。
	            if( $k == 5 )
	            {
	                $this->load->model('Config_mdl');
	                $ehw_info = $this->Config_mdl->get_config('ehw_id');
	            
	                if( $ehw_info['value'])
	                {
	                    $role_obj[5]['obj_id'] = $ehw_info['value'];
	                }
	            }
	            
	            //将角色对象ID赋值新数组。//不存在的对象就分成比率母分则不加上去。
	            if( isset( $role_obj[$k]['obj_id'] ) || isset( $val['children'] ) )
	            {
	                //将比率赋值于用户数组这块-计算总额母分比率。
	                $obj_ratio['list'][$k]['obj_id'] = isset( $role_obj[$k]['obj_id']) ? $role_obj[$k]['obj_id'] : 0;
	                $obj_ratio['list'][$k]['rebate'] = $val['rebate'];
	                $obj_ratio['list'][$k]['role_id'] = $val['role_id'];
	                $obj_ratio['list'][$k]['app_id'] = $this->app_id;
	                $obj_ratio['list'][$k]['order_rebate_new_id'] = $this->order_rebate_id;
	                $obj_ratio['list'][$k]['level'] = $val['level'];
	                
	                if( isset( $val['children'] ) )
	                { 
	                    $obj_ratio['list'][$k]['children'] = $val['children'];
	                }
	                
	                $zongbilv += $obj_ratio['list'][$k]['rebate'];
	            
	            }
	        }
	       
	        $obj_ratio['sift']['zongbilv'] = $zongbilv;
	        $obj_ratio['sift']['retio_price'] = $retio_price;
	       
	       //处理返回应该得到的金额。
	        $data = $this->Computational($obj_ratio);
// 	        echo '<pre>';
// 	        var_dump($data);
	        //拼接担保人对象返回出去处理。
	        if( isset( $data['list'][8] ) )
	        { 
	            $data['list'][8]['guarantee_list'] = $guarantee_list;
	            $data['list'][8]['guarantee_total'] = $guarantee_total;
	        }
	        
	        //当前级别分成-剩余的金额。
	        $surplus_price = $data['sift']['retio_price'] - $data['sift']['total_price'];
	        
	        //处理返回的数据，在验证是否有子类，如果有则递归调用，并把上一次处理的结果+起来。
	        if( !empty( $data['list'] ) )
	        { 
	            //剩余的金额分给同级的给最后一位。
	            $data['list'][max( array_keys( $data['list'] ) )]['rebate'] += $surplus_price;
	            
	            $result = $result+$data['list'];//上一次处理结果和本次结果。
	            
	            $children_role_ratio = array(); //初始化。
	            
	            foreach ( $data['list'] as $k=> $v )
	            { 
	                if( isset( $v['children'] ) )
	                {  
	                    unset($result[$k]);
	                    
	                    //格式化子类数据。key = 角色id。
	                    $children_role_ratio = array_column( $v['children'], null ,'role_id');
	                    
	                    //递归。
	                    $this->Rebate_Obj($children_role_ratio,$role_obj,$v['rebate'],$result);
            	    }
	            }
	        }
	    }
	    
	    return $result;
	}
	
	
	
	/**
	 * 根据金额计算比率
	 */
	private function Computational_Ratio( $data = array(), $commission= 0 )
	{ 
	    
	    $new_rebaterate = 0;
	    $new_rebate = 0;
	  
	    //转成金额对应比率-方便后台查询。
	    foreach ( $data as $k => $v )
	    {
	        if( $v['rebate'] > 0 )
	        {
    	        $rebaterate = ( $v['rebate'] / $commission );
    	        
    	        //精确分到的比率
    	        $rebaterate = strpos( $rebaterate,'.') ? substr_replace( $rebaterate, '', strpos( $rebaterate , '.') + 5) : $rebaterate;
    	        //比率重新赋值。
    	        $data[$k]['rebaterate'] = $rebaterate;
    	    
    	        if( $v['role_id'] == 5 )
    	        { 
    	            $i = $k;
    	        }
    	        
    	        $new_rebaterate += $data[$k]['rebaterate'];
    	        $new_rebate += $data[$k]['rebate'];
    	        
	        }else{ 
	            
	            unset($data[$k]);
	        }
	    
	    }
	    
	    //如果易货网存在则用易货网-else 最后一位收益。
	    $i =  isset($i) ? $i : $k;

	    if( !empty( $data[$i] ) )
	    {
	        $data[$i]['rebaterate'] += ( 1 - $new_rebaterate );
	        $data[$i]['rebate'] += $commission - $new_rebate;
	    }
	    
	   
	    return $data;
	}
	/**
	 * 进行分成计算。
	 * 二维数组
	 */
	private function Computational( $data = array() )
	{ 
	    //计算详细分成-分配。
	    $total_rebate = 0;//初始化分成到的总比率  -
	    $total_price = 0;//初始化分成到的总金额 -
	    $zongbilv = $data['sift']['zongbilv'];
	    $retio_price = $data['sift']['retio_price'];
	    
	    
	    if( !empty( $data['list'] ) )
	    {
    	    //构造分成SQL数据
    	    foreach ( $data['list'] as $key => $val )
    	    {
    	        if( $val['rebate'] > 0 && $zongbilv > 0 )
    	        {
        	       //分成比率
        	        $rebaterate = $val['rebate']/$zongbilv;
        	        
        	        //精确到两位小数点的分成比率-精确计算先-后面再用额度计算比率。
        	        $data['list'][$key]["rebaterate"] = $rebaterate;//strpos($rebaterate,'.') ? substr_replace($rebaterate, '', strpos($rebaterate, '.') + 5) : $rebaterate;
        	        
        	        $total_rebate +=  $data['list'][$key]["rebaterate"];
        	        
        	        //分成金额
        	        $commission = ( $data['list'][$key]["rebaterate"] * $retio_price );
        	       
        	        //精确到两位小数点的分成金额。
        	        $data['list'][$key]["rebate"] = strpos( $commission,'.') ? substr_replace( $commission, '', strpos($commission, '.') + 3) : $commission;
        	        $total_price += $data['list'][$key]["rebate"];
    	        }
    	        
    	    }
	    }
	    $data['sift']['total_price'] = $total_price;
	    $data['sift']['total_rebate'] = $total_rebate;
	    
	    return $data;
	}
	
	
	/**
	 * 担保人分成记录
	 * @担保人列表 $guarantee_list
	 * @可分成金额 $rebate_total
	 * @总担保额 $guarantee_total
	 * @分成表的ID $order_rebate_id
	 */
	private function Guarantee_Rebate( $order_rebate_id,$rebate_info)
	{ 
	    
	    /**
	     * 开始计算比率
	     */
	   
	    $guarantee_data = array();//初始化数组
	    $guarantee_rebate = 0;//初始化已分出去的数组
	    $guarantee_rebaterate = 0;//初始化已经分出去的比率
// 	    $guarantee_total = $rebate_info['rebate'];//担保人总分成额
	    
	   
	    foreach ($rebate_info['guarantee_list'] as $key => $val)
	    { 
	        //比率
	        
	        $rebaterate =  $val['guarantee_money']/$rebate_info['guarantee_total'];
	       
	        
	        //精确分到的比率
// 	        $rebaterate = strpos( $rebaterate,'.') ? substr_replace( $rebaterate, '', strpos( $rebaterate , '.') + 5) : $rebaterate;
	        

	        //精确分到的金额
	        $commission = strpos( $rebaterate*$rebate_info['rebate'],'.') ? substr_replace( $rebaterate*$rebate_info['rebate'], '', strpos($rebaterate*$rebate_info['rebate'], '.') + 3) : $rebaterate*$rebate_info['rebate'];
	        
	        //如果分到的钱大于 0 
	        if( $commission > 0 )
	        {
	            
	            $guarantee_data['data'][$key]['role_id'] =  $rebate_info['role_id'];
	            $guarantee_data['data'][$key]['rebaterate'] =  $rebaterate;
	            $guarantee_data['data'][$key]['rebate'] = $commission;
	            $guarantee_data['data'][$key]['obj_id'] = $val['customer_id'];
	            $guarantee_data['data'][$key]['order_rebate_new_id'] = $order_rebate_id;
// 	            $guarantee_data[$key]['guarantee_money'] = $val['guarantee_money'];
	            $guarantee_data['data'][$key]['app_id'] = 0;
	            $guarantee_data['data'][$key]['level'] = $rebate_info['level'];
	            $guarantee_rebate += $commission;
	            $guarantee_rebaterate += $rebaterate;
	            
	            $last_key = $key;//最后一个KEY
	            
	        }
	       
	    }
	    
	    
	    if( $guarantee_data )
	    {
	        //剩余多少钱分给最后一个。
	        $guarantee_data['data'][$last_key]['rebate'] += $rebate_info['rebate'] - $guarantee_rebate;
	      
    	    return $guarantee_data;
    	}
    	
	    return true;
    }
	
	/**
	 * 个人中心查询下级分成给我的信息
	 */
	public function my_order_bebate( $customer_id,$condition,$like, $num = null , $limit= null, $offset = null )
	{ 
	    
	    if (!empty($limit) )
	        $this->db->limit ( $limit );
	    if (!empty($offset) )
	        $this->db->offset ( $offset );
	    
	    if (!empty($like) ) {
	    
	        $this->db->like ( $like );
	    }
	    if ( !empty($condition) ){
	        $this->db->where ( $condition );
	    }
	    
	    $this->db->select('o_r.customer_id,c.registry_at, c.login_count, c.name,sum(o.total_price) as total_price,sum(rd.rebate) as rebate' );
	    $this->db->from('order_rebate_new as o_r');
	    $this->db->join('order_rebate_detail as rd','o_r.id = rd.order_rebate_new_id');
	    $this->db->join('order as o', 'o.id = o_r.orderid','left');
	    $this->db->join('customer as c', 'o_r.customer_id = c.id','left');
	    $this->db->where('rd.obj_id',$customer_id);
	    $this->db->group_by('o_r.customer_id');
	    $query = $this->db->get();
	    
	    if( $num )
	    {
	        return $query->num_rows();
        }
//         echo $this->db->last_query();
        return $query->result_array();
	}
	
	
	/**
	 * 我的收益-包括担保分成收益
	 */
	public function My_Order_Guarantee( $customer_id,$time,$limit,$offset )
	{ 
	    if ( !empty( $limit ) )
	        $this->db->limit ( $limit );
	    
	    if (!empty($offset) )
	        $this->db->offset ( $offset );
	    
	    if( !empty($time['start_at']) && !empty($time['ent_at']) )
	    {
	        $this->db->where('ord.create_date >=',$time['start_at']);
	        $this->db->where('ord.create_date <=',$time['ent_at']);
	    }
	    
	    $this->db->select('cc.corporation_name,orn.total_price,ord.rebate,ord.create_date');
	    
	    $this->db->from('order_rebate_new as orn');
	    $this->db->join('order_rebate_detail as ord', 'orn.id = ord.order_rebate_new_id');
	    $this->db->join('customer_corporation as cc','cc.customer_id = orn.customer_id','left');
	    $this->db->where('ord.obj_id',$customer_id);
	    $this->db->where('orn.status',1);
	    $this->db->order_by('ord.id','desc');
	    $query = $this->db->get();
	    
	    return $query->result_array();
	}
	
	/**
	 * 我的收益-统计相同用户带给我的金额。
	 */
	public function My_Income( $customer_id = 0, $limit, $offset,$corporation_name = '' )
	{ 

	    $this->db->select('orn.customer_id, sum(ord.rebate) as rebate,cc.corporation_name');
	    $this->db->from('order_rebate_new as orn');
	    $this->db->join('order_rebate_detail as ord', 'orn.id = ord.order_rebate_new_id');
	    $this->db->join('customer_corporation as cc','cc.customer_id = orn.customer_id','left');
	    $this->db->where('ord.obj_id',$customer_id);
	    $this->db->where('orn.status',1);
	    if( $corporation_name )
	    {
	       $this->db->like('cc.corporation_name',$corporation_name);
	    }
	    $this->db->group_by('orn.customer_id');
	    $this->db->group_by('cc.id');
	    
	    if($offset)
	    {
            $this->db->limit($limit,$offset);
        }else if($limit){
            $this->db->limit($limit);
        }
        
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	/**
	 * 我的收益-查询某一个用户给我带来的收益列表。
	 */
	public function Obj_Income_List( $my_customer_id,$customer_id = 0, $limit, $offset, $status = '', $order_sn = '',$start_time = '',$end_time = '' )
	{
	   
	    if( $status == 'total' )
	    {
	        $this->db->select('sum(ord.rebate) as total_rebate');
	        
	    }else{
	        
	       $this->db->select('orn.order_sn,orn.customer_id, ord.rebate,ord.rebaterate,ord.create_date,rr.name');
	    }
	    
	    $this->db->from('order_rebate_new as orn');
	    $this->db->join('order_rebate_detail as ord', 'orn.id = ord.order_rebate_new_id');
	    if( $status != 'total')
	    { 
	        $this->db->join('rebate_role as rr', 'rr.role_id = ord.role_id','left');
	    }
	    $this->db->where('ord.obj_id',$my_customer_id);
	    $this->db->where('orn.customer_id',$customer_id);
	    $this->db->where('orn.status',1);
	    
	    if( $order_sn )
	    {
	       $this->db->where('orn.order_sn',$order_sn);
	    }
	    
	    if( $start_time && $end_time )
	    { 
	        $this->db->where('ord.create_date >=',$start_time.' 00:00:00');
	        $this->db->where('ord.create_date <=',$end_time. '23:59:59');
	    }
	    
	    if($offset)
	    {
	        $this->db->limit($limit,$offset);
	        
	    }else if($limit){
	        
	        $this->db->limit($limit);
	    }
	    
	    $query = $this->db->get();
	    
	    if( $status == 'total')
	    {
	        return $query->row_array();
	    }
	    return $query->result_array();
	    
	}
	
    /**
     * 统计某个订单的各个角色分到多少钱。
     *
     */
	public function Order_Rebate_Role( $order_sn = 0 )
	{ 
	    $this->db->select('rr.name,sum(ord.rebate) as rebate,orn.total_price');
	    $this->db->from('order_rebate_new as orn');
	    $this->db->join('order_rebate_detail as ord','orn.id = ord.order_rebate_new_id');
	    $this->db->join('rebate_role as rr','rr.role_id = ord.role_id');
	    $this->db->where('orn.order_sn',$order_sn);
	    $this->db->where('orn.status',1);
	    $this->db->group_by('ord.role_id');
	    $this->db->group_by('ord.id');
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	/**
	 * 订单号 = 企业&订单信息。
	 */
	public function Order( $order_sn = 0 )
	{ 
	    $this->db->select('cc.corporation_name,o.order_sn,o.place_at,o.total_price');
	    $this->db->from('order as o');
	    $this->db->join('customer_corporation as cc','cc.id = o.corporation_id','left');
	    $this->db->where('o.order_sn',$order_sn);
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	/**
	 * 根据时间点统计用户收益了多少钱。
	 */
	public function My_Sum_Rebate( $customer_id = 0 , $time = array() )
	{ 
	    
	    if( !empty( $time['start_at'] ) && !empty( $time['ent_at'] ) )
        {
            $this->db->where('ord.create_date >=',$time['start_at'] );
            $this->db->where('ord.create_date <=',$time['ent_at'] );
        }
         
        $this->db->select('sum(rebate) as total_rebate');
         
        $this->db->from('order_rebate_new as orn');
        $this->db->join('order_rebate_detail as ord', 'orn.id = ord.order_rebate_new_id');
        $this->db->join('customer as c','c.id = orn.customer_id','left');
        $this->db->where('ord.obj_id',$customer_id);
        $this->db->where('orn.status',1);
        $this->db->order_by('ord.id','desc');
        $query = $this->db->get();
        return $query->row_array();
	}
	
	
}