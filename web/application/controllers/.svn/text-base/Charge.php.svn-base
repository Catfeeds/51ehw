<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Charge extends Front_Controller {

    public function __construct()
    {
        parent::__construct();
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        
        // 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && ! $this->session->userdata("mobile_exist")) {
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        
        $this->load->helper('order');
    }

    public function incharge( $message = 0 )
    {
        $data['message'] = $message;
        $data['title'] = '现金充值';
        $data['back'] = 'customer/fortune';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('charge/charge');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * PC支付提交
     */
    public function changeSubmit()
    {
        $data["amount"] = $this->input->post('amount');
        $data["payment_id"] = $this->input->post('payment_id');
        
        $customer_id = $this->session->userdata("user_id");
        $this->load->model("charge_mdl", "charge");
        $data['customer_id'] = $customer_id;
        
        do {
            $data['chargeno'] = get_order_sn();
            
            if ($this->charge->load_byChangeNum($data['chargeno'])) {
                $order_exist = true;
            } else {
                $new_charge_id = $this->charge->create($data);
                $order_exist = false;
            }
        } while ($order_exist); // 如果是订单号重复则重新提交数据
        
        if (! $new_charge_id) {
            echo '<meta charset="utf-8">
		        <script type="text/javascript">
                    alert("订单提交失败");
                	history.back();
                </script>';
            exit();
        }
        
        // 在pc浏览器中->
        if ($data['payment_id'] == 2) { // pc微信扫码支付
            redirect('wechatpay/native_dynamic_qrcode/charge/' . $new_charge_id);
        } else {
            redirect('alipay/charge_pay/' . $new_charge_id); // PC支付宝支付
        }
    }
    
    // ----------------------------------------------------------------------------------------
    
    /**
     * 支付提交 H5用
     */
    public function Web_Change_Submit()
    {
        $data["amount"] = $this->input->post('amount');
        $data["payment_id"] = $this->input->post('payment_id');
        
        $customer_id = $this->session->userdata("user_id");
        $this->load->model("charge_mdl", "charge");
        $data['customer_id'] = $customer_id;
        
        do {
            $data['chargeno'] = get_order_sn();
            
            if ($this->charge->load_byChangeNum($data['chargeno'])) {
                $order_exist = true;
            } else {
                $new_charge_id = $this->charge->create($data);
                $order_exist = false;
            }
        } while ($order_exist); // 如果是订单号重复则重新提交数据
        
        if (! $new_charge_id) {
            echo '<meta charset="utf-8">
		        <script type="text/javascript">
                    alert("订单提交失败");
                	history.back();
                </script>';
            exit();
        }
        
        // 在微信浏览器中->
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            
            if ($data['payment_id'] == 2) { // <-判断是微信支付的话调用
                redirect('wechatpay/js_api_call/charge/' . $new_charge_id);
                return;
            } else { // <-否则就是支付宝的
                redirect('alipay/wapsubmit/' . $new_charge_id);
                return;
            }
        } else {
            redirect('alipay/wapsubmit/' . $new_charge_id); // H5支付宝支付
        }
    }

    /**
     */
    /*
     * public function save_pay() {
     * $amount = $_REQUEST ['amount'];
     * $userid = $this->session->userdata ( 'user_id' );
     *
     * $data = array (
     * "customer_id" => $userid,
     * "amount" => $amount,
     * "payment_id" => 1,
     * "status" => 0
     * );
     * $this->load->model ( 'charge_mdl' );
     * do {
     * $order_sn = $this->get_chargenum ();
     * if ($this->charge_mdl->check_ordernum ( $order_sn )) {
     * $order_exist = true;
     * } else {
     * $data ["chargeno"] = $order_sn;
     * $this->charge_mdl->create ( $data );
     * $order_exist = false;
     * // $new_order_id = $this->db->insert_id();
     * }
     * } while ( $order_exist );
     *
     * // 商户编号p1_MerId,以及密钥Key
     * // $merchant_id = "80140311172356932106";
     * // $key = "433a63646a514606a9d25f01971fe330";
     * $merchant_id = "80140527151937717428";
     * $key = "14aa9b5b0bb1462a91c5c6f1217e8ef1";
     * $req_url = "http://bank.kuaiyinpay.com/Payment";
     * $refund_url = "http://payment.kuaiyinpay.com/kuaiyinAPI/refundOrder/kuaiYinOrderId/";
     * $query_url = "http://payment.kuaiyinpay.com/kuaiyinAPI/inquiryOrder/merchantOrderId/";
     * $refundquery_url = "http://payment.kuaiyinpay.com/kuaiyinAPI/inquiryRefundOrder/kuaiYinOrderId/";
     *
     * $kypay = array ();
     * // 目前网关版本固定为1.0.0
     * $kypay ['version'] = '1.0.0';
     * // 银行代码 招商银行CMB
     * $kypay ['bank_code'] = $_REQUEST ['bank_code'];
     * // 支付金额 精确到小数点后两位，如0.10,10.00
     * $kypay ['amount'] = $amount;
     * // 商户ID
     * $kypay ['merchant_id'] = $merchant_id;
     * // 订单时间 格式为：yyyyMMddHHmmss
     * $kypay ['order_time'] = date ( 'YmdHis' );
     * // 商户生成该订单号并上送快银，唯一标识该笔订单
     * $kypay ['order_id'] = $order_sn . str_pad ( mt_rand ( 1, 99 ), 2, '0', STR_PAD_LEFT );
     * // 商户用于接收支付结果通知的一个URL地址
     * $kypay ['merchant_url'] = site_url ( 'charge/afterpay' ) . '/' . $order_sn; // 交易结果回调页面（推荐使用IP形式）
     *
     * // 自定义字段
     * $kypay ['cust_param'] = "webcharge";
     *
     * // 去除数组中值为空的数据(参数为空时，不参与签名。)
     * $sign_kypay = array_diff ( $kypay, array (
     * ''
     * ) );
     * ksort ( $sign_kypay );
     * $str_sign = '';
     * foreach ( $sign_kypay as $k => $v ) {
     * $str_sign .= $k . '=' . $v . '&';
     * }
     *
     * $sign_msg = md5 ( urlencode ( $str_sign . 'key=' . $key ) );
     *
     * // 拼接要传送的数据
     * $ky_str = '';
     * foreach ( $kypay as $k => $v ) {
     * $ky_str .= $k . '=' . $v . '&';
     * }
     * $ky_pay_str = $ky_str . 'sign_msg=' . $sign_msg;
     *
     * // 打开连接 ,需开启curl服务插件
     * $ch = curl_init ();
     * // 设置url,post的数据类型，post的值
     * curl_setopt ( $ch, CURLOPT_URL, $req_url );
     * // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。
     * curl_setopt ( $ch, CURLOPT_POST, count ( $ky_pay_str ) );
     * curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
     * // 在HTTP中的"POST"操作。如果要传送一个文件，需要一个@开头的文件名
     * curl_setopt ( $ch, CURLOPT_POSTFIELDS, $ky_pay_str );
     * curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
     * curl_exec ( $ch );
     * curl_close ( $ch );
     * exit ();
     * }
     */
    
    // 支付返回
    public function after_pay($chargeno = 0, $status = 2)
    {
        error_log("came in after_pay!");
        $data = array();
        $user_id = $this->session->userdata('user_id');
        $parent_id = $this->session->userdata('parent_id');
        $this->load->model('charge_mdl');
        // 查询该支付订单是否已经完成的。 //防止用户刷新重新调用方法
        $charge = $this->charge_mdl->load_byChangeNum($chargeno, $user_id);
        
        if ($charge && $charge['order_sn'] == '') {
            
            // 是否支付成功
            if ($status == 1) {
                
                /*
                 * 同步不做处理
                 * $this->load->model("pay_account_mdl", "pay_account");
                 * $this->load->model("customer_money_log_mdl",'customer_money_log');
                 *
                 *
                 * if( $charge['status'] == 4 || !$charge){ //如果是已经支付过的 或者取消支付的订单 或者不存在 就返回。
                 * redirect ( 'customer/fortune' );
                 * return;
                 * }
                 * // if(!strpos ( $_SERVER ['HTTP_USER_AGENT'], 'MicroMessenger' ) !== false ) //如果不是微信浏览器不执行
                 * // redirect ( 'customer/fortune' );
                 * // return;
                 *
                 * if($charge['status'] == '0' && $charge['payment_id'] == 2 ){ //如果没有支付过的充值订单才 && 是微信支付方式才执行
                 * //查询该用户的支付账号
                 * $pay_detailed = $this->pay_account->load($user_id);
                 *
                 * $this->db->trans_begin(); //事物执行方法中的MODEL。
                 * // 修改订单状态为已支付
                 * $charge_row = $this->charge_mdl->update_pay ( $charge ["id"],'微信支付' );
                 *
                 * $charge_cash = $charge['amount']; //该充值订单的金额
                 *
                 * $pay_id = $pay_detailed['id']; //该用户的支付账号的ID
                 *
                 * $pay_relation_id = $pay_detailed['r_id']; //关联表的ID
                 *
                 * $cash = $pay_detailed['cash']; //充值前的现金余额
                 * //充值成功后帮用户添加现金余额;
                 * $charge_cash_row = $this->pay_account->charge_cash($pay_id,$charge_cash);
                 *
                 * //上一次用户交易的日志
                 * $last_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id);
                 * //上一次平台交易的日志
                 * $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
                 *
                 * //平台支出现金日志
                 * $cash_data['relation_id'] = '-1';
                 * $cash_data['id_event'] = '68';
                 * $cash_data['remark'] = '平台支出-现金充值';
                 * $cash_data['cash'] = $charge_cash;
                 * $cash_data['charge_no'] = $chargeno;
                 * $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
                 * $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance']-$charge_cash : -$charge_cash;
                 * $cash_data['type'] = '2';
                 * $cash_data['customer_id'] = $user_id;
                 * $cash_data['status'] = '1';
                 * //写入现金日志
                 * $to_cash_log = $this->customer_money_log->add_log($cash_data);
                 *
                 * //检测是否异常
                 * if( isset($last_cash_log['ending_balance']) && $last_cash_log['ending_balance'] == $cash){
                 * $cash_data['status'] = '1';
                 * }else if(!$last_cash_log && $cash =='0'){
                 * $cash_data['status'] = '1';
                 * }else{
                 * $cash_data['status'] = '2';
                 * }
                 *
                 * $cash_data['relation_id'] = $pay_relation_id;
                 * $cash_data['type'] = '1';
                 * $cash_data['remark'] = '现金充值到账';
                 * $cash_data['beginning_balance'] = $cash;
                 * $cash_data['ending_balance'] = $cash+$charge_cash;
                 * $cash_data['customer_id'] = '-1';
                 *
                 * //写入现金日志
                 * $cash_log = $this->customer_money_log->add_log($cash_data);
                 *
                 * //事物结束
                 * if ($charge_row && $charge_cash_row && $to_cash_log && $cash_log ) {
                 * $this->db->trans_commit();
                 * } else {
                 * $this->db->trans_rollback();
                 * $status = 3;
                 * }
                 *
                 * }
                 */
                // 读取订单内容
                $data['charge'] = $charge;
                $data["title"] = "支付成功";
            }
            
            if ($status == 2) {
                // 改成作废订单
                if ($charge['status'] == 1 || $charge['status'] == 2) { // 判断如果确认支付过或者已经支付的话就返回回去。防止改URL
                    redirect('customer/fortune');
                    return;
                }
                $this->load->model('charge_mdl');
                $this->charge_mdl->update_charge_status($chargeno, $user_id);
                redirect( "charge/incharge/1" );
                $data["title"] = "支付取消";
            }
            
            if ($status == 3) {
                if ($charge['status'] == 1 || $charge['status'] == 2) { // 判断如果确认支付过或者已经支付的话就返回回去。防止改URL
                    redirect('customer/fortune');
                    return;
                }
                $this->load->model('charge_mdl');
                $this->charge_mdl->update_charge_status($chargeno, $user_id);
                redirect( "charge/incharge/2" );
                $data["title"] = "支付失败";
            }

            $ref_from_url = $this->session->userdata("ref_from_url");
            if($ref_from_url){
                $this->session->unset_userdata("ref_from_url");
                redirect( $ref_from_url );
            }
            
            $data['status'] = $status;
            
            $data['head_set'] = 2;
            $data['foot_set'] = 1;
            $data['back'] = 'customer/fortune';
            
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('payment/afterpay_charge_view', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        } else if ($charge && $charge['order_sn']) { // 订单的
            
            $order_sn = $charge['order_sn'];
            
            if ($status == 1) {
                $this->load->model('groupbuy_mdl');
                $groupbuy_info = $this->groupbuy_mdl->groupbuy_info($order_sn);
                // 拼团支付返回页面
                redirect("activity/groupbuy/group_detail?buy_num=" . $groupbuy_info['buy_num'] . "&head_menber=" . $groupbuy_info['head_menber'] . "&productid=" . $groupbuy_info['productid'] . " ");
            } else {
                $this->load->model('product_mdl');
                $order = $this->product_mdl->item_product_order_sn($order_sn);
                
                if ($order && $charge['status'] == '0') {
                    // 取消支付 OR 支付失败 时 加回库存
                    $this->product_mdl->update_add_stock($order['product_id'], 1);
                }
                
                $this->charge_mdl->update_charge_status($chargeno, $user_id); // 将该单改为作废充值订单
                                                                                 // 拼团支付返回页面
                redirect("activity/groupbuy/groupbuy_confirm/" . $order['product_id'] . "/0");
            }
        }
    }
    
    
    /**
     * 购买M券页面
     */
    public function purchase()
    {
        $this->session->set_userdata("ref_from_url", current_url());
        $this->load->model("pay_account_mdl", "pay_account");
        $data['pay_detailed'] = $this->pay_account->load($this->session->userdata("user_id"));
        
        $data['title'] = 'M券充值';
        $data['back'] = 'customer/fortune';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        // H5弹窗
        if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
            if (! $data['pay_detailed']['pay_passwd']) {
                $data['bullet_set'] = '1';
                $this->load->view('widget/bullet', $data);
            } else {
                $data['bullet_set'] = '3';
                $this->load->view('widget/bullet', $data);
            }
        }
        $this->load->view('charge/purchase', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 现金余额充值M券
     */
    public function purchase_M()
    {
        $status = false;
        $M_credit = $this->input->post('m_credit');
        $password = $this->input->post('pass');
        
        $customer_id = $this->session->userdata("user_id"); // 购买用户ID
        
        $this->load->model("pay_account_mdl", "pay_account");
        $this->load->model("customer_money_log_mdl", 'customer_money_log');
        $this->load->model("customer_currency_log_mdl", 'customer_currency_log');
        
        // 查询该用户的支付账号
        $pay_detailed = $this->pay_account->load($customer_id);
        
        if (! $pay_detailed) { // 没有充值账号账号
            $status = 3;
            echo json_encode($status);
            exit();
        }
        if ($pay_detailed['pay_passwd'] != md5($password)) {
            $status = 4;
            echo json_encode($status);
            exit();
        }
        // 判断支付账号中的现金余额是否足够购买M券
        $cash = $pay_detailed['cash']; // 支付账号中的现金余额
        
        $surplus_m = $pay_detailed['M_credit']; // 支付账号中的M券余额
        
        $pay_id = $pay_detailed['id']; // 支付账号的ID
        
        $pay_relation_id = $pay_detailed['r_id']; // 关联表的ID
        
        if ($cash < $M_credit) {
            $status = 2; // 现金余额不足
            echo json_encode($status);
            exit();
        }
        
        $this->db->trans_begin(); // 事物执行方法中的MODEL。
                                  // 生成一张M券充值的记录
        
        $data['customer_id'] = $customer_id;
        $data['amount'] = $M_credit;
        $data['charge_no'] = get_order_sn();
        
        do {
            $data['charge_no'] = get_order_sn();
            
            if ($this->customer_currency_log->check_charge_sn($data['charge_no'])) {
                $order_exist = true;
            } else {
                $currency_order = $this->customer_currency_log->create_charge_currency($data);
                $order_exist = false;
            }
        } while ($order_exist); // 如果是订单号重复则重新提交数据
                                  
        // 去掉现金余额
        $update_cash = $this->pay_account->update_cash($pay_id, $M_credit);
        
        // 加上M券余额
        $update_M_credit = $this->pay_account->charge_M_credit($pay_id, $M_credit);
        
        // 上一次现金交易的日志中的信息
        $last_cash_log = $this->customer_money_log->load_create_desc($pay_relation_id); // 现金日志
                                                                                        // 上一次平台现金交易的日志中的信息
        $to_last_cash_log = $this->customer_money_log->load_create_desc('-1');
        
        // 上一次M券交易的日志中的信息
        $last_m_log = $this->customer_currency_log->load_last($pay_relation_id);
        // 上一次平台M券交易的日志中的信息
        $to_last_m_log = $this->customer_currency_log->load_last('-1');
        
        // 检测现金是否异常
        if (isset($last_cash_log['ending_balance']) && $last_cash_log['ending_balance'] == $cash) {
            $cash_data['status'] = '1';
        } else 
            if (! $last_cash_log && $cash == '0') {
                $cash_data['status'] = '1';
            } else {
                $cash_data['status'] = '2';
            }
        
        // 现金支出日志
        $cash_data['relation_id'] = $pay_relation_id;
        $cash_data['id_event'] = '66';
        $cash_data['type'] = '2';
        $cash_data['remark'] = '现金充值M券';
        $cash_data['cash'] = $M_credit;
        $cash_data['charge_no'] = $data['charge_no'];
        $cash_data['beginning_balance'] = $cash;
        $cash_data['ending_balance'] = $cash - $M_credit;
        $cash_data['customer_id'] = '-1';
        // 写入现金日志
        $cash_log = $this->customer_money_log->add_log($cash_data);
        
        // 平台现金收入日志
        $cash_data['relation_id'] = '-1';
        $cash_data['type'] = '1';
        $cash_data['status'] = '1';
        $cash_data['remark'] = '平台收入-充值M券';
        $cash_data['beginning_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] : '0.00';
        $cash_data['ending_balance'] = isset($to_last_cash_log['ending_balance']) ? $to_last_cash_log['ending_balance'] + $M_credit : $M_credit;
        $cash_data['customer_id'] = $customer_id;
        // 写入现金日志
        $to_cash_log = $this->customer_money_log->add_log($cash_data);
        
        // M券日志 -平台支出M券
        $M_credit_data['relation_id'] = '-1';
        $M_credit_data['id_event'] = '66';
        $M_credit_data['type'] = '2';
        $M_credit_data['status'] = '1';
        $M_credit_data['remark'] = '平台支出-充值M券';
        $M_credit_data['amount'] = $M_credit;
        $M_credit_data['order_no'] = $data['charge_no'];
        $M_credit_data['beginning_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] : '0.00';
        $M_credit_data['ending_balance'] = isset($to_last_m_log['ending_balance']) ? $to_last_m_log['ending_balance'] - $M_credit : - $M_credit;
        $M_credit_data['customer_id'] = $customer_id;
        // 写入M券日志
        $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
        
        // M券日志 -用户收入M券日志
        if (isset($last_m_log['ending_balance']) && $last_m_log['ending_balance'] == $surplus_m) { // 检测M券是否异常
            $M_credit_data['status'] = '1';
        } else 
            if (! $last_m_log && $surplus_m == '0') {
                $M_credit_data['status'] = '1';
            } else {
                $M_credit_data['status'] = '2';
            }
        
        $M_credit_data['relation_id'] = $pay_relation_id;
        $M_credit_data['type'] = '1';
        $M_credit_data['remark'] = '现金充值M券到账';
        $M_credit_data['beginning_balance'] = $surplus_m;
        $M_credit_data['ending_balance'] = $M_credit + $surplus_m;
        $M_credit_data['customer_id'] = '-1';
        // 写入M券日志
        $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
        
        // 事物
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            echo json_encode(false);
            exit();
        }
        
        if ($currency_order && $update_cash && $update_M_credit && $cash_log && $to_cash_log && $M_credit_log && $to_M_credit_log) {
            $this->db->trans_commit();
            $status = 1; // 充值成功
        } else {
            $this->db->trans_rollback();
        }
        
        echo json_encode($status);
    }
    
    // 查询订单。
    function examine_charge()
    {
        $charge_sn = $this->input->post('order_sn');
        $this->load->model('charge_mdl');
        $data = $this->charge_mdl->get_ok_charge($charge_sn, 1);
        echo json_encode($data);
    }
}