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
        }else if( !$last_cash_log && $cash =='0'){
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
     * 简易店收货。
     * @date:2018年4月4日 上午11:49:06
     * @author: fxm
     * @param: post order_info 订单信息，二维数组（通用）
     * @return: json
     */
    public function receive(){
        
        $return['message'] = '处理失败';
        $return['status'] = '';
        
        //--接收数据
        $order_list = $this->input->post('order_list');
       
        if( !$order_list )
        { 
            $return['message'] = '无订单';
            echo json_encode($return);
            exit();
        }
        
         //事物执行方法中的MODEL。
        $this->db->trans_begin(); 
        
        $this->load->model('pay_account_mdl');
        $this->load->model('customer_money_log_mdl','customer_money_log');
        
        //上一次现金交易的日志中的信息
        $last_cash_log = $this->customer_money_log->load_create_desc('-1');//现金日志
        
        $cash_income_beg = isset($last_cash_log['ending_balance']) ? $last_cash_log['ending_balance'] : 0;
        $cash_income_end = 0;
        $i = 0;
        
        //查询卖家的支付账户->写日志平台支出日志->写卖家收入日志->卖家账户（没有则跳过）+金额->完成）
        foreach ( $order_list as $k=>$v )
        { 
            $corp_customer_id = $v['corp_customer_id'];
            $pay_info = $this->pay_account_mdl->load( $corp_customer_id );
           
            if( empty( $v['corp_customer_id'] ) || empty( $v['total_price'] ) || empty( $v['order_sn'] ) )
            {
                $return['message'] = '缺少参数';
                echo json_encode($return);
                exit();
            }
           
            if( !$pay_info )
            { 
                $return['message'] = '用户ID：'.$v['corp_customer_id'].'支付账户不存在';
                echo json_encode($return);
                exit();
            }
            
            if($i == 0)
            {
                //平台的 - 第一张订单处理
                $cash_income_end = $cash_income_beg - $v['total_price'];
            }else{
                //平台的
                $cash_income_beg = $cash_income_end;
                $cash_income_end = $cash_income_end - $v['total_price'];
            }
            
           //现金收入日志
           $cash_data['relation_id'] = '-1';
           $cash_data['id_event'] = '999';//待定事件
           $cash_data['type'] = '2';
           $cash_data['remark'] = '平台支出';
           $cash_data['cash'] = $v['total_price'];
           $cash_data['charge_no'] = $v['order_sn'];
           $cash_data['beginning_balance'] = $cash_income_beg;
           $cash_data['ending_balance'] = $cash_income_end;
           $cash_data['customer_id'] = $v['corp_customer_id'];
           $cash_data['app_id'] = 0;
           $cash_data['status'] = 1;
           
           //写入现金日志
           if( !$this->customer_money_log->add_log( $cash_data ) )
           {
               $this->db->trans_rollback();
               echo json_encode($return);
               exit();
               //失败。
           }
           
           //上一次用户现金交易的日志中的信息
           $to_last_cash_log = $this->customer_money_log->load_create_desc($pay_info['r_id']);
           
           if( isset( $to_last_cash_log['ending_balance']) &&  $to_last_cash_log['ending_balance'] == $pay_info['cash'] )
           {
               $cash_data['status'] = 1;
           }else if( !$to_last_cash_log && $pay_info['cash'] == 0 )
           {
               $cash_data['status'] = 1;
           }else{
               $cash_data['status'] = 2;
           }
           
           //现金支出日志
           $cash_data['relation_id'] = $pay_info['r_id'];
           $cash_data['type'] = '1';
           $cash_data['remark'] = '销售收入';
           $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : 0;
           $cash_data['ending_balance'] = isset( $to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance']+$v['total_price']:$v['total_price'];
           $cash_data['customer_id'] = $v['corp_customer_id'];
          
           //写入现金日志+现金
           if( !$this->customer_money_log->add_log( $cash_data ) || !$this->pay_account_mdl->charge_cash( $pay_info['id'],$v['total_price'] ) )
           { 
               //失败
               $this->db->trans_rollback();
               echo json_encode($return);
               exit();
           }
           $i++;
        }
       
        $this->db->trans_commit(); //处理成功
        $return['status']  = true;
        $return['message']  = '处理成功';
        echo json_encode($return);    	
    }

}

?>