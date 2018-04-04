<?php
/**
 * 内容控制器
 */
class Wechat extends Front_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('app_info_mdl');
	}
	 
	// --------------------------------------------------------------------

	/**
	 * 站点列表
	 */
	function index()
	{
	    $url = "http://api.map.baidu.com/location/ip?ak=8VUp1IbWAlMzjt4GoC5kuaf7&ip=&coor=bd09ll";
        $json = (json_decode(file_get_contents($url),true));
        $data['address'] = mb_substr($json['content']['address_detail']['city'],0,-1);
        $data['app_info'] = $this->app_info_mdl->get_situs_list();
        $data['head_set'] = 2;
        $data['title'] = '分站点';
        $data['foot_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('situs/list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data); 
	}

	// --------------------------------------------------------------------
	 
	/**
	 * ajax 搜索
	 */
	function search(){
	    $search_val = $this->input->post('search_val');
	    //获取中文首字母
	    $this->load->library('pinyin');
	    @$pinyin = $this->pinyin->getFirstPY($search_val);
	    //搜索
	    $data = $this->app_info_mdl->search_situs($search_val,$pinyin);
	    echo json_encode($data);
	}
	 
	// --------------------------------------------------------------------
	

	


}