<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 客户管理控制器
 * 
 * 查看会员列表
 * 
 * @author 		Clark So
 * @copyright 	Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license		http://www.9-leaf.com/
 * @link		http://www.9-leaf.com/
 * @since		Version 1.0
 * @filesource
 *
 */
class Client extends Front_Controller {
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		$this->load->model ( 'customer_mdl' );
		$this->load->model ( 'corporation_mdl' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 获取列表
	 * 带分页功能
	 */
	public function get_list(){
	    $this->load->view ( 'head');
	    $this->load->view ( '_header' );
	    $this->load->view ( 'corporate/client/list');
	    $this->load->view ( '_footer');
	    $this->load->view ( 'foot');
	}
}