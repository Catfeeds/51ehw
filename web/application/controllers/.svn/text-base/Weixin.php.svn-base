<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	// error_reporting(E_ALL);
error_reporting ( E_ALL ^ E_DEPRECATED );
define ( 'TOKEN', 'ninthleaf' );
define ( 'EncodingAESKey', 'GsTig3XLId5dglQxgkT0Yv29j4rVobzOK3Fh3npP4AZ' );
include_once "wechatfile/WXBizMsgCrypt.php";
class Weixin extends Wechat_Controller {
	function __construct() {
		parent::__construct ();
		
		// $this->log = Logger::getLogger(__CLASS__);
		// $this->load->library('session');
		// CI 2.0 以前需要这句话才可以获取 GET 参数，
		// 2.0 及新版则不需要，这里和微信公众平台无关
		// parse_str($_SERVER['QUERY_STRING'], $_GET);
	}
	
	// 在微信平台上设置的对外 URL
	public function message() {
		$echostr = $this->input->get ( 'echostr' );
		if ($this->checkSignature ()) {
			// 判读是不是只是验证
			if (! empty ( $echostr )) {
				$this->load->view ( 'valid_view', array (
						'output' => $echostr 
				) );
			} else {
				// 实际处理用户消息
				$this->_responseMsg ();
			}
		} else {
			$this->_responseMsg ();
			// $this->load->view ( 'valid_view', array (
			// 'output' => 'Error!'
			// ) );
		}
	}
	
	// 用于企业号接入验证
	private function _valid() {
		$signature = $this->input->get ( 'msg_signature' );
		$timestamp = $this->input->get ( 'timestamp' );
		$nonce = $this->input->get ( 'nonce' );
		$echostr = $this->input->get ( 'echostr' );
		$sEchoStr = "";
		
		$wxcpt = new WXBizMsgCrypt ( $this->token, $this->encodingAesKey, $this->corpId );
		
		$errCode = $wxcpt->VerifyURL ( $signature, $timestamp, $nonce, $echostr, $sEchoStr );
		if ($errCode == 0) {
			// echo $sEchoStr;
			// exit();
			return true;
		} else {
			// echo $errCode;
			return false;
		}
		
		// return ($tmp_str == $signature);
	}
	
