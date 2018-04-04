<?php
/**
 * 商品
 *
 *
 */
class Order_comments_mdl extends CI_Model {

	var $orderitem_id;
	var $product_score;
	var $service_score;
	var $content;


	function __construct() {
		parent::__construct ();
	}
	
	// --------------------------------------------------------------------
	
    /**
     * 查询评论
     */
	function find_comments($corporation_id ,$count = '', $offset = '',$condition='',$type=''){

	    $this->db->select('oc.*,oi.order_id,oi.product_id,oi.product_name,oi.sku_id,o.order_sn,c.name');
	    $this->db->from('order_comments as oc');
	    $this->db->join('order_item as oi','oc.orderitem_id = oi.id','left');
	    $this->db->join('order as o','oi.order_id = o.id','left outer');
	    $this->db->join('customer as c','oc.create_by = c.id','left outer');
	    $this->db->where('o.is_delete =  0');
	    $this->db->where('o.corporation_id = '.$corporation_id);
	    $this->search($condition,$type);
	    $this->db->limit ( ( int ) $count, ( int ) $offset );
	    $query=$this->db->order_by('oc.create_at','desc')->get();
	    return $query->result_array();
	           
	}

	// --------------------------------------------------------------------
	
	/**
	 * 查询评论总数
	 */
	function all_comments($corporation_id ,$count = '', $offset = '',$condition='',$type=''){

	    $this->db->select('oc.*,oi.order_id,oi.product_id,oi.product_name,oi.sku_id,o.order_sn,c.name');
	    $this->db->from('order_comments as oc');
	    $this->db->join('order_item as oi','oc.orderitem_id = oi.id','left');
	    $this->db->join('order as o','oi.order_id = o.id','left outer');
	    $this->db->join('customer as c','oc.create_by = c.id','left outer');
	    $this->db->where('o.is_delete =  0');
	    $this->db->where('o.corporation_id = '.$corporation_id);
	    $this->search($condition,$type);
	    $query=$this->db->order_by('oc.create_at','DESC')->get();
// 	    echo $this->db->last_query();exit;
	    return count($query->result_array());
	
	}
	
