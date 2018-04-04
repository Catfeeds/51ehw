<?php
/**
 * 部落投票活动模块
 */
class Tribe_vote extends Front_Controller
{
    
    function __construct()
    {
        parent::__construct();
       
       
        if( empty( $_SERVER['HTTP_REQUEST_TYPE'] ) )
        { 
            $this->session->set_userdata('ref_from_url', current_url());
        }
        
        if( !$this->session->userdata("user_in") ) 
        {
            //ajax异步
            if( !empty( $_SERVER['HTTP_REQUEST_TYPE'] ) )
            {
                $return['status'] = 255;
                $return['message'] = '登录信息过期，重新登录';
                $return['redirect_url'] = 'javascript:history.go(0)';
                echo json_encode($return);
                exit();
        
            }else {
               
                //转跳验证。
                redirect('customer/login');
                exit();
            }
        }
       
        
        $this->customer_id = $this->session->userdata("user_id");
    }
    
  
    /**
     * 查询某个部落下的活动（投票）列表。
     * @date:2018年2月27日 下午4:13:49
     * @author: fxm
     * @param: $tribe_id = 部落ID;
     * @return: json
     */
    public function VoteList( $tribe_id = 0 )
    { 
        
        do
        { 
            if( !$tribe_id )
            { 
                $return['message'] = '参数不能为空';
                $return['status'] = 3;
                break;
            }
            
            $this->load->model('Tribe_mdl');
            $tribe_ts_info = $this->Tribe_mdl->verify_tribe_customer( $tribe_id ,$this->customer_id );
            
            if( !$tribe_ts_info )
            {
                $return['message'] = '您尚未加入该部落，无法获取';
                $return['status'] = 2;
                break;
                
            }
            
            //获取某个部落的投票活动列表。
            $this->load->model('Vote_mdl');
            $sift['where']['tribe_id'] = $tribe_id;
            $vote_list = $this->Vote_mdl->Load($sift);
            $return['data']['list'] = $vote_list;
            $return['status'] = 1;
            
        }while(0);
        
        echo json_encode($return);
       
    }
   
    
    /**
     * 投票详细信息页面
     * @date:2018年2月27日 下午4:23:47
     * @author: fxm
     * @param:  $vote_id = 投票活动ID ，$type = 显示类型;
     * @return: view
     */
    public function Detaile( $vote_id = 0, $type = 0  )
    { 
        
        do{
            //获取某个部落的投票活动详情。
            $this->load->model('Vote_mdl');
            $sift['where']['id'] = $vote_id;
            $vote_info = $this->Vote_mdl->Detaile($sift);
            
            if( !$vote_info )
            {
                $data['error']['message'] = '活动不存在';
                $data['error']['redirect_url'] = 'javascript:history.go(-1)';
                break;
            }
            
            //验证投票权限。
            if( $vote_info['authority'] == 0 )
            {
                //验证是否部落成员。
                $this->load->model('Tribe_mdl');
                $tribe_ts_info = $this->Tribe_mdl->verify_tribe_customer( $vote_info['tribe_id'] ,$this->customer_id );
                 
                if( !$tribe_ts_info )
                {
                     $data['error']['message'] = '尚未加入部落，或审核中';
                     $data['error']['redirect_url'] = site_url('Tribe/tribe_detail/'.$vote_info['tribe_id']);
                     break;
                }
            }
            
            //投票后才显示。
            if( $vote_info['result'] == 0 )
            { 
                //查询用户最新投票记录。
                $SiftNewStaffTime['where']['vote_id'] = $vote_id;
                $SiftNewStaffTime['where']['customer_id'] = $this->customer_id;
                $staff_time = $this->Vote_mdl->VoteNewStaffTime( $SiftNewStaffTime )['create_at'];
                
                
                //如果是每天投一次。
                if( $staff_time && ( $vote_info['vote_time'] == 0 || $vote_info['vote_time'] == 1 && date('Y-m-d',strtotime($staff_time) ) ==  date('Y-m-d') ) )
                {
                    $vote_info['result'] = 1;
                    
                }
                
            }
            
            //累计参与项目
            $sift_count['where']['vote_id'] = $vote_id;
            $sift_count['sql_status']['table'] = 'vote_option';
            $data['project_num'] = $this->Vote_mdl->VoteCount( $sift_count )['total_num'];
            
            //累计投票
            $sift_count['sql_status']['table'] = 'vote_staff';
            $data['staff_num'] = $this->Vote_mdl->VoteCount( $sift_count )['total_num'];
            
            
            //更新访问次数。
            $sift['sql_status']['table'] = 'vote';
            $this->Vote_mdl->VoteUpdate( $sift );
            
        }while (0);
       
        $data['type'] = $type;
        $data['vote_info'] = $vote_info;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_vote/vote', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
        
        
    }
    
    /**
     * 某个投票活动的子选项列表。
     * @date:2018年2月28日 下午4:16:49
     * @author: fxm
     * @param: $vote_id:活动ID，$type={1：默认排序，2：投票多的排序}
     * @return: 
     */
    public function OptionList( $vote_id = 0,$type = 1 )
    { 
        $page = $this->input->get('page');
        $search_name = $this->input->get('search_name');
        $vote_time = $this->input->get('vote_type') ? 1 : 0;
        
        if( !$page  || !is_numeric($page) || !is_int($page+0)  )
        {
            $page = 1;
        }
        
        $limit = 2;
        $offset = ( $page-1 ) * $limit;//偏移量
        
        //查询活动子选项列表
        $this->load->model('Vote_mdl');
        
        if( $search_name )
        {
            $sift_option['like']['option_tile_id'] = $search_name;
        }
        $sift_option['where']['vote_id'] = $vote_id;
        $sift_option['page']['limit'] = $limit;
        $sift_option['page']['offset'] = $offset;
        
        
        $date = date('Y-m-d');
        
        if( $type == 2 )
            $sift_option['sql_status'] = 'votes_num_ordeby';
        
        $option_list = $this->Vote_mdl->VoteOptionList( $sift_option );
        
        if( $option_list )
        { 
            //批量查询是否有投票记录，返回状态和投票时间。
            $option_ids = array_column($option_list, 'id');
            $sift['where']['customer_id'] = $this->customer_id;
            $sift['where']['option_id'] = $option_ids;
            $staff_list = $this->Vote_mdl->VoteStaffNew( $sift );
            
            if( $staff_list )
            { 
                $staff_list = array_column($staff_list,NULL,'option_id');
            }
            
            foreach ( $option_list as $k => $v )
            {
                $option_list[$k]['is_vote'] = true;
            
                //默认只能投票一次。
                if( !empty( $staff_list[$v['id']] ) )
                {
                    $option_list[$k]['is_vote'] = false;
            
                    //如果是每天投一次。
                    if( $vote_time == 1 && date('Y-m-d',strtotime($staff_list[$v['id']]['create_at']) ) != $date )
                    {
                        $option_list[$k]['is_vote'] = true;
            
                    }
                }
            }
            
//             echo '<pre>';
//             var_dump($option_list);
//             exit();
        }           
        
        $return['data']['type'] = $type;
        $return['data']['list'] = $option_list;
        $return['data']['limit'] = $limit;
        echo json_encode($return);
    }
    
