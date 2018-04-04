<?php
/**
 * 公司信息内容
 *
 *
 */
class App_info_mdl extends CI_Model {
	function __construct() {
		parent::__construct ();
	}
	/**
	 * 根据网站地址获取公司信息
	 *
	 * @param unknown $app_url
	 * @return unknown
	 */
	function getAll($select = "", $app_flag = -1, $orderby = "",$condition = "",$area="",$hot="",$city = "") {
		if ($app_flag != - 1) {
			$this->db->where ( "app_flag", $app_flag );
		}
		if ($select != "") {
			$this->db->select ( $select );
		}
		if ($orderby != "") {
			$this->db->order_by ( $orderby );
		}
		if($condition!=""){
		    $this->db->where("id != 0");
		}
		$this->db->from ( "app_info" );
		if($area!="")
		{
		    $this->db->join("region as r","app_info.region_id = r.region_id","left outer");
		    if($hot!=""){
		        $id = array(1,311);
		        $this->db->where_in("app_info.region_id",$id);
		    }
		}

		if($city != "")
		{
		    $this->db->where ( 'app_name', $city );
		}

		$this->db->order_by("app_info.letter","ASC");
		$this->db->order_by("CONVERT(`9thleaf_app_info`.`app_name` USING gbk)","ASC");		$query = $this->db->get ();
		//echo $this->db->last_query();exit;
		$arr = $query->result_array ();

		return $arr;
	}
	function get_app_info($app_url) {
		$query = $this->db->get_where ( 'app_info', array (
				'site_url' => $app_url
		) );
		$arr = $query->row_array ();
		return $arr;
	}

	
	//---------------------------------------------------------------
	/**
	 * 读取信息
	 * @param unknown $app_id
	 */
	function get_user_byID($app_id) {
	    $this->db->select("id,customer_id");
	    $this->db->from("app_info");
	    $this->db->where('id', $app_id);
	    $query = $this->db->get();
	    $arr = $query->row_array ();
	    return $arr;
	}
	// --------------------------------------------------------------------

	/**
	 * 读取信息
	 * @param unknown $app_id
	 */
	function load($app_id) {
	    $this->db->select("id, customer_id,app_name, site_url, site_logo, seo_keyword, seo_description,icp_num,copy_right,theme,wechat_jsapi_timestamp,wechat_jsapi_ticket,wechat_token_timestamp,wechat_access_token");
	    $this->db->from("app_info");
	    $this->db->where('id', $app_id);
		$query = $this->db->get();
// 		echo $this->db->last_query();
		$arr = $query->row_array ();
		return $arr;
	}

	// --------------------------------------------------------------------

	/**
	 *
	 * @param unknown $ticket
	 * @param unknown $expire_time
	 */
	public function set_jsapi_ticket($ticket, $expire_time) {
		$app_id = $this->session->userdata ( 'app_info' )['id'];
		$this->db->set ( 'wechat_jsapi_ticket', $ticket );
		$this->db->set ( 'wechat_jsapi_timestamp', $expire_time );
		$this->db->where ('id', $app_id);
		$this->db->update ( 'app_info' );
	}

	// --------------------------------------------------------------------

	/**
	 *
	 * @param unknown $token
	 * @param unknown $expire_time
	 */
	public function set_access_token($token, $expire_time) {
		$app_id = $this->session->userdata ( 'app_info' )['id'];
		$this->db->set ( 'wechat_access_token', $token );
		$this->db->set ( 'wechat_token_timestamp', $expire_time );
		$this->db->where ('id', $app_id);
		$this->db->update ( 'app_info' );
	}

	//---------------------------------------------------------------------

	/**
	 * 获取站点
	 *
	 */
	public function get_situs_list($id=null){
	    $this->db->select('a.*');
        $this->db->from('app_info a');
        $this->db->join('region b','b.region_id=a.region_id');
        $id != null?$this->db->where('a.id',$id):null;
        $query = $this->db->get();
        $result = $id !=null?$query->row_array():$query->result_array();
        return $result;
	}

	//---------------------------------------------------------------------

	/**
	 * 搜索站点
	 * @param unlnown $search_val
	 */
	public function search_situs($search_val,$pinyin=""){
	    $this->db->from('app_info a');
        $this->db->like('a.app_name',$search_val);
        if($pinyin){
            $this->db->or_like('a.letter',$pinyin);
        }
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
	}
}