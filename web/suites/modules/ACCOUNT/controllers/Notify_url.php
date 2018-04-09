<?php
/**
 * 通用通知接口 B端-C端--微信--支付宝--操作账户接口
 * ====================================================
 * 
 */
class Notify_url extends Account_Controller {
	public function __construct() {
		parent::__construct ();
		
	}
	
	
	/**
	 * 充值返回接口-A端操作
	 */
	
	public function after_pay_charge(){
	    $error['status'] = false;
	    $customer = $this->input->post('customer_id'); 
	    $charge_cash = $this->input->post('charge_cash');//该充值订单的金额
	    $app_id = $this->input->post('app_id');
	    $chargeno = $this->input->post('chargeno');
	    
	    $this->load->model('Pay_account_mdl','pay_account');
	    
	    //查询该用户的支付账号
	    $pay_detailed = $this->pay_account->load($customer);
	    $cash = $pay_detailed['cash']; //充值前的现金余额
	    $pay_id = $pay_detailed['id']; //该用户的支付账号的ID
	    $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
	    
	    $this->db->trans_begin(); //事物执行方法中的MODEL
	    
	    
	    //帮用户添加现金余额;
	    $charge_cash_row = $this->pay_account->charge_cash($pay_id,$charge_cash);
	    
	    if($charge_cash_row)
	    { 
	        $this->load->model("customer_money_log_mdl",'customer_money_log');
	        //上一次用户交易的日志
	        $last_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);
	         
	        
	        $cash_data['id_event'] = '68';
	        $cash_data['cash'] = $charge_cash;
	        $cash_data['charge_no'] = $chargeno;
	        $cash_data['status'] = '1';
	        $cash_data['relation_id'] = $pay_relation_id;
	        $cash_data['type'] = '1';
	        $cash_data['remark'] = '现金充值到账';
	        $cash_data['beginning_balance'] = $cash;
	        $cash_data['ending_balance'] = $cash+$charge_cash;
	        $cash_data['customer_id'] = '-1';
	        $cash_data['app_id'] = $app_id;
	        //写入现金日志
	        $cash_log = $this->customer_money_log->add_log($cash_data);
	        
	        if($cash_log)
	        { 
	            $this->db->trans_commit();
	            $error['status'] = true;
	        }
	    }
	    
	    if(empty($error['status']) )
	        $this->db->trans_rollback();
	    
