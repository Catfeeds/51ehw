<?php
/*
 * 客户综合交易记录 
 * */
class Customer_log_mdl extends CI_Model {
    function __construct() {
        parent::__construct ();
    }
    
    /*
     * 交易记录
     * $limit 每页记录数
     * $offset 偏移量
     * */
    public function getLogByUserId($customer_id, $limit = 0, $offset = 0)
    {
        if (!$limit)
        {
            $limit = 10;
        }
        if (!$offset)
        {
            $offset = 0;
        }
        $sql="select create_user as customer_id,created_at as log_at,credit,ifnull(remarks,'授信充值') as reamrk from 9thleaf_corporation_credit_log where create_user=".$customer_id."
                union all select pr.customer_id,cc.created_at as log_at,amount as credit,remark from 9thleaf_customer_currency_log as cc left join 9thleaf_pay_relation as pr on cc.relation_id = pr.id where pr.customer_id=".$customer_id." and amount<>''
                union all select pr.customer_id,cm.created_at as log_at,cash as credit,remark from 9thleaf_customer_money_log as cm left join 9thleaf_pay_relation as pr on cm.relation_id = pr.id where pr.customer_id=".$customer_id."
                order by log_at desc limit ".$offset.",".$limit;
        $result = $this->db->query($sql)->result_array();
	    return $result;
    }
    
    //交易记录总数
    public function getLogCount($customer_id)
    {   
        $sql="select count(*) as amount from (select create_user as customer_id,created_at as log_at,credit,ifnull(remarks,'授信充值') as reamrk from 9thleaf_corporation_credit_log where create_user=".$customer_id."
                union all select pr.customer_id,cc.created_at as log_at,amount as credit,remark from 9thleaf_customer_currency_log as cc left join 9thleaf_pay_relation as pr on cc.relation_id = pr.id where pr.customer_id=".$customer_id." and amount<>''
                union all select pr.customer_id,cm.created_at as log_at,cash as credit,remark from 9thleaf_customer_money_log as cm left join 9thleaf_pay_relation as pr on cm.relation_id = pr.id where pr.customer_id=".$customer_id.")a";
        //返回数组
        $result = $this->db->query($sql)->result_array();
        return $result;
    }
}