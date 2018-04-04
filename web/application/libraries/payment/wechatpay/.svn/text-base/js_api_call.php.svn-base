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
	/**
	 * 支付订单
	 * 
	 * @param String $orderid
	 *        	订单号，或者充值单号
	 */
	public function pay($orderid) {

		include_once ("WxPayPubHelper/WxPayPubHelper.php");
		// 使用jsapi接口
		$jsApi = new JsApi_pub ();
		
		// =========步骤1：网页授权获取用户openid============
		// 通过code获得openid
		
		// $orderid = 97;
		
		if (! isset ( $_GET ['code'] )) {
			// 触发微信返回code码
			$url = $jsApi->createOauthUrlForCode ( urlencode ( WxPayConf_pub::JS_API_CALL_URL . "/" . $orderid ) );
			Header ( "Location: $url" );
		} else {
			// 获取code码，以获取openid
			$code = $_GET ['code'];
			$jsApi->setCode ( $code );
			$openid = $jsApi->getOpenId ();
		}
		
		$this->load->model ( 'order_mdl' );
		$user_id = $this->session->userdata ( 'user_id' );
		$order = $this->order_mdl->load ( $orderid );
		$price = $order ['total_price'] * 100;
		// =========步骤2：使用统一支付接口，获取prepay_id============
		// 使用统一支付接口

		$unifiedOrder = new UnifiedOrder_pub ();
		
		// 设置统一支付接口参数
		// 设置必填参数
		// appid已填,商户无需重复填写
		// mch_id已填,商户无需重复填写
		// noncestr已填,商户无需重复填写
		// spbill_create_ip已填,商户无需重复填写
		// sign已填,商户无需重复填写
		$unifiedOrder->setParameter ( "openid", "$openid" ); // 商品描述
		$unifiedOrder->setParameter ( "body", "订单：" . $order ['order_sn'] ); // 商品描述
		                                                                     // 自定义订单号，此处仅作举例
		$timeStamp = time ();
		$out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
		$order_sn = "ODR" . $order ['order_sn'];
		$unifiedOrder->setParameter ( "out_trade_no", $order_sn ); // 商户订单号
		$unifiedOrder->setParameter ( "total_fee", $price ); // 总金额
		$unifiedOrder->setParameter ( "notify_url", WxPayConf_pub::NOTIFY_URL ); // 通知地址
		$unifiedOrder->setParameter ( "trade_type", "JSAPI" ); // 交易类型
		                                                       // 非必填参数，商户可根据实际情况选填
		                                                       // $unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号
		                                                       // $unifiedOrder->setParameter("device_info","XXXX");//设备号
		                                                       // $unifiedOrder->setParameter("attach","XXXX");//附加数据
		                                                       // $unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
		                                                       // $unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间
		                                                       // $unifiedOrder->setParameter("goods_tag","XXXX");//商品标记
		                                                       // $unifiedOrder->setParameter("openid","XXXX");//用户标识
		                                                       // $unifiedOrder->setParameter("product_id","XXXX");//商品ID
		
		$prepay_id = $unifiedOrder->getPrepayId ();
		// =========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId ( $prepay_id );
		
		$data ['jsApiParameters'] = $jsApi->getParameters ();
		
		$data ['order'] = $order;
		
		$this->load->view ( 'payment/wechaypay', $data );
	}
	
	//---------------------------------------------------------------
	
	/**
	 * 充值
	 * 
	 * @param String $orderid
	 *        	订单号，或者充值单号
	 */
	public function charge($orderid) {
		include_once ("WxPayPubHelper/WxPayPubHelper.php");
		// 使用jsapi接口
		$jsApi = new JsApi_pub ();
		
		// =========步骤1：网页授权获取用户openid============
		// 通过code获得openid
		
		// $orderid = 97;
		
		if (! isset ( $_GET ['code'] )) {
			// 触发微信返回code码
			$url = $jsApi->createOauthUrlForCode ( urlencode ( WxPayConf_pub::JS_API_CALL_URL_CHARGE . "/" . $orderid  ) );
			Header ( "Location: $url" );
		} else {
			// 获取code码，以获取openid
			$code = $_GET ['code'];
			$jsApi->setCode ( $code );
			$openid = $jsApi->getOpenId ();
		}
		
		$this->load->model ( 'charge_mdl', 'charge' );
		$user_id = $this->session->userdata ( 'user_id' );
		$charge = $this->charge->load ( $orderid );
		$price = $charge ['amount'] * 100;
		
		$unifiedOrder = new UnifiedOrder_pub ();
		
		$unifiedOrder->setParameter ( "openid", "$openid" ); // 商品描述
		$unifiedOrder->setParameter ( "body", "充值：" . $charge ['chargeno'] ); // 商品描述
		                                                                      
		// 自定义订单号，此处仅作举例
		$timeStamp = time ();
		$out_trade_no = WxPayConf_pub::APPID . "$timeStamp";
		$order_sn = "CHR" . $charge ['chargeno'];
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
		
		$this->load->view ( 'payment/wechat_charge', $data );
	}
}
?>