	    echo json_encode($error);
	}
	
	/**
	 * 互助店开通返回接口-A端操作
	 */
	public function after_shop_charge(){
	    $error['status'] = false;
	    $customer = $this->input->post('customer_id');
	    $charge_cash = $this->input->post('charge_cash');//该充值订单的金额
	    $app_id = $this->input->post('app_id');
	    $chargeno = $this->input->post('chargeno');
	    
	    $this->load->model('Pay_account_mdl','pay_account');
	    
	    $this->db->trans_begin(); //事物执行方法中的MODEL
	    
	    $this->load->model("customer_money_log_mdl",'customer_money_log');
	    $platform_last_cash_log = $this->customer_money_log->load_create_desc('-1');
	    
	    $cash_data['relation_id'] = '-1';
	    $cash_data['id_event'] = '79';
	    $cash_data['cash'] = $charge_cash;
	    $cash_data['charge_no'] = $chargeno;
	    $cash_data['type'] = '1';
	    $cash_data['status'] = '1';
	    $cash_data['remark'] = '平台收入-开通互助店';
	    $cash_data['beginning_balance'] = !empty( $platform_last_cash_log['ending_balance'] ) ? $platform_last_cash_log['ending_balance'] : '0.00';
	    $cash_data['ending_balance'] = $cash_data['beginning_balance']+$charge_cash;
	    $cash_data['customer_id'] = $customer;
	    $cash_data['app_id'] = $app_id;
	    
	    
	    
	    //写入现金日志
	    $cash_log = $this->customer_money_log->add_log($cash_data);
	     
	    if($cash_log)
	    {
	        $this->db->trans_commit();
	        $error['status'] = true;
	    }
	    
	    if(empty($error['status']) ){
	        $this->db->trans_rollback();
	    }
	    echo json_encode($error);
	}
	
	
	
	/**
	 * 充值返回普通订单接口-A端操作
	 */
	
	public function after_pay_order(){ 
	    $customer_id = $this->input->post('customer_id');
	    $charge_cash = $this->input->post('charge_cash');//该充值订单的金额
	    $chargeno = $this->input->post('chargeno');
	    $order_total_price = $this->input->post('order_total_price');
	    $corp_customer_id = $this->input->post('corp_customer_id');
	    $order_sn = $this->input->post('order_sn');
	    $app_id = $this->input->post('app_id');
	    $commission = $this->input->post('commission');
	    $charge_commission = $this->input->post('charge_commission');
	    
	    $this->load->model('Pay_account_mdl','pay_account');
	    $error['status'] = false;
	    
	    //查询该用户的支付账号
	    $pay_detailed = $this->pay_account->load($customer_id);
	    $pay_id = $pay_detailed['id']; //该用户的支付账号的ID
	    $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
	    $cash = $pay_detailed['cash']; //充值前的现金余额
	    $M_credit = $pay_detailed['M_credit'];//充值前提货权余额
	    $total_charge_cash = $charge_cash; //总充值余额
	    
	    $time = date('Y-m-d H:i:s');
	     
	    if( $pay_detailed ){
	        if(! ($pay_detailed['credit_start_time'] <= $time && $pay_detailed['credit_end_time'] >= $time) ){
	            $pay_detailed['credit'] = '0.00';
	        }
	    }
	    
	    $this->db->trans_begin(); //事物执行方法中的MODEL。
	    
	    //充值成功后帮用户添加现金余额;
	    $total_cash = $cash+$charge_cash;//充值后的现金余额
	    
        //----现金日志收入操作开始<
	    $this->load->model("customer_money_log_mdl",'customer_money_log');
	    $last_user_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);//上一次用户现金交易的日志
	    
	    //检测现金是否异常
	    if( isset($last_user_cash_log['ending_balance']) &&  $last_user_cash_log['ending_balance'] == $cash){
	        $user_cash_income['status'] = '1';
	    }else if(!$last_user_cash_log && $cash =='0'){
	        $user_cash_income['status'] = '1';
	    }else{
	        $user_cash_income['status'] = '2';
	    }
	    
	    $user_cash_income['relation_id'] = $pay_relation_id;
	    $user_cash_income['id_event'] = '68';
	    $user_cash_income['remark'] = '现金充值到账';
	    $user_cash_income['cash'] = $total_charge_cash;
	    $user_cash_income['charge_no'] = $chargeno;
	    $user_cash_income['beginning_balance'] = $cash;
	    $user_cash_income['ending_balance'] = $total_cash;
	    $user_cash_income['status'] = '1';
	    $user_cash_income['type'] = '1';
	    $user_cash_income['app_id'] = $app_id;
	    $user_cash_income['customer_id'] = '-1';
	    //写入现金收入日志
	    $user_cash_log = $this->customer_money_log->add_log($user_cash_income);
        //----现金日志收入操作结束 ->
    
	    if($user_cash_log){  //写入现金收入日志成功后
	       
	        $commission_row = true;
	        /**---处理手续费开始*/
	         
	        //如果有手续费->先处理手续费
	        if( $commission > 0 )
	        {
	            //如果充值手续费+原现金足够扣除
	            if( ($charge_commission + $cash ) >=  $commission )
	            {
	                //扣除手续费
	                $commission_row = $this->order_commission( $pay_detailed, $order_sn, $app_id, $commission, $charge_commission, $total_cash );
	                
	                //除去充值的手续费剩余就是充值提货权支付的。
	                $charge_cash = $charge_cash - $charge_commission;
	                 
	            }else{
	                 
	                $this->db->trans_rollback();//回滚。
	                //充值的金额+上提货权不足以扣除此订单的金额，让B端调用充值的方法吧。
	                $error['status'] = 2;
	                echo json_encode($error);; //返回给端口状态码
	                return;
	            }
	        }
	        
	        /**---处理手续费结束*/
	        
	        /**---处理扣除提货权开始*/
	        //--金额判断
	        $user_total_m = $M_credit+$charge_cash; //用户现金充值提货权后，剩余总提货权
	        $user_M_credit = $order_total_price - $charge_cash; //充值金额减去订单金额，剩余需要用户支付的提货权是多少。
	        
	        $charge_cash_row = true;
	        
	        if($user_M_credit != 0){ //判断是混合支付，还是全款微信
	            //减去用户需支付提货权
	        
	            //混合支付做多个判断。
	            //判断可用余额是否足够减去 订单
	            if( ($pay_detailed['credit']+$user_total_m) >= $order_total_price ){
	                $charge_cash_row = $this->pay_account->update_M_creadit($pay_detailed['id'],$user_M_credit);
	                 
	            }else{
	                 
	                $this->db->trans_rollback();//回滚。
	                //充值的金额+上提货权不足以扣除此订单的金额，让C端或者B端调用充值的方法吧。
	                $error['status'] = 2;
	                echo json_encode($error);; //返回给端口状态码
	                return;
	            }
	        }
	        /**---处理扣除提货权结束*/
	        
	        if( $commission_row  && $charge_cash_row){
	            
	            if( $charge_cash > 0 )
	            { //说明if中都是执行 订单和手续费的充值支付。
	                
	                //构造现金充值提货权订单数据
        	        $this->load->helper('order');
        	        $data ['customer_id'] = $customer_id;
        	        $data ['amount'] = $charge_cash;
        	        $this->load->model('customer_currency_log_mdl','customer_currency_log');
        	    
        	        do {
        	    
        	            $data ['charge_no'] = get_order_sn ();
        	            if ($this->customer_currency_log->check_charge_sn ( $data ['charge_no'] ) ) {
        	                $order_exist = true;
        	            } else {
        	                $currency_order = $this->customer_currency_log->create_charge_currency( $data );
        	                $order_exist = false;
        	            }
        	        } while ( $order_exist ); // 如果是订单号重复则重新提交数据
        	    
        	        if($currency_order){ //生成提货权充值订单成功后
        	    
        	            //写用户现金支出.
        	            $user_cash_expend['relation_id'] = $pay_relation_id;
        	            $user_cash_expend['id_event'] = '66';
        	            $user_cash_expend['remark'] = '现金充值提货权';
        	            $user_cash_expend['cash'] = $charge_cash;
        	            $user_cash_expend['charge_no'] = $data ['charge_no'];
        	            $user_cash_expend['beginning_balance'] = $total_cash - $commission;
        	            $user_cash_expend['ending_balance'] = $user_cash_expend['beginning_balance'] - $charge_cash;
        	            $user_cash_expend['status'] = '1';
        	            $user_cash_expend['type'] = '2';
        	            $user_cash_expend['customer_id'] = '-1';
        	            $user_cash_expend['app_id'] = $app_id;
        	            //写入现金日志（支出）
        	            $user_cash_log = $this->customer_money_log->add_log($user_cash_expend);
        	    
        	            if($user_cash_log){
        	    
        	                //上一次平台交易的日志
        	                $platform_last_cash_log = $this->customer_money_log->load_create_desc('-1');
        	    
        	                //写平台现金收入。
        	                $platform_cash_income['relation_id'] = '-1';
        	                $platform_cash_income['id_event'] = '66';
        	                $platform_cash_income['cash'] = $charge_cash;
        	                $platform_cash_income['charge_no'] = $data ['charge_no'];
        	                $platform_cash_income['type'] = '1';
        	                $platform_cash_income['status'] = '1';
        	                $platform_cash_income['remark'] = '平台收入-充值提货权';
        	                $platform_cash_income['beginning_balance'] = !empty( $platform_last_cash_log['ending_balance'] ) ? $platform_last_cash_log['ending_balance'] : '0.00';
        	                $platform_cash_income['ending_balance'] = $platform_cash_income['beginning_balance']+$charge_cash;
        	                $platform_cash_income['customer_id'] = $customer_id;
        	                $platform_cash_income['app_id'] = $app_id;
        	                //写入现金日志（收入）
        	                $platform_cash_log = $this->customer_money_log->add_log($platform_cash_income);
        	    
        	                if($platform_cash_log){
        	                    //写平台提货权减去，用户M卷加
        	    
        	    
        	                    //上一次平台提货权交易的日志中的信息
        	                    $platform_last_m_log  = $this->customer_currency_log->load_last('-1');
        	    
        	    
        	                    //提货权日志 -平台支出提货权
        	                    $platform_m_expend['relation_id'] = '-1';
        	                    $platform_m_expend['id_event'] = '66';
        	                    $platform_m_expend['type'] = '2';
        	                    $platform_m_expend['status'] = '1';
        	                    $platform_m_expend['remark'] = '平台支出-充值提货权';
        	                    $platform_m_expend['amount'] = $charge_cash;
        	                    $platform_m_expend['order_no'] = $data['charge_no'];
        	                    $platform_m_expend['beginning_balance'] = !empty($platform_last_m_log['ending_balance']) ? $platform_last_m_log['ending_balance'] : '0.00';;
        	                    $platform_m_expend['ending_balance'] = $platform_m_expend['beginning_balance']-$charge_cash;
        	                    $platform_m_expend['customer_id'] = $customer_id;
        	                    $platform_m_expend['app_id'] = $app_id;
        	                    //平台提货权支出
        	                    $platform_m_log = $this->customer_currency_log->add_log($platform_m_expend);
        	    
        	                    if($platform_m_log){
        	    
        	                        //上一次提货权交易的日志中的信息
        	                        $user_last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
        	    
        	                        //提货权日志 -用户收入提货权日志
        	                        if( isset($user_last_m_log['ending_balance']) &&  $user_last_m_log['ending_balance'] == $M_credit){  //检测提货权是否异常
        	                            $user_m_income['status'] = '1';
        	                        }else if(!$user_last_m_log && $M_credit =='0'){
        	                            $user_m_income['status'] = '1';
        	                        }else{
        	                            $user_m_income['status'] = '2';
        	                        }
        	                        $user_m_income['id_event'] = '66';
        	                        $user_m_income['relation_id'] = $pay_relation_id;
        	                        $user_m_income['type'] = '1';
        	                        $user_m_income['amount'] = $charge_cash;
        	                        $user_m_income['remark'] = '现金充值提货权到账';
        	                        $user_m_income['order_no'] = $data['charge_no'];
        	                        $user_m_income['beginning_balance'] = $M_credit;
        	                        $user_m_income['ending_balance'] = $M_credit+$charge_cash;
        	                        $user_m_income['customer_id'] = '-1';
        	                        $user_m_income['app_id'] = $app_id;
        	                        //写入提货权日志
        	                        $user_m_log = $this->customer_currency_log->add_log($user_m_income);
        	    
                                    //用户提货权处理完毕
                                    if($user_m_log){
            
                                        //处理交易提货权日志 ，用户支出提货权日志，平台收入提货权日志，更改订单状态
            
                                        //用户购物支出提货权日志
                                        $user_m_expend['relation_id'] = $pay_relation_id;
            
                                        $user_m_expend['id_event'] = '60';
                                        $user_m_expend['type'] = '2';
                                        $user_m_expend['status'] = '1';
                                        $user_m_expend['remark'] = '购物支出';
                                        $user_m_expend['amount'] = $order_total_price;
                                        $user_m_expend['order_no'] = $order_sn;
                                        $user_m_expend['beginning_balance'] = $M_credit+$charge_cash;
                                        $user_m_expend['ending_balance'] = $M_credit-$user_M_credit;
                                        $user_m_expend['customer_id'] = $corp_customer_id;
                                        $user_m_expend['app_id'] = $app_id;
                                        //用户支出提货权日志
                                        $user_m_log = $this->customer_currency_log->add_log($user_m_expend);
            
                                        if($user_m_log){
                                        
                                            //提货权日志 -平台收入提货权
                                            $platform_m_income['relation_id'] = '-1';
                                            $platform_m_income['id_event'] = '60';
                                            $platform_m_income['type'] = '1';
                                            $platform_m_income['status'] = '1';
                                            $platform_m_income['remark'] = '平台收入';
                                            $platform_m_income['amount'] = $order_total_price;
                                            $platform_m_income['order_no'] = $order_sn;
                                            $platform_m_income['beginning_balance'] = $platform_last_m_log['ending_balance'] - $charge_cash;
                                            $platform_m_income['ending_balance'] = $platform_m_income['beginning_balance']+$order_total_price;
                                            $platform_m_income['customer_id'] = $customer_id;
                                            $platform_m_income['app_id'] = $app_id;
                                            //用户提货权日志
                                            $platform_m_log = $this->customer_currency_log->add_log($platform_m_income);
            
                                            if($platform_m_log){
                                                $this->db->trans_commit();
                                                $error['status'] = 1;
                                                
                                            }
                                        }
                                    }
        	                    }
        	                }
        	            }
        	        }
        	        
        	        
    	        }else{
    	            
    	            //说明else中都是执行 订单的提货权支付。
    	             
    	            $this->load->model('customer_currency_log_mdl','customer_currency_log');
    	           //处理交易提货权日志 ，用户支出提货权日志，平台收入提货权日志，更改订单状态
	            
	                //用户购物支出提货权日志
	                $user_m_expend['relation_id'] = $pay_relation_id;
	            
	                $user_m_expend['id_event'] = '60';
	                $user_m_expend['type'] = '2';
	                $user_m_expend['status'] = '1';
	                $user_m_expend['remark'] = '购物支出';
	                $user_m_expend['amount'] = $order_total_price;
	                $user_m_expend['order_no'] = $order_sn;
	                $user_m_expend['beginning_balance'] = $M_credit+$charge_cash;
	                $user_m_expend['ending_balance'] = $M_credit-$user_M_credit;
	                $user_m_expend['customer_id'] = $corp_customer_id;
	                $user_m_expend['app_id'] = $app_id;
	                //用户支出提货权日志
	                $user_m_log = $this->customer_currency_log->add_log($user_m_expend);
	            
	                if($user_m_log){
	            
	                    //上一次平台提货权交易的日志中的信息
	                    $platform_last_m_log  = $this->customer_currency_log->load_last('-1');
	                    
	                    //提货权日志 -平台收入提货权
	                    $platform_m_income['relation_id'] = '-1';
	                    $platform_m_income['id_event'] = '60';
	                    $platform_m_income['type'] = '1';
	                    $platform_m_income['status'] = '1';
	                    $platform_m_income['remark'] = '平台收入';
	                    $platform_m_income['amount'] = $order_total_price;
	                    $platform_m_income['order_no'] = $order_sn;
	                    $platform_m_income['beginning_balance'] = $platform_last_m_log['ending_balance'];
	                    $platform_m_income['ending_balance'] = $platform_m_income['beginning_balance']+$order_total_price;
	                    $platform_m_income['customer_id'] = $customer_id;
	                    $platform_m_income['app_id'] = $app_id;
	                    //用户提货权日志
	                    $platform_m_log = $this->customer_currency_log->add_log($platform_m_income);
	            
	                    if($platform_m_log){
	                        $this->db->trans_commit();
	                        $error['status'] = 1;
	            
	                    }
	                }
    	        }
	        }
	    }
	    
	    if( empty($error['status']) )
	    {
	        $this->db->trans_rollback();
	    }
	    echo json_encode($error);
	}
	
	/**
	 * 充值返回拼团订单接口-A端操作
	 */
	
	public function after_pay_groupby(){

	    $user_id = $this->input->post('user_id');
	    $order_sn = $this->input->post('order_sn');
	    $total_price = $this->input->post('total_price');
	    $charge_cash = $this->input->post('charge_cash');//该充值订单的金额
	    $chargeno = $this->input->post('chargeno');
	    $corp_customer_id = $this->input->post('corp_customer_id');
	    $app_id = $this->input->post('app_id');
	    $this->load->model("pay_account_mdl", "pay_account");
	     
	    //查询该用户的支付账号
	    $pay_detailed = $this->pay_account->load($user_id);
	     
	    $this->db->trans_begin(); //事物执行方法中的MODEL。
	    $error['status'] = false;
	    $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
	     
	    $cash = $pay_detailed['cash']; //充值前的现金余额
	     
	    $surplus_m = $pay_detailed['M_credit'];//支付账号中的提货权余额
	     
	    $time = date('Y-m-d H:i:s');
	    
	    if( $pay_detailed ){
	        if(! ($pay_detailed['credit_start_time'] <= $time && $pay_detailed['credit_end_time'] >= $time) ){
	            $pay_detailed['credit'] = '0.00';
	        }
	    }
	    
	    $this->load->model("customer_money_log_mdl",'customer_money_log');
	    //上一次用户交易的日志
	    $last_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);
	    
	     
	    //检测是否异常
	    if( isset($last_cash_log['ending_balance']) &&  $last_cash_log['ending_balance'] == $cash){
	        $cash_data['status'] = '1';
	    }else if(!$last_cash_log && $cash =='0'){
	        $cash_data['status'] = '1';
	    }else{
	        $cash_data['status'] = '2';
	    }
	    $cash_data['id_event'] = '68';
	    $cash_data['relation_id'] = $pay_relation_id;
	    $cash_data['cash'] = $charge_cash;
	    $cash_data['charge_no'] = $chargeno;
	    $cash_data['type'] = '1';
	    $cash_data['remark'] = '现金充值到账';
	    $cash_data['beginning_balance'] = $cash;
	    $cash_data['ending_balance'] = $cash+$charge_cash;
	    $cash_data['customer_id'] = '-1';
	    $cash_data['app_id'] = $app_id;
	    //用户充值现金写入日志
	    $cash_log_one = $this->customer_money_log->add_log($cash_data);
	    
	    if( $cash_log_one )
	    { 
	        //用户最后金额
	        $last_cash_log['ending_balance'] = $cash_data['ending_balance'];
	        
	        //-----用户进行充值提货权------------
	         
	        $this->load->helper ( 'order' );
	        $this->load->model("customer_currency_log_mdl",'customer_currency_log');
	         
	        $data ['customer_id'] = $user_id;
	        $data ['amount'] = $charge_cash;
	        $data ['charge_no'] = get_order_sn ();
	        $M_credit = $charge_cash;
	        
	        do {
	        
	            $data ['charge_no'] = get_order_sn ();
	             
	            if ($this->customer_currency_log->check_charge_sn ( $data ['charge_no'] ) ) {
	                $order_exist = true;
	            } else {
	                $currency_order = $this->customer_currency_log->create_charge_currency( $data );
	                $order_exist = false;
	            }
	        } while ( $order_exist ); // 如果是订单号重复则重新提交数据
	        // 	        echo $currency_order;
	         
	        if( $currency_order )
	        { 
	            //检测现金是否异常
	            if( isset($last_cash_log['ending_balance']) &&  $last_cash_log['ending_balance'] == $cash+$M_credit)
	            {
	                $cash_data['status'] = '1';
	            }else if(!$last_cash_log && $cash =='0'){
	                $cash_data['status'] = '1';
	            }else{
	                $cash_data['status'] = '2';
	            }
	             
	            //现金支出日志
	            $cash_data['relation_id'] = $pay_relation_id;
	            $cash_data['id_event'] = '66';
	            $cash_data['type'] = '2';
	            $cash_data['remark'] = '现金充值提货权';
	            $cash_data['cash'] = $M_credit;
	            $cash_data['charge_no'] = $data['charge_no'];
	            $cash_data['beginning_balance'] = $last_cash_log['ending_balance'];
	            $cash_data['ending_balance'] = $last_cash_log['ending_balance']-$M_credit;
	            $cash_data['customer_id'] = '-1';
	            //写入现金日志
	            $cash_log_two = $this->customer_money_log->add_log($cash_data);
	            
	            if( $cash_log_two )
	            {
	                //用户最后现金金额
	                $last_cash_log['ending_balance'] = $cash_data['ending_balance'];
	                
	                //上一次平台交易的日志
	                $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
	                 
	                //平台现金收入日志
	                $cash_data['relation_id'] = '-1';
	                $cash_data['type'] = '1';
	                $cash_data['status'] = '1';
	                $cash_data['remark'] = '平台收入-充值提货权';
	                $cash_data['beginning_balance'] = $to_last_cash_log['ending_balance'];
	                $cash_data['ending_balance'] = $to_last_cash_log['ending_balance']+$M_credit;
	                $cash_data['customer_id'] = $user_id;
	                //写入现金日志
	                $to_cash_log_two = $this->customer_money_log->add_log($cash_data);
	                
	                if( $to_cash_log_two )
	                { 
	                    //平台最后现金金额
	                    $to_last_cash_log_two['ending_balance'] = $cash_data['ending_balance'];
	                    
	                    //上一次提货权交易的日志中的信息
	                    $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
	                    
	                    //上一次平台提货权交易的日志中的信息
	                    $to_last_m_log    = $this->customer_currency_log->load_last('-1');
	                     
	                    
	                    //提货权日志 -平台支出提货权
	                    $M_credit_data['relation_id'] = '-1';
	                    $M_credit_data['id_event'] = '66';
	                    $M_credit_data['type'] = '2';
	                    $M_credit_data['status'] = '1';
	                    $M_credit_data['remark'] = '平台支出-充值提货权';
	                    $M_credit_data['amount'] = $M_credit;
	                    $M_credit_data['order_no'] = $data['charge_no'];
	                    $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';;
	                    $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance']-$M_credit: -$M_credit;
	                    $M_credit_data['customer_id'] = $user_id;
	                    $M_credit_data['app_id'] = $app_id;
	                    //写入提货权日志
	                    $M_credit_log_one = $this->customer_currency_log->add_log($M_credit_data);
	                    
	                    if( $M_credit_log_one )
	                    { 
	                        //平台提货权最后余额
	                        $to_last_m_log['ending_balance'] = $M_credit_data['ending_balance'];
	                        
	                        //提货权日志 -用户收入提货权日志
	                        if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m){  //检测提货权是否异常
	                            $M_credit_data['status'] = '1';
	                        }else if(!$last_m_log && $surplus_m =='0'){
	                            $M_credit_data['status'] = '1';
	                        }else{
	                            $M_credit_data['status'] = '2';
	                        }
	                        
	                        $M_credit_data['relation_id'] = $pay_relation_id;
	                        $M_credit_data['type'] = '1';
	                        $M_credit_data['remark'] = '现金充值提货权到账';
	                        $M_credit_data['beginning_balance'] = $surplus_m;
	                        $M_credit_data['ending_balance'] = $M_credit+$surplus_m;
	                        $M_credit_data['customer_id'] = '-1';
	                        //写入提货权日志
	                        $to_M_credit_log_two = $this->customer_currency_log->add_log($M_credit_data);
	                        
	                        if( $to_M_credit_log_two )
	                        {
	                            //用户最后提货权金额
	                            $last_m_log['ending_balance'] = $M_credit_data['ending_balance'];
	                            
	                            $user_total_m = $surplus_m+$charge_cash; //用户现金充值提货权后，剩余总提货权
	                            
	                            $user_M_credit = $total_price - $charge_cash; //充值金额减去订单金额，剩余需要用户支付的提货权是多少。
	                             
	                            $charge_cash_row = true;
	                             
	                            if($user_M_credit != 0){
	                                //减去用户需支付提货权
	                                 
	                                //判断可用余额是否足够减去 订单
	                                if( ($pay_detailed['credit']+$user_total_m) >= $total_price ){
	                                    
	                                    $charge_cash_row = $this->pay_account->update_M_creadit($pay_detailed['id'],$user_M_credit);
	                                     
	                                }else{
	                                    $this->db->trans_rollback();
	                                     //充值的金额+上提货权不足以扣除此订单的金额，让C端或者B端调用充值的方法吧。
	                                    $error['status'] =  2; //返回给端口状态码
	                                    echo json_encode($error);
	                                    return;
	                                }
	                            }
	                            
	                            if( $charge_cash_row )
	                            { 
	                                //平台收入日志
	                                $M_credit_data['remark'] = '平台收入';
	                                $M_credit_data['relation_id'] = '-1';
	                                $M_credit_data['type'] = '1';
	                                $M_credit_data['status'] = '1';
	                                $M_credit_data['amount'] = $total_price;
	                                $M_credit_data['order_no'] = $order_sn;
	                                $M_credit_data['beginning_balance'] = $to_last_m_log['ending_balance'];
	                                $M_credit_data['ending_balance'] = $to_last_m_log['ending_balance']+$total_price;
	                                $M_credit_data['customer_id'] = $user_id;
	                                 
	                                //收入方提货权日志
	                                $to_M_credit_log_three = $this->customer_currency_log->add_log($M_credit_data);
	                                
	                                if( $to_M_credit_log_three )
	                                { 

	                                    //用户支出提货权日志
	                                    $M_credit_data['status'] = '1';
	                                    $M_credit_data['relation_id'] = $pay_relation_id;
	                                    $M_credit_data['id_event'] = '60';
	                                    $M_credit_data['remark'] = '购物支出';
	                                    $M_credit_data['type'] = '2';
	                                    $M_credit_data['beginning_balance'] = $last_m_log['ending_balance'];
	                                    $M_credit_data['ending_balance'] = $last_m_log['ending_balance']-$total_price;
	                                    $M_credit_data['customer_id'] = $corp_customer_id;
	                                    //用户提货权日志
	                                    $M_credit_log_three = $this->customer_currency_log->add_log($M_credit_data);
	                                    
	                                    if($M_credit_log_three)
	                                    { 
	                                        $this->db->trans_commit();
	                                        $error['status'] = 1;
	                                    }
	                                }
	                            }
	                        }
	                    }
	                }
	            }
	        }
	    }
	    
	    if( empty($error['status']) )
	    {
	        $this->db->trans_rollback();
	    }
	    echo json_encode($error);
	}
	
	/**
	 * 充值返回面对面订单接口-A端操作
	 */
	
	public function code_pay_order()
	{ 
	    
	    $customer_id = $this->input->post('customer_id');
	    $charge_cash = $this->input->post('charge_cash');//该充值订单的金额
	    $chargeno = $this->input->post('chargeno');
	    $order_total_price = $this->input->post('order_total_price');
	    $corp_customer_id = $this->input->post('corp_customer_id');
	    $order_sn = $this->input->post('order_sn');
	    $app_id = $this->input->post('app_id');
	    $commission = $this->input->post('commission'); //B端手续费
	    $C_commission = $this->input->post('C_commission');//c端手续费
	    $charge_commission = $this->input->post('charge_commission');
	    $this->load->model('Pay_account_mdl','pay_account');
	     
	    
	    //查询该用户的支付账号
	    $pay_detailed = $this->pay_account->load($customer_id);

	   
	    $pay_id = $pay_detailed['id']; //该用户的支付账号的ID
	    $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
	    $cash = $pay_detailed['cash']; //充值前的现金余额
	    $M_credit = $pay_detailed['M_credit'];//充值前提货权余额
	    $total_charge_cash = $charge_cash; //总充值余额
	    
	    $time = date('Y-m-d H:i:s');
	     
	    if( $pay_detailed ){
	        if(! ($pay_detailed['credit_start_time'] <= $time && $pay_detailed['credit_end_time'] >= $time) ){
	            $pay_detailed['credit'] = '0.00';
	        }
	    }
	     
	    //充值成功后帮用户添加现金余额;
	    $total_cash = $cash+$charge_cash;
	    
	    $this->db->trans_begin(); //事物执行方法中的MODEL。
	    $error['status'] = false;
	    
	    
        //----现金日志收入操作开始<
        $this->load->model("customer_money_log_mdl",'customer_money_log');
        $last_user_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);//上一次用户现金交易的日志
         
        //检测现金是否异常
        if( isset($last_user_cash_log['ending_balance']) &&  $last_user_cash_log['ending_balance'] == $cash){
            $user_cash_income['status'] = '1';
        }else if(!$last_user_cash_log && $cash =='0'){
            $user_cash_income['status'] = '1';
        }else{
            $user_cash_income['status'] = '2';
        }
         
        $user_cash_income['relation_id'] = $pay_relation_id;
        $user_cash_income['id_event'] = '68';
        $user_cash_income['remark'] = '现金充值到账';
        $user_cash_income['cash'] = $total_charge_cash;
        $user_cash_income['charge_no'] = $chargeno;
        $user_cash_income['beginning_balance'] = $cash;
        $user_cash_income['ending_balance'] = $total_cash;
        $user_cash_income['status'] = '1';
        $user_cash_income['type'] = '1';
        $user_cash_income['app_id'] = $app_id;
        $user_cash_income['customer_id'] = '-1';
        //写入现金收入日志
        $user_cash_log = $this->customer_money_log->add_log($user_cash_income);
        
        if( $user_cash_log )
        {
            
            $commission_row = true;
            /**---处理手续费开始*/
            
            //如果有手续费->先处理手续费
            if( $commission > 0 )
            {
                //如果充值手续费+原现金足够扣除
                if( ($charge_commission + $cash ) >=  $commission )
                {
                    //扣除手续费
                    $commission_row = $this->order_commission( $pay_detailed, $order_sn, $app_id, $commission, $charge_commission, $total_cash );
                     
                    //除去充值的手续费剩余就是充值提货权支付的。
                    $charge_cash = $charge_cash - $charge_commission;
            
                }else{
            
                    $this->db->trans_rollback();//回滚。
                    //充值的金额+上提货权不足以扣除此订单的金额，让B端调用充值的方法吧。
                    $error['status'] = 2;
                    echo json_encode($error);; //返回给端口状态码
                    return;
                }
            }
             
            /**---处理手续费结束*/
            
            
            /**---处理扣除提货权开始*/
            
            $user_total_m = $M_credit+$charge_cash; //用户现金充值提货权后，剩余总提货权
            $user_M_credit = $order_total_price - $charge_cash; //充值金额减去订单金额，剩余需要用户支付的提货权是多少。
            
            $charge_cash_row = true;
            
            if($user_M_credit != 0){ //判断是混合支付，还是全款微信
                //减去用户需支付提货权
            
                //混合支付做多个判断。
                //判断可用余额是否足够减去 订单
                if( ($pay_detailed['credit']+$user_total_m) >= $order_total_price ){
                    $charge_cash_row = $this->pay_account->update_M_creadit($pay_detailed['id'],$user_M_credit);
                     
                }else{
                    $this->db->trans_rollback();//回滚。
                    //充值的金额+上提货权不足以扣除此订单的金额，让C端或者B端调用充值的方法吧。
                    $error['status'] = 2; //返回给端口状态码
                    echo json_encode($error);
                    return;
                }
            }
            
            /**---处理扣除提货权结束*/
            
            if( $commission_row && $charge_cash_row )
            {
                if( $charge_cash > 0 )
                { //说明if中都是执行 订单和手续费的充值支付。
                        
                        
                    //构造现金充值提货权订单数据
                    $this->load->helper('order');
                    $data ['customer_id'] = $customer_id;
                    $data ['amount'] = $charge_cash;
                    $this->load->model('customer_currency_log_mdl','customer_currency_log');
                     
                    do {
                         
                        $data ['charge_no'] = get_order_sn ();
                        if ($this->customer_currency_log->check_charge_sn ( $data ['charge_no'] ) ) {
                            $order_exist = true;
                        } else {
                            $currency_order = $this->customer_currency_log->create_charge_currency( $data );
                            $order_exist = false;
                        }
                    } while ( $order_exist ); // 如果是订单号重复则重新提交数据
                
                    if( $currency_order )
                    {
                        //写用户现金支出.
                        $user_cash_expend['relation_id'] = $pay_relation_id;
                        $user_cash_expend['id_event'] = '66';
                        $user_cash_expend['remark'] = '现金充值提货权';
                        $user_cash_expend['cash'] = $charge_cash;
                        $user_cash_expend['charge_no'] = $data ['charge_no'];
                        $user_cash_expend['beginning_balance'] = $total_cash - $commission;
                        $user_cash_expend['ending_balance'] = $user_cash_expend['beginning_balance'] - $charge_cash;
                        $user_cash_expend['status'] = '1';
                        $user_cash_expend['type'] = '2';
                        $user_cash_expend['customer_id'] = '-1';
                        $user_cash_expend['app_id'] = $app_id;
                        //写入现金日志（支出）
                        
                        
                        $user_cash_log = $this->customer_money_log->add_log($user_cash_expend);
                         
                        if($user_cash_log){
                             
                            //上一次平台交易的日志
                            $platform_last_cash_log = $this->customer_money_log->load_create_desc('-1');
                             
                            //写平台现金收入。
                            $platform_cash_income['relation_id'] = '-1';
                            $platform_cash_income['id_event'] = '66';
                            $platform_cash_income['cash'] = $charge_cash;
                            $platform_cash_income['charge_no'] = $data ['charge_no'];
                            $platform_cash_income['type'] = '1';
                            $platform_cash_income['status'] = '1';
                            $platform_cash_income['remark'] = '平台收入-充值提货权';
                            $platform_cash_income['beginning_balance'] = !empty( $platform_last_cash_log['ending_balance'] ) ? $platform_last_cash_log['ending_balance'] : '0.00';
                            $platform_cash_income['ending_balance'] = $platform_cash_income['beginning_balance']+$charge_cash;
                            $platform_cash_income['customer_id'] = $customer_id;
                            $platform_cash_income['app_id'] = $app_id;
                            //写入现金日志（收入）
                            $platform_cash_log = $this->customer_money_log->add_log($platform_cash_income);
                            
                            if($platform_cash_log)
                            { 
                                //写平台提货权减去，用户M卷加
                                	  
                                	  
                                //上一次平台提货权交易的日志中的信息
                                $platform_last_m_log  = $this->customer_currency_log->load_last('-1');
                                 
                                 
                                //提货权日志 -平台支出提货权
                                $platform_m_expend['relation_id'] = '-1';
                                $platform_m_expend['id_event'] = '66';
                                $platform_m_expend['type'] = '2';
                                $platform_m_expend['status'] = '1';
                                $platform_m_expend['remark'] = '平台支出-充值提货权';
                                $platform_m_expend['amount'] = $charge_cash;
                                $platform_m_expend['order_no'] = $data['charge_no'];
                                $platform_m_expend['beginning_balance'] = !empty($platform_last_m_log['ending_balance']) ? $platform_last_m_log['ending_balance'] : '0.00';;
                                $platform_m_expend['ending_balance'] = $platform_m_expend['beginning_balance']-$charge_cash;
                                $platform_m_expend['customer_id'] = $customer_id;
                                $platform_m_expend['app_id'] = $app_id;
                                //平台提货权支出
                                $platform_m_log = $this->customer_currency_log->add_log($platform_m_expend);
                                
                                if($platform_m_log)
                                { 
                                    //上一次提货权交易的日志中的信息
                                    $user_last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
                                     
                                    //提货权日志 -用户收入提货权日志
                                    if( isset($user_last_m_log['ending_balance']) &&  $user_last_m_log['ending_balance'] == $M_credit){  //检测提货权是否异常
                                        $user_m_income['status'] = '1';
                                    }else if(!$user_last_m_log && $M_credit =='0'){
                                        $user_m_income['status'] = '1';
                                    }else{
                                        $user_m_income['status'] = '2';
                                    }
                                    $user_m_income['id_event'] = '66';
                                    $user_m_income['relation_id'] = $pay_relation_id;
                                    $user_m_income['type'] = '1';
                                    $user_m_income['amount'] = $charge_cash;
                                    $user_m_income['remark'] = '现金充值提货权到账';
                                    $user_m_income['order_no'] = $data['charge_no'];
                                    $user_m_income['beginning_balance'] = $M_credit;
                                    $user_m_income['ending_balance'] = $M_credit+$charge_cash;
                                    $user_m_income['customer_id'] = '-1';
                                    $user_m_income['app_id'] = $app_id;
                                    //写入提货权日志
                                    $user_m_log = $this->customer_currency_log->add_log($user_m_income);
                                    
                                    if($user_m_log)
                                    { 
        
        
                                        //处理交易提货权日志 ，用户支出提货权日志，平台收入提货权日志，更改订单状态
                                         
                                        //用户购物支出提货权日志
                                        $user_m_expend['relation_id'] = $pay_relation_id;
                                         
                                        $user_m_expend['id_event'] = '60';
                                        $user_m_expend['type'] = '2';
                                        $user_m_expend['status'] = '1';
                                        $user_m_expend['remark'] = '面对面-购物支出';
                                        $user_m_expend['amount'] = $order_total_price;
                                        $user_m_expend['order_no'] = $order_sn;
                                        $user_m_expend['beginning_balance'] = $M_credit+$charge_cash;
                                        $user_m_expend['ending_balance'] = $M_credit-$user_M_credit;
                                        $user_m_expend['customer_id'] = $corp_customer_id;
                                        $user_m_expend['app_id'] = $app_id;
                                        //用户支出提货权日志
                                        $user_m_log = $this->customer_currency_log->add_log($user_m_expend);
                                         
                                        if($user_m_log){
                                            
                                            //读取收款账户信息
                                            $pay_info = $this->pay_account->load( $corp_customer_id );
                                            
                                            //上一次店主提货权交易的日志中的信息
                                            $corp_last_m_log = $this->customer_currency_log->load_last($pay_info['r_id']);
                                            
                                            //收入检测提货权是否异常
                                            if( isset($corp_last_m_log['ending_balance']) &&  $corp_last_m_log['ending_balance'] == $pay_info['M_credit'])
                                            {
                                                $M_corp_credit_data['status'] = '1';
                                            }else if(!$corp_last_m_log && $pay_info['M_credit'] =='0'){
                                                $M_corp_credit_data['status'] = '1';
                                            }else{
                                                $M_corp_credit_data['status'] = '2';
                                            }
                                             
                                           
                                            //店主收入提货权日志
                                            $M_corp_credit_data['relation_id'] = $pay_info['r_id'];
                                            $M_corp_credit_data['id_event'] = '62';
                                            $M_corp_credit_data['remark'] = '面对面-销售收入';
                                            $M_corp_credit_data['type'] = '1';
                                            $M_corp_credit_data['amount'] = $order_total_price;
                                            $M_corp_credit_data['order_no'] = $order_sn;
                                            $M_corp_credit_data['beginning_balance'] = $pay_info['M_credit'];
                                            $M_corp_credit_data['ending_balance'] = $pay_info['M_credit']+$order_total_price;
                                            $M_corp_credit_data['customer_id'] = $customer_id;
                                            $M_corp_credit_data['app_id'] = $app_id;
                                            
                                            //收入出方提货权日志
                                            $to_M_credit_log = $this->customer_currency_log->add_log($M_corp_credit_data);
                                            
                                            
                                            if($M_corp_credit_data){
                                                
                                                $C_commission_row = true;
                                                
                                                //一定是C端才会进这一段
                                                if( $C_commission > 0 )
                                                {
                                                    //店主收钱之前要把手续费扣出来分成。
                                                    $order_total_price = $order_total_price - $C_commission;
                                                    
                                                    //调用C端扣除手续费方法
                                                    $corp_M = $M_corp_credit_data['ending_balance'];
                                                    $platform_M = $platform_m_expend['ending_balance'];
                                                    
                                                    $C_commission_row = $this->C_order_commission($pay_info['r_id'],$order_sn,$app_id,$C_commission,$corp_M,$platform_M,$corp_customer_id);
                                                
                                                }
                                                
                                                if( $C_commission_row )
                                                { 
                                                    //店主账号+提货权
                                                    $up_row = $this->pay_account->charge_M_credit($pay_info['id'], $order_total_price );
                                                    
                                                    if( $up_row )
                                                    {
                                                        $this->db->trans_commit();
                                                        $error['status'] = 1;
                                                    }    
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                }else{ 
                    
                    //C 端不会进这里。
                    
                    //处理交易提货权日志 ，用户支出提货权日志，平台收入提货权日志，更改订单状态

                    $this->load->model('customer_currency_log_mdl','customer_currency_log');
                    //用户购物支出提货权日志
                    $user_m_expend['relation_id'] = $pay_relation_id;
                     
                    $user_m_expend['id_event'] = '60';
                    $user_m_expend['type'] = '2';
                    $user_m_expend['status'] = '1';
                    $user_m_expend['remark'] = '面对面-购物支出';
                    $user_m_expend['amount'] = $order_total_price;
                    $user_m_expend['order_no'] = $order_sn;
                    $user_m_expend['beginning_balance'] = $M_credit+$charge_cash;
                    $user_m_expend['ending_balance'] = $M_credit-$user_M_credit;
                    $user_m_expend['customer_id'] = $corp_customer_id;
                    $user_m_expend['app_id'] = $app_id;
                    //用户支出提货权日志
                    $user_m_log = $this->customer_currency_log->add_log($user_m_expend);
                     
                    if($user_m_log){
                    
                        //读取收款账户信息
                        $pay_info = $this->pay_account->load( $corp_customer_id );
                    
                        //上一次店主提货权交易的日志中的信息
                        $corp_last_m_log = $this->customer_currency_log->load_last($pay_info['r_id']);
                    
                        //收入检测提货权是否异常
                        if( isset($corp_last_m_log['ending_balance']) &&  $corp_last_m_log['ending_balance'] == $pay_info['M_credit'])
                        {
                            $M_corp_credit_data['status'] = '1';
                        }else if(!$corp_last_m_log && $pay_info['M_credit'] =='0'){
                            $M_corp_credit_data['status'] = '1';
                        }else{
                            $M_corp_credit_data['status'] = '2';
                        }
                         
                        //店主收入提货权日志
                        $M_corp_credit_data['relation_id'] = $pay_info['r_id'];
                        $M_corp_credit_data['id_event'] = '62';
                        $M_corp_credit_data['remark'] = '面对面-销售收入';
                        $M_corp_credit_data['type'] = '1';
                        $M_corp_credit_data['amount'] = $order_total_price;
                        $M_corp_credit_data['order_no'] = $order_sn;
                        $M_corp_credit_data['beginning_balance'] = $pay_info['M_credit'];
                        $M_corp_credit_data['ending_balance'] = $pay_info['M_credit']+$order_total_price;
                        $M_corp_credit_data['customer_id'] = $customer_id;
                        $M_corp_credit_data['app_id'] = $app_id;
                    
                        //收入出方提货权日志
                        $to_M_credit_log = $this->customer_currency_log->add_log($M_corp_credit_data);
                    
                         
                        if($M_corp_credit_data){
                            //店主账号+提货权
                            $up_row = $this->pay_account->charge_M_credit($pay_info['id'], $order_total_price );
                    
                            if( $up_row )
                            {
                                $this->db->trans_commit();
                                $error['status'] = 1;
                            }
                        }
                    }
                }
            }
        }
        
        if( empty($error['status']) )
        {
            $this->db->trans_rollback();
        }
        
        
        echo json_encode($error);
    }	
    
    public function all_order_pay()
    { 
        //二维数组
        $order_info = $this->input->post('order_info');
        
        $customer_id = $this->input->post('customer_id');//用户ID
        $order_total_price = $this->input->post('total_price');//订单总额
        $charge_cash = $this->input->post('charge_cash');//此次充值的金额
        $chargeno   = $this->input->post('charge_no');
        $app_id = $order_info[0]['app_id'];
        
        $this->load->model('Pay_account_mdl','pay_account');
        
        //查询该用户的支付账号
        $pay_detailed = $this->pay_account->load($customer_id);
        
        $pay_id = $pay_detailed['id']; //该用户的支付账号的ID
        $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
        $cash = $pay_detailed['cash']; //充值前的现金余额
        $M_credit = $pay_detailed['M_credit'];//充值前提货权余额
        
        $time = date('Y-m-d H:i:s');
        
        if( $pay_detailed ){
            if(! ($pay_detailed['credit_start_time'] <= $time && $pay_detailed['credit_end_time'] >= $time) ){
                $pay_detailed['credit'] = '0.00';
            }
        }
        
        //充值成功后帮用户添加现金余额;
        $total_cash = $cash+$charge_cash;//充值后的现金余额
     
         
        $this->db->trans_begin(); //事物执行方法中的MODEL。
        $error['status'] = false;
         
        $user_total_m = $M_credit+$charge_cash; //用户现金充值提货权后，剩余总提货权
        $user_M_credit = $order_total_price - $charge_cash; //充值金额减去订单金额，剩余需要用户支付的提货权是多少。
        
        $charge_cash_row = true;
        
        if($user_M_credit != 0){ //判断是混合支付，还是全款微信
            //减去用户需支付提货权
        
            //混合支付做多个判断。
            //判断可用余额是否足够减去 订单
            if( ($pay_detailed['credit']+$user_total_m) >= $order_total_price ){
                $charge_cash_row = $this->pay_account->update_M_creadit($pay_detailed['id'],$user_M_credit);
                 
            }else{
                $this->db->trans_rollback();//回滚。
                //充值的金额+上提货权不足以扣除此订单的金额，让C端或者B端调用充值的方法吧。
                $error['status'] = 2; //返回给端口状态码
                echo json_encode($error);
                return;
            }
        }
        
        
        if( $charge_cash_row )
        { 
            //----现金日志收入操作开始<
            $this->load->model("customer_money_log_mdl",'customer_money_log');
            $last_user_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);//上一次用户现金交易的日志
             
            //检测现金是否异常
            if( isset($last_user_cash_log['ending_balance']) &&  $last_user_cash_log['ending_balance'] == $cash){
                $user_cash_income['status'] = '1';
            }else if(!$last_user_cash_log && $cash =='0'){
                $user_cash_income['status'] = '1';
            }else{
                $user_cash_income['status'] = '2';
            }
             
            $user_cash_income['relation_id'] = $pay_relation_id;
            $user_cash_income['id_event'] = '68';
            $user_cash_income['remark'] = '现金充值到账';
            $user_cash_income['cash'] = $charge_cash;
            $user_cash_income['charge_no'] = $chargeno;
            $user_cash_income['beginning_balance'] = $cash;
            $user_cash_income['ending_balance'] = $total_cash;
            $user_cash_income['status'] = '1';
            $user_cash_income['type'] = '1';
            $user_cash_income['app_id'] = $app_id;
            $user_cash_income['customer_id'] = '-1';
            //写入现金收入日志
            $user_cash_log = $this->customer_money_log->add_log($user_cash_income);
            
            if( $user_cash_log )
            {
                //构造现金充值提货权订单数据
                $this->load->helper('order');
                $data ['customer_id'] = $customer_id;
                $data ['amount'] = $charge_cash;
                $this->load->model('customer_currency_log_mdl','customer_currency_log');
                 
                do {
                     
                    $data ['charge_no'] = get_order_sn ();
                    if ($this->customer_currency_log->check_charge_sn ( $data ['charge_no'] ) ) {
                        $order_exist = true;
                    } else {
                        $currency_order = $this->customer_currency_log->create_charge_currency( $data );
                        $order_exist = false;
                    }
                } while ( $order_exist ); // 如果是订单号重复则重新提交数据
            
                if( $currency_order )
                {
                    //写用户现金支出.
                    $user_cash_expend['relation_id'] = $pay_relation_id;
                    $user_cash_expend['id_event'] = '66';
                    $user_cash_expend['remark'] = '现金充值提货权';
                    $user_cash_expend['cash'] = $charge_cash;
                    $user_cash_expend['charge_no'] = $data ['charge_no'];
                    $user_cash_expend['beginning_balance'] = $total_cash;
                    $user_cash_expend['ending_balance'] = $cash;
                    $user_cash_expend['status'] = '1';
                    $user_cash_expend['type'] = '2';
                    $user_cash_expend['customer_id'] = '-1';
                    $user_cash_expend['app_id'] = $app_id;
                    //写入现金日志（支出）
                    $user_cash_log = $this->customer_money_log->add_log($user_cash_expend);
                     
                    if($user_cash_log){
                         
                        //上一次平台交易的日志
                        $platform_last_cash_log = $this->customer_money_log->load_create_desc('-1');
                         
                        //写平台现金收入。
                        $platform_cash_income['relation_id'] = '-1';
                        $platform_cash_income['id_event'] = '66';
                        $platform_cash_income['cash'] = $charge_cash;
                        $platform_cash_income['charge_no'] = $data ['charge_no'];
                        $platform_cash_income['type'] = '1';
                        $platform_cash_income['status'] = '1';
                        $platform_cash_income['remark'] = '平台收入-充值提货权';
                        $platform_cash_income['beginning_balance'] = !empty( $platform_last_cash_log['ending_balance'] ) ? $platform_last_cash_log['ending_balance'] : '0.00';
                        $platform_cash_income['ending_balance'] = $platform_cash_income['beginning_balance']+$charge_cash;
                        $platform_cash_income['customer_id'] = $customer_id;
                        $platform_cash_income['app_id'] = $app_id;
                        //写入现金日志（收入）
                        $platform_cash_log = $this->customer_money_log->add_log($platform_cash_income);
                        
                        
                        if( $platform_cash_log )
                        { 

                            //写平台提货权减去，用户M卷加
                            	  
                            	  
                            //上一次平台提货权交易的日志中的信息
                            $platform_last_m_log  = $this->customer_currency_log->load_last('-1');
                             
                             
                            //提货权日志 -平台支出提货权
                            $platform_m_expend['relation_id'] = '-1';
                            $platform_m_expend['id_event'] = '66';
                            $platform_m_expend['type'] = '2';
                            $platform_m_expend['status'] = '1';
                            $platform_m_expend['remark'] = '平台支出-充值提货权';
                            $platform_m_expend['amount'] = $charge_cash;
                            $platform_m_expend['order_no'] = $data['charge_no'];
                            $platform_m_expend['beginning_balance'] = !empty($platform_last_m_log['ending_balance']) ? $platform_last_m_log['ending_balance'] : '0.00';;
                            $platform_m_expend['ending_balance'] = $platform_m_expend['beginning_balance']-$charge_cash;
                            $platform_m_expend['customer_id'] = $customer_id;
                            $platform_m_expend['app_id'] = $app_id;
                            //平台提货权支出
                            $platform_m_log = $this->customer_currency_log->add_log($platform_m_expend);
                             
                            if($platform_m_log){
                                 
                                //上一次提货权交易的日志中的信息
                                $user_last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
                                 
                                //提货权日志 -用户收入提货权日志
                                if( isset($user_last_m_log['ending_balance']) &&  $user_last_m_log['ending_balance'] == $M_credit){  //检测提货权是否异常
                                    $user_m_income['status'] = '1';
                                }else if(!$user_last_m_log && $M_credit =='0'){
                                    $user_m_income['status'] = '1';
                                }else{
                                    $user_m_income['status'] = '2';
                                }
                                $user_m_income['id_event'] = '66';
                                $user_m_income['relation_id'] = $pay_relation_id;
                                $user_m_income['type'] = '1';
                                $user_m_income['amount'] = $charge_cash;
                                $user_m_income['remark'] = '现金充值提货权到账';
                                $user_m_income['order_no'] = $data['charge_no'];
                                $user_m_income['beginning_balance'] = $M_credit;
                                $user_m_income['ending_balance'] = $M_credit+$charge_cash;
                                $user_m_income['customer_id'] = '-1';
                                $user_m_income['app_id'] = $app_id;
                                //写入提货权日志
                                $user_m_log = $this->customer_currency_log->add_log($user_m_income);
                                 
                                if($user_m_log){
                                    
                                    //用户的
                                    $M_expend_beg = $M_credit+$charge_cash;
                                    $M_expend_end = 0;
                                    
                                    //平台的
                                    $M_income_beg = isset($platform_m_expend['ending_balance']) ? $platform_m_expend['ending_balance'] : '0.00';
                                    $M_income_end = 0;
                                    
                                    $i = 0;
                                    
                                    foreach ( $order_info as $v ){ 
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
                                            $M_income_end = isset($platform_m_expend['ending_balance']) ? $platform_m_expend['ending_balance']+$order_total_price: $order_total_price ;
                                        
                                        }else{
                                        
                                            //用户的
                                            $M_expend_beg = $M_expend_end;
                                            $M_expend_end = $M_expend_end - $order_total_price;
                                        
                                            //平台的
                                            $M_income_beg = $M_income_end;
                                            $M_income_end = $M_income_end + $order_total_price;
                                        }
                                        
                                        //用户购物支出提货权日志
                                        $user_m_expend['relation_id'] = $pay_relation_id;
                                         
                                        $user_m_expend['id_event'] = '60';
                                        $user_m_expend['type'] = '2';
                                        $user_m_expend['status'] = '1';
                                        $user_m_expend['remark'] = '购物支出';
                                        $user_m_expend['amount'] = $order_total_price;
                                        $user_m_expend['order_no'] = $order_sn;
                                        $user_m_expend['beginning_balance'] = $M_expend_beg;
                                        $user_m_expend['ending_balance'] = $M_expend_end;
                                        $user_m_expend['customer_id'] = $corp_customer_id;
                                        $user_m_expend['app_id'] = $app_id;
                                        //用户支出提货权日志
                                        $user_m_log = $this->customer_currency_log->add_log($user_m_expend);
                                         
                                        if($user_m_log){
                                             
                                            //提货权日志 -平台收入提货权
                                            $platform_m_income['relation_id'] = '-1';
                                            $platform_m_income['id_event'] = '60';
                                            $platform_m_income['type'] = '1';
                                            $platform_m_income['status'] = '1';
                                            $platform_m_income['remark'] = '平台收入';
                                            $platform_m_income['amount'] = $order_total_price;
                                            $platform_m_income['order_no'] = $order_sn;
                                            $platform_m_income['beginning_balance'] = $M_income_beg;
                                            $platform_m_income['ending_balance'] = $M_income_end;
                                            $platform_m_income['customer_id'] = $customer_id;
                                            $platform_m_income['app_id'] = $app_id;
                                            //用户提货权日志
                                            $platform_m_log = $this->customer_currency_log->add_log($platform_m_income);
                                             
                                            if(!$platform_m_log){
                                                
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
                                    echo json_encode($error);
                                    exit();
                                }
                            }
                        }
                    }
                }
            }
            
            $this->db->trans_rollback();
            $error['status'] = 'fail';
            echo json_encode($error);
            exit();
        }
    }
    
    
    
    /**
     * B端手续费新流程
     * @array $pay_detailed = 支付账户信息
     * $order_sn = 订单ID
     * $pay_account_id = 支付ID
     * $app_id = 地区ID
     * $commission = 手续费金额
     * $charge_commission = 此次充值的手续费
     * $total_cash = 现金余额+总充值
     */
    private function order_commission( $pay_detailed, $order_sn, $app_id, $commission, $charge_commission, $total_cash )
    {
        $cash = $pay_detailed['cash'];
        $relation_id = $pay_detailed['r_id'];
        
        //加上充值手续费还需扣除多少手续费
        $order_commission =  $commission  - $charge_commission;
        $update_cash = true;
        
        if( $order_commission > 0)
        {
            $update_cash = $this->pay_account->update_cash($pay_detailed['id'], $order_commission);
           
        }
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
            $cash_data['beginning_balance'] = $total_cash;
            $cash_data['ending_balance'] = $total_cash - $commission;
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
     * C端手续费扣店主的  -- 面对面支付才用这个了，一般流程是收货扣店主手续费
     * @$pay_r_id = 支付账户关联表ID
     * $order_sn = 订单号
     * $app_id = 地区ID
     * $C_commission = 手续费金额
     * $corp_M = 扣除手续费钱的提货权（用户）
     * $platform_M = 收取手续费前的提货权（平台）
     * $corp_customer_id 支出手续费的用户ID。
     */
    private function C_order_commission( $pay_r_id, $order_sn, $app_id, $C_commission, $corp_M, $platform_M,$corp_customer_id)
    {
    
        //店主支出提货权手续费
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
        
        //店主支出提货权手续费日志
        $M_corp_commission_log = $this->customer_currency_log->add_log($M_corp_commission);
        
        
        if( $M_corp_commission_log )
        { 
            //平台收入提货权手续费
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
            
            //平台收入提货权手续费日志
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