<?php
/**
 * 
 *  抽奖系统
 *
 */
class Lottery_mdl extends CI_Model {
     
	function __construct() {
		parent::__construct ();
	}
	
	
	
	/**
	 * 综合处理  当存在openid 跟mobile两条记录 的customer_idshi 一样的时候
	 * 
	 * 调用此方法  前提customer_id 肯定在主表9thleaf_lottery存在一条有效的记录
	 * 
	 */
	
	public function manage($sift){
	    $customer_id = $this->session->userdata("user_id");
	    
	    if(empty( $sift['openid']) && empty( $sift['mobile'])){
	       echo  'manage参数错误1'; 
	       exit;
	    }
	    if(!empty( $sift['openid']) && !empty( $sift['mobile'])){
	        echo  'manage参数错误2';
	        exit;
	    }
	    
	    $where['type'] = 'customer_id';
	    $where['key'] = $customer_id;
	    $lottery = $this->load($where);
	   
	    if(!empty( $sift['openid'])){
	        $load['type'] = 'openid';
	        $load['key'] = $sift['openid'];
	    }else{
	        $load['type'] = 'mobile';
	        $load['key']  = $sift['mobile'];
	    }
	     
	    if( $load['type'] == 'openid'){
	        $openid_lottery = $this->load($load);
	        //对比用户
	        if($openid_lottery['id'] == $lottery['id']){
	            $return = array(
	                'status' => 0,
	                'msg' => '信息无误'
	            );
	            return $return;
	        }
	        
	        
	        //对比用户ID
	        if(empty($openid_lottery['customer_id']) && empty($lottery['openid'])){
	            
	            if(empty($lottery['mobile'])){
	                $this->db->trans_begin();//开启事务
	                $update = array();
	                //将两个记录合并  切让其中一个失效
	                $update['id'] = $openid_lottery['id'];
	                $update['customer_id'] = $lottery['customer_id'];
	                $update_aff = $this->update($update);
	                 
	                error_log($this->db->last_query());
	                if($update_aff){
	                    $update = array();
	                    $update['id'] = $lottery['id'];
	                    $update['is_valid'] = 0;
	                    $aff = $this->update($update);
	                    $this->del_log($lottery['id']);
	                    if($aff){
	                        $this->db->trans_commit();
	                        $return = array(
	                            'status' => 0,
	                            'msg' => '数据合并成功'
	                        );
	                    }else{
	                        $this->db->trans_rollback();
	                        $return = array(
	                            'status' => 3,
	                            'msg' => 'openid数据同步失败'
	                        );
	                    }
	                }else{
	                    $this->db->trans_rollback();
	                    $return = array(
	                        'status' => 4,
	                        'msg' => 'openid数据合并失败'
	                    );
	                }
	                return $return;
	          }else{
	              $this->db->trans_begin();//开启事务
	              $update = array();
	              //将两个记录合并  
	              $update['id'] = $lottery['id'];
	              $update['openid'] = $openid_lottery['openid'];
	              $update_aff = $this->update($update);
	              if($update_aff){
	                  //使openid记录失效
	                  $update = array();
	                  $update['id'] = $openid_lottery['id'];
	                  $update['is_valid'] = 0;
	                  $aff = $this->update($update);
	                  //获取最新投票时间
	                  $del_log =  $this->loadLog($openid_lottery['id']);
	                  $vote_at = $del_log['vote_at'];
	                  
	                  $this->del_log($openid_lottery['id']);
	                  if($aff){
	                      $lottery_log = $this->getThisDayLog($lottery['id']);
	                      if($lottery_log['total_num'] < 10){
	                          $update = array();
	                          $update['total_num'] = $lottery_log['total_num']+1;
	                          $update['vote_num'] = $lottery_log['vote_num']+1;
	                          $update['id'] = $lottery_log['id'];
	                          $update['vote_at'] = $vote_at;
	                          $update_af = $this->updateTotalNum($update);
	                        }
                          $this->db->trans_commit();
                          $return = array(
                              'status' => 0,
                              'msg' => '数据合并成功'
                          );
	                  }
	              }else{
	                  $this->db->trans_rollback();
	                  $return = array(
	                      'status' => 4,
	                      'msg' => 'openid数据合并失败'
	                  );
	               
	              }
	              return $return;
	          } 
	       }
	       if(!empty($openid_lottery['customer_id'])  && $openid_lottery['customer_id'] != $customer_id){
	           $return = array(
	               'status' => 5,
	               'msg' => 'openid数据用户非法'
	           );
	           return $return;
	       }     
	         
	    }else if( $load['type'] == 'mobile'){
	        $mobile_lottery = $this->load($load);
	        if($mobile_lottery['id'] == $lottery['id']){
	            $return = array(
	                'status' => 0,
	                'msg' => '信息无误'
	            );
	            return true;
	        }
	        //对比用户ID
	        if(empty($mobile_lottery['customer_id']) && empty($lottery['mobile'])){
	            if(empty($lottery['openid'])){
	                $this->db->trans_begin();//开启事务
	                $update = array();
	                //将两个记录合并  切让其中一个失效
	                $update['id'] = $mobile_lottery['id'];
	                $update['customer_id'] = $lottery['customer_id'];
	                $update_aff = $this->update($update);
	                if($update_aff){
	                    $update = array();
	                    $update['id'] = $lottery['id'];
	                    $update['is_valid'] = 0;
	                    $aff = $this->update($update);
	                    $this->del_log($lottery['id']);
	                    if($aff){
	                        $this->db->trans_commit();
	                        $return = array(
	                            'status' => 0,
	                            'msg' => '数据合并成功'
	                        );
	                    }else{
	                        $this->db->trans_rollback();
	                        $return = array(
	                            'status' => 3,
	                            'msg' => 'mobile数据同步失败'
	                        );
	                    }
	                    return $return;
	                }else{
	                    $this->db->trans_rollback();
	                    $return = array(
	                        'status' => 4,
	                        'msg' => 'mobile数据合并失败'
	                    );
	                }
	                return $return;
	            }else{
	                $this->db->trans_begin();//开启事务
	                $update = array();
	                //将两个记录合并  切让其中一个失效
	                $update['id'] = $lottery['id'];
	                $update['mobile'] = $mobile_lottery['mobile'];
	                $update_aff = $this->update($update);
	                if($update_aff){
	                    $update = array();
	                    $update['id'] = $mobile_lottery['id'];
	                    $update['is_valid'] = 0;
	                    $aff = $this->update($update);
	                    
	                    //获取最新投票时间
	                    $del_log =  $this->loadLog($mobile_lottery['id']);
	                    $vote_at = $del_log['vote_at'];
	                    
	                    $this->del_log($mobile_lottery['id']);
	                    if($aff){
	                        $lottery_log = $this->getThisDayLog($lottery['id']);
	                        if($lottery_log['total_num'] < 10){
	                            $update = array();
	                            $update['total_num'] = $lottery_log['total_num']+1;
	                            $update['vote_num'] = $lottery_log['vote_num']+1;
	                            $update['id'] = $lottery_log['id'];
	                            $update['vote_at'] = $vote_at;
	                            $update_af = $this->updateTotalNum($update);
	                        }
	                        $this->db->trans_commit();
	                        $return = array(
	                            'status' => 0,
	                            'msg' => '数据合并成功'
	                        );
	                    }
	                }else{
	                    $this->db->trans_rollback();
	                    $return = array(
	                        'status' => 4,
	                        'msg' => 'openid数据合并失败'
	                    );
	                
	                }
	                return $return;
	            }
	        }
	        if(!empty($mobile_lottery['customer_id'])  && $mobile_lottery['customer_id'] != $customer_id){
	            $return = array(
	                'status' => 5,
	                'msg' => 'mobile数据用户非法'
	            );
	            return $return;
	        }
	    }
	}
	
	
	/**
	 * 更新lottery主表
	 */
	
