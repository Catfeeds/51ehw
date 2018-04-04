<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');


class Message extends Api_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_message_mdl','Message');
    }
    
    public function index()
    {
        echo 'Message API';
    }
    
    
    /**
     * 推送信息列表
     * title
     * type
     * customer_id
     */
    public function get_SectionLists(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        $page = $this->n;
        $return['data'] = array(
            'perpage' => 0,
            'currentpage' => 0,
            'totalpage' => 0,
            'totalcount' => 0,
            'listdate' => array()
        );
        $user_id = $this->session->userdata("user_id");
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
        
        $this->_check_prams($prams, array(
            'type'
        ));
        $data = array(
            'where'=>array(),
            'page'=>array(),
            'like'=>array(),
        );
        
        $data['where']['customer_id'] = $user_id;
        $data['where']['type'] = $prams['type'];
//         $data['where']['read'] = true;
        
        $perPage = $page['perPage']; // 每页记录数
        $currPage = $page['currPage']; // 当前页
        $offset = ($currPage - 1) * $perPage; // 偏移量
        
        
        $label_id = $this->session->userdata("label_id");
        $app_tribe_ids = array(0);
        if($label_id && $prams['type']==4){
            $app_tribe_ids = $this->get_app_tribe_ids();
            //筛选出商会加入的部落与用户加入到部落之间的交集部落
            $mytribe = $this->tribe_mdl->identical_tribe($app_tribe_ids);
             
            $app_tribe_ids = "0";
            foreach ($mytribe as $k =>$v){
                $app_tribe_ids .= ','.$v['id'];
            }
            $data['where']['tribe_id'] = $app_tribe_ids;
        }
        
        $totalcount = count($this->Message->Load_Customer_Message($data));//获取推送信息总数量
        $totalpage = $perPage ? ceil($totalcount / $perPage) : 1; // 总页数
        
//         if(isset($currPage) && $currPage == 1 ){
//             $currPage = 0;
//         }
        $data['page']['limit'] = $perPage;
        $data['page']['offset'] = $offset;
        
       
        $list =  $this->Message->Load_Customer_Message($data);//获取推送信息列表
      
        if($prams['type'] == 4){//处理APP部落担保队列消息不跳转
            foreach ($list as $key =>$val){
                if($val['template_id'] == 10){
                   $list[$key]['message'] = preg_replace("#<!--.*?-->#", "", $val['message']);
                }                            
            }
        }
        
        $this->Message->update_batch($user_id,$prams['type']);
       
        $return['data']['perpage'] = $perPage;
        $return['data']['currentpage'] = $currPage;
        $return['data']['totalcount'] = $totalcount;
        $return['data']['totalpage'] = $totalpage;
        $return['data']['listdate'] = $list;
        
         print_r(json_encode($return));
    }
    
    
    
    public function  lists(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
       
       
        
        $user_id = $this->session->userdata("user_id");
        // 验证登录
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
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
        $qian=array(" ","　","\t","\n","\r","&nbsp;");
        if(count($system_info) > 0){
           
            $system_content = preg_replace("#<!--.*?-->#", "", $system_info[0]['message']);
            $system_content =  strip_tags($system_content);
            $system_content = preg_replace("/(\s|\&nbsp\;||\xc2\xa0)/","",$system_content);
        }else{
            $system_content = '';
        }
        $order_count = count($order_array);
        if(count($order_info) > 0){
            
            $order_content = preg_replace("#<!--.*?-->#", "", $order_info[0]['message']);
            $order_content =  strip_tags($order_content);
            $order_content = preg_replace("/(\s|\&nbsp\;||\xc2\xa0)/","",$order_content);
        }else{
            $order_content = '';
        }
        $property_count = count($property_array);
        if(count($property_info) > 0){
           
            $property_content = preg_replace("#<!--.*?-->#", "", $property_info[0]['message']);
            $property_content =  strip_tags($property_content);
            $property_content = preg_replace("/(\s|\&nbsp\;||\xc2\xa0)/","",$property_content);
        }else{
            $property_content = '';
        }
        $tribe_count = count($tribe_array);
        if(count($tribe_info) > 0){
           
            $tribe_content = preg_replace("#<!--.*?-->#", "", $tribe_info[0]['message']);
            $tribe_content =  strip_tags($tribe_content);
            $tribe_content = preg_replace("/(\s|\&nbsp\;||\xc2\xa0)/","",$tribe_content);
        }else{
            $tribe_content = '';
        }
       $return['data']['system']['count'] = $system_count;
       $return['data']['system']['content'] = $system_content;
       $return['data']['order']['count'] = $order_count;
       $return['data']['order']['content'] = $order_content;
       $return['data']['property']['count'] = $property_count;
       $return['data']['property']['content'] = $property_content;
       $return['data']['tribe']['count'] = $tribe_count;
       $return['data']['tribe']['content'] = $tribe_content;
       
       $label_id = $this->session->userdata("label_id");
       if($label_id){
           
           $this->load->model('Tribe_content_mdl');
           $sift['where']['customer_id'] = $user_id;
           
           $label_id = $this->session->userdata("label_id");
           $app_tribe_ids = $this->get_app_tribe_ids();
           
           if($app_tribe_ids){
               //筛选出商会加入的部落与用户加入到部落之间的交集部落
               $mytribe = $this->tribe_mdl->identical_tribe($app_tribe_ids);
                
               $app_tribe_ids = array();
               foreach ($mytribe as $k =>$v){
                   $app_tribe_ids[] = $v['id'];
               }
               if(!$app_tribe_ids){
                   $app_tribe_ids = array(0);
               }
           }else{
               $app_tribe_ids = array(0);
           }
           
           
           //查询新的部落消息通知
           $new_message = $this->tribe_mdl->Load_Tribe_Message( $user_id ,$app_tribe_ids);
        
           if( $new_message )
           {
               $return['data']['tribe']['count'] = count($this->tribe_mdl->Load_Tribe_Message( $user_id ,$app_tribe_ids,"return_array",0));
               $return['data']['tribe']['content'] = str_replace( array('<!--','-->'),array('',''), $new_message['message'] );
           }
           
           $sift['sql_status'] = true;
           $sift['where']['tribe_id'] = $app_tribe_ids;
           
           //商会下全部的公告
           $data = $this->Tribe_content_mdl->Load_List( $sift );
       
           $announce_Not_read =count($data);
           $announce_content = '';
           if($announce_Not_read > 0){
               $this->load->model('Tribe_read_mdl');
               //已阅读数
               $read_data = $this->Tribe_read_mdl->read_list($app_tribe_ids,$user_id,1);
               $read_count = count($read_data);
               $announce_Not_read =  $announce_Not_read-$read_count;
              
               $announce_content = preg_replace("#<!--.*?-->#", "", $data[0]['content']);
               $announce_content = strip_tags($announce_content);
               $announce_content = preg_replace("/(\s|\&nbsp\;||\xc2\xa0)/","",$announce_content);

           }
           $return['data']['announcement']['count'] = $announce_Not_read;
           $return['data']['announcement']['content'] = $announce_content;
           
           $this->load->model('Tribe_activity_mdl');
           
           $activity_data = $this->Tribe_activity_mdl->Load( $sift );
           $activity_Not_read =count($activity_data);
           $act_content = '';
           if($activity_Not_read > 0){
               //已阅读数
               $act_read_data = $this->Tribe_read_mdl->read_list($app_tribe_ids,$user_id,2);
              
               $act_read_count = count($read_data);
               $activity_Not_read =  $activity_Not_read - $act_read_count;
               
               $act_content = preg_replace("#<!--.*?-->#", "", nl2br($activity_data[0]['content']));
               $act_content = preg_replace('/\s(?=\s)/', '', strip_tags($act_content));
               $act_content = preg_replace("/(\s|\&nbsp\;||\xc2\xa0)/","",$act_content);
               

           }
//            $return['data']['activity']['count'] = $activity_Not_read;
           $return['data']['activity']['count'] = 0;
           $return['data']['activity']['content'] = $act_content;
       }
      
       print_r(json_encode($return));
        
    }
    
    
    //获取商会下所有的部落ID
    private  function get_app_tribe_ids(){
        $label_id = $this->session->userdata("label_id");
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
    
    
    public function pull_Message(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $user_id = $this->session->userdata("user_id");
        $query =  $this->Message->check_read($user_id);
        if(empty($query)){
            $return['data']['status'] = false;
            $return['data']['num'] = 0;
        }else{
            $return['data']['status'] = true;
            $return['data']['num'] = count($query);
        }
        print_r(json_encode($return));
    }
    
    
    
    private function curl_post_result($url,$data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url.'&key=jiami');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return($result);
    }
}