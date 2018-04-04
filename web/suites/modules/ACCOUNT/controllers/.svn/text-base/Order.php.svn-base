<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

    // ------------------------------------------------------------------------

/**
 * 接口订单类
 *
 */
class Order extends Account_Controller
{

    public function __construct()
    {
        parent::__construct();
        
    }
    
    /**
     * 普通订单的支付---货豆&日志处理
     */
    public function pay_order(){
        
        //--接收数据
        $relation_id = $this->input->post('relation_id');
        $pay_passwd = md5( $this->input->post('pass') );
        $corp_customer_id = $this->input->post('corp_customer_id');//收款方的用户ID
        $total_price = $this->input->post('total_price');
        $order_sn = $this->input->post('order_sn');
        $app_id = $this->input->post('app_id');
        $commission = $this->input->post('commission');
        
        $error['status'] = false;
        $this->load->model ( 'Pay_relation_mdl','Pay_relation' );
        $this->Pay_relation->id = $relation_id;
        $pay_detailed = $this->Pay_relation->load();
        
        if($pay_detailed['pay_passwd'] == $pay_passwd )
        { 

            $customer_id = $pay_detailed['customer_id'];//支付账号的用户ID
            $pay_account_id = $pay_detailed['id'];//支付账号ID
            $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
            $surplus_m = $pay_detailed['M_credit']; //支付前的货豆余额
            $credit = '0.00'; //授信
            $time = date('Y-m-d H:i:s');
            
            if($pay_detailed['credit_start_time'] <= $time && $pay_detailed['credit_end_time'] >= $time)
                $credit = $pay_detailed['credit'];
            
            
            //判断余额
            if( ($pay_detailed["M_credit"]+$credit) >=  $total_price )
	        {
	            if( !empty( $commission ) )
	            { 
	                if($pay_detailed['cash'] < $commission)
	                { 
	                    $error['status'] = 5;//手续费不够
	                    echo json_encode($error);
	                    exit();
	                } 
	            }

	            $this->db->trans_begin(); //事物执行方法中的MODEL。
	            $process = true; //表示进了事物。
	            //扣用户货豆
	            $this->load->model ( 'pay_account_mdl' );
	            $row = $this->pay_account_mdl->update_M_creadit($pay_account_id, $total_price);
	             
	            if($row)
	            { 
	                
	                //上一次用户货豆交易的日志中的信息
	                $this->load->model("customer_currency_log_mdl",'customer_currency_log');
	                
	                $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
	                //检测货豆是否异常
	                if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m)
	                {
	                    $M_credit_expend_data['status'] = '1';
	                }else if(!$last_m_log && $surplus_m =='0'){
	                    $M_credit_expend_data['status'] = '1';
	                }else{
	                    $M_credit_expend_data['status'] = '2';
	                }
	                
	                //货豆日志
	                $M_credit_expend_data['relation_id'] = $pay_relation_id;
	                $M_credit_expend_data['id_event'] = '60';
	                $M_credit_expend_data['remark'] = '购物支出';
	                $M_credit_expend_data['amount'] = $total_price;
	                $M_credit_expend_data['order_no'] = $order_sn;
	                $M_credit_expend_data['type'] = '2';
	                $M_credit_expend_data['beginning_balance'] = $surplus_m;
	                $M_credit_expend_data['ending_balance'] = $surplus_m - $total_price;
	                $M_credit_expend_data['customer_id'] = $corp_customer_id;
	                $M_credit_expend_data['app_id'] = $app_id;
	                $M_credit_log = $this->customer_currency_log->add_log($M_credit_expend_data);
	                
	                if( $M_credit_log )
	                { 
	                    
	                    //上一次平台的货豆交易日志
	                    $to_last_m_log    = $this->customer_currency_log->load_last('-1');
	                     
	                    //支出方货豆日志
	                    $M_credit_data['remark'] = '平台收入';
	                    $M_credit_data['relation_id'] = '-1';
	                    $M_credit_data['type'] = '1';
	                    $M_credit_data['status'] = '1';
	                    $M_credit_data['id_event'] = '60';
	                    $M_credit_data['order_no'] = $order_sn;
	                    $M_credit_data['amount'] = $total_price;
	                    $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
	                    $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance']+$total_price:$total_price ;
	                    $M_credit_data['customer_id'] = $customer_id;
	                    $M_credit_data['app_id'] = $app_id;
	                    //收入方货豆日志
	                    $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
	                     
	                    if($to_M_credit_log)
	                    { 
	                        
	                        $commission_row = true;
	                        
	                        if( $commission >= 0.01) //如果有手续费
	                        { 
	                            $commission_row = false;
	                            
	                            //处理手续费的方法
	                            $commission_row = $this->order_commission($pay_detailed, $order_sn ,$app_id,$commission);
	                            
	                        }
	                        
	                        if( $commission_row ){
	                            
    	                        $this->db->trans_commit();
    	                        $error['status'] = 1;//支付成功
    	                        $is_ok = true;
                                //$this->customer_currency_log->openid = $this->session->userdata('openid');
    	                        //$this->customer_currency_log->result_message( $M_credit_expend_data ); //货豆支出-微信推送
	                        }
	                    }
	                }
	            }
	            
	        }else{ 
	            //余额不足
	            $error['status'] = 4;
	        }
	        
        }else{ 
            //密码错误
            $error['status'] = 3;
            
        }
        
