<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

    // ------------------------------------------------------------------------

/**
 * 切换端口调用数据
 *
 */
class Charge extends Account_Controller
{

    public function __construct()
    {
        parent::__construct();
        
    }
    /**
     * 现金余额充值货豆
     */
    public function purchase_M()
    {
        $status = false;
        $is_ok = false;
        $port = $this->input->get_post('port');
        $M_credit = $this->input->get_post('m_credit');
        $password = $this->input->get_post('pass');
        $relation_id = $this->input->get_post("relation_id"); // 购买用户ID
        $app_id = $this->input->get_post('app_id');
        $this->load->model("Pay_relation_mdl",'Pay_relation');
        $this->load->model("pay_account_mdl", "pay_account");
        $this->load->model("customer_money_log_mdl", 'customer_money_log');
        $this->load->model("customer_currency_log_mdl", 'customer_currency_log');
        
        // 查询该用户的支付账号
        $this->Pay_relation->id = $relation_id;
        $pay_detailed = $this->Pay_relation->load();
        $customer_id = $pay_detailed['customer_id'];
       
        if( $pay_detailed )
        {
        
            if ($pay_detailed['pay_passwd'] == md5($password)) 
            {
        
                // 判断支付账号中的现金余额是否足够购买货豆
                $cash = $pay_detailed['cash']; // 支付账号中的现金余额
        
                $surplus_m = $pay_detailed['M_credit']; // 支付账号中的货豆余额
        
                $pay_id = $pay_detailed['id']; // 支付账号的ID
        
                $pay_relation_id = $pay_detailed['r_id']; // 关联表的ID
        
                if ($cash >= $M_credit) 
                {
        
                    $this->db->trans_begin(); // 事物执行方法中的MODEL。
                    // 生成一张货豆充值的记录
                    $this->load->helper('order');
                    $data['customer_id'] = $customer_id;
                    $data['amount'] = $M_credit;
        
                    do {
                        $data['charge_no'] = get_order_sn();
        
                        if ($this->customer_currency_log->check_charge_sn($data['charge_no'])) {
                            $order_exist = true;
                        } else {
                            $data['charge_no'].= $port == 'C'? $port : 'B';
                            $currency_order = $this->customer_currency_log->create_charge_currency($data);
                            $order_exist = false;
                        }
                    } while ($order_exist); // 如果是订单号重复则重新提交数据
                    
                    if( $currency_order )
                    {
                        // 去掉现金余额
                        $update_cash = $this->pay_account->update_cash($pay_id, $M_credit);
        
                        if($update_cash)
                        {
                            // 加上货豆余额
                            $update_M_credit = $this->pay_account->charge_M_credit($pay_id, $M_credit);
        
                            if( $update_M_credit )
                            {
        
                                // 上一次现金交易的日志中的信息
                                $last_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id); // 现金日志
                                 
        
                                // 检测现金是否异常
                                if (isset($last_cash_log['ending_balance']) && $last_cash_log['ending_balance'] == $cash) 
                                {
                                    $cash_data['status'] = '1';
                                } elseif (! $last_cash_log && $cash == '0') {
                                    $cash_data['status'] = '1';
                                } else {
                                    $cash_data['status'] = '2';
                                }
        
                                // 现金支出日志
                                $cash_data['relation_id'] = $pay_relation_id;
                                $cash_data['id_event'] = '66';
                                $cash_data['type'] = '2';
                                $cash_data['remark'] = '现金充值货豆';
                                $cash_data['cash'] = $M_credit;
                                $cash_data['charge_no'] = $data['charge_no'];
                                $cash_data['beginning_balance'] = $cash;
                                $cash_data['ending_balance'] = $cash - $M_credit;
                                $cash_data['customer_id'] = '-1';
                                $cash_data['app_id'] = $app_id;
                                // 写入现金日志
                                $cash_log = $this->customer_money_log->add_log($cash_data);
        
                                if( $cash_log )
                                {
                                    // 上一次平台现金交易的日志中的信息
                                    $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
        
                                    // 平台现金收入日志
                                    $cash_data['relation_id'] = '-1';
                                    $cash_data['type'] = '1';
                                    $cash_data['status'] = '1';
                                    $cash_data['remark'] = '平台收入-充值货豆';
                                    $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
                                    $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] + $M_credit : $M_credit;
                                    $cash_data['customer_id'] = $customer_id;
                                    // 写入现金日志
                                    $to_cash_log = $this->customer_money_log->add_log($cash_data);
        
                                    if($to_cash_log)
                                    {
                                        // 上一次平台货豆交易的日志中的信息
                                        $to_last_m_log = $this->customer_currency_log->load_last('-1');
                                        // 货豆日志 -平台支出货豆
                                        $M_credit_data['relation_id'] = '-1';
                                        $M_credit_data['id_event'] = '66';
                                        $M_credit_data['type'] = '2';
                                        $M_credit_data['status'] = '1';
                                        $M_credit_data['remark'] = '平台支出-充值货豆';
                                        $M_credit_data['amount'] = $M_credit;
                                        $M_credit_data['order_no'] = $data['charge_no'];
                                        $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
                                        $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] - $M_credit : - $M_credit;
                                        $M_credit_data['customer_id'] = $customer_id;
                                        $M_credit_data['app_id'] = $app_id;
                                        // 写入货豆日志
                                        $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
        
                                        if($M_credit_log)
                                        {
                                            // 上一次货豆交易的日志中的信息
                                            $last_m_log = $this->customer_currency_log->load_last($pay_relation_id);
                                            // 货豆日志 -用户收入货豆日志
                                            if (isset($last_m_log['ending_balance']) && $last_m_log['ending_balance'] == $surplus_m) 
                                            { // 检测货豆是否异常
                                                $M_credit_data['status'] = '1';
                                            } else if (! $last_m_log && $surplus_m == '0') {
                                                $M_credit_data['status'] = '1';
                                            } else {
                                                $M_credit_data['status'] = '2';
                                            }
        
                                            $M_credit_data['relation_id'] = $pay_relation_id;
                                            $M_credit_data['type'] = '1';
                                            $M_credit_data['remark'] = '现金充值货豆到账';
                                            $M_credit_data['beginning_balance'] = $surplus_m;
                                            $M_credit_data['ending_balance'] = $M_credit + $surplus_m;
                                            $M_credit_data['customer_id'] = '-1';
                                            //写入货豆日志
                                            $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
        
                                            if($to_M_credit_log)
                                            {
                                                $is_ok = true;
                                                $this->db->trans_commit();
                                                $status = 1; // 充值成功
//                                                 $this->customer_currency_log->openid = $this->session->userdata('openid');
//                                                 $this->customer_currency_log->result_message( $M_credit_data ); //货豆充值到账-微信推送
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
        
                }else{
                    $status = 2; // 现金余额不足
                }
            }else{
                $status = 4; //密码错误
            }
        }else{
            $status = 3;// 没有充值账号账号
        }
        
        if(!$is_ok)
            $this->db->trans_rollback();
        
        echo json_encode($status);
    }
    
    //---------------------------------------------------
    
    /**
     * 提现
     */
    function Withdrawals(){
 
        $customer_id = $this->input->post("customer_id");//用户id
        $cash = $this->input->post("cash");//金额
        $app_id = $this->input->post("app_id");//分站点
        $source = $this->input->post("source");//来源
        $password = $this->input->post("password");//密码


        $this->load->model("pay_account_mdl");
        $this->load->model("customer_money_log_mdl");

        //查询银行卡状态
        $bank = $this->pay_account_mdl->check_bank($customer_id);
        if($bank){
            if($bank["status"] != 2){
                echo json_encode(array("status"=>1));//银行卡审核中or被冻结
                exit();
            }
        }else{
            echo json_encode(array("status"=>2));//请绑定银行卡
            exit();
        }
        
        //查询支付账户
        if($pay_account = $this->pay_account_mdl->load($customer_id)){
            if($pay_account["pay_passwd"] != md5($password)){
                echo json_encode(array("status"=>7));//密码错误
                exit();
            }
            
            if($pay_account["cash"] < $cash){
                echo json_encode(array("status"=>4));//金额不足
                exit();
            }
        }else{
            echo json_encode(array("status"=>6));//没有支付账户
            exit();
        }
        
        //生成订单号
        $this->load->helper('order_helper');
        do{
            $order_sn = get_order_sn();
            if($this->pay_account_mdl->check_cash_order_no($order_sn)){
                $order_exist = true;
            }else{
                $order_exist = false;
            }
        }while($order_exist);
        
        
        //数据提交模型
        $this->pay_account_mdl->cash = $cash;
        $this->pay_account_mdl->pay_id = $pay_account["id"];
        $this->pay_account_mdl->app_id = $app_id;
        $this->pay_account_mdl->order_sn = $order_sn;
        $this->pay_account_mdl->source = $source;
        $this->pay_account_mdl->port_source = PORT_SOURCE;
        
        $this->db->trans_begin();//开启事务
        $row = $this->pay_account_mdl->Withdrawals($customer_id);//添加提现纪录
        if($row){
            $row = $this->pay_account_mdl->update_cash($pay_account["id"],$cash);//扣除现金
            if($row){
                //查询最后一次log，判断账户是否异常，并且添加一条支出log
                $last_cash_log = $this->customer_money_log_mdl->load_create_desc($pay_account["r_id"]);
                if($last_cash_log["ending_balance"]==$pay_account["cash"]){
                    $data["status"] = 1;
                }else{
                    $data["status"] = 2;
                }
                $data["relation_id"] = $pay_account["r_id"];
                $data['id_event'] = 74;
                $data['remark'] = "客户提现申请";
                $data['app_id'] = $app_id;
                $data['cash'] = $cash;
                $data['beginning_balance'] = $pay_account["cash"];
                $data['ending_balance'] = $pay_account["cash"]-$cash;
                $data['type'] = 2;
                $data['customer_id'] = -1;
                $data['charge_no'] = $order_sn;
                $row = $this->customer_money_log_mdl->add_log($data);//添加支出log
                if($row){
                    //查询最后一次log，判断账户是否异常，并且添加一条支出log
                    $last_cash_log = $this->customer_money_log_mdl->load_create_desc("-1");
                    $data["relation_id"] = "-1";
                    $data['id_event'] = 74;
                    $data['remark'] = "平台收入-现金提现";
                    $data['app_id'] = $app_id;
                    $data['cash'] = $cash;
                    $data['beginning_balance'] = $last_cash_log["ending_balance"];
                    $data['ending_balance'] = $last_cash_log["ending_balance"]+$cash;
                    $data['type'] = 1;
                    $data['customer_id'] = $customer_id;
                    $data['charge_no'] = $order_sn;
                    $row = $this->customer_money_log_mdl->add_log($data);//添加支出log
                    if($row){
                        $this->db->trans_commit();
                        //查询最后一次log
                        $last_cash_log = $this->customer_money_log_mdl->load_create_desc($pay_account["r_id"]);
                        $last_cash_log["status"] = 3;
                        
                        echo json_encode($last_cash_log);//成功
                        exit();
                    }else{
                        $this->db->trans_rollback();
                        error_log("平台收入log添加失败:".$this->db->last_query());
                        echo json_encode(array("status"=>5));//提现失败
                        exit();
                    }
                }else{
                    $this->db->trans_rollback();
                    error_log("支出收入log添加失败:".$this->db->last_query());
                    echo json_encode(array("status"=>5));//提现失败
                    exit();
                }

            }else{
                $this->db->trans_rollback();
                echo json_encode(array("status"=>4));//余额不足
                exit();
            }
        }else{
            error_log("提现记录log添加失败:".$this->db->last_query());
            $this->db->trans_rollback();
            echo json_encode(array("status"=>5));//提现失败
            exit();
        }

    }
    
    //----------------------------------------------------------------------
    

}

?>