	function search($condition='',$type=''){
	    if($type == 1){
	        $this->db->where('oc.reply_by is null');
	    }else if($type == 2){
	        $this->db->where('oc.reply_by is not null');
	    }
	    if(isset($condition['product_name']) && $condition['product_name'] != ''){
	        $this->db->like('oi.product_name',$condition['product_name']);
	    }
	    if(isset($condition['product_id']) && $condition['product_id'] !=''){
	        $this->db->where('oi.product_id',$condition['product_id']);
	    }
	    if(isset($condition['start_time']) && $condition['start_time'] != ''){
	        $this->db->where('oc.create_at >=',$condition['start_time']);
	    }
	    if(isset($condition['end_time']) && $condition['end_time'] != ''){
	        $this->db->where('oc.create_at <=',$condition['end_time']);
	    }
	    if(isset($condition['content']) && $condition['content'] != ''){
	        $this->db->like('oc.content',$condition['content']);
	    }
	    if(isset($condition['username']) && $condition['username'] != ''){
	        $this->db->like('c.name',$condition['username']);
	    }
	    if(isset($condition['product_score']) && $condition['product_score'] != ''){
	        $this->db->where('oc.product_score',$condition['product_score']);
	    }
	    if(isset($condition['order_sn']) && $condition['order_sn'] != ''){
	        $this->db->like('o.order_sn',$condition['order_sn']);
	    }
	    if(isset($condition['reply']) && $condition['reply'] != '' && $condition['reply'] > 0 && $condition['reply'] == 1){
	        $this->db->where('oc.reply_by is not null');
	    }
	    if(isset($condition['reply']) && $condition['reply'] != '' && $condition['reply'] > 0 && $condition['reply'] == 2){
	        $this->db->where('oc.reply_by is null');
	    }
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 回复评论
	 */
	function reply(){
	    
	    $datetime = date('Y-m-d H:i:s');
	    $this->db->set('reply_content',$this->reply_content);
	    $this->db->set('reply_by',$this->reply_by);
	    $this->db->set('reply_at',$datetime);
	    $this->db->where('id',$this->id);
	    
	    if($this->db->update('order_comments')) return 1;
	    else return 0;
	}
	
	// --------------------------------------------------------------------
	
    /**
     * 审核
     */
	function examine(){
	    
	    $this->db->set('status',1);
	    $this->db->where('id',$this->id);
	    
	    if($this->db->update('order_comments')) return 1;
	    else return 0;
	    
	}
	
	// --------------------------------------------------------------------
	
    /**
     * 个人中心-我的评论
     */
	public function my_comment( $user_id , $status, $offset, $num,$order_id = '',$details=''){ 

	    $this->db->select('OI.*,OC.id as comments_id, O.place_at, P.name,P.goods_thumb');
	    $this->db->from('order as O, order_item as OI, product as P');
	    $this->db->join('order_comments as OC','OI.id = OC.orderitem_id','left');
	    $this->db->where('OI.product_id = P.id and O.status in (7,9,14) and O.id = OI.order_id and O.customer_id = '.$user_id);
	    switch ($status){ 
	        case 'already':
	            $this->db->where('OC.orderitem_id = OI.id');
	            break;
	        case 'not':
	            $this->db->where('OC.id is null');
	            if(!empty($order_id) && $order_id>0)$this->db->where('O.id',$order_id);
                break;
            case 'details':
                if(!empty($order_id) && $order_id>0)$this->db->where('O.id',$order_id);
                break;
	    }
	    $this->db->order_by('O.place_at','desc');
	    if(empty($details)){
	       $this->db->limit($num, $offset);
	    }
	    $query  = $this->db->get();
// 	    echo $this->db->last_query();
	$result = $query->result_array();
	return $result;
	    
	}
	// --------------------------------------------------------------------
	
	/**
	 * 统计评论条数
	 */
	public function count_comment($user_id, $status){ 
	    $this->db->select('OI.id');
	    $this->db->from('order as O, order_item as OI, product as P');
	    $this->db->join('order_comments as OC','OI.id = OC.orderitem_id','left');
	    $this->db->where('OI.product_id = P.id');
	    $this->db->where('O.id = OI.order_id');
	    $this->db->where('O.customer_id',$user_id);
	    $this->db->where_in('O.status',array('7','9','14'));
	    switch ($status){
	        case 'already':
	            $this->db->where('OC.orderitem_id = OI.id');
	            break;
	        case 'not':
	            $this->db->where('OC.id is null');
	            break;
	    }
// 	    echo $this->db->last_query();
	    return $this->db->count_all_results();
	}
	// --------------------------------------------------------------------
	/**
	 * 增加商品评论
	 */
	public function increase_comment( $data ){ 
	    $this->db->set('orderitem_id',$data['id']);
	    $this->db->set('product_score',$data['mark']);
	    $this->db->set('content',$data['comment']);
	    $this->db->set('create_by',$data['user_id']);
	    $this->db->set('create_at',date('Y-m-d H:i:s') );
	    $this->db->set('status',0);
	    $this->db->insert('order_comments');
	    return $this->db->insert_id();
	}

	
	// --------------------------------------------------------------------
	/**
	 * 统计已经评价的条数
	 */
	public function count_yes_comment( $user_id ){ 
	    $this->db->select('OI.id');
	    $this->db->from('order as O, order_item as OI, product as P');
	    $this->db->join('order_comments as OC','OI.id = OC.orderitem_id','left');
	    $this->db->where('OI.product_id = P.id  and O.id = OI.order_id and O.customer_id = '.$user_id);
	    $this->db->where('OC.orderitem_id = OI.id');
	    $this->db->where_in('O.status',array('7','9',14));
	    
	    return $this->db->count_all_results();
	}

	
	// --------------------------------------------------------------------
	/**
	 * 统计未评价的条数
	 */
	public function count_no_comment( $user_id ){ 
	    $this->db->select('OI.id');
	    $this->db->from('order as O, order_item as OI, product as P');
	    $this->db->join('order_comments as OC','OI.id = OC.orderitem_id','left');
	    $this->db->where('OI.product_id = P.id  and O.id = OI.order_id and O.customer_id = '.$user_id);
	    $this->db->where('OC.id is null');
	    $this->db->where_in('O.status',array('7','9',14));
	    return $this->db->count_all_results();
	}
    
    /**
     * 统计全部评价
     */
	public function count_all_commnet( $user_id){
	    $this->db->select('OI.id');
	    $this->db->from('order as O, order_item as OI, product as P');
	    $this->db->join('order_comments as OC','OI.id = OC.orderitem_id','left');

	    $this->db->where('OI.product_id = P.id');
	    $this->db->where('O.id = OI.order_id');
	    $this->db->where('O.customer_id',$user_id);
	    $this->db->where_in('O.status',array('7','9','14'));

	    
        
	    return $this->db->count_all_results();
	}
	
	// --------------------------------------------------------------------
	/**
     * 商品评价
     */
	public function shop_commnet( $shop_id,$status){ 
	    $this->db->select('c.content,c.create_at,c.product_score,d.name,e.place_at,c.id,c.reply_content');
	    $this->db->from('product a');
	    $this->db->join('order_item b','b.product_id=a.id');
	    $this->db->join('order_comments c','c.orderitem_id=b.id');
	    $this->db->join('customer d','d.id=c.create_by');
	    $this->db->join('order e','e.id=b.order_id');
	    $this->db->where("a.id",$shop_id);
	    $this->db->where("c.status",1);
	    switch ($status){
	        case 2:
	            $where = array(4,5);
	            $this->db->where_in("c.product_score",$where);
	        break;
	        case 3:
	            $where = array(2,3);
	            $this->db->where_in("c.product_score",$where);
	        break;
	        case 4:
	            $this->db->where("c.product_score",'1');
	        break;
	    }
	    $query = $this->db->get();
	    $result = $query->result_array();
        return $result;
	}
	

	
	// --------------------------------------------------------------------
	
	/**
	 * 统计全部商品评价
	 */
	public function all_commnet($shop_id){
	    $this->db->from('product a');
	    $this->db->join('order_item b','b.product_id=a.id');
	    $this->db->join('order_comments c','c.orderitem_id=b.id');
	    $this->db->where("c.status",1);
	    $this->db->where('a.id',$shop_id);
	    return ($this->db->count_all_results());
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 统计商品好评
	 */
	public function good_commnet($shop_id){
	    $this->db->from('product a');
	    $this->db->join('order_item b','b.product_id=a.id','left');
	    $this->db->join('order_comments c','c.orderitem_id=b.id','left');
	    $this->db->where('a.id',$shop_id);
	    $this->db->where("c.status",1);
	    $where = array(4,5);
	    $this->db->where_in("c.product_score",$where);
	    return ($this->db->count_all_results());
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 统计商品中评
	 */
	public function in_commnet($shop_id){
	    $this->db->from('product a');
	    $this->db->join('order_item b','b.product_id=a.id','left');
	    $this->db->join('order_comments c','c.orderitem_id=b.id','left');
	    $this->db->where('a.id',$shop_id);
	    $this->db->where("c.status",1);
	    $where = array(2,3);
	    $this->db->where_in("c.product_score",$where);
	    return ($this->db->count_all_results());
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 统计商品差评
	 */
	public function bad_commnet($shop_id){
	    $this->db->from('product a');
	    $this->db->join('order_item b','b.product_id=a.id','left');
	    $this->db->join('order_comments c','c.orderitem_id=b.id','left');
	    $this->db->where('a.id',$shop_id);
	    $this->db->where("c.status",1);
	    $this->db->where("c.product_score",1);
	    return ($this->db->count_all_results());
	}
	
	// --------------------------------------------------------------------
    /**
     * app增加评论
     */
	public function create(){
	    $this->db->set('orderitem_id',$this->orderitem_id);
	    $this->db->set('product_score',$this->product_score);
	    $this->db->set('content',$this->content);
	    $this->db->set('create_by',$this->create_by);
	    $this->db->set('create_at',date('Y-m-d H:i:s') );
	    $this->db->insert('order_comments');
	    return $this->db->insert_id();
	}
	
	/**
	 * app查询该商品是否评论
	 */
	public function check_iscomment($orderitemid){
	    
	    if($orderitemid==null)
	        return NULL;
	    $query = $this->db->get_where('order_comments',array(
	        'orderitem_id' =>$orderitemid,
	    ));
	    
	    if($query->result_array())
	        return true;
	    else return NULL;
	}
	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

	
	// --------------------------------------------------------------------
	

}