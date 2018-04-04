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
        $this->load->model("customer_mdl");
    }
    
    // ------------------------------------------------------------
    
    /**
     */
    public function index()
    {
        // $this->load->view('customer/info');
        redirect(site_url('member/info'));
    }
     
    // ------------------微信公众号推送绑定上线消息------------------------------------------
    public function sendTplParentMsg(){
        $user_id = $this->input->post_get('user_id');//下线ID
        
        if($user_id){
            $user_info = $this->customer_mdl->load($user_id);
            print_r($user_info);
            if(!empty($user_info['parent_id'])){
                
                $parent_info =  $this->customer_mdl->load($user_info['parent_id']);
               
                if(!empty($parent_info['openid'])){
               
                    $this->load->library('Wechat_message');
                    $url = $this->session->userdata('app_info')['site_url'];
                    
                    $openid  = $parent_info['openid'];
                    $wechat_appid =   $this->session->userdata('app_info')['wechat_appid'];
                    $wechat_appsecret = $this->session->userdata('app_info')['wechat_appsecret'];
                    
                    $this->wechat_message->status = 4;   //4   模板类型 当绑定上线,后者测试 
                    $this->wechat_message->openid = $openid;
                    $this->wechat_message->app_id = $wechat_appid;
                    $this->wechat_message->appsecret = $wechat_appsecret;
                    $this->wechat_message->web_url  = $url;
                    
                    $real_name = '';
                    if($user_info['real_name']){
                        $real_name = $user_info['real_name'];
                    }else if($user_info['nick_name']){
                        $real_name = $user_info['nick_name'];
                    }else{
                        $real_name = $user_info['wechat_nickname'];
                    }
                     
                    $data  =  array(
                        "first" => '恭喜您，有一位新下级用户',
                        "keyword1" => $real_name,
                        "keyword2" => '普通会员',
                        "keyword3" => '暂未带来收入',
                        "keyword4" =>  date('Y-m-d H:i:s'),//时间
                        "remark" => '若有疑问，请联系客服 4000-029-777',
                        "url" => $url.'index.php/_BUSINESS/Home',
                    );
                 
                    //模板消息 -- 默认
                    $message = array(
                        'first'=>array('value'=>urlencode( $data['first'] ),'color'=>"#000000"),
                        'keyword1'=>array('value'=>urlencode( $data['keyword1'] ),'color'=>'#000000'),
                        'keyword2'=>array('value'=>urlencode( $data['keyword2'] ),'color'=>'#000000'),
                        'keyword3'=>array('value'=>urlencode( $data['keyword3'] ),'color'=>'#000000'),
                        'keyword4'=>array('value'=>urlencode( $data['keyword4'] ),'color'=>'#000000'),
                        'remark' => array('value'=>urlencode( $data['remark'] ),'color'=>'#000000'),
                    );
                    $res = $this->wechat_message->sendtpl_msg($data['url'],$message);
                    echo  '<pre>';
                    print_r($data);
                    print_r($res);
                }
            }
        }
    }
    
    // ------------------------------------------------------------
    /**
     */
    public function login($err_msg = 0)
    {
        if ($this->session->userdata('user_in')) {
            redirect('member/info');
        }
        
        //判断是否微信浏览器
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
    public function  activity_check_customer(){
        $user_id = $this->input->get_post("id");
        //调用接口处理
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $user_id;
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        if(!empty($customer['mobile'])){
            $data = array(
                "Result"=>true
            );
          
        }else{
             $data = array(
                "Result"=>false
            );
        }
        echo json_encode($data);
    }
    /**
     * 微信用户扫码，用户未注册
     * 进行手机号获取
     * 
     */
    public function loadmobile($err_msg = 0)
    {
        //-----切换站点 扫码绑定 开始
        $user_key = $this->input->get("user_key");
        if($user_key){
            //接口获取用户信息
            $url = $this->url_prefix.'Customer/get_memcached';
            $post['user_key']=$user_key;
            $_customer = json_decode($this->curl_post_result($url,$post),true);
            if(!$_customer['user_in'] && $_customer['type'] == 'bingding'){//未注册用户扫码绑定
                   $customer = array(
                       'user_in' => false,
                       'wechat_nickname'=>$_customer['nick_name'],
                       'wechat_avatar'=>$_customer['img_avatar'],
                       'unionid'=>$_customer['unionid'],
                       'openid'=>$_customer['openid'],
                       'todowechat'=>true,
                       'mobile' => $_customer['mobile'] 
                   );
                   $this->session->set_userdata($customer);
                   //切换站点后,购物车记录会被清空,需重新获取购物车
                   $this->load->model('cart_mdl');
                   $this->cart_mdl->reinit($customer['user_id']);
            }
            
        }
        //-----切换站点 扫码绑定 结束
        
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
        if(date('Y-m-d H:i:s', strtotime("-300 second")) > $set_time) {
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
//                 'privilege_id' => 0,
                'openid' => $openid,
                'pay_relation' => $_customer['pay_relation_id'],
                'mobile'=> $mobile
            );
            
            //查询企业信息
            $this->load->model("corporation_mdl");
            $corpinfo = $this->corporation_mdl->load($_customer['customer_id']);
            if ($corpinfo != null) {
                $customer["corporation_status"] = $corpinfo["status"];
                $customer["approval_status"] = $corpinfo["approval_status"];
                $customer['corporation_id'] = $corpinfo['id'];
//                 $customer['privilege_id'] = $corpinfo['privilege_id'];
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
    
    
    function  update_real_name(){
        $real_name = $this->input->post("real_name");
        $user_id = $this->session->userdata("user_id");
        
        if(!$real_name){
            $return = array(
                "status"=>false,
                'msg'=>'真实姓名不能为空！'
            );
            echo json_encode($return);
            exit;
        }
        $length = preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $real_name);
        if(!$length){
            $return = array(
                "status"=>false,
                'msg'=>'真实姓名只能填写中文！'
            );
            echo json_encode($return);
            exit;
        }
        
        //更新调用接口
        $url = $this->url_prefix.'Customer/info_save?';
        $userlist['user_id'] = $user_id;
        $userlist['real_name'] = $real_name;
        $customer_aff = json_decode($this->curl_post_result($url,$userlist),true);
        if($customer_aff['status']){
            $this->session->set_userdata("user_name",$real_name);
            $this->session->set_userdata("real_name",$real_name);
            $this->load->model('tribe_mdl');
            $this->tribe_mdl->update_tribe_member_name($real_name,$user_id);
            
            $return = array(
                "status"=>true,
                'msg'=>'保存成功！'
            );
            echo json_encode($return);
            
        }else{
            $return = array(
                "status"=>false,
                'msg'=>'保存失败！'
            );
            echo json_encode($return);
        }
    }
    
    // ------------------------------------------------------------
    
    /**
     * 保存注册信息
     */
    function save()
    {
        $this->load->model('customer_mdl');
        $parent_id = $this->session->userdata('inviteid');
        if (isset($parent_id)) {
            $this->customer_mdl->parent_id = $parent_id;
        }
        
        $name = $this->input->post('mobile');
        $mobile = $this->input->post('mobile');
        $nick_name = $this->input->post('Nickname');
        $password = $this->input->post('tbxRegisterPassword');
        $mobile_vertify = $this->input->post('mobile_vertify');
        $this->load->library('Validation');
        
        
        // 后台验证注册手机验证码
        $mobile_vertify2 = $this->session->userdata('verfity_yzm_8');
        $mobile2 = $this->session->userdata('verfity_mobile_8');
        
        if ($mobile_vertify != $mobile_vertify2 || $mobile != $mobile2) {
            echo "<script>alert('手机验证码填写错误');history.back(-1);</script>";
            exit();
        }
        
            //接口注册用户
            if (stristr($_SERVER['HTTP_USER_AGENT'], "Android") || stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") || stristr($_SERVER['HTTP_USER_AGENT'], "wp")) {
                $_POST['registry_by'] = "H5";
            }else{
                $_POST['registry_by'] = "PC";
            }
            $_POST['app_id'] = $this->session->userdata("app_info")["id"];
            $_POST['time'] = date("Y-m-d H:i:s");
            $_POST['module'] = "B";
            if(!$nick_name){
                $_POST['Nickname'] = "访客";
            }
            $_POST['parent_id'] = $parent_id;
            $url = $this->url_prefix.'Customer/save';
            
            $user = json_decode($this->curl_post_result($url,$_POST),true);
       
            switch ($user['status']){
                case 1:
                    echo "<script>alert('用户已存在');history.back(-1);</script>";exit;
                    break;
                case 2:
                    echo "<script>alert('注册失败');history.back(-1);</script>";exit;
                    break;
                case 3://注册成功
                    $customer_id = $user['customer_id'];
                    break;
            }


            // 生成二维码图片
//             $this->generateBarcode($customer_id);
            $this->session->unset_userdata('mobile_verfity');
            
            //加载用户支付账户信息写入session
            $p_data =array();
            $p_data['customer_id'] = $customer_id;
            $url = $this->url_prefix.'Customer/get_pay_relation_id?';
            $pay_data = json_decode($this->curl_post_result($url,$p_data),true);
             
            $this->load->helper("session");
            
            $this->load->model("customer_mdl");
            $user_info = $this->customer_mdl->load($customer_id);
            $user_info['pay_relation'] = $pay_data;
            set_customer($user_info,"other");
           
            $activity_to = $this->session->userdata('ref_activity_url');
            if (! empty($activity_to)) {
                $this->session->unset_userdata('ref_activity_url');
                redirect($activity_to);
                exit();
            }
            
            if ($this->isMobile()) {
                redirect('Home');
            } else {    
                redirect('Member/info');
            }
    }
    
    
    // --------------------------------------------------------------------
  
    


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

    
    
    //作废待删除
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

        if ( ( empty( $corporation_id) && $corporation_id <= 0 ) || empty($data['dt']) ) {
            redirect('Member/info');    // 未注册企业帐号或者后台删除
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && ($data['dt']['status'] == 0) && ($data['dt']['approval_status'] == null || $data['dt']['approval_status'] == 0)) {
            redirect('Member/info');    // 未绑定
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && ($data['dt']['status'] == 0) && $data['dt']['approval_status'] == 1) {
            redirect('customer/reg_succ');      // 申核中
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && ($data['dt']['status'] == 0) && $data['dt']['approval_status'] == 3) {
            redirect('customer/reg_error');     // 申核失败
        } elseif (! empty($data['dt']['id']) && $data['dt']['id'] > 0 && $data['dt']['status'] == 2) {
//             redirect('customer/reg_error');     // 企业冻结
        } else {
            $this->session->set_userdata('corporation_status',$data['dt']['status']);
            redirect('corporate/info');
        }
    }

    //作废待删除
    function reg_succ()
    {
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $data['message'] = '注册成功，等待验证';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/reg_step_succ', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    //作废待删除
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
            $this->load->model("customer_mdl");
            $info = $this->customer_mdl->load($_customer['id']);
            $info['pay_relation'] = $_customer['pay_relation'];
            $this->load->helper("session");
            set_customer($info);
        } else {
            redirect('customer/login/1');
        }
    }
    
    
    // ------------------------------------------------------------
    
    /**
     *
     * @param number $id            
     */
    public function registration($id = 0)
    {
        
        if ($id) {
            //保存上线用户ID
            $this->session->set_userdata('inviteid',$id);
        }
        $tribe_id = $this->input->get('tribe_id');
        if($tribe_id){
            $this->session->set_userdata('ref_activity_url',site_url("Tribe/tribe_detail/".$tribe_id));
        }
        $user_id = $this->session->userdata('user_id');
        $data['err'] = $this->input->get_post("err");
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
        
        $customer_id = $this->session->userdata('user_id');
        
        if ($level < 0 || $level > 5) {
            $this->showMessage("找不到所需页面！", site_url('customer/customerdata'), true, true);
        } else {
            if ($level > 0 && $fid == 0) {
                $this->showMessage("参数错误！", site_url('customer/customerdata'), true, true);
            } else {
                if ($level == 0) {
                    $fid = $this->session->userdata('user_id');
                }
                
                $data_url["begindate"] = $this->input->get_post("begindate");
                $data_url["enddate"] = $this->input->get_post("enddate");
                $data_url["username"] = $this->input->get_post("username");
                $data_url["phone"] = $this->input->get_post("phone");
                
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
               
            }
        }
        
        $this->load->library('pagination');
        $config['per_page'] = 5; //每页显示几条
        $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        if(0 == $current_page)
        {
            $current_page = 1;
        }
        $offset   = ($current_page - 1 ) * $config['per_page'];
        $url = '';
        foreach ($data_url as $k=>$v)
        { 
             if( $v ){
                 $url .= $k.'='.$v.'&';
             }
        }
        $url = substr($url, 0, -1);
        
        $config['base_url'] = site_url('Customer/customerdata').'/'.$level.'/'.$fid.'/?'.$url;
        
        $this->load->model('Order_rebate_mdl');
        $data['result'] = $this->Order_rebate_mdl->my_order_bebate($customer_id,$condition, $like,false,$config['per_page'],$offset);
        $total_rows =  $this->Order_rebate_mdl->my_order_bebate($customer_id,$condition, $like,true);
         
        $config['total_rows'] = $total_rows;
        $config['use_page_numbers']   = TRUE;
        $config['page_query_string']  = TRUE;
        $config['num_links'] = 3; //可以看到当前页后面的3页a连接
        $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config ['prev_tag_css'] = 'class="lPage"';
        $config ['next_link'] = '下一页';
        $config ['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
         
       
        
        $data['title'] = "我的家族";
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $this->pagination->initialize($config);
        $data['total_rows'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        $data['cu_page'] = $current_page;
        $data['page'] =  $this->pagination->create_links();
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
        
        $this->load->model('customer_corporation_mdl');
        
        $Corp_info = $this->customer_corporation_mdl->load( $account_id );
        //查看担保记录
        
        $data['is_guarantee'] = true;
        $this->load->model('Guarantee_request_mdl');
        $guarantee_info = $this->Guarantee_request_mdl->is_effect($account_id);
        
        if( $guarantee_info['total'] )
        {
            $data['is_guarantee'] = false;
            $data['guarantee_total'] = $guarantee_info['total'];
        }
        
//         if( !empty($Corp_info['status'])  && $Corp_info['status'] == 1 )
//         {
            
//             $data['is_guarantee'] = true;
//             $this->load->model('Guarantee_request_mdl');
//             $guarantee_info = $this->Guarantee_request_mdl->is_effect($account_id);
            
//             if( $guarantee_info['total'] )
//             { 
//                 $data['is_guarantee'] = false;    
//                 $data['guarantee_total'] = $guarantee_info['total'];
                
//             }
            
//             $data['is_corp'] = true;
//         }
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
  
        //判断是否登录，如果没有登录则验证验证码
        $customer_id = $this->session->userdata("user_id");//用户id
        
        $user_info =  $this->customer_mdl->load($customer_id);
        
        if( $status != 255 )
        {
            if(!$customer_id){
                $Verifier1 = $this->input->get_post('yzm');//验证码
                $Verifier2 = $_SESSION['verify'];
                if($Verifier1 != $Verifier2){
                    echo "发送失败";exit;
                }
            }
        }
        //检查手机是否黑名单接口
        $post['mobile'] = $mobile;
        $url = $this->url_prefix.'Customer/check_blacklist';
        $result = json_decode($this->curl_post_result($url,$post),true);
        if($result["status"]){
            echo "发送失败";exit;
        }

        $this->load->helper("message");
        
        switch ($status) {
            case 1://登录密码修改验证码
                $content = '#code，您正在51易货修改登录密码，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 2:
                $content = '#code，您正在51易货修改支付密码，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 3://更换手机步骤1验证绑定手机验证码
                $content = '#code，您正在51易货更换手机号码，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 4://4更换手机步骤2绑定手机验证码,
                $content = '#code，您正在51易货更换手机号码，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 9://9微信端绑定手机号
                $content = '#code，您正在51易货绑定手机号码，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 5:
                $content = '#code，您正在51易货微信与手机号绑定，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 7:
                $name = $user_info['real_name'] ?  $user_info['real_name']: $user_info['mobile'];
                $content  = "尊敬的【{$name}】，您的密码已经修改成功，请勿向任何人泄露。如非本人操作，请尽快咨询您的专属客服：4000029777【51易货网】";
                break;
            case 6://微信与手机解绑验证码
                $content = '#code，您正在51易货微信与手机号解绑，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 8:case 255://8注册,255部落登录
                $content = '#code，您正在51易货注册，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            case 10:
                $content = '#code，您正在51易货微信与银行卡绑定，5分钟内有效，请勿向任何人泄露【51易货网】';
                break;
            default:
                echo "发送失败";exit;
                break;
        }
        
        //发送短信
        $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
        $result = send_message($mobile,$status,$content,1,$source);
        $result = json_decode($result,true);
        if($result["returnstatus"] == "00"){
            echo "发送成功";
        }else if($result["returnstatus"] == "02"){
            echo "过于频繁";
        }else{
            echo "发送失败";
        }
    }

    /**
     * 验证手机验证码.msg true
     */
    public function check_mobile($status = 0)
    {
        $vertify1 = $this->input->get('mobile_vertify');
        $vertify2 = $this->session->userdata('verfity_yzm_'.$status);
        
        //襄阳站特殊要求，只要验证码是515151都能通过2017-05-20
        if($status == 3 && $vertify1 == "515151"){
            $msg = array(
                'Result' => true
            );
            echo json_encode($msg);exit;
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
     * 找回密码1
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

    /**
     * 找回密码2
     */
    
    public function forget_password2()
    {
        $this->session->unset_userdata('key');//清空key
        
        if ($this->session->userdata('forget') == 1) {
            $name = $this->input->get('name');
            $mobile_vertify = $this->input->get('mobile_vertify');
            $mobile_verfity = $this->session->userdata('verfity_yzm_1');
            $this->session->unset_userdata('verfity_yzm_1');
            
            
            // 验证用户与手机
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

    /**
     * 找回密码3
     */
    public function update_password()
    {
        $key = $this->session->userdata("key");//密钥
//      $verfity = $this->session->userdata("password_mobile_verfity");
       
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $ConfirmPassword = $this->input->post('ConfirmPassword');
        
        if (!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){
            $mobile_verfity = $this->input->post("mobile_verfity");
        }else{
            $mobile_verfity = $this->input->post("mobile_vertify");
        }
        // 验证用户与手机
        $customer = $this->customer_mdl->load_by_mobile($name);
        // 判断条件是否满足
        if ($key==md5($name.$mobile_verfity) && $customer && $name != null && $password != null && $ConfirmPassword != null && $ConfirmPassword == $password && $mobile_verfity) {
            
          
            //接口修改密码
            $post['customer_id'] = $customer['id'];
            $post['password'] = $password;
            $url = $this->url_prefix.'Customer/update_pwd';
            $row = json_decode($this->curl_post_result($url,$post),true);
            if ($row['status']) {
                //修改密码成功
                $this->load->helper("message");
                $real_name = $customer['real_name'] ? $customer['real_name']:$name;
                $content  = "尊敬的【{$real_name}】，您的密码已经修改成功，请勿向任何人泄露。如非本人操作，请尽快咨询您的专属客服：4000029777【51易货网】";
                //发送短信
                $this->load->helper("message");
                $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
                $sms = send_message($name,7,$content,2,$source);
                $sms = json_decode($sms,true);
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
    
    // -----------------------------------------------------------------
    
    /**
     * 预绑定用户
     * 此手机未绑定微信，未注册->帮他注册一个账号，红包放进这个账号
     * 此手机已绑定微信，已注册->重新输入手机
     * 此手机未绑定微信，已注册->红包直接放进这个手机账号
     */
    public function pre_customer(){
        $customer_id = $this->session->userdata("user_id");
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            $url = site_url($_SERVER['PATH_INFO']);
            // 检查登录
            $customer_id = $this->session->userdata("user_id");
            if (!$customer_id) { 
                $this->session->set_userdata('ref_from_url', $url);
                redirect('third_signin/wechat');
                return;
            }
        }else{
             redirect('home');
             return;
        }
        $mobile = $this->input->get("mobile");//手机号码
        //跳转的路径
        $ref_from_url = $this->session->userdata("ref_from_url");
        
        if(preg_match("/^1[34578]{1}\d{9}$/",$mobile) && $ref_from_url){
            // 微信用户绑定监测
            $customer = $this->customer_mdl->load_by_name($mobile);
            if(!$customer){//帮他注册一个账号，红包放进这个账号
                $post["user_id"] = $customer_id;
                $post['name'] = $mobile;
                $post['registry_by'] = "pre-wechat";
                $post['app_id'] = $this->session->userdata("app_info")["id"];
                $post['time'] = date("Y-m-d H:i:s");
                
                //接口--预注册预绑定
                $url = $this->url_prefix.'Customer/customer_pre';
                $_customer = json_decode($this->curl_post_result($url,$post),true);
                if($_customer['status'] == 3){
                    $this->session->unset_userdata("ref_from_url");
                    $this->session->set_userdata("pre_customer_id",$_customer["customer_id"]);
                    $this->session->set_userdata("pre_pay_relation",$_customer["pay_relation_id"]);
                    redirect($ref_from_url);
                }else{
                    echo "注册失败";exit;
                }
                
            }else if (empty($customer['wechat_account'])) {//红包直接放进这个手机账号
                $this->session->unset_userdata("ref_from_url");
                //接口--获取支付信息
                $url = $this->url_prefix.'Customer/fortune?customer_id='.$customer["id"];
                $pay = json_decode($this->curl_get_result($url),true);
                $this->session->set_userdata("pre_customer_id",$customer["id"]);
                $this->session->set_userdata("pre_pay_relation",$pay["r_id"]);
                redirect($ref_from_url);
            }else{//重新输入手机
                echo "<script>alert('此手机已被绑定，请重新输入手机');history.back(-1);</script>";exit;
            }
        }else{
            echo "<script>alert('请重新输入正确的手机');history.back(-1);</script>";exit;
        }
        
    }
    
    
    // -----------------------------------------------------------------
    
    /**
     * 查询支付账户
     */
    public function check_pay_passwod(){
        $customer_id = $this->session->userdata("user_id");
        // 检查登录
        if (!$customer_id) {
            echo json_encode(array("status"=>1));//请登录
            exit;
        }
        
        $post["customer_id"] = $customer_id;
        $url = $this->url_prefix.'Customer/load_pay_account';
        $pay_account = json_decode($this->curl_post_result($url,$post),true);
        if($pay_account["passwd"]){
            echo json_encode(array("status"=>2));//已经设置过
        }else{
            echo json_encode(array("status"=>3));//需要设置支付密码
        }
    }
    

    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */