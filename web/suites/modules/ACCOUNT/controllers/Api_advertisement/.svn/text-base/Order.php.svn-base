<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

    // ------------------------------------------------------------------------

/**
 * B-C端的广告接口-调用数据
 *
 */
class Order extends Account_Controller
{

    
    public function __construct()
    {
        parent::__construct();
       
    }
   
    //---------------------------------------------------------------------------------------------------
    
   
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 发布广告扣除货豆
     */
    public function transaction()
    { 
        
        $customer_id = $this->input->post('customer_id');
        $corp_customer_id = $this->input->post('corp_customer_id');
        $total_price = $this->input->post('total_price');
        $order_sn = $this->input->post('order_sn');
        $expend_remark = $this->input->post('expend_remark'); //支出备注
        $income_remark = $this->input->post('income_remark'); //收入备注
        $id_event = $this->input->post('id_event');
        $return ['status'] = 0;
        $result ['message'] = '支付失败';
        
        //开启事物
        $this->db->trans_begin();
        
        //支付方账户
        $time = date('Y-m-d H:i:s');
        $this->load->model('pay_account_mdl');
        $customer_pay = $this->pay_account_mdl->load( $customer_id );
        
        if ($customer_pay) 
        {
            if (! ($customer_pay['credit_start_time'] <= $time && $customer_pay['credit_end_time'] >= $time)) 
            {
                $customer_pay['credit'] = '0.00';
            }
        }
        
        //----支出方一系列操作
        
        //支出方最后一次日志
        $this->load->model("customer_currency_log_mdl",'customer_currency_log');
        $last_m_log    = $this->customer_currency_log->load_last($customer_pay['r_id']);
        
        //检测货豆是否异常
        if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $customer_pay['M_credit']){
            $M_credit_data['status'] = '1';
        }else if(!$last_m_log && $customer_pay['M_credit'] =='0'){
            $M_credit_data['status'] = '1';
        }else{
            $M_credit_data['status'] = '2';
        }
        
        //货豆日志
        $M_credit_data['relation_id'] = $customer_pay['r_id'];
        $M_credit_data['id_event'] = $id_event;
        $M_credit_data['remark'] = $expend_remark;
        $M_credit_data['amount'] = $total_price;
        $M_credit_data['order_no'] = $order_sn;
        $M_credit_data['type'] = '2';
        $M_credit_data['beginning_balance'] = $customer_pay['M_credit'];
        $M_credit_data['ending_balance'] = $customer_pay['M_credit']-$total_price;
        $M_credit_data['customer_id'] = $corp_customer_id;
        $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
        
        //将支付方的金额减去
        $row = $this->pay_account_mdl->update_M_creadit($customer_pay['id'], $total_price);
        
        //----支出方一系列操作结束
        
        //如果支出方操作成功
        if($M_credit_log && $row) {
        
            //----收入方一系列操作
        
            //收入方账户
            $corp_customer_pay = $this->pay_account_mdl->load( $corp_customer_id );
            //收入方最后一次日志
            $to_last_m_log    = $this->customer_currency_log->load_last($corp_customer_pay['r_id']);
        
            //检测货豆是否异常
            if( isset($to_last_m_log['ending_balance']) &&  $to_last_m_log['ending_balance'] == $corp_customer_pay['M_credit']){
                $M_credit_data_to['status'] = '1';
            }else if(!$to_last_m_log && $corp_customer_pay['M_credit'] =='0'){
                $M_credit_data_to['status'] = '1';
            }else{
                $M_credit_data_to['status'] = '2';
            }
        
            //收入方货豆日志
            $M_credit_data_to['relation_id'] = $corp_customer_pay['r_id'];
            $M_credit_data_to['id_event'] = $id_event;
            $M_credit_data_to['remark'] = $income_remark;
            $M_credit_data_to['amount'] = $total_price;
            $M_credit_data_to['order_no'] = $order_sn;
            $M_credit_data_to['type'] = '1';
            $M_credit_data_to['beginning_balance'] = $corp_customer_pay['M_credit'];
            $M_credit_data_to['ending_balance'] = $corp_customer_pay['M_credit']+$total_price;
            $M_credit_data_to['customer_id'] = $customer_id;
            $M_credit_to_log = $this->customer_currency_log->add_log($M_credit_data_to);
        
            //收入方账户+货豆
            $up_row = $this->pay_account_mdl->charge_M_credit($corp_customer_pay['id'], $total_price );
            //----收入方一系列操作结束
        
            if($M_credit_to_log && $up_row){
                $commit = true;
                $this->db->trans_commit(); //提交事物
                $return ['status'] = 1;
                $result ['message'] = '支付成功';
            }
        }
        
        
        if( empty( $commit ) )
        { 
            $this->db->trans_rollback(); //事物回滚
            
        }
        
        echo json_encode($return);
    }
    
    
  
}
   
?>