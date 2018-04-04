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
        
        $appid = $this->session->userdata('app_info')['wechat_appid']; // $appid = $third_info['appid'];//公众号在微信的appid
        $feedback_url = urlencode($this->session->userdata('app_info')['site_url'] . 'index.php/third_signin/wechat_callback');
        
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $feedback_url . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        
        header("Location:" . $url);
    }

    // ------------------------------------------------------------
    
    /**
     * 微信二维码扫码登录
     */
    public function wechat_code_login()
    {
        $session_id = $this->session->userdata('session_id');
        
        $appid = $this->session->userdata('app_info')['wechat_appid'];
        $feedback_url = urlencode($this->session->userdata('app_info')['site_url'] . 'index.php/third_signin/wechat_callback');

        $url = 'https://open.weixin.qq.com/connect/qrconnect?appid=' . $appid . '&redirect_uri=' . $feedback_url . '&response_type=code&scope=snsapi_login&state=' . $session_id . '#wechat_redirect';
        
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
        $appid = $this->session->userdata('app_info')['wechat_appid'];
        // $secret = $third_info['appsecret'];//公众号在微信的app secret
        $secret = $this->session->userdata('app_info')['wechat_appsecret'];
        $code = $_GET["code"];
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        
        /*
         * $ch = curl_init ();
         * curl_setopt ( $ch, CURLOPT_URL, $get_token_url );
         * curl_setopt ( $ch, CURLOPT_HEADER, 0 );
         * curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
         * curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
         * $res = curl_exec ( $ch );
         * curl_close ( $ch );
         */
        $res = file_get_contents($get_token_url);
        $json_obj = json_decode($res, true);
        
        // 根据openid和access_token查询用户信息
        $access_token = $json_obj['access_token'];
        
        $openid = $json_obj['openid'];
        $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $access_token . '&openid=' . $openid . '&lang=zh_CN';
        
        /*
         * $ch = curl_init ();
         * curl_setopt ( $ch, CURLOPT_URL, $get_user_info_url );
         * curl_setopt ( $ch, CURLOPT_HEADER, 0 );
         * curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
         * curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
         * $res = curl_exec ( $ch );
         * curl_close ( $ch );
         */
        $res = file_get_contents($get_user_info_url);
        
        error_log("res:" . $res);
        
        if ($res != NULL) {
            
            // 解析json
            $user_obj = json_decode($res, true);
            
            $this->load->model('customer_mdl');
            $customer_all = $this->customer_mdl->load_by_wechat($user_obj['openid']);
            
            // emoji表情截断
            $user_obj['nickname'] = preg_replace_callback('/./u', function (array $match) {
                return strlen($match[0]) >= 4 ? '^' : $match[0];
            }, $user_obj['nickname']);
            
            if (count($customer_all) === 0) {
                
                $this->customer_mdl->name = "wechat:" . $user_obj['openid'];
                $this->customer_mdl->password = '888888';
                $this->customer_mdl->sex = $user_obj['sex'];
                $this->customer_mdl->wechat_nickname = $user_obj['nickname'];
                $this->customer_mdl->wechat_avatar = $user_obj['headimgurl'];
                $this->customer_mdl->registry_by = "wechat";
                $this->customer_mdl->wechat_account = $user_obj['openid'];
                $this->customer_mdl->app_id = $this->session->userdata('app_info')['id'];
                $customer_id = $this->customer_mdl->create();
                
                error_log("customer_id:" . $customer_id . " " . $this->db->last_query());
                
                // 插入pay信息
                // $this->load->model('pay_account_mdl');
                // $this->load->model('pay_relation_mdl');
                // // 插入成功
                // if ($customer_id) {
                // $this->pay_account_mdl->name = "wechat:" . $user_obj['openid'];
                // $this->pay_account_mdl->passwd = "888888";
                // $pay_account_id = $this->pay_account_mdl->createpay_account();
                // if ($pay_account_id) {
                // $this->pay_relation_mdl->id_pay = $pay_account_id;
                // $this->pay_relation_mdl->customer_id = $customer_id;
                // $pay_relation_id = $this->pay_relation_mdl->createpay_relation();
                // }
                // }
                
                $customer = array(
                    'user_name' => "wechat:" . $user_obj['openid'],
                    'user_id' => $customer_id,
                    'nick_name' => $user_obj['nickname'],
                    'img_avatar' => $user_obj['headimgurl'],
                    'unionid' => $user_obj['unionid'],
                    'user_in' => TRUE
                );
                
                // 生成二维码图片
                $this->generateBarcode($customer_id);
            } else {
                $customer_id = $customer_all['id'];
                $this->customer_mdl->wechat_nickname = $user_obj['nickname'];
                $this->customer_mdl->wechat_avatar = $user_obj['headimgurl'];
                $this->customer_mdl->update($customer_all['id']);
                
                // mobile_exist 用于各个页面检查是否需要绑定手机
                $customer = array(
                    'user_name' => $customer_all['name'],
                    'user_id' => $customer_all['id'],
                    'nick_name' => $user_obj['nickname'],
                    'img_avatar' => $user_obj['headimgurl'],
                    'is_active' => $customer_all['is_active'],
                    'user_in' => TRUE,
                    'mobile_exist' => $customer_all['mobile'] != "" ? true : false
                );
            }
            
            $this->session->set_userdata($customer);
            
            $this->load->model('cart_mdl');
            $this->cart_mdl->reinit($customer_id);
            
            $return_url = $this->session->userdata('ref_from_url'); // 页面转跳
            $return_url2 = $this->session->userdata('redirect'); // 待废除 页面转跳
            
            if ($return_url) {
                header("Location:" . $return_url);
                $this->session->set_userdata('ref_from_url', '');
                return;
            } else 
                if ($return_url2) {
                    header("Location:" . $return_url2);
                    $this->session->set_userdata('redirect', '');
                    return;
                } else {
                    redirect('member/info');
                    return;
                }
        } else {
            echo "微信端返回错误！";
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
}