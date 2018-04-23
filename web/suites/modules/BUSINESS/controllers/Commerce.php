<?php
/** 
 * @author Fxm
 * 商会控制器-基于部落
 * 商会 = 部落。
 */
class Commerce extends Front_Controller
{
    var $customer_id;
	function __construct()
	{
		parent::__construct();
		$this->session->set_userdata('ref_from_url', current_url());
		//判断登录
        if (! $this->session->userdata('user_in')) 
        {
            redirect('customer/login');
            exit();
        }
        
        // 判断是否微信浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            //调用接口处理
            $url = $this->url_prefix.'Customer/load';
            $data_post['customer_id'] = $this->session->userdata("user_id");
            $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
            if(!empty($customer['mobile'])){
                $this->session->set_userdata("mobile_exist",true);
            }else{
                redirect('member/binding/binding_mobile');
            }
        
        }
                                                            
        $this->customer_id = $this->session->userdata("user_id");//用户id
        
	}
	
	/**
	 * 检测联合会是否存在。
	 * @date:2017年11月23日 上午9:30:34
	 * @author: fxm
	 * @param: $app_labe_id 标签ID
	 * @return: array
	 */
	private function check_app( $app_labe_id = 0 )
	{ 
	    //一级。
	    $this->load->model('App_label_mdl');
	    $status = 'show_app_tribe_ids';
	    $app_labe_info = $this->App_label_mdl->Load( $app_labe_id, $status );
	    
	    //商户脚部导航颜色写进session方便foot文件获取
	    if(!empty($app_labe_info['color']))
	    {
	        $this->session->set_userdata("labe_foot_nav_color",$app_labe_info['color']);
	    }
	    
	    //如果一级标签不存在。
	    if( !$app_labe_info )
	    {
	        //参数错误
	        echo "<script>history.back(-1);alert('参数错误');</script>";exit;
	    }
	    
	    //二级。
	    $app_labe_info['app_tribe_ids'] = '';
	    $tribe_app_label_info = $this->App_label_mdl->Load_tribe_app_label( $app_labe_id );
	        
	    $app_tribe_id = !empty( $app_labe_info['tribe_id'] ) ? $app_labe_info['tribe_id'] : '';
	    
	    //如果二级存在，将二级标签下的部落ID拼接起来。
        if( $tribe_app_label_info )
        {
            foreach ($tribe_app_label_info as $key =>$val )
            {
	            $app_tribe_id = trim($app_tribe_id,",");
	            
	            if( $val['tribe_ids'])
	            {
	                $app_tribe_id .= ','.$val['tribe_ids'];
	            }
	        }
	    }
	    
        //将部落IDS 转为数组。
	    if( $app_tribe_id )
	    {
	        $ids = explode(',',$app_tribe_id);//字符串转数组
	        $app_labe_info['app_tribe_ids'] = array_unique($ids);
	        $app_labe_info['app_tribe_ids_string']  = $app_tribe_id;
	    }
	    
	    return $app_labe_info;
	    
	}
	
	/**
	 * 商会首页
	 */
	function index( $label_id )
	{
	    if($label_id == 2){
	        //当是在秦商注册绑定后 默认加入到某个部落
	        $qs_tribe_id = 155;//;
	        if(base_url() ==  'http://www.51ehw.com/'){
	            $qs_tribe_id = 364;
	        }
	        $this->load->model('Tribe_mdl');
	        $mobile =  $this->session->userdata("mobile");
	        $qs_tribe_info = $this->Tribe_mdl->get_tribe($qs_tribe_id);
	        if($qs_tribe_info && $qs_tribe_info['status'] == 2 ){
	            $qs_staff_info =  $this->Tribe_mdl->verify_tribe_user($qs_tribe_id,$mobile);
	            if(!$qs_staff_info){
	                $qs_num = $this->Tribe_mdl->getQSmemberList($qs_tribe_id);
	                $qs_num ++;
	                $qs_data["customer_id"] =  $this->customer_id;
	                $qs_data["tribe_id"] = $qs_tribe_id;
	                $qs_data["mobile"] = $mobile;
	                $qs_data["member_name"] = '好项目支持者'.$qs_num;
	                $qs_data['status'] = 2;//审核通过
	                $qs_data['show_mobile'] = 2;
	                $aff = $this->Tribe_mdl->add_staff($qs_data);
	            }
	        }
	    }
	    
	    
	    
	    $app_labe_info = $this->check_app( $label_id );
	    $this->load->model('tribe_mdl');
        //查nav。
        $data['nav_info'] = $this->App_label_mdl->Load_Nav( $label_id );
        
        //查询图片。
        $data['app_label_banner'] = $this->App_label_mdl->Load_Banner( $label_id );

       
        $data["mytribe"] = array();//我加入的部落。
        $data['announcement_list'] = array(); //公告
        $data['is_host'] = array(); //是否部落管理员。
        
        if( $app_labe_info['app_tribe_ids'] )
        {
           //查询加入的部落列表 && tribe_id = $labe_info['tribe_ids']。
	       $data["mytribe"] = $this->tribe_mdl->MyTribe($this->customer_id,1,$app_labe_info['app_tribe_ids']);
	       
	       //商会中的-部落公告
	       $this->load->model('Tribe_content_mdl');
	       $data['announcement_list'] = $this->Tribe_content_mdl->Load_Tribe_Content( $this->customer_id, $app_labe_info['app_tribe_ids'] );
	       
	       
	       //商会中的-部落活动
	       $this->load->model('Tribe_activity_mdl');
	       $data['activities_list'] = $this->Tribe_activity_mdl->tribe_activity( $app_labe_info['app_tribe_ids'],$this->customer_id,4 );
	       
	       
	       //是否部落管理员。
	       $data['is_host'] = $this->is_host($app_labe_info['app_tribe_ids']);

	       //商会中的-政策法规和行业动态
	       $the_label_tribe = $this->tribe_mdl->identical_tribe($app_labe_info['app_tribe_ids']);
	       $the_label_tribe = array_column($the_label_tribe,'id');
	       $data['laws_regulations'] = $this->Tribe_activity_mdl->news_information( $the_label_tribe,1,1,0 );
	       $data['industry_news'] = $this->Tribe_activity_mdl->news_information( $the_label_tribe,2,1,0 );

        }
        
        //秦商
        if($label_id == 2){
           $data['RecomendedShop'] = $this->App_label_mdl->getRecomendedShop($label_id);
        }
	   
	    $data['label_id'] = $label_id;
	    $data['title'] = $app_labe_info['name'];
	  
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $data['choose_foot'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/commerce_index', $data);
	    $this->load->view('commerce/foot',$data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	    

	}
	
	/**
	 * 首页菜单需要显示的各个页面。
	 * @date:2017年11月22日 下午2:41:13
	 * @author: fxm
	 * @param: variable
	 * @return: view
	 */
	public function Outstanding( $view = '', $label_id = 0 ) 
	{
	    $title_view['commerce'] = '杰出商会';
	    $title_view['corp'] = '企业推荐';
	    $title_view['celebrity'] = '名人推荐';
	    $title_view['integrity_corp'] = '诚信企业榜';
	    $title_view['integrity_customer'] = '诚信企业家榜';
	    $title_view['appraise'] = '项目评选';
	    $title_view['renwu'] = '十佳人物';
	    $title_view['cishan'] = '慈善企业';
	    $title_view['qiye'] = '十佳企业';
	    
	    
	    //秦商商会专属
	    if($label_id == 2){
	        
	        $search = $this->input->get("search");
	        
	        $title_view['specialty'] = '陕西特产专区';
	        $Nav_info = array();
	        $this->load->model('App_label_mdl');
	        $Nav_info = $this->App_label_mdl->get_SpecialtyTopNav($label_id);
	        foreach($Nav_info as $key =>$val){
	            $chilren = $this->App_label_mdl->get_SpecialtyNav($val['id']);
	            if($chilren){
	                $Nav_info[$key]['children'] = $chilren;
	            }else{
	                unset($Nav_info[$key]);
	            }
	          
	        }
	        $data['search'] = $search;
	        $data['Nav'] = $Nav_info;
	        
	    }else{
	        //参数错误
	        // show_404();
	        // exit;
	    }
	    
	    // 要底部导航的页面
	    $commerce_foot[] = 'commerce';
	    $commerce_foot[] = 'integrity_corp';
	    $commerce_foot[] = 'integrity_customer';
	    
	    $commerce_foot[] = 'specialty';
	  
	    if( !array_key_exists( $view,$title_view ) )
	    {
	        //参数错误
	        echo "<script>history.back(-1);alert('参数错误');</script>";exit;
	    }
	  
	    
	    $app_labe_info = $this->check_app( $label_id );
	    
	    if( $view == 'commerce' )
	    {
	       //杰出商会数据查询。
	       $this->load->model('Outstanding_mdl');
	       $data['commerce_list'] = $this->Outstanding_mdl->Load();
	       
	    }
	    $data['is_host'] = $this->is_host($app_labe_info['app_tribe_ids']);
	    
	    $mac_type = $this->input->get_post("mac_type");
	    if(isset($mac_type) && $mac_type == 'APP'){
	        $this->session->set_userdata("mac_type",$mac_type);
	    }
	    $data['mac_type'] = $mac_type;
	    $data ['title'] = $title_view[$view];
	    $data ['head_set'] = 2;
	    $data ['foot_set'] = 1;
	    $data['label_id'] = $label_id;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/'.$view, $data);
	    
	    if( in_array( $view, $commerce_foot) )
	    {
	        $this->load->view('commerce/foot',$data);
	    }
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	    
	}
	
	
	
	public  function get_SpecialtyProduct(){
	    
	    
	    $search = $this->input->post("search");
	    
	    $parent_id = $this->input->post("parent_id");
	    $label_id = $this->input->post("label_id");
	    $type = $this->input->post("type");
	    $limit = 10;//显示条数
	    $page = $this->input->post("page");//页数
	    if(0 == $page)
	    {
	        $page = 1;
	    }
	    $offset = ($page-1)*$limit;//偏移量
	    
	    if($parent_id){
	        $sift['where']['parent_id'] = $parent_id;
	    }
	    
	    $sift['search']['product'] = $search;
	    $sift['where']['type'] = $type;
	    $sift['where']['label_id'] = $label_id;
	    
	    $sift['page']['limit'] = $limit;
	    $sift['page']['offset'] = $offset;
	    
	    
	    $this->load->model('App_label_mdl');
	    $return['Product'] = $this->App_label_mdl->get_SpecialtyProduct($sift);
	  
	    if($return['Product']){
	        foreach ($return['Product'] as $k => $v){
	             if(!$v['market_price']){
	                 $return['Product'][$k]['market_price'] = 0;
	             }
	        }
	    }
	    
	    echo json_encode($return);
	}
	
	
	/**
	 * 秦商  会员中心
	 */
	public function UserCenter($label_id = 0){
	    if($label_id != 2){
	        show_404();
	        exit;
	    }
	    
	    $this->load->model('App_label_mdl');
	    $info = $this->App_label_mdl->load_label_member($label_id);
	    $data['info'] = $info;
	     
	    if($info){
	        echo "<script>history.back();alert('你已经成功提交');</script>";
	        exit;
	    }
	     
	    $data['title'] = '会员中心';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $data['label_id'] = $label_id;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/member_centre.php', $data);
// 	    $this->load->view('commerce/foot',$data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	 * 会员中心 异步提交
	 */
	public function  ajax_PostUser(){
	   $data =  $this->input->post();
	   
	   
	   
	   
	   if(!$data){
	       $return = array(
	           "Msg"=>'参数错误',
	           "status"=>'99'
	       );
	       echo json_encode($return);
	       exit;
	   }
	   
	   $education = array(
	       '硕士',
	       '研究生',
	       '本科',
	       '大专',
	       '高中',
	       '初中',
	       '小学'
	   );
	   if (!in_array($data['education'], $education)){
	       $return = array(
	           "Msg"=>'参数错误',
	           "status"=>'98'
	       );
	       echo json_encode($return);
	       exit;
	   }
	   //文化程度1，硕士，2研究生，3本科，4大专，5高中，6初中，7小学',
	   switch ($data['education']){
	       case '硕士':
	           $data['education'] = 1;
	           break;
           case '研究生':
               $data['education'] = 2;
               break;
           case '本科':
               $data['education'] = 3;
               break;
           case '大专':
               $data['education'] = 4;
               break;
           case '高中':
               $data['education'] = 5;
               break;
           case '初中':
               $data['education'] = 6;
               break;
           case '小学':
               $data['education'] = 7;
               break;
	   }
	  
	   $political_status = array(
	       '党员',
	       '群众',
	       '团员'
	   );
	   
	   if (!in_array($data['political_status'], $political_status)){
	       $return = array(
	           "Msg"=>'参数错误',
	           "status"=>'97'
	       );
	       echo json_encode($return);
	       exit;
	   }
	   //政治面貌，1党员，2群众，3团员',
	   switch ($data['political_status']){
	       case '党员':
	           $data['political_status'] = 1;
	           break;
	       case '群众':
	           $data['political_status'] = 2;
	           break;
	       case '团员':
	           $data['political_status'] = 3;
	           break;
	   }
	   
	   $user_id  =  $this->session->userdata("user_id");//用户id
	   $data['year'] = $data['sel1'];
	   $data['day'] = $data['sel2'];
	   
	   $data['native_provice'] = $data['province_id'];
	   $data['native_city'] = $data['city_id'];
	   
	   unset( $data['province_id']);
	   unset( $data['city_id']);
	   unset( $data['sel1']);
	   unset( $data['sel2']);
	   
	   if($data['sex'] == '男'){
	       $data['sex'] = 1;
	   }else {
	       $data['sex'] = 2;
	   }
	   
	   $data['customer_id'] = $user_id;
	   $this->load->model('App_label_mdl');
	   $info = $this->App_label_mdl->load_label_member($data['app_label_id']);
	   if($info){
	       $return = array(
	           "Msg"=>'已提交,请勿重复提交',
	           "status"=>'3'
	       );
	       echo json_encode($return);
	       exit;
	   }
	   
	   $data['created_at'] =   date('Y-m-d H:i:s');
	   
	   
	   $aff = $this->App_label_mdl->create_label_member($data);
	   if($aff){
	       $return = array(
	           "Msg"=>'提交成功',
	           "status"=>'1'
	       );
	   }else{
	       $return = array(
	           "Msg"=>'提交失败，请重试',
	           "status"=>'2'
	       );
	   }
	   echo json_encode($return);
	}
	/**
	 * 秦商 发现页面
	 */
	
	public function Seek($label_id){
	    if($label_id != 2){
	        show_404();
	        exit;
	    }
	    
	    $data['choose_foot'] = '3';
	    $data['title'] = '发现';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $data['label_id'] = $label_id;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/seek', $data);
	    $this->load->view('commerce/foot',$data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	 * 活动列表
	 */
	public function ajax_activity_list( )
	{
	    $label_id = $this->input->post("app_labe_id");
	    $limit = 10;//显示条数
	    $page = $this->input->post("page");//页数
	    if(0 == $page)
	    {
	        $page = 1;
	    }
	    $offset = ($page-1)*$limit;//偏移量
	    
	    $sift['page']['limit'] =  $limit;
	    $sift['page']['offset'] =  $offset;
	    
	    $app_label_info = $this->check_app($label_id);
	    $app_tribe_ids = $app_label_info['app_tribe_ids'];
	    
	    $customer_id = $this->session->userdata("user_id");//用户id
	    $sift['where']['customer_id'] = $customer_id;
	    $sift['where']['tribe_id'] = $app_tribe_ids;
	    $sift['sql_status'] = true;
	    
	    $this->load->model('Tribe_activity_mdl');
	    $this->load->model('tribe_mdl');
	    $data['activity_list'] = $this->Tribe_activity_mdl->Load( $sift );
	    if($data['activity_list']){
	        foreach ($data['activity_list'] as $key =>$val){
	            $tribe_info =   $this->tribe_mdl->get_tribe($val['tribe_id']);
	            $data['activity_list'][$key]['tribe_name'] = $tribe_info['name'];
	            $data['activity_list'][$key]['tribe_logo'] = $tribe_info['logo'];
	        }
	    }
	    echo  json_encode($data);
	}
	
	
	/**
	 * 商会-个人中心。
	 * @date:2017年11月22日 下午3:32:35
	 * @author: fxm
	 * @param: variable
	 * @return: view
	 */
	public function Customer_Info( $label_id = 0 )
	{ 
       
	    //查询商会存在哪些部落ID。
	    $labe_info = $this->check_app( $label_id );
	    
	    $this->session->unset_userdata('ref_from_url');
	    // 判断是否微信浏览器
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
	         
	        //调用接口处理
	        $url = $this->url_prefix.'Customer/load';
	        $data_post['customer_id'] = $this->customer_id;
	        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
	    
	        // 如果没有上线
	        if ($customer['parent_id'] == 0) {
	            if (isset($_COOKIE['inviteid'])) {
	                $parent_id = $_COOKIE['inviteid'];
	                $this->customer_mdl->update_parent($this->customer_id, $parent_id);
	            }
	        }
	    }
	    
	 
	    //-----切换站点  开始
	    $user_key = $this->input->get("user_key");
	    if($user_key)
	    {
	        //接口获取用户信息
	        $url = $this->url_prefix.'Customer/get_memcached';
	        $post['user_key']=$user_key;
	        $_customer = json_decode($this->curl_post_result($url,$post),true);
	        if( $_customer['type'] == 'wechat'){//wechat
	            $customer = array(
	                'user_name' => $_customer['user_name'],
	                'user_id' => $_customer['user_id'],
	                'img_avatar' => $_customer['img_avatar'],
	                'is_active' => $_customer['is_active'],
	                'user_in' => TRUE,
	                'unionid' => $_customer['unionid'],
	                'openid' => $_customer['openid'],
	                'pay_relation' => $_customer['pay_relation'],
	    
	            );
	    
	            if(!empty($_customer['nick_name'])){
	                $customer['nick_name'] = $_customer['nick_name'];
	            }
	            if(!empty($_customer['pay_relation'])){
	                $customer['pay_relation'] = $_customer['pay_relation'];
	            }
	            $this->session->set_userdata($customer);
	            //切换站点后,购物车记录会被清空,需重新获取购物车
	            $this->load->model('cart_mdl');
	            $this->cart_mdl->reinit($customer['user_id']);
	        }
	    }
	    //-----切换站点  结束
	    
	    $account_id = $this->session->userdata('user_id');
	    $this->load->model("customer_mdl");
	    $this->load->model('customer_address_mdl');
	    $data['customer'] = $this->customer_mdl->get_customer_info($account_id);//查询用户信息
	    //h5
	    if( $this->isMobile() ){
	    
	        $url = $this->url_prefix.'Customer/load_pay_account?';
	        $customerinfo['customer_id'] =$account_id;
	    
	        $pay_info = json_decode($this->curl_post_result($url,$customerinfo),true);
	    
	        if($pay_info){
	            $data['customer'] = array_merge($data['customer'],$pay_info);
	            if (! ($data['customer']['credit_start_time'] <= date('Y-m-d H:i:s') && $data['customer']['credit_end_time'] >= date('Y-m-d H:i:s'))) {
	                $data['customer']['credit'] = '0.00';
	            }
	        }else{
	            //若没有支付账户，则现金为0 提货权为0
	            $data['customer']['cash'] = 0;
	            $data['customer']['credit'] = '0.00';
	        }
	    
	        // 获取默认收货地址
	        $data['address'] = $this->customer_address_mdl->load($account_id);
	        $this->load->model('order_mdl');
	        $data['count_unfinished_orders'] = $this->order_mdl->count_orders($account_id);
	    
	        if (! $data['address']) {
	            $data['address'] = array(
	                'phone' => null,
	                'mobile' => null,
	                'address' => null,
	                'email' => null,
	                'postcode' => null,
	                'address_for_name' => null
	            );
	        }
	    }
	   
	    //应产品需求  管自己部落不需要再对部落进行限制 
// 	    $data['is_host'] = array();
// 	    if( $labe_info['app_tribe_ids'] )
// 	    {
// 	        $this->load->model('tribe_mdl');
// 	        $data['is_host'] = $this->tribe_mdl->get_Mytribe($this->customer_id,$labe_info['app_tribe_ids']);
// 	    }
        $data['is_host'] = $this->is_host($labe_info['app_tribe_ids']);  
       
	    $this->load->model("tribe_mdl");
	    $tribe = $this->tribe_mdl->get_MyTribe($account_id);///查询我创建的部落
	 
	    $data['show'] = false;
	    if(count($data['is_host']) > 0){
	        if($tribe){
	                $data['show'] = true;
	        }
	       
	    }
	    $data['tribe'] =$tribe;
        
	    $this->load->model("tribe_package_mdl");
	    $packages = $this->tribe_package_mdl->get_tribe_package($account_id);
	    
	    $data['send_tribe_pack'] = false;
	    
	    if($packages){
	        $data['send_tribe_pack'] = true;
	    }
	    
// 	    $data["is_host"] = false;
// 	    $data['is_manage'] = 1;//默认可以创建部落。
	    
// 	    $tribe = $this->tribe_mdl->get_MyTribe( $account_id );//查询我创建的部落
	   
	   
        //是否部落管理员。
        $data['app_tribe_ids'] = $labe_info['app_tribe_ids'];
	    $data['choose_foot'] = 5;
	    $data['label_id'] = $label_id;
	    $data['title'] = '我的商会';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/customer_info', $data);
	    $this->load->view('commerce/foot',$data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
    
	
	/**
	 * 我的商会 = 加入的部落。
	 * @date:2017年11月22日 下午4:52:03
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function My_Commerce()
	{ 

	    $this->load->model('tribe_mdl');
	    
	    //我的部落
	    $data["mytribe"] = $this->tribe_mdl->MyTribe($this->customer_id,1);
	    $data['title'] = '我的商会';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
// 	    $this->load->view('commerce/customer_info', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	    
	}
	
	
	
	/**
	 * 人脉页面。
	 * @date:2017年11月23日 上午11:23:27
	 * @author: fxm
	 * @param: variable
	 * @return: 
	 */
	public function People( $labe_id = 0 , $tribe_id = 0 ) 
	{
	    
	    //查询商会存在哪些部落ID。
	    $labe_info = $this->check_app( $labe_id );
	    
	    
	    $data['is_host'] = array();
	    $data['tribe_list'] = array(); 
	    
	    if( $labe_info['app_tribe_ids'] )
	    { 
	        //查询加入的部落列表 && tribe_id = $labe_info['tribe_ids']。
	        $this->load->model('tribe_mdl');
	        $tribe_list = $this->tribe_mdl->MyTribe($this->customer_id,'',$labe_info['app_tribe_ids']);
	        
	        if( $tribe_list )
	        {
    	         
    	        $id  = $tribe_id ? $tribe_id : $tribe_list[0]['id'];
    	         
    	        $user_info = $id ? $this->tribe_mdl->load_members_list( $id, $this->customer_id,null,'manager') : 0;//查询部落
    	        
    	        if( !$user_info )
    	        {
    	            echo "<script>history.back(-1);alert('您不是该部落成员，无法访问');</script>";exit;
    	        }
    	         
    	        $tribe_duties_list = $this->tribe_mdl->load_members_duties( $id );
    	         
    	        $list = $this->tribe_mdl->load_members_list( $id,0,null ,'manager');
    	        
    	        $tribe_duties_list = array_column($tribe_duties_list, NULL,'id');
    	        
    	        $i = 0;
    	        //处理数据
    	        foreach ( $list as $k=>$v )
    	        {
    	             
    	            if( isset( $tribe_duties_list[$v['tribe_role_id']]) )
    	            {
    	                $tribe_duties_list[$v['tribe_role_id']]['list'][] = $v;
    	                continue;
    	            }
    	             
    	            $i++;
    	            $tribe_duties_list[0]['list'][] = $v;
    	             
    	        }
    	         
    	        
    	        if( $i )
    	        {
    	            $tribe_duties_list[0]['id'] = 0;
    	            $tribe_duties_list[0]['total'] = $i;
    	            $tribe_duties_list[0]['role_name'] = '部落成员';
    	        }
    	        
    	        $data['my_info'] = $user_info;
    	        $data['list'] = $tribe_duties_list;
    	        $data['tribe_id'] = $id;
    	        $data['tribe_list'] = $tribe_list;
	        }
	        
	    }
	   
	    $data['is_host'] = $this->is_host($labe_info['app_tribe_ids']);
	    
	    $data['label_id'] = $labe_id;
	    $data['choose_foot'] = 4;
	    $data['title'] = !empty( $user_info['t_name'] ) ? $user_info['t_name'] : '人脉';
	    
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/people', $data);
	    $this->load->view('commerce/foot',$data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	
	/**
	 * ajax 获取部落成员列表
	 */
	
	public function  ajax_People(){
	    
	    $label_id = $this->input->post("label_id");
	    $tribe_id = $this->input->post("tribe_id");
	    
	   
// 	    $labe_id = 2;
// 	    $tribe_id = 6;
	    //查询商会存在哪些部落ID。
	    $labe_info = $this->check_app( $label_id );
	    
	    if( $labe_info['app_tribe_ids'] )
	    {
	        //查询加入的部落列表 && tribe_id = $labe_info['tribe_ids']。
	        $this->load->model('tribe_mdl');
	        $tribe_list = $this->tribe_mdl->MyTribe($this->customer_id,'',$labe_info['app_tribe_ids']);
	         
	        if( $tribe_list )
	        {
	    
	            $id  = $tribe_id ? $tribe_id : $tribe_list[0]['id'];
	    
	            $user_info = $id ? $this->tribe_mdl->load_members_list( $id, $this->customer_id,null,'manager') : 0;//查询部落
	             
	            if( !$user_info )
	            {
	                echo "<script>history.back(-1);alert('您不是该部落成员，无法访问');</script>";exit;
	            }
	    
	            $tribe_duties_list = $this->tribe_mdl->load_members_duties( $id );
	    
	            $list = $this->tribe_mdl->load_members_list( $id,0,null ,'manager');
	             
	            $tribe_duties_list = array_column($tribe_duties_list, NULL,'id');
	             
	            $i = 0;
	            //处理数据
	            foreach ( $list as $k=>$v )
	            {
	    
	                if( isset( $tribe_duties_list[$v['tribe_role_id']]) )
	                {
	                    $tribe_duties_list[$v['tribe_role_id']]['list'][] = $v;
	                    continue;
	                }
	    
	                $i++;
	                $tribe_duties_list[0]['list'][] = $v;
	    
	            }
	    
	             
	            if( $i )
	            {
	                $tribe_duties_list[0]['id'] = 0;
	                $tribe_duties_list[0]['total'] = $i;
	                $tribe_duties_list[0]['role_name'] = '部落成员';
	            }
	             
	           
	            $data['my_info'] = $user_info;
	            $data['list'] =    array_values($tribe_duties_list);
	            $data['tribe_id'] = $id;
	            $data['tribe_list'] = $tribe_list;
	        }
	    }
	    $data['is_host'] = $this->is_host($labe_info['app_tribe_ids']);
	    
	    echo json_encode($data);
	}
	
	
	
	/**
	 * 选择商会页面。
	 * @date:2017年11月24日 上午10:35:05
	 * @author: fxm
	 * @param: 发布圈子动态使用页面。
	 * @return: 
	 */
	public function Choose_Commerce( $labe_id = 0, $status = 0 )
	{ 
	    //查询商会存在哪些部落ID。
	    $labe_info = $this->check_app( $labe_id );
	    
	    $tribe_list = array();
	    if( $labe_info['app_tribe_ids'] )
	    {
    	    $data['is_host'] = $this->is_host($labe_info['app_tribe_ids']);
    	}
	    $this->load->model('tribe_mdl');
	    
	    switch ( $status )
	    { 
	        case 2:
	            $modules = 'Tribe/tribe_announcements_view/';//公告
	            $tribe_list = $this->tribe_mdl->ManagementTribe($this->customer_id,$labe_info['app_tribe_ids'],2);//查询管理的部落
	            break;
	        case 3:
	            $modules = 'Tribe/publish_events_view';//发活动
	            $tribe_list = $this->tribe_mdl->ManagementTribe($this->customer_id,$labe_info['app_tribe_ids'],2);//查询管理的部落
	            
	            break;
            default:
                $tribe_list = $this->tribe_mdl->MyTribe($this->customer_id,'',$labe_info['app_tribe_ids']);
                $modules = 'Circles/Add_Topic';//发动态
                break;
	    }
	    $data['modules'] = $modules;
	    $data['status'] = $status;
	    $data['tribe_list'] = $tribe_list;
	    $data['label_id'] = $labe_id;
	    $data['choose_foot'] = 4;
	    
	    $data['title'] = '选择部落';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/commerce_choice', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	
	/**
	 * 商会名录(商会二级标签列表)
	 * @date:2017年11月24日 上午11:27
	 * @author:tan
	 * @param int $label_id 一级标签ID
	 */
	public function  Commerce_label_list($label_id = 0){
	     
	    $app_info  = $this->check_app($label_id);
	   
	    $this->load->model('tribe_mdl');
	     
	    $data['tribe_info'] = $this->tribe_mdl->get_tribe($app_info['tribe_id']);
	     
	    $this->load->model('App_label_mdl');
	    $data['label_list'] =  $this->App_label_mdl-> Load_tribe_app_label($label_id);
	   
	    $data['is_host'] = $this->is_host(  $app_info['app_tribe_ids']);
	    $data['label_id'] = $label_id;
	    $data['title'] = '商会名录';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/commerce_directory', $data);
	    // 	    $data['choose_foot'] = 5;
	    // 	    $this->load->view('commerce/foot',$data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	 * 商会名录(商会二级标签列表)
	 * @date:2017年11月24日 下午14:15
	 * @author:tan
	 * @param int $tribe_app_label_id 二级标签ID
	 */
	public function tribe_label_list($tribe_app_label_id){
	   
	    
	    $this->load->model('App_label_mdl');
	    $app_label_detail = $this->App_label_mdl->Load_tribe_app_label_detail($tribe_app_label_id);
	    if(!$app_label_detail){
	        //参数错误
	        echo "<script>history.back(-1);alert('参数错误');</script>";exit;
	    }
	    $label_info = $this->check_app( $app_label_detail['app_label_id']);
	  
	    if($app_label_detail['tribe_ids'])
	    {
	        $tribe_ids = trim($app_label_detail['tribe_ids'],',');
	        $tribe_ids = explode(',', $tribe_ids);
	    }
	    
	 
	    
	    if( !empty( $tribe_ids ) )
	    {
	        $this->load->model("tribe_mdl");
    	    $tribe_info = $this->tribe_mdl->get_tribe_list($tribe_ids);
    	 
    	}
	    $data['tribe_info'] = !empty( $tribe_info ) ? $tribe_info : array();
	    $data['is_host'] = $this->is_host($label_info['app_tribe_ids']);
	    $data['label_id'] = $label_info['id'];
	    $data['title'] = '商会名录';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/tribe_label_list', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	     
	     
	}
	
	/**
	 * 搜索商会会员(商会部落)
	 * @date:2017年11月24日 下午14:40
	 * @author:tan
	 * @param int $tribe_app_label_id 一级标签ID
	 */
	public  function  search_tribe($label_id = 0){
	     
	    $app_info  = $this->check_app($label_id);
	    
	    $data['is_host'] = $this->is_host($app_info['app_tribe_ids']);
	    $data['label_id'] = $label_id;
	    $data['title'] = '搜索商会';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/search_tribe', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	 * 搜索商会会员(商会部落)
	 * @date:2017年11月24日 下午14:40
	 * @author:tan
	 * @param int $tribe_app_label_id 一级标签ID
	 */
	public function JoinCommerce( $label_id = 0 )
	{ 
	    
	    $app_labe_info = $this->check_app( $label_id );
	    
	    
	    $data["tribe_info"] = array();
	    if( $app_labe_info['app_tribe_ids'] )
	    {
    	    //查询加入的部落列表 && tribe_id = $labe_info['tribe_ids']。
    	    $this->load->model('tribe_mdl');
    	    $data["tribe_info"] = $this->tribe_mdl->MyTribe($this->customer_id,1,$app_labe_info['app_tribe_ids']);
	    }
	    $data['is_host'] = $this->is_host($app_labe_info['app_tribe_ids']);
	    $data['label_id'] = $label_id;
	    $data['title'] = '我的商会';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/commerce_my', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	
	/**
	 * 搜索商会会员(商会部落)
	 * @date:2017年11月24日 下午14:40
	 * @author:tan
	 * @param int $tribe_app_label_id 一级标签ID
	 * @param string $param 搜索内容
	 */
	public  function ajax_search_tribe(){
	    $label_id = $this->input->post("id");//搜索内容
	     
	    $label_info = $this->check_app($label_id);
	
	    $return['list'] = array();
	    
	    if( $label_info['app_tribe_ids'] ) 
	    {
    	    $keyword = $this->input->post("param");//搜索内容
    	    $limit = 10;//显示条数
    	    $page = $this->input->post("page");//页数
    	    if(0 == $page)
    	    {
    	        $page = 1;
    	    }
    	    $offset = ($page-1)*$limit;//偏移量
    	     
    	    $this->load->model('tribe_mdl');

    	    
    	    $return['list'] = $this->tribe_mdl->get_tribe_list($label_info['app_tribe_ids'],$keyword,$limit,$offset);

//     	    echo '<pre>';
//     	    var_dump($return['list']);
	    }
	    
	    echo json_encode($return);
	}
	
	
	/**
	 * @author JF
	 * 2017年11月27日
	 * 查询商会公告列表
	 */
	function ajax_notice_list(){
	    $app_labe_id = $this->input->post("app_labe_id");//商会id
	    $keyword = $this->input->post("keyword");//关键词
	    $customer_id = $this->customer_id;
	    
	    $app_labe_info = $this->check_app($app_labe_id);
	   
	    $limit = 10;//显示条数
	    $page = $this->input->post("page");//页数
	    if(0 == $page)
	    {
	        $page = 1;
	    }
	    $offset = ($page-1)*$limit;//偏移量
	    
	    $this->load->model("tribe_mdl");
	    $this->load->model("tribe_content_mdl");
	    $return['announcement_list']  = array();
	    $mytribe = $this->tribe_mdl->MyTribe($this->customer_id,1,$app_labe_info['app_tribe_ids']);//查询加入的部落列表 && tribe_id = $labe_info['tribe_ids']。
	    if($mytribe){
	        $tribe_ids = array_column($mytribe,"id");
	        //------------暂时处理------------
	        $list = $this->tribe_content_mdl->Load_Notice($tribe_ids);
	        
	        if(count($list) > 0){
	            $this->load->model('Tribe_read_mdl');
	            foreach ($list as $k => $v){
	                //查询判断是否已经阅读，如果无则添加
	                $row = $this->Tribe_read_mdl->check_read($customer_id,$v['id'],1);
	                if(!$row ){
	                    $parameter = array(
	                        "customer_id" => $customer_id,
	                        "type" => 1,
	                        "obj_id" => $v['id'],
	                        "tribe_id" => $v['tribe_id']
	                    );
	                    $this->Tribe_read_mdl->create($parameter);
	                }
	            }
	        }
	        //------------暂时处理------------
	        $return['announcement_list'] = $this->tribe_content_mdl->Load_Notice($tribe_ids,$limit,$offset,$keyword);//查询公告列表
        }
      
        echo json_encode($return);
	}
	
	/**
	* @author JF
	* 2017年11月27日
	* 进入公告读取状态页
	* @param number $id 公告id
	* @param number $type 1未读2已读
	*/
	function notice_state($id=0,$type = 1){
	    $this->load->model("tribe_content_mdl");
	    $data["unread_total"] = $this->tribe_content_mdl->unread($id);//未读
	    $data["read_total"] = $this->tribe_content_mdl->read($id);//已读
	    
	    $data["id"] = $id;
	    $data["type"] = $type;
	    $data['title'] = '查看已读';
	    $data['head_set'] = 2;
	    $data['foot_set'] = 1;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/commerce_notice_people', $data);
	    $this->load->view('_footer', $data);
	    $this->load->view('foot', $data);
	}
	
	/**
	* @author JF
	* 2017年11月28日
	* ajax查询公告状态
	*/
	function ajax_notice_state(){
       $id = $this->input->post("id");//公告id
       $type = $this->input->post("type");//类型1未读2已读
       $limit = 10;//显示条数
       $page = $this->input->post("page");//页数
       if(0 == $page)
       {
           $page = 1;
       }
       $offset = ($page-1)*$limit;//偏移量
       
	   $this->load->model("tribe_content_mdl");
	   if($type == 1){
	       $return["list"] = $this->tribe_content_mdl->unread($id,$limit,$offset);//未读
	   }else{
	       $return["list"] = $this->tribe_content_mdl->read($id,$limit,$offset);//已读
	   }
	   echo json_encode($return);
	}
	
	public function is_host($app_tribe_ids){
	    $this->load->model('tribe_mdl');
	    //是否部落管理员。
	    if( $app_tribe_ids )
	    {
	        $data = $this->tribe_mdl->ManagementTribe($this->customer_id,$app_tribe_ids,2);
	        
	        if(count($data) > 0){
	            return $data;
	        }else{
	            return array();
	        }
	    }
	}
	
	
	
	//关注商会微信公众号
	public function  subscribe( $label_id = 0 )
	{
	    $data['title'] = '关注公众号';
	    $data['foot_set'] = 1;
	    $data['head_set'] = 2;
	    $this->load->view('head', $data);
	    $this->load->view('_header', $data);
	    $this->load->view('commerce/subscribe', $data);
	    $this->load->view('_footer', $data);
	}
}