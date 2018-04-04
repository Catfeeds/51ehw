<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once FCPATH.'application/libraries/Easemob.php';

class Control extends Front_Controller
{
    var $options = array();
    var $h;
    
    function __construct()
    {
        parent::__construct();
        $user_id = $this->session->userdata("user_id");
        if(!$user_id){
            //稍微限制下必选存在用户登录下才能使用聊天系统
            show_404();
            exit;
        }
        $this->load->model('Chat_message_mdl','chat');
        //目前需求暂时只需要用到环信上一个应用  后续可开发多个应用进行聊天   2018.01.16 autor Tan
        if(base_url() == 'http://www.test51ehw.com/' || base_url()=='http://localhost/51ehw/web/' || base_url()=='http://test51ehw.9-leaf.com/'){
               //测试
               $parm['client_id'] = 'YXA6bZRHEG0eEeeyLoGg_S8Sfg';
               $parm['client_secret'] = 'YXA66J5F_NoG2GZ_8fcQRLNLxSdHqlI';
               $parm['org_name'] = '1141170719115422';
               $parm['app_name'] = 'tribebox-test';
                
           }else{
               //正式
               $parm['client_id'] = 'YXA60WhJsAsdEeiqD-e_-6s4uw';
               $parm['client_secret'] = 'YXA6T3McYmkmiIB5cM8pJBhF3JHXVBc';
               $parm['org_name'] = '1162180206115305';
               $parm['app_name'] = '51web';
           }
        $this->options = $parm;
        $this->h = new Easemob($this->options);
    }
    
    function  index(){
        echo  'Chat';
        exit;
    }
    
    /**
     * 聊天列表 全站
     */
    public function Lists(){
        $user_id = $this->session->userdata("user_id");//用户id
        if(!$user_id || $user_id == ''){
            echo "<script>history.back(-1);alert('用户未登录');</script>";exit;
        }
        
        //定义一个存放聊天室的数组
        $channel_list = array();
        
        //获取用户加入的所有部落
        $this->load->model('Tribe_mdl');
        $Tribes = $this->Tribe_mdl->MyTribe($user_id);
        
        //通过部落ID查询群聊聊天室ID
        if($Tribes){
            $TribeIds = array();
            $chat_channel_ids = array();
            foreach ($Tribes as $k=>$v ){
                $TribeIds[] = $v['id'];
                
                $single_chat =  $this->chat->getChatList($v['id']);
             
                if($single_chat){
                    foreach ($single_chat as $k1=>$v1 ){
                        if(!in_array($v1['chat_channel_id'],$chat_channel_ids )){
                            //获取部落下所有的单聊聊天室ID
                            $single = array(
                                'type'=>'single',
                                "tribe_id"=>$v['id'],
                                "chat_channel_id"=>$v1['chat_channel_id'],
                                "update_at"=>$v1['update_at'],
                                
                            );
                            $channel_list[] = $single;
                            $chat_channel_ids[] = $v1['chat_channel_id'];
                        }
                    }
                }
            }
           
            $TribeChatLists = $this->chat->getTribeChatLists($TribeIds);
          
//             echo '<pre>';
//             print_r($TribeChatLists);
//             exit;
            if($TribeChatLists){
                foreach ($TribeChatLists as $k=>$v ){
                    $group = array(
                        'type'=>'group',
                        "tribe_id"=>$v['tribe_id'],
                        "chat_channel_id"=>$v['id'],
                        "update_at"=>$v['create_at'],
                    );
                    $channel_list[] = $group;
                    $chat_channel_ids[] = $v['id'];
                    
                }
            }
//             echo '<pre>';
//             print_r($channel_list);
//             exit;
        }
       
        
        $chatList = array ();
        if($channel_list){
            foreach ($channel_list as $k => $v){
                $chatList[$k]['tribe_id'] = $v['tribe_id'];
                $chatList[$k]['chat_channel_id'] = $v['chat_channel_id'];
                $condition = array();
                $condition['chat_channel_id'] = $v['chat_channel_id'];
                
                //获取最新一条信息
                $Msg_info = $this->chat->getChatLog($condition,1);
                $chatList[$k]['Msg_info']  = $Msg_info;
                if(!$Msg_info){
                   $chatList[$k]['sort_at'] = $v['update_at'];
                }else{
                    $chatList[$k]['sort_at'] = $Msg_info['create_at'];
                }
              if($v['type'] == 'single'){
                  $chatList[$k]['Msg_count'] = $this->chat->getNotReadCount($v['chat_channel_id']);
                  $Send_info = $this->chat->geChatUser($v['chat_channel_id']);
                  if(!$Send_info){
                      //只有自己发的
                      $OtherMember =  $this->chat->getChannelOtherMember($v['chat_channel_id'],$user_id);//另外一个人的
                      $this->load->model('customer_mdl');
                      $OtherMemberinfo = $this->customer_mdl->load($OtherMember['customer_id']);
                      $Send_info  = array(
                          'from_customer_id' => $OtherMember['customer_id'],
                          'real_name' => $OtherMemberinfo['real_name'],
                          'brief_avatar' => $OtherMemberinfo['brief_avatar'],
                          'wechat_avatar' => $OtherMemberinfo['wechat_avatar'],
                      );
                  }
                  //获取发送人信息
                  $chatList[$k]['Send_info'] = $Send_info;
              }else{
                  $chatList[$k]['tribe_info'] = $this->Tribe_mdl->get_tribe($v['tribe_id']);
                  $chatList[$k]['Msg_count'] = $this->chat->getNotReadCount(0,$v['tribe_id']);
              }  
            }
        } 
        
        //时间排序
        $sort = array(
            'direction' => 'SORT_DESC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
            'field'     => 'sort_at',       //排序字段
        );
        $arrSort = array();
        foreach($chatList as $k => $v){
            foreach($v AS $key=>$value){
                $arrSort[$key][$k] = $value;
            }
        }
        if($sort['direction']){
            array_multisort($arrSort[$sort['field']], constant($sort['direction']), $chatList);
        }
        
        
//         echo '<pre>';
//         print_r($chatList);exit;
        $data['list'] = $chatList;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] =  '聊天信息';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('webim/Lists', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    } 
    
    
    
