<?php
/**
 * 商品
 *
 *
 */
class Product_mdl extends CI_Model {
	var $productnum;
	var $cat_id;
	var $name;
	var $short_name;
	var $url_alias;
	var $brand_id;
	var $weight;
	var $stock = 0;
	var $market_price = 0;
	var $price = 0;
	var $profits = 0;
	var $commission;
	var $vip_price = 0;
	var $is_special_price = 0;
	var $special_price = 0;
	var $special_price_start_at;
	var $special_price_end_at;
	var $is_on_sale; 
	var $is_new;
	var $is_hot;
	var $is_commend;
	var $is_vip;
	var $is_mc;
	var $short_desc;
	var $desc;
	var $meta_title;
	var $meta_keywords;
	var $meta_desc;
	var $attr_set_id;
	var $in_wechat;
	var $is_gift;
	var $app_id;
	var $section_ids;
	var $m_price = 0;
	var $mix_m_price = 0;
	var $mix_rmb_price = 0;
	var $customer_id;
    var $corporation_id;
    var $sales_count = 0;
	var $fav_count = 0;
	var $longitude;
	var $latitude;
	var $address;
    var $menber_num;
    var $groupbuy_price;
    var $groupbuy_start_at;
    var $groupbuy_end_at;
    var $g_status;
    var $is_freight;
    var $default_item;
    var $default_freight;
    var $add_item;
    var $add_freight;
    var $is_reveal;
    
	function __construct() {
		parent::__construct ();
	}

	// --------------------------------------------------------------------


	/**
	 * load by id
	 */
	function load($id, $app_id = 0) {
		if (! $id) {
			return array ();
		}

		/*$query = $this->db->get_where ( 'product', array (
				'id' => $id,
				'app_id' => $app_id
		) );*/
		$this->db->where("id",$id);
		if ($app_id != 0){
		  $this->db->where("(app_id = ".$app_id." or app_id = 0)");
		}
		$query = $this->db->get("product");

		if ($row = $query->row_array ()) {
			// 图片
			$query1 = $this->db->get_where ( 'product_image', array (
					'product_id' => $id
			) );
			$row1 = $query1->result_array ();
			if (! empty ( $row1 )) {
				$row ['images'] = $row1;
			} else {
				$row ['images'] = array ();
			}
			// 属性
			// $row['attr_list'] = array('sss');

			$this->db->select ( 'a.*,v.attr_value' );
			$this->db->from ( 'product_attr as a' );
			$this->db->join ( 'product_attr_value as v', 'v.attr_id = a.id and v.product_id=' . $id, 'left' );
			// $this->db->where('v.product_id',$id);
			$this->db->where ( 'a.attr_set_id', $row ['attr_set_id'] );
			$this->db->order_by ( "sequence" );
			$query2 = $this->db->get ();

			// $row['attr_list'] = $query2->result_array();
			$rows2 = array ();
			foreach ( $query2->result_array () as $row2 ) {

				$row2 ['option_values_array'] = array ();
				if (! empty ( $row2 ['option_values'] )) {
					// foreach (explode(",",$row2['option_values']) as $k=>$v)
					// {
					// $row2['option_values_array'][] = array('id'=>$v,'name'=>$v);
					// }
					$row2 ['option_values_array'] = explode ( ",", $row2 ['option_values'] );
				}
				if ($row2 ['attr_type'] == 'related') {
					$query_related = $this->db->select ( 'sign_id as id,sign_name as name' )->get_where ( 'sign', array (
							'cate_id' => $row2 ['default_value']
					) );

					$row2 ['option_values_array'] = $query_related->result_array ();
				}
				$rows2 [] = $row2;
			}
			if (! empty ( $rows2 )) {
				$row ['attr_list'] = $rows2;
			} else {
				$row ['attr_list'] = array ();
			}
			// 分类
			$query3 = $this->db->get_where ( 'product_attr_set', array (
					'id' => $row ['cat_id']
			) );
			$row3 = $query3->row_array ();
			if (! empty ( $row3 )) {
				$row ['attr_set_name'] = $row3 ['name'];
			} else {
				$row ['attr_set_name'] = '';
			}



			return $row;
		}

		return array ();
	}
	
	// -------------------------------------------------------------------------------------------------------
	
