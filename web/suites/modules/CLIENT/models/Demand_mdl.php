<?php
/**
 *  需求模块
 *
 *
 */
class Demand_mdl extends CI_Model {
    var $explain;
    var $title;
    var $number;
    var $unit;
    var $price_min;
    var $price_max;
    var $receiptdate;
    var $effectdate;
    var $address;
    var $needtax;
    var $price_demand;
    var $m_price;
    var $cate_id;
    var $img_path;
    var $search_val;
    var $cateid_array;
    var $app_id;
    var $province_id;
    var $city_id;
    var $district_id;
	
	function __construct() {
		parent::__construct ();
	}

	// --------------------------------------------------------------------

	/**
	 * 获取留言咨询
	 * @param unknown $id 商品id
	 */
	function get_advisory($id) {
	    $this->db->select('a.*,b.nick_name');
        $this->db->from('product_advisory a');
        $this->db->join('customer b','b.id=a.created_by','left');
        $this->db->where('a.product_id',$id);
//         $this->db->where('a.created_approve_status',1);
        $this->db->where('a.replay_approve_status',1);
        $this->db->order_by('a.created_at','DESC');
        if($result = $this->db->get()->result_array()){
            return $result;
        }else{
            return array();
        }
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 添加留言咨询
	 * @param unknown $id 商品id
	 * @param unknown $user_id 发布人id
	 */
	function add_advisory($user_id,$id){
	    $this->db->set('product_id',$id);
	    $this->db->set('created_content',$this->content);
	    $this->db->set('created_at',date('Y-m-d H:i:s'));
	    $this->db->set('created_approve_status',0);
	    $this->db->set('created_by',$user_id);
	    $this->db->insert('product_advisory');
	    return $this->db->insert_id();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 回复留言咨询
	 * @param int $id 咨询表id
	 * @param int $user_id 回复人id
	 */
	function add_reply($user_id,$id){
	    $this->db->set('reply_by',$user_id);
	    $this->db->set('reply_at',date('Y-m-d H:i:s'));
	    $this->db->set('replay_content',$this->content);
	    $this->db->set('replay_approve_status',0);
	    $this->db->where('id',$id);
	    return $this->db->update('product_advisory');
	}
	
	
	// --------------------------------------------------------------------
	
	/**
	 * 查询店铺商品咨询
	 * @param unknown $corporation_id 店铺id
	 * @param unknown $status 0查询数据，1统计条数。
	 */
	function get_demand($corporation_id,$limit,$offset,$status=null){
	    $this->db->select('b.id as product_id,b.name,b.goods_thumb,d.id as corporation_id,c.nick_name,c.name,a.*');
	    $this->db->from('product_advisory a');
	    $this->db->join('product b','b.id = a.product_id','left');
	    $this->db->join('customer c','c.id = a.created_by','left');
	    $this->db->join('customer_corporation d','d.id = b.corporation_id','left');
	    $this->db->where('d.id',$corporation_id);
	    if(!$status){
	    $this->db->limit($limit,$offset);
	    $this->db->order_by('a.created_at','DESC');
	       return $this->db->get()->result_array();
	    }else{
	       return $this->db->get()->num_rows();
	    }
	    
	    
	} 
	
	//---------------------------------------------------------------------
	
	/**
	 * 供求总条数
	 * @param unknown $customer_id 店铺id
	 */
	function total($corporation_id){
	    $this->db->from('product_advisory a');
	    $this->db->join('product b','b.id=a.product_id');
	    $this->db->where('b.corporation_id',$corporation_id);
	    $query = $this->db->get();
	    return $query->num_rows();
	    
	}
	
	//---------------------------------------------------------------------
	
	/**
	 * 添加需求
	 * 
	 */
	function add_demand(){

	    $needtax = $this->needtax===0?$this->needtax:1;
	    $price_demand = $this->price_demand==1?$this->price_demand:2;
	    $this->db->set('title',$this->title);
	    $this->db->set('p_count',$this->number);
	    $this->db->set('unit',$this->unit);
	    $this->db->set('max_vip_price',$this->price_max);
	    $this->db->set('min_vip_price',$this->price_min);
	    $this->db->set('create_at',date('Y-m-d H:i:s'));
	    $this->db->set('create_by',$this->session->userdata('user_id'));
	    $this->db->set('ispublish',1);
	    $this->db->set('receiptdate',$this->receiptdate);
	    $this->db->set('effectdate',$this->effectdate);
	    $this->db->set('shippingaddress',$this->address);
	    $this->db->set('p_content',$this->explain);
	    $this->db->set('needtax',$needtax);
	    $this->db->set('img_path',$this->img_path);
	    $this->db->set('cate_id',$this->cate_id);
	    $this->db->set('price_demand',$price_demand);
	    $this->db->set('m_price',$this->m_price);
	    $this->db->set('app_id',$this->app_id);
	    $this->db->set('province_id',$this->province_id);
	    $this->db->set('city_id',$this->city_id);
	    $this->db->set('district_id',$this->district_id);
	    $this->db->insert('requirement');
	    return $this->db->insert_id();

	}
	
	//---------------------------------------------------------------------
	
	/**
	 * 获取需求信息
	 * @param int $customer_id 用户id
	 * @param int $status 全部＝null，待审核＝1，通过＝2，不通过＝3，下架＝4
	 * @param string $select
	 * @param $keyword 关键词
	 * @param $cateids 分类id
	 */
	function get_requirement($customer_id,$status,$select,$limit,$offset,$keyword=null,$cateids=null,$sort=null){
	    $this->db->select($select);
	    $this->db->from('requirement a');
	    $this->db->join('product_cat c','c.id=a.cate_id');
	    $this->db->join('region e','e.region_id=a.province_id','left');
	    $this->db->join('region f','f.region_id=a.city_id','left');
	    $this->db->join('region g','g.region_id=a.district_id','left');
		if($customer_id){
	        $this->db->where('create_by',$customer_id);
	    }else{
	        $this->db->join('customer_corporation b','a.create_by=b.customer_id','left');
	        $this->db->join('customer d','d.id=a.create_by');
	    }
	    
	    //有选择分类执行
	    if($cateids){
	        $this->db->where_in('a.cate_id',$cateids);
	    }
	    
	    $status?$this->db->where('ispublish',$status):null;

	    
	    //搜索
        if($keyword){
            $where = "";
            $i=0;
            foreach ($keyword as $key) {
                if($i==0){
                    $where .= "( a.title like '%".$key."%'";
                }else{
                    if(!empty($key)){
                    $where .= " OR a.title like '%".$key."%'";
                    }
                }
                $i++;
            }
            $where .= ")";
            $this->db->where($where);
        }
        
	    $limit?$this->db->limit($limit,$offset):null;
	    
	    //排序
        switch ($sort){
            case 1:
                $this->db->order_by('a.create_at','DESC');//综合
                break;
            case 2:
                $this->db->order_by('a.p_count','DESC');//数量
                break;
            case 3:
                $this->db->order_by('max_vip_price','DESC');//总价
                break;
            case 4:
                $this->db->order_by('a.create_at','DESC');//时间
                break;
            case 5:
                $this->db->order_by('a.create_at');
                break;
            case 6:
                $this->db->order_by('a.p_count');
                break;
            case 7:
                $this->db->order_by('max_vip_price');
                break;
            case 8:
                $this->db->order_by('a.create_at');
                break;
            default:
                $this->db->order_by('a.create_at','DESC');
                break;
        }
        
	    $query = $this->db->get();
	    return $query->result_array();
	}
	 
	//---------------------------------------------------------------------
	
	/**
	 * 需求总条数
	 * @param int $customer_id 用户id
	 * @param int $status 全部＝null，待审核＝1，通过＝2，不通过＝3，下架＝4
	 * @param $keyword 关键词
	 * @param $cateids 分类id
	 */
	function count_total($customer_id,$status=null,$keyword=null,$cateids=null){
	    $this->db->from('requirement a');
    	if($customer_id){
    	    $this->db->where('create_by',$customer_id);
	    }else{
	        $this->db->join('customer_corporation b','a.create_by=b.customer_id','left');
	        $this->db->join('customer c','c.id=a.create_by');
	    }
	    
	    //有选择分类执行
	    if($cateids){
	        $this->db->where_in('a.cate_id',$cateids);
	    }
        $status?$this->db->where('a.ispublish',$status):null;
        
        
        //搜索
        if($keyword){
            $where = "";
            $i=0;
            foreach ($keyword as $key) {
                if($i==0){
                    $where .= "( a.title like '%".$key."%'";
                }else{
                    if(!empty($key)){
                    $where .= " OR a.title like '%".$key."%'";
                    }
                }
                $i++;
            }
            $where .= ")";
            $this->db->where($where);
        }
        

	    $query = $this->db->get();
	    return $query->num_rows();
	}
	
	//---------------------------------------------------------------------
	
	/**
	 * 更改审核状态
	 * @param int $id 需求id 
	 * @param int $state 修改的状态
	 * @param int $customer_id 用户id
	 */
	function change_status($id,$state,$customer_id){
	   $this->db->set('ispublish',$state);
	   $this->db->where('id',$id);
	   $this->db->where('create_by',$customer_id);
	   return $this->db->update('requirement');
	}
	
	//---------------------------------------------------------------------
	
	/**
	 * 供需详情
	 * @param int $id 供需id
	 * @param int $customer 用户id
	 */
	function get_details($id,$customer=null){
	    $this->db->select('a.*,b.name,c.region_name as province,d.region_name as city,e.region_name as district');
        $this->db->from('requirement a');
        $this->db->join('product_cat b','b.id=a.cate_id','left');
        $this->db->join('region c','c.region_id=a.province_id','left');
        $this->db->join('region d','d.region_id=a.city_id','left');
        $this->db->join('region e','e.region_id=a.district_id','left');
        $this->db->where('a.id',$id);
        if($customer){
            $this->db->where('a.create_by',$customer);
        }else{
            $this->db->where('a.ispublish',2);
        }
        $query = $this->db->get();
        if($result = $query->row_array()){
            return $result;
        }
        return  null;
	     
	}
	
	//----------------------------------------------------------------------
	
	/**
	 * 添加换货信息
	 * @param array $barter
	 */
	public function add_barter($barter){
	    $this->db->set('contactuser',$barter['contactuser']);
	    $this->db->set('customer_id',$barter['customer_id']);
	    $this->db->set('remark',$barter['remark']);
	    $this->db->set('requirement_id',$barter['requirement_id']);
	    $this->db->set('create_at',date("Y-m-d H:i:s"));
	    $this->db->insert('requirement_barter');
	    return $this->db->insert_id();
	    
	}
	
	//----------------------------------------------------------------------
	
	/**
	 * 统计金额
	 * @param array $cateids 分类id
	 */
	public function count_amount($cateids){
	    $this->db->select('sum(max_vip_price) as m_price');
	    $this->db->from('requirement');
	    $this->db->where('ispublish',2);
	    if($cateids){
	    $this->db->where_in('cate_id',$cateids);
	    }
	    $query = $this->db->get();
	    return  $query->row_array();

	}
	
	//----------------------------------------------------------------------
	
	/**
	 * 修改图片
	 */
	public function img_update($id,$customer_id,$img_path){
	    $this->db->set('img_path',$img_path);
	    $this->db->where('id',$id);
	    $this->db->where('create_by',$customer_id);
	    return $this->db->update('requirement');
	}
	
	//----------------------------------------------------------------------
	
	/**
	 * 修改
	 */
	public function edit($id){
	    $needtax = $this->needtax===0?$this->needtax:1;
	    $price_demand = $this->price_demand==1?$this->price_demand:2;
	    $this->db->set('title',$this->title);
	    $this->db->set('p_count',$this->number);
	    $this->db->set('unit',$this->unit);
	    $this->db->set('max_vip_price',$this->price_max);
	    $this->db->set('min_vip_price',$this->price_min);
	    $this->db->set('create_at',date('Y-m-d H:i:s'));
	    $this->db->set('ispublish',1);
	    $this->db->set('receiptdate',$this->receiptdate);
	    $this->db->set('effectdate',$this->effectdate);
	    $this->db->set('shippingaddress',$this->address);
	    $this->db->set('p_content',$this->explain);
	    $this->db->set('needtax',$needtax);
	    $this->db->set('img_path',$this->img_path);
	    $this->db->set('cate_id',$this->cate_id);
	    $this->db->set('price_demand',$price_demand);
	    $this->db->set('m_price',$this->m_price);
	    $this->db->set('app_id',$this->app_id);
	    $this->db->set('province_id',$this->province_id);
	    $this->db->set('city_id',$this->city_id);
	    $this->db->set('district_id',$this->district_id);
	    $this->db->where('create_by',$this->session->userdata('user_id'));
	    $this->db->where('id',$id);
	    return $this->db->update('requirement');
	} 


}