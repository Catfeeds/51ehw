<?php
/**
 * 内容控制器
 */
class Tribe extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('ref_from_url', current_url());
        //判断登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $mac_type = $this->input->get_post("mac_type");
        if(isset($mac_type) && $mac_type == 'APP'){
            $this->session->set_userdata("mac_type",$mac_type);
        }
        $this->load->model("tribe_mdl");
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
    
    
    
    // --------------------------------------------------------------------
    
    /**
     * 部落首页
     */
    function index()
    {
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type == 'APP'){
            $data['mac_type'] = $mac_type;
        }else{
            $data['mac_type'] = '';
        }
        
        $this->load->helper('format_time');
        $customer_id = $this->session->userdata("user_id");//用户id
        
        //查询通知
        $sift['where']['customer_id'] = $customer_id;
        $this->load->model('Customer_message_mdl');
        $not_read = $this->Customer_message_mdl->Count_Num( $sift )['not_read'];
        
        //查询新的部落消息通知
        $new_message = $this->tribe_mdl->Load_Tribe_Message( $customer_id );
        
        if( $new_message &&  $new_message['template_id'] == 10 )
        {
            $new_message['message'] =  str_replace( array('<!--','-->'),array('',''), $new_message['message'] );
        }
        
        //我的部落
        $data["mytribe"] = $this->tribe_mdl->MyTribe($customer_id,1);
        
        
        //部落公告
        $this->load->model('Tribe_content_mdl');
        $announcement_sift['where']['customer_id'] = $customer_id;
        $announcement_sift['sql_status'] = 'result_array';
        $data['announcement_list'] = $this->Tribe_content_mdl->Load_new_content( $announcement_sift );
        
        
        //全平台+已经入的部落的最新一条活动记录
        $this->load->model('Tribe_activity_mdl');
        
        $sift['where']['type'] = 0;
        $data['activities'] = $this->Tribe_activity_mdl->Load_new_activity( $sift );
        
        //全平台+已经入的部落的最新一条公告
        $data['new_announcement'] = !empty( $data['announcement_list'][0] ) ? $data['announcement_list'][0] : array();
        
        
        //我加入的部落中的最新一条圈子动态
        if( !empty( $data['mytribe'] ) )
        {
            $sift['where']['tribe_id'] = array_column($data["mytribe"], 'id');
            $sift['where']['customer_id'] = $customer_id;
            $sift['return_row'] = true;
            $this->load->model('Tribe_topic_mdl');
            $data['topic_detaile'] = $this->Tribe_topic_mdl->Load( $sift,true );
            
            if( $data['topic_detaile'] )
            {
                $data['topic_detaile']['upvote_info']  =  $this->Tribe_topic_mdl->topic_upvote_member_name($data['topic_detaile']['id']);
            }
        }
        
        //查询判断是否部落管理者
        $flag = true;
        if(ISMOBILE == "pc"){//如果是pc端，则判断是否拥有（族员管理，部落资料，商品管理）权限的部落
            $module_id = array(2,3,6);
        }else{
            $module_id = array(1,2,3,4,5);
        }
        $tribe = $this->tribe_mdl->ManagementTribe($customer_id,0,0,$module_id);
        if(!$tribe){
            $flag = false;
        }
        
        $mobile = $this->session->userdata('mobile');
        $tribe_id_lists = array();
        if(isset($mobile)){
            // 按手机号码查询部落id
            $tribe_id_list = $this->tribe_mdl->load_tribe_by_mobile($mobile);
            
            foreach($tribe_id_list as $val){
                $tribe_id_lists[] = $val['tribe_id'];
            }
            if(isset($tribe_id_lists) && $tribe_id_lists != ''){
                $tribe_id_lists = implode(',', $tribe_id_lists);
                if($tribe_id_lists){
                    $tribe_staff_list = $this->tribe_mdl->load_tribe_staff_list($tribe_id_lists);
                    $data['tribe_staff_list'] = $tribe_staff_list;
                }
            }
            
        }
        
        if(empty($tribe_staff_list)){
            $data['is_exits'] = 'not_exits';
        }else{
            $data['is_exits'] = 'exits';
        }
        
        // // 查询弹出次数
        $tips = $this->tribe_mdl->load_tribe_tips($mobile);
        
        $data['tips'] = $tips;
        if(isset($tips)){
            $pop_num = $tips['tip_num'];
            $data['pop_num'] = $pop_num;
        }
        
        // 确认刷新
        $data['aff'] = $this->input->get_post('aff');
        
        
        //获取用户未审核部落的数量
        $data['count_unaudited_tribe'] = $this->tribe_mdl->count_unaudited_tribe($customer_id);
        $data["flag"] = $flag;
        
        $NotReadNum = $this->getChatNotReadNum();
        
        $data['not_read_message'] = $not_read+ $NotReadNum;//未读消息条数
        
        $data['new_message'] = $new_message;
        
        $data['title'] = "部落首页";
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/index.php', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
        
        
    }
    
    public function  getChatNotReadNum(){
        $user_id = $this->session->userdata("user_id");
        //获取用户加入的所有部落
        $this->load->model('Tribe_mdl');
        $Tribes = $this->Tribe_mdl->MyTribe($user_id);
        //聊天信息
        $this->load->model('Chat_message_mdl','chat');
        
        //通过部落ID查询群聊聊天室ID
        $chat_channel_ids = array();
        if($Tribes){
            $TribeIds = array();
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
                                "chat_channel_id"=>$v1['chat_channel_id']
                            );
                            $channel_list[] = $single;
                            $chat_channel_ids[] = $v1['chat_channel_id'];
                        }
                    }
                }
            }
            
            $TribeChatLists = $this->chat->getTribeChatLists($TribeIds);
            if($TribeChatLists){
                foreach ($TribeChatLists as $k=>$v ){
                    if(!in_array($v['id'],$chat_channel_ids )){
                        $chat_channel_ids[] = $v['id'];
                    }
                    
                }
            }
        }
        if(!$chat_channel_ids){
            $chat_channel_ids[] = '0';
        }
        $NotReadNum = $this->chat->getAllNotReadCount($chat_channel_ids);
        return  $NotReadNum;
    }
    
    
    /**
     * 异步加载我的部落
     *
     */
    // function ajax_mytribe()
    // {
    
    //     $customer_id = $this->session->userdata("user_id");//用户id
    
    //     //我的部落
    //     $mytribe = $this->tribe_mdl->MyTribe($customer_id,1);
    
    //     if($mytribe){
    //         $return = ['status' => 1, 'message'=>'success', 'data'=>$mytribe];
    //     }else{
    //         $return = ['status' => 1, 'message'=>'暂无部落'];
    //     }
    
    //     echo json_encode($return);
    // }
    
    /**
     * @author JF
     * 2017年12月26日
     * 管理部落列表
     * $customer_id 用户ID
     * $tribe_id   部落ID
     * $label_id  商会ID
     */
    function ManagementTribe($label_id = 0){
        $return = array(
            'status' => "01",
            'message'=>'fail'
        );
        
        $customer_id = $this->session->userdata("user_id");//用户id
        $tribe_id = 0;
        if($label_id){
            $tribe_id = $this->get_app_tribe_ids($label_id);
        }
        
        if(ISMOBILE == "pc"){//如果是pc端，则判断是否拥有（族员管理，部落资料，商品管理）权限的部落
            $module_id = array(2,3,6);
        }else{
            $module_id = array(1,2,3,4,5);
        }
        $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id,0,$module_id );//查询管理的部落
        
        $this->session->set_userdata("tribe_manager",!empty($tribe));//更新权限session
        $tribe_list = [];
        $this->load->helper("ps");
        
        // php 判断是否为 ajax 请求
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])&&strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest'){
            
            if($tribe){
                $return = array(
                    'status' => "00",
                    'message'=>'success'
                );
                $return["list"] = $tribe;
            }
            echo json_encode($return);exit;
        }else{
            // 正常请求的处理方式
            if(!$tribe){
                redirect("tribe/add_view");
            }
            $passtribe = array();//已通过的部落
            $audittribe = array();//暂不通过的部落
            foreach($tribe as $v){
                if($v["status"] == 2){
                    $passtribe[] = $v;
                }else{
                    $audittribe[] = $v;
                }
            }
            $tribe_apply = $this->tribe_mdl->ManagementTribe_apply($customer_id);//根据用户id查询拥有族员管理权限的部落
            if($tribe_apply){
                $tribe_apply_id = array_column($tribe_apply,'id','id');
                $ids = array_column($passtribe,'id');
                $num = $this->tribe_mdl->count_unaudited_tribe_list_num($ids);
                $arr = array_column($num,"total",'tribe_id');
                foreach ($passtribe as $k => $v) {
                    $exist = array_key_exists($v['id'],$arr);
                    if($exist) {
                        $exist = array_key_exists($v['id'],$tribe_apply_id);
                    }
                    $passtribe[$k]['total'] = $exist ? $arr[$v['id']]: '';
                }
            }
            $data["passtribe"] = $passtribe;
            $data["audittribe"] = $audittribe;
            $data['title'] = "部落管理";
            $data ['head_set'] = 2;
            $data ['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('tribe/tribe_manage_lists', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        }
        
        
    }
    
    //--------置顶部落----------------
    /**
     * 置顶部落
     */
    public function  sort_tribe(){
        $tribe_id = $this->input->get_post("id");
        $customer_id = $this->session->userdata("user_id");//用户id
        $sort_info = $this->tribe_mdl->load_tribe_sort($customer_id,$tribe_id);
        
        if(!$sort_info){//没有则添加
            $this->tribe_mdl->add_tribe_sort($customer_id,$tribe_id);
            //1;//置顶
            $row = $this->tribe_mdl->sort_tribe(1,$customer_id,$tribe_id);
            if($row){
                $return = array(
                    'status' => true,
                    'message'=>'置顶成功'
                );
            }else{
                $return = array(
                    'status' => false,
                    'message'=>'置顶失败'
                );
            }
            echo json_encode($return);exit;
        }
        
        if($sort_info['sort'] == 0){
            $sort = 1;//置顶
            $return = array(
                'status' => false,
                'message'=>'置顶失败'
            );
        }else{
            $sort = 0;//取消置顶
            $return = array(
                'status' => false,
                'message'=>'取消置顶失败'
            );
        }
        $row = $this->tribe_mdl->sort_tribe($sort,$customer_id,$tribe_id);
        
        if($row){
            if($sort){
                $return = array(
                    'status' => true,
                    'message'=>'置顶成功'
                );
            }else{
                $return = array(
                    'status' => true,
                    'message'=>'取消置顶成功'
                );
            }
        }
        echo json_encode($return);
    }
    
    // --------------------------------------------------------------------
    //       /**
    //      * 部落列表
    //      */
    //     function lists(){
    //         //验证部落权限
    //         $this->load->helper("ps");
    //         if(!CheckTribePower("/Tribe/Modifydata")){
    //             echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
    //         }
    //         $tribe_id = $this->session->userdata("tribe_id");
    //         $customer_id = $this->session->userdata("user_id");//用户id
    //         if(!$tribe_id){
    //             redirect('Home');exit;
    //         }
    //         $times = $this->input->get_post("times");
    //         $status = $this->input->get_post("status");
    //         $keyword = $this->input->get('search_name');
    
    //         if($status){
    //             switch ($status){
    //                 case '未审核':
    //                     $status_type = 1;
    //                     break;
    //                 case '已审核':
    //                     $status_type = 2;
    //                     break;
    //                 case '全部':
    //                     $status_type = '';
    //                     break;
    //                 default:
    //                     $status_type = '';
    //                     $status = '';
    //                     break;
    //             }
    //         }else{
    //             $status_type = '';
    //         }
    //         if($times){
    //             $date = date('Y-m-d ');// 当前时间
    //             switch ($times){
    //                 case '显示全部':
    //                     $times_type = '';
    //                     break;
    //                 case '近7天内':
    //                     $limit_date = date('Y-m-d ', strtotime("-7 days"));// 筛除时间段：7天
    //                     $times_type = "where a.created_at >= '$limit_date' and a.created_at <= '$date'";
    //                     break;
    //                 case '近一个月内':
    //                     $limit_date = date('Y-m-d ', strtotime("-30 days"));// 筛除时间段：30天
    //                     $times_type = "where a.created_at >= '$limit_date' and a.created_at <= '$date'";
    //                     break;
    //                 case '3个月内':
    //                     $limit_date = date('Y-m-d ', strtotime("-90 days"));// 筛除时间段：90天
    //                     $times_type = "where a.created_at >= '$limit_date' and a.created_at <= '$date'";
    //                     break;
    //                 case '半年内':
    //                     $limit_date = date('Y-m-d ', strtotime("-182 days"));// 筛除时间段：半年
    //                     $times_type = "where a.created_at >= '$limit_date' and a.created_at <= '$date'";
    //                     break;
    //                 case '1年内':
    //                     $limit_date = date('Y-m-d ', strtotime("-365 days"));// 筛除时间段：一年
    //                     $times_type = "where a.created_at >= '$limit_date' and a.created_at <= '$date'";
    //                     break;
    //                 default:
    //                     $times_type = '';
    //                     $times = '';
    //                     break;
    //             }
    //         }else{
    //             $times_type = '';
    //         }
    
    //         $data['search'] = $keyword;
    //         $data['times'] = $times;
    //         $data['status'] = $status;
    //         //验证是否义工委
    //         $curr_page = $this->input->get_post("per_page");
    //         if(!$curr_page || $curr_page == 0){
    //             $curr_page = 1;
    //         }
    //         $pagesize = 15;
    
    
    
    //         // 分页设置
    //         $this->load->library('pagination');
    //         $config['base_url'] = site_url('tribe/lists/?');
    //         $config['total_rows'] = count($this->tribe_mdl->Tribe_list($keyword,$times_type,$status_type));
    //         $config['curr_page'] = $curr_page;
    //         $config['per_page'] = $pagesize;
    //         $config['curr_page'] = $curr_page;
    //         $config['use_page_numbers'] = TRUE;
    //         $config['page_query_string'] = TRUE;
    //         $config['num_links'] = 10;
    //         $config['first_link'] = FALSE;
    //         $config['last_link'] = FALSE;
    //         $config['next_link'] = '下一页';
    //         $config['next_tag_css'] = 'class="lPage"';
    //         $config['prev_link'] = '上一页';
    //         $config['prev_tag_css'] = 'class="lPage"';
    //         $config['cur_tag_open'] = '&nbsp;<a href="javascript:" class="cpage">';
    //         $config['cur_tag_close'] = '</a>';
    //         $this->pagination->initialize($config);
    //         $data['pagination'] = $this->pagination->create_links();
    
    //         $list = $this->tribe_mdl->Tribe_list($keyword,$times_type,$status_type,$pagesize,($curr_page - 1) * $pagesize,'list');
    
    //         // 查询所有管理员角色
    //         $info = $this->tribe_mdl->load_tribe_manager_by_id($tribe_id);
    
    //         $role = $this->tribe_mdl->load_tribe_manager_by_id($tribe_id,'role');
    //         $role_id = array_column($role, 'id');
    //         // var_dump(array_column($role, 'id'));
    
    //         $result = [];  //初始化一个数组
    
    //         foreach($info as $k=>$v){
    
    //             $result[$v['tribe_manager_id']][]    =   $v;  // 进行数组重新赋值
    
    //         }
    
    //         // 没有管理员的角色
    //         $manager_list = $this->tribe_mdl->load_all_manager_role($role_id);
    //         $manager_id = [];
    //         foreach($manager_list as $v){
    //             $manager_id[] = $v['id'];
    //         }
    //         // $manager_id = array_flip($manager_id);
    //         // $result = $result + $manager_id;
    //         // var_dump($result);
    //         //$result 就是分组之后的返回值
    
    
    //         // var_dump($manager_id);
    
    //          $manager_role = $this->tribe_mdl->load_all_manager_role();
    //          $m_role = [];
    //          foreach($manager_role as $key=>$val){
    
    //              $m_role[$val['id']] = $val['name'];
    //          }
    //        // var_dump($result);
    //         $data['info'] = $result;
    
    
    //         $data['m_role'] = $m_role;
    
    //         // 获取待添加的管理员
    //         $member_lists = $this->tribe_mdl->load_staff_by_id($tribe_id);
    
    //         // 获取管理员
    //         $nor_manager = $this->tribe_mdl->load_staff_by_id($tribe_id,1);
    
    
    //         // print_r($nor_manager);
    //         // 获取正式族员
    //         $nor_manager_num = $this->tribe_mdl->query_nor_tribe_members($tribe_id);
    //         $data['nor_manager_num'] =  count($nor_manager_num);
    //         $sub_nor_manager = [];
    
    //         // 获取非正式族员
    //         $not_tribe_member = $this->tribe_mdl->query_nor_tribe_members($tribe_id,'not');
    
    //         $data['not_tribe_member_num'] = count($not_tribe_member);
    //         // 拼装key/value数组
    //         $sub_nor_manager_lable = [];
    //         foreach($nor_manager as $key => $val){
    
    //             if($val['customer_id'] && !$val['is_host']){
    //                 if($val['real_name']){
    //                     // $sub_nor_manager[] = $val['real_name'];
    //                     $sub_nor_manager_lable[$val['id']] = $val['real_name'];
    //                 }else{
    //                     // $sub_nor_manager[] = $val['member_name'];
    //                     $sub_nor_manager_lable[$val['id']] = $val['member_name'];
    //                 }
    
    //             }
    
    //         }
    
    //         $this->load->model('Region_mdl');
    
    //         $region  = $this->Region_mdl->provinces();//获取省
    
    //         // 获取城市
    //         if(isset($list[0]['provice'])){
    //             $provice_info = $this->Region_mdl->get_info_ByName($list[0]['provice']);
    //             $city_info =  $this->Region_mdl->children_of($provice_info['region_id']);
    //             $data['city_info'] = $city_info;
    //         }
    
    
    //         $manager_lable = array();
    //         // 拼装key/value数组
    //         $manager_lable_array = [];
    //         foreach($member_lists as $key => $val){
    
    //             if($val['customer_id'] && !$val['is_host']){
    //                 if($val['real_name']){
    //                     // $manager_lable[] = $val['real_name'];
    //                     $manager_lable_array[$val['id']] = $val['real_name'];
    //                 }else{
    //                     // $manager_lable[] = $val['member_name'];
    //                     $manager_lable_array[$val['id']] = $val['member_name'];
    //                 }
    
    //             }
    
    //         }
    
    
    //         //获取该部落的管理者名单
    //         $id = $this->session->userdata('tribe_id');
    //          $role_list = $this->tribe_mdl->get_role();
    //          if( count($role_list)>0 ){
    //              $role_arr=array_column($role_list,"name","id");
    //              $role_id_arr=array_column($role_list,"id");
    //              $role_admin_arr=array();
    //              $all_old_id=array();
    
    //              for ($i=0;$i<count($role_id_arr);$i++){
    //                  $role_id=$role_id_arr[$i];
    //                  $role_admin_arr[$role_id]['name']=$role_arr[$role_id];
    //                  $tribe_staff_r = $this->tribe_mdl->get_staff_by_role($id,$role_id);
    
    //                  if( $tribe_staff_r ){
    //                      $role_admin_arr[$role_id]['count']=count($tribe_staff_r);
    //                      $str="";
    //                      $tem_arr=array();
    //                      foreach( $tribe_staff_r as $key=>$value ){
    //                          $arr=array();
    //                          $arr['id']=$value['id'];
    //                          if( !empty($value['real_name']) ){
    //                              $arr['text']=$value['real_name'];
    //                          }else{
    //                              $arr['text']=$value['member_name'];
    //                          }
    //                          $tem_arr[]=$arr;
    //                      }
    //                       $role_admin_arr[$role_id]['str']=$tem_arr;
    
    //                      $old_id_arr=array_column($tribe_staff_r,"id");
    //                      if( $old_id_arr ){
    //                          $role_admin_arr[$role_id]['old_id']=implode(",",$old_id_arr);
    //                          $all_old_id[$role_id]=$old_id_arr;
    //                      }else{
    //                          $role_admin_arr[$role_id]['old_id']="";
    //                          $all_old_id[$role_id]=array();
    //                      }
    //                  }
    //                  if( $all_old_id ){
    //                      $new_arr=array();
    //                      foreach($all_old_id as $key=>$value){
    //                          $new_arr=array_merge($new_arr,$value);
    //                      }
    
    //                  }
    //              }
    
    //              if( $new_arr ){
    //              $new_arr = implode(',',$new_arr);
    //                 // var_dump($new_arr);
    //              }
    //          }
    
    //         //  // var_dump($new_arr);
    //         //  // return $role_admin_arr;
    //         //   // $this->assign("role_admin_arr",$role_admin_arr);
    //          // echo '<pre>';
    //          // print_r($role_admin_arr);
    //          // echo '</pre>';
    
    //         $data['role_admin_arr'] = $role_admin_arr;
    //         // echo '<pre>';
    //         // print_r($role_admin_arr);
    //         // echo '</pre>';
    //         $master = $this->tribe_mdl->TribeMaster($tribe_id);
    //         $data["is_host"] = ($master["customer_id"]==$customer_id);
    //         //部落折扣
    //         $this->load->model("Config_mdl");
    //         $discount = $this->Config_mdl->get_config("discount");
    
    //         $data['manager_lable'] = $manager_lable_array;
    //         $data['region'] = $region;
    //         $data['sub_nor_manager_lable'] = $sub_nor_manager_lable;
    //         $data["discount"] = $discount['value'];
    //         // var_dump($list);
    //         if(isset($list)){
    //             $data["List"] = $list[0];
    //         }
    
    //         // var_dump( $list);
    //         $data["totalcount"] = $config["total_rows"];
    //         $data["totalpage"] = ceil($config["total_rows"] / $pagesize);
    //         $data['pagesize'] = $pagesize;
    //         $data['page'] = $curr_page;
    
    //         $data['head_set'] = 3;
    //         $data['foot_set'] = 1;
    //         $data['title'] = '部落列表';
    //         $data['nav_type'] = 'lists';
    //         $this->load->view('head', $data);
    //         $this->load->view('_header', $data);
    //         $this->load->view('tribe/tribal_list', $data);
    //         $this->load->view('_footer', $data);
    //         $this->load->view('foot');
    //     }
    
    
    
    /**
     * 部落列表
     */
    function lists(){
        //验证部落权限
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/Modifydata")){
            echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
        }
        
        $this->load->model("region_mdl");
        
        $tribe_id = $this->session->userdata("tribe_id");
        $user_id = $this->session->userdata("user_id");//用户id
        $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
        $is_host = $user_id == $customer_id?true:false;//是否部落首领
        
        //查询部落基本信息
        $this->db->select("a.id,a.name,a.industry,a.provice,a.city,a.content,a.created_at,a.staff_status,a.logo,a.shop_img,a.bg_img,a.content_img,b.member_name,c.mobile");
        $this->db->from("tribe as a");
        $this->db->join("tribe_staff as b","a.id = b.tribe_id");
        $this->db->join("customer as c","b.customer_id = c.id");
        $this->db->where("a.id",$tribe_id);
        $this->db->where("b.is_host",1);
        $tribe = $this->db->get()->row_array();
        //处理部落首页banner
        if (!empty($tribe['bg_img'])) {
            $bg_img = trim($tribe['bg_img'],";");
            $tribe['bg_img'] = $bg_img?explode(';',$bg_img):array();
        }
        
        
        $list = array();
        if($is_host){
            //查询每个角色的用户
            $this->db->select("a.id,a.name,group_concat(c.mobile) as mobile");
            $this->db->from("tribe_manager as a");
            $this->db->join("tribe_staff as b","a.id = b.tribe_manager_id and b.status = 2 and tribe_id = $tribe_id","left");
            $this->db->join("customer as c","b.customer_id = c.id and c.mobile is not null","left");
            $this->db->group_by("a.id");
            $list = $this->db->get()->result_array();
        }
        
        //查询部落族员
        $this->db->select("a.id,b.mobile");
        $this->db->from("tribe_staff as a");
        $this->db->join("customer as b","a.customer_id = b.id");
        $this->db->where("a.status",2);
        $this->db->where("a.tribe_id",$tribe_id);
        $this->db->where("b.mobile is not null");
        $tribe_staff = $this->db->get()->result_array();
        
        
        //部落正式族员数量
        $formal_staff = count($tribe_staff);
        
        //查询部落所有族员数量(预录入和通过)
        $this->db->from("tribe_staff");
        $this->db->where("tribe_id",$tribe_id);
        $this->db->where("status",2);
        $this->db->or_where("customer_id is null");
        $all_staff = $this->db->get()->num_rows();
        
        //查询省级地区
        $provinces = $this->region_mdl->provinces();
        
        $data["is_host"] = $is_host;
        $data["tribe"] = $tribe;
        $data["is_host"] = $is_host;
        $data["tribe"] = $tribe;
        $data["list"] = $list;
        $data["tribe_staff"] = $tribe_staff;
        $data["formal_staff"] = $formal_staff;
        $data["all_staff"] = $all_staff;
        $data["provinces"] = $provinces;
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $data['title'] = '部落列表';
        $data['nav_type'] = 'lists';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribal_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 部落推荐商品
     */
    function products(){
        //验证部落权限
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/products")){
            echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
        }
        $tribe_id = $this->session->userdata("tribe_id");
        
        $times = $this->input->get_post("times");
        $status = $this->input->get_post("status");
        $keyword = $this->input->get('search_name');
        $product_id = $this->input->get('search_id');
        if($status){
            switch ($status){
                case '未上架':
                    $status_type = 2;
                    break;
                case '已上架':
                    $status_type = 1;
                    break;
                case '全部':
                    $status_type = '';
                    break;
                default:
                    $status_type = '';
                    $status = '';
                    break;
            }
        }else{
            $status_type = '';
        }
        if($times){
            $date = date('Y-m-d ');// 当前时间
            switch ($times){
                case '显示全部':
                    $times_type = '';
                    break;
                case '近7天内':
                    $limit_date = date('Y-m-d ', strtotime("-7 days"));// 筛除时间段：7天
                    $times_type = "d.on_sale_at >= '$limit_date' and d.on_sale_at <= '$date'";
                    break;
                case '近一个月内':
                    $limit_date = date('Y-m-d ', strtotime("-30 days"));// 筛除时间段：30天
                    $times_type = "d.on_sale_at >= '$limit_date' and d.on_sale_at <= '$date'";
                    break;
                case '3个月内':
                    $limit_date = date('Y-m-d ', strtotime("-90 days"));// 筛除时间段：90天
                    $times_type = "d.on_sale_at >= '$limit_date' and d.on_sale_at <= '$date'";
                    break;
                case '半年内':
                    $limit_date = date('Y-m-d ', strtotime("-182 days"));// 筛除时间段：半年
                    $times_type = "d.on_sale_at >= '$limit_date' and d.on_sale_at <= '$date'";
                    break;
                case '1年内':
                    $limit_date = date('Y-m-d ', strtotime("-365 days"));// 筛除时间段：一年
                    $times_type = "d.on_sale_at >= '$limit_date' and d.on_sale_at <= '$date'";
                    break;
                default:
                    $times_type = '';
                    $times = '';
                    break;
            }
        }else{
            $times_type = '';
        }
        $data['search'] = $keyword;
        $data['times'] = $times;
        $data['status'] = $status;
        $data['product_id'] = $product_id;
        
        
        $curr_page = $this->input->get_post("per_page");
        if(!$curr_page || $curr_page == 0){
            $curr_page = 1;
        }
        $pagesize = 15;
        
        // 分页设置
        $this->load->library('pagination');
        $url =  site_url('tribe/products/?');
        if($data['search'] || $data['times'] ||$data['status'] || $data['product_id'] ){
            $url .= '&search_name='.$data['search'].'&search_id='.$data['product_id'].'&times='.$data['times'].'&status='.$data['status'];
        }
        
        $config['base_url'] =$url;
        $config['total_rows'] = $this->tribe_mdl->Tribe_product_list($tribe_id,$keyword,$times_type,$product_id,$status_type);
        $config['curr_page'] = $curr_page;
        $config['per_page'] = $pagesize;
        $config['curr_page'] = $curr_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 10;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['cur_tag_open'] = '&nbsp;<a href="javascript:" class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        
        $pro_list = $this->tribe_mdl->Tribe_product_list($tribe_id,$keyword,$times_type,$product_id,$status_type,$pagesize,($curr_page - 1) * $pagesize);//部落商品列表
        
        $data["List"] = $pro_list;
        $data["totalcount"] = $config["total_rows"];
        $data["totalpage"] = ceil($config["total_rows"] / $pagesize);
        $data['pagesize'] = $pagesize;
        $data['page'] = $curr_page;
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $data['title'] = '推荐商品';
        $data['nav_type'] = 'products';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribal_recommendation', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 部落商品上下架
     */
    function ajax_edit_product(){
        $id = $this->input->get_post("id");//部落商品ID
        $type = $this->input->post("type");//状态1上架2下架
        $tribe_id = $this->session->userdata("tribe_id");
        if(!$tribe_id || !in_array($type,array(1,2))){
            $data = array(
                'Result'=>false
            );
            echo json_encode($data);exit;
        }
        $aff =  $this->tribe_mdl->edit_product($id,$tribe_id,$type);
        if($aff){
            $data = array(
                'Result'=>true
            );
        }else{
            $data = array(
                'Result'=>false
            );
        }
        echo json_encode($data);
    }
    /**
     * 商品排序
     */
    function ajax_sort_product(){
        $id = $this->input->get_post("id");//部落商品ID
        $sort = $this->input->get_post("sort");//排序
        $aff =  $this->tribe_mdl->sort_product($id,$sort);
        if($aff){
            echo true;
        }else{
            echo false;
        }
    }
    
    /**
     * 部落成员
     */
    function members(){
        //验证部落权限
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/apply_list")){
            echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
        }
        
        $tribe_id = $this->session->userdata("tribe_id");
        $times = $this->input->get_post("times");
        $status = $this->input->get_post("status");
        $keyword = $this->input->get('search_name');
        $search_id = $this->input->get('search_id');
        $search_mobile = $this->input->get('search_mobile');
        $re_status = $this->input->get('re_status');
        
        
        if($times){
            $date = date('Y-m-d ');// 当前时间
            switch ($times){
                case '显示全部':
                    $times_type = '';
                    break;
                case '近7天内':
                    $limit_date = date('Y-m-d ', strtotime("-7 days"));// 筛除时间段：7天
                    $times_type = "ts.created_at >= '$limit_date' and ts.created_at <= '$date'";
                    break;
                case '近一个月内':
                    $limit_date = date('Y-m-d ', strtotime("-30 days"));// 筛除时间段：30天
                    $times_type = "ts.created_at >= '$limit_date' and ts.created_at <= '$date'";
                    break;
                case '3个月内':
                    $limit_date = date('Y-m-d ', strtotime("-90 days"));// 筛除时间段：90天
                    $times_type = "ts.created_at >= '$limit_date' and ts.created_at <= '$date'";
                    break;
                case '半年内':
                    $limit_date = date('Y-m-d ', strtotime("-182 days"));// 筛除时间段：半年
                    $times_type = "ts.created_at >= '$limit_date' and ts.created_at <= '$date'";
                    break;
                case '1年内':
                    $limit_date = date('Y-m-d ', strtotime("-365 days"));// 筛除时间段：一年
                    $times_type = "ts.created_at >= '$limit_date' and ts.created_at <= '$date'";
                    break;
                default:
                    $times_type = '';
                    $times = '';
                    break;
            }
        }else{
            $times_type = '';
        }
        
        $data['search'] = $keyword;
        $data['times'] = $times;
        $data['status'] = $status;
        $data['search_id'] = $search_id;
        $data['search_mobile'] = $search_mobile;
        $data['re_status'] = $re_status;
        
        $curr_page = $this->input->get_post("per_page");
        if(!$curr_page || $curr_page == 0){
            $curr_page = 1;
        }
        $pagesize = 15;
        
        // 分页设置
        $this->load->library('pagination');
        if($keyword || $times || $status || $search_id || $search_mobile || $re_status ){
            $config['base_url'] = site_url("tribe/members/?search_name=$keyword&search_id=$search_id&search_mobile=$search_mobile&times=$times&status=$status&re_status=$re_status");
        }else{
            $config['base_url'] = site_url('tribe/members/?');
        }
        $config['total_rows'] = $this->tribe_mdl->tribe_member_list($tribe_id,$keyword,$times_type,$status,$search_id,$search_mobile,$re_status,$type='');
        
        $config['curr_page'] = $curr_page;
        $config['per_page'] = $pagesize;
        $config['curr_page'] = $curr_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 10;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['cur_tag_open'] = '&nbsp;<a href="javascript:" class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        
        $member_list = $this->tribe_mdl->tribe_member_list($tribe_id,$keyword,$times_type,$status,$search_id,$search_mobile,$re_status,$pagesize,($curr_page - 1) * $pagesize,$type='list');
        
        $tribe_info = $this->tribe_mdl->get_tribe($tribe_id);
        
        $data["tribe_info"] = $tribe_info;
        
        $data["List"] = $member_list;
        $data["totalcount"] = $config["total_rows"];
        $data["totalpage"] = ceil($config["total_rows"] / $pagesize);
        $data['pagesize'] = $pagesize;
        $data['page'] = $curr_page;
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $data['title'] = '部落成员列表';
        $data['nav_type'] = 'members';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribal_members', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    function ajax_get_city_by_name(){
        $provice_name = $this->input->get_post('provice_name');
        
        $this->load->model("Region_mdl");
        $provice_info = $this->Region_mdl->get_info_ByName($provice_name);
        $city_info =  $this->Region_mdl->children_of($provice_info['region_id']);
        echo json_encode($city_info);
    }
    
    /**
     * 异步修改是否显示预录入用户手机号
     */
    public function  ajax_update_show_mobile(){
        //验证部落权限
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/apply_list")){
            $data = array(
                'status'=>false
            );
            echo json_encode($data);exit;
        }
        
        $tribe_id = $this->session->userdata("tribe_id");
        $show_mobile = $this->input->post('show_mobile');//0隐藏1显示
        
        $aff = $this->tribe_mdl->update_tribe_show_mobile($tribe_id,$show_mobile);
        
        if($aff){
            $return['status'] = true;
        }else{
            $return['status'] = false;
        }
        echo json_encode($return);
        
    }
    
    /**
     * 添加部落成员
     *
     */
    function ajax_add_members(){
        //验证部落权限
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/apply_list")){
            $data = array(
                'status'=>false
            );
            echo json_encode($data);exit;
        }
        
        $info = array();
        
        $info['corporation_name'] = $this->input->get_post('corp_name');
        $info['member_name'] = $this->input->get_post('user_name');
        $info['provice'] = $this->input->get_post('province');
        $info['city'] = $this->input->get_post('city');
        $info['scope'] = $this->input->get_post('scope');
        $info['duties'] = $this->input->get_post('duties');
        $info['tribe_id'] = $this->input->get_post('tribe_id');
        $info['tribe_role_id'] = $this->input->get_post('tribe_role_id');
        $info['mobile'] = $this->input->get_post('mobile');
        $info['hope_offer'] = $this->input->get_post('hope_offer');
        $credit = $this->input->get_post('credit');
        $info['guarantee_ceiling'] = $this->input->get_post('guarantee_ceiling');
        $info['guarantee_to_ceiling'] = $this->input->get_post('guarantee_to_ceiling');
        $info['guarantee_from_ceiling'] = $this->input->get_post('guarantee_from_ceiling');
        $info['remain_guarantee_price'] = $this->input->get_post('remain_guarantee_price');
        $info['own_goods'] = $this->input->get_post('own_goods');
        $info['replacement_intention'] = $this->input->get_post('replacement_intention');
        $info['industry'] = $this->input->get_post('industry');
        $info['show_mobile'] = $this->input->get_post('is_phone');
        $info['member_type'] = $this->input->get_post('member_type');// 预录入族员默认隐藏
        $info['status'] =2;//义工委默认通过
        $info['is_pre_record'] = 1; // pc端预录入默认是语录入成员类型
        $this->load->model("Customer_mdl");
        $customer = $this->Customer_mdl->load_by_mobile($info['mobile']);
        
        if($customer){
            if($credit){
                $this->Customer_mdl->credit_ceiling = $credit;
                $credit_status = $this->Customer_mdl->update($customer['id']);
            }
            // $info['customer_id'] = $customer['id'];//手机号已注册添加用户ID
        }
        
        $staff = $this->tribe_mdl->check_mobile($info['mobile'],$info['tribe_id']);
        if($staff){
            $info['id'] = $staff['id'];
            $info['customer_id'] = null;
            $info['add'] = 'add';
            $aff = $this->tribe_mdl->update_member($info,$info['tribe_id']);
            $res = $this->tribe_mdl->load_tribe_tips($info['mobile']);
            if($res ){
                $this->tribe_mdl->update_tips(0,$info['mobile'],'reset');
            }
            // echo $this->db->last_query();
            // exit;
        }else{
            // $info['status'] =1;//预录入默认待审核
            $info['customer_id'] = null; // 预录入用户id为null
            $aff = $this->tribe_mdl->add_staff($info);
            // 先检测是否有这个纪录
            $res = $this->tribe_mdl->load_tribe_tips($info['mobile']);
            if($res ){
                $this->tribe_mdl->update_tips(0,$info['mobile'],'reset');
            }
            
        }
        
        if($aff){
            if($customer){//用户存在&&添加部落成员成功=>发送信息
                $tribe = $this->tribe_mdl->load($info['tribe_id'],$customer['id']);
                $this->load->model('Customer_message_mdl');
                $message_data['template_id'] = 8;//通知的模板Id;
                $message_data['customer_id'] = $customer['id'];
                $message_data['type'] = 4;//订单类型;
                $message_data['obj_id'] = $info['tribe_id'];//部落ID
                $message_data['parameter']['name'] = $tribe['name'];
                $this->Customer_message_mdl->Create_Message( $message_data );
            }
            
            $data = array(
                'status'=>true
            );
        }
        echo json_encode($data);
    }
    
    /**
     * 更新部员
     */
    
    function ajax_update_members(){
        //验证部落权限
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/apply_list")){
            $data = array(
                'status'=>false
            );
            echo json_encode($data);exit;
        }
        
        $info = array();
        
        $info['corporation_name'] = $this->input->get_post('corp_name');
        $info['member_name'] = $this->input->get_post('user_name');
        $info['provice'] = $this->input->get_post('province');
        $info['city'] = $this->input->get_post('city');
        $info['scope'] = $this->input->get_post('scope');
        $duties = $this->input->get_post('duties');
        if(!$duties){
            $duties = NULL;
        }
        $info['duties'] = $duties;
        $info['tribe_id'] = $this->input->get_post('tribe_id');
        $info['tribe_role_id'] = $this->input->get_post('tribe_role_id');
        $info['mobile'] = $this->input->get_post('mobile');
        $info['hope_offer'] = $this->input->get_post('hope_offer');
        $credit = $this->input->get_post('credit');
        $info['guarantee_ceiling'] = $this->input->get_post('guarantee_ceiling');
        $info['guarantee_to_ceiling'] = $this->input->get_post('guarantee_to_ceiling');
        $info['guarantee_from_ceiling'] = $this->input->get_post('guarantee_from_ceiling');
        $info['remain_guarantee_price'] = $this->input->get_post('remain_guarantee_price');
        $info['own_goods'] = $this->input->get_post('own_goods');
        $info['replacement_intention'] = $this->input->get_post('replacement_intention');
        $info['industry'] = $this->input->get_post('industry');
        
        
        $info['status'] =$this->input->get_post('status');
        $info['show_mobile'] =$this->input->get_post('is_phone');
        
        $info['id'] =$this->input->get_post('id');
        
        //获取用户的部员信息
        $this->load->model('Tribe_mdl');
        $tribe_info = $this->Tribe_mdl->get_tribe_customet_info($info['id']);
        if($tribe_info['status'] !=2 || $tribe_info['status'] !=3){
            $audit =false;
        }else{
            $audit = true;
        }
        
        //正常应该是通过接口获取用户信息，但credit_ceiling只在B端有
        $this->load->model("Customer_mdl");
        $customer = $this->Customer_mdl->load_by_mobile($info['mobile']);
        if($customer){
            if($credit){
                if($customer['credit_ceiling'] != $credit){
                    $this->Customer_mdl->credit_ceiling = $credit;
                    $credit_status =  $this->Customer_mdl->update($customer['id']);
                }
            }
            // $info['customer_id'] = $customer['id'];//手机号已注册添加用户ID
        }
        // $info['customer_id'] = null; // 预录入用户id为null
        
        $aff =  $this->tribe_mdl->update_member($info);
        
        if($aff){
            if(!$audit && !empty($customer)){
                
                //发送短信
                $this->load->helper("message");
                $tribe = $this->tribe_mdl->get_tribe($info['tribe_id']);
                //                 $tribe = $this->tribe_mdl->load($info['tribe_id'],$customer['id']);
                //判断是否是审核过
                if($info['status'] == 2){
                    $this->load->model('Customer_message_mdl');
                    $message_data['template_id'] = 8;//通知的模板Id;
                    $message_data['customer_id'] = $customer['id'];
                    $message_data['type'] = 4;//订单类型;
                    $message_data['obj_id'] = $info['tribe_id'];//部落ID
                    //部落名称
                    $message_data['parameter']['name'] =$tribe['name'];
                    $this->Customer_message_mdl->Create_Message( $message_data );
                    
                    $mobile = $tribe_info['mobile'];
                    
                    $param['customer_id'] = $customer['id'];
                    $param['resource'] = "Tribe/home/{$tribe_info['tribe_id']}";
                    $req = json_decode(  ToConect($param),true);
                    
                    $content = "欢迎加入".$tribe['name']."，快点去认识一下部落的其他成员，寻找自己的合作伙伴，点击进入：".$req['url_short']." 退订回N【51易货网】";
                    
                    $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
                    $sms = send_message($mobile,0,$content,2,$source);
                    $sms = json_decode($sms,true);
                    
                    //加入聊天室
                    $this->HuanXinGroupHandle($info['tribe_id'],$customer['id'],"join");
                }else if($info['status'] == 3){
                    
                    $mobile = $tribe_info['mobile'];
                    $param['customer_id'] = $customer['id'];
                    $param['resource'] = "Tribe/tribe_detail/{$tribe_info['tribe_id']}";
                    $req = json_decode(  ToConect($param),true);
                    
                    $content = "您加入的部落审核不通过，点击查看：".$req['url_short']." 详情请咨询：4000029777 退订回N【51易货网】";
                    
                    $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
                    $sms = send_message($mobile,0,$content,2,$source);
                    $sms = json_decode($sms,true);
                    
                    //退出聊天室  有则退出
                    $this->HuanXinGroupHandle($info['tribe_id'], $customer['id'],"exit");
                    
                }else if($info['status'] == 1){
                    //退出聊天室  有则退出
                    $this->HuanXinGroupHandle($info['tribe_id'], $customer['id'],"exit");
                }
                
            }
            
            $data = array(
                'status'=>true
            );
        }else{
            $data = array(
                'status'=>false
            );
        }
        
        echo json_encode($data);
    }
    
    /**
     * 检查手机号
     */
    function ajax_check_mobile(){
        $mobile = $this->input->get_post('mobile');
        $tribe_id = $this->input->get_post('tribe_id');
        $type = $this->input->get_post('type');
        $info = $this->tribe_mdl->check_mobile($mobile,$tribe_id,$type);
        if($info){
            $data = array(
                'Result'=>true
            );
        }else{
            $data = array(
                'Result'=>false
            );
        }
        echo json_encode($data);
    }
    
    /**
     * 新增族员
     */
    function add_member(){
        //验证部落权限
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/apply_list")){
            echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
        }
        
        $this->edit_members(0,"add");
    }
    
    function edit_members($id = 0,$type=""){
        $this->load->model("Region_mdl");
        if($type == 'add'){//添加部员
            $data['show'] = false;
            $data['check_mobile'] = true;
            
        }else{
            $id = $this->input->get_post('id');
            if($id){
                $tribe_info = $this->tribe_mdl->get_tribe_customet_info($id);
                $data['tribe_info'] = $tribe_info ;
                $provice_info = $this->Region_mdl->get_info_ByName($tribe_info['provice']);
                $city_info =  $this->Region_mdl->children_of($provice_info['region_id']);
                $data['city_info'] = $city_info;
                $data['show'] = true;
                $data['check_mobile'] = false;
                if($tribe_info['customer_id']){
                    $this->load->model("Customer_mdl");
                    $customer = $this->Customer_mdl->load($tribe_info['customer_id']);
                    $data['credit'] = $customer['credit_ceiling'];
                }
                
            }
            
        }
        $user_id = $this->session->userdata("user_id");
        $tribe_id = $this->session->userdata("tribe_id");
        
        //部落信息
        $tribe = $this->tribe_mdl->ManagementTribe($user_id,$tribe_id);
        $data['tribe_list'] = $tribe;
        //部落角色
        $role_info = $this->tribe_mdl->get_tribe_role($tribe_id);
        $data['role_info'] = $role_info;
        
        //      echo '<pre>';
        //      print_r( $data['tribe_info']);exit;
        //地区
        $this->load->model("Region_mdl");
        $region  = $this->Region_mdl->provinces();//获取省
        //      echo '<pre>';
        //      print_r($region);exit;
        $data['region'] = $region;
        $data['head_set'] = 3;
        $data['foot_set'] = 1;
        $data['title'] = '编辑部落成员';
        $data['nav_type'] = 'members';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/newly_added', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * 进入部落商城
     */
    public function shop($id=0, $label_id = '' ){
        
        $type = $this->input->get("type");
        $customer_id = $this->session->userdata("user_id");//用户id
        $real_name = $this->session->userdata("real_name");//真实姓名
        $appid = $this->session->userdata("app_info")['id'];
        //         print_r($appid);exit;
        $data["tribe"] = $this->tribe_mdl->load($id,$customer_id);//查询部落
        //判断部落是否存在
        if($data["tribe"]){
            
            //判断是否已经加入此部落
            if($data["tribe"]["tribe_staff_id"] && $data["tribe"]["status"]==2){//已加入
                $data["goods"] = $this->tribe_mdl->hot_goods($id,$appid);//查询最新商品
                $data["customer_id"] = $customer_id;
                $data["real_name"] = !empty($real_name)?$real_name:$data["tribe"]["member_name"];//用户名称
                $data["tribe_id"] = $id;
                
                if($type){
                    $data['title'] = $type == 1?"部落商城":"企业展示";
                }else{
                    $data['title'] = "部落商城";
                }
                
                $data["type"] = $type;
                $data['label_id'] = $label_id;
                $data['head_set'] = 2;
                $data['foot_set'] = 1;
                $this->load->view('head', $data);
                $this->load->view('_header', $data);
                $this->load->view('tribe/tribe_shop', $data);
                $this->load->view('_footer', $data);
                $this->load->view('foot');
                
            }else{//未加入
                redirect("tribe/tribe_detail/$id");
            }
            
        }else{
            echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
        }}
        
        
        
        // --------------------------------------------------------------------
        
        /**
         * 商城
         * ajax下拉加载商品（根据类型排序）
         */
        public function loading_goods_mall(){
            $appid = $this->session->userdata("app_info")['id'];//分站点id
            $tribe_id = $this->input->post("tribe_id");//部落id
            $type = $this->input->post("type");//排序类型1全部商品价格DESC2最新3共享服务4全部商品价格ASC
            if(!in_array($type,array(1,2,3,4))){
                $data = array();
                echo json_encode($data);exit;
            }
            $limit = 5;//每页显示的数量
            $page = $this->input->post("page");//页数
            if(0 == $page)
            {
                $page = 1;
            }
            
            $offset = ($page-1)*$limit;//偏移量
            $data["list"] = $this->tribe_mdl->loading_goods($tribe_id,$appid,$limit,$offset,$type);//商品列表
            
            echo json_encode($data);
            
        }
        
        /**
         * 部落
         * ajax下拉加载商品（根据类型排序）
         */
        public function loading_goods(){
            $user_id= $this->session->userdata("user_id");//用户id
            $tribe_id = $this->input->post("tribe_id");//部落id
            $type = $this->input->post("type");//1为商城，2为部落
            if(!in_array($type,array(1,2))){
                $data = array();
                echo json_encode($data);exit;
            }
            $limit = 6;//每页显示的数量
            $page = $this->input->post("page");//页数
            if(0 == $page)
            {
                $page = 1;
            }
            $offset = ($page-1)*$limit;//偏移量
            if ($type == '1') {
                $data["list"] = $this->db->where('is_on_sale','1')->from('easy_product')->order_by('id','desc')->limit((int) $limit, (int) $offset)->get()->result_array();
            } elseif ($type == '2') {
                $data['list'] = $this->db->where('tribe_id',$tribe_id)->where('is_on_sale','1')->from('easy_product')->order_by('sort','desc')->order_by('update_at','desc')->limit((int) $limit, (int) $offset)->get()->result_array();
            } else {
                $data = array();
            }
            foreach ($data['list'] as $key => $value) {
                if ($value['sort'] == '1') {
                    $value['stick'] = '已置顶';
                } else {
                    $value['stick'] = '置顶';
                }
                $img_data = $this->db->where('product_id',$value['id'])->from('easy_product_img')->get()->row_array();
                $img= substr($img_data['path'], 1);
                $value['img_path'] = $img;
                $data['list'][$key] = $value;
            }
            $staff_data = $this->db->where('tribe_id',$tribe_id)->where('customer_id',$user_id)->from('tribe_staff')->get()->row_array();
            if ($staff_data['is_host'] == '1' || $staff_data['tribe_manager_id'] == '1') {
                $data['limit'] = 1;
            } else {
                $data['limit'] = 0;
            }
            echo json_encode($data);exit;
        }
        
        /*
         *
         * 部落管理员置顶商品
         */
        public function up_product () {
            $tribe_id = $this->input->post("tribe_id");//部落id
            $id = $this->input->post('id');
            $label_data = $this->input->post('label_data');
            if (empty($id) || empty($label_data)) {
                $data = array(
                    'Type'=>0,
                    'Msg'=>'商品信息错误',
                );
                echo json_encode($data);
                exit();
            }
            if ($label_data == '置顶') {
                $this->db->where('id',$id)->update('easy_product',array('sort' => '1'));
                $data = array(
                    'Type'=>1,
                    'Msg'=>'置顶商品成功',
                );
            } else {
                $this->db->where('id',$id)->update('easy_product',array('sort' => '0'));
                $empty_sort = $this->db->where('tribe_id',$tribe_id)->where('is_on_sale','1')->where('sort','1')->from('easy_product')->get()->result_array();
                if (empty($empty_sort)) {
                    $data['last_up_id'] = '0';
                }else {
                    $last_up_data = $this->db->where('tribe_id',$tribe_id)->where('is_on_sale','1')->from('easy_product')->order_by('sort','desc')->order_by('update_at','asc')->get()->result_array();
                    $data['last_up_id'] = $last_up_data['0']['id'];
                }
                
                $data = array(
                    'last_up_id'=>$data['last_up_id'],
                    'Type'=>2,
                    'Msg'=>'取消置顶成功',
                );
            }
            echo json_encode($data);
            
        }
        
        // --------------------------------------------------------------------
        
        
        /**
         * 部落详情
         */
        public function tribe_detail($id,$label_id = 0){
            
            $customer_id = $this->session->userdata("user_id");//用户id
            $mobile = $this->session->userdata("mobile");//用户id
            //获取部落信息
            $data["tribe"] = $this->tribe_mdl->get_tribe($id);
            
            if(!$data["tribe"]){
                echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
            }else if($data["tribe"]['status'] !=2){
                echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
            }
            //通过手机验证成员信息
            $staff_info =  $this->tribe_mdl->verify_tribe_user($id,$mobile);
            if(!$staff_info){
                //未加入或没有预录入
                $data["status"] = 4;
            }
            //存在用户ID
            if($staff_info['customer_id']){
                if($staff_info["status"]==1){
                    //已经申请
                    $data["status"] = 1;
                }else if($staff_info["status"]==2){
                    //商会进去部落详情 直接跳去首页
                    redirect("Tribe/home/$id/$label_id");
                    $data["status"] = 2;
                }else if($staff_info["status"]==3){
                    //审核不通过
                    $data["status"] = 3;
                }else if($staff_info["status"]==4){
                    //审核不通过
                    $data["status"] = 4;
                }
            }else{
                //已经预录入用户
                //默认为未申请
                $data["status"] = 4;
            }
            
            //             $data["tribe"] = $this->tribe_mdl->check_My_apply($id,$customer_id);//查询部落
            //             if($data["tribe"]){
            //                 if($data["tribe"]["tribe_staff_id"] && $data["tribe"]["status"]==1){//已经申请
            //                     $data["status"] = 1;
            //                 }else if($data["tribe"]["tribe_staff_id"] && $data["tribe"]["status"]==2){//已经加入
            //                     //商会进去部落详情 直接跳去首页
            //                     redirect("Tribe/home/$id/$label_id");
            
            //                     $data["status"] = 2;
            //                 }else if($data["tribe"]["tribe_staff_id"] && $data["tribe"]["status"]==3){//审核不通过
            //                     $data["status"] = 3;
            //                 }else{//未加入
            //                     $data["status"] = 4;
            //                 }
            //             }else{
            //                 echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
            //             }
            
            
            $data["id"] = $id;
            $data["label_id"] = $label_id;
            $data['title'] = $data["tribe"]['name'];
            $data['head_set'] = 2;
            $data['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/tribe_detail", $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot');
        }
        
        // --------------------------------------------------------------------
        
        /**
         * 申请加入部落填写资料页面
         */
        public function apply_view( $id = 0,$label_id = 0 )
        {
            //接口查询用户信息
            $customer_id = $this->session->userdata("user_id");//用户id
            $url = $this->url_prefix.'Customer/load';
            $post['customer_id']=$customer_id;
            $customer = json_decode($this->curl_post_result($url,$post),true);
            //判断是否绑定手机
            if (!$customer["mobile"] )
            {
                $this->session->set_userdata('ref_from_url', current_url() );
                redirect('member/binding/binding_mobile');
                exit;//手机未绑定
            }
            
            
            $mobile = $this->session->userdata("mobile");//用户id
            
            //获取部落信息
            $data["tribe"] = $this->tribe_mdl->get_tribe($id);
            //通过手机验证成员信息
            $staff_info =  $this->tribe_mdl->verify_tribe_user($id,$mobile);
            
            //             $data["tribe"] = $this->tribe_mdl->check_My_apply($id,$customer_id);//查询部落
            
            if( $data["tribe"] )
            {
                if($staff_info){
                    if ($staff_info['customer_id']){
                        if($staff_info["status"]==1){
                            echo '<script>alert("您已经申请过了！工作人员正在审核...");
                                   window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$id.'"
                                 </script>';exit;//已经在申请列表
                        }else if($staff_info["status"]==2){
                            echo '<script>alert("您已经加入该部落，无需重复申请！");
                                 window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$id.'"
                                </script>';exit;
                        }
                    }else{
                        //预录入用户(不作处理)
                        $data['is_pre_record'] = 'is_pre_record';//标记是预录入用户
                        
                    }
                }
            }else{
                
                echo '<script>alert("部落不存在");
                 window.location.href = "'.site_url("Tribe").'"
                </script>';exit;
            }
            //             $data['staff_info'] = $staff_info;
            $data['label_id'] = $label_id;
            $data['customer_info'] = $customer;
            $data['id'] = $id;
            $data['title'] =  $data["tribe"]['name'];
            $data['head_set'] = 2;
            $data['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/tribe_information_fill", $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot');
        }
        
        /**
         * 审核不通过  用户再次申请修改记录为待审核
         */
        public function  update_apply(){
            $id = $this->input->post("id");//部落id
            $customer_id = $this->session->userdata("user_id");//用户id
            
            $info = $this->tribe_mdl->check_My_apply($id,$customer_id);//查询部落
            $_update['id'] =  $info['tribe_staff_id'];
            $_update['status'] =  1;
            $aff = $this->tribe_mdl->update_member($_update,$id);
            
            $return = array(
                "status"=>0,
                "Message"=>"申请成功"
            );
            if(!$aff){
                $return = array(
                    "status"=>5,
                    "Message"=>"申请失败"
                );
            }
            echo json_encode($return);
        }
        
        /**
         * ajax申请加入部落
         */
        public function  apply(){
            $id = $this->input->post("id");//部落id
            $customer_id = $this->session->userdata("user_id");//用户id
            $customer_name = $this->input->post('customer_name');//真实姓名
            
            $code_invite = $this->input->post('code_invite');//二维码邀请
            
            $is_pre_record = $this->input->post('is_pre_record');//是否是预录入用户
            
            if($is_pre_record){
                
                $mobile = $this->session->userdata("mobile");//用户id
                
                //通过手机验证成员信息
                $staff_info =  $this->tribe_mdl->verify_tribe_user($id,$mobile);
                $update['add'] = true;
                $update['id'] = $staff_info['id'];
                $update['customer_id'] = $customer_id;
                $aff =  $this->tribe_mdl->update_member($update,$id);
                
                //同步所有的部落的真实姓名
                $this->tribe_mdl->update_tribe_member_name($customer_name,$customer_id);
                
                //同步用户信息表。
                $url = $this->url_prefix.'Customer/info_save';
                $post['real_name'] = $customer_name;
                $post['user_id'] = $customer_id;
                $api_update_row = json_decode($this->curl_post_result($url,$post),true);
                
                if($aff){
                    //同步部落身份信息
                    $staff_idenity =  $this->tribe_mdl->load_staff_idenity($mobile);
                    if($staff_idenity){
                        foreach ($staff_idenity as $key =>$val){
                            $this->tribe_mdl->del_staff_idenity($val['id']);
                            unset( $staff_idenity[$key]['id']);
                            unset( $staff_idenity[$key]['mobile']);
                            unset( $staff_idenity[$key]['created_at']);
                            $staff_idenity[$key]['customer_id'] = $customer_id;
                        }
                        $this->load->model('Customer_identity_mdl');
                        $this->Customer_identity_mdl->add_idenity_batch($staff_idenity);
                    }
                    ///同步部落预录入的相册个人形象
                    $this->load->model('Tribe_staff_album_mdl');
                    $this->Tribe_staff_album_mdl->synchro_Update($customer_id,$id);
                    
                    $num = 3;//提示改成3次
                    $this->tribe_mdl->update_tips($num,$mobile);
                    if($staff_info['status'] ==2){
                        //无需审核，直接加入。
                        echo json_encode(array("status"=>8,'message'=>'您已经成功加入该部落，正在转跳.....') );exit;//申请成功
                    }else if($staff_info['status'] ==1){
                        echo json_encode(array("status"=>3,'message'=>'申请成功'));exit;//申请成功
                    }
                }else{
                    echo json_encode(array("status"=>4,'message'=>'申请失败'));exit;//申请失败
                }
            }
            
            if( $id )
            {
                //接口查询用户信息
                $url = $this->url_prefix.'Customer/load';
                $post['customer_id']=$customer_id;
                $customer = json_decode($this->curl_post_result($url,$post),true);
                
                //判断是否绑定手机
                if(!$customer["mobile"])
                {
                    echo json_encode(array("status"=>6,'message'=>'手机未绑定'));exit;//手机未绑定
                }
                
                //查询部落（主表) left join 成员信息。
                $tribe_ts_info = $this->tribe_mdl->check_My_apply( $id,$customer_id );//查询部落
                
                if( $tribe_ts_info )
                {
                    
                    //部落是否需要审核。
                    if( $tribe_ts_info['staff_status'] == 0 )
                    {
                        //不需要审核
                        $_data["status"] = 2;//审核通过
                    }else{
                        $_data["status"] = 1;//审核
                    }
                    
                    if($code_invite){
                        if( !empty($_COOKIE['invitetp_'.$id])){
                            if($tribe_ts_info["tribe_staff_id"]){
                                //当是部落二维码邀请时并且是管理员邀请的话则用户加入部落默认审核通过
                                $inviteid =  $this->session->userdata('inviteid');
                                $authority = $this->tribe_mdl->ManagementTribe($inviteid,$id);
                                if($authority){
                                    $_update['id'] =  $tribe_ts_info['tribe_staff_id'];
                                    $_update["status"] = 2;
                                    $_update["is_agree"] = 1;
                                    $aff = $this->tribe_mdl->update_member($_update,$id);
                                    if($aff){
                                        //无需审核，直接加入。
                                        echo json_encode(array("status"=>8,'message'=>'您已经成功加入该部落，正在转跳.....') );exit;//申请成功
                                    }
                                }
                            }
                            
                            $_data["status"] = 2;//审核通过
                        }
                    }
                    
                    if( $tribe_ts_info["tribe_staff_id"] && $tribe_ts_info["status"] == 1 )
                    {
                        //已经在申请列表
                        echo json_encode(array("status"=>1,'message'=>'您已经申请过了！工作人员正在审核...'));exit;//已经在申请列表
                        
                    }else if($tribe_ts_info["tribe_staff_id"] && $tribe_ts_info["status"]==2)
                    {
                        //已经加入
                        echo json_encode(array("status"=>2,'message'=>'您已经成功加入该部落，正在转跳...'));exit;//已经加入
                        
                    }else if( $tribe_ts_info["tribe_staff_id"] && $tribe_ts_info["status"] == 3 || $tribe_ts_info["tribe_staff_id"] && $tribe_ts_info["status"] == 4)
                    {
                        
                        //更新。
                        $_data['id'] =  $tribe_ts_info['tribe_staff_id'];
                        $_data["is_agree"] = 1;
                        $_data["member_name"] = $customer_name ;
                        $row = $this->tribe_mdl->update_member($_data,$id);
                        
                        $aff = $this->tribe_mdl->update_tribe_member_name($_data["member_name"],$customer_id);
                        
                    }else{
                        //添加。
                        $_data["customer_id"] = $customer_id;
                        $_data["tribe_id"] = $id;
                        $_data["mobile"] = $customer["mobile"];
                        //新增。
                        $_data["member_name"] = $customer_name;
                        $_data['is_agree'] = 1;
                        $ts_id = $this->tribe_mdl->add_staff($_data);
                        if($ts_id){
                            $aff = $this->tribe_mdl->update_tribe_member_name($customer_name,$customer_id);
                        }
                    }
                    
                    if( !empty( $ts_id ) || !empty( $row ) )
                    {
                        //同步用户信息表。
                        $url = $this->url_prefix.'Customer/info_save';
                        $post['real_name'] = $customer_name;
                        $post['user_id'] = $customer_id;
                        $api_update_row = json_decode($this->curl_post_result($url,$post),true);
                        
                        if( $_data['status'] == 2 )
                        {
                            //无需审核，直接加入。
                            echo json_encode(array("status"=>8,'message'=>'您已经成功加入该部落，正在转跳.....') );exit;//申请成功
                            
                        }else{
                            
                            echo json_encode(array("status"=>3,'message'=>'申请成功'));exit;//申请成功
                        }
                        
                    }else{
                        
                        echo json_encode(array("status"=>4,'message'=>'申请失败'));exit;//申请失败
                    }
                    
                }else{
                    
                    echo json_encode(array("status"=>5,'message'=>'部落不存在'));exit;//部落不存在
                }
                
            }else{
                
                echo json_encode(array("status"=>7,'message'=>'缺少必填参数'));exit;//缺少必填参数。
            }
        }
        
        
        /**
         * 部落排行榜 -- 页面
         */
        public function Tribe_Ranking( $id = 0 )
        {
            $customer_id = $this->session->userdata("user_id");//用户id
            $tribe_info = $id ? $this->tribe_mdl->load($id,$customer_id) : 0;//查询部落
            
            if( !$tribe_info ){
                
                echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
                
            }else if ( !$tribe_info['tribe_staff_id'] || $tribe_info['status'] != 2 )
            {
                echo ' <base href="'.THEMEURL.'" />
                        <meta name="viewport"
                        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                        <style>
                        .black_feds{
                            padding: 10px 0;
                            border-radius: 2px;
                            background: #696969;
                            color: #fff;
                            text-align: center;
                            display: none;
                            width: 70%;
                            margin: 0 15%;
                            position: fixed;
                            top: 150px;
                            font-size: 12px;
                        }
                        </style>
                        <span class="black_feds" style="z-index: 999;">51易货网</span>
                        <script type="text/javascript" src="js/jquery.min.js"></script>
                        <script>
                        function prompt(){
                            $(".black_feds").toggle();
                        }
                        $(".black_feds").text("您不是该部落成员，无法访问").show();
                        setTimeout("prompt();", 2000);
                        setTimeout(function(){
                        window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$id.'"
                        }, 2500);
                        </script>';
                exit;
                
                
            }
            
            $data['tribe_id'] = $id;
            $data['head_set'] = 2;
            $data['foot_icon'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/tribe_ranking", $data);
            $this->load->view('foot');
        }
        
        /**
         * 排行排详细
         */
        public function Ranking_Detaile( $type, $tribe_id = 0 )
        {
            $customer_id = $this->session->userdata("user_id");//用户id
            
            //Help:互助排行 Contribute:贡献排行 Guarantee:担保排行 Profit:收益排行 Credit:授信排行
            $Ranking = array(
                
                'Help'=>'互助排行榜','Contribute'=>'贡献排行榜','Guarantee'=>'担保排行榜','Profit'=>'收益排行榜','Credit'=>'授信排行榜'
                
            );
            
            if( !array_key_exists($type,$Ranking) )
            {
                //参数错误
                echo "<script>history.back(-1);alert('排行榜不存在');</script>";exit;
            }
            
            $name = array(
                
                'Help'=>'消费额(货豆)','Contribute'=>'贡献额(货豆)','Guarantee'=>'担保额(货豆)','Profit'=>'总收益(元)','Credit'=>'授信额(货豆)'
                
            );
            
            $tribe_info = $tribe_id ? $this->tribe_mdl->load($tribe_id,$customer_id) : 0;//查询部落
            
            if( !$tribe_info )
            {
                echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
                
            }else if ( !$tribe_info['tribe_staff_id'] || $tribe_info['status'] != 2 )
            {
                echo ' <base href="'.THEMEURL.'" />
                        <meta name="viewport"
                        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                        <style>
                        .black_feds{
                            padding: 10px 0;
                            border-radius: 2px;
                            background: #696969;
                            color: #fff;
                            text-align: center;
                            display: none;
                            width: 70%;
                            margin: 0 15%;
                            position: fixed;
                            top: 150px;
                            font-size: 12px;
                        }
                        </style>
                        <span class="black_feds" style="z-index: 999;">51易货网</span>
                        <script type="text/javascript" src="js/jquery.min.js"></script>
                        <script>
                        function prompt(){
                            $(".black_feds").toggle();
                        }
                        $(".black_feds").text("您不是该部落成员，无法访问").show();
                        setTimeout("prompt();", 2000);
                        setTimeout(function(){
                        window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$tribe_id.'"
                        }, 2500);
                        </script>';
                exit;
                
            }
            $data['title'] = $Ranking[$type];
            //验证部落
            $data['name'] = !empty($name[$type]) ? $name[$type] : '';
            $data['tribe_id'] = $tribe_id;
            $data['type'] = $type;
            $data['head_set'] = 2;
            $data['foot_icon'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/ranking_list", $data);
            $this->load->view('foot');
        }
        
        /**
         * AJAX 加载各个排行榜
         */
        public function Ranking_List()
        {
            
            $type = $this->input->post('type');
            $time = $this->input->post('time');
            $tribe_id = $this->input->post('tribe_id');
            $page = $this->input->post('page');
            
            $return['message'] = '成功';
            $return['statsu'] = 1;
            $return['list'] = array();
            
            $customer_id = $this->session->userdata("user_id");//用户id
            $tribe_info = $tribe_id ? $this->tribe_mdl->load($tribe_id,$customer_id) : 0;//查询部落
            //              echo $this->db->last_query();
            if( !$tribe_info )
            {
                //部落不存在
                $return['statsu'] = 2;
                $return['message'] = '部落不存在';
                echo json_encode($return);
                exit;
                
            }else if ( !$tribe_info['tribe_staff_id'] || $tribe_info['status'] != 2 )
            {
                //不是部落成员
                $return['statsu'] = 3;
                $return['message'] = '您不是该部落成员，无法访问';
                echo json_encode($return);
                exit;
            }
            
            if( !$page  || !is_numeric($page) || !is_int($page+0)  )
            {
                $page = 1;
            }
            //获取时间区间
            $this->load->helper("time");
            $time = GetTime($time);
            
            $limit = 10;
            $offset = ($page-1)*$limit;//偏移量
            
            switch ($type)
            {
                case 'Help': //互助排行
                    $this->load->model('Order_mdl');
                    if( $page < 2)
                    {
                        $return['user_info'] = $this->Order_mdl->Tribal_Members_Consumption($tribe_id,$customer_id,null,null,$time);
                        if(!$return['user_info']){
                            $return['user_info']['position'] = '-';
                            $return['user_info']['member_name'] = $tribe_info['real_name'];
                            $return['user_info']['corporation_name'] = $tribe_info['real_corp_name'];
                            $return['user_info']['total'] = "0";
                        }
                    }
                    $return['list'] = $this->Order_mdl->Tribal_Members_Consumption($tribe_id,null,$limit,$offset,$time);
                    
                    break;
                case 'Contribute': //贡献排行1
                    $this->load->model('Order_mdl');
                    if( $page < 2)
                    {
                        $return['user_info'] = $this->Order_mdl->Corp_Total_Sales( $tribe_id,$customer_id,null,null,$time );
                        if(!$return['user_info']){
                            $return['user_info']['position'] = '-';
                            $return['user_info']['member_name'] = $tribe_info['real_name'];
                            $return['user_info']['corporation_name'] = $tribe_info['real_corp_name'];
                            $return['user_info']['total'] = "0";
                        }
                    }
                    $return['list'] = $this->Order_mdl->Corp_Total_Sales( $tribe_id,null,$limit,$offset,$time );
                    
                    
                    break;
                case 'Guarantee': //担保排行1
                    $this->load->model('Guarantee_request_mdl');
                    if( $page < 2)
                    {
                        $return['user_info'] = $this->Guarantee_request_mdl->Ranking_list($tribe_id,$customer_id,null,null,$time);
                        
                        if(!$return['user_info']){
                            $return['user_info']['position'] = '-';
                            $return['user_info']['member_name'] = $tribe_info['real_name'];
                            $return['user_info']['corporation_name'] =  $tribe_info['real_corp_name'];
                            $return['user_info']['total'] = "0";
                        }
                    }
                    $return['list'] = $this->Guarantee_request_mdl->Ranking_list($tribe_id,null,$limit,$offset,$time);
                    
                    break;
                case 'Profit': //收益排行
                    $this->load->model('Tribe_mdl');
                    if( $page < 2)
                    {
                        $return['user_info'] = $this->Tribe_mdl->Rebate_Ranking_list( $tribe_id,$customer_id,null,null,$time );
                        if(!$return['user_info']){
                            $return['user_info']['position'] = '-';
                            $return['user_info']['member_name'] = $tribe_info['real_name'];
                            $return['user_info']['corporation_name'] = $tribe_info['real_corp_name'];
                            $return['user_info']['total'] = "0";
                        }
                    }
                    $return['list'] = $this->Tribe_mdl->Rebate_Ranking_list( $tribe_id,null,$limit,$offset,$time );
                    
                    break;
                case 'Credit': //授信排行
                default:
                    $this->load->model('Credit_mdl');
                    
                    if( $page < 2)
                    {
                        $return['user_info'] = $this->Credit_mdl->Ranking_List($tribe_id,null,null,$time,$customer_id);
                        if(!$return['user_info']){
                            $return['user_info']['position'] = '-';
                            $return['user_info']['member_name'] = $tribe_info['member_name'];
                            $return['user_info']['corporation_name'] = $tribe_info['real_corp_name'];
                            $return['user_info']['total'] = "0";
                        }
                    }
                    
                    $return['list'] = $this->Credit_mdl->Ranking_List($tribe_id,$limit,$offset,$time);
                    
                    //授信
                    break;
                    
            }
            
            echo json_encode($return);
            
        }
        
        // --------------------------------------------------------------------
        
        
        /**
         * 搜索部落
         */
        public function tribe_search(){
            $customer_id = $this->session->userdata("user_id");//用户id
            $keywords = $this->input->get("keywords");//搜索关键词
            $data["keywords"] = $keywords;
            
            $this->load->model('hot_keywords_mdl');
            if ($keywords && isset($keywords) && !empty($keywords) && $keywords != null && $keywords != "" && !ctype_space($keywords)) {//有关键词
                //处理$keywords值
                $keywords = trim($keywords);
                $keywords = explode(" ", $keywords);
                foreach ($keywords as $key => $value) {
                    if($value){
                        $this->hot_keywords_mdl->add_hot_keywords($customer_id,$value,2);
                        $keyword_array[] = $value;
                    }
                }
                $keyword_array = array_merge(array_unique($keyword_array));//搜索关键词去处重复
                $data['list'] = $this->tribe_mdl->tribe_search($keyword_array);//查询部落
                
            } else {//没有关键词
                $data['list'] = array();
            }
            
            $data["mymemories"] = $this->hot_keywords_mdl->Mymemories($customer_id,2,4);//查询我的搜索记录
            
            $data['head_set'] = 2;
            $data['foot_icon'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/tribe_search", $data);
            $this->load->view('foot');
            
        }
        
        // --------------------------------------------------------------------
        
        /**
         * 删除部落搜索记录
         */
        public function del_memories(){
            $customer_id = $this->session->userdata("user_id");//用户id
            if($customer_id){
                $this->load->model('hot_keywords_mdl');
                $row = $this->hot_keywords_mdl->del_memories($customer_id,2);
                if($row){
                    echo json_encode(array("status"=>1));//成功
                }
            }else{
                echo json_encode(array("status"=>2));//还没登录
            }
        }
        
        /**
         * 族员列表
         */
        public function Members_List( $id = 0, $label_id = '' )
        {
            
            // 预录入族员的的手机号码默认隐藏，show_mobile= 2 ，不显示
            // $show_mobile = 2;
            // $where = 'NOT_EXITS';
            // $res = $this->tribe_mdl->update_tribe_show_mobile_init($id,$show_mobile,$where);
            
            
            $customer_id = $this->session->userdata("user_id");//用户id
            $like['member_name'] = $this->input->get('search_index');
            //         $user_info = $id ? $this->tribe_mdl->credit_guarantee_info( $id, $customer_id ) : 0;//查询部落 真实数据
            $user_info = $id ? $this->tribe_mdl->load_members_list( $id, $customer_id,null,$type='manager' ) : 0;//查询部落
            //         echo $this->db->last_query();
            if( !$user_info )
            {
                echo ' <base href="'.THEMEURL.'" />
                        <meta name="viewport"
                        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                        <style>
                        .black_feds{
                            padding: 10px 0;
                            border-radius: 2px;
                            background: #696969;
                            color: #fff;
                            text-align: center;
                            display: none;
                            width: 70%;
                            margin: 0 15%;
                            position: fixed;
                            top: 150px;
                            font-size: 12px;
                        }
                        </style>
                        <span class="black_feds" style="z-index: 999;">51易货网</span>
                        <script type="text/javascript" src="js/jquery.min.js"></script>
                        <script>
                        function prompt(){
                            $(".black_feds").toggle();
                        }
                        $(".black_feds").text("您不是该部落成员，无法访问").show();
                        setTimeout("prompt();", 2000);
                        setTimeout(function(){
                        window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$id.'"
                        }, 2500);
                        </script>';
                exit;
            }
            $tribe_duties_list = $this->tribe_mdl->load_members_duties( $id,$like );
            
            // 使用类型
            $type = 'manager';
            
            $list = $this->tribe_mdl->load_members_list( $id,0,$like,$type);
            
            
            $tribe_duties_list = array_column($tribe_duties_list, NULL,'id');
            
            $i = 0;
            //处理数据
            foreach ( $list as $k=>$v )
            {
                
                if( isset( $tribe_duties_list[$v['tribe_role_id']]) )
                {
                    $tribe_duties_list[$v['tribe_role_id']]['list'][] = $v;
                    continue;
                }
                
                $i++;
                $tribe_duties_list[0]['list'][] = $v;
                
            }
            
            
            
            if( $i )
            {
                $tribe_duties_list[0]['id'] = 0;
                $tribe_duties_list[0]['total'] = $i;
                $tribe_duties_list[0]['role_name'] = '部落成员';
            }
            
            $data['label_id'] = $label_id;
            $data['my_info'] = $user_info;
            $data['list'] = $tribe_duties_list;
            $data['tribe_id'] = $id;
            
            // echo '<pre>';
            // print_r($data['list']);
            //退出部落处理
            
            $tribe_owner = false;
            $tribe_detail = $this->tribe_mdl->get_MyTribe($customer_id,$id);
            if($tribe_detail){
                $tribe_owner = true;
            }
            
            // // 查询部落角色
            // $manager_role = $this->tribe_mdl->get_Tribe_Manager($customer_id,$id);
            // $data['manager_role'] = $manager_role;
            
            $member_count = count($list);
            $data['member_count'] = $member_count;
            $data['tribe_owner'] = $tribe_owner;
            
            
            $data['head_set'] = 2;
            $data['foot_icon'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/tribe_people", $data);
            $this->load->view('foot');
        }
        
        
        /**
         * 当部落仅为一人时退出部落则变成解散部落
         * 当部落拥有者退出 则必须先把拥有者权限转出
         * 正常情况下最开始的出现一个人或最后剩下的一个人都是拥有者
         * 所以只有部落的拥有者才能有这个权限
         */
        public function del_tribe(){
            $tribe_id = $this->input->get_post("tribe_id");
            $customer_id = $this->session->userdata("user_id");//用户id
            
            $tribe_detail = $this->tribe_mdl->get_tribe($tribe_id);
            $return = array(
                'Type'=>0,
                'Msg'=>'部落不存在',
            );
            
            $member_list = $this->tribe_mdl->load_members_list( $tribe_id);//部落成员人数
            $member_count = count($member_list);
            
            if($tribe_detail){
                $return = array(
                    'Type'=>1,
                    'Msg'=>'非法操作',
                );
                if($customer_id != $tribe_detail['customer_id']){
                    echo json_encode($return);exit;
                }elseif ($member_count > 1){
                    echo json_encode($return);exit;
                }
            }else{
                echo json_encode($return);exit;
            }
            $aff = $this->tribe_mdl->del_tribe($tribe_id);
            $staff_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$customer_id,0);
            $row = $this->tribe_mdl->del_staff($staff_info['id']);
            
            
            $return = array(
                'Type'=>2,
                'Msg'=>'操作失败',
            );
            if($aff){
                $this->HuanXinGroupHandle($tribe_id,$customer_id,'delete');
                $return = array(
                    'Type'=>3,
                    'Msg'=>'解散部落成功',
                );
            }
            echo json_encode($return);
            
        }
        
        /**
         * 环信即时通讯 部落聊天室退出及添加成员  默认添加聊天室成员
         *
         */
        private function HuanXinGroupHandle($tribe_id = 0,$customer_id = 0,$type = "join"){
            //删除聊天室成员
            include_once FCPATH.'application/libraries/Easemob.php';
            $parm['client_id'] = 'YXA60WhJsAsdEeiqD-e_-6s4uw';
            $parm['client_secret'] = 'YXA6T3McYmkmiIB5cM8pJBhF3JHXVBc';
            $parm['org_name'] = '1162180206115305';
            $parm['app_name'] = '51web';
            $h = new Easemob($parm);
            
            $this->load->model('Chat_message_mdl','chat');
            $Channel = $this->chat->loadChannelById(0,$tribe_id);
            
            if($Channel){
                if($type == 'delete'){
                    //删除群组
                    $h->deleteGroup($Channel['huanxin_group_id']);
                    return;
                }
                //--------------------------
                $Channel_id = $Channel['id'];
                $member = $this->chat->getChannelMember($Channel_id,$customer_id);
                if($type == 'join'){//添加聊天室成员
                    if($member){
                    }else{
                        $this->chat->addChannelMember($Channel_id,$Channel['huanxin_group_id'],$customer_id);//本地服务器添加
                        //判断当前用户是否在环信聊天室
                        $huanxin_member_info =  $h->getGroupUsers($Channel['huanxin_group_id']);
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
                        if(!$huanxin_GroupMember || !in_array($customer_id, $huanxin_GroupMember)){
                            $h->addGroupMember($Channel['huanxin_group_id'],$customer_id);
                        }
                    }
                }else{//删除聊天室成员
                    
                    if($member){
                        //删除聊天室成员
                        $aff =  $this->chat->delChannelMember($member['id']);
                        $h->deleteGroupMember($Channel['huanxin_group_id'],$customer_id);
                    }
                }
            }
        }
        
        
        
        
        /**
         * 退出部落
         * 删除成员记录
         */
        public function  quit_tribe(){
            $tribe_id = $this->input->get_post("tribe_id");
            $customer_id = $this->session->userdata("user_id");//用户id
            
            $tribe_detail = $this->tribe_mdl->get_tribe($tribe_id);
            $return = array(
                'Type'=>0,
                'Msg'=>'部落不存在',
            );
            
            if(!$tribe_detail){
                echo json_encode($return);exit;
            }
            $staff_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$customer_id,0);
            if(!$staff_info){
                $return = array(
                    'Type'=>1,
                    'Msg'=>'非法访问',
                );
                echo json_encode($return);exit;
            }
            
            $this->db->trans_begin(); // 事物执行方法中的MODEL。
            $is_ok  = true;
            $tribe_manager = $this->tribe_mdl->get_MyTribe($customer_id,$tribe_id);
            
            if($tribe_manager){//如果是创建者退出部落则先把义工委权限给其它管理员
                $is_Manager = 1;//是否管理员
                $number = 1;//记录条数
                $Manager = $this->tribe_mdl->get_ManagerList($tribe_id,$is_Manager,$number);//管理员
                
                $Manager_customer_id = 0;//需要转移义工委权限的ID
                if($Manager){
                    $Manager_customer_id = $Manager[0]['customer_id'];
                }else {
                    $is_Manager = 0;
                    $Member = $this->tribe_mdl->get_ManagerList($tribe_id,$is_Manager,$number);//部落成员
                    if($Member){
                        $Manager_customer_id = $Member[0]['customer_id'];
                    }
                }
                
                if(!$Manager_customer_id){
                    $return = array(
                        'Type'=>4,
                        'Msg'=>'操作失败',
                    );
                    $is_ok = false;
                    echo json_encode($return);
                }
                
                //转移义工委权限
                $rows = $this->tribe_mdl->set_host($tribe_id,$Manager_customer_id);
                if(!$rows){
                    $is_ok = false;
                    $return = array(
                        'Type'=>5,
                        'Msg'=>'操作失败',
                    );
                    echo json_encode($return);
                }
            }
            
            $return = array(
                'Type'=>2,
                'Msg'=>'退出成功',
            );
            $aff = $this->tribe_mdl->del_staff($staff_info['id']);
            
            if(!$aff){
                $return = array(
                    'Type'=>3,
                    'Msg'=>'操作失败',
                );
                $is_ok = false;
            }
            if(!$is_ok){
                $this->db->trans_rollback();
            }else{
                $this->db->trans_commit();
                //退出部落群聊
                $this->HuanXinGroupHandle($tribe_id,$customer_id,'exit');
            }
            echo json_encode($return);
        }
        
        
        
        /**
         * 族员详情
         */
        public function Members_Info( $tribe_id = 0 ,$tribe_staff_id = 0 )
        {
            
            $customer_id = $this->session->userdata("user_id");//用户id
            $tribe_info = $tribe_id ? $this->tribe_mdl->load($tribe_id,$customer_id) : 0;//查询部落
            
            if( !$tribe_info ){
                
                echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
                
            }else if ( !$tribe_info['tribe_staff_id'] || $tribe_info['status'] != 2 )
            {
                
                echo ' <base href="'.THEMEURL.'" />
                        <meta name="viewport"
                        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                        <style>
                        .black_feds{
                            padding: 10px 0;
                            border-radius: 2px;
                            background: #696969;
                            color: #fff;
                            text-align: center;
                            display: none;
                            width: 70%;
                            margin: 0 15%;
                            position: fixed;
                            top: 150px;
                            font-size: 12px;
                        }
                        </style>
                        <span class="black_feds" style="z-index: 999;">51易货网</span>
                        <script type="text/javascript" src="js/jquery.min.js"></script>
                        <script>
                        function prompt(){
                            $(".black_feds").toggle();
                        }
                        $(".black_feds").text("您不是该部落成员，无法访问").show();
                        setTimeout("prompt();", 2000);
                        setTimeout(function(){
                        window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$tribe_id.'"
                        }, 2500);
                        </script>';
                exit;
                
            }
            
            $data['user_info'] = $this->tribe_mdl->load_tribe_staff( $tribe_id, $tribe_staff_id );
            
            $data['tribe_id'] = $tribe_id;
            $data['head_set'] = 2;
            $data['foot_icon'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/tribe_clan_details", $data);
            $this->load->view('foot');
        }
        
        /**
         *
         */
        public  function Invite_Code($tribe_id=0){
            $customer_id = $this->session->userdata("user_id");//用户id
            if(!$tribe_id || !$customer_id){
                redirect("Tribe");
            }
            //邀请人
            $from_info = $this->tribe_mdl->load($tribe_id,$customer_id);
            if(!$from_info){
                redirect("Tribe");
            }
            $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);
            
            $authority = 0;
            if($tribe){
                $authority = 1;
            }
            $data['authority'] = $authority;
            $data['tribe_id'] = $tribe_id;
            $data['customer_id'] = $customer_id;
            $data['head_set'] = 2;
            $data['foot_icon'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view("tribe/invite_code", $data);
            $this->load->view('foot');
        }
        
        
        /**
         * 异步生成部落邀请二维码
         */
        public function Create_Invite_Code(){
            $tribe_id = $this->input->get_post('tribe_id');
            $customer_id = $this->session->userdata("user_id");//用户id
            
            $tribe = $this->tribe_mdl->load($tribe_id,$customer_id);
            if(!$tribe){
                $return = array(
                    "Status"=>3,
                    'Msg' =>'您不是该部落成员无法邀请'
                );
                echo json_encode($return);
                exit;
            }
            
            $this->load->helper("message");
            $param['customer_id'] = $customer_id;
            $param['resource'] = "Login/code_login/$tribe_id?in_id=$customer_id&in_tp=code";
            $req = json_decode(ToConect($param,'_BUSINESS','n',2),true);
            if(!empty($req['key'])){
                $this->load->model("Conect_mdl");
                $this->Conect_mdl->Del_CodeLink($req['key']);
            }
            $return['url_short'] =$req['url_short'];
            echo json_encode($return);
        }
        
        
        /**
         * 邀请说明页面
         * @param text $type - 邀请类型 value=Customer 加入部落 Corp = 加入企业
         * @param number $tribe_id - 部落ID
         * @param number $tribe_staff - 成员表ID
         * @param number $status = NULL OR 0 短信邀请  1：微信分享邀请
         */
        public function Invite_View( $type, $tribe_id = 0, $tribe_staff = 0,$status = 0 )
        {
            
            
            $view = array('Customer','Corp');
            
            // if($type == 'Customer'){
            //     //查询受邀请人信息
            //     $to_info = $this->tribe_mdl->load_tribe_staff( $tribe_id,$tribe_staff );
            //     // // 邀请加入部落,提示信息归0
            // 先检测是否有这个纪录
            // $res = $this->tribe_mdl->load_tribe_tips($to_info['mobile']);
            // if($res ){
            //   $this->tribe_mdl->update_tips(0,$to_info['mobile'],'reset');
            // }
            // }
            
            if( !$status )
            {
                if( !in_array( $type, $view ) || !$tribe_id || !$tribe_staff )
                {
                    //参数错误
                    echo "<script>history.back(-1);alert('参数错误');</script>";exit;
                    
                }
            }else{
                
                if( !in_array( $type, $view ) || !$tribe_id )
                {
                    //参数错误
                    echo "<script>history.back(-1);alert('参数错误');</script>";exit;
                    
                }
                if( $tribe_staff )
                {
                    //3天内只能对一个人邀请一次。
                    setcookie('invite_wx_'.$type.'_'.$tribe_staff,true, time()+3600*24*3,'/');
                }
                
            }
            //邀请人信息
            $user_id = $this->session->userdata("user_id");//用户id
            $invite_info = $this->tribe_mdl->load($tribe_id,$user_id);//查询部落
            $invite_info['from_customer_id'] = $user_id;
            
            $this->load->model('customer_mdl');
            $Cus_info = $this->customer_mdl->load($user_id);
            $data['real_name'] = $Cus_info['real_name'];
            $data['invite_info'] = $invite_info;
            $data['invite_status'] = $status;
            $data['type'] = $type;
            $data['tribe_id'] = $tribe_id;
            $data['tribe_staff'] = $tribe_staff;
            $data['head_set'] = 2;
            $data['foot_icon'] = 1;
            $this->load->view('head', $data);
            //         $this->load->view('_header', $data);
            $this->load->view("tribe/tribe_approve", $data);
            $this->load->view('foot');
            
            
}


/**
 * 部落邀请加入企业或者加入部落方法。（发送短信）
 */
public function Invite()
{
    
    $type = $this->input->post('type'); //邀请类型 value=Customer 加入部落 Corp = 加入企业
    $tribe_id = $this->input->post('tribe_id'); //部落ID
    $tribe_staff = $this->input->post('tribe_staff'); //成员表ID
    
    $from_customer_id = $this->session->userdata("user_id");//用户id
    $return['message'] = '邀请失败';
    $return['status'] = 0;
    
    
    if( $type && $tribe_id && $tribe_staff )
    {
        if( empty( $_COOKIE['invite_dx_'.$type.'_'.$tribe_staff]) )
        {
            //邀请人
            $from_info = $this->tribe_mdl->load($tribe_id,$from_customer_id);
            
            if( !empty($from_info['tribe_staff_id'])  ){
                
                //查询受邀请人信息
                $to_info = $this->tribe_mdl->load_tribe_staff( $tribe_id,$tribe_staff );
                
                if( !empty( $to_info ) )
                {
                    if( !empty($to_info['mobile']) )
                    {
                        $mobile = $to_info['mobile'];
                        $real_name = $from_info['real_name'] ? $from_info['real_name']:$from_info['mobile'];
                        $corp_name = $from_info['real_corp_name'] ? $from_info['real_corp_name']:'';
                        
                        //转化短连接
                        $this->load->helper("message");
                        if( $type == 'Corp')
                        {
                            //配置长连接
                            //                                $url_long = site_url('Navigation/cooperate_nav');
                            //                                $req = json_decode(  Message_LongToShort_result($url_long),true)[0];
                            $param['customer_id'] = $from_customer_id;
                            $param['resource'] = 'Navigation/cooperate_nav';
                            $req = json_decode(  ToConect($param),true);
                            $content = "尊敬的{$to_info['member_name']}，{$real_name}诚邀请您进行企业认证，尊享更多专属特权，让易货更有保证。点击进入：".$req['url_short']." 退订回N【51易货网】";
                            //                                $content = "尊敬的{$to_info['member_name']}，{$corp_name}{$real_name}诚意邀请您进行企业认证，尊享更多专属特权，让更多的企业家们认识您企业的品牌和产品！".$req['url_short']." 退订回N【51易货网】";
                        }else{
                            //配置长连接
                            //                              $url_long = "http://www.51ehw.com/index.php/_BUSINESS/Login/code_login/".$tribe_id."?in_id=".$from_customer_id;
                            //                              $req = json_decode(  Message_LongToShort_result($url_long),true)[0];
                            
                            
                            // // 邀请加入部落,提示信息归0
                            // $this->tribe_mdl->update_tips(0,$to_info['mobile'],'reset');
                            // // 先检测是否有这个纪录
                            // $res = $this->tribe_mdl->load_tribe_tips($to_info['mobile']);
                            // if($res ){
                            //     $this->tribe_mdl->update_tips(0,$to_info['mobile'],'reset');
                            // }
                            
                            $param['customer_id'] = $from_customer_id;
                            $param['resource'] = "Login/code_login/".$tribe_id."?in_id=".$from_customer_id;
                            $req = json_decode(  ToConect($param),true);
                            $content = "hi~{$to_info['member_name']}，这是您认识的{$real_name}。点击进入：".$req['url_short']." 退订回N【51易货网】";
                            //                              $content = "尊敬的{$to_info['member_name']}，{$corp_name}{$real_name}诚意邀请您加入{$to_info['name']}，充分展示您的个人形象和企业风采，与业内精英互动交流，还有更多专属特权等着您，快快来参加吧。".$req['url_short']." 退订回N【51易货网】";
                        }
                        
                        //发送短信
                        $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
                        $sms = send_message($mobile,0,$content,2,$source);
                        $sms = json_decode($sms,true);
                        if( $sms["returnstatus"] == "00" )
                        {
                            //3天内只能对一个人邀请一次。
                            setcookie('invite_dx_'.$this->input->post('type').'_'.$to_info['id'],1, time()+3600*24*3,'/');
                            $return['status'] = 1;
                            $return['message'] = '您的邀请已以短信发送给对方';
                        }else{
                            $return['status'] = 4;
                            $return['message'] = '短信发送失败';
                        }
                        
                    }else{
                        
                        //未知受邀请人手机号码无法邀请
                        $return['status'] = 2;
                        $return['message'] = '未知受邀请人手机号码无法邀请';
                    }
                }else{
                    
                    //受邀人不是该部落成员
                    $return['status'] = 3;
                    $return['message'] = '受邀人不是该部落成员';
                }
            }else{
                
                //您不是该部落成员无法邀请
                $return['status'] = 4;
                $return['message'] = '您不是该部落成员无法邀请';
            }
        }else{
            
            $return['status'] = 5;
            $return['message'] = '3天内不可重复邀请';
        }
    }
    
    echo json_encode($return);
}

public function My_Info( $tribe_id = 0,$customer_id = 0 )
{
    
    $customer_id = $this->session->userdata("user_id");//用户id
    
    if( $tribe_id  && is_numeric($tribe_id) && is_int($tribe_id+0) && !(0==$customer_id)  )
    {
        $user_info = $tribe_id ? $this->tribe_mdl->credit_guarantee_info( $tribe_id, $customer_id ) : 0;//查询部落
        
        if( !$user_info )
        {
            echo ' <base href="'.THEMEURL.'" />
                        <meta name="viewport"
                        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                        <style>
                        .black_feds{
                            padding: 10px 0;
                            border-radius: 2px;
                            background: #696969;
                            color: #fff;
                            text-align: center;
                            display: none;
                            width: 70%;
                            margin: 0 15%;
                            position: fixed;
                            top: 150px;
                            font-size: 12px;
                        }
                        </style>
                        <span class="black_feds" style="z-index: 999;">51易货网</span>
                        <script type="text/javascript" src="js/jquery.min.js"></script>
                        <script>
                        function prompt(){
                            $(".black_feds").toggle();
                        }
                        $(".black_feds").text("您不是该部落成员，无法访问").show();
                        setTimeout("prompt();", 2000);
                        setTimeout(function(){
                        window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$tribe_id.'"
                        }, 2500);
                        </script>';
            exit;
        }
        
        $data['tribe_id'] = $tribe_id;
        $data['user_info'] = $user_info;
        $data['head_set'] = 2;
        $data['foot_icon'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view("tribe/tribe_details", $data);
        $mac_type = $this->session->userdata("mac_type");
        if(!$mac_type){
            $this->load->view('foot');
        }
        
        
    }else {
        
        echo "<script>history.back(-1);alert('参数错误');</script>";exit;
    }
}

public function Description( $type = 'Guarantee' )
{
    $message = $type == 'Guarantee' ? '担保说明' : '易呗说明';
    $data['type'] = $type;
    $data['title'] = $message;
    $data['head_set'] = 2;
    $data['foot_icon'] = 1;
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_detail_explain', $data);
    $this->load->view('foot', $data);
}


//部落banner
public function tirbe_banner_detail(){
    
    $data['title'] = "互助部落资源共享";
    $data ['head_set'] = 2;
    $data ['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tirbe_banner_detail', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
}



/**
 * 推荐部落
 */
public function recommended_tribe()
{
    $customer_id = $this->session->userdata("user_id");//用户id
    $data["hot_list"] = $this->tribe_mdl->hot_tribe( $customer_id );//查询推介部落
    
    $data['title'] = "推荐部落";
    $data ['head_set'] = 2;
    $data ['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_recommended', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
}

/**
 * 部落公告
 */
public function announcement( $trib_id = 0 )
{
    $customer_id = $this->session->userdata("user_id");//用户id
    
    
    $this->load->model('Tribe_content_mdl');
    
    if( $trib_id )
    {
        //查询公告
        $sift['where']['customer_id'] = $customer_id;
        $sift['where']['tribe_id'] = $trib_id;
        $sift['sql_status'] = $trib_id ? true : false;
        $data['announcement_list'] = $this->Tribe_content_mdl->Load_List( $sift );
        
    }else {
        
        $announcement_sift['where']['customer_id'] = $customer_id;
        $announcement_sift['sql_status'] = 'result_array';
        $data['announcement_list'] = $this->Tribe_content_mdl->Load_new_content( $announcement_sift );
        
    }
    
    
    $data['title'] = "部落公告";
    $data['head_set'] = 2;
    $data['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_proclamation', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
    
}
/**
 * 某个部落的主页
 * $back = 1; 右上角Home的ICON 标识转跳 商会主页。
 */

public function home( $id, $label_id = '' )
{
    
    //         echo base_url();
    //         echo '<pre>';
    //         var_dump( $_SERVER );
    //         exit();
    
    //部落信息
    $customer_id = $this->session->userdata("user_id");//用户id
    $appid = $this->session->userdata("app_info")['id'];
    $data["tribe"] = $this->tribe_mdl->load( $id,$customer_id );//查询部落
    
    $this->load->model("customer_mdl");
    $info = $this->customer_mdl->load($customer_id);
    
    $data['real_name'] = empty($info['real_name']) ? true:false;
    //判断部落是否存在
    if($data["tribe"]){
        
        
        
        //判断是否已经加入此部落
        if($data["tribe"]["tribe_staff_id"] && $data["tribe"]["status"]==2)
        {
            $sort_info = $this->tribe_mdl->load_tribe_sort($customer_id,$id);
            if(!$sort_info){
                $this->tribe_mdl->add_tribe_sort($customer_id,$id);
            }
            //更新用户最新浏览部落时间
            $this->tribe_mdl->record_tribe_time($customer_id,$id);
            
            $data["tribe"]['bg_img'] =  explode(';',$data["tribe"]['bg_img']);
            $data["tribe"]['bg_img'] = array_filter($data["tribe"]['bg_img']);
            
            //部落内的公告
            $sift['where']['customer_id'] = $customer_id;
            $sift['where']['tribe_id'] = $id;
            $sift['sql_status'] = true;
            
            //部落活动
            $this->load->model('Tribe_activity_mdl');
            $data['activities_list'] = $this->Tribe_activity_mdl->Load( $sift );
            
            $this->load->model('Tribe_content_mdl');
            $data["is_manage"] = $data["tribe"]["is_host"]?true:($data["tribe"]["tribe_manager_id"] > 0);//是否部落管理者
            $data['announcement_list'] = $this->Tribe_content_mdl->Load_List( $sift );
            $data['label_id'] = $label_id;
            $data['tribe_id'] = $id;
            $data['title'] = $data["tribe"]['name'];
            $data ['head_set'] = 2;
            $data ['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('tribe/tribe_home', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
            
            
        }else{//未加入
            redirect("tribe/tribe_detail/$id/$label_id");
        }
        
    }else{
        echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
    }
    
    
}
/**
 * 公告详情
 * @param number $id 公告id
 * @param number $trib_id 部落id
 * @param number $flag 识别是否预览
 *
 */
public function announcement_detaile( $id = 0, $trib_id = 0, $flag = 0)
{
    if($flag){
        $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    }else{
        $customer_id = $this->session->userdata("user_id");//用户id
    }
    $this->load->model('Tribe_content_mdl');
    $this->load->model('Tribe_read_mdl');
    //查询公告
    $sift['where']['customer_id'] = $customer_id;
    $sift['where']['tribe_id'] = $trib_id;
    $sift['where']['id'] = 0 == $id ? 0 : $id;
    $sift['where']['status'] = $flag ? array(0,1,2) : 0;
    if( $flag )
    {
        $info = $this->Tribe_content_mdl->Load( $sift );
        
    }else{
        
        
        $info = $this->Tribe_content_mdl->Load_new_content( $sift );
        
    }
    
    
    if(!$info){
        echo ' <base href="'.THEMEURL.'" />
                        <meta name="viewport"
                        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                        <style>
                        .black_feds{
                            padding: 10px 0;
                            border-radius: 2px;
                            background: #696969;
                            color: #fff;
                            text-align: center;
                            display: none;
                            width: 70%;
                            margin: 0 15%;
                            position: fixed;
                            top: 150px;
                            font-size: 12px;
                        }
                        </style>
                        <span class="black_feds" style="z-index: 999;">51易货网</span>
                        <script type="text/javascript" src="js/jquery.min.js"></script>
                        <script>
                        function prompt(){
                            $(".black_feds").toggle();
                        }
                        $(".black_feds").text("您尚未加入该部落或申请还在审核中，无法查看该部落中的公告").show();
                        setTimeout("prompt();", 2000);
                        setTimeout(function(){
                        window.location.href = "'.site_url("Tribe/tribe_detail").'/'.$trib_id.'"
                        }, 2500);
                        </script>';
        exit;
        
    }
    
    //查询判断是否已经阅读，如果无则添加
    $row = $this->Tribe_read_mdl->check_read($customer_id,$id,1);
    if(!$row && $info["status"] == 1){
        $parameter = array(
            "customer_id" => $customer_id,
            "type" => 1,
            "obj_id" => $id,
            "tribe_id" => $trib_id
        );
        $this->Tribe_read_mdl->create($parameter);
    }
    
    $data['info'] = $info;//部落信息
    $data['title'] = "公告详情";
    $data ['head_set'] = 2;
    $data ['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('tribe/announcement_detaile', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
}

/**
 * 活动列表
 */
public function activity_list( $label_id = 0 )
{
    $type = $this->input->get('type');
    $this->load->model('Tribe_activity_mdl');
    $customer_id = $this->session->userdata("user_id");//用户id
    $sift['where']['customer_id'] = $customer_id;
    $list = array();
    
    if( $label_id )
    {
        $app_tribe_ids = $this->get_app_tribe_ids($label_id);
        $sift['where']['tribe_id'] = $app_tribe_ids;
        $sift['sql_status'] = true;
        
        if( count($app_tribe_ids) > 0 )
        {
            if( $type )
            {
                //投票活动、
                $this->load->model('Vote_mdl');
                $sift['where']['tribe_id'] = $app_tribe_ids;
                $list = $this->Vote_mdl->Load($sift);
                
            }else{
                //普通活动
                
                $this->load->model('Tribe_read_mdl');
                $list = $this->Tribe_activity_mdl->Load( $sift );
                foreach ($list as $k => $v){
                    //查询判断是否已经阅读，如果无则添加
                    $row = $this->Tribe_read_mdl->check_read($customer_id,$v['id'],2);
                    if(!$row ){
                        $parameter = array(
                            "customer_id" => $customer_id,
                            "type" => 2,
                            "obj_id" => $v['id'],
                            "tribe_id" => $v['tribe_id']
                        );
                        $this->Tribe_read_mdl->create($parameter);
                    }
                }
            }
        }
        
    }else{
        
        if( !$type )
        {
            //查询我加入过的部落的活动。
            $sift['where']['customer_id'] = $customer_id;
            $sift['sql_status'] = 'result_array';
            $sift['type'] = 0;
            $list = $this->Tribe_activity_mdl->Load_new_activity( $sift );
            
        }else{
            
            //查询我加入过的部落
            $tribe_ids = array_column($this->tribe_mdl->Customer_Tribe_List( $customer_id ),'id');
            //投票活动、
            $this->load->model('Vote_mdl');
            $sift['where']['tribe_id'] = $tribe_ids;
            $list = $this->Vote_mdl->Load($sift);
        }
    }
    
    
    $data['type'] = $type;
    $data['label_id'] = $label_id;
    $data['list'] = $list;
    $data['title'] = "活动列表";
    $data ['head_set'] = 2;
    $data ['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_activity_list', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
}

//获取商会下所有的部落ID
private  function get_app_tribe_ids($label_id){
    $this->load->model("App_label_mdl");
    //将二级标签下部落全部拿出来堆放在一起方便进行处理
    $label_infos = $this->App_label_mdl->Load_tribe_app_label($label_id);//获取标签信息
    $app_tribe_id = '';
    foreach ($label_infos as $key =>$val ){
        $app_tribe_id = trim($app_tribe_id,",");
        $app_tribe_id .= ','.$val['tribe_ids'];
    }
    $ids = explode(',',$app_tribe_id);//字符串转数组
    $app_tribe_ids = array_unique($ids);
    $this->load->model("tribe_mdl");
    $info = $this->tribe_mdl->identical_tribe($app_tribe_ids);
    $app_tribe_ids = array();
    foreach ($info as $k =>$v){
        $app_tribe_ids[] = $v['id'];
    }
    return $app_tribe_ids;
}

/**
 *
 * @param number $id
 * @param number $tribe_id
 * 活动详情
 */
public function activity_detaile( $id = 0 )
{
    $customer_id = $this->session->userdata("user_id");//用户id
    $tribe_masterid = $this->session->userdata("tribe_masterid");//部落管理员
    
    $sift['where']['id'] = 0 == $id ? 0 : $id;
    $sift['where']['customer_id'] = $customer_id;
    // $sift['is_host'] = ($customer_id==$tribe_masterid);
    $sift['is_host'] = true;
    $this->load->model('Tribe_activity_mdl');
    $activity_info = $this->Tribe_activity_mdl->Load_new_activity( $sift );
    
    $title = '活动详情';
    switch($activity_info['type'])
    {
        case 0:
            break;
        case 1:
            $title = '政策法规';
            break;
        case 2:
            $title = '行业动态';
            break;
    }
    
    $data['title'] = $title;
    
    $data ['head_set'] = 2;
    $data ['foot_set'] = 1;
    $this->load->view('head', $data);
    //         $this->load->view('_header', $data);
    //验证活动是否存在
    if(!$activity_info){
        echo ' <base href="'.THEMEURL.'" />
                        <meta name="viewport"
                        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
                        <style>
                        .black_feds{
                            padding: 10px 0;
                            border-radius: 2px;
                            background: #696969;
                            color: #fff;
                            text-align: center;
                            display: none;
                            width: 70%;
                            margin: 0 15%;
                            position: fixed;
                            top: 150px;
                            font-size: 12px;
                        }
                        </style>
                        <span class="black_feds" style="z-index: 999;">51易货网</span>
                        <script type="text/javascript" src="js/jquery.min.js"></script>
                        <script>
                        function prompt(){
                            $(".black_feds").toggle();
                        }
                        $(".black_feds").text("活动不存在，或您无权查看该部落活动").show();
                        setTimeout("prompt();", 2000);
                        setTimeout(function(){
                        window.location.href = "'.site_url("Home").'"
                        }, 2500);
                        </script>';
        exit;
        
    }
    $data['tribe_id'] = $activity_info['tribe_id'];
    $data['activity_info'] = $activity_info;
    
    $this->load->view('tribe/tribe_activities_detail', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
    
}



/**
 * 活动报名
 */
public function activity_signup($id = 0)
{
    
    $customer_id = $this->session->userdata("user_id");//用户id
    
    //查看活动是否存在 && 是否报名
    $sift['where']['customer_id'] = $customer_id;
    $sift['where']['id'] = 0 == $id ? 0 : $id;
    $this->load->model('Tribe_activity_mdl');
    $activity_info = $this->Tribe_activity_mdl->Load_Activity( $sift );
    
    
    if( $activity_info )
    {
        if( !$activity_info['register'] )
        {
            $ts_info = true;
            
            if( $activity_info["start_time"] < date("Y-m-d H:i:s") )
            {
                if( $activity_info["end_time"] > date("Y-m-d H:i:s") )
                {
                    
                    if( $activity_info['tribe_id'] != -1 )
                    {
                        //查询是否有资格参加
                        $this->load->model('Tribe_mdl');
                        $ts_info = $this->Tribe_mdl->verify_tribe_customer( $activity_info['tribe_id'], $customer_id );
                        
                    }
                    
                    //执行
                    if( $ts_info )
                    {
                        $data['activity_id'] = $id;
                        $data['customer_id'] = $customer_id;
                        $row = $this->Tribe_activity_mdl->Add_Activity_Staff( $data );
                        
                        $return['message'] = '报名成功';
                        $return['status'] = 1;
                        
                        
                        $message_data['template_id'] = 9;//通知的模板Id;
                        $message_data['customer_id'] = $customer_id;
                        $message_data['obj_id'] = $activity_info['tribe_id'];
                        $message_data['type'] = 4;//部落类型;
                        $message_data['parameter']['time'] = $activity_info['start_time'];
                        $message_data['parameter']['name'] = $activity_info['name'];
                        $this->load->model('Customer_message_mdl');
                        $this->Customer_message_mdl->Create_Message( $message_data );
                        
                        
                    }else{
                        //无资格参加
                        $return['message'] = '你不是该部落成员，无法报名';
                        $return['status'] = 2;
                    }
                    
                }else{
                    //已结束
                    $return['message'] = '活动已结束';
                    $return['status'] = 6;
                    
                }
            }else{
                //未开始
                $return['message'] = '活动未开始';
                $return['status'] = 5;
                
            }
        }else{
            //已经注册
            $return['status'] = 3;
            $return['message'] = '已报名成功，请勿重复报名';
        }
        
    }else{
        //活动不存在
        $return['status'] = 4;
        $return['message'] = '该活动不存在';
    }
    
    echo json_encode($return);
    
}



/**
 * 部落活动报名--临时使用
 */
public function activity_signup_tribe($id = 0)
{
    
    $customer_id = $this->session->userdata("user_id");//用户id
    
    //查看活动是否存在 && 是否报名
    $sift['where']['customer_id'] = $customer_id;
    $sift['where']['id'] = 0 == $id ? 0 : $id;
    $this->load->model('Tribe_activity_mdl');
    $activity_info = $this->Tribe_activity_mdl->Load_Activity( $sift );
    
    
    if( $activity_info )
    {
        $tribe_info = $this->tribe_mdl->get_MyTribe( $customer_id );
        
        if( !$tribe_info )
        {
            if( !$activity_info['register'] )
            {
                
                if( $activity_info["start_time"] < date("Y-m-d H:i:s") )
                {
                    if( $activity_info["end_time"] > date("Y-m-d H:i:s") )
                    {
                        
                        $data['activity_id'] = $id;
                        $data['customer_id'] = $customer_id;
                        $row = $this->Tribe_activity_mdl->Add_Activity_Staff( $data );
                        
                        if( $row )
                        {
                            $return['message'] = '您的消息我们已经收到,稍后我们的客服人员会与您取得联系。咨询电话400-0029-777';
                            $return['status'] = 1;
                        }
                    }else{
                        //已结束
                        $return['message'] = '申请已结束';
                        $return['status'] = 2;
                        
                    }
                }else{
                    //未开始
                    $return['message'] = '申请未开始';
                    $return['status'] = 3;
                    
                }
            }else{
                //已经申请过
                $return['status'] = 4;
                $return['message'] = '您的消息我们已经收到,稍后我们的客服人员会与您取得联系。咨询电话400-0029-777';
            }
        }else{
            //已经创建过部落
            $return['status'] = 5;
            $return['message'] = '每个人只能创建一个部落，您已创建了部落';
        }
    }else{
        //活动不存在
        $return['status'] = 6;
        $return['message'] = '该活动不存在';
    }
    
    echo json_encode($return);
    
}
// -----------------------管理员设置开始----------------------------
/**
 * 管理员设置
 */
public function adminList(){
    $this->load->model("Tribe_role_access_mdl","role_access");
    
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    $times = $this->input->get_post("times");
    $keyword = $this->input->get_post("keyword");
    
    
    if($keyword){
        $data['keyword'] = $keyword;
    }
    if($times){
        $data['times'] = $times;
    }
    $curr_page = $this->input->get_post("per_page");
    if(!$curr_page || $curr_page == 0){
        $curr_page = 1;
    }
    $pagesize = 10;
    
    // 分页设置
    $this->load->library('pagination');
    $config['base_url'] = site_url('Tribe/adminList/?');
    if($keyword || $times){
        $config['base_url'] = site_url("Tribe/adminList")."?keyword=$keyword&times=$times";
    }
    $config['total_rows'] = count($this->role_access->get_tribe_staff_access($tribe_id,$keyword,$times));
    $config['curr_page'] = $curr_page;
    $config['per_page'] = $pagesize;
    $config['curr_page'] = $curr_page;
    $config['use_page_numbers'] = TRUE;
    $config['page_query_string'] = TRUE;
    $config['num_links'] = 10;
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;
    $config['next_link'] = '下一页';
    $config['next_tag_css'] = 'class="lPage"';
    $config['prev_link'] = '上一页';
    $config['prev_tag_css'] = 'class="lPage"';
    $config['cur_tag_open'] = '&nbsp;<a href="javascript:" class="cpage">';
    $config['cur_tag_close'] = '</a>';
    $this->pagination->initialize($config);
    $data['pagination'] = $this->pagination->create_links();
    
    $data["totalcount"] = $config["total_rows"];
    $data["totalpage"] = ceil($config["total_rows"] / $pagesize);
    $data['pagesize'] = $pagesize;
    $data['page'] = $curr_page;
    
    $staff_list = $this->role_access->get_tribe_staff_access($tribe_id,$keyword,$times,$pagesize,($curr_page - 1) * $pagesize);
    $data['List'] = $staff_list;
    //         echo '<pre>';
    //         echo $this->db->last_query();exit;
    //         print_r( $data['List']);exit;
    $data['head_set'] = 3;
    $data['foot_set'] = 1;
    $data['title'] = '管理员设置';
    $data['nav_type'] = 'adminList';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribal_manager_set', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot');
}

/**
 * 管理员设置
 */
public function adminSet($id=0){
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    if($id){
        $staff_access = $this->role_access->check_staff_access($tribe_id,$id);
        if(!$staff_access){
            redirect("Tribe/adminList");
        }
        $data['staff_access'] =$staff_access;
    }
    
    $curr_page = $this->input->get_post("per_page");
    if(!$curr_page || $curr_page == 0){
        $curr_page = 1;
    }
    $pagesize = 15;
    
    $tribe_staff_list = $this->role_access->tribe_staff_list($tribe_id);
    $data['tribe_staff_list'] = $tribe_staff_list;
    //         echo '<pre>';
    //         print_r($tribe_staff_list);exit;
    $role_list = $this->role_access->get_tribe_role_access($tribe_id);
    $data['role_list'] = $role_list;
    
    $data['head_set'] = 3;
    $data['foot_set'] = 1;
    $data['title'] = '管理员权限设置';
    $data['nav_type'] = 'adminList';
    
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribal_add_manager', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot');
}

/**
 * 删除管理员
 */
public function del_admin(){
    $id = $this->input->get_post("id");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    
    $this->load->model("Tribe_role_access_mdl","role_access");
    $aff = $this->role_access->del_admin($tribe_id,$id);
    
    $return = array(
        "status"=>0,
        "Message"=>"删除成功"
    );
    if(!$aff){
        $return = array(
            "status"=>3,
            "Message"=>"删除失败"
        );
    }
    echo json_encode($return);
}


/**
 *
 * 保存管理员角色
 */
public function ajax_save_staff_role(){
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    
    $staff_id = $this->input->get_post("staff_id");
    $role_id = $this->input->get_post("role_id");
    $remark = $this->input->get_post("remark");
    
    $data['tribe_id'] = $tribe_id;
    $data['tribe_staff_id'] =$staff_id;
    $data['tribe_role_access_id'] =$role_id;
    $data['remark'] =$remark;
    
    $aff = $this->role_access->save_staff_role($data);
    
    $return = array(
        "status"=>3,
        "Message"=>"保存失败"
    );
    if($aff){
        $return = array(
            "status"=>0,
            "Message"=>"保存成功"
        );
    }
    echo json_encode($return);
}

/**
 * 更新管理员角色
 */
public function ajax_update_staff_role(){
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    
    $staff_id = $this->input->get_post("staff_id");
    $role_id = $this->input->get_post("role_id");
    $remark = $this->input->get_post("remark");
    
    $data['tribe_id'] = $tribe_id;
    $data['tribe_staff_id'] =$staff_id;
    $data['tribe_role_access_id'] =$role_id;
    $data['remark'] =$remark;
    
    $aff = $this->role_access->update_staff_role($data);
    
    $return = array(
        "status"=>3,
        "Message"=>"保存失败"
    );
    if($aff){
        $return = array(
            "status"=>0,
            "Message"=>"保存成功"
        );
    }
    echo json_encode($return);
}
/**
 * 管理员权限设置
 */
public function adminRoleSet($id = 0){
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    if($id){
        //检车角色名称是否重复
        $detail = $this->role_access->get_role_detail($tribe_id,0,false,$id);
        if(!$detail){
            //不存在角色权限
            redirect("Tribe/adminRoleList");
        }
        $data['detail'] =$detail;
    }
    
    $role = $this->role_access->get_role();
    
    $data['role'] = $role;
    $role_child = array();
    $child_num = 0;//循环子级数量
    foreach ($role as $key =>$val){
        $pid  = $val['id'];
        $role_child[$pid] = $this->role_access->get_role($pid);
        if(count($role_child[$pid]) > $child_num){
            $child_num = count($role_child[$pid]);
        }
    }
    $data['role_child'] = $role_child;
    $data['child_num'] = $child_num;
    
    //         echo '<pre>';
    //         print_r($data);exit;
    $data['head_set'] = 3;
    $data['foot_set'] = 1;
    $data['title'] = '管理员权限设置';
    $data['nav_type'] = 'adminRoleList';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribal_add_role', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot');
}

/**
 * 管理员权限列表
 */
public function adminRoleList(){
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    
    $role_list = $this->role_access->get_tribe_role_access($tribe_id);
    
    $data['role_list'] = $role_list;
    
    //         echo '<pre>';
    //         print_r($role_list);exit;
    $data['head_set'] = 3;
    $data['foot_set'] = 1;
    $data['title'] = '管理员列表';
    $data['nav_type'] = 'adminRoleList';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribal_role_permission', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot');
}

/**
 * 新建管理员角色权限
 */
public function ajax_save_role(){
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    $name = $this->input->get_post("name");
    $module_str = $this->input->get_post("module_str");
    
    //检车角色名称是否重复
    $detail = $this->role_access->get_role_detail($tribe_id,$name);
    if($detail){
        $return = array(
            "status"=>3,
            "Message"=>"已存在角色名称"
        );
        echo json_encode($return);exit;
    }
    $data['tribe_id'] = $tribe_id;
    $data['name'] = $name;
    $data['module_id'] = $module_str;
    $aff = $this->role_access->save_role($data);
    $return = array(
        "status"=>0,
        "Message"=>"保存成功"
    );
    if(!$aff){
        $return = array(
            "status"=>5,
            "Message"=>"保存失败"
        );
    }
    echo json_encode($return);
}

/**
 * 更新管理员权限
 */
public function ajax_update_role(){
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    $name = $this->input->get_post("name");
    $id = $this->input->get_post("id");
    $module_str = $this->input->get_post("module_str");
    //检车角色名称是否重复
    $detail = $this->role_access->get_role_detail($tribe_id,$name,true,$id);
    if($detail){
        $return = array(
            "status"=>3,
            "Message"=>"已存在角色名称"
        );
        echo json_encode($return);exit;
    }
    
    $data['tribe_id'] = $tribe_id;
    $data['id'] = $id;
    $data['name'] = $name;
    $data['module_id'] = $module_str;
    $aff = $this->role_access->update_role($data);
    
    
    $return = array(
        "status"=>0,
        "Message"=>"更新成功"
    );
    if(!$aff){
        $return = array(
            "status"=>5,
            "Message"=>"更新失败"
        );
    }
    echo json_encode($return);
    
}

/**
 * 删除 管理员权限
 */
public function ajax_del_role(){
    $id = $this->input->get_post("id");
    $this->load->model("Tribe_role_access_mdl","role_access");
    $tribe_id =  $this->session->userdata ( 'tribe_id' );
    
    $info  =  $this->role_access->get_role_staff_by_Role($tribe_id,$id);
    if(count($info) > 0 ){
        $return = array(
            "status"=>5,
            "Message"=>"删除失败,该角色权限正在使用中"
        );
        echo json_encode($return);exit;
    }
    
    $aff = $this->role_access->del_role($tribe_id,$id);
    
    $return = array(
        "status"=>0,
        "Message"=>"删除成功"
    );
    if(!$aff){
        $return = array(
            "status"=>3,
            "Message"=>"删除失败"
        );
    }
    echo json_encode($return);
}
// -----------------------管理员设置结束----------------------------

/**
 * 添加部落页面
 * @param number $id 部落id
 */
public function add_view($id = 0){
    $mobile = $this->session->userdata('mobile');//手机号码
    $customer_id = $this->session->userdata("user_id");//用户id
    
    $tribe = null;
    if($id){
        $tribe = $this->tribe_mdl->get_MyTribe($customer_id,$id);//查询部落信息
    }
    
    //判断是否绑定手机
    if(!$mobile){
        $this->session->set_userdata('redirect',site_url("tribe/add_view"));
        redirect("member/binding/binding_mobile");
    }
    $data["tribe"] = $tribe;
    $data["tribe_id"] = $id;
    $data ['head_set'] = 2;
    $data['title'] = '创建部落';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/add_tribe_view', $data);
}


/**
 * 部落
 */

public function manageTribe($tribe_id){
    $user_id = $this->session->userdata("user_id");
    
    
    //获取部落信息
    $data["tribe"] = $this->tribe_mdl->get_tribe($tribe_id);
    
    if(!$data["tribe"]){
        echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
    }else if($data["tribe"]['status'] !=2){
        echo "<script>history.back(-1);alert('部落不存在');</script>";exit;
    }
    
    $staff_info = $this->tribe_mdl->verify_tribe_customer($tribe_id,$user_id,0);
    if(!$staff_info){
        echo "<script>history.back(-1);alert('非法访问');</script>";exit;
    }
    if($staff_info['status'] != 2){
        echo "<script>history.back(-1);alert('非法访问');</script>";exit;
    }
    
    $member_list = $this->tribe_mdl->load_members_list( $tribe_id);//部落成员人数
    $member_count = count($member_list);
    
    $data["member_count"] =  $member_count;
    $data["tribe_id"] =  $data["tribe"]['id'];
    $data["staff_info"] = $staff_info;
    $data ['head_set'] = 2;
    $data['title'] = '部落设置';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_set', $data);
}




// ----------------------------------------------------------------------------------------

/**
 * 创建
 */
public function create(){
    $name = $this->input->post("name");//部落名称
    $content = $this->input->post("content");//简介
    $region = $this->input->post("region");//省份-城市
    $industry = $this->input->post("industry");//行业
    $datetime = date("Y-m-d H:i:s");
    $customer_id = $this->session->userdata("user_id");//用户id
    $corporation_id = $this->session->userdata("corporation_id");//企业id
    $customer_name = $this->session->userdata('customer_name');//真实姓名
    $corporation_name = $this->session->userdata('corporation_name');//企业名称
    $mobile = $this->session->userdata("mobile");//手机号码
    //判断是否绑定手机
    if(!$mobile){
        $this->add_view();exit;
    }
    
    //地址处理
    $region = explode("-",$region);
    if(count($region) == 2){
        $provice = $region[0];
        $city = $region[1];
    }else{
        $region = null;
    }
    
    
    if(mb_strlen($name) < 1 || mb_strlen($name) > 10 ||  !$region || !$industry || !array_key_exists("logo",$_FILES) ){
        redirect("tribe/add_view");exit;//参数错误
    }
    
    
    //查询名称是否存在
    $is_exists = $this->tribe_mdl->check_name($name);
    if($is_exists){
        redirect("tribe/add_view");exit;//部落已经存在
    }
    
    //循环上传图片
    $this->load->helper("uploads");
    $images = array();
    foreach ($_FILES as $k => $v){
        $images[$k] = file_upload("uploads/tribe/images/",null,null,$k);
        if(!$images){
            redirect("tribe/add_view");exit;//上传图片失败
        }
    }
    
    $this->db->trans_begin();//事务
    $parameter = array(
        "name" => $name,
        "content" => $content,
        "logo" => "uploads/tribe/images/".$images["logo"]["file_name"],
        "provice" => $provice,
        "city" => $city,
        "industry" => $industry,
        "created_at" => $datetime,
        "source" => ($this->isMobile()?2:1),
        "customer_id" => $customer_id
    );
    $tribe_id = $this->tribe_mdl->create($parameter);//添加部落
    if(!$tribe_id){
        $this->db->trans_rollback();
        redirect("tribe/add_view");exit;//创建部落失败
    }
    
    $parameter = array(
        "customer_id" => $customer_id,
        "grade" => ($corporation_id?2:1),
        "member_name" => $customer_name,
        "is_host" => 1,//义工委
        "corporation_name" => $corporation_name,
        "tribe_id" => $tribe_id,
        "provice" => $provice,
        "city" => $city,
        "mobile" => $mobile,
        "created_at" => $datetime,
        "industry" => $industry,
        "status" => 2,
        
    );
    
    $row = $this->tribe_mdl->add_staff($parameter);//添加成员
    if($row){
        $this->db->trans_commit();
        redirect("tribe/tribe_Inaudit/{$tribe_id}");exit;
    }else{
        $this->db->trans_rollback();
        redirect("tribe/add_view");exit;//创建部落失败
    }
}



// ----------------------------------------------------------------------------------------

/**
 * ajax检查部落名称
 */
public function ajax_check_name($tribe_id = 0){
    $customer_id = $this->session->userdata("user_id");//用户id
    $name = $this->input->post("name");//部落名称
    if(mb_strlen($name) < 1 || mb_strlen($name) > 10){
        $return = array(
            "status"=>1,
            "Message"=>"参数错误"
        );
        echo json_encode($return);exit;
    }
    
    $return = array(
        "status"=>2,
        "Message"=>"ok"
    );
    
    $tribe = $this->tribe_mdl->check_name($name);
    if($tribe ){
        if($tribe["customer_id"] != $customer_id || $tribe["id"] != $tribe_id){
            $return = array(
                "status"=>1,
                "Message"=>"部落已经存在"
            );
        }
    }
    
    
    echo json_encode($return);
}


// ----------------------------------------------------------------------------------------

/**
 * 管理部落
 * @param number $tribe_id 部落id
 */
public function managingtribes($tribe_id = 0){
    
    $customer_id = $this->session->userdata("user_id");//用户id
    if($tribe_id){
        if(ISMOBILE == "pc"){//如果是pc端，则判断是否拥有（族员管理，部落资料，商品管理）权限的部落
            $module_id = array(2,3,6);
        }else{
            $module_id = array(1,2,3,4,5);
        }
        $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id,0,$module_id);//查询管理的部落
        
        if(!$tribe || $tribe["status"] != 2){
            echo "<script>history.back();</script>";exit;
        }
    }else{
        echo "<script>history.back();</script>";exit;
    }
    
    
    $this->load->model("tribe_power_mdl");
    
    //查询权限并且设置权限session
    if($tribe["is_host"]){
        $powerlist = $this->tribe_power_mdl->PowerList();
        
    }else{
        $powerlist = $this->tribe_power_mdl->TribePower($tribe["tribe_manager_id"]);
    }
    // var_dump($powerlist);
    //查询部落主人
    $master = $this->tribe_mdl->TribeMaster($tribe_id);
    if(!$master){
        echo "<script>history.back();</script>";exit;//没有主人
    }
    
    $power = null;
    foreach ($powerlist as $v){
        $power .= ",".$v["url"].",";
        if($v["url"] == "/Tribe/apply_list"){
            $url = "Tribe/members";
        }else if($v["url"] == "/Tribe/Modifydata"){
            $url = "Tribe/lists";
        }else if($v["url"] == "/Tribe/products"){
            $url = "Tribe/lists";
        }
    }
    $this->session->set_userdata("tribe_id",$tribe_id);
    $this->session->set_userdata("tribe_power",$power);
    $this->session->set_userdata("tribe_masterid",$master["customer_id"]);
    // echo $url;exit;
    if(ISMOBILE == "pc"){
        if(!empty($url)){
            redirect($url);exit;
        }else{
            echo "<script>history.back();</script>";exit;//权限错误
        }
    }
    
    //获取未审核加入部落的人数
    $data['count_unaudited_tribe_num'] = $this->tribe_mdl->count_unaudited_tribe_num($tribe_id);
    $data["power"] = $power;
    
    //查询管理员数量
    $manager_list = $this->tribe_mdl->load_staff_by_id($tribe_id,1);
    $manager_num = [];
    // 排除义工委
    foreach( $manager_list as $val){
        if($val['is_host'] !=1){
            $manager_num[] = $val;
        }
    }
    
    $data['manager_num'] = $manager_num;
    $data["power"] = $power;
    $data["is_host"] = ($master["customer_id"]==$customer_id);
    $data["tribe"] = $tribe;//部落资料
    $data ['head_set'] = 2;
    $data['title'] = '部落管理';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/managingtribes', $data);
}


/**
 * 查看管理员权限
 * @param type 类型新增／删除
 */
public function manage_auth($tribe_id=0,$type=0)
{
    $customer_id = $this->session->userdata('user_id');
    $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);//查询管理的部落
    
    // var_dump($tribe);
    $data['create_customer'] = $tribe['customer_id'];
    //  查询管理员
    $data["tribe"] = $tribe;//部落资料
    $data ['head_set'] = 2;
    $data['title'] = '管理员权限';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    if($type){
        
        // 获取普通族员
        $data['list'] = $this->tribe_mdl->load_staff_by_id($tribe_id);
        
        // 获取角色id
        $role_id = $this->input->get_post('role');
        if(!$role_id){
            echo "<script>alert('缺少参数');history.back();</script>";return false;
        }
        $data['role_id'] = $role_id;
        $this->load->view('tribe/tribe_manage_add', $data);
        
    }else{
        
        // 获取管理员
        $data['list'] = $this->tribe_mdl->load_staff_by_id($tribe_id,1);
        
        // 获取管理员角色
        $data['role_list'] = $this->tribe_mdl->load_all_manager_role();
        
        $this->load->view('tribe/tribe_manage_delete', $data);
    }
    
}


/**
 * ajax 获取管理员权限
 * @return json
 */
public function ajax_manager_auth()
{
    $id = $this->input->get_post('id');
    if(isset($id) && $id != ''){
        $auth = $this->tribe_mdl->load_auth_by_id($id);
        $return = ['status'=>1, 'msg'=> '获取成功','data' => $auth];
    }else{
        $return = ['status'=>1, 'msg'=> '获取失败'];
    }
    
    echo json_encode($return);
}
// ----------------------------------------------------------------------------------------

/**
 * 修改部落资料
 */
public function Modifydata(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Modifydata")){
        echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
    }
    
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);//查询部落信息
    
    $data["tribe"] = $tribe;//部落资料
    $data ['head_set'] = 2;
    $data['title'] = '编辑部落资料';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/edit_tribe', $data);
}

// ----------------------------------------------------------------------------------------

/**
 * 申请部落列表
 */
public function apply_list(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/apply_list")){
        echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
    }
    
    $data ['head_set'] = 2;
    $data['title'] = '加入部落申请';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_apply_list', $data);
}

/**
 * ajax申请部落列表
 */
public function Ajax_apply_list(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/apply_list")){
        echo json_encode(array()); exit;
    }
    $keyword = $this->input->post("keyword");//关键词
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $limit = 10;
    $page = $this->input->post("page");//页数
    if(0 == $page)
    {
        $page = 1;
    }
    $offset = ($page-1)*$limit;//偏移量
    $data["apply_list"] = $this->tribe_mdl->tribe_member_list($tribe_id,$keyword,null,null,null,null,null,$limit,$offset,"list",array($customer_id));//查询申请列表
    echo json_encode($data);
    
}

/**
 * 族员信息
 * @param number $tribe_staffId 族员id
 */
public function Family_member($tribe_staffId=0){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/apply_list")){
        echo "<script>history.back();alert('对不起你暂无权限');</script>";exit;
    }
    
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    //查询族员信息
    $staff_info = $this->tribe_mdl->load_tribe_staff($tribe_id,$tribe_staffId);
    if(!$staff_info){
        echo "<script>history.back();</script>";exit;
    }
    $data["staff_info"] = $staff_info;
    $data ['head_set'] = 2;
    $data['title'] = '族员信息';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_staff_info', $data);
    
}

// --------------------------------------------------------------------------------------

/**
 * 根据类型进入修改资料页面
 * @param number $type 类型1简介2简介图3所属行业4banner图
 */
public function tribe_edit_view($type){
    
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Modifydata")){
        echo "<script>history.back();</script>";exit;
    }
    
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);//查询部落信息
    
    $data["tribe"] = $tribe;//部落资料
    $data["type"] = $type;
    $data ['head_set'] = 2;
    $data['title'] = '编辑部落资料';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    switch ($type){
        case 1:
            $this->load->view('tribe/tribe_edit_introduce', $data);
            break;
        case 2:case 4:
            $this->load->view('tribe/tribal_customization', $data);
            break;
        case 3:
            $this->load->view('tribe/tribe_edit_industry', $data);
            break;
        default:
            echo "<script>history.back();</script>";return;
            break;
    }
    
}