    /**
     * 投票活动子选项详情信息。
     */
    public function OptionDetaile( $option_id = 0 )
    {
        
        do {
            
            if( !$option_id )
            {
                //参数错误
                $data['error']['message'] = '参数错误';
                $data['error']['redirect_url'] = 'javascript:history.go(-1)';
                break;
            }
            
            //查询子选项and项目信息
            $this->load->model('Vote_mdl');
            $sift['where']['id'] = $option_id;
            $VoteOptionInfo = $this->Vote_mdl->VoteOptionDetaile( $sift );
            
            if( !$VoteOptionInfo )
            {
                //活动不存在
                $data['error']['message'] = '活动不存在';
                $data['error']['redirect_url'] = 'javascript:history.go(-1)';
                break;
            }
            
            //验证投票权限。
            if( $VoteOptionInfo['authority'] == 0 )
            {
                //验证是否部落成员。
                $this->load->model('Tribe_mdl');
                $tribe_ts_info = $this->Tribe_mdl->verify_tribe_customer( $VoteOptionInfo['tribe_id'] ,$this->customer_id );
                 
                if( !$tribe_ts_info )
                {
                    //未加入部落；
                    $data['error']['message'] = '尚未加入部落，或审核中';
                    $data['error']['redirect_url'] = site_url('Tribe/tribe_detail/'.$vote_info['tribe_id']);
                    break;
                }
            }
            
            //查询是否可投票。
            $sift_staff['where']['customer_id'] = $this->customer_id;
            $sift_staff['where']['option_id'] = $option_id;
            $staff_info = $this->Vote_mdl->VoteStaffNew( $sift_staff );
             
            $VoteOptionInfo['is_vote'] = true;
            
            //默认只能投票一次。
            if( !empty( $staff_info ) )
            {
                $VoteOptionInfo['is_vote'] = false;
            
                //如果是每天投一次。
                if( $VoteOptionInfo['vote_time'] == 1 && date('Y-m-d',strtotime($staff_info['create_at']) ) != date('Y-m-d') )
                {
                    $VoteOptionInfo['is_vote'] = true;
                }
            }
            
            //是否显示票数 0投票后可见1任何人可见。
            if( $VoteOptionInfo['result'] == 0 )
            {
                //查询用户最新投票记录。
                $SiftNewStaffTime['where']['vote_id'] = $VoteOptionInfo['vote_id'];
                $SiftNewStaffTime['where']['customer_id'] = $this->customer_id;
                $staff_time = $this->Vote_mdl->VoteNewStaffTime( $SiftNewStaffTime )['create_at'];
            
                //如果是每天投一次。
                if( $staff_time && ( $VoteOptionInfo['vote_time'] == 0 || $VoteOptionInfo['vote_time'] == 1 && date('Y-m-d',strtotime($staff_time) ) ==  date('Y-m-d') ) )
                {
                    $VoteOptionInfo['result'] = 1;
                 }
            }
            
           
            //累计投票
            $sift_count['where']['option_id'] = $option_id;
            $sift_count['sql_status']['table'] = 'vote_staff';
            $VoteOptionInfo['staff_num'] = $this->Vote_mdl->VoteCount( $sift_count )['total_num'];
            
            
            //更新访问次数。
            $this->load->model('Vote_mdl');
            $sift['sql_status']['table'] = 'vote_option';
            $this->Vote_mdl->VoteUpdate( $sift );
            
        }while(0);
        
        
//         echo '<pre>';
//         var_dump($VoteOptionInfo);
//         exit();
        $data['VoteOptionInfo'] = $VoteOptionInfo;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_vote/vote_detail', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 用户投票。
     * @date:2018年2月27日 下午5:37:21
     * @author: fxm
     * @param: $option_id = 投票活动子选项ID
     * @return: json
     */
    public function VoteSub( $option_id = 0 )
    { 
        
        $return['status'] = false;
        
        do {
            //解耦拆分SQL.
            
           //查询子选项and项目信息
            $this->load->model('Vote_mdl');
            $sift['where']['id'] = $option_id;
            $VoteOptionInfo = $this->Vote_mdl->VoteOptionDetaile( $sift );
            
            if( !$VoteOptionInfo )
            { 
                //投票活动不存在
                $return['message'] = '投票活动不存在';
                break;
            }
            
            $datetime = date('Y-m-d H:i:s');//日期时间
            
            //验证投票开始时间
            if( $VoteOptionInfo['start_time'] > $datetime )
            { 
                //投票尚未开始。
                $return['message'] = '投票尚未开始';
                break;
            }
            
            //验证投票结束时间
            if( $VoteOptionInfo['end_time'] < $datetime )
            {
                //投票已结束。
                $return['message'] = '投票已结束';
                break;
            }
            
            //验证投票权限。
            if( $VoteOptionInfo['authority'] == 0 )
            { 
                //验证是否部落成员。
                 $this->load->model('Tribe_mdl');
                 $tribe_ts_info = $this->Tribe_mdl->verify_tribe_customer( $VoteOptionInfo['tribe_id'] ,$this->customer_id );
                 
                 if( !$tribe_ts_info )
                 {
                     //未加入部落；
                     $return['redirect_url']  = site_url('Tribe/tribe_detail/'.$VoteOptionInfo['tribe_id']);
                     $return['message'] = '尚未加入部落，或审核中';
                     break;
                 }
            }
            
            //验证该活动每日可投票数量。
            if( $VoteOptionInfo['multi_nums'] != 0 )
            { 
                //查询今天用户在该活动中心投票了几个子选项。
                $sift_VoteNum['where']['vote_id'] = $VoteOptionInfo['vote_id'];
                $sift_VoteNum['where']['customer_id'] = $this->customer_id;
                $count_num = $this->Vote_mdl->CustomerVoteNum($sift_VoteNum)['num'];
                
                //验证每日可投票对象数量。
                if( $count_num >= $VoteOptionInfo['multi_nums']  )
                {
                    $return['message'] = '今日投票已达上限';
                    break;
                }
            }
           
            //验证投票平台
            if( !in_array($VoteOptionInfo['vote_platform'], array( 0,2 ) ) )
            { 
                //下载app才能投票 
                $return['message'] = '该活动仅支持APP内投票';
                break;
            }
            
            //验证子选项是否可投票。
            $is_vote = true;
            $sift_staff['where']['customer_id'] = $this->customer_id;
            $sift_staff['where']['option_id'] = $option_id;
            $staff_info = $this->Vote_mdl->VoteStaffNew( $sift_staff );
            
            //默认只能投票一次。
            if( !empty( $staff_info ) )
            {   
                $is_vote = false;
                
                //如果是每天投一次。
                if( $VoteOptionInfo['vote_time'] == 1 && date('Y-m-d',strtotime($staff_info['create_at']) ) != date('Y-m-d') )
                {
                    $is_vote = true;
                }
            }
           
            //不可继续投票提示。
            if ( !$is_vote )
            { 
                $return['message'] = $VoteOptionInfo['vote_time'] == 1 ? '您今日已投过该项目' : '您已投过该项目';
                break;
            }
            
            $data['vote_id'] = $VoteOptionInfo['vote_id'];
            $data['option_id'] = $option_id;
            $data['customer_id'] = $this->customer_id;
            $data['wechat_head'] = $this->session->userdata('wechat_avatar');
            $data['unionId'] = $this->session->userdata('unionid');
            $data['wechat_nick_name'] = $this->session->userdata('wechat_nickname');
            
            $vote_staff_id = $this->Vote_mdl->CreateVoteStaff( $data );
            
            if( !$vote_staff_id )
            { 
                $return['message'] = '投票失败，请重试';
                break;
            }
            
            $return['status'] = true;
            $return['message'] = '投票成功';
            
        }while(0);
        
        echo json_encode($return);
    }
    
    
    
    
    
 
}