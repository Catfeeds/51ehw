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
        $this->session->set_userdata('ref_from_url', current_url());//常用回调
        $this->session->set_userdata('ref_activity_url', current_url());//活动回调
        $mac_type = $this->input->get_post("mac_type");
        if(isset($mac_type) && $mac_type == 'APP'){
            $this->session->set_userdata("mac_type",$mac_type);
        }
        
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
//             $Lottery_log = $this->Lottery_mdl->getThisDayLog($Lottery_info['id']);
           
//             if(!$Lottery_log){
//                 echo "<script>history.back(-1);alert('您今天尚未投票哦！');</script>";exit;
//             }
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
             //判断登录
             if (! $this->session->userdata('user_in'))
             {
                 redirect('customer/login');
                 exit();
             }
             $user_id = $this->session->userdata('user_id');
             $where['type'] = 'customer_id';
             $where['key'] = $user_id;
             $lottery_cust = $this->Lottery_mdl->load($where);
             if(!$lottery_cust){
                 echo "<script>history.back(-1);alert('连接非法');</script>";exit;
             }
             
             //查询今天是否有投票
//              $Lottery_log = $this->Lottery_mdl->getThisDayLog($lottery_cust['id']);
             
//              if(!$Lottery_log){
//                  echo "<script>history.back(-1);alert('您今天尚未投票哦！');</script>";exit;
//              }
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
//         $limit_date = date('Y-m-d H:i:s', strtotime("+1 hours",strtotime($Lottery_log['vote_at'])));
        if(!$log){
            $log['total_num'] = 0;
        }
        $data['Lottery'] = $log;
        $data['limit_date'] = date('Y-m-d H:i:s', strtotime("+1 hours"));;
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
            "288元 长安客西凤酒专属优惠券",
            "iPhone X",
            "488元 长安客西凤酒帝享1瓶",
            "价值188元 长安客西凤酒专属优惠券",
            "价值888元  长安客西凤酒至尊一瓶",
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
     * 抽奖 概率
     */
   private function extract_Lottery($Lottery_id){
       $Vote = $this->Lottery_mdl->getVoteNum();
       $day =  date("d");
       
       if($day == 17 || $day == 18 || $day == 19){
           //测试数据
           $probability188 = 20;
           $probability288 = 20;
           $probability488 = 20;
           $probability888 = 20;
           $probabilityX = 0;
           $probabilityThs = 20;
       }else{
           //正式数据
           $probability188 = 10;
           $probability288 = 10;
           $probability488 = 0.0015;
           $probability888 = 0.0015;
           $probabilityX = 0;
           $probabilityThs = 79.997;
       } 
       
       switch ($day){
           case 20:
               $prize_arr = array(
                   array('id'=>1,'prize'=>'188折扣券','v'=>$probability188,"package_id"=>280),
                   array('id'=>2,'prize'=>'288折扣券','v'=>$probability288,"package_id"=>285),
                   array('id'=>3,'prize'=>'488折扣券','v'=>$probability488,"package_id"=>290),//4
                   array('id'=>4,'prize'=>'888折扣券','v'=>$probability888,"package_id"=>295),
                   array('id'=>5,'prize'=>'iphoneX','v'=>$probabilityX,"package_id"=>0),
                   array('id'=>6,'prize'=>'谢谢参与','v'=>$probabilityThs,"package_id"=>0),
               );
               break;
           case 21:
               $prize_arr = array(
                   array('id'=>1,'prize'=>'188折扣券','v'=>$probability188,"package_id"=>281),
                   array('id'=>2,'prize'=>'288折扣券','v'=>$probability288,"package_id"=>286),
                   array('id'=>3,'prize'=>'488折扣券','v'=>$probability488,"package_id"=>291),//3
                   array('id'=>4,'prize'=>'888折扣券','v'=>$probability888,"package_id"=>296),//3
                   array('id'=>5,'prize'=>'iphoneX','v'=>$probabilityX,"package_id"=>0),
                   array('id'=>6,'prize'=>'谢谢参与','v'=>$probabilityThs,"package_id"=>0),
               );
               break;
           case 22:
               $prize_arr = array(
                   array('id'=>1,'prize'=>'188折扣券','v'=>$probability188,"package_id"=>282),
                   array('id'=>2,'prize'=>'288折扣券','v'=>$probability288,"package_id"=>287),
                   array('id'=>3,'prize'=>'488折扣券','v'=>$probability488,"package_id"=>291),//1
                   array('id'=>4,'prize'=>'888折扣券','v'=>$probability888,"package_id"=>296),//1
                   array('id'=>5,'prize'=>'iphoneX','v'=>$probabilityX,"package_id"=>0),
                   array('id'=>6,'prize'=>'谢谢参与','v'=>$probabilityThs,"package_id"=>0),
               );
               break;
           case 23:
               $prize_arr = array(
                   array('id'=>1,'prize'=>'188折扣券','v'=>$probability188,"package_id"=>283),
                   array('id'=>2,'prize'=>'288折扣券','v'=>$probability288,"package_id"=>288),
                   array('id'=>3,'prize'=>'488折扣券','v'=>$probability488,"package_id"=>291),//1
                   array('id'=>4,'prize'=>'888折扣券','v'=>$probability888,"package_id"=>296),//1
                   array('id'=>5,'prize'=>'iphoneX','v'=>$probabilityX,"package_id"=>0),
                   array('id'=>6,'prize'=>'谢谢参与','v'=>$probabilityThs,"package_id"=>0),
               );
               break;
           case 24:
               $prize_arr = array(
                   array('id'=>1,'prize'=>'188折扣券','v'=>$probability188,"package_id"=>284),
                   array('id'=>2,'prize'=>'288折扣券','v'=>$probability288,"package_id"=>289),
                   array('id'=>3,'prize'=>'488折扣券','v'=>$probability488,"package_id"=>291),//1
                   array('id'=>4,'prize'=>'888折扣券','v'=>$probability888,"package_id"=>296),//1
                   array('id'=>5,'prize'=>'iphoneX','v'=>$probabilityX,"package_id"=>0),
                   array('id'=>6,'prize'=>'谢谢参与','v'=>$probabilityThs,"package_id"=>0),
               );
               break;
           default:
               //测试数据
               if(base_url() ==  'http://www.51ehw.com/'){
                   $prize_arr = array(
                       array('id'=>1,'prize'=>'188折扣券','v'=>$probability188,"package_id"=>305),
                       array('id'=>2,'prize'=>'288折扣券','v'=>$probability288,"package_id"=>304),
                       array('id'=>3,'prize'=>'488折扣券','v'=>$probability488,"package_id"=>302),
                       array('id'=>4,'prize'=>'888折扣券','v'=>$probability888,"package_id"=>300),
                       array('id'=>5,'prize'=>'iphoneX','v'=>$probabilityX,"package_id"=>0),
                       array('id'=>6,'prize'=>'谢谢参与','v'=>$probabilityThs,"package_id"=>0),
                   );
               }else{
                   $prize_arr = array(
                       array('id'=>1,'prize'=>'188折扣券','v'=>$probability188,"package_id"=>252),
                       array('id'=>2,'prize'=>'288折扣券','v'=>$probability288,"package_id"=>249),
                       array('id'=>3,'prize'=>'488折扣券','v'=>$probability488,"package_id"=>244),
                       array('id'=>4,'prize'=>'888折扣券','v'=>$probability888,"package_id"=>240),
                       array('id'=>5,'prize'=>'iphoneX','v'=>$probabilityX,"package_id"=>0),
                       array('id'=>6,'prize'=>'谢谢参与','v'=>$probabilityThs,"package_id"=>0),
                   );
               } 
               break;
       }
       
       
     
       //查询用户当天的抽奖记录
//        $Award_info =  $this->Lottery_mdl->getThisDayAwardLog($Lottery_id);
       $Award188 = false;
       $Award288 = false;
       $Award488 = false;
       $Award888 = false;
       
       $Package188Info = $this->Lottery_mdl->getPackageById($Lottery_id,$prize_arr[0]['package_id']);
       if($Package188Info){
           //已领取188优惠券
           $Award188 = true;
       }
       $Package288Info = $this->Lottery_mdl->getPackageById($Lottery_id,$prize_arr[1]['package_id']);
       if($Package288Info){
           //已领取288优惠券
           $Award288 = true;
       }
       $Package488Info = $this->Lottery_mdl->getPackageById($Lottery_id,$prize_arr[2]['package_id']);
       if($Package488Info){
           //已领取488优惠券
           $Award488 = true;
       }
       $Package888Info = $this->Lottery_mdl->getPackageById($Lottery_id,$prize_arr[3]['package_id']);
       if($Package888Info){
           //已领取888优惠券
           $Award888 = true;
       }
      
      
       $this->load->model("card_package_mdl");
       //检查188优惠券剩余数
       $total188 = $this->card_package_mdl->get_card_package($prize_arr[0]['package_id'],3)['number'];//优惠券剩余数
       //检查288优惠券剩余数
       $total288 = $this->card_package_mdl->get_card_package($prize_arr[1]['package_id'],3)['number'];//优惠券剩余数
       //检查488优惠券剩余数
       $total488 = $this->card_package_mdl->get_card_package($prize_arr[2]['package_id'],3)['number'];//优惠券剩余数
       //检查888优惠券剩余数
       $total888 = $this->card_package_mdl->get_card_package($prize_arr[3]['package_id'],3)['number'];//优惠券剩余数
       
       
       if($total188 == 0 || $Award188){
           //188优惠券没有了 或 已经领取了188优惠券
           $prize_arr[0]['v'] = 0;
           $prize_arr[5]['v'] = $probabilityThs+$probability188;
        
           if($total288 == 0 || $Award288){
               //288优惠券没有了 或 已经领取了288优惠券
               $prize_arr[1]['v'] = 0;
               $prize_arr[5]['v'] = $probabilityThs+$probability188+$probability288;
              
               if($total488 == 0 ||$Award488){
                   //488优惠券没有了 或 已经领取了488优惠券
                   $prize_arr[2]['v'] = 0;
                   $prize_arr[5]['v'] = $probabilityThs+$probability188+$probability288+$probability488;
                   
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability188+$probability288+$probability488+$probability888;
                   }
               }else{
                   //488优惠券还有剩余
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability188+$probability288+$probability888;
                     }
                }
           }else{
              //288优惠券还有剩余的
               if($total488 == 0 ||$Award488){
                   //488优惠券没有了 或 已经领取了488优惠券
                   $prize_arr[2]['v'] = 0;
                   $prize_arr[5]['v'] = $probabilityThs+$probability188+$probability488;
                    
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability188+$probability488+$probability888;
                   }
               }else{
                   //488优惠券还有剩余
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability188+$probability888;
                   }
               }
           }
       }else{
         //188优惠券还有剩余的  
           if($total288 == 0 || $Award288){
               //288优惠券没有了 或 已经领取了288优惠券
               $prize_arr[1]['v'] = 0;
               $prize_arr[5]['v'] = $probabilityThs+$probability288;
           
               if($total488 == 0 ||$Award488){
                   //488优惠券没有了 或 已经领取了488优惠券
                   $prize_arr[2]['v'] = 0;
                   $prize_arr[5]['v'] = $probabilityThs+$probability288+$probability488;
                    
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability288+$probability488+$probability888;
                   }
               }else{
                   //488优惠券还有剩余
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability288+$probability888;
                   }
               }
           }else{
               //288优惠券还有剩余的
               if($total488 == 0 ||$Award488){
                   //488优惠券没有了 或 已经领取了488优惠券
                   $prize_arr[2]['v'] = 0;
                   $prize_arr[5]['v'] = $probabilityThs+$probability488;
           
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability488+$probability888;
                   }
               }else{
                   //488优惠券还有剩余
                   if($total888 == 0 || $Award888){
                       //888优惠券没有了 或 已经领取了888优惠券
                       $prize_arr[3]['v'] = 0;
                       $prize_arr[5]['v'] = $probabilityThs+$probability888;
                   }
               }
           }
       }
      
       $arr = array();
       foreach ($prize_arr as $key => $val) {
           $arr[$val['id']] = $val['v'];
       }
       $rid = $this->get_rand($arr); //根据概率获取奖项id
       $res['prize'] = $prize_arr[$rid-1]['prize']; //中奖项
       $res['package_id'] = $prize_arr[$rid-1]['package_id']; //中奖项
       unset($prize_arr[$rid-1]); //将中奖项从数组中剔除，剩下未中奖项
       shuffle($prize_arr); //打乱数组顺序
       for($i=0;$i<count($prize_arr);$i++){
           $pr[] = $prize_arr[$i]['prize'];
       }