// ----------------------------------------------------------------------------------------

/**
 * 部落状态显示页面
 * @param number $tribe_id 部落id
 */
function tribe_Inaudit($tribe_id = 0){
    $customer_id = $this->session->userdata("user_id");//用户id
    //查询部落状态
    $tribe = $this->tribe_mdl->get_MyTribe($customer_id,$tribe_id);
    if($tribe){
        if($tribe["status"] == 2){
            redirect("tribe/managingtribes");
        }
    }else{
        redirect("tribe/add_view");exit;
    }
    
    //设置权限
    $this->load->model("tribe_power_mdl");
    $powerlist = $this->tribe_power_mdl->PowerList();
    $power = null;
    foreach ($powerlist as $v){
        $power .= ",".$v["url"].",";
    }
    $this->session->set_userdata("tribe_id",$tribe_id);
    $this->session->set_userdata("tribe_power",$power);
    $this->session->set_userdata("tribe_masterid",$customer_id);
    
    
    $data["tribe"] = $tribe;
    $data['head_set'] = 2;
    $data['title'] = '部落资料';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_Inaudit', $data);
}


// ----------------------------------------------------------------------------------------

/**
 * ajax审核部落人员
 */
function Ajax_audit(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/apply_list")){
        $return = array(
            "status"=>1,
            "Message"=>"对不起你没有权限"
        );
        echo json_encode($return);exit;
    }
    
    
    $staff_id = $this->input->post("staff_id");
    $status = $this->input->post("status");//状态：2同意3拒绝
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    $datetime = date("Y-m-d H:i:s");
    
    
    //查询判断参数信息
    if($staff_id < 1 || !in_array($status,array(2,3))){
        $return = array(
            "status"=>1,
            "Message"=>"参数错误"
        );
        echo json_encode($return);exit;
    }
    $tribe = $this->tribe_mdl->get_tribe($tribe_id);//查询部落
    $tribe_info = $this->tribe_mdl->get_tribe_customet_info($staff_id);//查询组员信息
    if(!$tribe_info || !$tribe){
        $return = array(
            "status"=>1,
            "Message"=>"用户不存在 or 部落不存在"
        );
        echo json_encode($return);exit;
    }
    
    
    $parameter = array(
        "status" => $status,
        "id" => $staff_id,
        "update_at" => $datetime
    );
    $row = $this->tribe_mdl->update_member($parameter,$tribe_id);//更新
    if($row){
        //发送短信
        $this->load->helper("message");
        if($status == 2){
            $mobile = $tribe_info['mobile'];
            $param['customer_id'] = $tribe_info['customer_id'];
            $param['resource'] = "Tribe/home/{$tribe_id}";
            $req = json_decode(  ToConect($param),true);
            
            $content = "欢迎加入".$tribe['name']."，快点去认识一下部落的其他成员，寻找自己的合作伙伴，点击进入：".$req['url_short']." 退订回N【51易货网】";
            $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
            $sms = send_message($mobile,0,$content,2,$source);
            
            //加入聊天室
            $this->HuanXinGroupHandle($tribe_id,$tribe_info['customer_id'],"join");
            
        }else if($status == 3){
            $mobile = $tribe_info['mobile'];
            
            $param['customer_id'] = $tribe_info['customer_id'];
            $param['resource'] = "Tribe/tribe_detail/{$tribe_id}";
            $req = json_decode(  ToConect($param),true);
            
            $content = "您加入的部落审核不通过，点击查看：".$req['url_short']." 详情请咨询：4000029777 退订回N【51易货网】";
            $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
            $sms = send_message($mobile,0,$content,2,$source);
        }
        $return = array(
            "status"=>2,
            "Message"=>"成功"
        );
    }else{
        $return = array(
            "status"=>1,
            "Message"=>"失败"
        );
    }
    echo json_encode($return);exit;
}

// ----------------------------------------------------------------------------------------


/**
 * 进入发布活动页面
 * @param number $id 活动id
 */
function publish_events_view($id=0){
    
    
    $tribe_id = $this->input->get('tribe_id');
    
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Activity_management_view",$tribe_id)){
        
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $activity = array();
    if($id){
        $this->load->model("tribe_activity_mdl");
        $activity = $this->tribe_activity_mdl->tribe_activity_info($id,$tribe_id);//查询活动
        
    }
    
    $data["activity"] = $activity;
    $data['head_set'] = 2;
    $data['title'] = '发布活动';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/publish_events_view', $data);;
}

/**
 * 富文本编辑器上传图片
 */
function editor_uploads(){
    $this->load->helper("uploads_helper");
    $file = "uploads/fck/images";
    $image = file_upload($file);
    $return["success"] = $image?true:false;
    if(!$image){
        $return["msg"] = "上传图片失败";
    }
    $return["file_path"] = IMAGE_URL.$file."/".$image["file_name"];
    echo json_encode($return);
}

// ----------------------------------------------------------------------------------------

/**
 * 活动管理页面 (活动类型0、默认  1、政策法规 2、行业动态)
 */
function Activity_management_view($type=0){
    
    //验证部落权限
    if($type==0){
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/Activity_management_view")){
            echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
        }
    }
    
    switch ($type) {
        case 0:
            $data['title'] = '活动管理';
            break;
        case 1:
            $data['title'] = '政策法规';
            break;
        case 2:
            $data['title'] = '行业动态';
            break;
            
        default:
            echo "<script>history.back();</script>";
            break;
    }
    $data['activity_type'] = $type;
    
    $data['head_set'] = 2;
    // $data['title'] = '活动管理';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_active_manage', $data);
    
}

// -----------------------------------------------------------------------------------

/**
 * ajax获取活动管理列表
 */
function Ajax_Activity_management(){
    
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Activity_management_view")){
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $this->load->model('Tribe_activity_mdl');
    
    $limit = 10;
    $page = $this->input->post("page");//页数
    $type = $this->input->post('type');//活动类型
    if(0 == $page)
    {
        $page = 1;
    }
    $offset = ($page-1)*$limit;//偏移量
    
    $return["activity_list"] = $this->Tribe_activity_mdl->tribe_activity($tribe_id,$customer_id,$limit,$offset,$type);//查询我的部落活动列表
    
    echo json_encode($return);exit;
}


/**
 * 政策法规/行业动态 列表
 */
public function news_information($type=0,$app_label_id=0){
    
    if(!$app_label_id){
        echo "<script>history.back(-1);</script>";
    }
    
    switch ($type) {
        case '1':
            $data['title'] = '政策法规';
            break;
        case '2':
            $data['title'] = '行业动态';
            break;
            
        default:
            echo "<script>history.back(-1);</script>";
            break;
    }
    
    //商会一级标签
    $this->load->model('App_label_mdl');
    $app_label_info = $this->App_label_mdl->Load( $app_label_id );
    
    if(!$app_label_info){
        echo "<script>history.back(-1);</script>";
    }
    
    // 此商会下的部落ID
    $tribe_ids_arr = $this->get_app_tribe_ids($app_label_id);
    array_push($tribe_ids_arr,$app_label_info['tribe_id']);
    
    $this->load->model('tribe_activity_mdl');
    $data['list'] = $this->tribe_activity_mdl->news_information($tribe_ids_arr,$type);
    
    $data ['head_set'] = 2;
    $data ['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_news_information', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
}

/**
 * 政策法规/行业动态 详情
 */
public function news_information_detail($tribe_activity_id){
    if(!$tribe_activity_id){
        echo "<script>history.back(-1);</script>";
        exit;
    }
    
    $this->load->model('tribe_activity_mdl');
    $res = $this->tribe_activity_mdl->news_information($tribe_activity_id);
    
    switch ($res['type']) {
        case '1':
            $data['title'] = '政策法规';
            break;
        case '2':
            $data['title'] = '行业动态';
            break;
            
        default:
            echo "<script>history.back(-1);</script>";
            break;
    }
    
    $data['activity_info'] = $res;
    $data ['head_set'] = 2;
    $data ['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('tribe/tribe_activities_detail', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
    
}

// -----------------------------------------------------------------------------------

/**
 * ajax发布活动 or 修改
 * @param number $id 活动id
 */
function ajax_save_activity($id=0){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Activity_management_view")){
        $return = array(
            "status"=>1,
            "Message"=>"对不起你没有权限"
        );
        echo json_encode($return);exit;
    }
    
    $name = $this->input->post("name");//活动名称
    $content = str_replace(array("\r\n", "\r", "\n"), '<br>',str_replace("'","\'",$this->input->post("content")));//内容
    $start_time = $this->input->post("start_time");//开始时间
    $end_time = $this->input->post("end_time");//结束时间
    $datetime = date("Y-m-d H:i:s");
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    $display = $this->input->post("display") ? 1 : 0 ;//是否公开
    
    $this->load->helper("verification_helper");
    $this->load->model("tribe_activity_mdl");
    
    //验证数据是否符合要求
    if(!strlen($name) || !$content || !validateDate($start_time) || !validateDate($end_time)){
        $return = array(
            "status"=>1,
            "Message"=>"参数错误"
        );
        echo json_encode($return);exit;
    }
    
    
    if($id){
        $activity = $this->tribe_activity_mdl->tribe_activity_info($id,$tribe_id);//查询活动
        if(!$activity){
            $return = array(
                "status"=>1,
                "Message"=>"活动不存在"
            );
            echo json_encode($return);exit;
        }
    }
    
    
    //上传图片
    $this->load->helper("uploads");
    if($_FILES["banner_img"]["error"] == 0){
        $images = file_upload("uploads/tribe_content/images/",null,null,"banner_img");
    }else{
        if($id){
            $images["file_name"] = str_replace("uploads/tribe_content/images/","",$activity["banner_img"]);
        }else{
            $images = null;
        }
        
    }
    
    if(!$images){
        $return = array(
            "status"=>1,
            "Message"=>"上传图片失败"
        );
        echo json_encode($return);exit;
    }
    
    
    $parameter["banner_img"] = "uploads/tribe_content/images/".$images["file_name"];
    $parameter["name"] = $name;
    $parameter["content"] = $content;
    $parameter["start_time"] = $start_time;
    $parameter["end_time"] = $end_time." 23:59:59";
    $parameter["tribe_id"] = $tribe_id;
    $parameter["update_at"] = $datetime;
    $parameter["status"] = 0;
    $parameter['display'] = $display;
    if($id){
        $row = $this->tribe_activity_mdl->update($parameter,$id,$tribe_id);//更新发布
    }else{
        $parameter["created_at"] = $datetime;
        $row = $this->tribe_activity_mdl->create($parameter);//添加发布
        $id = $row;
    }
    if($row){
        $return = array(
            "id" => $id,
            "status"=>2,
            "Message"=>"发布成功"
        );
        echo json_encode($return);exit;
    }else{
        $return = array(
            "status"=>1,
            "Message"=>"发布失败"
        );
        echo json_encode($return);exit;
    }
    
    
}



/**
 * ajax删除活动
 * @param number $id 活动id
 */
function ajax_delete_activity(){
    $id = $this->input->post("id");
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Activity_management_view")){
        $return = array(
            "status"=>1,
            "Message"=>"对不起你没有权限"
        );
        echo json_encode($return);exit;
    }
    
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    $this->load->model("tribe_activity_mdl");
    
    $activity = $this->tribe_activity_mdl->tribe_activity_info($id,$tribe_id);//查询活动
    if(!$activity){
        $return = array(
            "status"=>1,
            "Message"=>"活动不存在"
        );
        echo json_encode($return);exit;
    }
    
    //执行删除
    $row = $this->tribe_activity_mdl->delete($id);
    $id = $row;
    
    if($row){
        $return = array(
            "id" => $id,
            "status"=>2,
            "Message"=>"删除成功"
        );
        echo json_encode($return);exit;
    }else{
        $return = array(
            "status"=>1,
            "Message"=>"删除失败"
            
        );
        echo json_encode($return);exit;
    }
    
    
}

