<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class Datacollation extends Front_Controller {
	

	public function __construct() 
	{
		parent::__construct ();

	}
	
	// --------------------------------------------------------------
	
	/**
	 * 授信
	 */
	function Credit($status = 0){
        //接口－删除授信
        $post['status']=$status;
        $url = $this->url_prefix.'Data_collation/Credit';
        echo $this->curl_post_result($url,$post);
	}
	
	// --------------------------------------------------------------
	
	
	/**
	 * 删除订单
	 * @param int $status 识别是否执行操作
	 */
	function order($status=0){
	    //查询订单
        $this->db->from("order_temp");
        $order_list = $this->db->get()->result_array();
        $this->db->trans_begin();
        foreach ($order_list as $v){
            $order_id = $v['id'];//订单id
            //判断订单是否付款
            if(in_array($v["status"],array("4","6","9","14"))){//已付款
                if($v["status"] == 14){//判断是否评价
                    //删除评价
                    $this->db->where_in("orderitem_id","(select id from 9thleaf_order_item where order_id = $order_id)",false);
                    $row = $this->db->delete("order_comments");
                    if(!$row){
                        $this->db->trans_rollback();
                        echo "id为".$order_id."的订单删除评价失败"; exit;
                    }
                }
                
                //删除核销
                $this->db->where("order_id",$order_id);
                $row = $this->db->delete("order_verify");
                if(!$row){
                    $this->db->trans_rollback();
                    echo "id为".$order_id."的订单删除核销记录失败"; exit;
                }
                
                
                if(in_array($v["status"],array("6","9","14"))){//判断是否已经收货
                    //删除分成记录
                    $this->db->where("orderid",$order_id);
                    $row = $this->db->delete("order_rebate");
                    if(!$row){
                        $this->db->trans_rollback();
                        echo "id为".$order_id."的订单删除分成记录失败"; exit;
                    }
                }
                
                $row = $this->del_order($order_id);//删除订单
                if(!$row){
                    $this->db->trans_rollback();
                    echo "id为".$order_id."的订单删除记录失败"; exit;
                }
                
                //接口-订单退款
                $post['status']=$v["status"];//9,14卖家退款，4,6平台退款
                $post['total_price']=$v["total_price"];//订单总金额（不算手续费）
                $post['commission']=$v["commission"]?$v["commission"]:"0.00";//手续费
                $post['customer_id']=$v["customer_id"];//买家用户id
                $post['corp_customer_id']=$v["corp_customer_id"];//卖家用户id
                $post['order_sn']= $v["order_sn"];//订单编号
                $post['type'] = $status;//识别是否执行操作
                $url = $this->url_prefix.'Data_collation/refunds';
                $row = json_decode($this->curl_post_result($url,$post),true);
                if($row["status"] != 2){
                    $this->db->trans_rollback();
                    echo "id为".$order_id."的退款失败"; exit;
                }
                
                
            }else if(in_array($v["status"],array("1","2","10","11","12"))){//未付款
                $row = $this->del_order($order_id);//删除订单
                if(!$row){
                    $this->db->trans_rollback();
                    echo "id为".$order_id."的订单删除记录失败"; exit;
                }
            }
        }
        
        if($status==1){
            $this->db->trans_commit();
            echo "清除成功：一共清除了".count($order_list)."张订单数据";
        }else{
            $this->db->trans_rollback();
            echo "你确定要清除".count($order_list)."张订单数据吗？";
        }
        

	}
	
	/**
	 * 删除订单
	 */
	private function del_order($order_id){
	    //删除9thleaf_order
	    $this->db->where("id",$order_id);
	    $row = $this->db->delete("order");
	    if(!$row){
	        return false;
	    }
	    
	    //删除9thleaf_order_log
	    $this->db->where("orderid",$order_id);
	    $row = $this->db->delete("order_log");
	    if(!$row){
	        return false;
	    }
	    
	    //删除9thleaf_order_delivery
	    $this->db->where("order_id",$order_id);
	    $row = $this->db->delete("order_delivery");
	    if(!$row){
	        return false;
	    }
	    
	    //删除9thleaf_order_item
	    $this->db->where("order_id",$order_id);
	    $row = $this->db->delete("order_item");
	    if(!$row){
	        return false;
	    }

	    return true;
	   
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 货豆转移
	 */
	function  M_credit($status = 0){
	    //接口－删除货豆转移log
        $post['status']=$status;
	    $url = $this->url_prefix.'Data_collation/M_credit';
	    echo $this->curl_post_result($url,$post);
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 现金转货豆
	 */
	function  money($status = 0){
	    //接口－删除现金转货豆log
	    $post['status']=$status;
	    $url = $this->url_prefix.'Data_collation/money';
	    echo $this->curl_post_result($url,$post);
	}
	
	// --------------------------------------------------------------
	
	/**
	 * 清空帐户订单
	 */
	function  emptied_account_order($status = 0){
	    //查询用户
	    $url = $this->url_prefix.'Data_collation/get_customerid';
	    $data = json_decode($this->curl_post_result($url,$post),true);
        if(count($data) != 103){
            echo "删除失败，一共".count($data)."个用户订单，并非指定的103个用户";exit;
        }
        $customer_ids = array_column($data,"customer_id");
        //查询订单
        $this->db->from("order");
        $this->db->where_in("customer_id",$customer_ids);
        $order_list = $this->db->get()->result_array();
        $this->db->trans_begin();
        foreach ($order_list as $v){
            $order_id = $v['id'];//订单id
            //判断订单是否付款
            if(in_array($v["status"],array("4","6","9","14"))){//已付款
                if($v["status"] == 14){//判断是否评价
                    //删除评价
                    $this->db->where_in("orderitem_id","(select id from 9thleaf_order_item where order_id = $order_id)",false);
                    $row = $this->db->delete("order_comments");
                    if(!$row){
                        $this->db->trans_rollback();
                        echo "订单id为".$order_id."的订单删除评价失败"; exit;
                    }
                }
        
                //删除核销
                $this->db->where("order_id",$order_id);
                $row = $this->db->delete("order_verify");
                if(!$row){
                    $this->db->trans_rollback();
                    echo "订单id为".$order_id."的订单删除核销记录失败"; exit;
                }
        
        
                if(in_array($v["status"],array("6","9","14"))){//判断是否已经收货
                    //删除分成记录
                    $this->db->where("orderid",$order_id);
                    $row = $this->db->delete("order_rebate");
                    if(!$row){
                        $this->db->trans_rollback();
                        echo "订单id为".$order_id."的订单删除分成记录失败"; exit;
                    }
                }
        
                $row = $this->del_order($order_id);//删除订单
                if(!$row){
                    $this->db->trans_rollback();
                    echo "订单id为".$order_id."的订单删除记录失败"; exit;
                }
        
                //接口-订单退款
                $post['status']=$v["status"];//9,14卖家退款，4,6平台退款
                $post['total_price']=$v["total_price"];//订单总金额（不算手续费）
                $post['commission']=$v["commission"]?$v["commission"]:"0.00";//手续费
                $post['customer_id']=$v["customer_id"];//买家用户id
                $post['corp_customer_id']=$v["corp_customer_id"];//卖家用户id
                $post['order_sn']= $v["order_sn"];//订单编号
                $post['type'] = $status;//识别是否执行操作
                $url = $this->url_prefix.'Data_collation/refunds';
                $row = json_decode($this->curl_post_result($url,$post),true);
                if($row["status"] != 2){
                    $this->db->trans_rollback();
                    echo "订单id为".$order_id."的退款失败"; exit;
                }
        
        
            }else if(in_array($v["status"],array("1","2","10","11","12"))){//未付款
                $row = $this->del_order($order_id);//删除订单
                if(!$row){
                    $this->db->trans_rollback();
                    echo "订单id为".$order_id."的订单删除记录失败"; exit;
                }
            }
        }
        
        if($status==1){
            $this->db->trans_commit();
            echo "清除成功：一共清除了".count($order_list)."张订单数据";
        }else{
            $this->db->trans_rollback();
            echo "你确定要清除".count($order_list)."张订单数据吗？";
        }
        
        
        
        
	    

	}
	
	// --------------------------------------------------------------
	
	/**
	 * 清理帐户红包发送
	 */
	function emptied_account_send_red($status = 0){
	    //查询用户
	    $url = $this->url_prefix.'Data_collation/get_customerid';
	    $data = json_decode($this->curl_post_result($url,$post),true);
	    if(count($data) != 103){
	        echo "删除失败，一共".count($data)."个用户订单，并非指定的103个用户";exit;
	    }
	    $customer_ids = array_column($data,"customer_id");
	    
	    //处理发送红包
	    $this->db->select("b.*");
	    $this->db->from("red_envelope as a");
	    $this->db->join("red_envelope_detail as b","a.id = b.r_id");
	    $this->db->where_in("a.originator",$customer_ids);
	    $RedList = $this->db->get()->result_array();
	    foreach($RedList as $v){
	        $this->db->trans_begin();
	        if($v["customer_id"] != null && $v["customer_id"] != '-1'){//已被领取，领取人退款
	            //接口-红包退款
	            $post['status']=$status;
	            $post['amount']=$v["amount"];//订单总金额（不算手续费）
	            $post['customer_id']=$v["customer_id"];//买家用户id
	            $url = $this->url_prefix.'Data_collation/emptied_account_red';
	            $row = json_decode($this->curl_post_result($url,$post),true);
	            if($row["status"] != 1){
	                $this->db->trans_rollback();
	                echo "red_envelope_detail表id为".$v['id']."退款失败"; exit;
	            }
	        }
	        //删除发送记录
	        $this->db->where("id",$v["r_id"]);
	        $row = $this->db->delete("red_envelope");
            if(!$row){
                $this->db->trans_rollback();
                echo "red_envelope表id为".$v['r_id']."删除失败"; exit;
            }
            
            $this->db->where("id",$v["id"]);
            $row = $this->db->delete("red_envelope_detail");
            if(!$row){
                $this->db->trans_rollback();
                echo "red_envelope_detail表id为".$v['id']."删除失败"; exit;
            }
            
            
            if($status){
                $this->db->trans_commit();
            }else{
                $this->db->trans_rollback();
            }
	    }
	    
	    if($status){
	        echo "清除成功：一共清除了".count($RedList)."个红包数据";
	    }else{
	        echo "你确定要清除".count($RedList)."个红包数据吗？";
	    }

	}
	
	// --------------------------------------------------------------
	
	/**
	 * 清理帐户红包领取
	 */
	function emptied_account_get_red($status = 0){
	    //查询用户
	    $url = $this->url_prefix.'Data_collation/get_customerid';
	    $data = json_decode($this->curl_post_result($url,$post),true);
	    if(count($data) != 5){
	        echo "删除失败，一共".count($data)."个用户订单，并非指定的103个用户";exit;
	    }
	    $customer_ids = array_column($data,"customer_id");
	    $customer_ids[] = 11;
	    //处理领取红包
	    $this->db->from("red_envelope_detail");
	    $this->db->where_in("customer_id",$customer_ids);
	    $RedList = $this->db->get()->result_array();
	    $this->db->trans_begin();
	    foreach($RedList as $v){
	        $this->db->set("receive_at",null);
	        $this->db->set("remark",null);
	        $this->db->set("customer_id",null);
	        $this->db->where($v["id"]);
	        $row = $this->db->update("red_envelope_detail");
	        if(!$row){
	            $this->db->trans_rollback();
	            echo "red_envelope_detail表id为".$v['id']."设置未领取状态失败"; exit;
	        }
	    }
	     
	    if($status){
	        $this->db->trans_commit();
	        echo "设置成功：一共设置未领取状态".count($RedList)."个红包数据";
	    }else{
            $this->db->trans_rollback();
	        echo "你确定要设置未领取状态".count($RedList)."个红包数据吗？";
	    }
	
	}
	
	// --------------------------------------------------------------
	
	function emptied_account($status = 0){
	    //接口－清空账户
	    $post['status']=$status;
	    $url = $this->url_prefix.'Data_collation/emptied_account';
	    echo $this->curl_post_result($url,$post);
	}
	
}
