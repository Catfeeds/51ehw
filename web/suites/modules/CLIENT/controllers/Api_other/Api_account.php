<?php
class Api_account extends External_Api_Controller
{	
    /**
     * 
     * 修改第三方接口信息
     */
    
    // ------------------------------------------------------------
    /**
     */
     public function __construct()
     {
         parent::__construct();
         
     }
     
     
     /**
      * 修改商户（调用者）信息
      */
     public function Update_Api_Info()
     { 
         //验证值
         $app_id = $this->input->post('app_id');
         $app_key = $this->input->post('app_key');
         
         //修改值
         $customer_id = $this->input->post('customer_id');
         $corporation_id = $this->input->post('corporation_id');
         $product_id = $this->input->post('product_id');
         
         if( $app_id && $app_key && $customer_id && $corporation_id &&  $product_id )
         { 
             
             if($app_key == $this->api_key)
             { 
                 
                 $this->load->model('Api_account_mdl');
                 $this->Api_account_mdl->customer_id = $customer_id;
                 $this->Api_account_mdl->corporation_id = $corporation_id;
                 $this->Api_account_mdl->product_id = $product_id;
                 $this->Api_account_mdl->shop_number = $app_id;
                 $row = $this->Api_account_mdl->Update();
             
                 $return['status'] = '-1';
                 $return['message'] = '修改失败';
                 
                 if( $row )
                 {
                     $return['status'] = 0;
                     $return['message'] = '修改成功';
                 }
                 
             }else{ 
                 
                 $return['status'] = '-254';
                 $return['message'] = '验证商户失败';
                 
             }
             
         }else{ 
             
             $return ['status'] = '-253';
             $return ['message'] = '缺少参数';
             
         }
         
         echo json_encode($return);
     }
    
     
     /**
      * 返回商户在易货网中的账户余额情况。
      */
     public function Api_Pay_Info()
     { 
         //验证值
         $app_id = $this->input->post('app_id');
         $app_key = $this->input->post('app_key');
         
         try {
         
             if( !$app_key || !$app_key )
             {
                 throw new Exception('缺少参数','-253');
             }
                
             //查询信息。
             $this->load->model('Api_account_mdl');
              
             $this->Api_account_mdl->shop_number = $app_id;
             $this->Api_account_mdl->key = $app_key;
             $api_info = $this->Api_account_mdl->load();
             
             if( !$api_info )
             { 
                 throw new Exception('验证商户失败','-254');
             }                 
             
             $url = $this->url_prefix.'Customer/fortune/?customer_id='.$api_info['customer_id'];
             $pay_info = json_decode($this->curl_get_result($url),true);
             
             if( !$pay_info )
             { 
                 throw new Exception('获取失败','-1');
             }
             
             $return['data']['M_credit'] = $pay_info['M_credit'];
             
             $time = date('Y-m-d H:i:s');
             $credit = 0; //授信
             if($pay_info['credit_start_time'] <= $time && $pay_info['credit_end_time'] >= $time)
             {
                 $credit = $pay_info['credit'];
             }
             
             $return['data']['credit'] = $credit;
             $return['status'] = 0;
             
         } catch (Exception $e) {
             
             $return['message'] =  $e->getMessage();
             $return['status'] =  $e->getCode();
         }
         
       
         echo json_encode($return);
     }
   
}