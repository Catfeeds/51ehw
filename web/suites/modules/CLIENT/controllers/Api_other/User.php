<?php

if (! defined('BASEPATH')) exit('No direct script access allowed');

class User extends External_Api_Controller
{
    
    var $account_key;
    var $mem;
    // ------------------------------------------------------------
    /**
    */
    public function __construct()
    {
        parent::__construct();
        //连接memcache
        $this->mem = parent::tel_memcached();
        header("Content-type: application/json");
    }


    // --------------------------------------------------------------------

    /**
     * 登出 ok
     */
    function logout()
    {   
        $this->account_key = $this->input->post('key');
        
        if($this->account_key){
             
            if($this->mem->delete($this->account_key) ){ 
                $result ['status'] = 0;
                $result ['message'] = '退出成功';
            }else{ 
                $result ['status'] = '-1';
                $result ['message'] = '退出失败';
            }
             
            echo json_encode($result);
        }
    }

    // --------------------------------------------------------------------

    
    /**
     * 登录 ok
     */
    function login()
    {
        $name = $this->input->post('username');
        $password = $this->input->post('password');
        $key = md5($name.rand(0,999999));
        
        //验证参数是否正确
        if($name && $password){
            
            //接口获取用户信息
            $post['tbxLoginNickname'] = $name;
            $post['tbxLoginPassword'] = $password;
            $post['is_api'] = true;
            $url = $this->url_prefix.'Customer/check_customer';
            
            $_customer = json_decode($this->curl_post_result($url,$post),true);

            
            if ( isset($_customer['password']) && $_customer['password'] == md5($post['tbxLoginPassword']) ) {
                
                
                 $customer = array(
                    'user_name' => !empty($_customer['nick_name'])?$_customer['nick_name']:(!empty($_customer['wechat_nickname'])?$_customer['wechat_nickname']:$_customer['name']),
                    'user_id' => $_customer['id'],
                    'user_in' => TRUE,
                    'is_vip' => $_customer['is_vip'],
                    'is_active' => $_customer['is_active'],
                    'user_last_login' => $_customer['last_login_at'],
                    'corporation_id' => 0,
//                     'privilege_id' => 0,
                    'openid' => $_customer['openid'],
                    'pay_relation' => $_customer['pay_relation']['id'],
                    'is_active' => $_customer['is_active'],
                    'email' => $_customer['email'],
                    'mobile' => $_customer['mobile'],
                    'name' => $_customer['name'],
                    'user_key' => $key,
                    'password' => $_customer['password']
                 );
    
                 //查询企业信息
                 $this->load->model("corporation_mdl");
                 $corpinfo = $this->corporation_mdl->load($_customer['id']);
                 
                 if ($corpinfo != null) {
                     $customer["corporation_status"] = $corpinfo["status"];
                     $customer["approval_status"] = $corpinfo["approval_status"];
                     $customer['corporation_id'] = $corpinfo['id'];
//                      $customer['privilege_id'] = $corpinfo['privilege_id'];
                 }

                 
                 

                 
                 //写入Memcahce  //登录成功
                 if( $this->mem->set($key,$customer,MEMCACHE_COMPRESSED,1800) )
                 {
                
                    $this->session->set_userdata($customer);
                    
                    $result['data'] = array(
                        'customer_id' => $customer['user_id'],
                        'name' => $customer['name'],
                        'nick_name' => $customer['user_name'],
                        'email' => $customer['email'],
                        'mobile' => $customer['mobile'],
                        'key' => $customer['user_key'],
                        'corporation_id' => $customer['corporation_id']
                        
                    );
        
                    $result['status'] = 0;
                    $result['message'] = '登录成功';
                
                }else{ 
                    
                    $result['status'] = '-2';
                    $result['message'] = '登录失败';
                }
                
            } else {
                $result['status'] = '-1';
                $result['message'] = '用户名或密码错误';
                
            }
        }else{ 
            
            $result ['status'] = '-253';
            $result ['message'] = '缺少参数';
        }
        echo json_encode($result);
    }

    
   // ------------------------------------------------------------
    /**
     * 用户消费排行榜
     */
    
    public function user_convert_list(){ 
        $status = $this->input->post('status');
        $page = $this->input->post('page') ? $this->input->post('page') : 1;//页数
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;//默认10条
        
        $per_page = ($page -1) * $limit;
        
        $this->load->model('order_mdl');
        $result['data'] = $this->order_mdl->user_convert_list($status,$limit, $per_page);
        
        $result['data']['total_num'] = $this->order_mdl->user_convert_list($status);
        $result['status'] = 0;
        $result['message'] = '获取成功';
        
        echo json_encode($result);
        
    }
    
    // ------------------------------------------------------------
    /**
     * 商家售出排行榜
     */
    public function corporation_sell_list(){
        $status = $this->input->post('status');
        $page = $this->input->post('page') ? $this->input->post('page') : 1;//页数
        $limit = $this->input->post('limit') ? $this->input->post('limit') : 10;//默认10条
    
        $per_page = ($page -1) * $limit;
    
        $this->load->model('order_mdl');
        $this->order_mdl->corporation_id = true;
        $data = $this->order_mdl->user_convert_list($status,$limit, $per_page);
        
        if(count($data) > 0 ){
            foreach ($data as $k=>$v){ 
                if( !strstr($v['img_url'],"http") )
                     $data[$k]['img_url'] = IMAGE_URL.$v['img_url'];
            }
        }
        
        $result['data'] = $data;
        $result['data']['total_num'] = $this->order_mdl->user_convert_list($status);
        $result['status'] = 0;
        $result['message'] = '获取成功';
    
        echo json_encode($result);
    
    }
    
   // ------------------------------------------------------------
   
    /**
     * 用户消费信息 - 需得到：用户名-分类名-商品-消费时间。
     * 
     */
    
