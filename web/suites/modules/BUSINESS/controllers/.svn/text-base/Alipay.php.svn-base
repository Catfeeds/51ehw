<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alipay extends Front_Controller {
	


	public function __construct()
	{
	    header("Content-type:text/html;charset=utf-8");
		parent::__construct();

	}


	/**
	 *   发起充值
	 *  $status = null 充值; =1 普通订单支付；
	 **/
    
	public function charge_pay( $charge_id, $status = null )
	{
	    
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
		
		require_once("Alipay.config.php");
		require_once("Alipaylib/Alipay_submit.class.php");

	
		$this->load->model ( 'charge_mdl', 'charge' );
		$user_id = $this->session->userdata ( 'user_id' );
		$charge = $this->charge->load ( $charge_id );
        
		//更改成支付宝支付
		$this->charge->update_payment( $charge_id, 1 );
		 //支付类型
        $payment_type = "1";
        
        
        if( $status == 1 ){
            //异步通知页面路径
            $notify_url = site_url('alipay/order_notify');
            
            //同步通知页面路径
            $return_url = site_url('alipay/order_return');
           
            //订单名称
            $subject = "51易货网充值购物";
            
        }else{ 
            
           //异步通知页面路径
            $notify_url = site_url('alipay/chargenotify');
            
            //同步通知页面路径
            $return_url = site_url('alipay/chargereturn');
           
            //订单名称
            $subject = "51易货网充值";
        }
        //卖家支付宝帐户
        $seller_email = "3316981437@qq.com";//"wyehw@qq.com";//"371037888@qq.com";
        //必填

        //商户订单号
        $out_trade_no = $charge['chargeno'];
        $orderid = $charge['id'];
        //商户网站订单系统中唯一订单号，必填


        //付款金额
        $total_fee = $charge['amount'];
        //必填

        //订单描述
        $body = $subject;
        
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
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
// 				"notify_url"	=> $notify_url."/".$orderid."/".$this->session->userdata('user_id'),
// 				"return_url"	=> $return_url."/".$orderid."/".$this->session->userdata('user_id'),
    		    "notify_url"	=> $notify_url,
    		    "return_url"	=> $return_url,
		        "seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				//"orderid"	=> $orderid,
				//"account"	=> $this->session->userdata('user_id'),
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);
		
		//建立请求
		//print_r($parameter);
		//exit();
		$alipaySubmit = new AlipaySubmit($alipay_config);
		$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
		echo $html_text;
		exit();

	}


	
	
	/*wap支付提交*/
	function wapsubmit($charge_id){
	     
	    if (!$this->session->userdata('user_in')){
	        redirect('customer/login');
	        exit();
	    }
	     
	    require_once("Alipay.config.php");
	    require_once("Alipaylib/Alipay_submit.class.php");
	
	
	    $this->load->model ( 'charge_mdl', 'charge' );
	    $user_id = $this->session->userdata ( 'user_id' );
	    $charge = $this->charge->load ( $charge_id );
	
	    /**************************请求参数**************************/
	
	    //商户订单号，商户网站订单系统中唯一订单号，必填
	    $out_trade_no = $charge['chargeno'];//$_POST['WIDout_trade_no'];
	
	    //订单名称，必填
	    $subject = '51易货网充值';//$_POST['WIDsubject'];
	
	    //付款金额，必填
	    $total_fee = $charge['amount'];//$_POST['WIDtotal_fee'];
	
	    //收银台页面上，商品展示的超链接，必填
	    $show_url = site_url('customer/fortune');//'http://www.51ehw.com/customer/fortune';//$_POST['WIDshow_url'];
	
	    //商品描述，可空
	    $body = '51易货网充值';//$_POST['WIDbody'];
	
	
	
	    /************************************************************/
	
	    //构造要请求的参数数组，无需改动
	    $parameter = array(
	        "service"       => 'alipay.wap.create.direct.pay.by.user',
	        "partner"       => $alipay_config['partner'],
	        "seller_id"  => $alipay_config['partner'],
	        "payment_type"	=> '1',
	        "notify_url"	=> site_url('alipay/chargenotify'),//"http://www.51ehw.com/alipay/chargenotify",//异步通知方法
	        "return_url"	=> site_url('alipay/chargereturn'),//"http://www.51ehw.com/alipay/chargereturn",//同步通知返回
	        "_input_charset"	=> trim(strtolower($alipay_config['input_charset'])),
	        "out_trade_no"	=> $out_trade_no,
	        "subject"	=> $subject,
	        "total_fee"	=> $total_fee,
	        "show_url"	=> $show_url,
	        "body"	=> $body,
	        //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
	        //如"参数名"	=> "参数值"   注：上一个参数末尾需要“,”逗号。
	
	    );
	
	    //建立请求
	    $alipaySubmit = new AlipaySubmit($alipay_config);
	    $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
	    echo $html_text;
	    	
	}
	
	
	/**
	 *  发起充值
	 *  $status = null 充值; = 3开店支付；
	 **/
	
	public function pay( $charge_id, $status = 3 )
	{
	     
	    if ( !$this->session->userdata('user_in') )
	    {
	        redirect('customer/login');
	        exit();
	    }
	
	    require_once("Alipay.config.php");
	    require_once("Alipaylib/Alipay_submit.class.php");
	
	
	    $this->load->model ( 'charge_mdl', 'charge' );
	    $user_id = $this->session->userdata ( 'user_id' );
	    $charge = $this->charge->load ( $charge_id , $user_id );
	
	    if( !$charge || $charge['status'] == 1 )
	    {
	        echo '<meta charset="utf-8">
                <script type="text/javascript">
                    alert("订单不存在，或已成功支付");
                    history.back();
                </script>';
	        exit();
	       
	    }
	
	    if( $status == 3 )
	    {
	        //异步通知页面路径
	        $notify_url = site_url('alipay/shop_notify');
	
	        //同步通知页面路径
	        $return_url = site_url('alipay/shop_return');
	         
	        //订单名称
	        $subject = "51易货网开店";
	
	    }
	
	    //支付宝帐户
	    $seller_email = "3316981437@qq.com";//"wyehw@qq.com";//"371037888@qq.com";
	    //必填
	
	    //商户订单号
	    $out_trade_no = $charge['chargeno'];
	
	    //付款金额
	    $total_fee = $charge['amount'];
	   
	    //订单描述
	    $body = $subject;
	
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
	        "service" => "create_direct_pay_by_user",
	        "partner" => trim($alipay_config['partner']),
	        "payment_type"	=> 1,
	        "notify_url"	=> $notify_url,
	        "return_url"	=> $return_url,
	        "seller_email"	=> $seller_email,
	        "out_trade_no"	=> $out_trade_no,
	        //"orderid"	=> $orderid,
	        //"account"	=> $this->session->userdata('user_id'),
	        "subject"	=> $subject,
	        "total_fee"	=> $total_fee,
	        "body"	=> $body,
	        "show_url"	=> $show_url,
	        "anti_phishing_key"	=> $anti_phishing_key,
	        "exter_invoke_ip"	=> $exter_invoke_ip,
	        "_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
	    );
	
	    //建立请求
	    //print_r($parameter);
	    //exit();
	    $alipaySubmit = new AlipaySubmit($alipay_config);
	    $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
	    echo $html_text;
	    exit();
	
	}
	
	
	//--------------------开店返回方法开始--------------------//
	public function shop_notify()
	{
	    error_log("came in after_pay!");
	    require_once("Alipay.config.php");
	    require_once("Alipaylib/Alipay_notify.class.php");
	    
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if( $verify_result ) 
		{ 
		    //商户订单号
		    $out_trade_no = $this->input->post('out_trade_no');
			$trade_no = $this->input->post('trade_no');//支付宝交易号
		    $trade_status = $this->input->post('trade_status');//交易状态
		
			//交易金额
			$total_fee = $this->input->post('total_fee');
		
		    if( $trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS' ) 
		    {

		        $this->load->helper('pay_return_config');
		        $return_info = select_return_info('COP');
		        
		        if( $return_info['status'] != 1 )
		        {
		            error_log('支付COP.未定义转跳路径');
		            exit();
		        }
		        
		        do{
		             
		            $this->load->model ( 'charge_mdl', 'charge' );
		            $charge = $this->charge->load_byChangeNum ( $out_trade_no );
		             
		            if ( !$charge )
		            {
		                error_log('订单不存在');
		                break;
		            }
		        
		        
		            if( $total_fee != $charge['amount'] )
		            {
		                error_log('订单金额错误,充值交易失败！');
		                $this->charge_mdl->update_status($orderId,5);
		                break;
		            }
		        
		            //开店处理方法。
		            $model = $return_info['model']; //MODEL。
		            $function = $return_info['function'];//MODEL中处理逻辑的方法
		            $this->load->model($model);//实例化。
		            $is_ok = $this->$model->$function( $charge, $trade_no,'支付宝支付' );
		        
		        }while(0);
		         
		    }
		    
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		    if( !empty( $is_ok ) ) 
		    {
		    	echo "success";		//请不要修改或删除
		    }
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}else {
		    
		    //验证失败
		    echo "fail";
		
		    //调试用，写文本函数记录程序运行情况是否正常
		    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}

	//--------------------开店返回方法结束--------------------//


	//--------------------开店同步方法开始--------------------//
	public function shop_return()
	{
	    
		require_once("Alipay.config.php");
		require_once("Alipaylib/Alipay_notify.class.php");

				//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
	    $verify_result = $alipayNotify->verifyReturn();
		
		if($verify_result) 
		{
		    //验证成功
			$out_trade_no = $this->input->get('out_trade_no');
			$trade_no = $this->input->get('trade_no');//支付宝交易号
		    $trade_status = $this->input->get('trade_status');//交易状态

			//交易金额
			$total_fee = $this->input->get('total_fee');
			
		    if( $trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') 
		    {
				
		        $this->load->helper('pay_return_config');
		        $return_info = select_return_info('COP');
		        
		        if( $return_info['status'] != 1 )
		        {
		            alert('未定义转跳路径');
		            exit();
		        }
		        
		        do{
		             
		            $this->load->model ( 'charge_mdl', 'charge' );
		            $charge = $this->charge->load_byChangeNum ( $out_trade_no );
		           
		            if ( !$charge )
		            {
		                alert('订单不存在');
		                break;
		            }
		        
		            
		            if( $total_fee != $charge['amount'] )
		            {
		                alert('订单金额错误,充值交易失败！');
		                $this->charge_mdl->update_status($orderId,5);
		                break;
		            }
		        
		            //开店处理方法。
		            $model = $return_info['model']; //MODEL。
		            $function = $return_info['function'];//MODEL中处理逻辑的方法
		            $this->load->model($model);//实例化。
		            $is_ok = $this->$model->$function( $charge, $trade_no,'支付宝支付' );
		              
		        }while(0);
		 		
		 		$code = 2;
		 		
				if ( !empty( $is_ok ) ) 
				{
				    $code = 1;
				}
		
		    }else {
		        
 		        $code = 3;
		    }
				
		}else {
		   
		   $code = 3;
		   
		}
		
		redirect('corporation/pay_notify/'.$code);
// 		$data ['title'] = '支付结果';
// 		$data ['head_set'] = 3;
// 		$data ['foot_set'] = 1;
// 		$this->load->view ( 'head', $data );
// 		$this->load->view ( '_header', $data );
// 		$this->load->view('merchant/pay_notify',$data);
// 		$this->load->view ( 'foot', $data );
		
	}
	//--------------------开店同步方法结束--------------------//


	//--------------------充值返回方法开始--------------------//
	public function chargenotify()
	{
	    error_log("came in after_pay!");
	    require_once("Alipay.config.php");
	    require_once("Alipaylib/Alipay_notify.class.php");
	    
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if( $verify_result ) 
		{
			
			$out_trade_no = $this->input->post('out_trade_no');//商户订单号
			$trade_no = $this->input->post('trade_no');//支付宝交易号
			$trade_status = $this->input->post('trade_status');//交易状态
		
			
		
		    if( $trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS' ) 
		    {
				$is_ok = $this->after_pay($out_trade_no, $trade_no);
			}
			
		    //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		    if( !empty( $is_ok ) )
		    { 
		        echo "success";
		    }
			
		}else {
		    //验证失败
		    echo "fail";
		
		    //调试用，写文本函数记录程序运行情况是否正常
		    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		}
	}
	
	public function chargereturn()
	{
		
		require_once("Alipay.config.php");
		require_once("Alipaylib/Alipay_notify.class.php");

				//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
	    $verify_result = $alipayNotify->verifyReturn();
		if($verify_result) 
		{
		
			
		    $out_trade_no =$this->input->get('out_trade_no');//商户订单号
		    $trade_no = $this->input->get('trade_no');//支付宝交易号
		    $trade_status = $this->input->get('trade_status');//交易状态

		    if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') 
		    {
				
		 		$is_ok = $this->after_pay($out_trade_no, $trade_no);

				if( $is_ok )
				{
					
                    $data["message"] = "支付成功！";
					$data["code"] = 1;
					$data["orderid"] = $out_trade_no;
						
					
				}else
				{

	 				$data["message"] = '充值单状态不正确，充值单或已完成充值。';
	 				$data["code"] = 0;
	 				$data["orderid"] = $out_trade_no;
						
				}
		
		    }else {
		        
		      $data["message"] = "trade_status=".$this->input->get('trade_status').",请与客服联系：400-0029-777";
		      $data["code"] = 0;
		      $data["orderid"] = $out_trade_no;
		      
		    }
				
    	}else {
		    //验证失败
		    //如要调试，请看alipay_notify.php页面的verifyReturn函数
		   $data["message"] = "验证失败,联系客服 400-0029-777";
		   $data["code"] = 0;
		   $data["orderid"] = 0;
		   
		}
		//print_r($data);
		$data ['title'] = '充值通知';
		$data ['head_set'] = 3;
		$data ['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view('property/pay_notify',$data);
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
		
	}


	
	//--------------------普通订单充值支付返回方法开始--------------------//
	
	public function order_notify()
	{
	    error_log("came in after_pay!");
	    require_once("Alipay.config.php");
	    require_once("Alipaylib/Alipay_notify.class.php");
	     
	    $alipayNotify = new AlipayNotify($alipay_config);
	    $verify_result = $alipayNotify->verifyNotify();
	
	    if($verify_result) 
	    {
                      
	        $out_trade_no = $this->input->post('out_trade_no');//商户订单号
	        $trade_no = $this->input->post('trade_no');//支付宝交易号
	        $trade_status = $this->input->post('trade_status'); //交易状态
	
	
	        if( $trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') 
	        {
	            
	            $is_ok = $this->after_order($out_trade_no, $trade_no);
	
	        }
	        
	
	        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	        if( !empty( $is_ok ) )
	        {
	           echo "success";		//请不要修改或删除
	        }
	        
        }else {
	        //验证失败
	        echo "fail";
	
	        //调试用，写文本函数记录程序运行情况是否正常
	        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
	    }
	}
	
	public function order_return()
	{
	
	    require_once("Alipay.config.php");
	    require_once("Alipaylib/Alipay_notify.class.php");
	
	    //计算得出通知验证结果
	    $alipayNotify = new AlipayNotify($alipay_config);
	
	
	    $verify_result = $alipayNotify->verifyReturn();
	    if($verify_result) 
	    {
	        
	
	        $out_trade_no =$this->input->get('out_trade_no');//商户订单号
	        $trade_no = $this->input->get('trade_no');//支付宝交易号
	        $trade_status = $this->input->get('trade_status');//交易状态
	        
	
	
	        if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') 
	        {
	            
	            $this->load->model("charge_mdl");
	            $this->load->model("Order_mdl");
	            
	            // 查询该支付订单;
	            $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	            
	           
	            if( !empty($charge) && $charge['status'] == 1 && $charge['order_sn'])
	            {
	            
	                $order_info = $this->Order_mdl->load_by_sn( $charge['order_sn'] );
	                $data["message"] = "支付成功！";
	                $data["code"] = 1;
	                $data["orderid"] = $order_info['id'];
	                
	            }else{
	                 
	                $data["message"] = "trade_status=".$this->input->get('trade_status').",请与客服联系：400-0029-777";
	                $data["code"] = 0;
	                 
	            }
	           
	
	        }else {
	            
	            $data["message"] = "trade_status=".$this->input->get('trade_status').",请与客服联系：400-0029-777";
	            $data["code"] = 0;
	            $data["orderid"] = 0;
	
	        }
	
	        //echo "验证成功<br />";
	
	        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	        	
	        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    }else {
	        //验证失败
	        //如要调试，请看alipay_notify.php页面的verifyReturn函数
	        $data["message"] = "验证失败,联系客服 400-0029-777";
	        $data["code"] = 0;
	        $data["orderid"] = 0;
	         
	    }
	    
	    
	    //print_r($data);
	    $data ['title'] = '充值通知';
	    $data ['head_set'] = 3;
	    $data ['foot_set'] = 1;
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view('property/order_notify',$data);
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	
	}
	
	
	
	

	//--------------------充值返回方法结束--------------------//
	
	
	
	//充值支付成功返回逻辑代码
	private function after_pay( $out_trade_no, $trade_no ){
	     
	    //充值订单信息
	    $this->load->model("charge_mdl");
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	    $user_id = $charge['customer_id'];
	    $charge_id = $charge['id'];
	    //如果该订单状态是未支付的 才执行
	    if($charge && $trade_no ){
	         
	        if($charge['status'] == 1)
	        {
	            return true; //已经充值过
	        }
	
	        $this->db->trans_begin(); //事物执行方法中的MODEL。
	        	
	        // 修改订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'支付宝充值',$trade_no );
	        $charge_cash = $charge['amount']; //该充值订单的金额
	        	
	        if( $charge_row )
	        {
	            //调用接口处理
	            $url = $this->url_prefix.'Notify_url/after_pay_charge';
	             
	            $data_post['customer_id'] = $user_id;
	            $data_post['charge_cash'] = $charge['amount'];
	            $data_post['chargeno'] = $charge['chargeno'];
	            $data_post['app_id'] =  $this->session->userdata('app_info')['id'];
	            $is_ok = $this->curl_post_result($url,$data_post);
	             
	            if ( $is_ok )
	            {
	                $this->db->trans_commit();
	                return true;
	            } 
	            
                $this->db->trans_rollback();
                return false;
	            
	             
	        }else{
	            //该订单可能已支付过
	            $this->db->trans_rollback();
	            return false;
	        }
	         
	    }else{
	        return false;
	    }
	
	}
	
	//--------------------充值返回方法结束--------------------//
	
	
	
	
	// 	private
	//@$out_trade_no = 发起支付的单号，
	//@$trade_no = 微信单号
	private function after_order( $out_trade_no, $trade_no ){
	    $this->load->model("charge_mdl");
	    $this->load->helper ( 'order' );
	
	    $is_ok =  false;//成功与否标示
	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	
	    if( !empty($charge['order_sn'])   ){
	
	        $this->db->trans_begin(); //事物执行方法中的MODEL。
	
	        // 修改充值订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'支付宝支付订单',$trade_no );
	
	        //如果该订单状态修改成功 才执行
	        if($charge_row)
	        {
	            //订单信息
	            $this->load->model('order_mdl');
	            $order_info = $this->order_mdl->load_by_sn($charge['order_sn']);
	             
	            if( $order_info )
	            {
	                //商家信息
	                $this->load->model('customer_corporation_mdl');
	                $corp_customer = $this->customer_corporation_mdl->corp_load($order_info['corporation_id']);
	                 
	                if( $corp_customer )
	                {
	                     
	                    //修改订单状态
	                    $change_status =  4;
	                     
	                    $up_status = $this->order_mdl->order_confirm_paid( $order_info['order_sn'], $change_status  );
	                     
	                    if($up_status)
	                    {
	                        //构造数据调用接口处理
	                        $data_post['customer_id'] = $charge['customer_id'];
	                        $data_post['charge_cash'] = $charge['amount'];
	                        $data_post['app_id'] =  0;
	                        $data_post['chargeno'] = $charge['chargeno'];
	                        $data_post['order_total_price'] =  $order_info['total_price'];
	                        $data_post['corp_customer_id'] =  $corp_customer['customer_id'];
	                        $data_post['order_sn'] = $order_info['order_sn'];
	                        $data_post['commission'] = $order_info['commission'];
	                        $data_post['app_id'] = $order_info['app_id'];
	                        $data_post['charge_commission'] = $charge['commission'];
	                         
	                         
	                        $url = $this->url_prefix.'Notify_url/after_pay_order';
                            $error = json_decode($this->curl_post_result($url,$data_post),true);
                            //调用接口处理吧，骚年。
                             
                            if($error['status'] == 1)
                            {
                                $this->db->trans_commit();
                                $is_ok = true;
                                
                                //支付成功,插入支付成功信息
                                $this->load->model('Customer_message_mdl',"Message");
                                $this->load->model('Customer_mdl');
                                $customer_info = $this->Customer_mdl->load( $charge['customer_id'] );
                                //模板
                                $Msg_info['template_id']= 6;
                                //标题
                                $Msg_info['customer_id']= $charge['customer_id'];
                                $Msg_info['obj_id'] = $order_info['id'];
                                $Msg_info['type'] = 2;
                                $Msg_info['parameter']['name'] = !empty($customer_info['nick_name']) ? $customer_info['nick_name'] : $customer_info['name'];
                                $Msg_info['parameter']['number'] = $order_info['order_sn'];
                                $this->Message->Create_Message($Msg_info);
                                 
                            }else if( $error['status'] == 2 )
                            {
                                 
                                $this->db->trans_rollback();
                                //调用充值方法。
                                $this->after_pay($out_trade_no,$trade_no);
                                return;
                            }
	                        
	                    }
	                }
	            }
	            
	        }else{
	            //该订单可能已支付过
	            $this->db->trans_rollback();
	            return false;
	        }
	
	        //判断流程是否完成
	        if( empty( $is_ok ) )
	        {
	            $this->db->trans_rollback();
	            return false;
	            
	        }else{
	            
	            return true;
	        }
	         
	    }else{
	        return false;
	    }
	}
	
	//--------------------普通订单充值支付返回方法开始--------------------//
}
