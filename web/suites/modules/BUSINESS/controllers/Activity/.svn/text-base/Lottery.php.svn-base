<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
    
/**
 * 抽奖系统
 */
class Lottery extends Front_Controller {
    
    public function __construct() {
    
        parent::__construct();
        
        $this->load->model('Lottery_mdl');
    }
    
    
    
    
    public function index($login_type = 0,$type = 0,$key = 0){
        if($login_type){
            //1 openid 2mobile
            if(!in_array($type, array(1,2)) || !$key ){
                show_404();
                exit;
            }
            if($type == 1){
                $type = 'openid';
            }else {
                $type = 'mobile';
            }
            $load['type'] = $type;
            $load['key'] = $key;
            $Lottery_info = $this->Lottery_mdl->load($load);
           
            if(!$Lottery_info){
                echo "<script>history.back(-1);alert('连接非法');</script>";exit;
            }
            //查询今天是否有投票
            $Lottery_log = $this->Lottery_mdl->getThisDayLog($Lottery_info['id']);
         
            if(!$Lottery_log){
                echo "<script>history.back(-1);alert('您今天尚未投票哦！');</script>";exit;
            }
            
            $this->session->set_userdata('ref_from_url', current_url());
            //判断登录
            if (! $this->session->userdata('user_in'))
            {
                redirect('customer/login');
                exit();
            }
            
            $user_id = $this->session->userdata('user_id');
            
            if(!empty($Lottery_info['customer_id']) && $Lottery_info['customer_id'] != $user_id){
                echo "<script>history.back(-1);alert('连接非法');</script>";exit;
            }
            
            $where['type'] = 'customer_id';
            $where['key'] = $user_id;
            $lottery_cust = $this->Lottery_mdl->load($where);
            
            if(!$lottery_cust){
                $this->Lottery_mdl->CreateByCus();
            }
            
            if($type == 'openid' && $lottery_cust['openid']){
                if($key != $lottery_cust['openid']){
                    echo "<script>history.back(-1);alert('连接非法');</script>";exit;
                }
            }
            
            if($type == 'mobile' && $lottery_cust['mobile']){
                if($key != $lottery_cust['mobile']){
                    echo "<script>history.back(-1);alert('连接非法');</script>";exit;
                }
            }
            
            $url = $this->url_prefix.'Customer/load';
            $user_id = $this->session->userdata("user_id");
            $data_post['customer_id'] = $user_id;
            $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
            
            $mobile = 0;
            if(!empty($customer['mobile'])){
                $mobile = 1;
            }
            $data['mobile'] = $mobile;
            
            //处理记录合并
            $sift[$type] = $key;
            $this->Lottery_mdl->manage($sift);
        
            
            $LotteryID = $Lottery_info['id'];
         }else{
             $user_id = $this->session->userdata('user_id');
             $where['type'] = 'customer_id';
             $where['key'] = $user_id;
             $lottery_cust = $this->Lottery_mdl->load($where);
             if(!$lottery_cust){
                 echo "<script>history.back(-1);alert('连接非法');</script>";exit;
             }
             
             //查询今天是否有投票
             $Lottery_log = $this->Lottery_mdl->getThisDayLog($lottery_cust['id']);
             
             if(!$Lottery_log){
                 echo "<script>history.back(-1);alert('您今天尚未投票哦！');</script>";exit;
             }
             $url = $this->url_prefix.'Customer/load';
             $user_id = $this->session->userdata("user_id");
             $data_post['customer_id'] = $user_id;
             $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
             
             $mobile = 0;
             if(!empty($customer['mobile'])){
                 $mobile = 1;
             }
             $data['mobile'] = $mobile;
             
             $LotteryID = $lottery_cust['id'];
         }
        //数据处理后  重新获取后台数据
        $log = $this->Lottery_mdl->getThisDayLog($LotteryID);
        $limit_date = date('Y-m-d H:i:s', strtotime("+1 hours",strtotime($Lottery_log['vote_at'])));
        $data['Lottery'] = $log;
        $data['limit_date'] = $limit_date;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = "抽奖";
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('lottery', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    
    public function  getLotteryList(){
        $user_id = $this->session->userdata("user_id");
        
        $return['list'] = array();
        if(!$user_id){
            echo json_encode($return);
            exit;
        }
        
        $this->load->model('customer_mdl');
        $Mobile_list = $this->customer_mdl->get100Mobile();
        shuffle($Mobile_list);
        
        $msg_info = array(
            "长安客西凤酒专属优惠券50元",
            "抽中iPhoneX",
            "小米电视机",
            "长安客西凤酒专属优惠券80元",
            "长安客西凤酒专属优惠券100元",
        );
        
        foreach ($Mobile_list as $key =>$val){
            $Mobile_list[$key]['mobile'] =  substr_replace($val['mobile'],'******',3,6);
            $random =  rand(0,4);
            $Mobile_list[$key]['award'] =  $msg_info[$random];
        }
        $return['list'] = $Mobile_list;
        echo json_encode($return);
    }
    
    /**
     * 获取当前用户当天剩余抽奖数
     */
    
    public function getLotteryTotalNum(){
        $user_id = $this->session->userdata("user_id");
        if(!$user_id){
            exit;
        }
        
        $load['type'] = 'customer_id';
        $load['key'] = $user_id;
        $Lottery_info = $this->Lottery_mdl->load($load);
        $Lottery_log = $this->Lottery_mdl->getThisDayLog($Lottery_info['id']);
      
        $Num = $Lottery_log['total_num'];
        echo $Num;
    }
    
    
    /**
     * 抽奖
     */
    public function stochastic(){
        $user_id = $this->session->userdata("user_id");
        if(!$user_id){
            exit;
        }
        
       $data =  $this->input->post();
       if(empty($data)){
           exit;
       }
       if( empty($data['key'])){
           exit;
       }
       if( $data['key'] != 'stochastic'){
           exit;
       }
       
       
       $load['type'] = 'customer_id';
       $load['key'] = $user_id;
       $Lottery_info = $this->Lottery_mdl->load($load);
       if(!$Lottery_info){
           $return = array(
               "status"=> '2',
               "error_msg"=> '您尚未投过票,还不能抽奖哦！',
           );
           print_r(json_encode($return));
           exit;
       }
       $Lottery_log = $this->Lottery_mdl->getThisDayLog($Lottery_info['id']);
       if(!$Lottery_log){
           $return = array(
               "status"=> '3',
               "error_msg"=> '您今天尚未投票哦！',
           );
           print_r(json_encode($return));
           exit;
       }
       if($Lottery_log['numbers'] >= 10){
           $return = array(
               "status"=> '4',
               "error_msg"=> '您今天的抽奖次数已经用完，快去投票赢取更多抽奖次数吧！',
           );
           print_r(json_encode($return));
           exit;
       }
      
       //已抽奖总数+1
       $numbers = $Lottery_log['numbers']+1;
       //可抽奖次数-1
       $total_num =  $Lottery_log['total_num'] - 1;
       //更新已抽奖次数
       $sift = array(
           'total_num'=> $total_num,
           'numbers'=> $numbers,
           'id'=>$Lottery_log['id'],
       );
       $this->Lottery_mdl->updateNumbers($sift);
       
       $award_info  = $this->Lottery_mdl->getThisDayAwardLog($Lottery_info['id'],'item');
       
       $stochastic = array(1,1,1,1,2,2,2,4,4,6);
       if($award_info){
           $item_info = array();
           foreach ($award_info as $key => $val){
               $item_info[] = $val['item'];
           }
           
           if(in_array(2, $item_info) ){
               foreach ($stochastic as $key => $val){
                   if($val == 2){
                       $stochastic[$key] = 1;
                   }
           
               }
           }
           if(in_array(4, $item_info) ){
               foreach ($stochastic as $key => $val){
                   if($val == 4){
                       $stochastic[$key] = 1;
                   }
               }
           }
           if(in_array(6, $item_info) ){
               foreach ($stochastic as $key => $val){
                   if($val == 6){
                       $stochastic[$key] = 1;
                   }
           
               }
           }
       } 
       
       $i = rand(0,9);
       $return = array(
           'total_num'=> $total_num,
           "status"=> '0',
           "item"=> $stochastic[$i],
       );
       
       $return['item'] = 6;
       $award = '谢谢参与 GOODLUCK';
       switch ($return['item']){
           case 1:
               break;
           case 2:
               $award = '80元长安客西凤酒专属优惠券';
               break;
           case 4:
               $award = '50元长安客西凤酒专属优惠券';
               break;
           case 6:
               $award = '100元长安客西凤酒专属优惠券';
               break;
           
       }
       $add['lottery_id'] = $Lottery_log['lottery_id'];
       $add['customer_id'] = $user_id;
       $add['award'] = $award;
       $add['item'] = $return['item'];
       
       $Config_info = $this->Lottery_mdl->getLotteryConfig( $add['item']);
       if(!$Config_info){
           $return = array(
               "status"=> '77',
               "error_msg"=> '活动配置有误',
           );
           print_r(json_encode($return));
           exit;
       }
       
       $add['package_id'] = $Config_info['value'];
       $award_id = $this->Lottery_mdl->add_award($add);
     
       $return['award_id'] = $award_id;
       print_r(json_encode($return));
       
    }
    
    /**
     * 点击领取卡包
     * @param int $p_id 卡包id
     */
    public function gain_package($awardId = 0,$customer_id = 0,$type = ''){
        $this->load->model("card_package_mdl");
        
        if(!$type){
            $customer_id = $this->session->userdata("user_id");
        }
        
        $award_id = $this->input->post("award_id");
        if(!$award_id){
            $award_id = $awardId;
        }
        if(!$award_id ){
            $json = array(
                "status"=>9,
                'msg'=>'参数错误'
            );
            echo json_encode($json);
            exit;
        }
        $award_info = $this->Lottery_mdl->getAward($award_id);
        if(!$award_info){
            $json = array(
                "status"=>10,
                'msg'=>'奖品不存在'
            );
            if($type){
                return  $json;
            }else{
                echo json_encode($json);
                exit;
            }
           
        }
        if($award_info['status'] == 1){
            $json = array(
                "status"=>11,
                'msg'=>'奖品已被领取'
            );
            if($type){
                return  $json;
            }else{
                echo json_encode($json);
                exit;
            }
        }
        $p_id  = $award_info['package_id'] ;
        //查询卡包并且判断是否存在
        $package = $this->card_package_mdl->get_card_package($p_id,true);
        
        if($package){
            //判断是否已经领取
            //判断发放时间
            $row = $this->card_package_mdl->receive($p_id,$customer_id);
            if($row){
                $json = array(
                    "status"=>1,
                    'msg'=>'奖品已被领取'
                );//已经领取
                if($type){
                    return  $json;
                }else{
                    echo json_encode($json);
                    exit;
                }
            }else if($package["grant_start_at"] > date("Y-m-d")){
                $json = array(
                    "status"=>5,
                    'msg'=>'领取时间还没到'
                );//领取时间还没到
                if($type){
                    return  $json;
                }else{
                    echo json_encode($json);
                    exit;
                }
            }else if($package["grant_end_at"] < date("Y-m-d")){
                $json = array(
                    "status"=>6,
                    'msg'=>'奖品发放结束'
                );//卡包发放结束
                if($type){
                    return  $json;
                }else{
                    echo json_encode($json);
                    exit;
                }
            }else{
                $this->db->trans_begin();//开启事务
                $row1 = $this->card_package_mdl->subduction($p_id,1);//扣除卡包数量
                if(!$row1){
                    $this->db->trans_rollback();//回滚
                    $json = array(
                        "status"=>2,
                        'msg'=>'奖品数量不足'
                    );//数量不足
                    if($type){
                        return  $json;
                    }else{
                        echo json_encode($json);
                        exit;
                    }
                }
                //领取卡包
                $data[0]['p_id'] = $package['id'];
                $data[0]['sender_id'] = $package['customer_id'];
                $data[0]['customer_id'] = $customer_id;
                $data[0]['created_at'] = date("Y-m-d H:i:s");
                $data[0]['status'] = 2;
                $row2 = $this->card_package_mdl->aad_package($data);//领取
                if($row1){
                    $this->db->trans_commit();//提交
                    $this->Lottery_mdl->updataAward($award_id);
                    $json = array(
                        "status"=>3,
                        'msg'=>'领取成功'
                    );//领取成功
                    if($type){
                        return  $json;
                    }else{
                        echo json_encode($json);
                        exit;
                    }
                }else{
                    $this->db->trans_rollback();//回滚
                    $json = array(
                        "status"=>4,
                        'msg'=>'领取失败'
                    );//领取失败
                    if($type){
                        return  $json;
                    }else{
                        echo json_encode($json);
                        exit;
                    }
                        }
            }
        }else{
            $json = array(
                "status"=>4,
                'msg'=>'领取失败'
            );//领取失败
            if($type){
                return  $json;
            }else{
                echo json_encode($json);
                exit;
            }
        }
    }
    
    //绑定手机账号 并领取
    public function bingdingLottery(){
        $award_id = $this->input->post('award_id');//获奖ID
        
        $vertify1 = $this->input->post('mobile_code');//验证码
        $mobile = $this->input->post('code_mobile');//手机
        
        $vertify2 = $this->session->userdata('verfity_yzm_255');//session验证码
        $mobile2 = $this->session->userdata('verfity_mobile_255');//session手机
        $set_time = $this->session->userdata('verfity_settime_255');//session验证码有效时间
        
        //验证码验证
        if($vertify1 != $vertify2 || $mobile != $mobile2){
            $return = array(
                'status' => '33',
                'Message' => "验证码错误"
            );
            echo  json_encode($return);exit;
        }
         
        // 验证码超时验证
        if(date('Y-m-d H:i:s',strtotime("-300 second")) > $set_time){
            $return = array(
                'status' => '34',
                'Message' => "验证码超时"
            );
            echo  json_encode($return);exit;
        }
        //调用接口 查询该手机是否已经绑定用户
        $post['mobile'] = $mobile;
        $url = $this->url_prefix.'Customer/load_by_mobile';
        $_customer = json_decode($this->curl_post_result($url,$post),true);
        if($_customer){//手机之前已经注册过
        
        
        }else{
            $post['mobile'] = $mobile;
            $post['tbxRegisterPassword'] = 'ehw888888';
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
         
        //帮绑定在微信用户的抽奖记录更换到手机用户上
        $this->Lottery_mdl->changeUserAward($customer_id,$_customer['id']);
        
        //领取货包
        $return = $this->gain_package($award_id,$_customer['id'],'return');
        
        //加载用户支付账户信息写入session
        $url = $this->url_prefix.'Customer/get_pay_relation_id?';
        $data['customer_id'] = $_customer['id'];
        $pay_data = json_decode($this->curl_post_result($url,$data),true);
         
        $this->load->helper("session");
        $this->load->model("customer_mdl");
        $info = $this->customer_mdl->load($_customer['id']);
        $info['pay_relation'] = $pay_data;
        set_customer($info,"other");
        echo  json_encode($return);exit;
    }
    
    
    
    
    /**
     * 对外第三方投票接口
     * 更新抽奖次数  每次调用只能在抽奖次数的基础上+1
     * 
     */
    public function updateLottery(){
        
        $return = array(
            "error_code"=> '40001',
            "error_msg"=> '有效参数错误',
        );
        
       
        $post = $this->input->post();
        if(!$post){
            $post = $this->input->get();
        }
        //有效参数仅限第三方的openid 或 用户提交的手机号码
        if( empty($post['openid']) && empty($post['mobile']) ){
            print_r(json_encode($return));
            exit;
        }
        //openid 跟 手机号码 不能同时存在
        if(!empty($post['openid']) && !empty($post['mobile']) ){
            $return = array(
                "error_code"=> '40002',
                "error_msg"=> '提交参数有误',
            );
            print_r(json_encode($return));
            exit;
        }
        if(!empty($post['openid'])){
             $load['type'] = 'openid';
             $load['key'] = $post['openid'];
        }else{
             $load['type'] = 'mobile';
             $load['key'] = $post['mobile'];
        }
        
        
        //检查抽奖主表数据是否之前已有记录 
        $Lottery_info = $this->Lottery_mdl->load($load);
        if(!$Lottery_info){
            //没有则进入新增抽奖记录逻辑
            $Create[$load['type']]=  $load['key'];
            $Lottery_id = $this->Lottery_mdl->Create($Create);
            if(!$Lottery_id){
                $return = array(
                    "error_code"=> '40003',
                    "error_msg"=> '更新抽奖次数失败',
                );
                print_r(json_encode($return));
                exit;
            }else{
                $return = array(
                    "error_code"=> '00000',
                    "error_msg"=> '更新抽奖次数成功',
                    "total_num"=> 1,
                );
                print_r(json_encode($return));
                exit;
            }
        }else{
            //之前已在主表存在数据  
            //判断当天是否有抽奖
            $Lottery_log = $this->Lottery_mdl->getThisDayLog($Lottery_info['id']);
            if($Lottery_log){
                //判断当天抽奖次数是否达到10次上限   一天只能抽10次
                if($Lottery_log['total_num'] >=10){
                    $return = array(
                        "error_code"=> '40004',
                        "error_msg"=> '今天新增抽奖次数已达10次',
                    );
                    print_r(json_encode($return));
                    exit;
                }else{
                    $vote_at = strtotime($Lottery_log['vote_at']);
                    
                    $diff = time() - $vote_at;
                    if($diff < 3700){
                        $return = array(
                            "error_code"=> '40006',
                            "error_msg"=> '距离上一次投票不足一小时',
                        );
                        print_r(json_encode($return));
                        exit;
                    }
                    
                   //抽奖次数尚未达到10  抽奖次数+1
                    $total_num = $Lottery_log['total_num']+1;//总次数加1
                    $updateTotalNum['total_num'] = $total_num;
                    $updateTotalNum['id'] = $Lottery_log['id'];
                    $updateTotalNum['vote_num'] = $Lottery_log['vote_num']+1;
                    $datetime = date('Y-m-d H:i:s');
                    $updateTotalNum['vote_at'] = $datetime;
                    $aff = $this->Lottery_mdl->updateTotalNum($updateTotalNum);
                    if($aff){
                        $return = array(
                            "error_code"=> '00000',
                            "error_msg"=> '更新抽奖次数成功',
                            "total_num"=> $total_num,
                        );
                        print_r(json_encode($return));
                        exit;
                    }else{
                        $return = array(
                            "error_code"=> '40005',
                            "error_msg"=> '更新抽奖次数失败',
                        );
                        print_r(json_encode($return));
                        exit;
                    }
                }
            }else{
             //当天没有抽过奖   
             //新增当天抽奖记录 并且+1  
                $CreateLog['lottery_id'] = $Lottery_info['id'];
                $CreateLog['total_num'] = 1;
                $CreateLog['vote_num'] = 1;
                $datetime = date('Y-m-d H:i:s');
                $CreateLog['update_at'] = $datetime;
                $CreateLog['vote_at'] = $datetime;
                $lottery_Log_id = $this->Lottery_mdl->CreateLotteryLog($CreateLog);
                if($lottery_Log_id){
                        $return = array(
                            "error_code"=> '00000',
                            "error_msg"=> '更新抽奖次数成功',
                            "total_num"=> 1,
                        );
                        print_r(json_encode($return));
                        exit;
                    }else{
                        $return = array(
                            "error_code"=> '40005',
                            "error_msg"=> '更新抽奖次数失败',
                        );
                        print_r(json_encode($return));
                        exit;
                    }
            }
        }
        
    }
    
    
}