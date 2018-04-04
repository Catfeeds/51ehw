<?php

/**
 *  发货豆红包接口
 *
 */
class Package extends Account_Controller
{

    function __construct()
    {
        parent::__construct();
       
    }


    // ---------------------------------------------------------------------------------


    /**
     * 提交发送红包
     */
    function send_package()
    {
        $relation_id = $this->input->post('relation_id');
        $customer_id = $this->input->post('customer_id');
        $total_price = $this->input->post('total_price');    
        $package_id = $this->input->post('package_id');
        $app_id = $this->input->post('app_id');
        $error['status'] = false;
        // 查询该用户的支付账号
        $this->load->model("Pay_relation_mdl",'Pay_relation');
        $this->Pay_relation->id = $relation_id;
        $pay_info = $this->Pay_relation->load();

        $time = date('Y-m-d H:i:s');
        if( $pay_info ){
            if(! ($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time) ){
                $pay_info['credit'] = '0.00';
            }
        }

        
        if( $pay_info['credit']+$pay_info['M_credit'] >= $total_price )
        { 
            //开启事务
            $this->db->trans_begin();
            $this->load->model ( 'pay_account_mdl' );
            $row = $this->pay_account_mdl->update_M_creadit($pay_info['id'], $total_price);

            if( $row )
            {
                $pay_account_id = $pay_info['id'];//支付账号ID
                $pay_relation_id = $pay_info['r_id']; //关联表的ID
                $surplus_m = $pay_info['M_credit']; //支付前的货豆余额
                
                
                //上一次货豆交易的日志中的信息
                $this->load->model('customer_currency_log_mdl','customer_currency_log');
                $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
                
                
                //检测货豆是否异常
                if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m){
                    $M_credit_data['status'] = '1';
                }else if(!$last_m_log && $surplus_m =='0'){
                    $M_credit_data['status'] = '1';
                }else{
                    $M_credit_data['status'] = '2';
                }
                 
                //货豆日志
                $M_credit_data['relation_id'] = $pay_relation_id;
                $M_credit_data['id_event'] = '58';
                $M_credit_data['remark'] = '红包支出';
                $M_credit_data['amount'] = $total_price;
                $M_credit_data['order_no'] = $package_id;
                $M_credit_data['type'] = '2';
                $M_credit_data['beginning_balance'] = $surplus_m;
                $M_credit_data['ending_balance'] = $surplus_m-$total_price;
                $M_credit_data['customer_id'] = '-1';
                $M_credit_data['app_id'] = $app_id;
                $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                
                if($M_credit_log)
                { 
                    
                    $error['status'] = 1;
                }
            }else{
                $error['status'] = 2;
            }
        }else{ 
            $error['status'] = 2;
        }
        
        if( $error['status'] == 1)
        { 
            $this->db->trans_commit();
        }else{
            $this->db->trans_rollback();
        }
       
       echo json_encode($error);
}

    //------------------------------------------------------------------------------


