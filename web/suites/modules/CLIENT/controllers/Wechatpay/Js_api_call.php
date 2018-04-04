<?php
/**
 * JS_API支付demo
 * ====================================================
 * 在微信浏览器里面打开H5网页中执行JS调起支付。接口输入输出数据格式为JSON。
 * 成功调起支付需要三个步骤：
 * 步骤1：网页授权获取用户openid
 * 步骤2：使用统一支付接口，获取prepay_id
 * 步骤3：使用jsapi调起支付
 */
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Js_api_call extends Front_Controller {
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		
		$this->load->helper ( 'order' );
	}

	
	//1，充值, 2:拼团, 3:普通订单,  4：批量支付普通定订单
	//截取ID后一位做判断
	public function pay( $orderid ){ 
	    
	    include_once ("WxPayPubHelper/WxPayPubHelper.php");
	    
	    $orderid_info = explode("_",$orderid);
	    $charge_id = $orderid_info[0];
	    $status =  $orderid_info[1];//截取ID后一位做判断
	    
	    // 使用jsapi接口
	    $jsApi = new JsApi_pub ();
	    
	    
	    // =========步骤1：网页授权获取用户openid============
	    // 通过code获得openid
	    
	    if( $status == 1)
	    { 
	        $body = '充值';
	        $order_prefix = 'CHR';
	        
	        
	    }else if( $status == 2)
	    { 
	        $body = '充值购物';
	        $order_prefix = 'ODR';
	        
	    }else if( $status == 3){ 
	        
	        $body = '充值购物';
	        $order_prefix = 'POR';
	       
	    }else if( $status == 4){ 
	        $body = '充值购物';
	        $order_prefix = 'ALL';
	        
	    }else{ 
	         echo '<script type="text/javascript">
                    history.back(-2);
                </script>';
	        return ;
	    }
	    
	    if (! isset ( $_GET ['code'] ) ) {
	        // 触发微信返回code码
	        $url = $jsApi->createOauthUrlForCode ( urlencode (  WxPayConf_pub::JS_API_CALL_URL . "/" . $orderid  ) );
	        Header ( "Location: $url" );
	        exit();
	    } else {
	        // 获取code码，以获取openid
	        $code = $_GET ['code'];
	        $jsApi->setCode ( $code );
	        $openid = $jsApi->getOpenId ();
	        
	        if( empty($openid) )
	        {
	             
	            Header ( "Location: ".site_url('Member/info') );
	        }
	    }
	    
	    
	    
	    $this->load->model ( 'charge_mdl', 'charge' );
	    $user_id = $this->session->userdata ( 'user_id' );
	    $charge = $this->charge->load ( $charge_id );
	    $price = $charge ['amount'] * 100;
	    
	    $unifiedOrder = new UnifiedOrder_pub ();
	    
	    $unifiedOrder->setParameter ( "openid", "$openid" ); // 商品描述
	    $unifiedOrder->setParameter ( "body", "$body" . $charge ['chargeno'] ); // 商品描述
	    
	    // 自定义订单号，此处仅作举例
	    $timeStamp = time ();
	    $out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
	    $order_sn = $order_prefix . $charge ['chargeno'];
	    $unifiedOrder->setParameter ( "out_trade_no", $order_sn ); // 商户订单号
	    $unifiedOrder->setParameter ( "total_fee", $price ); // 总金额
	    $unifiedOrder->setParameter ( "notify_url", WxPayConf_pub::NOTIFY_URL ); // 通知地址
	    $unifiedOrder->setParameter ( "trade_type", "JSAPI" );
	    
	    // 交易类型
	    $prepay_id = $unifiedOrder->getPrepayId ();
	    // =========步骤3：使用jsapi调起支付============
	    $jsApi->setPrepayId ( $prepay_id );
	    
	    $data ['jsApiParameters'] = $jsApi->getParameters ();
	    
	    $data ['charge'] = $charge;
	    
	    if( $order_prefix == 'POR' || $order_prefix == 'ALL'){
	        $this->load->view ( 'payment/wechaypay', $data );
	    }else{ 
	        $this->load->view ( 'payment/wechat_charge', $data );
	    }
	}

}
?>

