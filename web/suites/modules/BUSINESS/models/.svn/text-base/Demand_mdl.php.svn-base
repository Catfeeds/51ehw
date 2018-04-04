<?php
/**
 *  需求模块
 *21 + 8 + 41
 *
 */
class Demand_mdl extends CI_Model {
    var $title;
    var $p_count;
    var $unit;
    var $receiptdate;
    var $effectdate;
    var $m_price;
    var $cate_id;
    var $img_path;
    var $app_id;
    var $province_id;
    var $city_id;
    var $district_id;
    var $shippingaddress;
    var $needtax;
    var $freight;
    var $contactuser;
    var $contactphone;
    var $explain;
    var $number;
    var $price_min;
    var $price_max;
    var $address;
    var $search_val;
    var $cateid_array;
    var $total_price;
    var $label_id;
   
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
	 * 需求过期后自动变下架
	 */
	function update_reqirements(){
	    $date = date('Y-m-d H:i:s');// 当前时间
        $this->db->set('is_putaway',0);
        $this->db->where('effectdate <',$date);
        $this->db->update('requirement');
        return $query=$this->db->affected_rows();
	}
	// --------------------------------------------------------------------
	
	/**
	 * 查询店铺商品咨询
	 * @param unknown $corporation_id 店铺id
	 * @param unknown $status 0查询数据，1统计条数。
	 */
	function get_demand($corporation_id,$limit,$offset,$status=null){
	    $this->db->select('b.id as product_id,b.name,b.goods_thumb,d.id as corporation_id,c.nick_name,c.mobile,c.qq_account,a.*');
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
	
	//-------------------2017-6-7-------------------------------------------------
	/**
	 * 添加关键词搜索需求记录
	 */
	public function add_demand_history($data){
	    if(isset($data['customer_id'])){
	        $this->db->set("customer_id",$data['customer_id']);
	    }
	    if(isset($data['cate_id'])){
	        $this->db->set("cate_id",$data['cate_id']);
	    }
	    if(isset($data['keyword'])){
	        $this->db->set("keyword",$data['keyword']);
	    }
	    if(isset($data['type'])){
	        if($data['type'] == 'keyword'){
	            $this->db->set("type",0);
	        }
	        if($data['type'] == 'cate'){
	            $this->db->set("type",1);
	        }
	    }
	   $time = date('Y-m-d H:i:s');
	   $this->db->set("created_at",$time);
	   $this->db->insert('customer_demand_history');
	   return $this->db->insert_id();
	}
	
	
	//---------------------------------------------------------------------
	
	/**
	 * 添加需求
	 * 
	 */
	function add_demand(){
	  
	   
	    $this->db->set('title',$this->title);
	    $this->db->set('p_count',$this->p_count);
	    $this->db->set('unit',$this->unit);
	    $this->db->set('p_content',$this->explain);
	    $this->db->set('create_at',date('Y-m-d H:i:s'));
	    $this->db->set('create_by',$this->session->userdata('user_id'));
	    $this->db->set('ispublish',1);
	    $this->db->set('is_putaway',0);
	    $this->db->set('receiptdate',$this->receiptdate);
	    $this->db->set('effectdate',$this->effectdate);
	    $this->db->set('shippingaddress',$this->shippingaddress);
	    $this->db->set('contactuser',$this->contactuser);
	    $this->db->set('contactphone',$this->contactphone);
	    $this->db->set('img_path',$this->img_path);
	    $this->db->set('needtax',$this->needtax);
	    $this->db->set('freight',$this->freight);
	    $this->db->set('cate_id',$this->cate_id);
	    $this->db->set('m_price',$this->m_price);
	    if(empty($this->total_price)){
	        $p_count = $this->p_count ;
	        $m_price = $this->m_price;
	        $total_price = $p_count *  $m_price;
	        $this->db->set('total_price',$total_price);
	    }else{
	        $this->db->set('total_price',$this->total_price);
	    }
	    $this->db->set('app_id',$this->app_id);
	    $this->db->set('province_id',$this->province_id);
	    $this->db->set('city_id',$this->city_id);
	    $this->db->set('district_id',$this->district_id);
	    
	    
	    $this->db->insert('requirement');
	    $requirement_id = $this->db->insert_id();

	    if(isset($this->label_id) && $this->label_id !=''){
	    	$label_id = $this->label_id;
	    	
	    	$label_id = json_decode($label_id, TRUE);
	    	$data = [];
	    	foreach($label_id as $val){
	    	    $data[] = ['requirement_id' => $requirement_id, 'label_id' => $val];
	    	}
	    	$this->db->insert_batch('requirement_label', $data);
	    }
	   
	    return $requirement_id;

	}

	//---------------------------------------------------------------------
	/**
	 *搜索需求总数
	 *
	 */
	function get_count_with_condition($options =array()){
	    $date = date('Y-m-d H:i:s');// 当前时间
	    $_app_id = '';
	    // 分站点
	    if ($options['app_id']) {
	       $app_id = $options['app_id'];
	       $_app_id = " AND r.app_id IN(0, $app_id)"; 
	    }
	    $_keyword = '';
	    if($options['keyword']){
	        $keyword = $options['keyword'];
	        $_keyword = "AND r.title like '%$keyword%'";
	    }
	    $_cate = '';
	    if( $options['cate']){
	        if(is_array($options['cate'])){
	            $_classify = '';
	            foreach ($options['cate'] as $key =>$val){
	                $_classify .= $val['id'].',';
	            }
	            $_classify = trim($_classify,',');
	           
	            //分类
	            $_cate = " AND r.cate_id IN($_classify)"; 
	        }else{
	            $cate = $options['cate'];
	           
	            $_cate = "AND r.cate_id = $cate";
	        }
	    
	    }
	    
	    $_orderBy = 'ORDER BY create_at  DESC ';
	    if($options['orderBy']){
	        switch($options['orderBy']){
	            case 'generate_up'://升序
	                $_orderBy = 'ORDER BY create_at  ASC';
	                break;
// 	            case 'generate_down': //降序
// // 	               $_orderBy = 'ORDER BY create_at  DESC ';
// 	                break;
	            case 'time_up':
	                $_orderBy = "WHERE diff <= 60  ORDER BY diff ASC";
	                break;
	            case 'time_down':
	                 $_orderBy = "WHERE diff <= 60  ORDER BY diff DESC";
	                break;
	        }
	    }
	    
	   $query =  $this->db->query("
	        select a.* from(
	               SELECT `r`.`id`, `r`.`create_at`,`r`.`total_price`, `r`.`img_path`, `r`.`title`, `r`.`create_by`, `r`.`effectdate`, count(b.id) as total, TIMESTAMPDIFF(minute, '$date', r.effectdate) as diff 
 	               FROM `9thleaf_requirement` as `r` 
 	               LEFT JOIN `9thleaf_requirement_barter` as `b` ON `r`.`id` = `b`.`requirement_id` 
 	               WHERE`r`.`effectdate` > '$date'
	               AND `r`.`is_putaway` = 1 AND `r`.`ispublish` = 2 
	               $_app_id $_keyword $_cate
 	               GROUP BY `r`.`id` 
            ) as a 
            $_orderBy
	        ");
	    
	    return $query->result_array();
	}
	
	/**
	 * 搜索需求
	 *
	 */
	function get_lists_for_search($options =array(),$limit=0,$offset=0,$lables='', $is_all=''){
	    $date = date('Y-m-d H:i:s');// 当前时间
	    $_app_id = '';
	    // 分站点
	    if ($options['app_id']) {
	       $app_id = $options['app_id'];
	       $_app_id = " AND r.app_id IN(0, $app_id)"; 
	    }
	    $_keyword = '';
	    if($options['keyword']){
	        $keyword = $options['keyword'];
	        $_keyword = "AND r.title like '%$keyword%'";
	    }
	    $_cate = '';
	    if( $options['cate']){
	        if(is_array($options['cate'])){
	            $_classify = '';
	            foreach ($options['cate'] as $key =>$val){
	                $_classify .= $val['id'].',';
	            }
	            $_classify = trim($_classify,',');
	            //分类
	            $_cate = " AND r.cate_id IN($_classify)"; 
	        }else{
	            $cate = $options['cate'];
	           
	            $_cate = "AND r.cate_id = $cate";
	        }
	    }
	    $_limit = '';
	    if ($offset) {
	        $_limit = "limit $offset,$limit";
	    } elseif ($limit) {
	        $_limit = "limit $limit";
	    }
	    if($is_all){
	    	$_orderBy = 'ORDER BY a.total_price  DESC ';
	    }else{
	    	$_orderBy = 'ORDER BY id  DESC ';
	    }
	    if($options['orderBy']){
	        switch($options['orderBy']){
	            case 'generate_up'://升序
	                $_orderBy = 'ORDER BY create_at  ASC';
	                break;
	            case 'generate_down': //降序
// 	               $_orderBy = 'ORDER BY create_at  DESC ';
	                break;
	            case 'time_up':
	                $_orderBy = "ORDER BY diff ASC";
// 	                $_orderBy = "WHERE diff <= 60  ORDER BY diff ASC";
	                break;
	            case 'time_down':
	                 $_orderBy = "ORDER BY diff DESC";
// 	                 $_orderBy = "WHERE diff <= 60  ORDER BY diff DESC";
	                break;
	        }
	    }

        if($lables){
            $query =  $this->db->query("
	        (select DISTINCT a.* from(
	               SELECT `r`.`id`, `r`.`create_at`,`r`.`total_price`, `r`.`img_path`, `r`.`title`, `r`.`create_by`, `r`.`effectdate`, count(b.id) as total, TIMESTAMPDIFF(minute, '$date', r.effectdate) as diff 
 	               FROM `9thleaf_requirement` as `r` 
 	               LEFT JOIN `9thleaf_requirement_barter` as `b` ON `r`.`id` = `b`.`requirement_id`
 	               LEFT JOIN `9thleaf_requirement_label` as `c` ON `r`.`id` = `c`.`requirement_id`
 	               LEFT JOIN `9thleaf_label` as `d` ON `d`.`id` = `c`.`label_id` 
 	               WHERE`r`.`effectdate` > '$date' AND `c`.`label_id` in (".$lables.")
	               AND `r`.`is_putaway` = 1 AND `r`.`ispublish` = 2 
	               $_app_id $_keyword $_cate
 	               GROUP BY `r`.`id` 
            ) as a 

            ORDER BY id  DESC 

        
	        $_limit
	    	)
	    	union
	    	(
	    		select DISTINCT a.* from(
	               SELECT `r`.`id`, `r`.`create_at`,`r`.`total_price`, `r`.`img_path`, `r`.`title`, `r`.`create_by`, `r`.`effectdate`, count(b.id) as total, TIMESTAMPDIFF(minute, '$date', r.effectdate) as diff 
 	               FROM `9thleaf_requirement` as `r` 
 	               LEFT JOIN `9thleaf_requirement_barter` as `b` ON `r`.`id` = `b`.`requirement_id`
 	               WHERE`r`.`effectdate` > '$date' 
	               AND `r`.`is_putaway` = 1 AND `r`.`ispublish` = 2 
	               $_app_id $_keyword $_cate
 	               GROUP BY `r`.`id` 
	            ) as a 

	            ORDER BY id DESC 

		        $_limit
	    	)
	        ");
        }else{
            $query =  $this->db->query("
	        select a.* from(
	               SELECT `r`.`id`, `r`.`create_at`,`r`.`total_price`, `r`.`img_path`, `r`.`title`, `r`.`create_by`, `r`.`effectdate`, count(b.id) as total, TIMESTAMPDIFF(minute, '$date', r.effectdate) as diff 
 	               FROM `9thleaf_requirement` as `r` 
 	               LEFT JOIN `9thleaf_requirement_barter` as `b` ON `r`.`id` = `b`.`requirement_id`
 	               WHERE`r`.`effectdate` > '$date' 
	               AND `r`.`is_putaway` = 1 AND `r`.`ispublish` = 2 
	               $_app_id $_keyword $_cate
 	               GROUP BY `r`.`id` 
            ) as a 
            $_orderBy
	        $_limit
	        ");
        }

	   // 去重复
        $res = $query->result_array();
        $keyid = [];
        $result = [];
        foreach ($res as $key => $value) {
        	if(!in_array($value['id'], $keyid)){
        		$keyid[] = $value['id'];
        		$result[] = $value;
        	}
        	
        }

	   return $result;
	 
	}
	
	
	/**
	 * 获取报价人数
	 *
	 */
	function getOffererTotal($requirement_id,$options){
	    $this->db->select('*');
	    $this->db->from('requirement_barter');
	    // 分站点
	    if ($options['app_id']) {
	        $_app_id = array(
	            0,
	            $options['app_id']
	        );
	        $this->db->where_in('app_id', $_app_id);
	    }
	    $this->db->where('requirement_id',$requirement_id);
	    $res = $this->db->count_all_results();
	 
	    return $res;
	}
	/**
	 * 获取多条报价信息
	 *
	 */
	function getBartersByRid($requirement_id,$options,$limit =0,$offset =0){
	    $this->db->select('*');
	    $this->db->from('requirement_barter');
	    $this->db->where('requirement_id',$requirement_id);
	    // 分站点
	    if ($options['app_id']) {
	        $_app_id = array(
	            0,
	            $options['app_id']
	        );
	        $this->db->where_in('app_id', $_app_id);
	    }
	   
	    if ($offset) {
	        $this->db->limit($limit, $offset);
	    } elseif ($limit) {
	        $this->db->limit($limit);
	    }
	    
	    $this->db->order_by('create_at',"DESC");
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	
	
	
	
	/**
	 * 需求上架下架
	 * 
	 */
	function putRequirement($requirement_id,$status){
	    $this->db->set('is_putaway',$status);
	    $this->db->where('id',$requirement_id);
	    $this->db->update('requirement');
	    return $query=$this->db->affected_rows();
	}
	/**
	 * 修改需求信息
	 */
	function updateRequirementByid($id,$data){
	    $data['create_at'] =date("Y-m-d H:i:s");
	    $this->db->where('id', $id);
	    return $this->db->update('requirement', $data);
	}
	
	
	/**
	 * 用户的需求
	 * $options 条件
	 */
	
	function getRequirementByid($id,$options=array(),$limit=0,$offset=0){
	    $this->db->select('r.*,count(b.id) as total');
	    switch ($options['type']) {
	        case 0://0全部
	            break;
	        case 1: // 1抢单中(上架) 
	            $this->db->where('r.ispublish',2);
	            $this->db->where('r.is_putaway',1);
	            break;
            case 2:// 2审核通过
                $this->db->where('r.ispublish',2);
                $this->db->where('r.is_putaway',0);
                break;
            case 3://3审核中
                $this->db->where('r.ispublish',1);
                break;
            case 4://4审核失败
                $this->db->where('r.ispublish',3);
                break;
            case 5://5删除
                $this->db->where('r.ispublish',5);
                break;
	    }
	    
	    // 分站点
	    if ($options['app_id']) {
	        $_app_id = array(
	            0,
	            $options['app_id']
	        );
	        $this->db->where_in('r.app_id', $_app_id);
	    }
	    if ($offset) {
	        $this->db->limit($limit, $offset);
	    } elseif ($limit) {
	        $this->db->limit($limit);
	    }
	    $this->db->where('r.create_by',$id);
	    $this->db->order_by('r.create_at','DESC');//排序
	    $this->db->from('requirement as r');
	    $this->db->join("requirement_barter as b","r.id = b.requirement_id ","left");
	    $this->db->group_by('r.id');
	    $query = $this->db->get();
	    return $query->result_array();
	}
	/**
	 * 用户的需求数量
	 * $options 条件
	 */
	function getRequirementCountsByid($id,$options=array()){
	    $this->db->select('*');
    	switch ($options['type']) {
    	        case 0://0全部
    	            break;
    	        case 1: // 1抢单中(上架) 
    	            $this->db->where('ispublish',2);
    	            $this->db->where('is_putaway',1);
    	            break;
                case 2:// 2审核通过
                    $this->db->where('ispublish',2);
                    $this->db->where('is_putaway',0);
                    break;
                case 3://3审核中
                    $this->db->where('ispublish',1);
                    break;
                case 4://4审核失败
                    $this->db->where('ispublish',3);
                    break;
                case 5://5删除
                    $this->db->where('ispublish',5);
                    break;
    	    }
	    /// 分站点
	    if ($options['app_id']) {
	        $_app_id = array(
	            0,
	            $options['app_id']
	        );
	        $this->db->where_in('app_id', $_app_id);
	    }
	    $this->db->where('create_by',$id);
	    $this->db->from('requirement');
	    $res = $this->db->count_all_results();
	 
	    return $res;
	}
	
	/**
	 * 用户报价信息
	 * 
	 */
	public function getBarterByid($id,$options=array(),$limit=0,$offset=0){
	    $this->db->select('r.id as requirement_id,r.title,r.img_path,rb.offer,rb.create_at,rb.id as barter_id');
	    $this->db->from('requirement r');
	    $this->db->join('requirement_barter rb',"rb.requirement_id=r.id and rb.customer_id =$id ");
	    $this->db->where('r.ispublish',2);//审核通过
// 	    $this->db->where('r.is_putaway',1);//上架的
	   
	    /// 分站点
	    if ($options['app_id']) {
	        $_app_id = array(
	            0,
	            $options['app_id']
	        );
	       $this->db->where_in('r.app_id', $_app_id);
	       $this->db->where_in('rb.app_id', $_app_id);
	    }
	    if ($offset) {
	        $this->db->limit($limit, $offset);
	    } elseif ($limit) {
	        $this->db->limit($limit);
	    }
	    $this->db->order_by('rb.create_at','DESC');//排序
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	/**
	 * 用户报价信息记录数
	 *
	 */
	public function getBarterCountsByid($id,$options=array()){
	    $this->db->select('r.id,r.title,r.create_at,rb.requirement_id');
	    $this->db->from('requirement r');
	    $this->db->join('requirement_barter rb','rb.requirement_id=r.id','left');
	     
	    $this->db->where('r.ispublish',2);//审核通过
	    $this->db->where('r.is_putaway',1);//上架的
	    $this->db->where('customer_id',$id);
	    /// 分站点
	    if ($options['app_id']) {
	        $_app_id = array(
	            0,
	            $options['app_id']
	        );
	        $this->db->where_in('r.app_id', $_app_id);
	        $this->db->where_in('rb.app_id', $_app_id);
	    }
	    $res = $this->db->count_all_results();
	    
	    return $res;
	}
	
	
	/**
	 * 获取用户公司名称
	 * 同时获取手机号码和邮箱
	 */
	public function getCorporName($id){
	    $this->db->select('cc.id,cc.corporation_name,cc.email,cc.contact_name,cc.contact_mobile as mobile');
	    $this->db->from('customer_corporation as cc');
	    $this->db->where('cc.status',1);
	    $this->db->where('cc.customer_id',$id);
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	/**
	 * 获取单条需求信息
	 * 
	 */
	function getrequirByid($id){
	    $this->db->select('r.*,count(rb.id) as total');
	    $this->db->where('r.id',$id);
	    $this->db->from('requirement as r');
	    $this->db->join("requirement_barter as rb","rb.requirement_id = r.id","left");
	    $this->db->group_by('r.id');
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	/**
	 * 获取单条报价信息
	 *
	 */
	function getbartByid($id){
	    $this->db->select('*');
	    $this->db->where('id',$id);
	    $this->db->from('requirement_barter');
	    $query = $this->db->get();
	    return $query->row_array();
	}
	
	/**
	 * 修改报价信息
	 */
	function updatebartByid($id,$data){
        $this->db->where('id', $id);
	    return $this->db->update('requirement_barter', $data);
	}
	function getbarterwithid($id,$options=array()){
	    $this->db->select('*');
	    $this->db->where('customer_id',$id);
	    /// 分站点
	    if ($options['app_id']) {
	        $_app_id = array(
	            0,
	            $options['app_id']
	        );
	        $this->db->where_in('app_id', $_app_id);
	    }
	    $this->db->from('requirement_barter');
	    $query = $this->db->get();
	    return $query->result_array();
	}
	
	
    /**
     * 获取父级分类
     */
	function get_classify($id){
	    $array =array(
	    );
	    $this->db->select('id,name,level');
	    $this->db->where('parent_id',$id);
	    $query = $this->db->get('product_cat')->result_array();
	    if (count($query)>0){
	        return $query;
	    }
	    return $array;
	}
	/**
	 * 获取当前分类名称
	 */
	function get_classify_name($id){
	    $this->db->select('id,name,level');
	    $this->db->where('id',$id);
	    $query = $this->db->get('product_cat')->row_array();
	    return $query;
	}
	/**
	 * 查询子分类id
	 * @param  $id 父级分类id
	 * @param  $level 分等级
	 */
	function get_son_classify($id,$level,$type = 0){
	    //区别  发布和搜索
	    
	    $this->db->select('id,name,level');
	    $this->db->from('product_cat');
	    if($type && $type == 'add'){
	        //发布
	        $this->db->where("parent_id" ,$id);
	    }else{
	        //搜索
	        $this->db->where("FIND_IN_SET($id,path )");
	        $this->db->where("level > $level");
	    }
	    
	    $query = $this->db->get()->result_array();
	    return $query;
	}
	
	
	
	
	/**
	 * 省级
	 *
	 * @return array
	 */
	function getprovince()
	{
	    $array =array(
	        'region_id' => '',
	        'region_name' => '',
	    );
	    $this->db->select('region_id,region_name');
	    $this->db->where('parent_id', 1);
	    $query = $this->db->get('region')->result_array();
	    if (count($query)>0){
	        return $query;
	    }
	    return $array;
	}
	
	/**
	 * 下级区域
	 *
	 * @return array
	 */
	function getchild($id)
	{
	    $array =array(
	        'region_id' => '',
	        'region_name' => '',
	    );
	    $this->db->select('region_id,region_name');
	    $this->db->where('parent_id',$id);
	    $query = $this->db->get('region')->result_array();
	    if (count($query)>0){
	        return $query;
	    }
	    return $array;
	}
	
	/**
	 *获取区域名
	 * 
	 */
	function get_name($id)
	{
	    $array =array(
	        'region_id' => '',
	        'region_name' => '',
	    );
	    $this->db->select('region_id,region_name');
	    $this->db->where('region_id',$id);
	    $query = $this->db->get('region')->row_array();
	    if (count($query)>0){
	        return $query;
	    }
	    return $array;
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
	    $this->db->distinct();	
	    $this->db->from('requirement a');
	    $this->db->join('product_cat c','c.id=a.cate_id');
	    $this->db->join('region e','e.region_id=a.province_id','left');
	    $this->db->join('region f','f.region_id=a.city_id','left');
	    $this->db->join('region g','g.region_id=a.district_id','left');
		if($customer_id){
	        $this->db->where('create_by',$customer_id);
	    }else{
	        $this->db->join('customer_corporation b','a.create_by=b.customer_id','left');
	        $this->db->join('customer d','d.id=a.create_by', 'left');
	  		if($is_tuijian == '99999'){
	  			$this->db->join('customer_label as cl', 'd.id = cl.customer_id', 'left');
	  			$this->db->join('label as la', 'cl.label_id = la.id', 'left');
	  			$this->db->join('requirement_label as rel', 'rel.requirement_id = a.id', 'left');	
	  		}

	    }
	    
	    //有选择分类执行
	    if($cateids){
	    		$this->db->where_in('a.cate_id',$cateids);
	    }
	    if($status){
	        switch ($status){
	        case 2:
	            //上架 
	            $this->db->where('ispublish',2);
	            $this->db->where('is_putaway',1);
	            break;
	        case 4:
	            //下架
	            $this->db->where('ispublish',2);
	            $this->db->where('is_putaway',0);
	            break;
	        default:
	            $this->db->where('ispublish',$status);
	            break;
	        }    
	    }

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
        
	    // $this->db->limit($limit,$offset);
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
                $this->db->order_by('total_price','DESC');//总价
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
                $this->db->order_by('total_price');
                break;
            case 8:
                $this->db->order_by('a.create_at');
                break;
            default:
                $this->db->order_by('a.create_at','DESC');
                break;
        }
        
	    $query = $this->db->get();
	    // echo $this->db->last_query();
	    return $query->result_array();

	}

		/**
		 * 获取列表需求信息
		 * @param int $customer_id 用户id
		 * @param int $status 全部＝null，待审核＝1，通过＝2，不通过＝3，下架＝4
		 * @param string $select
		 * @param $keyword 关键词
		 * @param $cateids 分类id
		 */
			function get_requirement_page_list($select,$limit,$offset,$keyword=null,$cateids=null,$sort=null,$labels=null){
		 
		    $where = '';
		    $where2 = '';

		    if($labels){
		        $labels = implode(',',$labels);
		        	
		        $where .= " and rel.label_id in ( {$labels} ) ";	
		    }
		

		    if($offset && $limit){
		    	$limit_a = " limit $offset, $limit "; 
		    }else if($limit){
		    	$limit_a = " limit $limit ";
		    }else{
		    	$limit_a = '';
		    }

		    $where_status = " where ispublish = 2 and is_putaway = 1 ";
		    //有选择分类执行
		    if($cateids){
		        $cateids = implode(',',$cateids);
		        $where .= " and  9thleaf_requirement.cate_id in ( {$cateids} ) ";
		        $where2 .= " and  9thleaf_requirement.cate_id in ( {$cateids} ) ";
		    }

		    
		    //搜索
	        if($keyword){
	            $i=0;
	            foreach ($keyword as $key) {
	                if($i==0){
	                    $where .= " and 9thleaf_requirement.title like '%".$key."%' ";
	                    $where2 .= " and 9thleaf_requirement.title like '%".$key."%' ";
	                }else{
	                    if(!empty($key)){
	                    $where .= " OR 9thleaf_requirement.title like '%".$key."%' ";
	                    $where2 .= " OR 9thleaf_requirement.title like '%".$key."%' ";
	                    }
	                }
	                $i++;
	            }

	        }
    
		   //排序
		        switch ($sort){
		            case 1:
		                // $this->db->order_by('a.create_at','DESC');//综合
		                $order_by  = " order by 9thleaf_requirement.create_at DESC ";
		               
		                break;
		            case 2:
		                // $this->db->order_by('a.p_count','DESC');//数量
		                $order_by  = " order by 9thleaf_requirement.p_count DESC ";

		                break;
		            case 3:
		                // $this->db->order_by('total_price','DESC');//总价
		                $order_by  = " order by total_price DESC ";
		                break;
		            case 4:
		                // $this->db->order_by('a.create_at','DESC');//时间
		                $order_by  = " order by 9thleaf_requirement.create_at DESC ";
		                break;
		            case 5:
		                // $this->db->order_by('a.create_at');
		                $order_by  = " order by 9thleaf_requirement.create_at  ";
		                break;
		            case 6:
		                // $this->db->order_by('a.p_count');
		                $order_by  = " order by 9thleaf_requirement.p_count ";
		                break;
		            case 7:
		                // $this->db->order_by('total_price');
		                $order_by  = " order by 9thleaf_requirement.total_price  ";
		                break;
		            case 8:
		                // $this->db->order_by('a.create_at');
		                $order_by  = " order by 9thleaf_requirement.create_at ";
		                break;
		            default:
		                // $this->db->order_by('a.create_at','DESC');
		                $order_by  = " order by 9thleaf_requirement.create_at DESC ";
		                break;
		        }
		        
	        
		    $sql1 = "SELECT DISTINCT `9thleaf_requirement`.*, `b`.`corporation_name`, `b`.`status`, `c`.`id` as `cate_ids`, `c`.`name`, `d`.`mobile`, `e`.`region_name` as `province`, `f`.`region_name` as `city`, `g`.`region_name` as `district` 
			FROM `9thleaf_requirement`  
			LEFT JOIN `9thleaf_product_cat`as `c` ON `c`.`id`=`9thleaf_requirement`.`cate_id` 
			LEFT JOIN `9thleaf_region`as `e` ON `e`.`region_id`=`9thleaf_requirement`.`province_id` 
			LEFT JOIN `9thleaf_region`as `f` ON `f`.`region_id`=`9thleaf_requirement`.`city_id` 
			LEFT JOIN `9thleaf_region`as `g` ON `g`.`region_id`=`9thleaf_requirement`.`district_id` 
			LEFT JOIN `9thleaf_customer_corporation`as `b` ON `9thleaf_requirement`.`create_by`=`b`.`customer_id` 
			LEFT JOIN `9thleaf_customer`as `d` ON `d`.`id`=`9thleaf_requirement`.`create_by` 
			LEFT JOIN `9thleaf_customer_label` as `cl` ON `d`.`id` = `cl`.`customer_id` 
			LEFT JOIN `9thleaf_label` as `la` ON `cl`.`label_id` = `la`.`id` 
			LEFT JOIN `9thleaf_requirement_label` as `rel` ON `rel`.`requirement_id` = `9thleaf_requirement`.`id` 
			".$where_status.$where.$order_by;

			  $sql2 = "SELECT DISTINCT `9thleaf_requirement`.*, `b`.`corporation_name`, `b`.`status`, `c`.`id` as `cate_ids`, `c`.`name`, `d`.`mobile`, `e`.`region_name` as `province`, `f`.`region_name` as `city`, `g`.`region_name` as `district` 
			FROM `9thleaf_requirement`  
			LEFT JOIN `9thleaf_product_cat`as `c` ON `c`.`id`=`9thleaf_requirement`.`cate_id` 
			LEFT JOIN `9thleaf_region`as `e` ON `e`.`region_id`=`9thleaf_requirement`.`province_id` 
			LEFT JOIN `9thleaf_region`as `f` ON `f`.`region_id`=`9thleaf_requirement`.`city_id` 
			LEFT JOIN `9thleaf_region`as `g` ON `g`.`region_id`=`9thleaf_requirement`.`district_id` 
			LEFT JOIN `9thleaf_customer_corporation`as `b` ON `9thleaf_requirement`.`create_by`=`b`.`customer_id` 
			LEFT JOIN `9thleaf_customer`as `d` ON `d`.`id`=`9thleaf_requirement`.`create_by` 
			LEFT JOIN `9thleaf_customer_label` as `cl` ON `d`.`id` = `cl`.`customer_id` 
			LEFT JOIN `9thleaf_label` as `la` ON `cl`.`label_id` = `la`.`id` 
			LEFT JOIN `9thleaf_requirement_label` as `rel` ON `rel`.`requirement_id` = `9thleaf_requirement`.`id` 
			".$where_status.$where2.$order_by;

			if($labels){
				$query = $this->db->query(" (select demand.* from ( ".$sql1." ) as demand ) "." union "." ( select demand.* from (".$sql2." ) as demand ) " .$limit_a);
			}else{
				$query = $this->db->query($sql2.$limit_a);
			}
		  
			// echo $this->db->last_query();
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
	function count_total($customer_id,$status=null,$keyword=null,$cateids=null,$labels=''){
	    $this->db->from('requirement a');
    	if($customer_id){
    	    $this->db->where('create_by',$customer_id);
	    }else{
	        $this->db->join('customer_corporation b','a.create_by=b.customer_id','left');
	        $this->db->join('customer c','c.id=a.create_by');

	        if($labels){
	        	$this->db->join('customer_label d', 'c.id=d.customer_id');
	        	$this->db->join('label e', 'd.label_id=e.id' );
	        	$this->db->join('requirement_label f', 'f.requirement_id=a.id');
	        	$this->db->where_in('f.label_id',$labels);
	        }
	    }
	    

	    //有选择分类执行
	    if($cateids){
	        $this->db->where_in('a.cate_id',$cateids);
	    }
    	if($status){
    	        switch ($status){
    	        case 2:
    	            //上架 
    	            $this->db->where('ispublish',2);
    	            $this->db->where('is_putaway',1);
    	            break;
    	        case 4:
    	            //下架
    	            $this->db->where('ispublish',2);
    	            $this->db->where('is_putaway',0);
    	            break;
    	        default:
    	            $this->db->where('ispublish',$status);
    	            break;
    	        }    
    	    }
        
        
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
		// echo $this->db->last_query();
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

    /**
     * 供需详情
     * @param int $id 供需id
     * @param int $customer 用户id
     */
    function get_details_tow($id,$customer=null){
        $this->db->select('a.*,b.name,la.id as label_id,la.name as label_name,c.region_name as province,d.region_name as city,e.region_name as district');
        $this->db->from('requirement a');
        $this->db->join('product_cat b','b.id=a.cate_id','left');
        $this->db->join('region c','c.region_id=a.province_id','left');
        $this->db->join('region d','d.region_id=a.city_id','left');
        $this->db->join('region e','e.region_id=a.district_id','left');
        $this->db->join('requirement_label as rl', 'a.id = rl.requirement_id', 'left');
        $this->db->join('label as la', 'la.id = rl.label_id', 'left');
        $this->db->where('a.id',$id);
        if($customer){
            $this->db->where('a.create_by',$customer);
        }else{
            $this->db->where('a.ispublish',2);
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        if($result = $query->result_array()){
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
	    if(isset($barter['offer'])){
	        $this->db->set('offer',$barter['offer']);
	        $this->db->set('price',$barter['price']);
	        $this->db->set('days',$barter['days']);
	        $this->db->set('app_id',$barter['app_id']);
	        $this->db->set('accessory_url',$barter['accessory_url']);
	        $this->db->set('freight',$barter['freight']);
	        $this->db->set('needtax',$barter['needtax']);
	    }else{
	    }
	    $this->db->set('remark',$barter['remark']);
	    $this->db->set('requirement_id',$barter['requirement_id']);
	    $this->db->set('state',0);
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
	    $this->db->select('sum(total_price) as total_price');
	    $this->db->from('requirement');
	    $this->db->where('ispublish',2);
	    $this->db->where('is_putaway',1);
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
	    $this->db->set('title',$this->title);
	    $this->db->set('p_count',$this->p_count);
	    $this->db->set('p_content',$this->explain);
	    $this->db->set('unit',$this->unit);
	    $this->db->set('create_at',date('Y-m-d H:i:s'));
	    $this->db->set('ispublish',1);
	    $this->db->set('receiptdate',$this->receiptdate);
	    $this->db->set('effectdate',$this->effectdate);
	    $this->db->set('shippingaddress',$this->shippingaddress);
	    $this->db->set('img_path',$this->img_path);
	    $this->db->set('cate_id',$this->cate_id);
	    if($this->needtax){
	        $this->db->set('needtax',$this->needtax);
	    }
	    if($this->freight){
	        $this->db->set('freight',$this->freight);
	    }
	    $this->db->set('m_price',$this->m_price);
	    $this->db->set('app_id',$this->app_id);
	    $this->db->set('province_id',$this->province_id);
	    $this->db->set('city_id',$this->city_id);
	    $this->db->set('district_id',$this->district_id);
	    $this->db->where('create_by',$this->session->userdata('user_id'));
	    $this->db->where('id',$id);
	    return $this->db->update('requirement');
	} 

	/**
	* 获取需求标签id
	*/
	public function get_demand_label($id)
	{
		$this->db->where("requirement_id", $id);
		return $this->db->get("requirement_label")->result_array();
	}

	
	/**
	 * 删除标签。
	 */
	public function del_demand_label( $requirement_id = 0 )
	{ 
	    if( !$requirement_id)
	        return false;
	   
        $this->db->where('requirement_id', $requirement_id);
        $this->db->delete('requirement_label'); 
        $this->db->affected_rows();
	}
	/**
	* 获取精确需求
	*/
	public function get_accurate_demand($label_id, $customer_id)
	{
		$this->db->select('pc.name as product_cate_name');
		$this->db->select('p.name as product_name');
		$this->db->select('rq.unit');
		$this->db->select('rq.contactphone');
		$this->db->select('rq.total_price');
		$this->db->select('rg.region_name as province');
		$this->db->select('rc.region_name as city');
		$this->db->select('rd.region_name as district');
		$this->db->select('rq.shippingaddress');
		$this->db->from('requirement as rq');
		$this->db->join('requirement_label as rl', 'rl.requirement_id = rq.id');
		$this->db->join('label as la', 'la.id = rl.label_id');
		$this->db->join('product_label as pl', 'pl.label_id = la.id');
		$this->db->join('product as p', 'p.id = pl.product_id');
		$this->db->join('product_cat as pc', 'pc.id = p.cat_id');
		$this->db->join('customer_label as cl', 'la.id = cl.label_id');
		$this->db->join('customer as cu', 'cu.id = cl.customer_id');
		$this->db->join('region as rg', 'rq.province_id = rg.region_id');
		$this->db->join('region as rc', 'rq.city_id = rc.region_id');
		$this->db->join('region as rd', 'rq.district_id = rd.region_id');
		
		$this->db->where_in('pl.label_id', $label_id);
		$this->db->where('cl.customer_id', $customer_id);
		$result = $this->db->get();
		echo $this->db->last_query();
		return $result->result_array();
	}
	
	
	/**
	 * 批量添加需求对应的标签。
	 * @date:2017年12月7日 上午10:51:32
	 * @author: fxm
	 * @param: variable
	 * @return: boolean
	 */
	public function batch_requirement_label( $data = array() )
	{ 
	    if( !empty( $data ) && is_array( $data ) )
	    { 
	        $this->db->insert_batch('requirement_label', $data);
	        return $this->db->insert_id();
	    }
	    
	    return false;
	}
	   

}