	public function  update($update){
	    if(!empty($update['mobile'])){
	        $this->db->set("mobile",$update['mobile']);
	    }elseif(!empty($update['openid'])){
	        $this->db->set("openid",$update['openid']);
	    }elseif(!empty($update['customer_id'])){
	        $this->db->set("customer_id",$update['customer_id']);
	    }
	    if(isset($update['is_valid'])){
	        $this->db->set("is_valid",$update['is_valid']);
	    }
	    
	    $datetime = date('Y-m-d H:i:s');
	    $this->db->set('update_at',$datetime);
	    $this->db->where('id',$update['id']);
	    $this->db->update("lottery");
	    return $this->db->affected_rows();
	}
	
	
	/**
	 * 查询是否存在某一条数据
	 */
	
	public function load($sift){
	    
	    $type = array(
	        "id",
	        "openid",
	        "customer_id",
	        "mobile",
	    );
 	    if(empty($sift['type'])){
	        return  false;
	    }else if(!in_array($sift['type'], $type)){
	        return  false;
	    }
	    $this->db->where($sift['type'],$sift['key']);
	    $this->db->where('is_valid',1);//有效的
	    $this->db->from("lottery");
	    $row = $this->db->get()->row_array();
	    return $row;
	}
	
	/**
	 * 获取后台设置的添加优惠券
	 */
	
