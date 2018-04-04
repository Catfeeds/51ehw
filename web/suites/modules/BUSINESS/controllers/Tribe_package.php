<?php
/**
 * 部落货包控制器
 */
class Tribe_package extends Front_Controller
{
    
    function __construct()
    {
        parent::__construct();
       
        $this->load->model("tribe_package_mdl");
        
        //判断登录
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('customer/login');
            exit();
        }
    }
    
    
    
    /**
     * 货包领取
     * id   分享ID
     */
    public function  index($id){
        //获取货包内容
        $package = $this->tribe_package_mdl->get_share_detail($id);
        
        $this->load->model('customer_mdl');
        $user_id  = $this->session->userdata("user_id");
        //调用接口处理
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $user_id;
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
        //手机是否绑定
        $data['mobile_exist'] = false;
        //是否领取改货包
        $data['gain_package_status'] = false;
        if(!empty($customer['mobile'])){
            $data['mobile_exist'] = true;
            //已经绑定手机 检查是否领取货包
            $gain_package_info = $this->tribe_package_mdl->load($id,$package['tribe_package_id']);
            if($gain_package_info){
                $data['gain_package_status'] = true;
                //领取货包的详细信息（收货信息）
                $data['gain_package_info'] =$gain_package_info;
            }
        }
        
        //获取该货包多少人领取
        $data['gain_package_list'] = $this->tribe_package_mdl->get_gain_package_list($id); 
        
        $data['title'] = "领货包了！";
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_package/package', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    
    /**
     * 分享列表
     */
   public function  share_list(){
       //获取用户存在授权分享权限下的货包
       $user_id = $this->session->userdata("user_id");
       $packages = $this->tribe_package_mdl->get_tribe_package($user_id);
       if(empty($packages)){
         
           echo "<script>alert('无权限');window.location.href ='".site_url('Member/info')."'</script>";
           exit;
          
       }
       $share_list = $this->tribe_package_mdl->get_share_list($user_id);
       $data['list'] = $share_list;
       
       $data['title'] = "我的分享";
       $data ['head_set'] = 2;
       $data ['foot_set'] = 1;
       $this->load->view('head', $data);
       $this->load->view('_header', $data);
       $this->load->view('', $data);
       $this->load->view('_footer', $data);
       $this->load->view('foot', $data);
       
   }
   
   /**
    * 新建分享
    */
   public function share_create(){
       //获取用户存在授权分享权限下的货包
       $user_id = $this->session->userdata("user_id");
       $packages = $this->tribe_package_mdl->get_tribe_package($user_id);
       if(empty($packages)){
           echo "<script>alert('无权限');window.location.href ='".site_url('Member/info')."'</script>";
           exit;
       }
       $data['packages'] =$packages;
       
       $data['title'] = "创建分享";
       $data ['head_set'] = 2;
       $data ['foot_set'] = 1;
       $this->load->view('head', $data);
       $this->load->view('_header', $data);
       $this->load->view('', $data);
       $this->load->view('_footer', $data);
       $this->load->view('foot', $data);
       
   }
   
   /**
    * 异步获取后台货包设置的部落信息
    */
   public function ajax_get_share_package_tribe(){
       //货包ID
      $tribe_package_id = $this->input->get_post("tribe_package_id");
      $tribe_package = $this->tribe_package_mdl->get_tribe_packageById($tribe_package_id);
      $data['tribe_infos'] =  $this->tribe_package_mdl->get_share_package_tribe($tribe_package['tribe_id']);
      echo json_encode($data);
   }
   
   // ---------------------------------------------------------------------------
   
   /**
    * 异步生成分享未领取的货包记录
    */
   public function ajax_create_share_package(){
       //获取用户存在授权分享权限下的货包
       $customer_id = $this->session->userdata("user_id");

       $tribe_package_id = $this->input->post("tribe_package_id");//货包ID
       $number = $this->input->post("number");//分享数量
       $title = $this->input->post("title");//分享标题
       $desc = $this->input->post("desc");//分享描述

       
       //验证数据
       if(!$tribe_package_id || $number <= 0 || !strlen($title) || !strlen($desc)){
            $return = array(
                'status' => '1',
                'Message' => "参数错误"
            );
           echo  json_encode($return);exit;
       }
       
       //检查判断是否有权限创建货包
       $packages = $this->tribe_package_mdl->get_tribe_package($customer_id,$tribe_package_id);
       if(!$packages){
           $return = array(
                    'status' => '1',
                    'Message' => "没有权限生成分享货包"
                );
           echo  json_encode($return);exit;
       }
       

       $this->db->trans_begin();//开启事务
       $row = $this->tribe_package_mdl->update_stock($tribe_package_id,$number);//扣除库存
       if($row){
           $flag = false;//识别
           $data = array(
               "title" => $title,
               "desc" => $desc,
               "customer_id" => $customer_id,
               "quanity" => $number,
               'tribe_package_id' => $tribe_package_id
           );
           
           $share_id = $this->tribe_package_mdl->AddSharePackage($data);//添加分享货包
           if($share_id){
               
               for($i = 0;$i < $number; $i++){
                   $item[] = array(
                           'package_share_id' => $share_id,
                           'tribe_package_id' => $tribe_package_id,
                   );
               }
 
               $row = $this->tribe_package_mdl->AddSharePackage_log($item);//添加分享货包log
               if($row){
                   $flag = true;
               }
               
           }
           
           if($flag){
               $this->db->trans_commit();//提交事务
               $return = array(
                   'status' => '3',
                   'Message' => "成功"
               );
               echo  json_encode($return);exit;
           }else{
               $this->db->trans_rollback();//回滚
               $return = array(
                   'status' => '1',
                   'Message' => "失败"
               );
               echo  json_encode($return);exit;
           }
       }else{
           $this->db->trans_rollback();//回滚
           $return = array(
               'status' => '2',
               'Message' => "库存不足"
           );
           echo  json_encode($return);exit;
       }
       
       
   }
   
   // ---------------------------------------------------------------------------
   
   /**
    * 修改分享的卡包
    */
   public function save(){
       $share_id = $this->input->post("share_id");//分享id
       $title = $this->input->post("title");//分享标题
       $desc = $this->input->post("desc");//分享描述
       $customer_id = $this->session->userdata("user_id");//用户id
       
       //验证数据
       if( !$share_id || !strlen($title) || !strlen($desc)){
           $return = array(
               'status' => '1',
               'Message' => "参数错误"
           );
           echo  json_encode($return);exit;
       }
       
       $data["title"] = $title;
       $data["desc"] = $desc;
       $row = $this->tribe_package_mdl->save($share_id,$customer_id,$data);
       if($row){
           $return = array(
               'status' => '2',
               'Message' => "成功"
           );
           echo  json_encode($return);exit;
       }else{
           $return = array(
               'status' => '1',
               'Message' => "失败"
           );
           echo  json_encode($return);exit;
       }
   }
   
   // ---------------------------------------------------------------------------
   
   /**
    * 绑定用户->领取货包->加入部落
    */
   public function aa(){

       $customer_id = $this->session->userdata("user_id");
       

       $name = $this->input->post('mobile');//手机
       $vertify1 = $this->input->post('mobile-vertify');//验证码
       
       $vertify2 = $this->session->userdata('verfity_yzm_3');//session验证码
       $mobile2 = $this->session->userdata('verfity_mobile_3');//session手机
       


       if($vertify1 != $vertify2 || $name != $mobile2){
           $return = array(
               'status' => '1',
               'Message' => "验证码错误"
           );
           echo  json_encode($return);exit;
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
       
           //发送绑定成功信息
           $this->load->model('Customer_message_mdl',"Message");
       
           $link = $this->url_prefix.'Customer/load?';
           $dta['customer_id'] = $data['user_id'];
           $customers = json_decode($this->curl_post_result($link,$dta),true);
           //模板
           $Msg_info['template_id']= 4;
           //标题
           $Msg_info['name']= '账号绑定';
           $Msg_info['customer_id']= $data['user_id'];
           $Msg_info['obj_id'] = 0;
           $Msg_info['type'] = 1;
           $Msg_info['parameter']['name'] = isset($customers['nick_name']) && !empty($customers['nick_name'])? $customers['nick_name']:$customers['name'];
           $this->Message->Create_Message($Msg_info);
       
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
           $post['nickname'] = $this->session->userdata('nick_name')?  $this->session->userdata('nick_name'):$name;
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
       
           //更新部落用户ID信息
           $update_data['customer_id'] =  $_customer['id'];
           $update_data['status'] = 2;
           $update_data['mobile'] = $name;
           $this->load->model('Tribe_mdl');
           $this->Tribe_mdl->update_tribe_staff( $update_data );
       
           
           //同步部落身份信息
           $staff_idenity =  $this->Tribe_mdl->load_staff_idenity($name);
           if($staff_idenity){
               foreach ($staff_idenity as $key =>$val){
                   unset( $staff_idenity[$key]['id']);
                   unset( $staff_idenity[$key]['mobile']);
                   unset( $staff_idenity[$key]['created_at']);
                   $staff_idenity[$key]['customer_id'] =  $_customer['id'];
               }
                
               $this->load->model('Customer_identity_mdl');
               $this->Customer_identity_mdl->add_idenity_batch($staff_idenity);
           }
       
           //将微信注册账号给失效
           $info['customer_id'] = $customer_id;
           $info['type'] = 'wechat';
           //接口-
           $url = $this->url_prefix.'Customer/unbundling';
           json_decode($this->curl_post_result($url,$info),true);
       
       }
       $this->load->model('customer_mdl');
       $customer_avatar = $this->customer_mdl->load($_customer['id']);
       $customer = array(
           'user_name' => $name,
           'user_id' => $_customer['id'],
           'user_in' => TRUE,
           'is_vip' => 0,
           'is_active' => 0,
           'user_last_login' => date('Y-m-d H:i:s'),
           'corporation_id' => 0,
           //                 'privilege_id' => 0,
           'img_avatar' =>!empty($customer_avatar['img_avatar'])?$customer_avatar['img_avatar']:!empty($customer_avatar['wechat_avatar'])?$customer_avatar['wechat_avatar']:'',
           'openid' => $this->session->userdata('openid'),
           'pay_relation' => $_customer['pay_relation_id'],
           'mobile' => $name,
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
       
       $activity_to = $this->session->userdata('ref_activity_url');
       if (! empty($activity_to)) {
           $this->session->unset_userdata('ref_activity_url');
           redirect($activity_to);
           exit();
       }
       
       $return_url = $this->session->userdata('ref_from_url'); // 页面转跳
       if($return_url){
           header("Location:" . $return_url);
           $this->session->set_userdata('ref_from_url', '');
       }else {
           redirect("member/info");
       }
        
        
   }
   
   // ---------------------------------------------------------------------------
   
    /**
     * 填写收货地址确定领取
     */
   public function confirm_to_receive(){
       $real_name = $this->input->post("real_name");//真实姓名
       $mobile = $this->input->post("mobile");//联系人电话
       $address = $this->input->post("address");//收货地址
       $share_id = $this->input->post("share_id");//分享id
       $customer_id = $this->session->userdata("user_id");//用户id
       
       //验证数据
       $this->load->helpers("verification_helper");
       if(!checkMobile($mobile) || !strlen($real_name) || !strlen($address)){
           $return = array(
               'status' => '1',
               'Message' => "参数错误"
           );
           echo  json_encode($return);exit;
       }

       $data["name"] = $real_name;
       $data["mobile"] = $mobile;
       $data["address"] = $address;
       $data["type"] = 1;
       $row = $this->tribe_package_mdl->update_package_log($share_id,$customer_id,$data);
       if($row){
           $return = array(
               'status' => '2',
               'Message' => "成功"
           );
       }else{
           $return = array(
               'status' => '1',
               'Message' => "失败"
           );
       }
       
       echo  json_encode($return);exit;

   }
   
   // ---------------------------------------------------------------------------
   
   
   /**
    * 分享详情
    * id
    */
   public function  share_detail($id){
       //获取用户存在授权分享权限下的货包
       $user_id = $this->session->userdata("user_id");
       $packages = $this->tribe_package_mdl->get_tribe_package($user_id);
       if(empty($packages)){
           echo "<script>alert('无权限');window.location.href ='".site_url('Member/info')."'</script>";
           exit;
       
       }
       if(!$id){
           show_404();
           exit;
       }
       $data['detail'] = $this->tribe_package_mdl->get_share_detail($id);
       if($data['detail'] ){
           $CURRENT_TIME =  date('Y-m-d H:i:s');// 当前时间
           if($data['detail']['grant_start_at'] <=$CURRENT_TIME && $CURRENT_TIME <= $data['detail']['grant_start_at']){
               //是否显示编辑按钮
               $data['detail']['edit_status'] = true;
           }else{
               //是否显示编辑按钮
               $data['detail']['edit_status'] = false;
           }
        //获取货包绑定的部落信息
         $data['tribe_info'] =  $this->tribe_package_mdl->get_share_package_tribe($data['detail']['tribe_ids']);
           
           $data['title'] = "分享详情";
           $data ['head_set'] = 2;
           $data ['foot_set'] = 1;
           $this->load->view('head', $data);
//            $this->load->view('_header', $data); 微信分享不能注册微信JS插件两次
           $this->load->view('', $data);
           $this->load->view('_footer', $data);
           $this->load->view('foot', $data);
       }else{
           show_404();
       }
       
   }
   /**
    * 编辑分享
    * id
    */
   public function  share_edit($id){
       //获取用户存在授权分享权限下的货包
       $user_id = $this->session->userdata("user_id");
       $packages = $this->tribe_package_mdl->get_tribe_package($user_id);
       if(empty($packages)){
           echo "<script>alert('无权限');window.location.href ='".site_url('Member/info')."'</script>";
           exit;
       }
       $data['detail'] = $this->tribe_package_mdl->get_share_detail($id);
       if($data['detail']){
           $CURRENT_TIME =  date('Y-m-d H:i:s');// 当前时间
           if($data['detail']['grant_start_at'] <=$CURRENT_TIME && $CURRENT_TIME <= $data['detail']['grant_start_at']){
           }else{
               //不可编辑
               //跳回列表页
               redirect("Tribe_package/share_list");
//                exit;
           }
           //获取货包绑定的部落信息
           $data['tribe_infos'] =  $this->tribe_package_mdl->get_share_package_tribe($data['detail']['tribe_ids']);

           $data['title'] = "编辑分享";
           $data ['head_set'] = 2;
           $data ['foot_set'] = 1;
           
           $this->load->view('head', $data);
           $this->load->view('_header', $data);
           $this->load->view('', $data);
           $this->load->view('_footer', $data);
           $this->load->view('foot', $data);
           
       }else{
           show_404();
       }
   }
   
    
}