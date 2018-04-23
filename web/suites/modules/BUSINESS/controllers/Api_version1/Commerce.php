<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Commerce extends Api_Controller {
    
    /**
     * 商会APP接口
     * 
     */
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("tribe_mdl");
        $this->load->model("customer_mdl");
        $this->load->model("App_label_mdl");
       
        //标签sn  唯一标识APP访问
        $label_sn = $this->session->userdata("label_sn");
        if(!$label_sn){
            $tag = json_decode($this->input->get_post('t', 0), true);
            $label_sn = $tag["label_sn"];
            if(!$label_sn){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '98',
                    'errorMessage' => '参数错误'
                );
                print_r(json_encode($return));
                exit();
            }

            $this->load->model("app_version_mdl");
            $label_info = $this->app_version_mdl->getIDBylabel_sn($label_sn);
            if(!$label_info){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '99',
                    'errorMessage' => '参数错误'
                );
                print_r(json_encode($return));
                exit();
            }
            $this->session->set_userdata("label_sn",$label_sn);
            $this->session->set_userdata("label_id",$label_info['id']);
        }
    }
    
    public function index()
    {
        echo 'Commerce API';
    }
    
    
    
    /**
     * 商会首页 以及 部落内页
     */
    public  function  Home(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $return['data'] = array(
            "announcement" =>array(),
            "tribe" =>array(),
            "activities" =>array(),
            "banner_info" =>array(),
            "nav_info" =>array(),
        );
        
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $tribe_id = isset($prams['tribe_id']) && $prams['tribe_id'] ? $prams['tribe_id']:0;
        //商会首页
        if(!$tribe_id){
            $this->load->model('Tribe_content_mdl');
            $sift['where']['customer_id'] = $user_id;
            
            $label_id = $this->session->userdata("label_id");
            $app_tribe_ids = $this->get_app_tribe_ids();
          
            $sift['sql_status'] = true;
            $sift['where']['tribe_id'] = $app_tribe_ids;
            
            //联合会公告
            
            $data= $this->Tribe_content_mdl->Load_Tribe_Content( $user_id, $app_tribe_ids);
//             $data = $this->Tribe_content_mdl->Load_new_content( $sift );
            if(!empty($data)){
                foreach ($data as $key =>$val){
                    $list[$key]['id'] = $val['id'];
                    $list[$key]['title'] = $val['title'];
                    $list[$key]['content'] = $val['content'];
                    $list[$key]['title_img'] = $val['title_img'];
                    $list[$key]['url'] =  site_url("Tribe/announcement_detaile/").'/'.$val['id'].'?mac_type=APP';
                    	
                }
            }else{
                $list= $data;
            }
            
            //部落的最新一条公告
            $return['data']['single_announcement'] = NULL;
            if(!empty($data)){
                
                $tribe_info = $this->tribe_mdl->get_tribe(  $data[0]['tribe_id']);
                $data[0]['tribe_name'] =$tribe_info['name'];
                $data[0]['logo'] =$tribe_info['logo'];
                $data[0]['url'] =  site_url("Tribe/announcement_detaile/").'/'.$data[0]['id'].'?mac_type=APP';
                $return['data']['single_announcement'] = $data[0];
            }
            
            $label_id = $this->session->userdata("label_id");
            $banner_info = $this->App_label_mdl->Load_Banner($label_id);
            $nav_info = $this->App_label_mdl->Load_Nav($label_id);
           
            $return['data']['banner_info'] = $banner_info;
            
            if($nav_info){
                foreach ($nav_info as $k =>$v) {
                    $nav_info[$k]['link'] = $v['link'].'?mac_type=APP';
                }
            }
            $return['data']['nav_info'] = $nav_info;
            
            //我的部落
            $sift['where']['all_tribe_id'] = $app_tribe_ids;
            //筛选出商会加入的部落与用户加入到部落之间的交集部落
            $mytribe = $this->tribe_mdl->identical_tribe($app_tribe_ids);
         
            
            $app_tribe_ids_str = "0";
            
            $app_tribe_ids = array();
            foreach ($mytribe as $k =>$v){
                $app_tribe_ids[] = $v['id'];
                $app_tribe_ids_str .= ','.$v['id'];
            }
            if(!$app_tribe_ids){
                $app_tribe_ids = array(0);
            }
            
            $sift['where']['customer_id'] =  '999';//默认ture
            
            $sift['where']['tribe_id'] = $app_tribe_ids;
            $sift['where']['type'] = 1;
            $sift['sql_status'] = false;
            $sift['sql_app'] = true;
            $this->load->model('Tribe_activity_mdl');
            $law_info= $this->Tribe_activity_mdl->Load( $sift );
           
            //部落的最新一条活动记录
            $sift['where']['type'] = 0;
            $single_activity = $this->Tribe_activity_mdl->Load( $sift );
            $return['data']['single_activity'] = NULL;
            if($single_activity){
                $return['data']['single_activity'] = $single_activity[0];
            }
          
            //查询新的部落消息通知
//             $new_message = $this->tribe_mdl->Load_Tribe_Message( $user_id ,$app_tribe_ids);
          
            $Msg['where']['customer_id'] = $user_id;
            $Msg['where']['type'] = 4;
            $Msg['where']['tribe_id'] = $app_tribe_ids_str;
            
            $this->load->model('Customer_message_mdl','Message');
            $Message = $this->Message->Load_Customer_Message($Msg);///获取推送信息列表
//             echo '<pre>';
//             print_r($this->db->last_query());exit;
            $return['data']['single_message'] = NULL;
            if($Message){
                $new_message = $Message[0];
                if( $new_message )
                {
                    $tribe_info = $this->tribe_mdl->get_tribe(   $new_message['obj_id']);
                    $return['data']['single_message'] = $new_message;
                    $return['data']['single_message']['tribe_name'] = $tribe_info['name'];
                    $return['data']['single_message']['logo'] = $tribe_info['logo'];
                    $return['data']['single_message']['message'] =  str_replace( array('<!--','-->'),array('',''), $new_message['message'] );
                }
            }
            
            //部落的最新一条话题
            $return['data']['single_topic'] = NULL;
            if($mytribe){
                $topic['where']['tribe_id'] = array_column($mytribe, 'id');
                $topic['where']['customer_id'] = $user_id;
                $topic['return_row'] = true;
                $this->load->model('Tribe_topic_mdl');
                $return['data']['single_topic'] = $this->Tribe_topic_mdl->Load( $topic,true );
                if($return['data']['single_topic'] )
                {
                    $tribe_info = $this->tribe_mdl->get_tribe(   $return['data']['single_topic']['tribe_id']);
                    if(empty($return['data']['single_topic']['brief_avatar'])){
                         $return['data']['single_topic']['logo_avatar'] = $return['data']['single_topic']['wechat_avatar'];
                    }else{
                         $return['data']['single_topic']['logo_avatar'] = IMAGE_URL.$return['data']['single_topic']['brief_avatar'];
                    }
                    $return['data']['single_topic']['tribe_name'] = $tribe_info['name'];
                    if(!$return['data']['single_topic']['images']){
                        $return['data']['single_topic']['images'] = array();
                    }else{
                            $bg_img = explode(';',  $return['data']['single_topic']['images']);
                            $bg_img = array_filter($bg_img);
                            $return['data']['single_topic']['images'] = $bg_img;
                    }
                    $return['data']['single_topic']['upvote_info']  =  $this->Tribe_topic_mdl->topic_upvote_member_name($return['data']['single_topic']['id']);
                }
            }
            
            
            if($law_info){
                $law_status = 1;
            }else{
                $law_status = 0;
            }
            $sift['where']['type'] = 2;
            $dynamic_info= $this->Tribe_activity_mdl->Load( $sift );
            if($dynamic_info){
                $dynamic_status = 1;
            }else{
                $dynamic_status = 0;
            }
            
            
            $return['data']['law_status'] = $law_status;
            $return['data']['dynamic_status'] = $dynamic_status;
            
            //秦商
            if($label_id == 2){
                $return['data']['Lottery'] = array(
                    'logo' => 'images/lottery/vote.png',
                    'mobile' => 0,
                );
                $this->load->model("customer_mdl");
                $UserInfo = $this->customer_mdl->load($user_id);
                if(!empty($UserInfo['mobile'])){
                    $return['data']['Lottery']['mobile'] = $UserInfo['mobile'];
                }
                $this->load->model('Lottery_mdl');
                $sift['key'] = $user_id;
                $sift['type'] = 'customer_id';
                $LotteryInfo = $this->Lottery_mdl->load($sift);
                if($LotteryInfo && !empty($LotteryInfo['mobile'])){
                    $return['data']['Lottery']['mobile'] = $LotteryInfo['mobile'];
                }
                
                $return['data']['Commerce_label_list']['logo'] = 'images/commerce/commerce_name.png';
                $return['data']['TopTenProject'] = array(
                        "logo" =>  'images/commerce/commerce_xiangmu01.png',
                        "link" =>  site_url('Notice/shijia/2'),
                );
                $return['data']['Specialty']['logo'] = 'images/commerce/specialty.png';
                $return['data']['Specialty']['title'] = ' 陕西特产专区';
                
                $RecomendedShop = $this->App_label_mdl->getRecomendedShop($label_id);
                if($RecomendedShop){
                    foreach ($RecomendedShop as $key => $val){
                        $RecomendedShop[$key]['url'] = site_url("Home/GetShopGoods/{$val['id']}");
                        unset($RecomendedShop[$key]['link'] );
                    }
                }else{
                    $RecomendedShop = null;
                }
                $return['data']['RecomendedShop']= $RecomendedShop;
            }
            
        }else{
            $mytribe = $this->tribe_mdl->load( $tribe_id,$user_id );//查询部落
            if(!$mytribe){
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '7',
                    'errorMessage' => '部落不存在'
                );
                print_r(json_encode($return));
                exit();
            }
            	
            if($mytribe['tribe_staff_id'] && $mytribe['status'] == 2){
        
                $mytribe['bg_img'] = explode(';',$mytribe['bg_img']);
                $mytribe['bg_img'] = array_filter($mytribe['bg_img']);
        
                //部落内的公告
                $sift['where']['customer_id'] = $user_id;
                $sift['where']['tribe_id'] = $tribe_id;
                $sift['sql_status'] = true;
        
                //部落活动
                $this->load->model('Tribe_activity_mdl');
                $activities = $this->Tribe_activity_mdl->Load( $sift );
                foreach ($activities as $key => $val){
                    $activities[$key]['tr_name'] = $mytribe['name'];
                    $activities[$key]['logo'] = $mytribe['logo'];
                }
                $return['data']['activities'] = $activities;
                $this->load->model('Tribe_content_mdl');
                $list = $this->Tribe_content_mdl->Load_List( $sift );
                foreach ($list as $key =>$val){
                    $list[$key]['url'] = site_url("Tribe/announcement_detaile/").'/'.$val['id'].'/'.$tribe_id;
                }
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '8',
                    'errorMessage' => '尚未加入该部落'
                );
                print_r(json_encode($return));
                exit();
            }
        }
        
        $return['data']['announcement'] = $list;
        $return['data']['tribe'] = $mytribe;
       
        print_r(json_encode($return));
        
    }
    
    /**
     * 获取商会话题最新的一条
     */
    public  function  newest_topic(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $app_tribe_ids = $this->get_app_tribe_ids();
        //筛选出商会加入的部落与用户加入到部落之间的交集部落
        $mytribe = $this->tribe_mdl->identical_tribe($app_tribe_ids);
        
        $return['data'] = null;
        if($mytribe){
            $topic['where']['tribe_id'] = array_column($mytribe, 'id');
            $topic['where']['customer_id'] = $user_id;
            $topic['return_row'] = true;
            $this->load->model('Tribe_topic_mdl');
            $return['data'] = $this->Tribe_topic_mdl->Load( $topic,true );
            if($return['data'])
            {
                
                
                $tribe_info = $this->tribe_mdl->get_tribe(   $return['data']['tribe_id']);
                if(empty($return['data']['brief_avatar'])){
                    $return['data']['logo_avatar'] = $return['data']['wechat_avatar'];
                }else{
                    $return['data']['logo_avatar'] = IMAGE_URL.$return['data']['brief_avatar'];
                }
                $return['data']['tribe_name'] = $tribe_info['name'];
                if(!$return['data']['images']){
                    $return['data']['images'] = array();
                }else{
                    $bg_img = explode(';',$return['data']['images']);
                    $bg_img = array_filter($bg_img);
                    $return['data']['images'] = $bg_img;
                }
                $return['data']['upvote_info']  =  $this->Tribe_topic_mdl->topic_upvote_member_name($return['data']['id']);
            }
        }
        print_r(json_encode($return));
    }
    
    /**
     * 商会话题列表
     */
    public  function  topic_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $app_tribe_ids = $this->get_app_tribe_ids();
        
        
        //筛选出商会加入的部落与用户加入到部落之间的交集部落
        $mytribe = $this->tribe_mdl->identical_tribe($app_tribe_ids);
        
        if($mytribe){
            $topic['where']['tribe_id'] = array_column($mytribe, 'id');
            $topic['where']['customer_id'] = $user_id;
            $this->load->model('Tribe_topic_mdl');
            
            $totalcount = count( $topic_list = $this->Tribe_topic_mdl->Load( $topic,true ));
            
            $perPage = $page['perPage']; // 每页记录数
            $currPage = $page['currPage']; // 当前页
            $offset = ($currPage - 1) * $perPage; // 偏移量
            
            $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
            
            $topic['page']['limit'] = $perPage;
            $topic['page']['offset'] = $offset;
            $topic_list = $this->Tribe_topic_mdl->Load( $topic,true );
            if($topic_list )
            {
                foreach ($topic_list as $k =>$v){
                    
                    $bg_img = explode(';',$v['images']);
                    $bg_img = array_filter($bg_img);
                    $topic_list[$k]['images'] = $bg_img;
                    
                    $tribe_info = $this->tribe_mdl->get_tribe($v['tribe_id']);
                    if(empty($v['brief_avatar'])){
                        $topic_list[$k]['logo_avatar'] = $v['wechat_avatar'];
                    }else{
                         $topic_list[$k]['logo_avatar'] = IMAGE_URL.$v['brief_avatar'];
                    }
                     $topic_list[$k]['tribe_name'] = $tribe_info['name'];
                    if(!$v['images']){
                         $topic_list[$k]['images'] = array();
                    }
                     $topic_list[$k]['upvote_info']  =  $this->Tribe_topic_mdl->topic_upvote_member_name($v['id']);
                }
            }
            
            $return['data']['listdate'] =$topic_list;
        }
        print_r(json_encode($return));
    }
    
    /**
     * 商会公告通知列表
     */
    public  function  announcement_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        $user_id = $this->session->userdata('user_id');
        
        $this->load->model('Tribe_content_mdl');
        
        $sift['where']['customer_id'] = $user_id;
        
        $label_id = $this->session->userdata("label_id");
        $app_tribe_ids = $this->get_app_tribe_ids();
        
        
        $this->load->model("tribe_mdl");
        $info = $this->tribe_mdl->identical_tribe($app_tribe_ids);
        $app_tribe_ids = array();
        foreach ($info as $k =>$v){
            $app_tribe_ids[] = $v['id'];
        }
        if(!$app_tribe_ids){
            $app_tribe_ids = array(0);
        }
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        $totalcount = count($this->Tribe_content_mdl->Load_Notice( $app_tribe_ids ));
        
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        $list = array();
        
        $tribe_id = isset($prams['tribe_id']) ? $prams['tribe_id']:0;
        if($tribe_id){
            $app_tribe_ids = $tribe_id;
        }
        
        //联合会公告
        $data = $this->Tribe_content_mdl->Load_Notice( $app_tribe_ids,$perPage,$offset);
 
        
        if(!empty($data)){
            foreach ($data as $key =>$val){
                $list[$key]['id'] = $val['id'];
                $list[$key]['title'] = $val['title'];
                $list[$key]['content'] = $val['content'];
                $list[$key]['title_img'] = $val['title_img'];
                $list[$key]['unreadnum'] =  $val['unreadnum'];
                $list[$key]['create_at'] =  $val['create_time'];
                $list[$key]['last_updated_time'] =  $val['last_updated_time'];
                $list[$key]['url'] =  site_url("Tribe/announcement_detaile/").'/'.$val['id'].'/'.$val['tribe_id'].'/?mac_type=APP';
            }
        }
            
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $list;
       
        print_r(json_encode($return));
    }
    
    /**
     * 获取单条公告未读人数
     */
    public  function getUnreadNum()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'id'
        ));
        $id = $prams['id'];
        $this->load->model('Tribe_content_mdl');
        $Notice = $this->Tribe_content_mdl->getNoticeUnreadCount($id);
        $return['data']['unreadnum'] = '0';
        if($Notice){
            $return['data']['unreadnum'] = $Notice['unreadnum'];
        }
        print_r(json_encode($return));
    }
    
    /**
     * 发布公告
     * @param int $tribe_id 部落ID
     * @param int $type  按全部 1   按组织 2
     */
    
    public function announcement_send_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'tribe_id',
            'type'
        ));
        $tribe_id = $prams['tribe_id'];
        $type = $prams['type'];
        $this->load->model("tribe_mdl");
        $user_id = $this->session->userdata('user_id');
        $tribe = $this->tribe_mdl->ManagementTribe($user_id,$tribe_id);
        if(!$tribe){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '13',
                'errorMessage' => '权限不足'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $staff_list = $this->tribe_mdl->load_members_list($tribe_id);//查询部落成员
     
        if($type == 1){//全部
          
            if ($staff_list) {
                $list = array();
                foreach ($staff_list as $key => $val){
                    $list[$key]['id'] = $val['id'] ;
                    $list[$key]['customer_id'] = $val['customer_id'] ;
                    $list[$key]['name'] = $val['real_name'] ? $val['real_name'] :$val['member_name'] ;
                    $list[$key]['role_name'] = $val['role_name'] ? $val['role_name'] :"部落成员";
                }
                $return['data'] =  $list;
            }else{
                $return['data'] =  $staff_list;
            }
            
        }else if($type == 2){
            $list = array();
            $tribe_duties_list = $this->tribe_mdl->load_members_duties( $tribe_id );
            if($staff_list){
                if($tribe_duties_list){
                    $duties_list = $tribe_duties_list;
                    $array_key = count($tribe_duties_list);
                   
                     foreach ($staff_list as $k => $v){
                         if($v['tribe_role_id']){
                             foreach ($tribe_duties_list as $key =>$val){
                                     unset($duties_list[$key]['id']); 
                                     unset($duties_list[$key]['total']);
                                     if($val['id'] == $v['tribe_role_id']){
                                         $list['id'] = $v['id'];
                                         $list['customer_id'] = $v['customer_id'] ;
                                         $list['name'] =  $v['real_name'] ? $v['real_name'] :$v['member_name'] ;
                                         $duties_list[$key]['member_list'][] = $list;
                                     }
                             }
                         }else{
                             $duties_list[$array_key]['role_name'] =  "部落成员";
                             $list['id'] = $v['id'] ;
                             $list['customer_id'] = $v['customer_id'] ;
                             $list['name'] =  $v['real_name'] ? $v['real_name'] :$v['member_name'] ;
                             $duties_list[$array_key]['member_list'][] = $list;
                         }
                         
                    }
                    $return['data'] =  $duties_list;
                   
                }else{
                    $list['role_name'] = "部落成员";
                    foreach ($staff_list as $key => $val){
                        $list['member_list'][$key]['id'] = $val['id'] ;
                        $list['member_list'][$key]['customer_id'] = $val['customer_id'] ;
                        $list['member_list'][$key]['name'] = $val['real_name'] ? $val['real_name'] :$val['member_name'] ;
                    }
                    $return['data'][] =  $list;
                }
            }else{
                $return['data'] =  $list;
            }
        }else{
            $return['data'] = array();
            print_r(json_encode($return));
            exit;
        }
        print_r(json_encode($return));
    }
    
    /**
     * 商会活列表
     */
    public  function  activity_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        
        $user_id = $this->session->userdata('user_id');
        $label_id = $this->session->userdata("label_id");
        $app_tribe_ids = $this->get_app_tribe_ids();
        
        $sift['where']['all_tribe_id'] = $app_tribe_ids;
        
        $this->load->model("tribe_mdl");
        $info = $this->tribe_mdl->identical_tribe($app_tribe_ids);
        
        
        $app_tribe_ids = array();
        foreach ($info as $k =>$v){
            $app_tribe_ids[] = $v['id'];
        }
        if(!$app_tribe_ids){
            $app_tribe_ids = array(0);
        }
        
        
        $type = isset($prams['type']) ? $prams['type']:'';
        if($type){
            //1 law    2  dynamic
            //1、政策法规 2、行业动态',
            if($type == 'law'){
                $sift['where']['type'] = 1;
            }
            if($type == 'dynamic'){
                $sift['where']['type'] = 2;
            }
        }
        
        $sift['where']['customer_id'] = $user_id;
        $sift['where']['tribe_id'] = $app_tribe_ids;
        
        $sift['sql_app'] = true;
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        $this->load->model('Tribe_activity_mdl');
        
        $totalcount = count($this->Tribe_activity_mdl->Load( $sift ));
        
        $sift['page']['limit']  = $perPage;
        $sift['page']['offset']  = $offset;
        
        $activities = $this->Tribe_activity_mdl->Load( $sift );
        
        if($type){
            foreach ($activities as $k => $v){
                $activities[$k]['url']= site_url("Tribe/activity_detaile")."/".$v['id'].'?mac_type=APP';
            }
        }
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $activities;
        print_r(json_encode($return));
    }
    
    
    /**
     * 搜索部落公告(当用户有加入过部落则进入搜索部落的公告，若用户没加入过部落 则搜索全平台的)
     */
    public function  search_announcement(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        // 检验参数
	    $this->_check_prams($prams, array(
	        'keyword'
	    ));
        
        $keyword = $prams['keyword'];
        $this->load->model('Tribe_content_mdl');
        $sift['where']['customer_id'] = $user_id;
        $sift['like']['keyword'] = $keyword;
        
        $label_id = $this->session->userdata("label_id");
        $app_tribe_ids = $this->get_app_tribe_ids();
        $sift['where']['tribe_id'] = $app_tribe_ids;
        
        $list = array();
        //部落公告
        $data = $this->Tribe_content_mdl->Load_List( $sift );
      
        if(!empty($data)){
            foreach ($data as $key =>$val){
                $list[$key]['id'] = $val['id'];
                $list[$key]['title'] = $val['title'];
                $list[$key]['content'] = $val['content'];
                $list[$key]['title_img'] = $val['title_img'];
                $list[$key]['url'] =  site_url("Tribe/announcement_detaile/").'/'.$val['id'];
            }
        }
        $return['data'] = $list;
        print_r(json_encode($return));
    }
    
    /**
     * 公告列表点击未读人数查看未读或已读人数列表
     * @param announcement_id  公告ID
     * 
     */
    public  function announcement_state(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        // 检验参数
        $this->_check_prams($prams, array(
            'announcement_id',
            'type'
        ));
        
        $announcement_id = $prams['announcement_id'];
        
        $this->load->model("tribe_content_mdl");
        $return['data']['unread_total'] = $this->tribe_content_mdl->unread($announcement_id);//未读
        $return['data']['read_total'] = $this->tribe_content_mdl->read($announcement_id);//已读
      
        $type = $prams['type'];
        
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        if($type != 'read'){
            $totalcount = count($this->tribe_content_mdl->unread($announcement_id));
            $list = $this->tribe_content_mdl->unread($announcement_id,$perPage,$offset);//未读
        }else{
            $totalcount = count($this->tribe_content_mdl->read($announcement_id));
            $list = $this->tribe_content_mdl->read($announcement_id,$perPage,$offset);//已读
        }
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $list;
        
        print_r(json_encode($return));
        
    } 
    
    
    /**
     * 商会名录
     */
    public function tribe_label(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $label_id = $this->session->userdata("label_id");
        
        $label = $this->App_label_mdl->Load($label_id);
        //一级标签绑定的商会(部落)
        $this->load->model("tribe_mdl");
        $tribe_info = $this->tribe_mdl->get_tribe($label['tribe_id']);
        
        $tribe =array();
        $tribe['id'] = $tribe_info['id'];
        $tribe['name'] = $tribe_info['name'];
        $tribe['logo'] = $tribe_info['logo'];
        $tribe['content'] = $tribe_info['content'];
        
        
        $tribe_label = $this->App_label_mdl->Load_tribe_app_label($label_id);
        foreach ($tribe_label as $k => $val){
            if(!$val['tribe_ids']){
                $tribe_label[$k]['tribe_ids'] = '0';
            }
            //秦商
            if($label_id == 2){
                if($val['id'] == 42 || $val['id'] == 18){
                    unset($tribe_label[$k]);
                }
            }
        }
        
        if($label_id == 2){
            $tribe_label = array_values($tribe_label);
        }
        
        $return['data']['tribe_info'] = $tribe;
        $return['data']['tribe_label']= $tribe_label;
        
        print_r(json_encode($return));
    }
    
    
    
    /**
     * 
     */
    public function  check_tribe_label(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
       
	    $this->_check_prams($prams, array(
	        'tribe_label_id'
	    ));
	    $tribe_label_id = $prams['tribe_label_id'];
	    $label_detail = $this->App_label_mdl->Load_tribe_app_label_detail($tribe_label_id);
	    $tribe_ids = $label_detail['tribe_ids'];
	    $ids =  trim($tribe_ids,',');
	    $ids =  explode(',', $ids);
	    
	    if(!$ids[0]){
	       $num  = 0;
	    }else {
	        $num = count($ids);
	        if($num == 1){
	            $return['data']['tribe_id']= $ids[0];
	        }
	    }
	    $return['data']['num']= $num;
	    print_r(json_encode($return));
	    
    }
    
    
    /**
     * 会员名录(部落列表)
     * str $tribe_ids
     */
    public function  label_members(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
// 	    $this->_check_prams($prams, array(
// 	        'tribe_ids'
// 	    ));
        $tribe_ids =  isset($prams['tribe_ids']) ? $prams['tribe_ids'] :0;
	    $tribe_label_id = isset($prams['tribe_label_id']) ? $prams['tribe_label_id'] :0;
	    if($tribe_label_id && $tribe_ids){
	        $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '参数错误'
            );
            print_r(json_encode($return));
            exit();
	    }
	    
	    if($tribe_label_id){
	        $label_detail = $this->App_label_mdl->Load_tribe_app_label_detail($tribe_label_id);
	        if(!$label_detail['tribe_ids']){
	            $tribe_ids = '0';
	        }else{
	            $tribe_ids = $label_detail['tribe_ids'];
	        }
	    }
	    
	    $this->load->model("tribe_mdl");
	    $ids =  trim($tribe_ids,',');
	    $ids =  explode(',', $ids);
	    $tribe_info = $this->tribe_mdl->get_tribe_list($ids);
	    if(!$tribe_info){
	        $tribe_info = NULL;
	    }
	    $return['data']= $tribe_info;
	    print_r(json_encode($return));
    }
    
    
    /**
     * 杰出商会
     */
    
    public function outstanding(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        $perPage = $page['perPage']; // 每页记录数
	    $currPage = $page['currPage']; // 当前页
	    $offset = ($currPage - 1) * $perPage; // 偏移量
        
	    $totalcount = count($this->App_label_mdl->outstanding());
	    
        $outstanding = $this->App_label_mdl->outstanding($perPage,$offset);
        
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $outstanding;
        
        print_r(json_encode($return));
        
    }
    
    /**
     * 搜索商会下的部落
     */
    public function search_tribe(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        // 检验参数
        $this->_check_prams($prams, array(
            'keyword'
        ));
        
        $keyword = $prams['keyword'];
        $label_id = $this->session->userdata("label_id");
        
        $app_tribe_ids = $this->get_app_tribe_ids();
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        $totalcount = count($this->tribe_mdl->get_tribe_list($app_tribe_ids,$keyword));
        
        $list = $this->tribe_mdl->get_tribe_list($app_tribe_ids,$keyword,$perPage,$offset);
        
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $list;
        
        print_r(json_encode($return));
        
    }
    
    
    
    /**
     * 检查是否加入某个部落
     */
    public function check_join_tribe(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'tribe_id'
        ));
        
        $tribe_id = $prams['tribe_id'];
        
        $user_id = $this->session->userdata("user_id");
        
        $ts_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$user_id,0);//检查我是否存在部落
        $return['data']['status']= 0;
        if($ts_info){
            $return['data']['status']= $ts_info['status'];
        }
        print_r(json_encode($return));
        
    }
    
    /**
     * 检查在加入商会的部落中是否存在管理的部落权限
     */
    public  function  check_is_host(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $app_tribe_ids = $this->get_app_tribe_ids();
        $user_id = $this->session->userdata("user_id");
        
        $data = $this->tribe_mdl->ManagementTribe($user_id,$app_tribe_ids);
        $return['data']['status']= 0;
        
        if(count($data) > 0){
            $return['data']['status']= 1;
        }
        print_r(json_encode($return));
    }
    
    
    
    /**
     * 人脉部落导航
     */
    public function select_tribe(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $label_id = $this->session->userdata("label_id");
        
        $app_tribe_ids = $this->get_app_tribe_ids();
        
        //筛选出商会加入的部落与用户加入到部落之间的交集部落
        $tribe_info = $this->tribe_mdl->identical_tribe($app_tribe_ids);
      
        $return['data']= $tribe_info;
        print_r(json_encode($return));
       
    }
      
    
    //获取商会下所有的部落ID
    private  function get_app_tribe_ids(){
        $label_id = $this->session->userdata("label_id");
        
        $this->load->model('App_label_mdl');
        $status = 'show_app_tribe_ids';
        $app_labe_info = $this->App_label_mdl->Load( $label_id, $status );
        
        //将二级标签下部落全部拿出来堆放在一起方便进行处理
        $label_infos = $this->App_label_mdl->Load_tribe_app_label($label_id);//获取标签信息
       
        $app_tribe_id = '';
        foreach ($label_infos as $key =>$val ){
            $app_tribe_id = trim($app_tribe_id,",");
            if($val['tribe_ids']){
                $app_tribe_id .= ','.$val['tribe_ids'];
            }
          
        }
        
        if( $app_labe_info['tribe_id'] )
        {
            $app_tribe_id .= ','.$app_labe_info['tribe_id'];
        }
        
        $ids = explode(',',$app_tribe_id);//字符串转数组
        $app_tribe_ids = array_unique($ids);
        
        return $app_tribe_ids;
    }
    
    
    /**
     * 获取特产商品
     */
    public  function getSpecialtyProduct(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
       
        $type = isset($prams['type']) ? $prams['type']:0;
        $search = isset($prams['search']) ? $prams['search']:'';
        $parent_id = isset($prams['parent_id']) ? $prams['parent_id']:0;
       
        $this->load->model('App_label_mdl');
        $label_id = $this->session->userdata("label_id");
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        $sift['where']['type'] = $type;
        $sift['where']['label_id'] = $label_id;
        $sift['where']['parent_id'] = $parent_id;
        $sift['search']['product'] = $search;
        
        $totalcount = count($this->App_label_mdl->get_SpecialtyProduct($sift));
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
         
        $sift['page']['limit'] = $perPage;
        $sift['page']['offset'] = $offset;
        
        $Product = $this->App_label_mdl->get_SpecialtyProduct($sift);
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $Product;
        print_r(json_encode($return));
       
    }
    
    public  function getSpecialtyNav(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $label_id = $this->session->userdata("label_id");
        
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
        if(!$Nav_info){
            $Nav_info = NULL;
        }
        $return['data'] = $Nav_info;
        print_r(json_encode($return));
    }
    
    public  function  topTen(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $label_id = $this->session->userdata("label_id");
        
        $topTenComm = 
        $return['data']  = array(
             array(
                'type'=>'topTenComm',
                'logo'=> 'images/commerce/commerce_icon_01.png'
            ),
            array(
                'type'=>'topTenCorp',
                'url' => site_url("Notice/shijia/2").'?mac_type=APP',
                'logo'=> 'images/commerce/commerce_icon_02.png'
            ),
           array(
                'type'=>'topTenPeople',
                'url' => site_url("Commerce/Outstanding/renwu/2").'?mac_type=APP',
                'logo'=> 'images/commerce/commerce_icon_03.png'
            ),
           array(
                'type'=>'topTenCharityCorp',
                'url' => site_url("Commerce/Outstanding/cishan/2").'?mac_type=APP',
                'logo'=> 'images/commerce/commerce_icon_04.png'
            )
        );
        print_r(json_encode($return));
    }
    
    
}