	public function getLotteryConfig($name = ''){
	    if($name){
	        $this->db->where("name",$name);
	        $this->db->from("lottery_config");
	        $row = $this->db->get()->row_array();
	    }else{
	        $this->db->from("lottery_config");
	        $row = $this->db->get()->result_array();
	    }
	    
	    return $row;
	}
	
	/**
	 * 查询当天抽奖记录
	 */
	public function getThisDayLog($lottery_id){
	    $this->db->from("lottery_log as ll");
	    $min_date = date('Y-m-d ', strtotime("-1 days"));// 筛除时间段：1天
	    $max_date = date('Y-m-d ', strtotime("+1 days"));// 筛除时间段：1天
	    $this->db->where("ll.create_at >=",$min_date);
	    $this->db->where("ll.create_at <=",$max_date);
	    $this->db->where("ll.lottery_id ",$lottery_id);
	    $row = $this->db->get()->row_array();
	    return $row;
	}
	
	/**
	 * 查询某一条log
	 */
	public function loadLog($lottery_id){
	    $this->db->where("lottery_id",$lottery_id);
	    $this->db->from("lottery_log");
	    $row = $this->db->get()->row_array();
	    return $row;
	}
	
	/**
	 * 新增当天抽奖记录
	 */
	public function CreateLotteryLog($sift){
	    $this->db->insert('lottery_log',$sift);
	    $lottery_Log_id = $this->db->insert_id();
	    return $lottery_Log_id;
	} 
	
	
	public function  CreateByCus(){
	    $customer_id = $this->session->userdata("user_id");
	    $data['customer_id'] = $customer_id;
	    $this->db->insert('lottery',$data);
	    $lottery_id = $this->db->insert_id();
	    return $lottery_id;
	}
	
	/**
	 * 生成一条可抽奖 并且 可抽奖数+1
	 */
   public function  Create($data){
       
       $is_ok = false;//事务识别
       $this->db->trans_begin();//开启事务
       $this->db->insert('lottery',$data);
       $lottery_id = $this->db->insert_id();
       
       if($lottery_id){
           $log['lottery_id'] = $lottery_id;
           $log['total_num'] = 1;
           $log['vote_num'] = 1;
           $datetime = date('Y-m-d H:i:s');
           $log['update_at'] = $datetime;
           $log['vote_at'] = $datetime;
           $this->db->insert('lottery_log',$log);
           $log_id = $this->db->insert_id();
           if($log_id){
               $is_ok = true;
           }
       }
       
       if($is_ok){
           $this->db->trans_commit();
           return $lottery_id;
       }else{
           $this->db->trans_rollback();
           return false;
       }
    }
   
    
    /**
     * 更新抽奖次数
     */
    public  function  updateNumbers($sift){
        $datetime = date('Y-m-d H:i:s');
        $this->db->set('update_at',$datetime);
        $this->db->set('total_num',$sift['total_num']);
        $this->db->set('numbers',$sift['numbers']);
        $this->db->where('id', $sift['id']);
        $this->db->update("lottery_log");
        return $this->db->affected_rows();
    }
    