    /**
     * 聊天列表
     */
    public function chatList($tribe_id = 0,$label_id = 0){
        $user_id = $this->session->userdata("user_id");//用户id
        
        if(!$user_id || $user_id == ''){
            echo "<script>history.back(-1);alert('用户未登录');</script>";exit;
        }
        if(!$tribe_id){
            echo "<script>history.back(-1);alert('参数错误');</script>";exit;
        }
        $this->load->model("tribe_mdl");
        $member_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$user_id);//检查我是否存在部落
        if(!$member_info){
            echo "<script>history.back(-1);alert('非法链接');</script>";exit;
        }
        
        $chatlist =  $this->chat->getChatList($tribe_id);
        // echo '<pre>';
        // print_r($this->db->last_query());exit;
        $single_chat =  array();
        $condition = array();
        foreach ($chatlist as $k => $v){
            $condition['chat_channel_id'] = $v['chat_channel_id'];
            
            //获取最新一条信息
            $chatlist[$k]['Msg_info']  = $this->chat->getChatLog($condition,1);
//             echo '<pre>';
//             print_r($this->db->last_query());exit;
            //获取未读消息数
            if(!$v['is_read']){
                $chatlist[$k]['Msg_count'] = $this->chat->getNotReadCount($v['chat_channel_id']);
            }else{
                $chatlist[$k]['Msg_count'] = 0;
            }
            $Send_info = $this->chat->geChatUser($v['chat_channel_id']);
            if(!$Send_info){
                //只有自己发的
               $OtherMember =  $this->chat->getChannelOtherMember($v['chat_channel_id'],$user_id);//另外一个人的
               $this->load->model('customer_mdl');
               $OtherMemberinfo = $this->customer_mdl->load($OtherMember['customer_id']);
               $Send_info  = array(
                   'from_customer_id' => $OtherMember['customer_id'],
                   'real_name' => $OtherMemberinfo['real_name'],
                   'brief_avatar' => $OtherMemberinfo['brief_avatar'],
                   'wechat_avatar' => $OtherMemberinfo['wechat_avatar'],
               );
            }
            //获取发送人信息
            $chatlist[$k]['Send_info'] = $Send_info;
          
            $single_chat[] =  $chatlist[$k];
        }
      
        $data['single_chat'] = $single_chat;
        
        $group_chat = $this->chat->getTribeChatList($tribe_id);
        if($group_chat){
            $condition = array();
            $condition['chat_channel_id'] = $group_chat['id'];
            $group_chat['Msg_info']  = $this->chat->getChatLog($condition,1);
            $group_chat['Msg_count'] = $this->chat->getNotReadCount(0,$tribe_id);
            
            $data['group_chat']  = $group_chat;
//             echo '<pre>';
//             print_r( $data['group_chat']);exit;
        }
   
        
//         echo '<pre>';
//         print_r($data);exit;
        
