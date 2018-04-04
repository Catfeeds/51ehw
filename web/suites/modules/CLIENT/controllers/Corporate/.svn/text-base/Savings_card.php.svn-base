<?php 

if (! defined ( 'BASEPATH' ) )  exit ( 'No direct script access allowed' );
/**
 * 线上储值卡控制器
 *
 * @author Fxm
 * @copyright Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license http://www.9-leaf.com/
 * @link http://www.9-leaf.com/
 * @since Version 1.0
 * @filesource
 *
 */
    
class Savings_card extends Front_Controller
{ 
    
        function __construct()
        { 
            parent::__construct ();
    		// 判断用户是否登录
    		if (! $this->session->userdata ( 'user_in' ) ) {
    			redirect ( 'customer/login' );
    			exit ();
    		}
    		
    		$this->customer_id = $this->session->userdata ( 'user_id' );
        }
 
   
    /**
     * 购买方主页。
     */
    public function My_List()
    { 

        //分页参数
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        $this->load->library('pagination');
        if (0 == $current_page)
        {
            $current_page = 1;
        }
        
        $config['per_page'] = 10;//每页显示几条。
        $offset = ($current_page - 1) * $config['per_page'];
        
        $this->load->model('Savings_card_mdl');
        $sift['where']['customer_id'] = $this->customer_id;
        
        //统计总条数。
        $sift['return_rows'] = true;
        $config['total_rows'] = $this->Savings_card_mdl->Load_Card_Buy( $sift );
        
        //查询列表。
        $sift['page']['limit'] = $config['per_page'];
        $sift['page']['offset'] = $offset;
        $sift['return_rows'] = false;
        
        $list = $this->Savings_card_mdl->Load_Card_Buy( $sift );
        
        $this->load->helper('time');
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $config['base_url'] = site_url('Corporate/Savings_card/My_List?');
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
    
        $data['list'] = $list;
        $data ['head_set'] = 4;
        $data['title'] = '使用授权管理';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/Personal_information', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 购买方发起授权使用页面
     */
    public function My_Card_Authorize_View( $id = 0 )
    {
        $sift['where']['customer_id'] = $this->customer_id;
        $sift['where']['id'] = $id;
        $sift['where']['parent_id'] = 0;
        
    
        $this->load->model('Savings_card_mdl');
        $detaile = $this->Savings_card_mdl->Card_Buy_Detaile( $sift );
        
//                 echo $this->db->last_query();
        if( !$detaile )
        {
            echo "<script>
                  alert('储值卡不存在');history.back(-1);
                </script>";
            exit();
        }
        $detaile['card_remaining'] = $detaile['remaining_card_amount'];
        $data['status'] = 1;
        $data['detaile'] = $detaile;
        $data ['head_set'] = 4;
        $data['title'] = '使用授权管理';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/management', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 查看我授权给二级的页面。
     */
    public function My_Authorize_View( $id )
    {
        $this->load->model('Savings_card_mdl');
        $sift['where']['customer_id'] = $this->customer_id;
        $sift['where']['id'] = $id;
        $sift['where']['parent_id'] = 0;
        
        $detaile = $this->Savings_card_mdl->Card_Buy_Detaile( $sift );
        
        if( $detaile )
        {
            //分页参数
            $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
            $this->load->library('pagination');
            
            if (0 == $current_page)
            {
                $current_page = 1;
            }
            
            $config['per_page'] = 5;//每页显示几条。
            $offset = ($current_page - 1) * $config['per_page'];
            
            //统计总条数和一些数据。
            $sift_b['return_rows'] = true;
            $sift_b['where']['parent_id'] = $id;
            $count = $this->Savings_card_mdl->Load_Card_Buy_Authorize( $sift_b );
           
            //已授权额度。
            $detaile['authorize_amount'] = $count['authorize_amount'];
            //总条数。
            $config['total_rows'] = $count['total_rows'];
            
            //查询授权二级记录列表。
            
            $sift_b['return_rows'] = false;
            $sift_b['page']['limit'] = $config['per_page'];
            $sift_b['page']['offset'] = $offset;
            $list = $this->Savings_card_mdl->Load_Card_Buy_Authorize( $sift_b );
            
            //分页
            $config['curr_page'] = $current_page;
            $config['use_page_numbers'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
            $config['next_link'] = '下一页';
            $config['next_tag_css'] = 'class="lPage"';
            $config['prev_link'] = '上一页';
            $config['prev_tag_css'] = 'class="lPage"';
            $config['first_link'] = '<<';
            $config['last_link'] = '>>';
            $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
            $config['cur_tag_close'] = '</a>';
            $config['base_url'] = site_url('Corporate/Savings_card/My_Authorize_View/'.$id.'?');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            $data['total_rows'] = $config['total_rows'];
          
            
        }else{ 
           
            echo "<script>
                  alert('参数错误无法访问');history.back(-1);
                </script>";
            exit();
        }
        
        $data['detaile'] = $detaile;
        $data['list'] = $list;
        $data['head_set'] = 4;
        $data['title'] = '使用授权管理';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/use_authorization', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 购买方使用授权给其他人。
     */
    public function My_Authorize_Card()
    { 

        $return['status'] = false;
        $return['message'] = '添加失败';
        
        
        $id = $this->input->post('buy_id');
        $start_time = $this->input->post('start_time');//开始时间。
        $end_time = $this->input->post('end_time');//结束时间。
        $card_amount = $this->input->post('card_amount');//授权金额。
        $customer_id = $this->input->post('customer_id');//被授权的用户ID。
        
        if( $customer_id == $this->customer_id )
        {
            $return['message'] = '不能授权给自己';
            echo json_encode( $return );
            exit();
        }
        //1.查询卡信息是否与传过来的信息匹配。
        $sift['where']['customer_id'] = $this->customer_id;
        $sift['where']['id'] = $id;
        $sift['where']['parent_id'] = 0;
        
    
        $this->load->model('Savings_card_mdl');
        $detaile = $this->Savings_card_mdl->Card_Buy_Detaile( $sift );
        
        if( $detaile )
        {
            //判断时间范围。
            if(  ( $start_time >= $detaile['start_time'] && $start_time <= $detaile['end_time'] ) && ( $end_time <= $detaile['end_time'] && $end_time >= $detaile['start_time'] ) )
            {
                //判断金额。
                if( $card_amount <= $detaile['remaining_card_amount'] )
                {
                    
                    $add_data['savings_card_sales_id'] = $detaile['savings_card_sales_id'];
                    $add_data['customer_id'] = $customer_id;
                    $add_data['card_amount'] = $card_amount;
                    $add_data['start_time'] = $start_time;
                    $add_data['end_time'] = $end_time;
                    $add_data['parent_id'] = $detaile['id'];
                    $add_data['level'] = 2;
                    //添加记录。
                    $id = $this->Savings_card_mdl->Create_Card_Buy( $add_data );
        
                    
                    if( !empty( $id ) )
                    {
                        //写卡日志。
                        $log_data['card_amount'] = $card_amount;
                        $log_data['type'] = 1;//收入
                        $log_data['obj_id'] = $id;
                        $log_data['remarks'] = '获得'.$detaile['card_name'].'二级使用授权';
                        $log_data['event'] = 2;//授权事件。
                        $log_data['customer_id'] = $customer_id;
                         
                        //添加消费日志。
                        $log_id = $this->Savings_card_mdl->Create_Card_Log($log_data);
                        
                        $return['status'] = 1;
                        $return['message'] = '授权成功';
                    }
        
                }else{
        
                    $return['status'] = 2;//超出时间范围。
                    $return['message'] = '余额不足';
                }
        
            }else{
        
                $return['status'] = 3;//超出时间范围。
                $return['message'] = '有效期不在储值卡期限内,请选择正确的日期';
            }
        
        }else{
        
            $return['status'] = 4;//卡不存在。
            $return['message'] = '该储蓄卡不存在或未通过审核';
        }
        
        echo json_encode( $return );
        
    }
    /**
     * 销售商主页。
     */   
    public function Sales_List()
    { 
        //分页参数
       
        if( ! $this->session->userdata ('corporation_id') )
        { 
             echo "<script>
                   alert('您还不是商家，无法进入该页面');history.back(-1);
                   </script>";
            exit();
        }
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        $this->load->library('pagination');
        if (0 == $current_page) 
        {
            $current_page = 1;
        }
        
        $config['per_page'] = 10;//每页显示几条。
        $offset = ($current_page - 1) * $config['per_page'];
        
        $this->load->model('Savings_card_mdl');
        $sift['where']['customer_id'] = $this->customer_id;
        
        //统计总条数。
        $sift['return_rows'] = true;
        $config['total_rows'] = $this->Savings_card_mdl->Load_Card_Sales( $sift );
        
        //查询列表。
        $sift['page']['limit'] = $config['per_page'];
        $sift['page']['offset'] = $offset;
        $sift['return_rows'] = false;
        
        $list = $this->Savings_card_mdl->Load_Card_Sales( $sift );
       
       
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $config['base_url'] = site_url('Corporate/Savings_card/Sales_List?');
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['total_rows'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        $data['curr_page'] = $config['curr_page'];
        
        $data ['head_set'] = 4;
        $data['list'] = $list;
        $data['title'] = '线上储值卡';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/list', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 销售授权详细页面。
     */
    public function Sales_Authorization( $id = 0,$status = '' )
    { 
        if( !$status )
        {
            $sift['where']['customer_id'] = $this->customer_id;
            
        }else{ 
            
            $corporation_id = $this->session->userdata ('corporation_id');
            
            if( !$corporation_id )
            {
                echo "<script>
                  alert('您还不是商家，无法进入该页面');history.back(-1);
                </script>";
                exit();
            }
            
            //承兑商进行查看。
            $sift['where']['corporation_id'] = $corporation_id;
        }
       
        
        $sift['where']['id'] = $id;
        
        $this->load->model('Savings_card_mdl');
        $list = array();
        
        $detaile = $this->Savings_card_mdl->Card_Sales_Detaile( $sift );
        $data['pagination'] = '';
        
        if( $detaile )
        { 
            $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
            $this->load->library('pagination');
            
            if (0 == $current_page)
            {
                $current_page = 1;
            }
            
            $config['per_page'] = 5;//每页显示几条。
            $offset = ($current_page - 1) * $config['per_page'];
            
            $sift_b['where']['savings_card_sales_id'] = $id;
            //统计总条数。
            $sift_b['return_rows'] = true;
            $config['total_rows'] = $this->Savings_card_mdl->Load_Card_Buy_Corp( $sift_b );
           
            //查询列表
            $sift_b['return_rows'] = false;
            $sift_b['page']['limit'] = $config['per_page'];
            $sift_b['page']['offset'] = $offset;
            $list = $this->Savings_card_mdl->Load_Card_Buy_Corp( $sift_b );
            
            $config['curr_page'] = $current_page;
            $config['use_page_numbers'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
            $config['next_link'] = '下一页';
            $config['next_tag_css'] = 'class="lPage"';
            $config['prev_link'] = '上一页';
            $config['prev_tag_css'] = 'class="lPage"';
            $config['first_link'] = '<<';
            $config['last_link'] = '>>';
            $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
            $config['cur_tag_close'] = '</a>';
            $config['base_url'] = site_url('Corporate/Savings_card/Sales_Authorization/'.$id.'/'.$status.'?');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();

        }
        
        $data['list'] = $list;
        $data['head_set'] = 4;
        $data['status'] = $status;
        $data['detaile'] = $detaile;
        $data['title'] = !$status ? '销售授权管理' : '承兑商查看销售商';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/grant_authorization', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 发起销售授权页面 
     */
    public function Sales_Card_View( $id = 0 )
    { 
        $sift['where']['customer_id'] = $this->customer_id;
        $sift['where']['id'] = $id;
//         $sift['where']['status'] = 1;
        
        $this->load->model('Savings_card_mdl');
        $detaile = $this->Savings_card_mdl->Card_Sales_Detaile( $sift );
//         echo $this->db->last_query();
        if( !$detaile )
        { 
            echo "<script>
                  alert('储值卡不存在。');history.back(-1);
                </script>";
            exit();
        }else if( $detaile['status'] != 1 )
        { 
            echo "<script>
                  alert('储值卡未通过审核，无法销售授权。');history.back(-1);
                </script>";
            exit();
        }
        $data['status'] = 0;
        $data['detaile'] = $detaile;
        $data ['head_set'] = 4;
        $data['title'] = '销售授权管理';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/management', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 添加储值卡授权记录.
     */
    public function Sales_Add_Card()
    { 
        $return['status'] = false;
        $return['message'] = '添加失败';
        
        $card_id = $this->input->post('card_id');//主卡ID。
        $start_time = $this->input->post('start_time');//开始时间。
        $end_time = $this->input->post('end_time');//结束时间。
        $card_amount = $this->input->post('card_amount');//授权金额。
        $customer_id = $this->input->post('customer_id');//被授权的用户ID。
        
        if( $customer_id == $this->customer_id )
        { 
            $return['message'] = '不能授权给自己';
            echo json_encode( $return );
            exit();
        }
        //1.查询卡信息是否与传过来的信息匹配。
        $sift['where']['customer_id'] = $this->customer_id;
        $sift['where']['id'] = $card_id;
        $sift['where']['status'] = 1;
        
        $this->load->model('Savings_card_mdl');
        $card_detaile = $this->Savings_card_mdl->Card_Sales_Detaile( $sift );
        
        if( $card_detaile )
        {
            //判断时间范围。
            if(  ( $start_time >= $card_detaile['start_time'] && $start_time <= $card_detaile['end_time'] ) && ( $end_time <= $card_detaile['end_time'] && $end_time >= $card_detaile['start_time'] ) )
            { 
                //判断金额。
                if( $card_amount <= $card_detaile['card_remaining'] )
                {
                    $this->db->trans_begin(); //事物执行方法中的MODEL。
                    //更新卡余额。
                    $row = $this->Savings_card_mdl->Update_Card_Remaining( $card_amount, $card_detaile['id'] );
                    
                    if( $row )
                    {
                        $add_data['savings_card_sales_id'] = $card_detaile['id'];
                        $add_data['customer_id'] = $customer_id;
                        $add_data['card_amount'] = $card_amount;
                        $add_data['start_time'] = $start_time;
                        $add_data['end_time'] = $end_time;
                        
                        //添加记录。
                        $id = $this->Savings_card_mdl->Create_Card_Buy( $add_data );
                        
                        if( $id )
                        { 
                            //写卡日志。
                            $log_data['card_amount'] = $card_amount;
                            $log_data['type'] = 1;//收入
                            $log_data['obj_id'] = $id;
                            $log_data['remarks'] = '获得'.$card_detaile['card_name'].'一级使用授权';
                            $log_data['event'] = 2;//授权事件。
                            $log_data['customer_id'] = $customer_id;
                             
                            //添加消费日志。
                            $log_id = $this->Savings_card_mdl->Create_Card_Log($log_data);
                        }
                        
                    }
                    
                    if( empty( $log_id ) )
                    {
                        $this->db->trans_rollback();
                        
                    }else{ 
                        
                        $return['status'] = 1;
                        $return['message'] = '授权成功';
                        
                        $this->db->trans_commit();
                    }
                    
                }else{ 
                    
                    $return['status'] = 2;//超出时间范围。
                    $return['message'] = '余额不足';
                }
                
            }else{ 
                
                $return['status'] = 3;//超出时间范围。
                $return['message'] = '有效期不在储值卡期限内,请选择正确的日期';
            }
                
        }else{ 
            
            $return['status'] = 4;//卡不存在。
            $return['message'] = '该储蓄卡不存在或未通过审核';
        }
        
        echo json_encode( $return );
    }
    
    
    
    /**
     * 承兑方主页
     */
    public function Convert_List( $status = 0 )
    { 
        
        $corporation_id = $this->session->userdata ('corporation_id');
        
        if( !$corporation_id )
        { 
            echo "<script>
                  alert('您还不是商家，无法进入该页面');history.back(-1);
                </script>";
            exit();
        }

        if( !in_array( $status, array('0','1','2','3') ) )
        { 
            $status = 0;
        }
        
        if( $status != 0 )
        {
            $sift['where']['status'] = $status - 1;
        }
        
        //分页参数
        $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
        $this->load->library('pagination');
        if (0 == $current_page)
        {
            $current_page = 1;
        }
        
        $config['per_page'] = 10;//每页显示几条。
        $offset = ($current_page - 1) * $config['per_page'];
        
        $this->load->model('Savings_card_mdl');
        $sift['where']['corporation_id'] = $corporation_id;
        
        //统计总条数。
        $sift['return_rows'] = true;
        $config['total_rows'] = $this->Savings_card_mdl->Load_Card_Sales_Corp( $sift );
        
        //查询列表。
        $sift['page']['limit'] = $config['per_page'];
        $sift['page']['offset'] = $offset;
        $sift['return_rows'] = false;
        
        $list = $this->Savings_card_mdl->Load_Card_Sales_Corp( $sift );
        
        $config['curr_page'] = $current_page;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
        $config['next_link'] = '下一页';
        $config['next_tag_css'] = 'class="lPage"';
        $config['prev_link'] = '上一页';
        $config['prev_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
        $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
        $config['cur_tag_close'] = '</a>';
        $config['base_url'] = site_url('Corporate/Savings_card/Convert_List/'.$status.'?');
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
//         $data['total_rows'] = $config['total_rows'];
//         $data['per_page'] = $config['per_page'];
//         $data['curr_page'] = $config['curr_page'];
        $data['list'] = $list;
        $data['status'] = $status;
        $data ['head_set'] = 4;
        $data['title'] = '线上储值卡';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/on_line', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 承兑方审核储值卡页面。
     */
    public function Convert_Apply_View( $id = 0 )
    { 

        $corporation_id = $this->session->userdata ('corporation_id');
        
        if( !$corporation_id )
        {
            echo "<script>
                  alert('您还不是商家，无法进入该页面');history.back(-1);
                </script>";
            exit();
        }
        
        $sift['where']['corporation_id'] = $corporation_id;
        $sift['where']['id'] = $id;
//         $sift['where']['status'] = 0;
        
        $this->load->model('Savings_card_mdl');
        $detaile = $this->Savings_card_mdl->Card_Sales_Detaile_Corp( $sift );
        
         
        if( !$detaile )
        {
            echo "<script>
                  alert('储值卡不存在。');history.back(-1);
                </script>";
            exit();
        }else if( $detaile['status'] == 2 )
        {
            echo "<script>
                  alert('储值卡已被拒绝，无法重新审核');history.back(-1);
                </script>";
            exit();
            
        }else if( $detaile['status'] == 1){ 
            
            echo "<script>
                  alert('储值卡已经是审核成功状态。');history.back(-1);
                </script>";
            exit();
        }
        
        $detaile['images'] =  $detaile['images'] ? explode(',', trim( $detaile['images'],',' ) ) : '';
       
        $data['detaile'] = $detaile;
        
        
        $data ['head_set'] = 4;
        $data['title'] = '储值卡申请审核';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/to_examine', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    /**
     * 承兑方审核储值卡。
     */
    public function Convert_Apply_Card()
    { 
        
        $corporation_id = $this->session->userdata ('corporation_id');
        $id = $this->input->get('id');
        $status = $this->input->get('status');
        
        $return['status'] = false;
        $return['message'] = '审核失败';
        
        if( $corporation_id && $id )
        {
            //条件是未审核过才可以。
            $sift['where']['status'] = 0;
            $sift['where']['corporation_id'] = $corporation_id;
            $sift['where']['id'] = $id;
            
            $sift['set']['status'] = $status == 1 ? 1 : 2;
            
            $this->load->model('Savings_card_mdl');
            $detaile = $this->Savings_card_mdl->Card_Sales_Detaile( $sift );
            
            if( $detaile )
            {
                $row = $this->Savings_card_mdl->Update_Card_Sales( $sift );
                
                if( $row )
                { 
                    $log_data['card_amount'] = $detaile['card_amount'];
                    $log_data['type'] = 1;//收入
                    $log_data['obj_id'] = $detaile['id'];
                    $log_data['remarks'] = '获得'.$detaile['card_name'].'销售授权';
                    $log_data['event'] = 3;//销售权事件。
                    $log_data['customer_id'] = $detaile['customer_id'];
                     
                    //添加日志。
                    $this->Savings_card_mdl->Create_Card_Log($log_data);
                        
                    $return['status'] = true;
                    $return['message'] = '操作成功';
                    
                }
            }
        }
        
        echo json_encode($return);
    }
    
    
    /**
     * 购买方卡消费明细。
     * 购买方-$status = 0 一级查看授权给二级某张卡的消费记录。
     * 购买方-$status = 1 查看属于属于自己的或者被授权的卡。
     */
    public function Card_Consume_List( $id = 0 ,$status = 0)
    { 

        if( !$status )
        {
            $sift['where']['customer_id'] = $this->customer_id;
        }else{ 
            $sift['where']['scb_a.customer_id'] = $this->customer_id;
        }
        
        $sift['where']['id'] = $id;
        
        $this->load->model('Savings_card_mdl');
        $detaile = $this->Savings_card_mdl->Card_Buy_All_Detaile( $sift );
//         echo $this->db->last_query();exit;
        if( $detaile )
        { 
            $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
            $this->load->library('pagination');
            
            if (0 == $current_page)
            {
                $current_page = 1;
            }
            
            $config['per_page'] = 10;//每页显示几条。
            $offset = ($current_page - 1) * $config['per_page'];
            
            //如果是一级。
            if( $detaile['level'] == 1 )
            {
                $sift_b['where']['savings_card_buy_praent_id'] = $detaile['id'];
                
            }else{ 
                
                //二级。
                $sift_b['where']['savings_card_buy_id'] = $detaile['id'];
            }
            //统计总条数。
            $sift_b['return_rows'] = true;
            $config['total_rows'] = $this->Savings_card_mdl->Load_Card_Consumption( $sift_b );
            
            //查询列表。
            $sift_b['page']['limit'] = $config['per_page'];
            $sift_b['page']['offset'] = $offset;
            $sift_b['return_rows'] = false;
            $list = $this->Savings_card_mdl->Load_Card_Consumption( $sift_b );
           
            $config['curr_page'] = $current_page;
            $config['use_page_numbers'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
            $config['next_link'] = '下一页';
            $config['next_tag_css'] = 'class="lPage"';
            $config['prev_link'] = '上一页';
            $config['prev_tag_css'] = 'class="lPage"';
            $config['first_link'] = '<<';
            $config['last_link'] = '>>';
            $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
            $config['cur_tag_close'] = '</a>';
            $config['base_url'] = site_url('Corporate/Savings_card/Card_Consume_List/'.$id.'?');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
            
            
        }else{ 
            
            echo "<script>
                  alert('储值卡不存在。');history.back(-1);
                </script>";
            exit();
        }
        
        $data['list'] = $list;
        $data['detaile'] = $detaile;
        $data ['head_set'] = 4;
        $data['title'] = '使用详情';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/use_details', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    

    /**
     * 销售方卡消费明细 $status = 0。
     * 承兑方卡消费明细 $status = 1。
     * $id = 9thleaf_savings_card_buy表ID。
     */
    public function Card_Consume_Detaile( $id = 0 ,$status = 0 )
    {
    
        if( !$status )
        {
             $sift['where']['scs.customer_id'] = $this->customer_id;
            
        }else{ 
            $corporation_id = $this->session->userdata ('corporation_id');
            
            if( !$corporation_id )
            { 
                echo "<script>
                  alert('您不是商家无法访问。');history.back(-1);
                </script>";
                exit();
                
            }
            $sift['where']['corporation_id'] = $corporation_id;
            
        }
        
        $sift['where']['id'] = $id;
    
        $this->load->model('Savings_card_mdl');
        $detaile = $this->Savings_card_mdl->Card_Buy_All_Detaile( $sift );
//         echo $this->db->last_query();
        if( $detaile )
        {
            $current_page = ($this->input->get_post('per_page', true)); // 获取当前分页页码数
            $this->load->library('pagination');
    
            if (0 == $current_page)
            {
                $current_page = 1;
            }
    
            $config['per_page'] = 10;//每页显示几条。
            $offset = ($current_page - 1) * $config['per_page'];
    
            $sift_b['where']['savings_card_buy_praent_id'] = $detaile['id'];
    
           
            //统计总条数。
            $sift_b['return_rows'] = true;
            $config['total_rows'] = $this->Savings_card_mdl->Load_Card_Consumption( $sift_b );
           
            //查询列表。
            $sift_b['page']['limit'] = $config['per_page'];
            $sift_b['page']['offset'] = $offset;
            $sift_b['return_rows'] = false;
            $list = $this->Savings_card_mdl->Load_Card_Consumption( $sift_b );
    
            $config['curr_page'] = $current_page;
            $config['use_page_numbers'] = TRUE;
            $config['page_query_string'] = TRUE;
            $config['num_links'] = 3; // 可以看到当前页后面的3页a连接
            $config['next_link'] = '下一页';
            $config['next_tag_css'] = 'class="lPage"';
            $config['prev_link'] = '上一页';
            $config['prev_tag_css'] = 'class="lPage"';
            $config['first_link'] = '<<';
            $config['last_link'] = '>>';
            $config['cur_tag_open'] = '&nbsp;<a class="cpage">';
            $config['cur_tag_close'] = '</a>';
            $config['base_url'] = site_url('Corporate/Savings_card/Card_Consume_Detaile/'.$id.'/'.$status.'?');
            $this->pagination->initialize($config);
            $data['pagination'] = $this->pagination->create_links();
    
    
        }else{
    
            echo "<script>
                  alert('储值卡不存在。');history.back(-1);
                </script>";
            exit();
        }
    
        $data['status'] = $status;
        $data['list'] = $list;
        $data['detaile'] = $detaile;
        $data ['head_set'] = 4;
        $data['title'] = '使用详情';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/use_details_s', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
    
    /**
     * 销售商申请储值卡页面。
     */
    public function Apply_View()
    { 
        
        $data ['head_set'] = 4;
        $data['title'] = '申请储值卡';
        $this->load->view ( 'head', $data );
        $this->load->view ( '_header', $data );
        $this->load->view ( 'corporate/stored_value_card/apply', $data );
        $this->load->view ( '_footer', $data );
        $this->load->view ( 'foot', $data );
    }
    
   
    /**
     * 添加储值卡申请。
     */
    public function Add_Apply_Card()
    { 
        
        $card_name = $this->input->post('card_name');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $card_amount =  $this->input->post('card_amount');
        $corp_id = $this->input->post('corporation_id');
        $add_img = $this->input->post('add_img');
        $return['status'] = false;
        $return['message'] = "申请失败";
        
       
        $add_data['card_name'] = $card_name;
        $add_data['start_time'] = $start_time;
        $add_data['end_time'] = $end_time;
        $add_data['card_amount'] = $card_amount;
        $add_data['corporation_id'] = $corp_id;
        $add_data['customer_id'] = $this->customer_id;
        
        if( $_FILES )
        { 
            //需要上传的图片，图片名+大小。
            $img_add = explode(',', trim( $add_img,',' ) );
            
            //保存数据的路径。
            $save_path = "uploads/savings_card/";
            
            //上传的全路径。
            $path = FCPATH.UPLOAD_PATH. $save_path;
            
            //上传图片，返回字符串。
            $add_data['images'] = $this->Upload( $save_path, $path, $img_add );
            
        }
        
        $this->load->model('Savings_card_mdl');
        $id = $this->Savings_card_mdl->Create_Card_Sales( $add_data );
        
        if( $id )
        { 
            $return['status'] = true;
            $return['message'] = "提交成功，请等待承兑方审核";
            
            $this->load->model('Customer_corporation_mdl');
            $my_info = $this->Customer_corporation_mdl->load($this->customer_id);
            $convert_info = $this->Customer_corporation_mdl->coro_customer_info($corp_id);
            
            if( $my_info && $convert_info )
            {
                $content = "“{$convert_info['corporation_name']}”负责人您好，“{$my_info['corporation_name']}.”向您申请了线上储值卡“{$card_name}”，请登录51易货网进行审核。如有问题，请联系客服，客服电话：400-0029-777";
                $this->sendShortmMsg($convert_info['mobile'], $content);
            }
        }
       
        echo json_encode($return);
       
    }
    
    
    
    
    /**
     * 根据手机号码查询用户信息。
     */
    public function Mobile_Customer_Info( $mobile = 0 )
    {
        $this->load->model('Customer_mdl');
        $customer_info = $this->Customer_mdl->load_by_mobile( $mobile );
    
        if( $customer_info )
        {
            $info['id'] = $customer_info['id'];
            $info['mobile'] = $customer_info['mobile'];
            $info['name'] = $customer_info['name'];
            $info['nick_name'] = $customer_info['nick_name'];
        }
    
        $return['data'] = !empty( $info ) ? $info : FALSE;
    
        $return['status'] = !empty( $info ) && $this->customer_id == $info['id']? 2 : 1;
        echo json_encode( $return );
    }
   
    /**
     * @author :fxm
     * 用途：
     *    配合H5的上传图片，前端做图片名称处理，把需要上传的图片名称保存成一个组数，
     *    和$_FILES里做匹配，匹配成功才上传，因为前端删除图片的时候，无法操作file节点
     *    所以只能匹配对比的方式。
     * @save_path : 保存数据的路径。
     * @add_img: 需要上传图片的数组。
     * @$path : 全路径。
     
     */
    
    private function Upload( $save_path = '', $path = '', $img_add = array() )
    { 
       
           
        $images = '';
    
        if( !empty( $_FILES['file'] )  && $img_add )
        {
            // 图片 初始化数据
    
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
    
                            $images .= $save_path.$img['file_name'].',';
                        }
                        unset($img_add[$img_key]);
                    }
                }
    
            }
    
        }
    
        return $images;
    
    }
        
    
    
    /**
     * 发送短信提示操作
     * @param unknown $mobile
     * @param unknown $content
     */
    private  function sendShortmMsg($mobile, $content)
    {
        $this->load->library('Short_Message_Factory', '', 'message');
        $this->load->model("shortmsg_log_mdl");
        // 读取默认短信提供商
        $this->load->model("sms_supplier_mdl");
        $supplier = $this->sms_supplier_mdl->get_in_use();
        $sms = $this->message->get_message($supplier);
        $id = $this->shortmsg_log_mdl->create(array(
            'mobile' => $mobile,
            'content' => $content
        ));
        $msgs = $sms->send($mobile, $content);
        
        $msg = explode("&", $msgs);
        $type = $msg[0];
        $status = $msg[1];
        $return_msg = $msg[2];
        $log = array(
            'id' => $id,
            'msg_type' => $type,
            'status' => $status,
            'return_msg' => $return_msg
        );
        $this->shortmsg_log_mdl->update($log);
    }
}

?>