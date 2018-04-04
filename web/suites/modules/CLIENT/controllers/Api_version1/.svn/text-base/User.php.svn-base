<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Api_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_mdl');
    }

    public function index()
    {
        echo 'user API';
    }
    
    private function curl_do_result($url,$data){
        $data['key'] = 'jiami';
        $data['port_source'] = strtoupper(SUITE);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return  $result;
    }
    
    // 登录
    public function login()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'username',
            'password'
        ));
        
        $url = $this->url_prefix.'Customer/check_customer?';
        $data =array();
        //配置传参
        $data['tbxLoginNickname'] =  $prams['username'];
        $data['tbxLoginPassword'] =  $prams['password'];
       
       
        $_customer = json_decode($this->curl_do_result($url,$data),true);
      
        //加载用户支付账户信息写入session
        $data =array();
        $data['customer_id'] = $_customer['id'];
        $url = $this->url_prefix.'Customer/get_pay_relation_id?';
        $pay_data = json_decode($this->curl_do_result($url,$data),true);
      
        if ($_customer) {
            $__customer = array(
                'nick_name' => $_customer['nick_name'],
                'user_name' => $_customer['name'],
                'user_id' => $_customer['id'],
                'user_in' => TRUE,
                'is_vip' => $_customer['is_vip'],
                'user_last_login' => $_customer['last_login_at'],
                'pay_relation' => $pay_data,
                'openid' => $_customer['openid'],
                'mobile' => isset($_customer['mobile']) ? $_customer['mobile'] : "",
                'wechat_avatar' => isset($_customer['wechat_avatar']) ? $_customer['wechat_avatar'] : "",
                'wechat_nickname' => isset($_customer['wechat_nickname']) ? $_customer['wechat_nickname'] : "",
                'verify_status' => false
            );
            
            $this->load->model('Customer_corporation_mdl');
            $corp_detail= $this->Customer_corporation_mdl->load( $_customer['id']);
         
            if($corp_detail){
                $__customer['verify_status'] = true;
                //检验是否有生成默认的分店总店
                $this->load->model('corporation_branch_mdl','branch');
                $host_branch = $this->branch->get_branch_detail(0, $corp_detail['id'],true);
                if(!$host_branch){//若没有，则帮用户生成默认分店总店(不需要判断企业状态)
                    $this->branch->corporation_id = $corp_detail['id'];
                    $this->branch->owner_id = $corp_detail['customer_id'];
                    $this->branch->address = $corp_detail['address'];
                    $this->branch->owner_name = $corp_detail['contact_name'];
                    $this->branch->branch_name = $corp_detail['corporation_name'];
                    $this->branch->is_host = 1;
                    $this->branch->edit_branch();
                }
                
            }else{
                $this->load->model('Corporation_staff_mdl');
                //获取该用户在平台的所有在职的企业下的角色信息
                $staff = $this->Corporation_staff_mdl->get_staff($_customer['id'],2);
                //或者是判断用户是否拥有处理订单的权限  根据9thleaf_corporation_module表确定权限url
                $authority_str = '/Corporate/order/get_list';
                if(!empty($staff)){
                    foreach ($staff as $key =>$val){
                        $authority = $this->Corporation_staff_mdl->get_staff_authority($val['corporation_id'],$_customer['id']);
                     
                        if($authority){
                            //将获取出来的权限字符串进行处理成数组
                            foreach ($authority as $key => $val){
                                $authority_arr[$key] = $val['url'];
                            }
                            if(in_array($authority_str, $authority_arr)){
                                $__customer['verify_status'] = true;
                            }
                        }
                         
                    }
                }
            }
           
            $this->load->model('customer_shop_mdl','shop');
            $shop = $this->shop->load($_customer['id']);
            if(!$shop){
                $__customer['shop'] = '未开通';
            }else{
                if(!$shop['status']){
                    $__customer['shop'] = '审核中';
                }else{
                    $__customer['shop'] = '';
                }
            }
            
            $this->load->model('corporation_branch_mdl','branch');
            $branch = $this->branch->get_user_branch($_customer['id']);
            $__customer['branch'] = "0";
            if($branch){
                $__customer['branch'] = count($branch)."";
                if(count($branch) == 1){
                    $__customer['branch_id'] =  $branch[0]['id']."";
                }
            }
          
            $this->session->set_userdata($__customer);
            
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
            $return['data'] = array(
                'sessionid' => $this->session->userdata('session_id'),
                'sessions' => $__customer
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '用户或密码错误'
            );
        }
        
        print_r(json_encode($return));
    }
    
    
    
    /**
     * Memcache写入用户信息
     */
    public function get_UserAdvUrl(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $user_id =  $this->session->userdata('user_id');
        
       
        if($user_id){
            //连接Memcached
            $mem = $this->tel_memcached();
            $key = md5(time().rand(0,999999));
            //用户信息
            $url = $this->url_prefix.'Customer/load?';
            $data['customer_id'] = $user_id;
            $info = json_decode($this->curl_do_result($url,$data),true);
            
            //支付账户关联
            $data['customer_id'] = $user_id;
            $url = $this->url_prefix.'Customer/get_pay_relation_id?';
            $pay_data = json_decode($this->curl_do_result($url,$data),true);
          
            $_info = array(
                'user_name' => !empty($info['nick_name'])?$info['nick_name']:(!empty($info['wechat_nickname'])?$info['wechat_nickname']:$info['name']),
                'user_id' => $info['id'],
                'user_in' => TRUE,
                'is_vip' => $info['is_vip'],
                'is_active' => $info['is_active'],
                'user_last_login' => $info['last_login_at'],
                'corporation_id' => 0,
                //                     'privilege_id' => 0,
                'openid' => $info['openid'],
                'pay_relation' => $pay_data['id'],
                'is_active' => $info['is_active'],
                'email' => $info['email'],
                'mobile' => $info['mobile'],
                'name' => $info['name'],
                'user_key' => $key,
                'password' => $info['password']
                
            );
            
            //查询企业信息
            $this->load->model("corporation_mdl");
            $corpinfo = $this->corporation_mdl->load($info['id']);
             
            if ($corpinfo != null) {
                $_info["corporation_status"] = $corpinfo["status"];
                $_info["approval_status"] = $corpinfo["approval_status"];
                $_info['corporation_id'] = $corpinfo['id'];
                //                      $customer['privilege_id'] = $corpinfo['privilege_id'];
            }
            
             
            
            //写入Memcahce
            if( $mem->set($key,$_info,MEMCACHE_COMPRESSED,1800) )
            {
                if(base_url() == 'http://www.test51ehw.com/'){
                    $url = 'http://ad.api.diabin.cn/api/v1/useraccount/token'; //测试
                }else{
                    $url = 'http://gameapi.51ehw.com/api/v1/useraccount/token';//正式
                }
              
                $data['key'] = $key;
                $token  =  $this->curl_advertisement($url,$data);
 
                if(base_url() == 'http://www.test51ehw.com/'){
                    $return['data']['url'] = 'http://ad.m.diabin.cn/?token='.$token['result'];//测试
                }else{
                    $return['data']['url'] = 'http://game.51ehw.com/?token='.$token['result'];//正式
                    //                 $return['data']['url'] = 'http://adtask.m.diabin.cn/?token='.$token['result'];
                }
            }
          
        }else{
            $return['data']['url'] = '';
        }
        
        print_r(json_encode($return));
    }
    
   
    
    
    //广告接口POST获取所需参数
    private function curl_advertisement($url,$data){
        $ch = curl_init();
        $res= curl_setopt ($ch, CURLOPT_URL,$url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        // 	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        // 	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        // 	    curl_setopt ($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );
    
        $result = curl_exec ($ch);
        // 	    echo $result;exit;
        curl_close($ch);
        if(preg_match('/^\xEF\xBB\xBF/',$result))
        {
            $result = substr($result,3);
             
        }
        return json_decode($result,true);
    }
    
    
    
    /**
     * 第三方登录
     */
    public function other_login()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'unionid',
            'type'
        ));
        $where = array();
        $where['type']= $prams['type'];
        $where['unionid']= $prams['unionid'];
        
        $url = $this->url_prefix.'Customer/other_login?';
        
        $_customer = json_decode($this->curl_do_result($url,$where),true);
        
        if ($_customer) {
            
            //A端数据
            $userlist = array();
            // 更新第三方账户头像及昵称
            if ($prams['type'] == 'wechat') {
                $wechat_avatar = isset($prams['wechat_avatar']) ? $prams['wechat_avatar'] : "";
                $_wechat_nickname = isset($prams['wechat_nickname']) ? $prams['wechat_nickname'] : "";
                if ($wechat_avatar) {
                    $this->customer_mdl->wechat_avatar = $wechat_avatar;
                    $userlist['wechat_avatar'] =$wechat_avatar;
                }
                // emoji表情截断
                $wechat_nickname = preg_replace_callback('/./u', function (array $match) {
                    return strlen($match[0]) >= 4 ? '^' : $match[0];
                }, $_wechat_nickname);
                $this->customer_mdl->wechat_nickname = $wechat_nickname;
                $userlist['wechat_nickname'] =$wechat_nickname;
            }
            
            //更新调用接口
            $url = $this->url_prefix.'Customer/update?';
            $userlist['customer_id'] = $_customer['id'];
            $customer_aff = json_decode($this->curl_do_result($url,$userlist),true);
            
            //加载用户支付账户信息写入session
            $data =array();
            $data['customer_id'] = $_customer['id'];
            $url = $this->url_prefix.'Customer/get_pay_relation_id?';
            $pay_data = json_decode($this->curl_do_result($url,$data),true);
            
            $__customer = array(
                'user_name' => !empty($wechat_nickname)?$wechat_nickname:$_customer['name'],
                'user_id' => $_customer['id'],
                'user_in' => TRUE,
                'is_vip' => $_customer['is_vip'],
                'user_last_login' => $_customer['last_login_at'],
                'pay_relation' => $pay_data,
                'mobile' => isset($_customer['mobile']) ? $_customer['mobile'] : "",
                'openid' => $_customer['openid'],
                'wechat_avatar' => $wechat_avatar,
                'wechat_nickname' => !empty($wechat_nickname)?$wechat_nickname:$_customer['name'],
                'verify_status' => false
            );
            
            $url = $this->url_prefix.'Customer/update_last_login';
            $_data =array();
            $_data['customer_id'] = $_customer['id'];
            $this->curl_do_result($url,$_data);
            
            $this->load->model('Customer_corporation_mdl');
            $corp_detail= $this->Customer_corporation_mdl->load( $_customer['id']);
           
            if($corp_detail){
                $__customer['verify_status'] = true;
                //检验是否有生成默认的分店总店
                $this->load->model('corporation_branch_mdl','branch');
                $host_branch = $this->branch->get_branch_detail(0, $corp_detail['id'],true);
                if(!$host_branch){ //若没有，则帮用户生成默认分店总店(不需要判断企业状态)
                    $this->branch->corporation_id = $corp_detail['id'];
                    $this->branch->owner_id = $corp_detail['customer_id'];
                    $this->branch->address = $corp_detail['address'];
                    $this->branch->owner_name = $corp_detail['contact_name'];
                    $this->branch->branch_name = $corp_detail['corporation_name'];
                    $this->branch->is_host = 1;
                    $this->branch->edit_branch();
                }
                
            }else{
                $this->load->model('Corporation_staff_mdl');
                //获取该用户在平台的所有在职的企业下的角色信息
                $staff = $this->Corporation_staff_mdl->get_staff($_customer['id'],2);
                 
                //或者是判断用户是否拥有处理订单的权限  根据9thleaf_corporation_module表确定权限url
                $authority_str = '/Corporate/order/get_list';
                if(!empty($staff)){
                    foreach ($staff as $key =>$val){
                        $authority = $this->Corporation_staff_mdl->get_staff_authority($val['corporation_id'],$_customer['id']);
            
                        if($authority){
                            //将获取出来的权限字符串进行处理成数组
                            foreach ($authority as $key => $val){
                                $authority_arr[$key] = $val['url'];
                            }
                            if(in_array($authority_str, $authority_arr)){
                                $__customer['verify_status'] = true;
                            }
                        }
                         
                    }
                }
            }
            
            $this->load->model('customer_shop_mdl','shop');
            $shop = $this->shop->load($_customer['id']);
            if(!$shop){
                $__customer['shop'] = '未开通';
            }else{
                if(!$shop['status']){
                    $__customer['shop'] = '审核中';
                }else{
                    $__customer['shop'] = '';
                }
            }
            
            $this->load->model('corporation_branch_mdl','branch');
            $branch = $this->branch->get_user_branch($_customer['id']);
            $__customer['branch'] = "0";
            if($branch){
                $__customer['branch'] = "".count($branch);
                if(count($branch) == 1){
                    $__customer['branch_id'] = "". $branch[0]['id'];
                }
            }
            
            $this->session->set_userdata($__customer);
            
            $return['responseMessage']['messageType'] = 'success';
            $return['data'] = array(
                'sessionid' => $this->session->userdata('session_id'),
                'sessions' => $__customer
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '绑定失败，请重新绑定'
            );
        }
        print_r(json_encode($return));
    }
    
    /**
     * 根据类型检查绑定关系是否存在
     * 类型检查
     */
    public function check_binding_by_type()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'type',
            'check_type',
            'object'
        ));
        
        $type = $prams['type']; // wechat_account、weibo_account、alipay_account、qq_account
        $check_type = $prams['check_type']; // wechat_account、weibo_account、alipay_account、qq_account
        $object = $prams['object'];
        
        $where['type'] = $type;
        $where[$type] = $object;
        //调用接口
        $url = $this->url_prefix.'Customer/load_by_where?';
        $_customer = json_decode($this->curl_do_result($url,$where),true);
     
        $mobile = isset($_customer['mobile']) ? $_customer['mobile'] : "";
        $wechat_nickname = isset($_customer['wechat_nickname']) ? $_customer['wechat_nickname'] : "";
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ""
        );
        
        if (count($_customer) > 0) {
            if ($_customer[$check_type]) {
                $return['data'] = array(
                    'is_exist' => '已绑定',
                    'is_registered' => '已注册',
                    'mobile' => $mobile,
                    'wechat_nickname' => $wechat_nickname
                );
            } else {
                $return['data'] = array(
                    'is_exist' => '未绑定',
                    'is_registered' => '已注册',
                    'mobile' => $mobile,
                    'wechat_nickname' => $wechat_nickname
                );
            }
        } else {
            $return['data'] = array(
                'is_exist' => '未绑定',
                'is_registered' => '未注册',
                'mobile' => $mobile,
                'wechat_nickname' => $wechat_nickname
            );
        }
        print_r(json_encode($return));
    }

    /**
     * 检查帐号绑定情况
     * 列表检查
     */
    public function check_binding()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata("user_id");
        
        
        
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $url = $this->url_prefix.'Customer/load?';
        $data['customer_id'] = $user_id;
        $_customer = json_decode($this->curl_do_result($url,$data),true);
        
        if (count($_customer) > 0) {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ""
            );
            $return['data'] = array(
                'user_id' => $user_id,
                'username' => $_customer['name'],
                'mobile' => isset($_customer['mobile']) && $_customer['mobile'] != '' ? $_customer['mobile'] : "未绑定",
                'wechat_account' => isset($_customer['wechat_account']) && $_customer['wechat_account'] != '' ? "已绑定" : "未绑定",
                'qq_account' => isset($_customer['qq_account']) && $_customer['qq_account'] != '' ? "已绑定" : "未绑定",
                'weibo_account' => isset($_customer['weibo_account']) && $_customer['weibo_account'] != '' ? "已绑定" : "未绑定",
                'alipay_account' => isset($_customer['alipay_account']) && $_customer['alipay_account'] != '' ? "已绑定" : "未绑定",
                'wechat_nickname' => isset($_customer['wechat_nickname']) ? $_customer['wechat_nickname'] : ""
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '9',
                'errorMessage' => '用户未注册'
            );
        }
        print_r(json_encode($return));
    }

    /**
     * 解绑
     */
    public function unbundling()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'type',
            'verfity'
        ));
        
        $type = $prams['type'];
        $verfity = $prams['verfity'];
        $mobile = isset($prams["mobile"]) ? $prams["mobile"] : "";
        
        $user_id = $this->session->userdata("user_id");
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }

        $verfity_mobile = "app_unbundling" . $type . "_verfity_mobile";
        $verfity_type = "app_unbundling" . $type . "_mobile_verfity";
        $settime_type = "app_unbundling" . $type . "_verfity_settime";
        $mobile_verfity = $this->session->userdata($verfity_type);
        $set_time = $this->session->userdata($settime_type);
        $ver_mobile = $this->session->userdata($verfity_mobile);
        $this->load->model('customer_mdl');
        $data = array();
        $data['mobile'] = $mobile;
        $data['type'] = $type;
        $data['customer_id'] = $user_id;
        
        // 验证验证码
        if ($verfity != $mobile_verfity) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '手机验证码不正确'
            );
            print_r(json_encode($return));
            exit();
        }
        if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '验证码已失效，请重新获取'
            );
            print_r(json_encode($return));
            exit();
        }
        if ($mobile == '') {
            $link = $this->url_prefix.'Customer/load?';
            $customer = json_decode($this->curl_do_result($link,$data),true);
            $mobile = $customer['mobile'];
        }
        if ($mobile != $ver_mobile) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '手机号码异常'
            );
            print_r(json_encode($return));
            exit();
        }
        $url =$this->url_prefix.'Customer/unbundling?';
        $result = json_decode($this->curl_do_result($url,$data),true);
        if ($result['status']) {
            $this->session->set_userdata("user_name",$mobile);
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '解绑成功'
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '网络出错'
            );
        }
        switch ($type){
            case 'wechat':
                $content_type = '微信';
                break;
            case 'qq':
                $content_type = 'QQ';
                break;
            case 'weibo':
                $content_type = '微博';
                break;
            case 'alipay':
                $content_type = '支付宝';
                break;
        }
        $this->session->unset_userdata("{$verfity_mobile}");
        $this->session->unset_userdata("{$verfity_type}");
        $this->session->unset_userdata("{$settime_type}");
        $content = "您的51易货网账号刚刚解绑了" . $content_type . "，如非本人操作请致电400-0029-777";
        $this->sendmobileWithoutverfity($mobile, $content);
        
        print_r(json_encode($return));
    }

    /**
     * 绑定
     */
    public function other_binding()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'verfity',
            'type1',
            'type2',
            'object1',
            'object2'
        ));
        
        $type1 = $prams['type1'];
        $type2 = $prams['type2'];
        $object1 = $prams['object1'];
        $object2 = $prams['object2'];
        $verfity = $prams['verfity'];
        $password = ! empty($prams['password']) ? $prams['password'] : '';
        
        // 检验注册状态,获取对应账户id
        //type1 mobile type2 wechat 系手机绑微信
        if ($type1 == 'mobile') {
            $mobile = $object1;
            $other_account = $type2 . "_account";
            $open_id = $object2;
            $verfity_mobile = "app_binding" . $type2 . "_verfity_mobile";
            $verfity_type = "app_binding" . $type2 . "_mobile_verfity";
            $settime_type = "app_binding" . $type2 . "_verfity_settime";
        } else {
            //type1 wechat type2 mobile 系微信绑手机
            $mobile = $object2;
            $other_account = $type1 . "_account";
            $open_id = $object1;
            $verfity_mobile = "app_binding" . $type2 . "_verfity_mobile";
            $verfity_type = "app_binding" . $type2 . "_mobile_verfity";
            $settime_type = "app_binding" . $type2 . "_verfity_settime";
        }
        
        // 检验验证码
        $binding_verfity = $this->session->userdata($verfity_type);
        $set_time = $this->session->userdata($settime_type);
        $verf_mobile = $this->session->userdata($verfity_mobile);
        if ($verfity != $binding_verfity) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机验证码不正确'
            );
            print_r(json_encode($return));
            exit();
        }
        if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '验证码已失效，请重新获取'
            );
            print_r(json_encode($return));
            exit();
        }
        
       
        //校验接受验证码手机号码
        if ($mobile != $verf_mobile) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机号码异常'
            );
            print_r(json_encode($return));
            exit();
        }
        //type1 mobile type2 wechat 系手机绑微信
        //type1 wechat type2 mobile 系微信绑手机
        if ($type1 == 'mobile') {
            //微信用户
            $other_customer_id = $this->check_register($type2, $object2, $password);
            //手机用户
            $mobile_customer_id = $this->check_register($type1, $object1, $password);
        } else {
            //微信用户
            $other_customer_id = $this->check_register($type1, $object1, $password);
            //手机用户
            $mobile_customer_id = $this->check_register($type2, $object2, $password);
        }
       
        if ($other_customer_id == false || $mobile_customer_id == false) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '9',
                'errorMessage' => '生成账户失败',
               
            );
            print_r(json_encode($return));
            exit();
        }
       
        //调用接口
        // 检验微信账户是否有log记录
        $info =array();
        $info['customer_id']= $other_customer_id;
        $url = $this->url_prefix.'Customer/get_pay_relation_id?';
        $other_log = json_decode($this->curl_do_result($url,$info),true);
       
        if (count($other_log) != 0) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '账号异常，请联系客服'
            ); // 有log
            print_r(json_encode($return));
            exit();
        }
        
        // 检验对应绑定信息
        $url = $this->url_prefix.'Customer/load?';
        $idinfo =array();
        $idinfo['customer_id'] =$other_customer_id;
        $other_customer = json_decode($this->curl_do_result($url,$idinfo),true);
        
        $idinfo['customer_id'] =$mobile_customer_id;
        $mobile_customer = json_decode($this->curl_do_result($url,$idinfo),true);
       
        if ($type1 == 'mobile' && $other_customer['mobile'] != $mobile && $other_customer['mobile'] != '' && $other_customer['mobile'] != null) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '此手机号已被绑定，请输入新手机号或解绑旧'.$type2.'号再重试'
            );
            print_r(json_encode($return));
            exit();
        } elseif ($type1 != 'mobile' && $mobile_customer[$other_account] != $open_id && $mobile_customer[$other_account] != '' || $type1 != 'mobile' && $mobile_customer[$other_account] != null) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => "该账户已绑定" . $type1 . "账户，请先解绑旧账号"
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 判断结束，开始合并
        $updateinfo = array();
        if (! empty($other_customer['wechat_account']) && empty($mobile_customer['wechat_account'])) {
            $updateinfo['wechat_account'] = $other_customer['wechat_account'];
        }
        if (! empty($other_customer['openid']) && empty($mobile_customer['openid'])) {
            $updateinfo['openid'] = $other_customer['openid'];
        }
        if (! empty($other_customer['qq_account']) && empty($mobile_customer['qq_account'])) {
            $updateinfo['qq_account']= $other_customer['qq_account'];
        }
        if (! empty($other_customer['weibo_account']) && empty($mobile_customer['weibo_account'])) {
            $updateinfo['weibo_account']= $other_customer['weibo_account'];
        }
        if (! empty($other_customer['alipay_account']) && empty($mobile_customer['alipay_account'])) {
            $updateinfo['alipay_account']= $other_customer['alipay_account'];
        }
       
        
        $updateinfo['name'] = $mobile ;
        $updateinfo['customer_id'] = $mobile_customer_id ;
        //将绑定信息更新到手机用户上
        $url = $this->url_prefix.'Customer/update?';
        $_update = json_decode($this->curl_do_result($url,$updateinfo),true);
       
        //同步数据
        $this->load->model('customer_shop_mdl','shop');
        if($other_customer['parent_id']){
            $this->shop->update_share_log($other_customer_id,$mobile_customer_id,$other_customer['parent_id']);//同步分享数据
            $this->shop->update_read_log($other_customer_id,$mobile_customer_id,$other_customer['parent_id']);//同步阅读数据
        }
        //清除上线ID
        $this->load->model('customer_mdl');
        $this->customer_mdl->parent_id = NULL;
        $this->customer_mdl->update($other_customer_id);
        if($_update['status']){
            //不删除微信用户，但清除微信用户信息，使微信账户失效
            $url = $this->url_prefix.'Customer/unbundling?';
            $updateinfo=array();
            $updateinfo['customer_id'] = $other_customer_id ;
            $updateinfo['type'] = 'wechat';
            $_del = json_decode($this->curl_do_result($url,$updateinfo),true);
        }
        //判断更新成功，三库同步清除微信用户信息成功使微信账户失效 =>绑定成功！
        if ($_del['status']) {
            $mobile = isset($mobile_customer['mobile']) ? $mobile_customer['mobile'] : $mobile_customer['name'];
            
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '绑定成功！'
            );
            $content = "您的51易货网账号刚刚绑定了" . $type2 . "，如非本人操作请致电400-0029-777";
            $this->sendmobileWithoutverfity($mobile, $content);
            print_r(json_encode($return));
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '8',
                'errorMessage' => '网络出错8'
            );
            print_r(json_encode($return));
            exit();
        }
    }

    /**
     * 检验是否已经注册
     * 是，返回user_id
     * 否注册，返回user_id
     * 
     * @param unknown $type            
     * @param unknown $object            
     */
    private function check_register($type, $object, $password = '123456')
    {
        $username = $type . ":" . $object;
      
        if ($type == 'mobile') {
            $where['type'] = 'mobile';
            $where['mobile'] =$object;
        } else {
            $name = $type."_account";
            $where['type'] =$name;
            $where[$name] = $object;
        }
        
        //调用接口
        $url = $this->url_prefix.'Customer/load_by_where?';
        $_customer = json_decode($this->curl_do_result($url,$where),true);
       
        if (empty($_customer)) {
            
            if ($type == 'mobile') {
                $this->customer_mdl->mobile = $object;
                $username = $object;
            }
            if ($type == 'wechat') {
                $this->customer_mdl->wechat_account = $object;
            }
            if ($type == 'weibo') {
                $this->customer_mdl->weibo_account = $object;
            }
            if ($type == 'qq') {
                $this->customer_mdl->qq_account = $object;
            }
            if ($type == 'alipay') {
                $this->customer_mdl->alipay_account = $object;
            }
            
            $this->customer_mdl->name = $username;
            $this->customer_mdl->app_id = $this->session->userdata("app_info")["id"];
            $this->customer_mdl->registry_by = 'app';
            $this->customer_mdl->password = $password;
            
            $data = array();
            if ($type == 'mobile') {
                $data['mobile'] = $object;
                $this->customer_mdl->mobile =$object;
                $this->customer_mdl->name =$object;
            }
            if ($type == 'wechat') {
                $data['unionid'] = $object;
                $data['name'] ='wechat:'. $object;
                $this->customer_mdl->wechat_account = $object;
            }
            if ($type == 'weibo') {
                $data['weibo_account'] = $object;
                $data['name'] ='weibo:'. $object;
                $this->customer_mdl->weibo_account = $object;
            }
            if ($type == 'qq') {
                $data['qq_account'] = $object;
                $data['name'] ='qq:'. $object;
                $this->customer_mdl->qq_account = $object;
            }
            if ($type == 'alipay') {
                $data['alipay_account'] = $object;
                $data['name'] ='alipay:'. $object;
                $this->customer_mdl->alipay_account = $object;
            }
            $data['app_id'] = $this->session->userdata("app_info")["id"];
            $data['registry_by'] = 'APP';
            $data['time'] = date('Y-m-d H:i:s');
            $data['password'] = $password;
            //调用接口
            $url = $this->url_prefix.'Customer/save?';
           
            $result = json_decode($this->curl_do_result($url,$data),true);
         
            $this->customer_mdl->name = '';
            $this->customer_mdl->mobile = '';
            $this->customer_mdl->wechat_account = '';
            $this->customer_mdl->weibo_account = '';
            $this->customer_mdl->qq_account = '';
            $this->customer_mdl->alipay_account = '';
            
            $this->load->model("pay_account_mdl");
            $this->load->model("pay_relation_mdl");
            if (isset($result['customer_id'])) {
                if ($type == 'mobile' && isset($customer_id)) {
                    $this->pay_account_mdl->name = $username;
                    $this->pay_account_mdl->passwd = $password;
                    $pay_account_id = $this->pay_account_mdl->createpay_account();
                    if ($pay_account_id) {
                        $this->pay_relation_mdl->id_pay = $pay_account_id;
                        $this->pay_relation_mdl->customer_id = $result['customer_id'];
                        $this->pay_relation_mdl->createpay_relation();
                        $pay_relation_id = $this->db->insert_id();
                        if ($pay_relation_id) {
                            return $result['customer_id'];
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return $result['customer_id'];
                }
            } else {
                return false;
            }
        } else {            
            if(!empty($customer['mobile']) && $_customer['mobile'] != $_customer['name']){
                $this->customer_mdl->name = $_customer['name'];
                // 修改并清空残留数据
                $this->customer_mdl->update($_customer['customer_id']);
                $this->customer_mdl->name = '';
            }
            
            return $_customer['id'];
        }
    }

    /**
     * 注册
     */
    public function register()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'username',
            'email',
            'password',
            'mobile_vertify'
        ));
        
        // 检查用户名是否存在
        if ($this->customer_mdl->check_name($prams['username'])) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '该用户名已经存在'
            );
            print_r(json_encode($return));
            exit();
        }

        $mobile = $this->session->userdata("mobile_register_verfity_mobile");
        $mobile_vertify = $this->session->userdata("mobile_register_mobile_verfity");
        $set_time = $this->session->userdata('mobile_register_verfity_settime');
        if ($mobile_vertify != $prams['mobile_vertify']) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机验证码不正确'
            );
            print_r(json_encode($return));
            exit();
        }
        if ($mobile != $prams['username']) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机号码异常'
            );
            print_r(json_encode($return));
            exit();
        }
        if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '验证码已失效，请重新获取'
            );
            print_r(json_encode($return));
            exit();
        }
        if( isset($prams['parent_id'])){
            $data['parent_id']  = $prams['parent_id'];//上线ID
        }
        $data['mobile'] =$prams['username'];
        $data['tbxRegisterPassword'] =$prams['password'];
        $data['email'] =$prams['email'];
        $data['app_id'] =$this->session->userdata("app_info")["id"];
        $data['time'] =date('Y-m-d H:i:s');
        $data['phone'] =isset($prams['phone'])? $prams['phone']:NULL;
        $data['sex'] =isset($prams['sex'])? $prams['sex']:NULL;
        $data['registry_by'] = 'APP';
        $url = $this->url_prefix.'Customer/save?';
        $customer_info = json_decode($this->curl_do_result($url,$data),true);
        
         if($customer_info['status'] == 3){
         
            $customer = array(
                'user_name' => $prams['username'],
                'user_id' => $customer_info['customer_id'],
                'user_in' => TRUE,
                'is_vip' => 0,
                'user_last_login' => null
            );
            
            $this->session->set_userdata($customer);
            
            $return['data'] = array(
                'result' => 'success',
                'errorMessage' => null,
                'sessionid' => $this->session->userdata('session_id'),
                'sessions' => $customer
            );
            $this->generateBarcode($customer_info['customer_id']);
            $content = "恭喜，您的51易货网账号" . $prams['username'] . "注册成功";
            $this->sendmobileWithoutverfity($prams['username'], $content);
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '注册失败'
            );
        }
        $this->session->unset_userdata("mobile_register_verfity_mobile");
        $this->session->unset_userdata("mobile_register_mobile_verfity");
        $this->session->unset_userdata('mobile_register_verfity_settime');
        print_r(json_encode($return));
    }

    /**
     * 获取用户个人资料
     */
    public function getUserByUserId()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'userid'
        ));
        
        // 获取用户资料
        $user_id = $prams['userid'];
        $url = $this->url_prefix.'Customer/load?';
        $data['customer_id'] = $user_id;
        $customer = json_decode($this->curl_do_result($url,$data),true);
        
        
        if ($customer) {
            $return['data'] = array(
                'userid' => $customer['id'],
                'username' => $customer['name'],
                'password' => $customer['password'],
                'email' => isset($customer['email']) ? $customer['email'] : "",
                'mobile' => isset($customer['mobile']) ? $customer['mobile'] : "",
                'phone' => isset($customer['phone']) ? $customer['phone'] : "",
                'sex' => isset($customer['sex']) ? $customer['sex'] : 1,
                'birthday' => isset($customer['birthday']) ? date('Y-m-d', strtotime($customer['birthday'])) : date('Y-m-d'),
                'is_vip' => isset($customer['is_vip']) ? $customer['is_vip'] : 0,
                'is_mc' => isset($customer['is_mc']) ? $customer['is_mc'] : "",
            );
            //检查是否开通互助店
            $this->load->model('customer_shop_mdl','shop');
            $data = $this->shop->load($user_id);
            if(!$data){
                $return['data']['shopMessage'] = '未开通';
            }else{
                if($data['status'] == 1){
                    $return['data']['shopMessage'] = '审核中';
                }
                if($data['status'] == 2){
                    $return['data']['shopMessage'] = '已开通';
                }
            }
           
        } else {
            $return['data'] = array();
        }
        
        print_r(json_encode($return));
    }

    /**
     * 修改用户资料
     */
    public function updateUserByUserId()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'userid',
            'prams'
        ));
        
        $user_id = $prams['userid'];
        
        // $updatePrams = json_decode($prams['prams'],true);
        $updatePrams = $prams['prams'];
        
        if (isset($updatePrams['mobile']))
            $this->customer_mdl->mobile = $updatePrams['mobile'];
        
        if (isset($updatePrams['phone']))
            $this->customer_mdl->phone = $updatePrams['phone'];
        if (isset($updatePrams['email'])) {
            $customer = $this->customer_mdl->load($user_id);
            
            if ($customer['email'] != $updatePrams['email']) {
                // 检查email是否存在
                if ($this->customer_mdl->check_email($updatePrams['email'])) {
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '3',
                        'errorMessage' => '该email已经存在'
                    );
                    print_r(json_encode($return));
                    exit();
                }
                $this->customer_mdl->email = $updatePrams['email'];
            }
        }
        
        if (isset($updatePrams['sex']))
            $this->customer_mdl->sex = $updatePrams['sex'];
        
        if (isset($updatePrams['birthday']))
            $this->customer_mdl->birthday = $updatePrams['birthday'];
        
        if ($this->customer_mdl->update($user_id) != '-1') {
            $return['data'] = array();
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '该用户名已经存在'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 获取用户所有收货地址
     */
    public function getAddressByUserId()
    {
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
        
        $this->load->model('customer_address_mdl', 'address');
        $totalcount = $this->address->count_address($user_id); // 获取总记录数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
                                                                  
        // 获取列表
        $listdate = $this->address->load_all($user_id, $perPage, $offset);
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdate;
        
        print_r(json_encode($return));
    }

    /**
     * 根据ID获取用户收货地址详细
     */
    public function getAddressDetailById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'addressid'
        ));
        
        $addressid = $prams['addressid'];
        
        // 获取数据
        $this->load->model('customer_address_mdl', 'address');
        $return['data'] = $this->address->load_by_id($addressid);
        
        print_r(json_encode($return));
    }

    /**
     * 获取用户默认收货地址
     */
    public function getAddressDetailByDefault()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata('user_id');
        
        // 获取数据
        $this->load->model('customer_address_mdl', 'address');
        $return['data'] = $this->address->load($user_id);
        
        print_r(json_encode($return));
    }

    /**
     * 新增用户收货地址
     */
    public function createAddress()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'consignee',
            'province_id',
            'city_id',
            'district_id',
            'address'
        ));

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
        
        $this->load->model('customer_address_mdl', 'address');
        $this->address->customer_id = $user_id;
        $this->address->consignee = $prams['consignee'];
        $this->address->province_id = $prams['province_id'];
        $this->address->city_id = $prams['city_id'];
        $this->address->district_id = $prams['district_id'];
        $this->address->address = $prams['address'];
        if (isset($prams['phone']))
            $this->address->phone = $prams['phone'];
        if (isset($prams['mobile']))
            $this->address->mobile = $prams['mobile'];
        if (isset($prams['postcode']))
            $this->address->postcode = $prams['postcode'];
        if (isset($prams['address_name']))
            $this->address->address_name = $prams['address_name'];
        
        $is_default = isset($prams['is_default']) ? $prams['is_default'] : 0;
        
        if (! $this->address->create($is_default)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '添加用户收货地址失败'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 修改默认收货地址
     */
    public function updateDefaultAddress()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'addressid',
            'isdefault'
        ));

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
        
        $this->load->model('customer_address_mdl', 'address');
        if (! $this->address->set_default($prams['addressid'], $user_id, $prams['isdefault'])) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '修改默认货地址失败'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 修改用户收货地址
     */
    public function updateAddressById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'addressid',
            'consignee',
            'province_id',
            'city_id',
            'district_id',
            'address'
        ));

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
        
        $this->load->model('customer_address_mdl', 'address');
        $this->address->customer_id = $user_id;
        $this->address->consignee = $prams['consignee'];
        $this->address->province_id = $prams['province_id'];
        $this->address->city_id = $prams['city_id'];
        $this->address->district_id = $prams['district_id'];
        $this->address->address = $prams['address'];
        if (isset($prams['phone']))
            $this->address->phone = $prams['phone'];
        if (isset($prams['mobile']))
            $this->address->mobile = $prams['mobile'];
        if (isset($prams['postcode']))
            $this->address->postcode = $prams['postcode'];
        if (isset($prams['address_name']))
            $this->address->address_name = $prams['address_name'];
        
        if (! $this->address->update($prams['addressid'], $user_id)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '修改用户收货地址失败'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 删除用户收货地址
     */
    public function deleteAddressById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'addressid'
        ));

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
        
        $addressid = $prams['addressid'];

        $this->load->model('customer_address_mdl', 'address');
        if (! $this->address->delete($addressid, $user_id)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '删除用户收货地址失败'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 二维码检查用户存在与否
     */
    public function checkUser()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'userid'
        ));
        $this->_check_prams($prams, array(
            'username'
        ));
        
        // 获取用户资料
        $user_id = $prams['userid'];
        $username = $prams['username'];
        $customer = $this->customer_mdl->load($user_id);
        if ($customer) {
            
            if ($customer["name"] == $username) {
                $return["data"] = array(
                    "username" => $customer["name"]
                );
            } else {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '3',
                    'errorMessage' => '用户不存在，二维码错误'
                );
            }
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '用户不存在，二维码错误'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 收藏记录
     */
    public function getfavourites()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        // 检验参数
        // $this->_check_prams($prams,array('userid'));
        
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
        
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        $this->load->model("favourites_mdl");
        $totalcount = $this->favourites_mdl->count_Favourites(array(
            "customer_id" => $user_id
        ));
       
        // 获取总记录数
        $perPage = isset($page['perPage']) ? $page['perPage'] : 20; // 每页记录数
        $currPage = isset($page['currPage']) ? $page['currPage'] : 1; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
                                                                  
        // 获取列表
        $listdate = $this->favourites_mdl->fav_product_list($user_id, $perPage, $offset);
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdate;
        
        print_r(json_encode($return));
    }

    /**
     * 检查收藏
     */
    public function checkfavourites()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'pid'
        ));
        
        $pid = $prams['pid'];
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => 'false'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 获取商品即时信息
        $this->load->model("goods_mdl");
        $product = $this->goods_mdl->get_by_id($pid);
        if (empty($product['id'])) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => 'flase'
            );
            print_r(json_encode($return));
            exit();
        }
        
        // 插入浏览记录
        $this->load->model("customer_browsing_history_mdl", "cbh");
        $history = $this->cbh->load_by_condition($pid);
        if (empty($history['id'])) {
            $this->cbh->customer_id = $user_id;
            $this->cbh->product_id = $pid;
            $this->cbh->p_name = $product['name'];
            $this->cbh->p_price = $product['vip_price'];
            $this->cbh->cate_id = $product['cat_id'];
            $this->cbh->goods_thumb = $product['file'];
            $this->cbh->create();
        }
        
        $this->load->model("favourites_mdl");
        if ($this->favourites_mdl->_check_fav($pid)) {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => 'true'
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => 'false'
            );
        }
        print_r(json_encode($return));
    }

    /**
     * 添加收藏
     */
    public function addFavourites()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $this->_check_prams($prams, array(
            'pid'
        ));
        
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
        
        $this->load->model("goods_mdl");
        $product = $this->goods_mdl->get_by_id($prams['pid']);
        if (empty($product)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '添加收藏夹失败，商品信息不足!'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $this->load->model("favourites_mdl");
        if ($this->favourites_mdl->_check_fav($product['id'])) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '该商品已经收藏了'
            );
        } else {
            $data = array(
                "customer_id" => $user_id,
                "product_id" => $product['id'],
                "product_name" => $product['name'],
                "price" => $product['vip_price'],
                "goods_thumb" => $product['goods_thumb']
            );
            
            if ($this->favourites_mdl->create($data)) {
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '0',
                    'errorMessage' => '添加收藏夹成功'
                );
            } else {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '3',
                    'errorMessage' => '添加收藏夹失败'
                );
            }
        }
        print_r(json_encode($return));
    }

    /**
     * 删除收藏
     */
    public function deleteFavourites()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'ids'
        ));
        
        $id = $prams['ids'];
        $ids = explode(",", $id);
        
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
        
        $this->load->model("favourites_mdl");
        if ($this->favourites_mdl->_check_fav($ids)) {
            if (! $this->favourites_mdl->deletefav($ids, $user_id)) {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '3',
                    'errorMessage' => '删除商品失败！'
                );
            } else {
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '0',
                    'errorMessage' => '成功删除收藏夹商品！'
                );
            }
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '该商品不在收藏夹内！'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 客户列表
     */
    public function customerdata($level = 0, $fid = 0)
    {
        if ($level < 0 || $level > 5) {
            $this->showMessage("找不到所需页面！", site_url('customer/customerdata'), true, true);
        } else {
            if ($level > 0 && $fid == 0) {
                $this->showMessage("参数错误！", site_url('customer/customerdata'), true, true);
            } else {
                if ($level == 0) {
                    $fid = $this->session->userdata('user_id');
                }
                
                $data["begindate"] = $this->input->get_post("begindate");
                $data["enddate"] = $this->input->get_post("enddate");
                $data["username"] = $this->input->get_post("username");
                $data["phone"] = $this->input->get_post("phone");
                $like = array();
                $condition = array();
                if ($data["begindate"] && $data["begindate"] != "") {
                    $condition["registry_at >="] = $data["begindate"];
                }
                if ($data["enddate"] && $data["enddate"] != "") {
                    $condition["registry_at <="] = $data["enddate"];
                }
                if ($data["username"] && $data["username"] != "") {
                    $like["name"] = $data["username"];
                }
                if ($data["phone"] && $data["phone"] != "") {
                    $like["phone"] = $data["phone"];
                }
                
                $data["fid"] = $fid;
                $data["level"] = $level;
                $data["result"] = $this->customer_mdl->getChildList($level, $fid, $condition, $like);
            }
        }
        $this->load->view('app/customerdata', $data);
    }

    /**
     * 整合购物车
     */
    public function initCart()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'cartlist'
        ));
        
        $cartlist = $prams['cartlist'];
        
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
        
        $this->load->model("cart_mdl");
        $check_array = isset($cartlist['0']) ? $cartlist['0'] : $cartlist;
        if (count($check_array) > 0 && ! empty($cartlist)) {
            $this->cart_mdl->reinitforapp($user_id, $cartlist);
        }
        
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        
        $totalcount = $this->cart_mdl->count_list($user_id); // 获取总记录数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1;
        
        $result = $this->cart_mdl->getCartList($user_id, $perPage, $offset);
        $sku_id_array = '';
        foreach ($result as $key => $r) {
            if ($r["sku_id"] != 0) {
                $sku_id_array .= $r["sku_id"] . ',';
            }
        }
        if ($sku_id_array != '' || $sku_id_array != null) {
            // 加载商品sku信息
            $sku_id_array = substr($sku_id_array, 0, strlen($sku_id_array) - 1);
            $sku_id_array = explode(',', $sku_id_array);
            $sku_info = $this->getAttrSkuName($sku_id_array);
            // result、sku整合到result
            foreach ($result as $k => $v) {
                $i = 0;
                foreach ($sku_info as $key => $values) {
                    if ($v['sku_id'] == $values['val_id']) {
                        $result[$k]['sku_item'][$i]['attr_value'] = isset($values['attr_name']) ? $values['attr_name'] : '';
                        $result[$k]['sku_item'][$i]['sku_name'] = $values['sku_name'];
                        $i ++;
                    }
                }
            }
        }
        
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $result;
        print_r(json_encode($return));
    }

    /**
     * 取购物车
     */
    public function getCart()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        // 检验参数
        // $this->_check_prams($prams,array('userid'));
        
        $this->load->model('attribute_mdl');
        $this->load->model('cart_mdl');
        
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
        
        $totalcount = $this->cart_mdl->count_list($user_id); // 获取总记录数
        $perPage = isset($page['perPage']) ? $page['perPage'] : 20; // 每页记录数
        $currPage = isset($page['currPage']) ? $page['currPage'] : 1; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1;
        
        $result = $this->cart_mdl->getCartList($user_id, $perPage, $offset);
        
        // 获取sku_id数组
        $sku_id_array = '';
        foreach ($result as $key => $r) {
            if ($r["sku_id"] != 0) {
                $sku_id_array .= $r["sku_id"] . ',';
            }
        }
        if ($sku_id_array != '' || $sku_id_array != null) {
            // 加载商品sku信息
            $sku_id_array = substr($sku_id_array, 0, strlen($sku_id_array) - 1);
            $sku_id_array = explode(',', $sku_id_array);
            $sku_info = $this->getAttrSkuName($sku_id_array);
            // result、sku整合到result
            foreach ($result as $k => $v) {
                $i = 0;
                foreach ($sku_info as $key => $values) {
                    if ($v['sku_id'] == $values['val_id']) {
                        $result[$k]['sku_item'][$i]['attr_value'] = isset($values['attr_name']) ? $values['attr_name'] : '';
                        $result[$k]['sku_item'][$i]['sku_name'] = $values['sku_name'];
                        $i ++;
                    }
                }
            }
        }
        
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $result;
        print_r(json_encode($return));
    }

    /**
     * 根据sku_id_array获取attr、sku
     * 
     * @param array $sku_id_array            
     * @return unknown
     */
    private function getAttrSkuName($sku_id_array = array())
    {
        $this->load->model('product_sku_mdl');
        $this->load->model('attribute_mdl');
        
        // 加载商品sku信息
        $sku_info = $this->product_sku_mdl->getSKUByValID($sku_id_array);
        // 加载商品attr信息
        $attr_id_array = '';
        foreach ($sku_info as $k => $v) {
            $attr_id_array .= $v['attr_id'] . ',';
        }
        $attr_id_array = substr($attr_id_array, 0, strlen($attr_id_array) - 1);
        $attr_id_array = explode(',', $attr_id_array);
        $attr = $this->attribute_mdl->load($attr_id_array);
        // attr、sku整合到sku_info
        foreach ($attr as $k => $v) {
            foreach ($sku_info as $key => $values) {
                if ($values['attr_id'] == $v['id']) {
                    $sku_info[$key]['attr_name'] = $v['attr_name'];
                }
            }
        }
        return $sku_info;
    }

    /**
     * 获取用户购物车数量
     */
    public function getCartAmount()
    {
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
        $this->load->model("cart_mdl");
        $result = $this->cart_mdl->product_amount($user_id); // 获取总记录数
        foreach ($result as $res) {
            $return['data']["customer_id"] = $res["customer_id"];
            $return['data']["amount"] = isset($res["amount"]) ? $res["amount"] : 0;
        }
        print_r(json_encode($return));
    }

    /**
     * 添加购物车
     */
    public function addCart()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'pid',
            'qty'
        ));
        
        $pid = $prams['pid'];
        $qty = $prams['qty'];
        $sku_id = isset($prams['sku_id']) ? $prams['sku_id'] : 0;
        
        $this->load->model("goods_mdl");
        $this->load->model("cart_mdl");
        $this->load->model("corporation_mdl");
        $this->load->model("product_sku_mdl");
        
        $product = $this->goods_mdl->get_by_id($pid);
        $corporation_id = $product['corporation_id'];
        
        // 商品没有店铺的处理
        if ($corporation_id == 0 || $corporation_id == "" || $corporation_id == null) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '加入购物车失败!'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $corporate = $this->corporation_mdl->load_id($corporation_id);
        $corporate_name = $corporate['corporation_name'];
        if (empty($product)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '加入购物车失败!'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $customer_id = $this->session->userdata('user_id');
        if ($sku_id != null && $sku_id != 0) {
            $sku = $this->product_sku_mdl->getSKUByValID($sku_id);
            $sku_val = $this->product_sku_mdl->getSKUValue($sku_id);
            foreach ($sku as $key => $s) {
                $sku_val['sku_name'][$key] = $s['sku_name'];
            }
        }
        
        if ($customer_id !== 0) {
            
            $condition['cart'] = $this->cart_mdl->load($customer_id, $pid, $sku_id);
            // 购物车有就更新数量，没有就添加数据库
            if (isset($condition['cart']['id'])) {
                //计算运费
                $freight = $this->freight_count($product,$condition['cart']['quantity'] + $qty);
                
                $cart = array(
                    'id' => $condition['cart']['id'],
                    'quantity' => $condition['cart']['quantity'] + $qty,
                    'freight' => $freight
                );
               
                //判断是否是特价商品执行
                if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                    $cart['price'] = $product['special_price'];
                }else{
                    //不是特价商品
                    $cart["price"] = $product['vip_price'];
                }
              
                $this->cart_mdl->updateCart($condition['cart']['id'], $customer_id, $cart);
                
                $res = $condition['cart']['id'];
            } else {
                //计算运费
                $freight = $this->freight_count($product,$qty);
                $cart = array(
                    'customer_id' => $customer_id,
                    'product_id' => $product['id'],
                    'quantity' => $qty,
                    'product_name' => $product['name'],
                    'sku_id' => $sku_id,
                    'img_goods' => $product['goods_thumb'],
                    'freight' => $freight
                );
                //是否是sku商品
                if (isset($sku) && $sku != null && $sku_id != 0) {
                    
                    //判断是否是特价商品执行
                    if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                        $cart['price'] = $sku_val['special_offer'];
                    }else{
                        //不是特价商品
                        $cart["price"] = $sku_val['m_price'];
                    }
                } else {
                    
                    //判断是否是特价商品执行
                    if ($product['special_price_start_at'] <= date("Y-m-d H:i:s") && $product['special_price_end_at'] >= date("Y-m-d H:i:s")) {
                        $cart['price'] = $product['special_price'];
                    }else{
                        //不是特价商品
                        $cart["price"] = $product['vip_price'];
                    }
                    
                }
                
                $res = $this->cart_mdl->add($cart);
            }
        }
        $return['data'] = $cart;
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => '成功加入购物车'
        );
        print_r(json_encode($return));
    }

    /**
     * 删除购物车
     */
    public function deleteCart()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'id'
        ));
        $this->load->model("cart_mdl");
        
        $id = $prams['id'];
        
        $customer_id = $this->session->userdata('user_id');
        
        if ($customer_id == null || $customer_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if (! $this->cart_mdl->deleteCart($id, $customer_id)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '删除产品失败！'
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '成功删除购物车中产品！'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 修改购物车
     */
 public function updateCart()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'id',
            "qty",
            "pid"
        ));
        $this->load->model("cart_mdl");
        $this->load->model("goods_mdl");
        $customer_id = $this->session->userdata('user_id');
        
        if ($customer_id == null || $customer_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $product = $this->goods_mdl->get_by_id($prams["pid"]);
        if($prams["qty"]>$product['stock']){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '添加失败，购买数量不能超出库存。'
            );
            print_r(json_encode($return));
            exit;
        }
        $data["quantity"] = $prams["qty"] == "" ? 0 : $prams["qty"];// 数量
        $data["freight"] = $this->freight_count($prams["pid"],$data["quantity"],1);// 运费
        if (isset($prams["val_id"])) {
            $data["sku_id"] = $prams["val_id"];
        }
        
        if (! $this->cart_mdl->updateCart($prams["id"], $customer_id, $data)) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '修改失败！'
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '修改成功！'
            );
        }
        
        print_r(json_encode($return));
    }

    /**
     * 生成二维码
     */
    public function generateBarcode($userid)
    {
        //根据用户时间生成二维码
        $this->load->model("customer_mdl");
        $customer = $this->customer_mdl->load($userid);
        $year=(int)substr($customer["registry_at"],0,4);
        $month=(int)substr($customer["registry_at"],5,2);
        $day=(int)substr($customer["registry_at"],8,2);
        
        $data = site_url('customer/registration/' . $userid);
        $size = '400x400';
        $logo = './logo.png'; // 中间那logo图
                              
        // 生成二维码
        include dirname(BASEPATH) . "/phpqrcode/qrlib.php";
        $errorCorrectionLevel = "L";
        $matrixPointSize = "6";
        
        //文件不存在创建
        if(!file_exists('./'.UPLOAD_PATH.'uploads/userinfo/'. $year . '/' . $month . '/' . $day )){
            mkdir('./'.UPLOAD_PATH.'uploads/userinfo/'. $year . '/' . $month . '/' . $day, 0777,true);
        }
        
         $filename = '/'.UPLOAD_PATH.'uploads/userinfo/'. $year . '/' . $month . '/' . $day . '/'.$userid . '.png';
        $margin = 1;
        QRcode::png($data, dirname(BASEPATH) . $filename, $errorCorrectionLevel, $matrixPointSize, $margin);
        
        $QR = imagecreatefromstring(file_get_contents("." . $filename));
        
        if ($logo !== FALSE) {
            $logo = imagecreatefromstring(file_get_contents($logo));
            
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);
            
            $logo_width = imagesx($logo);
            $logo_height = imagesy($logo);
            
            $logo_qr_width = $QR_width / 6;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;
            $from_width = ($QR_width - $logo_qr_width) / 2;
            
            imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
        }
        
       imagepng($QR, './'.$filename);
        
        imagedestroy($QR);
    }

    /**
     * 获取用户二维码
     */
    public function getUserBarcode()
    {
        $customer_id = $this->session->userdata('user_id');
        if ($customer_id == null || $customer_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        
        //根据用户时间生成二维码
        $this->load->model("customer_mdl");
        $customer = $this->customer_mdl->load($customer_id);
        $year=(int)substr($customer["registry_at"],0,4);
        $month=(int)substr($customer["registry_at"],5,2);
        $day=(int)substr($customer["registry_at"],8,2);
        
        $filename = '/'.UPLOAD_PATH.'uploads/userinfo/'. $year . '/' . $month . '/' . $day . '/'.$customer_id . '.png';
       
        if (! file_exists(dirname(BASEPATH) . $filename)) {
            
            $this->generateBarcode($customer_id);
        }
        $return["data"] = base_url($filename);
        print_r(json_encode($return));
    }

    /**
     * 发送验证码短信
     */
    public function sendmobile()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'mobile'
        ));
        
        $this->load->model("shortmsg_log_mdl");
        
        $mobile = $prams["mobile"];
        $status = isset($prams["status"]) ? $prams["status"] : 0;
        
        if (isset($status) && ($status == 1 || $status == 2)) {
            $check_mobile = $this->customer_mdl->check_mobile($mobile);
            if (! $check_mobile) {
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '2',
                    'errorMessage' => '用户未注册'
                );
            }
        }
        
        $this->load->library('Short_Message_Factory', '', 'message');
        $num = $this->message->random(6);
       
        // 读取默认短信提供商
        $this->load->model("sms_supplier_mdl");
        $supplier = $this->sms_supplier_mdl->get_in_use();
        $sms = $this->message->get_message($supplier);
        $date = date('Y-m-d H:i:s');
        
        if (isset($status) && $status == 1) {
            $this->session->set_userdata('forgot_password_verfity_mobile', $mobile);
            $this->session->set_userdata('forgot_password_mobile_verfity', $num);
            $this->session->set_userdata('forgot_password_verfity_settime', $date);
            $content = '忘记密码短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露【51易货网】';
        } elseif (isset($status) && $status == 2) {
            $this->session->set_userdata('set_paypassword_verfity_mobile', $mobile);
            $this->session->set_userdata('set_paypassword_mobile_verfity', $num);
            $this->session->set_userdata('set_paypassword_verfity_settime', $date);
            $content = '设置支付密码短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露【51易货网】';
        } elseif (isset($status) && $status == 3) {
            $this->session->set_userdata('app_bindingmobile_verfity_mobile', $mobile);
            $this->session->set_userdata('app_bindingmobile_mobile_verfity', $num);
            $this->session->set_userdata('app_bindingmobile_verfity_settime', $date);
            $content = '绑定手机短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露【51易货网】';
        } elseif (isset($status) && $status == 4) {
            $this->session->set_userdata('update_password_verfity_mobile', $mobile);
            $this->session->set_userdata('update_password_mobile_verfity', $num);
            $this->session->set_userdata('update_password_verfity_settime', $date);
            $content = '设置密码短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露【51易货网】';
        } elseif (isset($status) && $status == 5) {
            $this->session->set_userdata('app_bindingwechat_verfity_mobile', $mobile);
            $this->session->set_userdata('app_bindingwechat_mobile_verfity', $num);
            $this->session->set_userdata('app_bindingwechat_verfity_settime', $date);
            $content = '绑定微信短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露【51易货网】';
        } elseif (isset($status) && $status == 6) {
            $this->session->set_userdata('app_unbundlingwechat_verfity_mobile', $mobile);
            $this->session->set_userdata('app_unbundlingwechat_mobile_verfity', $num);
            $this->session->set_userdata('app_unbundlingwechat_verfity_settime', $date);
            $content = '解绑微信短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露【51易货网】';
        } else {
            $this->session->set_userdata('mobile_register_verfity_mobile', $mobile);
            $this->session->set_userdata('mobile_register_mobile_verfity', $num);
            $this->session->set_userdata('mobile_register_verfity_settime', $date);
            $content = '手机注册短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露【51易货网】';
        }
        
        $id = $this->shortmsg_log_mdl->create(array(
            'mobile' => $mobile,
            'content' => $content
        ));
        $msgs = $sms->send($mobile, $content); // 'sms&stat=100&message=发送成功';//
        $msg = explode("&", $msgs);
        $type = $msg[0];
        $status = $msg[1]; // substr($msg[1], strpos($msg[1], "=") + 1);
        $return_msg = $msg[2]; // substr($msg[2], strpos($msg[2], "=") + 1);
        $log = array(
            'id' => $id,
            'msg_type' => $type,
            'status' => $status,
            'return_msg' => $return_msg
        );
        $this->shortmsg_log_mdl->update($log);
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => 0,
            'errorMessage' => $return_msg
        );
        
        print_r(json_encode($return));
   
    }
    
    // 接口内部发送短信操作
    private function sendmobileWithoutverfity($mobile, $content)
    {
        $this->load->library('Short_Message_Factory', '', 'message');
        $this->load->model("shortmsg_log_mdl");
        // 读取默认短信提供商
        $this->load->model("sms_supplier_mdl");
        $supplier = $this->sms_supplier_mdl->get_in_use();
        $sms = $this->message->get_message($supplier);
        $id = $this->shortmsg_log_mdl->create(array(
            'mobile' => $mobile,
            'content' => $content
        ));
        $msgs = $sms->send($mobile, $content);
        $msg = explode("&", $msgs);
        $type = $msg[0];
        $status = $msg[1];
        $return_msg = $msg[2];
        $log = array(
            'id' => $id,
            'msg_type' => $type,
            'status' => $status,
            'return_msg' => $return_msg
        );
        $this->shortmsg_log_mdl->update($log);
    }

    /**
     * 修改登录密码
     */
    public function updatePassword()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'verfity',
            'password'
        ));
        
        $user_id = $this->session->userdata("user_id");
        $verfity = $prams['verfity'];
        $password = $prams['password'];
        $mobile = isset($prams["mobile"]) ? $prams["mobile"] : "";
        $mobile_verfity = $this->session->userdata('update_password_mobile_verfity');
        $set_time = $this->session->userdata('update_password_verfity_settime');
        
        // 验证登录
        if (! $user_id) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        // 验证验证码
        if ($verfity != $mobile_verfity) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '手机验证码不正确'
            );
            print_r(json_encode($return));
            exit();
        }
        if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '验证码已失效，请重新获取'
            );
            print_r(json_encode($return));
            exit();
        }
        // 验证密码
        if ($password == '') {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '密码不能为空'
            );
            print_r(json_encode($return));
            exit();
        }
        
        
        $url = $this->url_prefix.'Customer/update_pwd?';
        $data = array();
        $data['customer_id'] = $user_id;
        $data['password'] = $password;
        $change = json_decode($this->curl_do_result($url,$data),true);
        if($change['status']){
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '密码修改成功'
            );
        }
        
        if ($mobile == '') {
            $url = $this->url_prefix.'Customer/load?';
            $customer = json_decode($this->curl_do_result($url,$data),true);
            $mobile = $customer['mobile'];
        }
        $content = "您的登录密码修改成功，如非本人操作请致电400-0029-777";
        $this->sendmobileWithoutverfity($mobile, $content);
        print_r(json_encode($return));
    }

    /**
     * 忘记登录密码
     */
    public function forgotPassword()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'password',
            "mobilevertify",
            "mobile"
        ));
        
        $mobile_vertify = $prams['mobilevertify'];
        $mobile = isset($prams["mobile"]) ? $prams["mobile"] : "";
        $vertify_mobile = $this->session->userdata('forgot_password_verfity_mobile');
        $vertify = $this->session->userdata('forgot_password_mobile_verfity');
        $set_time = $this->session->userdata('forgot_password_verfity_settime');
        
        $password = $prams['password'];
        //接口调用
        $url = $this->url_prefix.'Customer/load_by_mobile?';
        $data =array();
        $data['mobile']= $mobile;
        $customer = json_decode($this->curl_do_result($url,$data),true);
