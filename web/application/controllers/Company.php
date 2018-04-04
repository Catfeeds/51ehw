<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'common/uri.php';
/**
 * 品牌
 *
 *
 */
class company extends Front_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('app_info_mdl');

	}
	// --------------------------------------------------------------------
	
	/**
	 * 品牌列表
	 */
	function index() {
		
		$data["recommend"] = $this->app_info_mdl->getAll("site_logo,site_url,app_name,id",1);
		$data["apps"] = $this->app_info_mdl->getAll("site_logo,site_url,app_name,id",0,"id desc");
		$data['title'] = "品牌";
        $data['head_set'] = 3;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'brand/company_list', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 品牌详细页面
	 */
	function single() {
		// 判断是否二级分类，否则跳转到首页
		$segments = $this->uri->uri_to_assoc ();
		if (! empty ( $segments ['brand_id'] )) {
			$brand_id = ( int ) $segments ['brand_id'];
			$this->load->model ( 'brand_mdl' );
			$brand = $this->brand_mdl->load ( $brand_id );
			if (empty ( $brand )) {
				redirect ( 'home' );
				exit ();
			}
		} else {
			redirect ( 'home' );
			exit ();
		}
		
		$data ['css'] [0] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/.css' />";
		$data ['title'] = $brand ['name'] . '&nbsp;【行情  价格 评价 正品行货】';


		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'brand/single', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
}