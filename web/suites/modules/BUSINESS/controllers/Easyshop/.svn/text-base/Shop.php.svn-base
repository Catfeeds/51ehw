<?php
if (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );
    
/**
 * 简易店
 */
class Shop extends Front_Controller {
        
        public function __construct() {
            
            parent::__construct();
            if( !$this->session->userdata('user_id'))
            {
               show_404();exit;
               
            }
            $this->load->model('Easyshop_mdl');
        }
        
        
        /**
         * 创建简易店
         */
        public  function ajax_CreateShop(){
            
            $user_id = $this->session->userdata("user_id");
            
            //调用接口处理->验证实名认证
            $url = $this->url_prefix.'Customer/load';
            $data_post['customer_id'] = $user_id;
            $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
            
            if(empty($customer["idcard"])){
                $return = array(
                    "status" => "02",
                    "msg" => "你还未实名认证",
                    "shop_id" => 0,
                );
                echo json_encode($return);exit;
            }
          
            $shop = $this->Easyshop_mdl->Load($user_id);
            if($shop){
                $return = array(
                    "status" => "01",
                    "msg" => "简易店已存在",
                    "shop_id" => $shop['id'],
                );
                echo json_encode($return);exit;
            }
           
            $data =array(
               'customer_id'=>$user_id,
               'real_name' => $customer['real_name'],
             );
          
            $shop_id = $this->Easyshop_mdl->Create($data);
            if(!$shop_id){
               $return = array(
                   "status" => "04",
                   "msg" => "创建简易店失败",
                   "shop_id" => 0,
               );
               echo json_encode($return);exit;
             }
            $return = array(
               "status" => "00",
               "msg" => "创建简易店成功",
               "shop_id" => $shop_id,
             );    
            $this->session->set_userdata("Easyshop_id",$shop_id);
            
            echo json_encode($return);
        }
        
        
        /**
         * 检查是否创建了简易店
         */
        public function check_Shop(){
            $user_id = $this->session->userdata("user_id");
            
            //调用接口处理->验证实名认证
            $url = $this->url_prefix.'Customer/load';
            $data_post['customer_id'] = $user_id;
            $customer = json_decode($this->curl_post_result( $url,$data_post ),true);
            
            if(empty($customer["idcard"])){
                $return = array(
                    "status" => "02",
                    "msg" => "你还未实名认证",
                    "shop_id" => 0,
                );
                echo json_encode($return);exit;
            }
            $return = array(
                "status" => "00",
                "msg" => "未创建简易店",
                "shop_id" => 0,
            );
            
            $shop = $this->Easyshop_mdl->Load($user_id);
            if($shop){
                $return = array(
                    "status" => "01",
                    "msg" => "已创建简易店",
                    "shop_id" => $shop['id'],
                );
            }
            echo json_encode($return);exit;
        }
        
}