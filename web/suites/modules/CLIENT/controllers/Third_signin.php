<?php

/**
 * 第三方登录控制器
 */
class Third_signin extends Front_Controller
{
  
    
    /**
     *
     * 同步登陆控制器
     */
    // ------------------------------------------------------------
    /**
     */
    function __construct()
    {
        parent::__construct();
    }
    
    // --------------------------------------------------------------------
    
    /**
     */
    function index()
    {}
    
    // --------------------------------------------------------------------
    
    /**
     */
    function wechat() 
    {
        // $this->load->model ( 'third_account_mdl' );
        $app_id = $this->session->userdata('app_info')['id'];
        // $third_info = $this->third_account_mdl->get_info ( 'open_wechat', $app_id );
        // $appid = $this->session->userdata('app_info')['wechat_appid']; // $appid = $third_info['appid'];
        if(base_url() == 'http://www.test51ehw.com/'){
            //测试
            //公众号在微信的appid
            $appid =  'wxdb9347555ac39e9e';
            $feedback_url = urlencode('http://www.test51ehw.com/index.php/_CLIENT/Third_signin/wechat_callback');
        }else{
            //正式
            //公众号在微信的appid
            //$appid =  'wx9b8bd6c3da712dda';
            //回调地址指向B端
            //$feedback_url = urlencode('http://www.51ehw.com/index.php/_BUSINESS/Third_signin/wechat_callback_c');
            
            $appid =  'wx3903a3dcf6da327a';
            $feedback_url = urlencode($this->session->userdata('app_info')['site_url'] . 'index.php/_CLIENT/Third_signin/wechat_callback');
        }
        
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $feedback_url . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
//         echo $url;exit;
        header("Location:" . $url);
    }
    
