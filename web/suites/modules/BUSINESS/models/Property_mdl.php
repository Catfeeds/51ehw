<?php
/**
 * 
 * 我的资产
 *
 */
class Property_mdl extends CI_Model
{

	function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 我的资产
     * $user_id = 用户ID
     */
    public function get_list( $user_id , $status='', $offset, $num){ 
        $this->db->select('*')->from('charge')->where("customer_id = $user_id");
        switch ($status){ 
            case 'pay':
                $this->db->where('status = 1');
                break;
            case 'no_pay':
                $this->db->where('status = 0');
        }
        $this->db->limit($num,$offset);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    /**
     * 统计记录的条数
     * $user_id = 用户ID 
     * $status= 状态
     */
    public function count_property( $user_id ,$status='' ){ 
        $this->db->select('id')->from('charge')->where("customer_id = $user_id");
        switch ($status){
            case 'pay':
                $this->db->where('status = 1');
                break;
            case 'no_pay':
                $this->db->where('status = 0');
        }
        return $this->db->count_all_results();
        
    }
    
    /**
     * 生成充值订单
     */
    function create(){
        
        $datetime = date( 'Y-m-d H:i:s' );
        $this->db->set( 'customer_id',$this->customer_id );
        $this->db->set( 'amount',$this->amount );
        $this->db->set( 'chargeno',$this->chargeno );
        $this->db->set( 'status',$this->status );
        $this->db->set( 'create_date',$datetime);
        
        $res = $this->db->insert( 'charge' );
        
        if($res){
            return $this->db->insert_id();
        }
        
    }
    
    /**
     * 更新充值订单状态
     */
    function update( $id='' ){
        
        $date = date( 'Y-m-d H:i:s' );
        if( $this->amount )
            $this->db->set( 'customer_id' ,$this->customer_id );
        if( $this->status && $this->status==1 ){
            $this->db->set( 'status' ,$this->status );
            $this->db->set( 'pay_date' ,$date );
        }else{
            $this->db->set( 'status' ,$this->status );
        }
        if( $this->payment_id )
            $this->db->set( 'payment_id' ,$this->payment_id );
        if( $this->remark )
            $this->db->set( 'remark' ,$this->remark );
        $res = $this->db->where( 'charge' );
        
        if(isset($res)){
            return $id;
        }else{
            return $res;
        }
        
    }
    
    /**
     * 获取充值订单
     * $id
     */
    function load($id=''){
        
        if(!$id){
            return array();
        }
        $query = $this->db->get_where( 'charge',array(
            'id'=>$id,
        ));
        if($res = $query->row_array()){
            return $res;
        }
        return array();
    }
    
    /**
     * 删除订单
     */
    function deleted($id='',$type=''){
        
        if($type)
            $this->db->where( 'status != "1"' );
        $this->db->where( 'id' ,$id );
        
        $res = $this->db->delete( 'charge' );
        
        return $res;
        
    }
    
    /**
     * 获取未支付所有订单
     */
    function get_nopay(){
        
        $query = $this->db->get_where( 'charge' ,array(
            'stauts'=>0,
        ));
        if($res = $query->row_array()){
            return $res;
        }
        return array();
        
    }

}