/**
 * 点击拆红包，获取红包
 * @param unknown $package_id
 */
    function get_package(){
        
        $relation_id = $this->input->post('relation_id');
        $promoter_customer_id = $this->input->post('promoter_customer_id');
        $total_price = $this->input->post('total_price');
        $package_id = $this->input->post('package_id');
        $app_id = $this->input->post('app_id');
        $error['status'] = false;
        $this->load->model("Pay_relation_mdl",'Pay_relation');
        $this->Pay_relation->id = $relation_id;
        $pay_info = $this->Pay_relation->load();
        
        if(count( $pay_info ) > 0){
            

            //开启事务
            $this->db->trans_begin();
            $process = true; //标示事物
            
            $pay_account_id = $pay_info['id'];//支付账号ID
            $pay_relation_id = $pay_info['r_id']; //关联表的ID
            $surplus_m = $pay_info['M_credit']; //支付前的货豆余额
            
            $this->load->model('pay_account_mdl');
            $row = $this->pay_account_mdl->charge_M_credit($pay_info['id'], $total_price );
            
            if( $row )
            { 
                //上一次货豆交易的日志中的信息
                $this->load->model('customer_currency_log_mdl','customer_currency_log');
                $last_m_log   = $this->customer_currency_log->load_last($pay_relation_id);
                
                
                //检测货豆是否异常
                if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m)
                {
                    $M_credit_data['status'] = '1';
                }else if(!$last_m_log && $surplus_m =='0'){
                    $M_credit_data['status'] = '1';
                }else{
                    $M_credit_data['status'] = '2';
                }
                 
                //货豆日志
                $M_credit_data['relation_id'] = $pay_relation_id;
                $M_credit_data['id_event'] = '59';
                $M_credit_data['remark'] = '红包收入';
                $M_credit_data['amount'] = $total_price;
                $M_credit_data['order_no'] = "";
                $M_credit_data['type'] = '1';
                $M_credit_data['beginning_balance'] = $surplus_m;
                $M_credit_data['ending_balance'] = $surplus_m+$total_price;
                $M_credit_data['customer_id'] = $promoter_customer_id;
                $M_credit_data['order_no'] = $package_id;
                $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                
                
                
                if ($M_credit_log) {
                    $error['status'] = true;
                    $this->db->trans_commit();
                } 
                
            }
        }else{
            return false;
           
        }
        
        if(!empty($process) && empty($error['status']) )
        { 
            $this->db->trans_rollback();
        }
        
        echo json_encode($error);
    }
    
    
    /**
     * 处理退款
     */
    function refund_red_packet()
    { 


        $this->load->model('pay_account_mdl');
        $red_packet_info = $this->input->post('red_packet_info');
        $type = $this->input->post('type');
        // 开启事物
        $this->db->trans_begin();
         
        // 事物执行方法中的MODEL。
        if (count($red_packet_info) > 0) {
             
            foreach ($red_packet_info as $v) {
                 
                // 处理已经付款过的订单
                $customer_pay = $this->pay_account_mdl->load($v['customer_id']); // 获取订单用户的支付账号信息
        
                $up_row = $this->pay_account_mdl->charge_M_credit( $customer_pay['id'], $v['price'] ); // 退款给用户
        
                if( $up_row )
                {
                     
                    $this->load->model('customer_currency_log_mdl','customer_currency_log');
//                     // 上一次平台的货豆交易日志
//                     $to_last_m_log = $this->customer_currency_log->load_last('-1');
        
//                     // 平台支出货豆日志
//                     $M_credit_data['relation_id'] = '-1';
//                     $M_credit_data['id_event'] = '64';
//                     $M_credit_data['remark'] = '平台支出-退款';
//                     $M_credit_data['type'] = '2';
//                     $M_credit_data['amount'] = $v['price'];
//                     $M_credit_data['order_no'] = $v['id'].'_'.$type;
//                     $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
//                     $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] - $v['price'] : - $v['price'];
//                     $M_credit_data['customer_id'] = $v['customer_id'];
//                     $M_credit_data['status'] = '1';
//                     $M_credit_data['app_id'] = 0;
//                     $M_credit_data['created_at'] = date('Y-m-d H:i:s');
        
//                     // 支出方货豆日志
//                     $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                    $to_M_credit_log = true;
                    
                    if ($to_M_credit_log)
                    {
                         
                        // 上一次客户货豆交易的日志中的信息
                        $last_m_log = $this->customer_currency_log->load_last( $customer_pay['r_id'] );
        
                        // 用户接收退款货豆日志
                        $customer_credit_data['relation_id'] = $customer_pay['r_id'];
                        $customer_credit_data['id_event'] = '63';
                        $customer_credit_data['remark'] = '红包退款';
                        $customer_credit_data['type'] = '1';
                        $customer_credit_data['amount'] = $v['price'];
                        $customer_credit_data['order_no'] = $v['id'].'_'.$type;
                        $customer_credit_data['beginning_balance'] = $customer_pay['M_credit'];
                        $customer_credit_data['ending_balance'] = $customer_pay['M_credit'] + $v['price'];
                        $customer_credit_data['customer_id'] = $v['customer_id'];
                        $customer_credit_data['created_at'] = date('Y-m-d H:i:s');
                        $customer_credit_data['app_id'] = 0;
                        $customer_credit_data['status'] = !empty($last_m_log['ending_balance']) && $last_m_log['ending_balance'] == $customer_pay['M_credit'] ? 1 : 2; // 批量插入无法验证是否异常，只能用正常表示
                        $customer_credit_log = $this->customer_currency_log->add_log($customer_credit_data);
        
                    }
                }
                
                if( empty($customer_credit_log) )
                { 
                    $error['status'] = 'fail';
                    $this->db->trans_rollback(); // 事物回滚
                    echo json_encode($error);
                    exit();
                }
        
            }
        
            $error['status'] = 'success';
            $this->db->trans_commit(); // 提交事物
             
        } else {
             
            $error['status'] = 'NO_ORDER';
             
        }
         
        echo json_encode($error);
        
    }
}