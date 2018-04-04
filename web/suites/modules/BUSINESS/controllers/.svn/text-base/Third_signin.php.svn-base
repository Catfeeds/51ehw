<?php

/**
 * 第三方登录控制器
 */
class Third_signin extends Front_Controller
{

  
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
        if(base_url() == 'http://www.test51ehw.com/'){
            $appid =  'wxa05e0970ca30515a';
            $feedback_url = urlencode('http://www.test51ehw.com/index.php/_BUSINESS/Third_signin/wechat_callback');
        }else{
            $appid = $this->session->userdata('app_info')['wechat_appid']; // $appid = $third_info['appid'];//公众号在微信的appid
            // $appid =  'wx304db9b2a6f5133b';
            $feedback_url = urlencode('http://www.51ehw.com/index.php/_BUSINESS/Third_signin/wechat_callback');
        }
        //$feedback_url = urlencode('http://b.51ehw.com/index.php/_BUSINESS/Third_signin/wechat_callback');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $feedback_url . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header("Location:" . $url);
    }

    // ------------------------------------------------------------
    /**
     * PC端微信二维码扫码登录
     */
    public function wechat_code_login()
    {
        $session_id = rand(10,99);
        //站点
        $app_id = $this->session->userdata("app_info")["id"];
        //将分站点ID拼接到session_id，附在回调地址上
        $session_id = $session_id.$app_id;
        
        $this->session->set_userdata('session_id',$session_id);
        //开放平台上的网站应用APPID
        $appid = 'wxeb4dfec9b0bc28c0';
        //回调地址
        $feedback_url = urlencode('http://www.51ehw.com/index.php/_BUSINESS/third_signin/callback');
        $url = 'https://open.weixin.qq.com/connect/qrconnect?appid=' . $appid . '&redirect_uri=' . $feedback_url . '&response_type=code&scope=snsapi_login&state=' . $session_id . '&connect_redirect=1#wechat_redirect';
        
        header("Location:" . $url);
    }
    
    
    // ------------------------------------------------------------

    /**
     * C端回调跳到B端微信登录
     * 再由B端获取unionid传到A端获取用户信息后写入Memcache
     * 
     */
    function wechat_callback_c()
    {
        
        if(base_url() == 'http://www.test51ehw.com/'){
            $appid =  'wxa05e0970ca30515a';
            $secret = '3d84852e5aa33c8dd2e9c9d5da8ad2ae';
        }else{
            $appid = $this->session->userdata('app_info')['wechat_appid'];
            $secret = $this->session->userdata('app_info')['wechat_appsecret'];
            }
        
        
        
        //用户授权后code
        $code = $_GET["code"];
        //H5微信绑定回调 state参数值为bingding，其它情况为默认state
        $state = $_GET['state'];
        $get_user_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $userinfo = file_get_contents($get_user_url);
        $userinfo_obj = json_decode($userinfo, true);
    
         //获取用户信息access_token,refresh_token和openid
        $post =array();
        $post['access_token'] = $userinfo_obj['access_token'];
        $post['openid'] = $userinfo_obj['openid'];
        
        //A端wechat_code_login  识别调用memcache
        $post['registry_by'] = 'wechat_c';
        //接口post access_token,openid
        //A端接收access_token，openid  查出用户并写入memcached   返回user_key值
        $url = $this->url_prefix."Customer/wechat_code_login?";
        $user_key = json_decode($this->curl_post_result($url,$post),true);
       
        
        if(base_url() == 'http://www.test51ehw.com/'){
            if($state == 'bingding'){
                if($user_key){
                    // 发送key值到C端接口
                    $url = 'http://www.test51ehw.com/index.php/_CLIENT/Member/Bingding/binding_wechat_update?user_key='.$user_key;
                    header("Location: ".$url);
                }else{
                    error_log("微信端返回错误");
                    //微信端错误
                    $url = 'http://www.test51ehw.com/index.php/_CLIENT/Member/info';
                    header("Location: ".$url);
                }
            }else{
                //登录回调
                if($user_key){
                    // 发送key值到C端接口
                    $url = 'http://www.test51ehw.com/index.php/_CLIENT/Third_signin/check_mem_key?user_key='.$user_key;
                    header("Location: ".$url);
                }else{
                    error_log("微信端返回错误");
                    //微信端错误
                    $url = 'http://www.test51ehw.com/index.php/_CLIENT/Home';
                    header("Location: ".$url);
                }
            }
        }else{
            if($state == 'bingding'){
                if($user_key){
                    // 发送key值到C端接口
                    $url = 'http://c.51ehw.com/index.php/_CLIENT/Member/Bingding/binding_wechat_update?user_key='.$user_key;
                    header("Location: ".$url);
                }else{
                    error_log("微信端返回错误");
                    //微信端错误
                    $url = 'http://c.51ehw.com/index.php/_CLIENT/Member/info';
                    header("Location: ".$url);
                }
            }else{
                //登录回调
                if($user_key){
                    // 发送key值到C端接口
                    $url = 'http://c.51ehw.com/index.php/_CLIENT/Third_signin/check_mem_key?user_key='.$user_key;
                    header("Location: ".$url);
                }else{
                    error_log("微信端返回错误");
                    //微信端错误
                    $url = 'http://c.51ehw.com/index.php/_CLIENT/Home';
                    header("Location: ".$url);
                }
            }
        }
        
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
        // $appid = $third_info['appid'];
       
        //B端测试appid
        //$appid =  'wxa05e0970ca30515a';
        // $secret = $third_info['appsecret'];
        
        //B端测试app secret
        //$secret = '3d84852e5aa33c8dd2e9c9d5da8ad2ae';
        
        //         $appid = 'wx304db9b2a6f5133b';
        //         $secret = 'd4bd529a5601ceb73772fcd4c7646ab3';
      
        if(base_url() == 'http://www.test51ehw.com/'){
            $appid =  'wxa05e0970ca30515a';
            $secret = '3d84852e5aa33c8dd2e9c9d5da8ad2ae';
        }else{
            //公众号在微信的appid
            $appid = $this->session->userdata('app_info')['wechat_appid'];
            //公众号在微信的app secret
            $secret = $this->session->userdata('app_info')['wechat_appsecret'];
        }
      
        //用户授权后code
        $code = $_GET["code"];
     
        //获取access_token,返回的数据中若用户没有关注公众号 可能不会返回用户的在公众号唯一的openid
        $get_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$secret;
        
        //无论用户是否关注公众号 都能获取到用户的在公众号唯一的openid
        $get_openid_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        
        $openid_info = file_get_contents($get_openid_url);
        $token_info = file_get_contents($get_token_url);
        
        $token_obj = json_decode($token_info, true);
        $openid_obj = json_decode($openid_info, true);
        
        //将全局access_token 写进session
        $this->session->set_userdata('Wx_Access_Token',$token_obj['access_token']);
        
        //获取用户信息access_token,refresh_token和openid
        $post['access_token'] = $openid_obj['access_token'];
        $post['access_token1'] = $token_obj['access_token'];
        $post['openid'] = $openid_obj['openid'];
        $post['registry_by'] = 'wechat';
        $url = $this->url_prefix."Customer/wechat_code_login?";
       
        $data = json_decode($this->curl_post_result($url,$post),true);
       
        $this->load->helper("session");
        if ($data != NULL) {     
                
            if ($data['is_user'] ==false) {
                             //接口新用户注册
                $url = $this->url_prefix."Customer/save";
                $info =array();
                $info['Nickname'] =$data['wechat_nickname'];
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
                    $this->load->model("customer_mdl");
                    $customer = $this->customer_mdl->load($_customer['customer_id']);
                    set_customer($customer);
                }else{
                    //注册失败
                   echo "注册失败";exit;
                }
            } else {//有用户
               set_customer($data);
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
        if(empty($state) || $state !=$this->session->userdata('session_id') || empty($code)){
            redirect('customer/login');exit;
        }

        //截取字符串，获取站点ID
        $app_id = substr($state,2);
        $_branch = false;
        //判断是否是分站点 ，是则获取分站点信息
        if($app_id != 0){
            $this->load->model('app_info_mdl');
            //获取分站点信息
            $appinfo = $this->app_info_mdl->load($app_id);
            $_branch=true;
        }
        
        
        
       //开放平台上的网站应用APPID
        $appid = 'wxeb4dfec9b0bc28c0';
        //开放平台上的网站应用密钥
        $secret ='4a57d68b19b428a086fbe42f322d75c6';
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
                if($_customer['is_user']){//用户存在
                    $customer = array(
                        'user_name' => !empty($_customer['nick_name'])?$_customer['nick_name']:(!empty($_customer['wechat_nickname'])?$_customer['wechat_nickname']:$_customer['name']),
                        'user_id' => $_customer['id'],
                        'user_in' => TRUE,
                        'is_vip' => $_customer['is_vip'],
                        'is_active' => $_customer['is_active'],
                        'user_last_login' => $_customer['last_login_at'],
                        'corporation_id' => 0,
                        'privilege_id' => 0,
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
                        $customer['privilege_id'] = $corpinfo['privilege_id'];
                    }
        
                    //当在分站点扫码时
                    if($_branch){
                        //指定扫码后跳到分站点的个人中心
                        $url =$appinfo['site_url'].'_BUSINESS/Member/info';
                    
                        $_customer['user_key'] = md5($customer['user_id']);
                        //接口获取用户信息
                        $account_url = $this->url_prefix.'Customer/set_memcached';
                        $key = $this->curl_post_result($account_url,$_customer);
                    
                        if($key){
                            //跳到分站点的个人中心
                            redirect($url."?user_key=$key");//跳转
                        }else{
                            //当扫码后用户信息写memcached失败，则跳回分站点首页
                            redirect($appinfo['site_url'].'Home');//跳转
                        }
                    }
                    
                    
                    //更新购物车
                    $this->load->model('cart_mdl');
                    $this->cart_mdl->reinit($_customer['id']);
                    
                    $this->session->set_userdata($customer);
                    redirect('member/info');
                
                }else{//不存在

                    //当在分站点扫码时
                    if($_branch){
                        //指定扫码后跳到分站点的绑定手机注册页面
                        $url =$appinfo['site_url'].'_BUSINESS/Customer/loadmobile';
                    
                        $_customer['user_in'] = false;
                        $_customer['type'] = 'bingding';
                        //没有用户id，则用openid
                        $_customer['user_key'] = md5( $_customer['openid']);
                        //接口获取用户信息
                        $account_url = $this->url_prefix.'Customer/set_memcached';
                        $key = $this->curl_post_result($account_url,$_customer);
                        if($key){
                            //跳到分站点的个人中心
                            redirect($url."?user_key=$key");//跳转
                        }else{
                            //当扫码后用户信息写memcached失败，则跳回分站点首页
                            redirect($appinfo['site_url'].'Home');//跳转
                        }
                    }

                    $this->session->set_userdata($_customer);
                    redirect('customer/loadmobile');
                }
    
            } else {
                if($_branch){//分站点
                    redirect($appinfo['site_url'].'Home');//跳转
                }
                redirect('home');//微信返回错误
            }
        } else {
            if($_branch){//分站点
                redirect($appinfo['site_url'].'Home');//跳转
            }
            
            redirect('home');//微信返回错误
        }
    }
    // ------------------------------------------------------------
    
    /**
     * 生成二维码
     */
    public function generateBarcode($userid)
    {
        $data = site_url('customer/registration/' . $userid);
        $size = '400x400';
        $logo = './logo.png'; // 中间那logo图
                              
        // 生成二维码
        include dirname(BASEPATH) . "/phpqrcode/qrlib.php";
        $errorCorrectionLevel = "L";
        $matrixPointSize = "6";
        
        $filename = '/uploads/userinfo/' . $userid . '.png';
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
        imagepng($QR, 'uploads/userinfo/' . $userid . '.png');
        
        imagedestroy($QR);
    }
    //关注微信公众号
    public function  subscribe(){
        $user_id = $this->session->userdata("user_id");
        if(!$user_id){
            $this->session->set_userdata ( 'ref_from_url', current_url () ); // 统一使用ref_from_url
            redirect ( 'Third_signin/wechat' );
            exit;
        }
       
       $data['title'] = '关注公众号';
       $data['back'] = 'Home';
       $data['foot_set'] = 1;
       $data['head_set'] = 2;
       $data['user_id'] =$user_id;
       $this->load->view('head', $data);
       $this->load->view('_header', $data);
       $this->load->view('customer/subscribe', $data);
       $this->load->view('_footer', $data);
    }
    
}