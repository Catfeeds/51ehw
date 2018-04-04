<?php

/**
* @author JF
* 2017年11月10日
* 企业形象
*/
class Corporation_style extends Front_Controller
{
    public $customer_id;
    
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
        $this->load->model('corporationstyle_topic_mdl');
    }


    /**
     * 进入某个用户发布的话题列表
     * @param int $user_id 用户id
     */
    public function User_Topic($user_id = 0)
    {
    	$customer_id = $this->customer_id;//用户Id
    	$me = false;//默认不是查看自身话题
    	$this->load->model("customer_mdl");
    	$this->load->model("corporationstyle_message_mdl");
    	
    	$user_info = $this->customer_mdl->load($user_id);//查询用户信息
    	if(!$user_info){
    		echo "<script>history.back();</script>";exit;
    	}
    	
    	//如果自己的话题则查看通知条数
    	$letter_total = array();
    	if($user_id == $customer_id){
    		$letter_total = $this->corporationstyle_message_mdl->Not_Read_Num($customer_id);//查看通知条数
    		$me = true;
    	}
    	
    	$data["message_total"] = $letter_total;
    	$data["customer_id"] = $customer_id;
    	$data["user_info"] = $user_info;
    	$data["me"] = $me;
    	$data["real_name"] = $user_info["real_name"]?$user_info["real_name"]:$user_info["name"];//用户名称
        $data['title'] = "产品展示";
        $data ['head_set'] = 2;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporationstyle/user_topic', $data);
    }

    /**
     * 我收到的消息
     */
    public function My_Message()
    {
        $customer_id = $this->customer_id;
        
        $this->load->model('corporationstyle_message_mdl');

        $list = $this->corporationstyle_message_mdl->Load( $customer_id );//查询未读消息列表
        
        $row = $this->corporationstyle_message_mdl->Update( $customer_id );//更新消息已读
      
        
        $data['list'] = $list;
        $data['title'] = "最新消息";
        $data ['head_set'] = 2;
        $data ['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporationstyle/my_message', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }


    
    /**
     * 评论页面
     * @param number $obj_id 对象id
     * @param number $id  回复id
     * @param string $to_name 被回复名字
     */
    public function Comment($obj_id =0 , $id=0 , $to_name = null)
    { 

        $data['to_name'] = urldecode($to_name);
        $data['id'] = $id;
        $data["obj_id"] = $obj_id;
        $data['title'] = "评论";
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporationstyle/topic_comment', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * ajax加载某个用户 or 部落话题
     */
    public function Topic_List()
    {
    	$tribe_id = $this->input->post("tribe_id");//部落id
    	$user_id = $this->input->post("user_id");//某个人的用户id
    	$customer_id = $this->customer_id;
    	$return = array();
    	//分页
        $page = $this->input->post('page');
        if( !$page  || !is_numeric($page) || !is_int($page+0)  )
        {
            $page = 1;
        }
        $limit = 5;
        $offset = ( $page-1 ) * $limit;//偏移量
        
        
        $this->load->model("Corporationstyle_comment_mdl");

        $topic_list = $this->corporationstyle_topic_mdl->Load($tribe_id,$user_id,$limit,$offset);//查询话题列表
        if($topic_list){
       
            
            $topicids = array_column($topic_list,"id");
            
            //查询点赞人员信息
            $UpvoteList = $this->corporationstyle_topic_mdl->topic_upvote_member_name($topicids);
            $TempUpvoteList = array();
            foreach ($UpvoteList as $k => $v){
                $TempUpvoteList[$v["id"]][] = $v;
            }
            
            //查询话题评论
            $CommentList = $this->Corporationstyle_comment_mdl->Load($topicids,$tribe_id);
            $TempTopicList = array();
            foreach ($CommentList as $k => $v){
                $TempTopicList[$v["obj_id"]][] = $v;
            }
            
            //处理数据
            foreach ($topic_list as $k => $v){
                if(!empty($TempUpvoteList[$v["id"]])){
                    $topic_list[$k]["upvote_info"] = $TempUpvoteList[$v["id"]];
                }
                
                if(!empty($TempTopicList[$v["id"]])){
                    $topic_list[$k]["comment"] = $TempTopicList[$v["id"]];
                }
            }

        }
       	$return["topic_list"] = $topic_list;

        echo json_encode( $return );
    }
    

    
    /**
     * 动态点赞
     */
    public function Add_Upvote()
    { 
        $obj_id = $this->input->post('obj_id');//对象id
        $customer_id = $this->customer_id;
        
        
        $this->load->model('Corporationstyle_upvote_mdl');
        $this->load->model("corporationstyle_message_mdl");
        
        $topic_detaile = $this->corporationstyle_topic_mdl->Load_Row( $obj_id );//查询话题是否存在
        if( $topic_detaile )
        {
            //判断是否点赞
        	if( $this->Corporationstyle_upvote_mdl->Load( $customer_id, $obj_id))
            {
            	$row = $this->Corporationstyle_upvote_mdl->Del( $customer_id,$obj_id ); //删除点赞
            	$type = 1;
            }else{
                //添加
            	$param = array(
            			"customer_id" => $customer_id,
            			"obj_id" => $obj_id
            	);
            	$row = $this->Corporationstyle_upvote_mdl->Create( $param );
                if( $row )
                {
                	$type = 2;
                    //推送消息
                    $messgae_data['to_customer_id'] =  $topic_detaile['customer_id'];
                    $messgae_data['form_customer_id'] = $this->customer_id;
                    $messgae_data['obj_id'] = $obj_id;
                    $messgae_data['content_obj_id'] = $row;
                    $messgae_data['type'] = 2;
                    $this->corporationstyle_message_mdl->Create( $messgae_data );
                }
                
            }
        }
        
        $return['status'] = !empty($row) ? 1 : 0;
        $return['type'] = $type;
        
        echo json_encode($return);
    }
    
    /**
     *  发布话题。
     */
    public  function  Add_Topic(){
        $data['head_set'] = 2;
        $data['title'] = "发布企业展示";
        $data['foot_set'] = 1;
       
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporationstyle/create_topic', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    
    /**
     * 发布话题。
     */
    public function Create_Topic()
    {
        $user_id =  $this->session->userdata("user_id");
        $this->load->model('Tribe_mdl');
        $tribe_info = $this->Tribe_mdl->MyTribe($user_id);
        if(!$tribe_info){
            $return['status'] = false;
            echo json_encode($return);
            exit;
        }

        $add_img = $this->input->post("add_img"); 
        $files = $this->input->post("file");
        $content = $this->input->post("content");
        
        
        if(!$files && !$content){
            $return['status'] = false;
            echo json_encode($return);
            exit;
        }
        
        $images = '';
        if($files)
        {
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($add_img,',') );
            // 图片 初始化数据
            $save_path = "uploads/Corporation_style/$user_id/topic/";
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
        $data['images'] = !empty($images)?$images:null;
        $data['content'] = !empty($content)?$content:null;
        $data['customer_id'] = $user_id;
        $this->load->model('Corporationstyle_topic_mdl');
        $id = $this->Corporationstyle_topic_mdl->Create( $data );
        
        
        $return['status'] = $id ? true : false;
        $return['id'] = $id;
        echo json_encode($return);
    }
    
    /**
     * 发布话题。
     */
    public function Create_Topic1()
    { 
        
        $user_id =  $this->session->userdata("user_id");
        
        $this->load->model('Tribe_mdl');
        $tribe_info = $this->Tribe_mdl->MyTribe($user_id);
        if(!$tribe_info){
            $return['status'] = false;
            echo json_encode($return);
            exit;
        }
      
      
        $data_post = $this->input->post();
        
        $images = '';

        if( !empty( $_FILES['file'] ) )
        {
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($data_post['add_img'],',') );
           
            // 图片 初始化数据
            $save_path = "uploads/Corporation_style/$user_id/topic/";
            
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
        $data['content'] = $data_post['content'];
        $data['customer_id'] = $user_id;
      
        
        $this->load->model('Corporationstyle_topic_mdl');
        $id = $this->Corporationstyle_topic_mdl->Create( $data );
        
       
        
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
        $obj_id = $this->input->post('obj_id');//对象id
        $content = $this->input->post('content');//内容
        $id = $this->input->post('id');//回复id
        $customer_id = $this->customer_id;
        
       $this->load->model("corporationstyle_comment_mdl");
       $this->load->model('corporationstyle_message_mdl');
        
        $topic_detaile = $this->corporationstyle_topic_mdl->Load_Row( $obj_id );//查询话题。
        if( $topic_detaile )
        {
        	if($id){
        		$comment = $this->corporationstyle_comment_mdl->Load_Row($id,$obj_id);//查询评论信息
        		if($comment){
        			$data["to_customer_id"] = $comment["customer_id"];
        			$data["parent_id"] = $id;
        		}
            }
            //添加评论
            $data['content'] = $content;
            $data['obj_id'] = $obj_id;
            $data['customer_id'] = $customer_id;
            $id = $this->corporationstyle_comment_mdl->Create( $data );//创建评论
            if( $id )
            { 
                
                //推送消息
            	$messgae_data['to_customer_id'] = !empty( $comment["customer_id"] ) ? $comment["customer_id"] : $topic_detaile['customer_id'];
                $messgae_data['form_customer_id'] = $customer_id;
                $messgae_data['obj_id'] = $obj_id;
                $messgae_data['content'] = $content;
                $messgae_data['content_obj_id'] = $id;
                $messgae_data['type'] = 1;
                
                $this->corporationstyle_message_mdl->Create( $messgae_data );
                
            }
            
            $return['status'] = $id ? true : false;
            $return['message'] = $id ? '评论成功' : '评论失败';
            
        }else{ 
            
            $return['status'] =  false;
            $return['message'] = '话题不存在无法发表评论';
        }
        echo json_encode( $return );
    }
  
    
    
    /**
     * 异步删除话题
     */
    public function Delete_Topic()
    { 
    	$id = $this->input->post("id");//话题id
        if( !(0 == $id) )
        {
            $customer_id = $this->customer_id;
            $param['status'] = 0;
            $row = $this->corporationstyle_topic_mdl->Update($id,$customer_id,$param );
        }
        
        $return['status'] = !empty( $row ) ? true : false;
        $return['message'] = !empty( $row ) ? '删除成功' : '删除失败';
        
        echo json_encode($return);
    }
    
    
}