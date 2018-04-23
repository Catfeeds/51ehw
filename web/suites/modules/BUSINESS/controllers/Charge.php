<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Charge extends Front_Controller {

    public function __construct()
    {
        parent::__construct();
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('customer/login');
            exit();
        }
        
        // 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && ! $this->session->userdata("mobile")) {
            // 如果没有写手机
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('member/binding/binding_mobile');
            return;
            
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
        
        //后台退款区别标识
        $data['app_sign'] = '51ehw';//pc端或H5端
        
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
        if ($data['payment_id'] == 2) 
        { // pc微信扫码支付
            redirect('Charge/wx_native/' . $new_charge_id.'/1');
            
        } elseif($data['payment_id'] == 3){//pc银联支付
            
            redirect('Acppay/Notify_url/charge_pay/'.$new_charge_id); 
        }else{
            redirect('alipay/charge_pay/' . $new_charge_id); // PC支付宝支付
        }
    }

    /**
     * PC开店支付提交
     */
    public function merchant_changeSubmit()
    {   
        
        //获取店铺级别。
        $customer_id = $this->session->userdata('user_id');
        $this->load->model('customer_corporation_mdl');
        $corp_info = $this->customer_corporation_mdl->load( $customer_id );
        
        if( $corp_info && !$corp_info['is_paied'] ) //保证金是否已经支付：0待支付，1已支付
        { 
            
            //获取开店产品。
            $this->load->helper('product');
            $product_list = corporation_cash();
            
            $pay_info = !empty( $product_list[$corp_info['grade']] ) ? $product_list[$corp_info['grade']] : array() ;
            
            if( $pay_info )
            {
                $row = true;
                
                //缴纳保证金金额对应支付金额。
                if( $corp_info['deposit'] != $pay_info['cash'] )
                { 
                    $this->load->model('corporation_mdl');
                    
                    $this->corporation_mdl->deposit = $pay_info['cash'];
                    $this->corporation_mdl->corporation_id = $corp_info['id'];
                    $row = $this->corporation_mdl->update();
                }
                
                if( $row )
                {
                    $this->load->model("charge_mdl", "charge");
                    $data['amount'] = $pay_info['cash'];
                    $data["payment_id"] = $this->input->post('payment_id');
                    $data['order_source'] = 1; //PC网页支付
                    $data['customer_id'] = $customer_id;
                    
                    do {
                        
                        $data['chargeno'] = get_order_sn();
                    
                        if ( $this->charge->load_byChangeNum( $data['chargeno'] ) ) 
                        {
                            $order_exist = true;
                            
                        } else {
                            $new_charge_id = $this->charge->create($data);
                            
                            $order_exist = false;
                        }
                        
                    } while ($order_exist); // 如果是订单号重复则重新提交数据
                
                }
                
                if ( empty( $new_charge_id ) ) 
                {
                    echo '<meta charset="utf-8">
                        <script type="text/javascript">
                            alert("订单提交失败");
                            history.back();
                        </script>';
                    exit();
                }
            }else{ 
                
                echo '<meta charset="utf-8">
                        <script type="text/javascript">
                            alert("支付产品不存在");
                            history.back();
                        </script>';
                exit();
            }
            
        }else{ 
            
            echo '<meta charset="utf-8">
                <script type="text/javascript">
                    alert("您已经缴纳过保证金，无需重复缴纳");
                    history.back();
                </script>';
            exit();
            
        }
        
       
       if( $data['payment_id'] == 1 )
        { 
            redirect('alipay/pay/' . $new_charge_id); // PC支付宝支付
            
        }else if ( $data['payment_id'] == 2 ) 
        {   // pc微信扫码支付
            redirect('Charge/wx_native/' . $new_charge_id.'/3');
        
        } elseif($data['payment_id'] == 3){//pc银联支付

            redirect('Acppay/Pay/charge_pay/'.$new_charge_id.'/COP'); 
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
        
        //后台退款区别标识
        $data['app_sign'] = '51ehw';//pc端或H5端
        
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
           redirect('Wechatpay/Js_api_call/pay/' . $new_charge_id.'_1_B' );
        } elseif($data['payment_id'] == 3){//H5银联支付
            redirect('Acppay/pay/charge_pay/'.$new_charge_id);
        }else{
           redirect('alipay/wapsubmit/' . $new_charge_id); // H5支付宝支付
        }
        
        
//         // 在微信浏览器中->
//         if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            
//             if ($data['payment_id'] == 2) { // <-判断是微信支付的话调用
//                 redirect('Wechatpay/Js_api_call/pay/' . $new_charge_id.'_1_B' );
//                 return;
//             } else { // <-否则就是支付宝的
//                 redirect('alipay/wapsubmit/' . $new_charge_id);
//                 return;
//             }
//         } else {
//             redirect('alipay/wapsubmit/' . $new_charge_id); // H5支付宝支付
//         }
    }

    
    
    // 支付同步返回
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
     * 购买提货权页面
     */
    public function purchase()
    {
        $this->session->set_userdata("ref_from_url", current_url());
        $relation_id = $this->session->userdata( 'pay_relation' );
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $result = json_decode($this->curl_get_result($url),true);
        
        $data['pay_detailed'] = $result;
        
        $data['title'] = '提货权充值';
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
     * 现金余额充值提货权
     */
    public function purchase_M()
    {
        $status = false;
        $is_ok = false;
        $M_credit = $this->input->post('m_credit');
        $password = $this->input->post('pass');
        $relation_id = $this->session->userdata('pay_relation');
        $app_id = $this->session->userdata('app_info')['id'];
        $url = $this->url_prefix.'Charge/purchase_M/?m_credit='.$M_credit.'&pass='.$password.'&relation_id='.$relation_id.'&app_id='.$app_id;
        $result = $this->curl_get_result($url);
        echo $result;
    }
    
    // 根据ID查询。
    function charge_status()
    {   $status = 0;
        $id = $this->input->post('charge_id');
        $this->load->model('charge_mdl');
        $data = $this->charge_mdl->load($id);
        
        if( $data['status'] == 1){ 
            $status = true;
        }
        echo json_encode($status);
    }
    
    
    // 查询订单。
    function examine_charge()
    {
        $data['status'] = false;
        $charge_id = $this->input->post('charge_id');
        $customer_id = $this->session->userdata('user_id');
        // $charge_sn = '2017113048488';
        $this->load->model('charge_mdl');
        $charge_info = $this->charge_mdl->load( $charge_id, $customer_id, 1);
        
        if( $charge_info )
        { 
            $data['status'] = true;
        }
        echo json_encode($data);
    }

    
    /**
     * H5开店。
     */
    public function Cash_Shop( $corp_type = 0  )
    {
        //获取开店产品。
        $this->load->helper('product');
        $product_list = corporation_cash();
        
        if( !empty( $product_list[$corp_type] ) )
        { 
            $pay_info = $product_list[$corp_type];
            $data["amount"] =  $pay_info['cash'];
            $data["payment_id"] = 2;
            $data['order_source'] = 2; //H5支付
            
            
            $customer_id = $this->session->userdata("user_id");
            $this->load->model('Customer_corporation_mdl');
            
            $corp_info = $this->Customer_corporation_mdl->load( $customer_id );
            
            //店铺不存在或者没缴纳保证金才可以发起支付。
            if( !$corp_info || !$corp_info['is_paied'] )
            {   
                $row = true;
                
                if(  $corp_info['grade'] != $corp_type || $corp_info['deposit'] != $pay_info['cash'] )
                { 
                    //等级不一致，更新店铺等级。
                    $this->load->model('Corporation_mdl');
                    $this->Corporation_mdl->grade = $corp_type;
                    $this->Corporation_mdl->deposit = $pay_info['cash'];
                    $this->Corporation_mdl->corporation_id = $corp_info['id'];
                    $row = $this->Corporation_mdl->update();
                }
                
                if( $row )
                { 
                    
                    $this->load->model("charge_mdl", "charge");
                    $data['customer_id'] = $customer_id;
                    
                    do {
                    
                        $data['chargeno'] = get_order_sn();
                    
                        if ( $this->charge->load_byChangeNum( $data['chargeno'] ) )
                        {
                            $order_exist = true;
                    
                        } else {
                    
                            $new_charge_id = $this->charge->create($data);
                            $order_exist = false;
                        }
                    
                    } while ($order_exist); // 如果是订单号重复则重新提交数据
                    
                    if (! $new_charge_id )
                    {
                        echo '<meta charset="utf-8">
    		        <script type="text/javascript">
                        alert("订单提交失败");
                    	history.back();
                    </script>';
                        exit();
                    }
                    // H5微信支付
                    redirect('Wechatpay/Js_api_call/pay/' . $new_charge_id.'_4_B' );
                }
                
            }else{
            
                echo '<meta charset="utf-8">
    		        <script type="text/javascript">
                        alert("您已经是店主或店铺在申请中，无需重复开店");
                    	history.back();
                    </script>';
                exit();
            }
            
            
        }else{ 
            
            echo '<meta charset="utf-8">
                <script type="text/javascript">
                    alert("支付产品不存在");
                    history.back();
                </script>';
            exit();
            
        }
   }
    
    /**
     * 支付开店金额-同步返回显示结果页面。
     */
    public function after_shop( $change_no = 0 ,$status = 1 )
    {
        $data['status'] = $status;
    
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['back'] = 'customer/fortune';
    
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('payment/afterpay_shop_view', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    
    /**
     * 微信二维码支付页面。
     * @date:2017年12月14日 下午12:01:53
     * @author: fxm
     * @param: variable
     * @return: 
     */
    public function wx_native( $charge_id = 0 , $status = 1 )
    { 
       
        $pay_message[1] = '充值现金需支付';
        $pay_message[3] = '开通店铺需支付';
        
        if( !array_key_exists( $status, $pay_message) )
        { 
            echo '<meta charset="utf-8">
                <script type="text/javascript">
                    alert("无效参数");
                    history.back();
                </script>';
            exit();
        }            
        
        $data['title'] = $pay_message[$status];
        $data['status'] = $status;
        $data['charge_id'] = $charge_id;
        $this->load->view ( 'head' ,$data );
        $this->load->view ( '_header' ,$data );
        $this->load->view ( 'property/wechat_qrcode', $data );
        $this->load->view ( '_footer' ,$data ) ;
        $this->load->view ( 'foot' ,$data );
        
    }
    

}