    public function convert_info(){ 
        $limit = !empty($this->input->post('limit') ) ? $this->input->post('limit') : 10;
        
        $this->load->model('order_mdl');
        $result['data'] = $this->order_mdl->customer_convert_info($limit);
        $result['status'] = 0;
        $result['message'] = '获取成功';
        echo json_encode($result);
    }
    // ------------------------------------------------------------
   //注册
   function register(){ 
        
        $this->load->model('customer_mdl');
        
        $name = $this->input->post('name');
        $mobile = $this->input->post('name');
        $nick_name = $this->input->post('nick_name') ? $this->input->post('nick_name') : $name;
        $password = $this->input->post('password');
        $mobile_vertify = $this->input->post('mobile_vertify');
        $mobile_vertify_key = $this->input->post('mobile_key');
        $memcache_ok = false;
        
        if( $name && $password && $mobile_vertify && $mobile_vertify_key){
            
            //获取手机验证码
            $mobile_vertify2 = $this->mem->get( $mobile_vertify_key );
            
            if( !$mobile_vertify2 ) {
                $result['status'] = '-4';
                $result['message'] = '验证码超时';
                echo json_encode($result);
                return;
            }
            
            //验证码判断
            if ($mobile_vertify != $mobile_vertify2['num'] || $mobile != $mobile_vertify2['mobile'] ) {
                $result['status'] = '-3';
                $result['message'] = '手机验证码填写错误';
                echo json_encode($result);
                return;
            }
            
            switch ($this->type){
                case 1:
                    $form = 'advertisement_api';
                    break;
            }
            
            //调用接口注册用户
            //拼装接口需要的数据
            $post_data['name'] = $name;
            $post_data['mobile'] = $name;
            $post_data['Nickname'] = $nick_name;
            $post_data['tbxRegisterPassword'] = $password;
            $post_data['app_id'] = 0;
            $post_data['registry_by'] = $form;
            $post_data['time'] = date('Y-m-d H:i:s');
            
            $url = $this->url_prefix.'Customer/save';
            $user = json_decode($this->curl_post_result($url,$post_data),true);
            
            
            switch ($user['status']){
                case 1:
                    $status = '-2';
                    $messahe = "用户已经存在";
                    break;
                case 2:
                    $status = '-1';
                    $messahe =  "注册失败";
                    break;
                case 3://注册成功
                    $status = '0';
                    $messahe = "注册成功";
                    $customer_id = $user['customer_id'];
                    
                    $customer = array(
                        'user_name' => $nick_name ? $nick_name : $mobile,
                        'user_id' => $customer_id,
                        'is_vip' => 0,
                        'promo_name' => $name,
                        'name' => $name,
                        'user_last_login' => '',
                        'user_in' => TRUE,
                        'corporation_id' => 0,
//                         'privilege_id' => 0,
                        'pay_relation' => $user['pay_relation_id']
                    );
                    $key = md5($name.rand(0,999999));
                    //写入memcached
                    if( $this->mem->set($key,$customer,MEMCACHE_COMPRESSED,1800) )
                    { 
                        
                        $result['data']['key'] = $key;
                    }
                    //删除改验证码
                    $this->mem->delete($mobile_vertify_key);
                    
                    // 生成二维码图片
                    //$this->generateBarcode($customer_id);
                    
//                     $this->session->set_userdata($customer);
                    break;
            }
            
            $result['status'] = $status;
            $result['message'] = $messahe;
            echo json_encode($result);
            return;
            
        }else{ 
            $result['status'] = '-253';
            $result['message'] = '缺少参数';
        }
        echo json_encode($result);  
    }
    
    // ------------------------------------------------------------
    /**
     * 修改用户密码
     */
    public function update_password()
    {
        //验证是否登录 ok
        $this->account_key = $this->input->post('key');
        $cache_result = $this->is_login();
        
        $customer_id = $cache_result['user_id'];
         
        $old_pwd = $this->input->post('password');
        $new_pwd = $this->input->post('new_password');
        
        if( $old_pwd && $new_pwd ){
        
            //如果session中没有
            if( empty( $cache_result['password'] ) )
            { 
                //接口获取旧密码
                $post['type'] = 'id';
                $post['id'] = $customer_id;
                $url = $this->url_prefix.'Customer/load_by_where';
                $customer_info = json_decode($this->curl_post_result($url,$post),true);
                $cache_result['password'] = $customer_info['password'];
            }
            
            if ( $cache_result['password'] != md5($old_pwd) ) {
                
                $result['status'] = '-2';
                $result['message'] = '旧密码错误';
                echo json_encode($result);
                return;
            }
            
            //接口修改密码
            $post['customer_id'] = $customer_id;
            $post['password'] = $new_pwd;
            $url = $this->url_prefix.'Customer/update_pwd';
            
            $row = json_decode($this->curl_post_result($url,$post),true);
            
            
            if ( $row['status'] ) {
        
                $cache_result['password'] = md5( $new_pwd );
                
                //将修改的新密码写入memcached
                $this->mem->set($this->account_key,$cache_result,MEMCACHE_COMPRESSED,1800);
              
                if( !empty($cache_result['mobile']) )
                {
                    // pc web发送短信提示修改成功暂时无
                    $content = "您的密码修改成功，如非本人操作请致电400-0029-777";
                    $this->sendShortmMsg($cache_result['mobile'], $content);
                }
                
                $result['status'] = 0;
                $result['message'] = '修改成功';
               
            }else{ 
                $result['status'] = '-1';
                $result['message'] = '修改失败';
            }
            
        }else{ 
            $result ['status'] = '-253';
            $result ['message'] = '缺少参数';
        }
        echo json_encode($result);
    }
    
    
    // ------------------------------------------------------------
    
