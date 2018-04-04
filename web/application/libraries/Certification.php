<?php
/**
 * 实名认证
 * @author jiangfeng
 *
 */
class Certification
{
    public function __construct(){
    }
    
    /**
	* @author JF
	* 2018年3月7日
	* 京东万象接口
	* @param int $type 类型
	* @param array $data 参数
	*/
    function jdwx($type,$data){
        $CI = & get_instance();
	    switch($type){
	        case "1";//四要素验证
	           $parameter = array(
	                   "cardNo" => $data["certificateNo"],//银行卡
	                   "accName" => $data["accName"],//姓名
	                   "certificateNo" => $data["cardNo"],//身份证
	                   "cardPhone" => $data["cardPhone"]//银行预留手机
	           );
	  
	           $url = "https://way.jd.com/YOUYU365/keyelement?appkey=0d954004468f4fb0786dc48ff69779c5";
	           $result = $CI->curl_post_result($url,$parameter);
	           $return = json_decode($result,true);

	           //写日志log
	           $arr["name"] = $data["accName"];
	           $arr["idcard"] = $data["cardNo"];
	           $arr["bankmobile"] = $data["cardPhone"];
	           $arr["bankcard"] = $data["certificateNo"];
	           $arr["return_msg"] = $return["msg"];
	           $arr["return_desc"] = $result;
	           $arr["status"] = !empty($return["result"]["respCode"])?$return["result"]["respCode"]:null;
	           $arr["ordersn"] = !empty($return["result"]["serialNo"])?$return["result"]["serialNo"]:null;
	           $CI->db->set($arr);
	           $CI->db->insert("certification_log");
	           return $return;
	           
	           break;
	        case "2";
	           break;
           default:
               $return = array();
               break;
	    }
	    
	    
	    
	}

}