// -----------------------------------------------------------------------------------

/**
 * 修改部落资料
 */
function update(){
    $tribe_id = $this->input->post("tribe_id");//部落id
    $region = $this->input->post("region");//地区
    $content = $this->input->post("content");//简介
    $industry = $this->input->post("industry");//行业
    $name = $this->input->post("name");//部落名称
    $staff_status = $this->input->post("staff_status");//'族员是否需要审核0否1是'
    $datetime = date("Y-m-d H:i:s");
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $user_id = $this->session->userdata("user_id");//当前登录id
    
    //判断识别ajax请求还是普通请求
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        $ajax_flag = true;
    }else {
        $ajax_flag = false;
    }
    
    $this->load->helper("uploads");
    $this->load->helper("ps");
    
    //验证是否我的部落
    if($tribe_id && $customer_id == $user_id){
        $tribe = $this->tribe_mdl->get_MyTribe($customer_id,$tribe_id);
    }
    
    //验证部落权限
    if(!empty($tribe)){
        //审核不通过重新填写执行
        if($tribe["status"] == 3 ){
            $parameter["status"] = 1;
            if($name){
                $tribe = $this->tribe_mdl->check_name($name);
                if($tribe && $tribe["customer_id"] != $customer_id){
                    if($ajax_flag){
                        $this->ajax_update_prompt("2","部落已经存在");
                    }else{
                        redirect("tribe/add_view");exit;//更新失败
                    }
                }else{
                    $parameter["name"] = $name;
                }
            }
        }
    }else if(CheckTribePower("/Tribe/Modifydata")){
        $tribe_id = $this->session->userdata("tribe_id");
    }else{
        if($ajax_flag){
            $this->ajax_update_prompt("2","权限不足");
        }else{
            redirect("tribe/add_view");exit;//更新失败
        }
    }
    
    
    //如果有商城背景图片上传执行
    if((array_key_exists("shop_img1",$_FILES) && $_FILES["shop_img1"]["error"] == 0) || (array_key_exists("shop_img2",$_FILES) && $_FILES["shop_img2"]["error"] == 0)){
        if(array_key_exists("shop_img2",$_FILES) && $_FILES["shop_img2"]["error"] == 0){
            $images = file_upload("uploads/tribe/images/",null,null,"shop_img2");
        }else{
            $images = file_upload("uploads/tribe/images/",null,null,"shop_img1");
        }
        if(!$images){
            if($ajax_flag){
                $this->ajax_update_prompt("2","上传图片失败");
            }else{
                redirect("tribe/add_view");exit;//更新失败
            }
        }else{
            $parameter["shop_img"] = "uploads/tribe/images/".$images["file_name"];
        }
    }
    
    //如果有logo上传执行
    if(array_key_exists("logo",$_FILES) && $_FILES["logo"]["error"] == 0){
        $images = file_upload("uploads/tribe/images/",null,null,"logo");
        if(!$images){
            if($ajax_flag){
                $this->ajax_update_prompt("2","上传图片失败");
            }else{
                redirect("tribe/add_view");exit;//更新失败
            }
        }else{
            $parameter["logo"] = "uploads/tribe/images/".$images["file_name"];
        }
    }
    
    
    //如果有地区修改执行
    if($region){
        $region = explode("-",$region);
        if(count($region) == 2){
            $provice = $region[0];
            $city = $region[1];
            
            $parameter["provice"] = $provice;
            $parameter["city"] = $city;
        }else{
            if($ajax_flag){
                $this->ajax_update_prompt("2","地址错误");
            }else{
                redirect("tribe/add_view");exit;//更新失败
            }
        }
    }
    
    //如果有简介修改执行
    if($content){
        $parameter["content"] = $content;
        if( mb_strlen($content) < 1 ){//mb_strlen($content) > 150
            if($ajax_flag){
                $this->ajax_update_prompt("2","简介参数错误");
            }else{
                redirect("tribe/add_view");exit;//更新失败
            }
        }
    }
    
    //如果有简介图片上传执行
    if((array_key_exists("content_img1",$_FILES) && $_FILES["content_img1"]["error"] == 0) || (array_key_exists("content_img2",$_FILES) && $_FILES["content_img2"]["error"] == 0)){
        if(array_key_exists("content_img2",$_FILES) && $_FILES["content_img2"]["error"] == 0){
            $images = file_upload("uploads/tribe/images/",null,null,"content_img2");
        }else{
            $images = file_upload("uploads/tribe/images/",null,null,"content_img1");
        }
        if(!$images){
            if($ajax_flag){
                $this->ajax_update_prompt("2","上传图片失败");
            }else{
                redirect("tribe/add_view");exit;//更新失败
            }
        }else{
            $parameter["content_img"] = "uploads/tribe/images/".$images["file_name"];
        }
    }
    
    //如果有行业修改执行
    if($industry){
        $parameter["industry"] = $industry;
    }
    
    
    $parameter["update_at"] = $datetime;
    $row = $this->tribe_mdl->save($tribe_id,$parameter);//更新部落
    if($row){
        if($ajax_flag){
            $this->ajax_update_prompt("1","更新成功");
        }else{
            redirect("tribe/ManagementTribe");//更新成功
        }
    }else{
        if($ajax_flag){
            $this->ajax_update_prompt("2","更新失败");
        }else{
            redirect("tribe/add_view");//更新失败
        }
    }
    
}



