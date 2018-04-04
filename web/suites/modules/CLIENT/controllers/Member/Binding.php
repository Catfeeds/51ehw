<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Binding extends Front_Controller {

    public function __construct()
    {
        parent::__construct();
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('redirect', current_url());
            redirect('customer/login');
            exit();
        }
        $this->load->model('customer_mdl');
        
        $customer = $this->customer_mdl->load($this->session->userdata("user_id"));
        if(isset($customer['mobile']) &&!empty($customer['mobile'])){
            $this->session->set_userdata("mobile_exist","true");
          
        }
    }

    public function index()
    {
        $this->load->model("customer_mdl");
        $user_id = $this->session->userdata("user_id");
        $data['customer'] = $this->customer_mdl->load($user_id);
        
        $data['title'] = '账户绑定';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('binding/binding_info', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data); 
    }
    
    /**
     * 微信登录，绑定手机
     * @param number $step 操作状态：1、开始绑定，3、绑定成功
     * @param number $err  错误信息：1、验证码错误，2、验证码超时，3、用户已绑定，4、数据错误，update失败
     */
    public function binding_mobile( $step = 1,$err = 0)
    {
       
        $data['step'] = $step;
        $data['err'] = $err;
        $redirect = $this->session->userdata('redirect');
        $data['back'] = isset($redirect)?$redirect:"member/info";
        $data['title'] = '绑定手机';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['mobile_code_type'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('binding/binding_mobile', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 微信登录，绑定手机 － 保存操作
     */
    public function update_login()
   {
        //验证用户是否存在，存在直接绑定，未存在添加账户、绑定
        $customer_id = $this->session->userdata("user_id");
      
        // 获取表单数据
        $name = $this->input->post('tbxBindingMobile');
        $vertify1 = $this->input->post('mobile-vertify');
    
        //验证用户验证码
        $vertify2 = $this->session->userdata('verfity_yzm_3');
        $mobile2 = $this->session->userdata('verfity_mobile_3');
        if($vertify1 != $vertify2 || $name != $mobile2){
            redirect("member/binding/binding_mobile/1/1");
        }
        // 验证码超时验证
        $set_time = $this->session->userdata('verfity_settime_3');
        if(date('Y-m-d H:i:s',strtotime("-90 second")) > $set_time){
            redirect("member/binding/binding_mobile/1/2");
        }
    
        
        $post['mobile'] = $name;
        
        //调用接口 查询该手机是否已经绑定用户
        $url = $this->url_prefix.'Customer/load_by_mobile';
        $_customer = json_decode($this->curl_post_result($url,$post),true);
        if($_customer){//手机之前已经注册过
            if($_customer['wechat_account']){//已经绑定了微信
                redirect("member/binding/binding_mobile/1/3");
                exit;
            }
            //没有绑定微信
            //接口--绑定用户
            $data['user_id'] = $_customer['id'];
            $data['openid'] = $this->session->userdata('openid');
            $data['unionid'] = $this->session->userdata('unionid');
            $data['wechat_avatar'] = $this->session->userdata('img_avatar');
            $data['wechat_nickname'] = $this->session->userdata('nick_name');
            $url = $this->url_prefix.'Customer/info_save';
            $is_binding = json_decode($this->curl_post_result($url,$data),true);
            if(!$is_binding){//绑定失败
                redirect("member/binding/binding_mobile/1/4");
                exit;
            }
            //接口--支付账户
            $url = $this->url_prefix.'Customer/fortune?customer_id='.$_customer['id'];
            $pay_relation  =  json_decode($this->curl_get_result($url),true);
            $_customer['pay_relation_id'] = $pay_relation['r_id'];
            
            $parent_id = $this->session->userdata('inviteid');
            $parent_appid = $this->session->userdata('inviteid_appid');
            if (isset($parent_id)) {
                $this->load->model('customer_mdl');
                $info =  $this->customer_mdl->load($_customer['id']);
                if(!$info['change_parent']){//change_parent = 0
                    if(!$info['parent_id']){//parent_id = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $parent_id;
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $parent_appid;
                        if($this->session->userdata('inviteid_type') == 'code'){
                            $this->customer_mdl->change_parent = 1;
                        }
                        $this->customer_mdl->update($_customer['id']);
                    }
                }else{//change_parent = 1
                    if(!$info['is_active']){//is_active = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $parent_id;
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $parent_appid;
                        $this->customer_mdl->update($_customer['id']);
                    }
                }
               
            }
            
            $this->load->model('customer_mdl');
            $weixin_info = $this->customer_mdl->load($customer_id);
            //同步数据
            if($weixin_info['parent_id']){
                $this->load->model('customer_shop_mdl','shop');
                $this->shop->update_share_log($customer_id,$_customer['id'],$weixin_info['parent_id']);//同步分享数据
                $this->shop->update_read_log($customer_id,$_customer['id'],$weixin_info['parent_id']);//同步阅读数据
                
                $mobile_info =$this->customer_mdl->load($_customer['id']);
                if(!$mobile_info['change_parent']){//change_parent = 0
                    if(!$mobile_info['is_active']){//is_active = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $weixin_info['parent_id'];
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $weixin_info['app_id'];
                        $this->customer_mdl->update($_customer['id']);
                    }
                }
            }
            //清除上线ID
            $this->customer_mdl->parent_id = NULL;
            $this->customer_mdl->update($customer_id);
            
            //将微信注册账号给失效
            $info['customer_id'] = $customer_id;
            $info['type'] = 'wechat';
           
            //接口-
            $url = $this->url_prefix.'Customer/unbundling';
          
            json_decode($this->curl_post_result($url,$info),true);
            
        }else{//手机之前没有注册过
            //用手机注册一个新用户并生成一个新的支付账户
            //生成密码默认值
            $password = 'ehw888888';
            $post['mobile'] = $name;
            $post['tbxRegisterPassword'] = $password;
            $post['nickname'] =  $post['nickname'] = $this->session->userdata('nick_name')?  $this->session->userdata('nick_name'):$name;
            $post['unionid'] = $this->session->userdata('unionid');
            $post['headimgurl'] = $this->session->userdata('img_avatar');
            $post['openid'] = $this->session->userdata('openid');
            $post['registry_by'] = "H5";
            $post['app_id'] = $this->session->userdata("app_info")["id"];
            $post['time'] = date("Y-m-d H:i:s");
            
            //调用接口
            $url = $this->url_prefix.'Customer/save';
            $_customer = json_decode($this->curl_post_result($url,$post),true);
            
            $_customer['id'] = $_customer['customer_id'];
            $_customer['pay_relation_id'] = $_customer['pay_relation_id'];
            
            $parent_id = $this->session->userdata('inviteid');
            $parent_appid = $this->session->userdata('inviteid_appid');
            if (isset($parent_id)) {
                $this->load->model('customer_mdl');
                $info =  $this->customer_mdl->load($_customer['id']);
                if(!$info['change_parent']){//change_parent = 0
                    if(!$info['parent_id']){//parent_id = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $parent_id;
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $parent_appid;
                        if($this->session->userdata('inviteid_type') == 'code'){
                            $this->customer_mdl->change_parent = 1;
                        }
                        $this->customer_mdl->update($_customer['id']);
                    }
                }else{//change_parent = 1
                    if(!$info['is_active']){//is_active = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $parent_id;
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $parent_appid;
                        $this->customer_mdl->update($_customer['id']);
                    }
                }
                 
            }
            
            $this->load->model('customer_mdl');
            $weixin_info = $this->customer_mdl->load($customer_id);
            //同步数据
            if($weixin_info['parent_id']){
                $this->load->model('customer_shop_mdl','shop');
                $this->shop->update_share_log($customer_id,$_customer['id'],$weixin_info['parent_id']);//同步分享数据
                $this->shop->update_read_log($customer_id,$_customer['id'],$weixin_info['parent_id']);//同步阅读数据
                
                $mobile_info =$this->customer_mdl->load($_customer['id']);
                if(!$mobile_info['change_parent']){//change_parent = 0
                    if(!$mobile_info['is_active']){//is_active = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $weixin_info['parent_id'];
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $weixin_info['app_id'];
                        $this->customer_mdl->update($_customer['id']);
                    }
                }
            }
            
            //清除上线ID
            $this->customer_mdl->parent_id = NULL;
            $this->customer_mdl->update($customer_id);
            
            //将微信注册账号给失效
            $info['customer_id'] = $customer_id;
            $info['type'] = 'wechat';
            //接口-
            $url = $this->url_prefix.'Customer/unbundling';
            json_decode($this->curl_post_result($url,$info),true);
            
        }
        
            $customer = array(
                'user_name' => $name,
                'user_id' => $_customer['id'],
                'user_in' => TRUE,
                'is_vip' => 0,
                'is_active' => 0,
                'user_last_login' => date('Y-m-d H:i:s'),
                'corporation_id' => 0,
//                 'privilege_id' => 0,
                'openid' => $this->session->userdata('openid'),
                'pay_relation' => $_customer['pay_relation_id']
            );
        
            //查询企业信息
            $this->load->model("corporation_mdl");
            $corpinfo = $this->corporation_mdl->load($_customer['id']);
            if ($corpinfo != null) {
                $customer["corporation_status"] = $corpinfo["status"];
                $customer["approval_status"] = $corpinfo["approval_status"];
                $customer['corporation_id'] = $corpinfo['id'];
//                 $customer['privilege_id'] = $corpinfo['privilege_id'];
            }
        
            //更新购物车
            $this->load->model('cart_mdl');
            $this->cart_mdl->reinit($_customer['id']);
        
            $this->session->set_userdata($customer);
            redirect("member/info");
     }        
            
            
            
            
            
    
    
    

    /**
     * 手机登录解绑/绑定other帐号 - first
     * @param number $step
     */
    public function binding_check($type = 'wechat')
    {
        $this->load->model("customer_mdl");
        $user_id = $this->session->userdata("user_id");
        $customer = $this->customer_mdl->load($user_id);
        
        $data['state'] = ($type=='wechat' && $customer['wechat_account'])?2:(($type=='qq' && $customer['qq_account'])?
                        2:(($type=='weibo' && $customer['weibo_account'])?2:(($type=='alipay' && $customer['alipay_account'])?2:1)));
        $data['type'] = $type;
        $data['type_show'] = ($type=='wechat')?"微信":(($type=='qq')?"QQ":(($type=='weibo')?"微博":(($type=='alipay')?"支付宝":"其他")));
        $data['account'] = isset($customer[$type."_nickname"])?$customer[$type."_nickname"]:"";
        $data['title'] = "解绑".$data['type_show']."号";
        $data['customer'] = $customer;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('binding/binding_check', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 手机登录绑定解绑/绑定other帐号 - second
     * @param string $type
     */
    public function binding_save($type = 'wechat',$err = 0)
    {
        // $err:1、验证码错误;
        // $err:2、有pay帐号，生成失败;
        // $err:3、
        $this->load->model("customer_mdl");
        $user_id = $this->session->userdata("user_id");
        
        $data['err'] = $err;
        $data['type'] = $type;
        $data['customer'] = $this->customer_mdl->load($user_id);
        $data['mobile_code_type'] = empty($data['customer'][$type . '_account']) ? "5" : "6";
        
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('binding/binding_save', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 手机登录绑定解绑other帐号 - third
     * @param string $type
     */
    public function unbundling_update( $type = 'wechat' )
    {
        $this->load->model("customer_mdl");
        $user_id = $this->session->userdata("user_id");
        $customer = $this->customer_mdl->load($user_id);
        
        $mobile_code_type = $this->input->post('mobile_code_type');
        switch ($mobile_code_type){
            case 5:
                $vertify2 = $this->session->userdata('verfity_yzm_5');
                $mobile2 = $this->session->userdata('verfity_mobile_5');
                $set_time = $this->session->userdata('verfity_settime_5');
                break;
            case 6:
                $vertify2 = $this->session->userdata('verfity_yzm_6');
                $mobile2 = $this->session->userdata('verfity_mobile_6');
                $set_time = $this->session->userdata('verfity_settime_6');
                break;
        }

        $vertify1 = $this->input->post('handset-num');
        $mobile1 = $customer['mobile'];
        
        // 验证验证码
        if( $mobile1!=$mobile2 || $vertify1!=$vertify2){
            redirect('member/binding/binding_save/wechat/1');
        }
        // 验证码超时验证
        if(date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            redirect('member/binding/binding_save/wechat/5');
        }
        
        // 解绑/绑定 start
        if($customer[$type.'_account']){
            
            // 解绑 start
            //调用接口解绑
            $info['type'] = $type;
            $info['customer_id'] = $user_id;
            $info['mobile'] = $mobile1;
            $url =$this->url_prefix.'Customer/unbundling?';
            $result = json_decode($this->curl_post_result($url,$info),true);
            if(!$result['status']){
                redirect('member/binding/binding_save/wechat/3');
                exit;
            }
            $this->session->set_userdata("user_name",$mobile1);
            $this->session->set_userdata("nick_name",$mobile1);
            switch ($mobile_code_type){
                case 5:
                    $this->session->unset_userdata('verfity_yzm_5');
                    $this->session->unset_userdata('verfity_mobile_5');
                    $this->session->unset_userdata('verfity_settime_5');
                    break;
                case 6:
                    $this->session->unset_userdata('verfity_yzm_6');
                    $this->session->unset_userdata('verfity_mobile_6');
                    $this->session->unset_userdata('verfity_settime_6');
                    break;
            }
        
            $data['head_set'] = 2;
            $data['customer'] = $customer;
            $data['type'] = $type;
            $data['type_show'] = ($type == 'wechat') ? "微信" : (($type == 'qq') ? "QQ" : (($type == 'weibo') ? "微博" : (($type == 'alipay') ? "支付宝" : "其他")));
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('binding/binding_success', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }else if($type == 'wechat'){
            // 绑定 start
            
            // 绑定微信跳转获取微信权限
            $this->binding_wechat();
            
        }
    }
    
    /**
     * 获取微信权限，回调绑定函数binding_wechat_update
     */
    public function binding_wechat()
    {
        $app_id = $this->session->userdata('app_info')['id'];
        
        //$appid = $this->session->userdata('app_info')['wechat_appid'];
        //公众号在微信的appid
        $appid =  'wx9b8bd6c3da712dda';
        //$feedback_url = urlencode($this->session->userdata('app_info')['site_url'] . 'index.php/member/binding/binding_wechat_update');
        $feedback_url = urlencode('http://www.51ehw.com/index.php/_BUSINESS/Third_signin/wechat_callback_c');
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $feedback_url . '&response_type=code&scope=snsapi_userinfo&state=bingding#wechat_redirect';

        header("Location:" . $url);
    }
    
    /**
     * 微信绑定回调函数
     */
    public function binding_wechat_update()
    {
//         $appid = $this->session->userdata('app_info')['wechat_appid'];
//         $secret = $this->session->userdata('app_info')['wechat_appsecret'];
//         $code = $_GET["code"];
//         $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        
//         $res = file_get_contents($get_token_url);
//         $json_obj = json_decode($res, true);
        
//         $access_token = $json_obj['access_token'];
        
//         $openid = $json_obj['openid'];
//         $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
//         $res = file_get_contents($get_user_info_url);
        
        //获取mem_key
        $account_key = $this->input->get('user_key');
        if(!$account_key){
            echo '<script>alert("微信端返回错误！")</script>';
            redirect('Member/info');
        }else{
            //调用接口
            //获取返回的微信用户数据
            $url = $this->url_prefix.'Customer/load_Memcached_Key?user_key='.$account_key;
            $data = json_decode($this->curl_get_result($url),true);
        
            if ($data != NULL) {
                if($data['is_user']){
                    $weixin_info['wechat_account'] = $data['unionid'];
                    $weixin_info['wechat_avatar'] = $data['img_avatar'];
                    $weixin_info['wechat_nickname'] = $data['nick_name'];
                    $weixin_info['openid'] = $data['openid'];
                
                }else {
                    $weixin_info['wechat_account'] = $data['unionid'];
                    $weixin_info['wechat_avatar'] = $data['img_avatar'];
                    $weixin_info['wechat_nickname'] =$data['nick_name'];
                    $weixin_info['openid'] = $data['openid'];
                }
                 $user_id = $this->session->userdata("user_id");
            //调用接口将微信信息合并到手机用户
            $url = $this->url_prefix.'Customer/update?';
            $weixin_info['customer_id'] = $user_id;
            $_update = json_decode($this->curl_post_result($url,$weixin_info),true);
            
            if($data['is_user']){
                if($_update['status']){
                    
                    //不删除微信用户，但清除微信用户信息，使微信账户失效
                    $url = $this->url_prefix.'Customer/unbundling?';
                    $updateinfo=array();
                    $updateinfo['customer_id'] = $data['id'] ;
                    $updateinfo['type'] = 'wechat';
                    $_del = json_decode($this->curl_post_result($url,$updateinfo),true);
                    
                    if(!$_del['status']){
                        redirect('member/binding/binding_save/wechat/3');
                    }
                }
            }else{
                if(!$_update['status']){
                    redirect('member/binding/binding_save/wechat/3');
                }
            }
            
            //调用重新获取用户最新信息
            $url = $this->url_prefix.'Customer/load?';
            $user_info['customer_id'] = $user_id;
            $customer = json_decode($this->curl_post_result($url,$user_info),true);
            
            $parent_id = $this->session->userdata('inviteid');
            $parent_appid = $this->session->userdata('inviteid_appid');
            if (isset($parent_id)) {
                $this->load->model('customer_mdl');
                $info =  $this->customer_mdl->load($user_id);
                if(!$info['change_parent']){//change_parent = 0
                    if(!$info['parent_id']){//parent_id = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $parent_id;
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $parent_appid;
                        if($this->session->userdata('inviteid_type') == 'code'){
                            $this->customer_mdl->change_parent = 1;
                        }
                        $this->customer_mdl->update($user_id);
                    }
                }else{//change_parent = 1
                    if(!$info['is_active']){//is_active = 0
                        $datetime = date ( 'Y-m-d H:i:s' );
                        $this->customer_mdl->parent_id = $parent_id;
                        $this->customer_mdl->parent_update_time = $datetime;
                        $this->customer_mdl->app_id = $parent_appid;
                        $this->customer_mdl->update($user_id);
                    }
                }
                 
            }
            
            $data['head_set'] = 2;
            $data['customer'] = $customer;
            $data['type'] = 'wechat';
            $data['type_show'] = "微信";
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('binding/binding_success', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
            } else {
                redirect('member/binding/binding_save/wechat/4');
            }
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
        
        imagepng($QR, 'uploads/userinfo/' . $userid . '.png');
        
        imagedestroy($QR);
    }
}