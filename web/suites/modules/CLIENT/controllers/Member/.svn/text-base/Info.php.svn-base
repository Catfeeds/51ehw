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
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false || $this->isMobile()) {
            $customer = $this->customer_mdl->load($this->session->userdata("user_id"));
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
            $this->load->model("customer_mdl");
            $customer = $this->customer_mdl->load($customer_id);
            
            // 如果没有上线
            if ($customer['parent_id'] == 0) {
                $parent_id = $this->session->userdata('inviteid');
                if (isset($parent_id)) {
                    $this->customer_mdl->update_parent($customer_id, $parent_id);
                }
            }
        }
        
        $this->info();
    }
    
    // 用户资料界面
    public function info()
    {
        $account_id = $this->session->userdata('user_id');
      
        
        $this->load->model("customer_mdl");
        $data['customer'] = $this->customer_mdl->get_customer_info($account_id);//查询用户信息
        $this->load->model('customer_shop_mdl','shop');
        $shop = $this->shop->load($account_id);
        if(!$shop){
            $data['shop'] =false;//未开通
        }else{
            if($shop['status'] != 1 ){
                $data['shop'] =false;//审核中
            }else{
                $data['shop'] =true;//已开通互助店
            }
        }
        //h5
        if( $this->isMobile() ){
            
            //调用接口获取数据
//             $relation_id = $this->session->userdata ( 'pay_relation' );
//             $url = $this->url_prefix.'Customer/fortune/?relation_id='.$relation_id;
//             $pay_info = json_decode($this->curl_get_result($url),true);
//             $data['customer'] = array_merge($data['customer'],$pay_info);

            $url = $this->url_prefix.'Customer/load_pay_account?';
            $customerinfo['customer_id'] =$account_id;
            
            $pay_info = json_decode($this->curl_post_result($url,$customerinfo),true);
      
            if($pay_info){
                $data['customer'] = array_merge($data['customer'],$pay_info);
                if (! ($data['customer']['credit_start_time'] <= date('Y-m-d H:i:s') && $data['customer']['credit_end_time'] >= date('Y-m-d H:i:s'))) {
                    $data['customer']['credit'] = '0.00';
                }
            }else{
                //若某支付账户，则现金为0
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
      
        
        $this->load->model('corporation_branch_mdl','branch');
        $branch = $this->branch->get_user_branch($account_id);
        $data['branch'] = false;
        if($branch){
            $data['branch'] = true;
        }
        
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
        
        //获取用户资料
        $this->load->model("customer_mdl");
        $data['customer'] = $this->customer_mdl->load($customer_id);
        
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
        
        //接口修改用户信息
        $url = $this->url_prefix.'Customer/info_save';
        $result = json_decode($this->curl_post_result($url,$post),true);
        if($result['status']){//成功
            $this->session->set_userdata('user_name', $nick_name);
            redirect('member/info');
        }else{//失败
            redirect('Member/info/info_edit');
        }
    }
    
    /**
     * 修改用户密码界面
     */
    public function pwd_edit()
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
        $data['error_msg'] = $this->uri->segment(4, 0);
        

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
                header("Content-type: text/html; charset=utf-8");
                echo "<script>alert('验证码错误');location.href='" . site_url('member/info/pwd_edit') . "';</script>";
                exit;
            }
            
            if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
                header("Content-type: text/html; charset=utf-8");
                echo "<script>alert('验证码已失效，请重新获取');location.href='" . site_url('member/info/pwd_edit') . "';</script>";
                exit;
            }
        } else {
            //验证新旧密码是否同
            if($old_pwd == $new_pwd){
                header("Content-type: text/html; charset=utf-8");
                echo "<script>alert('新密码不能和旧密码相同！');location.href='" . site_url('member/info/pwd_edit') . "';</script>";exit;
            }else{
                //接口匹配用户密码
                $url = $this->url_prefix.'Customer/check_pwd';
                $post['password'] = $old_pwd;
                $post['customer_id'] = $this->session->userdata('user_id');
                $result = json_decode($this->curl_post_result($url,$post),true);
                
                if (!$result['status']) {
                    header("Content-type: text/html; charset=utf-8");
                    echo "<script>alert('旧密码输入错误');javascript:history.back();</script>";
                    exit;
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
                $content = "您的密码修改成功，如非本人操作请致电400-0029-777";
                $this->sendShortmMsg($customer['mobile'], $content);
            }
            header("Content-type: text/html; charset=utf-8");
            echo "<script>alert('密码修改成功');location.href='" . site_url('member/info/') . "';</script>";exit;
        }else{//修改失败
            echo "<script>alert('网络异常！');location.href='" . site_url('Member/info/pwd_edit') . "';</script>";exit;
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
        } else if (date('Y-m-d H:i:s', strtotime("-90 second")) > $set_time) {
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
            

            if ($res) {
                $this->session->unset_userdata('verfity_yzm_2');
                $this->session->unset_userdata('verfity_mobile_2');
                $this->session->unset_userdata('verfity_settime_2');
                
                $content = "您的支付密码修改成功，如非本人操作请致电400-0029-777";
                $this->sendShortmMsg($customer['mobile'], $content);
                $ref_from_url = $this->session->userdata("ref_from_url");
                $this->session->unset_userdata("ref_from_url");
                if($ref_from_url){
                    redirect($ref_from_url);
                    exit;
                }
                redirect("member/info/paypwd_edit/1");
            } else {
                redirect("member/info/paypwd_edit/3");
                exit();
            }
        }
    }

    /**
     * 发送短信提示操作
     * @param unknown $mobile
     * @param unknown $content
     */
    private function sendShortmMsg($mobile, $content)
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
}