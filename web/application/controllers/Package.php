<?php

/**
 *  M包
 *
 *
 */
class Package extends Front_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('package_mdl');
    }

    // --------------------------------------------------------------------

    /**
     * 进入发送红包
     */
    function index()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            // 检查登录
            $customer_id = $this->session->userdata("user_id");
            if ($customer_id == "") {
                $this->session->set_userdata('ref_from_url', site_url('package'));
                header('Location: ' . MAINURL . 'index.php/third_signin/wechat');
                return;
            } else {
                $this->load->model("customer_mdl");
                $customer = $this->customer_mdl->load($customer_id);
                // 如果有写手机
                if ($customer['mobile'] != "") {
                    $this->load->view('package/list_view');
                } else {
                    $this->session->set_userdata('redirect', site_url('package/login'));
                    $this->load->view('package/login_view');
                }
            }
        } else {
            $this->session->set_userdata('redirect', site_url('package/login'));
            $this->load->view('package/login_view');
        }
    }

    // -----------------------------------------------------------------------------------

    /**
     */
    public function login()
    {
        $customer_id = $this->session->userdata("user_id");

        if ($customer_id == "") {
            header('Location: ' . site_url('package'));
            return;
        }
        // 读出用户
        $this->load->model("customer_mdl");
        $customer = $this->customer_mdl->load($customer_id);
        // 如果微信登录的，绑定和整合两个用户
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {}
        // 判断用户是否有手机
        if ($customer['mobile'] == "") {
            $this->customer_mdl->update_username();
        }else{
            $this->load->view('package/list_view');
        }
    }

    // ---------------------------------------------------------------------------------

    /**
     * 整合两个用户
     */
    public function update_login()
    {
        $customer_id = $this->session->userdata("user_id");
        $this->load->model("customer_mdl");

        $name = $this->input->post('tbxLoginNickname');
        $password = $this->input->post('tbxLoginPassword');

        $this->customer_mdl->name = $name;
        $this->customer_mdl->password = $password;
        $customer2 = $this->customer_mdl->check_customer();

        if (! $customer2) {
            ?>
<script type="text/javascript">
<!--
	alert("用户名密码错误！");
	history.back();
//-->
</script>
<?php
            return;
        }

        // 读出用户，将两个用户合并
        $customer = $this->customer_mdl->load($customer_id);
        $this->customer_mdl->wechat_account = $customer['wechat_account'];
        $this->customer_mdl->nick_name = $customer['nick_name'];
        $this->customer_mdl->img_avatar = $customer['img_avatar'];
        if ($customer2['mobile'] == "") {
            $this->customer_mdl->mobile = $name;
        }
        $this->customer_mdl->update($customer2['id']);
        if ($customer['id'] != $customer2['id']) {
            $this->customer_mdl->delete($customer_id);
        }

        // 重新更新登录信息
        $customer = array(
            'user_name' => $customer2['name'],
            'user_id' => $customer2['id'],
            'user_in' => TRUE,
            'is_vip' => $customer2['is_vip'],
            'is_active' => $customer2['is_active'],
            'user_last_login' => $customer2['last_login_at'],
            'corporation_id' => $customer2['corporation_id'],
            'privilege_id' => $customer2['privilege_id']
        );

        if ($customer2['corporation_id'] > 0) {

            $this->load->model('customer_corporation_mdl');
            $corpinfo = $this->customer_corporation_mdl->getById($customer2['corporation_id']);

            if ($corpinfo != null) {
                $customer2["corporation_status"] = $corpinfo["status"];
            }
        }

        $this->session->set_userdata($customer);

        $this->load->view('package/list_view');
    }

    /**
     * 提交发送红包
     */
    function send_package()
    {
        $customer_id = $this->session->userdata("user_id");

        if ($customer_id == "") {
            header('Location: ' . site_url('package'));
            return;
        }

        $data['num'] = $this->input->post('num');
        $data['per_m'] = $this->input->post('per_m');
        $data['desc'] = $this->input->post('desc');
        $data['state'] = $this->input->post('state');
        $total = $data['state'] == 1 ? ($data['num'] * $data['per_m']) : $data['per_m'];
        $data['total'] = $total;

        $this->load->model('customer_mdl');
        $this->load->model("customer_currency_log_mdl",'customer_currency_log');
        $this->load->model ( 'pay_account_mdl' );
        //开启事务
        $this->db->trans_begin();

        //扣除M券
        $row = $this->customer_mdl->update_Credit($customer_id, $total);
        //判断是否够余额
        if (! $row) {
            //回滚
            $this->db->trans_rollback();
            ?>
            <script type="text/javascript">
            	alert("余额不足！");
            	history.back();
            </script>
            <?php

            return;
        }
        //分发红包
        $package_id = $this->package_mdl->send_package($customer_id, $data);
        
        //支付账号
        $customer_pay  = $this->pay_account_mdl->load( $customer_id );
        
        $pay_account_id = $customer_pay['id'];//支付账号ID
        $pay_relation_id = $customer_pay['r_id']; //关联表的ID
        $surplus_m = $customer_pay['M_credit']; //支付前的M券余额
        $credit = '0.00'; //授信
        $time = date('Y-m-d H:i:s');
        
        //上一次M券交易的日志中的信息
        $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
        

        //检测M券是否异常
        if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m){
            $M_credit_data['status'] = '1';
        }else if(!$last_m_log && $surplus_m =='0'){
            $M_credit_data['status'] = '1';
        }else{
            $M_credit_data['status'] = '2';
        }
         
        //M券日志
        $M_credit_data['relation_id'] = $pay_relation_id;
        $M_credit_data['id_event'] = '58';
        $M_credit_data['remark'] = '红包支出';
        $M_credit_data['amount'] = $total;
        $M_credit_data['order_no'] = "";
        $M_credit_data['type'] = '2';
        $M_credit_data['beginning_balance'] = $surplus_m;
        $M_credit_data['ending_balance'] = $surplus_m-$total;
        $M_credit_data['customer_id'] = $customer_id;
        $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);

        
        
        if ($M_credit_log) {
            $this->db->trans_commit();
        } else {
            $this->db->trans_rollback();
            ?>
                <script type="text/javascript">
                	alert("发送失败！");
                	history.back();
                </script>
            <?php
            return;
        }
        
        $this->session->set_userdata('my_package', $package_id);

        redirect(site_url('package/share/' . $package_id));
    }

    //------------------------------------------------------------------------------

    /**
     * 分享出去
     * @param unknown $package_id
     */
    function share($package_id)
    {
        $customer_id = $this->session->userdata("user_id");
        //判断登录
        if ($customer_id == "") {
                $this->session->set_userdata('ref_from_url', site_url('package/share/'.$package_id));
                header('Location: ' . MAINURL . 'index.php/third_signin/wechat');
            return;
        }
        $pack_id = $this->session->userdata('my_package');
        if($pack_id != ""){
            $data['package'] = $this->package_mdl->load($package_id);
            $this->session->unset_userdata('my_package');
            $this->load->view('package/share_view', $data);
            return;
        }else{
            $this->load->model('customer_mdl');
            $customer = $this->customer_mdl->load($customer_id);
            error_log('customer_id:'.$customer_id);
            error_log("customer:".$customer['id']);
            $data['customer'] = $customer;
            $data['package_id'] = $package_id;
            //判断有没有手机号码
            if(!isset($customer['mobile']) || $customer['mobile'] == ""){
                $this->load->view('package/split_view', $data);
            }else{
                $package = $this->package_mdl->load($package_id);
                //判断是否存在红包
                if(!$package){
                        echo '<script type="text/javascript"> alert("非法操作！"); history.back(); </script>';
                        return ;
                }
                $data['sender'] = $this->customer_mdl->load($package['originator']);
                $data['package'] = $package;

                //判断是否抽过红包
                $detail = $this->package_mdl->get_package($package_id, $customer_id);
                if(count($detail) > 0){
                    $data['is_full'] = false;
                    $data['package'] = $detail;
                    $data['getter'] = $this->package_mdl->get_package_list($package_id);
                    $this->load->view('package/show_view', $data);
                }else{
                    //如果红包被抢满
                    if($this->package_mdl->is_package_full($package_id) == 0){
                        $data['is_full'] = true;
                        $data['getter'] = $this->package_mdl->get_package_list($package_id);
                        $this->load->view('package/show_view', $data);
                    }else{
                        $this->load->view('package/broken_view', $data);
                    }
                }
            }
        }
    }

