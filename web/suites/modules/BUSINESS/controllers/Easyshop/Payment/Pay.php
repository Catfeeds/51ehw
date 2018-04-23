<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

/**
 * 第三方发起支付类。
 * @author fxm
 */
class Pay extends Front_Controller {
	/**
	 * 构造函数
	 *
	 * @access public
	 * @return void
	 */

    private $payment_id;
    private $customer_id;
    
	public function __construct() 
	{
	    parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata('user_in')) 
		{
		    redirect('customer/login');
		    exit();
		}
		
		$this->customer_id = $this->session->userdata('user_id');
	}
	
	/**
	 * 发起支付
	 */
	public function Index() 
	{
	    $this->load->helper('order');
	    
	    //接收支付价格-支付事件-支付方式等信息。
// 	    $charge_info['amount'] = 10;//$this->input->get_post('amount');//充值金额
	    $charge_info['obj_type'] = 1;//$this->input->get_post('charge_type');//1支付订单（简易店）。
	    $charge_info['source'] = 2;//$this->input->get_post('charge_source');//1:PC支付 2:H5支付 3:安卓 4:IOS 5后台
	    $charge_info['payment_id'] = 1;//$this->input->get_post('payment_id');//充值平台 1:微信H5 2:支付宝 3:银联
	    $charge_info['customer_id'] = $this->customer_id; //用户ID
	    $charge_info['obj_id'] = 27;//$this->input->post('obj_id');
	   
        //根据不同的充值类型生成子选项。一或多。
        $item = $this->ChargeItem( $charge_info );
        
        //选择支付方式
        if( !empty( $item['status'] ) )
        {
            switch ( $charge_info['payment_id'] )
            {
                case 1 :
                    //调用微信发起支付
                    $this->Wechat_Pay( $item['data']['charge_id'] );
                    break;
                case 2:
                    //调用支付宝发起支付
                    // 	                $this->Alipay( $charge_id );
                    break;
                default:
                    //调用微信二维码支付
                    // 	                $this->Wechat_Qrcode_Pay( $charge_id );
                    //防止刷新重复提交，所以用转跳的方式。
                    // 	                redirect('Pay/Wechat_Qrcode_Pay/'.$charge_id);
                    break;
            }
            
        }else{ 
            
            //提示失败信息
            echo $item['message'];
        }
	}
	
    /**
     * 根据不同的充值类型生成记录选项。一或多。
     * @date:2018年4月2日 上午10:49:09
     * @author: fxm
     * @param: variable
     * @return: 
     */
	private function ChargeItem( $charge_info )
	{ 
	    $return['message'] = '类型不存在';
	    $return['status'] = '';
	    
	    //生成流水号
	    $this->load->model('Easy_charge_mdl');
	    $order_exist = true;
	   
	    do {
	         
	        $charge_info['charge_no'] = get_order_sn();
	    
	        if ( !$this->Easy_charge_mdl->CheckOrdernum( $charge_info['charge_no'] )   )
	        {
	            $order_exist = false;
	        }
	         
	    } while ($order_exist); // 如果是订单号重复则重新提交数据
	    
	    
	    //根据不同类型生成对象价格。
	    switch ( $charge_info['obj_type'] )
	    {
	        case 1 :
                 //查询对象订单信息。
                $this->load->model('easyshop_order_mdl');
                $order_info = $this->easyshop_order_mdl->get_where('easy_order',array('id'=>$charge_info['obj_id'],'customer_id'=>$this->customer_id));
                
                if( !$order_info )
                { 
                    //订单不存在。
                    $return['message'] = '订单不存在';
                    $return['status'] = '';
                    return $return;
                }
                
                $charge_info['amount'] = $order_info['total_price'];
                $charge_info['remark'] = '订单支付';
                $charge_info['obj_no'] = $order_info['order_sn'];
                break;
        }
      
    
        //生成支付信息
        $charge_id = $this->Easy_charge_mdl->Create( $charge_info );
      
        if( !$charge_id )
        {
            $return['message'] = '发起支付失败，请重试';
            $return['status'] = '';
            return $return;
        }
        
        $return['message'] = 'ok';
        $return['status'] = true;
        $return['data']['charge_id'] = $charge_id;
        
        
        //使用通用逻辑，如果其它类型还需要则array(添加类型)，特殊类型则else 中生成item.
//         if( in_array( $charge_info['type'], array(1) ) )
//         {
//             //构造信息
//             $item['easy_charge_id'] = $charge_id;
//             $item['amount'] = $charge_info['amount'];
//             $item['obj_id'] = $charge_info['obj_id'];
            
//             if( $this->Easy_charge_mdl->CreateItem( $item ) )
//             {
//                 $return['message'] = 'ok';
//                 $return['status'] = true;
//                 $return['data']['charge_id'] = $charge_id;
//             }
//         }

        return $return;
	}
	
	
	/**
	 * 发起微信充值&code回调
	 */
	public function Wechat_Pay( $charge_id )
	{ 
	    include_once (FCPATH."application/libraries/Wechatpay/WxPayPubHelper/WxPayPubHelper.php");//放在libarires
	    
	    // 使用jsapi接口
	    $jsApi = new JsApi_pub ();
	     
	    // =========步骤1：网页授权获取用户openid============
	    // 通过code获得openid
	     
	    if (! isset ( $_GET ['code'] ) ) 
	    {
	        // 触发微信返回code码
	        $url = $jsApi->createOauthUrlForCode ( urlencode (  WxPayConf_pub::JS_API_CALL_URL . "/" . $charge_id  ) );
	        Header ( "Location: $url" );
	        exit();
	        
	    } else {
	        
	        // 获取code码，以获取openid
	        $code = $_GET ['code'];
	        $jsApi->setCode ( $code );
	        $openid = $jsApi->getOpenId ();
	        
	    }
	    
	    //查询信息
	    $this->load->model ( 'Easy_charge_mdl', 'charge' );
	    $charge = $this->charge->Load ( $charge_id );
	    
	    //构造充值信息
	    $price = $charge ['amount'] * 100;
	    $unifiedOrder = new UnifiedOrder_pub ();
	    $unifiedOrder->setParameter ( "openid", "$openid" ); // 商品描述
	    $unifiedOrder->setParameter ( "body", "{$charge['remark']}"); // 商品描述
	    $unifiedOrder->setParameter ( "out_trade_no", $charge ['charge_no'] ); // 商户订单号
	    $unifiedOrder->setParameter ( "total_fee", $price ); // 总金额
	    $unifiedOrder->setParameter ( "notify_url", WxPayConf_pub::NOTIFY_URL ); // 通知地址
	    $unifiedOrder->setParameter ( "trade_type", "JSAPI" );//类型
	     
	    // 交易类型
	    $prepay_id = $unifiedOrder->getPrepayId ();
	    // =========步骤3：使用jsapi调起支付============
	    $jsApi->setPrepayId ( $prepay_id );
	     
	    $data ['jsApiParameters'] = $jsApi->getParameters ();
	    $data ['charge'] = $charge;
	
	    $this->load->view ( 'easyshop/payment/wechat_charge', $data );
	    
	}
	
	/**
	 * 微信扫码支付
	 */
	public function Wechat_Qrcode_Pay( $charge_id )
	{ 
	    include_once (FCPATH."application/libraries/Wechatpay/WxPayPubHelper/WxPayPubHelper.php");//放在libarires
	    //使用统一支付接口
	    $unifiedOrder = new UnifiedOrder_pub();
	    
	    $this->load->model ( 'Easy_charge_mdl', 'charge' );
	    $sift['where']['id'] = $charge_id;
	    $sift['where']['customer_id'] = $this->customer_id;
	    $sift['where']['status'] = 0;
	    $charge = $this->charge->Load ( $sift );
	    
	    if( !$charge )
	    { 
	        echo '<meta charset="utf-8">
		        <script type="text/javascript">
                    alert("该充值订单无效");
                	history.back();
                </script>';
            exit();
	    }
	    $price = $charge ['amount'] * 100;
	    
	    
	    //设置统一支付接口参数
	    //设置必填参数
	    //appid已填,商户无需重复填写
	    //mch_id已填,商户无需重复填写
	    //noncestr已填,商户无需重复填写
	    //spbill_create_ip已填,商户无需重复填写
	    //sign已填,商户无需重复填写
	    $unifiedOrder->setParameter("body","{$charge['remark']}:" . $charge ['charge_no']);//商品描述
	    $unifiedOrder->setParameter("out_trade_no",$charge ['charge_no'] );//商户订单号
	    $unifiedOrder->setParameter("total_fee",$price);//总金额
	    $unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址
	    $unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
	    //非必填参数，商户可根据实际情况选填
	    //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
	    //$unifiedOrder->setParameter("device_info","XXXX");//设备号
	    //$unifiedOrder->setParameter("attach","XXXX");//附加数据
	    //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
	    //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
	    //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
	    //$unifiedOrder->setParameter("openid","XXXX");//用户标识
	    //$unifiedOrder->setParameter("product_id","XXXX");//商品ID
	    
	    //获取统一支付接口结果
	    $unifiedOrderResult = $unifiedOrder->getResult();
	    
	    //print_r($unifiedOrderResult);
	    $code_url = "";
	    //商户根据实际情况设置相应的处理流程
	    if ($unifiedOrderResult["return_code"] == "FAIL")
	    {
	        //商户自行增加处理流程
	        echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
	    }
	    elseif($unifiedOrderResult["result_code"] == "FAIL")
	    {
	        //商户自行增加处理流程
	        echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
	        echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
	    }
	    elseif($unifiedOrderResult["code_url"] != NULL)
	    {
	        //从统一支付接口获取到code_url
	        $code_url = $unifiedOrderResult["code_url"];
	        //商户自行增加处理流程
	        //......
	    }
	    
	    $data['title'] = '微信扫码支付';
	    $data['price'] = $charge['amount'];
	    $data['order_sn'] = $charge ['charge_no'];
	    $data['unifiedOrderResult'] = $unifiedOrderResult;
	    $data['code_url'] = $code_url;
	    
	    $this->load->view ( 'head' ,$data );
	    $this->load->view ( '_header' ,$data );
	    $this->load->view ( 'property/wechat_qrcode', $data );
	    $this->load->view ( '_footer' ,$data ) ;
	    $this->load->view ( 'foot' ,$data );
	    
	    
	}
	
	/**
	 * 发起支付宝充值
	 */
	private function Alipay( $charge_id )
	{ 
	    //以后放在libarires
	    require_once(__DIR__."/../libraries/Alipaylib/Alipay.config.php");
	    require_once(__DIR__."/../libraries/Alipaylib/Alipay_submit.class.php");
	    
	    
	    //查询信息
	    $this->load->model ( 'Easy_charge_mdl', 'charge' );
	    $sift['where']['id'] = $charge_id;
	    $charge = $this->charge->Load ( $sift );
	    
	    //必填，不能修改
	    
	    //商户订单号
	    $out_trade_no = $charge['charge_no'];
	    
	    //订单名称
	    $subject = $charge['remark'];
	    //必填
	    
	    //付款金额
	    $total_fee = $charge['amount'];
	    //必填
	    
	    //订单描述
	    $body = $charge['remark'];
	    
	    //商品展示地址
	    $show_url = '';
	    //需以http://开头的完整路径，例如：http://www.xxx.com/myorder.html
	    
	    //防钓鱼时间戳
	    $anti_phishing_key = "";
	    //若要使用请调用类文件submit中的query_timestamp函数
	    
	    //客户端的IP地址
	    $exter_invoke_ip = "";
	    //非局域网的外网IP地址，如：221.0.0.1
	    
	    /************************************************************/
	    
	    //构造要请求的参数数组，无需改动
	    $parameter = array(
	        //2 = h5
	        "service" => $charge['charge_source'] == 2 ? 'alipay.wap.create.direct.pay.by.user': 'create_direct_pay_by_user',
	        "partner" => trim($alipay_config['partner']),
	        "payment_type"	=> $alipay_config['payment_type'],
	        "notify_url"	=> $alipay_config['notify_url'],//服务器异步通知
	        "return_url"	=> $alipay_config['return_url'],//同步跳转同步通知
	        "seller_email"	=> $alipay_config['seller_email'],//卖家支付宝帐户
	        "out_trade_no"	=> $out_trade_no,
	        "subject"	=> $subject,
	        "total_fee"	=> $total_fee,
	        "body"	=> $body,
	        "show_url"	=> $show_url,
	        "anti_phishing_key"	=> $anti_phishing_key,
	        "exter_invoke_ip"	=> $exter_invoke_ip,
	        "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
	    
	    );
	    
	    //建立请求
	    $alipaySubmit = new AlipaySubmit($alipay_config);
	    $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
	    echo $html_text;
	    exit();
	    
	}
	
	
}
?>