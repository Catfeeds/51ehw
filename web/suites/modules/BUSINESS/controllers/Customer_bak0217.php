<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends Front_Controller
{
    var $is_mobile;
        // ------------------------------------------------------------
    /**
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    // ------------------------------------------------------------
    
    /**
     */
    public function index()
    {
        // $this->load->view('customer/info');
        redirect(site_url('member/info'));
    }
    
    // ------------------------------------------------------------
    
    /**
     */
    public function login($err_msg = 0)
    {
        if ($this->session->userdata('user_in')) {
            redirect('member/info');
        }
        
        // 判断是否微信浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            header('Location: ' . site_url() . '/index.php/_BUSINESS/Third_signin/wechat');
        }
        $data['head_set'] = 6;
        $data['foot_set'] = 1;
        $data['title'] = '客户登录';
        if ($err_msg != 0) {
            switch ($err_msg) {
                default:
                    $data['err_msg'] = "用户名或密码错误";
            }
        } else {
            $data['err_msg'] = "";
        }
        
        $url = site_url('customer/login');
        $data['ip_address'] = $this->session->userdata('ip_address');
        $data['session_id'] = $this->session->userdata('session_id');
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/login', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    
    /**
     * 微信用户扫码，用户未注册
     * 进行手机号获取
     * 
     */
    public function loadmobile($err_msg = 0)
    {
        //防止后退
        if ($this->session->userdata('user_in')) {
            redirect('member/info');exit;
        }else if (!$this->session->userdata('openid')) {
            redirect('customer/login');exit;
        }
        

        $data['ip_address'] = $this->session->userdata('ip_address');
        $data['session_id'] = $this->session->userdata('session_id');
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/loadmobile', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
  
    /**
     * 微信用户扫码注册绑定微信保存数据库
     */
    public function save_mobile_wechat(){

        $mobile = $this->input->post('tbxBindingMobile');
        $password = $this->input->post('tbxLoginPassword');
        $mobile_vertify = $this->input->post('bingdingcode');
    
        $nick_name = $this->session->userdata('wechat_nickname');
        $wechat_avatar =  $this->session->userdata('wechat_avatar');
        $unionid = $this->session->userdata('unionid');
        $openid = $this->session->userdata('openid');
        
        //清空session
        $this->session->unset_userdata('wechat_nickname');
        $this->session->unset_userdata('wechat_avatar');
        $this->session->unset_userdata('unionid');
        $this->session->unset_userdata('openid');


        
        // 后台验证绑定手机验证码
        $mobile_vertify2 = $this->session->userdata('binding_mobile_verfity');
        $mobile2 = $this->session->userdata('binding_verfity_mobile');
        $set_time = $this->session->userdata('binding_mobile_verfity_settime');
        // 验证码超时验证
        if(date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
            echo "<script>history.back(-1);alert('手机验证码超时，请重新获取');</script>";
            return;
        }

        if ($mobile_vertify != $mobile_vertify2 || $mobile != $mobile2) {
            echo "<script>history.back(-1);alert('手机验证码填写错误');</script>";
            return;
        }

        $post['mobile'] = $mobile;
        $post['tbxRegisterPassword'] = $password;
        $post['nickname'] = $nick_name;
        $post['unionid'] = $unionid;
        $post['headimgurl'] = $wechat_avatar;
        $post['openid'] = $openid;
        $post['registry_by'] = "PC";
        $post['app_id'] = $this->session->userdata("app_info")["id"];
        $post['time'] = date("Y-m-d H:i:s");

        //接口--注册用户
        $url = $this->url_prefix.'Customer/save';
        $_customer = json_decode($this->curl_post_result($url,$post),true);
        if($_customer['status'] != 2){
            if($_customer['status']==1){//合并用户
                
                if($_customer['wechat_account']){//已经绑定
                    echo "<script>history.back(-1);alert('此手机已经被绑定');</script>";return;
                }else{//未绑定合并用户
                    //接口--绑定用户
                    $data['user_id'] = $_customer['id'];
                    $data['openid'] = $openid;
                    $data['unionid'] = $unionid;
                    $data['wechat_avatar'] = $wechat_avatar;
                    $data['wechat_nickname'] = $nick_name;
                    $url = $this->url_prefix.'Customer/info_save';
                    $is_binding = json_decode($this->curl_post_result($url,$data),true);
                    if(!$is_binding){//绑定失败
                        echo "绑定失败";exit;
                    }
                    
                    $_customer['customer_id'] = $_customer['id'];
                    //接口--支付账户
                    $url = $this->url_prefix.'Customer/fortune?customer_id='.$_customer['id'];
                    $pay_relation  =  json_decode($this->curl_get_result($url),true);
                    $_customer['pay_relation_id'] = $pay_relation['r_id'];
                }
                
 
            }
            
            $customer = array(
                'user_name' => $nick_name,
                'user_id' => $_customer['customer_id'],
                'user_in' => TRUE,
                'is_vip' => 0,
                'is_active' => 0,
                'user_last_login' => $post['time'],
                'corporation_id' => 0,
                'privilege_id' => 0,
                'openid' => $openid,
                'pay_relation' => $_customer['pay_relation_id']
            );
            
            //查询企业信息
            $this->load->model("corporation_mdl");
            $corpinfo = $this->corporation_mdl->load($_customer['customer_id']);
            if ($corpinfo != null) {
                $customer["corporation_status"] = $corpinfo["status"];
                $customer["approval_status"] = $corpinfo["approval_status"];
                $customer['corporation_id'] = $corpinfo['id'];
                $customer['privilege_id'] = $corpinfo['privilege_id'];
            }
            
            //更新购物车
            $this->load->model('cart_mdl');
            $this->cart_mdl->reinit($_customer['customer_id']);
            
            $this->session->set_userdata($customer);
            
            redirect('customer/regsuccess');
            

        }else{
            echo "<script>history.back(-1);alert('绑定失败');</script>";return;
        }
    }
    
    /**
     * 微信用户扫码注册绑定微信保存数据库成功跳转页面
     */
    public function regsuccess(){
        if (!$this->session->userdata('todowechat')) {
            redirect('customer/login');
        }
        
        $data['head_set'] = 6;
        $data['foot_set'] = 1;
        $data['title'] = '绑定成功';
       
        $this->session->set_userdata('todowechat',false);
        
        $url = site_url('customer/login');
        $data['ip_address'] = $this->session->userdata('ip_address');
        $data['session_id'] = $this->session->userdata('session_id');
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/regsuccess', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    // ------------------------------------------------------------

    // ------------------------------------------------------------
    
        /**
     * 生成二维码
     */
    public function generateBarcode($userid)
    {
        //判断传过来的id是否和我session相同
        if($userid != $this->session->userdata("user_id")){
            echo "<script>history.back(-1);</script>";exit;
        }
        
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
        
        imagepng($QR, './'.$filename);
        
        imagedestroy($QR);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 我的消息
     */
    public function mymessage()
    {
        $this->load->view('customer/mymessage');
    }
    
    // ------------------------------------------------------------
    
    /**
     * 验证名字是否已存在 ajax
     */
    function check_name()
    {
        $name = $this->input->get('tbxRegisterNickname');
        $this->load->model('customer_mdl');
        $msg = array(
            'Result' => true
        );
        if ($name) {
            if ($this->customer_mdl->check_name($name)) {
                $msg = array(
                    'Result' => false
                );
            }
        }
        echo json_encode($msg);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 验证手机是否已绑定 ajax
     */
    function check_mobile_binding_info()
    {
        $name = $this->input->get('mobile');
        $post['mobile'] = $name;
        
        $url = $this->url_prefix.'Customer/load_by_mobile';
        $_customer = json_decode($this->curl_post_result($url,$post),true);
       
        $msg = array(
            'Result' => true
        );
        if(count($_customer)>0){
            if ($_customer['wechat_account']) {
                $msg = array(
                    'Result' => false
                );
            }
        }
      
        echo json_encode($msg);
        
    }
    
    // ------------------------------------------------------------
    
    /**
     * 注册生成验证码
     */
    function yzm_img()
    {
        $this->load->helper('captcha');
        code();
    }
    
    // ------------------------------------------------------------
    
    /**
     * 检查注册验证码是否准确
     */
    function _check_yzm()
    {
        session_start();
        $Verifier = $this->input->get('tbxVerifier');
        if ($_SESSION['verify'] == $Verifier) {} else {
            $data["error"] = "验证码错误！";
            $this->load->view('customer/findPwd');
            exit();
        }
        return;
    }
    
    // ------------------------------------------------------------
    
    /**
     * ajax检查注册验证码是否准确,magtrue
     */
    function ajax_check_yzm()
    {
        $Verifier1 = $this->input->get('captcha');
        $Verifier2 = $_SESSION['verify'];
        
        if (strtolower($Verifier1) === $Verifier2) {
            $msg = array(
                'Result' => true
            );
        } else {
            $msg = array(
                'Result' => false
            );
        }
        
        echo json_encode($msg);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 验证邮箱是否已存在 ajax
     */
    function check_email()
    {
        $email = $this->input->get('tbxRegisterEmail');
        $this->load->model('customer_mdl');
        $msg = array(
            'Result' => true
        );
        if ($email) {
            if ($this->customer_mdl->check_email($email)) {
                $msg = array(
                    'Result' => false
                );
            }
        }
        
        echo json_encode($msg);
    }

    /**
     * 验证手机是否已存在 ajax
     */
    function check_mobile_phone()
    {
        $mobile = $this->input->get('mobile');
        $this->load->model('customer_mdl');
        $msg = array(
            'Result' => true
        );
        if ($mobile) {
            if ($arry =  $this->customer_mdl->check_mobile($mobile)) {
                $msg = array(
                    'Result' => false
                );
            }
        }
      
        echo json_encode($msg);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 保存注册信息
     */
    function save()
    {
        $this->load->model('customer_mdl');
        if (isset($_COOKIE['inviteid'])) {
            $this->customer_mdl->parent_id = $_COOKIE['inviteid'];
        }
        
        $name = $this->input->post('mobile');
        $mobile = $this->input->post('mobile');
        $nick_name = $this->input->post('Nickname');
        $password = $this->input->post('tbxRegisterPassword');
        $mobile_vertify = $this->input->post('mobile_vertify');
        $this->load->library('Validation');
        
        
        // 后台验证注册手机验证码
        $mobile_vertify2 = $this->session->userdata('mobile_verfity');
        $mobile2 = $this->session->userdata('mobile_verfity_mobile');
        if ($mobile_vertify != $mobile_vertify2 || $mobile != $mobile2) {
            echo "<script>alert('手机验证码填写错误');history.back(-1);</script>";
            exit();
        }
        
        if ($this->is_mobile > 0) {
            $this->set_mobile_save_form_rules();
        } else {
            $this->set_save_form_rules();
        }
        if (TRUE == $this->validation->run()) {
            //接口注册用户
            if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
                $_POST['registry_by'] = "H5";
            }else{
                $_POST['registry_by'] = "PC";
            }
            $_POST['app_id'] = $this->session->userdata("app_info")["id"];
            $_POST['time'] = date("Y-m-d H:i:s");
            $_POST['module'] = "C";
            $url = $this->url_prefix.'Customer/save';
            $user = json_decode($this->curl_post_result($url,$_POST),true);
            switch ($user['status']){
                case 1:
                    echo "用户已经存在";exit;
                    break;
                case 2:
                    echo "注册失败";exit;
                    break;
                case 3://注册成功
                    $customer_id = $user['customer_id'];
                    break;
            }
            
            // 如果微信登陆注册绑定手机
//             $user_id = $this->session->userdata('user_id');
//             if (! empty($user_id)) {
//                 // 读出新注册用户信息
//                 $customer2 = $this->customer_mdl->check_customer($customer_id);
                
//                 // 读出用户，将两个用户合并
//                 $customer = $this->customer_mdl->load($user_id);
//                 $this->customer_mdl->wechat_account = $customer['wechat_account'];
//                 $this->customer_mdl->nick_name = $customer['nick_name'];
//                 $this->customer_mdl->img_avatar = $customer['img_avatar'];
//                 if ($customer2['mobile'] == "") {
//                     $this->customer_mdl->mobile = $name;
//                 }
//                 $this->customer_mdl->update($customer2['id']);
//                 if ($customer['id'] != $customer2['id']) {
//                     $this->customer_mdl->delete($user_id);
//                 }
                
//                 // 重新更新登录信息
//                 $customer = array(
//                     'user_name' => $customer2['name'],
//                     'user_id' => $customer2['id'],
//                     'user_in' => TRUE,
//                     'is_vip' => $customer2['is_vip'],
//                     'is_active' => $customer2['is_active'],
//                     'user_last_login' => $customer2['last_login_at'],
//                     'corporation_id' => $customer2['corporation_id'],
//                     'privilege_id' => $customer2['privilege_id'],
//                     'openid' => $customer2['openid'],
//                     'pay_relation' => $pay_relation_id
//                 );
                
//                 if ($customer2['corporation_id'] > 0) {
                    
//                     $this->load->model('customer_corporation_mdl');
//                     $corpinfo = $this->customer_corporation_mdl->getById($customer2['corporation_id']);
                    
//                     if ($corpinfo != null) {
//                         $customer2["corporation_status"] = $corpinfo["status"];
//                     }
//                 }
                
//                 $this->session->set_userdata($customer);
//                 if ($this->session->userdata('ref_from_url') != '') {
//                     $url = $this->session->userdata('ref_from_url');
//                     header("Location:" . $url);
//                     $this->session->set_userdata('ref_from_url', '');
//                 } else {
//                     redirect('member/info');
//                 }
//                 exit();
//             }
            
            $customer = array(
                'user_name' => $nick_name ? $nick_name : $mobile,
                'user_id' => $customer_id,
                'is_vip' => 0,
                'promo_name' => $name,
                'user_last_login' => '',
                'user_in' => TRUE,
                'corporation_id' => 0,
                'privilege_id' => 0,
                'pay_relation' => $user['pay_relation_id']
            );
            $this->session->set_userdata($customer);


            // 生成二维码图片
            $this->generateBarcode($customer_id);

            $this->session->unset_userdata('mobile_verfity');
            if ($this->isMobile()) {
                redirect('Home');
            } else {    
                redirect('customer/save_step2');
            }

        } else {
                redirect('customer/registration');
        }
    }
    
    
    // --------------------------------------------------------------------
    function save_step2()
    {
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $this->load->model('region_mdl');
        $this->load->model('corporation_mdl');
        $data['provinces'] = $this->region_mdl->provinces();
        $corporation_id = $this->session->userdata['corporation_id'];
        $customer_id = $this->session->userdata['user_id'];
        if ($corporation_id > 0) {
            $data['dt'] = $this->corporation_mdl->load($customer_id);
        }
        
        $data['title'] = '客户注册 - 步骤2';
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/reg_step2', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    function save_2()
    {
        $customer_id = $this->session->userdata('user_id');
        $cor_id = $this->session->userdata['corporation_id'];
        
        $this->load->model('corporation_mdl', 'cp');
        $this->load->model('customer_mdl');
        // $cd = $this->input->post();
        
        $cor_name = $this->input->post('cor_name');
        $cor_address = $this->input->post('cor_address1') . ";" . $this->input->post('cor_address2');
        $address = $this->input->post('address');
        $postcode = $this->input->post('postcode');
        $email = $this->input->post('email');
        $contact_name = $this->input->post('contact_name');
        $contact_mobile = $this->input->post('contact_mobile');
        $province_id = $this->input->post('province_id');
        $city_id = $this->input->post('city_id');
        $district_id = $this->input->post('district_id');
        if ($customer_id != null) {
            if ($cor_name != null && $cor_address != null && $email != null && $contact_name != null && $contact_mobile != null && $province_id != null && $city_id != null && $district_id != null) {
                
                $this->cp->corporation_name = $cor_name;
                $this->cp->corporation_area = $cor_address;
                $this->cp->address = $address;
                $this->cp->postcode = $postcode;
                $this->cp->email = $email;
                $this->cp->province_id = $province_id;
                $this->cp->city_id = $city_id;
                $this->cp->district_id = $district_id;
                $this->cp->contact_name = $contact_name;
                $this->cp->contact_mobile = $contact_mobile;
                $this->cp->customer_id = $customer_id;
                $this->cp->app_id = $this->session->userdata("app_info")["id"];
                
                if (! empty($cor_id) && $cor_id != 0) {
                    $corporation = $this->cp->load($customer_id);
                }
               
                if ((empty($cor_id) && $cor_id == 0) || empty($corporation['id'])) {
                   
                    $corporation_id = $this->cp->create();
//                     $this->customer_mdl->corporation_id = $corporation_id;
//                     $this->customer_mdl->corporation_status = 0;
//                     $res = $this->customer_mdl->update($customer_id);
                    $this->session->set_userdata('corporation_id', $corporation_id);
                } else {
                    $this->cp->corporation_id = $corporation['id'];
                    $this->cp->update();
//                     $corporation_id = $corporation['id'];
//                     $this->customer_mdl->corporation_id = $corporation_id;
//                     $this->customer_mdl->corporation_status = 0;
//                     $res = $this->customer_mdl->update($customer_id);
                    $this->session->set_userdata('corporation_id', $corporation_id);
                }
                
                if ($corporation_id > 0) {
                    $this->session->set_userdata('corporation_id', $corporation_id);
                    redirect('customer/save_step3');
                } else {
                    redirect('customer/save_step2');
                }
            } else {
                redirect('customer/save_step2');
            }
        } else {
            redirect('customer/registration');
        }
    }
    
    // 上传营业图片
    function upload_charter()
    {
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $corporation_id = $this->session->userdata['corporation_id'];
            
            // error_log("customer_id:".$customer_id.' corporation_id:'.$corporation_id);
            
            $save_path = 'myshop/' . $corporation_id . '/new/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path)) {
                mkdirsByPath($path);
            }
            
            $config['file_name'] = 'charter' . '_' . $corporation_id . '_newcharter';
            $config['upload_path'] = $path;
            $p = $path . $config['file_name'] . '.jpg';
            if (file_exists($p)) {
                
                unlink($p);
            }
            
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            
            // $images = $this->session->userdata ( "busimage" );
            
            // if(count($images)==0){
            // $images = array ();
            // }
            if (! empty($_FILES)) {
                try {
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        $this->session->set_userdata("busimage", $images);
                        $this->session->set_userdata("busimage1");
                        $this->session->set_userdata("busimage2");
                        $this->session->set_userdata("busimage3");
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error($e);
        }
    }
    // 上传旧营业图片
    function upload_old()
    {
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $corporation_id = $this->session->userdata['corporation_id'];
            
            $save_path = 'myshop/' . $corporation_id . '/old/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path)) {
                mkdirsByPath($path);
            }
            $config['file_name'] = 'charter' . '_' . $corporation_id . '_old1charter';
            $config['upload_path'] = $path;
            
            $p = $path . $config['file_name'] . '.jpg';
            if (file_exists($p)) {
                
                unlink($p);
            }
            
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            
            if (! empty($_FILES)) {
                
                try {
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        
                        $this->session->set_userdata("busimage1", $images);
                        $this->session->set_userdata("busimage");
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error($e);
        }
    }

    function upload_old2()
    {
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $corporation_id = $this->session->userdata['corporation_id'];
            
            $save_path = 'myshop/' . $corporation_id . '/old/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path)) {
                mkdirsByPath($path);
            }
            $config['file_name'] = 'charter' . '_' . $corporation_id . '_old2charter';
            $config['upload_path'] = $path;
            
            $p = $path . $config['file_name'] . '.jpg';
            if (file_exists($p)) {
                
                unlink($p);
            }
            
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            
            if (! empty($_FILES)) {
                
                try {
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        
                        $this->session->set_userdata("busimage2", $images);
                        $this->session->set_userdata("busimage");
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error_log($e);
        }
    }

    function upload_old3()
    {
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $corporation_id = $this->session->userdata['corporation_id'];
            
            $save_path = 'myshop/' . $corporation_id . '/old/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path)) {
                mkdirsByPath($path);
            }
            $config['file_name'] = 'charter' . '_' . $corporation_id . '_old3charter';
            $config['upload_path'] = $path;
            
            $p = $path . $config['file_name'] . '.jpg';
            if (file_exists($p)) {
                
                unlink($p);
            }
            
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            
            if (! empty($_FILES)) {
                
                try {
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        
                        $this->session->set_userdata("busimage3", $images);
                        $this->session->set_userdata("busimage");
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error($e);
        }
    }
    // 身份证件照正
    function upload_idcard()
    {
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $corporation_id = $this->session->userdata['corporation_id'];
            
            $save_path = 'myshop/' . $corporation_id . '/idcard/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path)) {
                mkdirsByPath($path);
            }
            $config['file_name'] = 'idcard' . '_' . $corporation_id . '_idcard';
            $config['upload_path'] = $path;
            
            $p = $path . $config['file_name'] . '.jpg';
            if (file_exists($p)) {
                
                unlink($p);
            }
            
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            
            if (! empty($_FILES)) {
                
                try {
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        $this->session->set_userdata("idcardimage", $images);
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error($e);
        }
    }
    // 上传身份证反
    function upload_idcard_back()
    {
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $corporation_id = $this->session->userdata['corporation_id'];
            
            $save_path = 'myshop/' . $corporation_id . '/idcard/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            if (! file_exists($path)) {
                mkdirsByPath($path);
            }
            $config['file_name'] = 'idcard' . '_' . $corporation_id . 'idcardback';
            $config['upload_path'] = $path;
            
            $p = $path . $config['file_name'] . '.jpg';
            if (file_exists($p)) {
                
                unlink($p);
            }
            
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            
            if (! empty($_FILES)) {
                
                try {
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        $this->session->set_userdata("idcardbackimage", $images);
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error($e);
        }
    }

    function upload_wts()
    {
        try {
            
            $this->load->helper("ps_helper");
            
            $customer_id = $this->session->userdata('user_id');
            $corporation_id = $this->session->userdata['corporation_id'];
            
            $save_path = 'myshop/' . $corporation_id . '/wts/';
            $path = FCPATH .UPLOAD_PATH. "uploads/" . $save_path;
            
            $config['file_name'] = 'proexy' . '_' . $corporation_id . '_wts';
            $config['upload_path'] = $path;
            
            if (! file_exists($path)) {
                mkdirsByPath($path);
            }
            $p = $path . $config['file_name'] . '.jpg';
            if (file_exists($p)) {
                
                unlink($p);
            }
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2000';
            $config['max_filename'] = '50';
            $this->load->library('upload');
            
            if (! empty($_FILES)) {
                
                try {
                    $this->upload->initialize($config);
                    
                    if ($this->upload->do_upload('file')) {
                        
                        $uploaded = $this->upload->data();
                        
                        $images = "uploads/" . $save_path . $uploaded['file_name'];
                        
                        $this->session->set_userdata("proxy_img", $images);
                    } else {
                        error("上传文件失败，原因：" . $this->upload->display_errors('<p>', '</p>'));
                    }
                } catch (Exception $e) {
                    error($e);
                }
            }
        } catch (Exception $e) {
            error($e);
        }
    }

    function save_step3()
    {
        if (! $this->session->userdata('user_id')) {
            redirect('customer/login');
            exit();
        }
        
        $this->load->model('corporation_mdl');
        $this->load->model('corporation_detail_mdl', 'cd');
        // 企业性质
        $data['cor_type'] = $this->corporation_mdl->corporation_type();
        // 企业行业
        $data['cor_ind'] = $this->corporation_mdl->cor_ind_info();
        $corporation_id = $this->session->userdata['corporation_id'];
        $customer_id = $this->session->userdata['user_id'];
        
        if (isset($corporation_id) && $corporation_id > 0) {
            $data['detail'] = $this->corporation_mdl->load($customer_id);
            $data['dt'] = $this->cd->load($corporation_id);
        }
        
        $data['title'] = '企业注册 - 步骤3';
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/reg_step3', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    function check_poto()
    {
        $this->load->model('corporation_detail_mdl', 'cd');
        $corporation_id = $this->session->userdata['corporation_id'];
        
        if (isset($corporation_id) && $corporation_id > 0) {
            $data['dt'] = $this->cd->load($corporation_id);
        }
        
        $busimg = $this->session->userdata('busimage');
        $old1img = $this->session->userdata('busimage1');
        $old2img = $this->session->userdata('busimage2');
        $old3img = $this->session->userdata('busimage3');
        $idcard_img = $this->session->userdata('idcardimage');
        $idcardback_img = $this->session->userdata('idcardbackimage');
        $proxy_img = $this->session->userdata('proxy_img');
        
        if (empty($busimg) && empty($old1img) && empty($old2img) && empty($old3img)) {
            echo 1; // 未上传营业执照
        } elseif ((empty($busimg) && empty($old1img) && ! empty($old2img) && ! empty($old3img)) || (empty($busimg) && empty($old1img) && empty($old2img) && ! empty($old3img)) || (empty($busimg) && empty($old1img) && ! empty($old2img) && empty($old3img))) {
            echo 2; // 旧营业执照三张未上传齐 第一张
        } elseif ((empty($busimg) && ! empty($old1img) && empty($old2img) && empty($old3img)) || (empty($busimg) && ! empty($old1img) && empty($old2img) && ! empty($old3img))) {
            echo 3; // 旧营业执照三张未上传齐 第二张
        } elseif ((empty($busimg) && ! empty($old1img) && ! empty($old2img) && empty($old3img))) {
            echo 4; // 旧营业执照三张未上传齐 第三张
        } elseif (empty($idcard_img)) {
            echo 5; // 未上传正面身份证照
        } elseif (empty($idcardback_img)) {
            echo 6; // 未上传反面身份证照
        } elseif (empty($proxy_img)) {
            echo 7; // 全部上传成功，可以提交表单
        } else {
            echo 8; // 提交订单
        }
    }

    function save_3()
    {
        $this->load->model('corporation_detail_mdl', 'cd');
        $this->load->model('corporation_mdl');
        $this->load->model('customer_mdl');
        
        $busimg = $this->session->userdata('busimage');
        if ($busimg == '' && ($this->session->userdata('busimage1') || $this->session->userdata('busimage2') || $this->session->userdata('busimage2'))) {
            $busimg = $this->session->userdata('busimage1') . ';' . $this->session->userdata('busimage2') . ';' . $this->session->userdata('busimage3');
        }
        if ($this->session->userdata('idcardimage') && $this->session->userdata('idcardbackimage')) {
            $idcard_img = $this->session->userdata('idcardimage') . ';' . $this->session->userdata('idcardbackimage');
        } elseif ($this->session->userdata('idcardimage')) {
            $idcard_img = $this->session->userdata('idcardimage');
        } else {
            $idcard_img = ';' . $this->session->userdata('idcardbackimage');
        }
        $proxy_img = $this->session->userdata('proxy_img');
        $Industrial_Info = $this->input->post('Industrial_Info');
        $nature = $this->input->post('nature');
        $legal_person = $this->input->post('legal_person');
        $idcard = $this->input->post('idcard');
        $user_id = $this->session->userdata('user_id');
        $_corporation_id = $this->session->userdata('corporation_id');
        
        $this->load->model('corporation_detail_mdl', 'cd');
        $this->load->model('corporation_mdl');
        if ($user_id) {
            
            $corporation = $this->corporation_mdl->load($user_id);
            $corporation_id = $corporation['id'];
            
            if ($corporation_id != $_corporation_id) {
                $this->customer_mdl->corporation_id = $corporation_id;
                $this->customer_mdl->corporation_status = 1;
                $this->customer_mdl->update($user_id);
                $this->session->set_userdata("corporation_id", $corporation_id);
            }
            
            if ($proxy_img != null && $proxy_img != null && $Industrial_Info != null && $nature != null && $legal_person != null && $idcard != null) {
                
                if (isset($corporation_id) && $corporation_id > 0) {
                    $data['dt'] = $this->cd->load($corporation_id);
                }
                
                if (isset($data['dt']['corporation_id']) && $data['dt']['corporation_id'] != '') {
                    $company_registration = $this->input->post('company_registration');
                    if ($busimg != '' && $busimg != '') {
                        $this->cd->bus_licence_img = $busimg;
                    }
                    if ($idcard_img != '' && $idcard_img != '') {
                        $this->cd->idcard_img = $idcard_img;
                    }
                    if ($proxy_img != '') {
                        $this->cd->proxy_img = $proxy_img;
                    }
                    $this->cd->corporation_id = $corporation_id;
                    $this->cd->Industrial_Info = $Industrial_Info;
                    $this->cd->nature = $nature;
                    $this->cd->legal_person = $legal_person;
                    $this->cd->idcard = $idcard;
                    $this->cd->company_registration = $company_registration;
                    
                    $res = $this->cd->update();
                    
                    if ($res) {
                        
                        $this->session->set_userdata("busimage");
                        $this->session->set_userdata("busimage1");
                        $this->session->set_userdata("busimage2");
                        $this->session->set_userdata("busimage3");
                        $this->session->set_userdata("idcardbackimage");
                        $this->session->set_userdata("idcardimage");
                        $this->session->set_userdata("proxy_img");
                        
                        $this->corporation_mdl->approval_status = 1;
                        $this->corporation_mdl->corporation_id = $corporation_id;
                        $result = $this->corporation_mdl->update();
                        
                        if ($result) {
                            redirect('customer/is_authenticate');
                        }
                    } else {
                        redirect('customer/save_step3');
                    }
                } else {
                    // 验证是否有上传文件
                    $company_registration = $this->input->post('company_registration');
                    
                    $this->cd->proxy_img = $proxy_img;
                    $this->cd->corporation_id = $corporation_id;
                    $this->cd->idcard_img = $idcard_img;
                    $this->cd->bus_licence_img = $busimg;
                    
                    $this->cd->Industrial_Info = $Industrial_Info;
                    $this->cd->nature = $nature;
                    $this->cd->legal_person = $legal_person;
                    $this->cd->idcard = $idcard;
                    $this->cd->company_registration = $company_registration;
                    
                    $res = $this->cd->create();
                    
                    if ($res) {
                        
                        $this->session->set_userdata("busimage");
                        $this->session->set_userdata("busimage1");
                        $this->session->set_userdata("busimage2");
                        $this->session->set_userdata("busimage3");
                        $this->session->set_userdata("idcardbackimage");
                        $this->session->set_userdata("idcardimage");
                        $this->session->set_userdata("proxy_img");
                        
                        $this->corporation_mdl->approval_status = 1;
                        $this->corporation_mdl->corporation_id = $corporation_id;
                        $result = $this->corporation_mdl->update();
                        if ($result) {
                            redirect('customer/is_authenticate');
                        }
                    } else {
                        redirect('customer/save_step3');
                    }
                }
            } else {
                redirect('customer/save_step2');
            }
        } else {
            redirect('customer/login');
        }
    }

    function is_authenticate()
    {
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('redirect', current_url());
            redirect('customer/login');
            exit();
        }
        
        $this->load->model('corporation_mdl', 'cd');
        $corporation_id = $this->session->userdata['corporation_id'];
        
        if ($corporation_id > 0) {
            $data['dt'] = $this->cd->load_id($corporation_id);
        }

        if ((empty($corporation_id) && $corporation_id <= 0) || empty($data['dt'])) {
            redirect('customer/save_step2');    // 未注册企业帐号或者后台删除
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && ($data['dt']['status'] == 0) && ($data['dt']['approval_status'] == null || $data['dt']['approval_status'] == 0)) {
            redirect('customer/save_step3');    // 未绑定
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && ($data['dt']['status'] == 0) && $data['dt']['approval_status'] == 1) {
            redirect('customer/reg_succ');      // 申核中
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && ($data['dt']['status'] == 0) && $data['dt']['approval_status'] == 3) {
            redirect('customer/reg_error');     // 申核失败
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && $data['dt']['status'] == 2) {
            redirect('customer/reg_error');     // 企业冻结
        } else {
            $this->session->set_userdata('corporation_status',$data['dt']['status']);
            redirect('corporate/info');
        }
    }

    function reg_succ()
    {
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $data['title'] = '注册成功，等待验证';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/reg_step_succ', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    function reg_error()
    {
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        
        $this->load->model('corporation_mdl', 'cd');
        $corporation_id = $this->session->userdata['corporation_id'];
        
        if ($corporation_id > 0) {
            $data['dt'] = $this->cd->load_id($corporation_id);
        }
        $data['message'] = $data['dt']['approval_desc'];
        $data['title'] = '认证失败，重新填写资料';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/reg_step_succ2', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 注册验证规则
     */
    function set_save_form_rules()
    {
        // $rules['tbxRegisterNickname'] = 'required|min_length[4]|max_length[20]|alpha_dash';
        $rules['tbxRegisterPassword'] = 'required|min_length[6]|max_length[16]|alpha_dash';
        $rules['mobile'] = 'required|is_numeric|min_length[11]|max_length[11]';
        $this->validation->set_rules($rules);
    }

    /**
     * 注册验证规则
     */
    function set_mobile_save_form_rules()
    {
        $rules['mobile'] = 'required|min_length[11]|max_length[11]';
        $rules['tbxRegisterPassword'] = 'required|min_length[6]|max_length[16]';
        // $rules ['tbxRegisterRepeatPassword'] = 'required|min_length[6]|max_length[16]';
        /*
         * $this->validation->set_rules('tbxRegisterNickname','Username','required|min_length[11]|max_length[11]');
         * $this->validation->set_rules('tbxRegisterPassword','Password', 'required|min_length[6]|max_length[16]');
         */
        $this->validation->set_rules($rules);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 登出
     */
    function logout()
    {
        $this->session->sess_destroy();
        redirect('home');
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 登录
     */
    function check_customer()
    {
        $post['tbxLoginNickname'] = $this->input->post('tbxLoginNickname');
        $post['tbxLoginPassword'] = $this->input->post('tbxLoginPassword');
        

        //接口获取用户信息
        $url = $this->url_prefix.'Customer/check_customer';
        $_customer = json_decode($this->curl_post_result($url,$post),true);
        if (isset($_customer['password']) && $_customer['password'] == md5($post['tbxLoginPassword'])) {
            
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


            $this->session->set_userdata($customer);
            
            $this->load->model('cart_mdl');
            $this->cart_mdl->reinit($_customer['id']);
            $redir = $this->session->userdata('redirect');
            $redir_to = $this->session->userdata('ref_from_url');
            
            if (! empty($redir_to)) {
                $this->session->unset_userdata('ref_from_url');
                redirect($redir_to);
                exit();
            }
            if (! empty($redir)) {
                $this->session->unset_userdata('redirect');
                redirect($redir);
                exit();
            }
            redirect('member/info');
        } else {
            redirect('customer/login/1');
        }
    }
    
    
    // ------------------------------------------------------------
    
    /**
     *
     * @param number $id            
     */
    public function registration($id = 0, $stauts = null)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            $data['title'] = '客户注册';
            $data['head_set'] = 2;
            $data['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('customer/register', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        } else {
            redirect('Home');
        }
    }
    
    // --------------------------------------------------------------------
    
    /**
     */
    public function info()
    {
        $this->load->model('customer_mdl');
        
        $data['info'] = array(); // = $this->customer_mdl->load($this->session->get_userdata('user_id'));
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/info', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 客户列表
     *
     * @param number $level            
     * @param number $fid            
     */
    public function customerdata($level = 0, $fid = 0)
    {
        // 判断用户是否登录
        if (! $this->session->userdata('user_id')) {
            $this->session->set_userdata('redirect','customer/customerdata');
            redirect('customer/login');
            exit();
        }
        if ($level < 0 || $level > 5) {
            $this->showMessage("找不到所需页面！", site_url('customer/customerdata'), true, true);
        } else {
            if ($level > 0 && $fid == 0) {
                $this->showMessage("参数错误！", site_url('customer/customerdata'), true, true);
            } else {
                if ($level == 0) {
                    $fid = $this->session->userdata('user_id');
                }
                
                $this->load->model('customer_mdl');
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
                $data["result"] = $this->customer_mdl->getChildList($level, $fid, $condition, $like, "M");
                
                $total_price = 0;
                
                foreach ($data["result"] as $result) {
                    $total_price += $result['total_price'];
                }
                $data["total_price"] = $total_price;
                
                // 年显示
                
                $data["result_y"] = $this->customer_mdl->getChildList($level, $fid, $condition, $like);
                
                $total_price_y = 0;
                
                foreach ($data["result_y"] as $result) {
                    $total_price_y += $result['total_price'];
                }
                $data["total_price_y"] = $total_price_y;
            }
        }
        $data['title'] = "我的家族";
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/customer', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    /**
     *
     * @param number $level            
     * @param unknown $id            
     */
    public function customerDataDetail($level = 0, $id)
    {
        if ($id) {
            $this->load->model('customer_mdl');
            // 判斷用戶是否可以查詢
            if ($this->checkUser($level, $id)) {
                $this->load->model("order_mdl");
                $data["period"] = $this->input->get_post('period');
                $data["status"] = $this->input->get_post('status');
                $data["page"] = $this->input->get_post('page');
                $data["pagesize"] = 5;
                $data["id"] = $id;
                $data["level"] = $level;
                if (! $data["page"]) {
                    $data["page"] = 1;
                }
                
                // 查詢用戶數據
                $data['user'] = $this->customer_mdl->load($id);
                $data['user']['childcount'] = $this->customer_mdl->countChild($id);
                $data['user']['salecount'] = $this->order_mdl->count_orders($id);
                
                // 查詢用戶消費數據
                $data["saledata"] = $this->customer_mdl->getCustomerSaleData($id, array(), false);
                $data["saledata_month"] = $this->customer_mdl->getCustomerSaleData($id, array(
                    "place_at >=" => strtotime("-30 day")
                ), false);
                $data["childdata"] = $this->customer_mdl->getCustomerSaleData($id, array(), true);
                $data["childdata_month"] = $this->customer_mdl->getCustomerSaleData($id, array(
                    "place_at >=" => strtotime("-30 day")
                ), true);
                
                // 单订信息
                $condition = array();
                if ($data["period"]) {
                    $condition = array(
                        "place_at>=",
                        strtotime("-30 day")
                    );
                }
                if ($data["status"]) {
                    $condition = array(
                        "status",
                        $data["status"]
                    );
                }
                
                // echo $data["page"];
                $data["order"] = $this->order_mdl->get_customer_orders($id, "order_sn,place_at,b.product_id,c.name,quantity,b.price,a.status,a.id,a.total_product_price,c.goods_thumb", $condition, $data["pagesize"], ($data["page"] - 1) * $data["pagesize"]);
                
                $pagecondition = "?period=" . $data["period"] . "&status=" . $data["status"];
                $this->load->library('pagination');
                $config['base_url'] = site_url('goods/vip/');
                $config['suffix'] = $pagecondition;
                $config['total_rows'] = $this->order_mdl->count_orders($id, $condition);
                $config['per_page'] = $data["pagesize"];
                $config['curr_page'] = $data["page"];
                $config['num_links'] = 10;
                $config['full_tag_open'] = '';
                $config['full_tag_close'] = '';
                $config['num_tag_open'] = '';
                $config['num_tag_close'] = '';
                $config['first_link'] = FALSE;
                $config['last_link'] = FALSE;
                $config['next_link'] = '下一页';
                $config['next_tag_css'] = 'class="next"';
                $config['next_tag_open'] = '';
                $config['next_tag_close'] = '';
                $config['prev_link'] = '上一页';
                $config['prev_tag_css'] = 'class="prev"';
                $config['prev_tag_open'] = '';
                $config['prev_tag_close'] = '';
                // $config['cur_tag_css'] = 'class="current"';
                $config['cur_tag_open'] = '<a href="javascript:" class="ui-paging-current">';
                $config['cur_tag_close'] = '</a>';
                $this->pagination->initialize($config);
                $data['pagination'] = $this->pagination->create_links();
                $data['head_set'] = 3;
                $data['title'] = "我的家族";
                $data['foot_set'] = 1;
                $this->load->view('head', $data);
                $this->load->view('_header', $data);
                $this->load->view('customer/datadetails', $data);
                $this->load->view('_footer', $data);
                $this->load->view('foot', $data);
            } else {
                $this->showMessage("参数错误！", site_url('customer/customerdata'), true, true);
            }
        } else {
            $this->showMessage("参数错误！", site_url('customer/customerdata'), true, true);
        }
    }
    
    // --------------------------------------------------------------------
    /**
     *
     * @param unknown $level            
     * @param unknown $id            
     * @return boolean
     */
    public function checkUser($level, $id)
    {
        return true;
    }
    

    
    // --------------------------------------------------------------------
    
    /**
     *
     * @param string $msg            
     */
    public function forgot($msg = "")
    {
        $data["error"] = $msg;
        $this->load->view('customer/findPwd', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     */
    public function getPW()
    {
        $this->_check_yzm();
        $this->load->model('customer_mdl');
        $username = $this->input->post("username");
        $email = $this->input->post("email");
        $data["error"] = "";
        
        if ($username && $email) {
            $email = trim($email);
            $password = rand(100000, 999999);
            $condition = array(
                "name" => $username,
                "email" => $email,
                "is_active" => "0"
            );
            $user = $this->customer_mdl->get_by_condition($condition);
            if ($user) {
                $c = $this->customer_mdl->update_pwd($user["id"], $password);
                if ($c > 0) {
                    $this->load->library('email');
                    
                    $this->email->from('2190311733@qq.com', 'Administrator');
                    $this->email->to($user["email"]);
                    
                    $this->email->subject('重置密码邮件（请勿回复此邮件）');
                    // $this->email->header("Content-type:text/html; charset=utf-8");
                    $this->email->message('尊敬的' . $this->session->userdata('app_info')['app_name'] . '客户：<br/> ' . $username . '，您好！<br/> 您的密码已被重置，您的新密码是：' . $password . '<br/> 温馨提示：<br/> 1、如果您想修改您的安全邮箱，请登录账号管理里面的【个人资料】进行修改。<br/> 2、本邮件为系统自动发出，请勿回复。<br/> =============================================================== <br/> ' . $this->session->userdata('app_info')['app_name'] . '<br/> 敬启');
                    
                    try {
                        $this->email->send();
                    } catch (Exception $e) {
                        echo $e;
                    }
                    
                    $data["error"] = "密码已重置成功,请查收EMAIL!";
                    $data['head_set'] = 3;
                    $data['foot_set'] = 1;
                    $this->load->view('head', $data);
                    $this->load->view('_header', $data);
                    $this->load->view('customer/findPwd', $data);
                    $this->load->view('_footer', $data);
                    $this->load->view('foot', $data);
                }
            } else {
                $data["error"] = "会员名或电子邮件错误！";
                $data['head_set'] = 3;
                $data['foot_set'] = 1;
                $this->load->view('head', $data);
                $this->load->view('_header', $data);
                $this->load->view('customer/findPwd', $data);
                $this->load->view('_footer', $data);
                $this->load->view('foot', $data);
            }
        } else {
            $data["error"] = "数据缺失错误！";
            $data['head_set'] = 3;
            $data['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('customer/findPwd', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
    }
    
    // --------------------------------------------------------------------
    /**
     */
    public function address()
    {
        $data = array();
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/address');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     */
    public function complaints()
    {
        $data = array();
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/complaints');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 邀请朋友
     */
    public function invite()
    {
        $user_id = $this->session->userdata('user_id');
        if (! $user_id)
            redirect('customer/login');
        
        //获取用户资料
        $this->load->model("customer_mdl");
        $customer = $this->customer_mdl->load($user_id);
        
        $data['year']=(int)substr($customer["registry_at"],0,4);
        $data['month']=(int)substr($customer["registry_at"],5,2);
        $data['day']=(int)substr($customer["registry_at"],8,2);
            
        $data['title'] = "我的二维码";
        $data['back'] = 'member/info';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/invite');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 安全设置
     */
    public function safety_setting()
    {
        // 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist")) {
            $user_id = $this->session->userdata("user_id");
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($user_id);
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        
        $data['title'] = '安全设置';
        $data['back'] = 'member/info';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/safety_setting');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // --------------------------------------------------------------------
    
    /**
     * 提成
     */
    public function rebate()
    {
        $userid = $this->session->userdata('user_id');
        if ($userid) {
            $this->load->model("order_mdl");
            $this->load->model("balance_mdl");
            
            $totallist = $this->order_mdl->get_cutomer_rebate_list(array(
                "agentid" => $userid
            ));
            $hadpay = $this->balance_mdl->getBalanceByCustomer($userid);
            $waitingpay = $this->balance_mdl->getBalanceByCustomerForNoPay($userid);
            
            $data["totalcount"] = 0;
            if ($totallist && count($totallist) > 0) {
                $data["totalcount"] = $totallist[0]["rebate_1"];
            }
            
            if ($hadpay != 0) {
                $data["hadpay"] = $hadpay["balancetotal"] == null ? 0 : $hadpay["balancetotal"];
            } else {
                $data["hadpay"] = 0;
            }
            
            if ($waitingpay != 0) {
                $data["waitingpay"] = $waitingpay["balancetotal"] == null ? 0 : $waitingpay["balancetotal"];
            } else {
                $data["waitingpay"] = 0;
            }
            
            $data["nopay"] = $data["totalcount"] - $data["hadpay"] - $data["waitingpay"];
            
            $data['head_set'] = 3;
            $data['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('customer/rebate', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        } else {
            redirect('customer/login');
        }
    }
    
    // ------------------------------------------------------------
    
    /**
     */
    public function rebate_do()
    {
        $data['customerid'] = $this->session->userdata('user_id');
        if ($data['customerid']) {
            $data['balancetotal'] = urlencode($this->input->post('total'));
            $data['bankname'] = urlencode($this->input->post('bankname'));
            $data['banksubname'] = urlencode($this->input->post('banksubname'));
            $data['bankaccount'] = urlencode($this->input->post('bankaccount'));
            $data['realname'] = urlencode($this->input->post('realname'));
            
            // $data["create_time"] = time();
            $this->load->model("balance_mdl");
            $this->load->model("order_mdl");
            
            $totallist = $this->order_mdl->getCutomerRebateList(array(
                "agentid" => $data['customerid']
            ));
            $hadpay = $this->balance_mdl->getBalanceByCustomer($data['customerid']);
            
            $waitingpay = $this->balance_mdl->getBalanceByCustomerForNoPay($data['customerid']);
            
            $totalcount = 0;
            if ($totallist && count($totallist) > 0) {
                $totalcount = $totallist[0]["rebate_1"];
            }
            
            if ($hadpay != 0) {
                $hadpay = $hadpay["balancetotal"] == null ? 0 : $hadpay["balancetotal"];
            } else {
                $hadpay = 0;
            }
            
            if ($waitingpay != 0) {
                $waitingpay = $waitingpay["balancetotal"] == null ? 0 : $waitingpay["balancetotal"];
            } else {
                $waitingpay = 0;
            }
            
            if ($totalcount - $hadpay - $waitingpay > 0 && $totalcount - $hadpay - $waitingpay > $data['balancetotal']) {
                $id = $this->balance_mdl->create($data);
                if ($id) {
                    $data["totalcount"] = $totalcount;
                    $data["hadpay"] = $hadpay;
                    $data["nopay"] = $totalcount - $hadpay - $waitingpay;
                    $data["message"] = "结算申请成功";
                    $data["result"] = true;
                    $data["waitingpay"] = $waitingpay;
                } else {
                    $data["message"] = "结算申请失败";
                    $data["result"] = false;
                    $data["totalcount"] = $totalcount;
                    $data["hadpay"] = $hadpay;
                    $data["nopay"] = $totalcount - $hadpay - $waitingpay;
                    $data["waitingpay"] = $waitingpay;
                }
            } else {
                $data["message"] = "不需要结算或结算金额太多！";
                $data["result"] = false;
                $data["totalcount"] = $totalcount;
                $data["hadpay"] = $hadpay;
                $data["nopay"] = $totalcount - $hadpay - $waitingpay;
                $data["waitingpay"] = $waitingpay;
            }
        }
        
        $this->load->view('customer/rebate', $data);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 财富页
     */
    public function fortune()
    {
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
       
        $account_id = $this->session->userdata('user_id');
        $relation_id = $this->session->userdata( 'pay_relation' );
        $data['customerid'] = $account_id;
       
        // 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist")) {
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        
        $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
        $result = $this->curl_get_result($url);
        $data['customer'] = json_decode($result,true);
        
        
        $data['title'] = '我的资产';
        $data['back'] = 'member/info';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/my_money', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    // ------------------------------------------------------------
    
    /**
     */
    public function faq()
    {
        $data = array();
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/faq');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // ------------------------------------------------------------
    
    /**
     * app注册页面 － 废除待删
     *
     * @param number $id            
     */
    public function appregist($id = 0)
    {
        redirect("customer/registration/$id");
    }
    
    // ------------------------------------------------------------
    
    /**
     * 发送验证码
     */
    public function ajax_send($status = 0)
    {
        $mobile = $this->input->post('mobile');
        // $this->load->library('ninthLeaf_Mobile_Message', '', 'message');
        // 读取工厂
        $this->load->library('sms/Short_Message_Factory', '', 'message');
        $num = $this->message->random(6);
        $date = date('Y-m-d H:i:s');
        //密钥
        $key = md5($mobile.$num);
        $this->session->set_userdata('key',$key);
        // 读取默认短信提供商
        $this->load->model('sms_supplier_mdl');
        $supplier = $this->sms_supplier_mdl->get_in_use();
        $sms = $this->message->get_message($supplier);
        
        $this->load->model('shortmsg_log_mdl');
        
        switch ($status) {
            case 1:
                $this->session->set_userdata('password_mobile_verfity', $num);
                $this->session->set_userdata('password_verfity_mobile', $mobile);
                $this->session->set_userdata('password_mobile_verfity_settime', $date);
                $content = '修改密码短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 2:
                $this->session->set_userdata('paypassword_mobile_verfity', $num);
                $this->session->set_userdata('paypassword_verfity_mobile', $mobile);
                $this->session->set_userdata('paypassword_mobile_verfity_settime', $date);
                $content = '设置支付密码短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 3:
                $this->session->set_userdata('binding_mobile_verfity', $num);
                $this->session->set_userdata('binding_verfity_mobile', $mobile);
                $this->session->set_userdata('binding_mobile_verfity_settime', $date);
                $content = '验证绑定手机短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 4:
                $this->session->set_userdata('changemobile_mobile_verfity', $num);
                $this->session->set_userdata('changemobile_verfity_mobile', $mobile);
                $this->session->set_userdata('changemobile_mobile_verfity_settime', $date);
                $this->session->set_userdata('checkmobile', $mobile);
                $content = '绑定手机短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 5:
                $this->session->set_userdata('bindingwechat_mobile_verfity', $num);
                $this->session->set_userdata('bindingwechat_verfity_mobile', $mobile);
                $this->session->set_userdata('bindingwechat_mobile_verfity_settime', $date);
                $content = '绑定微信短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 6:
                $this->session->set_userdata('unbundlingwechat_mobile_verfity', $num);
                $this->session->set_userdata('unbundlingwechat_verfity_mobile', $mobile);
                $this->session->set_userdata('unbundlingwechat_mobile_verfity_settime', $date);
                $content = '解绑微信短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            default:
                $this->session->set_userdata('mobile_verfity', $num);
                $this->session->set_userdata('mobile_verfity_mobile', $mobile);
                $this->session->set_userdata('mobile_verfity_settime', $date);
                $content = '动态登录验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
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
        echo $return_msg;
    }

    /**
     * 验证手机验证码.msg true
     */
    public function check_mobile($status = 0)
    {
        $vertify1 = $this->input->get('mobile_vertify');
        switch ($status) {
            case 1:
                $vertify2 = $this->session->userdata('password_mobile_verfity');
                break;
            case 2:
                $vertify2 = $this->session->userdata('paypassword_mobile_verfity');
                break;
            case 3:
                $vertify2 = $this->session->userdata('binding_mobile_verfity');
                break;
            case 4:
                $vertify2 = $this->session->userdata('changemobile_mobile_verfity');
                break;
            case 5:
                $vertify2 = $this->session->userdata('bindingwechat_mobile_verfity');
                break;
            case 6:
                $vertify2 = $this->session->userdata('unbundlingwechat_mobile_verfity');
                break;
            default:
                $vertify2 = $this->session->userdata('mobile_verfity');
                break;
        }
        
        if ((string) $vertify1 === (string) $vertify2) {
            $msg = array(
                'Result' => true
            );
        } else {
            $msg = array(
                'Result' => false
            );
        }
        echo json_encode($msg);
    }

    
    
    

    /**
     * 找回密码
     */
    public function forget_password()
    {
        $data['title'] = '找回密码！';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/forget_password1', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    public function forget_password2()
    {
        $this->session->unset_userdata('key');//清空key
        
        if ($this->session->userdata('forget') == 1) {
            $name = $this->input->get('name');
            $mobile_vertify = $this->input->get('mobile_vertify');
            $mobile_verfity = $this->session->userdata('password_mobile_verfity');
            $this->session->unset_userdata('password_mobile_verfity');
            
            // 验证用户与手机
            $this->load->model('customer_mdl');
            $cus = $this->customer_mdl->load_by_mobile($name);
            if ($cus != null) {
                if ($name != null && $mobile_vertify != null && $mobile_vertify == $mobile_verfity) {
                    //加密
                    $key = md5($name.$mobile_verfity);
                    $this->session->set_userdata('key',$key);
                    
                    $data['mobile_verfity'] = $mobile_verfity;
                    $data['title'] = '找回密码！';
                    $data['name'] = $name;
                    $data['head_set'] = 2;
                    $this->load->view('head', $data);
                    $this->load->view('_header', $data);
                    $this->load->view('customer/forget_password2', $data);
                    $this->load->view('_footer', $data);
                    $this->load->view('foot', $data);
                } else {
                    show_404();
                    /*
                     * $data['type'] = true;
                     * $data['auto'] = true;
                     * $data['msg'] = '非法操作！';
                     * $data['goto'] = site_url('customer/login');
                     * return $this->load->view('message',$data);
                     */
                }
            } else {
                show_404();
            }
        } else {
            redirect('customer/forget_password');
        }
    }

    public function update_password()
    {
        $key = $this->session->userdata("key");//密钥
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $ConfirmPassword = $this->input->post('ConfirmPassword');
//      $verfity = $this->session->userdata("password_mobile_verfity");

        if (!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){
            $mobile_verfity = $this->input->post("mobile_verfity");
        }else{
           $mobile_verfity = $this->input->post("mobile_vertify");
        }
     
        // 验证用户与手机
        $this->load->model('customer_mdl');
        $customer = $this->customer_mdl->load_by_mobile($name);

        // 判断条件是否满足
        if ($key==md5($name.$mobile_verfity) && $customer && $name != null && $password != null && $ConfirmPassword != null && $ConfirmPassword == $password && $mobile_verfity) {
            
            //接口修改密码
            $post['customer_id'] = $customer['id'];
            $post['password'] = $password;
            $url = $this->url_prefix.'Customer/update_pwd';
            $row = json_decode($this->curl_post_result($url,$post),true);
            
            if ($row['status']) {
                redirect('customer/forget_password3');
            } else {
                if (!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){
                }else{
                    $data['head_set'] = 2;
                }
                $data['type'] = true;
                $data['auto'] = true;
                $data['msg'] = '修改密码失败!';
                $data['goto'] = site_url('customer/login');
                return $this->load->view('message', $data);
            }
            
        } else {
            show_404();
        }

    }

    public function forget_password3()
    {
        $data['title'] = '找回密码！';
        $data['head_set'] = 2;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/forget_password3', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    public function check_name_mobile()
    {
        $name = $this->input->get('name');
        $mobile = $this->input->get('mobile');
        
        $this->load->model('customer_mdl');
        $cus = $this->customer_mdl->load_by_name($name);
        if ($cus['mobile'] === $mobile || $cus['phone'] === $mobile || $cus['name'] === $mobile) {
            $msg = array(
                'Result' => true
            );
        } else {
            $msg = array(
                'Result' => false
            );
        }
        
        echo json_encode($msg);
    }

    public function load_mobile()
    {
        $name = $this->input->get('mobile');
        
        $this->load->model('customer_mdl');
        $cus = $this->customer_mdl->load_by_mobile($name);
        if ($cus != null) {
            $msg = array(
                'mobile' => $cus['mobile']
            );
            echo json_encode($msg);
        } else
            echo null;
    }

    public function unset_session()
    {
        $this->session->set_forgot('forget');
    }

    public function app()
    {
        $this->load->model("app_info_mdl");
        $app_info = $this->app_info_mdl->getAll("", - 1, "", "", true);
        if (count($app_info) > 0) {
            foreach ($app_info as $key => $v) {
                $customer["app"][$key]["id"] = $v["id"];
                $customer["app"][$key]["app_name"] = $v["app_name"];
                $customer["app"][$key]["site_url"] = $v["site_url"];
                $customer["app"][$key]["region"] = $v["region_name"];
                $customer["app"][$key]["region_id"] = $v["region_id"];
                $customer["app"][$key]["letter"] = $v["letter"] ? $v["letter"] : "#";
            }
        }
        $this->session->set_userdata($customer);
    }

    public function search_app()
    {
        $city = $this->input->get('cityName');
        $this->load->model("app_info_mdl");
        $app_info = $this->app_info_mdl->search_situs($city);
        $data["success"] = false;
        if (count($app_info) > 0) {
            $data["success"] = true;
            foreach ($app_info as $key => $v) {
                $data['app']["site_url"] = $v["site_url"];
                $data['app']["app_name"] = $v["app_name"];
            }
        }
        echo json_encode($data);
    }
    
    /**
     * 复制店铺
     */
    public function cp_corporation(){

        $corporation_id = $this->session->userdata('corporation_id');
        $customer_id = $this->session->userdata('user_id');
        if(!$corporation_id){
            echo "没店铺的人走";exit;
        }

        $this->load->model("customer_corporation_mdl","customer_cp");
        $this->load->model("corporation_detail_mdl","corp_detail");
        
        $corp = $this->customer_cp->corp_load($corporation_id);//查询店铺信息
        $crop_detail = $this->corp_detail->load($corporation_id);//查询店铺详情

        
        //切换数据库
        $db = $this->load->database("C",true);
        $db->trans_begin();//开启事务
        
        $db->set('customer_id',$customer_id);
        $db->set('corporation_name',$corp['corporation_name']);
        $db->set('corporation_area',$corp['corporation_area']);
        $db->set('address',$corp['address']);
        $db->set('postcode',$corp['postcode']);
        $db->set('email',$corp['email']);
        $db->set('contact_name',$corp['contact_name']);
        $db->set('contact_mobile',$corp['contact_mobile']);
        $db->set('province_id',$corp['province_id']);
        $db->set('city_id', $corp['city_id']);
        $db->set('district_id',$corp['district_id']);
        $db->set("app_id",$corp['app_id']);
        $db->set("auto_order_amount",$corp['auto_order_amount']);
        $db->set("approval_status",1);
        $db->insert ( 'customer_corporation');
        $corporation_id = $db->insert_id();//复制店铺信息

        if($corporation_id){
            $db->set('corporation_id',$corporation_id);
            $db->set('Industrial_Info',$crop_detail['Industrial_Info']);
            $db->set('nature',$crop_detail['nature']);
            $db->set('legal_person',$crop_detail['legal_person']);
            $db->set('idcard',$crop_detail['idcard']);
            $db->set('company_registration',$crop_detail['company_registration']);
            $db->set('bus_licence_img',$crop_detail['bus_licence_img']);
            $db->set('idcard_img',$crop_detail['idcard_img']);
            $db->set('proxy_img',$crop_detail['proxy_img']);
            $db->set('regist_date', date("Y-m-d H:i:s"));
            $row = $db->insert ( 'corporation_detail');//查询店铺详情
            if(!$row){
                $db->trans_rollback();//回滚
            }else{
                
                
                $this->load->library("Curl");

                //同步营业执照图片
                $bus_licence_img = explode(";",$crop_detail["bus_licence_img"]);
                foreach($bus_licence_img as $file){
                    $this->curl->execUpload(FCPATH.UPLOAD_PATH.$file,base_url()."index.php/_CLIENT/Customer/upload_charter/$corporation_id");
                }


                //同步身份证图片
                $idcard_img = explode(";",$crop_detail["idcard_img"]);
                foreach($idcard_img as $file){
                    $this->curl->execUpload(FCPATH.UPLOAD_PATH.$file,base_url()."index.php/_CLIENT/Customer/upload_idcard/$corporation_id");
                }
                
                //同步法人委托书图片
                $proxy_img = explode(";",$crop_detail["proxy_img"]);
                foreach($proxy_img as $file){
                    $this->curl->execUpload(FCPATH.UPLOAD_PATH.$file,base_url()."index.php/_CLIENT/Customer/upload_wts/$corporation_id");
                }
                
                $db->trans_commit();//提交
            }
        }else{
            $db->trans_rollback();//回滚
        }


    
    }
    

    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */