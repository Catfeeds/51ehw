<?php
/**
 * 通用异步通知接口
 * ====================================================
 * 支付完成后，支付平台把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 */
class Notify_url extends Front_Controller {
    
    private $chargeno; //平台自己生成的充值单号。
    private $return_numbers;//充值成功后支付平台返回的单号。
    private $total_fee;//支付平台返回的充值金额。
    
	public function __construct() 
	{
		parent::__construct ();
		
	}
	/**
	 * 微信异步返回
	 */
	public function Get_feedback() {
	    // include_once ("log_.php");
		include_once (__DIR__."/../libraries/Wechatpay/WxPayPubHelper/WxPayPubHelper.php");//放在libarires
		
		// 使用通用通知接口
		$notify = new Notify_pub ();
		
		// 存储微信的回调
		$xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
		if( empty($xml) )
		{
		    $xml = file_get_contents("php://input");
		}
		
		$notify->saveData ( $xml );
		
		// 验证签名，并回应微信。
		// 对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		// 微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		// 尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if ($notify->checkSign () == FALSE) {
			$notify->setReturnParameter ( "return_code", "FAIL" ); // 返回状态码
			$notify->setReturnParameter ( "return_msg", "签名失败" ); // 返回信息
		} else {
			$notify->setReturnParameter ( "return_code", "SUCCESS" ); // 设置返回码
		}
		$returnXml = $notify->returnXml ();
		echo $returnXml;
		