//         $customer = $this->customer_mdl->load_by_mobile($mobile);
        
        if (! $customer || count($customer) == 0) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '此账号未注册，无法重设密码'
            );
            print_r(json_encode($return));
            exit();
        }

        if ($mobile_vertify != $vertify) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机验证码不正确'
            );
            print_r(json_encode($return));
            exit();
        }
        if ($vertify_mobile != $mobile) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机号码异常'
            );
            print_r(json_encode($return));
            exit();
        }        
        if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '验证码已失效，请重新获取'
            );
            print_r(json_encode($return));
            exit();
        }
        
        
        $data['password'] = md5($password);
        $link = $this->url_prefix.'Customer/forget_password?';
        $res = json_decode($this->curl_do_result($link,$data),true);
        
        
        if ($res) {
            
            $cus = json_decode($this->curl_do_result($url,$data),true);
            
            $customer = array(
                'user_name' => $cus['name'],
                'user_id' => $cus['id'],
                'user_in' => TRUE,
                'is_vip' => 0,
                'user_last_login' => date("Y-m-d H:i:s")
            );
            
            $this->session->set_userdata($customer);
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '修改密码成功！'
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '修改密码失败！'
            );
        }
        $this->session->unset_userdata('forgot_password_verfity_mobile');
        $this->session->unset_userdata('forgot_password_mobile_verfity');
        $this->session->unset_userdata('forgot_password_verfity_settime');
        $content = "您的登录密码修改成功，如非本人操作请致电400-0029-777";
        $this->sendmobileWithoutverfity($mobile, $content);
        print_r(json_encode($return));
    }

    /**
     * 设置支付密码
     */
    public function setPayPassword()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'paypassword',
            "mobilevertify"
        ));
        
        $mobile = isset($prams['mobile']) ? $prams['mobile'] : "";
        $mobile_vertify = $prams['mobilevertify'];
        $verfity_mobile = $this->session->userdata('set_paypassword_verfity_mobile');
        $vertify = $this->session->userdata('set_paypassword_mobile_verfity');
        $set_time = $this->session->userdata('set_paypassword_verfity_settime');
        $paypassword = $prams['paypassword'];
        $user_id = $this->session->userdata('user_id');
        
        if ($mobile_vertify != $vertify) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机验证码不正确'
            );
            print_r(json_encode($return));
            exit();
        }
        if ($verfity_mobile != $mobile) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '手机号码异常'
            );
            print_r(json_encode($return));
            exit();
        }
        if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '验证码已失效，请重新获取'
            );
            print_r(json_encode($return));
            exit();
        }

        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $data =array();
        $data['customer_id'] =$user_id;
        $url =$this->url_prefix.'Customer/load_pay_account?';
        $pay_account = json_decode($this->curl_do_result($url,$data),true);
        
        if (! $pay_account['id']) {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '6',
                'errorMessage' => '请先绑定手机'
            );
        }
        
        $data['pay_passwd'] = $paypassword;
        
        //判断新旧支付密码是否相同
        $link = $this->url_prefix.'Customer/getPayAccount?';
        $Accountinfo = json_decode($this->curl_do_result($link,$data),true);
        if($Accountinfo['status']){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '8',
                'errorMessage' => '新旧支付密码不能相同！'
            );
            print_r(json_encode($return));
            exit;
        }
        $link = $this->url_prefix.'Customer/setPayPassword?';
        $res = json_decode($this->curl_do_result($link,$data),true);
        
        if ($res['status']) {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => '设置支付密码成功！'
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '3',
                'errorMessage' => '设置支付密码失败！'
            );
            print_r(json_encode($return));
            exit;
        }
        if ($mobile == '') {
            //接口调用
            $url = $this->url_prefix.'Customer/load?';
            $data =array();
            $data['customer_id']= $user_id;
            $customer = json_decode($this->curl_do_result($url,$data),true);
            $mobile = $customer['mobile'];
        }
        $this->session->unset_userdata('set_paypassword_verfity_mobile');
        $this->session->unset_userdata('set_paypassword_mobile_verfity');
        $this->session->unset_userdata('set_paypassword_verfity_settime');
        $content = "您的支付密码修改成功，如非本人操作请致电400-0029-777";
        $this->sendmobileWithoutverfity($mobile, $content);
        print_r(json_encode($return));
    }
    
    private function curl_get_result( $url ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }

    /**
     * 获取用户资产
     */
    public function getUserCreditById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        // $this->_check_prams($prams,array('userid'));
        
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
        
        $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
        $credit = json_decode($this->curl_get_result($url),true);
        
        
        if ($credit) {
            $return['data'] = array(
                'cash' => $credit['cash'],
                'credit' => $credit['credit'],
                'M_credit' => $credit['M_credit'],
                'pay_pd_exist' => empty($credit['pay_passwd']) ? "false" : "true"
            );
            $time = date('Y-m-d H:i:s');
            if (! ($credit['credit_start_time'] <= $time && $credit['credit_end_time'] >= $time)) {
                $return['data']['credit'] = '0.00';
            }
            
            
            //接口-查询银行卡信息接口
            $card_url = $this->url_prefix.'Customer/load_card?';
            $data['customer_id']= $user_id;
            $card_info = json_decode($this->curl_do_result($card_url,$data),true);
       
            if($card_info){
                switch($card_info['status'])
                {
                    case '1':
                        $return['data']['status'] = '审核中';
                        break;
                    case '2':
                        $return['data']['status'] = '已绑定';
                        break;
                    case '3':
                        $return['data']['status'] = '已冻结';
                        break;
                    case '4':
                        $return['data']['status'] = '已解绑';
                        break;
                    case '5':
                        $return['data']['status'] = '审核失败';
                        break;
                }
            }else{
               $return['data']['status'] = '未绑定';
            }
           
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '8',
                'errorMessage' => '该账户无资产资料！'
            );
        }
        
        $this->load->model('customer_shop_mdl','shop');
        $shop = $this->shop->load($user_id);
        if(!$shop){
            $shop_status = '未开通';
        }else{
            if(!$shop['status']){
                $shop_status = '审核中';
            }else{
                $shop_status = '';
            }
        }
        $return['data']['shop'] = $shop_status;
        print_r(json_encode($return));
    }
    
    /**
     * 货豆日志
     */
    public function getUserlog()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $this->_check_prams($prams, array('status'));
        
        $status = $prams["status"];
        $relation_id = $this->session->userdata ( 'pay_relation' )["id"];
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页

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
        
        //接口-获取日志
        $url = $this->url_prefix.'log/ajax_transaction_list/?status='.$status.'&page='.$perPage.'&limit='.$currPage.'&relation_id='.$relation_id;
        $return["data"]["list"] = json_decode($this->curl_get_result($url),true)["log"];
        
        if($status==3){
            //接口－获取资产信息
            $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
            $return["data"]["credit"] = json_decode($this->curl_get_result($url),true)["credit"];
        }
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
        );
        print_r(json_encode($return));
    }
    

    /**
     * 货豆日志
     */
