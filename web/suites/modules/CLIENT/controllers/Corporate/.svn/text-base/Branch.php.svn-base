<?php
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 店铺分店管理控制器
 * 
 */
class Branch extends Front_Controller
{
    var $cropinfo;
    // --------------------------------------------------------------------
    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }
        $this->load->model('corporation_branch_mdl','branch');
        $corporation_id = $this->session->userdata('corporation_id');
        $cropinfo = $this->branch->load_corp_info ( $corporation_id );
      
        //验证店铺
        if($cropinfo){
            //验证是否审核通过和是否冻结
            if($cropinfo['approval_status'] != 2 || $cropinfo['status'] != 1){
                echo '<script>alert("该企业未审核通过或被冻结，详情请联系客服！");history.back(-1);</script>';
                exit();
            }
            $this->cropinfo = $cropinfo;
        }
    }
    
    /**
     * 分店列表页
     * 
     */
    public function index(){
	    $data['cropinfo'] = $this->cropinfo;
	   
	    $data['logo'] = '';
	    if(file_exists( IMAGE_URL.$data['cropinfo']['img_url'])){
	        $data['logo'] = IMAGE_URL.$data['cropinfo']['img_url'];
	    }
	    // 分页设置(网页版使用)
	    $this->load->library ( 'pagination' );
	    $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
	    if(0 == $current_page || !$current_page)
	    {
	        $current_page = 1;
	    }
	    $config ['per_page'] = 5;
	    $offset   = ($current_page - 1 ) * $config['per_page'];
	  
	    $config['base_url'] = site_url('Corporate/branch?');
	    $config ['total_rows'] = count($this->branch->get_corp_branch( $data['cropinfo']['id'] ));
	    //$config ['curr_page'] = $data ["page"]; // count_page_orders
	    $config ['num_links'] = 10;
	 
	    $config['use_page_numbers']   = TRUE;
	    $config['page_query_string']  = TRUE;
	    $config['num_links'] = 3; //可以看到当前页后面的3页a连接
	    $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
	    $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
	    $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
	    $config ['prev_tag_css'] = 'class="lPage"';
	    $config ['next_link'] = '下一页';
	    $config ['next_tag_css'] = 'class="lPage"';
	    $config['first_link'] = '<<';
	    $config['last_link'] = '>>';
	    
	    $data['total_rows'] = $config['total_rows'];
	    $data['per_page'] = $config['per_page'];
	    $data['cu_page'] = $current_page;
	    $this->pagination->initialize ( $config );
	    $data ['page'] = $this->pagination->create_links ();
       
        $data['branch'] = $this->branch->get_corp_branch( $data['cropinfo']['id'] ,$config ['per_page'],($current_page - 1) * $config ['per_page']);
        
        foreach ( $data['branch'] as $key =>$val){
            $order_info = $this->branch->branch_saleroom($val['id']);
            if($order_info['order_total_price']){
                $data['branch'][$key]['order_total_price'] = $order_info['order_total_price'];
            }else{
                $data['branch'][$key]['order_total_price']=0;
            }
        }
    
        $data['title'] = '分店管理';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/branch/branch_management', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    
    public function edit_branch($id){
        $data['cropinfo'] = $this->cropinfo;
        $corp_id = $data['cropinfo']['id'];
       
        $branch = $this->branch->get_branch_detail($id,$corp_id);
        if(!$branch){
                echo "<script>alert('您尚未加入该部落，无法查看该部落中的活动');history.back(-1);
                     </script>";
                exit;
        }
        $data['title'] = '编辑门店';
        $data['branch'] = $branch;
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/branch/edit_branch', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
        
    }
    
    /**
     * 添加分店
     */
    public function add_branch(){
        $data['title'] = '添加门店';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/branch/branch_guli', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
   
    /**
     * 异步执行
     */
    public function ajax_edit(){
        $cropinfo = $this->cropinfo;
        $this->branch->corporation_id = $cropinfo['id'];
        $this->branch->owner_id = $this->input->get_post('owner_id');
        $this->branch->address = $this->input->get_post('address');
        $this->branch->owner_name = $this->input->get_post('owner_name');
        $this->branch->branch_name = $this->input->get_post('name');
        $this->branch->id = $this->input->get_post('id');
        $id = $this->branch->edit_branch();
        if($id){
            echo json_encode(array("status"=>"success"));exit;
        }else{
            echo json_encode(array("status"=>"error"));exit;
        }
    }
    /**
     * 检查是否存在手机用户
     */
    public function  check_user(){
        $mobile = $this->input->post('mobile');//手机号码
        if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){
            echo json_encode(array("status"=>"error_mobile"));exit;//手机号码错误
        }
        $this->load->model('customer_mdl');
        //查询判断用户是否存在
        $customer = $this->customer_mdl->load_by_name($mobile);
        if($customer){
            echo json_encode(array("status"=>"success","id"=>$customer['id']));exit;//用户存在
        }else{
           echo json_encode(array("status"=>"no_user"));exit;//用户不存在
        }
    }
    
    /**
     * 分店销售报表
     */
    public function branch_report(){
        $cropinfo = $this->cropinfo;
        $data['branch_info'] = $this->branch->get_corp_branch($cropinfo['id'] );
        $option = array();
        $option['branch_id'] = $this->input->get_post("branch_id");
        $option['grant_start_at'] = $this->input->get_post("grant_start_at");
        $option['grant_end_at'] = $this->input->get_post("grant_end_at");
        
        
        // 分页设置(网页版使用)
        $this->load->library ( 'pagination' );
        $current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
        if(0 == $current_page || !$current_page)
        {
            $current_page = 1;
        }
        $config ['per_page'] = 5;
        $offset   = ($current_page - 1 ) * $config['per_page'];
        
        $option['list_type'] = '';//PC
        
        $all_info = $this->branch->get_branch_order($cropinfo['id'],$option);
        $config['base_url'] = site_url('Corporate/branch/branch_report?');
        if($option['branch_id']){
            $data['branch_id'] = $option['branch_id'];
            $config['base_url'] = site_url('Corporate/branch/branch_report?').'branch_id='.$option['branch_id'];
            if($option['grant_start_at'] && $option['grant_end_at']){
            $data['grant_start_at'] = $option['grant_start_at'];
            $data['grant_end_at'] = $option['grant_end_at'];
            $config['base_url'] = site_url('Corporate/branch/branch_report?').'branch_id='.$option['branch_id'].'&grant_start_at='.$option['grant_start_at'].'&grant_end_at='.$option['grant_end_at'];
            }
        }else{
            if($option['grant_start_at'] && $option['grant_end_at']){
                $data['grant_start_at'] = $option['grant_start_at'];
                $data['grant_end_at'] = $option['grant_end_at'];
                $config['base_url'] = site_url('Corporate/branch/branch_report?').'grant_start_at='.$option['grant_start_at'].'&grant_end_at='.$option['grant_end_at'];
            }
        }
        
        $config ['total_rows'] = count($all_info);
        //$config ['curr_page'] = $data ["page"]; // count_page_orders
        $config ['num_links'] = 10;
         
        $config['use_page_numbers']   = TRUE;
        $config['page_query_string']  = TRUE;
        $config['num_links'] = 3; //可以看到当前页后面的3页a连接
        $config['cur_tag_open'] = ' <a class="cpage">';//“当前页”链接的打开标签。
        $config['cur_tag_close'] = '</a>';//“当前页”链接的关闭标签。
        $config['prev_link'] = '上一页';//你希望在分页中显示“上一页”链接的名字。
        $config ['prev_tag_css'] = 'class="lPage"';
        $config ['next_link'] = '下一页';
        $config ['next_tag_css'] = 'class="lPage"';
        $config['first_link'] = '<<';
        $config['last_link'] = '>>';
         
        $data['total_rows'] = $config['total_rows'];
        $data['per_page'] = $config['per_page'];
        $data['cu_page'] = $current_page;
        $this->pagination->initialize ( $config );
        $data ['page'] = $this->pagination->create_links ();
        
        
        $data['order'] = $this->branch->get_branch_order( $cropinfo['id'] ,$option,$config ['per_page'],($current_page - 1) * $config ['per_page']);
        $data['sum_price'] = 0;
        foreach ($all_info as $key =>$val){
            $data['sum_price'] += $val['total_price'];
        }
        
        $data['title'] = '销售报表';
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/branch/branch_report', $data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    }
    
    public  function  excel_order(){
        $cropinfo = $this->cropinfo;
        //验证权限
        $user_id = $this->session->userdata("user_id");//识别是否店主
        if($user_id != $cropinfo['customer_id']){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        
        
        //标题
        $title = array(
//             array('商品总金额', '订单状态','买家留言','收货人姓名','收货地址','联系电话','联系手机','订单创建时间','订单付款时间','宝贝标题','宝贝总数量','店铺ID','店铺名称','订单来源','订单号')
            array('消费时间', '消费金额(货豆)','消费账号','消费昵称','消费门店')
        
        );
        //行宽
        $row_width = array(
            'A' => 40,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 40
        );
        //科学计算法转字符串的列
        $string = array('O');
        
        //居中的列
        $center = array(
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
            'E' => 0,
        );
        $this->load->library("Download_Excel");
        $Download_Excel = new Download_Excel();
        $data = $this->branch->get_branch_order($cropinfo['id']);
        
        $Download_Excel->Download($title,$data,'order.xls',$row_width,$center,$string);
        
        
        
    }
    
    
    /**
     * H5分店列表
     */
    
    public function branch_list(){
        $user_id = $this->session->userdata("user_id");
        
        $branch = $this->branch->get_user_branch($user_id);
       
//                 echo '<pre>';
//                 print_r($branch);exit;
        
        if(count($branch) == 1){  //当用户仅有一家分店直接进入分店订单
            $this->branch_order($branch[0]['id']);
          
        }else{
            $data['branch'] = $branch;
            $data['title'] = '选择分店';
            $data['head_set'] = 2;
            $data['foot_set'] = 1;
            $this->load->view('head', $data);
            $this->load->view('_header', $data);
            $this->load->view('branch/branch_list', $data);
            $this->load->view('_footer', $data);
            $this->load->view('foot', $data);
        } 
      
    }
    
   public function  branch_order($id){
       $user_id = $this->session->userdata("user_id");
       $branch_detail = $this->branch->get_user_branch($user_id,$id);
       if(!$branch_detail){
           redirect('Member/info');exit;
       }
       
       $data['branch'] = $branch_detail;
       $data['title'] = $branch_detail['branch_name'];
       $data['head_set'] = 2;
       $data['foot_set'] = 1;
       $this->load->view('head', $data);
       $this->load->view('_header', $data);
       $this->load->view('branch/order_branch', $data);
       $this->load->view('_footer', $data);
       $this->load->view('foot', $data);
   }
   
   
   /**
    * 删除分店
    */
    public function  ajax_del(){
        $branch_id = $this->input->get_post("id");
        $corporation_id =$this->session->userdata("corporation_id");
        
        $aff = $this->branch->del_branch($branch_id,$corporation_id);
        $data = array(
            "Message"=>"删除失败"
        );
        if($aff){
            $data = array(
                "Message"=>"删除成功"
            );
        }
        echo json_encode($data);
    }    
   /**
    * 异步加载订单
    */
   public function ajax_branch_order(){
       $branch_id = $this->input->get_post("branch_id");
       $type = $this->input->get_post("type");
       $start_at = $this->input->get_post("start_at");
       $end_at = $this->input->get_post("end_at");
       if($start_at){
          $option['grant_start_at'] = $start_at;
       }
       if($end_at){
           $option['grant_end_at'] = $end_at;
       }
       $user_id = $this->session->userdata("user_id");
       $branch_detail = $this->branch->get_user_branch($user_id,$branch_id);
      
       $option['type'] = $type; //全部订单 all 货豆订单 credit  储蓄卡订单 card
       $option['branch_id'] =$branch_id;
       if(!$branch_detail){
            echo json_encode(array());exit;
       }
      
       
       //无刷新加载数据
       $page = $this->input->get_post('page');
       $pagesize = 4;      
       if($page == 1){
           $page = 0;
       }else{
           $page   = ($page - 1 ) * $pagesize;
       }
       $option['list_type'] = 'load_list';//分店订单下拉加载类型
       
       $total_price = 0;
       $all_orders = $this->branch->get_branch_order(0,$option);
       foreach ($all_orders as $key =>$val){
           $total_price += $val['total_price'];
       }
       $data['total_price'] = $total_price;
       $data['List'] = $this->branch->get_branch_order(0,$option,$pagesize,$page);
//        echo '<pre>';
//        echo $this->db->last_query();
       echo json_encode($data);
   }
    
}