/**
 * ajax更新提示
 * @param number $status 返回码
 * @param string $message 消息
 */
private function ajax_update_prompt($status,$message){
    $return = array(
        "status"=>$status,
        "Message"=>$message
    );
    echo json_encode($return);exit;
}

// -----------------------------------------------------------------------------------


/**
 * 部落公告管理 or 商会页面
 * @param number $flag 0管理列表
 */
function tribe_announcements_view($label_id = 0){
    //验证部落权限
    
    $tribe_id = $this->input->get('tribe_id');
    
    if( !$label_id )
    {
        $this->load->helper("ps");
        if(!CheckTribePower("/Tribe/tribe_announcements_view",$tribe_id)){
            echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
        }
    }
    
    $keyword = $this->input->get("keyword");//关键词
    
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    $data['administrator'] = true;
    
    
    if($label_id){
        $this->load->model('App_label_mdl');
        $status = 'show_app_tribe_ids';
        $app_labe_info = $this->App_label_mdl->Load( $label_id, $status );
        
        if( $app_labe_info )
        {
            $tribe_app_label_info = $this->App_label_mdl->Load_tribe_app_label( $label_id );
            if( $tribe_app_label_info )
            {
                $app_tribe_id = '';
                foreach ($tribe_app_label_info as $key =>$val )
                {
                    $app_tribe_id = trim($app_tribe_id,",");
                    $app_tribe_id .= ','.$val['tribe_ids'];
                }
                
                $ids = explode(',',$app_tribe_id);//字符串转数组
                $app_tribe_ids = array_unique($ids);
                
                if(in_array($tribe_id,$app_tribe_ids)){
                    $data['administrator'] = true;
                }else{
                    $data['administrator'] = false;
                }
            }
        }
    }
    
    
    
    $data["keyword"] = $keyword;
    $data['label_id'] = $label_id?$label_id:false;
    $data['head_set'] = 2;
    $data['title'] = '公告管理';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/tribe_announcements_view', $data);
    
}