        $data['label_id'] = $label_id;
        $data['tribe_id'] = $tribe_id;
        $data['chatListTag'] = 'chatListTag';
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] =  '聊天列表';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('webim/chat_List', $data);
//         $this->load->view('webim/tirbal_chat', $data);
//         $this->load->view('webim/personal_chat', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 群聊
     */
    public function chats($Channel_id){
        
        $Channel = $this->chat->loadChannelById($Channel_id);
        if(!$Channel){
            //聊天室不存在
            echo "<script>alert('非法访问');history.back();</script>";exit;
        }else if($Channel['tribe_id'] == 0){
            //不是群聊
            echo "<script>alert('非法访问');history.back();</script>";exit;
        }
        $this->load->model("tribe_mdl");
        $tribe = $this->tribe_mdl->get_tribe($Channel['tribe_id']);
        if(!$tribe || $tribe['status'] != 2){
            //部落不存在
            echo "<script>alert('部落不存在');history.back();</script>";exit;
        }
        $user_id = $this->session->userdata("user_id");
        //检查我有没有加入过这个部落
        $ts_info = $this->tribe_mdl->verify_tribe_customer($Channel['tribe_id'],$user_id);//检查我是否存在部落
        if(!$ts_info){
            //未加入部落
            echo "<script>alert('尚未加入部落');history.back();</script>";exit;
        }
        
        $member = $this->chat->getChannelMember($Channel_id,$user_id);
       
        if(!$member){
            //当用户加入了部落  没有添加到聊天室时则添加
            $this->chat->addChannelMember($Channel_id,$Channel['huanxin_group_id'],$user_id);//本地服务器添加
        }
        
        //判断当前用户是否在环信聊天室
        $huanxin_member_info = $this->h->getGroupUsers($Channel['huanxin_group_id']);
     
        $huanxin_GroupMember = array();
        $huanxin_GroupOwner = 0;
        foreach ($huanxin_member_info['data'] as $key =>$val){
            //获取环信聊天室上的成员
            if(!empty($val['member'])){
                $huanxin_GroupMember[] =  $val['member'];
            }
            //环信聊天室的拥有者
            if(!empty($val['owner'])){
                $huanxin_GroupOwner =  $val['owner'];
            }
        }
        //当没有成员  或当前用户不存在聊天室内 则添加
        if(!$huanxin_GroupMember || !in_array($user_id, $huanxin_GroupMember)){
             $this->h->addGroupMember($Channel['huanxin_group_id'],$user_id);
        }
        
        //处理自己的信息
        $this->load->model('customer_mdl');
        $from_customer = $this->customer_mdl->load($user_id);
        $real_name = '';
        $logo = '';
        if(empty($from_customer['real_name'])){
            if(empty($from_customer['nick_name'])){
                $real_name= $from_customer['wechat_nickname'];
            }else{
                $real_name = $from_customer['nick_name'];
            }
        }else{
            $real_name = $from_customer['real_name'];
        }
        
        if(empty($from_customer['brief_avatar'])){
            $logo = $from_customer['wechat_avatar'];//微信头像不用拼接IMAGE_URL
        }else{
            $logo = IMAGE_URL.$from_customer['brief_avatar'];
        }
        $info = array(
            'id'=> $user_id,
            'real_name'=> $real_name,
            'logo'=> $logo,
        );
        $data['from_customer'] = $info;
        
        
        //获取历史记录的前5条
        $condition['chat_channel_id'] = $Channel_id;
        $list = $this->chat->getChatLog($condition,10);
        if($list){
            foreach ($list as $key =>$val){
                if($val['from_customer_id'] == $user_id){
                    continue;
                }
                $to_customer =   $this->customer_mdl->load($val['from_customer_id']);
                $real_name = '';
                $logo = '';
                if(empty($to_customer['real_name'])){
                    if(empty($to_customer['nick_name'])){
                        $real_name= $to_customer['wechat_nickname'];
                    }else{
                        $real_name = $to_customer['nick_name'];
                    }
                }else{
                    $real_name = $to_customer['real_name'];
                }
                
                if(empty($to_customer['brief_avatar'])){
                    $logo = $to_customer['wechat_avatar'];//微信头像不用拼接IMAGE_URL
                }else{
                    $logo = IMAGE_URL.$to_customer['brief_avatar'];
                }
                $Send_info = array(
                    'real_name'=> $real_name,
                    'logo'=> $logo,
                );
                $list[$key]['Send_info'] = $Send_info;
            }
        }
        //部落群聊的聊天室并不存在每个用户的列表中
        //部落的未读的消息标记为已读
        $aff = $this->chat->updateAllReadLog($Channel_id,$user_id);
//        echo '<pre>';
//        print_r($this->db->last_query());exit;
        $data['Msg_list'] = $list;
        
//         echo '<pre>';
//         print_r($data);exit;
        //         echo  '<pre>';
        //         print_r($data);exit;
        $data['Channel_id'] = $Channel_id;
        $data['tribe_id'] = $Channel['tribe_id'];
        $data['group_id'] = $Channel['huanxin_group_id'];
        
        
        
        $data['head_set'] = 2;
        $data['title'] = $tribe['name'];
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
//         $this->load->view('webim/tirbal_chat', $data);
        $this->load->view('webim/group_chat', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    
    /**
     * 单聊
     */
    public function chat($tribe_id = 0,$customer_id = 0){
        $user_id = $this->session->userdata("user_id");
        //必须要是两个用户都是51易货会员 不能自己跟自己聊天
        if(!$customer_id || !empty($customer_id) && $user_id == $customer_id){
            echo "<script>history.back();</script>";exit;
        }
        //验证接收人
        $to_customer = $this->getUser($customer_id);
        if($to_customer['status'] == 1){
            //接收人不存在
            echo "<script>history.back();</script>";exit;
        }else if($to_customer['status'] == 3){
            error_log($to_customer['msg']);
            echo "<script>history.back();alert('用户信息错误');</script>";exit;
        }
        //当接收人信息确保正确后就可以处理下头像名称的优先级了
        //单纯用户信息  不存在优先级(以下用if else 条件处理 可能比三元运算快)
        $real_name = '';
        $logo = '';
        
        if(empty($to_customer['user_info']['real_name'])){
            if(empty($to_customer['user_info']['nick_name'])){
                $real_name= $to_customer['user_info']['wechat_nickname'];
            }else{
                $real_name = $to_customer['user_info']['nick_name'];
            }
        }else{
              $real_name = $to_customer['user_info']['real_name'];
        }
        
        if(empty($to_customer['user_info']['brief_avatar'])){
            $logo = $to_customer['user_info']['wechat_avatar'];//微信头像不用拼接IMAGE_URL
        }else{
            $logo = IMAGE_URL.$to_customer['user_info']['brief_avatar'];
        }
        $info = array(
            'id'=>$to_customer['user_info']['id'],
            'real_name'=> $real_name,
            'logo'=> $logo,
        );
        $data['to_customer'] = $info;
        
        
        //处理发送人的信息
        $this->load->model('customer_mdl');
        $from_customer = $this->customer_mdl->load($user_id);
        $real_name = '';
        $logo = '';
        
        if(empty($from_customer['real_name'])){
            if(empty($from_customer['nick_name'])){
                $real_name= $from_customer['wechat_nickname'];
            }else{
                $real_name = $from_customer['nick_name'];
            }
        }else{
            $real_name = $from_customer['real_name'];
        }
        
        if(empty($from_customer['brief_avatar'])){
            $logo = $from_customer['wechat_avatar'];//微信头像不用拼接IMAGE_URL
        }else{
            $logo = IMAGE_URL.$from_customer['brief_avatar'];
        }
        $info = array(
            'id'=>$from_customer['id'],
            'real_name'=> $real_name,
            'logo'=> $logo,
        );
        $data['from_customer'] = $info;
        
        if($tribe_id){
            $this->load->model("tribe_mdl");
            $to_customer_staff_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$data['to_customer']['id']);
            
            //当部落ID存在时 则关连部落族员信息  然后对用户信息进行优先级处理(处理 名称)
            if(empty( $data['to_customer']['real_name'])){
                $data['to_customer']['real_name'] = $to_customer_staff_info['member_name'];
            }
            $from_customer_staff_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$data['from_customer']['id']);
            if(empty( $data['from_customer']['real_name'])){
                $data['from_customer']['real_name'] = $to_customer_staff_info['member_name'];
            }
            $data['to_customer']['ts_id'] =   $to_customer_staff_info['id'];
          
        }
        
        $Channel_id = 0;
        //创建聊天室
        $select = "($user_id,$customer_id)";
        $msg = $this->chat->getChatChannel($select);
        $Channel_id = 0;
        if($msg){
            //之前已经创建了聊天室
            $ids = $msg['ids'];
            $ids = explode(",",$ids);
            if(in_array($user_id, $ids) && in_array($customer_id, $ids)){
                $Channel_id = $msg['id'];
            }
           
         }
         if(!$Channel_id){
             $member_id = array(
                 $user_id,
                 $customer_id
             );
             //之前没有创建聊天室
             $Channel_id = $this->chat->createChatChannel($member_id);//创建聊天室
         }
       
        if(!$Channel_id){
            echo '创建聊天室失败';
            exit;
        }
       
        //获取历史记录的前5条
        $condition['chat_channel_id'] = $Channel_id;
        $list = $this->chat->getChatLog($condition,10);
        //把自己的聊天室标记为已读
        $aff = $this->chat->updateList($user_id,$Channel_id);
        
        $data['Msg_list'] = $list;
//         echo  '<pre>';
//         print_r($data);exit;
        $data['Channel_id'] = $Channel_id;
        $data['tribe_id'] = $tribe_id;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        
        $data['title'] =  $data['to_customer']['real_name'];//聊天室的标题  即就接收人的名称
        
       
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('webim/personal_chat', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    
    /**
     * 更新用户聊天列表
     * $chat_channel_id  聊天室ID
     */
    public function updateList($chat_channel_id){
        $customer_id = $this->session->userdata("user_id");
        
        $Channel = $this->chat->loadChannelById($chat_channel_id);
       
        if(!empty($Channel['tribe_id'] && !empty($Channel['huanxin_group_id']))){
            $aff = $this->chat->updateAllReadLog($chat_channel_id,$customer_id);
        }else{
            $aff = $this->chat->updateList($customer_id,$chat_channel_id,1);
        }
        
        // php 判断是否为 ajax 请求  
        if(isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && strtolower($_SERVER["HTTP_X_REQUESTED_WITH"])=="xmlhttprequest"){
            // ajax 请求的处理方式
            if($aff){
                echo true;
            }else{
                echo false;
            }
           
        }else{
            // 正常请求的处理方式
            return $aff;
        };
    }
    
    
    /**
     * 获取token
     */
    public function get_token(){
        $token = $this->session->userdata("webim_token");
        if(!$token){
            $token=$this->h->getToken();
            $this->session->set_userdata("webim_token",$token);
        }
        return $token;
    }
    
    /**
     * 发送文本消息
     */
    public  function sendText($customer_id = 0){
        $group_id = $this->input->post("group_id");//环信群聊ID
        $customer_id = $this->input->post("user");//用户
        $Channel_id = $this->input->post("Channel_id");//聊天室ID
        $content = $this->input->post("content");//内容
        $msg_type = $this->input->post("msg_type");//消息类型
        $tribe_id = $this->input->post("tribe_id");//部落ID
        
        if(!$group_id){
            if(!$customer_id){
                $return['status'] = 0;
                $return['msg'] = '参数错误';
                echo json_encode($return);
                exit;
            }
            $chat_user = $this->getUser($customer_id,1);
             
            if($chat_user['status'] != 5){
                $return['status'] = 0;
                $return['msg'] = $chat_user['msg'];
                echo json_encode($return);
                exit;
            }
        }
        $user_id = $this->session->userdata("user_id");
        
        $insert['from_customer_id'] = $user_id;
        $insert['chat_channel_id'] = $Channel_id;
//         $insert['to_customer_id'] = $customer_id;
       
      
        if($msg_type == 2){
            $insert['message_url'] =  strip_tags($content);
        }else{
            $insert['message'] =  $content;
        }
        $insert['message_type'] = $msg_type;
      
        //保存信息到服务器
        $Msg_id = $this->chat->createChatMessage($insert);
       
//             echo '<pre>';
//             print_r($this->db->last_query());exit;
        
        if($Msg_id){
            if(!$group_id){
            //更新接收用户修改为有未读消息
            $this->chat->updateList($customer_id,$Channel_id,0);
            }
        }
       
        $from=$user_id;
        
        if($group_id){
            //群聊
            $target_type="chatgroups";
            $target=array($group_id);
        }else{
            //单聊
            $target_type="users";
            $target=array($customer_id);
        }
        $content_text = $content;
        $ext['a']="a";
        $ext['b']="b";
        $ext['Channel_id']=$Channel_id;
        $ext['Msg_id']=$Msg_id;
        $ext['tribe_id']=$tribe_id;
        
        $send = $this->h->sendText($from,$target_type,$target,$content_text,$ext);
        if(isset($send['error'])){
            $return['status'] = 3;
            $return['msg'] = $send['error_description'];
        }else{
            $return['status'] = 5;
            $return['msg'] = '发送成功';
            $return['Msg_id'] = $Msg_id;
        }
        echo json_encode($return);
    }
    
    /**
     * 发送图片信息
     */
    public function sendImage(){
        $group_id = $this->input->post("group_id");//环信群聊ID
        $customer_id = $this->input->post("user");//用户
        $Channel_id = $this->input->post("Channel_id");//聊天室ID
        $Img_blob = $this->input->post("blob");//64位图片
        $tribe_id = $this->input->post("tribe_id");//部落ID
        if(!$Img_blob){
            $return['status'] = 3;
            $return['msg'] = '参数错误';
            echo json_encode($return);
            exit;
        }
        
        //上传图片到环信服务器
        $result =  $this->h->uploadFile($Img_blob);
      
        if(isset($result['error'])){
            $return['status'] = 3;
            $return['msg'] = $result['error_description'];
            echo json_encode($return);
            exit;
        }
        
        $uuid = $result['entities'][0]['uuid'];
        $shareSecret = $result['entities'][0]['share-secret'];
        //再下载到51服务器本地
        $year = date("Y",time());
        $month = date("m",time());
        $day = date("d",time());
        // 图片 初始化数据
        $save_path = "chat/$Channel_id/$year/$month/$day/";
        //下载图片
        $file_name = $this->h->downloadFile($uuid,$shareSecret,$save_path);
       
        $user_id = $this->session->userdata("user_id");
        $insert['from_customer_id'] = $user_id;
        $insert['chat_channel_id'] = $Channel_id;
//         $insert['to_customer_id'] = $customer_id;
        $insert['message'] = '';
        $insert['message_type'] = 1;
        $insert['message_url'] = 'uploads/'.$save_path.$file_name;
        //保存信息到服务器
        $Msg_id = $this->chat->createChatMessage($insert);
      
        if($Msg_id){
            //更新接收用户修改为有未读消息
            $this->chat->updateList($customer_id,$Channel_id,0);
        }
        //$result['uri']    https://a1.easemob.com/1141170719115422/tribebox-test/chatfiles
        //$uuid a0a59810-01b7-11e8-a105-517a122075fa
        
        $filePath= $result['uri'].'/'.$uuid; //https://a1.easemob.com/1141170719115422/tribebox-test/chatfiles/a0a59810-01b7-11e8-a105-517a122075fa
        $from= $user_id;
        if($group_id){
            //群聊
            $target_type="chatgroups";
            $target=array($group_id);
        }else{
            //单聊
            $target_type="users";
            $target=array($customer_id);
        }
        $filename= $file_name;
        $ext['a']="a";
        $ext['b']="b";
        $ext['Channel_id']=$Channel_id;
        $ext['Msg_id']=$Msg_id;
        $ext['tribe_id']=$tribe_id;
        $send = $this->h->sendImage($filePath,$from,$target_type,$target,$filename,$ext);
        
        if(isset($send['error'])){
            $return['status'] = 3;
            $return['msg'] = $send['error_description'];
        }else{
            $return['status'] = 5;
            $return['msg'] = '发送成功';
            $return['Msg_id'] = $Msg_id;
        }
        echo json_encode($return);
    }
    
    /**
     * 主要用户后台获取用户数据 及判断用户是否在环信平台注册了
     * @param number $customer_id
     */
    public function getUser($customer_id = 0,$return_type = 0){
        // php 判断是否为 ajax 请求
        $is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if(!$customer_id){
            $return['status'] = 0;
            $return['msg'] = '参数错误';
            if($is_ajax){
                echo json_encode($return);
                exit;
            }else{
                return $return;
            }
            
        }
        $this->load->model('customer_mdl');
        $customer = $this->customer_mdl->load($customer_id);
        if(!$customer){
            $return['status'] = 1;
            $return['msg'] = '该用户尚未注册51易货会员';
            if(!$return_type){
                if($is_ajax){
                    echo json_encode($return);
                    exit;
                }else{
                    return $return;
                }
            }else{
                return $return;
            }
           
        }
        $data = $this->h->getUser($customer_id);
        if(isset($data['error'])){
            //当存在返回error时 先尝试注册 看下是否未注册环信
            $pwd = '51ehwhuanxin';//注册密码统一默认
            $create = $this->h->createUser($customer_id,$pwd);
            if(isset($create['error'])){
                $return['status'] = 3;
                $return['msg'] = '获取用户报错'.$data['error'].'创建用户报错'.$create['error'];
            }else{
                $return['status'] = 5;
                $return['msg'] = '注册聊天室成功';
                $return['user_info'] = $customer;
            }
        }else{
            $return['status'] = 5;
            $return['msg'] = '获取用户成功';
            $return['user_info'] = $customer;
        }
        if(!$return_type){
            if($is_ajax){
                echo json_encode($return);
                exit;
            }else{
                return $return;
            }
        }else{
            return $return;
        }
    }
    
    /**
     * 获取当前用户的未读消息数
     */
    public function getNotReadCount($tribe_id = 0){
       $NotReadCount = 0;
       //部落群聊天未读数
       $Tribe_NotReadCount = $this->chat->getNotReadCount(0,$tribe_id);
//        echo '<pre>';
//        print_r($this->db->last_query());exit;
       //获取当前用户与部落里成员间的单聊聊天室
       $SingleTribeChannel = $this->chat->getTribeSingleChat($tribe_id);
    
       $SingleNotReadCount = 0;
       if($SingleTribeChannel){
           foreach ($SingleTribeChannel as $key => $val){
              $Count = $this->chat->getNotReadCount($val['chat_channel_id']);
              $SingleNotReadCount +=$Count;
           }
       }
     
       $NotReadCount = $Tribe_NotReadCount+$SingleNotReadCount;
       
       if($NotReadCount){
           if($NotReadCount > 99){
               $NotReadCount = '99';
           }
       }
       $return['MsgCount'] = $NotReadCount;
       echo  json_encode($return);
    }
    
    /**
     * 获取单条信息
     */
    public function getSingleChatlog(){
        $Msg_id = $this->input->post("Msg_id");//ID
        $Msg = $this->chat->getSingleChatlog($Msg_id);
        if($Msg){
            if($Msg['real_name']){
                $Msg['user_name'] = $Msg['real_name'];
            }else if($Msg['nick_name']){
                $Msg['user_name'] = $Msg['nick_name'];
            }else{
                $Msg['user_name'] = $Msg['wechat_nickname'];
            }
            if($Msg['brief_avatar']){
                $Msg['user_logo'] = IMAGE_URL.$Msg['brief_avatar'];
            }else{
                $Msg['user_logo'] = $Msg['wechat_avatar'];
            }
            if($Msg['message_type'] == 1 ){
                if($Msg['message_url'] ){
                    $Msg['message_url'] = IMAGE_URL.$Msg['message_url'];
                }
            }
            if($Msg['tribe_id']){
                $Msg['url'] = site_url("Webim/Control/chats/{$Msg['chat_channel_id']}");
            }else{
                $Msg['url'] = site_url("Webim/Control/chat/{$Msg['chat_channel_id']}/{$Msg['from_customer_id']}");
            }
            
        }
        echo json_encode($Msg);
    }
    
    public function getChatlog(){
        $Channel_id = $this->input->post("Channel_id");//聊天室ID
        $hist_ids = $this->input->post("hist_ids");//默认查出来的历史记录ID
        if(!$Channel_id){
            $return['status'] = 3;
            $return['msg'] = '参数错误';
            echo json_encode($return);exit;
        }
        $condition['hist_ids'] = $hist_ids;
        $condition['chat_channel_id'] = $Channel_id;
        $limit = 20;//每页显示的数量
        $page = $this->input->post("page");//页数
        if(0 == $page)
        {
            $page = 1;
        }
        $offset = ($page-1)*$limit;//偏移量
        
        $list = $this->chat->getChatLog($condition,$limit,$offset);
        if($list){
            $this->load->model('customer_mdl');
            $user_id = $this->session->userdata("user_id");
            foreach ($list as $key =>$val){
                 if($val['from_customer_id'] == $user_id){
                    continue;
                }
                $to_customer =   $this->customer_mdl->load($val['from_customer_id']);
                $real_name = '';
                $logo = '';
                if(empty($to_customer['real_name'])){
                    if(empty($to_customer['nick_name'])){
                        $real_name= $to_customer['wechat_nickname'];
                    }else{
                        $real_name = $to_customer['nick_name'];
                    }
                }else{
                    $real_name = $to_customer['real_name'];
                }
                
                if(empty($to_customer['brief_avatar'])){
                    $logo = $to_customer['wechat_avatar'];//微信头像不用拼接IMAGE_URL
                }else{
                    $logo = IMAGE_URL.$to_customer['brief_avatar'];
                }
                $Send_info = array(
                    'real_name'=> $real_name,
                    'logo'=> $logo,
                );
                $list[$key]['Send_info'] = $Send_info;
            }
        }
       
       
        $return['status'] = 5;
        $return['list'] = $list;
        echo  json_encode($return);
    }
    
    //-------------------似乎下面的方法对外用不到-----------开始--------------------------
    /**
     * 创建聊天用户
     */
    public function createUser($customer_id = 0){
        if(!$customer_id){
            $return['status'] = 0;
            $return['msg'] = '参数错误';
            echo json_encode($return);
            exit;
        }
        
        $this->load->model('customer_mdl');
        $customer = $this->customer_mdl->load($customer_id);
        if(!$customer){
            $return['status'] = 1;
            $return['msg'] = '该用户尚未注册51易货会员';
            echo json_encode($return);
            exit;
        }
        $pwd = '51ehwhuanxin';//注册密码统一默认   
        $data = $this->h->createUser($customer_id,$pwd);
        if(isset($data['error'])){
            $return['status'] = 3;
            $return['msg'] = $data['error'];
        }else{
            $return['status'] = 5;
            $return['msg'] = '注册聊天室成功';
        }
        echo json_encode($return);
        
        //以下是正确的注册成功返回数据  当存在error参数即创建失败
//         $data = Array(
//             'action' => 'post',
//             'application' => '6d944710-6d1e-11e7-b22e-81a0fd2f127e',
//             'path' => '/users',
//             'uri' => 'https://a1.easemob.com/1141170719115422/tribebox-test/users',
//             'entities' => Array(
//                Array
//                 (
//                     'uuid' => '2906a5d0-fa62-11e7-9ed5-cbbbabb9f62b',
//                     'type'=> 'user',
//                     'created' => '1516068516013',
//                     'modified' => '1516068516013',
//                     'username' => 'lisis4',
//                     'activated' => '1'
//                     )
//                 ),
//             'timestamp' => '1516068516115',
//             'duration' => '0',
//             'organization' => '1141170719115422',
//             'applicationName' => 'tribebox-test'
//             );
        
    }
    
    //-------------------似乎上面的方法对外用不到-----------结束--------------------------
}
/**
 * 以下是环信平台对外提供的接口
 * 
$i=35;
switch($i){
	case 10://获取token
	    $token = $this->session->userdata("webim_token");
	    if(!$token){
	        $token=$h->getToken();
	        $this->session->set_userdata("webim_token",$token);
	    }
// 		var_dump($token);
		break;
	case 11://创建单个用户
	    $h->createUser("lisi","123456");
// 		var_dump($h->createUser("zhangsan","123456"));
		break;
	case 12://创建批量用户
		var_dump($h->createUsers(array(
			array(
				"username"=>"zhangsan",
				"password"=>"123456"
			),
			array(
				"username"=>"lisi",
				"password"=>"123456"
			)
		)));
		break;
	case 13://重置用户密码
		var_dump($h->resetPassword("zhangsan","123456"));
		break;
	case 14://获取单个用户
		var_dump($h->getUser("zhangsan"));
		break;
	case 15://获取批量用户---不分页(默认返回10个)
		var_dump($h->getUsers());
		break;
	case 16://获取批量用户----分页
		$cursor=$h->readCursor("userfile.txt");
		var_dump($h->getUsersForPage(10,$cursor));
		break;
	case 17://删除单个用户
	    echo '<pre>';
	    print_r($h->deleteUser("3433"));exit;
		var_dump($h->deleteUser("zhangsan"));
		break;
	case 18://删除批量用户
		var_dump($h->deleteUsers(2));
		break;
	case 19://修改昵称
		var_dump($h->editNickname("zhangsan","小B"));
		break;
	case 20://添加好友------400
		var_dump($h->addFriend("zhangsan","lisi"));
		break;
	case 21://删除好友
		var_dump($h->deleteFriend("zhangsan","lisi"));
		break;
	case 22://查看好友
		var_dump($h->showFriends("zhangsan"));
		break;
	case 23://查看黑名单
		var_dump($h->getBlacklist("zhangsan"));
		break;
	case 24://往黑名单中加人
		$usernames=array(
			"usernames"=>array("wangwu","lisi")
		);
		var_dump($h->addUserForBlacklist("zhangsan",$usernames));
		break;
	case 25://从黑名单中减人
		var_dump($h->deleteUserFromBlacklist("zhangsan","lisi"));
		break;
	case 26://查看用户是否在线
		var_dump($h->isOnline("zhangsan"));
		break;
	case 27://查看用户离线消息数
		var_dump($h->getOfflineMessages("zhangsan"));
		break;
	case 28://查看某条消息的离线状态
		var_dump($h->getOfflineMessageStatus("zhangsan","77225969013752296_pd7J8-20-c3104"));
		break;
	case 29://禁用用户账号----
		var_dump($h->deactiveUser("zhangsan"));
		break;
	case 30://解禁用户账号-----
		var_dump($h->activeUser("zhangsan"));
		break;
	case 31://强制用户下线
		var_dump($h->disconnectUser("zhangsan"));
		break;
	case 32://上传图片或文件
		var_dump($h->uploadFile("./resource/up/pujing.jpg"));
		//var_dump($h->uploadFile("./resource/up/mangai.mp3"));
		//var_dump($h->uploadFile("./resource/up/sunny.mp4"));
		break;
	case 33://下载图片或文件
		var_dump($h->downloadFile('01adb440-7be0-11e5-8b3f-e7e11cda33bb','Aa20SnvgEeWul_Mq8KN-Ck-613IMXvJN8i6U9kBKzYo13RL5'));
		break;
	case 34://下载图片缩略图
		var_dump($h->downloadThumbnail('01adb440-7be0-11e5-8b3f-e7e11cda33bb','Aa20SnvgEeWul_Mq8KN-Ck-613IMXvJN8i6U9kBKzYo13RL5'));
		break;
	case 35://发送文本消息
		$from='admin';
		$target_type="users";
		//$target_type="chatgroups";
		$target=array("zhangsan");//,"lisi","wangwu"
		//$target=array("122633509780062768");
		$content="Hello HuanXin!";
		$ext['a']="a";
		$ext['b']="b";
		var_dump($h->sendText($from,$target_type,$target,$content,$ext));
		break;
	case 36://发送透传消息
		$from='admin';
		$target_type="users";
		//$target_type="chatgroups";
		$target=array("zhangsan","lisi","wangwu");
		//$target=array("122633509780062768");
		$action="Hello HuanXin!";
		$ext['a']="a";
		$ext['b']="b";
		var_dump($h->sendCmd($from,$target_type,$target,$action,$ext));
		break;
	case 37://发送图片消息
		$filePath="./resource/up/pujing.jpg";
		$from='admin';
		$target_type="users";
		$target=array("zhangsan","lisi");
		$filename="pujing.jpg";
		$ext['a']="a";
		$ext['b']="b";
		var_dump($h->sendImage($filePath,$from,$target_type,$target,$filename,$ext));
		break;
	case 38://发送语音消息
		$filePath="./resource/up/mangai.mp3";
		$from='admin';
		$target_type="users";
		$target=array("zhangsan","lisi");
		$filename="mangai.mp3";
		$length=10;
		$ext['a']="a";
		$ext['b']="b";
		var_dump($h->sendAudio($filePath,$from="admin",$target_type,$target,$filename,$length,$ext));
		break;
	case 39://发送视频消息
		$filePath="./resource/up/sunny.mp4";
		$from='admin';
		$target_type="users";
		$target=array("zhangsan","lisi");
		$filename="sunny.mp4";
		$length=10;//时长
		$thumb='https://a1.easemob.com/easemob-demo/chatdemoui/chatfiles/c06588c0-7df4-11e5-932c-9f90699e6d72';
		$thumb_secret='wGWIyn30EeW9AD1fA7wz23zI8-dl3PJI0yKyI3Iqk08NBqCJ';
		$ext['a']="a";
		$ext['b']="b";
		var_dump($h->sendVedio($filePath,$from="admin",$target_type,$target,$filename,$length,$thumb,$thumb_secret,$ext));
		break;
	case 40://发文件消息
	
		break;
	case 41://获取app中的所有群组-----不分页（默认返回10个）
		var_dump($h->getGroups());
		break;
	case 42:////获取app中的所有群组--------分页
		$cursor=$h->readCursor("groupfile.txt");
		var_dump($h->getGroupsForPage(2,$cursor));
		break;
	case 43://获取一个或多个群组的详情
		$group_ids=array("1445830526109","1445833238210");
		var_dump($h->getGroupDetail($group_ids));
		break;
	case 44://创建一个群组
		$options ['groupname'] = "group001";
		$options ['desc'] = "this is a love group";
		$options ['public'] = true;
		$options ['owner'] = "zhangsan";
		$options['members']=Array("fengpei","lisi");
		var_dump($h->createGroup($options));
		break;
	case 45://修改群组信息
		$group_id="124113058216804760";
		$options['groupname']="group002";
		$options['description']="修改群描述";
		$options['maxusers']=300;
		var_dump($h->modifyGroupInfo($group_id,$options));
		break;
	case 46://删除群组
		$group_id="124113058216804760";
		var_dump($h->deleteGroup($group_id));
		break;
	case 47://获取群组中的成员
		$group_id="122633509780062768";
		var_dump($h->getGroupUsers($group_id));
		break;
	case 48://群组单个加人------
		$group_id="122633509780062768";
		$username="lisi";
		var_dump($h->addGroupMember($group_id,$username));
		break;
	case 49://群组批量加人
		$group_id="122633509780062768";
		$usernames['usernames']=array("wangwu","lisi");
		var_dump($h->addGroupMembers($group_id,$usernames));
		break;
	case 50://群组单个减人
		$group_id="122633509780062768";
		$username="test";
		var_dump($h->deleteGroupMember($group_id,$username));	
		break;
	case 51://群组批量减人-----
		$group_id="122633509780062768";
		//$usernames['usernames']=array("wangwu","lisi");
		$usernames='wangwu,lisi';
		var_dump($h->deleteGroupMembers($group_id,$usernames));	
		break;
	case 52://获取一个用户参与的所有群组
		var_dump($h->getGroupsForUser("zhangsan"));
		break;
	case 53://群组转让
		$group_id="122633509780062768";
		$options['newowner']="lisi";
		var_dump($h->changeGroupOwner($group_id,$options));
		break;
	case 54://查询一个群组黑名单用户名列表
		$group_id="122633509780062768";
		var_dump($h->getGroupBlackList($group_id));
		break;
	case 55://群组黑名单单个加人-----
		$group_id="122633509780062768";
		$username="lisi";
		var_dump($h->addGroupBlackMember($group_id,$username));		
		break;
	case 56://群组黑名单批量加人
		$group_id="122633509780062768";
		$usernames['usernames']=array("lisi","wangwu");
		var_dump($h->addGroupBlackMembers($group_id,$usernames));		
		break;
	case 57://群组黑名单单个减人
		$group_id="122633509780062768";
		$username="lisi";
		var_dump($h->deleteGroupBlackMember($group_id,$username));		
		break;
	case 58://群组黑名单批量减人
		$group_id="122633509780062768";
		$usernames['usernames']=array("wangwu","lisi");
		var_dump($h->deleteGroupBlackMembers($group_id,$usernames));		
		break;
	case 59://创建聊天室
		$options ['name'] = "chatroom001";
		$options ['description'] = "this is a love chatroom";
		$options ['maxusers'] = 300;
		$options ['owner'] = "zhangsan";
		$options['members']=Array("man","lisi");
		var_dump($h->createChatRoom($options));	
		break;
	case 60://修改聊天室信息
		$chatroom_id="124121390293975664";
		$options['name']="chatroom002";
		$options['description']="修改聊天室描述";
		$options['maxusers']=300;
		var_dump($h->modifyChatRoom($chatroom_id,$options));
		break;
	case 61://删除聊天室
		$chatroom_id="124121390293975664";
		var_dump($h->deleteChatRoom($chatroom_id));
		break;
	case 62://获取app中所有的聊天室
		var_dump($h->getChatRooms());
		break;
	case 63://获取一个聊天室的详情
		$chatroom_id="124121939693277716";
		var_dump($h->getChatRoomDetail($chatroom_id));
		break;
	case 64://获取一个用户加入的所有聊天室
		var_dump($h->getChatRoomJoined("zhangsan"));
		break;
	case 65://聊天室单个成员添加--
		$chatroom_id="124121939693277716";
		$username="zhangsan";
		var_dump($h->addChatRoomMember($chatroom_id,$username));
		break;
	case 66://聊天室批量成员添加
		$chatroom_id="124121939693277716";
		$usernames['usernames']=array('wangwu','lisi');
		var_dump($h->addChatRoomMembers($chatroom_id,$usernames));
		break;
	case 67://聊天室单个成员删除
		$chatroom_id="124121939693277716";
		$username="zhangsan";
		var_dump($h->deleteChatRoomMember($chatroom_id,$username));
		break;
	case 68://聊天室批量成员删除
		$chatroom_id="124121939693277716";
		//$usernames['usernames']=array('zhangsan','lisi');
		$usernames='zhangsan,lisi';
		var_dump($h->deleteChatRoomMembers($chatroom_id,$usernames));
		break;
	case 69://导出聊天记录-------不分页
		$ql="select+*+where+timestamp>1435536480000";
		var_dump($h->getChatRecord($ql));
		break;
	case 70://导出聊天记录-------分页
		$ql="select+*+where+timestamp>1435536480000";
		$cursor=$h->readCursor("chatfile.txt");
		//var_dump($h->$cursor);
		var_dump($h->getChatRecordForPage($ql,10,$cursor));
		break;
}
**/
?>