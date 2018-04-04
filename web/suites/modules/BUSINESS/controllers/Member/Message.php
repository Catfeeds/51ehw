<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Message extends Front_Controller {

    public $customer_id;
    
    public function __construct()
    {
        parent::__construct();
       
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            $this->session->set_userdata('ref_from_url', current_url());
            redirect('customer/login');
            exit();
        }
		
        $this->customer_id = $this->session->userdata('user_id');
    }
    
    //PC端消息首页
    public function index()
    {
        $get_data = $this->input->get();
       
        $this->load->helper('time');
        
        //时间条件
        $time_sift = array( 1=>'week',2=>'month',3=>'six_months' );
        
        //类别
        $type_list = array(0=>'不限',1=>'系统通知',2=>'订单通知',3=>'我的资产',4=>'部落通知');
 
        //时间段
        $time_list = array(0=>'不限',1=>'一个星期',2=>'一个月',3=>'半年');
        
        //时间
        if( !empty($get_data['time'] ) && !empty( $time_sift["{$get_data['time']}"]) )
        {
             $time_data = GetTime( $time_sift["{$get_data['time']}"] );
             
             if( !empty( $time_data ) )
             {
                 $sift['where']['start_time'] = $time_data['start_at'];
                 $sift['where']['end_time'] = $time_data['ent_at'];
             }
        }
       
        //类型
        if ( !empty( $get_data['type'] ) )
        { 
            $sift['where']['type'] = $get_data['type'];
        }
        
        //分页
        $current_page = 0;
        if ( !empty( $get_data['per_page'] ) )
        {
            $current_page = !empty($get_data['per_page']) ? $get_data['per_page'] : 0;  //获取当前分页页码数
        }
        
        //查询
        if( !empty( $get_data['search_name'] ) )
        { 
            $sift['like']['title'] = $get_data['search_name'];
        }
        
        //拼接搜索URL
        $url='';
        if( !empty($get_data) ){
            unset( $get_data['per_page'] );
            foreach ( $get_data as $k => $v ){
        
                $url .= '&'.$k.'='.$v;
            }
        }
        
        // 分页设置(网页版使用)
        $this->load->library ( 'pagination' );
        $config ['per_page'] = 5;
        if(0 == $current_page)
        {
            $current_page = 1;
        }
        $offset   = ( $current_page - 1 ) * $config['per_page'];
        
        
        $sift['page']['limit'] = $config['per_page'];//页数
        $sift['page']['offset'] = $offset;//偏移量
        
        //查询数据
        $sift['where']['customer_id'] = $this->customer_id;
        $this->load->model('Customer_message_mdl');
        $message_list = $this->Customer_message_mdl->Load_Customer_Message( $sift );
        
        //判断如果该页没有数据则返回。
        if( $current_page > 1 && !$message_list)
        {
            redirect('Member/Message');
        }
//         echo $this->db->last_query();
        //统计信息
        $num = $this->Customer_message_mdl->Count_Num( $sift );
        
        //配置分页参数
        $config ['base_url'] = site_url ( 'Member/Message').'?';
        $config ['suffix'] = $url;
        $config ['total_rows'] = $num['total'];
        $config ['curr_page'] = $current_page;
        $config ['num_links'] = 10;// 可以看到当前页后面的3页a连接
        $config['use_page_numbers']   = TRUE;
        $config['page_query_string']  = TRUE;
        $config['num_links'] = 3; //可以看到当前页后面的3页a连接
        $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config ['prev_tag_css'] = 'class="lPage"';
        $config ['next_link'] = '下一页';
        $config ['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $this->pagination->initialize ( $config );
        
        //view层数据
        $data['page'] = $this->pagination->create_links ();
        $data['not_read_num'] = $num['not_read'];//未读数量
        $data['total_num'] = $num['total'];//未读数量
        $data['time_list'] = $time_list;//时间列表
        $data['type_list'] = $type_list;//类型列表
        $data['per_page'] = $config ['per_page'];//每页显示多少条
        $data['url_get'] = $get_data;
        $data['foot_set'] = 1;
        $data['head_set'] = 3;
        $data['title'] = '消息通知';
        $data['list'] = $message_list;
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view('customer/message_reminder',$data);
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 统计用户未读消息
     */
    public function Not_Read_Message()
    { 
        $return['status'] = 0;
        $return['messgae'] = '获取失败';
        
        $this->load->model('Customer_message_mdl');
        $sift['where']['customer_id'] = $this->customer_id;
        $result = $this->Customer_message_mdl->Count_Num( $sift );
        
        if( $result )
        {
            $return['status'] = 1;
            $return['data'] = $result ;
            $return['messgae'] = '获取成功';
        }
        echo json_encode($return);
        
    }
    /**
     * 删除消息
     */
    public function Del_Message()
    { 
        $ids = $this->input->post('ids');
        $return['message'] = '删除失败';
        $return['status'] = 0;
        
        if( $ids )
        { 
            $this->load->model('Customer_message_mdl');
            $this->Customer_message_mdl->customer_id = $this->customer_id;
            $this->Customer_message_mdl->id = $ids;//array();
            $this->Customer_message_mdl->is_detele = 1;
            $row = $this->Customer_message_mdl->Update();
            
        }
        if( $row )
        { 
            $return['message'] = '删除成功';
            $return['status'] = 1;
        }
        
        echo json_encode($return);
    }
    
    /**
     * 修改为已读
     */
    public function Read( $id = 0)
    { 
        $return['message'] = '操作失败';
        $return['status'] = 0;
        
        if( $id )
        { 
            $this->load->model('Customer_message_mdl');
            $this->Customer_message_mdl->customer_id = $this->customer_id;
            $this->Customer_message_mdl->id = $id;
            $this->Customer_message_mdl->is_read = 1;
            $row = $this->Customer_message_mdl->Update();
        }
        
        if( $row )
        {
            $return['message'] = '删除成功';
            $return['status'] = 1;
        }
        
        echo json_encode($return);
    }
    //H5消息中心
    public function MessageCenter($app_labe_id = 0 ){
        $user_id = $this->customer_id;
        // 判断是否微信浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            //调用接口处理
            $url = $this->url_prefix.'Customer/load';
            $data_post['customer_id'] = $user_id;
            $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
             
            if(!empty($customer['mobile'])){
                $this->session->set_userdata("mobile_exist",true);
            }else{
                redirect('member/binding/binding_mobile');
            }
        
        }
        
        
        $this->load->model('Customer_message_mdl',"Message");
        //类型1系统通知2订单通知3我的资产(优惠券)4部落通知
        $section = array(1,2,3,4);
        $system_info = array();
        $order_info = array();
        $property_info = array();
        $tribe_info = array();
        $system_array = array();
        $order_array = array();
        $property_array = array();
        $tribe_array = array();
        $Msginfo = $this->Message->get_Lists($user_id,$section);
        foreach ($Msginfo as $key =>$val){
            if($val['type'] == 1){
                //全部系统通知
                $system_info[] = $Msginfo[$key];
                if($val['is_read'] == 0){
                    //系统通知未阅读
                    $system_array[] = $Msginfo[$key];
                }
            }
            if($val['type'] == 2){
                //全部系统通知
                $order_info[] = $Msginfo[$key];
                if($val['is_read'] == 0){
                    //系统通知未阅读
                    $order_array[] = $Msginfo[$key];
                }
            }
            if($val['type'] == 3){
                //全部系统通知
                $property_info[] = $Msginfo[$key];
                if($val['is_read'] == 0){
                    //系统通知未阅读
                    $property_array[] = $Msginfo[$key];
                }
            }
            if($val['type'] == 4){
                //全部系统通知
                $tribe_info[] = $Msginfo[$key];
                if($val['is_read'] == 0){
                    //系统通知未阅读
                    $tribe_array[] = $Msginfo[$key];
                }
            }
        }
        $system_count = count($system_array);
        if(count($system_info) > 0){
           $system_content  = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "$1", $system_info[0]['message']);
        }else{
            $system_content = '';
        }
        $order_count = count($order_array);
        if(count($order_info) > 0){
            $order_content  = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "$1", $order_info[0]['message']);
        }else{
            $order_content = '';
        }
        $property_count = count($property_array);
        if(count($property_info) > 0){
            $property_content  = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "$1", $property_info[0]['message']);
        }else{
            $property_content = '';
        }
        $tribe_count = count($tribe_array);
        if(count($tribe_info) > 0){
            $tribe_content  = preg_replace("/<a[^>]*>(.*?)<\/a>/is", "$1", $tribe_info[0]['message']);
        }else{
            $tribe_content = '';
        }
       
        //聊天信息
        $this->load->model('Chat_message_mdl','chat');
        
        
        //获取用户加入的所有部落
        $this->load->model('Tribe_mdl');
        $Tribes = $this->Tribe_mdl->MyTribe($user_id);
        
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
        
        $LatestLog =  $this->chat->getLatestLog($chat_channel_ids);
        $NotReadCount =  $this->chat->getAllNotReadCount($chat_channel_ids);
      
        $data['chat']['count'] = $NotReadCount;
        $data['chat']['content'] = '';
        if($LatestLog){
            if($LatestLog['message_type'] == 1){
                $content = '[图片]';
            }else if($LatestLog['message_type'] == 2){
                $content = $LatestLog['message_url'];
            }else{
                $content = $LatestLog['message'];
            }
            $data['chat']['content'] = $content;
        }
        
        $data['system']['count'] = $system_count;
        $data['system']['content'] = $system_content;
        $data['order']['count'] = $order_count;
        $data['order']['content'] = $order_content;
        $data['property']['count'] = $property_count;
        $data['property']['content'] = $property_content;
        $data['tribe']['count'] = $tribe_count;
        $data['tribe']['content'] = $tribe_content;
        
        if($app_labe_id){
            $this->load->model('Tribe_content_mdl');
            $this->load->model('Tribe_read_mdl');
            $sift['where']['customer_id'] = $user_id;
             
            $app_tribe_ids = $this->get_app_tribe_ids($app_labe_id);
            if(count($app_tribe_ids) > 0){
                $this->load->model('tribe_mdl');
                $data['is_host'] = $this->tribe_mdl->get_Mytribe($user_id,$app_tribe_ids);
                $sift['sql_status'] = true;
                $sift['where']['tribe_id'] = $app_tribe_ids;
                
                //商会下全部的公告
                $info = $this->Tribe_content_mdl->Load_List( $sift );
               
                $announce_Not_read =count($info);
                $announce_content = '';
                if($announce_Not_read > 0){
                    //已阅读数
                    $read_data = $this->Tribe_read_mdl->read_list($app_tribe_ids,$user_id,1);
                     
                    $read_count = count($read_data);
                    $announce_Not_read =  $announce_Not_read-$read_count;
                     
                    $announce_content = preg_replace("#<!--.*?-->#", "", $info[0]['title']);
                    $announce_content = strip_tags($announce_content);
                }
                $data['announcement']['count'] = $announce_Not_read;
                $data['announcement']['content'] = $announce_content;
                 
                $this->load->model('Tribe_activity_mdl');
                 
                $activity_data = $this->Tribe_activity_mdl->Load( $sift );
                $activity_Not_read =count($activity_data);
                $act_content = '';
                if($activity_Not_read > 0){
                    //已阅读数
                    $act_read_data = $this->Tribe_read_mdl->read_list($app_tribe_ids,$user_id,2);
               
                    $act_read_count = count($act_read_data);
                   
                    $activity_Not_read =  $activity_Not_read - $act_read_count;
                     
                    $act_content = preg_replace("#<!--.*?-->#", "", $activity_data[0]['name']);
                    $act_content = strip_tags($act_content);
                     
                }
                $data['activity']['count'] = $activity_Not_read;
                $data['activity']['content'] = $act_content;
            }else{
                $data['announcement']['count'] = 0;
                $data['announcement']['content'] = "";
                $data['activity']['count'] = 0;
                $data['activity']['content'] = "";
            }
            
        }
        
       
        $data['label_id'] = $app_labe_id;
       
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $data['title'] = '消息中心';
        
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view('customer/news_centre.php',$data);
        if($app_labe_id){
            $data['choose_foot'] = 2;
            $this->load->view('commerce/foot',$data);
        }
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
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
    
    
    public function  Notification(){
        $type = $this->input->get_post("type");
        if(empty($type)){//默认系统通知
            $type = 1;
        }
        
        $data['user_id'] = $this->customer_id;
        $data['type'] =$type;
        //类型1系统通知2订单通知3我的资产(优惠券)4部落通知
        switch($type){
            case 1 :
                $title = '系统';
                break;
            case 2 :
                $title = '订单';
                break;
            case 3 :
                $title = '资产';
                break;
            case 4 :
                $title = '部落';
                break;
        }
        
        $data['foot_set'] = 1;
        $data['head_set'] = 2;
        $data['title'] = $title.'通知';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view('customer/news_inform.php',$data);
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
        
    }
   
    
    public function ajax_list(){
        $type = $this->input->get_post("type");
        $user_id = $this->customer_id;
        
        $page = $this->input->get_post('page');
        $pagesize = 4;
        if($page == 1){
            $page = 0;
        }else{
            $page   = ($page - 1 ) * $pagesize;
        }
        $data['page']['limit'] = $pagesize;
        $data['page']['offset'] = $page;
        
        $data['where']['customer_id'] = $user_id;
        $data['where']['type'] = $type;
        $this->load->model('Customer_message_mdl',"Message");
        
       
        $info['list'] =  $this->Message->Load_Customer_Message($data);//获取推送信息列表
        
        $this->Message->update_batch($user_id,$type);
        echo json_encode($info);
    }
}