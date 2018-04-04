<?php
class Js_api_sdk {
	private $appId;
	private $appSecret;
	public function __construct() {
	}
	public function init($appId, $appSecret) {
		$this->appId = $appId;
		$this->appSecret = $appSecret;
	}
	public function getSignPackage() {
		$jsapiTicket = $this->getJsApiTicket ();
		error_log("JSAPITICKET: ".$jsapiTicket);
		$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		error_log("URL: ".$url);
		$timestamp = time ();
		error_log("TIMESTAMP: ".$timestamp);
		$nonceStr = $this->createNonceStr ();
		error_log("NONCESTR: ".$nonceStr);

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=".$jsapiTicket."&noncestr=".$nonceStr."&timestamp=".$timestamp."&url=".$url;

		error_log("string1: ".$string);
		$signature = sha1 ( $string );
		error_log("SIGNATURE: ".$signature);
		$signPackage = array (
				"appId" => $this->appId,
				"nonceStr" => $nonceStr,
				"timestamp" => $timestamp,
				"url" => $url,
				"signature" => $signature,
				"rawString" => $string
		);
		return $signPackage;
	}
	private function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for($i = 0; $i < $length; $i ++) {
			$str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
		}
		return $str;
	}

	// --------------------------------------------------------------------
	private function getJsApiTicket() {
		$CI = & get_instance ();

		$CI->load->model ( "app_info_mdl", "app_info" );
		$app_info = $CI->app_info->load ( $CI->session->userdata ( 'app_info' )['id'] );

		$expire_time = $app_info ['wechat_jsapi_timestamp'];
		$jsapi_ticket = $app_info ['wechat_jsapi_ticket'];
		
		
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		// $data = json_decode(file_get_contents("jsapi_ticket.json"));
		if (( double ) $expire_time < ( double ) time ()) {
			$accessToken = $this->getAccessToken ();
			$url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=" . $accessToken;
			$return = $this->httpGet ( $url );
			$res = json_decode ( $return );
			$ticket = $res->ticket;
			
			if ($ticket) {
				$CI->load->model ( "app_info_mdl" );
				$expire_time = time () + 7000;
				error_log ( $expire_time );
				$CI->app_info_mdl->set_jsapi_ticket ( $ticket, $expire_time );
			}
			
		} else {
			$ticket = $jsapi_ticket;
		}

		return $ticket;
	}

	// --------------------------------------------------------------------
	private function getAccessToken() {
		$CI = & get_instance ();
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		// $data = json_decode ( file_get_contents ( "access_token.json" ) );
		// @TODO: 这部分需要换内存表实现，不能获取session中的信息的

		$CI->load->model ( "app_info_mdl", "app_info" );
		$app_info = $CI->app_info->load ( $CI->session->userdata ( 'app_info' )['id'] );

		$expire_time = $app_info ['wechat_token_timestamp'];
		$jsapi_ticket = $app_info ['wechat_access_token'];
		
		if ($expire_time < time ()) {
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appId . "&secret=" . $this->appSecret;
			$return = $this->httpGet ( $url );
			error_log ( $return );
			$res = json_decode ( $return );
			$access_token = ( string ) $res->access_token;
			if ($access_token) {
				$CI->load->model ( "app_info_mdl" );
				$expire_time = time () + 7000;
				error_log ( $expire_time );
				$CI->app_info_mdl->set_access_token ( $access_token, $expire_time );
                $_SESSION["app_info"]["wechat_token_timestamp"] = $expire_time;//更新时间
			}
		} else {
            $access_token = $CI->session->userdata("app_info")["wechat_access_token"];
            
			//$access_token = $data->access_token;
		}
		return $access_token;
	}
	private function httpGet($url) {
		/*
		 * $curl = curl_init ();
		 * curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		 * curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		 * curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, FALSE );
		 * curl_setopt ( $curl, CURLOPT_TIMEOUT, 500 );
		 * curl_setopt ( $curl, CURLOPT_URL, $url );
		 *
		 * $res = curl_exec ( $curl );
		 * error_log($res);
		 * curl_close ( $curl );
		 */
		$res = file_get_contents ( $url );

		return $res;
	}
}
?>