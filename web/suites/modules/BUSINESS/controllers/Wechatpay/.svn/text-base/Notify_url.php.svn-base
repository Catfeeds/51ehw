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
	    error_log ( "进入微信支付回调" );
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
				
			    if ($pay_type == "ODR" ) { //拼团订单的
					
				    
					$this->after_groupbuy($chargeno,$res ["transaction_id"],$total_fee);
				
				}else if ($pay_type == "CHR" ){ //现金充值 

				    
                    $this->after_pay($chargeno,$res ["transaction_id"],$total_fee);
				
				}else if($pay_type =='COR' ){ //微信二维码方式的充值
				    
				    
				    $this->after_pay($chargeno,$res ["transaction_id"],$total_fee);
				    
				}else if($pay_type == 'POR' ){ //普通订单的 
				    
				    $this->after_order($chargeno,$res ["transaction_id"],$total_fee);

                }else if( $pay_type == 'COP' ){//H5 || PC 现金开店。
				    
				    $this->after_cash_shop($chargeno,$res ["transaction_id"],$total_fee);
				    
                
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
	
	
	/**
	 * 开店支付回调方法。
	 * @date:2017年11月7日 下午5:17:35
	 * @author: fxm
	 * @param: string $out_trade_no 本地单号
	 * @param: string $trade_no 第三方单号。
	 * @param: float $total_fee 第三方返回的支付金额。
	 * @return: mixed
	 */
	private function after_cash_shop( $out_trade_no, $trade_no, $total_fee )
	{

	    $this->load->model("charge_mdl");

	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
        
	    if ( $charge['amount'] == $total_fee ) 
	    {
            $this->db->trans_begin(); //事物执行方法中的MODEL
            
	        // 修改订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay($out_trade_no, '微信支付开店',$trade_no);

	        //如果该订单状态修改成功 才执行
	        if ( $charge_row ) 
	        {
	            $charge['trade_no'] = $trade_no;//微信支付单号。
	            $charge['payment_name'] = '微信支付';
	            $this->load->model("cash_shop_mdl");
	            $result = $this->cash_shop_mdl->Cash_shop( $charge );
	            
	            //事物结束
                if ( $result['status'] == 1 ) 
	            {
	                $this->db->trans_commit();
	                echo 'success';
	                exit();
	            }
	            
                $this->db->trans_rollback();
                echo 'fail';
	            exit;

            } else {
	            //该订单可能已支付过
                error_log('开店charge处理失败,charge_no:'.$out_trade_no);
	            $this->db->trans_rollback();
	            return false;
	        }

	    } else {
	        error_log('充值金额不匹配chagrno:'.$out_trade_no);
	        $this->charge_mdl->update_status($out_trade_no, 5);
	        return false;
	    }

	}

	
	//支付成功返回逻辑代码
	 private function after_pay( $out_trade_no, $trade_no, $total_fee ){
	    
	     $this->load->model("charge_mdl");

	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	    
	    if($charge['amount'] == $total_fee){
	        
	    
    	    $this->db->trans_begin(); //事物执行方法中的MODEL
    	    // 修改订单状态为已支付
    	    $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付充值',$trade_no );
    	    
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
    private function after_groupbuy($out_trade_no, $trade_no, $total_fee ){ 
	    
        $this->load->model("charge_mdl");
	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	    
	    //如果该订单状态是未支付的 才执行
	    if(!empty($charge['order_sn']) && $charge['amount'] == $total_fee ){
	        
	        $user_id = $charge['customer_id'];
	        
	        $this->db->trans_begin();
	        
	        // 修改订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付拼团订单',$trade_no );
	        
	        
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
	                    
	                    if($error['status'] == 1)
                        { 
                            $this->db->trans_commit();
                            echo 'success';
                            $is_ok = true;
                            
                            //支付成功,插入支付成功信息
                            $this->load->model('Customer_message_mdl',"Message");
                            $this->load->model('Customer_mdl');
                            $customer_info = $this->Customer_mdl->load( $charge['customer_id'] );
                            //模板
                            $Msg_info['template_id']= 6;
                            //标题
                            $Msg_info['customer_id']= $charge['customer_id'];
                            $Msg_info['obj_id'] = $order_info['id'];
                            $Msg_info['type'] = 2;
                            $Msg_info['parameter']['name'] = !empty($customer_info['nick_name']) ? $customer_info['nick_name'] : $customer_info['name'];
                            $Msg_info['parameter']['number'] = $order_info['order_sn'];
                            $this->Message->Create_Message($Msg_info);
                            
	                            
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
	    $this->load->helper ( 'order' );
	
	    $is_ok =  false;//成功与否标示
	    //充值订单信息
	    $charge = $this->charge_mdl->load_byChangeNum($out_trade_no);
	     
	    if( !empty($charge['order_sn'])  && $charge['amount'] == $total_fee ){
	
	        $this->db->trans_begin(); //事物执行方法中的MODEL。
	
	        // 修改充值订单状态为已支付
	        $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,'微信支付订单',$trade_no );
	
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
	                    
	                    $up_status = $this->order_mdl->order_confirm_paid( $order_info['order_sn'], $change_status,$pay_time );
	                    
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
	                        $data_post['commission'] = $order_info['commission'];
	                        $data_post['app_id'] = $order_info['app_id'];
	                        $data_post['charge_commission'] = $charge['commission'];
	                        
	                        
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
    	                        
    	                        if($error['status'] == 1)
    	                        { 
    	                            $this->db->trans_commit();
    	                            echo 'success';
    	                            $is_ok = true;
    	                            
    	                            //支付成功,插入支付成功信息
    	                            $this->load->model('Customer_message_mdl',"Message");
                                    $this->load->model('Customer_mdl');
                                    $customer_info = $this->Customer_mdl->load( $charge['customer_id'] );
    	                            //模板
    	                            $Msg_info['template_id']= 6;
    	                            //标题
    	                            $Msg_info['customer_id']= $charge['customer_id'];
    	                            $Msg_info['obj_id'] = $order_info['id'];
    	                            $Msg_info['type'] = 2;
    	                            $Msg_info['parameter']['name'] = !empty($customer_info['nick_name']) ? $customer_info['nick_name'] : $customer_info['name'];
    	                            $Msg_info['parameter']['number'] = $order_info['order_sn'];
    	                            $this->Message->Create_Message($Msg_info);
    	                            
    	                            
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
}
?>