//     public function getUserCurrencylog_back()
//     {
//         // 获取参数
//         $prams = $this->p;
//         $return = $this->return;
//         $page = $this->n;
        
//         // 检验参数
//         // $this->_check_prams($prams,array('user_id'));
//         $user_id = $this->session->userdata('user_id');
//         if ($user_id == null || $user_id == "") {
//                 $return['responseMessage'] = array(
//                     'messageType' => 'error',
//                     'errorType' => '5',
//                     'errorMessage' => '用户未登录'
//                 );
//                 print_r(json_encode($return));
//                 exit();
//             }
//         $pay_relation = $this->session->userdata ( 'pay_relation' );
//         $relation_id = isset($pay_relation['id'])? $pay_relation['id']:NULL;
       
//         $url = $this->url_prefix.'log/?relation_id='.$relation_id;
      
//         $result = json_decode($this->curl_get_result($url),true);
        
//         $totalcount = count($result['m_log']); // 获取总记录数
//         $perPage = $page['perPage']; // 每页记录数
//         $currPage = $page['currPage']; // 当前页
//         $offset = ($currPage - 1) * $perPage; // 偏移量
//         $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
       
//         $url = $this->url_prefix.'log/ajax_transaction_list/?status=1&page='.$perPage.'&limit='.$currPage.'&relation_id='.$relation_id;
//         $result = json_decode($this->curl_get_result($url),true);
//         $m_log = $result['log'];
//         if ($m_log) {
//             foreach ($m_log as $key => $res) {
//                 $return['data'][$key]["remark"] = $res["remark"];
//                 $return['data'][$key]["created_at"] = $res["created_at"];
//                 $return['data'][$key]["amount"] = $res["amount"];
//                 $return['data'][$key]["customer_id"] = $res["customer_id"];
//                 $return['data'][$key]["corporation_name"] = isset($res["corporation_name"]) ? $res["corporation_name"] : "";
//                 $return['data'][$key]["order_no"] = $res["order_no"];
//                 $return['data'][$key]["type"] = $res["type"];
//             }
//         } else {
//             $return['responseMessage'] = array(
//                 'messageType' => 'error',
//                 'errorType' => '7',
//                 'errorMessage' => '无货豆日志！'
//             );
//         }
//         print_r(json_encode($return));
//     }

    /**
     * 现金日志
     */