// -----------------------------------------------------------------------------------

/**
 * ajax获取公告管理
 */
function ajax_announcements(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/tribe_announcements_view")){
        $return["activity_list"] = array();
        echo json_encode($return);exit;
    }
    
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    $this->load->model('tribe_content_mdl');
    $limit = 10;
    $page = $this->input->post("page");//页数
    if(0 == $page)
    {
        $page = 1;
    }
    $offset = ($page-1)*$limit;//偏移量
    $return["announcement_list"] = $this->tribe_content_mdl->load_announcements_list($customer_id,$tribe_id,$limit,$offset);//查询我的部落活动列表
    echo json_encode($return);exit;
}

// -----------------------------------------------------------------------------------

/**
 * 发布部落公告页面
 */
function announcement_view($id = 0){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/tribe_announcements_view")){
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    
    $info = array();
    if($id){
        $this->load->model("tribe_content_mdl");
        
        //查询公告
        $sift['where']['customer_id'] = $customer_id;
        $sift['where']['tribe_id'] = $tribe_id;
        $sift['where']['id'] = $id;
        $sift['where']['status'] = array(0,1,2);
        //部落信息
        $this->load->model('Tribe_content_mdl');
        $info = $this->Tribe_content_mdl->Load( $sift );
    }
    $staff_list = $this->tribe_mdl->load_members_list($tribe_id);//查询部落成员
    
    $data["staff_list"] = $staff_list;
    $data['info'] = $info;
    $data['head_set'] = 2;
    $data['title'] = '发布公告';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/publish_notice_view', $data);
    
}

// -----------------------------------------------------------------------------------

/**
 * ajax发布 or 更新公告
 * @param number $id 公告id
 */
function ajax_save_notice($id=0){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Activity_management_view")){
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    
    $title = $this->input->post("title");//活动名称
    $sendee_id = $this->input->post("sendee_id");//短信接收人id
    $on_off = $this->input->post("on_off");//识别短信发送
    $display = $this->input->post("display") ? 1 : 0 ;//是否公开
    
    $content = str_replace(array("\r\n", "\r", "\n"), '<br>',str_replace("'","\'",$this->input->post("content")));//内容
    $datetime = date("Y-m-d H:i:s");
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $this->load->helper("uploads");
    $this->load->model("tribe_content_mdl");
    
    //判断参数
    if(!strlen($title) || !$content){
        $return = array(
            "status"=>1,
            "Message"=>"参数错误"
        );
        echo json_encode($return);exit;
    }
    
    
    if($id){
        //查询公告
        $sift['where']['customer_id'] = $customer_id;
        $sift['where']['tribe_id'] = $tribe_id;
        $sift['where']['id'] = $id;
        $sift['where']['status'] = array(0,1,2);
        //部落信息
        $info = $this->tribe_content_mdl->Load( $sift );//查询公告
        if(!$info){
            $return = array(
                "status"=>1,
                "Message"=>"公告不存在"
            );
            echo json_encode($return);exit;
        }
    }
    
    //处理接收人数据
    $sendee_ids = null;
    if($on_off){
        if(is_array($sendee_id)){
            $sendee_id = array_unique($sendee_id);
            foreach ($sendee_id as $v){
                if($v && is_numeric($v)){
                    $sendee_ids .= ",".$v;
                }
            }
            $sendee_ids = trim($sendee_ids,",");
        }
    }
    
    
    //上传图片
    if(!empty($_FILES["title_img"]) && $_FILES["title_img"]["error"] == 0){
        $images = file_upload("uploads/tribe_content/images/",null,null,"title_img");
    }else{
        if($id){
            $images["file_name"] = str_replace("uploads/tribe_content/images/","",$info["title_img"]);
        }else{
            $images = null;
        }
        
    }
    if(!$images){
        $return = array(
            "status"=>1,
            "Message"=>"上传图片失败"
        );
        echo json_encode($return);exit;
    }
    $parameter["title_img"] = "uploads/tribe_content/images/".$images["file_name"];
    $parameter["title"] = $title;
    $parameter["content"] = $content;
    $parameter["tribe_id"] = $tribe_id;
    $parameter["last_updated_time"] = $datetime;
    $parameter['sendee_id'] = $sendee_ids;
    $parameter['display'] = $display;
    if($id){
        $parameter["status"] = 0;
        $row = $this->tribe_content_mdl->update($id,$tribe_id,$parameter);//更新公告
    }else{
        $parameter["create_time"] = $datetime;
        $row = $this->tribe_content_mdl->create($parameter);//发布公告
    }
    if($row){
        $return = array(
            "status"=>2,
            "Message"=>"发布成功"
        );
        echo json_encode($return);exit;
    }else{
        $return = array(
            "status"=>1,
            "Message"=>"发布失败"
        );
        echo json_encode($return);exit;
    }
    
}

/**
 * ajax删除公告
 * @param number $id 公告id
 */
function ajax_delete_notice(){
    $id = $this->input->post("id");
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/Activity_management_view")){
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    //查询公告
    $sift['where']['customer_id'] = $customer_id;
    $sift['where']['tribe_id'] = $tribe_id;
    $sift['where']['id'] = $id;
    $sift['where']['status'] = array(0,1,2);
    //部落信息
    $this->load->model("tribe_content_mdl");
    $info = $this->tribe_content_mdl->Load( $sift );//查询公告
    if(!$info){
        $return = array(
            "status"=>1,
            "Message"=>"公告不存在"
        );
        echo json_encode($return);exit;
    }
    
    //执行删除
    $row = $this->tribe_content_mdl->delete($id);
    $id = $row;
    
    if($row){
        $return = array(
            "id" => $id,
            "status"=>2,
            "Message"=>"删除成功"
        );
        echo json_encode($return);exit;
    }else{
        $return = array(
            "status"=>1,
            "Message"=>"删除失败"
            
        );
        echo json_encode($return);exit;
    }
    
}

// -----------------------------------------------------------------------------------

/**
 * 圈子管理页面
 */
function topic_manage_view(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/topic_manage_view")){
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    $data['head_set'] = 2;
    $data['title'] = '圈子管理';
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('tribe/topic_manage', $data);
}

// -----------------------------------------------------------------------------------

/**
 * ajax获取圈子管理列表
 */
function ajax_topic_list(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/topic_manage_view")){
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    $this->load->model('tribe_topic_mdl');
    $limit = 10;
    $page = $this->input->post("page");//页数
    if(0 == $page)
    {
        $page = 1;
    }
    $offset = ($page-1)*$limit;//偏移量
    $TopicList = $this->tribe_topic_mdl->ManageTopicList($tribe_id,$limit,$offset);//查询我的部落活动列表
    foreach($TopicList as $key => $val){
        $TopicList[$key]["images"] = explode(";", $val["images"]);
    }
    $return["TopicList"] = $TopicList;
    echo json_encode($return);
}

