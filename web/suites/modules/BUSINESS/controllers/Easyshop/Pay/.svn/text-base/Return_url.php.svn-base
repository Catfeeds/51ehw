<?php
/**
 * 通用通知接口 (同步)
 * ====================================================
 * 支付完成后，支付平台把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 */
class Return_url extends NLF_Controller {
    
    private $customer_id;
	public function __construct() 
	{
		parent::__construct ();
	    // 判断用户是否登录
		if (! $this->session->userdata('user_in')) {
		    redirect('customer/login');
		    exit();
		}
		
		$this->customer_id = $this->session->userdata('user_id');
	}
	/**
	 * 微信 && 支付宝 显示结果页面
	 */
	public function Notify_View( $charge_no = 0 ) 
	{
	    $message[0] = '充值号不存在';
	    $message[1] = '支付成功';
// 	    $message[2] = '支付取消';
	    $message[3] = '支付失败';
	    
	    //充值事件 1 普通充值现金 2 支付订单  3拼团支付 4面对面支付 5互助店开通
	   
	    
	    $title = $message[0];
	    $status = 3;
	    
	    $this->load->model ( 'charge_mdl', 'charge' );
	    $sift['where']['charge_no'] = $charge_no;
	    $sift['where']['customer_id'] = $this->customer_id;
	    $charge = $this->charge->Load_by_Change_No( $sift );
	    
	    if( $charge )
	    {
    	    //验证是否支付成功
	        if( $charge['status'] == 1 )
	        { 
	            $title = $message[1];
	            $status = 1;
	            
	            //成功的就转跳当前事件显示成功页面。
	            
	            if( $charge['charge_type'] == 2 )
	            { 
	                //调用接口获取订单ID。
	                $order_id = 1;//接口
	                Header ( "Location: ".ORDER_URL."Customer/Order/Payfinish?new_order_id={$order_id}&status=4" );
	            }
	            
	        }else{ 
	            //失败统一显示。
	            $title = $message[3];
	            $status = 3;
	        }
	    }        
    	

        $data['charge'] = $charge;
	    $data['message'] = $title;
	    $data['head_set'] = 2;
	    $data['status'] = $status;
	   
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('payment/afterpay_charge_view', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	 * 支付宝同步
	 */
	public function Alipay_Notify()
	{ 
	    
	    require_once(__DIR__."/../libraries/Alipaylib/Alipay.config.php");
	    require_once(__DIR__."/../libraries/Alipaylib/Alipay_notify.class.php");
	    
	    //计算得出通知验证结果
	    $alipayNotify = new AlipayNotify($alipay_config);
	    
	    //print_r($_GET);
	    
	    
	    $verify_result = $alipayNotify->verifyReturn();
	   
	    if( $verify_result ) 
	    {
	        //验证成功
	        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        //请在这里加上商户的业务逻辑程序代码
	        	
	        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	        //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
	    
	        //商户订单号
	    
	        $out_trade_no = $this->input->get('out_trade_no');
	        	
	        //$orderid =$this->input->get('out_orderid');
	        //$userid = $this->input->get('account');
	    
	        //支付宝交易号
	    
	        $trade_no = $this->input->get('trade_no');
	    
	        //交易状态
	        $trade_status = $this->input->get('trade_status');
	    
	        if($this->input->get('trade_status') == 'TRADE_FINISHED' || $this->input->get('trade_status') == 'TRADE_SUCCESS') 
	        {   
	            //判断该笔订单是否在商户网站中已经做过处理
	            //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
	            //如果有做过处理，不执行商户的业务程序
	           
// 	            $this->load->model('Charge_mdl');
// 	            $sift['where']['charge_no'] =  $out_trade_no;
// 	            $sift['where']['customer_id'] =  $this->customer_id;
// 	            $charge = $this->Charge_mdl->Load_by_Change_No( $sift );
	            
// 	            $data["status"] = 1;
	    	
	           
	        }else{
// 	            $data["title"] = "trade_status=".$this->input->get('trade_status').",请与客服联系：400-0029-777";
// 	            $data["status"] = 3;
	           
	    
	        }
	    
	        //echo "验证成功<br />";
	    
	        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	        	
	        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    }else{
	        //验证失败
	        //如要调试，请看alipay_notify.php页面的verifyReturn函数
// 	        $data["title"] = "验证失败,联系客服 400-0029-777";
// 	        $data["status"] = 3;
	        $out_trade_no = 0;
	         
	    }
	    
	    $this->Notify_View( $out_trade_no );
	    //print_r($data);
// 	    $data ['title'] = '充值通知';
// 	    $data ['head_set'] = 3;
// 	    $data ['foot_set'] = 1;
// 	    $this->load->view ( 'head', $data );
// 	    $this->load->view ( '_header', $data );
// 	    $this->load->view ('property/pay_notify',$data);
// 	    $this->load->view ( '_footer', $data );
// 	    $this->load->view ( 'foot', $data );
	    
	 }
	
}
?>