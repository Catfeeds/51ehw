<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Save_set extends Front_Controller {

    public function __construct()
    {
        parent::__construct();
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $this->load->model('customer_mdl');
        $this->load->model('customer_address_mdl');
    }

    public function index()
    {
        $this->save_set();
    }
    
    // 安全设置界面
    public function save_set()
    {
        $user_id = $this->session->userdata('user_id');
        $data['customer'] = $this->customer_mdl->load($user_id);
        $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
        $data['pay_account'] = json_decode($this->curl_get_result($url),true);
        
        
        //调用接口处理->验证实名认证
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $user_id;
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        
        //默认未实名验证
        $data['idcard'] = false;
        if($customer["idcard"]){
            //已经实名验证
            $data['idcard'] = true;
        }
        
        
        $data['title'] = '安全设置';
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/save_set', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    // 设置支付密码
    public function paypwd_set($status = 0)
    {
        if(stristr($_SERVER['HTTP_USER_AGENT'],"Android") || stristr($_SERVER['HTTP_USER_AGENT'],"iPhone") || stristr($_SERVER['HTTP_USER_AGENT'],"wp")){
            redirect("member/info/passpwd_edit");
            exit;
        }
        $user_id = $this->session->userdata('user_id');
        $data['customer'] = $this->customer_mdl->load($user_id);
        
        $data['title'] = '安全设置--支付密码';
        $data['status'] = 'paypassword';
        
        if (isset($status) && $status === 'forgetpay') {
            $data['forget'] = 'forgetpaypassword';
        }
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/paypwd_set', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    public function paypwd_update($status = 0)
    {
        $user_id = $this->session->userdata('user_id');
        $data['customer'] = $this->customer_mdl->load($user_id);
        
        switch ($status) {
            case 1:
                $data['msg'] = '旧密码错误！';
        }
        $data['title'] = '安全设置--修改支付密码';
        $data['status'] = 'updatepaypassword';
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/paypwd_set', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 修改支付密码页面2
     * @param number $status
     */
    public function set_paypwd($status = 0)
    {
        if ($this->session->userdata('pay') == 1) {
            $mobile_vertify = $this->input->get_post('m_verfity');
             $mobile_verfity = $this->session->userdata('verfity_yzm_2');
            
            
            if ($mobile_verfity != null && $mobile_verfity == $mobile_vertify) {
                $data['title'] = '设置支付密码';
                switch ($status) {
                    case 1:
                        $data['status'] = 'updatepay';
                }
                
                $data['m_verfity'] = $mobile_vertify;
                
                $this->load->view('head', $data);
                $this->load->view('_header', $data);
                $this->load->view('customer/paypwd_two', $data);
                $this->load->view('_footer', $data);
                $this->load->view('foot', $data);
            } else {
                show_404();
            }
        } else {
            redirect('member/save_set');
        }
    }

    /**
     * 验证支付密码
     */
    public function check_old_paypassword()
    {
        $password = $this->input->post('password');
        $user_id = $this->session->userdata('user_id');
        
        //接口-验证支付密码
        $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
        $account = json_decode($this->curl_get_result($url),true);
        if ($password != null && md5($password) == $account['pay_passwd']) {
            
            $this->load->library('Short_Message_Factory', '', 'message');
            $num = $this->message->random(6);
            $this->session->set_userdata('pay', 1);
            $this->session->set_userdata('verfity_yzm_2', $num);
            
            redirect('member/save_set/set_paypwd/1?m_verfity=' . $num);
        } else {
            redirect('member/save_set/paypwd_update/1');
        }
    }
    
    
    /**
     * ajax验证支付密码
     */
    public function check_paypassword_ajax()
    {
        $msg = array(
            'Result' => false
        );
        $user_id = $this->session->userdata('user_id');
        //接口-验证支付密码
        $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
        $account = json_decode($this->curl_get_result($url),true);
        $password = $this->input->post('password');
        if ($password != null && md5($password) != $account['pay_passwd']) {
            $msg = array(
                'Result' => true
            );
        }
        echo json_encode($msg);
    }

    /**
     * 修改支付密码
     * @param number $status
     */
    public function update_paypwd($status = 0)
    {
        $paypwd = $this->input->post('paypassword');//密码
        $mobile_vertify = $this->input->get_post('m_verfity');//验证码
        $mobile_verfity = $this->session->userdata('verfity_yzm_2');
        $user_id = $this->session->userdata('user_id');
        if ($paypwd != null && $user_id != null && $mobile_vertify != null && $mobile_vertify == $mobile_verfity) {
            
            //接口-验证支付密码
            $url = $this->url_prefix.'Customer/fortune/?customer_id='.$user_id;
            $pay_account = json_decode($this->curl_get_result($url),true);
            
            //判断是否有支付账户，没有则创建
            if (count($pay_account) == 0) {
                //查询用户信息
                $this->load->model('customer_mdl');
                $customer = $this->customer_mdl->load($user_id);
                //接口-创建支付账户
                $url = $this->url_prefix.'Customer/add_pay';
                $post['customer_id'] = $user_id; 
                $post['password'] = $customer['password'];
                $post['name'] = $customer['name'];
                $post['pay_passwd'] = $paypwd;
            }else{
                //接口-修改支付密码
                $url = $this->url_prefix.'Customer/update_paypwd';
                $post['user_id'] = $user_id; 
                $post['paypassword'] = $paypwd;
                $post['old_passwd'] = $pay_account['pay_passwd'];
            }
            $res = json_decode($this->curl_post_result($url,$post),true);
            
            
            //清除session
            $this->session->unset_userdata('verfity_yzm_2');
            $this->session->unset_userdata('pay');
            
            if ($res['status']) {
                switch ($status) {
                    case 1:
                        redirect('member/save_set/success_setpaypwd/3');
                        break;
                    default:
                        redirect('member/save_set/success_setpaypwd/1');
                        break;
                }
            } else {
                $data['type'] = true;
                $data['auto'] = true;
                $data['msg'] = '支付密码设置失败！';
                $data['goto'] = site_url('member/save_set');
                return $this->load->view('message', $data);
            }
        } else {
            $this->session->unset_userdata('paypassword_mobile_verfity');
            $this->session->unset_userdata('pay');
            show_404();
        }
    }

    public function success_setpaypwd($status)
    {
        switch ($status) {
            case 1:
                $data['title'] = '设置支付密码成功';
                $data['type'] = 'pay';
                break;
            case 2:
                $data['title'] = '绑定手机号码成功';
                $data['type'] = 'mobile';
                break;
            case 3:
                $data['title'] = '修改支付密码成功';
                $data['type'] = 'updatepay';
                break;
        }
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/paypwd_three', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 更换手机第一步
     */
    public function change_mobile()
    {
        $user_id = $this->session->userdata('user_id');
        $data['customer'] = $this->customer_mdl->load($user_id);
        
        $data['title'] = '绑定手机';
        $data['status'] = 'mobile';
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('customer/paypwd_set', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 更换手机第二步
     */
    public function set_mobile()
    {
        if ($this->session->userdata('mobile') == 1) {
            $mobile_verfity = $this->input->get('m_verfity');
            if (($mobile_verfity != '' && $mobile_verfity == $this->session->userdata('verfity_yzm_3')) || $this->session->userdata('binding_mobile') == 1) {
                $data['title'] = '绑定手机号';
                $this->load->view('head', $data);
                $this->load->view('_header', $data);
                $this->load->view('customer/change_mobile', $data);
                $this->load->view('_footer', $data);
                $this->load->view('foot', $data);
            } else {
                show_404();
            }
        } else {
            redirect('Member/save_set');
        }
    }
    
    /**
     * 更换手机第三步
     * 同步数据
     */
    public function update_mobile()
    {
        $mobile = $this->input->post('mobile');
        $mobile_verify = $this->input->post('mobile_vertify');
        $checkmobile = $this->session->userdata('verfity_mobile_4');
        $checkmobile_verify = $this->session->userdata('verfity_yzm_4');
        
        $this->session->unset_userdata('verfity_yzm_4');
        $this->session->unset_userdata('verfity_mobile_4');
        $this->session->unset_userdata('binding_mobile');
        
        $user_id = $this->session->userdata('user_id');
        
        if ($mobile != null && $checkmobile != null && $mobile_verify != null && $mobile == $checkmobile && $mobile_verify == $checkmobile_verify) {
            //接口-更换手机同步数据
            $url = $this->url_prefix.'Customer/info_save';
            $post['user_id'] = $user_id;
            $post['name'] = $mobile;
            $post['mobile'] = $mobile;
            $res = json_decode($this->curl_post_result($url,$post),true);
            if ($res['status']) {

                $this->session->set_userdata("user_name",$mobile);
                redirect('Member/save_set/success_setpaypwd/2');
            } else {
                $data['type'] = true;
                $data['auto'] = true;
                $data['msg'] = '手机绑定失败！';
                $data['goto'] = site_url('member/save_set');
                return $this->load->view('message', $data);
            }
        } else {
            echo "<script>history.back();</script>";
        }
    }

//     /**
//      * 已废除 2016-12-30 锋
//      * 用户未有pay账户
//      * 
//      * @param unknown $user_id            
//      * @return num
//      */
//     private function create_pay($user_id)
//     {
//         $this->load->model('customer_mdl');
//         $this->load->model('pay_account_mdl');
//         $this->load->model('pay_relation_mdl');
        
//         $customer = $this->customer_mdl->load($user_id);
        
//         $this->pay_account_mdl->name = $customer['name'];
//         $this->pay_account_mdl->passwd = '888888';
//         $pay_account_id = $this->pay_account_mdl->createpay_account();
//         if ($pay_account_id) {
//             $pay_relation = $this->pay_relation_mdl->load_by_customerId($user_id);
//             if (count($pay_relation) > 0) {
//                 $this->pay_relation_mdl->id_pay = $pay_account_id;
//                 $pay_relation_id = $this->pay_relation_mdl->update($user_id);
//             } else {
//                 $this->pay_relation_mdl->id_pay = $pay_account_id;
//                 $this->pay_relation_mdl->customer_id = $user_id;
//                 $pay_relation_id = $this->pay_relation_mdl->createpay_relation();
//             }
//         }
//         return $pay_relation_id;
//     }
}