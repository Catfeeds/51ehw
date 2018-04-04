<?php
/**
 * Native（原生）支付-模式二-demo
 * ====================================================
 * 商户生成订单，先调用统一支付接口获取到code_url，
 * 此URL直接生成二维码，用户扫码后调起支付。
 * 
*/
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Native_dynamic_qrcode extends Front_Controller {

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
	 * 异步返回。
	 * @date:2017年12月14日 上午11:59:43
	 * @author: fxm
	 * @param: variable
	 * @return:
	 */
	

	public function charge( $charge_id , $status = 1 )
	{
	    
        include_once("WxPayPubHelper/WxPayPubHelper.php");
        
		//使用统一支付接口
		$unifiedOrder = new UnifiedOrder_pub();
		
		$this->load->model ( 'charge_mdl', 'charge' );
		$user_id = $this->session->userdata ( 'user_id' );
		$charge = $this->charge->load ( $charge_id, $user_id );
		
		if( !$charge || $charge['status'] == 1 ) 
		{ 
		    $return['status'] = 2 ;
		    $return['message'] = '订单不存在，或已成功支付';
		    echo json_encode( $return );
		    exit;
		}
		
		if( $status == 1 )
		{ 
		    $body = '充值';
		    $order_prefix = 'COR';
		    
		}else if ( $status == 2 )
		{ 
		    $body = '充值购物';
		    $order_prefix = 'POR';
		    
		}else if ( $status == 3 )
		{ 
		    $body = '现金开店';
		    $order_prefix = 'COP';
		}
		
		
		$price = $charge ['amount'] * 100;
		

		//设置统一支付接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//spbill_create_ip已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$unifiedOrder->setParameter("body","{$body}：" . $charge ['chargeno']);//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$out_trade_no = WxPayConf_pub::APPID."$timeStamp";
		$order_sn =  $charge ['chargeno'];
		$unifiedOrder->setParameter("out_trade_no",$order_prefix.$order_sn);//商户订单号 
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
		
		$data['price'] = $charge['amount'];
		$data['order_sn'] = $order_sn;
		$data['unifiedOrderResult'] = $unifiedOrderResult;
		$data['code_url'] = $code_url;
		
		echo json_encode($data);
		
	}
}



