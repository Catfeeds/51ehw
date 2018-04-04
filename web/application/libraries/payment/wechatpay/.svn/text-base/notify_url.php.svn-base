<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
 */
class Notify_url extends CI_Controller {
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		/*
		 * if (! $this->session->userdata ( 'user_in' )) {
		 * redirect ( 'customer/login' );
		 * exit ();
		 * }
		 *
		 * $this->load->helper ( 'order' );
		 */
	}
	public function get_feedback() {
		// include_once ("log_.php");
		include_once ("WxPayPubHelper/WxPayPubHelper.php");
		
		// 使用通用通知接口
		$notify = new Notify_pub ();
		
		// 存储微信的回调
		$xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
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
				$order_num = $res ['out_trade_no'];
				$pay_type = substr ( $order_num, 0, 3 );
				$res ['out_trade_no'] = substr ( $order_num, 3, strlen ( $order_num ) );
				/*
				 * foreach ($res as $k => $v){
				 * error_log ( "【".$k."】:\n" . $v . "\n" );
				 * }
				 */
				$this->load->model ( "wechat_pay_log_mdl", "paylog" );
				$this->paylog->create ( $res );
				
				if ($pay_type == "ODR") {
					
					$order_sn = $res ["out_trade_no"];
					
					// 修改订单状态为确认支付
					$this->load->model ( "order_mdl", "order" );
					
					$this->order->order_confirm_paid ( $order_sn );
				}


				if ($pay_type == "CHR") {
					$chargeno = $res ["out_trade_no"];
					$this->load->model ( "charge_mdl", "charge" );
					$this->charge->charge_confirm_paid ( $chargeno , $res ["transaction_id"]);
				}
				
			}
			// 例如：更新订单状态
			// 例如：数据库操作
			// 例如：推送支付完成信息
		}
	}
}
?>