		// ==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		/*
		 * // 以log文件形式记录回调信息
		 * $log_ = new Log_ ();
		 * $log_name = "notify_url.log"; // log文件路径
		 * $log_->log_result ( $log_name, "【接收到的notify通知】:\n" . $xml . "\n" );
		 *
		 * if ($notify->checkSign () == TRUE) {
		 * if ($notify->data ["return_code"] == "FAIL") {
		 * // 此处应该更新一下订单状态，商户自行增删操作
		 * $log_->log_result ( $log_name, "【通信出错】:\n" . $xml . "\n" );
		 * } elseif ($notify->data ["result_code"] == "FAIL") {
		 * // 此处应该更新一下订单状态，商户自行增删操作
		 * $log_->log_result ( $log_name, "【业务出错】:\n" . $xml . "\n" );
		 * } else {
		 * // 此处应该更新一下订单状态，商户自行增删操作
		 * $log_->log_result ( $log_name, "【支付成功】:\n" . $xml . "\n" );
		 * }
		 *
		 * // 商户自行增加处理流程,
		 * // 例如：更新订单状态
		 * // 例如：数据库操作
		 * // 例如：推送支付完成信息
		 * }
		 */
		error_log ( "【接收到的notify通知】:\n" . $xml . "\n" );
		if ($notify->checkSign () == TRUE) {
			if ($notify->data ["return_code"] == "FAIL") {
				// 此处应该更新一下订单状态，商户自行增删操作
				error_log ( "【通信出错】:\n" . $xml . "\n" );
			} elseif ($notify->data ["result_code"] == "FAIL") {
				// 此处应该更新一下订单状态，商户自行增删操作
				error_log ( "【业务出错】:\n" . $xml . "\n" );
			} else {
				// 此处应该更新一下订单状态，商户自行增删操作
				error_log ( "【支付成功】:\n" . $xml . "\n" );
				// 将返回的xml转为数组
				$res = @simplexml_load_string ( $xml, NULL, LIBXML_NOCDATA );
				$res = json_decode ( json_encode ( $res ), true );
				$chargeno = $res ['out_trade_no'];//发起的单号
				$total_fee = $res ['total_fee']/100;//充值成功的金额
				$return_numbers = $res["transaction_id"];//充值成功后支付平台返回的单号。
				/*
				 * foreach ($res as $k => $v){
				 * error_log ( "【".$k."】:\n" . $v . "\n" );
				 * }
				 */
				//调用方法处理---开始
				$this->chargeno = $chargeno; //平台自己生成的充值单号。
				$this->return_numbers = $return_numbers;//充值成功后支付平台返回的单号。
				$this->total_fee = $total_fee;//支付平台返回的充值金额。
				$this->HandlingEvents();
				//调用方法处理---结束
				
				//微信充值日志表。
				$this->load->model ( "easy_wechat_pay_log", "paylog" );
				$this->paylog->create ( $res );
				
            }
		}
	}
	
	/**
	 * 函数的用途描述。
	 * @date:2018年2月30日 下午5:39:37
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function Alipay_notify()
	{ 
	    
	    require_once(__DIR__."/../libraries/Alipaylib/Alipay.config.php");
	    require_once(__DIR__."/../libraries/Alipaylib/Alipay_notify.class.php");
	     
	    $alipayNotify = new AlipayNotify($alipay_config);
	    $verify_result = $alipayNotify->verifyNotify();
	    
	    if($verify_result) {//验证成功
	        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	        //请在这里加上商户的业务逻辑程序代
	    
	        error_log( $this->input->post() );
	        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	        	
	        //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	        	
	        //商户订单号
	        $res['out_trade_no'] = $this->input->post('out_trade_no');
	        
	        //支付宝交易号
	        $res['trade_no'] = $this->input->post('trade_no');
	    
	        //交易状态
	        $res['trade_status'] = $this->input->post('trade_status');
	        
	        //交易金额
	        $res['total_fee'] = $this->input->post('total_fee');
	       
	        if($this->input->post('trade_status') == 'TRADE_FINISHED' || $this->input->post('trade_status') == 'TRADE_SUCCESS' ) 
	        {
	            //注意：返回逻辑中必须判断订单状态是否未充值状态，才继续做处理，避免支付宝多次返回。
	            
	            //该种交易状态只在两种情况下出现
	            //1、开通了普通即时到账，买家付款成功后。TRADE_SUCCESS
	            //2、开通了高级即时到账，从该笔交易成功时间算起，过了签约时的可退款时限（如：三个月以内可退款、一年以内可退款等）后。TRADE_FINISHED
	    
	            //支付宝充值日志表。
	            $this->load->model ( "alipay_pay_log_mdl", "paylog" );
	            $this->paylog->create ( $res );
	            
	            //调用方法处理
	            $this->chargeno = $res['out_trade_no']; //平台自己生成的充值单号。
	            $this->return_numbers = $res['trade_no'];//充值成功后支付平台返回的单号。
	            $this->total_fee = $res['total_fee'];//支付平台返回的充值金额。
	            $this->HandlingEvents();
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
	
	/**
	 * 支付成功后根据充值单号判断处理事件。
	 * 只负责调用各个事件的方法，完整逻辑建议写在MODEL或者helper.
	 * @date:2018年3月30日 下午5:40:41
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function HandlingEvents()
	{ 
	    $this->total_fee = 100;
	    $this->chargeno = '111111';
	    //查询充值单
	    $this->load->model('easy_charge_mdl');
	    $charge = $this->easy_charge_mdl->LoadByChangeNo($this->chargeno);
	    
	    //以下逻辑需重写。
	    $this->db->trans_begin(); //事物执行方法中的MODEL
        
        do{
            //判断价钱=充值。
            if( !$charge || $this->total_fee != $charge['amount'] )
            { 
                //充值价格不匹配
                error_log( '单号:'.$this->chargeno.',Message:充值价格不匹配' );
                break;
            }
            
            //更新主表状态+第三方单号。
            $set['status'] = 1;
            $set['payment_id'] = 1;
            
            if( !$this->easy_charge_mdl->Update( $charge['id'],$set ) )
            { 
                //状态更新失败。
                error_log( '单号:'.$this->chargeno.',Message:状态更新失败' );
                break;
            }
            
            
            if ( $charge['type'] == 1 )
            {
                $obj_id = $this->easy_charge_mdl->LoadItem( $charge['id'] )['obj_id'];
                //订单支付--完成
                $this->load->model('easyshop_order_mdl');
                $result = $this->easyshop_order_mdl->AfterEasyOrder( $obj_id );
                error_log( '单号:'.$this->chargeno.',Message:'.$result['message'].',type:'.$charge['type'] );
            }
            
            
        }while(0);
        
        //判断处理情况
        if( !empty( $result['status'] ) && $result['status'] == 1 )
        { 
            echo 'success';
            $this->db->trans_commit();
            return;
        }
	    
        $this->db->trans_rollback();
        echo 'fail';
	}
	
}
