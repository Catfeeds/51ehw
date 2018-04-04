<?php

/**
* @author JF
* 2017年11月10日
* 企业形象
*/
class Corporation_style extends Api_Controller
{
    public $customer_id;
    
    function __construct()
    {
        parent::__construct();
       
       
        $customer_id = $this->session->userdata("user_id");
        //检查登录
        if ($customer_id == null || $customer_id == "") {
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '5',
                    'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        $this->customer_id = $customer_id;
        $this->load->model('corporationstyle_topic_mdl');
    }

    
    
    /**
     * 进入某个用户发布的话题列表
     * @param int $user_id 用户id
     */
    public function User_Topic()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
                'user_id'
        ));
        $user_id = $prams["user_id"];
        $customer_id = $this->customer_id;//用户Id
        $this->load->model("customer_mdl");
        
        $user_info = $this->customer_mdl->load($user_id);//查询用户信息
        if(!$user_info){
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '用户不存在'
            );
            print_r(json_encode($return));
            exit();
        }
        
        //判断是否进入自己的话题列表
        $me = false;
        if($user_id == $customer_id){
            $me = true;
        }
        
        $return["data"]["me"] = $me;
        $return["data"]["customer_id"] = $customer_id;
        $return["data"]["bg_img"] = IMAGE_URL.$user_info["bg_img"];//背景图
        $return["data"]["avatar"] = $user_info["brief_avatar"]?IMAGE_URL.$user_info["brief_avatar"]:$user_info["wechat_avatar"];//头像
        $return["data"]["real_name"] = $user_info["real_name"]?$user_info["real_name"]:$user_info["name"];//用户名称
        echo json_encode($return);

    }


    
    /**
     * ajax加载某个用户 or 部落话题
     */
    public function Topic_List()
    {
        // 获取参数
        $page = $this->n;
        $prams = $this->p;
        $return = $this->return;

        if(empty($prams["tribe_id"]) && empty($prams["user_id"])){
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '1',
                    'errorMessage' => '缺少参数'
            );
            echo json_encode($return);exit;
    	}
    	
    	$tribe_id = !empty($prams["tribe_id"])?$prams["tribe_id"]:null;//部落id
    	$user_id = !empty($prams["user_id"])?$prams["user_id"]:null;//某个人的用户id
    	$customer_id = $this->customer_id;
    	

    	//分页
    	$currPage = $page["currPage"];
    	if( !$currPage  || !is_numeric($currPage) || !is_int($currPage+0)  )
        {
            $currPage = 1;
        }
        $limit = $page["perPage"];
        $offset = ( $currPage-1 ) * $limit;//偏移量
        
        
        $this->load->model("Corporationstyle_comment_mdl");
        $totalcount = $this->corporationstyle_topic_mdl->Load($tribe_id,$user_id);//查询话题总条数
        $topic_list = array();
        if($totalcount){
            $topic_list = $this->corporationstyle_topic_mdl->Load($tribe_id,$user_id,$limit,$offset);//查询话题列表
            if($topic_list){
                //处理图片
                foreach ($topic_list as $k => $v){
                    $images = trim($v["images"],";");
                    $topic_list[$k]["images"] = null;
                    if($images){
                        $topic_list[$k]["images"] = explode(";",$images);
                    }
                }
                
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
                    $topic_list[$k]["upvote_info"] = array();
                    $topic_list[$k]["upvote_num"] = 0;//默认点赞数0个
                    if(!empty($TempUpvoteList[$v["id"]])){
                        $topic_list[$k]["upvote_num"] = count($TempUpvoteList[$v["id"]]);//统计点赞数
                        $topic_list[$k]["upvote_info"] = $TempUpvoteList[$v["id"]];
                        foreach ($TempUpvoteList[$v["id"]] as $key => $val){
                            $topic_list[$k]["my_upvote"] = false;
                            if($val["customer_id"] == $customer_id){
                                $topic_list[$k]["my_upvote"] = true;
                                break;
                            }
                        }
                    }
                    
                    $topic_list[$k]["comment_num"] = 0;//默认评论数0个
                    $topic_list[$k]["comment"] = array();
                    if(!empty($TempTopicList[$v["id"]])){
                        $topic_list[$k]["comment_num"] = count($TempTopicList[$v["id"]]);//默认评论数0个
                        $topic_list[$k]["comment"] = $TempTopicList[$v["id"]];
                    }
                }
    
            }
        }
        $return["data"]["totalcount"] = $totalcount;
       	$return["data"]["listdate"] = $topic_list;
       	$return["data"]["perpage"] = $page["perPage"];
       	$return["data"]["currentpage"] = $page["currPage"];
       	

        echo json_encode( $return );
    }
    

    
    /**
     * 动态点赞
     */
    public function Add_Upvote()
    { 
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
                'obj_id'
        ));
        
        $obj_id = $prams['obj_id'];//对象id
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
        
        if($row){
            $return["data"]['type'] = $type;
        }else{
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '操作失败'
            );
        } 
        echo json_encode($return);
    }

    
    /**
     * 未阅读的消息数量
     */
    public function NotReadNum()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        

        $customer_id = $this->customer_id;//用户Id
        $this->load->model("corporationstyle_message_mdl");
        

        $letter_total = $this->corporationstyle_message_mdl->Not_Read_Num($customer_id);//查看通知条数
        $avatar = null;
        if($letter_total){
            $lastmessage = $this->corporationstyle_message_mdl->Load($customer_id,1)[0];//查询最后一条消息记录
            $avatar = $lastmessage["brief_avatar"]?$lastmessage["brief_avatar"]:$lastmessage["wechat_avatar"];
        }
