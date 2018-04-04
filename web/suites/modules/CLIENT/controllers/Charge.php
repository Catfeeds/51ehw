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
        
        $data['order_source'] = 1; //PC网页支付
        
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
        }elseif($data['payment_id'] == 3){//pc银联支付
                $this->session->set_userdata("Acppay_chargeNo",$new_charge_id);//不想让用户看到这个参数
                redirect('Acppay/Notify_url/charge_pay/');
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
        $data['order_source'] = 2; //H5支付
        
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
        if ($data['payment_id'] == 2) { // H5微信支付
            redirect('Wechatpay/Js_api_call/pay/' . $new_charge_id.'_1_C' );
        } elseif($data['payment_id'] == 3){//H5银联支付
            $this->session->set_userdata("Acppay_chargeNo",$new_charge_id);//不想让用户看到这个参数
            redirect('Acppay/Notify_url/charge_pay/');
        } else{
            redirect('alipay/wapsubmit/' . $new_charge_id); // H5支付宝支付
        }
        
//         // 在微信浏览器中->
//         if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            
//             if ($data['payment_id'] == 2) { // <-判断是微信支付的话调用
//                 redirect('Wechatpay/Js_api_call/pay/' . $new_charge_id.'_1_C');
//                 return;
//             } else { // <-否则就是支付宝的
//                 redirect('alipay/wapsubmit/' . $new_charge_id);
//                 return;
//             }
//         } else {
//             redirect('alipay/wapsubmit/' . $new_charge_id); // H5支付宝支付
//         }
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
        } else if ($charge && $charge['order_sn']) { // 拼团订单的
            
            $order_sn = $charge['order_sn'];
            
            if ($status == 1) {
                $this->load->model('groupbuy_mdl');
                $groupbuy_info = $this->groupbuy_mdl->groupbuy_info($order_sn);
                $url = site_url("activity/groupbuy/group_detail?buy_num=" . $groupbuy_info['buy_num'] . "&head_menber=" . $groupbuy_info['head_menber'] . "&productid=" . $groupbuy_info['productid'] . " ");
                
                if(!$groupbuy_info || $groupbuy_info['o_status'] != 4){ 
                    
                    ?>
                    <meta charset="utf-8">
                    <script>alert("订单尚未完成请等待1~2分钟，或资金不足以扣除此次交易，已将充值金额转至现金账户，请查收！")
                         window.location.href="<?php echo $url?>";
                         
                    </script>
                    <?php 
                    return;
                }
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
                $buy_num = 0;
                if(!empty($order['activity_id']))
                    $buy_num = $order['activity_id'];
                                                                                 // 拼团支付返回页面
//                 redirect("activity/groupbuy/groupbuy_confirm/" . $order['product_id'] . "/$buy_num/".$order['quantity']);
            }
        }
    }
    
    
    /**
     * 购买货豆页面
     */
    public function purchase()
    {
        $this->session->set_userdata("ref_from_url", current_url());
        $relation_id = $this->session->userdata( 'pay_relation' );
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $result = json_decode($this->curl_get_result($url),true);
        
        $data['pay_detailed'] = $result;
        
        $data['title'] = '货豆充值';
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
     * 现金余额充值货豆
     */
    public function purchase_M()
    {
        $status = false;
        $is_ok = false;
        $M_credit = $this->input->post('m_credit');
        $password = $this->input->post('pass');
        $relation_id = $this->session->userdata('pay_relation');
        $app_id = $this->session->userdata('app_info')['id'];
        $url = $this->url_prefix.'Charge/purchase_M/?m_credit='.$M_credit.'&pass='.$password.'&relation_id='.$relation_id.'&app_id='.$app_id.'&port=C';
        $result = $this->curl_get_result($url);
        echo $result;
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