//     public function getUserMoneylog()
//     {
//         // 获取参数
//         $prams = $this->p;
//         $return = $this->return;
//         $page = $this->n;
        
//         // 检验参数
//         // $this->_check_prams($prams,array('userid'));
        
//         $user_id = $this->session->userdata('user_id');
        
//         $pay_relation = $this->session->userdata ( 'pay_relation' );
//         $relation_id = isset($pay_relation['id'])? $pay_relation['id']:NULL;
       
//         $url = $this->url_prefix.'log/?relation_id='.$relation_id;
//         $result = json_decode($this->curl_get_result($url),true);
//         if ($user_id == null || $user_id == "") {
//             $return['responseMessage'] = array(
//                 'messageType' => 'error',
//                 'errorType' => '5',
//                 'errorMessage' => '用户未登录'
//             );
//             print_r(json_encode($return));
//             exit();
//         }
//         $totalcount = count($result['cash_log']); // 获取总记录数
//         $perPage = $page['perPage']; // 每页记录数
//         $currPage = $page['currPage']; // 当前页
//         $offset = ($currPage - 1) * $perPage; // 偏移量
//         $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
//         $url = $this->url_prefix.'log/ajax_transaction_list/?status=2&page='.$perPage.'&limit='.$currPage.'&relation_id='.$relation_id;
//         $result = json_decode($this->curl_get_result($url),true);
//         $cash_log = $result['log'];
        
//         if ($cash_log) {
//             foreach ($cash_log as $key => $res) {
//                 $return['data'][$key]["remark"] = $res["remark"] == "销售分成" ? "手续费扣款" : $res["remark"];
//                 $return['data'][$key]["created_at"] = $res["created_at"];
//                 $return['data'][$key]["cash"] = $res["cash"];
//                 $return['data'][$key]["customer_id"] = $res["customer_id"];
//                 $return['data'][$key]["corporation_name"] = isset($res["corporation_name"]) ? $res["corporation_name"] : "";
//                 $return['data'][$key]["charge_no"] = $res["charge_no"];
//                 $return['data'][$key]["type"] = $res["type"];
//             }
//         } else {
//             $return['responseMessage'] = array(
//                 'messageType' => 'error',
//                 'errorType' => '7',
//                 'errorMessage' => '无现金日志！'
//             );
//         }
//         print_r(json_encode($return));
//     }

    /**
     * 授信日志
     */
//     public function getUserCreditlog()
//     {
//         // 获取参数
//         $prams = $this->p;
//         $return = $this->return;
//         $page = $this->n;
       
//         // 检验参数
//         // $this->_check_prams($prams,array('userid'));
        
//         $pay_relation = $this->session->userdata ( 'pay_relation' );
//         $relation_id = isset($pay_relation['id'])? $pay_relation['id']:NULL;
//         $url = $this->url_prefix.'log/?relation_id='.$relation_id;
//         $result = json_decode($this->curl_get_result($url),true);
//         $user_id = $this->session->userdata('user_id');
       
//         if ($user_id == null || $user_id == "") {
//             $return['responseMessage'] = array(
//                 'messageType' => 'error',
//                 'errorType' => '5',
//                 'errorMessage' => '用户未登录'
//             );
//             print_r(json_encode($return));
//             exit();
//         }
        
//         $totalcount = count($result['credit_log']); // 获取总记录数
//         $perPage = $page['perPage']; // 每页记录数
//         $currPage = $page['currPage']; // 当前页
//         $offset = ($currPage - 1) * $perPage; // 偏移量
//         $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
//         $url = $this->url_prefix.'log/ajax_transaction_list/?status=3&page='.$perPage.'&limit='.$currPage.'&relation_id='.$relation_id;
//         $result = json_decode($this->curl_get_result($url),true);
//         $credit_log = $result['log'];
//         if ($credit_log) {
//             foreach ($credit_log as $key => $res) {
//                 $return['data'][$key]["remark"] = $res["remark"];
//                 $return['data'][$key]["created_at"] = $res["created_at"];
//                 $return['data'][$key]["credit"] = $res["credit"];
//                 $return['data'][$key]["type"] = $res["type"];
//             }
//         } else {
//             $return['responseMessage'] = array(
//                 'messageType' => 'error',
//                 'errorType' => '7',
//                 'errorMessage' => '无授信日志！'
//             );
//         }
//         print_r(json_encode($return));
//     }

    /**
     * 获取用户所有交易日志
     */
    public function getUserLogById()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
        // 检验参数
        // $this->_check_prams($prams,array('userid'));
        
        $this->load->model("customer_log_mdl");
        
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
        
        $this->load->model("customer_log_mdl");
        
        $totalcount = $this->customer_log_mdl->getLogCount($user_id);
        $totalamount = $totalcount[0]['amount']; // 获取总记录数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalamount / $perPage) : 1;
        
        $log = $this->customer_log_mdl->getLogByUserId($user_id, $perPage, $offset);
        
        if ($log) {
            foreach ($log as $key => $res) {
                $return['data'][$key]["customer_id"] = $res["customer_id"];
                $return['data'][$key]["log_at"] = $res["log_at"];
                $return['data'][$key]["credit"] = $res["credit"];
                $return['data'][$key]['reamrk'] = $res['reamrk'];
            }
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '9',
                'errorMessage' => '该账户无交易记录！'
            );
        }
        print_r(json_encode($return));
    }

    /**
     * 获取用户浏览记录
     */
    public function getBrowsingHistoryList()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        
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
        
        $this->load->model("customer_browsing_history_mdl", "cbh");
        
        $totalcount = $this->cbh->get_count_with_condition(); // 获取总记录数
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
        $select = "c.id,c.customer_id,c.product_id,c.cate_id as cat_id,c.p_name as name,c.p_price as vip_price,c.created_at,c.goods_thumb";
        
        $listdate = $this->cbh->get_lists_with_condition($perPage, $offset, $select);
        
        // 返回数据
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $listdate;
        
        print_r(json_encode($return));
    }

    /**
     * 删除用户浏览记录
     */
    public function deleteBrowsingHistory()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        // $this->_check_prams($prams,array('p_id'));
        
        $user_id = $this->session->userdata('user_id');
        $this->load->model("customer_browsing_history_mdl", "cbh");
        
        $product_id = isset($prams['product_id']) ? $prams['product_id'] : 0;
        
        if ($this->cbh->delete($product_id)) {
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '网络错误，请重新操作'
            );
        }
        print_r(json_encode($return));
    }

    /**
     * 计算运费
     * @param unknown $product  商品信息
     * @param unknown $qty      数量
     * @return number|unknown
     */
    private function freight_count($product,$qty,$status=0)
    {    
        $freight = 0; //运费
        if($status){
            $this->load->model('goods_mdl');
            $product = $this->goods_mdl->get_by_id($product);
        }
        //计算运费
        if($product['is_freight'] == 1){
            $default_freight =  $product['default_freight'];//默认价格 10
            $default_item =  $product['default_item'];//默认数量是多少 1
            $add_item  =  $product['add_item'];//每增加多少件 3
            $add_freight =  $product['add_freight'];//每增加X件+多少钱 10
    
            if($qty > $default_item ){
                $num = $qty - $default_item;
                $num_a = $num/$add_item;
                if(is_int($num_a) ){ //如果是整型
                    $freight = ($num_a*$add_freight)+$default_freight;
                }else{
    
                    if($num_a < 1){
                        $freight = $default_freight+$add_freight;
                    }else{
                        $num_a = intval($num_a);
                        $freight = ($num_a*$add_freight) + $add_freight+$default_freight;
                    }
                }
            }else{
                $freight = $default_freight;
            }
        }
    
        return $freight;
    }
    
    //-----------------------------------------------------------
    
    /**
     * 查询银行卡信息
     */
    public function load_card(){
        $return = $this->return;
        $prams = $this->p;
        
        $mactype = $prams['mactype'];
        $customer_id = $this->session->userdata("user_id");//用户id
        //数据验证
        if(!$customer_id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //接口-查询银行卡信息接口
        $url = $this->url_prefix.'Customer/load_card?';
        $data['customer_id']= $customer_id;
        $card = json_decode($this->curl_do_result($url,$data));
        $return['data'] = $card;
        if(empty($card) && $mactype){
                $return['data'] = array();
        }
       
        $return['responseMessage'] = array(
            'messageType' => 'success',
            'errorType' => '0',
            'errorMessage' => ''
            );
        print_r(json_encode($return));
    }
    
    //-----------------------------------------------------------
    
    /**
     * 绑定银行卡
     */
    public function add_card(){
        // 获取参数
        $return = $this->return;
        $prams = $this->p;
        // 检验参数
        $this->_check_prams($prams, array('name','identity','card_number','address',"bank"));
        $name = $prams["name"];//真实姓名
        $identity = $prams["identity"];//身份证号码
        $card_number = $prams["card_number"];//银行卡号
        $address = $prams["address"]; //地区
        $bank = $prams["bank"]; //地区


        $customer_id = $this->session->userdata("user_id");//用户id
        //数据验证
        if(!$customer_id){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }

        
        if(!preg_match('/^([\xe4-\xe9][\x80-\xbf]{2}){2,4}$/',$name)){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '6',
                'errorMessage' => '请输入正确的中文名字'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if(!preg_match('/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/',$identity)){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '7',
                'errorMessage' => '请输入正确的身份证号码'
            );
            print_r(json_encode($return));
            exit();
        }
        

        //验证银行卡
        if(!preg_match('/^(\d{16}|\d{19})$/',$card_number)){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '8',
                'errorMessage' => '请输入正确的银行卡号'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if(!$address){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '9',
                'errorMessage' => '请输入正确的地址'
            );
            print_r(json_encode($return));
            exit();
        }
        
        if(!$prams["bank"]){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '11',
                'errorMessage' => '请输入所属银行'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $this->load->library("bank");
        $branch = $this->bank->bankInfo($card_number);
        if(!$branch){
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '8',
                'errorMessage' => '请输入正确的银行卡号'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //接口-查询银行卡信息接口,如果有则修改，没用则绑定
        $url = $this->url_prefix.'Customer/load_card?';
        $data['customer_id']= $customer_id;
        $is_binding  = json_decode($this->curl_do_result($url,$data),true);
        
        //提交的数据
        $data['customer_id']= $customer_id;
        $data['real_name']= $name;
        $data['identity']= $identity;
        $data['card_number']= $card_number;
        $data['address']= $address;
        $data['bank']= $bank;
        $data['branch']= "$branch";
        
        if($is_binding){
            //接口-修改银行卡
            $url = $this->url_prefix.'Customer/save_card?';
            $row = $this->curl_do_result($url,$data);
            if($row){
                $return['responseMessage'] = array(
                    'messageType' => 'success',
                    'errorType' => '0',
                    'errorMessage' => ''
                );
                print_r(json_encode($return));
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '11',
                    'errorMessage' => '更新失败'
                );
                print_r(json_encode($return));
                exit();
            }
        }else{
            //接口-绑定银行卡
            $url = $this->url_prefix.'Customer/add_card?';
            $id = $this->curl_do_result($url,$data);
            if($id){
                $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
                );
                print_r(json_encode($return));
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '10',
                    'errorMessage' => '添加失败'
                );
                print_r(json_encode($return));
                exit();
            }
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */