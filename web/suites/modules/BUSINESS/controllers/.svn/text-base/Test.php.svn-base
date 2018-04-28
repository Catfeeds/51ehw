<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');


class Test extends Front_Controller{
	/**
	* @author JF
	* 2017年11月9日
	* 执行sql
	*/
	function sql(){
		$sql = $this->input->get_post("sql");
		$type = $this->input->get_post("type");
		$query = $this->db->query($sql);
		if($type == "list"){
			$result = $query->result_array();
		}else if($type == "num"){
			$result = $query->num_rows();
		}else if($type == "row"){
			$result = $query->row_array();
		}else if($type == "affected"){
			$result = $this->db->affected_rows();
		}
		echo "<pre>";
		print_r($result);exit;
		
	}
	
	/**
	* @author JF
	* 2018年3月7日
	* 京东万象接口
	* @param int $type 类型
	*/
	function jingdongwanxiang($type){
	    switch($type){
	        case "1";
	           $parameter = array(
	                   "cardNo" => "6212263602067615302",
	                   "accName" => "江锋",
	                   "certificateNo" => "441223199604252030",
	                   "cardPhone" => "13450891497"
	           );
	           $url = "https://way.jd.com/YOUYU365/keyelement?appkey=0d954004468f4fb0786dc48ff69779c5";
	           $result = $this->curl_post_result($url,$parameter);
	           echo "<pre>";
	           print_r($result);exit;
	           break;
	        case "2";
	           break;
           default:
               $return = array();
               break;
	    }
	}
	
	
	//curl_post
	public function curl_post_result( $url, $data ){
	    $ch = curl_init ();
	    curl_setopt ( $ch, CURLOPT_URL, $url );
	    curl_setopt ( $ch, CURLOPT_POST, 1 );
	    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	    curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query($data) );
	    $result = curl_exec ( $ch );
	    curl_close ( $ch );
	    
	    return($result);
	    
	}
}