    /**
     * 忘记密码
     */
    public function forget_password()
    {
        //接收参数
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $ConfirmPassword = $this->input->post('new_password');
        $mobile_vertify = $this->input->post('mobile_vertify');
        $mobile_vertify_key = $this->input->post('mobile_key');
        
        //判断参数是否正确
        if ($name != null && $password != null && $ConfirmPassword != null && $mobile_vertify_key) {
            
            if($ConfirmPassword == $password){
            
                $mobile_vertify2 = $this->mem->get( $mobile_vertify_key );
                
                if( !$mobile_vertify2 ) {
                    $result['status'] = '-4';
                    $result['message'] = '验证码超时';
                    echo json_encode($result);
                    return;
                }
                //判断手机验证码是否正确
                if($mobile_vertify == $mobile_vertify2['num'] && $mobile_vertify2['mobile'] == $name){
                    
                    //接口修改密码
                    $post['password'] = $password;
                    $post['mobile'] = $name;
                    $url = $this->url_prefix.'Api_advertisement/Customer/forget_password';
                    
                    $return = json_decode($this->curl_post_result($url,$post),true);
                    
                    if( $return['status'] == 1 ){ 
                        
                        $result['status'] = 0;
                        $result['message'] = '修改成功';
                        // pc web发送短信提示修改成功暂时无
                        $content = "您的密码修改成功，如非本人操作请致电400-0029-777";
                        $this->sendShortmMsg($name, $content);
                        $this->mem->delete($mobile_vertify_key);
                        
                    }else if($return['status'] == '-4'){
                         
                        $result['status'] = '-4';
                        $result['message'] = '用户不存在';
                    
                    }else{ 
                        
                        $result['status'] = '-1';
                        $result['message'] = '修改失败';
                    }
                    
                }else{

                    $result['status'] = '-3';
                    $result['message'] = '手机验证码错误';
                }
                
            }else{ 
                $result['status'] = '-2';
                $result['message'] = '两次输入的密码不一致';
            }
            
        }else{ 
            $result['status'] = '-253';
            $result['message'] = '缺少参数';
        }

        echo json_encode($result);
    }
    
    // ------------------------------------------------------------
    
    
    /**
     * 保存用户资料
     */ 
    public function update_user()
    {
        //验证是否登录
        $this->account_key = $this->input->post('key');
        $cache_result = $this->is_login();
        
        $customer_id = $cache_result['user_id'];
        
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $real_name = $this->input->post('real_name');
        $nick_name = $this->input->post('nick_name');
        $sex = $this->input->post('sex');
        $job = $this->input->post('job');
        
        
        
        if($email)
            $post['email'] = $email;
        
        if($phone)
            $post['phone'] = $phone;
        
        if($nick_name)
            $post['nick_name'] = $nick_name;
        
        if($job)
            $post['job'] = $job;
        
        if($real_name)
            $post['real_name'] = $real_name;
        
        $post['sex'] = $sex;
        $post['user_id'] = $customer_id;
          
            
//         if($nick_name)
//             $this->session->set_userdata('user_name', $nick_name);
        
        //接口修改信息
        $url = $this->url_prefix.'Customer/info_save';
        
        $return = json_decode($this->curl_post_result($url,$post),true);
        
        if( $return['status'] ){ 
            $result['status'] = 0;
            $result['message'] = '修改成功';
        }else{
            $result['status'] = '-1';
            $result['message'] = '修改失败';
        }
        
   
        echo json_encode($result);
    }
    
    
    // ------------------------------------------------------------
    
    /**
     * 查询用户基本信息和资金
     */
    public function user_detaile(){ 
        //验证是否登录
        $this->account_key = $this->input->post('key');
        $cache_result = $this->is_login();
       
        $customer_id = $cache_result['user_id'];
        
        //接口获取信息
        $post['customer_id'] = $customer_id;
        $url = $this->url_prefix.'Customer/load';
        
        $data = json_decode($this->curl_post_result($url,$post),true);
       
        if($data){
            $result['data']['id'] = $data['id'];
            $result['data']['name'] = $data['name'];
            $result['data']['real_name'] = $data['real_name'];
            $result['data']['nick_name'] = $data['nick_name'];
            $result['data']['sex'] = $data['sex'];
            $result['data']['phone'] = $data['phone'];
            $result['data']['mobile'] = $data['mobile'];
            $result['data']['email'] = $data['email'];
            $result['data']['nick_name'] = $data['nick_name'];
            $result['data']['M_credit'] = $data['M_credit'];
            $result['data']['cash'] = $data['cash'];
            $result['status'] = 0;
            $result['message'] = '获取成功';
        }else{ 
            $result['status'] = '-1';
            $result['message'] = '获取失败';
        }
        
        echo json_encode($result);
    }
    
    
 // ------------------------------------------------------------
    
