<?php

if (! defined('BASEPATH'))
    exit('No direct script access allowed');

class Preferential extends External_Api_Controller
{

    var $account_key;
    var $mem;
    
    // ------------------------------------------------------------
    /**
    */ 
    public function __construct()
    {
        parent::__construct();
        
        //连接memcache
        $this->mem = parent::tel_memcached();
        $this->load->model('Card_package_mdl');
        header("Content-type: application/json");
    }

    // -----------------------------------------------------------

    /**
     * 查询我的优惠券
     */
    public function load()
    { 
        //验证是否登录
        $this->account_key = $this->input->post('key');
        $status = is_numeric( $this->input->post('status') ) ? $this->input->post('status') : 4 ;
        
        $cache_result = $this->is_login();
        $customer_id = $cache_result['user_id'];
        $result = $this->Card_package_mdl->package( $customer_id,$status,null );
        $return['data'] = $result;
        $return['status'] = 0;
        $return['message'] = '获取成功';
        $return['img_path_prefix'] = 'http://images.51ehw.com/C/';
        echo json_encode($return);
        
    }
    
    
    /**
     * 查询某个店铺（外部接口）中存在的优惠券
     */
    public function preferential_list()
    { 
        $app_key = $this->input->post('app_key');
        $corp_id = $this->input->post('corporation_id');
        if( $app_key == $this->api_key )
        {
            if( is_numeric( $corp_id ) )
            {
                $result = $this->Card_package_mdl->get_package(null,2,null,null,null, $corp_id);
                
                $return['data'] = $result;
                $return['status'] = 0;
                $return['message'] = '获取成功';
                $return['img_path_prefix'] = 'http://images.51ehw.com/C/';
            }else{ 
                $return['status'] = '-1';
                $return['message'] = '无法识别商家';
            }
            
        }else{ 
            
            $return['status'] = '-254';
            $return['message'] = '验证商户失败';
            
        }
        
        echo json_encode($return);
    }
    
    /**
     * 优惠券详情
     */
    public function preferential_detail()
    { 
        $preferential_id = $this->input->post('card_id');
        
        if( is_numeric( $preferential_id ) )
        { 
            $preferential_info = $this->Card_package_mdl->get_card_package( $preferential_id );
            
            $return['status'] = 0;
            $return['message'] = '获取成功';
            $return['img_path_prefix'] = 'http://images.51ehw.com/C/';
            $return['data'] = $preferential_info;
        }else{ 
            $return['status'] = '-253';
            $return['message'] = '缺少参数';
        }
        
        echo json_encode( $return );
    }
    
    /**
     * 商家（接口）赠送给用户优惠券
     */
    public function preferential_give()
    { 
       
        $app_key = $this->input->post('app_key');
        $customer_id = $this->input->post('customer_id');
        
        $preferential_id = $this->input->post('card_id');
        
        if( $app_key == $this->api_key )
        {
            if( is_numeric( $preferential_id ) && is_numeric( $customer_id) )
            {
                $preferential_info = $this->Card_package_mdl->get_card_package( $preferential_id, 3 );
                
                if( !empty($preferential_info)  )
                {
                    $row = $this->Card_package_mdl->receive($preferential_id,$customer_id);
                    
                    if( !$row )
                    {
                        if( $preferential_info["grant_start_at"] > date("Y-m-d") )
                        { 
                           $return['status'] = '-2';
                           $return['message'] = '领取时间未开始';
                           
                        }else if ( $preferential_info["grant_end_at"] < date("Y-m-d") )
                        { 
                           $return['status'] = '-3';
                           $return['message'] = '发放时间已结束'; 
                           
                        }else{
                            //验证优惠券成功--进入领取阶段 
                            $row = $this->Card_package_mdl->subduction($preferential_id,1);//扣除卡包数量
                            if( $row )
                            { 
                                //领取卡包
                                $data[0]['p_id'] = $preferential_info['id'];
                                $data[0]['sender_id'] = $preferential_info['customer_id'];
                                $data[0]['customer_id'] = $customer_id;
                                $data[0]['created_at'] = date("Y-m-d H:i:s");
                                $data[0]['status'] = 2;
                                $detail_row = $this->Card_package_mdl->aad_package($data);//领取
                                
                                if( $detail_row )
                                { 
                                    $return['status'] = 0;
                                    $return['message'] = '领取成功';
                                    $return['data']['number'] = $preferential_info['number']-1;
                                    
                                }else{ 
                                    
                                    $return['status'] = '-5';
                                    $return['message'] = '领取失败';
                                }
                                
                            }else{ 
                                $return['status'] = '-4';
                                $return['message'] = '优惠券数量不足';
                            }
                        }
                        
                    }else{ 
                        $return['status'] = '-5';
                        $return['message'] = '您已经领取过该优惠券';
                    }
                    
                }else{ 
                    
                    $return['status'] = '-1';
                    $return['message'] = '优惠券不存在';
                }
            }else{
                $return['status'] = '-253';
                $return['message'] = '缺少参数';
            }
        }else{ 
            
            $return['status'] = '-254';
            $return['message'] = '验证商户失败';
        }
        echo json_encode($return);
    }
    
    /**
     * 检测优惠券
     */
    public function check_preferential()
    { 
        $preferential_id = $this->input->post('card_id');
        
        if( 0 == $preferential_id )
        {
            $return['status'] = '-253';
            $return['message'] = '参数错误';
            
        }else{
        
            $preferential_info = $this->Card_package_mdl->get_card_package( $preferential_id );
            
           if( $preferential_info )
           {
               if( $preferential_info['number'] > 0 )
               {
                   if( $preferential_info['grant_start_at'] <= date('Y-m-d') && $preferential_info['grant_end_at'] >= date('Y-m-d') )
                   { 
                       $return['status'] = 0;
                       $return['message'] = '优惠券有效';
                       
                   }else{ 
                       
                       $return['status'] = '-2';
                       $return['message'] = '优惠券不在发放时范围内';
                   }
               }else{ 
                   $return['status'] = '-3';
                   $return['message'] = '优惠券已被领完';
               }
           }else{ 
               $return['status'] = '-1';
               $return['message'] = '优惠券不存在';
           }
        }
        
        echo json_encode($return);
        
    }
    //验证是否登录
    public function is_login(){
    
        $mem = $this->mem;
    
        $account_key = $this->account_key;
    
        if(!$account_key){
            $result['status'] = '-98';
            $result['message'] = '请传递用户KEY值';
            echo json_encode($result);
            exit;
    
        }else{
    
            $val = $mem->get( $account_key );
    
            if($val){
    
                //设置
                $mem->set($account_key,$val,MEMCACHE_COMPRESSED,1800);
                return $val;
            }else{
                $result['status'] = '-99';
                $result['message'] = '请登录';
                echo json_encode($result);
                exit;
            }
        }
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */