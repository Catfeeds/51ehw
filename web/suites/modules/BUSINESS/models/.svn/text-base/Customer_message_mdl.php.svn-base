<?php
/**
 * 消息推送
 * @author fxm
 */

class Customer_message_mdl extends CI_Model {
    
    public $id;
    public $title;
    public $customer_id;
    public $obj_id;
    public $is_read;
    public $created_at;
    public $template_id;
    
    function __construct() {
        parent::__construct ();
    }
    
    
    /**
     * 时间消息处理
     * @data['template_id'] = 事件id;(必须)
     * @data['customer_id'] = 用户id;(必须)
     * @data['obj'] = 对象id;(有必要时)
     * @data['type'] = 消息类型(必须); 类型 1系统通知  2订单通知  3我的资产(优惠券)  4部落通知
     * @data['parameter'][自定义参数] = 自定义参数；
     * 
     */
    public function Create_Message( $data = array() )
    { 
        if( !empty( $data ) )
        {
            $temp_message = $this->Load_Message_Template( $data['template_id'] );
            
            if( $temp_message )
            { 
                $parameter = explode(',', $temp_message['parameter']);
                $message = $temp_message['message'];
                
                foreach ( $parameter as $k => $v )
                {
                    $message = str_replace("%{$v}%", $data['parameter']["{$v}"], $message );
                }
                
                
                //插入消息
                $this->title = $temp_message['name'];
                $this->template_id = $data['template_id'];
                $this->customer_id = $data['customer_id'];
                $this->obj_id = !empty( $data['obj_id'] ) ? $data['obj_id'] : 0;
                $this->type = $data['type'];
                $this->message = $message;
                $this->Create();
            }
        }
        
        return true;
    }
    
    /**
     * 创建
     */
    public function Create()
    { 
        if( !empty( $this->title ) )
            $this->db->set('title', $this->title );
        
        if( !empty( $this->customer_id ) )
            $this->db->set('customer_id', $this->customer_id );
        
        if( !empty( $this->obj_id ) )
            $this->db->set('obj_id', $this->obj_id );
        
        if( !empty( $this->message ) )
            $this->db->set('message', $this->message );
        
        if( !empty( $this->is_read ) )
            $this->db->set('is_read', $this->is_read );
        
        if( !empty($this->type) )
            $this->db->set('type',$this->type);
        if( !empty($this->template_id) )
            $this->db->set('template_id',$this->template_id);
        
        $this->db->set('created_at', date('Y-m-d H:i:s') );
        
        $this->db->insert('customer_message');
        return $this->db->insert_id();
        
        
    }
    /**
     * 根据事件ID查询消息模板
     */
    public function Load_Message_Template( $temp_id = 0)
    { 
        $query = $this->db->get_where('message_template ', array( 'template_id'=> $temp_id ) );
        return $query->row_array();
    }
    
    /**
     * 查询
     */
    public function Load_Customer_Message( $sift = array() )
    { 
        if( empty( $sift['where']['customer_id'] ) )
            return array();
        
        $this->db->select('cm.*');
        $this->db->from('customer_message as cm');
        $this->db->where('cm.customer_id',$sift['where']['customer_id']);
        $this->db->where('cm.is_detele',0);
        
       if(!empty( $sift['where']['tribe_id'] )){
            $this->db->join("message_template as mt","mt.template_id = cm.template_id","LEFT");
            $this->db->where("IF(cm.template_id != NULL, mt.type = 4  and cm. obj_id IN ({$sift['where']['tribe_id']}),true)",'',false);
        }
        
        //类型
        if( !empty ( $sift['where']['type'] ) )
            $this->db->where('cm.type',$sift['where']['type']);

        
//         //页数
//         if( !empty( $sift['page']['limit'] ) )
//             $this->db->limit( $sift['page']['limit']);  
        
//         //偏移量
//         if( !empty( $sift['page']['offset'] ) )
//             $this->db->offset( $sift['page']['offset']);
        

        //分页
        if(!empty($sift['page']['limit'])){
            $this->db->limit($sift['page']['limit'],$sift['page']['offset']);
        }
       

        //开始时间
        if( !empty($sift['where']['start_time']) )
            $this->db->where('cm.created_at >=',$sift['where']['start_time'] );
            
        //结束时间
        if( !empty( $sift['where']['end_time'] ) )
            $this->db->where('cm.created_at <=',$sift['where']['end_time'] );
        
        
        if( !empty($sift['like']['title']) )
            $this->db->like('cm.title',$sift['like']['title']);
        
        if( !empty($sift['where']['read']) )
            $this->db->where("cm.is_read",0);//未阅读
        
        $this->db->order_by('cm.id','desc');
        $query = $this->db->get();
      
        return $query->result_array();
    }
    
