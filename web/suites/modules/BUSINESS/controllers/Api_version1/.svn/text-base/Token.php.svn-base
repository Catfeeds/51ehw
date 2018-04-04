<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Token extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
	
	public function index()
	{
		//$key = 'nine_api_leaf_key_muke';//接口密钥，待用
		
	    
		$app = $this->input->post('a',0);
		$imei = $this->input->post('imei',0);
		$imsi = $this->input->post('imsi',0);
		
		//定义返回值格式
		$return['responseMessage'] = array('messageType'=>null,'errorType'=>null,'errorMessage'=>null);
		$return['data'] = array();
		
		//允许客户端
		$clientArray = array('phone_app_android','phone_app_iphone');
		
		if(!in_array($app, $clientArray))
		{
			//设置接口调用出错信息
			$return['responseMessage'] = array('messageType'=>'error','errorType'=>'0','errorMessage'=>'非法调用');
		}else{
			$return['responseMessage']['messageType'] = 'success';
			
			//生成token
			$token = 'abc';
			
			//将客户端信息保存数据库
			//do something
			
			
			//设置返回值
			$return['data']['token'] = $token;
		}
		
		//print_r(json_encode($return));
		print_r($return);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */