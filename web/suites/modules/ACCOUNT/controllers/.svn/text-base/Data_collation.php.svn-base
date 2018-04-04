<?php
if  (! defined ( 'BASEPATH' ))
    exit ( 'No direct script access allowed' );

    // ------------------------------------------------------------------------

/**
 * 数据调整
 *
 */
class Data_collation extends Account_Controller
{

    
    public function __construct()
    {
        parent::__construct();
    }
   
    //---------------------------------------------------------------------------------------------------
    /**
     * 授信
     */
    function Credit(){
        $status = $this->input->post("status");//状态
        //查询保留的log
        $this->db->from("customer_credit_log");
        $this->db->where_in("created_at",array("2016-12-08 13:53:29","2016-11-16 16:14:16"));
        $credit = $this->db->get()->result_array();
        $num = count($credit);
        $credit_ids = array_column($credit,"id");
        $relation_ids = array_column($credit,"relation_id");
        
        if($num == 2){
            $this->db->trans_begin();//开启事务
            //删除授信log
            $this->db->where_not_in("id",$credit_ids);
            $this->db->delete("customer_credit_log");
            $del_num = $this->db->affected_rows();
            if($del_num == 0){
                //清空授信
                $this->db->where_not_in("id","select id_pay from 9thleaf_pay_relation where id = 12",false);
                $this->db->set("credit",0);
                $row = $this->db->update("pay_account");
                if($status == 1){
                    $this->db->trans_commit();
                    echo "操作成功，一共删除了".$del_num."条授信";
                }else{
                    echo "确定要删除".$del_num."条授信？";
                    $this->db->trans_rollback();
                }
            }else{
                $this->db->trans_rollback();
                echo "一共删除了".$del_num."条授信，不是特定的33条";
            }
        }else{
            echo "一共保留了".$num."条数据，不是特定的2条";
            echo "<pre>";
            print_r($credit);
        }
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 订单退款
     */
    function refunds(){
        $status = $this->input->post("status");//9,14卖家退款，4,6平台退款
        $total_price = $this->input->post("total_price");//订单总金额（不算手续费）
        $commission = $this->input->post("commission");//手续费
        $customer_id = $this->input->post("customer_id");//买家用户id
        $corp_customer_id = $this->input->post("corp_customer_id");//卖家用户id
        $order_sn = $this->input->post("order_sn");//订单编号
        $type = $this->input->post("type");//识别是否执行操作

        
        $this->db->trans_begin();
        //退款给买家
        $this->db->set("cash","cash+$commission",false);
        $this->db->set("M_credit","M_credit+$total_price",false);
        $this->db->where("id","(select id_pay from 9thleaf_pay_relation where customer_id = $customer_id)",false);
        $row = $this->db->update("pay_account");
        if(!$row){
            $this->db->trans_rollback();
            echo json_encode(array("status"=>1));//退款失败
            exit;
        }

        
        if(in_array($status,array("9","14")) && $corp_customer_id != null){//订单完成，商家退款
            //扣商家款
            $this->db->set("cash","cash-$commission",false);
            $this->db->set("M_credit","M_credit-$total_price",false);
            $this->db->where("id","(select id_pay from 9thleaf_pay_relation where customer_id = $corp_customer_id)",false);
            $row = $this->db->update("pay_account");
            if(!$row){
                $this->db->trans_rollback();
                echo json_encode(array("status"=>1));//退款失败
                exit;
            }
        }
        
        
        //删除customer_currency_log
        $this->db->where("order_no",$order_sn);
        $row = $this->db->delete("customer_currency_log");
        if(!$row){
            $this->db->trans_rollback();
            echo json_encode(array("status"=>1));//退款失败
            exit;
        }
        
        
        //删除customer_money_log
        $this->db->where("charge_no",$order_sn);
        $row = $this->db->delete("customer_money_log");
        if(!$row){
            $this->db->trans_rollback();
            echo json_encode(array("status"=>1));//退款失败
            exit;
        }
        
        if($type==1){
            $this->db->trans_commit();
            echo json_encode(array("status"=>2));//退款成功
        }else{
            $this->db->trans_rollback();
            echo json_encode(array("status"=>2));//退款成功
        }
  
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 货豆转移
     */
    function M_credit(){
        $status = $this->input->post("status");//状态
        $this->db->from("customer_currency_log as a");
        $this->db->join("temp_m_currency_log as b","a.id = b.id");
        $this->db->where("id_event",70);
        $m_credit = $this->db->get()->result_array();

        if(count($m_credit) != 70){
            $this->db->trans_rollback();
            echo "删除失败，一共".count($m_credit)."条货豆转移log,并不是指定的70条";exit;
        }
        $this->db->trans_begin();
        //返还货豆
        foreach ($m_credit as $v){
            if($v["type"]== 1){//收入
                if($v["customer_id"] != "-1"){
                    //扣除货豆
                    $this->db->set("M_credit","M_credit+{$v['amount']}",false);
                    $this->db->where("id","(select id_pay from 9thleaf_pay_relation where customer_id = {$v['customer_id']})",false);
                    $row = $this->db->update("pay_account");
                    if(!$row){
                        $this->db->trans_rollback();
                        echo "返还货豆失败";exit;
                    }
                }
                
            }else{//支出
                if($v["customer_id"] != "-1"){
                    //返回货豆
                    $this->db->set("M_credit","M_credit-{$v['amount']}",false);
                    $this->db->where("id","(select id_pay from 9thleaf_pay_relation where customer_id = {$v['customer_id']})",false);
                    $row = $this->db->update("pay_account");
                    if(!$row){
                        $this->db->trans_rollback();
                        echo "返还货豆失败";exit;
                    }
                }
            }
            
            $row = $this->del_M_credit($v["id"]);//删除数据
            if(!$row){
                $this->db->trans_rollback();
                echo "删除失败";exit;
            }
        }
        
        if($status){
            $this->db->trans_commit();
            echo "删除成功，一共删除了70条货豆转移数据";
        }else{
            $this->db->trans_rollback();
            echo "确定删除70条货豆转移数据？";
        }
    }
    
    
    /**
     * 删除货豆记录
     * @param int $id 记录id
     */
    private function del_M_credit($id){
        $this->db->where("id",$id);
        $row = $this->db->delete("customer_currency_log");
        if(!$row){
            return false;
        }
        return true;
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 现金转货豆
     */
    function money(){
        $status = $this->input->post("status");//状态
        $this->db->from("charge_currency as a");
        $this->db->join("temp_money_log as b","a.id=b.id");
        //$this->db->where("id_event",66);
        $money = $this->db->get()->result_array();
        if(count($money) != 241){
            $this->db->trans_rollback();
            echo "删除失败，一共".count($money)."条现金转货豆记录,并不是指定的241条";exit;
        }
  
        $this->db->trans_begin();
        foreach ($money as $v){
        
                $this->db->set("cash","cash+{$v['amount']}",false);
                $this->db->set("M_credit","M_credit-{$v['amount']}",false);
                $this->db->where("id","(select id_pay from 9thleaf_pay_relation where customer_id = {$v['customer_id']})",false);
                $row = $this->db->update("pay_account");
                if(!$row){
                    $this->db->trans_rollback();
                    echo "返还货豆失败1";exit;
                }
            
            
            $this->db->where("charge_no",$v["charge_no"]);
            $row = $this->db->delete("customer_money_log");
            if(!$row){
                $this->db->trans_rollback();
                echo "返还货豆失败2";exit;
            }
            
            $this->db->where("order_no",$v["charge_no"]);
            $row = $this->db->delete("customer_currency_log");
            if(!$row){
                $this->db->trans_rollback();
                echo "返还货豆失败3";exit;
            }
            
            $this->db->where("id",$v["id"]);
            $row = $this->db->delete("charge_currency");
            if(!$row){
                $this->db->trans_rollback();
                echo "charge_currency失败";exit;
            }
        }
        
        
        
        if($status){
            $this->db->trans_commit();
            echo "删除成功，一共删除了241条现金转货豆记录";
        }else{
            $this->db->trans_rollback();
            echo "确定删除241条现金转货豆记录？";
        }

    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 查询用户id
     */
    function get_customerid(){
        $this->db->select("a.*,c.customer_id,c.id as relation_id");
        $this->db->from("pay_account as a");
        $this->db->join("temp_pay_account as b","a.id=b.id");
        $this->db->join("pay_relation as c","b.id = c.id_pay","left");
        $data = $this->db->get()->result_array();
        echo json_encode($data);
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 清理帐户红包->退款
     */
    function emptied_account_red(){
        $status = $this->input->post("status");//执行状态
        $amount = $this->input->post("amount");//退款金额
        $customer_id = $this->input->post("customer_id");//退款用户
        
        $this->db->trans_begin();
        $this->db->set("M_credit","M_credit-$amount",false);
        $this->db->where("id","(select id_pay from 9thleaf_pay_relation where customer_id = $customer_id)",false);
        $row = $this->db->update("pay_account");
        if(!$row){
            $this->db->trans_rollback();
            echo json_encode(array("status"=>2));//失败
        }

        if($status){
            $this->db->trans_commit();
            echo json_encode(array("status"=>1));//失败
        }else{
            $this->db->trans_rollback();
            echo json_encode(array("status"=>1));//失败
        }
    }
    
    //---------------------------------------------------------------------------------------------------
    
    /**
     * 清空账户
     */
    function  emptied_account(){
        $status = $this->input->post("status");//状态
        //查询用户
        $this->db->select("a.*,c.customer_id,c.id as relation_id");
        $this->db->from("pay_account as a");
        $this->db->join("temp_pay_account as b","a.id=b.id");
        $this->db->join("pay_relation as c","b.id = c.id_pay","left");
        $pay_list = $this->db->get()->result_array();

        if(count($pay_list) != 5){
            $this->db->trans_rollback();
            echo "删除失败，一共".count($pay_list)."个账户余额0.00，并非指定的103个账户";exit;
        }
    
    
        $this->db->trans_begin();
        foreach($pay_list as $v){
            //删除授信
            $this->db->where("relation_id",$v["relation_id"]);
            $row = $this->db->delete("customer_credit_log");
            if(!$row){
                $this->db->trans_rollback();
                echo "用户id为:".$v["customer_id"]."授信删除失败";exit;
            }
            
            //删除货豆log
            $this->db->where("relation_id",$v["relation_id"]);
            $row = $this->db->delete("customer_currency_log");
            if(!$row){
                $this->db->trans_rollback();
                echo "用户id为:".$v["customer_id"]."删除货豆log失败1";exit;
            }
            
            $this->db->where("customer_id",$v["customer_id"]);
            $row = $this->db->delete("customer_currency_log");
            if(!$row){
                $this->db->trans_rollback();
                echo "用户id为:".$v["customer_id"]."删除货豆log失败2";exit;
            }
            
            //删除货豆充值log
            $this->db->where("customer_id",$v["customer_id"]);
            $row = $this->db->delete("charge_currency");
            if(!$row){
                $this->db->trans_rollback();
                echo "用户id为:".$v["customer_id"]."删除货豆充值log失败";exit;
            }
            
            //删除现金log
            $this->db->where("customer_id",$v["customer_id"]);
            $row = $this->db->delete("customer_money_log");
            if(!$row){
                $this->db->trans_rollback();
                echo "用户id为:".$v["customer_id"]."删除现金log失败1";exit;
            }
            
            $this->db->where("relation_id",$v["relation_id"]);
            $row = $this->db->delete("customer_money_log");
            if(!$row){
                $this->db->trans_rollback();
                echo "用户id为:".$v["customer_id"]."删除现金log失败2";exit;
            }
            
            //清空账户
            $this->db->set("credit","0.00");
            $this->db->set("cash","0.00");
            $this->db->set("M_credit","0.00");
            $this->db->where("id",$v["id"]);
            $row = $this->db->update("pay_account");
            if(!$row){
                $this->db->trans_rollback();
                echo "支付账户id为:".$v["id"]."余额清除失败";exit;
            }
        }
        if($status){
            $this->db->trans_commit();
            echo "本次一共清除了103账户余额为0.00";
        }else{
            $this->db->trans_rollback();
            echo "确定清除103个账户余额为0.00吗？";
        }

    }
    
}

?>