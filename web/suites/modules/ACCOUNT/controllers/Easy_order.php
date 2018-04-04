<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

    // ------------------------------------------------------------------------

/**
 * 接口订单类
 *
 */
class Easy_order extends Account_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 简易店订单的支付
     */
    public function pay_order(){

        //--接收数据
        $corp_customer_id = $this->input->post('corp_customer_id');//收款方的用户ID
        $total_price = $this->input->post('total_price');
        $order_sn = $this->input->post('order_sn');
        $app_id = $this->input->post('app_id');
        $customer_id = $this->input->post('customer_id');

        //支付账户信息
        $this->load->model('pay_account_mdl');
        $pay_info = $this->pay_account_mdl->load( $customer_id );
        $cash = $pay_info['cash'];
        $relation_id = $pay_info['r_id'];
        
        $error['status']  = false;
        $this->db->trans_begin(); //事物执行方法中的MODEL。
        $process = true; //表示进了事物。

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
        $cash_data['remark'] = '现金充值到账';
        $cash_data['cash'] = $total_price;
        $cash_data['charge_no'] = $order_sn;
        $cash_data['beginning_balance'] = $cash;
        $cash_data['ending_balance'] = $cash-$total;
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
	        $cash_data['remark'] = '平台收入-现金充值';
	        $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
	        $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance']+$total_price:$total_price;
	        $cash_data['customer_id'] = $customer_id;
	        //写入现金日志
	        $to_cash_log = $this->customer_money_log->add_log($cash_data);
        }

        if( $to_cash_log )
        {
            $this->db->trans_commit(); //处理成功
            $error['status']  = true;
        }

        if( empty($is_ok)  && !empty($process) )
            $this->db->trans_rollback();
        
        echo json_encode($error);
    }
    

    /**
     * 简易店订单的确认收货
     */
    public function receive(){
        //--接收数据
        $corp_customer_id = $this->input->post('corp_customer_id');//收款方的用户ID
        $total_price = $this->input->post('total_price');
        $order_sn = $this->input->post('order_sn');
        $app_id = $this->input->post('app_id');
        $customer_id = $this->input->post('customer_id');

        //收款账户信息
        $this->load->model('pay_account_mdl');
        $pay_info = $this->pay_account_mdl->load( $corp_customer_id );
        $cash = $pay_info['cash'];
        $relation_id = $pay_info['r_id'];
        
        $error['status']  = false;
        $this->db->trans_begin(); //事物执行方法中的MODEL。
        $process = true; //表示进了事物。

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
        //现金收入日志
        $cash_data['relation_id'] = $relation_id;
        $cash_data['id_event'] = '76';
        $cash_data['type'] = '2';
        $cash_data['remark'] = '现金充值到账';
        $cash_data['cash'] = $total_price;
        $cash_data['charge_no'] = $order_sn;
        $cash_data['beginning_balance'] = $cash;
        $cash_data['ending_balance'] = $cash+$total_price;
        $cash_data['customer_id'] = '-1';
        $cash_data['app_id'] = $app_id;
	        
        //写入现金日志
        $cash_log = $this->customer_money_log->add_log($cash_data);

        if($cash_log)
        {
	        //上一次平台现金交易的日志中的信息
	        $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
	        //平台现金支出日志
	        $cash_data['relation_id'] = '-1';
	        $cash_data['type'] = '1';
	        $cash_data['status'] = '1';
	        $cash_data['remark'] = '平台收入-现金充值';
	        $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
	        $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance']-$total_price:-$total_price;
	        $cash_data['customer_id'] = $corp_customer_id;
	        //写入现金日志
	        $to_cash_log = $this->customer_money_log->add_log($cash_data);
        }

        // 收款方现金收入
        $to_cash = $this->pay_account_mdl->charge_cash($pay_info['id'], $total_price);

        if( $to_cash_log && $to_cash)
        {
            $this->db->trans_commit(); //处理成功
            $error['status']  = true;
        }

        if( empty($is_ok)  && !empty($process) )
            $this->db->trans_rollback();
        
        echo json_encode($error);    	
    }


}

?>