        if( empty($is_ok)  && !empty($process) )
            $this->db->trans_rollback();
        
        echo json_encode($error);
    }
    
    
    /**
     * B端手续费新流程
     * @array $pay_detailed = 支付账户信息
     * $order_sn = 订单ID
     * $pay_account_id = 支付ID
     * $app_id = 地区ID
     * $commission = 手续费金额
     */
    private function order_commission( $pay_detailed, $order_sn, $app_id, $commission )
    { 
        $cash = $pay_detailed['cash'];
        $relation_id = $pay_detailed['r_id'];
        
        $update_cash = $this->pay_account_mdl->update_cash($pay_detailed['id'], $commission);
    
        if($update_cash)
        {
            $this->load->model('customer_money_log_mdl','customer_money_log');
            //上一次现金交易的日志中的信息
            $last_cash_log = $this->customer_money_log->load_create_desc($relation_id);//现金日志
    
            //检测现金是否异常
            if( isset($last_cash_log['ending_balance']) &&  $last_cash_log['ending_balance'] == $cash){
                $cash_data['status'] = '1';
            }else if(!$last_cash_log && $cash =='0'){
                $cash_data['status'] = '1';
            }else{
                $cash_data['status'] = '2';
            }
            //现金支出日志
            $cash_data['relation_id'] = $relation_id;
            $cash_data['id_event'] = '76';
            $cash_data['type'] = '2';
            $cash_data['remark'] = '手续费扣款';
            $cash_data['cash'] = $commission;
            $cash_data['charge_no'] = $order_sn;
            $cash_data['beginning_balance'] = $cash;
            $cash_data['ending_balance'] = $cash-$commission;
            $cash_data['customer_id'] = '-1';
            $cash_data['app_id'] = $app_id;
            //写入现金日志
            $cash_log = $this->customer_money_log->add_log($cash_data);
    
            if($cash_log)
            {
                //上一次平台现金交易的日志中的信息
                $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
                //平台现金收入日志
                $cash_data['relation_id'] = '-1';
                $cash_data['type'] = '1';
                $cash_data['status'] = '1';
                $cash_data['remark'] = '平台收入-手续费扣款';
                $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
                $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance']+$commission : $commission;
                $cash_data['customer_id'] = $pay_detailed['customer_id'];
                //写入现金日志
                $to_cash_log = $this->customer_money_log->add_log($cash_data);
    
                if( $to_cash_log )
                {
                    return true;
                }
            }
        }
       
        return false;
    }
    
    /**
     * 订单收货---货豆&日志处理
     */
    public function order_receive(){ 
        
        $corp_customer_id = $this->input->post('corp_customer_id');
        $relation_id = $this->input->post('relation_id');
        $pass = $this->input->post('password');
        $total_price = $this->input->post('total_price');
        $order_sn = $this->input->post('order_sn');
        $app_id = $this->input->post('app_id');
        $C_commission = $this->input->post('C_commission'); //C端的手续费
        
        //支付账号
        $this->load->model ( 'Pay_relation_mdl','Pay_relation' );
        $this->load->model ( 'pay_account_mdl' );
        $this->Pay_relation->id = $relation_id;
        $customer_pay = $this->Pay_relation->load();
        
        //店主的支付账号
        $corp_customer_pay = $this->pay_account_mdl->load( $corp_customer_id );
        
        //店主支付账号ID
        $corp_pay_id = $corp_customer_pay['id'];
        
        //店主关联支付账号表的ID
        $pay_relation_id = $corp_customer_pay['r_id'];
        
        //收货前店主剩余的货豆
        $corp_surplus_m = $corp_customer_pay['M_credit'];
        
        if( $customer_pay['pay_passwd'] == $pass ){   
            //开启事物
	        $this->db->trans_begin(); //事物执行方法中的MODEL。
	        $error['status']  = false;
	        
	        $this->load->model('customer_currency_log_mdl','customer_currency_log');
	        //上一次店主货豆交易的日志中的信息
	        $last_m_log = $this->customer_currency_log->load_last($pay_relation_id);
	        
	        //C端才有的手续费店主扣除
	        if( !empty($C_commission ) && $C_commission > 0)
	        {
	            $total_price = $total_price;
	            
	        }else{ 
	            
	            $C_commission = 0;
	        }
	        //店主账号+货豆
	        $up_row = $this->pay_account_mdl->charge_M_credit($corp_pay_id, $total_price-$C_commission );
	        
	        if( $up_row )
	        {
	            //上一次平台的货豆交易日志
	            $to_last_m_log    = $this->customer_currency_log->load_last('-1');
	             
	            //平台支出货豆日志
	            $M_credit_data['relation_id'] = '-1';
	            $M_credit_data['id_event'] = '62';
	            $M_credit_data['remark'] = '平台支出';
	            $M_credit_data['type'] = '2';
	            $M_credit_data['amount'] = $total_price;
	            $M_credit_data['order_no'] = $order_sn;
	            $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';;
	            $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] - $total_price: - $total_price ;
	            $platform_M = $M_credit_data['ending_balance']; //下面覆盖了-所有在这里赋值。
	            $M_credit_data['customer_id'] = $corp_customer_id;
	            $M_credit_data['status'] = '1';
	            $M_credit_data['app_id'] = $app_id;
	            //支出方货豆日志
	            $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
	            
	            if( $to_M_credit_log )
	            { 
	                //收入检测货豆是否异常
	                if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $corp_surplus_m)
	                {
	                    $M_credit_data['status'] = '1';
	                }else if(!$last_m_log && $corp_surplus_m =='0'){
	                    $M_credit_data['status'] = '1';
	                }else{
	                    $M_credit_data['status'] = '2';
	                }
	                 
	                //店主收入货豆日志
	                $M_credit_data['relation_id'] = $pay_relation_id;
	                $M_credit_data['id_event'] = '62';
	                $M_credit_data['remark'] = '销售收入';
	                $M_credit_data['type'] = '1';
	                $M_credit_data['amount'] = $total_price;
	                $M_credit_data['order_no'] = $order_sn;
	                $M_credit_data['beginning_balance'] = $corp_surplus_m;
	                $M_credit_data['ending_balance'] = $corp_surplus_m+$total_price;
	                $M_credit_data['customer_id'] = $customer_pay['customer_id'];
	                $M_credit_data['app_id'] = $app_id;
	                
	                //写入货豆日志
	                $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
	                
	                if( $M_credit_log )
	                {
	                    
	                    $C_commission_row = true;
	                    
	                    //C端才有的手续费店主扣除--写日志
	                    if( !empty($C_commission ) && $C_commission > 0)
	                    {
	                       $corp_M =  $M_credit_data['ending_balance'];
	                       
	                       $C_commission_row = $this->C_order_commission( $pay_relation_id, $order_sn, $app_id, $C_commission, $corp_M, $platform_M,$corp_customer_id);
    
	                    }
	                    
	                    if( $C_commission_row )
	                    {
    	                    $this->db->trans_commit(); //提交事物
    	                    $error['status'] = true;
	                    }
	                }
	            }
	        }
	        
	    }else{ 
	        $error['status'] = false;
	        echo json_encode($error);
	        return;
	    }
	    
	    if( empty($error['status'] ) ){
	        $this->db->trans_rollback(); //事物回滚
	    }
	    
	    echo json_encode($error);
    }
    
    /**
     * 用户收货-订单分成-接口处理部分逻辑 B端使用接口
     */
    public function order_rebate() 
    {
        $app_id = $this->input->post('app_id');
        $retio_price = $this->input->post('retio_price');//分成出去的现金
        $order_sn = $this->input->post('order_sn');//订单号
        $customer_id = $this->input->post('customer_id'); //收货人的ID
        $corp_customer_id = $this->input->post('corp_customer_id');
        
        //店主的支付账户信息
        $this->load->model('pay_account_mdl');
        $pay_info = $this->pay_account_mdl->load( $corp_customer_id );
        $cash = $pay_info['cash'];
        $relation_id = $pay_info['r_id'];
        
        if($cash >= $retio_price){
            //扣店主分成现金的金额
            $this->db->trans_begin(); //事物；
            $error['status']  = false;
            $this->load->model('pay_account_mdl');
            $update_cash = $this->pay_account_mdl->update_cash($pay_info['id'], $retio_price);
            
            if($update_cash)
            { 
                $this->load->model('customer_money_log_mdl','customer_money_log');
                //上一次现金交易的日志中的信息
                $last_cash_log = $this->customer_money_log->load_create_desc($relation_id);//现金日志
                
                //检测现金是否异常
                if( isset($last_cash_log['ending_balance']) &&  $last_cash_log['ending_balance'] == $cash){
                    $cash_data['status'] = '1';
                }else if(!$last_cash_log && $cash =='0'){
                    $cash_data['status'] = '1';
                }else{
                    $cash_data['status'] = '2';
                }
                //现金支出日志
                $cash_data['relation_id'] = $relation_id;
                $cash_data['id_event'] = '76';
                $cash_data['type'] = '2';
                $cash_data['remark'] = '手续费扣款';
                $cash_data['cash'] = $retio_price;
                $cash_data['charge_no'] = $order_sn;
                $cash_data['beginning_balance'] = $cash;
                $cash_data['ending_balance'] = $cash-$retio_price;
                $cash_data['customer_id'] = '-1';
                $cash_data['app_id'] = $app_id;
                //写入现金日志
                $cash_log = $this->customer_money_log->add_log($cash_data);
                
                if($cash_log)
                { 
                    //上一次平台现金交易的日志中的信息
                    $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
                    //平台现金收入日志
                    $cash_data['relation_id'] = '-1';
                    $cash_data['type'] = '1';
                    $cash_data['status'] = '1';
                    $cash_data['remark'] = '平台收入-手续费扣款';
                    $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
                    $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance']+$retio_price:$retio_price;
                    $cash_data['customer_id'] = $corp_customer_id;
                    //写入现金日志
                    $to_cash_log = $this->customer_money_log->add_log($cash_data);
                    
                    if( $to_cash_log )
                    {
                        $this->db->trans_commit(); //处理成功
                        $error['status']  = true;
                    }
                }
            }
        }else{ 
            $error['status'] = false;
	        echo json_encode($error);
	        return;
        }
        
       if( empty($error['status']) )
           $this->db->trans_rollback(); //事物回滚
       
       echo json_encode($error);
    }
    
    /**
     * 订单处理-
     * 店主手动提取货豆扣除现金手续费-部分逻辑接口
     */
    public function carry_rebate(){
        
        $total_price = $this->input->post('total_price');
        $relation_id = $this->input->post('relation_id');
        $order_sn = $this->input->post('order_sn');
        $customer_id = $this->input->post('customer_id');
        $buy_customer_id = $this->input->post('buy_customer_id');
        $pass = $this->input->post('password');
        $app_id = $this->input->post('app_id');
        
        $this->load->model('pay_account_mdl');
        $this->load->model("Pay_relation_mdl", "Pay_relation");
        $this->Pay_relation->id = $relation_id;
        $pay_info = $this->Pay_relation->load();
        $this->db->trans_begin(); //事物；
        $error['status'] = false;
        if( $pay_info['pay_passwd'] == md5($pass) ) {
            //店主账号+货豆
            $up_row = $this->pay_account_mdl->charge_M_credit($pay_info['id'], $total_price );
            
            if( $up_row ){ 
                $this->load->model("customer_currency_log_mdl",'customer_currency_log');
                //上一次平台的货豆交易日志
                $to_last_m_log    = $this->customer_currency_log->load_last('-1');
                 
                //平台支出货豆日志
                $M_credit_data['relation_id'] = '-1';
                $M_credit_data['id_event'] = '62';
                $M_credit_data['remark'] = '平台支出';
                $M_credit_data['type'] = '2';
                $M_credit_data['amount'] = $total_price;
                $M_credit_data['order_no'] = $order_sn;
                $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';;
                $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance']-$total_price: -$total_price ;
                $M_credit_data['customer_id'] = $customer_id;
                $M_credit_data['status'] = '1';
                $M_credit_data['app_id'] = $app_id;
                //支出方货豆日志
                $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                
                if( $to_M_credit_log )
                { 
                    //上一次店主货豆交易的日志中的信息
                    $last_m_log = $this->customer_currency_log->load_last( $relation_id );
                    //收入检测货豆是否异常
                    if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $pay_info['M_credit'])
                    {
                        $M_credit_data['status'] = '1';
                    }else if(!$last_m_log && $customer_pay['M_credit'] =='0')
                    {
                        $M_credit_data['status'] = '1';
                    }else{
                        $M_credit_data['status'] = '2';
                    }
                     
                    //店主收入货豆日志
                    $M_credit_data['relation_id'] = $relation_id;
                    $M_credit_data['id_event'] = '62';
                    $M_credit_data['remark'] = '销售收入';
                    $M_credit_data['type'] = '1';
                    $M_credit_data['amount'] = $total_price;
                    $M_credit_data['order_no'] = $order_sn;
                    $M_credit_data['beginning_balance'] = $pay_info['M_credit'];
                    $M_credit_data['ending_balance'] = $pay_info['M_credit']+$total_price;
                    $M_credit_data['customer_id'] = $buy_customer_id;
                    
                    
                    //写入货豆日志
                    $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                    
                    if( $M_credit_log ){ 
                        $this->db->trans_commit(); //提交事物
                        $error['status'] = true;
                    }
                }
            } 
        }
        
        if( empty($error['status']) )
            $this->db->trans_rollback(); //事物回滚
        
        echo json_encode($error);
    }
    
    
    /**
     * 订单处理-
     * 拼团的日志-扣钱。
     */
    public function groupbuy_save_order(){ 
        
        //接收数据
        $error['status'] = false;//事物表示
        $total_groupbuy_price = $this->input->post('total_groupbuy_price');
        $corp_customer_id = $this->input->post('corp_customer_id');
        $customer_id = $this->input->post('customer_id');
        $relation_id = $this->input->post('relation_id');
        $order_sn = $this->input->post('order_sn');
        $app_id = $this->input->post('app_id');
        
        //处理数据
        $this->load->model("Pay_relation_mdl", "Pay_relation");
        $this->load->model("pay_account_mdl");
        $this->Pay_relation->id = $relation_id;
        $pay_info = $this->Pay_relation->load();
        // 扣货豆
        $this->db->trans_begin(); //事物；
        
        $row = $this->pay_account_mdl->update_M_creadit($pay_info['id'], $total_groupbuy_price);
        
        if( $row ){
        
            // 上一次货豆交易的日志中的信息
            $this->load->model('customer_currency_log_mdl');
            $last_m_log = $this->customer_currency_log_mdl->load_last( $relation_id );
            
            // 检测货豆是否异常
            if (isset($last_m_log['ending_balance']) && $last_m_log['ending_balance'] == $pay_info['M_credit'])
            {
                $M_credit_expend_data['status'] = '1';
            } else if (! $last_m_log && $pay_info['M_credit'] == '0') {
                $M_credit_expend_data['status'] = '1';
            } else {
                $M_credit_expend_data['status'] = '2';
            }
        
            // 货豆日志
            $M_credit_expend_data['relation_id'] = $pay_info['r_id'];
            $M_credit_expend_data['id_event'] = '60';
            $M_credit_expend_data['remark'] = '购物支出';
            $M_credit_expend_data['amount'] = $total_groupbuy_price;
            $M_credit_expend_data['order_no'] = $order_sn;
            $M_credit_expend_data['type'] = '2';
            $M_credit_expend_data['beginning_balance'] = $pay_info['M_credit'];
            $M_credit_expend_data['ending_balance'] = $pay_info['M_credit'] - $total_groupbuy_price;
            $M_credit_expend_data['customer_id'] = $corp_customer_id;
            $M_credit_expend_data['app_id'] = $app_id;
            $M_credit_log = $this->customer_currency_log_mdl->add_log($M_credit_expend_data);
        
            // 上一次平台的货豆交易日志
            $to_last_m_log = $this->customer_currency_log_mdl->load_last('-1');
            
            if( $to_last_m_log ){ 
                // 收入方货豆日志
                $M_credit_data['remark'] = '平台收入';
                $M_credit_data['relation_id'] = '-1';
                $M_credit_data['type'] = '1';
                $M_credit_data['status'] = '1';
                $M_credit_data['id_event'] = '60';
                $M_credit_data['amount'] = $total_groupbuy_price;
                $M_credit_data['order_no'] = $order_sn;
                $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
                $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] + $total_groupbuy_price : $total_groupbuy_price;
                $M_credit_data['customer_id'] = $customer_id;
                $M_credit_data['app_id'] = $app_id;
                // 收入方货豆日志
                $to_M_credit_log = $this->customer_currency_log_mdl->add_log($M_credit_data);
                

                if ( $to_M_credit_log ) {
                    $this->db->trans_commit(); // 事务结束-----------------------------------------------------
                    $error['status'] = true;
                
                    //$this->customer_currency_log_mdl->openid = $this->session->userdata('openid');
                    //$this->customer_currency_log_mdl->result_message( $M_credit_expend_data ); //消费-微信推送
                    // 发送短信
                }
            }
            
        }
        if( empty($error['status']) )
            $this->db->trans_rollback(); //事物回滚
        
        echo json_encode($error);
        
    }
    
    /**
     * 订单处理-面对面支付逻辑
     */
    public function code_order()
    { 
        
         //--接收数据
        $relation_id = $this->input->post('relation_id');
//         $pay_passwd = md5( $this->input->post('pass') );
        $corp_customer_id = $this->input->post('corp_customer_id');//收款方的用户ID
        $total_price = $this->input->post('total_price');
        $order_sn = $this->input->post('order_sn');
        $app_id = $this->input->post('app_id');
        $commission = $this->input->post('commission');
        $C_commission = $this->input->post('C_commission');
        $status = false;
        
        //读取支付账户信息
        $this->load->model ( 'Pay_relation_mdl','Pay_relation' );
        $this->Pay_relation->id = $relation_id;
        $pay_detailed = $this->Pay_relation->load();
        
        

        $customer_id = $pay_detailed['customer_id'];//支付账号的用户ID
        $pay_account_id = $pay_detailed['id'];//支付账号ID
        $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
        $surplus_m = $pay_detailed['M_credit']; //支付前的货豆余额
        $credit = '0.00'; //授信
        $time = date('Y-m-d H:i:s');
        
        if($pay_detailed['credit_start_time'] <= $time && $pay_detailed['credit_end_time'] >= $time)
            $credit = $pay_detailed['credit'];
        
        
        //判断余额
        if( ($pay_detailed["M_credit"]+$credit) >=  $total_price )
        {
        
            if( !empty( $commission ) )
            {
                if($pay_detailed['cash'] < $commission)
                {
                    $error['status'] = 4;//手续费不够
                    echo json_encode($error);
                    exit();
                }
            }
            
            $this->db->trans_begin(); //事物执行方法中的MODEL。
            $process = true; //表示进了事物处理
            //扣用户货豆
            $this->load->model ( 'pay_account_mdl' );
            $row = $this->pay_account_mdl->update_M_creadit($pay_account_id, $total_price);
            
            if($row)
            {
                $this->load->model("customer_currency_log_mdl",'customer_currency_log');
                
                //上一次货豆交易的日志中的信息
                $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
                
                //检测支付方货豆是否异常
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
                $M_credit_data['id_event'] = '60';
                $M_credit_data['remark'] = '面对面-购物支出';
                $M_credit_data['amount'] = $total_price;
                $M_credit_data['order_no'] = $order_sn;
                $M_credit_data['type'] = '2';
                $M_credit_data['beginning_balance'] = $surplus_m;
                $M_credit_data['ending_balance'] = $surplus_m-$total_price;
                $M_credit_data['customer_id'] = $corp_customer_id;
                $M_credit_data['app_id'] = $app_id;
                $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                
                if( $M_credit_log )
                { 
                    //读取收款账户信息
                    $corp_customer_id = $this->input->post('corp_customer_id');
                    $pay_info = $this->pay_account_mdl->load( $corp_customer_id );
                    
                    //上一次店主货豆交易的日志中的信息
                    $corp_last_m_log = $this->customer_currency_log->load_last($pay_info['r_id']);
                    
                    //收入检测货豆是否异常
                    if( isset($corp_last_m_log['ending_balance']) &&  $corp_last_m_log['ending_balance'] == $pay_info['M_credit'])
                    {
                        $M_corp_credit_data['status'] = '1';
                    }else if(!$corp_last_m_log && $pay_info['M_credit'] =='0'){
                        $M_corp_credit_data['status'] = '1';
                    }else{
                        $M_corp_credit_data['status'] = '2';
                    }
                     
                    //店主收入货豆日志
                    $M_corp_credit_data['relation_id'] = $pay_info['r_id'];
                    $M_corp_credit_data['id_event'] = '62';
                    $M_corp_credit_data['remark'] = '面对面-销售收入';
                    $M_corp_credit_data['type'] = '1';
                    $M_corp_credit_data['amount'] = $total_price;
                    $M_corp_credit_data['order_no'] = $order_sn;
                    $M_corp_credit_data['beginning_balance'] = $pay_info['M_credit'];
                    $M_corp_credit_data['ending_balance'] = $pay_info['M_credit']+$total_price;
                    $M_corp_credit_data['customer_id'] = $customer_id;
                    $M_corp_credit_data['app_id'] = $app_id;
                    //收入出方货豆日志
                    $to_M_credit_log = $this->customer_currency_log->add_log($M_corp_credit_data);
                    
                    if( $to_M_credit_log )
                    { 
                        
                        //--B端手续费-扣款方式不一样。
                        $commission_row = true;
                         
                        if( $commission >= 0.01) //如果有手续费 -- B端才进去。
                        {
                            $commission_row = false;
                             
                            //处理手续费的方法
                            $commission_row = $this->order_commission($pay_detailed, $order_sn ,$app_id, $commission );
                             
                        }
                         
                        //--C端手续费-扣款方式不一样。
                        $C_commission_row = true;
                        
                        if( !empty($C_commission ) && $C_commission > 0 )
                        { 
                            //上一次货豆交易的日志中的信息(平台)
                            $platform_M_last_log = $this->customer_currency_log->load_last('-1');
                            $platform_M  = !empty( $platform_M_last_log ) ? $platform_M_last_log['ending_balance'] : 0;
                            
                            //处理手续费的方法
                            $corp_M =  $M_corp_credit_data['ending_balance'];
	                        
	                        $C_commission_row = $this->C_order_commission( $pay_info['r_id'], $order_sn, $app_id, $C_commission, $corp_M, $platform_M,$corp_customer_id);
    
	                        $total_price = $total_price-$C_commission; //扣除手续费实际收入
                        }
                        
                        if( $commission_row && $C_commission_row){

                           //店主账号+货豆
                           $up_row = $this->pay_account_mdl->charge_M_credit($pay_info['id'], $total_price );

                           if( $up_row )
                           {
                               $this->db->trans_commit();
                               $status = 1;//支付成功
                               $is_ok = true;
                                //$this->customer_currency_log->openid = $this->session->userdata('openid');
                                //$this->customer_currency_log->result_message( $M_credit_expend_data ); //货豆支出-微信推送
                           }
                        }
                        
                    }
                }
            }
             
        }else{
            //余额不足
            $status = 4;
        }

        if( empty($is_ok) && !empty($process) )
            $this->db->trans_rollback();
        
        echo $status;
       
    }
    
    public function All_order_pay()
    {
        
        //二维数组
        $order_info = $this->input->post('order_info');
        
        $relation_id = $this->input->post('relation_id');
        $total_price = $this->input->post('total_price');
        $pay_passwd  = $this->input->post('pass');
        
        if( $relation_id )
        { 
            $this->load->model ( 'Pay_relation_mdl','Pay_relation' );
            $this->Pay_relation->id = $relation_id;
            $pay_detailed = $this->Pay_relation->load();
            
            
            if($pay_detailed['pay_passwd'] == md5($pay_passwd) )
            {
            
                $customer_id = $pay_detailed['customer_id'];//支付账号的用户ID
                $pay_account_id = $pay_detailed['id'];//支付账号ID
                $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
                $surplus_m = $pay_detailed['M_credit']; //支付前的货豆余额
                $credit = '0.00'; //授信
                $time = date('Y-m-d H:i:s');
            
                if($pay_detailed['credit_start_time'] <= $time && $pay_detailed['credit_end_time'] >= $time)
                    $credit = $pay_detailed['credit'];
            
            
                //判断余额
                if( ($pay_detailed["M_credit"]+$credit) >=  $total_price )
                {
                    
                    $this->db->trans_begin(); //事物执行方法中的MODEL。
                    
                    //扣用户货豆
                    $this->load->model ( 'pay_account_mdl' );
                    $row = $this->pay_account_mdl->update_M_creadit($pay_account_id, $total_price);
                    
                    if( $row )
                    { 
                        $this->load->model("customer_currency_log_mdl",'customer_currency_log');
                        
                        //上一次用户的货豆交易日志
                        $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
                        
                        //检测货豆是否异常
                        if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m)
                        {
                            $M_credit_expend_data['status'] = '1';
                        }else if(!$last_m_log && $surplus_m =='0'){
                            $M_credit_expend_data['status'] = '1';
                        }else{
                            $M_credit_expend_data['status'] = '2';
                        }
                        
                        //上一次平台的货豆交易日志
                        $to_last_m_log    = $this->customer_currency_log->load_last('-1');
                        
                        
                        //用户的
                        $M_expend_beg = $surplus_m;
                        $M_expend_end = 0;
                        
                        //平台的
                        $M_income_beg = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
                        $M_income_end = 0;
                        
                        $i = 0;
                        foreach  ( $order_info as $v)
                        {
                            
                            //--接收数据
                            $corp_customer_id = $v['corp_customer_id'];//收款方的用户ID
                            $order_total_price = $v['total_price'];
                            $order_sn = $v['order_sn'];
                            $app_id = $v['app_id'];
                            
                            if($i == 0)
                            {   
                                //用户的 - 第一张订单处理
                                
                                $M_expend_end = $M_expend_beg - $order_total_price;
                               
                                //平台的 - 第一张订单处理
                                $M_income_end = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance']+$order_total_price: $order_total_price ;
                                
                            }else{ 
                                
                                //用户的
                                $M_expend_beg = $M_expend_end;
                                $M_expend_end = $M_expend_end - $order_total_price;
                                
                                //平台的
                                $M_income_beg = $M_income_end;
                                $M_income_end = $M_income_end + $order_total_price;
                            }
                            
                            

                            //货豆日志
                            $M_credit_expend_data['status'] = '1';
                            $M_credit_expend_data['relation_id'] = $pay_relation_id;
                            $M_credit_expend_data['id_event'] = '60';
                            $M_credit_expend_data['remark'] = '购物支出';
                            $M_credit_expend_data['amount'] = $order_total_price;
                            $M_credit_expend_data['order_no'] = $order_sn;
                            $M_credit_expend_data['type'] = '2';
                            $M_credit_expend_data['beginning_balance'] = $M_expend_beg;
                            $M_credit_expend_data['ending_balance'] = $M_expend_end;
                            $M_credit_expend_data['customer_id'] = $corp_customer_id;
                            $M_credit_expend_data['app_id'] = $app_id;
                            
                            $M_credit_log = $this->customer_currency_log->add_log($M_credit_expend_data);
                             
                            if( $M_credit_log )
                            {
                                 
                                
                                //支出方货豆日志
                                $M_credit_data['remark'] = '平台收入';
                                $M_credit_data['relation_id'] = '-1';
                                $M_credit_data['type'] = '1';
                                $M_credit_data['status'] = '1';
                                $M_credit_data['id_event'] = '60';
                                $M_credit_data['order_no'] = $order_sn;
                                $M_credit_data['amount'] = $order_total_price;
                                $M_credit_data['beginning_balance'] = $M_income_beg;
                                $M_credit_data['ending_balance'] = $M_income_end;
                                $M_credit_data['customer_id'] = $customer_id;
                                $M_credit_data['app_id'] = $app_id;
                                //收入方货豆日志
                                $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                    
                                if(!$to_M_credit_log)
                                {
                                    
                                    $this->db->trans_rollback();
                                    $error['status'] = 'fail';
                                    echo json_encode($error);
                                    exit();
                                }
                            }else{ 
                                
                                $this->db->trans_rollback();
                                $error['status'] = 'fail';
                                echo json_encode($error);
                                exit();
                            }
                            
                            $i++;
                        }
                        
                        $this->db->trans_commit();
                        $error['status'] = 'success';//支付成功
                        
                    }else{ 
                        $this->db->trans_rollback();
                        $error['status'] = 'fail';
                        
                    }
                    
                }else{
                    //余额不足
                    $error['status'] = 'no_money';
                     
                }
                 
            }else{
                //密码错误
                $error['status'] = 'wrong';
            
            }
        }
        
        echo json_encode($error);
        

    }
    
    /**
     * C端手续费扣店主的  -- 面对面支付才用这个了，一般流程是收货扣店主手续费
     * @$pay_r_id = 支付账户关联表ID
     * $order_sn = 订单号
     * $app_id = 地区ID
     * $C_commission = 手续费金额
     * $corp_M = 扣除手续费钱的货豆（用户）
     * $platform_M = 收取手续费前的货豆（平台）
     * $corp_customer_id 支出手续费的用户ID。
     */
    private function C_order_commission( $pay_r_id, $order_sn, $app_id, $C_commission, $corp_M, $platform_M,$corp_customer_id)
    {
    
        //店主支出货豆手续费
        $M_corp_commission['relation_id'] = $pay_r_id;
        $M_corp_commission['status'] = 1;
        $M_corp_commission['id_event'] = '76';
        $M_corp_commission['remark'] = '手续费扣款';
        $M_corp_commission['type'] = '2';
        $M_corp_commission['amount'] = $C_commission;
        $M_corp_commission['order_no'] = $order_sn;
        $M_corp_commission['beginning_balance'] = $corp_M;
        $M_corp_commission['ending_balance'] = $corp_M - $C_commission;
        $M_corp_commission['customer_id'] = '-1';
        $M_corp_commission['app_id'] = $app_id;
        
        //店主支出货豆手续费日志
        $M_corp_commission_log = $this->customer_currency_log->add_log($M_corp_commission);
        
        
        if( $M_corp_commission_log )
        { 
            //平台收入货豆手续费
            $M_commission['relation_id'] = '-1';
            $M_commission['id_event'] = '76';
            $M_commission['remark'] = '平台收入-手续费扣款';
            $M_commission['type'] = '1';
            $M_commission['status'] = 1;
            $M_commission['amount'] = $C_commission;
            $M_commission['order_no'] = $order_sn;
            $M_commission['beginning_balance'] = $platform_M;
            $M_commission['ending_balance'] = $platform_M + $C_commission;
            $M_commission['customer_id'] = $corp_customer_id;
            $M_commission['app_id'] = $app_id;
            
            //平台收入货豆手续费日志
            $M_commission_log = $this->customer_currency_log->add_log($M_commission);
            
            if( $M_commission_log )
            { 
                return true;
            }
        }
                                
            return false;                    
        
    }
}

?>