// -----------------------------------------------------------------------------------

/**
 * ajax义工委删除话题
 */
public function Del_Topic(){
    
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/topic_manage_view")){
        echo "<script>history.back();alert('对不起你没有权限');</script>";exit;
    }
    
    $id = $this->input->post("id");//话题id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $sift['where']['id'] = 0==$id?-1:$id;
    $sift['where']['tribe_id'] = $tribe_id;
    $sift['set']['status'] = 0;
    
    $this->load->model('Tribe_topic_mdl');
    $row = $this->Tribe_topic_mdl->Update( $sift );
    if($row){
        $return = array(
            "status"=>2,
            "Message"=>"删除成功"
        );
        
    }else{
        $return = array(
            "status"=>1,
            "Message"=>"删除失败"
        );
    }
    
    echo json_encode($return);exit;
    
    
}

/**
 * 更新手机显示状态
 */
public function update_show_mobile()
{
    $show_mobile = $this->input->post("show_mobile");
    $staff_id = $this->input->post("staff_id");
    $customer_id = $this->input->post("customer_id");
    $res = $this->tribe_mdl->update_show_mobile_status($show_mobile,$staff_id,$customer_id);
    if($res){
        echo json_encode(['code'=>1, 'msg'=>'success']);
    }else{
        echo json_encode(['code'=>0, 'msg'=>'fail']);
    }
    
}



/**
 * 查询我加入过的部落的圈子
 * @date:2017年12月28日 下午2:56:58
 * @author: fxm
 * @param: variable
 * @return:
 */
public function topict()
{
    $data['real_name'] = '我';
    $data['head_set'] = 2;
    $data['foot_set'] = 1;
    $this->load->view('head', $data);
    $this->load->view('_header', $data);
    $this->load->view('circles/circles_topic_list', $data);
    $this->load->view('_footer', $data);
    $this->load->view('foot', $data);
}


/**
 * 异步加载话题，我加入过的部落的话题。
 */
public function Topic_List()
{
    
    $page = $this->input->get('page');
    
    $limit = 10;
    $offset = ( $page-1 ) * $limit;//偏移量
    
    $sift['page']['limit'] = $limit;
    $sift['page']['offset'] = $offset;
    $not_sort =  !empty( $this->input->get('not_sort') ) ? 1 : 0;
    if( !$page  || !is_numeric($page) || !is_int($page+0)  )
    {
        $page = 10;
    }
    
    $customer_id = $this->session->userdata("user_id");//用户id
    $list = array();
    $mytribe = array();
    //我的部落
    $mytribe = $this->tribe_mdl->MyTribe($customer_id,1);
    
    
    if( $mytribe )
    {
        $sift['where']['tribe_id'] = array_column($mytribe, 'id');
        $sift['where']['customer_id'] = $customer_id;
        
        $this->load->model('Tribe_topic_mdl');
        $list = $this->Tribe_topic_mdl->Load( $sift ,$not_sort );
        
        foreach ($list as $key =>$val)
        {
            $upvote_info =  $this->Tribe_topic_mdl->topic_upvote_member_name($val['id']);
            $list[$key]['upvote_info'] = array();
            if(count($upvote_info) > 0){
                $list[$key]['upvote_info'] =$upvote_info;
            }
        }
    }
    
    $return['list'] = $list;
    $return['tribe_list'] = array_column($mytribe, null,'id');
    $return['status'] = 1;
    
    echo json_encode( $return );
}


/**
 * @author JF
 * 2017年12月29日
 * 设置部落是否审核加入
 */
function ajax_set_staff_status(){
    //验证部落权限
    $this->load->helper("ps");
    if(!CheckTribePower("/Tribe/apply_list")){
        $return = array(
            "status"=>"01",
            "Message"=>"对不起你暂无权限"
        );
        echo json_encode($return);exit;
    }
    
    $staff_status = $this->input->post("staff_status");//族员是否需要审核0否1是'
    
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    
    $param["staff_status"] = $staff_status?1:0;
    $param["update_at"] = date("Y-m-d H:i:s");
    $row = $this->tribe_mdl->save($tribe_id,$param);
    if($row){
        $return = array(
            "status"=>"00",
            "Message"=>"success"
        );
    }else{
        $return = array(
            "status"=>"01",
            "Message"=>"设置失败"
        );
    }
    echo json_encode($return);
}



/**
 * 添加或删除管理员
 * @return json
 */
function update_manage()
{
    $staff_ids = $this->input->get_post('staff_id');
    $type = $this->input->get_post('type');
    $tribe_id = $this->input->get_post('tribe_id');
    $tribe_manage_id = $this->input->get_post('manage_id');
    $tribe_manage_id = isset($tribe_manage_id)?$tribe_manage_id:'';
    if(!$staff_ids || !$type || !$tribe_id ){
        echo json_encode(['code'=>4, 'msg'=>'参数不能为空']);
        exit;
    }
    
    // if(!$tribe_manage_id){
    //     echo json_encode(['code'=>4, 'msg'=>'参数不能为空']);exit;
    // }
    $customer_id = $this->session->userdata('user_id');
    $tribe = $this->tribe_mdl->ManagementTribe($customer_id,$tribe_id);//查询管理的部落
    
    
    // 校验是否该部落的义工委
    $customer_id = $this->session->userdata('user_id');
    $result_check = $this->tribe_mdl->TribeMaster($tribe_id);// 查询部落义工委
    if(!$result_check){
        echo json_encode(['code'=>3, 'msg'=>'不是部落首领操作,非法操作']);exit;
    }
    
    $staff_id = json_decode($staff_ids, true);
    $result = $this->tribe_mdl->update_manage($staff_id,$type,$tribe_manage_id);
    
    if(is_numeric($result)){
        echo json_encode(['code' => 1, 'msg' => '添加管理员成功']);
    }else{
        echo json_encode(['code' => 0, 'msg' => '添加管理员失败']);
    }
    
}

/**
 * @author JF
 * 2018年3月1日
 * ajax 更新部落信息
 */
function ajax_update_tribe(){
    
    $this->load->helper("verification");
    $this->load->helper("ps");
    $this->load->model("region_mdl");
    
    //验证部落权限
    if(!CheckTribePower("/Tribe/apply_list")){
        $return = array(
            "status"=>"01",
            "Message"=>"对不起你暂无权限"
        );
        echo json_encode($return);exit;
    }
    
    $provice = $this->input->post("province");//省份
    $city = $this->input->post("city");//城市
    $industry = $this->input->post("industry");//行业
    $content = $this->input->post("content");//简介
    $see_status = $this->input->post("see_status");//族员加入是否需要审核
    $post = $this->input->post();
    $user_id = $this->session->userdata("user_id");//当前用户id
    $customer_id = $this->session->userdata("tribe_masterid");//部落主人id
    $tribe_id = $this->session->userdata("tribe_id");//部落id
    $time = date("Y-m-d H:i:s");
    
    //验证参数
    if(!validateRequired($industry) || !validateRequired($content) || !$provice || !$city){
        $return = array(
            "status"=>"01",
            "Message"=>"请填写相关的数据"
        );
        echo json_encode($return);exit;
    }
    
    //查询地区
    $provice = $this->region_mdl->load($provice);
    $city = $this->region_mdl->load($city);
    if($provice && $city){
        $provice = $provice["region_name"];
        $city = $city["region_name"];
    }else{
        $return = array(
            "status"=>"01",
            "Message"=>"请填写相关的数据"
        );
        echo json_encode($return);exit;
    }
    
    $this->db->trans_begin();
    
    //只有部落首领才能设置角色
    if($user_id == $customer_id){
        //检验角色数据是否存在并且唯一（一个用户只允许一个角色）
        $arr = array();
        $role_mobile = array();//要设置角色=>用户手机
        $mobile_str = "";//用户手机（逗号分隔）
        foreach ($post as $k => $v){
            if(preg_match("/manager/",$k) && $v){
                $mobile = explode(",",trim($v,","));
                if(!array_intersect($arr,$mobile)){
                    $arr = array_merge_recursive($arr,$mobile);
                }else{
                    $return = array(
                        "status"=>"01",
                        "Message"=>"请填写相关的数据"
                    );
                    echo json_encode($return);exit;
                }
                
                //组成要设置角色id和用户的数组
                $manager_id = str_replace("manager",'',$k);
                if(!is_numeric($manager_id)){
                    $return = array(
                        "status"=>"01",
                        "Message"=>"请填写相关的数据"
                    );
                    echo json_encode($return);exit;
                }
                
                $role_mobile[$manager_id] = $mobile;
                
                //拼接批量更新用户管理权限sql（第一步）
                if(empty($sql)){
                    $sql = 'UPDATE 9thleaf_tribe_staff AS a JOIN 9thleaf_customer AS b ON a.customer_id = b.id SET a.tribe_manager_id = CASE  b.mobile ';//更新管理员sql
                }
                foreach($mobile as $key => $val){
                    $sql .= " WHEN '{$val}' THEN '{$manager_id}' ";
                    $mobile_str .= ","."'{$val}'";
                }
            }
        }
        
        //默认更新族员权限0
        $parameter = array(
            "tribe_manager_id" => '0',
            "tribe_id" => $tribe_id
        );
        $row = $this->tribe_mdl->update_manager_role($parameter,true);
        if(!$row){
            $this->db->trans_rollback();
            $this->ajax_update_prompt("01","更新失败");
        }
        
        //拼接用户管理权限sql并执行更新（第二步）
        if(!empty($sql)){//有设置角色
            //查询角色是否存在
            $manager_id = array_keys($role_mobile);
            $this->db->from("tribe_manager");
            $this->db->where_in("id",$manager_id);
            $total = $this->db->get()->num_rows();
            if(count($manager_id) != $total){
                $return = array(
                    "status"=>"01",
                    "Message"=>"请填写相关的数据"
                );
                echo json_encode($return);exit;
            }
            
            $mobile_str = trim($mobile_str,",");
            $sql .= "END WHERE a.tribe_id = '{$tribe_id}' AND b.mobile IN ($mobile_str)";
            $row = $this->db->query($sql);//批量更新
            if(!$row){
                $this->db->trans_rollback();
                $this->ajax_update_prompt("01","更新失败");
            }
            
        }
    }
    
    //更新部落资料
    $see_status = $see_status?1:0;
    $parameter = array(
        "industry" => $industry,
        "staff_status" => $see_status,
        "content" => $content,
        "provice" => $provice,
        "city" => $city,
        "update_at" => $time
    );
    $row = $this->tribe_mdl->save($tribe_id,$parameter);
    if(!$row){
        $this->db->trans_rollback();
        $this->ajax_update_prompt("01","更新失败");
    }
    
    //如果执行到这里就成功
    $this->db->trans_commit();
    $this->ajax_update_prompt("02","更新成功");
}


/**
 * ajax 更新上传部落图片
 */
public function ajax_upload()
{
    
    $this->load->helper('uploads_helper');
    
    //获取文件详细路径
    $filePath="uploads/tribe/images/";
    $new_name = "";
    /**
     * 单图片。
     * @param $filepath 上传的文件路径（全路径）(必选)
     * @param $new_name 上传后的文件名 (可选)
     * @param $img_size 上传图片的大小 (可选) 单位M;
     * @param $field    上传表单的字段 (可选)
     *
     */
    $res = file_upload($filePath,$new_name);
    if($res){
        
        $infor=array("err"=>0,"msg"=>"添加成功",'img'=>$filePath.$res['file_name']);
    }else{
        $infor=array("err"=>1,"msg"=>"添加失败");
    }
    
    echo json_encode($infor);
}



// 查找管理员
public function select_manager()
{
    
    $tribe_manager_id = $this->input->get_post("tribe_manager_id");
    $tribe_id = $this->input->get_post("tribe_id");
    
    if(empty($tribe_manager_id) || empty($tribe_id) ){
        $return = ['status'=>2, 'msg'=>'缺少参数'];
        exit;
    }
    $data['tribe_manager_id'] = $tribe_manager_id;
    // $data['tribe_manager_id'] = 1;
    $data['tribe_id'] = $tribe_id;
    // $data['tribe_id'] = 75;
    $query = $this->tribe_mdl->select_manager($data);
    if($query){
        $return = ['status'=>1, 'msg'=>'sucess','data' => $query];
    }else{
        $return = ['status'=>0, 'msg'=>'fail'];
    }
    echo json_encode($return);
}


function test()
{
    
    //获取该部落的管理者名单
    $id = $this->session->userdata('tribe_id');
    $role_list = $this->tribe_mdl->test();
    if( count($role_list)>0 ){
        $role_arr=array_column($role_list,"name","id");
        $role_id_arr=array_column($role_list,"id");
        $role_admin_arr=array();
        $all_old_id=array();
        
        for ($i=0;$i<count($role_id_arr);$i++){
            $role_id=$role_id_arr[$i];
            $role_admin_arr[$role_id]['name']=$role_arr[$role_id];
            $tribe_staff_r = $this->tribe_mdl->get_staff_by_role($id,$role_id);
            
            if( $tribe_staff_r ){
                $role_admin_arr[$role_id]['count']=count($tribe_staff_r);
                $str="";
                $tem_arr=array();
                foreach( $tribe_staff_r as $key=>$value ){
                    $arr=array();
                    $arr['id']=$value['id'];
                    if( !empty($value['real_name']) ){
                        $arr['text']=$value['real_name'];
                    }else{
                        $arr['text']=$value['member_name'];
                    }
                    $tem_arr[]=$arr;
                }
                $role_admin_arr[$role_id]['str']=json_encode($tem_arr);
                
                $old_id_arr=array_column($tribe_staff_r,"id");
                if( $old_id_arr ){
                    $role_admin_arr[$role_id]['old_id']=implode(",",$old_id_arr);
                    $all_old_id[$role_id]=$old_id_arr;
                }else{
                    $role_admin_arr[$role_id]['old_id']="";
                    $all_old_id[$role_id]=array();
                }
            }
            if( $all_old_id ){
                $new_arr=array();
                foreach($all_old_id as $key=>$value){
                    $new_arr=array_merge($new_arr,$value);
                }
                // if( $new_arr ){
                //     $this->assign("all_old_arr",implode(",",$new_arr));
                // }
            }
        }
    }
    
    // var_dump($new_arr);
    // return $role_admin_arr;
    $this->assign("role_admin_arr",$role_admin_arr);
    
}

// 更新部落信息
function update_staff(){
    $mobile = $this->session->userdata('mobile');
    $tribe_id = $this->input->get_post('tribe');
    $customer_id = $this->session->userdata('user_id');
    $user_id = $customer_id;
    $tribe_id = json_decode($tribe_id,true);
    $flag = false;
    if(isset($tribe_id)){
        $res2 = '';
        $this->load->model('Tribe_mdl');
        if($mobile){
            //更新部落用户ID信息  单独更新某一个部落
            $update_data['customer_id'] = $user_id;
            $update_data['mobile'] = $mobile;
            // $update_data['tribe_id'] = $tribe_id;
            
            foreach($tribe_id as $value){
                $update_data['tribe_id'] = $value;
                $update_data['show_mobile'] = 1;
                $update_data['status'] = 2;
                $is_check = $this->tribe_mdl->check_mobile($mobile, $value);
                if($is_check){
                    $res1 = $this->Tribe_mdl->update_tribe_staff( $update_data );
                }
                
            }
            //同步部落身份信息 单独更新某一个部落
            $staff_idenity =  $this->Tribe_mdl->load_staff_idenity($mobile);
            
            if($staff_idenity){
                foreach ($staff_idenity as $key =>$val){
                    $this->Tribe_mdl->del_staff_idenity($val['id']);
                    unset( $staff_idenity[$key]['id']);
                    unset( $staff_idenity[$key]['mobile']);
                    unset( $staff_idenity[$key]['created_at']);
                    $staff_idenity[$key]['customer_id'] = $user_id;
                }
                $this->load->model('Customer_identity_mdl');
                $res2 = $this->Customer_identity_mdl->add_idenity_batch($staff_idenity);
            }
            
            //同步部落预录入的相册个人形象 单独更新某一个部落
            $this->load->model('Tribe_staff_album_mdl');
            $res3 = $this->Tribe_staff_album_mdl->synchro_Update($user_id);
            // if($res){
            //      $flag = true;
            // }
            
        }
        
        // 更新部落信息
        // $res = $this->tribe_mdl->update_tribe_staff($data);
        if($res1 || $res2 && $res3){
            $return = ['status' =>1, 'msg' =>'添加成功', 'data'=>$tribe_id];
        }else{
            $return = ['status' =>2, 'msg' =>'添加失败', 'data'=>$tribe_id];
        }
        
    }else{
        $return = ['status' =>0, 'msg' => '缺少参数'];
    }
    
    echo json_encode($return);
    
}

/**
 * 记录弹窗弹出次数
 *
 */
public function record_tips()
{
    
    if(!empty($this->input->get_post('tips_num'))){
        $num = $this->input->get_post('tips_num');
        
        $mobile = $this->session->userdata('mobile');
        
        if(!empty($mobile)){
            $tip = $this->tribe_mdl->update_tips($num,$mobile);
            if($tip){
                $res = $this->tribe_mdl->load_tribe_tips($mobile);
                $return = ['status' => 1, 'msg' => '记录成功','data'=>$res['tip_num']];
            }else{
                $return = ['status' => 0, 'msg' => '操作错误'];
            }
            
        }else{
            $return = ['status' => 2, 'msg' => '操作错误'];
        }
        
        
    }else{
        $return = ['status' => 3, 'msg' => '缺少参数'];
    }
    echo json_encode($return);
    
}

/**
 * 是否显示弹窗
 */
public function show_page()
{
    $status = $this->input->get_post('status');
    $mobile = $this->session->userdata('mobile');
    // 关闭
    if(isset($status) && $status == 0){
        $result = $this->tribe_mdl->show_page($mobile,$status);
        if($result){
            $return = ['status'=>1,'msg'=>'更新成功'];
        }else{
            $return = ['status'=>0,'msg'=>'更新失败'];
        }
    }
    echo json_encode($return);
}


//搜索管理员,通过部落族员的手机号码，模糊搜索
public function get_tribe_staff(){
    $params=$this->input->get(null,true);
    //        var_dump($params);die();
    
    $key=$params['key'];
    $tribe_id=$params['id']?:0;
    if( !$key){
        return;
    }
    
    //筛选排除已经被选在的
    $reject_arr=array();
    if( isset($params['reject']) & strlen($params['reject'])>0 ){
        $reject_id=$params['reject'];
        $reject_arr=explode(",",$reject_id);
        if( $reject_arr ){
            $reject_arr=array_unique($reject_arr);
        }
    }
    //        var_dump($reject_arr);die();
    
    //查找关键字，模糊查找
    $infos=$this->Tribe_mdl->get_cor_by_key($key,$tribe_id,$reject_arr);
    
    if( !$infos ){
        echo  json_encode(array());
        exit();
    }
    $arr=array();
    foreach( $infos as $key=>$val ){
        $arr[$key]['id']=$val['id'];
        $arr[$key]['text']=$val['member_name']?:$val['mobile'];
    }
    echo json_encode($arr);
}

/**
 * 根据手机号查找部落成员
 */
public function get_staff_by_mobile(){
    
    $tribe_id = $this->session->userdata("tribe_id");
    $mobile = $this->input->get_post("mobile");
    $staff = $this->tribe_mdl->get_staff_by_mobile($mobile,$tribe_id);
    if($staff){
        $tmp = [];
        foreach($staff as $val){
            $tmp[] = $val['member_name'];
        }
        $return  = ['status'=>1, 'msg'=>'success', 'staff'=>$tmp];
    }else{
        $return  = ['status'=>0, 'msg'=>'fail'];
    }
    
    echo json_encode($return);
}

/**
 * @author JF
 * 2018年3月5日
 * PC更新部落资料
 */
function AjaxUpdateTribe(){
    $shopflag = $this->input->post("shopflag");//识别背景图片是否被修改
    $bgflag = $this->input->post("bgflag");//识别banner图片是否被修改
    $contentflag = $this->input->post("contentflag");//识别简介定制图片是否被修改
    
    
    $this->load->helper("uploads");
    $this->load->helper("ps");
    
    if(CheckTribePower("/Tribe/Modifydata")){
        $tribe_id = $this->session->userdata("tribe_id");
    }else{
        $return = array(
            "status"=>"01",
            "Message"=>"对不起你暂无权限"
        );
        echo json_encode($return);exit;
    }
    
    $datetime = date("Y-m-d H:i:s");//时间
    
    
    //如果有logo上传执行
    if(array_key_exists("logo",$_FILES) && $_FILES["logo"]["error"] == 0){
        $images = file_upload("uploads/tribe/images/",null,null,"logo");
        if(!$images){
            $this->ajax_update_prompt("02","头像图片上传失败");
        }else{
            $parameter["logo"] = "uploads/tribe/images/".$images["file_name"];
        }
    }
    
    //如果有商城背景图片上传执行
    if($shopflag){
        $parameter["shop_img"] = "";
        if((array_key_exists("shop_img",$_FILES) && $_FILES["shop_img"]["error"] == 0)){
            $images = file_upload("uploads/tribe/images/",null,null,"shop_img");
            if(!$images){
                $this->ajax_update_prompt("02","商城背景图片上传失败");
            }else{
                $parameter["shop_img"] = "uploads/tribe/images/".$images["file_name"];
            }
        }
    }
    
    //如果有简介图片上传执行
    if($contentflag){
        $parameter["content_img"] = "";
        if((array_key_exists("content_img",$_FILES) && $_FILES["content_img"]["error"] == 0) ){
            $images = file_upload("uploads/tribe/images/",null,null,"content_img");
            if(!$images){
                $this->ajax_update_prompt("02","简介图片上传失败");
            }else{
                $parameter["content_img"] = "uploads/tribe/images/".$images["file_name"];
            }
        }
    }
    
    //如果有部落banner图执行
    if($bgflag){
        $bg_img = "";
        for($i=1;$i<=3;$i++){
            $banner = "banner{$i}";
            if((array_key_exists($banner,$_FILES) && $_FILES[$banner]["error"] == 0) ){
                $images = file_upload("uploads/tribe/images/",null,null,$banner);
                if(!$images){
                    $this->ajax_update_prompt("02","banner图上传失败");
                }else{
                    $bg_img .=";uploads/tribe/images/".$images["file_name"];
                }
            }
        }
        $parameter["bg_img"] = trim($bg_img,";");
    }
    
    
    $parameter["update_at"] = $datetime;
    $row = $this->tribe_mdl->save($tribe_id,$parameter);//更新部落
    if($row){
        $this->ajax_update_prompt("03","更新成功");
    }else{
        $this->ajax_update_prompt("02","更新失败");
    }
    
}




}