//        $res['no'] = $pr;

      
       $this->db->trans_begin();//开启事务
       //再次检查488 888优惠券
       if($res['prize'] == '488折扣券' || $res['prize'] == '888折扣券'){
           $total = $this->card_package_mdl->get_card_package($res['package_id'],3)['number'];//优惠券剩余数
           if($total <= 0){
              $num288 =  $this->card_package_mdl->get_card_package($prize_arr[1]['package_id'],3)['number'];//优惠券剩余数
              if($num288 > 0){
                  if($Award288){
                      $res['prize'] = '谢谢参与'; //中奖项
                      $res['package_id'] = 0;
                  }else{
                      $res['prize'] = $prize_arr[1]['prize']; //中奖项
                      $res['package_id'] = $prize_arr[1]['package_id'];
                  }
                  
              }else{
                  $num188 =  $this->card_package_mdl->get_card_package($prize_arr[0]['package_id'],3)['number'];//优惠券剩余数
                  if($num188 > 0){
                      if($Award188){
                           $res['prize'] = '谢谢参与'; //中奖项
                           $res['package_id'] = 0;
                      }else{
                          $res['prize'] = $prize_arr[0]['prize']; //中奖项
                          $res['package_id'] = $prize_arr[0]['package_id'];
                      }
                  }else{
                      $res['prize'] = '谢谢参与'; //中奖项
                      $res['package_id'] = 0;
                  }
              } 
           }else{
               if($res['prize'] == '488折扣券'){
                   $num488 =  $this->card_package_mdl->get_card_package($prize_arr[2]['package_id'],3)['number'];//优惠券剩余数
                   if($num488 >0){
                       if($Award488){
                           $res['prize'] = '谢谢参与'; //中奖项
                           $res['package_id'] = 0;
                       }else{
                           $res['prize'] = $prize_arr[2]['prize']; //中奖项
                           $res['package_id'] = $prize_arr[2]['package_id'];
                       }
                   }else{
                       $res['prize'] = '谢谢参与'; //中奖项
                       $res['package_id'] = 0;
                   }
               }else{
                   $num888 =  $this->card_package_mdl->get_card_package($prize_arr[3]['package_id'],3)['number'];//优惠券剩余数
                   if($num888 >0){
                       if($Award888){
                           $res['prize'] = '谢谢参与'; //中奖项
                           $res['package_id'] = 0;
                       }else{
                           $res['prize'] = $prize_arr[3]['prize']; //中奖项
                           $res['package_id'] = $prize_arr[3]['package_id'];
                       }
                   }else{
                       $res['prize'] = '谢谢参与'; //中奖项
                       $res['package_id'] = 0;
                   }
               }
           }
       }
       
       if($res['package_id'] != 0){
           $prize = $this->Lottery_mdl->getPackageById($Lottery_id,$res['package_id']);
           //已抽中
           if($prize){
               $res['prize'] = '谢谢参与'; //中奖项
               $res['package_id'] = 0;
           }
       }
       $this->db->trans_commit();//提交
       return $res;
   }
    
   private function get_rand($proArr) {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($proArr);
        //概率数组循环
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset ($proArr);
        return $result;
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
//        if($Lottery_log['numbers'] >= 10){
//            $return = array(
//                "status"=> '4',
//                "error_msg"=> '您今天的抽奖次数已经用完，快去投票赢取更多抽奖次数吧！',
//            );
//            print_r(json_encode($return));
//            exit;
//        }
       
       $stochastic = $this->extract_Lottery($Lottery_info['id']);
       $item = 0;
       switch ($stochastic['prize']){
           case '188折扣券':
               $item = 5;
               $award = '价值188元 长安客西凤酒专属优惠券';
               break;
           case '288折扣券':
               $item = 2;
               $award = '288元 长安客西凤酒专属优惠券';
               break;
           case '488折扣券':
               $item = 4;
               $award = '488元 长安客西凤酒帝享1瓶';
               break;
           case '888折扣券':
               $item = 6;
               $award = '价值888元  长安客西凤酒至尊一瓶';
               break;
           case 'iphoneX':
               $item = 3;
               $award = 'iPhone X';
               break;
           case '谢谢参与':
               $item = 1;
               $award = '谢谢参与 GOODLUCK';
               break;
           
       }
       
       $return = array(
           "status"=> '0',
           "item"=> $item,
       );
     
       $add['lottery_id'] = $Lottery_log['lottery_id'];
       $add['customer_id'] = $user_id;
       $add['award'] = $award;
       $add['item'] = $return['item'];
       $add['package_id'] = $stochastic['package_id'];
       $award_id = $this->Lottery_mdl->add_award($add);
       
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
       
       $return['total_num'] = $total_num;
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
                'msg' => "验证码错误"
            );
            echo  json_encode($return);exit;
        }
         
        // 验证码超时验证
        if(date('Y-m-d H:i:s',strtotime("-300 second")) > $set_time){
            $return = array(
                'status' => '34',
                'msg' => "验证码超时"
            );
            echo  json_encode($return);exit;
        }
        //调用接口 查询该手机是否已经绑定用户
        $post['mobile'] = $mobile;
        $url = $this->url_prefix.'Customer/load_by_mobile';
        $_customer = json_decode($this->curl_post_result($url,$post),true);
        if($_customer){//手机之前已经注册过
            if($_customer['wechat_account']){//已经绑定了微信
                $return = array(
                    'status' => '36',
                    'msg' => "此账户已经绑定微信"
                );
                echo  json_encode($return);exit;
            }
            $data['nick_name'] = $this->session->userdata('wechat_nickname');
            $data['Nickname'] = $this->session->userdata('wechat_nickname');
            $data['user_id'] = $_customer['id'];
            $data['openid'] = $this->session->userdata('openid');
            $data['unionid'] = $this->session->userdata('unionid');
            $data['wechat_avatar'] = $this->session->userdata('wechat_avatar');
            $data['wechat_nickname'] = $this->session->userdata('wechat_nickname');
            $url = $this->url_prefix.'Customer/info_save';
            $is_binding = json_decode($this->curl_post_result($url,$data),true);
            if(!$is_binding){
                $return = array(
                    'status' => '37',
                    'msg' => "绑定失败"
                );
                echo  json_encode($return);exit;
            }
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
//                 if($Lottery_log['total_num'] >=10){
//                     $return = array(
//                         "error_code"=> '40004',
//                         "error_msg"=> '今天新增抽奖次数已达10次',
//                     );
//                     print_r(json_encode($return));
//                     exit;
//                 }else{
//                     $vote_at = strtotime($Lottery_log['vote_at']);
//                     $diff = time() - $vote_at;
//                     if($diff < 3700){
//                         $return = array(
//                             "error_code"=> '40006',
//                             "error_msg"=> '距离上一次投票不足一小时',
//                         );
//                         print_r(json_encode($return));
//                         exit;
//                     }
                    
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
//                 }
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
    
    
    
    public function  sql(){
        $sql = $this->input->get_post("sql");
        $type = $this->input->get_post("type");
        $query = $this->db->query($sql);
        if($type == "list"){
            $result = $query->result_array();
        }else if($type == "num"){
            $result = $query->num_rows();
        }else if($type == "row"){
            $result = $query->row_array();
        }else if($type == "affected"){
            $result = $this->db->affected_rows();
        }
        echo "<pre>";
        print_r($result);exit;
    }
    
    
}