	/**
	 * 商家产品列表
	 * @param int $corporation_id 企业id
	 * @param int $limit
	 * @param int $offset
	 * @param string $type 类型:sale销售中，notsale待发布,not已售罄 (默认全部)
	 */
	public function getgoodsList($corporation_id,$limit=0,$offset=0,$type=null,$keyword=null){
	    if(!$corporation_id){
	        return array();
	    }
	    $this->db->select("a.*,b.name as cat_name");
	    $this->db->from("product as a");
	    $this->db->join("product_cat as b","a.cat_id = b.id");
	    $this->db->where("a.corporation_id",$corporation_id);
	    $this->db->where("a.is_delete","0");
	    $this->db->like("a.name",$keyword);
	    if($limit){
	        $this->db->limit($limit,$offset);
	    }
	    switch($type){
	        case "sale"://销售中
	            $this->db->where('a.is_on_sale = 1');
	            break;
	        case "notsale"://待发布
	            $this->db->where('a.is_on_sale = 0');
	            break;
	        case "not"://已售罄
	            $this->db->where('a.is_on_sale = 1');
	            $this->db->where('a.stock = 0');
	            break;
	    }
	    $this->db->group_by("a.id");
	    $this->db->order_by("a.id","desc");
	    $query = $this->db->get();
	    if($limit){
	       return $query->result_array();
	    }else{
	        return $query->num_rows();
	    }
	}
	
	// -------------------------------------------------------------------------------------------------------
	
	/**
	 * 商家产品列表
	 * @param int $corporation_id 企业id
	 */
	 public function load_goodsList($corporation_id){
	    if(!$corporation_id){
    	   return array();
    	}
	    $this->db->from("product as a");
	    $this->db->where("a.corporation_id",$corporation_id);
        $this->db->where("a.is_delete","0");
        $this->db->order_by("a.id","desc");
        $query = $this->db->get();
        return $query->result_array();

	}
	
	// -------------------------------------------------------------------------------------------------------

	// 获取联动属性
	private function get_sign_for_selete($cate_id = 0) {
		if (! $cate_id) {
			return array ();
		}
		$return = array ();
		foreach ( $this->get_sign_by_cate ( $cate_id ) as $k => $v ) {
			$return [$k] ['id'] = $v ['sign_id'];
			$return [$k] ['name'] = $v ['sign_name'];
		}
		return $return;
	}
	
