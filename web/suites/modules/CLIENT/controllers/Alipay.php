<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alipay extends Front_Controller {
	


	public function __construct()
	{
	    header("Content-type:text/html;charset=utf-8");
		parent::__construct();

	}


	public function payreturn($orderid,$userid)
	{
		
		require_once("Alipay.config.php");
		require_once("Alipaylib/Alipay_notify.class.php");

				//计算得出通知验证结果
		$alipayNotify = new AlipayNotify($alipay_config);
		
		//print_r($_GET);
		
	
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		
			//商户订单号
		
			$out_trade_no =$this->input->get('out_trade_no');
			
			//$orderid =$this->input->get('out_orderid');
			//$userid = $this->input->get('account');
		
			//支付宝交易号
		
			$trade_no = $this->input->get('trade_no');
		
			//交易状态
			$trade_status = $this->input->get('trade_status');

		    if($this->input->get('trade_status') == 'TRADE_FINISHED' || $this->input->get('trade_status') == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
				//$data["message"] = '支付成功';
		 		//$data["code"] = 1;
				$this->load->model('order_mdl');
				$order = $this->order_mdl->load($orderid);
				if($order && $order["status"]<2 )
				{
						
					if($order["order_type"]==0)
					{
						//$order_item =  $this->order_mdl->find_order_items($orderid);
	
						$this->order_mdl->order_pay($orderid);
						
						//修改用户为有效用户
						$this->load->model("customer_mdl");
						$this->customer_mdl->updateByCondition(array("is_valid"=>1),array("id"=>$userid,"is_valid"=>0));
						
						//回扣
						$this->order_mdl->addRebate($orderid,$userid);

						$data["message"] = "支付成功！";
						$data["code"] = 1;
						$data["orderid"] = $orderid;
						$data["payment_id"]=4;
					}else
					{
						$this->order_mdl->order_payyugou($orderid);
						
						$data["message"] = "支付成功！";
						$data["code"] = 2;
						$data["orderid"] = $orderid;
						$data["payment_id"]=4;
					}
					
				}else
				{

		 				$data["message"] = '订单状态不付';
		 				$data["code"] = 0;
		 				$data["orderid"] = 0;
		 				$data["payment_id"] = 4;

				}
		
		    }
		    else {
		      $data["message"] = "trade_status=".$this->input->get('trade_status');
		      $data["code"] = 0;
		      $data["orderid"] = 0;
		      $data["payment_id"]=4;
		    }
				
			//echo "验证成功<br />";
		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
		    //验证失败
		    //如要调试，请看alipay_notify.php页面的verifyReturn函数
		   $data["message"] = "验证失败,联系客服 400-6569333";
		   $data["code"] = 0;
		   $data["orderid"] = 0;
		   $data["payment_id"]=4;
		}
		//print_r($data);
		$this->load->view('order/paysuccess',$data);
	}


	/*******充值*******************************************/

	public function charge_pay( $charge_id )
	{
	    
		if (!$this->session->userdata('user_in')){
			redirect('customer/login');
			exit();
		}
		
		require_once("Alipay.config.php");
		require_once("Alipaylib/Alipay_submit.class.php");

		
		//$this->load->library('payment/alipay_submit.class');
/*
		$amount = $this->input->post('amount');
		
		//新建充值单
		$userid = $this->session->userdata('user_id');


		$data = array("customer_id"=>$userid,"amount"=>$amount,"payment_id"=>4,"status"=>0);

		$this->load->model('charge_mdl');
				
		do{

			$order_sn = $this->get_chargenum();
			
			if ($this->charge_mdl->check_ordernum($order_sn)){
				$order_exist = true;
			}else{
				
				$data["chargeno"] = $order_sn;
				$this->charge_mdl->create($data);
				$new_order_id = $this->db->insert_id();
				$order_exist = false;
			}
		}while($order_exist);
*/
		$this->load->model ( 'charge_mdl', 'charge' );
		$user_id = $this->session->userdata ( 'user_id' );
		$charge = $this->charge->load ( $charge_id );
        
		 //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = site_url('alipay/chargenotify');//"http://www.51ehw.com/alipay/chargenotify";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = site_url('alipay/chargereturn');//"http://www.51ehw.com/alipay/chargereturn";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        //卖家支付宝帐户
        $seller_email = "3316981437@qq.com";//"371037888@qq.com";
        //必填

        //商户订单号
        $out_trade_no = $charge['chargeno'];
        $orderid = $charge['id'];
        //商户网站订单系统中唯一订单号，必填

        //订单名称
        $subject = "51易货网充值";
        //必填

        //付款金额
        $total_fee = $charge['amount'];
        //必填

        //订单描述

        $body = "51易货网充值";
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
	
	
	public function chargenotify()
	{
	    error_log("came in after_pay!");
	    require_once("Alipay.config.php");
	    require_once("Alipaylib/Alipay_notify.class.php");
	    
		$alipayNotify = new AlipayNotify($alipay_config);
		$verify_result = $alipayNotify->verifyNotify();

		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代
		
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
			
		    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
			
			//商户订单号
		
			$out_trade_no = $this->input->post('out_trade_no');
		
			//支付宝交易号
		
			$trade_no = $this->input->post('trade_no');
		
			//交易状态
			$trade_status = $this->input->post('trade_status');
		
		
		    if($this->input->post('trade_status') == 'TRADE_FINISHED') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//该种交易状态只在两种情况下出现
				//1、开通了普通即时到账，买家付款成功后。
				//2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。
		
		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		        
// 		        $this->load->model('charge_mdl');
// 				$charge = $this->charge_mdl->load($orderid);
                $is_ok = $this->after_pay($out_trade_no, $trade_no);
				
		    }
		    else if ($this->input->post('trade_status') == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
						
				//注意：
				//该种交易状态只在一种情况下出现——开通了高级即时到账，买家付款成功后。
		
		        //调试用，写文本函数记录程序运行情况是否正常
		        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
		        
// 		        $this->load->model('charge_mdl');
// 				$charge = $this->charge_mdl->load($orderid);
		        $is_ok = $this->after_pay($out_trade_no, $trade_no);
				
				
		    }
		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		        
			echo "success";		//请不要修改或删除
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
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
		
		//print_r($_GET);
		
	
		$verify_result = $alipayNotify->verifyReturn();
		if($verify_result) {//验证成功
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//请在这里加上商户的业务逻辑程序代码
			
			//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		
			//商户订单号
		
			$out_trade_no =$this->input->get('out_trade_no');
			
			//$orderid =$this->input->get('out_orderid');
			//$userid = $this->input->get('account');
		
			//支付宝交易号
		
			$trade_no = $this->input->get('trade_no');
		
			//交易状态
			$trade_status = $this->input->get('trade_status');

		    if($this->input->get('trade_status') == 'TRADE_FINISHED' || $this->input->get('trade_status') == 'TRADE_SUCCESS') {
				//判断该笔订单是否在商户网站中已经做过处理
					//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
					//如果有做过处理，不执行商户的业务程序
				//$data["message"] = '支付成功';
		 		//$data["code"] = 1;
		 		$is_ok = $this->after_pay($out_trade_no, $trade_no);
		 		
// 				$this->load->model('charge_mdl');
// 				$charge = $this->charge_mdl->load($orderid);
				if($is_ok)
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
		
		    }
		    else {
		      $data["message"] = "trade_status=".$this->input->get('trade_status').",请与客服联系：400-0029-777";
		      $data["code"] = 0;
		      $data["orderid"] = $out_trade_no;
		      
		    }
				
			//echo "验证成功<br />";
		
			//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		}
		else {
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


	function get_chargenum()
	{

		return '8'.date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
	}
	
	//支付成功返回逻辑代码
	private  function after_pay( $out_trade_no, $trade_no){ 
	    
        //充值订单信息
	    $this->load->model("charge_mdl");
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	    $user_id = $charge['customer_id'];
	    $charge_id = $charge['id'];
	    //如果该订单状态是未支付的 才执行
	    if($charge && $trade_no ){
	        
	        if($charge['status'] == 1){ 
	            return true; //已经充值过
	        }
    	   
    	    $this->db->trans_begin(); //事物执行方法中的MODEL。
    	    
    	    // 修改订单状态为已支付
    	    $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'支付宝订单号:'.$trade_no );
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
    	        
    	        if ($is_ok ) 
    	        {
    	            $this->db->trans_commit();
    	            echo 'success';
    	        } else {
    	            $this->db->trans_rollback();
    	            return false;
    	        }
    	        
    	    }else{ 
    	        //该订单可能已支付过
    	        $this->db->trans_rollback();
    	        return false;
    	    }
    	  
	    }else{ 
	        return false;
	    }

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
	
}
