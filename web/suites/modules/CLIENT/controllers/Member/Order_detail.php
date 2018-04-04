<?php
/**
 * 用户中心 > 订单 > 订单详情
 *
 *
 */
class Order_detail extends Front_Controller {
	function __construct() {
		parent::__construct ();
		
		if (! $this->session->userdata ( 'user_in' )) {
			redirect ( 'login' );
			exit ();
		}
		
		$this->load->helper ( 'order' );
	}
	function index() {
		// 判断是否有订单，否则跳转订单中心
		$segments = $this->uri->uri_to_assoc ();
		
		if (! empty ( $segments ['index'] )) {
			$order_id = ( int ) $segments ['index'];
			$this->load->model ( 'order_mdl' );
			$order = $this->order_mdl->load ( $order_id );
			if (empty ( $order )) {
				redirect ( 'customer/order' );
				exit ();
			}
		} else {
			redirect ( 'customer/order' );
			exit ();
		}
		
		$data ['css'] [0] = "<link type='text/css' rel='stylesheet' href='" . base_url () . "css/orderdetail.css'>";
		
		$data ['title'] = '订单详情';
        $data['back'] = 'member/order';
		
		$data ['order'] = $order;
		
		// 送货地址
		$this->load->model ( 'order_delivery_mdl' );
		$data ['delivery'] = $this->order_delivery_mdl->load ( $order_id );
		
		// 顾客
		$this->load->model ( 'customer_mdl' );
		$data ['customer'] = $this->customer_mdl->load ( $this->session->userdata ( 'user_id' ) );
		
		// 支付方式
		$this->load->model ( 'payment_mdl' );
		$data ['payment'] = $this->payment_mdl->load ( $order ['payment_id'] );
		
		// 购物清单
		$this->load->model ( 'order_item_mdl' );
		$data ['order_items'] = $this->order_item_mdl->find_order_items ( $order_id );
		
		/* 取得支付信息，生成支付代码 */
		$this->load->model ( 'payment_mdl' );
		$payment = $this->payment_mdl->load ( $order ['payment_id'] );
		$this->load->library ( 'payment/' . $payment ['code'] );
		$data ['pay_online'] = $this->$payment ['code']->get_code ( $order, unserialize_config ( $payment ['pay_config'] ) );
		$data['head_set'] = 3;
        $data['foot_set'] = 1;
		$this->load->view ( 'head', $data );
		$this->load->view ( '_header', $data );
		$this->load->view ( 'customer/order_detail', $data );
		$this->load->view ( '_footer', $data );
		$this->load->view ( 'foot', $data );
	}
}