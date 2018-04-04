<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * @author Fxm  
 * @拼团的接口
 */
class Groupbuy extends Account_Controller {
	


	public function __construct()
	{
	    
		parent::__construct();
		
	}

	
    /**（处理退款+写日志） 
	 */
	function refund()
	{
	 
	    $this->load->model('pay_account_mdl');
	    $order_info = $this->input->post('order_info');
	    
	    // 开启事物
	    $this->db->trans_begin();
	    
	    // 事物执行方法中的MODEL。
	    if (count($order_info) > 0) {
	        
	        foreach ($order_info as $v) {
	            
	            // 处理已经付款过的订单
                $customer_pay = $this->pay_account_mdl->load($v['customer_id']); // 获取订单用户的支付账号信息

                $up_row = $this->pay_account_mdl->charge_M_credit( $customer_pay['id'], $v['total_price'] ); // 退款给用户

                if( $up_row ){
                 
                    $this->load->model('customer_currency_log_mdl','customer_currency_log');
                    // 上一次平台的货豆交易日志
                    $to_last_m_log = $this->customer_currency_log->load_last('-1');
    
                    // 平台支出货豆日志
                    $M_credit_data['relation_id'] = '-1';
                    $M_credit_data['id_event'] = '64';
                    $M_credit_data['remark'] = '平台支出-退款';
                    $M_credit_data['type'] = '2';
                    $M_credit_data['amount'] = $v['total_price'];
                    $M_credit_data['order_no'] = $v['order_sn'];
                    $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
                    $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] - $v['total_price'] : - $v['total_price'];
                    $M_credit_data['customer_id'] = $v['customer_id'];
                    $M_credit_data['status'] = '1';
                    $M_credit_data['app_id'] = $v['app_id'];
                    $M_credit_data['created_at'] = date('Y-m-d H:i:s');
    
                    // 支出方货豆日志
                    $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
                    
                    if ($to_M_credit_log){
                       
                        // 上一次客户货豆交易的日志中的信息
                        $last_m_log = $this->customer_currency_log->load_last($customer_pay['r_id']);
        
                        // 用户接收退款货豆日志
                        $customer_credit_data['relation_id'] = $customer_pay['r_id'];
                        $customer_credit_data['id_event'] = '63';
                        $customer_credit_data['remark'] = '接收退款';
                        $customer_credit_data['type'] = '1';
                        $customer_credit_data['amount'] = $v['total_price'];
                        $customer_credit_data['order_no'] = $v['order_sn'];
                        $customer_credit_data['beginning_balance'] = $customer_pay['M_credit'];
                        $customer_credit_data['ending_balance'] = $customer_pay['M_credit'] + $v['total_price'];
                        $customer_credit_data['customer_id'] = $v['customer_id'];
                        $customer_credit_data['created_at'] = date('Y-m-d H:i:s');
                        $customer_credit_data['app_id'] = $v['app_id'];
                        $customer_credit_data['status'] = !empty($last_m_log['ending_balance']) && $last_m_log['ending_balance'] == $customer_pay['M_credit'] ? 1 : 2; // 批量插入无法验证是否异常，只能用正常表示
                        $customer_credit_log = $this->customer_currency_log->add_log($customer_credit_data);
                        
                        if(!$customer_credit_log)
                        { 
                            $error['status'] = 'fail';
                            $this->db->trans_rollback(); // 事物回滚
                            echo json_encode($error);
                            exit();
                        }
                    }
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