    /**
     * 更新抽奖总次数
     */
    public function updateTotalNum($sift){
        $datetime = date('Y-m-d H:i:s');
        $this->db->set('update_at',$datetime);
        $this->db->set('vote_num',$sift['vote_num']);
        $this->db->set('total_num',$sift['total_num']);
        if(!empty($sift['vote_at'])){
            $this->db->set('vote_at',$sift['vote_at']);
        }
        $this->db->where('id', $sift['id']);
        $this->db->update("lottery_log");
        return $this->db->affected_rows();
    }
    
	
    /**
     * 删除lottery主表失效后对应的lottery_log中的一条记录
     */
    
    public function  del_log($lottery_id){
        $this->db->where("lottery_id",$lottery_id);
        $this->db->delete("lottery_log");
        return $this->db->affected_rows();
    }
    
    
    
    /**
     * 添加获奖记录
     */
    
    public function add_award($data){
        $this->db->insert('lottery_award',$data);
        $award_id = $this->db->insert_id();
        return $award_id;
    }
    
    /**
     * 获奖记录
     */
    public function getAward($award_id){
        $this->db->where("id",$award_id);
        $this->db->from("lottery_award");
        $row = $this->db->get()->row_array();
	    return $row;
    }
    
    /**
     * 查询当天获奖记录
     */
    public function getThisDayAwardLog($lottery_id,$item = 0){
        $customer_id = $this->session->userdata('user_id');
        if($item){
            $this->db->select("la.item");
        }
        $this->db->from("lottery_award as la");
        $min_date = date('Y-m-d ', strtotime("-1 days"));// 筛除时间段：1天
        $max_date = date('Y-m-d ', strtotime("+1 days"));// 筛除时间段：1天
        $this->db->where("la.create_at >=",$min_date);
        $this->db->where("la.create_at <=",$max_date);
        $this->db->where("la.lottery_id ",$lottery_id);
       
        $query = $this->db->get()->result_array();
        return $query;
    }
    
    /**
     * 更新获奖记录
     */
    public function updataAward($award_id){
        $datetime = date('Y-m-d H:i:s');
        $this->db->set('update_at',$datetime);
        $this->db->set("status",1);
        $this->db->where("id",$award_id);
        $this->db->update("lottery_award");
        return $this->db->affected_rows();
            
    }
    
    /**
     * 更换获奖的用户ID
     * $old_id  旧的微信用户ID
     * $new_id  新的手机用户ID 
     */
    
    public function changeUserAward($old_id,$new_id){
        $this->db->where("customer_id",$old_id);
        $this->db->from("lottery");
        $row = $this->db->get()->row_array();
        if($row){
            $this->db->trans_begin();//开启事务
            $this->db->set("customer_id",$new_id);
            $this->db->where("customer_id",$old_id);
            $this->db->update("lottery");
            $lottery_aff = $this->db->affected_rows();
            if($lottery_aff){
                $this->db->set("customer_id",$new_id);
                $this->db->where("customer_id",$old_id);
                $this->db->update("lottery_award");
                $lottery_award_aff = $this->db->affected_rows();
                if($lottery_award_aff){
                    $this->db->trans_commit();
                    return true;
                }else {
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }else{
            return false;
        }
       
    }
    
    
	
}