    public function Load_Customer_MessageCount( $sift = array() )
    {
     
        if( empty( $sift['where']['customer_id'] ) )
            return array();
    
            $this->db->select('*');
            $this->db->from('customer_message');
            $this->db->where('customer_id',$sift['where']['customer_id']);
    
            //类型
            if( !empty ( $sift['where']['type'] ) )
                $this->db->where('type',$sift['where']['type']);

            //开始时间
            if( !empty($sift['where']['start_time']) )
                $this->db->where('created_at >=',$sift['where']['start_time'] );

            //结束时间
            if( !empty( $sift['where']['end_time'] ) )
                $this->db->where('created_at <=',$sift['where']['end_time'] );


            if( !empty($sift['like']['title']) )
                $this->db->like('title',$sift['like']['title']);

            if( !empty($sift['where']['read']) )
                $this->db->where("is_read",0);//未阅读
                
                
            $res = $this->db->count_all_results();
            return $res;
    }
    
    
    //获取信息中心
    
    public function get_Lists($customer_id,$section){
       
        $this->db->select("*");
        $this->db->where('customer_id',$customer_id);
        $this->db->where_in('type',$section);
//         $this->db->where('is_read',0);
        $this->db->where('is_detele',0);
        $this->db->order_by("created_at DESC");
        $this->db->from('customer_message');
        return $this->db->get()->result_array();
    }
    
    
    public function  check_read($customer_id){
        $this->db->select("*");
        $this->db->where('customer_id',$customer_id);
        $this->db->where('is_read',0);
        $this->db->where('is_detele',0);
        $this->db->from('customer_message');
        return $this->db->get()->result_array();
    }
    
    //更新
    public function Update()
    { 
        if( empty( $this->id ) )
            return array();
        
        if( !empty( $this->is_read ) )
            $this->db->set('is_read',$this->is_read);
        if( !empty( $this->is_detele ) )
            $this->db->set('is_detele',$this->is_detele);
        
        if( is_array( $this->id ) )
        {
            $this->db->where_in('id', $this->id );
        }else{ 
            $this->db->where('id',$this->id );
        }
        
        $this->db->where('customer_id',$this->customer_id);
        $this->db->update('customer_message');
        
        return $this->db->affected_rows();
    }
   
    /**
     * 统计一些状态+条件的条数
     */
    public function Count_Num( $sift )
    { 
        $this->db->select('count( is_read = 0 or null ) as not_read,count(id) as total');
        $this->db->from('customer_message');
        $this->db->where('customer_id',$sift['where']['customer_id']);
        $this->db->where('is_detele',0);
        //类型
        if( !empty ( $sift['where']['type'] ) )
            $this->db->where('type',$sift['where']['type']);
        
        //开始时间
        if( !empty($sift['where']['start_time']) )
            $this->db->where('created_at >=',$sift['where']['start_time'] );
            
        //结束时间
        if( !empty( $sift['where']['end_time'] ) )
            $this->db->where('created_at <=',$sift['where']['end_time'] );
    
            
        if( !empty($sift['like']['title']) )
            $this->db->like('title',$sift['like']['title']);
            
        $query = $this->db->get();
        return $query->row_array();
        
    }

    public function update_batch($user_id,$type){
        $this->db->set('is_read',1);
        $this->db->where("customer_id",$user_id);
        $this->db->where("is_read",0);//未阅读
        $this->db->where("is_detele",0);//未删除
        $this->db->where("type",$type);//类型
        $this->db->update('customer_message');
        return $this->db->affected_rows();
    }
    
    

}