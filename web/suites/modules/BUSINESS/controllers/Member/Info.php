<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Info extends Front_Controller {

    public function __construct()
    {
        parent::__construct();

//         判断用户是否登录

        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('customer/login');
            exit();
        }
        $this->load->model('customer_mdl');
        $this->load->model('customer_address_mdl');
        
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
    }

    public function index()
    {
        $customer_id = $this->session->userdata('user_id');
        $this->session->unset_userdata('ref_from_url');
        // 判断是否微信浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
           
            //调用接口处理
            $url = $this->url_prefix.'Customer/load';
            $data_post['customer_id'] = $customer_id;
            $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
            
            // 如果没有上线
            if ($customer['parent_id'] == 0) {
                if (isset($_COOKIE['inviteid'])) {
                    $parent_id = $_COOKIE['inviteid'];
                    $this->customer_mdl->update_parent($customer_id, $parent_id);
                }
            }
        }
        
        $this->info();
    }
    
    // 用户资料界面
    public function info()
    {
      
    	$customer_id = $this->session->userdata('user_id');
   
        //-----切换站点  开始
        $user_key = $this->input->get("user_key");
        if($user_key){
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
        $data['customer'] = $this->customer_mdl->get_customer_info($account_id);//查询用户信息
        //h5
        if( $this->isMobile() ){
            
            //调用接口获取数据
//             $relation_id = $this->session->userdata ( 'pay_relation' );
//             $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
//             $pay_info = json_decode($this->curl_get_result($url),true);
            $url = $this->url_prefix.'Customer/load_pay_account?';
            $customerinfo['customer_id'] =$account_id;
          
            $pay_info = json_decode($this->curl_post_result($url,$customerinfo),true);
            
            if($pay_info){
                $data['customer'] = array_merge($data['customer'],$pay_info);
                if (! ($data['customer']['credit_start_time'] <= date('Y-m-d H:i:s') && $data['customer']['credit_end_time'] >= date('Y-m-d H:i:s'))) {
                    $data['customer']['credit'] = '0.00';
                }
            }else{
                //若没有支付账户，则现金为0 货豆为0 
                 $data['customer']['cash'] = 0;
                 $data['customer']['credit'] = '0.00';
            }
            
            // 获取默认收货地址
            $data['address'] = $this->customer_address_mdl->load($account_id);
            
            $this->load->model('order_mdl');
            
            $data['count_unfinished_orders'] = $this->order_mdl->count_orders($account_id);

            //获取用户未审核部落的数量
            $this->load->model('tribe_mdl');
            $data['count_unaudited_tribe'] = $this->tribe_mdl->count_unaudited_tribe($account_id);
            
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
        $this->load->model("tribe_package_mdl");
        $packages = $this->tribe_package_mdl->get_tribe_package($account_id);
        
        $data['send_tribe_pack'] = false;
        if($packages){
            $data['send_tribe_pack'] = true;
        }
        
        $this->load->model("tribe_mdl");
        $tribe = $this->tribe_mdl->ManagementTribe($customer_id);//查询管理的部落

        
        $data["tribe"] = $tribe;
        $data['title'] = '个人中心';
        $data['head_set'] = 2;
        $data['foot_icon'] = 5;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/info', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // 修改用户资料
    public function info_edit()
    {
        $customer_id = $this->session->userdata('user_id');
        
        //接口获取用户资料
        $post['customer_id'] = $customer_id;
        $url = $this->url_prefix.'Customer/load';
        $data['customer'] = json_decode($this->curl_post_result($url,$post),true);
        
        // 获取默认收货地址
        $data['address'] = $this->customer_address_mdl->load($this->session->userdata('user_id'));
        if (! $data['address']) {
            $data['address'] = array(
                'phone' => null,
                'mobile' => null,
                'address' => null,
                'email' => null,
                'postcode' => null,
                'province_id' => null,
                'city_id' => null,
                'district_id' => null,
                'address_for_name' => null
            );
        }
        
        $data['head_set'] = 3;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/info_edit', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // 保存用户资料
    public function info_save()
    {
        $post['user_id'] = $customer_id = $this->session->userdata('user_id');
        $post['email'] = $email = $this->input->post('email');
        $post['phone'] = $phone = $this->input->post('phone');
        $post['real_name'] = $real_name = $this->input->post('real_name');
        $post['nick_name'] = $nick_name = $this->input->post('nick_name');
        $post['sex'] = $sex = $this->input->post('sex');
        $post['birthday'] = $birthday = $this->input->post('birthday');
        $post['job'] = $job = $this->input->post('job');
      
        //接口获取用户信息
        $url = $this->url_prefix.'Customer/info_save';
        $result = json_decode($this->curl_post_result($url,$post),true);
        if($result['status']){//成功
            
            if($real_name){
                //如果有存在修改真实姓名 则把族员姓名也同步
                $this->load->model("tribe_mdl");
                $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$customer_id);
                $this->session->set_userdata('user_name', $real_name);
                $this->session->set_userdata('real_name', $real_name);
            }else{
                $this->session->set_userdata('user_name', $nick_name);
            }
            
           
            redirect('member/info');
        }else{//失败
            redirect('Member/info/info_edit');
        }
    }
    
    /**
     * 修改用户密码界面
     */
    public function pwd_edit($msg = 0)
    {
        $user_id = $this->session->userdata("user_id");
        $this->load->model("customer_mdl");
        $customer = $this->customer_mdl->load($user_id);
        
		// 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist")) {            
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        $data['error_msg'] =$msg;
       

        $data['mobile']=$customer['mobile'];
        $data['mobile_code_type']="1";
        
        $data['title'] = '修改密码';
        $data['back'] = 'customer/safety_setting';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/changepwd', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 保存用户密码
     */
    public function pwd_save()
    {
        $old_pwd = $this->input->post('txtOldPwd');
        $new_pwd = $this->input->post('txtNewPwd');
        $verfity = $this->input->post('handset-num');//H5使用
        
        $this->load->model('customer_mdl');
        if ($verfity) {
            $user_id = $this->session->userdata("user_id");
            $customer = $this->customer_mdl->load($user_id);
            $mobile1 = $customer['mobile'];
            
            // 验证用户验证码
            $vertify2 = $this->session->userdata('verfity_yzm_1');
            $mobile2 = $this->session->userdata('verfity_mobile_1');
            $set_time = $this->session->userdata('verfity_settime_1');
            
            
            //清空session
            $this->session->unset_userdata('verfity_yzm_1');
            $this->session->unset_userdata('verfity_mobile_1');
            $this->session->unset_userdata('verfity_settime_1');

            if ($verfity != $vertify2 || $mobile1 != $mobile2) {
                redirect('member/info/pwd_edit/code_error');
//                 header("Content-type: text/html; charset=utf-8");
//                 echo "<script>alert('验证码错误');location.href='" . site_url('member/info/pwd_edit') . "';</script>";
//                 exit;
            }
            
            if (date('Y-m-d H:i:s', strtotime("-300 second")) > $set_time) {
                redirect('member/info/pwd_edit/code_timeout');
//                 header("Content-type: text/html; charset=utf-8");
//                 echo "<script>alert('验证码已失效，请重新获取');location.href='" . site_url('member/info/pwd_edit') . "';</script>";
//                 exit;
            }
        } else {
            //验证新旧密码是否同
            if($old_pwd == $new_pwd){
                redirect('member/info/pwd_edit/pw_repeat');
//                 header("Content-type: text/html; charset=utf-8");
//                 echo "<script>alert('新密码不能和旧密码相同！');location.href='" . site_url('member/info/pwd_edit') . "';</script>";exit;
            }else{
                //接口匹配用户密码
                $url = $this->url_prefix.'Customer/check_pwd';
                $post['password'] = $old_pwd;
                $post['customer_id'] = $this->session->userdata('user_id');
                $result = json_decode($this->curl_post_result($url,$post),true);
                
                if (!$result['status']) {
                    redirect('member/info/pwd_edit/old_pw_error');
//                     header("Content-type: text/html; charset=utf-8");
//                     echo "<script>alert('旧密码输入错误');javascript:history.back();</script>";
//                     exit;
                }
            }
            
        }

        
        //接口修改用户密码
        $url = $this->url_prefix.'Customer/update_pwd';
        $post['password'] = $new_pwd;
        $post['customer_id'] = $this->session->userdata('user_id');
        $result = json_decode($this->curl_post_result($url,$post),true);
        
        if ($result['status']) {//修改成功
            if ($verfity) {
                // pc web发送短信提示修改成功暂时无
//                 $content = "您的密码修改成功，如非本人操作请致电400-0029-777";
                $real_name = $customer['real_name'] ? $customer['real_name']:$customer['mobile'];
                $content  = "尊敬的【{$real_name}】，您的密码已经修改成功，请勿向任何人泄露。如非本人操作，请尽快咨询您的专属客服：4000029777【51易货网】";
                //发送短信
                $this->load->helper("message");
                $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
                $sms = send_message($customer['mobile'],0,$content,1,$source);
                $sms = json_decode($sms,true);
            }
            redirect('member/info/pwd_edit/update_success');
//             header("Content-type: text/html; charset=utf-8");
//             echo "<script>alert('密码修改成功');location.href='" . site_url('member/info/') . "';</script>";exit;
        }else{//修改失败
            redirect('member/info/pwd_edit/error');
//             echo "<script>alert('网络异常！');location.href='" . site_url('Member/info/pwd_edit') . "';</script>";exit;
        }
    }
    
    /**
     * web\h5验证流程不一致，分开控制器
     * 修改用户支付密码界面
     */
    public function paypwd_edit( $status = 0)
    {
        $user_id = $this->session->userdata("user_id");
        $this->load->model("customer_mdl");
        $customer = $this->customer_mdl->load($user_id);
        
		// 微信用户绑定监测
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false && !$this->session->userdata("mobile_exist")) {
            // 如果没有写手机
            if (empty($customer['mobile'])) {
                redirect('member/binding/binding_mobile');
                return;
            }
        }
        
        if(!stristr($_SERVER['HTTP_USER_AGENT'],"Android") && !stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
            redirect("member/save_set/paypwd_set");
            exit;
        }

        $data['mobile']=$customer['mobile'];
        $data['mobile_code_type']="2";

        switch ($status){
            case 1:
                $data['error_msg'] = "update_success";// 支付密码修改成功
                break;
            case 2:
                $data['error_msg'] = "code_error";// 验证码错误
                break;
            case 3:
                $data['error_msg'] = "error";// 网络错误
                break;
            case 4:
                $data['error_msg'] = "code_timeout";// 验证码失效
                break;
            case 5:
                $data['error_msg'] = "pw_repeat";// 新旧密码不能一致
                break;
            default:
                $data['error_msg'] = "0";
                break;
        }
        $data['title'] = '修改支付密码';
        $data['back'] = 'customer/safety_setting';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/changepwd', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 保存用户支付密码
     */
    public function paypwd_save()
    {   
    
        $new_pwd = $this->input->post('txtNewPwd');
        $verfity = $this->input->post('handset-num');
        
        $this->load->model('customer_mdl');
        $this->load->model('pay_account_mdl');
        
        $customer_id = $this->session->userdata("user_id");
        
        $customer = $this->customer_mdl->load($customer_id);
        $mobile1 = $customer['mobile'];
       
        // 验证用户验证码
        $vertify2 = $this->session->userdata('verfity_yzm_2');
        $mobile2 = $this->session->userdata('verfity_mobile_2');
        $set_time = $this->session->userdata('verfity_settime_2');
        
        
        if ($verfity != $vertify2 || $mobile1 != $mobile2) {
            redirect("member/info/paypwd_edit/2");
            exit();
        } else if (date('Y-m-d H:i:s', strtotime("-300 second")) > $set_time) {
            redirect("member/info/paypwd_edit/4");
            exit();
        } else {
            $data['customer_id'] = $customer_id;
            $data['pay_passwd'] = $new_pwd;
            
            //判断新旧密码是否相同
            $link = $this->url_prefix.'Customer/getPayAccount?';
            $Accountinfo = json_decode($this->curl_post_result($link,$data),true);
            if($Accountinfo['status']){
                redirect("member/info/paypwd_edit/5");
            }
            //修改支付密码
            $link = $this->url_prefix.'Customer/setPayPassword?';
            $res = json_decode($this->curl_post_result($link,$data),true);
//             $this->pay_account_mdl->pay_passwd = $new_pwd;
//             $res = $this->pay_account_mdl->update($customer_id);
         
            if ($res['status']) {
                
                $this->session->unset_userdata('verfity_yzm_2');
                $this->session->unset_userdata('verfity_mobile_2');
                $this->session->unset_userdata('verfity_settime_2');
                
                
                $content = "尊敬的【".($customer['real_name']?$customer['real_name']:$customer['mobile'])."】，您的密码已经修改成功，请勿向任何人泄露。如非本人操作，请尽快咨询您的专属客服：4000029777【51易货网】";
                //发送短信
                $this->load->helper("message");
                $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
                $sms = send_message($customer['mobile'],0,$content,1,$source);
                $sms = json_decode($sms,true);
                
                $ref_from_url = $this->session->userdata("ref_from_url");
                $this->session->unset_userdata("ref_from_url");
                if($ref_from_url){
                    redirect($ref_from_url);
                    exit;
                }
                redirect("Member/info/paypwd_edit/1");
            } else {
                redirect("member/info/paypwd_edit/3");
                exit();
            }
        }
    }

    
    
    /**
     * 
     */
    public function My_Profit()
    { 
        $data['title'] = '我的收益';
        
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_earnings');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
        
    }
    
    public function My_Profit_Data()
    { 
         $customer_id = $this->session->userdata("user_id");
         $page = $this->input->post('page');
         $time = $this->input->post('time');
         if( !$page  || !is_numeric($page) || !is_int($page+0)  )
         {
             $page = 1;
         }
         
         //获取时间区间
         $this->load->helper("time");
         $time = GetTime($time);
          
         $limit = 10;
         $offset = ($page-1)*$limit;//偏移量
         
         $this->load->model('Order_rebate_mdl');
         $return['list'] = $this->Order_rebate_mdl->My_Order_Guarantee( $customer_id ,$time, $limit ,$offset );
//          echo $this->db->last_query();
         if( $page == 1 )
         {
            $return['total_rebate']  = $this->Order_rebate_mdl->My_Sum_Rebate( $customer_id,$time )['total_rebate'];
         }
         
//          echo $this->db->last_query();
         echo json_encode($return);
    }
    
    /**
    * @author JF
    * 2017年12月7日
    * 账户设置view
    */
    function AccountSettings(){
        
        
        $customer_id = $this->session->userdata("user_id");//用户id
        $real_name = $this->session->userdata("real_name");//真实姓名
        $nick_name = $this->session->userdata("nick_name");//昵称
        $wechat_nickname = $this->session->userdata("wechat_nickname");//微信昵称
        $brief_avatar = $this->session->userdata("brief_avatar");//头像
        $wechat_avatar = $this->session->userdata("wechat_avatar");//微信头像
        
        $nick_name = $nick_name?$nick_name:$wechat_nickname;
        $avatar = $brief_avatar ? $brief_avatar:$wechat_avatar;//头像
        
        $this->load->model("tribe_mdl");
        $tribe = $this->tribe_mdl->Customer_Tribe_List($customer_id);//查询加入的部落
        
        //调用接口处理->验证实名认证
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $customer_id;
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        
        $data["is_authentication"] = $customer["idcard"];
        $data["tribe"] = $tribe;
        $data["nick_name"] = $nick_name;
        $data["real_name"] = $real_name;
        $data["avatar"] = $avatar;
        $data['title'] = '账户设置';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/account_settings');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
    * @author JF
    * 2017年12月7日
    * 用户资料view
    */
    function UserInfo(){
        $sex = $this->session->userdata("sex");//性别
        $job = $this->session->userdata("job");//职业
        $mobile = $this->session->userdata("mobile");//手机号码
        $real_name = $this->session->userdata("real_name");//真实姓名
        $nick_name = $this->session->userdata("nick_name");//昵称
        $wechat_nickname = $this->session->userdata("wechat_nickname");//微信昵称
        $brief_avatar = $this->session->userdata("brief_avatar");//头像
        $wechat_avatar = $this->session->userdata("wechat_avatar");//微信头像
        $customer_id = $this->session->userdata("user_id");//用户id
        
        $this->load->model('Customer_identity_mdl');
        
        $nick_name = $nick_name?$nick_name:$wechat_nickname;
        $avatar = $brief_avatar ? $brief_avatar:$wechat_avatar;//头像
        $corp_list = $this->Customer_identity_mdl->Load($customer_id);//查询社会身份列表。

        $tribe_id = $this->input->get('tribe_id');
        if($tribe_id){
            $customer_id = $this->session->userdata('user_id');
            $this->load->model('Customer_mdl');
            $customer_info = $this->Customer_mdl->load( $customer_id );
            $this->load->model('Tribe_mdl');
            $customer_info_Ts = $this->Tribe_mdl->Customer_Ts_Info($customer_id,$tribe_id);
            $data['customer_info_Ts'] = $customer_info_Ts;
            if($customer_info_Ts['show_mobile'] == 2 && $customer_info['id'] !=  $customer_id){
                $customer_info['mobile'] = $customer_info['mobile'] = substr_replace($customer_info['mobile'],'****',3,4);
            }
        }
        $this->load->model('Customer_mdl');
        $customer_info = $this->Customer_mdl->load( $customer_id );
        $data['customer_info'] = $customer_info;
        
        $data["sex"] = $sex;
        $data["job"] = $job;
        $data["nick_name"] = $nick_name;
        $data["mobile"] = $mobile;
        $data["avatar"] = $avatar;
        $data["real_name"] = $real_name;
        $data["corp_list"] = $corp_list;
        $data['title'] = '个人资料';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/personal_information');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
    * @author JF
    * 2017年12月7日
    * ajax修改个人资料
    */
    function ajax_up_info(){
        $real_name = $this->input->post("real_name");//真实姓名
        $nick_name = $this->input->post("nick_name");//昵称
        $job = $this->input->post("job");//职位
        $sex = $this->input->post("sex");//性别0为女，1为男
        $customer_id = $this->session->userdata("user_id");//用户id
        
        if(!empty($real_name)){
            $param["real_name"] = $real_name;
            $length = preg_match('/^[\x{4e00}-\x{9fa5}]+$/u', $real_name);
                if(!$length){
                     $return = array(
                    "status" => "03",
                    "msg" => "真实姓名只能填写中文！"
                );
                echo json_encode($return);
                exit;
                }
        }
        if(!empty($nick_name)){
             $param["nick_name"] = $nick_name;
        }
        if(!empty($job)){
           $param["job"] = $job;
        }
       
        if(isset($sex)){
            $param["sex"] = $sex;
        }
        
        $param["user_id"] = $customer_id; 
      
        //接口获取用户信息
        $url = $this->url_prefix.'Customer/info_save';
        $result = json_decode($this->curl_post_result($url,$param),true);
        if($result['status']){//成功
            if(!empty($real_name)){
                $param['user_name'] = $real_name;
                $param['real_name'] = $real_name;
                $this->session->set_userdata($param);
            }
            $this->load->model('tribe_mdl');
            $this->tribe_mdl->update_tribe_member_name($real_name,$customer_id);
            $return = array(
                    "status" => "00",
                    "msg" => "更换成功"
            );
            
        }else{
            $return = array(
                "status" => "01",
                "msg" => "更换失败"
            );
        }
        echo json_encode($return);exit;
        
    }
    
    /**
    * @author JF
    * 2018年3月7日
    * 实名认证页面
    */
    function AuthenticationView(){
        $mobile = $this->session->userdata("mobile");//手机号码
        $customer_id = $this->session->userdata("user_id");//用户id
        // 如果没有绑定手机
        if (empty($mobile)) {
            redirect('member/binding/binding_mobile');
            return;
        }

        //调用接口处理->验证实名认证
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $customer_id;
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        $data['customer'] = $customer;
        
        //判断商品是否存在
        if (!stristr($_SERVER['HTTP_USER_AGENT'], "Android") && !stristr($_SERVER['HTTP_USER_AGENT'], "iPhone") && !stristr($_SERVER['HTTP_USER_AGENT'], "wp")){//pc
            $view = "customer/verify_bank";
        }else{//h5
            if(!$customer["idcard"]){
                //调用接口处理->查询支付账户
                $url = $this->url_prefix.'Customer/load_pay_account';
                $data_post['customer_id'] = $customer_id;
                $pay = json_decode($this->curl_post_result( $url,$data_post ),true);
                $is_passwd = $pay["pay_passwd"]?true:false;//是否设置支付密码
                $data["is_passwd"] = $is_passwd;
                $data["mobile"] = $mobile;
                $view = "customer/verify_bank";
            }else{
                $view = "customer/verify_status";
            }
        }
        
        
        
        $data["customer"] = $customer;
        $data['title'] = '实名认证';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view($view);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
    * @author JF
    * 2018年3月7日
    * 实名认证协议
    */
    function approve_protocol(){
        
        $data['title'] = '实名认证协议';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/approve_protocol');
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
    * @author JF
    * 2018年3月7日
    * AJAX实名认证
    */
    function AjaxAuthentication(){

        $real_name = $this->input->post("real_name");//真实姓名
        $idcard = $this->input->post("idcard");//身份证号码
        $bankcard = $this->input->post("bank");//银行卡号
        $vertify1 = $this->input->post("VerificationCode");//验证码
        $bankmobile = $this->input->post("bankmobile");//预留手机号码
        $customer_id = $this->session->userdata("user_id");//用户id
        $mobile = $this->session->userdata("mobile");//手机号码
      
        $this->load->helper("verification");//验证类
        $this->load->library("Certification");//京东万象接口
        
        $this->load->model("tribe_mdl");
       
        //验证数据
        if( !$real_name || !checkIdCard($idcard) || !checkMobile($bankmobile) || !$vertify1){
            $return = array(
                    "status" => "02",
                    "msg" => "您提交实名认证有有误，请重新提交"
            );
            echo json_encode($return);exit;
        }
        
        // 验证用户验证码
        $vertify2 = $this->session->userdata('verfity_yzm_10');
        $mobile2 = $this->session->userdata('verfity_mobile_10');
        $set_time = $this->session->userdata('verfity_settime_10');
        
        // 验证码超时验证
        if(date('Y-m-d H:i:s', strtotime("-300 second")) > $set_time) {
            $return = array(
                    "status" => "04",
                    "msg" => "验证码超时"
            );
            echo json_encode($return);exit;
        }
 
        if ($vertify1 != $vertify2 || $mobile != $mobile2 ) {
            $return = array(
                    "status" => "03",
                    "msg" => "请输入正确的验证码"
            );
            echo json_encode($return);exit;
        }
        


        //调用接口处理->验证实名认证
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $customer_id;
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        if(!$customer["mobile"]){
            $return = array(
                    "status" => "05",
                    "msg" => "您未绑定手机号码"
            );
            echo json_encode($return);exit;
        }else if($customer["idcard"]){
            $return = array(
                    "status" => "06",
                    "msg" => "你已经实名认证了"
            );
            echo json_encode($return);exit;
        }
        
        //调用接口处理->查询身份证号
        $url = $this->url_prefix.'Customer/CheckIdCard';
        $parameter= array("idcard"=>$idcard);
        $isidcard = json_decode($this->curl_post_result( $url,$parameter ),true);
        if($isidcard){
            $return = array(
                    "status" => "07",
                    "msg" => "该身份已被占有，请提交其他身份信息"
            );
            echo json_encode($return);exit;
        }
        
        //京东万象-实名认证接口
        $parameter = array(
                "cardNo" => $idcard,
                "accName" => $real_name,
                "certificateNo" => $bankcard,
                "cardPhone" => $bankmobile
        );
        $result = $this->certification->jdwx(1,$parameter);
      
        if(empty($result["result"]["respCode"]) || $result["result"]["respCode"] != "000000"){
            $return = array(
                    "status" => "02",
                    "msg" => "您提交实名认证有误，请重新提交"
            );
            echo json_encode($return);exit;
        }
        
        
        $this->db->trans_begin();//开启事务
        
        //更新部落用户真实姓名
        $parament = array(
                "member_name" => $real_name
        );
        $row = $this->tribe_mdl->ChangeStaffName($customer_id,$parament);
        if(!$row){
            $this->db->trans_rollback();//开启事务
            $return = array(
                    "status" => "01",
                    "msg" => "实名认证失败"
            );
            echo json_encode($return);exit;
        }

        //调用接口处理->更新用户资料
        $url = $this->url_prefix.'Customer/UpdateA';
        $parameter = array(
                "user_id" => $customer_id,
                "real_name" => $real_name,
                "bankcard" => $bankcard,
                "idcard" => $idcard,
                "bankmobile" => $bankmobile
        );
        $result = json_decode($this->curl_post_result( $url,$parameter ),true);
        if($result["status"] == 00){
            $this->db->trans_commit();
            $return = array(
                    "status" => "00",
                    "msg" => "实名认证成功"
            );
        }else{
            $this->db->trans_rollback();//开启事务
            $return = array(
                    "status" => "01",
                    "msg" => "实名认证失败"
            );
        }
        echo json_encode($return);exit;
    }
    
    /**
    * @author JF
    * 2018年4月3日
    * 设置支付密码
    */
    function SetPayPassword(){
        $real_name = $this->input->post("real_name");//真实姓名
        $idcard = $this->input->post("idcard");//身份证号码
        $bankcard = $this->input->post("bank");//银行卡号
        $bankmobile = $this->input->post("bankmobile");//手机号码
        $pay_passwd = $this->input->post("pay_passwd");//支付密码
        
        $customer_id = $this->session->userdata("user_id");//用户id
        
        
        //调用接口处理->验证实名认证
        $url = $this->url_prefix.'Customer/load';
        $data_post = array(
                "customer_id" => $customer_id
        );
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        if(!$customer["mobile"]){
            $return = array(
                    "status" => "01",
                    "msg" => "您未绑定手机号码"
            );
            echo json_encode($return);exit;
        }else if(!$customer["idcard"]){
            $return = array(
                    "status" => "01",
                    "msg" => "你未实名认证"
            );
            echo json_encode($return);exit;
        }

        //验证实名认证数据
        if($customer["idcard"] != $idcard ||  $customer["bankcard"] != $bankcard ||  $customer["bankmobile"] != $bankmobile){
            $return = array(
                    "status" => "01",
                    "msg" => "非法操作"
            );
            echo json_encode($return);exit;
        }
        
        //接口-查询是否已经设置支付密码
        $url = $this->url_prefix.'Customer/load_pay_account';
        $data_post = array(
                "customer_id" => $customer_id
        );
        $pay = json_decode($this->curl_post_result( $url,$data_post ),true);
        if($pay["pay_passwd"]){
            $return = array(
                    "status" => "01",
                    "msg" => "你已经设置支付密码"
            );
            echo json_encode($return);exit;
        }
        
      
        //接口-设置支付密码
        $url = $this->url_prefix.'Customer/setPayPassword';
        $data_post = array(
                "customer_id" => $customer_id,
                "pay_passwd" => $pay_passwd
        );
        $result = json_decode($this->curl_post_result( $url,$data_post ),true);
        if($result["status"]){
            $return = array(
                    "status" => "00",
                    "msg" => "绑定成功"
            );
        }else{
            $return = array(
                    "status" => "01",
                    "msg" => "绑定失败"
            );
        }
        
        echo json_encode($return);exit;

    }
}