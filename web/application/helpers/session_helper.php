<?php
/**
 * 51易货session统一处理
 * @param 2017年12月7日
 * @author tan
 */


/**
 * 仅限51易货B端登录session处理
 * $data  用户数据对应用户表
 * $type  登录类型  web  或 app   或  other
 */
function set_customer($data,$type ='web'){
    if(empty($data['id'])){
        return  '缺少用户ID';
    }
    
    $user_id = $data['id'];
    $CI = & get_instance();
    $customer = array(
            'user_name'=>'', //用户名称
            'user_id'=>$user_id, //用户ID
            'real_name'=>'',//真实姓名
            'nick_name'=>'',//系统昵称
            'wechat_nickname'=>'',//微信昵称
            'wechat_avatar'=>'',//微信头像
            'brief_avatar'=>'',//系统头像
            'img_avatar'=>'',//系统头像
            'is_active'=>0,
            'sex'=>NULL,//性别默认为女
            'user_last_login'=>'',//最后登录时间
            'user_in'=>true,//登录状态
            'unionid'=>'',//微信unionid
            'openid'=>'',//微信openid
            'wechat_subscribe'=>'',//是否关注公众号
            'mobile'=>'',//手机
            'job'=>'',//职业
            'pay_relation'=>'',//支付账号信息
            'demand_status'=>true,//需求权限
            'verify_status'=>false,//订单核销权限
            'tribe_manager' => false,//是否部落管理者
            'tribe_id' => 0,//当前用户创建部落的ID 或管理的部落id
            'corporation_name'=>'',//企业名称
            'corporation_status'=>'',//企业 0:未生效　1:生效2：冻结
            'approval_status'=>'',//企业审核状态
            'corporation_id'=>'',//企业ID
            'corp_user'=>'',//是否是企业用户
            'Easyshop_id'=>0,//简易店id
    );
    //个人中心名称优先级
    if(!empty($data['real_name'])){
        $user_name = $data['real_name'];
    }else if(!empty($data['nick_name'])){
        $user_name = $data['nick_name'];
    }else if(!empty($data['wechat_nickname'])){
        $user_name = $data['wechat_nickname'];
    }else{
        $user_name = $data['mobile'];
    }
    $customer['user_name'] = $user_name;
    
    //用户真实姓名
    if(!empty($data['real_name'])){
        $customer['real_name'] = $data['real_name'];
    }
    //性别
    if(isset($data['sex'])){
        $customer['sex'] = $data['sex'];
    }
    
    //用户系统昵称
    if(!empty($data['nick_name'])){
        $customer['nick_name'] = $data['nick_name'];
    }
    //用户微信昵称
    if(!empty($data['wechat_nickname'])){
        $customer['wechat_nickname'] = $data['wechat_nickname'];
    }
    //用户微信头像
    if(!empty($data['wechat_avatar'])){
        $customer['wechat_avatar'] = $data['wechat_avatar'];
    }
    //用户系统头像
    if(!empty($data['brief_avatar'])){
        $customer['brief_avatar'] = IMAGE_URL.$data['brief_avatar'];
    }
    if($customer['brief_avatar']){
        $customer['img_avatar'] = $customer['brief_avatar'];
    }else if($customer['wechat_avatar']){
        $customer['img_avatar'] = $customer['wechat_avatar'];
    }
    if($type == 'app'){
        if(!empty($data['brief_avatar'])){
            $customer['wechat_avatar'] = IMAGE_URL.$data['brief_avatar'];
        }
    }
    //用户微信unionid
    if(!empty($data['unionid'])){
        $customer['unionid'] = $data['unionid'];
        $customer['wechat_account'] = $data['unionid'];
    }
    if(!empty($data['wechat_account'])){
        $customer['unionid'] = $data['wechat_account'];
        $customer['wechat_account'] = $data['wechat_account'];
    }
    //用户微信openid
    if(!empty($data['openid'])){
        $customer['openid'] = $data['openid'];
    }
    //是否关注公众号写入session
    if(!empty($data['wechat_subscribe'])){
        $customer['wechat_subscribe'] = $data['wechat_subscribe'];
    }
    
    //用户手机
    if(!empty($data['mobile'])){
        $customer['mobile'] = $data['mobile'];
    }
    
    
    //职业
    if(!empty($data['job'])){
        $customer['job'] = $data['job'];
    }
    //用户支付账号信息
    if(!empty($data['pay_relation'])){
        $customer['pay_relation'] = $data['pay_relation']['id'];
    }
    
    $CI->load->model('Tribe_mdl');
    if($customer['mobile']){
        //---------------------秦商商会逻辑开始---------------------
        $qx_label_id = $CI->session->userdata("label_id");
        if(!empty($qx_label_id) && $qx_label_id == 2){
            //当是在秦商注册绑定后 默认加入到某个部落
            $qs_tribe_id = 155;
            if(base_url() ==  'http://www.51ehw.com/'){
                $qs_tribe_id = 364;
            }
            $qs_tribe_info =  $CI->Tribe_mdl->get_tribe($qs_tribe_id);
            if($qs_tribe_info && $qs_tribe_info['status'] == 2 ){
                $qs_staff_info =  $CI->Tribe_mdl->verify_tribe_user($qs_tribe_id,$customer['mobile']);
                if(!$qs_staff_info){
                    $qs_num = $CI->Tribe_mdl->getQSmemberList($qs_tribe_id);
                    $qs_num ++;
                    $qs_data["customer_id"] = $user_id;
                    $qs_data["tribe_id"] = $qs_tribe_id;
                    $qs_data["mobile"] = $customer['mobile'];
                    $qs_data["member_name"] = '好项目支持者'.$qs_num;
                    $qs_data['status'] = 2;//审核通过
                    $qs_data['show_mobile'] = 2;
                    $aff = $CI->Tribe_mdl->add_staff($qs_data);
                  
                }
            }
        }
        //---------------------秦商商会逻辑结束---------------------
        
        //更新部落用户ID信息
        $update_data['customer_id'] = $user_id;
        $update_data['mobile'] = $customer['mobile'];
        
        $CI->Tribe_mdl->update_tribe_staff( $update_data );
        //同步部落身份信息
        $staff_idenity =  $CI->Tribe_mdl->load_staff_idenity($customer['mobile']);
        if($staff_idenity){
            foreach ($staff_idenity as $key =>$val){
                $CI->Tribe_mdl->del_staff_idenity($val['id']);
                unset( $staff_idenity[$key]['id']);
                unset( $staff_idenity[$key]['mobile']);
                unset( $staff_idenity[$key]['created_at']);
                $staff_idenity[$key]['customer_id'] = $user_id;
            }
            $CI->load->model('Customer_identity_mdl');
            $CI->Customer_identity_mdl->add_idenity_batch($staff_idenity);
        }
        //同步部落预录入的相册个人形象
        $CI->load->model('Tribe_staff_album_mdl');
        $CI->Tribe_staff_album_mdl->synchro_Update($user_id);
    }
    
    
    //查询是否开通简易店
    $CI->load->model("Easyshop_mdl");
    $Easyshop = $CI->Easyshop_mdl->Load($user_id);
    if($Easyshop){
        $customer['Easyshop_id'] = $Easyshop['id'];
    }
    
    //查询是否部落管理者
    $CI->load->model("tribe_mdl");
    $module_id = array();
    if(ISMOBILE == "pc"){//如果是pc端，则判断是否拥有（族员管理，部落资料，商品管理）权限的部落
        $module_id = array(2,3,6);
    }else{
        $module_id = array(1,2,3,4,5);
    }
    $tribe_id = $CI->session->userdata("tribe_id");
    $tribe_id = isset($tribe_id)?$tribe_id:0;
    $customer_id = $user_id;
    $tribe = $CI->tribe_mdl->ManagementTribe($customer_id,$tribe_id,0,$module_id );//查询管理的部落
//     echo "<pre>";
//     echo $CI->db->last_query();exit;
    // $tribe = $CI->tribe_mdl->ManagementTribe($user_id);//查询管理的部落
    $customer["tribe_manager"] = !empty($tribe);
    
    //H5版微信登录处理
    if(isset($data['wechat_subscribe'])){
        //更新用户关注公众号状态
        $CI->load->model('Customer_mdl');
        $CI->Customer_mdl->wechat_subscribe = $data['wechat_subscribe'];
        $CI->Customer_mdl->update($user_id);
    }
    
    //查询企业信息
    $CI->load->model("corporation_mdl");
    $corpinfo = $CI->corporation_mdl->load($user_id);
    //上正式请注释！ $corpinfo['approval_status'] == 2 && $corpinfo['is_paied'] == 1
    if($corpinfo && $corpinfo['approval_status'] == 2 && $corpinfo['is_paied'] == 1)
    { 
        $customer["corporation_name"] = $corpinfo["corporation_name"];
        $customer["corporation_status"] = $corpinfo["status"];
        $customer["approval_status"] = $corpinfo["approval_status"];
        $customer['corporation_id'] = $corpinfo['id'];
        $customer["corp_user"] = true;//店主
        $customer["verify_status"] = true;//店主
    }else{//查询当前用户是否拥有员工核销员权限
        $CI->load->model('Corporation_staff_mdl');
        if($type != 'app'){
            $is_staff = $CI->Corporation_staff_mdl->corp_manage($user_id);
            if(count($is_staff) > 0){
                $customer['is_staff'] = true;
                $corplist = array();
                foreach ($is_staff as $v){
                    $corplist[] = $v;
                }
                $customer['corp_list'] = $corplist;
            }
        }
        //获取该用户在平台的所有在职的企业下的角色信息
        $staff = $CI->Corporation_staff_mdl->get_staff($user_id,2);
        //或者是判断用户是否拥有处理订单的权限  根据9thleaf_corporation_module表确定权限url
        $authority_str = '/Corporate/order/get_list';
        if(!empty($staff)){
            foreach ($staff as $key =>$val){
                $authority = $CI->Corporation_staff_mdl->get_staff_authority($val['corporation_id'],$user_id);
                
                if($authority){
                    //将获取出来的权限字符串进行处理成数组
                    foreach ($authority as $key => $val){
                        $authority_arr[$key] = $val['url'];
                    }
                    if(in_array($authority_str, $authority_arr)){
                        $customer['verify_status'] = true;
                    }
                }
                
            }
        }
    }
    
    //更新购物车
    $CI->load->model('cart_mdl');
    $CI->cart_mdl->reinit($user_id);
    
    $CI->session->set_userdata($customer);
    
    if($type == 'web'){
        
        // 回调地址跳转
        $return_url = $CI->session->userdata('ref_from_url');
        $activity_url = $CI->session->userdata('ref_activity_url');
        
        //活动回调
        if (! empty($activity_url)) {
            $CI->session->unset_userdata('ref_activity_url');
            redirect($activity_url);
        }
        
        //常用回调
        if (! empty($return_url)) {
            $CI->session->unset_userdata('ref_from_url');
            redirect($return_url);
        }else{
            redirect('member/info');
        }
    }else if($type == 'app'){//APP
        return $customer;
    }else if($type == 'other'){
        //不返回任何信息
        //不做任何回调处理
    }
    
    
}


