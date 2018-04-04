<?php
/**
 * 部落货包控制器
 */
class Tribe_package extends Front_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model("tribe_mdl");
        $this->load->model("tribe_package_mdl");
       
        $this->session->set_userdata('ref_from_url', current_url());
        //判断登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
    }
    
   
    
    /**
     * 货包领取
     * id   分享ID
     */
    public function  receive($id){
        
       
        //获取货包内容
        $package = $this->tribe_package_mdl->get_share_detail($id);
        
        //货包不存在
        if(!$package){
            redirect("Home");
            exit;
        }
        //分享人信息
        $this->load->model('customer_mdl');
        $data['share_user'] = $this->customer_mdl->load($package['customer_id']);
        
       
        $grant_end_at =strtotime($package['grant_end_at']);
        $grant_start_at =strtotime($package['grant_start_at']);
        
        //截止日期
        $package['start_date'] = date('Y.m.d',$grant_start_at);
        $package['valid_date'] = date('Y.m.d',$grant_end_at);
        
        //有效期
        $palce_at =  strtotime($package['place_at']);
        $coupon_at = $package['coupon_at'];
        $limit_date = strtotime("+$coupon_at hour",$palce_at);
        
        $data['package'] = $package;
        $this->load->model('customer_mdl');
        $user_id = $this->session->userdata("user_id");
       
        //调用接口处理
        $url = $this->url_prefix.'Customer/load';
        $data_post['customer_id'] = $user_id;
        $customer = json_decode($this->curl_post_result( $url,$data_post ),true);

        //手机默认未绑定
        $data['mobile_exist'] = false;
        //默认未领取该货包
        $data['gain_package_status'] = false;
        //货包默认过期
        $data['gain_package_time'] = false;
        //货包数量默认领取完
        $data['gain_package_num'] = false;
       
        //判断当前货包是否过期
        if(time()  < $limit_date ){
            $data['gain_package_time'] = true;
        }
        
        //判断当前货包是否领取完
        $surplus_num = count($this->tribe_package_mdl->get_share_count($id));
        
        if($surplus_num > 0){
            $data['gain_package_num'] = true;
        }
        //获取用户在易货网设置过的默认地址
        $this->load->model("Customer_address_mdl");
        $address_info =  $this->Customer_address_mdl->load($user_id);
        $data['address_info'] = $address_info;

        //已经绑定手机
        if(!empty($customer['mobile'])){
          
            $data['mobile_exist'] = true;
            // 检查是否领取货包
            $gain_package_info = $this->tribe_package_mdl->load($user_id,$package['tribe_package_id']);
            if($gain_package_info){ //领取过该货包
                if($gain_package_info['package_share_id'] != $id){
                    $url = 'Activity/Tribe_package/receive/'.$gain_package_info['package_share_id'];
                    redirect($url);
                }
                //领取货包状态改为已领取
                $data['gain_package_status'] = true;
                //领取货包的详细信息（收货信息）
                $data['gain_package_info'] =$gain_package_info;
            }
            else{
                //已是易货会员未领取该货包
                if( !$data['gain_package_time'] || !$data['gain_package_num']){//当货包过期或已被领取完  依然要加入部落
                    $package_info = $this->tribe_package_mdl->get_tribe_packageById($package['tribe_package_id'],true);//查询货包信息
                    
                    $staff_info = $this->tribe_mdl->verify_tribe_customer($package_info['tribe_id'],$user_id,0);//检查我是否存在部落
                    if(!$staff_info){
                        $tribe = $this->tribe_mdl->get_tribe($package_info['tribe_id']);
                        $req["customer_id"] = $user_id;
                        $req["tribe_id"] = $package_info['tribe_id'];
                        $req["mobile"] = $customer['mobile'];
                        $req["member_name"] = $customer['real_name'] ? $customer['real_name']:"易货会员".$user_id;
                        $req['status'] = 2;//审核通过
                        $aff = $this->tribe_mdl->add_staff($req);
                    }
                }else{
                    //需要手动领取货包跟加入部落
                    $data['sub_package_info']['tribe_package_id'] = $package['tribe_package_id'];
                    $data['sub_package_info']['user_id'] = $user_id;
                    $data['sub_package_info']['mobile'] = $customer['mobile'];
                    $data['sub_package_info']['share_id'] = $id;
                }
                
                //先检查下货包状态
                
//                 //执行领取
//                 $result = $this->gain_pack_staff($package['tribe_package_id'],$member_name = 0,$user_id,$customer['mobile'],$id);
//                 if($result['status'] == 8 ){
//                     // 检查是否领取货包
//                     $gain_package_info = $this->tribe_package_mdl->load($user_id,$package['tribe_package_id']);
                  
//                     if($gain_package_info){
//                         //领取货包状态改为已领取
//                         $data['gain_package_status'] = true;
//                         //领取货包的详细信息（收货信息）
//                         $data['gain_package_info'] =$gain_package_info;
//                     }
//                 }else if($result['status'] == 4){//领取失败
//                     $data['gain_package_time'] = false;
//                 }else if($result['status'] == 10){//领取失败
//                     $data['gain_package_num'] = false;
//                 }
            }

        }
       
        //获取该货包多少人领取
        $gain_package_list = $this->tribe_package_mdl->get_gain_package_list($id); 
        $data['gain_package_list'] =$gain_package_list;
        $data['surplus_num'] = count($gain_package_list);
        //领取的人随机回复处理(每刷新一次都会变)
        $tribe_package = $this->tribe_package_mdl->get_tribe_packageById($package['tribe_package_id']);
        $reply = explode(';',$tribe_package['reply']);
        $reply = array_filter($reply);//删除空
        if(count($reply) > 2){
            foreach ($data['gain_package_list'] as $key =>$val){
                $reply_key = array_rand($reply,1);//获取随机的数组key
                $data['gain_package_list'][$key]['reply'] = $reply[$reply_key];
            }
        }else if(count($reply) == 1){ 
            foreach ($data['gain_package_list'] as $key =>$val){
//                 $reply_key = array_rand($reply,1);//获取随机的数组key
                $data['gain_package_list'][$key]['reply'] = $reply[0];
            }
        }else{
            foreach ($data['gain_package_list'] as $key =>$val){
                //                 $reply_key = array_rand($reply,1);//获取随机的数组key
                $data['gain_package_list'][$key]['reply'] = '';
            }
        }
        
      
        //货包绑定的部落信息
        $data['tribe'] = $this->tribe_mdl->get_share_package_tribe($package['tribe_id']);
     
      
        $data['title'] = $package['tribe_package_name'];
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view('head', $data);
//         $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_package/new_tribe_package', $data);
//         $this->load->view('tribe/tribe_package/package', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    public  function  package_add_staff(){
        $tribe_id = $this->input->get_post("tribe_id");
        $tribe = $this->tribe_mdl->get_tribe($tribe_id);
        if(!$tribe){
            $return = array(
                'status' => '3',
                'Message' => "部落不存在！"
            );
            echo json_encode($return);exit;
        }
      
        //检查用户是否填写真实姓名
        $this->load->model("customer_mdl");
        $user_id = $this->session->userdata("user_id");
        $user_info = $this->customer_mdl->load($user_id);
        
        
        $_data['mobile'] = $this->input->get_post("mobile");
//         $_data['member_name'] = $this->input->get_post("member_name");

        if(!$user_info['real_name']){
            //更新真实姓名
            $url = $this->url_prefix.'Customer/info_save';
            $req['real_name'] = "易货会员".$user_id;
            $req['user_id'] = $user_id;
            $aff = json_decode($this->curl_post_result($url,$req),true);
        }else{
            $_data['member_name'] = $user_info['real_name'];
        }
        $_data['tribe_id'] = $tribe_id;
        $_data["customer_id"] = $user_id;
        $_data['status'] = 2;//审核
        
        $aff = $this->tribe_mdl->add_staff($_data);
        if($aff){
            $return = array(
                'status' => '2',
                'Message' => "提交加入部落成功！"
            );
        }else{
            $return = array(
                'status' => '3',
                'Message' => "提交加入部落失败！"
            );
        }       
        echo json_encode($return);
    }
    /**
     * 退货包
     */
    public function refund_package(){
        
        //查询有多少要个货包要处理
        $package = $this->tribe_package_mdl->refund_package();
      
        foreach ($package as $key =>$val){
            //计算要退回的货包数量
            $info = $this->tribe_package_mdl->get_refund_package_count($val['id']);
            if($info){
                $surplus_num = $val['surplus_num']+$info['total'];//剩余货包数加上退回的
                //更新
                $this->tribe_package_mdl->update_refund_package($val['id'],$surplus_num);
            }
        }
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
       $data['title'] = "我的分享";
       $data ['head_set'] = 2;
       $data ['foot_set'] = 1;
       $this->load->view('head', $data);
       $this->load->view('_header', $data);
       $this->load->view('tribe/tribe_package/share_list', $data);
       $this->load->view('_footer', $data);
       $this->load->view('foot', $data);
   }
   /**
    * 异步加载分享列表
    */
   public function  ajax_share_list(){
       $user_id = $this->session->userdata("user_id");
       //无刷新加载数据
       $page = $this->input->get_post('page');
       $pagesize = 5;
       if($page == 1){
           $page = 0;
       }else{
           $page   = ($page - 1 ) * $pagesize;
       }
       $share_list = $this->tribe_package_mdl->get_share_list($user_id,$pagesize,$page);
    
       $data['List'] = $share_list;
       echo json_encode($data);
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
      
       $_package = $this->tribe_package_mdl->get_tribe_package($user_id,0,0);
       foreach ($_package as $key =>$val){
           $_package[$key]['grant_start_at'] =  date('Y.m.d',strtotime($val['grant_start_at']));
           $_package[$key]['grant_end_at'] =  date('Y.m.d',strtotime($val['grant_end_at']));
       }
//        echo '<pre>';
//        echo $this->db->last_query();
//        print_r($_package);exit;
       $data['packages'] =$_package;
  
       $data['title'] = "创建分享";
       $data ['head_set'] = 2;
       $data ['foot_set'] = 1;
       $this->load->view('head', $data);
       $this->load->view('_header', $data);
       $this->load->view('tribe/tribe_package/create_share', $data);
       $this->load->view('_footer', $data);
       $this->load->view('foot', $data);
       
   }
   
   /**
    * 异步获取后台设置的货包剩余数量
    */
   
   public function ajax_get_Package(){
      $tribe_package_id =  $this->input->get_post("tribe_package_id");
      $tribe_package = $this->tribe_package_mdl->get_tribe_packageById($tribe_package_id);
    
      $tribe = $this->tribe_mdl->get_share_package_tribe($tribe_package['tribe_id']);
      $tribe_package['tribe_name'] = $tribe['name'];
      $tribe_package['grant_start_at'] =  date('Y.m.d',strtotime($tribe_package['grant_start_at']));
      $tribe_package['grant_end_at'] =  date('Y.m.d',strtotime($tribe_package['grant_end_at']));
      $data['Package'] = $tribe_package;
      echo json_encode($data);
   }
   
   /**
    * 异步获取后台货包设置的部落信息
    */
   public function ajax_get_share_package_tribe(){
       //货包ID
       $tribe_package_id = $this->input->get_post("tribe_package_id");
       $tribe_package = $this->tribe_package_mdl->get_tribe_packageById($tribe_package_id);
       $data['tribe_infos'] =  $this->tribe_mdl->get_share_package_tribe($tribe_package['tribe_id']);
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
   public function gain_package(){
       
       $share_id =$this->input->post('share_id');//分享货包id
       $package_id = $this->input->post('package_id');//货包id
//        $real_name = $this->input->post('real_name');//真实姓名
       $real_name = '易货会员'; 
       $mobile = $this->input->post('mobile');//手机
       $vertify1 = $this->input->post('yzm');//验证码
      
       $vertify2 = $this->session->userdata('verfity_yzm_255');//session验证码
       $mobile2 = $this->session->userdata('verfity_mobile_255');//session手机
       $set_time = $this->session->userdata('verfity_settime_255');//session验证码有效时间
       
       $this->session->set_userdata("package_mobile",$mobile);//当领取货包成功后，默认填写这个手机号
       
       //验证码验证
       if($vertify1 != $vertify2 || $mobile != $mobile2){
           $return = array(
               'status' => '1',
               'Message' => "验证码错误"
           );
           echo  json_encode($return);exit;
       }
       
       // 验证码超时验证
       if(date('Y-m-d H:i:s',strtotime("-300 second")) > $set_time){
           $return = array(
               'status' => '2',
               'Message' => "验证码超时"
           );
           echo  json_encode($return);exit;
       }
       $this->load->model("tribe_mdl");
       //调用接口 查询该手机是否已经绑定用户
       $post['mobile'] = $mobile;
       $url = $this->url_prefix.'Customer/load_by_mobile';
       $_customer = json_decode($this->curl_post_result($url,$post),true);
       if($_customer){//手机之前已经注册过
           
           if($_customer['wechat_account']){//已经绑定了微信
               $return = array(
                  'status' => '4',
                  'Message' => "此账户已经绑定微信"
               );
               echo  json_encode($return);exit;
           }
           //没有绑定微信
           //接口--绑定用户
           if(!$_customer['nick_name'] || $_customer['nick_name'] == '访客'){
               $data['nick_name'] = $this->session->userdata('wechat_nickname');
               $data['Nickname'] = $this->session->userdata('wechat_nickname');
           }
           $data['user_id'] = $_customer['id'];
           $data['openid'] = $this->session->userdata('openid');
           $data['unionid'] = $this->session->userdata('unionid');
           $data['wechat_avatar'] = $this->session->userdata('wechat_avatar');
           $data['wechat_nickname'] = $this->session->userdata('wechat_nickname');
           $url = $this->url_prefix.'Customer/info_save';
           $is_binding = json_decode($this->curl_post_result($url,$data),true);
           if(!$is_binding){
               $return = array(
                  'status' => '3',
                  'Message' => "绑定失败"
               );
               echo  json_encode($return);exit;
           }

           //发送绑定成功信息
           $this->load->model('Customer_message_mdl',"Message");
           $link = $this->url_prefix.'Customer/load?';
           $dta['customer_id'] = $data['user_id'];
           $customers = json_decode($this->curl_post_result($link,$dta),true);
           $Msg_info['template_id']= 4;
           $Msg_info['name']= '账号绑定';
           $Msg_info['customer_id']= $data['user_id'];
           $Msg_info['obj_id'] = 0;
           $Msg_info['type'] = 1;
           $Msg_info['parameter']['name'] = isset($customers['nick_name']) && !empty($customers['nick_name'])? $customers['nick_name']:$customers['name'];
           $this->Message->Create_Message($Msg_info);
       

       }else{//手机之前没有注册过
            //用手机注册一个新用户并生成一个新的支付账户
            //生成密码默认值
          
            $password = 'ehw888888';
            $post['mobile'] = $mobile;
            $post['tbxRegisterPassword'] = $password;
            $post['nickname'] = $this->session->userdata('wechat_nickname');
            $post['Nickname'] = $this->session->userdata('wechat_nickname');
            $post['unionid'] = $this->session->userdata('unionid');
            $post['headimgurl'] = $this->session->userdata('wechat_avatar');
            $post['openid'] = $this->session->userdata('openid');
            $post['registry_by'] = "H5";
            $post['app_id'] = $this->session->userdata("app_info")["id"];
            $post['time'] = date("Y-m-d H:i:s");
            
            //调用接口
            $url = $this->url_prefix.'Customer/save';
            $_customer = json_decode($this->curl_post_result($url,$post),true);
            $_customer['id'] =$_customer['customer_id']; 
       }
       
       $customer_id =$this->session->userdata("user_id");
       //将微信注册账号给失效
       $info['customer_id'] = $customer_id;
       $info['type'] = 'wechat';
       //接口-
       $url = $this->url_prefix.'Customer/unbundling';
       $this->curl_post_result($url,$info);
       
       //申请加入部落及领取货包
       $return = $this->gain_pack_staff($package_id,$real_name,$_customer['id'],$mobile,$share_id);
      
       //加载用户支付账户信息写入session
       $url = $this->url_prefix.'Customer/get_pay_relation_id?';
       $data['customer_id'] = $_customer['id'];
       $pay_data = json_decode($this->curl_post_result($url,$data),true);
       
       $this->load->helper("session");
       $this->load->model("customer_mdl");
       $info = $this->customer_mdl->load($_customer['id']);
       $info['pay_relation'] = $pay_data;
       set_customer($info,"other");
       echo  json_encode($return);
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
       
       if(!checkMobile($mobile)){
           $return = array(
               'status' => '1',
               'Message' => "手机：$mobile"
           );
           echo  json_encode($return);exit;
       }
       if(!strlen($real_name)){
           $return = array(
               'status' => '1',
               'Message' => "姓名"
           );
           echo  json_encode($return);exit;
       }
       if(!strlen($address)){
           $return = array(
               'status' => '1',
               'Message' => "地址"
           );
           echo  json_encode($return);exit;
       }
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
           //更新真实姓名
           $post['user_id'] = $customer_id;
           $post['real_name'] = $real_name;
           $url = $this->url_prefix.'Customer/info_save';
           $result = json_decode($this->curl_post_result($url,$post),true);
           $this->load->model("tribe_mdl");
           $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$customer_id);
           $this->session->set_userdata('user_name', $real_name);
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
           //处理货包有效时间
           $palce_at =  strtotime($data['detail']['grant_end_at']);
           $start_at =  strtotime($data['detail']['grant_start_at']);
           $data['detail']['start_at'] = date('Y.m.d',$start_at);
           //有效期
           $data['detail']['valid_date'] = date('Y.m.d',$palce_at);
//            //处理货包有效时间
//            $palce_at =  strtotime($data['detail']['place_at']);
//            $coupon_at = $data['detail']['coupon_at'];
//            //有效期
//            $data['detail']['valid_date'] = date('Y年m月d日',strtotime("+$coupon_at hour",$palce_at));
           $CURRENT_TIME =  date('Y-m-d H:i:s');// 当前时间
           if($data['detail']['grant_start_at'] <=$CURRENT_TIME && $CURRENT_TIME <= $data['detail']['grant_end_at']){
               //是否显示编辑按钮
               $data['detail']['edit_status'] = true;
           }else{
               //是否显示编辑按钮
               $data['detail']['edit_status'] = false;
           }
           
        //判断当前货包是否领取完
        $gain_package_list = $this->tribe_package_mdl->get_gain_package_list($id); 
        $data['surplus_num'] = count($gain_package_list);
      
        //获取货包绑定的部落信息
         $data['tribe_info'] =   $this->tribe_mdl->get_share_package_tribe($data['detail']['tribe_id']);
      
           $data['title'] = "分享详情";
           $data ['head_set'] = 2;
           $data ['foot_set'] = 1;
           $this->load->view('head', $data);
//            $this->load->view('_header', $data); 微信分享不能注册微信JS插件两次
           $this->load->view('tribe/tribe_package/share_detail', $data);
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
           //处理货包有效时间
           $palce_at =  strtotime($data['detail']['grant_end_at']);
           //有效期
           $data['detail']['valid_date'] = date('Y年m月d日',$palce_at);
//            $coupon_at = $data['detail']['coupon_at'];
//            //有效期
//            $data['detail']['valid_date'] = date('Y年m月d日',strtotime("+$coupon_at hour",$palce_at));
         
           $CURRENT_TIME =  date('Y-m-d H:i:s');// 当前时间
           if($data['detail']['grant_start_at'] <=$CURRENT_TIME && $CURRENT_TIME <= $data['detail']['grant_end_at']){
           }else{
               //不可编辑
               //跳回列表页
               echo "<script>alert('该分享已失效，无法再次编辑！');window.location.href ='".site_url('Temporary/Tribe_package/share_list')."'</script>";
               exit;
           }
           //获取货包绑定的部落信息
           $data['tribe_info'] =   $this->tribe_mdl->get_share_package_tribe($data['detail']['tribe_id']);

           $data['title'] = "编辑分享";
           $data ['head_set'] = 2;
           $data ['foot_set'] = 1;
           
           $this->load->view('head', $data);
           $this->load->view('_header', $data);
           $this->load->view('tribe/tribe_package/edit_share', $data);
           $this->load->view('_footer', $data);
           $this->load->view('foot', $data);
           
       }else{
           show_404();
       }
   }
   
   
   //-------------------------------------------------------
   /**
    * @param unknown $package_id 货包ID
    * @param unknown $BindingMobile 绑定手机
    * @param unknown $customer_id 用户id
    */
   public  function gain_pack_staff($package_id,$type = 0,$customer_id,$BindingMobile,$share_id){
       
       $package = $this->tribe_package_mdl->get_share_detail($share_id);
       if(!$package){
           if($type && $type == "json"){
           
               echo false;exit;
           }else{
               $return = array(
                   'status' => '4',
                   'Message' => "领取失败"
               );
               return $return;
           }
       }
       
       //检查用户是否已经领取过次卡包
       $row  = $this->tribe_package_mdl->check($customer_id,$package_id);
       if($row){
           $return = array(
               'status' => '5',
               'Message' => "已经领取过"
           );
           if($type && $type == "json"){
               echo json_encode($return);exit;
           }else{
               return $return;
           }
          
       }
       
       $this->db->trans_begin();//开启事务
       $is_ok = false;
       $row = $this->tribe_package_mdl->Packet_receipt($customer_id,$package_id,$share_id);//领取货包
       
       $package_info = $this->tribe_package_mdl->get_tribe_packageById($package_id,true);//查询货包信息
       
       //检查用户是否填写真实姓名
       $this->load->model("customer_mdl");
       $user_info = $this->customer_mdl->load($customer_id);
       
       if($row){
           
           $staff_info = $this->tribe_mdl->verify_tribe_customer($package_info['tribe_id'],$customer_id,0);//检查我是否存在部落
           if($staff_info){
               $this->db->trans_commit();
               $return = array(
                   'status' => '8',
                   'Message' => "领取成功！"
               );
               if($type && $type = "json"){
                   echo json_encode($return);exit;
               }else{
                   return $return;
               }
           }
           //处理预录入更新部落用户ID信息
           $update_data['customer_id'] = $customer_id;
//            $update_data['status'] = 2;
           $update_data['tribe_id'] = $package_info['tribe_id'];
           $update_data['mobile'] = $BindingMobile;
           $this->load->model('tribe_mdl');
           $update_aff = $this->tribe_mdl->update_tribe_staff( $update_data );
           if($update_aff){
               $is_ok = true;
           }else{
               $staff_info = $this->tribe_mdl->verify_tribe_customer($package_info['tribe_id'],$customer_id,0);//检查我是否存在部落
               //未申请 不存在
               if(!$staff_info){
                   if(!$user_info['real_name']){
                       //更新真实姓名
                       $url = $this->url_prefix.'Customer/info_save';
                       $req['real_name'] = "易货会员".$customer_id;
                       $req['user_id'] = $customer_id;
                       $aff = json_decode($this->curl_post_result($url,$req),true);
                   }
                   
                   $tribe = $this->tribe_mdl->get_tribe($package_info['tribe_id']);
                   $data["customer_id"] = $customer_id;
                   $data["tribe_id"] = $package_info['tribe_id'];
                   $data["mobile"] = $BindingMobile;
                   $data["member_name"] = $user_info['real_name'] ? $user_info['real_name']:"易货会员".$customer_id;
                   $data['status'] = 2;//审核通过
                   $aff = $this->tribe_mdl->add_staff($data);
                   if($aff){
                       $is_ok =true;
                   }
               }
           }
            
           if(isset($is_ok) && $is_ok){
               $this->db->trans_commit();
               $return = array(
                   'status' => '8',
                   'Message' => "领取成功！"
               );
           }else{
               $this->db->trans_rollback();
               $return = array(
                   'status' => '4',
                   'Message' => "领取失败"
               );
           }
           
           if($type && $type == "json"){
               echo json_encode($return);exit;
           }else{
               return $return;
           }
       
       }else{
           $this->db->trans_rollback();
           
           $staff_info = $this->tribe_mdl->verify_tribe_customer($package_info['tribe_id'],$customer_id,0);//检查我是否存在部落
           //未申请 不存在
           if(!$staff_info){
                if(!$user_info['real_name']){
                    //更新真实姓名
                    $url = $this->url_prefix.'Customer/info_save';
                    $req['real_name'] = "易货会员".$customer_id;
                    $req['user_id'] = $customer_id;
                    $aff = json_decode($this->curl_post_result($url,$req),true);
                }
               
               $tribe = $this->tribe_mdl->get_tribe($package_info['tribe_id']);
               $data["customer_id"] = $customer_id;
               $data["tribe_id"] = $package_info['tribe_id'];
               $data["mobile"] = $BindingMobile;
               $data["member_name"] = $user_info['real_name'] ? $user_info['real_name']:"易货会员".$customer_id;
               $data['status'] = 2;//审核通过
               $aff = $this->tribe_mdl->add_staff($data);
               $return = array(
                       'status' => '10',
                       'Message' => "货包已经领完了！"
                   );
               if($type && $type == "json"){
                   echo json_encode($return);exit;
               }else{
                   return $return;
               }
         
       }
      
   }
 }
   
 
 
}