	// 这里是处理消息的地方，在这里拿到用户发送的字符串
	private function _responseMsg() {
		$this->load->model ( 'app_info_mdl' );
		$app_info = $this->app_info_mdl->get_app_info ( base_url () );
		// 获取公司ID
		$app_id = $app_info ['wechat_appid'];
		$app_name = $app_info ['app_name'];
		$company_id = $app_info ['id'];
		
		$timeStamp = strtotime ( date ( 'Y-d-m' ) );
		$post_str = file_get_contents ( 'php://input' );
		$pc = new WXBizMsgCrypt ( TOKEN, EncodingAESKey, $app_id );
		$nonce = rand () * 100000; // $post_obj->nonce;
		if (! empty ( $post_str )) {
			// 解析微信传过来的 XML 内容
			/*
			 * $xml_tree = new DOMDocument();
			 * $xml_tree->loadXML($post_str);
			 * error_log($post_str);
			 * $array_e = $xml_tree->getElementsByTagName('Encrypt');
			 * //$array_s = $xml_tree->getElementsByTagName('MsgSignature');
			 * $encrypt = $array_e->item(0)->nodeValue;
			 * //$msg_sign = $array_s->item(0)->nodeValue;
			 *
			 * $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
			 * $from_xml = sprintf($format, $encrypt);
			 *
			 * // 第三方收到公众号平台发送的消息
			 * $msg = '';
			 * $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
			 */
			$post_obj = simplexml_load_string ( $post_str, 'SimpleXMLElement', LIBXML_NOCDATA );
			
			// error_log($msg);
			
			$from_username = $post_obj->FromUserName;
			$to_username = $post_obj->ToUserName;
			$msg_id = $post_obj->MsgId;
			// $keyword 就是用户输入的内容
			$keyword = trim ( $post_obj->Content );
			$res_view = 'response_news_view';
			// 判断输入关键字
			if (! empty ( $keyword )) {
				try {
					$csdata = array();
					// 先把信息保存到数据库
					$this->load->model ( 'customer_mdl' );
					$customer = $this->customer_mdl->find_by_wechatopenid ( $from_username );
					$this->load->model ( 'wechat_cs_mdl' );
					$csdata ['account_id'] = $customer ['id'];
					$csdata ['app_id'] = $company_id;
					$csdata ['content'] = $keyword;
					$this->wechat_cs_mdl->create ( $csdata );
				} catch ( Exception $e ) {
					error_log ( $e );
				}
				// 文本类型的消息，本示例只支持文本类型的消息
				$type = "news";
				/*
				 * $userdata = array($this->user_record_model->get_data((string)$from_username));
				 * //判断用户是否已经进入菜单层
				 * if(is_array($userdata)){
				 * //在用户回复模型中查找用户信息
				 * $levelst = (string)$userdata[0]['menu_level'];
				 * $replydata = array($this->user_reply_model->get_reply((string)$keyword, $levelst));
				 * //$this->log->DEBUG($replydata[0]);
				 * if(count($replydata[0]) != 0){
				 * $content = strip_tags($replydata[0]['description']);
				 * }else{
				 * $content = $this->_parseMessage($keyword);
				 * }
				 * }else{
				 * $content = $this->_parseMessage($keyword);
				 * }
				 * $textdata = array($this->user_record_model->get_data((string)$from_username));
				 * if(!is_array($textdata)){
				 * $text = implode(",", $textdata);
				 * //$content.= ($getdata['menu_level'])." post test";
				 * $content.= $text;
				 * }
				 */
				$data = array (
						'to' => $from_username,
						'from' => $to_username,
						'type' => $type,
						'style' => 'news' 
				); // $content//." ".$this->session->userdata('EventKey')

				
				$this->load->model ( 'content_mdl' );
				
				$data ['contents'] = $this->content_mdl->find_by_title ( $keyword );
				
				//$this->load->model ( 'goods_mdl' );
				if (count($data['contents']) === 0) {
					$type = "text";
					$content = "亲，我找不到关键字内容哟。";
					$data = array (
							'to' => $from_username,
							'from' => $to_username,
							'type' => $type,
							'content' => $content 
					);
					$res_view = 'response_view';
				}
				//else{

				$this->load->view ( $res_view, $data );
				
				return;
				//}
				/*
				 * $text = "<xml><ToUserName><![CDATA[" . $from_username . "]]></ToUserName><FromUserName><![CDATA[" . $to_username . "]]></FromUserName><CreateTime>" . time () . "</CreateTime><MsgType><![CDATA[" . $type . "]]></MsgType><Content><![CDATA[" . $data ['content'] . "]]></Content><FuncFlag>0</FuncFlag></xml>";
				 *
				 * $encryptMsg = '';
				 * $errCode = $pc->encryptMsg ( $text, $timeStamp, $nonce, $encryptMsg );
				 * if ($errCode == 0) {
				 * echo $encryptMsg;
				 * } else {
				 * echo $errCode;
				 * }
				 */
			} else // 没有输入关键字
			{
				$event_key = ( string ) $post_obj->EventKey;
				if ($event_key != "") {
					$this->load->model ( 'wechat_menu_mdl' );
					$menu = $this->wechat_menu_mdl->get_menu_by_key ( $event_key, $app_id );
					
					switch ($menu ['menutype']) {
						case 'click' :
							{
							}
						case 'view' :
							{
							}
						case 'scancode_push' :
							{
							}
						case 'scancode_waitmsg' :
							{
							}
						case 'pic_sysphoto' :
							{
							}
						case 'pic_photo_or_album' :
							{
							}
						case 'pic_weixin' :
							{
							}
						case 'location_select' :
							{
							}
						default :
							{
							}
					}
				} else {
					$type = "text";
					$welcome = $app_info ['welcome_words'];
					$account_info = $this->session->userdata ( 'account_info' );
					if($account_info != null)
					{
						$welcome = str_replace("[nickname]",$account_info["wechat_nickname"],$app_info ['welcome_words']);
						$welcome = str_replace("[number]",$$account_info["id"],$app_info ['welcome_words']);
					}
					
					$content = $welcome; // "欢迎关注" . $app_name . "微信公众平台！";
					$data = array (
							'to' => $from_username,
							'from' => $to_username,
							'type' => $type,
							'content' => $content 
					);
					$res_view = 'response_view';
				}
				
				$this->load->view ( $res_view, $data );
			}
		} else {
			$this->load->view ( 'valid_view', array (
					'output' => 'Error!' 
			) );
		}
	}
	
	// 解析用户输入的字符串
	private function _parseMessage($message) {
		// log_message('debug', $message);
		
		// TODO: 在这里做一些字符串解析，比如分析某关键字，返回什么信息等等
		$return_msg = '';
		switch ($message) {
			default :
				{
					$getdata = $this->common_model->get_common ();
					$return_msg = strip_tags ( $getdata ['content'] );
				}
		}
		
		return $return_msg;
	}
	private function checkSignature() {
		// you must define TOKEN by yourself
		if (! defined ( "TOKEN" )) {
			throw new Exception ( 'TOKEN is not defined!' );
		}
		
		$signature = $this->input->get ( 'signature' );
		$timestamp = $this->input->get ( 'timestamp' );
		$nonce = $this->input->get ( 'nonce' );
		
		$token = TOKEN;
		$tmpArr = array (
				$token,
				$timestamp,
				$nonce 
		);
		// use SORT_STRING rule
		sort ( $tmpArr, SORT_STRING );
		$tmpStr = implode ( $tmpArr );
		$tmpStr = sha1 ( $tmpStr );
		
		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
}


/* End of file weixin.php */
/* Location: ./application/controllers/weixin.php */

/*
 * $getdata = $this->wxmenu_model->get_data($event_key);
 * $this->log->DEBUG($getdata["gotoid"]);
 * $this->user_record_model->set_data((string)$from_username, $event_key);
 * //判断自定义菜单进入跳转
 * switch($event_key){
 * case "V1001_JOBS"://校园招聘
 * {
 * $type = "news";
 * //判断有否指定ID
 * if($getdata["gotoid"] != 0){
 * $getdata = array($this->news_model->get_one_news($getdata["gotoid"]));
 * }
 * else{
 * $getdata = $this->news_model->get_news();
 * }
 * $data = array(
 * 'style' => 'news',
 * 'to' => $from_username,
 * 'from' => $to_username,
 * 'type' => $type,
 * 'content' => $getdata,
 * );
 * $res_view = 'response_news_view';
 * break;
 * }
 *
 * case "V1001_EVENT"://最新活动
 * {
 * $type = "news";
 * //判断有否指定ID
 * if($getdata["gotoid"] != 0){
 * $getdata = array($this->news_model->get_one_news($getdata["gotoid"]));
 * }
 * else{
 * $getdata = $this->news_model->get_news();
 * }
 * $data = array(
 * 'style' => 'news',
 * 'to' => $from_username,
 * 'from' => $to_username,
 * 'type' => $type,
 * 'content' => $getdata,
 * );
 * $res_view = 'response_news_view';
 * break;
 * }
 *
 *
 * case "V1001_NEWS"://新闻中心
 * {
 * $type = "news";
 * //判断有否指定ID
 * if($getdata["gotoid"] != 0){
 * $getdata = array($this->news_model->get_one_news($getdata["gotoid"]));
 * }
 * else{
 * $getdata = $this->news_model->get_news();
 * }
 * $data = array(
 * 'style' => 'news',
 * 'to' => $from_username,
 * 'from' => $to_username,
 * 'type' => $type,
 * 'content' => $getdata,
 * );
 * $res_view = 'response_news_view';
 * break;
 * }
 * default:
 * {
 * if($getdata != ""){
 * $type = $getdata["mark"];
 * switch($type){
 * case "text":
 * {
 * $content = $getdata["default_reply"];
 * $data = array(
 * 'style' => 'product',
 * 'to' => $from_username,
 * 'from' => $to_username,
 * 'type' => $type,
 * 'content' => $content,
 * );
 * $res_view = 'response_view';
 * break;
 * }
 * case "music":
 * {
 *
 * $res_view = 'response_music_view';
 * break;
 * }
 * case "news":
 * {
 * //判断有否指定ID
 * if($getdata["gotoid"] != 0){
 * $getdata = array($this->product_model->get_one_product($getdata["gotoid"]));
 * }
 * else{
 * $getdata = $this->product_model->get_product();
 * }
 * $data = array(
 * 'style' => 'product',
 * 'to' => $from_username,
 * 'from' => $to_username,
 * 'type' => $type,
 * 'content' => $getdata,
 * );
 * $res_view = 'response_news_view';
 * break;
 * }
 * default:
 * {
 * $data = array(
 * 'style' => 'product',
 * 'to' => $from_username,
 * 'from' => $to_username,
 * 'type' => 'text',
 * 'content' => '功能开发中',
 * );
 * $res_view = 'response_view';
 * }
 * }
 * }
 * }
 * }
 */
