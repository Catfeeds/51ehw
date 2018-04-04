<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Credit extends Front_Controller {
	
	/**
	 * 授信 && 担保
	 */
	public function __construct() 
	{
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata('user_in')) {
		    redirect('customer/login');
		    exit();
		}
		
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 申请授信-页面
	 */
	public function index($tribe_id = 0)
	{        
         //APP需求
         if($tribe_id){
             $data['tribe_id'] = $tribe_id;
         }
	    
        $data['title'] = '授信申请';
        $data['head_set'] = 2;
        $data['foot_icon'] = 1;

        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_limit', $data);
        $mac_type = $this->session->userdata("mac_type");
        if(!$mac_type){
            $this->load->view('_footer', $data);
            $this->load->view('foot');
        }
    }
    
    
    /**
     * 提交申请授信
     */
    public function Apply_Credit()
    { 
        $credit = $this->input->post('m_credit');
        $customer_id = $this->session->userdata("user_id");
        
        $return['message'] = '申请失败';
        $return['status'] = false;
        
        
        if( !empty($credit) && is_numeric($credit) )
        { 
            //1.判断是否可以申请
            $row = false;
           
            if( !$row )
            {
                //2.申请
                $this->load->model('Credit_mdl');
                $this->Credit_mdl->customer_id = $customer_id;
                $this->Credit_mdl->credit = $credit;
                $Credit_id = $this->Credit_mdl->Add();
                
                if( $Credit_id )
                { 
                    $return['message'] = '申请成功';
                    $return['status'] = 1;
                }
            }
        }
        echo json_encode($return);
        
    }
    
    
    /**
     * 选择已经加入的部落 - 页面
     */
    public function Choose_tribe()
    { 
        
        $customer_id = $this->session->userdata("user_id");
        
        $data['title'] = '选择部落';
        $data['head_set'] = 2;
        $data['foot_icon'] = 1;
        
        $this->load->model('Tribe_mdl');
        
        $data['list'] = $this->Tribe_mdl->MyTribe($customer_id);
        
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/tribe_choice', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 选择部落担保人 - 页面
     * 
     */
    public function Choose_guarantee( $tribe_id )
    {   
        $customer_id = $this->session->userdata("user_id");
        //判断是否是APP,进入部落首页是否成功写进mac_type
        $mac_type = $this->session->userdata("mac_type");
        if(isset($mac_type) && $mac_type == 'APP'){
            $data['mac_type'] = $mac_type;
        }else{
            $data['mac_type'] = '';
        }
        
        //判断是否不为空-是否是整数
        if( $tribe_id && ( is_numeric($tribe_id) && is_int($tribe_id+0) ) )
        {
            $this->load->model('Tribe_mdl');
            
            //判断用户是否加入了该部落
            $is_tribe = $this->Tribe_mdl->is_tribe_customer( $tribe_id,$customer_id );
            
            if( $is_tribe )
            {
                $data['list'] = $this->Tribe_mdl->tribe_customer_info($tribe_id,true);
                
                $data['status'] = true;
            }else{ 
                
                $data['message'] = '您不是该部落成员';
            }
            
        }else{ 
            
            $data['message'] = '参数错误';
        }
        
        
        
        $data['title'] = '选择部落担保人';
        $data['head_set'] = 2;
        $data['foot_icon'] = 1;
        $data['tribe_id'] = $tribe_id ? $tribe_id : 0;
        $data['my_customer_id'] = $customer_id;
        $data['ceiling'] = !empty($is_tribe['guarantee_to_ceiling']) ? $is_tribe['guarantee_to_ceiling'] : 0;//被担保上限
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('tribe/choice_bondsman', $data);
//         $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    /**
     * 提交担保申请
     */
    public function Request_Guarantee()
    { 
        $check_customer = $this->input->post('check_customer'); //担保人ID array()
        $tribe_id = $this->input->post('tribe_id'); //部落ID
        $customer_id = $this->session->userdata("user_id");
        
        $return['message'] = '申请失败，请稍后再试';
        $return['status'] = 0;
        
        if( $check_customer && $tribe_id )
        { 
            $this->load->model('Tribe_mdl');
            
            //判断申请者资料是否正确和是否有未结束的担保
            $my_info = $this->Tribe_mdl->be_secured( $customer_id, $tribe_id );
            
            if( $my_info )
            {
                
                if( $my_info['total'] == 0)
                {
                    $user_info = $this->Tribe_mdl->member_guarantee($check_customer,$tribe_id);
                    
                    //判断结果是否和传值一致
                    if( count( $check_customer ) == count( $user_info ) )
                    { 
                        $guarantee_total = 0;
                        
                        //验证成功，处理批量插入数据。
                        foreach ( $user_info as $k=>$v)
                        { 
                            
                            if( $v['total_guarantee_money'] < $v['guarantee_from_ceiling'] )
                            { 
                                $data[$k]['customer_id'] = $customer_id;
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
                                
                                //XX担保人余额已经超出上限
                                $return['message'] = $v['member_name'].'担保余额已经超出上限';
                                $return['status'] = 6;
                                $return['customer_id'] = $v['customer_id'];
                                
                                echo json_encode($return);
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
                                $return['message'] = '申请成功';
                                $return['status'] = 1;
                                
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
                            
                            //超出担保数额
                            $return['message'] = '超出担保数额';
                            $return['status'] = 2;
                        }
                    }else{
                         
                        //请选择正确用户
                        $return['message'] = '请选择正确用户';
                        $return['status'] = 3;
                    }
                    
                }else{ 
                    
                    //您上一笔的担保尚未结束，无法继续申请。
                    $return['message'] = '您上一笔的担保尚未结束，无法继续申请';
                    $return['status'] = 4;
                }
                
            }else{ 
                
                //部落未生效或您不是该部落成员
                $return['message'] = '部落未生效或您不是该部落成员';
                $return['status'] = 5;
            }
        }
        
        echo json_encode($return);
    }
}
