<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit extends Api_Controller {
    
    
    
    /**
     * 授信 && 担保
     */
    public function __construct()
    {
        parent::__construct ();
        
        $user_id = $this->session->userdata('user_id');
        if ($user_id == null || $user_id == "") {
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '5',
                'errorMessage' => '用户未登录'
            );
            print_r(json_encode($return));
            exit();
        }
    
    }
    
    
    public function index()
    {
        echo 'Credit API';
    }
    
    
    /**
     * 选择担保的部落
     */

    public function  tribe_list(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        $customer_id = $this->session->userdata("user_id");
        $this->load->model('Tribe_mdl');
        
        $list = $this->Tribe_mdl->MyTribe($customer_id);
        $return['data'] = $list;
        print_r(json_encode($return));
    }
    
    /**
     * 选择部落担保人  (担保人列表)
     *@param int tribe_id 部落ID
     */
    
    public function  Guarantee_List(){
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'tribe_id'
        ));
       $tribe_id = $prams['tribe_id'];
       $user_id = $this->session->userdata('user_id');
       if(!$user_id || $user_id == ''){
           $return['responseMessage'] = array(
               'messageType' => 'error',
               'errorType' => '5',
               'errorMessage' => '用户未登录'
           );
           print_r(json_encode($return));
           exit();
       }
       
       $this->load->model('Tribe_mdl');
       //判断用户是否加入了该部落
       $is_tribe = $this->Tribe_mdl->is_tribe_customer( $tribe_id,$user_id );
       if( $is_tribe )
       {
           $list = $this->Tribe_mdl->tribe_customer_info($tribe_id,true);
           $data = array();
           foreach ($list as $key =>$Val){
               if($Val['customer_id'] != $user_id){
                  array_push($data, $Val);
               }
           }
           $return['data'] = $data;
       }else{
           $return['responseMessage'] = array(
               'messageType' => 'error',
               'errorType' => '4',
               'errorMessage' => '您不是该部落成员'
           );
       }
       print_r(json_encode($return));
    }
    
    
    /**
     * 提交担保申请
     *@param array guarantee_ids  担保人
     *@param int tribe_id  部落ID
     */
    public function Request_Guarantee()
    {
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'guarantee_ids',
            'tribe_id',
        ));
        $tribe_id = $prams['tribe_id'];
        $guarantee_ids = $prams['guarantee_ids'];
        $user_id = $this->session->userdata('user_id');
        
        $this->load->model('Tribe_mdl');
        //判断申请者资料是否正确和是否有未结束的担保
        $my_info = $this->Tribe_mdl->be_secured( $user_id, $tribe_id );
        
        if( $my_info )
        {
            if( $my_info['total'] == 0)
            {
                $user_info = $this->Tribe_mdl->member_guarantee($guarantee_ids,$tribe_id);
                
                //判断结果是否和传值一致
                if( count( $guarantee_ids ) == count( $user_info ) )
                {
                    $guarantee_total = 0;
                    
                    //验证成功，处理批量插入数据。
                    foreach ( $user_info as $k=>$v)
                    {
                    
                        if( $v['total_guarantee_money'] < $v['guarantee_from_ceiling'] )
                        {
                            $data[$k]['customer_id'] = $user_id;
                            $data[$k]['guarantee_er_id'] = $v['customer_id'];
                            $data[$k]['tribe_id'] = $tribe_id;
                            $data[$k]['member_mobile'] = $my_info['mobile'];
                            $data[$k]['member_name'] = $my_info['member_name'];
                            $data[$k]['corporation_name'] = $my_info['corporation_name'];
                            $data[$k]['duties'] = $my_info['duties'];
                            $data[$k]['provice'] = $my_info['provice'];
                            $data[$k]['city'] = $my_info['city'];
                            $data[$k]['role_name'] = $my_info['role_name'];
                            $data[$k]['guarantee_name'] = $v['member_name'];
                            $data[$k]['guarantee_mobile'] = $v['mobile'];
                            $data[$k]['money'] = $v['guarantee_ceiling'];
                            $data[$k]['created_at'] = date('Y-m-d H:i:s');
                            $data[$k]['tribe_name'] = $my_info['tribe_name'];
                    
                    
                            //判断每个担保人的单笔担保金额加起来是否未超过自己的被担保上限
                            $guarantee_total += $v['guarantee_ceiling'];
                    
                        }else{
                            $return['responseMessage'] = array(
                                'messageType' => 'error',
                                'errorType' => '8',
                                'errorMessage' => '担保余额已经超出上限'
                            );
                            print_r(json_encode($return));
                            exit();
                        }
                    }
                    
                    //判断担保总额要小于自身被担保上限
                    if( $guarantee_total <= $my_info['guarantee_to_ceiling'] )
                    {
                        $this->load->model('Guarantee_request_mdl');
                        $ok_num = $this->Guarantee_request_mdl->Batch_Add($data);
                    
                        if( $ok_num )
                        {
                            $return['responseMessage'] = array(
                                'messageType' => 'success',
                                'errorType' => '7',
                                'errorMessage' => '申请成功'
                            );
                    
                            foreach ( $data as  $k => $v )
                            {
                    
                                $message_data['template_id'] = 10;//通知的模板Id;
                                $message_data['customer_id'] = $v['guarantee_er_id'];
                                $message_data['obj_id'] = $v['tribe_id'];
                                $message_data['type'] = 4;//部落类型;
                                $message_data['parameter']['url'] = site_url("Tribe/Members_Info/{$v['tribe_id']}/{$my_info['id']}");
                                $message_data['parameter']['name'] = $my_info['member_name'];
                                $message_data['parameter']['credit'] = $v['money'];
                                $this->load->model('Customer_message_mdl');
                                $this->Customer_message_mdl->Create_Message( $message_data );
                            }
                        }
                    }else {
                        $return['responseMessage'] = array(
                            'messageType' => 'error',
                            'errorType' => '7',
                            'errorMessage' => '超出可申请担保额度'
                        );
                    }
                    
                }else{
                    $return['responseMessage'] = array(
                        'messageType' => 'error',
                        'errorType' => '6',
                        'errorMessage' => '请选择正确用户'
                    );
                    
                }
            }else{
                $return['responseMessage'] = array(
                    'messageType' => 'error',
                    'errorType' => '5',
                    'errorMessage' => '您上一笔的担保尚未结束，无法继续申请'
                );
            }
        }else{
            $return['responseMessage'] = array(
                'messageType' => 'error',
                'errorType' => '4',
                'errorMessage' => '部落未生效或您不是该部落成员'
            );
        }
        print_r(json_encode($return));
    }
    
    
    /**
     * 提交申请授信
    *@param int m_credit  申请授信金额
     */
    public function Apply_Credit()
    {
        
        // 获取参数
        $prams = $this->p;
        $return = $this->return;
        
        // 检验参数
        $this->_check_prams($prams, array(
            'm_credit'
        ));
        
        $credit = $prams['m_credit'];
        $user_id = $this->session->userdata('user_id');
    
        
     
        $return['responseMessage'] = array(
            'messageType' => 'error',
            'errorType' => '4',
            'errorMessage' => '申请失败'
        );
    
        if( !empty($credit) && is_numeric($credit) )
        {
                //申请
                $this->load->model('Credit_mdl');
                $this->Credit_mdl->customer_id = $user_id;
                $this->Credit_mdl->credit = $credit;
                $Credit_id = $this->Credit_mdl->Add();
    
                if( $Credit_id )
                {
                    $return['responseMessage'] = array(
                        'messageType' => 'success',
                        'errorType' => '0',
                        'errorMessage' => '申请成功'
                    );
                }
           
        }
        print_r(json_encode($return));
    }
    
}