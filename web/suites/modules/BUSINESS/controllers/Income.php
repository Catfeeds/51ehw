<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 收益。
 * @author fxm
 *
 */
class Income extends Front_Controller {
	

    public $customer_id;
    
	public function __construct()
	{
	   parent::__construct();
	   $this->session->set_userdata('ref_from_url', current_url());
	   
	   // 判断用户是否登录
	   if (! $this->session->userdata('user_in') )
	   {
	       redirect('customer/login');
	       exit();
	   }
	   
	   $this->customer_id  = $this->session->userdata("user_id");
	}

   /**
    * 我的收益主页。
    * @date:2017年11月10日 上午11:10:21
    * @author: fxm
    */
    public function index()
    { 
        //查询当前身份。
        $this->load->model('customer_rebate_identity_mdl');
        $identity_info = $this->customer_rebate_identity_mdl->Load_Customer_Identity( $this->customer_id );
        
        if( !$identity_info )
        { 
            $identity_info['identity_name'] = '普通会员';
            $identity_info['level'] = 0;
        }
        $data['identity_info'] = $identity_info;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '我的收益';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('income/index', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 展示可升级身份列表。
     * @date:2017年11月10日 上午11:10:14
     * @author: fxm
     */
    public function Identity()
    { 
        $level = $this->input->get('level');
        
        if( 0 == $level )
        {
            $level = 0;
        }
        
        $this->load->model('customer_rebate_identity_mdl');
        $data['identity_list'] = $this->customer_rebate_identity_mdl->Load_Identity();
        $identity_info = $this->customer_rebate_identity_mdl->Load_Customer_Identity( $this->customer_id );
        
        if( !$identity_info )
        { 
            $identity_info['level'] = 0;
            $identity_info['identity_id'] = 0;
        }
        $data['identity_info'] = $identity_info;
        $data['my_level'] = $level;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '身份升级';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('income/identity', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 带给我分成企业的详细报表。
     * @date:2017年11月10日 下午3:16:53
     * @author: fxm
     */
    public function Detail_List( $customer_id = 0 )
    { 
        //查询当前身份。
        $this->load->model('customer_rebate_identity_mdl');
        
        $identity_info = $this->customer_rebate_identity_mdl->Load_Customer_Identity( $this->customer_id );
        $identity_info = $identity_info ? $identity_info : array('identity_name'=>'普通会员','level'=>0);
        
        if( !empty( $identity_info['rebaterate_description'] ) )
        { 
            $identity_info['rebaterate_description'] = json_decode($identity_info['rebaterate_description'],true);
           
        }else{
            
            $rebaterate_description[0]['name'] = '会员费收入';
            $rebaterate_description[0]['rebaterate'] = '-';
            $rebaterate_description[1]['name'] = '手续费收入';
            $rebaterate_description[1]['rebaterate'] = '-';
            $rebaterate_description[2]['name'] = '加盟费收入';
            $rebaterate_description[2]['rebaterate'] = '-';
            $rebaterate_description[3]['name'] = '担保/服务';
            $rebaterate_description[3]['rebaterate'] = '-';
            $identity_info['rebaterate_description'] = $rebaterate_description;
        }
        //统计这个用户给我带来的收益总额。
        $this->load->model('Order_rebate_mdl');
        $rebate_total = $this->Order_rebate_mdl->Obj_Income_List( $this->customer_id,$customer_id,0,0,'total');
        
        
        //查询该用户的企业信息。
        $this->load->model('Corporation_mdl');
        $data['total_rebate'] = $rebate_total['total_rebate'];
        $data['corp_info'] = $this->Corporation_mdl->load_corporation_info( $customer_id );
        $data['identity_info'] = $identity_info;
        $data['obj_id'] = $customer_id;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '企业订单查询';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('income/detail_list', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 申请升级身份页面。
     * @date:2017年11月10日 下午3:25:24
     * @author: fxm
     */
    public function Apply( $identity = 0 )
    { 
        //需要申请的身份。
        if ( !$identity || !is_numeric( $identity ) || !strpos( $identity,'.') == false )
        {
            //判断是否整数。
            echo '<script>history.back(-1);alert("参数错误");</script>';
            exit();
            
        }
        
        //查询申请的身份。
        $this->load->model('customer_rebate_identity_mdl');
        $apply_identity_info = $this->customer_rebate_identity_mdl->Identity_Info( $identity, $this->customer_id );
       
        if( !$apply_identity_info )
        { 
            //判断是存在。
            echo '<script>history.back(-1);alert("申请的身份不存在");</script>';
            exit();
        }
        
        //查询当前身份。
        $identity_info = $this->customer_rebate_identity_mdl->Load_Customer_Identity( $this->customer_id );
        $identity_info = $identity_info ? $identity_info : array('identity_name'=>'普通会员','level'=>0);
        
        if( $identity_info['level'] >= $apply_identity_info['level'] )
        { 
            //判断是存在。
            echo '<script>history.back(-1);alert("申请的身份必须大于当前身份");</script>';
            exit();
        }
        
        $data['is_apply'] = $apply_identity_info['is_apply'];
        $data['apply_identity_info'] = $apply_identity_info;
        $data['identity_info'] = $identity_info;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '申请升级';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('income/apply', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 某一笔分成的交易详细。
     * @date:2017年11月10日 下午3:25:24
     * @author: fxm
     */
    public function Order_Detail( $order_sn = 0 )
    {
        $this->load->model('order_rebate_mdl');
        $data['order_info'] = $this->order_rebate_mdl->Order( $order_sn );
        
        if( !$data['order_info'] )
        { 
            echo '<script>history.back(-1);alert("订单不存在");</script>';
            exit();
        }
            
        $data['rebate_list'] = $rebate_list = $this->order_rebate_mdl->Order_Rebate_Role( $order_sn );
        $data['rebate_total'] = isset( $data['rebate_list'][0]['total_price'] ) ? $data['rebate_list'][0]['total_price']  : 0;
        $data['head_set'] = 2;
        $data['foot_set'] = 1;
        $data['title'] = '订单详情';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('income/order_detail', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot');
    }
    
    /**
     * 加载收入信息（group by 同一企业,sum 金额 的列表 ）。
     * @date:2017年11月10日 下午3:35:35
     * @author: fxm
     * @param: session $this->customer_id 当前登录的用户ID。
     * @param: $page = 页数。
     * @return: json.
     */
    public function My_Income()
    { 
        $page = $this->input->post("page");//页数
        $corporation_name = $this->input->post('corporation_name');
        if( 0 == $page )
        {
            $page = 1;
        }
        
        $limit = 10;//每页显示的数量
        
        $offset = ($page-1) * $limit;//偏移量
         
        
        $this->load->model('Order_rebate_mdl');
        $list = $this->Order_rebate_mdl->My_Income( $this->customer_id,$limit, $offset,$corporation_name );
        
        $return['status'] = 1;
        $return['data']['list'] = $list;
        
        echo json_encode($return);
    }
    
     /**
     * 我的收益-查询某一个用户给我带来的收益列表。
     * @date:2017年11月10日 下午3:35:35
     * @author: fxm
     * @param: session $this->customer_id 当前登录的用户ID。
     * @param: post(obj_id) = 某个对象（用户ID）。
     * @param: $page = 页数。
     * @return: json.
     */
    public function My_Income_Detail()
    { 
        $obj_id = $this->input->post('obj_id');
        $page = $this->input->post("page");//页数
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $order_sn = $this->input->post('order_sn');
        
        if( 0 == $page )
        {
            $page = 1;
        }
        
        $limit = 10;//每页显示的数量
        
        $offset = ($page-1) * $limit;//偏移量
        
        $this->load->model('Order_rebate_mdl');
        
        $list = $this->Order_rebate_mdl->Obj_Income_List( $this->customer_id,$obj_id,$limit, $offset,null,$order_sn,$start_time,$end_time);
//         echo $this->db->last_query();
        $return['status'] = 1;
        $return['data']['list'] = $list;
        
        echo json_encode($return);
        
    }
    
    
    
    
    /**
     * 用户申请升级身份。
     * @date:2017年11月13日 下午5:34:16
     * @author: fxm
     * @param: $identity_id 升级身份的ID
     * @return: json
     */
    public function Apply_Upgrade_Identity( $identity_id = 0 )
    { 
        do{ 
            //需要申请的身份。
            if ( !$identity_id || !is_numeric( $identity_id ) || !strpos( $identity_id,'.') == false )
            {
                //判断是否整数。
                $return = array('status'=>255,'message' => '参数错误');
                break;
            }
            
            //查询申请的身份。
            $this->load->model('customer_rebate_identity_mdl');
            $apply_identity_info = $this->customer_rebate_identity_mdl->Identity_Info( $identity_id,$this->customer_id  );
            
            if( !$apply_identity_info )
            {
                //判断是存在。
                $return = array('status'=>2,'message' => '身份不存在');
                break;
            }else if ( $apply_identity_info['is_apply'] )
            { 
                $return = array('status'=>4,'message' => '你已经成功申请，无需重复提交');
                break;
            }
            
            //查询当前身份。
            $identity_info = $this->customer_rebate_identity_mdl->Load_Customer_Identity( $this->customer_id );
            $identity_info = $identity_info ? $identity_info : array('identity_name'=>'普通会员','level'=>0);
        
            if( $identity_info['level'] >= $apply_identity_info['level'] )
            {
                //申请的身份必须大于
                $return = array('status'=>3,'message' => '申请的身份必须大于当前身份');
                break;
            }
            
            $add_data['customer_id'] = $this->customer_id;
            $add_data['identity_id'] = $identity_id;//要申请的身份ID
            $add_data['identity_name'] = $apply_identity_info['identity_name'];//要申请的身份名称
            
            if( isset($identity_info['identity_id']) )
            {
                $add_data['current_identity_id'] = $identity_info['identity_id'];//当前身份ID
            }
            
            $add_data['current_identity_name'] = $identity_info['identity_name'];//当前身份名称
            $add_data['app_id'] = $this->session->userdata('app_info')['id'];
            $add_data['app_name'] = $this->session->userdata('app_info')['app_name'];
            $ari_id = $this->customer_rebate_identity_mdl->Create_Apply_Rebate_Identity( $add_data );
            
            if( !$ari_id )
            { 
                $return = array('status'=>0,'message' => '申请失败');
                break;
            }
            
            $return = array('status'=>1,'message' => '申请成功');
            
        }while(0);
        
        echo json_encode($return);
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
