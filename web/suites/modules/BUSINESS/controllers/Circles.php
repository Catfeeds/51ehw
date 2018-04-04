<?php

/**
 *
* @author fxm
* 圈子--基于部落
*/
class Circles extends Front_Controller
{
    public $customer_id;
    public $tribe_id;
    
    function __construct()
    {
        parent::__construct();
       
        // 判断用户是否登录
        if (! $this->session->userdata('user_in') ) 
        {
            redirect('customer/login');
            exit();
        }
        
        $this->customer_id  = $this->session->userdata("user_id");
        $tribe_id = $this->input->get_post('tribe_id');
        
        if( $tribe_id && is_numeric( $tribe_id ) && strpos( $tribe_id,'.') == false)
        {   
            $this->load->model('tribe_mdl');
            $tribe_info = $this->tribe_mdl->load( $tribe_id,$this->customer_id );
          
            if( !$tribe_info )
            { 
                //部落不存在，或未通过。
                echo "<script>history.back(-1);alert('部落不在，无法访问');</script>";exit;
                
            }else if( !$tribe_info["tribe_staff_id"] || $tribe_info['status'] != 2 )
            { 
                //未加入该部落
                echo "<script>history.back(-1);alert('未加入该部落，无法访问');</script>";exit;
            } 
        }else{ 
            //未加入该部落
            echo "<script>history.back(-1);alert('参数错误');</script>";exit;
        }  
        
        $this->tribe_id = $tribe_id; 
        $this->bg_img = $tribe_info['ts_bg_img'];
        $this->member_name = $tribe_info['member_name'];
        $this->tribe_name = $tribe_info['name'];
        $this->real_name = $tribe_info['real_name'];
        $this->tribe_staff_id = $tribe_info['tribe_staff_id'];
        $this->tribe_role_id = $tribe_info['tribe_role_id'];
        
        $this->load->model("tribe_mdl");
        $tribe = $this->tribe_mdl->ManagementTribe($this->customer_id,$tribe_id);
        $is_host = 0;
        if($tribe){
            $is_host = 1;
        }
        
        $this->is_host = $is_host;
        $this->load->helper('format_time');
    }

