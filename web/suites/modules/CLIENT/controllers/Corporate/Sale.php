<?php 
if (! defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * 店铺管理控制器
 *
 * 查看会员列表
 *
 * @author Clark So
 * @copyright Copyright © 2009-2016 NINTH·LEAF , All Rights Teserved.
 * @license http://www.9-leaf.com/
 * @link http://www.9-leaf.com/
 * @since Version 1.0
 * @filesource
 *
 */
class Sale extends Front_Controller
{

    // --------------------------------------------------------------------

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('ref_from_url',current_url () );
        // 判断用户是否登录
        if (! $this->session->userdata('user_in')) {
            redirect('customer/login');
            exit();
        }else{ 
            $account_id = $this->session->userdata('user_id');
            //判断是否微信浏览器
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
                $this->load->model("customer_mdl");
                $customer = $this->customer_mdl->load($account_id);
                // 如果没有写手机
                if (empty($customer['mobile'] ) ) {
                    $data['title'] = '绑定手机';
                    $data['head_set'] = 3;
                    $data['foot_set'] = 1;
                    $this->load->view ( 'head',$data);
                    $this->load->view ( '_header',$data);
                    $this->load->view('binding/binding_mobile',$data);
                    $this->load->view ( '_footer',$data);
                    $this->load->view ( 'foot',$data);
                    return ;
                }
            }
        }
        
        
        $this->load->model('customer_mdl');
    }

    // --------------------------------------------------------------------
    //绑定二维码页面
    public function shop_sale(){
        $options = array();
        $options["type"] = 'sale';
//         $options['conditions'] = array(
//             "p.app_id" => $this->session->userdata('app_info')['id'],
//         );
        $this->load->model('product_mdl');
        $data['product_list'] = $this->product_mdl->find_products($options,false);
        
        $data['title'] = "实体消费";
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/shop_sale',$data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
        
    }
    //后台二维化显示页面
    public function shop_sale_code(){
        $options["type"] = 'sale';
        $options['conditions'] = array(
//             "p.app_id" => $this->session->userdata('app_info')['id'],
            "p.is_mc" => '1'
        );
        $options['row'] = true;
        $this->load->model('product_mdl');
        $data['product_list'] = $this->product_mdl->find_products($options,false);
        $data['title'] = "实体消费二维码";
        $this->load->view('head', $data);
        $this->load->view('_header', $data);
        $this->load->view('corporate/shop/shop_sale_code',$data);
        $this->load->view('_footer', $data);
        $this->load->view('foot', $data);
    
    }
    
    //扫描后转跳到支付页面
   public function pay_view($product_id= 0, $corp_id= 0){ 
        
      
       if(empty($product_id) && empty($corp_id) ){ 
           exit;
       }
      
       //判断该店铺是否存在
       $this->load->model('corporation_mdl');
       $corp_message = $this->corporation_mdl->load_id($corp_id);
       if( !$corp_message )
           exit;
       
       $options["type"] = 'sale';
       $options['customer_id'] = $corp_message['customer_id'];
       $options['corporation_id'] = $corp_id;
       $options['conditions'] = array(
//            "p.app_id" => $this->session->userdata('app_info')['id'],
           "p.is_mc" => '1',
           "p.id" => $product_id
       );
      
       $options['row'] = true;
       $this->load->model('product_mdl');
       $data['product_list'] = $this->product_mdl->find_products($options,false);
      
//        if(!$data['product_list']) //判断店铺是否有二维码商品
//            exit;
       
       $data['title'] = $corp_message['corporation_name'];
       $data['head_set'] = 3;
       $data['product_id'] = $product_id;
       $data['corp_id'] = $corp_id;
       $this->load->view('head', $data);
       $this->load->view('_header',$data);
       $this->load->view('customer/code_pay');
//        $this->load->view('_footer', $data);
       $this->load->view('foot', $data);
   }
   
   
   
   /**
    * 进行扫码支付并且生成订单
    */
   public function code_pay(){ 
       $error_message = array();
       $corp_id     =  $this->input->post('corp_id'); //传过来的店铺ID
       $product_id  =  $this->input->post('product_id'); //穿过来的商品id
       $customer_id = $this->session->userdata ( 'user_id' ); //购买人登录id
       $price       = $this->input->post('price'); //支付金额
       $pay_passwd  = md5( $this->input->post('passwd') ); //支付密码
       
       //判断该店铺是否存在
       $this->load->model('corporation_mdl');
       $corp_message = $this->corporation_mdl->load_id($corp_id);
       
       if( !$corp_message ){
           $error_message['status'] = 1;
           $error_message['messgae'] = '店铺不存在';
           echo json_encode($error_message);
           exit;
       }
      
       //判断店铺是否有二维码
       $options["type"] = 'sale';
       $options['customer_id'] = $corp_message['customer_id'];
       $options['corporation_id'] = $corp_id;
       $options['conditions'] = array(
//            "p.app_id" => $this->session->userdata('app_info')['id'],
           "p.is_mc" => '1',
           "p.id" => $product_id
       );
       
       $options['row'] = true;
       $this->load->model('product_mdl');
       $product = $this->product_mdl->find_products($options,false);
        
       if(!$product){
           $error_message['status'] = 2; //商品不存在
           
           echo json_encode($error_message);
           exit;
       }
        
       //验证支付信息
       $this->load->model ( 'pay_account_mdl' );
       
       //支付账号
       $customer_pay  = $this->pay_account_mdl->load( $customer_id );
       
       if( empty( $customer_pay['pay_passwd']) ){
           $error_message['status'] = 3; //您还未设置支付密码
           echo json_encode($error_message);
           exit;
       }
       
       if( $customer_pay['pay_passwd'] !== $pay_passwd){ 
           $error_message['status'] = 4; //支付密码错误
           echo json_encode($error_message);
           exit;
       }
       
       $credit = '0.00'; //授信
       $time = date('Y-m-d H:i:s');
       if($customer_pay['credit_start_time'] <= $time && $customer_pay['credit_end_time'] >= $time){
           $credit = $customer_pay['credit'];
       }
       
       if( ($customer_pay["M_credit"]+$credit) < $price){ 
           $error_message['status'] = 5; //余额不足
           echo json_encode($error_message);
           exit;
       }
       
       $this->load->model("customer_currency_log_mdl",'customer_currency_log');
       
       //获取该店主信息
       $this->load->model('customer_corporation_mdl');
       $corp_customer = $this->customer_corporation_mdl->corp_load($corp_id);
       $corp_customer_id = $corp_customer['customer_id'];//店主的用户ID
       
       //支付方
       $pay_account_id = $customer_pay['id'];//支付账号ID
       $pay_relation_id = $customer_pay['r_id']; //关联表的ID
       $surplus_m = $customer_pay['M_credit']; //支付前的货豆余额
       
       
       //收入方
       $corp_customer_pay = $this->pay_account_mdl->load( $corp_customer_id );
       $corp_pay_id = $corp_customer_pay['id']; //店主支付账号ID
       $corp_pay_relation_id = $corp_customer_pay['r_id']; //店主关联支付账号表的ID
       $corp_surplus_m = $corp_customer_pay['M_credit'];//剩余的货豆
      
       $this->db->trans_begin(); //事物执行SQL
      
       /* 插入新订单信息 */
       $this->load->helper ( 'order' );
       $this->load->model ( 'order_mdl' );
       $this->order_mdl->customer_id = $customer_id;
       $this->order_mdl->payment_id = 5; //扫码支付
       $this->order_mdl->shipping_id = 0; // $shipping_id;
       $this->order_mdl->total_product_price = $price;
       $this->order_mdl->total_price = $price;
       $this->order_mdl->corporation_id = $corp_id;
       $this->order_mdl->status = 14; //订单完成不能评价
        
        
       $order_exist = false;
       do {
           $order_sn = get_order_sn ();
           if ($this->order_mdl->check_order_sn ( $order_sn )) {
               $order_exist = true;
           } else {
               $this->order_mdl->order_sn = $order_sn;
               $new_order_id = $this->order_mdl->create ();
           }
       } while ( $order_exist ); // 如果是订单号重复则重新提交数据
        
       /* 插入消费表 */
       $this->load->model ( 'order_item_mdl' );
       $this->order_item_mdl->order_id = $new_order_id;
       $this->order_item_mdl->product_id = $product_id;
       $this->order_item_mdl->product_name = $product['name'];
       $this->order_item_mdl->quantity = 1;
       $this->order_item_mdl->price = $price;
       $this->order_item_mdl->sku_id = 0;
       $this->order_item_mdl->weight = 0; // $items['options']['weight'];
       $res = $this->order_item_mdl->create ();

       //上一次货豆交易的日志中的信息
       $last_m_log    = $this->customer_currency_log->load_last($pay_relation_id);
       
       //扣钱
       $row = $this->pay_account_mdl->update_M_creadit($pay_account_id, $price);
       
       //店主账号+货豆
       $up_row = $this->pay_account_mdl->charge_M_credit($corp_pay_id, $price );
       
       //检测支付方货豆是否异常
       if( isset($last_m_log['ending_balance']) &&  $last_m_log['ending_balance'] == $surplus_m){
           $M_credit_data['status'] = '1';
       }else if(!$last_m_log && $surplus_m =='0'){
           $M_credit_data['status'] = '1';
       }else{
           $M_credit_data['status'] = '2';
       }
       
       
       //货豆日志
       $M_credit_data['relation_id'] = $pay_relation_id;
       $M_credit_data['id_event'] = '60';
       $M_credit_data['remark'] = '面对面-购物支出';
       $M_credit_data['amount'] = $price;
       $M_credit_data['order_no'] = $order_sn;
       $M_credit_data['type'] = '2';
       $M_credit_data['beginning_balance'] = $surplus_m;
       $M_credit_data['ending_balance'] = $surplus_m-$price;
       $M_credit_data['customer_id'] = $corp_customer_id;
       $M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
       
       //上一次店主货豆交易的日志中的信息
       $corp_last_m_log = $this->customer_currency_log->load_last($corp_pay_relation_id);
       
       //收入检测货豆是否异常
       if( isset($corp_last_m_log['ending_balance']) &&  $corp_last_m_log['ending_balance'] == $corp_surplus_m){
           $M_credit_data['status'] = '1';
       }else if(!$corp_last_m_log && $corp_last_m_log =='0'){
           $M_credit_data['status'] = '1';
       }else{
           $M_credit_data['status'] = '2';
       }
       
  	        //店主收入货豆日志
       $M_credit_data['relation_id'] = $corp_pay_relation_id;
       $M_credit_data['id_event'] = '62';
       $M_credit_data['remark'] = '面对面-销售收入';
       $M_credit_data['type'] = '1';
       $M_credit_data['amount'] = $price;
       $M_credit_data['order_no'] = $order_sn;
       $M_credit_data['beginning_balance'] = $corp_surplus_m;
       $M_credit_data['ending_balance'] = $corp_surplus_m+$price;
       $M_credit_data['customer_id'] = $customer_id;
     
       //收入出方货豆日志
       $to_M_credit_log = $this->customer_currency_log->add_log($M_credit_data);
       
       if(!$new_order_id || !$res || !$row || !$up_row || !$M_credit_log || !$to_M_credit_log){ 
           $this->db->trans_rollback();
           $error_message['status'] = 6; //交易失败
           echo json_encode($error_message);
           exit;
           
       }
       
       if ($this->db->trans_status() === FALSE) {
           $this->db->trans_rollback();
           $error_message['status'] = 6; //交易失败
           
       } else {
           $this->db->trans_commit();
           $error_message['status'] = 7; //交易成功
          
       }
       echo json_encode($error_message);
   }
   
   
   
    //将商品设置为二维码支付
   public function related_product(){ 
       $product_id = $this->input->post('product_id');
       
       //判断店铺是否有二维码商品
       $options["type"] = 'sale';
       $options['customer_id'] =  $this->session->userdata ( 'user_id' ); //登录id
       $options['corporation_id'] = $corporation_id = $this->session->userdata['corporation_id'];//店铺id
       $options['conditions'] = array(
//            "p.app_id" => $this->session->userdata('app_info')['id'],
           "p.is_mc" => '1',
       );
       $options['row'] = true;
       $this->load->model('product_mdl');
       $product = $this->product_mdl->find_products($options,false);
       
       //判断传过来的商品是否店主的
       $options['conditions'] = array(
//            "p.app_id" => $this->session->userdata('app_info')['id'],
           "p.id" => $product_id,
       );
       $row_product = $this->product_mdl->find_products($options,false);
       
       $this->db->trans_begin(); //事物执行SQL
       
       //如果没有设置过则 //事物开始
       if( !$product  ){  //如果没有设置过
           
           if($row_product){ //如果确定是该店家的商品则
               $row_new = $this->product_mdl->update_is_mc( $product_id, 1);//将传过来的商品设置成二维码商品
               
               if(!$row_new)
                   $massage_status = 0; //失败
           }
           
       }else{ //如果有设置过 则将之前的更改成不是二维码商品 

           if($row_product){
               $row_used = $this->product_mdl->update_is_mc( $product['id'], '0');//修改原来的
               $row_new  = $this->product_mdl->update_is_mc( $product_id, 1);//修改现在传过来的
               
               if( !$row_new || !$row_used){ 
                   $this->db->trans_rollback();
                   $massage_status = 0; //失败
               }
           }
       }
       
       if ($this->db->trans_status() === FALSE) {
           $this->db->trans_rollback();
           $massage_status = 0; //失败
       } else {
           $this->db->trans_commit();
           $massage_status = 1; //成功
       }
      //事物结束
      
       echo json_encode($massage_status);
   }
}