	// 获取联动属性
	private function get_sign_by_cate($cate_id) {
		$this->db->from ( 'sign' );
		$this->db->where ( 'cate_id', $cate_id );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	// --------------------------------------------------------------------

	/**
	 * 创建
	 */
	function create() {
		$datetime = date ( 'Y-m-d H:i:s' );
		$this->db->set ( 'fav_count', $this->fav_count );
	    $this->db->set ( 'sales_count', $this->sales_count );
		$this->db->set ( 'productnum', $this->productnum );
		$this->db->set ( 'cat_id', $this->cat_id );
		$this->db->set ( 'name', $this->name );
		$this->db->set ( 'short_name', $this->short_name );
		$this->db->set ( 'url_alias', $this->url_alias );
		$this->db->set ( 'brand_id', $this->brand_id );
		$this->db->set ( 'weight', ($this->weight?$this->weight:0) );
		$this->db->set ( 'stock', $this->stock );
		$this->db->set ( 'market_price', $this->market_price );
		$this->db->set ( 'price', ($this->price?$this->price:"0.00") );
		$this->db->set ( 'm_price', $this->m_price );
		$this->db->set ( 'mix_m_price', $this->mix_m_price );
		$this->db->set ( 'mix_rmb_price', $this->mix_rmb_price );
		$this->db->set ( 'vip_price', $this->vip_price );
		$this->db->set ( 'profits', $this->profits );
		$this->db->set ( 'commission', $this->commission );
		$this->db->set ( 'is_special_price', ($this->is_special_price?$this->is_special_price:0) );
		if(!empty($this->address) ){ 
		    $this->db->set('address',$this->address);
		}
		if (! empty ( $this->special_price ) && $this->is_special_price) {
			$this->db->set ( 'special_price', $this->special_price );
			$this->db->set ( 'special_price_start_at', $this->special_price_start_at );
			$this->db->set ( 'special_price_end_at', $this->special_price_end_at );
		}
		if ($this->is_on_sale) {
			$this->db->set ( 'is_on_sale', $this->is_on_sale );
			$this->db->set ( 'on_sale_at', $datetime );
		}else{
		    $this->db->set ( 'on_sale_at', '2999-12-31 00:00:00' );
		}
		
		$this->db->set ('is_freight',$this->is_freight);
		if($this->is_freight == 1){ 
		    $this->db->set ( 'default_item', $this->default_item );
		    $this->db->set ( 'default_freight', $this->default_freight );
		    $this->db->set ( 'add_item', $this->add_item );
		    $this->db->set ( 'add_freight', $this->add_freight );
		}
		$this->db->set ( 'is_new', ($this->is_new?$this->is_new:1) );
		$this->db->set ( 'is_hot', ($this->is_hot?$this->is_hot:0) );
		$this->db->set ( 'is_commend', ($this->is_commend?$this->is_commend:0) );
		$this->db->set ( 'is_vip', ($this->is_vip?$this->is_vip:0) );
		$this->db->set ( 'is_mc', ($this->is_mc?$this->is_mc:0) );
		$this->db->set ( 'is_gift', ($this->is_gift?$this->is_gift:0) );
		$this->db->set ( 'desc', $this->desc );
		$this->db->set ( 'short_desc', $this->short_desc );
		$this->db->set ( 'meta_title', $this->meta_title );
		$this->db->set ( 'meta_keywords', $this->meta_keywords );
		$this->db->set ( 'meta_desc', $this->meta_desc );
		$this->db->set ( 'attr_set_id', $this->attr_set_id );
		$this->db->set ( 'created_at', $datetime );
		$this->db->set ( 'updated_at', $datetime );
		$this->db->set ( 'app_id', $this->app_id );
		$this->db->set ( 'is_reveal', $this->is_reveal );
		if($this->app_id){
		    $this->db->set ( 'is_nationwide', 0 );
		}else{
		    $this->db->set ( 'is_nationwide', 1 );
		}
		$this->db->set ( 'section_ids', $this->section_ids );
		$this->db->set ( 'in_wechat', ($this->in_wechat?$this->in_wechat:0) );
		$this->db->set ( 'customer_id', $this->customer_id );
		$this->db->set ( 'corporation_id', $this->corporation_id );
		!empty($this->goods_img)?$this->db->set ( 'goods_img', $this->goods_img ):'';
		!empty($this->goods_thumb)?$this->db->set ( 'goods_thumb', $this->goods_thumb ):'';
		if ($this->is_on_sale) {
			$this->db->set ( 'on_sale_at', $datetime );
		}
		if($this->longitude && $this->latitude){
		    $this->db->set ( 'longitude', $this->longitude);
		    $this->db->set ( 'latitude', $this->latitude);
		}


		$this->db->insert ( 'product' );

		return $this->db->insert_id ();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 新建产品
	 * @param array 数据集合
	 */
	public function add($data){
	    $this->db->insert ('product',$data);
	    return $this->db->insert_id();
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * 更新产品
	 * @param int $product_id 产品id
	 * @param array $data 数据集合
	 */
	public function save($product_id,$data){
	    $this->db->where("id",$product_id);
	    $this->db->update('product',$data);
	    return $this->db->affected_rows();
	}

	// --------------------------------------------------------------------

	/**
	 * 结果集
	 */
	function find_products($options = array(), $count = 20, $offset = 0, $is_delete = 0,$status=null) {
		if (! is_array ( $options )) {
			return array ();
		}

		if ($count) {
			$this->db->limit ( ( int ) $count, ( int ) $offset );
		}

		// 产品
		$this->db->select ( 'p.*' );
		// 类型
		$this->db->select ( 'c.name as cat_name' );
		// 默认图
		$this->db->select ( 'i.file as image_url' );
		// 品牌商
		$this->db->select ( 'a.app_name as app_name' );


		$query = $this->_query_products ( $options, $is_delete ,$status);
// 		echo $this->db->last_query();exit;
		$rows = array ();
		if(isset($options['row']) == true){
		    $rows = $query->row_array ();
		}else{
		    $rows = $query->result_array ();
		}
		return $rows;
	}

	// --------------------------------------------------------------------

	/**
	 * 统计等待上架的商品数量
	 */
	public function count_wait_product( $customer_id ){
	    $status = 0;

	    $this->db->select ( 'COUNT(DISTINCT(id)) as total' );

	    $this->db->from ( 'product' );

	    $this->db->where ( 'is_on_sale', $status );

	    $this->db->where ( 'customer_id', $customer_id );

	    $query = $this->db->get ();

	    $total = 0;
	    if ($row = $query->row_array ()) {
	        $total = ( int ) $row ['total'];
	    }
	    return $total;
	}

	/**
	 * 更新
	 */
	function update($id) {
		$datetime = date ( 'Y-m-d H:i:s' );
		$this->db->set ( 'fav_count', $this->fav_count );
		$this->db->set ( 'sales_count', $this->sales_count );
		$this->db->set ( 'cat_id', $this->cat_id );
		$this->db->set ( 'name', $this->name );
		$this->db->set ( 'short_name', $this->short_name );
		$this->db->set ( 'url_alias', $this->url_alias );
		$this->db->set ( 'brand_id', $this->brand_id );
		$this->db->set ( 'weight', $this->weight );
		$this->db->set ( 'stock', $this->stock );
		$this->db->set ( 'market_price', $this->market_price );
		$this->db->set ( 'price', $this->price==""?0:$this->price );
		$this->db->set ( 'm_price', $this->m_price );
		$this->db->set ( 'mix_m_price', $this->mix_m_price );
		$this->db->set ( 'mix_rmb_price', $this->mix_rmb_price );
		$this->db->set ( 'vip_price', $this->vip_price );
		$this->db->set ( 'profits', $this->profits );
		$this->db->set ( 'commission', $this->commission );

		$this->db->set('address',$this->address?$this->address:null);

		if ($this->is_special_price) {
			$this->db->set ( 'is_special_price', $this->is_special_price );
			$this->db->set ( 'special_price', $this->special_price );
			$this->db->set ( 'special_price_start_at', $this->special_price_start_at );
			$this->db->set ( 'special_price_end_at', $this->special_price_end_at );
		} else {
			$this->db->set ( 'is_special_price', 0 );
			$this->db->set ( 'special_price', 0.00 );
			$this->db->set ( 'special_price_start_at', '1970-01-01 08:00:00' );
			$this->db->set ( 'special_price_end_at', '1970-01-01 08:00:00' );
		}
		
		$this->db->set ('is_freight',$this->is_freight);
		if($this->is_freight == 1){
		    $this->db->set ( 'default_item', $this->default_item );
		    $this->db->set ( 'default_freight', $this->default_freight );
		    $this->db->set ( 'add_item', $this->add_item );
		    $this->db->set ( 'add_freight', $this->add_freight );
		}
		
		$this->db->set ( 'is_on_sale', $this->is_on_sale );
		$this->db->set ( 'is_new', $this->is_new );
		$this->db->set ( 'is_hot', $this->is_hot );
		$this->db->set ( 'is_commend', $this->is_commend );
		$this->db->set ( 'is_vip', $this->is_vip );
		$this->db->set ( 'is_mc', $this->is_mc );
		$this->db->set ( 'is_gift', $this->is_gift );
		$this->db->set ( 'desc', $this->desc );
		$this->db->set ( 'short_desc', $this->short_desc );
		$this->db->set ( 'meta_title', $this->meta_title );
		$this->db->set ( 'meta_keywords', $this->meta_keywords );
		$this->db->set ( 'meta_desc', $this->meta_desc );
		$this->db->set ( 'attr_set_id', $this->attr_set_id );
		$this->db->set ( 'updated_at', $datetime );
		$this->db->set ( 'in_wechat', $this->in_wechat );
		$this->db->set ( 'section_ids', $this->section_ids );
		$this->db->set ( 'is_reveal', $this->is_reveal );
		
		if(isset($this->app_id)&&$this->app_id!=null){
		    $this->db->set("app_id",$this->app_id);
		}else{ 
		    $this->db->set("app_id",0);
		}
		!empty($this->goods_img)?$this->db->set ( 'goods_img', $this->goods_img ):'';
		!empty($this->goods_thumb)?$this->db->set ( 'goods_thumb', $this->goods_thumb ):'';
		$product = $this->load ( $id, $this->app_id );
		if ($this->is_on_sale && $product ['is_on_sale'] == 0) {
			$this->db->set ( 'on_sale_at', $datetime );
		} //else if (! $this->is_on_sale) {
			//$this->db->set ( 'on_sale_at', '0000-00-00 00:00:00' );
		//}

    	    $this->db->set ( 'longitude', $this->longitude?$this->longitude:null);
    	    $this->db->set ( 'latitude', $this->latitude?$this->latitude:null);

	    if($this->app_id){
	        $this->db->set ( 'is_nationwide', 0 );
	    }else{
	        $this->db->set ( 'is_nationwide', 1 );
	    }

		$this->db->where ( 'id', $id );
		return $this->db->update ( 'product' );
	}

	// --------------------------------------------------------------------

	/**
	 * 删除
	 */
	function delete($id, $app_id) {
	    /*$this->db->where_in('product_id', $id);
	    $query = $this->db->get('product_image');
	    $row = $query->result_array();*/

	    $this->db->set('is_delete',1);
		$this->db->where_in ( 'id', $id );
// 		$this->db->where ( 'app_id', $app_id );
		$c = $this->db->delete ( 'product' );

		/*if ($c > 0) {
		    if(count($row)>0){
    		    foreach ($row as $v){//删除本地图片
    		        file_exists($v['file'])?unlink($v['file']):'';
    		        file_exists($v['image_name'].'_270'.$v['file_ext'])?unlink($v['image_name'].'_270'.$v['file_ext']):'';
    		        file_exists($v['image_name'].'_290'.$v['file_ext'])?unlink($v['image_name'].'_290'.$v['file_ext']):'';
    		        file_exists($v['image_name'].'_670'.$v['file_ext'])?unlink($v['image_name'].'_670'.$v['file_ext']):'';
    		    }
		    }

			// 删除图片
			$this->db->where_in ( 'product_id', $id );
			$this->db->delete ( 'product_image' );
			// 删除属性值
			$this->db->where_in ( 'product_id', $id );
			$this->db->delete ( 'product_attr_value' );
		}*/

		return $c;
	}

	// --------------------------------------------------------------------

	/**
	 * 获取最新添加的数据
	 */
	function get_newly_one() {
		$this->db->from ( 'product' );
		$this->db->order_by ( "id", "desc" );
		$this->db->limit ( '1' );
		$query = $this->db->get ();
		return $query->row_array ();
	}

	// --------------------------------------------------------------------

	/**
	 * 私有函数
	 */
	function _query_products($options = null, $is_delete,$status=null) {
		$this->db->from ( 'product as p' );
// 		$this->db->join ( 'product_brand as b', 'b.id = p.brand_id', 'left outer' );
		$this->db->join ( 'product_cat as c', 'c.id = p.cat_id', 'left outer' );
		$this->db->join ( 'product_image as i', 'p.id = i.product_id and i.is_base = 1', 'left outer' );
		$this->db->join ( 'app_info as a', 'p.app_id = a.id', 'left outer' );
		$this->db->where ( 'is_delete', $is_delete );

//         if(!isset( $options['customer_id'] ) ){
// 		    $this->db->where ( 'customer_id', $this->session->userdata('user_id') );
//         }else{
//             $this->db->where ( 'customer_id', $options['customer_id'] );
//         }
        if(!isset($options['corporation_id']) ){
		    $this->db->where ( 'corporation_id', (int)$this->session->userdata('corporation_id') );
        }else{
            $this->db->where ( 'corporation_id', (int)$options['corporation_id'] );
        }

		if (! empty ( $options ['conditions'] )) {
			foreach ( $options ['conditions'] as $key => $value ) :
				switch ($key) {
					case 'p.cat_id' :
						$this->db->where_in ( $key, $value );
						break;
					case 'p.name' :
						$this->db->like ( $key, $value );
						break;
					case 'p.sale_start_at' :
						$this->db->where ( 'on_sale_at >', $value );
						break;
					case 'p.sale_end_at' :
						$this->db->where ( 'on_sale_at <', $value );
						break;
					case 'main_section' :
						$this->db->like ( 'main_section', $value );
						break;
					case 'p.id' :
					    $this->db->where ( 'p.id', $value );
					    break;
					case 'p.is_mc' :
					 $this->db->where ( 'p.is_mc', $value );
					 break;

					case 'p.app_id':
					    $this->db->where ( '(p.app_id = '. $value." or p.app_id =0)" );
					    break;
					default :
						$status?null:$this->db->where ( $key, $value );
						break;
				}
			endforeach
			;
		}

		// 商品状态查询 not 为售磬,sale为售中，notsale为待发布
		if(!empty($options['type'])){

		    switch ($options['type']){
		        case 'not':
		            $this->db->where('p.is_on_sale = 1');
		            $this->db->where('p.stock = 0');
		            break;
		        case 'sale':
		            $this->db->where('p.is_on_sale = 1');
		            $this->db->where('p.stock != 0');
		            break;
		        case 'notsale':
		            $this->db->where('p.is_on_sale = 0');
		            $this->db->where('p.stock != 0');
		            break;

		    }

		}

		if (isset ( $options ['order'] ) && $options ['order'] != "") {
			$this->db->order_by ( $options ['order'] );
		} else {
			$this->db->order_by ( 'p.id DESC' );
		}
		return $this->db->get ();

		//print_r($this->db->last_query()."<br/>");
		//return $returns;

	}

	// --------------------------------------------------------------------

	/**
	 * 总数
	 */
	function count_products($options = array(), $is_delete = 0) {
		$this->db->select ( 'COUNT(DISTINCT(p.id)) as total' );

		$query = $this->_query_products ( $options, $is_delete );

		$total = 0;
		if ($row = $query->row_array ()) {
			$total = ( int ) $row ['total'];
		}
// 		echo $this->db->last_query();
		return $total;
	}

	// --------------------------------------------------------------------

	/**
	 * 入回收站
	 */
	function in_recycle($id, $app_id) {
		$this->db->set ( 'is_delete', 1 );
		$this->db->where ( 'id', $id );
		$this->db->where ( 'app_id', $app_id );
		return $this->db->update ( 'product' );
	}

	// --------------------------------------------------------------------

	/**
	 * 出回收站
	 */
	function out_recycle($id, $app_id) {
		$this->db->set ( 'is_delete', 0 );
		$this->db->where ( 'id', $id );
		$this->db->where ( 'app_id', $app_id );
		return $this->db->update ( 'product' );
	}

	// --------------------------------------------------------------------

	/**
	 * 更新单个字段
	 */
	function update_one($fields = array(), $id) {
		$this->db->set ( key ( $fields ), current ( $fields ) );
		$this->db->where ( 'id', $id );
		$this->db->update ( 'product' );

		$this->db->select ( key ( $fields ) );
		$this->db->where ( 'id', $id );
		$query = $this->db->get ( 'product' );
		$field = $query->row_array ();
		return $field [key ( $fields )];
	}

	// --------------------------------------------------------------------

	/**
	 * 查询某分类下是否有商品
	 */
	function check_product_by_cat($cat_id) {
		$this->db->select ( 'id' );
		$query = $this->db->get_where ( 'product', array (
				'cat_id' => $cat_id
		) );
		return $query->row_array ();
	}
	public function loadById($id) {
		$this->db->from ( 'product' );
		$this->db->where ( 'id', $id );
		$query = $this->db->get ();
		return $query->row_array ();
	}

	private function findByIds($ids, $app_id) {
		$this->db->from ( 'product' );
		$this->db->where_in ( 'id', $ids );
		$this->db->where ( "app_id", $app_id );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	//  --------------------------------------------------------------------------------------------
	
	/**
	 * 检查产品编号
	 * @param string $num
	 */
	function checkProductNum($num) {
		$this->db->from ( 'product' );
		$this->db->where ( 'productnum', $num );
		$query = $this->db->get ();
		return $query->result_array ();
	}
	
	//  --------------------------------------------------------------------------------------------

    /**
     * 前台商品&&商品搜索
     */
    public function product_list( $name ){
        // 产品
		$this->db->select ( 'p.name,p.id' );
		// 品牌
// 		$this->db->select ( 'b.name as brand_name' );
		// 类型
		$this->db->select ( 'c.name as cat_name' );
		// 默认图
		$this->db->select ( 'i.file as image_url' );
		// 品牌商
		$this->db->select ( 'a.app_name as app_name' );
		$this->db->from ( 'product as p' );
		$this->db->join ( 'product_brand as b', 'b.id = p.brand_id', 'left outer' );
		$this->db->join ( 'product_cat as c', 'c.id = p.cat_id', 'left outer' );
		$this->db->join ( 'product_image as i', 'p.id = i.product_id and i.is_base = 1', 'left outer' );
		$this->db->join ( 'app_info as a', 'p.app_id = a.id', 'left outer' );
		$this->db->like ( 'p.name',$name );
		$this->db->or_like('c.name', $name );
		$query = $this->db->get();
		//echo $this->db->last_query();
		$rows = $query->result_array ();
		return $rows;
    }

    /**
     * 商品上下架
     * @param $data 商品id
     */
    function is_on_sale($data){
        @$this->db->update_batch('product', $data, 'id');
        return $this->db->affected_rows();
    }

	/**
	*
	*修改商品上下架狀態
	**/
	function updateSaleStatus($id,$status,$corp_id)
	{
		$this->db->where(array("id"=>$id,"corp_id"=>$corp_id));
		if($status == 1)
		{
			 $this->db->set('on_sale_at',date('Y-m-d H:i:s'));
		}
		$this->db->set('is_on_sale',$status);
		$res = $this->db->update('product');
        return $res;

	}

	/**
	 * 收藏量最多的商品 5个。
	 */
    function hot_product(){
        //$this->db->select('id,fav_count, name');
        $this->db->from('product');
        $this->db->where('corporation_id',$this->corporation_id);
        $this->db->where('is_on_sale','1');
        $this->db->where('is_delete','0');
        $this->db->order_by('fav_count','desc');
        $this->db->limit(5,0);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    /**
     * 销售量最多的商品 5个。
     */
    function sales_product(){
        //$this->db->select('id,fav_count, name');
        $this->db->from('product');
        $this->db->where('corporation_id',$this->corporation_id);
        $this->db->where('is_on_sale','1');
        $this->db->where('is_delete','0');
        $this->db->order_by('sales_count','desc');
        $this->db->limit(5,0);
        $query = $this->db->get();
        $result = $query->result_array();

        return $result;
    }

    /**
     * 查询指定分类的商品
     */
    function shop_classify_list( $section_ids ,$app_id = null,$limit = 0,$offset = 0,$status=null){

        $where_string = "";

        if (count($section_ids) < 2) {
            $sp_id = array($section_ids);
        }
        $i = 0;
        foreach ($section_ids as $cat_id) {
            if ($i == 0) {
                $where_string .= "( section_ids like '%".$cat_id."%'";
                //$this->db->like('c.path', $cat_id, 'after');
            } else {
                //$this->db->or_like('c.path', $cat_id, 'after');
                $where_string .= " or section_ids like '%".$cat_id."%'";

            }
            $i++;
        }
        $where_string .= ")";
        $this->db->where($where_string);
        $this->db->where('corporation_id',$this->corporation_id);
        $this->db->where('is_mc','0');
        if($app_id)
            $this->db->where("(app_id = ".$app_id." or app_id = 0)");
        if($limit)
            $this->db->limit($limit,$offset);
        $this->db->where('`is_on_sale` = 1 AND `is_delete` = "0" ORDER BY `on_sale_at` DESC');
        
        $query = $this->db->get('product');
        if(!$status){
            $result = $query->result_array();
        }else{ 
            $result = $query->num_rows();
        }
        return $result;
    }

    // ---------------------------------------------------------------------------------------------------
    
    /**
     * 修改商品库存
     * @param int $id 产品id
     * @param number $qty 扣除的库存数
     */
    public function update_stock($id,$qty){
        $this->db->set('stock','stock-'.$qty,false);
        $this->db->where("(stock - $qty) >=",0,false);
        $this->db->where('id',$id);
        $this->db->update('product');
        return $this->db->affected_rows();
    }
    
    // ---------------------------------------------------------------------------------------------------

    /**
     * 修改商品库存
     */
    public function update_add_stock($id,$qty){
        $this->db->set('stock','stock+'.$qty,false);
        $this->db->where('id',$id);
        $this->db->update('product');
        return $this->db->affected_rows();
    }
    
    
    /**
     * 将某个商品设置为二维码商品
     * @param int $id 商品id
     * @param int $status 状态
     * @param int $corporation_id 企业id
     */
    public function update_is_mc( $id, $status,$corporation_id = 0){
        $this->db->set('is_mc',$status);
        $this->db->where('id',$id);
        if($corporation_id){
            $this->db->where("corporation_id",$corporation_id);
        }
        $this->db->update('product');
        return $this->db->affected_rows();
    }
    
    
    /**
    * @author JF
    * 2017年12月6日
    * 取消某个企业的所有二维码商品
    * @param int $product_id 商品id
    * @param int $corporation_id 企业id
    */
    function cancel_is_mc($corporation_id){
        $this->db->set("is_mc",0);
        $this->db->where("corporation_id",$corporation_id);
        $this->db->update('product');
        return $this->db->affected_rows();
    }
    
    /**
     * 更改商品特价状态
     * @param int $pid 商品id
     */
    public function update_special_statu($pid){
        $this->db->set ( 'is_special_price', $this->is_special_price );
        $this->db->where('id',$pid);
        return $this->db->update ( 'product' );
    }
    
    /**
     * 更改商品特价状态
     * @param int $pid 商品id
     */
    public function update_activity_status($pid){
        $this->db->set ( 'is_special_price', $this->is_special_price );
        $this->db->where('id',$pid);
        return $this->db->update ( 'product' );
    }
    
    /**
     * 根据商品id查询商品信息
     * @param $pid 商品id
     * @param $app_id 站点id
     */
    public function product_info($pid,$app_id=null){
       if(!$pid){
           return array();
       }
        $this->db->from('product');
        $this->db->where('is_on_sale',1);
        $this->db->where('is_delete',0);
        $this->db->where('is_mc',0);
        $this->db->where('id',$pid);
        if($app_id){
            $this->db->where("(app_id = ".$app_id." or app_id = 0)");
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    
    //晒选查询商品
    public function load_sales($sift = array() ){ 
        
        
        $this->db->select ( '*' );
        
        $this->db->from ( 'product' );
        
        if( isset($sift['is_on_sale']) )//上架状态
            $this->db->where ( 'is_on_sale', $sift['is_on_sale'] );
        
        if( isset($sift['corporation_id']) )//店铺ID
            $this->db->where ( 'corporation_id', $sift['corporation_id'] );
        
        if( isset($sift['groupbuy_end_at']) ){//如果有设置团购商品要已经结束的才能继续设置。过期
            $this->db->where ( '(groupbuy_end_at < ', $sift['groupbuy_end_at'] );
            $this->db->or_where ( 'groupbuy_end_at  is null )' );
        }

        if( isset($sift['is_groupbuy']) )//是否团购
            $this->db->where ('is_groupbuy',$sift['is_groupbuy']);
            
        if( isset($sift['stock']) ) //库存不等于0
            $this->db->where ('stock !=','0');
        
        if( isset($sift['is_groupbuy_not_null']) )//有拼团状态的
            $this->db->where ("is_groupbuy!=","' '",false);
        
        $this->db->where ('is_delete','0');
        $query = $this->db->get ();
//         echo $this->db->last_query();
        $result = $query->result_array ();
        return $result;
    }
    
    //批量修改状态
    public function uodate_bath_activity_status($data){ 
        @$this->db->update_batch('product', $data, 'id');
        return $this->db->affected_rows();
    }
    
    //检测拼团状态某个商品是否
    function is_is_groupbuy($sift = array() ){
        $this->db->from('product');
        $this->db->where('is_on_sale',1);
        $this->db->where('is_delete',0);
        
        if(isset($sift['is_groupbuy']))
            $this->db->where('is_groupbuy',$sift['is_groupbuy']);
        if(isset($sift['corporation_id']))
            $this->db->where('corporation_id',$sift['corporation_id']);
        
        $this->db->where('id',$sift['id']);
        $query = $this->db->get();
        return $query->row_array();
    }

    //根据订单ID查询商品-单个
    function item_product($order_id){
        $this->db->select('p.*');
        $this->db->from('product as p');
        $this->db->join('order_item as oi','oi.product_id = p.id');
        $this->db->where('oi.order_id',$order_id);  
        return  $this->db->get()->row_array();      
    }
    
    //根据订单号查询商品-单个
    function item_product_order_sn($order_sn){
        $this->db->select('o.*,oi.product_id,oi.quantity');
        $this->db->from('order as o');
        $this->db->join('order_item as oi','oi.order_id = o.id');
        $this->db->where('o.order_sn',$order_sn);
        return  $this->db->get()->row_array();
    }
    
    /*
     *
     * 简易店查询列表
     * $tribe_id 为0，则为商城，其它为部落
     */
    public function tribe_search_list ($tribe_id,$types,$keyword,$offest,$limit) {
        if ($tribe_id == '0') {
            switch ($types) {
                case "1":
                    $query = $this->db->query("select a.* ,sum(b.quantity) as volume,any_value(c.path) from 9thleaf_easy_product as a
                    left join  9thleaf_easy_order as b on a.id  = b.product_id and b.status in ('4','5')
                    left join 9thleaf_easy_product_img as c on a.id = c.product_id and c.type = 1
                    where a.product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    group by a.id  order by volume asc limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "2":
                    $query = $this->db->query("select a.* ,sum(b.quantity) as volume,any_value(c.path) from 9thleaf_easy_product as a
                    left join  9thleaf_easy_order as b on a.id  = b.product_id  and b.status in ('4','5')
                    left join 9thleaf_easy_product_img as c on a.id = c.product_id and c.type = 1
                    where a.product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    group by a.id  order by volume desc limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "3":
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1
                    where product_name like '%".$this->db->escape_like_str($keyword)."%'ESCAPE '!'
                    order by price ASC
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "4":
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1
                    where product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    order by price desc
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "5":
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1
                    where product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
                default :
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
                    break;
            }
        } else {
            switch ($types) {
                case "1":
                    $query = $this->db->query("select a.* ,sum(b.quantity) as volume,any_value(c.path) from 9thleaf_easy_product as a
                    left join  9thleaf_easy_order as b on a.id  = b.product_id and b.status in ('4','5')
                    left join 9thleaf_easy_product_img as c on a.id = c.product_id and c.type = 1
                    where a.tribe_id = $tribe_id and is_on_sale = 1 and a.product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    group by a.id  order by volume asc limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "2":
                    $query = $this->db->query("select a.* ,sum(b.quantity) as volume,any_value(c.path) from 9thleaf_easy_product as a
                    left join  9thleaf_easy_order as b on a.id  = b.product_id and b.status in ('4','5')
                    left join 9thleaf_easy_product_img as c on a.id = c.product_id and c.type = 1
                    where a.tribe_id = $tribe_id and is_on_sale = 1 and a.product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    group by a.id  order by volume desc limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "3":
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1
                    where tribe_id = $tribe_id and is_on_sale = 1 and product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    order by price ASC
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "4":
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1
                    where tribe_id = $tribe_id and is_on_sale = 1 and product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    order by price desc
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
                case "5":
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1 and a.is_on_sale = 1
                    where tribe_id = $tribe_id and is_on_sale = 1 and product_name like '%".$this->db->escape_like_str($keyword)."%' ESCAPE '!'
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
                default :
                    $query = $this->db->query("select a.*,b.path as img_path from 9thleaf_easy_product as a
                    left join 9thleaf_easy_product_img as b on a.id = b.product_id
                    and type = 1
                    where tribe_id = $tribe_id and is_on_sale = 1
                    limit $offest,$limit");
                    return $query->result_array();
                    break;
            }
            
        }
    }
    
    /*
     *
     * 获取简易店商品的轮播图及数据
     */
    public function goods_img_detail ($id) {
        $this->db->select('easy_product.*,easy_product_img.path as img_path');
        $this->db->join('easy_product_img','easy_product_img.product_id = easy_product.id', 'left');
        $this->db->where('easy_product.id',$id);
        $this->db->from('easy_product');
        $query = $this->db->get();
        return $query->result_array();
    }
}