    private function Check_Tribe()
    { 
        
    }
    //主页
    public function index( $label_id = '' )
    {   
        
//         $time2 = '2017-07-05 15:37:12'; //测试格式化时间
//         echo format_time($time2);
        $sift['where']['to_customer_id'] = $this->customer_id;
        $sift['where']['tribe_id'] = $this->tribe_id;
        $sift['where']['is_read'] = 1;
        
        $this->load->model('Tribe_message_mdl');
        $not_read_num = $this->Tribe_message_mdl->Not_Read_Num( $sift );
        
        $data['label_id'] = $label_id;
        $data['title'] = $this->tribe_name;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['tribe_id'] = $this->tribe_id;
        $data['bg_img'] = $this->bg_img;
        $data['member_name'] = $this->member_name;
        $data['real_name'] = $this->real_name;
        $data['img_avatar'] = $this->session->userdata('img_avatar');
        $data['not_read_num'] = $not_read_num;//新消息
       
        

        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('circles/index.php', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
   
    
    /**
     * 创建话题显示页面
     */
    public function Add_Topic($status = 0)
    {
        $data['role'] = $this->is_host == 1 ? true : false;
        $data['title'] = "创建话题";
        $data['tribe_id'] = $this->tribe_id;
        $data ['head_set'] = 2;
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type =='APP' ){
            $data['head_set'] = 3;
        }
        $data['foot_set'] = 1;
        $data['status'] = $status;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('circles/circles_add_topic', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 我发布的话题列表
     */
    public function My_Topic()
    {
        $data['title'] = "我发布的话题";
        $data ['head_set'] = 2;
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type =='APP' ){
            $data['head_set'] = 3;
        }
        $data['role'] = $this->is_host == 1 ? true : false;
        $data ['foot_set'] = 1;
        $data['tribe_id'] = $this->tribe_id;
        $data['member_name'] = $this->member_name;
        $data['real_name'] = $this->real_name;
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('circles/circles_my_topic', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 我收到的消息
     * 1 = 最新消息
     */
    public function My_Message( $status = 0 )
    {
        $sift['where']['to_customer_id'] = $this->customer_id;
        $sift['where']['tribe_id'] = $this->tribe_id;
        $sift['where']['is_read'] = $status == 1 ? $status : 2;
        
        $this->load->model('Tribe_message_mdl');
        $list = $this->Tribe_message_mdl->Load( $sift );
//         echo $this->db->last_query();
        if( $status == 1 )
        { 
            //更新为已读
             $sift['set']['is_read'] = 2;
             $this->Tribe_message_mdl->Update( $sift );
//              echo $this->db->last_query();
            
        }
        $data['title'] = $status ? "最新消息" : "历史消息";
        $data ['head_set'] = 2;
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type =='APP' ){
            $data['head_set'] = 3;
        }
        $data ['foot_set'] = 1;
        $data ['status']  = $status;
        $data['list'] = $list;
        $data['tribe_id'] = $this->tribe_id;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('circles/circles_my_message', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 话题详情
     */
    public function Topic_Detaile( $id = 0 )
    {

      
        $sift['where']['tribe_id'] = $this->tribe_id;
        $sift['where']['id'] = $id;
        $sift['where']['customer_id'] = $this->customer_id;
        $sift['return_row'] = true;
        $this->load->model('Tribe_topic_mdl');
        $topic_detaile = $this->Tribe_topic_mdl->Load( $sift );
      
        $upvote_info=  $this->Tribe_topic_mdl->topic_upvote_member_name($topic_detaile['id']);
        $topic_detaile['upvote_info'] = $upvote_info;
      
        $data['customer_id'] = $this->customer_id;
        $data['title'] = "话题详情";
        
        $data['head_set'] = 2;
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type =='APP' ){
            $data['head_set'] = 3;
        }
//         echo '<pre>';
//         print_r($topic_detaile);exit;
      
        $data['member_name'] = $this->member_name;
        $data['real_name'] = $this->real_name;
        $data['tribe_name'] = $this->tribe_name;
        $data['foot_set'] = 1;
        $data['tribe_id'] = $this->tribe_id;
        $data['topic_detaile'] = $topic_detaile;
     
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('circles/circles_topic_detaile', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }

    /**
     * 举报页面
     */
    public function Complaints( $id = 0 )
    {


        $data['title'] = "话题举报";
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $data['obj_id'] = $id;
        $data['tribe_id'] = $this->tribe_id;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('circles/circles_report.php', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 评论页面
     */
    public function Comment( $id )
    { 
        $to_name = $this->input->get('to_name');
        $parent_id = $this->input->get('parent_id');
        $to_customer_id = $this->input->get('to_customer_id');
        $content_obj_id = $this->input->get('content_obj_id');
        
        //消息中回复缺少参数parent_id 通过$content_obj_id获得
        if( !(0 == $content_obj_id) )
        {
            $this->load->model('Tribe_comment_mdl');
            $comment_info = $this->Tribe_comment_mdl->Load_Row( $content_obj_id );
            $parent_id = $comment_info['parent_id'] == 0 ? $content_obj_id : $comment_info['parent_id'];
            
        }
        
        $data['to_name'] = $to_name;
        $data['parent_id'] = $parent_id;
        $data['to_customer_id'] = $to_customer_id;
        $data['content_obj_id'] = $content_obj_id;
        $data['title'] = "评论";
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['obj_id'] = $id;
        $data['tribe_id'] = $this->tribe_id;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('circles/circles_topic_comment', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 异步加载话题。
     */
    public function Topic_List( $status = 0 )
    {
        
        $page = $this->input->get('page');
        
        if( !$page  || !is_numeric($page) || !is_int($page+0)  )
        {
            $page = 10;
        }
        
        $limit = 10;
        $offset = ( $page-1 ) * $limit;//偏移量
        
        $sift['page']['limit'] = $limit;
        $sift['page']['offset'] = $offset;
        $sift['where']['tribe_id'] = $this->tribe_id;
        $sift['where']['customer_id'] = $this->customer_id;
        $this->load->model('Tribe_topic_mdl');
        
     
        if( !$status )
        {    //部落主页话题
            $list = $this->Tribe_topic_mdl->Load( $sift );
        }else{ 
            //我发布的话题
            $list = $this->Tribe_topic_mdl->My_Topic_List( $sift );
        }
        foreach ($list as $key =>$val){
            $upvote_info =  $this->Tribe_topic_mdl->topic_upvote_member_name($val['id']);
            $list[$key]['upvote_info'] = array();
            if(count($upvote_info) > 0){
                $list[$key]['upvote_info'] =$upvote_info;
            }
        }
        
//         echo $this->db->last_query();
        $return['list'] = $list;
        $return['status'] = 1;
//         echo '<pre>';
//         print_r($list);exit;
    
        echo json_encode( $return );
    }
    
    /**
     * 动态点赞
     */
    public function Add_Upvote()
    { 
        $obj_id = $this->input->get('obj_id');
        
        
        
        $sift_A['where']['tribe_id'] = $this->tribe_id;
        $sift_A['where']['id'] = $obj_id;
        $this->load->model('Tribe_topic_mdl');
        $topic_detaile = $this->Tribe_topic_mdl->Load_Row( $sift_A );
        
        if( $topic_detaile )
        {
            $sift['where']['obj_id'] = $obj_id;
            $sift['where']['customer_id'] = $this->customer_id;
            $sift['where']['type'] = 1;
            $this->load->model('Tribe_upvote_mdl');
            
            
            if( $this->Tribe_upvote_mdl->Load( $sift ) )
            {
                //删除点赞
                $row = $this->Tribe_upvote_mdl->Del( $sift );
                $type = 1;
                
            }else{
                //添加
                $row = $this->Tribe_upvote_mdl->Create( $sift['where'] );
                $type = 2;
                
                if( $row )
                {
                    //推送消息
                    $messgae_data['to_customer_id'] =  $topic_detaile['customer_id'];
                    $messgae_data['form_customer_id'] = $this->customer_id;
                    $messgae_data['tribe_id'] = $this->tribe_id;
                    $messgae_data['obj_id'] = $obj_id;
                    $messgae_data['content_obj_id'] = $row;
                    $messgae_data['type'] = 2;
                    $this->load->model('Tribe_message_mdl');
                    $this->Tribe_message_mdl->Create( $messgae_data );
                }
                
            }
        }
        
        $return['status'] = $row ? 1 : 0;
        $return['data']['type'] = $type;
        
        echo json_encode($return);
    }
    /**
     * 发布话题。
     */
    public function Create_Topic()
    {
        $data_post = $this->input->post();
        
        $images = '';
        $files =  empty($data_post['file']) ? false:$data_post['file'];
        if( $files )
        {
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($data_post['add_img'],',') );
             
            // 图片 初始化数据
            $save_path = "uploads/teibe_".$this->tribe_id.'/topic/';
        
            $path = FCPATH.UPLOAD_PATH. $save_path;
        
            if ( !file_exists( $path ) )
            {
                mkdir($path,0777,true);
            }
            $multip = array();//记录该上传的图片  避免重复上传
            //处理要上传的图片写入文件夹  不需要的的则不处理
            foreach ($img_add as $key => $val){
                foreach ($files as $k => $v){
                    if($val == $v['pic_sign']){
                        if(!in_array($key, $multip)){
                            $pic = $v['pic'];
                            $temp = explode('.',$v['pic_name'])[1];
                            //处理64位
                            $base64    = substr(strstr($pic, ","), 1);
                            $image_res = base64_decode($base64);
                            $pic_path = $save_path.date("YmdHis").rand(0,999999).'.'.$temp;
                            $res = file_put_contents(FCPATH.UPLOAD_PATH.$pic_path ,$image_res);
                            if($res){
                                $images .= $pic_path.';';
                                $multip[] = $key;
                            }
                        }     
                    }
                }
            }
        }
        
        //添加数据
        $data['images'] = $images;
        $data['tribe_id'] = $this->tribe_id;
        $data['content'] = $data_post['content'];
        $data['customer_id'] = $this->customer_id;
        
        
       
        if( !empty( $data_post['is_top'] ) )
        {
            $data['sort'] = 1;
        
//允许多个话题置顶  18 0126
//             //取消以前的旧置顶
//             $sift['where']['sort'] = 1;
//             $sift['set']['sort'] = 0;
//             $sift['where']['tribe_id'] = $this->tribe_id;
        
//             $this->load->model('Tribe_topic_mdl');
//             $this->Tribe_topic_mdl->Update( $sift );
        }
        
        
        $this->load->model('Tribe_topic_mdl');
        $id = $this->Tribe_topic_mdl->Create( $data );
        
         
        
        $return['status'] = $id ? true : false;
        
        if( $id )
            $return['id'] = $id;
        
            echo json_encode($return);
        
        
    }
    
    /**
     * 发布话题。
     */
    public function Create_Topic1()
    { 
      
        $data_post = $this->input->post();
        
        $images = '';
     
        if( !empty( $_FILES['file'] ) )
        {
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($data_post['add_img'],',') );
           
            // 图片 初始化数据
            $save_path = "uploads/teibe_".$this->tribe_id.'/topic/';
            
            $path = FCPATH.UPLOAD_PATH. $save_path;
            
            if ( !file_exists( $path ) )
            {
            
                mkdir(iconv("UTF-8", "GBK", $path),0777,true);
            }
           
            //重新组合一个$_FILES中的格式 使其变为和上传单个文件的数据格式类似
            foreach($_FILES['file'] as $index => $vals)
            {
                if( $vals )
                {
                   
                   foreach ($vals as $i => $val) 
                   {
                       $file_map[$i]['file'][$index] = $val;
                   }
                }
            }
           
            $this->load->library('upload');
            
            foreach ( $file_map as $key=>$files ) 
            {
                 
                if( $files['file']['name']  ) 
                {
                    
                    $img_flag = $files['file']['name'].$files['file']['size'];
                    $img_key = array_search($img_flag,$img_add);
                    
                    if( ( $img_key === 0 || $img_key ) )
                    {
                        $config['upload_path'] = $path;
                        $config['file_name'] = date("YmdHis").rand(0,999999);
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
//                         $config['max_size'] = 1024 * 1024 * 3;

                        //遍历   这样每次都去覆盖掉$_FILES中的数据 （PS：这样覆盖后，$_FILES格式就和上传单个文件的格式是一模一样的了）
                        $_FILES = $files;
                        $this->upload->initialize($config);
                        
                        if( $this->upload->do_upload("file") )
                        { 
                            $img = $this->upload->data();
                            
                            $images .= $save_path.$img['file_name'].';';
                        }
                        unset($img_add[$img_key]);
                    }
                }

            }
            
        }
        
        //添加数据
        $data['images'] = $images;
        $data['tribe_id'] = $this->tribe_id;
        $data['content'] = $data_post['content'];
        $data['customer_id'] = $this->customer_id;
        
        if( !empty( $data_post['is_top'] ) )
        {
            $data['sort'] = 1;
            
            //取消以前的旧置顶
//             $sift['where']['sort'] = 1;
//             $sift['set']['sort'] = 0;
//             $sift['where']['tribe_id'] = $this->tribe_id;
            
//             $this->load->model('Tribe_topic_mdl');
//             $this->Tribe_topic_mdl->Update( $sift );
        }
        
        $this->load->model('Tribe_topic_mdl');
        $id = $this->Tribe_topic_mdl->Create( $data );
        
       
        
        $return['status'] = $id ? true : false;
        
        if( $id )
            $return['id'] = $id;
        
        echo json_encode($return);
        
    }
    
    
    /**
     * 添加评论
     */
    public function Add_Comment()
    { 
        $obj_id = $this->input->post('obj_id');
        $content = $this->input->post('content');
        $to_customer_id = $this->input->post('to_customer_id');
        $parent_id = $this->input->post('parent_id');
       
        //查询话题。
        $sift['where']['tribe_id'] = $this->tribe_id;
        $sift['where']['id'] = $obj_id;
        $this->load->model('Tribe_topic_mdl');
        $topic_detaile = $this->Tribe_topic_mdl->Load_Row( $sift );
        
        if( $topic_detaile )
        {
            
            //添加评论
            $data['content'] = $content;
            $data['tribe_id'] = $this->tribe_id;
            $data['obj_id'] = $obj_id;
            $data['customer_id'] = $this->customer_id;
            $this->load->model('Tribe_comment_mdl');
            
            
            if( !(0 == $to_customer_id) && !(0 == $parent_id) )
            { 
                $data['parent_id'] = $parent_id;
                $data['to_customer_id'] = $to_customer_id;
                $huifu = true;
                
            }
            
            $id = $this->Tribe_comment_mdl->Create( $data );
            
            if( $id )
            { 
                
                //推送消息
                $messgae_data['to_customer_id'] = !empty( $huifu ) ? $to_customer_id : $topic_detaile['customer_id'];
                $messgae_data['form_customer_id'] = $this->customer_id;
                $messgae_data['tribe_id'] = $this->tribe_id;
                $messgae_data['obj_id'] = $obj_id;
                $messgae_data['content'] = $content;
                $messgae_data['content_obj_id'] = $id;
                $messgae_data['type'] = 1;
                $this->load->model('Tribe_message_mdl');
                $this->Tribe_message_mdl->Create( $messgae_data );
                
            }
            
            $return['status'] = $id ? true : false;
            $return['message'] = $id ? '发送成功' : '发送失败';
            
        }else{ 
            
            $return['status'] =  false;
            $return['message'] = '话题不存在无法发表评论';
        }
        echo json_encode( $return );
    }
    
    
    /**
     * 举报
     */
    public function Add_Complaints()
    { 
        
        $return['status'] = false;
        $return['message'] = '举报失败';
        
        $data['obj_id'] = $this->input->post('id');
        $data['content'] = $this->input->post('message');
        $data['customer_id'] = $this->customer_id;
        $data['tribe_id'] = $this->tribe_id;
        $sift['where']['tribe_id'] = $this->tribe_id;
        $sift['where']['id'] = $data['obj_id'];
        $this->load->model('Tribe_topic_mdl');
        $topic_detaile = $this->Tribe_topic_mdl->Load_Row( $sift );
        $is_complaints = $this->Tribe_topic_mdl->topic_is_complaints( $data['obj_id'],$data['customer_id']);
       
        if($is_complaints){
            $return['message'] = '您已经举过报该话题了';
            $return['status'] = 1;
        }else{
            if( $topic_detaile )
            {
                $this->db->insert('tribe_complaints',$data);

                if( $this->db->insert_id() )
                {
                    $return['message'] = '举报成功';
                    $return['status'] = 1;
                }

            }else{

                $return['message'] = '该话题不存在，无法举报';
                $return['status'] = 2;
            }
        }

        echo json_encode($return);
    }
    
   
    /**
     * 更换背景图片
     */
    public function Update_Background()
    { 
       
    	
        if( !empty( $_FILES['file'] ) )
        {
             
            $return['status'] = false;
            
            // 图片 初始化数据
            $save_path = "uploads/teibe_".$this->tribe_id.'/background/';
        
            $path = FCPATH.UPLOAD_PATH. $save_path;
        
            if ( !file_exists( $path ) )
            {
        		$this->load->helper("ps");
        		mkdirsByPath($path);
            }
        
            $this->load->library('upload');
        
            
            if( $_FILES['file']['name'] )
            {
                $config['upload_path'] = $path;
                $config['file_name'] = date("YmdHis").rand(0,999999);
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
              
                $this->upload->initialize($config);
    
                if( $this->upload->do_upload("file") )
                {
                    $img = $this->upload->data();
    
                    $images = $save_path.$img['file_name'];
                    
                    $data['bg_img'] = $images;
                    $data['id'] = $this->tribe_staff_id;
                    $row = $this->tribe_mdl->update_member( $data );
                }
            }
        }
        
        if( !empty( $row ) )
        {
            $return['status'] = 1;
            $return['data'] = IMAGE_URL.$images;
        }
        
        echo json_encode( $return );
    }
    
    /**
     * 置顶话题
     */
    public function Upadte_Topic( $id )
    { 
        
        if( $this->is_host == 1 )
        {
            //取消以前的旧置顶
//             $sift['where']['sort'] = 1;
//             $sift['set']['sort'] = 0;
//             $sift['where']['tribe_id'] = $this->tribe_id;
            
            $this->load->model('Tribe_topic_mdl');
//             $this->Tribe_topic_mdl->Update( $sift );
            
//             unset( $sift['where']['sort'] );

            
            $sift['where']['tribe_id'] = $this->tribe_id;
            $sift['where']['id'] = $id;
            $sift['where']['customer_id'] = $this->customer_id;
            $sift['return_row'] = true;
            
            $topic_detaile = $this->Tribe_topic_mdl->Load( $sift );
            if($topic_detaile['sort']){
                $sift['set']['sort'] = 0;
            }else{
                $sift['set']['sort'] = 1;
            }
            $sift['where']['id'] = $id;
            $sift['where']['tribe_id'] = $this->tribe_id;
            
            $row = $this->Tribe_topic_mdl->Update( $sift );
           
            $return['message'] = $row ? '操作成功' : '操作失败';
            $return['status'] = $row ? true : false ;
            //置顶目标话题
            
        }else{ 
            
            $return['message'] = '无权操作';
            $return['status'] = false;
        }
        
        echo json_encode( $return );
    }
    /**
     * 异步加载评论
     */
    public function Topic_Comment( $id )
    { 
           
        $page = $this->input->get('page');
        
        if( !$page  || !is_numeric($page) || !is_int($page+0)  )
        {
            $page = 10;
        }
        
        $limit = 10;
        $offset = ( $page-1 ) * $limit;//偏移量
        
        $sift['page']['limit'] = $limit;
        $sift['page']['offset'] = $offset;
        
      
        $sift['where']['obj_id'] = $id;
        $sift['where']['type'] = 1;
        $sift['where']['tribe_id'] = $this->tribe_id;
       
       
        $this->load->model('Tribe_comment_mdl'); 
        $list = $this->Tribe_comment_mdl->Load( $sift );
       
        $return['list'] = $list;
        $return['status'] = 1;
        echo json_encode( $return );
      
    }
    
    /**
     * 清空收到的历史消息
     */
    public function Delete_Message()
    {
    
        $sift['where']['to_customer_id'] = $this->customer_id;
        $sift['where']['tribe_id'] = $this->tribe_id;
        $sift['where']['is_read'] = 2;
    
        $this->load->model('Tribe_message_mdl');
    
        //删除
        $row = $this->Tribe_message_mdl->Delete( $sift );
    
        $return['status'] = $row ? true : false;
        $return['message'] = $row ? '清空成功' : '清空失败';
        echo json_encode( $return );
    }
    
    
    /**
     * 异步删除评论
     */
    public function Delete_Comment( $id = 0 )
    { 
        if( !(0 == $id) )
        {
            $sift['where']['id'] = $id;
            $sift['where']['customer_id'] = $this->customer_id;
            $sift['set']['is_delete'] = 1;
           
            $this->load->model('Tribe_comment_mdl');
            $row = $this->Tribe_comment_mdl->Update( $sift );
            
        }
        
        $return['status'] = !empty( $row ) ? true : false;
        $return['message'] = !empty( $row ) ? '删除成功' : '删除失败';
        
        echo json_encode($return);
    }
    
    
    /**
     * 异步删除话题
     */
    public function Delete_Topic( $id = 0)
    { 
        
        if( !(0 == $id) )
        {
            $sift['where']['id'] = $id;
            $sift['where']['tribe_id'] = $this->tribe_id;
            $sift['where']['customer_id'] = $this->customer_id;
            $sift['set']['status'] = 0;
            
            $this->load->model('Tribe_topic_mdl');
            $row = $this->Tribe_topic_mdl->Update( $sift );
            
        }
        
        $return['status'] = !empty( $row ) ? true : false;
        $return['message'] = !empty( $row ) ? '删除成功' : '删除失败';
        
        echo json_encode($return);
    }
    
    
}