    /**
     * 验证用户是否已存在
     */
    function check_name()
    {
        $name = $this->input->post('name');
        $this->load->model('customer_mdl');
        
        if( $name ){ 
            
            $result = array(
                'status' => '-1',
                'message' => '不存在'
            );
           
            if ($this->customer_mdl->check_name($name)) {
                $result = array(
                    'status' => 0,
                    'message' => '用户名已存在'
                );
            }
    
       }else { 
           
           $result = array(
               'status' => '-253',
               'message' => '缺少参数'
           );
       }
        echo json_encode($result);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 验证手机是否已绑定 ajax
     */
    function check_mobile_binding_info()
    {
        $name = $this->input->get('mobile');
        $this->load->model('customer_mdl');
        $msg = array(
            'Result' => 0
        );
        if ($name) {
            $customer = $this->customer_mdl->load($name);
            if ($customer['wechat_account']) {
                $msg = array(
                    'Result' => 1
                );
            }
        }
        
        echo json_encode($msg);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 商家注册
     */
    public function corporation_register()
    {

        $this->load->model('corporation_mdl');
    
        $post = true;
        $corporation_name = $this->input->post('corporation_name') ? $this->input->post('corporation_name') : $post = false;//名称
        
        $province_id = $this->input->post('province_id') ? $this->input->post('province_id') : $post = false;//省
        
        $city_id = $this->input->post('city_id') ? $this->input->post('city_id') : $post = false;//市
        
        $district_id = $this->input->post('district_id') ? $this->input->post('district_id') : $post = false; //区
        
        $address = $this->input->post('address') ? $this->input->post('address') : $post = false;//具体地址
        
        $postcode = $this->input->post('postcode') ? $this->input->post('postcode') : $post = false;//邮编
        
        $email = $this->input->post('email') ? $this->input->post('email') : $post = false;//邮编
        
        $contact_name = $this->input->post('contact_name') ? $this->input->post('contact_name') : $post = false;//店铺管理员
        
        $contact_mobile = $this->input->post('contact_mobile') ? $this->input->post('contact_mobile') : $post = false;//店铺联系方式
        
        $industry = $this->input->post('industry') ? $this->input->post('industry') : $post = false;//行业
        
        $nature = $this->input->post('nature') ? $this->input->post('nature') : $post = false; //性质
        
        $legal_person = $this->input->post('legal_person') ? $this->input->post('legal_person') : $post = false; //企业法人
        
        $idcard = $this->input->post('idcard') ? $this->input->post('idcard') : $post = false;//身份证号
        
        $company_registration = $this->input->post('company_registration') ? $this->input->post('company_registration') : $post = false;//工商注册号
        
        $bus_licence_img = $this->input->post('bus_licence_img') ? $this->input->post('bus_licence_img') : $post = false;//营业执照
        
        $idcard_img = $this->input->post('idcard_img') ? $this->input->post('idcard_img') : $post = false;//身份证正反
        
        $proxy_img = $this->input->post('proxy_img') ? $this->input->post('proxy_img') : $post = false; //法人委托书
        
        $name = $this->input->post('name') ? $this->input->post('name') : $post = false; //用户名
        
        $password = $this->input->post('password') ? $this->input->post('password') : $post = false; //密码
        
        $img_url = $this->input->post('img_url'); //店铺图标
        
        if( $post ){
            
            //验证用户名是否存在
            $this->load->model('customer_mdl');
            $this->load->model('Customer_corporation_mdl');
            $is_customer = $this->customer_mdl->load_by_name($name);
            
            if( $is_customer )
                $is_corp = $this->Customer_corporation_mdl->load($is_customer['id']);
            
            if( $is_customer && !empty($is_corp) ) 
            { 

                $result['status'] = '-2';
                $result['message'] = '已经注册过';
                echo json_encode($result);
                return;
             }
            
            
            if( $is_customer && empty( $is_corp ) )
            {
               //修改原密码
                $update_password_status = true;
                
                $this->db->trans_begin();
                $customer_id = $is_customer['id'];
                $is_ok = true;
                
            }else if( !$is_customer )
            {
            
                //注册用户
                $this->db->trans_begin(); 
                switch ($this->type){
                    case 1:
                        $form = 'advertisement_api';
                        break;
                }
                //调用接口注册用户
                //拼装接口需要的数据
                $post_data['name'] = $name;
                $post_data['mobile'] = $name;
                $post_data['Nickname'] = $name;
                $post_data['tbxRegisterPassword'] = $password;
                $post_data['app_id'] = 0;
                $post_data['registry_by'] = $form;
                $post_data['time'] = date('Y-m-d H:i:s');
                
                $url = $this->url_prefix.'Customer/save';
                $user = json_decode($this->curl_post_result( $url,$post_data),true);
               
                if ( $user['status'] == 3 )
                {
                    $customer_id = $user['customer_id'];
                    $is_ok = true;
                
                }
            }
            
            
            if( isset($is_ok) && $is_ok )
            {
                
                switch ($this->type)
                { 
                    case 1:
                        $approval_desc = '广告平台注册商家';
                        break;
                }
                
                
                
                $this->load->model('corporation_mdl', 'cp');
                
                $this->cp->corporation_name = $corporation_name;
        //         $this->cp->corporation_area = $cor_address;
                $this->cp->address = $address;
                $this->cp->postcode = $postcode;
                $this->cp->email = $email;
                $this->cp->province_id = $province_id;
                $this->cp->city_id = $city_id;
                $this->cp->district_id = $district_id;
                $this->cp->contact_name = $contact_name;
                $this->cp->contact_mobile = $contact_mobile;
                $this->cp->customer_id = $customer_id;
                $this->cp->app_id = 0;
                $this->cp->status = 1;
                $this->cp->approval_status = 2;
                $this->cp->approval_desc = $approval_desc;
                $this->cp->img_url = $img_url;
                
                $corporation_id = $this->cp->create();
                
                if($corporation_id)
                {  
                    
                    $this->load->model('corporation_detail_mdl', 'cd');
                    $this->cd->corporation_id = $corporation_id;
                    $this->cd->Industrial_Info = $industry;
                    $this->cd->nature = $nature;
                    $this->cd->legal_person = $legal_person;
                    $this->cd->idcard = $idcard;
                    $this->cd->company_registration = $company_registration;
                    $this->cd->bus_licence_img = $bus_licence_img;
                    $this->cd->idcard_img = $idcard_img;
                    $this->cd->proxy_img = $proxy_img;
                    
                    $corp_detaile_id = $this->cd->create();
                    
                    if($corp_detaile_id)
                    { 
                        $update_password_row = true;
                        
                        if( !empty($update_password_status ) )
                        { 
                            
                            //接口修改密码
                            $data_post['customer_id'] = $customer_id;
                            $data_post['password'] = $password;
                            $url = $this->url_prefix.'Customer/update_pwd';
                            
                            $update_password_row = json_decode($this->curl_post_result($url,$data_post),true)['status'];
                           
                        }
                        
                        if( $update_password_row )
                        {
                            
                            $result['status'] = 0;
                            $result['message'] = '注册成功';
                            $result['data']['corporation_id'] = $corporation_id;
                            $result['data']['customer_id'] = $customer_id;
                            
                            $this->db->trans_commit();
                            
                            echo json_encode($result);
                            exit();
                        }
                    }
                }
            }
            
        }else{ 
            $result['status'] = '-253';
            $result['message'] = '缺少参数';
            echo json_encode($result);
            exit();
        }
    
    
        if( empty($update_password_row) )
        {
            $this->db->trans_rollback();
            $result['status'] = '-1';
            $result['message'] = '注册失败';
            echo json_encode($result);
            exit();
        }
        
    }
    
    // ------------------------------------------------------------
    
    /**
     * 获取企业行业 && 企业性质
     */
    function corporation_ind_info(){ 
        
        $this->load->model('corporation_mdl');
        $status = $this->input->post('status');
        
        if($status == 1){
            
            // 企业行业
            $result['status'] = 0;
            $result['message'] = '获取行业信息成功';
            $result['data'] = $this->corporation_mdl->cor_ind_info();
        }else if($status == 2){ 
            
            // 企业性质
            $result['status'] = 0;
            $result['message'] = '获取性质信息成功';
            $result['data'] = $this->corporation_mdl->corporation_type();
            
        }else{ 
            
            // 企业行业
            $cor_ind = $this->corporation_mdl->cor_ind_info();
            // 企业性质
            $cor_type = $this->corporation_mdl->corporation_type();
            
            $result['status'] = 0;
            $result['message'] = '获取成功';
            $result['data']['corporation_ind_info'] = $cor_ind;
            $result['data']['corporation_type'] = $cor_type;
        }
        
        
        
        
        echo json_encode($result);
    }
    
    // ------------------------------------------------------------
    /**
     * 获取省份
     */
    function show_region(){ 
        
        $this->load->model('region_mdl');
        $status = $this->input->post('status');
        $parent_id = $this->input->post('parent_id');
        
        if(!$status == 1) //市
            $parent_id = 1;
     
        
        $province_list = $this->region_mdl->children_of($parent_id);
        $result['status'] = 0;
        $result['message'] = '获取成功';
        $result['data'] = $province_list;
        
        echo json_encode($result);
        
    }
    
    /**
     * 根据省的id获取城市
     */
    function show_city(){ 
        $this->load->model('region_mdl');
        $region_id = $this->input->post('parent_id');
        $city_list = $this->region_mdl->children_of($region_id);
        $result['status'] = 0;
        $result['message'] = '获取成功';
        $result['data'] = $city_list;
        
        echo json_encode($result);
    }
    
    // ------------------------------------------------------------

    /**
     * 用户购入扣除货豆
     */
    public function purchase(){ 
        //验证是否登录
        $this->account_key = $this->input->post('key');
        $cache_result = $this->is_login();
        $customer_id = $cache_result['user_id'];
        
        $commit = false;
        //订单参数
        $pay_password = $this->input->post('pay_password');
        $external_order_sn = $this->input->post('order_sn');
        $total_price = $this->input->post('total_price');
        $shop_number = $this->input->post('app_id');
        $Preferential_id = $this->input->post('preferential_id');

        //验证必填参数
        if($pay_password && $external_order_sn && $total_price){ 
            
            //接口-验证支付密码
            $url = $this->url_prefix.'Customer/fortune/?customer_id='.$customer_id;
            $customer_pay = json_decode($this->curl_get_result($url),true);
            
            
            if(isset($customer_pay['pay_passwd']) &&  $customer_pay['pay_passwd']!=null ){
                
                if($customer_pay['pay_passwd'] == md5($pay_password) ){
                    
                    $time = date('Y-m-d H:i:s');
                    $credit = 0; //授信
                    if($customer_pay['credit_start_time'] <= $time && $customer_pay['credit_end_time'] >= $time)
                        $credit = $customer_pay['credit'];
                    
                    if($customer_pay['M_credit']+$credit >= $total_price){
                        
                        $this->load->model('order_mdl');
                        
                        if ( !$this->order_mdl->check_external_order_sn ( $external_order_sn ) )
                        {
                            //开启事物
                            $this->db->trans_begin();
                            
                            //insert 第三方订单表
                            $this->load->helper('order');
                            $this->load->model('external_order_mdl');
                            
                            do {
                                $order_sn = get_order_sn ();//生成订单号
                                if ($this->order_mdl->check_order_sn ( $order_sn )) {
                                    $order_exist = true;
                                } else {
                                    $this->external_order_mdl->order_sn =  $order_sn;
                                    
                                    $order_exist = false;
                                }
                            } while ( $order_exist ); // 如果是订单号重复则重新提交数据
                            
                            
                            
                            $this->external_order_mdl->external_number = $external_order_sn;
                            $this->external_order_mdl->type = $this->type;
                            $this->external_order_mdl->shop_number = $shop_number;
                            $this->external_order_mdl->order_sn = $order_sn;
                            $create_order_id = $this->external_order_mdl->create();
                            
                            //第三方订单生成成功
                            if($create_order_id){ 
                                
                                //新建内部订单
                                
                                $freight = 0;//运费
                                /* 插入新订单信息 */
                                $this->order_mdl->customer_id = $customer_id;
                                $this->order_mdl->payment_id = 2;// 支付方式
                                $this->order_mdl->shipping_id = 0; // 物流
                                $this->order_mdl->total_product_price = $total_price;//产品总价
                                $this->order_mdl->auto_freight_fee = $freight;//运费
                                $this->order_mdl->total_price = $total_price + $freight;//总价格（包含运费）
                                $this->order_mdl->order_source = 5; // 订单来源
                                $this->order_mdl->status = 9; //订单状态
                                $this->order_mdl->corporation_id = $this->corporation_id;
                                $this->order_mdl->order_sn = $order_sn;
                                $new_order_id = $this->order_mdl->create ();
                               
                                if($new_order_id){ 
                                    switch ($this->type){
                                        case 1:
                                            //广告平台
                                            $product_id = $this->product_id;
                                            break;
                                    }
                                    
                                    //商品信息
                                    $product_info = $this->external_order_mdl->load_product($product_id);
                                    
                                    //新建消费记录
                                    $this->load->model('order_item_mdl');
                                    $this->order_item_mdl->order_id = $new_order_id;
                                    $this->order_item_mdl->product_id = $product_id;
                                    $this->order_item_mdl->product_name = $product_info['name'];
                                    $this->order_item_mdl->quantity = 1;
                                    $this->order_item_mdl->price = $total_price;
                                    $this->order_item_mdl->sku_id = 0;
                                    $this->order_item_mdl->weight = 0; // $items['options']['weight'];
                                     
                                    $res = $this->order_item_mdl->create ();
                                    
                                    //如果消费表生成记录成功
                                    if($res){
                                        
    
                                        //调用接口写日志-处理金额
                                        $post['customer_id'] = $customer_id;
                                        $post['corp_customer_id'] = $this->customer_id;
                                        $post['total_price'] = $total_price;
                                        $post['order_sn'] = $order_sn;
                                        $post['expend_remark'] = '购物支出';//支出备注
                                        $post['income_remark'] = '销售收入';//收入备注
                                        $post['id_event'] = '77';//事件
                                        
                                        //接口
                                        $url = $this->url_prefix.'Api_advertisement/Order/transaction';
                                        $return = json_decode($this->curl_post_result($url,$post),true);
                                        
                                        if( $return['status']  )
                                        {
                                            $commit = true;
                                            $this->db->trans_commit(); //提交事物
                                            $result ['status'] = 0;
                                            $result ['message'] = '支付成功';
                                        }
                                    }
                                }
                            }
                        }else{ 
                            
                            $result ['status'] = '-5';
                            $result ['message'] = '提交的单号已存在';
                            echo json_encode($result);
                            exit();
                            //提交的单号已存在
                        }
                    }else{ 
                        $result ['status'] = '-2';
                        $result ['message'] = '余额不足';
                        echo json_encode($result);
                        exit();
                        //余额不足
                    }
                }else{ 
                    $result ['status'] = '-3';
                    $result ['message'] = '支付密码错误';
                    echo json_encode($result);
                    exit();
                }
            }else{ 
                $result ['status'] = '-4';
                $result ['message'] = '未设置支付密码';
                echo json_encode($result);
                exit();
            }
        }else{ 
            $result ['status'] = '-253';
            $result ['message'] = '缺少参数';
            echo json_encode($result);
            exit();
        }
        
        
        if( !$commit ){
            $this->db->trans_rollback(); //事物回滚
            $result ['status'] = '-1';
            $result ['message'] = '支付失败';
            //支付失败
        }
        
        echo json_encode($result);
    }
    // ------------------------------------------------------------
    
    /**
     * 获取商家信息
     */
    public function corporation_info(){ 
        
        $corporation_id = $this->input->post('corporation_id');
        
        if($corporation_id){
            
            $this->load->model('corporation_mdl');
            $data = $this->corporation_mdl->load_id($corporation_id);
            
            if(count($data) > 0 ){ 
                
                $result ['data'] = $data;
                
                if( $data['QR_code'] )
                    $result['data']['QR_code'] = IMAGE_URL.$data['QR_code'];
                
                
                if( $data['img_url'] && !strstr($data['img_url'],"http") )
                    $result['data']['img_url'] = IMAGE_URL.$data['img_url'];

                    if(!empty($data['bus_licence_img']) ){
                        $arr = explode(';',$data['bus_licence_img']);
                        
                        if(count($arr) > 0){ 
                            $bus_licence_img = '';
                            foreach ($arr as $k => $v){ 
                                
                                if( !strstr($v,"http") ){ 
                                    $bus_licence_img .= IMAGE_URL.$v.';';
                                }else{ 
                                    $bus_licence_img .= $v.';';
                                }
                            }
                            
                            $result['data']['bus_licence_img'] = $bus_licence_img;
                        }
                    
                    }
                $result ['status'] = 0;
                $result ['message'] = '获取成功';
            }else{ 
                $result ['status'] = '-1';
                $result ['message'] = '获取失败';
            }
            
        }else{ 
            $result ['status'] = '-253';
            $result ['message'] = '缺少参数';
        }
        
        echo json_encode($result);
    }
    
    // ------------------------------------------------------------
    
    /**
     * 货豆转账
     */
    public function give_voucher(){
        
        $app_key = $this->input->post('app_key');
        $pay_password = $this->input->post('pay_password');
        $to_customer_id = $this->input->post('to_customer_id');//收入方
        $expend_customer_id = $this->input->post('expend_customer_id');//支出方
        $M_voucher = $this->input->post('M_voucher');
        
        
        if($app_key && $pay_password && $to_customer_id && $expend_customer_id && $M_voucher){ 
            
            if($app_key == $this->api_key){ 

                
                //获取用户的支付密码
                $url = $this->url_prefix.'Customer/fortune/?customer_id='.$expend_customer_id;
                $customer_pay = json_decode($this->curl_get_result($url),true);
                
                if($customer_pay){
                    //获取受赠方的支付信息
                    $url = $this->url_prefix.'Customer/fortune/?customer_id='.$to_customer_id;
                    $receive_pay_info = json_decode($this->curl_get_result($url),true);
                    
                    if($receive_pay_info){
                        
                        if(isset($customer_pay['pay_passwd']) && md5($pay_password) == $customer_pay['pay_passwd']){ 
        
                            $time = date('Y-m-d H:i:s');
                            $credit = 0; //授信
                            if($customer_pay['credit_start_time'] <= $time && $customer_pay['credit_end_time'] >= $time)
                                $credit = $customer_pay['credit'];
                            
                            
                            if($customer_pay['M_credit']+$credit >= $M_voucher)
                            {
                                
                                
                                switch ($this->type)
                                {
                                    case 1:
                                        $remark = '广告平台-货豆转账';
                                        break;
                                }
                                //调用接口写日志-处理金额
                                $post['customer_id'] = $expend_customer_id;
                                $post['corp_customer_id'] = $to_customer_id;
                                $post['total_price'] = $M_voucher;
                                $post['order_sn'] = '';
                                $post['expend_remark'] = $remark;//支出备注
                                $post['income_remark'] = $remark;//收入备注
                                $post['id_event'] = '77';//事件
                                
                                //接口
                                $url = $this->url_prefix.'Api_advertisement/Order/transaction';
                                $return = json_decode($this->curl_post_result($url,$post),true);
                                
                                if( $return['status'] )
                                {
                                    $this->db->trans_commit(); //提交事物
                                    $result ['status'] = 0;
                                    $result ['message'] = '赠送成功';
                                }else{ 
                                    
                                    $this->db->trans_rollback(); //事物回滚
                                    $result ['status'] = '-1';
                                    $result ['message'] = '赠送失败';
                                }
                                
                            }else{ 
                                $result ['status'] = '-2';
                                $result ['message'] = '余额不足';
                            }
                        }else{ 
                            $result ['status'] = '-3';
                            $result ['message'] = '商户支付密码错误或未设置支付密码';
                        }
                    }else{ 
                        $result['status'] = '-6';
                        $result['message'] = '收入方账户错误';
                    }
                }else{ 
                    $result['status'] = '-5';
                    $result['message'] = '支出方账户错误';
                }
            }else{ 
                $result ['status'] = '-4';
                $result ['message'] = '商户KEY错误';
            }
        }else{ 
            $result ['status'] = '-253';
            $result ['message'] = '缺少参数';
        }
        echo json_encode($result);
    }
    
    
    // ------------------------------------------------------------
    /**
     * 设置支付密码
     */
    public function set_pay_password(){ 
         
        //验证是否登录
        $this->account_key = $this->input->post('key');
        $cache_result = $this->is_login();
        $customer_id = $cache_result['user_id'];
        
        $mobile = $this->input->post('mobile');
        $pay_password = $this->input->post('pay_password');
        $mobile_vertify = $this->input->post('mobile_vertify');
        $mobile_key = $this->input->post('mobile_key');
        
        if ( $pay_password != null && $mobile_vertify != null && $mobile_key != null ) {
            
            $mobile_vertify2 = $this->mem->get( $mobile_key );
            
            if( !$mobile_vertify2 ) {

                $result['status'] = '-4';
                $result['message'] = '验证码超时';
                echo json_encode($result);
                return;
            }
            
            //手机验证码是否正确
            if( $mobile_vertify == $mobile_vertify2['num'] && ( $mobile_vertify2['mobile'] == $cache_result['name'] || $mobile_vertify2['mobile'] == $cache_result['mobile'])  )
            { 
                
                //接口
                $post['pay_passwd'] = $pay_password;
                $post['customer_id'] = $customer_id;
                
                $url = $this->url_prefix.'Customer/setPayPassword';
                $return = json_decode($this->curl_post_result($url,$post),true);
                
                if( $return['status'] )
                { 
                    $result['status'] = 0;
                    $result['message'] = '设置成功';
                    $this->mem->delete($mobile_key);
                    
                }else{ 
                    $result['status'] = '-1';
                    $result['message'] = '设置失败';
                }
                
            }else{
                 
                $result['status'] = '-3';
                $result['message'] = '手机验证码错误';
            }
            
        }else{ 
            
            $result['status'] = '-253';
            $result['message'] = '缺少参数';
        }
        
        echo json_encode($result);
    }   
    
    // ------------------------------------------------------------
    /**
     * 商家信息修改
     */
    public function corp_update(){ 
        $this->account_key = $this->input->post('key');
        $cache_result = $this->is_login();
        
        $corporation_id = $cache_result['corporation_id'];
        
        $province_id = $this->input->post('province_id'); //省份
        $city_id = $this->input->post('city_id');    //城市
        $district_id = $this->input->post('district_id'); //县区
        $address = $this->input->post('address'); //具体街道位置
        $industry = $this->input->post('industry'); //行业
        $nature  = $this->input->post('nature'); //性质
        $postcode = $this->input->post('postcode'); //邮编
        $email = $this->input->post('email'); //邮箱
        $img_url = $this->input->post('img_url'); //店铺图标
        $contact_name = $this->input->post('contact_name'); //管理员
        $contact_mobile = $this->input->post('contact_mobile'); //联系方式
        
        $bus_licence_img = $this->input->post('bus_licence_img');//营业执照
        $idcard_img = $this->input->post('idcard_img');//法人身份证复印件
        $proxy_img = $this->input->post('proxy_img'); //法人授权委托书
       
        $this->load->model('corporation_mdl','cp');
        $this->load->model('corporation_detail_mdl','cd');
        $this->cp->province_id = $province_id;
        $this->cp->city_id = $city_id;
        $this->cp->district_id = $district_id;
        $this->cp->address = $address;
        $this->cp->postcode = $postcode;
        $this->cp->email = $email;
        $this->cp->contact_name = $contact_name;
        $this->cp->contact_mobile = $contact_mobile;
        $this->cp->corporation_id = $corporation_id;
        $this->cd->corporation_id = $corporation_id;
        
        
        if( !empty($img_url) )
            $this->cp->img_url = $img_url;
        
        if( !empty($bus_licence_img) )
            $this->cd->bus_licence_img = $bus_licence_img;
        
        if( !empty($bus_licence_img) )
            $this->cd->idcard_img = $idcard_img;
        
        if( !empty($proxy_img) )
            $this->cd->proxy_img = $proxy_img;
        
        $this->cd->Industrial_Info = $industry;
        $this->cd->nature = $nature;
        
        $up_corp = $this->cp->update();
        $up_corp_detail = $this->cd->update();
        
        if($up_corp && $up_corp_detail){ 
            $result['status'] = 0;
            $result['message'] = '修改成功';
        }else{ 
            $result['status'] = 0;
            $result['message'] = '修改失败';
        }
        
        echo json_encode($result);
    }
    
    
    // ------------------------------------------------------------
    /**
     * 验证登录用户的支付密码
     */
    public function verify_pay_password(){ 
        $this->account_key = $this->input->post('key');
        $pay_password = $this->input->post('pay_password');
        
        if($this->account_key && $pay_password){
            $cache_result = $this->is_login();//获取登录信息
            $customer_id = $cache_result['user_id'];
            
            //接口-验证支付密码
            $url = $this->url_prefix.'Customer/fortune/?customer_id='.$customer_id;
            $data = json_decode($this->curl_get_result($url),true);
            
            
            if(count($data) > 0){ 
                
                if( empty($data['pay_passwd']) ){ 
                    $result['status'] = '-3';
                    $result['message'] = '未设置支付密码';
                
                }else{ 
                    
                    if(md5($pay_password) == $data['pay_passwd']){ 
                        $result['status'] = 0;
                        $result['message'] = '支付密码正确';
                    }else{ 
                        $result['status'] = '-1';
                        $result['message'] = '支付密码错误';
                    }
                }
                
            }else{ 
                 $result['status'] = '-2';
                 $result['message'] = '支付账户不存在，请联系客户';
            }
            
        }else{ 
             $result['status'] = '-253';
             $result['message'] = '缺少参数';
        }
        
        echo json_encode($result);
    }
    

    // ------------------------------------------------------------
    /**
     * 通过短信key检测验证码是否正确
     */
    public function verify_code(){ 
        $code_key = $this->input->post('code_key');
        $mobile = $this->input->post('mobile');
        $code = $this->input->post('code');
        $status = $this->input->post('status');
        
        if($code_key && $mobile && $code){
            //获取手机验证码
            $code_info = $this->mem->get( $code_key );
            
            if( $code_info ) {
                
                if($code_info['num'] == $code && $code_info['mobile'] == $mobile && $code_info['status'] == $status ){ 
                    
                    $result['message'] = '验证成功';
                    $result['status'] = 0;
                    $this->mem->delete( $code_key );
                    
                }else{ 
                    
                    $result['message'] = '验证码错误';
                    $result['status'] = '-1';
                }
                
            }else{ 
                $result['status'] = '-1';
                $result['message'] = '验证码超时，请重新获取';
                
            }
            
        }else{ 
            
            $result['status'] = '-253';
            $result['message'] = '缺少参数';
        }
        echo json_encode($result);
    }
    
    // ------------------------------------------------------------
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
    
    // ------------------------------------------------------------
    
    /**
     * 发送验证码
     */
    public function ajax_send()
    {
        $mobile = $this->input->post('mobile');
        $status = $this->input->post('status') ? $this->input->post('status') : 0;
        if(!$mobile){ 
            $result ['status'] = '-2';
            $result ['message'] = '请输入手机号';
            echo json_encode($result);
            exit;    
        }
        
        $key = md5($mobile.$status.rand(0,999999));
        // $this->load->library('ninthLeaf_Mobile_Message', '', 'message');
        // 读取工厂
        $this->load->library('Short_Message_Factory', '', 'message');
        $num = $this->message->random(6);
        $date = date('Y-m-d H:i:s');
    
        // 读取默认短信提供商
        $this->load->model('sms_supplier_mdl');
        $supplier = $this->sms_supplier_mdl->get_in_use();
        $sms = $this->message->get_message($supplier);
    
        $this->load->model('shortmsg_log_mdl');
        $mem_result ['num'] = $num;
        $mem_result ['mobile'] = $mobile;
        $mem_result ['status'] = $status;
        switch ($status) {
            case 1:
                $is_ok = $this->mem->set($key,$mem_result,MEMCACHE_COMPRESSED,1800);
                $content = '修改密码短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 2:
                $is_ok = $this->mem->set($key,$mem_result,MEMCACHE_COMPRESSED,1800);
                $content = '设置支付密码短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 3:
                $content = '验证绑定手机短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 4:
                $content = '绑定手机短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 5:
                $content = '绑定微信短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            case 6:
                $is_ok = $this->mem->set($key,$mem_result,MEMCACHE_COMPRESSED,1800);
                $content = '解绑微信短信验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
                break;
            default:
                $is_ok = $this->mem->set($key,$mem_result,MEMCACHE_COMPRESSED,1800);
                $content = '动态验证码' . $num . '，工作人员不会向您索要，请勿向任何人泄露';
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
        
        if($msgs && $is_ok){
            $result ['message'] = $return_msg;
            $result ['key'] = $key;
            $result ['status'] = 0;
            $result ['code'] = $num;
        }else{ 
            $result ['message'] = '失败';
            $result ['key'] = '-1';
        }
        echo json_encode($result);
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
        
        $filename = 'uploads/userinfo/' . $userid . '.png';
        $margin = 1;
        
        QRcode::png($data, dirname(BASEPATH) . $filename, $errorCorrectionLevel, $matrixPointSize, $margin);
        
        // $png = 'http://chart.googleapis.com/chart?chs=' . $size . '&cht=qr&chl=' . urlencode($data) . '&chld=L|1&choe=UTF-8';
        
        // $QR = imagecreatefrompng($png);
        
        $QR = imagecreatefromstring(file_get_contents(FCPATH. $filename));
        
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
        
        imagepng($QR, FCPATH.'uploads/userinfo/' . $userid . '.png');
        
        imagedestroy($QR);
    }
    
    
    // ------------------------------------------------------------

    
    //验证是否登录
    public function is_login(){ 
        
        $mem = $this->mem;
        
        $account_key = $this->account_key;
        
        if(!$account_key){ 
            $result['status'] = '-98';
            $result['message'] = '请传递用户KEY值';
            echo json_encode($result);
            exit;
            
        }else{ 

            $val = $mem->get( $account_key );
            
            if($val){ 
                
                //设置
                $mem->set($account_key,$val,MEMCACHE_COMPRESSED,1800);
                return $val;
            }else{ 
                $result['status'] = '-99';
                $result['message'] = '请登录';
                echo json_encode($result);
                exit;
            }
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */