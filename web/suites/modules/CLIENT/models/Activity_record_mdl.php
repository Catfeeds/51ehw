
    <?php
/**
 * 
 *
 *
 */
class Activity_record_mdl extends CI_Model {
    var $id;
    var $activity_num;
    var $type;
    var $product_id;
    var $start_time;
    var $end_time;
    var $status;
    var $groupbuy_price;
    var $menber_num;
    var $corporation_id;
    var $remarks;
    var $set_limit;
    var $least_purchase;
    var $most_purchase;
	function __construct() {
		parent::__construct ();
	}

	/**
	 * 拼团可创建的商品
	 * @$corporation_id = 店铺ID
	 * @$product; //如果有传商品ID就代表查询某一个商品是否可以设置为拼团商品 查的出-代表可以。
	 */
	public function add_groupbuy_product($corporation_id,$product=null){
	   $date = date('Y-m-d H:i:s');
	   $this->db->select('p.id,p.name');
	   $this->db->from('product as p');
	   $this->db->join('activity_record as ar','p.id = ar.product_id','left');
	   $this->db->where('p.is_on_sale','1');
	   $this->db->where('p.corporation_id',$corporation_id);
	   $this->db->where("(p.is_groupbuy = '0' or p.groupbuy_end_at < '$date' or p.groupbuy_end_at is null)");
	   $this->db->where("(ar.end_time < '$date' or ar.end_time is null)");
	   $this->db->where("(ar.status = 1 or ar.status is null)");
	   $this->db->group_by("p.id");
	   if( !empty($product) )
	       $this->db->where('p.id',$product);
	   $query = $this->db->get();
	   return !empty($product) ? $query->row_array() : $query->result_array();
	}	
	
	
	/**
	 * 创建活动审核
	 * 
	 */
	public function add_approve_activity(){
	    $this->db->set('activity_num',$this->activity_num);
	    $this->db->set('type',$this->type);
	    $this->db->set('product_id',$this->product_id);
	    $this->db->set('start_time',$this->start_time);
	    $this->db->set('end_time',$this->end_time);
	    $this->db->set('status',$this->status);
	    $this->db->set('groupbuy_price',$this->groupbuy_price);
	    $this->db->set('menber_num',$this->menber_num);
	    $this->db->set('corporation_id',$this->corporation_id);
	    $this->db->set('remarks',$this->remarks);
	    $this->db->set('set_limit',$this->set_limit);
	    if($this->set_limit == 1){ 
	        $this->db->set('least_purchase',$this->least_purchase);
	        $this->db->set('most_purchase',$this->most_purchase);
	    }
	    $this->db->insert ( 'activity_record' );
	    return $this->db->insert_id();
	}
	
	/**
	 * 获取活动信息列表
	 * @$sift = 数组条件
	 */
	public function load($corporation_id,$sift = array(),$offset=null, $num=null){ 
	    $this->db->select('ar.*,p.name');
	    $this->db->from('activity_record as ar');
	    $this->db->join('product as p','ar.product_id = p.id');
	    $this->db->where('ar.corporation_id',$corporation_id);
	    
	    if(isset( $sift['id']) )
	        $this->db->where('ar.id',$sift['id']);
	    if(isset( $sift['status']) )
	        $this->db->where_in('ar.status',$sift['status']);//数组
	    if(isset( $sift['start_time']) && $sift['start_time'] == '>')
	        $this->db->where('ar.start_time >',date('Y-m-d H:i:s') );
	    
	    if(isset( $sift['end_time']) && $sift['end_time'] == '>')
	        $this->db->where('ar.end_time >',date('Y-m-d H:i:s') );
	    
	    if(isset( $sift['end_time']) && $sift['end_time'] == '<')
	        $this->db->where('ar.end_time <',date('Y-m-d H:i:s') );
	    
	    if($num)//分页
	        $this->db->limit($num,$offset);
	    
	    if(isset( $sift['id_array']) )
	        $this->db->where_in('ar.id',$sift['id_array']);
	    
	    if(isset( $sift['search_name'] ) )
	        $this->db->like('p.name',$sift['search_name']);
	    
	    $this->db->order_by('ar.id','desc');
	    $query = $this->db->get();
    
	    //根据状态判断返回什么格式
	    if(isset( $sift['row']) ){
	        $result = $query->row_array();
	    }elseif(isset($sift['count']) ){
	        $result = $query->num_rows();
	    }else{
	        $result = $query->result_array();
	    }
	    
	    return $result;
	}
	
	/**
	 * 修改活动信息
	 */
	public function update_approve_activity(){ 
	    $this->db->set('type',$this->type);
	    $this->db->set('start_time',$this->start_time);
	    $this->db->set('end_time',$this->end_time);
	    $this->db->set('status',$this->status);
	    $this->db->set('groupbuy_price',$this->groupbuy_price);
	    $this->db->set('menber_num',$this->menber_num);
	    $this->db->set('remarks',$this->remarks);
	    $this->db->set('set_limit',$this->set_limit);
	    if($this->set_limit == 1){
	        $this->db->set('least_purchase',$this->least_purchase);
	        $this->db->set('most_purchase',$this->most_purchase);
	    }
	    
	    $this->db->where('product_id',$this->product_id);
	    $this->db->where('corporation_id',$this->corporation_id);
	    $this->db->where('id',$this->id);
	    $this->db->where('(status = 2 or status = 4)');
	    
	    return $this->db->update ( 'activity_record' );
	}
	
	/**
	 * 提交申请
	 */
	public function update_approve_status(){ 
	    $this->db->set('status','3');
	    $this->db->where('id',$this->id);
	    $this->db->update ( 'activity_record' );
	    return $this->db->affected_rows();
	}
	
	/**
	 * 批量修改
	 */
	public function update_batch($data){
    	@$this->db->update_batch('activity_record', $data, 'id');
    	return $this->db->affected_rows();
	}
	
	/**
	 * 某个活动下面的详细订单列表
	 * @$corp_id = 店铺ID；
	 * @activity_num = 活动编号
	 */
	public function activity_order_list($corp_id,$activity_num){ 
	    $this->db->select('o.id,g.enddate,g.activity_num, g.buy_num, c.name, o.place_at, g.status');
	    $this->db->from('groupbuy as g');
	    $this->db->join('order as o',' g.buy_num = o.activity_id');
	    $this->db->join('customer as c','o.customer_id = c.id');
	    $this->db->where('o.corporation_id',$corp_id);
	    $this->db->where('g.activity_num',$activity_num);
	    $this->db->where('o.status !=',10);
	    $query = $this->db->get();
	    return $query->result_array();
	}
}
 