//   
        $return["data"]["letter_total"] = $letter_total;
        $return["data"]["avatar"] = $avatar;
        

        echo json_encode($return);
    }
    
    
    /**
     * 我收到的消息
     */
    public function My_Message()
    {
        // 获取参数
        $page = $this->n;
        $return = $this->return;
        $customer_id = $this->customer_id;
        
        //分页
        $currPage = $page["currPage"];
        if( !$currPage  || !is_numeric($currPage) || !is_int($currPage+0)  )
        {
            $currPage = 1;
        }
        $limit = $page["perPage"];
        $offset = ( $currPage-1 ) * $limit;//偏移量
        
        $this->load->model('corporationstyle_message_mdl');
        
        $list = $this->corporationstyle_message_mdl->Load( $customer_id,$limit,$offset);//查询未读消息列表
        foreach ($list as $key => $v){
            $list[$key]["images"] = trim($v["images"],";");
        }
        
        $row = $this->corporationstyle_message_mdl->Update( $customer_id );//更新消息已读
        
        
        $return["data"]['listdata'] = $list;
        echo json_encode($return);

    }

    
    /**
     * 发布话题。
     */
    public function Create_Topic()
    {
    
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        
        $user_id =  $this->customer_id;
        $this->load->model('Tribe_mdl');
        $tribe_info = $this->Tribe_mdl->MyTribe($user_id);
        if(!$tribe_info){
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '你并没有加入部落'
            );
            echo json_encode($return);exit;
        }
    
        $content = !empty($prams["content"])?$prams["content"]:null;
        
        if(empty($_FILES["file"]["name"][0]) && !$content){
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '7',
                    'errorMessage' => '参数错误'
            );
            echo json_encode($return);exit;
        }
        
        if(!empty($_FILES["file"]["name"][0])){
            $path = "uploads/Corporation_style/$user_id/topic/";
            $this->load->helper("uploads");
            $images = complex_file_upload($path,null,"file");
            if(!$images){
                $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '8',
                        'errorMessage' => '上传图片失败'
                );
                echo json_encode($return);exit;
            }
            
            $data['images'] = null;
            foreach($images as $key => $v){
                    $data['images'] .= $path.$v["file_name"].";";
            }
        }
     
        //添加数据
        $data['content'] = !empty($content)?$content:null;
        $data['customer_id'] = $user_id;
        $this->load->model('Corporationstyle_topic_mdl');
        $id = $this->Corporationstyle_topic_mdl->Create( $data );
        
        if($id){
            $return['data']['id'] = $id;
        }else{
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '9',
                    'errorMessage' => '发布失败'
            );
        }
        echo json_encode($return);
    }
        
   
    
    
    /**
     * 添加评论
     */
    public function Add_Comment()
    { 
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
                'obj_id',
                'content'
        ));
        
        $obj_id = $prams["obj_id"];//对象id
        $content = $prams["content"];//内容
        $id = !empty($prams["id"])?$prams["id"]:null;//回复id
        $customer_id = $this->customer_id;
        
        if($content == null){
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '5',
                    'errorMessage' => '参数错误'
            );
            echo json_encode( $return );exit;
        }
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
            
            if(!$id){
                $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '6',
                        'errorMessage' => '话题评论失败'
                );
            }
            
            $return['data']["id"] = $id;
            
        }else{
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '7',
                    'errorMessage' => '话题不存在无法发表评论'
            );
        }
        echo json_encode( $return );
    }

    /**
     * 删除话题
     */
    public function Delete_Topic()
    { 
        
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
                'id'
        ));
        
        $id = $prams["id"];//话题id
        if( !(0 == $id) )
        {
            $customer_id = $this->customer_id;
            $param['status'] = 0;
            $row = $this->corporationstyle_topic_mdl->Update($id,$customer_id,$param );
        }

        if(empty( $row ) ){
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '删除失败'
            );
        }
        echo json_encode($return);
    }
    
    /**
    * @author JF
    * 2018年1月30日
    * 话题详情
    */
    function TopicDetail(){
        // 获取参数
        $page = $this->n;
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
                'id'
        ));
        

        $customer_id = $this->customer_id;
        $topicid = $prams["id"];
        
        $this->load->model("Corporationstyle_comment_mdl");
        $topic = $this->corporationstyle_topic_mdl->TopicDetail($topicid);//查询话题信息
        if($topic){
            //处理图片
            $images = trim($topic["images"],";");
            $topic["images"] = null;
            if($images){
                $topic["images"] = explode(";",$images);
            }
 

            
            //查询点赞人员信息
            $topic["my_upvote"] = false;//默认自己没有点赞
            $topic["upvote_info"]  = $this->corporationstyle_topic_mdl->topic_upvote_member_name($topicid);
            $topic["upvote_num"] = count($topic["upvote_info"]);
            foreach ($topic["upvote_info"] as $v){
                if($v["customer_id"] == $customer_id){
                    $topic["my_upvote"] = true;
                    break;
                }
            }
            //查询话题评论
            $topic["comment"] = $this->Corporationstyle_comment_mdl->Load($topicid);
            $topic["comment_num"] = count($topic["comment"]);
 
            
        }
        $return["data"]["topic"] = $topic;
        echo json_encode( $return );
    }
    
    /**
    * @author JF
    * 2018年2月2日
    * 删除评论
    */
    function DeleteComment(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        // 检验参数
        $this->_check_prams($prams, array(
                'id'
        ));
        $id = $prams["id"];//评论id
        $customer_id = $this->customer_id;//用户id
        $this->load->model("Corporationstyle_comment_mdl");
        $row = $this->Corporationstyle_comment_mdl->DeleteComment($id,$customer_id);
        if(!$row){
            $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '6',
                    'errorMessage' => '删除失败'
            );
        }
        echo  json_encode($return);
        
        
        
    }
    
    
}