/**
 * 点击拆红包，获取红包
 * @param unknown $package_id
 */
    function get_package($package_id){
        
        $customer_id = $this->session->userdata("user_id");
        //判断登录
        if ($customer_id == "") {
            $this->session->set_userdata('ref_from_url', site_url('package/share/'.$package_id));
            header('Location: ' . MAINURL . 'index.php/third_signin/wechat');
            return;
        }

        //查询红包信息
        $red_detail = $this->package_mdl->load($package_id);
        if(!$red_detail){
            echo "<script>alert('非法操作！');history.back();</script>";
            return ;
        }
        
        //判断是否抽过红包
        $detail = $this->package_mdl->get_package($package_id, $customer_id);
        if(count($detail) > 0){
            $data['is_full'] = false;
            $data['package'] = $detail;
            $data['getter'] = $this->package_mdl->get_package_list($package_id);
            $this->load->view('package/show_view', $data);
        }else{
            
            
            
            $this->load->model('customer_mdl');
            $this->load->model("customer_currency_log_mdl",'customer_currency_log');
            $this->load->model ( 'pay_account_mdl' );
            //开启事务
            $this->db->trans_begin();

            //领取红包
            $this->package_mdl->get_one_package($package_id, $customer_id);
            
            //支付账号
            $customer_pay  = $this->pay_account_mdl->load( $customer_id );
            
            $pay_account_id = $customer_pay['id'];//支付账号ID
            $pay_relation_id = $customer_pay['r_id']; //关联表的ID
            $surplus_m = $customer_pay['M_credit']; //支付前的M券余额
            $credit = '0.00'; //授信
            $time = date('Y-m-d H:i:s');
            
            //上一次M券交易的日志中的信息
            $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
            
    
            //检测M券是否异常
            if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m){
                $M_credit_data['status'] = '1';
            }else if(!$last_m_log && $surplus_m =='0'){
                $M_credit_data['status'] = '1';
            }else{
                $M_credit_data['status'] = '2';
            }
             
            //M券日志
            $M_credit_data['relation_id'] = $pay_relation_id;
            $M_credit_data['id_event'] = '59';
            $M_credit_data['remark'] = '红包收入';
            $M_credit_data['amount'] = $red_detail['total']/$red_detail['num'];
            $M_credit_data['order_no'] = "";
            $M_credit_data['type'] = '1';
            $M_credit_data['beginning_balance'] = $surplus_m;
            $M_credit_data['ending_balance'] = $surplus_m+($red_detail['total']/$red_detail['num']);
            $M_credit_data['customer_id'] = $customer_id;
            $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
    
            
            
            if ($M_credit_log) {
                $this->db->trans_commit();
            } else {
                $this->db->trans_rollback();
                ?>
                    <script type="text/javascript">
                    	alert("发送失败！");
                    	history.back();
                    </script>
                <?php
                return;
            }
                    
            
            redirect(site_url('package/share/' . $package_id));
        }
    }

    /**
     * 保存手机号码
     * @param unknown $package_id
     */
    function save_mobile($package_id){
        $customer_id = $this->session->userdata("user_id");
        $mobile = $this->input->post('mobile');

        $this->load->model('customer_mdl');

        if($this->customer_mdl->check_mobile($mobile)){
            $data['mobile'] = $mobile;
            $data['package_id'] = $package_id;
            $this->load->view('package/get_login_view', $data);
            return;
        }else{
            $this->customer_mdl->bind_mobile($customer_id,$mobile);
        }

        redirect(site_url('package/share/' . $package_id));

    }

    // ---------------------------------------------------------------------------------

    /**
     * 整合两个用户
     */
    public function update_get_login()
    {
        $customer_id = $this->session->userdata("user_id");
        $this->load->model("customer_mdl");

        $name = $this->input->post('tbxLoginNickname');
        $password = $this->input->post('tbxLoginPassword');
        $mobile = $this->input->post('mobile');
        $package_id = $this->input->post('package_id');

        $this->customer_mdl->name = $name;
        $this->customer_mdl->password = $password;
        $this->customer_mdl->mobile = $mobile;
        $customer2 = $this->customer_mdl->check_customer_with_mobile();

        if (count($customer2) == 0) {
            ?>
    <script type="text/javascript">
    <!--
    	alert("用户名密码错误！");
    	history.back();
    //-->
    </script>
    <?php
                return;
            }

            // 读出用户，将两个用户合并
            $customer = $this->customer_mdl->load($customer_id);
            $this->customer_mdl->wechat_account = $customer['wechat_account'];
            $this->customer_mdl->nick_name = $customer['nick_name'];
            $this->customer_mdl->img_avatar = $customer['img_avatar'];
            $this->customer_mdl->update($customer2['id']);
            if ($customer['id'] != $customer2['id']) {
                $this->customer_mdl->delete($customer_id);
            }

            // 重新更新登录信息
            $customer = array(
                'user_name' => $customer2['name'],
                'user_id' => $customer2['id'],
                'user_in' => TRUE,
                'is_vip' => $customer2['is_vip'],
                'is_active' => $customer2['is_active'],
                'user_last_login' => $customer2['last_login_at'],
                'corporation_id' => $customer2['corporation_id'],
                'privilege_id' => $customer2['privilege_id']
            );
            $this->session->sess_destroy();

            $this->session->set_userdata($customer);

            redirect(site_url('package/share/' . $package_id));
            //echo site_url('package/share/' . $package_id);

        return;
    }

    function test_jsapi(){
        $this->load->library('js_api_sdk');
        $this->load->view('package/test_jsapi_view');
    }

}