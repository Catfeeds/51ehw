<?php

/**
 * 发送短信
 * @param int $status 事件
 * @param string $mobile 手机
 * @param string $content 内容
 * @param int $type 短信类型1行业2营销
 * @param int $source '来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
 */
function send_message($mobile,$status = 0,$content,$type=1,$source){
	if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile) || !$content || !in_array($type, array(1,2,3))){
		$return = array(
				"returnstatus" => "01",
				"message" => "参数错误"
		);
		return json_encode($return);
	}
	//51易货网 -> 全球秦商
	//51易货 -> 全球秦商
	
	$content = str_replace('51易货网', '全球秦商', $content);//替换
	$content = str_replace('51易货', '全球秦商', $content);//替换
	
	$CI = & get_instance();
	$date = date('Y-m-d H:i:s');//时间
	$last_at = time();//当前时间戳
	$CI->load->model('shortmsg_log_mdl');
	$CI->load->model('sms_supplier_mdl');
    $CI->load->library('sms/Short_Message_Factory', '', 'message');//短信类库
    $num = $CI->message->random(4);//生成4位随机数
    if($type == 1 || $type == 3){ //行业事件设置session  $type == 3  核销订单
        if($type == 1){
            //验证安全时间
            $ip = $_SERVER['REMOTE_ADDR'];//获取客户端id
            $key_ip = $ip."_".$status;
            $created_at = $CI->session->userdata($key_ip);
            if($last_at-$created_at < 100){
                $return = array(
                				"returnstatus" => "02",
                				"message" => "过于频繁"
                );
                return json_encode($return);
            }
            $CI->session->set_userdata($key_ip,$last_at);//重新set一个安全时间
        }
    	
        $content = str_replace('#code', $num, $content);//匹配替换验证码
        //根据事件设置key
        $CI->session->set_userdata("verfity_yzm_".$status, $num);
        $CI->session->set_userdata("verfity_mobile_".$status, $mobile);
        $CI->session->set_userdata("verfity_settime_".$status, $date);
        //密钥
        $key = md5($mobile.$num);
        $CI->session->set_userdata('key',$key);
        //将$type=3时重新定义为1
        $type = 1;
     }
      
    // 读取默认短信提供商
    $supplier = $CI->sms_supplier_mdl->get_in_use($type);
    if(!$supplier){
    	$return = array(
    			"returnstatus" => "01",
    			"message" => "发送失败"
    	);
    	return json_encode($return);
    }
    $sms = $CI->message->get_message($supplier);
    
    //插入一条发送log
    $id = $CI->shortmsg_log_mdl->create(array(
        'mobile' => $mobile,
        'content' => $content,
    	'source' => $source
    ));
    if($id){
        //发送短信
    	$msg = $sms->send($mobile, $content); // 返回结果集
        $msg = json_decode($msg,true);
        $type = "华信科技";
        $status = $msg["returnstatus"]; //返回状态
        $return_msg = $msg["message"];//返回信息
        $taskID = $msg["taskID"];//返回id
        $log = array(
        		'id' => $id,
        		'msg_type' => $type,
        		'status' => $status,
        		'return_msg' => $return_msg,
        		'taskID' => $taskID
        );
        $CI->shortmsg_log_mdl->update($log);
        if($status == "Success"){
        	$return = array(
        			"returnstatus" => "00",
        			"message" => "发送成功"
        	);
        	return json_encode($return);
        }
    }
    
    $return = array(
    		"returnstatus" => "01",
    		"message" => "发送失败".(!empty($return_msg)?$return_msg."。":"。")
    );
    return json_encode($return);
}
/**
 * 短信长连接转短连接(新浪)
 * @param unknown source   应用的appkey   3271760578
 * @param unknown url_long  需要转换的长链接
 */
function Message_LongToShort_result($url_long){
    $url = 'http://api.t.sina.com.cn/short_url/shorten.json';
    $source = '3271760578';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url.'?source='.$source.'&url_long='.$url_long);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    curl_close($curl);
    return($result);
}

/**
 * 获取 长度为5的随机字符串
 * @return string|unknown
 */
function random_str(){
    //获取随机0-9,a-Z的随机5个不重复的字符
    $number = range('0','9'); //获取0-9的数据
    $lowercase = range('a','z'); //获取a-z的数据
    $uppercase = range('A','Z'); //获取A-Z的数据
    $arr = array_merge($number,$lowercase,$uppercase); //合并数组
    shuffle($arr); //打乱数组
    $len = 5;        //获取字符个数(5个)
    $arr_end = array_slice($arr,0,$len); //取出从角标0开始,5个数组单元
    $result = '';    //使用一个变量保存最终结果值
    foreach($arr_end as $k=>$v){
        $result .= $v; //拼接字符,并保存在$result变量中
    }
    return $result; //返回结果值
}

/**
 * 短信长连接转短连接(51)
 * @param array $param   $param['customer_id']  创建人  $param['resource'] 传递参数
 * @param str $type  B端 _BUSINESS  C端 _CLIENT
 * 
 * @param str  $control  控制器处理 (具体不同的控制器作用查看Conect.php)
 * @param str  $control_type  操作类型 类型 1:部落短信邀请 2:部落二维码邀请 (暂时只有这两个类型，根据实际情况可添加其它操作类型)
 *
 */
function  ToConect($param,$type = "_BUSINESS",$control = 't',$control_type = '1'){
    
    if(empty($param['customer_id'])){
        echo '缺少创建人';exit;
    }
    if(empty($param['resource'])){
        echo '缺少参数';exit;
    }
    
    $CI = & get_instance();
    $long_url = '';
    $short_url = '';
    $prefix = '';
    if(base_url() == 'http://www.test51ehw.com/' || base_url() =='http://test51ehw.9-leaf.com/'){ //测试
        $prefix = base_url().'index.php/_BUSINESS/';
    }else{ //正式
        $prefix = base_url();
    }
    $long_url = $prefix.$param['resource'];
    $CI->load->model("Conect_mdl");
    // 生成短连接key值
    $key_exist = false;
    do {
        $key = random_str();
        if ($CI->Conect_mdl->load($key)) {
            $key_exist = true;
        } else {
            $short_url = $prefix.'Conect/'.$control.'/'.$key;
            $_data['customer_id'] = $param['customer_id'];
            $_data['url_long'] = $long_url;
            $_data['url_short'] = $short_url;
            $_data['url_key'] = $key;
//             $_data['source'] = '';
            $_data['type'] = $control_type;
            $CI->Conect_mdl->create($_data);
            $key_exist = false;
        }
    } while ($key_exist);
    
    $return['url_short'] = $short_url;
    
    if($control_type == 2){
        //部落二维码邀请  需要返回$key
        $return['key'] = $key;
    }
    
    return json_encode($return);
}


function GetIP()
{
    if(!empty($_SERVER["HTTP_CLIENT_IP"]))
    {
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    }
    else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
    {
    $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    }
    else if(!empty($_SERVER["REMOTE_ADDR"]))
    {
        $cip = $_SERVER["REMOTE_ADDR"];
    }
    else
    {
        $cip = '';
    }
    preg_match("/[\d\.]{7,15}/", $cip, $cips);
    $cip = isset($cips[0]) ? $cips[0] : 'unknown';
    unset($cips);
    return $cip;
}
?>
