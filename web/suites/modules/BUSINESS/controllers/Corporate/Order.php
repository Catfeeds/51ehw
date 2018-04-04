<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
/**
 * 订单管理控制器
 *
 * 查看订单列表
 *
 * @author Clark So
 * @copyright Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license http://www.9-leaf.com/
 * @link http://www.9-leaf.com/
 * @since Version 1.0
 * @filesource
 *
 */
class Order extends Front_Controller {
	
	// --------------------------------------------------------------------
	
	/**
	 * 构造函数
	 */
	public function __construct() { 
		parent::__construct ();
		// 判断用户是否登录
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'customer/login' );
			exit ();
		}
		
		if( !$this->session->userdata("corporation_id") )
		{
		    redirect('Corporation/home_page');
		    exit();
		
		}
		
		$this->load->model ( 'customer_mdl' );
		$this->load->model ( 'corporation_mdl' );
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 获取列表
	 * 带分页功能
	 */
	public function get_list( $status='' ) {
	    
	    //验证权限
	    $corp_user = $this->session->userdata("corp_user");//识别是否店主
	    $power = $this->session->userdata("power");//权限
	    if(!$corp_user && !strpos($power,"/Corporate/order/get_list,")){
	        echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
	    }
	    
		$this->load->model ( 'order_mdl' );
// 		$customerInfo = $this->session->userdata ( 'customerInfo' );
// 		$appInfo = $this->session->userdata ( 'appInfo' );
		
		$data ['sn'] = $this->input->get('sn');
		
		// $mainsection_id = $this->input->get_post ( "mainsection_id" );
		//$section_id = $this->input->get_post ( "section_id" );
		// $attr = $this->input->get_post("attr");
// 		echo $cate;
		//$data ["type"] = $type;
		
		$search = $this->input->get();
		
		$pagecondition = "";
		$app_id = 0;
// 		$customer_id = 0;
		/*if (! empty ( $section_id )) {
			$pagecondition = "?section_id=" . $section_id;
		}*/
		
		// 判断是企业会员还是个人
		$customer_id = $this->session->userdata ( 'user_id' );
		
		$corporation_id = $this->session->userdata ( 'corporation_id' );
		
		// 获取企业资料
// 		$data ['corporation'] = $this->corporation_mdl->load ( $customer_id );
		/*
		if( isset($search['or_number']) || isset($search['ep_number']) || isset($search['name']) || isset($search['phone'])){
    		$pagecondition =  "&or_number=" .$search["or_number"];
    		$pagecondition .= "&ep_number=". $search['ep_number'];
    		$pagecondition .= "&name=". $search['name'];
    		$pagecondition .= "&phone=". $search['phone'];
		}
		*/
		$url='';
		if( !empty($search) ){   
    		unset($search['/']);
    		unset($search['per_page']);
    		
    		foreach ($search as $k => $v ){ 
    		    
    		    $url .= '&'.$k.'='.$v; 
    		}
    	}
    	
		/*
		$config ['uri_segment'] = 5;
		// echo $this->uri->segment($config['uri_segment'], 0);
		if ($this->uri->segment ( $config ['uri_segment'], 0 )) {
			$data ["page"] = $this->uri->segment ( $config ['uri_segment'], 0 ) / $data ["pagesize"] + 1;
		} else {
			if ($data ["page"] == "") {
				$data ["page"] = 1;
			}
		}
		*/
		$options = array ();
		
		$data['search'] = $search;
		
		// 分页设置(网页版使用)
		$this->load->library ( 'pagination' );
		$current_page = ($this->input->get_post('per_page',true) );  //获取当前分页页码数
		if(0 == $current_page)
		{
		    $current_page = 1;
		}
		$config ['per_page'] = 5;
		$offset   = ($current_page - 1 ) * $config['per_page'];
		//$orderList = $this->order_mdl->find_corporate_order_list ( $corporation_id, $options, $status,$offset,$config['per_page'],$search);
		$orderList = $this->order_mdl->corporate_order_list ( $corporation_id, $status,$offset,$config['per_page'],$search);

// 		echo '<pre>';
// 		var_Dump($orderList);
// 		exit;
		$config ['base_url'] = site_url ( 'corporate/order/get_list/'.$status ).'?/';
		$config ['suffix'] = $url;
		$config ['total_rows'] = $this->order_mdl->count_page_orders ( $corporation_id,$status ,$search); //SQL根据订单表的id统计
	    //$config ['curr_page'] = $data ["page"]; // count_page_orders
		$config ['num_links'] = 10;
// 		$config ['full_tag_open'] = '';
// 		$config ['full_tag_close'] = '';
// 		$config ['num_tag_open'] = '';
// 		$config ['num_tag_close'] = '';
		
		
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
		
		
		
		// $config['cur_tag_css'] = 'class="current"';
		$data['total_rows'] = $config['total_rows'];
		$data['per_page'] = $config['per_page'];
		$data['cu_page'] = $current_page;
		$this->pagination->initialize ( $config );
		$data ['page'] = $this->pagination->create_links ();
		
		// print_r($data["pagination"]);
		
		// 查询产品
		// $count = $this->goods_mdl->get_count_with_condition($mainid,$condAttr);
		//$options ["order"] = $data ["order"];
		// echo $data ["pagesize"];
		// echo $data["page"];
		// exit();
		
		
		$count_order = $this->order_mdl->count_corporate_orders($corporation_id, $options); //统计我总条数
		$data ["totalcount"] = $count_order;//显示全部条数用。
		
		$data ["orderList"] = $orderList; 
		
		$data['order_state'] = $status;
		
		//$data ["totalpage"] = ceil ( $config ["total_rows"] / $data ["pagesize"] );
		
		// 查询频道
		/*if ($app_id > 0) {
		} else if ($customer_id > 0) { 
			$this->load->model ( 'section_mdl' );
			$data ['sections'] = $this->section_mdl->load_tree ( $appInfo ['id'] );
		} else {
			// @TODO: 平台列表
		}*/
		for ($i = 0; $i < 15; ++$i){
			$data['status_'.$i] = $this->order_mdl->count_corporate_orders ( $corporation_id, array('conditions' => array('o.status' => $i)) );
		}
		
		$data ['title'] = $this->session->userdata ( 'app_info' )['app_name'];
		$data ['head_set'] = 4;
		
		
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'corporate/order/list', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}

    /**
     * 订单详情 --
     */
    public function order_details($order_id ){ 
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        $corporation_id = $this->session->userdata ( 'corporation_id' );
        $this->load->model ( 'order_mdl' );
        $this->load->model ( 'order_delivery_mdl' );
        $data['details'] = $this->order_mdl->details($order_id,$corporation_id);//暂不清楚需求
        
        
        //该订单的所有商品
        if($data['details']){
            $data ['order_items'] = $this->order_mdl->find_order_items ( $order_id );
            $data ['order_delivery'] = $this->order_delivery_mdl->load ( $order_id );
            if(count($data['order_delivery']) != 0){
                $this->load->model ( 'region_mdl' );
                $data ['order_delivery'] ['province'] = $this->region_mdl->get_name ( $data ['order_delivery'] ['province_id'] );
                $data ['order_delivery'] ['city']     = $this->region_mdl->get_name ( $data ['order_delivery'] ['city_id'] );
                $data ['order_delivery'] ['district'] = $this->region_mdl->get_name ( $data ['order_delivery'] ['district_id'] );
            }
        }

        for ($i = 0; $i < 14; ++$i){
            $data['status_'.$i] = $this->order_mdl->count_corporate_orders ( $corporation_id, array('conditions' => array('o.status' => $i)) );
        }
        $count_order = $this->order_mdl->count_corporate_orders($corporation_id, array()); //统计我店铺订单总条数
        $data ["totalcount"] = $count_order;//显示全部条数用。
        $data['title'] = $this->session->userdata('app_info')['app_name'];
        $this->load->view ( 'head',$data);
        $this->load->view ( '_header' );
        $this->load->view ( 'corporate/order/order_details',$data);
        $this->load->view ( '_footer' );
        $this->load->view ( 'foot');
    }
    
    
    /**
     * 修改订单里面的某个商品单价 
     */
    public function up_product_price(){ 
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo json_encode(array("role_status"=>true));exit();
        }
        $corporation_id = $this->session->userdata ( 'corporation_id' );
        $data = $this->input->post();
        $this->load->model('order_mdl');
        //判断该订单是否未确认，并且是该店铺的 才可以改单价
        $is_order = $this->order_mdl->load($data['o_id']);
            if( ($is_order['status'] == 1 || $is_order['status'] == 2) && $is_order['corporation_id'] == $corporation_id ){
                //执行事物事件
                $row = $this->order_mdl->update_price($data,$is_order);
            }
        echo json_encode($row);
    }
    
    
    /**
     * 发货
     */
    public function update_status_dispatch(){ 
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo json_encode(array("role_status"=>false));exit;
        }
        
        $order_id = $this->input->post('id');
        $status = 4; //已付款 未发货的状态
        $up_status = 6; //修改成已发货
        $result = $this->update_status( $status, $up_status, $order_id );
        
        //消息通知
        if( !empty($result['is_ok'] ) )
        {
            $this->load->model('Customer_mdl');
            $customer_info = $this->Customer_mdl->load( $result['customer_id'] );
            
            $message_data['template_id'] = 2;//发货通知的模板Id;
            $message_data['customer_id'] = $result['customer_id'];
            $message_data['obj_id'] = $order_id;
            $message_data['type'] = 2;//订单类型;
            $message_data['parameter']['number'] = $result['order_sn'];
            $message_data['parameter']['time'] = date('Y-m-d H:i:s');
            $message_data['parameter']['name'] = !empty($customer_info['nick_name']) ? $customer_info['nick_name'] : $customer_info['name'];
            $this->load->model('Customer_message_mdl');
            $this->Customer_message_mdl->Create_Message( $message_data );
        }
        
        echo json_encode($result);
    }
    
    
    /**
     * 确认接单使用
     */
    public function update_status_receive(){
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo json_encode(array("role_status"=>false));exit;
        }
        $order_id = $this->input->post('id');
        $status = 1; //未确认
        $up_status = 2; //修改成已确认
        $result = $this->update_status( $status, $up_status, $order_id);
        
        //消息通知
        if( !empty($result['is_ok'] ) )
        {
            $this->load->model('Customer_mdl');
            $customer_info = $this->Customer_mdl->load( $result['customer_id'] );
        
            $message_data['template_id'] = 3;//通知的模板Id;
            $message_data['customer_id'] = $result['customer_id'];
            $message_data['obj_id'] = $order_id;
            $message_data['type'] = 2;//订单类型;
            $message_data['parameter']['number'] = $result['order_sn'];
            $message_data['parameter']['name'] = !empty($customer_info['nick_name']) ? $customer_info['nick_name'] : $customer_info['name'];
            $this->load->model('Customer_message_mdl');
            $this->Customer_message_mdl->Create_Message( $message_data );
        }
        
        echo json_encode($result);
    }
    
    /**
     * 商家取消订单 
     */
    public function cancel_order(){ 
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo json_encode(array("role_status"=>false));exit;
        }
        
        $order_id = $this->input->post('id');
        $corporation_id = $this->session->userdata ( 'corporation_id' );
        $status = 1; //未确认
        $up_status = 10; //修改取消订单的状态
        $this->load->model ( 'order_mdl' );
        $this->load->model('order_item_mdl','order_item');
        
        $order = $this->order_mdl->is_corp_order($order_id, $status, $corporation_id);
        $goods = $this->order_item->order_item_goods( $order_id );
        
        if( !$order ){ 
            return false;
        }
        
        //执行事务取消订单 
        $is_ok = $this->order_mdl->cancel_order( $order_id , $up_status, $goods);
        $result['is_ok'] = $is_ok;
        $result['status'] = $up_status;
        
        //$result = $this->update_status( $status, $up_status, $order_id);

        echo json_encode($result);
    }
    
    /**
     * 公共修改状态使用的控制器
     * @ $status = 需要验证的状态
     * @ $up_status = 需要更改的状态
     * @ $order_id = 订单id号
     */
    public function update_status( $status, $up_status, $order_id ){ 
        $this->load->model ( 'order_mdl' );
       
        $corporation_id = $this->session->userdata ( 'corporation_id' );
        
        //判断传过来的是否是该商家的订单ID并且是正确的状态
        $order = $this->order_mdl->is_corp_order($order_id, $status, $corporation_id);
        if(!$order)
            return false;
        
        if(!empty($order['activity_id']) ){ 
            $this->load->model('groupbuy_mdl');
            $is_ok_groupbuy_status = $this->groupbuy_mdl->is_ok_status($order['activity_id']); //如果是团购 判断是否成团可以发货
            if(!$is_ok_groupbuy_status)
                return false;
        }
        
        //修改状态
        $row = $this->order_mdl->update_order_status($order_id, $up_status);
        
        $result ['is_ok'] = $row;
        $result ['status'] = $up_status; 
        $result ['customer_id'] = $order['customer_id'];
        $result ['order_sn'] = $order['order_sn'];
        return $result;
    }
    
    /**
     * 商家修改运费使用
     * 未付款状态前才可以
     */
    public function update_order_freight(){ 
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
             echo json_encode(array("role_status"=>true));exit();
        }
        $order_id = $this->input->post('o_id');
        $corporation_id = $this->session->userdata ( 'corporation_id' );
        $freight = $this->input->post('freight');
        $this->load->model ( 'order_mdl' );
        $order = $this->order_mdl->load($order_id);
        
        if($order){
            $this->order_mdl->id = $order_id;
            $this->order_mdl->auto_freight_fee = $freight;
            $this->order_mdl->corporation_id = $corporation_id;
            $this->order_mdl->total_price = $order['total_product_price']+$freight;
            $row_freight = $this->order_mdl->update_order_freight();
            $row_total_price = $this->order_mdl->update_oreder_total_price();
        }
        if($row_freight && $row_total_price){
           echo json_encode(true);
        }else{ 
           echo json_encode(false);
        }
    }
    
    /**
     * 商家后台订单导出
     */
    public function order_excel()
    {   
        //验证权限
        $corp_user = $this->session->userdata("corp_user");//识别是否店主
        $power = $this->session->userdata("power");//权限
        if(!$corp_user && !strpos($power,"/Corporate/product/get_list,")){
            echo "<script>alert('对不起，你暂时还没有权限！');history.back(-1);</script>";exit;
        }
        
        //标题
        $title = array(
            array('商品总金额', '订单状态','买家留言','收货人姓名','收货地址','联系电话','联系手机','订单创建时间','订单付款时间','宝贝标题','宝贝总数量','店铺ID','店铺名称','订单来源','订单号')
        
        );
        //行宽
        $row_width = array(
            'A' => 15,
            'B' => 15,
            'C' => 40,
            'D' => 10,
            'E' => 50,
            'F' => 20,
            'G' => 20,
            'H' => 30,
            'I' => 30,
            'J' => 80,
            'K' => 10,
            'M' => 30,
            'O' => 30
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
            'F' => 0,
            'G' => 0,
            'H' => 0,
            'I' => 0,
            'J' => 0,
            'K' => 0,
            'L' => 0,
            'M' => 0,
            'O' => 0
        
        );
        $corporation_id = $this->session->userdata ( 'corporation_id' );
        $this->load->library("Download_Excel");
        $Download_Excel = new Download_Excel();
        $this->load->model('order_mdl');
        $data = $this->order_mdl->order_info_excel( $corporation_id );
        
        $Download_Excel->Download($title,$data,'order.xls',$row_width,$center,$string);
        
        
    }
   
}