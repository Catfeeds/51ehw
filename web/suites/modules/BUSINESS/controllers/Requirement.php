<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 评论管理控制器
 *
 * 增删改查评论
 *
 * @author 		Clark So
 * @copyright 	Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license		http://www.9-leaf.com/
 * @link		http://www.9-leaf.com/
 * @since		Version 1.0
 * @filesource
 *
 */
class Requirement extends Front_Controller {

	// --------------------------------------------------------------------

	/**
	 * 构造函数
	 */
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		
		//判断是否为企业用户
		// 判断是企业会员还是个人

	}

	// --------------------------------------------------------------------

	/**
	 *
	 *
	 */
	public function pub_require(){

	    if (! $this->session->userdata ( 'user_in' )) {
	        redirect ( 'customer/login' );
	        exit ();
	    }
	    //判断是否为企业用户
	    // 判断是企业会员还是个人
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $app = $this->session->userdata("app_info");

	    $this->load->model ( 'customer_mdl' );
	    $this->load->model ( 'corporation_mdl' );

	    // 获取企业资料
	    $data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
	    if(!empty($data['corporation']['id']) && $data['corporation']['status']==1){

	        $this->load->model('requirement_cate_mdl','recate');
	        $this->load->model ( 'content_mdl' );
	        $data['cate'] = $this->recate->getList();
	        $data['title'] = '发布需求';
	        $data['notice'] = $this->content_mdl->getList(0, 20, $app['id'], $key = '');

	        //print_r($data);exit;
	        $this->load->view ( 'head', $data );
	        $this->load->view ( '_header', $data );
	        $this->load->view ( 'requirement/edit', $data );
	        $this->load->view ( '_footer', $data );
	        $this->load->view ( 'foot', $data );
	    }else{
	        $data['type'] = true;
	        $data['auto'] = true;
	        $data['title'] = "非企业用户";
	        $data['msg'] = '非企业用户！';
	        $data['goto'] = site_url("home");
	        $this->load->view('head');
	        return $this->load->view('message',$data);
	    }


	}


	/**
	 * 发布需求生成验证码
	 */
	function yzm_img() {

	    $this->load->helper ( 'captcha' );
	    code ();


	}

	/**
	 * 验证码验证
	 */
	public function checkyzm(){

	    session_start ();
	    $ver = $this->input->post ( 'ver' );
	    if ($_SESSION ['verify'] == $ver) {
	        echo 1;
	    } else {
	        echo 0;
	    }
	    return;
	}

	/**
	 * 发布需求
	 */
	public function pubrequire(){

	    if (! $this->session->userdata ( 'user_in' )) {
	        redirect ( 'customer/login' );
	        exit ();
	    }
	    //判断是否为企业用户
	    // 判断是企业会员还是个人
	    $customer_id = $this->session->userdata ( 'user_id' );

	    $this->load->model ( 'customer_mdl' );
	    $this->load->model ( 'corporation_mdl' );

	    // 获取企业资料
	    $data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
	    if(!$data['corporation']['id']){
	        $data['type'] = true;
	        $data['auto'] = true;
	        $data['msg'] = '非企业用户！';
	        $data['goto'] = site_url('corporate/myshop/get_shop');
	        return $this->load->view('message',$data);
	    }

	    $this->load->model('requirement_mdl','re');
	    $cd = $this->input->post();
	    $this->re->cate_id = $cd['cate_id'];
	    $this->re->p_name = $cd['p_name'];
	    $this->re->p_count = $cd['p_count'];
	    $this->re->m_price = $cd['m_price'];
	    $this->re->vip_price = $cd['vip_price']!=null?$cd['vip_price']:0;
	    $this->re->p_content = $cd['p_content'];
	    $this->re->create_by = $customer_id;

		$res = $this->re->create();
	    if($res) {
	        redirect('requirement/more_require');
	    }else{
	        $data['type'] = true;
	        $data['auto'] = true;
	        $data['msg'] = '发布失败！';
	        $data['goto'] = site_url('corporate/myshop/get_shop');
	        return $this->load->view('message',$data);
	    }
	}

	/**
	 * 更多需求
	 */
	public function more_require($status='',$keyword = ''){

	    /*if (! $this->session->userdata ( 'user_in' )) {
	        redirect ( 'customer/login' );
	        exit ();
	    }*/
	    //判断是否为企业用户
	    // 判断是企业会员还是个人
	    $customer_id = $this->session->userdata ( 'user_id' );
	    $app = $this->session->userdata('app_info');
	    // 获取企业资料
	    //$data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
	    /*if(!$data['corporation']['id']){
	        $data['type'] = true;
	        $data['auto'] = true;
	        $data['msg'] = '非企业用户！';
	        $data['goto'] = site_url('corporate/myshop/get_shop');
	        return $this->load->view('message',$data);
	    }*/

	    $this->load->model('requirement_cate_mdl','recate');
	    $this->load->model('requirement_mdl','re');
	    $this->load->model ( 'content_mdl' );
	    //获取分类列表
	    $data['res'] = $this->recate->getList();

	    $search_name = $keyword == "" ? $this->input->get('search_name'):urldecode($keyword);
	    $assort = $this->input->get('assort');
	    $status = $this->input->get('status');
	    $time = $this->input->get('time');

	    $data['keyword'] = $search_name;
	    $data['assorts'] = $assort;
	    $data['stu'] = $status;
	    $data['times'] = $time;

	    //分页
	    $config['per_page'] = 10;
	    $current_page          = ($this->input->get_post('per_page',true));  //获取当前分页页码数
	    if(0 == $current_page)
	    {
	        $current_page = 1;
	    }
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	    $this->load->library ( 'pagination' );
	    //分类搜索分页
	    /*if((isset($search_name) || isset($assort)) && $status==''){
	        $config ['base_url'] = site_url ('requirement/more_require/?');
	        $config ['base_url'] .= '&search_name='.$search_name.'&assort='.$assort;
	    }*/
	    //时间，等级搜索分页
	    if($status!='' || $time!='' || (isset($search_name) || isset($assort))){
	        $config ['base_url'] = site_url ('requirement/more_require/'.$status.'/?');
	        $config ['base_url'] .= '&status='.$status.'&time='.$time.'&search_name='.$search_name.'&assort='.$assort;
	    }
	    //正常分页
	    if($status=='' && $time=='' && $search_name=='' && $assort==''){$config ['base_url'] = site_url ('requirement/more_require/?');}
	    //
	    if($status=='' || ($status>=1 && $status<=3)){$config ['total_rows'] = $this->re->countList($status,$search_name,0,0,$assort);}
	    else{
    	switch ($time){
    	        case 4:$config ['total_rows'] = $this->re->countList($time,$search_name,date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59'),$assort);break;
    	        case 5:$now = time();  $time = strtotime('-2 day', $now);
    	        $beginTime = date('Y-m-d 00:00:00', $time);
    	        $endTime = date('Y-m-d 23:59:59', $now);$config ['total_rows'] = $this->re->countList($time,$search_name,$beginTime,$endTime,$assort);break;
    	        case 6:$now = time();  $time = strtotime('-6 day', $now);
    	        $beginTime = date('Y-m-d 00:00:00', $time);
    	        $endTime = date('Y-m-d 23:59:59', $now);
    	        $config ['total_rows'] = $this->re->countList($time,$search_name,$beginTime,$endTime,$assort);
    	        break;
    	        case 7:$now = time();  $time = strtotime('-30 day', $now);
    	        $beginTime = date('Y-m-d 00:00:00', $time);
    	        $endTime = date('Y-m-d 23:59:59', $now);
    	        $config ['total_rows'] = $this->re->countList($time,$search_name,$beginTime,$endTime,$assort);
    	        break;
    	    }
	    }
	    $config ['per_page'] = $config['per_page'];
	    $config ['curr_page'] = $current_page;
	    $config['use_page_numbers']   = TRUE;
	    $config['page_query_string']  = TRUE;
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="gongying_fenye_next"';
	    $config ['prev_link'] = '上一页';
	    $config ['prev_tag_css'] = 'class="gongying_fenye_last"';
	    $config ['first_link'] = '首页';
	    $config ['first_tag_css'] = 'class="gongying_fenye_last"';
	    $config ['last_link'] = '尾页';
	    $config ['last_tag_css'] = 'class="gongying_fenye_last"';
	    $config ['cur_tag_open'] = '<span class="gongying_fenye_xuanzhong" style="margin:0 3px 0 5px;"><a >';
	    $config ['cur_tag_close'] = '</a></span>';
	    $this->pagination->initialize ( $config );
	    $data ['pagination'] = $this->pagination->create_links ();
	    $data['search_type'] = 2;

	    $offset   = ($current_page  - 1 ) * $config['per_page'];

	    //根据分类进行搜索
	    if(($search_name!='' || $assort!='') && $status==''){

	        $data['list'] =$this->re->getList($status='',$search_name, $beginTime='',$endTime='',$assort,$offset,$config ['per_page']);
	    }

        //根据商家级别或发布时间搜索
	    if($status=='' && $search_name=='' && $assort==''){
	        $data['list'] = $this->re->getList($status='',$search_name='', $beginTime='',$endTime='',$assort='',$offset,$config ['per_page']);
	    }//print_r($data);exit;
	    if($status>=1 && $status<=3){
	        $data['list'] = $this->re->getList($status,$search_name, $beginTime='',$endTime='',$assort,$offset,$config ['per_page']);
	    }
	    switch ($time){
	        case 4:$data['list'] = $this->re->getList($time,$search_name='',date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59'),$assort='',$offset,$config ['per_page']);break;
	        case 5:$now = time();  $time = strtotime('-2 day', $now);
                    $beginTime = date('Y-m-d 00:00:00', $time);
                    $endTime = date('Y-m-d 23:59:59', $now);$data['list'] = $this->re->getList($status,$search_name,$beginTime,$endTime,$assort,$offset,$config ['per_page']);break;
	        case 6:$now = time();  $time = strtotime('-6 day', $now);
                    $beginTime = date('Y-m-d 00:00:00', $time);
                    $endTime = date('Y-m-d 23:59:59', $now);
                    $data['list'] =$this->re->getList($time,$search_name, $beginTime,$endTime,$assort,$offset,$config ['per_page']);
                    break;
	        case 7:$now = time();  $time = strtotime('-30 day', $now);
                    $beginTime = date('Y-m-d 00:00:00', $time);
                    $endTime = date('Y-m-d 23:59:59', $now);
                    $data['list'] =$this->re->getList($time,$search_name, $beginTime,$endTime,$assort,$offset,$config ['per_page']);
                    break;
	    }

	    $data['notice'] = $this->content_mdl->getList(0, 20, $app['id'], $key = '');

	    $data['total_rows'] = $config['total_rows'];
	    $data['per_page'] = $config['per_page'];
	    $data['cu_page']=  $current_page;
	    $data['title'] = '更多需求';

	    //$data['yzm'] = $this->yzm_img();
	    //print_r($config);exit;
	    $this->load->view ( 'head', $data );
	    $this->load->view ( '_header', $data );
	    $this->load->view ( 'requirement/list', $data );
	    $this->load->view ( '_footer', $data );
	    $this->load->view ( 'foot', $data );
	}

}