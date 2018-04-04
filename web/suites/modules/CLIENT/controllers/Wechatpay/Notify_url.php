<?php
/**
 * 通用通知接口demo
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 * 
 * 这里举例使用log文件形式记录回调信息。
 */
class Notify_url extends Front_Controller {
	public function __construct() {
		parent::__construct ();
		// 判断用户是否登录
		/*
		 * if (! $this->session->userdata ( 'user_in' )) {
		 * redirect ( 'customer/login' );
		 * exit ();
		 * }
		 *
		 * $this->load->helper ( 'order' );
		 */
	}
	public function get_feedback() {
	    // include_once ("log_.php");
		include_once ("WxPayPubHelper/WxPayPubHelper.php");
		
		// 使用通用通知接口
		$notify = new Notify_pub ();
		
		// 存储微信的回调
		$xml = $GLOBALS ['HTTP_RAW_POST_DATA'];
		if(empty($xml))
		    $xml = file_get_contents("php://input");
		
		$notify->saveData ( $xml );
		
		// 验证签名，并回应微信。
		// 对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		// 微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		// 尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if ($notify->checkSign () == FALSE) {
			$notify->setReturnParameter ( "return_code", "FAIL" ); // 返回状态码
			$notify->setReturnParameter ( "return_msg", "签名失败" ); // 返回信息
		} else {
			$notify->setReturnParameter ( "return_code", "SUCCESS" ); // 设置返回码
		}
		$returnXml = $notify->returnXml ();
		echo $returnXml;
		
		// ==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		/*
		 * // 以log文件形式记录回调信息
		 * $log_ = new Log_ ();
		 * $log_name = "notify_url.log"; // log文件路径
		 * $log_->log_result ( $log_name, "【接收到的notify通知】:\n" . $xml . "\n" );
		 *
		 * if ($notify->checkSign () == TRUE) {
		 * if ($notify->data ["return_code"] == "FAIL") {
		 * // 此处应该更新一下订单状态，商户自行增删操作
		 * $log_->log_result ( $log_name, "【通信出错】:\n" . $xml . "\n" );
		 * } elseif ($notify->data ["result_code"] == "FAIL") {
		 * // 此处应该更新一下订单状态，商户自行增删操作
		 * $log_->log_result ( $log_name, "【业务出错】:\n" . $xml . "\n" );
		 * } else {
		 * // 此处应该更新一下订单状态，商户自行增删操作
		 * $log_->log_result ( $log_name, "【支付成功】:\n" . $xml . "\n" );
		 * }
		 *
		 * // 商户自行增加处理流程,
		 * // 例如：更新订单状态
		 * // 例如：数据库操作
		 * // 例如：推送支付完成信息
		 * }
		 */
		error_log ( "【接收到的notify通知】:\n" . $xml . "\n" );
		if ($notify->checkSign () == TRUE) {
			if ($notify->data ["return_code"] == "FAIL") {
				// 此处应该更新一下订单状态，商户自行增删操作
				error_log ( "【通信出错】:\n" . $xml . "\n" );
			} elseif ($notify->data ["result_code"] == "FAIL") {
				// 此处应该更新一下订单状态，商户自行增删操作
				error_log ( "【业务出错】:\n" . $xml . "\n" );
			} else {
				// 此处应该更新一下订单状态，商户自行增删操作
				error_log ( "【支付成功】:\n" . $xml . "\n" );
				// 将返回的xml转为数组
				$res = @simplexml_load_string ( $xml, NULL, LIBXML_NOCDATA );
				$res = json_decode ( json_encode ( $res ), true );
				$order_num = $res ['out_trade_no'];
				$total_fee = $res ['total_fee']/100;
				$pay_type = substr ( $order_num, 0, 3 );
				$res ['out_trade_no'] = substr ( $order_num, 3, strlen ( $order_num ) );
				$chargeno = $res ['out_trade_no'];//发起支付拼接了支付类型，截取后的纯数字充值号
				/*
				 * foreach ($res as $k => $v){
				 * error_log ( "【".$k."】:\n" . $v . "\n" );
				 * }
				 */
				
			    if ($pay_type == "ODR") { //拼团订单的
					
				    
					$this->after_groupbuy($chargeno,$res ["transaction_id"],$total_fee);
				
				}else if ($pay_type == "CHR"){ //现金充值 

				    
                    $this->after_pay($chargeno,$res ["transaction_id"],$total_fee);
				
				}else if($pay_type =='COR'){ //微信二维码方式的充值
				    
				    
				    $this->after_pay($chargeno,$res ["transaction_id"],$total_fee);
				    
				}else if($pay_type == 'POR'){ //普通订单的 
				    
				    $this->after_order($chargeno,$res ["transaction_id"],$total_fee);
				    
				}else if( $pay_type == 'ALL'){ 
				    $this->all_order_pay($chargeno,$res ["transaction_id"],$total_fee);
				    
				    
				}else if( $pay_type == 'HZD'){//互助店订单 
				    $this->after_shop_pay($chargeno,$res ["transaction_id"],$total_fee);
				}else{ 
				    //app 订单无前缀。
				    $this->after_pay($order_num,$res ["transaction_id"],$total_fee);
				    $res['out_trade_no'] = $order_num;
				}
				
				$this->load->model ( "wechat_pay_log_mdl", "paylog" );
				$this->paylog->create ( $res );

			}
			// 例如：更新订单状态
			// 例如：数据库操作
			// 例如：推送支付完成信息
		}
	}
	//测试购买互助店
	public function pay_shop(){
	    $charge_no =  $this->input->get('charge_no');
	    if(empty($charge_no)){
	        echo '<script>alert("请输入购买单号！");</script>';
	        exit;
	    }else{
	        $this->load->model("charge_mdl");
	        //充值订单信息
	        $charge = $this->charge_mdl->load_byChangeNum($charge_no);
	        if(!$charge){
	            echo '<script>alert("请输入正确的购买单号！");</script>';
	            exit;
	        }
	     
	        $this->after_shop_pay($charge_no,"测试8888888","0.38");
	     
	    }
	} 
	
	//购买互助店支付成功返回逻辑代码
	private function after_shop_pay($out_trade_no, $trade_no, $total_fee = '' ){
	   
	    $this->load->model("charge_mdl");
	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	  
// 	    if($charge['amount'] == $total_fee){
	    
	        $this->db->trans_begin(); //事物执行方法中的MODEL
	        // 修改订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付:'.$trade_no );
	    
	        $user_id = $charge['customer_id'];
	     
	        if($charge_row){
	        //新建互助店用户
	        $this->load->model('customer_mdl');
	        $this->load->model('customer_shop_mdl','shop');
	        
	        $customer = $this->customer_mdl->load($user_id);
	        if(empty($customer)){
	            error_log('本地用户不存在');
	        }
	        $parent_id = empty($customer['parent_id']) ? NULL:$customer['parent_id'];//上线ID
	        if($parent_id){//有上线
	            $_customer = $this->customer_mdl->load($parent_id);//获取上线用户信息
	            $_parent_id = empty($_customer['parent_id']) ? NULL:$_customer['parent_id'];//上上线ID
	             
	        }else{
	            $_parent_id = NULL;//没有上线,那上上线ID也肯定没有呀
	        }
	        $datainfo['customer_id']= $user_id;
	        $datainfo['name']= $customer['name'];
	        $datainfo['app_id'] = $this->session->userdata("app_info")["id"];
	        //下载用户微信头像到本地
	        $this->load->library('downloadimage');
	        $imginfo = $this->downloadimage->download_weixin($customer['wechat_avatar'],$user_id,"shop");
	        if(isset($imginfo['file_name'])){
	            $datainfo['logo']=$imginfo['file_name'];
	        }else{
	            $datainfo['logo']='';
	        }
	       
	        $id = $this->shop->create($datainfo);
	     
	        if($id){
	            //获取互助点收取佣金比率
	            $this->load->model("Rebate_mdl", "Rebate");
	            $rebate = $this->Rebate->load(1);
	             
	            //            $app_id = $this->session->userdata("app_info")["id"];//分站点
	            //            $sort = 1; //互助店比率
	            //            $this->Rebate->load($app_id,$sort);
	            //分配分成
	            if($parent_id){ //如果有上线ID
	                 
	                if($_parent_id){ //如果也有上上线ID
	                    $data['rebate_1'] = $rebate['rebate1'];//上级分成
	                    $data['rebate_2'] = $rebate['rebate2'];//上上级分成
	                    $data['rebate_3'] = $rebate['rebate3'];//发货商
	                    $data['rebate_4'] = $rebate['rebate4'];//分站点
	                    $data['rebate_5'] = $charge['amount']-($rebate['rebate1']+$rebate['rebate2']+$rebate['rebate3']+$rebate['rebate4']);//易货网
	                }else{//没有上上线ID
	                    $data['rebate_1'] = $rebate['rebate1'];//上级分成
	                    $data['rebate_2'] = NULL;//上上级分成
	                    $data['rebate_3'] = $rebate['rebate3'];//发货商
	                    $data['rebate_4'] = $rebate['rebate4']+$rebate['rebate2'];//分站点
	                    $data['rebate_5'] = $charge['amount']-($rebate['rebate1']+$rebate['rebate2']+$rebate['rebate3']+$rebate['rebate4']);//易货网
	                }
	            }else{//没有上线ID
	                $data['rebate_1'] = NULL;//上级分成
	                $data['rebate_2'] = NULL;//上上级分成
	                $data['rebate_3'] = $rebate['rebate3'];//发货商
	                $data['rebate_4'] = $rebate['rebate4']+$rebate['rebate1'];//分站点
	                $data['rebate_5'] = $charge['amount']-($rebate['rebate1']+$rebate['rebate3']+$rebate['rebate4']);//易货网
	            }
	             
	            $data['chargeid'] = $charge['id'];//购买互助店资格订单ID
	            $data['orderid'] = 0;
	            $data['rebate_type'] = 1;//互助店加盟
	            $data['status'] = 0;//未审核
	            $data['customer_id'] = $user_id;//支出这笔分成的用户
	            $data['total_price'] = $charge['amount'];//可分成总额
	            $data['rebate_1_id'] = $parent_id;//上级用户ID
	            $data['rebate_2_id'] = $_parent_id;//上上级用户ID
	             
	            $this->load->model('Config_mdl');
	            $shop = $this->Config_mdl->get_ByName('shop_sell_id');//获取发货商
	            $data['rebate_3_id'] = $shop['value'];//发货商
	            
	            
	            
	            $this->load->model('App_info_mdl','App');
	            $_app_user = $this->App->get_user_byID($customer['app_id']);
	             
	            $data['rebate_4_id'] = $_app_user['customer_id'];//分站点ID
	            
	            $ehw = $this->Config_mdl->get_ByName('ehw_id');//获取易货网平台
	            $data['rebate_5_id'] = $ehw['value'];//易货网ID
	             
	             
	            $this->load->model("Order_rebate_mdl", "Order_rebate");
	            $rebate_id =  $this->Order_rebate->add_shop_rebate($data);
	         
	            if($rebate_id){
	                //修改is_active
	                $this->load->model('Customer_mdl');
	                $this->Customer_mdl->active_account( $user_id );
	                //调用接口处理
	                $url = $this->url_prefix.'Notify_url/after_shop_charge';
	            
	                $data_post['customer_id'] = $user_id;
	                $data_post['charge_cash'] = $charge['amount'];
	                $data_post['chargeno'] = $charge['chargeno'];
	                $data_post['app_id'] =  0;
	            
	                $error = json_decode($this->curl_post_result($url,$data_post),true);
	                 
	                if($error['status']){
	                    $this->db->trans_commit();
	                    echo 'success';
	                }else{
	                    return false;
	                }
	            }else{
	                //该订单可能已支付过
	                $this->db->trans_rollback();
	                return false;
	            }
	        }
	     } 
// 	    }else{
// 	        $this->charge_mdl->update_status($out_trade_no,5);
// 	        return false;
// 	    } 
	   
	}
	
	//支付成功返回逻辑代码
	 private function after_pay( $out_trade_no, $trade_no, $total_fee ){
	    
	     $this->load->model("charge_mdl");

	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	    
	    if($charge['amount'] == $total_fee){
	        
	    
    	    $this->db->trans_begin(); //事物执行方法中的MODEL
    	    // 修改订单状态为已支付
    	    $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付:'.$trade_no );
    	    
    	    $user_id = $charge['customer_id'];
    	    
    	    //如果该订单状态修改成功 才执行
    	    if($charge_row){
    	        
    	        //调用接口处理
    	        $url = $this->url_prefix.'Notify_url/after_pay_charge';
    	        
    	        $data_post['customer_id'] = $user_id;
    	        $data_post['charge_cash'] = $charge['amount'];
    	        $data_post['chargeno'] = $charge['chargeno'];
    	        $data_post['app_id'] =  0;
    	        $error = json_decode($this->curl_post_result($url,$data_post),true);
    	        //事物结束
    	        
    	        if ( $error['status'] ) 
    	        {
    	            $this->db->trans_commit();
    	            echo 'success';
    	        } else {
    	            $this->db->trans_rollback();
    	            return false;
    	        }
    	        
    	    }else{
    	        //该订单可能已支付过
    	        $this->db->trans_rollback();
    	        return false;
    	    }
    	    
	    }else{ 
	        $this->charge_mdl->update_status($out_trade_no,5);
	        return false;
	    }
	    
	}
	
	//拼团支付返回逻辑
    private  function after_groupbuy($out_trade_no, $trade_no, $total_fee ){ 
	    
        $this->load->model("charge_mdl");
	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	    
	    //如果该订单状态是未支付的 才执行
	    if(!empty($charge['order_sn']) && $charge['amount'] == $total_fee ){
	        
	        $user_id = $charge['customer_id'];
	        
	        $this->db->trans_begin();
	        
	        // 修改订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付:'.$trade_no );
	        
	        
	        if($charge_row)
	        { 
	            
	            //购物订单信息
	            $this->load->model("order_mdl");
	            $order_info = $this->order_mdl->load_by_sn($charge['order_sn']);
	             
	            //改订单状态
	            $up_status = $this->order_mdl->order_confirm_paid($order_info['order_sn'], 4);
	            
	            if($up_status)
	            { 
	                //商品信息
	                $this->load->model("product_mdl");
	                $product = $this->product_mdl->item_product($order_info['id']);
	                
	                //获取该店主信息
	                $this->load->model("customer_corporation_mdl");
	                $corp_customer = $this->customer_corporation_mdl->corp_load($order_info['corporation_id']);
	                $corp_customer_id = $corp_customer['customer_id'];//店主的用户ID
	                
	                
	                //插入团
	                $this->load->model('groupbuy_mdl');
	                
	                // 如果$buy_num为空，一人成团长  给了钱才要的逻辑1/-----
	                if (empty($order_info['activity_id']) || $order_info['activity_id'] == 0) 
	                {
	                    $this->groupbuy_mdl->enddate = $product['groupbuy_end_at'];
	                    $this->groupbuy_mdl->menber_num = 1;
	                    $this->groupbuy_mdl->productid = $product['id'];
	                    $this->groupbuy_mdl->head_menber = $user_id;
	                    $this->groupbuy_mdl->activity_num = $product['activity_num'];
	                    $this->groupbuy_mdl->status = ($product['menber_num'] == 1)?1:0;
	                    $buy_num = $this->groupbuy_mdl->create();
	                    $is_ok_activity_id = $this->order_mdl->activity_id($order_info['id'],$buy_num);
	                    $head_menber = $user_id;
	                     
	                } else {
	                    $group = $this->groupbuy_mdl->load_by_buy_num($order_info['activity_id']);
	                     
	                    $group_menber_num = isset($group['menber_num']) ? $group['menber_num'] : 0;
	                    // 修改group表status 2  3
	                    if ($group_menber_num < $product['menber_num']-1) 
	                    {
	                        $this->groupbuy_mdl->menber_num = $group_menber_num + 1;
	                    } else {
	                        $this->groupbuy_mdl->menber_num = $group_menber_num + 1;
	                        $this->groupbuy_mdl->status = 1;
	                    }
	                    $buy_num = $this->groupbuy_mdl->update($order_info['activity_id']);
	                    $is_ok_activity_id = true;
	                    $head_menber = $group['head_menber'];
	                }
	                
	                
	                if( $buy_num )
	                { 
	                    //调用接口
	                    $data_post['user_id'] = $charge['customer_id'];
	                    $data_post['order_sn'] = $order_info['order_sn'];
	                    $data_post['total_price'] = $order_info['total_price']; 
	                    $data_post['charge_cash'] = $charge['amount']; //该充值订单的金额
	                    $data_post['chargeno'] = $charge['chargeno'];
	                    $data_post['corp_customer_id'] = $corp_customer_id;
	                    $data_post['app_id'] = $order_info['app_id'];
	                    $url = $this->url_prefix.'Notify_url/after_pay_groupby';
	                    
	                    $error = json_decode($this->curl_post_result($url,$data_post),true);
	                    
	                    if( $error['status'] == 1)
                        { 
                            $this->db->trans_commit();

                            //修改为不是第一次购买了。
                            $this->load->model('Customer_mdl');
                            $this->Customer_mdl->active_account( $user_id );
                            
                            echo 'success';
                            $is_ok = true;
	                            
                        }else if( $error['status'] == 2)
                        {
	                            
                            $this->db->trans_rollback();
                            //调用充值方法。
                            $this->after_pay($out_trade_no,$trade_no,$charge['amount']);
                            return ;
                        }
	                }
	            }
	        }else{ 
	            //该订单可能已支付过
	            $this->db->trans_rollback();
	            return false;
	        }
	        
	        if( empty($is_ok) )
	        { 
	            $this->db->trans_rollback();
	        }
	        
	    }else{
	        return false;
	    }
	}
	
	

	// 	private
	//@$out_trade_no = 发起支付的单号，
	//@$trade_no = 微信单号
	  private function after_order( $out_trade_no, $trade_no, $total_fee ){
	    $this->load->model("charge_mdl");
	
	    $is_ok =  false;//成功与否标示
	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	     
	    if( !empty($charge['order_sn'])  && $charge['amount'] == $total_fee ){
	
	        $this->db->trans_begin(); //事物执行方法中的MODEL。
	
	        // 修改充值订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付:'.$trade_no );
	
	        //如果该订单状态修改成功 才执行
	        if($charge_row)
	        {
	            //订单信息
	            $this->load->model('order_mdl');
	            $order_info = $this->order_mdl->load_by_sn($charge['order_sn']);
	            
	            if( $order_info )
	            { 
	                //商家信息
	                $this->load->model('customer_corporation_mdl');
	                $corp_customer = $this->customer_corporation_mdl->corp_load($order_info['corporation_id']);
	                
	                if( $corp_customer )
	                { 
	                    
	                    //修改订单状态
	                    $change_status = $order_info['status']  == 10 ? 14 : 4;
	                    //是否修改支付时间
	                    $pay_time = $order_info['status']  == 10 ? true : null;
	                    $up_status = $this->order_mdl->order_confirm_paid( $order_info['order_sn'], $change_status, $pay_time );
	                    
	                    if($up_status)
	                    { 
	                        //构造数据调用接口处理
	                        $data_post['customer_id'] = $charge['customer_id'];
	                        $data_post['charge_cash'] = $charge['amount'];
	                        $data_post['app_id'] =  0;
	                        $data_post['chargeno'] = $charge['chargeno'];
	                        $data_post['order_total_price'] =  $order_info['total_price'];
	                        $data_post['corp_customer_id'] =  $corp_customer['customer_id'];
	                        $data_post['order_sn'] = $order_info['order_sn'];
	                        $data_post['app_id'] = $order_info['app_id'];
	                        $data_post['C_commission'] = $order_info['commission'];
	                        if( $change_status == 14 )
	                        { 
	                            $url = $this->url_prefix.'Notify_url/code_pay_order';
	                            $this->load->model('order_rebate_mdl');
	                            $rebate = $this->order_rebate_mdl->order_rebate( $order_info );
	                            
	                        }else{ 
	                            $url = $this->url_prefix.'Notify_url/after_pay_order';
	                            $rebate = true;
	                        }
	                        
	                        if( $rebate )
	                        {
	                            
    	                        $error = json_decode($this->curl_post_result($url,$data_post),true);
    	                        //调用接口处理吧，骚年。
    	                       
    	                        
    	                        if( $error['status'] == 1 )
    	                        { 
    	                            $this->db->trans_commit();
    	                            
    	                            //修改为不是第一次购买了。
    	                            $this->load->model('Customer_mdl');
    	                            $this->Customer_mdl->active_account( $charge['customer_id'] );
    	                            
    	                            echo 'success';
    	                            $is_ok = true;
    	                            
    	                        }else if( $error['status'] == 2)
    	                        {
    	                            
    	                            $this->db->trans_rollback();
    	                            //调用充值方法。
    	                            $this->after_pay($out_trade_no,$trade_no,$charge['amount']);
    	                            return;
    	                        }
	                        }
	                    }
	                }
	            }
	            
	        }else{
	            //该订单可能已支付过
	            $this->db->trans_rollback();
	            return false;
	        }
	
	        //判断流程是否完成
	        if(empty($is_ok) )
	        {
	            $this->db->trans_rollback();
	            
	        }
	        
	    }else{ 
	        return false;
	    }
	}
	
	
	/**
	 * 充值单号里面处理多个订单--批量混合支付
	 */
	private function all_order_pay( $out_trade_no, $trade_no, $total_fee )
	{ 
	    $this->load->model("charge_mdl");
	    
	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	    
	    if( !empty($charge['order_ids'])  && $charge['amount'] == $total_fee )
	    { 
	        $order_id_array = array();
	        
	        $this->db->trans_begin(); //事物执行方法中的MODEL。
	        
	        // 修改充值订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付:'.$trade_no );
	        
	        
	        if( $charge_row ){
	            
    	        $order_id_array = explode(',',$charge['order_ids']);
    	        $this->load->model ( 'order_mdl' );
    	        $order_all = $this->order_mdl->load_orderall( $order_id_array );
    	        
    	        $data_post['total_price'] = 0;
    	        
    	        foreach ( $order_all as $k => $v )
    	        {
    
                    //改状态
    	            $change_status = 4;
    	            $up_status = $this->order_mdl->update_order_status($v['id'], $change_status);
    	             
    	            if($up_status)//如果更新成功才调用
    	            {
    	                 
    	                //构造调用需要的数据
    	                $data_post['total_price'] += $v['total_price'];
    	                $data_post['order_info'][$k]['corp_customer_id'] = $v['corp_customer_id'];
    	                $data_post['order_info'][$k]['total_price'] = $v['total_price'];
    	                $data_post['order_info'][$k]['order_sn'] = $v['order_sn'];
    	                $data_post['order_info'][$k]['app_id'] =  $v['app_id'];
    	                 
    	            
    	                 
    	            }else{
    	                $this->db->trans_rollback();
    	                $error['status'] = 'fail';
    	                echo json_encode($error);
    	                exit();
    	            }
    	        }
    	        
    	        //构造调用需要的数据（一维）
    	        $data_post['customer_id'] = $charge['customer_id'];
    	        $data_post['charge_cash'] = $charge['amount'];
    	        $data_post['charge_no']   = $charge['chargeno'];
    	        
	           
    	        $url = $this->url_prefix.'Notify_url/all_order_pay';
//     	        var_Dump($this->curl_post_result( $url,$data_post ));
            	$error  =  json_decode($this->curl_post_result( $url,$data_post ),true);
    	        
            	if( $error['status'] == 'success')
            	{ 
            	    $this->db->trans_commit();
            	    
            	    //修改为不是第一次购买了。
            	    $this->load->model('Customer_mdl');
            	    $this->Customer_mdl->active_account( $charge['customer_id'] );
            	    
            	    echo 'success';
            	    
            	}else if( $error['status'] == 2){
	                            
                    $this->db->trans_rollback();
                    //调用充值方法。
                    $this->after_pay($out_trade_no,$trade_no,$charge['amount']);
                    return;
                    
                }else{ 
            	    $this->db->trans_rollback();
            	    echo 'fail';
            	}
            	
	        }else{ 
	            //该订单可能已支付过
	            $this->db->trans_rollback();
	            echo 'fail';
	            return false;
	        }
	    }
	}
	
	
	
	
	
	
	
	
}
?>