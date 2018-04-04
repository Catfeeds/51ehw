<?php
/**
 * 常见问题
 *
 * 
 */
class Cash_shop_mdl extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    // --------------------------------------------------------------------

    
    /**
     * 查询。
     */
    public function Load( $sift )
    { 
        if( isset( $sift['where']['customer_id']) )
            $this->db->where('customer_id',$sift['where']['customer_id']);
        
        if( isset( $sift['where']['status']) )
            $this->db->where('status',$sift['where']['status']);
        
        $query = $this->db->get('cash_shop');
        return $query->row_array();
    }
    
    
    /**
     * 添加。
     */
    public function Created( $data )
    { 
        $this->db->insert('cash_shop',$data);
	    return $this->db->insert_id();
    }
    
    /**
     * 更新。
     */
    public function Update( $sift )
    {
        if( isset( $sift['set']['status'] ) )
            
        $this->db->set('status',$sift['set']['status']);
        $this->db->where('id',$sift['where']['id']);
        $this->db->where('customer_id',$sift['where']['customer_id']);
        $this->db->update('cash_shop');
        return $this->db->affected_rows();
    }
    
    
    /**
     * 开店处理（pay_return_config_helper 中已经配置该方法名，如需改动则两边修改）
     * @date:2017年12月19日 下午2:44:04
     * @author: fxm
     * @param: $charge = charge 查询出来的信息。 $trade_no = 第三方支付单号
     * @return:
     */
    public function after_cash_shop( $charge, $trade_no,$payment_name = '银联支付')
    {
    
        if ( $charge && $trade_no )
        {
            if( $charge['status'] == 1 )
            {
                return true; //已经充值过
            }
             
            $out_trade_no = $charge['chargeno'];
    
            $this->db->trans_begin(); //事物执行方法中的MODEL
    
            //修改订单状态为已支付
            $this->load->model('charge_mdl');
            $charge_row = $this->charge_mdl->chargeno_update_pay ( $out_trade_no,$payment_name.'开店',$trade_no );
    
            //如果该订单状态修改成功 才执行
            if ( $charge_row )
            {
                $charge['trade_no'] = $trade_no;//微信支付单号。
                $charge['payment_name'] = $payment_name;
                
                $result = $this->Cash_shop( $charge );
                 
                //事物结束
                if ( $result['status'] == 1 )
                {
                    $this->db->trans_commit();
                    return true;
                }
                 
                $this->db->trans_rollback();
    
            } else {
                //该订单可能已支付过
                error_log('开店charge处理失败,charge_no:'.$out_trade_no);
                $this->db->trans_rollback();
                return false;
            }
    
        } else {
            error_log('参数错误'.$out_trade_no);
            return false;
        }
    
        return false;
    }
    
    
    /**
     * 处理整个开店流程。
     * @ $charge_info[key];
     * @ key customer_id = 用户ID。
     * @ key chargeno = 发起支付的单号。
     * @ key trade_no = 第三方返回的单号。
     * @ key payment_name = 第三方充值平台名称。
     * @ key amount = 金额;
     */
    public function Cash_Shop( $charge_info = array() )
    {
        
        $return['message'] = '用户ID:'.$charge_info['customer_id'].'开店支付失败';
        $return['status'] = false;
        
        // 查询店铺信息
        $this->load->model('customer_corporation_mdl');
        $corp_info = $this->customer_corporation_mdl->load( $charge_info['customer_id'] );
         
        $row = true;
         
        //如果店铺生成了才需要更新。
        if( $corp_info )
        {
            //如果支付金额和店铺保证金一致
            if( $charge_info['amount'] == $corp_info['deposit'] )
            {
                //修改店铺相关状态
                $row = $this->customer_corporation_mdl->customer_corporation_update( $corp_info['id'] );
                
            }else{ 
                
                $return['message'] = '支付金额和店铺记录保证金不一致';
                $return['status'] = false;
                $row = false;
            }
        }
        
        if( $row )
        {
            
            //手机号码
            $data['customer_id'] = $charge_info['customer_id'];
            $data['corporation_id'] = !empty( $corp_info['id'] ) ? $corp_info['id'] : '';
            $data['charge_no'] = $charge_info['chargeno'];
            $data['cash'] = $charge_info['amount'];
            $data['transaction_no'] = $charge_info['trade_no'];
            $data['payment_name'] = $charge_info['payment_name'];
            $data['remarks'] = !empty( $corp_info['id'] ) ? '已缴费' : '已缴费-未生成店铺';
            $data['status'] = !empty( $corp_info['id'] ) ? 1 : 0;
            $data['created_at'] = date("Y-m-d H:i:s");

            $this->db->insert("cash_shop",$data);
            $cash_shop_id = $this->db->insert_id();
        
            if ( $cash_shop_id )
            {
                $return['message'] = '支付成功';
                $return['status'] = 1;
            } 
        }
        
        error_log($return['message']);
        return $return;
    }    
    
    
    
    
}