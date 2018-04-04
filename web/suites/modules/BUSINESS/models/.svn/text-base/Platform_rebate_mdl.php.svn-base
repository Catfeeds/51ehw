<?php
/**
 * 
 * 购物车模型
 *
 */
class Platform_rebate_mdl extends CI_Model {
	
    	

	function __construct() {
		parent::__construct ();
		
	}
	
	//-------------------------------------------------
	
    function getList($id,$desc=null,$condition = array(),$status=false,$limit=null,$offset=null){
        
       //$date = date("Y-m");
       
       $select = "a.*,pr.id as prid,pr.rebate_rate,pr.total,pr.rebate,pr.rebate_type,pr.created_at as creat,c.id as cid,".
       "c.nick_name,cc.id as ccid,cc.corporation_name,o.order_sn,o.total_price,orr.id as orrid,orr.rebate_1,orr.total_price,orr.create_date,cp.name as parent";
       
       $this->_pub($select);
       
       switch ($desc){
           case "rebate_big" :
               $this->db->order_by("pr.rebate","desc");
               break;
           case "rebate_small" :
               $this->db->order_by("pr.rebate","asc");
               break;
           case "time_big" :
               $this->db->order_by("pr.created_at","desc");
               break;
           case "time_small" :
               $this->db->order_by("pr.created_at","asc");
               break;
           default:
               $this->db->order_by("cc.corporation_name","desc");
               $this->db->order_by("pr.rebate","desc");               
               break;
       }
       
       
       
       if(isset($condition["type"])&&$condition["type"]){
           switch ($condition["type"])
           {
               case 1 :
                   $this->db->where("pr.rebate_type",1);
                   break;
               case 2 : 
                   $this->db->where("pr.rebate_type",2);
                   break;
           }
           //$this->db->where("pr.created_at >= '".$condition["start_time"]."' and pr.created_at <= '".$condition["end_time"]."'" );
       }
       
       if(isset($condition["select"])){
           foreach ($condition as $key => $v){
               switch ($key){
                   case "order_sn":
                       $this->db->where("o.order_sn",$v);
                       break;
                   case "corporation_name": 
                       $this->db->where("cc.corporation_name",$v);
                       break;
               }
           }
       }
       
       if($status)
       {
           $this->db->where("pr.rebate_type",2);
       }

        $this->db->where("pr.created_at >= '".$condition["start_time"]."' and pr.created_at <= '".$condition["end_time"]."'" );


       if ($limit)
            $this->db->limit($limit);
       if ($offset)
            $this->db->offset($offset);
       $query = $this->db->where("a.id",$id)->get();
       //echo $this->db->last_query();exit;
       if($row = $query->result_array()){
           return $row;
       }
       
       return array();
       
        
    }
    
    function countRebate($id,$desc=null,$condition=null){
    
        //$date = date("Y-m");
         
        $select = "a.*,pr.id as prid,pr.rebate_rate,pr.total,pr.rebate,pr.rebate_type,pr.created_at as creat,c.id as cid,".
            "c.nick_name,cc.id as ccid,cc.corporation_name,o.order_sn,o.total_price,orr.id as orrid,orr.rebate_1,orr.total_price,orr.create_date,cp.name as parent";
         
        $this->_pub($select);
        if(isset($condition["start"])&&$condition["start"]!=null&&$condition["start"]!=""&&isset($condition["end"])&&$condition["end"]!=null&&$condition["end"]!=""){
            $this->db->where("pr.created_at >= '".$condition["start"]."' and pr.created_at <= '".$condition["end"]."'" );
        }

        $query = $this->db->where("a.id",$id)->get();
        //echo $this->db->last_query();exit;
        if($row = $query->result_array()){
            return $row;
        }
         
        return array();
         
    
    }
    
 
    
    public function _pub($select){
        
        $this->db->select($select);
        $this->db->from("agent as a");
        $this->db->join("platform_rebate as pr","a.id = pr.obj_id and pr.obj_type = 3","left outer");    
        $this->db->join("customer_corporation as cc","cc.id = pr.corporation_id","left outer");
        $this->db->join("order_rebate as orr","pr.order_id = orr.orderid and pr.rebate_type = 2","left outer");
        $this->db->join("order as o","o.id = pr.order_id","left outer");       
        $this->db->join("customer as c","cc.customer_id = c.id","left outer");
        $this->db->join("customer as cp","cp.id = c.parent_id","left outer");
        
    }
    
    /**
     * 插入分成
     */
    public function add( $data, $total,$order_id, $corporation_id,$rebate_type){ 
        $this->db->set('obj_id',$data['obj_id']);
        $this->db->set('obj_type',$data['obj_type']);
        $this->db->set('rebate_rate',$data['rebate_rate']);
        $this->db->set('total',$total);
        $this->db->set('rebate',$data['rebate']);
        $this->db->set('rebate_type',$rebate_type);
        $this->db->set('order_id',$order_id);
        $this->db->set('corporation_id',$corporation_id);
        $this->db->set('created_at',date('Y-m-d H:i:s') );
        $this->db->insert('platform_rebate');
        return $this->db->insert_id();
    }

}