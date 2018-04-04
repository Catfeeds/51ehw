<?php

/**
 * 简易店-两小时未支付的订单取消，回填库存。
 * @date:2018年4月3日 下午2:41:36
 * @author: fxm
 * @param: variable
 * @return: 
 */

function AutoOrderCancel( $customer_id = 0 )
{ 
    $CI = & get_instance();
   
    $return['message'] = '';
    
    do { 
        
        //开启事物。
        $CI->db->trans_begin();
        
        //----查询订单-----
        $where = [
            'status'=> 1,
            'created_at < '=> date("Y-m-d H:i:s",time()-7200)//两个小时前的时间。
        ];
        if( $customer_id )
            $where['customer_id'] = $customer_id;
        
        $order_list = $CI->db->get_where('easy_order',$where )->result_array();
        
        if( !$order_list )
        { 
            //无处理订单
            $return['status'] = 255;
            $return['message'] = '无处理订单';
            break;
        }
        
        //----批量更新状态-----
        $CI->db->set('status',6);
        $CI->db->where_in('id',array_column($order_list, 'id'));
        $CI->db->update('easy_order');
        if( $CI->db->affected_rows() != count( $order_list) )
        { 
            error_log('订单状态更新失败，无法取消订单');
            //更新失败，回滚
            break;
        }
        
        foreach ($order_list as $k => $v)
        {
            $insert_log[$k]['order_id'] = $v['id'];
            $insert_log[$k]['status'] = 6;
            $insert_log[$k]['remark'] = '超时未支付';
            
            //拼接更新库存，商品ID相同则相加。
            isset( $product_stock[$v['product_id']] ) ? $product_stock[$v['product_id']]['quantity'] += $v['quantity'] : $product_stock[$v['product_id']]['quantity'] = $v['quantity'];
        } 
        
        //----新增操作订单日志-----
        $CI->db->insert_batch('easy_order_log', $insert_log);
        
        if( $CI->db->affected_rows() != count( $order_list ) )
        { 
            //添加失败，回滚
            error_log('操作日志添加失败，无法取消订单');
            break;
        }
        
        
        //----批量更新库存-----
        $update_sql = "UPDATE 9thleaf_easy_product SET stock = CASE id  ";
        $id = '';
        foreach ($product_stock as $k => $v)
        {
            $update_sql .= " WHEN ".$k." THEN  stock+ ".$v['quantity'] ;
            $id .= $k.',';
        }
        
        $id = trim($id,',');
        $update_sql .="  END WHERE id IN($id)";
        $CI->db->query($update_sql);
        
        if( $CI->db->affected_rows() != count( $product_stock ) )
        {
            //库存更新失败
            error_log('库存更新失败，无法取消订单');
            break;
        }
        
        $return['status'] = 1;
        $CI->db->trans_commit();
        return $return;
        
    }while (0);
    
    $CI->db->trans_rollback();
    
    return $return;
}


/**
 * 超过十天未收货的订单执行收货流程
 * @date:2018年4月3日 下午5:51:13
 * @author: fxm
 * @param: variable
 * @return: 
 */

function AutoOrderReceipts()
{ 
    
}
