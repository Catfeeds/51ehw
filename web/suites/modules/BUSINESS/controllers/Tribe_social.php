<?php
/** 
 * 部落关于社交一块的内容。
 * 
 */
class Tribe_social extends Front_Controller
{
    
    public $customer_id;
    
	function __construct()
	{
		parent::__construct();
		$this->session->set_userdata('ref_from_url', current_url());
		//判断登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        
        $this->customer_id = $this->session->userdata('user_id');
    }
	
	
	/**
	 * 用户信息。
	 * @param number $customer_id
	 */
    public function Customer_Info( $customer_id = 0 )
    { 
        if( !$customer_id )
        { 
            $customer_id = $this->customer_id;
        }
        
        $tribe_id = $this->input->get('tribe_id');
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '个人资料';
      
        //由于叉乘结果过多--分开查询。
        //Customer_Ts_Info
        $this->load->model('Tribe_mdl');
        
        //用户信息。
        if( $tribe_id )
        { 
            $this->load->model('Tribe_mdl');
            $customer_info = $this->Tribe_mdl->Customer_Ts_Info($customer_id,$tribe_id);
            if($tribe_id == 143){//2018-02-03 荣特殊要求属于143部落的用户手机号码不隐藏
                $customer_info['show_mobile'] = 1;
            }
        }else{
            
            $this->load->model('Customer_mdl');
            $customer_info = $this->Customer_mdl->load($customer_id);
        }
        
        
        if( isset($customer_info) )
        { 
            
            //处理手机号码是否隐藏
            // $tribe_info = $this->Tribe_mdl->get_tribe($tribe_id);
            $show_mobile = $customer_info['show_mobile'];
            // echo $show_mobile;
//             if( $customer_info['id'] !=  $this->session->userdata('user_id') ){
//                 if($show_mobile == 2){
//                    $customer_info['mobile'] = substr_replace($customer_info['mobile'],'**',4,2);
//                } 
//             }
           $customer_info["show_mobile"] = $show_mobile;
            
            
            //判断显示名字。
            $customer_info['customer_name'] = $customer_info['real_name'] ? $customer_info['real_name'] : ( !empty($customer_info['member_name'] )  ? $customer_info['member_name'] : substr_replace($customer_info['name'],'********',2,8)  );
            //查询加入过的部落列表。
           
            $tribe_list = $this->Tribe_mdl->Customer_Tribe_List( $customer_id );
            
            //相册
            $this->load->model('Customer_album_mdl');
            $data['album'] = $this->Customer_album_mdl->load_albums($customer_id,$tribe_id,12);
//            echo '<pre>';
//            print_r($this->db->last_query());exit;
            // var_dump($data['album']);
           
           
            //社会身份列表。
            $this->load->model('Customer_identity_mdl');
            $corp_list = $this->Customer_identity_mdl->Load($customer_id);
            
            //点赞次数
            $this->load->model('Customer_upvote_mdl');
            $upvote_info = $this->Customer_upvote_mdl->Count_Customer_Upvote( $this->customer_id, $customer_id );
           
            $upvote_info['is_upvote'] = false;
            //查看是否点赞过。
            if( $this->Customer_upvote_mdl->Detaile( $this->customer_id, $customer_id ) )
            { 
                $upvote_info['is_upvote'] = true;
            }
            
            //推荐人-上级。
            if( !empty( $customer_info['parent_id'] ) )
            { 
                $parent_info = $this->Customer_identity_mdl->Customer_Info_Identity( $customer_info['parent_id'] );
            }
            
            //评价列表
            $comment_limit = 3;//每页显示的数量
            $this->load->model('Customer_comment_mdl');
            $comment_list = $this->Customer_comment_mdl->Load_List( $customer_id,$comment_limit );
            
            $data['comment_list']  = $comment_list; //评价列表
            $data['customer_id']   = $this->customer_id; //自身id
            $data['upvote_info']   = $upvote_info; //点赞信息+次数
            $data['identity_list'] = $corp_list; //身份列表
            $data['customer_info'] = $customer_info;//用户信息
            $data['tribe_list']    = $tribe_list;//部落身份列表。
            $data['comment_limit'] = $comment_limit;//评论每页显示条数
            $data['parent_info']   = !empty( $parent_info ) ? $parent_info : array() ;//上线信息
            $data['tribe_id'] = $tribe_id ? $tribe_id : 0 ;
            
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('tribe/tribe_social/customer_info', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot');
            
        }else{ 
            
            echo "<script>history.back(-1);alert('用户不存在');</script>";exit;
        }
    }
    
    /**
     * 评论页
     */
    public function Comment( $to_customer_id = 0 )
    {
        if( $to_customer_id && is_numeric( $to_customer_id ) && strpos( $to_customer_id,'.') == false )
        {
            $data['head_set'] = 2;
            $data['foot_set'] = 1;
            $data['title'] = '发表评价';
            $data['to_customer_id'] = $to_customer_id;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('tribe/tribe_social/comment', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot');
            
        }else{ 
            
            echo "<script>history.back(-1);alert('参数错误');</script>";exit;
        }
        
        
    }
    
    /**
     * 修改个人信息页面。
     */
    public function Edit_Info( $status = 0 )
    { 

        $tribe_id = $this->input->get('tribe_id');
        $customer_id = $this->session->userdata('user_id');
        $this->load->model('Customer_mdl');
        $customer_info = $this->Customer_mdl->load( $this->customer_id );
        $this->load->model('Tribe_mdl');
        if(isset($tribe_id )){
            $customer_info_Ts = $this->Tribe_mdl->Customer_Ts_Info($customer_id,$tribe_id);
             $data['customer_info_Ts'] = $customer_info_Ts;
             // if($customer_info_Ts['show_mobile'] == 2 ){
             //     $customer_info['mobile'] = $customer_info['mobile'] = substr_replace($customer_info['mobile'],'****',3,4); // 设置对自己／对他人都隐藏
             // }
        }
       
        // var_dump($customer_info_Ts);
        //查询个人信息。

        
        // var_dump($customer_info);
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '完善基本资料';
        $data['customer_info'] = $customer_info;
       

        // $this->load->view('head', $data);
        // $this->load->view('_header', $data);
        if( $status == 1 )
        {
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('tribe/tribe_social/edit_personal_description', $data);
            
        }else if ( $status == 2 )
        { 
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('tribe/tribe_social/edit_personal_stern', $data);
            
        }

        // else if($status == 3){
        //     $data['title'] = '手机号';
        //     $this->load->view('head', $data);
        //     $this->load->view('_header', $data);
        //     $this->load->view('tribe/tribe_social/edit_personal_stern_ts', $data);
        // }

        else{ 
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('tribe/tribe_social/edit_customer_info', $data);
        }
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    
    
    /**
     * 添加身份页面
     */
    public function Identity()
    { 
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '添加身份';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/add_identity', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
        
    }
    
    /**
     * 编辑身份页面
     */
    public function Edit_Identity( $id = 0 )
    {
        
        $this->load->model('Customer_identity_mdl');
        $identity_info = $this->Customer_identity_mdl->Detaile( $id,$this->customer_id );
        $data['identity_info'] = $identity_info;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '编辑身份';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/edit_identity', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    
    }
    
    /**
     * 邀请朋友页。
     */
    public function Invite( $tribe_id = 0 )
    { 

        $data['tribe_id'] = $tribe_id;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '邀请朋友';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/invite', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 更换头像
     */
    public function Upload_Avatar()
    { 
       
        $status = $this->input->post('status');
        
        $return['status'] = false;
        if( !empty( $_FILES['file'] ) )
        {
            
            // 图片 初始化数据
            $save_path = $status ? 'uploads/customer_background/': "uploads/customer_avatar/";
        
            $path = FCPATH.UPLOAD_PATH. $save_path;
        
            if ( !file_exists( $path ) )
            {
        
                mkdir($path,0777,true);
            }
        
            $this->load->library('upload');
        
        
            if( $_FILES['file']['name'] )
            {
                $config['upload_path'] = $path;
                $config['file_name'] = $status ? 'bg_'.$this->customer_id  : 'avatar_'.$this->customer_id;
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['overwrite'] = true;//同名覆盖。
                
                $this->upload->initialize($config);
        
                if( $this->upload->do_upload("file") )
                {
                    $img = $this->upload->data();
        
                    $images = $save_path.$img['file_name'];
        
                    $data['bg_img'] = $images;
                   
                    $this->load->model('customer_mdl');
                    
                    if( !$status )
                    {
                        $this->customer_mdl->brief_avatar = $images;
                    }else{ 
                        
                        $this->customer_mdl->bg_img = $images;
                    }
                    
                    $row = $this->customer_mdl->update( $this->customer_id );
                }
            }
        }
        
        if( !empty( $row ) )
        {
            $return['status'] = 1;
            $return['data'] = IMAGE_URL.$images."?refresh=".date('YmdHis');
            $this->session->set_userdata("brief_avatar",$return['data']);
            $this->session->set_userdata("img_avatar",IMAGE_URL.$images);
        }
        
        echo json_encode( $return );
        
    }
    
    /**
     * 添加社会身份。
     */
    public function Add_Identity()
    { 
        $type = $this->input->post('type');
        $organization_name = $this->input->post('organization_name');
        $organizationl_duties = $this->input->post('organizationl_duties');
        $return['message'] = '添加失败';
        $return['status'] = false;
        
        //验证参数。
        if( $type && $organization_name && $organizationl_duties )
        { 
            $data = array();
            $i = 0;
            foreach($organization_name as $k => $v){
                if($v && !empty($organizationl_duties[$k])){
                    $data[$i]["organization_name"] = $v;
                    $data[$i]["organizationl_duties"] = $organizationl_duties[$k];
                    $data[$i]['type'] = $type;
                    $data[$i]['customer_id'] = $this->customer_id;
                    $i++;
                }
            }
            $this->load->model('Customer_identity_mdl');
            $id = $this->Customer_identity_mdl->Create( $data );
            
            if( $id )
            { 
                $return['message'] = '添加成功';
                $return['status'] = true;
            }
            
        }else{ 
            
            $return['message'] = '缺少必填参数';
            $return['status'] = 2;
        }
        
        echo json_encode( $return );
    }
    
    /**
     * 更新身份信息。 
     */
    public function Upadte_Identity()
    { 
        $id = $this->input->post('id');
        $organization_name = $this->input->post('organization_name');
        $organizationl_duties = $this->input->post('organizationl_duties');
        
        $return['message'] = '更新失败';
        $return['status'] = false;
        
        //验证参数。
        if( $id && $organization_name && $organizationl_duties )
        { 
            $sift['set']['organization_name'] = $organization_name;
            $sift['set']['organizationl_duties'] = $organizationl_duties;
            $sift['where']['id'] = $id;
            $sift['where']['customer_id'] = $this->customer_id;
            
            $this->load->model('Customer_identity_mdl');
            $row = $this->Customer_identity_mdl->Update( $sift );
            
            if( $row )
            { 
                $return['message'] = '更新成功';
                $return['status'] = true;
            }
            
        }else{ 
            
            $return['message'] = '缺少必填参数';
            $return['status'] = 2;
        }
        
        echo json_encode($return);
    }
    
    /**
     * 更新信息。
     */
    public function Update_Customer_Info() 
    {
        $real_name = $this->input->post('real_name');//真实姓名
        $merit = $this->input->post('merit');//个人亮点
        $brief = $this->input->post('brief');//个人简介
        $return['message'] = '保存失败';
        $return['status'] = false;
        
        $i = false;
        
        $this->load->model('Customer_mdl');
       
        if($real_name && !$merit && !$brief){
            $param['real_name'] = $real_name;
            $param["user_id"] = $this->customer_id;
            //同步用户真实姓名
            $url = $this->url_prefix.'Customer/info_save';
            $result = json_decode($this->curl_post_result($url,$param),true);
            
            if($result['status']){
                $_data['user_name'] = $real_name;
                $_data['real_name'] = $real_name;
                $this->session->set_userdata($_data);
                
                $this->load->model('tribe_mdl');
                $aff = $this->tribe_mdl->update_tribe_member_name($real_name,$this->customer_id);
                $return['status'] = 1;
                $return['message'] = '保存成功';
                echo json_encode($return);exit;
            } else{
                $return['status'] = 1;
                $return['message'] = '保存失败';
                echo json_encode($return);exit;
            }
        }else{
            if( $merit )
            {
                $this->Customer_mdl->merit = $merit;
                $i = true;
            }
            if( $brief )
            {
                $this->Customer_mdl->brief = $brief;
                $i = true;
            }
            if( $i )
            {
                $row = $this->Customer_mdl->update( $this->customer_id );
            
            }
            if( !empty( $row ) )
            {
                $return['status'] = 1;
                $return['message'] = '保存成功';
            }
            echo json_encode($return);
        }
        
    }
    /**
     * 删除评论
     * 只可操作自己评论的 
     */
    public function Del_Comment()
    {
        $Comment_id = $this->input->post('com_id');
        $customer_id = $this->session->userdata("user_id");
        $this->load->model('Customer_comment_mdl');
        $sift['where']['from_customer_id'] =$customer_id;
        $sift['where']['id'] =$Comment_id;
        $Comment_Detail  = $this->Customer_comment_mdl->Detail($sift);
        $return = array(
            'status'=>false,
            'Msg'=>'删除失败！'
        );
        if($Comment_Detail){
            $sifts['where']['id'] = $Comment_id;
            $aff = $this->Customer_comment_mdl->del_comment($sifts);
            if($aff){
                $return['status'] = true;
                $return['Msg'] = '删除成功！';
            }
            
        }
        echo json_encode($return);
    }
    
    /**
     * 发表评论
     */
    public function Add_Comment()
    { 
        $to_customer_id = $this->input->post('to_customer_id');
        $content = $this->input->post('content');
        
        $return['status'] = false;
        $return['message'] = '评价失败';
        
        if( is_numeric( $to_customer_id ) && strpos( $to_customer_id,'.') == false )
        {
            $this->load->model('Customer_comment_mdl');
            $sift['where']['from_customer_id'] = $this->customer_id;
            $sift['where']['to_customer_id'] = $to_customer_id;
            
            
            if( !$this->Customer_comment_mdl->Detail( $sift ) )
            {
                
                $data['to_customer_id'] = $to_customer_id;
                $data['from_customer_id'] = $this->customer_id;
                $data['content'] = $content;
                
                $id = $this->Customer_comment_mdl->Create( $data );
                
                if( $id )
                { 
                    $return['status'] = 1;
                    $return['message'] = '评价成功';
                }
                
            }else{ 
                
                $return['status'] = 3;
                $return['message'] = '您已经评价过了';
            }
            
        }else{ 
            
            $return['status'] = 2;
            $return['message'] = '参数错误';
        }
        
        echo json_encode( $return );
    }
    
    /**
     * 动态点赞
     */
    public function Fabulous()
    {
        $customer_id = $this->input->post('customer_id'); //被点赞用户ID
        $from_customer_id = $this->customer_id;//点赞用户ID
        
        if( is_numeric( $customer_id ) && strpos( $customer_id,'.') == false )
        {
            //点赞查询。
            $this->load->model('Customer_upvote_mdl');
            $upvote_info = $this->Customer_upvote_mdl->Detaile( $from_customer_id, $customer_id );
            
            if( $upvote_info )
            {
                //删除点赞
                $sift['where']['id'] = $upvote_info['id'];
                $sift['where']['from_customer_id'] = $upvote_info['from_customer_id'];
                $row = $this->Customer_upvote_mdl->Delete( $sift );
                
                $type = 1;
                
            }else{
                //添加
                $data['from_customer_id'] = $this->customer_id;
                $data['to_customer_id'] = $customer_id;
                $row = $this->Customer_upvote_mdl->Create( $data );
                $type = 2;
                
            }
        
            
            $return['status'] = $row ? 1 : 0;
            $return['data']['type'] = $type;
            
        }else{ 
            
            $return['status'] = false;
            $return['message'] = '参数错误';
        }
        echo json_encode($return);
    
        
    }
    
    public function Invite_Moblie(){
        $tribe_id = $this->input->post('tribe_id'); //部落ID
        $moblie = $this->input->post('moblie');
        $from_customer_id = $this->session->userdata("user_id");//用户id
        $return['message'] = '邀请失败';
        $return['status'] = 0;
        
        setcookie("Invite_Moblie_".$moblie,true, time()+1800);
        if( empty( $_COOKIE['Invite_Moblie_'.$moblie] ) )
        {
            if( $tribe_id )
            {
                //邀请人
                $this->load->model('tribe_mdl');
                $from_info = $this->tribe_mdl->load($tribe_id,$from_customer_id);
                
                if( !empty($from_info['tribe_staff_id'])  )
                {
            
                    //配置长连接
//                     $url_long = "http://www.51ehw.com/index.php/_BUSINESS/Login/code_login/".$tribe_id."?in_id=".$from_customer_id;
//                     $req = json_decode( Message_LongToShort_result($url_long),true)[0];
                    //转化短连接
                    $this->load->helper("message");
                    
                    $param['customer_id'] = $from_customer_id;
                    $param['resource'] = "Login/code_login/".$tribe_id."?in_id=".$from_customer_id.'&in_tp=code';
                    $req = json_decode(  ToConect($param),true);
                    
                    if($from_info['real_name']){
                        $real_name = $from_info['real_name'];
                    }else if($from_info['member_name']){
                        $real_name = $from_info['member_name'];
                    }else{
                        $real_name =$from_info['mobile'];
                    }
                    $corp_name = $from_info['corporation_name'] ? '【'.$from_info['corporation_name'].'】':'';
                    
                    $user_tribe_info = $this->tribe_mdl->verify_tribe_user( $tribe_id, $moblie );
                   
                    if($user_tribe_info ){
                        if($user_tribe_info['customer_id']){
                            if($user_tribe_info['status'] == 1){
                                $return['status'] = 13;
                                $return['message'] = '该手机号用户已经申请加入部落了';
                                echo json_encode($return);exit;
                            }else if($user_tribe_info['status'] == 2){
                                $return['status'] = 9;
                                $return['message'] = '该手机号用户已经加入部落了';
                                echo json_encode($return);exit;
                            }else if($user_tribe_info['status'] == 3){
                                $return['status'] = 12;
                                $return['message'] = '该手机号用户被拒绝加入部落了';
                                echo json_encode($return);exit;
                            }
                        }else{
                            //预录入的
                            $updat['id'] = $user_tribe_info['id'];
                            $updat['status'] = 4;
                            $this->tribe_mdl->update_member($updat);
                        }
                    }
                    
                    //首先判断邀请用户是否已经注册的了
                    $this->load->model('customer_mdl');
                    $mobile_info = $this->customer_mdl->load_by_mobile($moblie);
                    if($mobile_info){
                        $invite_name = $mobile_info['real_name'] ? $mobile_info['real_name']:$moblie;
                    }else{
                        $user_tribe_info = $this->tribe_mdl->verify_tribe_user( $tribe_id, $moblie );
                        if($user_tribe_info){  //预录入用户
                            $invite_name = $user_tribe_info['member_name'] ? $user_tribe_info['member_name']:$moblie;
                        }else{//新用户
                            $invite_name = $moblie;
                           
                            //新用户  判断邀请者是否有管理权限  有则预录入用户并且默认通过
//                             $role = $this->tribe_mdl->ManagementTribe($from_customer_id,$tribe_id);
//                             if($role){
//                                 $info['tribe_id'] = $tribe_id;
//                                 $info['mobile'] = $moblie;
//                                 $info['member_name'] = $moblie;
//                                 $info['show_mobile'] = '2';
//                                 $info['status'] = '2';
//                                 $info['member_type'] = 'prepare';// 预录入类型
//                                 $affs = $this->tribe_mdl->add_staff($info);
//                             }
                        }
                        
                    }
                    
                    //发送短信
                    $content = "hi~{$invite_name}，这是您认识的{$real_name}。点击进入：".$req['url_short']." 退订回N【51易货网】";
//                     $content = "尊敬的{$invite_name}，{$corp_name}{$real_name}诚意邀请您加入{$from_info['name']}，充分展示您的个人形象和企业风采，与业内精英互动交流，还有更多专属特权等着您，快快来参加吧。".$req['url_short']." 退订回N【51易货网】";
                    $this->load->helper("message");
                    $source = ($this->isMobile()?2:1);//'来源 1:PC 2:微信 3:安卓 4:ios 5:后台'
                    $sms = send_message($moblie,1,$content,2,$source);
                    $sms = json_decode($sms,true);
                    if( $sms["returnstatus"] == "00" )
                    {
                        setcookie("Invite_Moblie_".$moblie,true, time()+1800);
                        $return['status'] = 1;
                        $return['message'] = '您的邀请已以短信发送给对方';
                    }else{
                    	$return['status'] = 4;
                    	$return['message'] = '发送短信失败';
                    }
                   
                    
                }else{
            
                    //您不是该部落成员无法邀请
                    $return['status'] = 2;
                    $return['message'] = '您不是该部落成员无法邀请';
                }
            }
        }else{ 
            
            //您不是该部落成员无法邀请
            $return['status'] = 3;
            $return['message'] = '请勿频繁发送同一手机号码';
        }
        echo json_encode($return);
        
    }
    
    /**
     * 加载更多评论
     */
    public function Load_Comment()
    { 
        $customer_id = $this->input->post('customer_id');
        
        $page = $this->input->post("page");//页数
        if(0 == $page)
        {
            $page = 1;
        }
        
        $limit = 3;//每页显示的数量
        
        $offset = ($page-1)*$limit;//偏移量
       
        
        $sift['page']['limit'] = $limit;
        $sift['page']['offset'] = $offset;
        
        //评价列表
        $this->load->model('Customer_comment_mdl');
        $comment_list = $this->Customer_comment_mdl->Load_List( $customer_id ,$limit, $offset );
        
        $return['data']['list'] = $comment_list;
        
        
        echo json_encode( $return );
        
    }
    
    
    /**
     * 查询单条评论-判断是否评论过。
     */
    public function Is_Exists_Comment()
    { 
        $to_customer_id = $this->input->post('to_customer_id');
        
        $this->load->model('Customer_comment_mdl');
        $sift['where']['from_customer_id'] = $this->customer_id;
        $sift['where']['to_customer_id'] = $to_customer_id;
        $return['status'] = true; //可以评价
        
        if( $this->Customer_comment_mdl->Detail( $sift ) )
        {
            $return['status'] = false; //不可以评价
        }
        
        echo json_encode( $return );
    }
    
    // ----------------个人形象(个人相册)-------------------------------------------------------------------
    /**
     *  个人形象
     * @param number $customer_id
     */
    public function Customer_Album($customer_id = 0,$tribe_id = 0){
        $this->load->model('Customer_album_mdl');
        if( !$customer_id )
        {
            $customer_id = $this->customer_id;
            $self = true;
        }
      
        $this->load->model('Customer_mdl');
        $customer = $this->Customer_mdl->load($customer_id);
        
        $mobile = substr_replace($customer['mobile'],'********',2,8);
        
        $data['real_name'] = $customer['real_name'] ? $customer['real_name']:$mobile;
        $data['bg_img'] = $customer['bg_img'];
        
       //获取用户相册
        $albums_list = $this->Customer_album_mdl->load_albums($customer_id,$tribe_id);
      
        $data['albums_list_count'] = count($albums_list);;
        if($customer_id == $this->session->userdata("user_id")){
            $data['show_button'] = true;
        }else{
            $data['show_button'] = false;
        }
        
        $data['customer_id'] =$customer_id;
        $data['tribe_id'] =$tribe_id;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '个人风采';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/customer_album', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    
    public function  staff_album($staff_id = 0){
        if(!$staff_id){
            echo "<script>history.back(-1);alert('参数错误');</script>";exit;
        }
        $this->load->model('Tribe_mdl');
        $ts_info = $this->Tribe_mdl->load_by_staff_id($staff_id);
        if(!$ts_info){
            echo "<script>history.back(-1);alert('用户不存在');</script>";exit;
        }
        $customer_id = $this->session->userdata('user_id');
        
        //验证当前用户与被上传用户是否在同一个部落
        $from_staff_info = $this->Tribe_mdl->verify_tribe_customer($ts_info['tribe_id'],$customer_id);
        if(!$from_staff_info){
            echo "<script>history.back(-1);alert('权限不足');</script>";exit;
        }
        
        $this->load->model('Tribe_staff_album_mdl');
//         $this->Tribe_staff_album_mdl->synchro_Update($staff_id);
        $data['albums_list_count']  = $this->Tribe_staff_album_mdl->get_albums($staff_id,0);
//         echo '<pre>';
//         print_r($data);exit;
        
        $this->load->model('Customer_mdl');
        //当前
        $customer = $this->Customer_mdl->load($customer_id);
      
        $data['mobile'] = substr_replace($ts_info['mobile'],'********',2,8);
        $data['member_name'] = $ts_info['member_name'];
      
        $data['staff_id'] = $staff_id;
        $data['from_customer'] = $customer_id;
        $data['tribe_id'] = $ts_info['tribe_id'];
        
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '个人风采';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/staff_album', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 加载预录入用户相册
     */
    public function  loading_staff_albums(){
        
        $this->load->model('Tribe_staff_album_mdl');
        $staff_id = $this->input->post("staff_id");//页数
        $limit = 5;//每页显示的数量
        
        $page = $this->input->post("page");//页数
        if(0 == $page)
        {
            $page = 1;
        }
        
        $offset = ($page-1)*$limit;//偏移量
        
        $albums_list = $this->Tribe_staff_album_mdl->load_albums($staff_id,$limit,$offset);
      
        $albums =array();
        if(count($albums_list) > 0){
            foreach ($albums_list as $k => $val){
                $photo = $this->Tribe_staff_album_mdl->load_ByAlbum_Id($val['id']);
                if(count($photo) > 0){
                    $list = array(
                        'corporation_name'=>'',
                        'job'=>'',
                        'real_name'=>'',
                    );
                    $list['tribe_id'] = $val['tribe_id'];
                    $list['created_at'] = $val['created_at'];
                    $list['remark'] = empty($val['remark']) ? "":$val['remark'];
                    $list['from_customer_id'] = $val['from_customer_id'];
        
                    $this->load->model('Customer_album_mdl');
                    $crop_info = $this->Customer_album_mdl->get_crop_info($val['from_customer_id'],$val['tribe_id']);
                    $this->load->model('Customer_mdl');
                    $customer_info = $this->Customer_mdl->load($val['from_customer_id']);
                    $list['job'] = $customer_info['job'];
                    $list['real_name'] = $customer_info['real_name'];
                    if($crop_info){
                        $list['corporation_name'] = $crop_info['corporation_name'];
                    }
                   
                     
                    $list['photo_list'] = $photo;
                    $albums[]= $list;
                }
            }
        }
        
        $data['list'] = $albums;
        echo json_encode($data);
    }
    
    /**
     * 加载相册
     */
    
    public function loading_albums(){
        $this->load->model('Customer_album_mdl');
        $tribe_id = $this->input->post("tribe_id");//页数
       
        $customer_id = $this->input->post("id");//页数
        $limit = 5;//每页显示的数量
        $page = $this->input->post("page");//页数
        if(0 == $page)
        {
            $page = 1;
        }
        
        $offset = ($page-1)*$limit;//偏移量
        
        //获取用户相册
        $albums_list = $this->Customer_album_mdl->load_albums_list($customer_id,$tribe_id,$limit,$offset);
//        echo '<pre>';
//        print_r($this->db->last_query());exit;
        $albums =array();
        if(count($albums_list) > 0){
            foreach ($albums_list as $k => $val){
                $photo = $this->Customer_album_mdl->load_ByAlbum_Id($val['id']);
                if(count($photo) > 0){
                    $list = array(
                        'corporation_name'=>'',
                        'job'=>'',
                        'real_name'=>'',
                    );
                    $list['tribe_name'] = $val['tribe_name'];
                    $list['tribe_id'] = $val['tribe_id'];
                    $list['created_at'] = $val['created_at'];
                    $list['remark'] = empty($val['remark']) ? "":$val['remark'];
                    $list['from_customer_id'] = $val['from_customer_id'];
                    
                    if($val['from_customer_id']){
                        $crop_info = $this->Customer_album_mdl->get_crop_info($val['from_customer_id'],$tribe_id);
                       
                        $this->load->model('Customer_mdl');
                        $customer_info = $this->Customer_mdl->load($val['from_customer_id']);
                        $list['job'] = $customer_info['job'];
                        $list['real_name'] = $customer_info['real_name'];
                        if($crop_info){
                            $list['corporation_name'] = $crop_info['corporation_name'];
                        }
                    }
                   
                    $list['photo_list'] = $photo;
                    $albums[]= $list;
                }
            }
        }
        $data['list'] = $albums;
       
        // echo '<pre>';
        // print_r($albums);exit;
        echo json_encode($data);
    }
    
    /**
     *  删除相册
     * 
     */
    public function del_album(){
        $id = $this->input->post("id");//相册ID
        if(!$id){
            echo false;
            exit;
        }
        $this->load->model('Customer_album_mdl');
        $customer_id =$this->session->userdata("user_id");
        $Album_info = $this->Customer_album_mdl->load_album($id);
        if(!$Album_info){
            $return['status'] = false;
            echo json_encode($return);exit;
        }
        $aff = $this->Customer_album_mdl->del_AlbumByID($id);
        if($aff){
            $return['status'] = true;
        }else{
            $return['status'] = false;
        }
        echo json_encode($return);
    }
    
    /**
     * 删除预录入用户相册
     */
    public function del_staff_album(){
        $staff_album_id = $this->input->post("staff_album_id");//相册ID
        $this->load->model('Tribe_staff_album_mdl');
        $staff_album_info = $this->Tribe_staff_album_mdl->load_staff_album($staff_album_id);
      
        if(!$staff_album_info){
            $return['status'] = false;
            echo json_encode($return);
            exit;
        }
        $customer_id = $this->session->userdata('user_id');
        if($staff_album_info['from_customer_id'] != $customer_id){
            $return['status'] = false;
            echo json_encode($return);
            exit;
        }
        $aff =  $this->Tribe_staff_album_mdl->del_AlbumByID($staff_album_id);
        if($aff){
            $return['status'] = true;
        }else{
            $return['status'] = false;
        }
        echo json_encode($return);
        
    }
    
    
    /**
     * 删除相片
     * $id array()
     */
    public  function del_album_img(){
        $id = $this->input->post("id");//相片ID
        
        if(!$id){
            echo false;
            exit;
        }
        
        $this->load->model('Customer_album_mdl');
        $customer_id = $this->customer_id;
        
        $img_info = $this->Customer_album_mdl->load_AlbumByImgID($id);
        
        $del_info = array();
        foreach ($img_info as $key =>$val){
            if($customer_id == $val['customer_id']){
              $del_info[] = $val['id'];
            }
        }
        if(count($del_info) <= 0 ){
           echo false;
           exit;
        }
        
        $aff = $this->Customer_album_mdl->del_AlbumByImgID($del_info);
        
        if($aff){
            $return['status'] = true;
        }else{
            $return['status'] = false;
        }
        echo json_encode($return);
    }
    
    /**
     * 修改备注
     * $id
     */
    public  function update_Album_remark(){
        $album_id = $this->input->post("id");//关联ID
        $remark = $this->input->post("remark");//关联ID
        $this->load->model('Customer_album_mdl');
     
        $aff = $this->Customer_album_mdl->update_Album_remark($album_id,$remark);
      
        if($aff){
            $return['status'] = true;
        }else{
            $return['status'] = false;
        }
        echo json_encode($return);
    }
    /**
     * 重新编辑预录入相册
     */
   public  function edit_staff_album($staff_album_id){
       $this->load->model('Tribe_staff_album_mdl');
       $staff_album_info = $this->Tribe_staff_album_mdl->load_staff_album($staff_album_id);
       
       if(!$staff_album_info){
            echo "<script>history.back(-1);alert('相册不存在');</script>";exit;
       }
       $photo_list = $this->Tribe_staff_album_mdl->load_ByAlbum_Id($staff_album_id);
      
       $data ['photo_list'] = $photo_list;
       $data ['remark'] = $staff_album_info['remark'];
       
       $data ['tribe_id'] = $staff_album_info['tribe_id'];
       $data ['staff_id'] = $staff_album_info['tribe_staff_id'];
        
       $data ['head_set'] = 2;
       $data['foot_set'] = 1;
       $data['staff_album_id'] = $staff_album_id;
       $this->load->view('head', $data);
       $this->load->view('_header', $data);
       $this->load->view('tribe/tribe_social/edit_staff_ablum', $data);
       $this->load->view('_footer', $data);
       $this->load->view('foot', $data);
   }
    
    
    /**
     * 重新编辑相册
     */
    public  function edit_ablum($Album_id){
        $this->load->model('Customer_album_mdl');
        $ablum  =  $this->Customer_album_mdl->load_album($Album_id);
      
        if(!$ablum){
            echo "<script>history.back(-1);alert('非法访问');</script>";exit;
        }
        $data ['customer_id'] = $ablum['customer_id'];
        if(!$ablum['tribe_id']){
            $ablum['tribe_id'] = 0;
        }
        
        $photo_list = $this->Customer_album_mdl->load_ByAlbum_Id($Album_id);
//         echo  '<pre>';
//         print_r($photo_list);exit;
        $data ['photo_list'] = $photo_list;
        $data ['remark'] = $ablum['remark'];
        $data ['is_show'] = $ablum['is_show'];
        
        $data ['customer_id'] = $ablum['customer_id'];
        $data ['tribe_id'] = $ablum['tribe_id'];
        $data ['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['album_id'] = $Album_id;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/edit_ablum', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 异步处理重新编辑预录入相册
     */
   public function  ajax_edit_staff_ablum(){

       $data_post = $this->input->post();
       
       $image = array();
       $images = array();
        
       $year = date("Y",time());
       $month = date("m",time());
       $day = date("d",time());
       
       $del = isset($data_post['del']) ? $data_post['del'] : false;
       
       $this->load->model('Tribe_staff_album_mdl');
       
       $staff_album_id = $data_post['staff_album_id'];
       
       $staff_album_info = $this->Tribe_staff_album_mdl->load_staff_album($staff_album_id);
      
       if(!$staff_album_info){
           $return['status'] =  false;
           echo json_encode($return);
           exit;
       }
       
       $tribe_staff_id = $staff_album_info['tribe_staff_id'];
       if($del){//删除操作图片
        
           $del_info = array();
           foreach ($del as $key =>$val){
               $del_info[] = $val['id'];
           }
           $this->Tribe_staff_album_mdl->del_AlbumByImgID($del_info);
          
       }
       $files =  isset($data_post['file']) ? $data_post['file'] : false;
       $add_img_status = false;
       $created_at = date("Y-m-d H:i:s");
       if($files){
           //需要上传的图片，图片名+大小。
           $img_add = explode(',', trim($data_post['add_img'],',') );
           // 图片 初始化数据
           $save_path = "uploads/staff_album/$tribe_staff_id/$year/$month/$day/";
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
                               $image['tribe_staff_id']= $tribe_staff_id;
                               $image['staff_album_id'] = $staff_album_id;
                               $image['path']= $pic_path;
                               $image['created_at']= $created_at;
                               $images[]= $image;
                               $multip[] = $key;
                           }
                       }
                   }
               }
           }
           //添加数据
           $add_img_status = $this->Tribe_staff_album_mdl->Create( $images );
       }
       $update['id'] = $staff_album_id;
       $update['remark'] = $data_post['content'];
       $update['update_at'] =$created_at;
       $update_aff = $this->Tribe_staff_album_mdl->update($update);
       
       $return['status'] =  false;
       
       if($update_aff ||$add_img_status){
           $return['status'] =  true;
       }
       echo json_encode($return);
   }
    
    /**
     * 异步处理重新编辑相册
     */
    public function ajax_edit_ablum(){
        $data_post = $this->input->post();
        $image = array();
        $images = array();
         
        $year = date("Y",time());
        $month = date("m",time());
        $day = date("d",time());
      
        $del = isset($data_post['del']) ? $data_post['del'] : false;
        
        $this->load->model('Customer_album_mdl');
        
        $album_id = $data_post['album_id'];
        $ablum  =  $this->Customer_album_mdl->load_album($album_id);
        if(!$ablum){
            $return['status'] =  false;
            echo json_encode($return);
            exit;
        }
        $customer_id = $ablum['customer_id'];
        if($del){//删除操作图片
            $del_info = array();
            foreach ($del as $key =>$val){
                $del_info[] = $val['id'];
            }
            $this->Customer_album_mdl->del_AlbumByImgID($del_info);
        }
        $files =  isset($data_post['file']) ? $data_post['file'] : false;
        $add_img_status = false;
        $created_at = date("Y-m-d H:i:s");
        if($files){
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($data_post['add_img'],',') );
            // 图片 初始化数据
            $save_path = "uploads/album/$customer_id/$year/$month/$day/";
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
                                $image['customer_id']= $customer_id;
                                $image['album_id'] = $album_id;
                                $image['path']= $pic_path;
                                $image['created_at']= $created_at;
                                $images[]= $image;
                                $multip[] = $key;
                            }
                        }
                    }
                }
            }
            //添加数据
            $add_img_status = $this->Customer_album_mdl->Create( $images );
        }
        $update['id'] = $album_id;
        $update['remark'] = $data_post['content'];
        $update['is_show'] =$data_post['is_show'];
        $update['update_at'] =$created_at;
        $update_aff = $this->Customer_album_mdl->update($update);
        
        $return['status'] =  false;
        $return['count'] =  1;
        if($update_aff ||$add_img_status){
            $return['status'] =  true;
        }
        
        $photo = $this->Customer_album_mdl->load_ByAlbum_Id($album_id);
        if(!$photo){
            $return['count'] =  0;
        }
        echo json_encode($return);
    }
        
    /**
     * 上传相册页面(预录入用户)
     */
    public function  staff_upload($staff_id = 0){
      if(!$staff_id){
            echo "<script>history.back(-1);alert('参数错误');</script>";exit;
        }
        $this->load->model('Tribe_mdl');
        $ts_info = $this->Tribe_mdl->load_by_staff_id($staff_id);
        if(!$ts_info){
            echo "<script>history.back(-1);alert('用户不存在');</script>";exit;
        }
        $customer_id = $this->session->userdata('user_id');
        
        //验证当前用户与被上传用户是否在同一个部落
        $from_staff_info = $this->Tribe_mdl->verify_tribe_customer($ts_info['tribe_id'],$customer_id);
        if(!$from_staff_info){
            echo "<script>history.back(-1);alert('权限不足');</script>";exit;
        }
        
        $data ['head_set'] = 2;
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type =='APP' ){
            $data['head_set'] = 3;
        }
        
        $data['from_customer_id'] = $customer_id;
        $data['staff_id'] = $staff_id;
        
        $data['foot_set'] = 1;
        $data['status'] = 0;
        $data['tribe_id'] = $ts_info['tribe_id'];
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/upload_staff_ablum', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 上传相册页面(已注册用户)
     */
    public function  Album_upload($tribe_id,$customer_id = 0){
        
        if( !$customer_id )
        {
            $customer_id = $this->customer_id;
        }
        $self= false;//默认帮他人上传形象
        if($customer_id == $this->session->userdata("user_id")){
            $self= true; //自己上传形象
        }
        if($self){//自己上传形象
            $data['customer_id'] = $customer_id;
            $data['from_customer_id'] = 0;
        }else{//帮他人上传形象
            $data['customer_id'] = $customer_id;
            $data['from_customer_id'] = $this->customer_id;
        }
        $this->load->model('Tribe_mdl');
        $staff_info = $this->Tribe_mdl->verify_tribe_customer($tribe_id,$customer_id);
       
        if(!$staff_info){
            echo "<script>history.back(-1);alert('非法访问');</script>";exit;
        }
        $data ['head_set'] = 2;
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type =='APP' ){
            $data['head_set'] = 3;
        }
        
        $data['foot_set'] = 1;
        $data['status'] = 0;
        $data['tribe_id'] = $tribe_id;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/upload_ablum', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
        
    }
    
    
    /**
     * 上传预录入相册图片
     */
    public function staff_upload_Album(){
        $data_post = $this->input->post();;
//          echo '<pre>';
//          print_r($data_post);exit;
        $image = array();
        $images = array();
         
        $year = date("Y",time());
        $month = date("m",time());
        $day = date("d",time());
         
        $files =  $data_post['file'];
        if($files)
        {
            $this->load->model('Tribe_staff_album_mdl');
            $created_at = date("Y-m-d H:i:s",time());
        
         
            $post['from_customer_id'] = $data_post['from_customer_id'];
            
            $post['tribe_staff_id'] =  $data_post["staff_id"];
            //成员ID
            $this->load->model('Tribe_mdl');
            $Ts_Info = $this->Tribe_mdl->load_by_staff_id($data_post["staff_id"]);
        
            $post['tribe_id'] =  $Ts_Info['tribe_id'];
            if($data_post['content']){
                $post['remark'] =  $data_post['content'];
            }
            $post['created_at'] = $created_at;
             
            $album_id =$this->Tribe_staff_album_mdl->create_Album($post);
             
             
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($data_post['add_img'],',') );
             
        
            // 图片 初始化数据
            $save_path = "uploads/staff_album/{$data_post['staff_id']}/$year/$month/$day/";
        
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
                                $image['tribe_staff_id']= $data_post["staff_id"];
                                $image['staff_album_id'] = $album_id;
                                $image['path']= $pic_path;
                                $image['created_at']= $created_at;
                                $images[]= $image;
                                $multip[] = $key;
                            }
                        }
        
                    }
                }
            }
             
            //添加数据
            $id = $this->Tribe_staff_album_mdl->Create( $images );
        
            $return['status'] = $id ? true : false;
        
            echo json_encode($return);
        
        }else{
            $return['status'] = false;
            echo json_encode($return);
        }
    }
    
    /**
     * 
     * 上传相册图片
     */
    public function upload_Album(){

        $data_post = $this->input->post();
       
        $image = array();
        $images = array();
         
        $year = date("Y",time());
        $month = date("m",time());
        $day = date("d",time());
       
        
        $files =  $data_post['file'];
        if($files)
        {
            
            
            $this->load->model('Customer_album_mdl');
            $created_at = date("Y-m-d H:i:s",time());
          
            if($data_post['from_customer_id']){
                $post['from_customer_id'] = $data_post['from_customer_id'];
            }
          
            $customer_id  =  $data_post['customer_id'];
            $post['customer_id'] = $customer_id;    
            //成员ID
            $this->load->model('Tribe_mdl');
            $Ts_Info = $this->Tribe_mdl->Customer_Ts_Info($customer_id,$data_post['tribe_id']);
            $post['tribe_staff_id'] =  $Ts_Info['staff_id'];
            
            $post['tribe_id'] =  $data_post['tribe_id'];
            if($data_post['content']){
                $post['remark'] =  $data_post['content'];
            }
            $post['created_at'] = $created_at;
            if($data_post['is_show']){
                $post['is_show'] =  $data_post['is_show'];
            }
           
            $album_id =$this->Customer_album_mdl->create_Album($post);
           
           
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim($data_post['add_img'],',') );
             
        
            // 图片 初始化数据
            $save_path = "uploads/album/$customer_id/$year/$month/$day/";
            
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
                                $image['customer_id']= $customer_id;
                                $image['album_id'] = $album_id;
                                $image['path']= $pic_path;
                                $image['created_at']= $created_at;
                                $images[]= $image;
                                $multip[] = $key;
                            }
                        }
                        
                    }
                }
            }
           
            //添加数据
            $id = $this->Customer_album_mdl->Create( $images );
            
            $return['status'] = $id ? true : false;
            
            echo json_encode($return);
        
        }else{
            $return['status'] = false;
            echo json_encode($return);
        }
        
        
    }
    
    
    
    /**
     * 暂时废除
     * 上传相册图片
     */
    public function  upload_Album11(){
      
        $image = array();
        $images = array();
        $customer_id = $this->customer_id;
        
        $year = date("Y",time());
        $month = date("m",time());
        $day = date("d",time());
        
        if( !empty( $_FILES['file'] ) )
        {
            $this->load->model('Customer_album_mdl');
            //先判断是否在关联表存在记录
            $album =$this->Customer_album_mdl->check_Album();
            if($album){
                $album_id = $album['id'];
            }else{
                $album_id =$this->Customer_album_mdl->create_Album();
            }
            
            // 图片 初始化数据
            $save_path = "uploads/album/$customer_id/$year/$month/$day/";
        
            $path = FCPATH.UPLOAD_PATH. $save_path;
           
            if ( !file_exists( $path ) )
            {
                mkdir($path,0777,true);
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
                            $image['customer_id']= $customer_id;
                            $image['album_id'] = $album_id;
                            $image['path']= $save_path.$img['file_name'];
                            $image['created_at']= date("Y-m-d",time());
                            $images[]= $image;
                        }
                }
        
            }
        
        }
      
        //添加数据
        $id = $this->Customer_album_mdl->Create( $images );
     
      
        $return['status'] = $id ? true : false;
      
        echo json_encode($return);
        
        
    }
    
    // ----------------个人形象(个人相册)-------------------------------------------------------------------
    
    /**
     * 部落族员(未注册) 个人主页 
     */
    public function  Staff_info( $staff_id = 0){
        if( !$staff_id )
        {
               echo "<script>history.back(-1);alert('参数错误！');</script>";exit;
        }
        $this->load->model('Tribe_mdl');
        $staff_info = $this->Tribe_mdl->load_by_staff_id($staff_id);
        // echo $this->db->last_query();
        //预录入的身份信息
        $data['idenity_info'] = $this->Tribe_mdl->load_staff_idenity($staff_info['mobile']);
        
        
        $tribe_info = $this->Tribe_mdl->get_tribe($staff_info['tribe_id']);
     
        $show_mobile = $staff_info['show_mobile'];
        
        // var_dump($staff_info);exit;
        if($show_mobile == 2){
            if($staff_info["tribe_id"] != 143){//2018-02-03 荣特殊要求属于143部落的用户手机号码不隐藏
                $staff_info['mobile'] = substr_replace($staff_info['mobile'],'****',3,4);
            }
        }

         // var_dump($staff_info);
       
        //预录入用户信息
        $data['staff_info'] = $staff_info;
        
        $this->load->model('Tribe_staff_album_mdl');
        $album = $this->Tribe_staff_album_mdl->get_albums($staff_id);
        $data['album'] = $album;
        
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '个人资料';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_social/staff_info', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
}