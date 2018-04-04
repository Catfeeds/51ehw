<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @author fxm  
 * @定时运行脚本
 */
class Program_script extends Front_Controller {
	


	public function __construct()
	{
	    
		parent::__construct();
		echo "<meta charset='utf-8'>";
	}

	
    /**
	 * 活动时间到期没成团退款 -- 所有
	 */
	function groupbuy_refund()
	{
	 //2017-01-03
	 //(事物处理)
	 //修改->1.已有订单，循环处理出来数组，支付过，但未成团，过期了的数组。
	 //判断有才执行->数组2->where_in 改退款状态 ->构造二维数组退款信息->调用接口。
	 
	   
	    $this->load->model('order_mdl');
	    $this->load->model('groupbuy_mdl');
	    
	    //查询出 付款&&未成团&&已过期 的订单；
	    $order_list = $this->groupbuy_mdl->load_not_group();
	    
	    if( $order_list )
	    {
    	    $refund_status_array = array(); //改状态加退款
    	    $buy_num = array(); //团购ID
    	    
    	    foreach ( $order_list as $val )
    	    { 
    	        //构造UPDATE的ID
    	        $refund_status_array[] = $val['id'];
    	        $buy_num[] = $val['activity_id']; 
    	        
    	        //构造接口需要的数组
    	        $data_post['order_info'][] = $val;
    	        
    	    }

    	    //去重复的拼团ID。
    	    $buy_num =  array_unique($buy_num);
    	    
    	    // 开启事物
    	    $this->db->trans_begin();
    	     
    	    //修改过期订单
    	    $change_row = $this->order_mdl->updates_order_status($refund_status_array,11);
    	    
	        if( $change_row )
	        { 
	            //修改过期订单
	            $buy_num_row = $this->groupbuy_mdl->updates_groupbuy_status($buy_num, 2);
	            
	            //判断修改成功条数 = 构造条数。
	            if( ($buy_num_row == count($buy_num) ) && $change_row == count($refund_status_array) )
	            { 
	                //调用接口
	                
	                $url = $this->url_prefix.'Groupbuy/refund';
	                $error  =  json_decode($this->curl_post_result( $url,$data_post ),true);
	                
	                if( $error['status'] == 'success')
	                {   $this->order_stock( $refund_status_array ); //加库存
	                    $this->db->trans_commit(); // 提交事物
	                    $change_order_num = $change_row;
	                }
	            }
	        }
	        
	        if ( !empty($change_order_num) )
	        {

	            echo '退款订单数量:' . $change_order_num . '<br/>';
	        
	        } else {

	            echo '操作失败, 请重试';
                $this->db->trans_rollback(); // 事物回滚
	        }
	        
	    }else{ 
	        
	        echo '无订单可操作';
	    }
	    
	}
      
	
	/**
	 * 普通商品使用（无SKU）
	 * 根据订单号-查商品-加库存
	 */
	private function order_stock($order_id_array = array() )
	{ 
	    $order_id_array = $order_id_array;
        $this->db->select('oi.product_id as id,sum(oi.quantity) as stock');
        $this->db->from('order_item as oi');
        $this->db->join('order as o','oi.order_id = o.id','left');
        $this->db->where_in('o.id',$order_id_array);
        $this->db->group_by('oi.product_id');
        $query = $this->db->get();
        $result = $query->result_array();
        
        if( $result )
        {
            $this->sql_bath('9thleaf_product',$result,'stock+');
            
        }
	}
	
	/**
	 * 执行超过48小时未付款的订单改为关闭状态
	 * 直接SQL化
	 */
	public function update_overdue_order()
	{
	    $time = date('Y-m-d H:i:s');

	    
        $this->db->select('oi.order_id,oi.product_id,oi.quantity as stock, oi.sku_id');
        $this->db->from('order_item as oi');
        $this->db->join('order as o','o.id = oi.order_id','left');
        $this->db->where("'$time' >", 'date_add(place_at, INTERVAL 2 day)',false);
        $this->db->where('status',2);
        $query = $this->db->get();
        $result = $query->result_array();
        
        if( $result )
        { 
            $sku_stock = array();
            $product_stock = array();
            $order_array_id = array();
            
            foreach ( $result as $k=> $v)
            { 
                if( $v['sku_id'])
                { 
                    array_push($sku_stock,$v); 
                    
                }
                    
                array_push($product_stock,$v);
                
                
                array_push($order_array_id,$v['order_id']);
            }
        
            $order_array_id = array_values(array_unique($order_array_id) );
            
            //改状态
            $this->db->set('status',10);
            $this->db->where_in('id',$order_array_id);
            $this->db->update('order');
            $row = $this->db->affected_rows();
            
            if( $product_stock )
            { 
                $product = array();
                
                //将重复的商品数量相加去除重复。
                foreach ($product_stock as $k => $v)
                { 
                    if (!isset($product[$v['product_id']]) )
                    { 
                        $product[$v['product_id']]['id'] = $v['product_id'];
                        $product[$v['product_id']]['stock'] = $v['stock'];
                    }
                    else{ 
                        $product[$v['product_id']]['stock'] = $product[$v['product_id']]['stock'] + $v['stock'];
                    }
                }
                
                $product =  array_values($product);
                //得出去除重复商品，数量相加结果。
                
                
                //批量修改普通商品库存 - sql	      
                $this->sql_bath('9thleaf_product',$product,'stock+');
            }
            
            if( $sku_stock )
            { 
                $sku = array();
                //将重复的商品数量相加去除重复。
                foreach ($sku_stock as $k => $v)
                {
                    if (!isset($sku[$v['sku_id']]) )
                    {
                        $sku[$v['sku_id']]['id'] = $v['sku_id'];
                        $sku[$v['sku_id']]['stock'] = $v['stock'];
                    }
                    else{
                        $sku[$v['sku_id']]['stock'] = $sku[$v['sku_id']]['stock'] + $v['stock'];
                    }
                }
                 
                //批量修改SKU商品库存
                $this->sql_bath('9thleaf_product_sku_value',$sku,'stock+');
            }
	    
        }
        
        echo '操作订单条数：'.(!empty($row) ? $row : 0);
	}
	
	//批量UPDATE库存语句
	private function sql_bath($table,$data=array(), $algorithm){
	    
	    $update_sql = "UPDATE $table SET stock = CASE id  ";
	    $id = '';
	    foreach ($data as $k => $v)
	    {
	        $update_sql .= " WHEN ".$v['id']." THEN  $algorithm ".$v['stock'] ;
	        $id .= $v['id'].',';
	    }
	    $id = trim($id,',');
	    $update_sql .="  END WHERE id IN($id)";
	    $this->db->query($update_sql);
	    return $this->db->affected_rows();
	    //批量修改普通商品库存 - sql
	    
	}
	
	/**
	 * 红包超过24小时退款
	 */
	public function red_packet_refund()
	{ 
        $this->load->model('Package_mdl');
	    $red_packet_list = $this->Package_mdl->overdue_redpacket();
// 	    echo $this->db->last_query();exit;
	    
	    if( $red_packet_list )
	    { 
	        $num = 0;
	        $data_post['red_packet_info'] = $red_packet_list;
	        $data_post['type'] = 'C';
	        //修改customer_id = -1  系统接收。
	        foreach ($red_packet_list as $v)
	        { 
	            $r_id_array[] = $v['id'];
	            $num += $v['num'];
	        }
	        
	        
	        // 开启事物
	        $this->db->trans_begin();
	        
	        //修改customer_id = -1;
	        $row = $this->Package_mdl->updates_customer( $r_id_array );
	       
	        if( $row == $num ) //判断查出来的未领取的红包数量和更新的数量是否一致。
	        {
	            //调用接口
	            $url = $this->url_prefix.'Package/refund_red_packet';
	            $error  =  json_decode($this->curl_post_result( $url,$data_post ),true);
	            
	            if( $error['status'] == 'success')
	            {   
	                $this->db->trans_commit(); // 提交事物
    	            $change_order_num = $row;
	            }
	        }
	        
	        
	        if ( !empty($change_order_num) )
	        {
	        
	            echo '退款红包数量:' . $change_order_num . '<br/>';
	             
	        } else {
	        
	            echo '操作失败, 请重试';
	            $this->db->trans_rollback(); // 事物回滚
	        }
	        
	    }else{ 
	        echo '无红包退款';
	    }
	   
	}

}
