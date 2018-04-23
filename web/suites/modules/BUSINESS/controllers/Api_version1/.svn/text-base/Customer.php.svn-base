<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Api_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('customer_mdl');
    }
    
    
    public function index()
    {
        echo 'Customer API';
    }
    
    private function curl_post_result($url,$data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
    
    private function curl_get_result( $url ){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
    
    /**
     *  用户登录
     */
    public function login()
    {
        
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
            'username',
            'password'
        ));
        
        $type = isset($prams['type'])? $prams['type']:"";
        $data['tbxLoginNickname'] =  $prams['username'];
        $data['tbxLoginPassword'] =  $prams['password'];
        
        if($type &&  $type == 'bjiami'){//密码免去加密 明文方便测试
        }else{
            //APP调用接口 密码需要md5加密
            $data['is_md5'] = 'is_md5';
            //处理加密 
            //位置：$i+5   5，6，7，8
            //长度：11-2*$i 11，9，7，5
            for($i = 0 ;$i <4 ;$i++){
                $tag = $i+5;
                $length = 11-2*$i;
                $data['tbxLoginPassword'] = substr_replace(  $data['tbxLoginPassword'], '', $tag,$length);
            }
        }
        
        $url = $this->url_prefix.'Customer/check_customer?';
        //配置传参
        //获取A端服务器用户信息
        $A_customer = json_decode($this->curl_post_result($url,$data),true);
        
        //获取当前B端服务器用户信息
        $B_customer = $this->customer_mdl->load($A_customer['id']);
        
        //获取A端用户支付账户信息
        $data =array();
        $data['customer_id'] = $A_customer['id'];
        $url = $this->url_prefix.'Customer/get_pay_relation_id?';
        $pay_data = json_decode($this->curl_post_result($url,$data),true);
        
        if ($A_customer) {
            $customer_session= array(
                //用户信息
                'user_in' => TRUE,
                'user_id' => $A_customer['id'],
                'user_name' => $A_customer['name'],
                'nick_name' => isset($A_customer['nick_name']) ? $A_customer['nick_name'] : "",
                'mobile' => isset($_customer['mobile']) ? $A_customer['mobile'] : "",
                'is_vip' => $A_customer['is_vip'],
                'user_last_login' => $A_customer['last_login_at'],
                //微信绑定信息
                'wechat_account' => isset($A_customer['wechat_account']) ? $A_customer['wechat_account'] : "",
                'wechat_nickname' => isset($A_customer['wechat_nickname']) ? $A_customer['wechat_nickname'] : "",
                'openid' => $A_customer['openid'],
                //支付账户信息
                'pay_relation' => $pay_data,
                //企业信息
                'corporation_id'=>'',
                'corporation_name'=>'',
                'corporation_status'=>'',
                'approval_status'=>'',
                
            );
            
            //B端独有的用户个人头像上传
            if($B_customer['brief_avatar']){
                $customer_session['logo_avatar'] = IMAGE_URL.$B_customer['brief_avatar'];
            }else{
                $customer_session['logo_avatar'] = isset($A_customer['wechat_avatar']) ? $A_customer['wechat_avatar'] : "";
            }
            //查询企业信息
            $this->load->model("corporation_mdl");
            $Corp_Info = $this->corporation_mdl->load($A_customer['id']);
            if ($Corp_Info != null) {
                $customer_session['corporation_id'] = $Corp_Info['id'];
                $customer_session['corporation_name'] = $Corp_Info['corporation_name'];
                $customer_session["corporation_status"] = $Corp_Info["status"];
                $customer_session["approval_status"] = $Corp_Info["approval_status"];
            }
            $this->session->set_userdata($customer_session);
            $return['responseMessage'] = array(
                'messageType' => 'success',
                'errorType' => '0',
                'errorMessage' => ''
            );
            $return['data'] = array(
                'sessionid' => $this->session->userdata('session_id'),
                'sessions' => $customer_session
            );
        } else {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '2',
                'errorMessage' => '用户或密码错误'
            );
        }
        print_r(json_encode($return));
    }
    
    
    /**
     * 用户各类权限
     */
    public function authority(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        //重置权限
        $return['data'] = array(
            'tribe_create_status'=> 0 ,
            'demand_status'=> false ,
            'verify_status'=> false ,
        );
        
        $user_id = $this->session->userdata('user_id');
        
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //创建部落权限
        $this->load->model("tribe_mdl");
        $tribe_id = $this->session->userdata("tribe_id");
        $tribe = $this->tribe_mdl->get_MyTribe($user_id,$tribe_id);//查询我创建的部落
        $return['data']['tribe_create_status'] = $tribe?$tribe["status"]:0;//0未创建1待审核2通过3不通过
       
        //需求权限  暂时先为true
        $return['data']['demand_status'] = true;
        
        //核销订单权限
        $this->load->model('Customer_corporation_mdl');
        $corp_detail= $this->Customer_corporation_mdl->load( $user_id);
        if($corp_detail){
             $return['data']['verify_status'] = true;
        }else{
            $this->load->model('Corporation_staff_mdl');
            //获取该用户在平台的所有在职的企业下的角色信息
            $staff = $this->Corporation_staff_mdl->get_staff($user_id,2);
             
            //或者是判断用户是否拥有处理订单的权限  根据9thleaf_corporation_module表确定权限url
            $authority_str = '/Corporate/order/get_list';
            if(!empty($staff)){
                foreach ($staff as $key =>$val){
                    $authority = $this->Corporation_staff_mdl->get_staff_authority($val['corporation_id'],$user_id);
        
                    if($authority){
                        //将获取出来的权限字符串进行处理成数组
                        foreach ($authority as $key => $val){
                            $authority_arr[$key] = $val['url'];
                        }
                        if(in_array($authority_str, $authority_arr)){
                            $return['data']['verify_status'] = true;
                        }
                    }
                     
                }
            }
        }
        print_r(json_encode($return));
    }
    
    
    
}