    function check_mem_key(){
        
        //获取mem_key
        $account_key = $this->input->get('user_key');
      
        if(!$account_key){
            return false;
        }else{
            //调用接口
            //获取用户数据
            $url = $this->url_prefix.'Customer/load_Memcached_Key?user_key='.$account_key;
            $data = json_decode($this->curl_get_result($url),true);
           
            if($data['is_user']){
                //已有用户
                $customer = array(
                            'user_name' => $data['user_name'],
                            'user_id' => $data['user_id'],
                            'nick_name' => $data['nick_name'],
                            'img_avatar' => $data['img_avatar'],
                            'is_active' => $data['is_active'],
                            'user_in' => TRUE,
                            'unionid' => $data['unionid'],
                            'openid' => $data['openid'],
                            'mobile_exist' => $data['mobile_exist'] ,
                        );
                
                //判断用户是否绑定了手机账号
                if($customer['mobile_exist']){
                    //已绑定手机
                    //加载用户支付账户信息写入session
                    $pay_data['customer_id'] = $data['user_id'];
                    $url = $this->url_prefix.'Customer/get_pay_relation_id?';
                    $pay_info = json_decode($this->curl_post_result($url,$pay_data),true);
                    $customer['pay_relation'] =$pay_info['id'];
                }
                
                $parent_id = $this->session->userdata('inviteid');
                $parent_appid = $this->session->userdata('inviteid_appid');
                if (isset($parent_id)) {
                    $this->load->model('customer_mdl');
                    $info =  $this->customer_mdl->load($customer['user_id']);
                    if(!$info['change_parent']){//change_parent = 0
                        if(!$info['parent_id']){//parent_id = 0
                            $datetime = date ( 'Y-m-d H:i:s' );
                            $this->customer_mdl->parent_id = $parent_id;
                            $this->customer_mdl->parent_update_time = $datetime;
                            $this->customer_mdl->app_id = $parent_appid;
                            if($this->session->userdata('inviteid_type') == 'code'){
                                $this->customer_mdl->change_parent = 1;
                            }
                            $this->customer_mdl->update($customer['user_id']);
                        }
                    }else{//change_parent = 1
                        if(!$info['is_active']){//is_active = 0
                            $datetime = date ( 'Y-m-d H:i:s' );
                            $this->customer_mdl->parent_id = $parent_id;
                            $this->customer_mdl->parent_update_time = $datetime;
                            $this->customer_mdl->app_id = $parent_appid;
                            $this->customer_mdl->update($customer['user_id']);
                        }
                    }
                   
                }
                
                //查询企业信息
                $this->load->model("corporation_mdl");
                $corpinfo = $this->corporation_mdl->load($data['user_id']);
                if ($corpinfo != null) {
                    $customer["corporation_status"] = $corpinfo["status"];
                    $customer["approval_status"] = $corpinfo["approval_status"];
                    $customer['corporation_id'] = $corpinfo['id'];
//                     $customer['privilege_id'] = $corpinfo['privilege_id'];

                    //检验是否有生成默认的分店总店
//                     $this->load->model('corporation_branch_mdl','branch');
//                     $host_branch = $this->branch->get_branch_detail(0, $corpinfo['id'],true);
//                     if(!$host_branch){//若没有，则帮用户生成默认分店总店(不需要判断企业状态)
//                         $this->branch->corporation_id = $corpinfo['id'];
//                         $this->branch->owner_id = $corpinfo['customer_id'];
//                         $this->branch->address = $corpinfo['address'];
//                         $this->branch->owner_name = $corpinfo['contact_name'];
//                         $this->branch->branch_name = $corpinfo['corporation_name'];
//                         $this->branch->is_host = 1;
//                         $this->branch->edit_branch();
//                     }
                }
                //更新购物车
                $this->load->model('cart_mdl');
                $this->cart_mdl->reinit($data['user_id']);
                
                $this->session->set_userdata($customer);
             
                // 生成二维码图片
                $this->generateBarcode($data['user_id']);
                
                $return_url = $this->session->userdata('ref_from_url'); // 页面转跳
                $return_url2 = $this->session->userdata('redirect'); // 待废除 页面转跳
              
                if ($return_url) {
                    header("Location:" . $return_url);
                    $this->session->set_userdata('ref_from_url', '');
                } else{
                    if ($return_url2) {
                        header("Location:" . $return_url2);
                        $this->session->set_userdata('redirect', '');
                    } else {
                        redirect('member/info');
            
                    }
                }
              
            }else{
                
                //接口新用户注册
                $url = $this->url_prefix."Customer/save";
               
                $info['nickname'] =$data['nick_name'];
                $info['headimgurl'] =$data['img_avatar'];
                $info['unionid'] =$data['unionid'];
                $info['openid'] =$data['openid'];
                $info['time'] =date('Y-m-d H:i:s');
                $info['registry_by'] = 'wechat';
                $info['tbxRegisterPassword'] = 'ehw88888888';
                $info['app_id'] =$this->session->userdata('app_info')['id'];
                $_customer = json_decode($this->curl_post_result($url,$info),true);
               
                if($_customer['customer_id']){
                    $url = $this->url_prefix."Customer/load?";
                    $userdata['customer_id'] =$_customer['customer_id'];
                    $customerinfo =   json_decode($this->curl_post_result($url,$userdata),true);
                    
                    $customer =array(
                        'user_name' => $customerinfo['name'],
                        'user_id' => $customerinfo['id'],
                        'nick_name' => $customerinfo['wechat_nickname'],
                        'img_avatar' => $customerinfo['wechat_avatar'],
                        'is_active' => $customerinfo['is_active'],
                        'user_in' => TRUE,
                        'unionid' => $customerinfo['wechat_account'],
                        'openid' => $customerinfo['openid'],
                        'mobile_exist' => false ,
                    );
                    
                    $parent_id = $this->session->userdata('inviteid');
                    $parent_appid = $this->session->userdata('inviteid_appid');
                    if (isset($parent_id)) {
                        $this->load->model('customer_mdl');
                        $info =  $this->customer_mdl->load($customer['user_id']);
                        if(!$info['change_parent']){//change_parent = 0
                            if(!$info['parent_id'] || $info['parent_id'] == '7005' ){//parent_id = 0 或者默认上线为7005 则可以修改
                                $datetime = date ( 'Y-m-d H:i:s' );
                                $this->customer_mdl->parent_id = $parent_id;
                                $this->customer_mdl->parent_update_time = $datetime;
                                $this->customer_mdl->app_id = $parent_appid;
                                if($this->session->userdata('inviteid_type') == 'code'){
                                    $this->customer_mdl->change_parent = 1;
                                }
                                $this->customer_mdl->update($customer['user_id']);
                            }
                        }else{//change_parent = 1
                            if(!$info['is_active']){//is_active = 0
                                $datetime = date ( 'Y-m-d H:i:s' );
                                $this->customer_mdl->parent_id = $parent_id;
                                $this->customer_mdl->parent_update_time = $datetime;
                                $this->customer_mdl->app_id = $parent_appid;
                                $this->customer_mdl->update($customer['user_id']);
                            }
                        }
                       
                    }
                    
                    $this->session->set_userdata($customer);
                    
                    if($this->session->userdata('inviteid_type') == 'code'){
                        $download = true;
                    }else{
                        $download = false;
                    }
                    
                    if($download){
                        redirect('shop/download');
                    }else{
                        $return_url = $this->session->userdata('ref_from_url'); // 页面转跳
                        $return_url2 = $this->session->userdata('redirect'); // 待废除 页面转跳
                        
                        if ($return_url) {
                            header("Location:" . $return_url);
                            $this->session->set_userdata('ref_from_url', '');
                        } else{
                            if ($return_url2) {
                                header("Location:" . $return_url2);
                                $this->session->set_userdata('redirect', '');
                            } else {
                                redirect('member/info');
                        
                            }
                        }
                    }
                    
                }else{
                    error_log("注册微信用户失败");
                    redirect('Home');
                }
            }
        }
    }
    
    
    
    // ------------------------------------------------------------
    /**
     * PC端微信二维码扫码登录
     */
    public function wechat_code_login()
    {
        $session_id = rand(10,99);
        $this->session->set_userdata('session_id',$session_id);
        //开放平台上的网站应用APPID
        $appid = 'wx2a706e1e44a2f841';
        //回调地址
        $feedback_url = urlencode('http://www.test51ehw.com/index.php/_CLIENT/Third_signin/callback');
        $url = 'https://open.weixin.qq.com/connect/qrconnect?appid=' . $appid . '&redirect_uri=' . $feedback_url . '&response_type=code&scope=snsapi_login&state=' . $session_id . '&connect_redirect=1#wechat_redirect';
        header("Location:" . $url);
    }
    
    
    // ------------------------------------------------------------

    /**
     * 微信登录
     */
    function wechat_callback()
    {
        /*
         * $this->load->model ( 'third_account_mdl' );
         * $app_id = $this->session->userdata ( 'app_info' )['id'];
         * $third_info = $this->third_account_mdl->get_info ( 'open_wechat', $app_id );
         */
        // $appid = $third_info['appid'];//公众号在微信的appid
        //$appid = $this->session->userdata('app_info')['wechat_appid'];
        // $secret = $third_info['appsecret'];//公众号在微信的app secret
        //$secret = $this->session->userdata('app_info')['wechat_appsecret'];
        if(base_url() == 'http://www.test51ehw.com/'){
            //C端测试appid
            $appid =  'wxdb9347555ac39e9e';
            //C端测试app secret
            $secret = 'f62c868b40381d57d281f49d377d8e37';
        }else{
            $appid = 'wx3903a3dcf6da327a';
            $secret = 'ddb07ae800f194ca7c523c111e3beac0';
        }
       
        //用户授权后code
        $code = $_GET["code"];
       
        $get_user_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $userinfo = file_get_contents($get_user_url);
        $userinfo_obj = json_decode($userinfo, true);
        
        //获取用户信息access_token,refresh_token和openid

        $post['access_token'] = $userinfo_obj['access_token'];
        $post['openid'] = $userinfo_obj['openid'];
        $post['registry_by'] = 'wechat';
        $url = $this->url_prefix."Customer/wechat_code_login?";
        $data = json_decode($this->curl_post_result($url,$post),true);
       
        if ($data != NULL) {
        
            if ($data['is_user'] ==false) {
                //接口新用户注册
                $url = $this->url_prefix."Customer/save";
                $info =array();
                $info['nickname'] =$data['wechat_nickname'];
                $info['headimgurl'] =$data['wechat_avatar'];
                $info['unionid'] =$data['unionid'];
                $info['openid'] =$data['openid'];
                $info['tbxRegisterPassword'] = 'ehw88888888';
                $info['time'] =date('Y-m-d H:i:s');
                $info['registry_by'] = 'wechat';
        
                $info['app_id'] =$this->session->userdata('app_info')['id'];
               
                $_customer = json_decode($this->curl_post_result($url,$info),true);
        
                if($_customer['status']==3){
                    $customer =array(
                        'user_name' => $data['wechat_nickname'],
                        'user_id' => $_customer['customer_id'],
                        'nick_name' => $data['wechat_nickname'],
                        'img_avatar' => $data['wechat_avatar'],
                        'is_active' => 0,
                        'user_in' => TRUE,
                        'unionid' => $data['unionid'],
                        'openid' => $data['openid'],
                    );
        
                    // 生成二维码图片
                    //                $this->generateBarcode($_customer['customer_id']);
                    $data['id'] = $_customer['customer_id'];
                }else{
                    //注册失败
                    echo "注册失败";exit;
                }
                if($this->session->userdata('inviteid_type') == 'code'){
                    $download = true;
                }else{
                    $download = false;
                }
                
            } else {//有用户
                $customer = array(
                    'user_name' => $data['name'],
                    'user_id' => $data['id'],
                    'nick_name' => $data['wechat_nickname'],
                    'img_avatar' => $data['wechat_avatar'],
                    'is_active' => $data['is_active'],
                    'user_in' => TRUE,
                    'unionid' => $data['wechat_account'],
                    'pay_relation'=>$data['pay_relation']['id'],
                    //                 'mobile_exist' => $data['mobile'] != "" ? true : false
                );
                $download = false;
            }
            
                $parent_id = $this->session->userdata('inviteid');
                $parent_appid = $this->session->userdata('inviteid_appid');
                if (isset($parent_id)) {
                    $this->load->model('customer_mdl');
                    $info =  $this->customer_mdl->load($customer['user_id']);
                    if(!$info['change_parent']){//change_parent = 0
                        if(!$info['parent_id']){//parent_id = 0
                            $datetime = date ( 'Y-m-d H:i:s' );
                            $this->customer_mdl->parent_id = $parent_id;
                            $this->customer_mdl->parent_update_time = $datetime;
                            $this->customer_mdl->app_id = $parent_appid;
                            if($this->session->userdata('inviteid_type') == 'code'){
                                $this->customer_mdl->change_parent = 1;
                            }
                            $this->customer_mdl->update($customer['user_id']);
                        }
                    }else{//change_parent = 1
                        if(!$info['is_active']){//is_active = 0
                            $datetime = date ( 'Y-m-d H:i:s' );
                            $this->customer_mdl->parent_id = $parent_id;
                            $this->customer_mdl->parent_update_time = $datetime;
                            $this->customer_mdl->app_id = $parent_appid;
                            $this->customer_mdl->update($customer['user_id']);
                        }
                    }
                   
                }
                //查询企业信息
                $this->load->model("corporation_mdl");
                $corpinfo = $this->corporation_mdl->load($data['id']);
                if ($corpinfo != null) {
                    $customer["corporation_status"] = $corpinfo["status"];
                    $customer["approval_status"] = $corpinfo["approval_status"];
                    $customer['corporation_id'] = $corpinfo['id'];
                    //                     $customer['privilege_id'] = $corpinfo['privilege_id'];
                
                    //检验是否有生成默认的分店总店
                    $this->load->model('corporation_branch_mdl','branch');
                    $host_branch = $this->branch->get_branch_detail(0, $corpinfo['id'],true);
                    if(!$host_branch){//若没有，则帮用户生成默认分店总店(不需要判断企业状态)
                        $this->branch->corporation_id = $corpinfo['id'];
                        $this->branch->owner_id = $corpinfo['customer_id'];
                        $this->branch->address = $corpinfo['address'];
                        $this->branch->owner_name = $corpinfo['contact_name'];
                        $this->branch->branch_name = $corpinfo['corporation_name'];
                        $this->branch->is_host = 1;
                        $this->branch->edit_branch();
                    }
                }
        
            //更新购物车
            $this->load->model('cart_mdl');
            $this->cart_mdl->reinit($data['id']);
        
            $this->session->set_userdata($customer);
        
        
            $return_url = $this->session->userdata('ref_from_url'); // 页面转跳
            $return_url2 = $this->session->userdata('redirect'); // 待废除 页面转跳
        
            
            if($download){//判断是否跳去下载APP
                redirect('shop/download');
            }else{
                if ($return_url) {
                    header("Location:" . $return_url);
                    $this->session->set_userdata('ref_from_url', '');
                } else{
                    if ($return_url2) {
                        header("Location:" . $return_url2);
                        $this->session->set_userdata('redirect', '');
                    } else {
                        redirect('member/info');
                
                    }
                }
            }
            
        } else {
            redirect('home');
        }
        
    }
    
    /**
     * 微信扫码登录
     */
    function callback(){
        //获取PC段端生成的二维码的sessionid变量值(安全性)
        //缺少参数
        //二维码已失效
        //授权失败
        $state = $_GET['state'];
        $code = $_GET['code'];//获取用户授权后返回的code值
        if(empty($state) || $state !=$this->session->userdata('session_id') || empty($code)){;
            redirect('customer/login');exit;
        }
 
       //开放平台上的网站应用APPID
        $appid = 'wx2a706e1e44a2f841';
        //开放平台上的网站应用密钥
        $secret ='7f9eb65aeea402196117e1e825d3b00b';
        $get_user_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $userinfo = file_get_contents($get_user_url);
        if($userinfo){
            $userinfo_obj = json_decode($userinfo, true);
            //获取用户信息access_token,refresh_token和openid
            $post['access_token'] = $userinfo_obj['access_token'];
            $post['openid'] = $userinfo_obj['openid'];
            $post['registry_by'] = "PC";
            //接口获取用户信息
            $url = $this->url_prefix."Customer/wechat_code_login";
            $_customer = json_decode($this->curl_post_result($url,$post),true);

            if ($_customer) {
                if($_customer['is_user'] && $_customer['mobile']){//用户存在
                    $customer = array(
                        'user_name' => !empty($_customer['nick_name'])?$_customer['nick_name']:(!empty($_customer['wechat_nickname'])?$_customer['wechat_nickname']:$_customer['name']),
                        'user_id' => $_customer['id'],
                        'user_in' => TRUE,
                        'is_vip' => $_customer['is_vip'],
                        'is_active' => $_customer['is_active'],
                        'user_last_login' => $_customer['last_login_at'],
                        'corporation_id' => 0,
//                         'privilege_id' => 0,
                        'openid' => $_customer['openid'],
                        'pay_relation' => $_customer['pay_relation']['id']
                    );
                    
                    //查询企业信息
                    $this->load->model("corporation_mdl");
                    $corpinfo = $this->corporation_mdl->load($_customer['id']);
                    if ($corpinfo != null) {
                        $customer["corporation_status"] = $corpinfo["status"];
                        $customer["approval_status"] = $corpinfo["approval_status"];
                        $customer['corporation_id'] = $corpinfo['id'];
//                         $customer['privilege_id'] = $corpinfo['privilege_id'];
                    }
        
                    $this->session->set_userdata($customer);


                    
                    //更新购物车
                    $this->load->model('cart_mdl');
                    $this->cart_mdl->reinit($_customer['customer_id']);
                    
                    
                    redirect('member/info');
                
                }else{//不存在

                    $this->session->set_userdata($_customer);
                    redirect('customer/loadmobile');
                }
    
            } else {
                redirect('home');//微信返回错误
            }
        } else {
            redirect('home');//微信返回错误
        }
    }
    // ------------------------------------------------------------
    
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
        // $png = 'http://chart.googleapis.com/chart?chs=' . $size . '&cht=qr&chl=' . urlencode($data) . '&chld=L|1&choe=UTF-8';
        
        // $QR = imagecreatefrompng($png);
        
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
        
        // header('Content-type: image/png');
        imagepng($QR, './'.$filename);
        
        imagedestroy($QR);
    }
}