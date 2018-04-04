<?php
/**
 * 用户中心 > 订单
 *
 *
 */
class Order extends Controller
{

	public $customer_id ;

	function __construct()
    {
        parent::Controller();

		if (!$this->session->userdata('user_in')){          		
			redirect('login');
			exit();
		}

		$this->customer_id = $this->session->userdata('user_id');

		$this->load->helper('order'); 
    }
    
	// --------------------------------------------------------------------

    /**
	 * 订单界面
	 *
	 *
	 */	
	function index()
	{       
	   $data['css'][0] = "<link type='text/css' rel='stylesheet' href='".base_url()."css/order3mouth.css'>";
  
	   $data['title'] = '订单中心';
        
	   //计算查询条件
		$options = array('status'=>null);
        
		$this->load->model('order_mdl');
	    $data['total'] = $this->order_mdl->count_orders($this->customer_id,$options); 		

	    //分页配置
		$this->config->set_item('enable_query_strings',FALSE) ;
        $config = $this->config->item('pagination');
		$config['uri_segment'] = '5';
		$config['total_rows'] = $data['total'];
		$config['per_page'] = '5';	
		$config['base_url'] = site_url('customer/order/index/page') . '/';

		//生成分页
        $this->load->library('pagination');
		$this->pagination->initialize($config); 
		$data['pagination'] = $this->pagination->create_links();
        
		$page = $this->uri->segment(5);
		if (!empty($page) && (int)$page>0){
			$page_offset = (int)$page;
        } else {
            $page_offset = 0;
        }      
       $data['orders'] = $this->order_mdl->find_customer_orders($this->customer_id, $options, $config['per_page'],$page_offset);

	   //订单商品 ，收货人
	   $this->load->model('order_item_mdl');	   
       $this->load->model('order_delivery_mdl');
	   $this->load->model('image_mdl');	

	   foreach ($data['orders'] as $key => $order):

           //商品图
           $data['orders'][$key]['items'] = $this->order_item_mdl->find_order_items($order['id'],4);
		   foreach ($data['orders'][$key]['items'] as $key1 => $item):
			   $data['orders'][$key]['items'][$key1]['image'] = $this->image_mdl->find_product_base_image($item['product_id']);
				if (empty($data['orders'][$key]['image'])){//如果没有建立主图，就从相册中取
					$product_images = $this->image_mdl->find_product_images($item['product_id']);
					if (!empty($product_images)){
						$data['orders'][$key]['items'][$key1]['image'] = $product_images[0];
					}else{
						$data['orders'][$key]['items'][$key1]['image'] = array('image_name'=>'','file'=>'','file_ext'=>'');
					}
				}
			endforeach;

		   //收货人
	       $data['orders'][$key]['delivery'] = $this->order_delivery_mdl->load($order['id']);

		   /* 取得支付信息，生成支付代码 */
		   $this->load->model('payment_mdl');
		   $payment = $this->payment_mdl->load($order['payment_id']);		
		   $this->load->library('payment/'.$payment['code']);
		   $data['orders'][$key]['pay_online'] = $this->$payment['code']->get_code($order, unserialize_config($payment['pay_config']));

	   endforeach;

	   //等待付款订单数
	   $data['wait_pay'] = $this->order_mdl->count_wait_pay_orders($this->customer_id,array(
            1,
            2
        ));

	   //未完成订单数
	   $data['unfinish'] = $this->order_mdl->count_unfinish_orders($this->customer_id);

	   //已完成订单数
	   $data['finished'] = $this->order_mdl->count_finished_orders($this->customer_id);

	   //已取消订单数
	   $data['cancel'] = $this->order_mdl->count_cancel_orders($this->customer_id);

       $data['head_set'] = 3;
       $data['foot_set'] = 1;
	   $this->load->view ( 'head', $data );
	   $this->load->view ( '_header', $data );
       $this->load->view('customer/order',$data);
	   $this->load->view ( '_footer', $data );
	   $this->load->view ( 'foot', $data );
	}


}