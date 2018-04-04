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
// 		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		
		$this->load->helper ( 'order' );
	}
    //主域名发起支付文件
    //默认B端自身
	public function pay( $orderid ){ 
	    
	    include_once ("WxPayPubHelper/WxPayPubHelper.php");
	    
	    $orderid_info = explode("_",$orderid);
	    $charge_id = $orderid_info[0];
	    
	    // 使用jsapi接口
	    $jsApi = new JsApi_pub ();
	    $status =  $orderid_info[1];//截取ID后一位做判断
	    
	    
	    //首先判断是B端还是C端发起的支付
	    if($orderid_info[2] == 'B')
	    { 
	        //B端自身
	        
	        // 通过code获得openid
	        if( $status == 1)
	        {
	            $body = '充值';
	            $order_prefix = 'CHR';
	             
	             
	        }else if( $status == 2)
	        {
	            $body = '充值购物';
	            $order_prefix = 'ODR';
	             
	        }else if( $status == 3 ){
	             
	            $body = '充值购物';
	            $order_prefix = 'POR';

	        }else if( $status == 4 ){
	            
	            $body = '缴费开店';//微信
	            $order_prefix = 'COP';

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
	         
	        if( $order_prefix == 'POR')
	        {
	            $this->load->view ( 'payment/wechaypay', $data );
	            
	        }else if( $order_prefix == 'COP'){
	            
	            $this->load->view ( 'payment/wechat_cash_shop', $data );
	            
	        }else{ 
	            $this->load->view ( 'payment/wechat_charge', $data );
	        }
	        
	        
	    }
// 	    else{ 
	        
// 	        //C端发起的支付验证CODE后返回回去处理
	        
//             // 获取code码，以获取openid
//             $code = $_GET ['code'];
        
//             //返回给C端处理
//             $C_url = 'http://c.51ehw.com/_CLIENT/Wechatpay/Js_api_call/pay/'.$orderid.'?code='.$code.'&state=STATE';
//             Header ( "Location: $C_url" );
	           
	        
	        
// 	    }
	    
	}
	
    	
    	
    /** 
     * 微信退款 
     * @param  $charge_id 充值单。
     * @param  $order_sn 对应要退款的订单。
      
     */  
    function wxRefund( $charge_id = 0 , $order_sn = 0 )
    {  
        include_once ("WxPayPubHelper/WxPayPubHelper.php");
            
        $input = new Refund_pub();  
        $input->setParameter('transaction_id',123);     //微信官方生成的订单流水号，在支付成功中有返回  
        $input->setParameter('out_refund_no',123); //退款本地需要记录的单号。
        $input->setParameter('refund_fee',123);//退款总金额，订单总金额，单位为分，只能为整数  
        $input->setParameter('op_user_id',WxPayConf_pub::MCHID);
        $input->setParameter('total_fee',123);
        
        $refundResult = $input->getResult();
        //商户根据实际情况设置相应的处理流程,此处仅作举例
        if ($refundResult["return_code"] == "FAIL") 
        {
            echo "通信出错：".$refundResult['return_msg']."<br>";
            
        }else if ( $refundResult["return_code"] == "SUCCESS")
        { 
            
        }
        
        
    }

}



