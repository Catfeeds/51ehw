<?php

/**
 *
 *
 *
 */
class Goods_mdl extends CI_Model
{

    var $mark;
    var $sequence;
    /**
     * 构造函数
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * 通过ID获得商品
     *
     * @param unknown $id
     * @param string $select
     * @param string $status
     */
    public function get_by_id($id, $select = null ,$status = null ,$activity = null)
    {
        if (! $id) {
            return array();
        }
        
        $select .= "p.*, i.width, i.height, i.file,i.is_base";
        
        $this->db->select($select);
        $this->db->from('product p');
        $this->db->join('product_image i', 'i.product_id = p.id and i.is_base = 1', 'left');
        // $this->db->where('i.is_base', 1); // 默认图片
        $this->db->where('p.is_on_sale', 1); // 上架的
        $this->db->where('p.is_delete', 0); // 不在回收站的
        $this->db->where('p.is_mc', 0); // 不是二维码商品
        $this->db->where_in('p.id', $id);
        if( $this->session->userdata("app_info")['id'] )
            $this->db->where_in('p.app_id',array(0,$this->session->userdata("app_info")['id']) );
        if ($activity) {
            $this->db->join('activity_record a', 'a.product_id = p.id and a.activity_num = p.activity_num', 'left');
        }
        $query = $this->db->get();
        
        if ($status) {
            return $row = $query->result_array();
        }
        
        if ($row = $query->row_array()) {
            return $row;
        }
        return array();
    }
    
    //----------------------------------------------------------------
    
    
    /**
     * 根据商品id查询商品信息
     * @param int $id 商品id
     */
    public function load($id)
    {
        $app_id = $this->session->userdata("app_info")['id'];
        
        $this->db->from('product p');
        $this->db->where('p.id', $id);
        $this->db->where('p.is_mc', 0); // 不是二维码商品
        if( $app_id ){
            $this->db->where_in('p.app_id',array(0,$app_id));
        }
        $query = $this->db->get();
        return $query->row_array();
    }
    
    //----------------------------------------------------------------
    
    /**
     * 根据商品id查询商品图片
     * @param unknown $id
     */
    public function get_gallery($id)
    {
        $this->db->where('product_id', $id);
        $this->db->from('product_image');
        $this->db->order_by('sort_order');
        $this->db->order_by('is_base', 'desc');
        return $this->db->get()->result_array();
    }
    
    //----------------------------------------------------------------

    public function get_lists($cate_ids = array(), $options = array(), $limit = 0, $offset = 0, $select = null)
    {
        if (empty($cate_ids) || ! is_array($cate_ids)) {
            return array();
        }
        
        if ($select)
            $this->db->select($select);
        
        if ($limit)
            $this->db->limit($limit);
        if ($offset)
            $this->db->offset($offset);
        
        $query = $this->_query_goods_by_category($cate_ids, $options);

        return $query->result_array();
    }

    public function get_lists_count($cate_ids = array(), $options = array(), $limit = 0, $offset = 0, $select = null)
    {
        if (empty($cate_ids) || ! is_array($cate_ids)) {
            return array();
        }
        
        if ($select)
            $this->db->select($select);
        
        if ($limit)
            $this->db->limit($limit);
        if ($offset)
            $this->db->offset($offset);
        
        $query = $this->_query_goods_by_category($cate_ids, $options);
        
        return $query->count_all_results();
    }

    /**
     * 私有函数
     */
    private function _query_goods_by_category($category_ids = array(), $options = array())
    {
        // 排序
        if (array_key_exists('order', $options)) {
            switch ($options['order']) {
                case 'price_up':
                    $this->db->order_by('p.price ASC');
                    break;
                case 'price_down':
                    $this->db->order_by('p.price DESC');
                    break;
                case 'osa':
                    $this->db->order_by('p.on_sale_at DESC');
                    break;
                default:
                    $this->db->order_by('p.on_sale_at DESC');
            }
        }

        // 按状态查询
        if (array_key_exists('recommend', $options)) {
            switch ($options['recommend']) {
                case 'new':
                    $this->db->where('p.is_new', 1);
                    break; // 新品
                case 'hot':
                    $this->db->where('p.is_hot', 1);
                    break; // 热销
                case 'spe':
                    $this->db->where('p.is_special_price', 1);
                    break; // 特价
                case 'cnd':
                    $this->db->where('p.is_commend', 1);
                    break; // 推荐

                default:
                    $this->db->where('p.is_new', 1);
                    ;
            }
        }

        if (array_key_exists('main_section', $options)) {
            $this->db->like('p.main_section', $options['main_section']);
        }

        $this->db->select('p.*, i.width, i.height, i.file');
        $this->db->from('product p');
        $this->db->join('product_image i', 'i.product_id = p.id', 'left');
        $this->db->where('i.is_base', 1); // 默认图片
        $this->db->where_in('p.cat_id', $category_ids); // 某分类下的
        $this->db->where('p.is_on_sale', 1); // 上架的
        $this->db->where('p.is_delete', 0); // 不在回收站的

        return $this->db->get();
    }

    public function get_lists_by_condition($cate_id, $attrs = array(), $options = array(), $select)
    {
        if ($select) {
            $select_array = explode(',', $select);
            foreach ($select_array as $k => $v) {
                $select_array[$k] = 'product.' . $v;
            }
            $select = implode(',', $select_array);
        } else {
            
            $select = "product.*";
        }
        
        $this->db->select($select . ",sign_name,sign_id,cate_id");
        
        // 排序
        if (array_key_exists('order', $options)) {
            switch ($options['order']) {
                case 'price_up':
                    $this->db->order_by('attr_value asc,price ASC');
                    break;
                case 'price_down':
                    $this->db->order_by('attr_value asc,price DESC');
                    break;
                case 'osa':
                    $this->db->order_by('attr_value asc,on_sale_at DESC');
                    break;
                default:
                    $this->db->order_by('attr_value asc,on_sale_at DESC');
            }
        }
        
        // 按状态查询
        if (array_key_exists('recommend', $options)) {
            switch ($options['recommend']) {
                case 'new':
                    $this->db->where('is_new', 1);
                    break; // 新品
                case 'hot':
                    $this->db->where('is_hot', 1);
                    break; // 热销
                case 'spe':
                    $this->db->where('is_special_price', 1);
                    break; // 特价
                case 'cnd':
                    $this->db->where('is_commend', 1);
                    break; // 推荐
                default:
                    $this->db->where('is_new', 1);
                    ;
            }
        }
        
        if (array_key_exists('main_section', $options)) {
            $this->db->like('main_section', $options['main_section']);
        }
        
        $this->db->from('product');
        
        foreach ($attrs as $key => $attr) {
            $this->db->join('(select sign_name,attr_value,product_id,attr_id,sign_id,cate_id from lcn_product_attr_value,lcn_sign where attr_value = lcn_sign.sign_id) as a', 'product.id=a.product_id');
            $this->db->where('a.attr_id', $attr);
        }
        
        if ($cate_id) {
            $this->db->where('cat_id', $cate_id);
        }
        
        $this->db->where('is_on_sale', 1); // 上架的
        $this->db->where('is_delete', 0); // 不在回收站的
        
        $return_arr = $this->db->get()->result_array();
        
        error_log($this->db->last_query());
        
        return $return_arr;
    }

    /**
     * goods 列表页查询
     *
     * @param number $limit
     * @param number $offset
     * @param unknown $cate_id
     * @param unknown $attrs
     * @param unknown $options
     * @param unknown $select
     * @param unknown $wherein
     * @return unknown
     */
    public function get_lists_with_condition($limit = 0, $offset = 0, $cate_id, $attrs = array(), $options = array(), $select = "", $wherein = array(), $app_id = 0, $customer_id = 0, $section_id = 0, $corporation_id = 0)
    {
        $path = "";
        // 是否深度搜索
        if ($cate_id != 0 && ! is_array($cate_id)) {
            $cate = $this->db->get_where('product_cat', array(
                'id' => $cate_id
            ))->row_array();
            if ($cate != null) {
                $path = $cate['path'];
            }
        }
 

        
        if ($select != "") {
            $select = $select . ",i.width, i.height, i.image_name,i.file_ext,pc.path";
        } else {
            $select = "p.*, i.width, i.height, i.image_name,i.file_ext";
        }
       
        $this->db->select($select);
        
        $this->db->from('product p');
        $this->db->join('product_image i', 'i.product_id = p.id and i.is_base = 1', 'left');
        $this->db->join('product_cat pc', 'pc.id = p.cat_id', 'left');
        
        $mark = $this->mark; // 唯一识别
                             // 查询商品总评价数量
        if ($mark == 'search') {
            $this->db->join('(SELECT oi.product_id,count(oi.product_id) as comment_total FROM 9thleaf_order_comments AS oc JOIN 9thleaf_order_item AS oi on oc.orderitem_id = oi.id WHERE oc.status=1 GROUP BY oi.product_id) oc', 'oc.product_id=p.id', 'left');
        }
        
        // 排序
        if (array_key_exists('order', $options)) {
            switch ($options['order']) {
                case 'price_up':
                    $this->db->order_by('price ASC');
                    break;
                case 'price_down':
                    $this->db->order_by('price DESC');
                    break;
                case 'm_price_up':
                    $this->db->order_by('m_price ASC');
                    break;
                case 'm_price_down':
                    $this->db->order_by('m_price DESC');
                    break;
                case 'vip_price_up':
                    $this->db->order_by('vip_price ASC');
                    break;
                case 'vip_price_down':
                    $this->db->order_by('vip_price DESC');
                    break;
                case 'onsale_up':
                    $this->db->order_by('on_sale_at ASC');
                    break;
                case 'onsale_down':
                    $this->db->order_by('on_sale_at Desc');
                    break;
                case 'sale_count_up':
                    $this->db->order_by('sales_count ASC');
                    break;
                case 'sale_count_down':
                    $this->db->order_by('sales_count Desc');
                    break;
                case 'recommend_up':
                    $this->db->order_by('is_commend ASC');
                    break;
                case 'recommend_down':
                    $this->db->order_by('is_commend Desc');
                    break;
                case 'updated_at_down':
                    $this->db->order_by('p.updated_at ASC', false);
                    break;
                case 'updated_at_up':
                    $this->db->order_by('p.updated_at Desc', false);
                    break;
                case 'near_distance':
                    $this->db->where("latitude is not null");
                    $this->db->where("`latitude` <> 0");
                    // 直角三角形边长公式 c²=a²+b²;a+b!=c
                    $this->db->order_by("abs(p.`latitude`-" . $options['location']['latitude'] . ")*abs(p.`latitude`-" . $options['location']['latitude'] . ") + abs(p.longitude-" . $options['location']['longitude'] . ")*abs(p.longitude-" . $options['location']['longitude'] . ")", "asc");
                    break;
                case 'far_distance':
                    $this->db->where("`latitude` is not null");
                    $this->db->where("`latitude` <> 0");
                    // 直角三角形边长公式 c²=a²+b²;a+b!=c
                    $this->db->order_by("abs(p.`latitude`-" . $options['location']['latitude'] . ")*abs(p.`latitude`-" . $options['location']['latitude'] . ") + abs(p.longitude-" . $options['location']['longitude'] . ")*abs(p.longitude-" . $options['location']['longitude'] . ")", "desc");
                    break;
                default:
                    $this->db->order_by('sequence,hits,on_sale_at' ,'DESC');
            }
            $this->db->order_by('id');
        }
        
        // 按状态查询
        if (array_key_exists('recommend', $options)) {
            switch ($options['recommend']) {
                case 'new':
                    $this->db->where('is_new', 1);
                    break; // 新品
                case 'hot':
                    $this->db->where('is_hot', 1);
                    break; // 热销
                case 'spe':
                    $this->db->where('is_special_price', 1);
                    break; // 特价
                case 'cnd':
                    $this->db->where('is_commend', 1);
                    break; // 推荐
                default:
                    $this->db->where('is_new', 1);
                    ;
            }
        }
        
        if (array_key_exists('main_section', $options)) {
            $this->db->like('main_section', $options['main_section']);
        }
        
        // 是否在首页上显示
        if (array_key_exists('in_wechat', $options)) {
            $this->db->where('in_wechat', $options["in_wechat"]);
        }
        
        // 是否有关键字
        if (array_key_exists('keywords', $options)) {
            $options["keywords"] = trim($options["keywords"], " ");
            $options["keywords"] = preg_replace("/[\s]+/is", " ", $options["keywords"]);
            $keyword = explode(" ", $options["keywords"]);
            $where = "";
            $i = 0;
            foreach ($keyword as $key) {
                if ($i == 0) {
                    $where .= "( upper(p.name) like upper('%" . $key . "%')";
                } else {
                    $where .= " OR upper(p.name) like upper('%" . $key . "%')";
                }
                $i ++;
            }
            $where .= ")";
            $this->db->where($where);
        }
        
        // 是否深度搜索
        if ($cate_id) {
            if (is_array($cate_id)) {
                $this->db->where_in('cat_id', $cate_id);
            } elseif ($cate != null) {
                $this->db->where(' pc.path like "' . $path . '%"', NULL, FALSE);
            }
        }
        
        // 酒店专题页酒店等级搜索
        if (isset($options['rank']) && $options['rank'] != '') {
            $this->db->join('product_attr_value as pav', 'p.id = pav.product_id', 'left');
            $this->db->where('pav.attr_value', $options['rank']);
        }
        
        if ($wherein) {
            if (is_array($wherein)) {
                $this->db->where_in('p.id', $wherein);
            }
        }
        
        $arrtkeys = array_keys($attrs);
        foreach ($arrtkeys as $key => $attr) {
            $this->db->join('(select product_id,attr_id,default_value,attr_value  from 9thleaf_product_attr_value,9thleaf_product_attr where attr_id = 9thleaf_product_attr.id) as a_' . $key, ' p.id=a_' . $key . '.product_id');
            $this->db->where('a_' . $key . '.default_value', $attr);
            $this->db->where('a_' . $key . '.attr_value', $attrs[$attr]);
        }
        if ($app_id) {
            $_app_id = array(
                0,
                $app_id
            );
            $this->db->where_in('p.app_id', $_app_id);
        } else 
            if ($customer_id) {
                $this->db->where('customer_id', $customer_id);
                if ($section_id) {
                    $this->db->like('section_ids', ',' . $section_id . ",");
                }
            }
        
        if ($corporation_id > 0)
            $this->db->where('p.corporation_id', $corporation_id);
        $this->db->where('p.is_on_sale', 1); // 上架的
        $this->db->where('p.is_delete', 0); // 不在回收站的
        $this->db->where('p.is_mc', 0); // 不是二维码商品的
        $this->db->where("p.is_reveal",0);//非部落商品
        if ($offset) {
            $this->db->limit($limit, $offset);
        } elseif ($limit) {
            $this->db->limit($limit);
        }
        
        
        $query = $this->db->get();

        error_log($this->db->last_query());
        
        $return = $query->result_array();
        
        
        
        return $return;
    }

    // --------------------------------------------------------------------

    /**
     *
     * @param number $cate_id
     * @param array $attrs
     * @param array $options
     * @param array $wherein
     * @param number $app_id
     * @param number $customer_id
     * @param number $section_id
     * * @param number $type
     */
    public function get_count_with_condition($cate_id = 0, $attrs = array(), $options = array(), $wherein = array(), $app_id = 0, $customer_id = 0, $section_id = 0, $corporation_id = 0 , $type = 0)
    {
        // 按状态查询
        if (array_key_exists('recommend', $options)) {
            switch ($options['recommend']) {
                case 'new':
                    $this->db->where('is_new', 1);
                    break; // 新品
                case 'hot':
                    $this->db->where('is_hot', 1);
                    break; // 热销
                case 'spe':
                    $this->db->where('is_special_price', 1);
                    break; // 特价
                case 'cnd':
                    $this->db->where('is_commend', 1);
                    break; // 推荐
                default:
                    $this->db->where('is_new', 1);
                    ;
            }
        }

        // 按距离筛选执行
        if ($type) {
            $this->db->where("`latitude` is not null");
        }

        // vip
        if (array_key_exists('is_vip', $options)) {
            $this->db->where('is_vip', $options['is_vip']); // vip
        }

        // mc
        if (array_key_exists('is_mc', $options)) {
            $this->db->where('is_mc', $options['is_mc']); // vip
        }

        if (array_key_exists('in_wechat', $options)) {
            $this->db->where('in_wechat', $options["in_wechat"]);
        }

        // 是否有关键字
        if (array_key_exists('keywords', $options)) {
            $options["keywords"] = trim($options["keywords"]," ");
            $options["keywords"] = preg_replace("/[\s]+/is"," ",$options["keywords"]);
            $keyword = explode(" ", $options["keywords"]);
            $where = "";
            $i = 0;
            foreach ($keyword as $key) {
                if($i==0){
                    $where .= "(upper(name) like upper('%".$key."%')";
                }else{
                    $where .= " OR upper(name) like upper('%".$key."%')";
                }
                $i++;
            }
            $where .= ")";
            $this->db->where($where);
        }

        if ($cate_id) {
            if (is_array($cate_id)) {
                $this->db->where_in('cat_id', $cate_id);
            } else {
                $this->db->where('cat_id', $cate_id);
            }
        }

        $this->db->from('product');

        //酒店专题页酒店等级搜索
        if(isset($options['rank']) && $options['rank']!=''){
            $this->db->join('product_attr_value as pav','product.id = pav.product_id','left');
            $this->db->where('pav.attr_value',$options['rank']);
        }

        $arrtkeys = array_keys($attrs);
        foreach ($arrtkeys as $key => $attr) {
            $this->db->join('(select product_id,attr_id,default_value,attr_value  from 9thleaf_product_attr_value,9thleaf_product_attr where attr_id = 9thleaf_product_attr.id) as a_' . $key, ' p.id=a_' . $key . '.product_id');
            $this->db->where('a_' . $key . '.default_value', $attr);
            $this->db->where('a_' . $key . '.attr_value', $attrs[$attr]);
        }
        if ($app_id) {
            $_app_id = array(0,$app_id);
            $this->db->where_in('app_id', $_app_id);

//             if ($cate_id) {
//                 if (is_array($cate_id)) {
//                     $this->db->where_in('cat_id', $cate_id);
//                 } else {
//                     $this->db->where('cat_id', $cate_id);
//                 }
//             }
        } else
            if ($customer_id) {
                $this->db->where('customer_id', $customer_id);
                if ($section_id) {
                    $this->db->like('section_ids', ',' . $section_id . ",");
                }
            }
        if ($corporation_id > 0)
            $this->db->where('corporation_id', $corporation_id);
        $this->db->where('is_on_sale', 1); // 上架的
        $this->db->where('is_delete', 0); // 不在回收站的
        if ($wherein) {
            if (is_array($wherein)) {
                $this->db->where_in('product.id', $wherein);
            }
        }
        $res = $this->db->count_all_results();
        error_log($this->db->last_query());
        return $res;
    }

    // --------------------------------------------------------------------
    /**
     *
     * @param unknown $cate_id
     * @param unknown $like
     * @param array $options
     * @param unknown $select
     * api 获取搜索总数
     */
    public function get_count_lists_for_search($cate_id, $like, $options = array(), $select,$longitude = 0,$latitude = 0)
    {
        $this->db->select($select);
        
        // 按状态查询
        if (array_key_exists('recommend', $options)) {
            switch ($options['recommend']) {
                case 'new':
                    $this->db->where('is_new', 1);
                    break; // 新品
                case 'hot':
                    $this->db->where('is_hot', 1);
                    break; // 热销
                case 'spe':
                    $this->db->where('is_special_price', 1);
                    break; // 特价
                case 'cnd':
                    $this->db->where('is_commend', 1);
                    break; // 推荐
                case 'in_wechat':
                    $this->db->where('in_wechat', 1);
                    break;
                default:
                    $this->db->where('is_new', 1);
                    break;
            }
        }
        
        if (array_key_exists('order', $options)) {
            switch ($options['order']) {
                case 'price_up':
                    $this->db->order_by('price ASC');
                    break;
                case 'price_down':
                    $this->db->order_by('price DESC');
                    break;
                case 'm_price_up':
                    $this->db->order_by('m_price ASC');
                    break;
                case 'm_price_down':
                    $this->db->order_by('m_price DESC');
                    break;
                case 'onsale_up':
                    $this->db->order_by('on_sale_at ASC');
                    break;
                case 'onsale_down':
                    $this->db->order_by('on_sale_at Desc');
                    break;
                case 'sale_count_up':
                    $this->db->order_by('sales_count ASC');
                    break;
                case 'sale_count_down':
                    $this->db->order_by('sales_count Desc');
                    break;
                case 'recommend_up':
                    $this->db->order_by('is_commend ASC');
                    break;
                case 'recommend_down':
                    $this->db->order_by('is_commend Desc');
                    break;
                case 'distance_up':
                    $this->db->where("latitude is not null");
                    $this->db->where("latitude != 0");
                    // 直角三角形边长公式 c²=a²+b²;a+b!=c
                    $this->db->order_by("ABS('latitude'-" . $latitude . ")*ABS('latitude'-" . $latitude . ")+ABS('longitude'-" . $longitude . ")*ABS('longitude'-" . $longitude . ")", "asc");
                    $distance_arr = array(
                        "SQRT((latitude-" . $latitude . ")*(latitude-" . $latitude . ")+(longitude-" . $longitude . ")*(longitude-" . $longitude . ")) < " => '5000'
                    );
                    $this->db->where($distance_arr);
                    break;
                case 'distance_down':
                    $this->db->where("latitude is not null");
                    $this->db->where("latitude != 0");
                    // 直角三角形边长公式 c²=a²+b²;a+b!=c
                    $this->db->order_by("ABS('latitude'-" . $latitude . ")*ABS('latitude'-" . $latitude . ")+ABS('longitude'-" . $longitude . ")*ABS('longitude'-" . $longitude . ")", "desc");
                    $distance_arr = array(
                        "SQRT((latitude-" . $latitude . ")*(latitude-" . $latitude . ")+(longitude-" . $longitude . ")*(longitude-" . $longitude . ")) < " => '5000'
                    );
                    $this->db->where($distance_arr);
                    break;
                default:
                    $this->db->order_by('on_sale_at DESC');
            }
            $this->db->order_by('id');
        }
        
        $this->db->from('product');
        
        // 分站点
        if ($options['app_id']) {
            $_app_id = array(
                0,
                $options['app_id']
            );
            $this->db->where_in('app_id', $_app_id);
        }
        
        // 企业内部搜索
        if ($options['corporation_id']) {
            $this->db->where('corporation_id', $options['corporation_id']);
        }
        
        // 分类内搜索
        if ($cate_id) {
            if (is_array($cate_id)) {
                $this->db->where_in('cat_id', $cate_id);
            } else 
                if ($cate_id) {
                    $this->db->where('cat_id', $cate_id);
                }
        }
        
        $where = "upper(name) like upper('%" . $like . "%')";
        $this->db->where($where);
        
        $this->db->where('is_on_sale', 1); // 上架的
        $this->db->where('is_delete', 0); // 不在回收站的
        $this->db->where('is_mc', 0); // 不是二维码商品的
        
        $res = $this->db->count_all_results();
        error_log($this->db->last_query());
        return $res;
    }

    /**
     *
     * @param unknown $cate_id
     * @param unknown $like
     * @param array $options
     * @param unknown $select
     */
    public function get_lists_for_search($cate_id, $like, $options = array(), $select,$count=null,$offset=null,$longitude=0,$latitude=0)
    {
        $this->db->select($select);
        
        // 按状态查询
        if (array_key_exists('recommend', $options)) {
            switch ($options['recommend']) {
                case 'new':
                    $this->db->where('is_new', 1);
                    break; // 新品
                case 'hot':
                    $this->db->where('is_hot', 1);
                    break; // 热销
                case 'spe':
                    $this->db->where('is_special_price', 1);
                    break; // 特价
                case 'cnd':
                    $this->db->where('is_commend', 1);
                    break; // 推荐
                case 'in_wechat':
                    $this->db->where('in_wechat', 1);
                    break;
                default:
                    $this->db->where('is_new', 1);
                    break;
            }
        }
        
        if (array_key_exists('order', $options)) {
            switch ($options['order']) {
                case 'price_up':
                    $this->db->order_by('price ASC');
                    break;
                case 'price_down':
                    $this->db->order_by('price DESC');
                    break;
                case 'vip_price_up':
                    $this->db->order_by('vip_price ASC');
                    break;
                case 'vip_price_down':
                    $this->db->order_by('vip_price DESC');
                    break;
                case 'onsale_up':
                    $this->db->order_by('on_sale_at ASC');
                    break;
                case 'onsale_down':
                    $this->db->order_by('on_sale_at Desc');
                    break;
                case 'sale_count_up':
                    $this->db->order_by('sales_count ASC');
                    break;
                case 'sale_count_down':
                    $this->db->order_by('sales_count Desc');
                    break;
                case 'recommend_up':
                    $this->db->order_by('is_commend ASC');
                    break;
                case 'recommend_down':
                    $this->db->order_by('is_commend Desc');
                    break;
                case 'distance_up':
                    $this->db->where("latitude is not null");
                    $this->db->where("latitude != 0");
                    // 直角三角形边长公式 c²=a²+b²;a+b!=c
                    $this->db->order_by("ABS('latitude'-" . $latitude . ")*ABS('latitude'-" . $latitude . ")+ABS('longitude'-" . $longitude . ")*ABS('longitude'-" . $longitude . ")", "asc");
                    $distance_arr = array(
                        "SQRT((latitude-" . $latitude . ")*(latitude-" . $latitude . ")+(longitude-" . $longitude . ")*(longitude-" . $longitude . ")) < " => '5000'
                    );
                    $this->db->where($distance_arr);
                    break;
                case 'distance_down':
                    $this->db->where("latitude is not null");
                    $this->db->where("latitude != 0");
                    // 直角三角形边长公式 c²=a²+b²;a+b!=c
                    $this->db->order_by("ABS('latitude'-" . $latitude . ")*ABS('latitude'-" . $latitude . ")+ABS('longitude'-" . $longitude . ")*ABS('longitude'-" . $longitude . ")", "desc");
                    $distance_arr = array(
                        "SQRT((latitude-" . $latitude . ")*(latitude-" . $latitude . ")+(longitude-" . $longitude . ")*(longitude-" . $longitude . ")) < " => '5000'
                    );
                    $this->db->where($distance_arr);
                    break;
                default:
                     $this->db->order_by('sequence,hits,on_sale_at' ,'DESC');
                    break;
            }
            $this->db->order_by('id');
        }
        
        if ($count) {
            $this->db->limit($count, $offset);
        }
        
        $this->db->from('product');
        
        // 分站点
        if ($options['app_id']) {
            $_app_id = array(
                0,
                $options['app_id']
            );
            $this->db->where_in('app_id', $_app_id);
        }
        
        // 企业内部搜索
        if ($options['corporation_id']) {
            $this->db->where('corporation_id', $options['corporation_id']);
        }
        
        // 分类
        if ($cate_id) {
            if (is_array($cate_id)) {
                $this->db->where_in('cat_id', $cate_id);
            } else 
                if ($cate_id) {
                    $this->db->where('cat_id', $cate_id);
                }
        }
        
        $where = "upper(name) like upper('%" . $like . "%')";
        $this->db->where($where);
        
        $this->db->where('is_on_sale', 1); // 上架的
        $this->db->where('is_delete', 0); // 不在回收站的
        $this->db->where('is_mc', 0); // 不是二维码商品的
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * 最新产品
     */
    public function new_arrival($app_id = 0)
    {
        $this->db->select('p.*, i.width, i.height, i.file,i.image_name,i.file_ext');
        $this->db->from('product p');
        $this->db->join('product_image i', 'i.product_id = p.id and i.is_base', 'left');
        if ($app_id === 0) {
            $this->db->join('product_cat c', 'p.cat_id = c.id', 'right');
        } else {
            $this->db->join('product_cat c', 'p.cat_id = c.id and c.app_id =' . $app_id, 'right');
        }
        $this->db->where('p.is_on_sale', 1); // 上架的
        $this->db->where('p.is_delete', 0); // 不在回收站的
        $this->db->order_by('p.updated_at', 'DESC');
        $this->db->limit(10);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * 拆单app_id
     *
     * @param unknown $all_ids
     */
    public function get_app_id($all_ids)
    {
        $this->db->distinct("app_id");
        $this->db->from("product");
        $this->db->where_in($all_ids);

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * 拆单统计app_id
     *
     * @param unknown $all_ids
     */
    public function count_app_id($all_ids)
    {
        $this->db->select("count(distinct app_id) as total");
        $this->db->from("product");
        $this->db->where_in("id", $all_ids);

        $query = $this->db->get();

        $rows = $query->row_array();

        error_log($this->db->last_query());

        return $rows['total'];
    }

    /**
     * 最新产品
     */
    public function getRequirementList($offset, $num, $app_id = 0, $key = '', $cate_id = 0, $begindate = '', $enddate = '', $grade = -1)
    {
        $this->db->select('a.*, c.name as cate_name,cc.corp_name,cc.grade');
        $this->_requestmentList($app_id, $key, $cate_id = 0, $begindate, $enddate, $grade);
        $this->db->order_by('a.updated_at', 'DESC');
        $this->db->limit(20);
        $query = $this->db->get();
        return $query->result_array();
    }

    private function _requestmentList($app_id = 0, $key = '', $cate_id = 0, $begindate = '', $enddate = '', $grade = -1)
    {
        $this->db->from('product a');

        if ($app_id === 0) {
            $this->db->join('product_cat c', 'a.cat_id = c.id', 'left');
        } else {
            $this->db->join('product_cat c', 'a.cat_id = c.id and c.app_id =' . $app_id, 'left');
        }

        if ($grade != - 1) {
            $this->db->join('customer_corporation_view cc', 'cc.customer_id = a.customer_id and cc.grade = ' . $grade, 'left');
        } else {
            $this->db->join('customer_corporation_view cc', 'cc.customer_id = a.customer_id', 'left');
        }

        if ($begindate != '') {
            $this->db->where('a.on_sale_at >=', $begindate);
        }

        if ($enddate != '') {
            $this->db->where('a.on_sale_at <=', $enddate);
        }

        $this->db->where('a.is_on_sale', 1); // 上架的
        $this->db->where('a.is_delete', 0); // 不在回收站的
    }

    // --------------------------------------------------------------------

    /**
     *
     * @param number $app_id
     * @param string $key
     * @param number $cate_id
     * @param string $begindate
     * @param string $enddate
     * @param unknown $grade
     */
    public function countRequirementList($app_id = 0, $key = '', $cate_id = 0, $begindate = '', $enddate = '', $grade = -1)
    {
        $this->_requestmentList($app_id, $key, $cate_id = 0, $begindate, $enddate, $grade);
        
        return $this->db->count_all_results();
    }

    // --------------------------------------------------------------------

    /**
     * 根据关键字搜索产品的类目
     *
     * @param unknown $keywords
     */
    public function get_categorys_with_keyword($keywords)
    {
        $keyword = explode(" ", trim($keywords));
        $this->db->distinct();
        $this->db->select('pc.name as cate_name, p.cat_id as cate_id');
        $this->db->from('product p');
        $this->db->join('product_cat pc', 'p.cat_id = pc.id', 'left');
        foreach ($keyword as $key) {
            if(!empty($key)){
            $this->db->or_like('p.name', $key);
            }
        }

        $query = $this->db->get();
        
        return $query->result_array();
    }

    // --------------------------------------------------------------------

    /**
     * 旧版
     * 根据顶层菜单查询产品列表
     *
     * @param unknown $cate_id
     */
    public function get_goods_with_top_category($ids,$perpage=null,$offset=null)
    {
        if($perpage!=null||$offset!=null){
            $this->db->limit($perpage,$offset);
        }

        $org_id = implode(",", $ids);


        $this->db->select('p.*, i.width, i.height, i.file,i.image_name,i.file_ext');
        $this->db->from('product p');

        $this->db->join('product_cat c', 'p.cat_id = c.id', 'left');


        $where_string = "p.is_on_sale = 1 and p.is_delete = 0";

        if (! is_array($org_id)) {

            // $this->db->like('c.path', $org_id, 'after');
            $sp_id = explode(',', $org_id);

        } // else {
        if (count($sp_id) < 2) {
            $sp_id = array($org_id);
        }
        $i = 0;
        foreach ($sp_id as $cat_id) {
            if ($i == 0) {
                $where_string .= " and ( c.path like '".$cat_id."%'";
                //$this->db->like('c.path', $cat_id, 'after');
            } else {
                //$this->db->or_like('c.path', $cat_id, 'after');
                $where_string .= " or c.path like '".$cat_id."%'";
            }
            $i ++;
        }
        $where_string .= ")";

        //echo $where_string;
        $this->db->where('p.is_mc','0');
        $this->db->where ( $where_string ); // 默认图片
        // $this->db->where_in('cat_id', $str_id);
        // $this->db->where ( 'i.is_base', 1 ); // 默认图片
        $this->db->order_by('p.updated_at', 'DESC');
        $this->db->limit(100);

        $query = $this->db->get();
        error_log($this->db->last_query());

        return $query->result_array();
    }

    // --------------------------------------------------------------------

    /**
     * 新版
     * 根据顶层菜单查询产品列表
     *
     * @param unknown $cate_id
     */
    public function get_goods_with_top_category_array($ids,$perpage=null,$offset=null)
    {
        $this->db->select(' a.id as cat_id ,b.*');
        $this->db->from('product_cat a');
        $this->db->join('product_attr b','a.attr_set_id = b.attr_set_id');
        $this->db->where('a.id',$ids);
        $this->db->where('iscondition',1);
        $this->db->where('option_values is not NULL');
        $query = $this->db->get();
        
        return $query->result_array();


    }



    // --------------------------------------------------------------------

    /**
     * 根据企业id搜索产品的类目
     *
     * @param unknown $corp_id
     */
    public function get_categorys_with_corp($corp_id)
    {
        $this->db->distinct();
        $this->db->select('pc.name as cate_name, p.cat_id as cate_id');
        $this->db->from('product p');
        $this->db->join('product_cat pc', 'p.cat_id = pc.id', 'left');
        $this->db->where('p.corporation_id', $corp_id);
        $this->db->where('p.is_mc','0');
        $query = $this->db->get();
//         echo $this->db->last_query();
        return $query->result_array();
    }

    /**
     * 查询店铺是否被收藏
     * @param unknown $user_id 用户id
     * @param unknown $corp_id 店铺id
     */
    public function check($user_id, $corp_id)
    {
        $this->db->select();
        $query = $this->db->get_where('favourites_corporation', array(
            'corporation_id' => $corp_id,
            'customer_id' => $user_id
        ));
        return $query->row_array();
    }

    /**
     * 添加店铺收藏
     * @param unknown $user_id 用户id
     * @param unknown $corp_id 店铺id
     */
    public function add_corporation($user_id, $corp_id)
    {
        $this->db->set('corporation_id', $corp_id);
        $this->db->set('customer_id', $user_id);
        $this->db->set('created_at', date('Y-m-d H:i:s'));
        $this->db->insert('favourites_corporation');
        return $this->db->insert_id();
    }

    /**
     * 最新的供应信息
     * @param int $cate_id 分类id
     */
    function latestproduct($cate_id,$app_id){
        $this->db->select('a.*');
        $this->db->from('product a');
        $this->db->join('product_cat b','b.id=a.cat_id','left');
        $this->db->where('a.stock >',0);
        $this->db->where('a.is_on_sale',1);
        $this->db->where('a.is_delete',0);
        $this->db->where('a.is_mc',0);
        $this->db->where('a.app_id',$app_id);
        $this->db->like('path',$cate_id.',','after');
        $this->db->order_by('a.on_sale_at','DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        error_log($this->db->last_query());
        return $query->result_array();
    }

    /**
     * 搜索分类
     * @param unknown $keyword
     * @param unknown $status
     */
    function get_count_cat_total ($keyword,$parameter,$limit=null,$offset=null,$status=null,$app_id=0,$pid=array()){
        $_app_id = array(0,$app_id);
        $keyword = explode(' ',trim($keyword));
        $catid = array();

        //搜索关键词查询分类
        $this->db->select('id');
        $this->db->from('product_cat');
        foreach ($keyword as $v){
            if(!empty($v)){
                $this->db->or_like('name',$v);
            }
        }
        $query = $this->db->get();
        foreach ($query->result_array() as $v){
            $catid[] = $v['id'];
        }


        //查询分类下面的子分类
        if($catid){
            $query = $this->db->select('id')->from('product_cat')->where_in('parent_id',$catid)->get();
            foreach ($query->result_array() as $v){
                $catid[] = $v['id'];
            }

            //查询分类下的商品
            $this->db->select($parameter);
            $this->db->from('product a');
            $this->db->join('product_image c','c.product_id = a.id and c.is_base = 1 ','left');
            $mark = $this->mark;//唯一识别
            //查询商品总评价数量
            if($mark=='search'){
                $this->db->join('(SELECT oi.product_id,count(oi.product_id) as comment_total FROM 9thleaf_order_comments AS oc JOIN 9thleaf_order_item AS oi on oc.orderitem_id = oi.id GROUP BY oi.product_id) oc','oc.product_id=a.id','left');
            }
            $this->db->where('a.is_mc',0);
            $this->db->where('a.is_on_sale',1);
            $this->db->where('a.is_delete',0);
            if($app_id){
            $this->db->where_in('a.app_id',$_app_id);
            }
            if($pid){
                $this->db->where_not_in('a.id',$pid);
            }
            if($catid){
            $this->db->where_in('a.cat_id',$catid);
            }
            $limit?$this->db->limit($limit,$offset):null;
            $this->db->order_by('a.id');
            $query = $this->db->get();
            return $status?$query->result_array():$query->num_rows();
        }
        return $status?array():0;
    }

    /**
     * 根据顶层菜单查询下级所有商品
     */
    public function get_cat_property($cat_string,$product_string=null,$search_val=null,$statu=null,$price=array(),$limit = null,$offset = null){

        $product_id = $product_string ? "and a.id in ($product_string)" : ''; //商品ID

        $like = $search_val ? "where (v.attr_value like '%$search_val%' or v.name like '%$search_val%')":'';//搜索参数

        $page = $limit ? "limit $offset,$limit" : ''; //分页参数


        $app = '';
        if($this->session->userdata('app_info')['id']){ //分站条件查询
            $app_id = '0';
            $app_id .= !empty($this->session->userdata('app_info')['id']) ? ','.$this->session->userdata('app_info')['id'] : '';
            $app = "and a.app_id in ($app_id)";
        }

        //价格区间
        $price_where = '';
        if(count($price) > 0){
            $price_where = $like ? 'and' : 'where'; //和like 共存或者其一不共存时判断,该使用那个。
            $price_where .= isset($price['form_price']) ? ' v.vip_price >= '.$price['form_price'].' and v.vip_price <= '.$price['to_price'].' ' : ' v.vip_price '.$price['symbol'].' '.$price['to_price'].'';
        }

        $where = "a.is_mc = '0' and a.is_on_sale = 1 and a.is_delete = '0'";//商品查询必须条件。

        $query = $this->db->query("SELECT * from (select `a`.*, group_concat(pav.attr_value) as attr_value, `cr`.`corporation_name` FROM (`9thleaf_product` a) JOIN `9thleaf_product_cat` b ON `b`.`id` = `a`.`cat_id` JOIN `9thleaf_customer_corporation` as cr ON `cr`.`id` = `a`.`corporation_id` left join 9thleaf_product_attr_value as pav on pav.`product_id` = a.id
            WHERE $where and `a`.`cat_id` IN ($cat_string) $product_id $app group by a.id ) as v $like $price_where  order by v.`updated_at` desc $page
        ");
//        echo $this->db->last_query().'<br/>';
        return $statu?$query->num_rows():$query->result_array();
    }


    /**
     * 根据分类id查找子分类
     */
    public function get_sub_classification($cate_id){
        if(!$cate_id){
            return array();
        }
        $row = $this->db->where('id',$cate_id)->get('product_cat')->row_array();

        if($row){
            $result = $this->db->select('id,name')->like('path',$row['path'].',','after')->get('product_cat')->result_array();
            return $result;
        }else{
            return array();
        }
    }
    
    /**
     * 优惠卷相关商品
     * @param int $p_id 卡包id
     * @return array $result
     */
    public function  discount_goods($p_id,$app_id){
        $this->db->select("a.id,a.vip_price,a.name,a.goods_thumb,a.sales_count,a.longitude,a.latitude");
        $this->db->from("product as a");
        $this->db->join("package_item as b","a.id = b.product_id or a.cat_id = b.cate_id");
        $this->db->join("package as c","c.id = b.package_id");
        $this->db->where("b.package_id",$p_id);
        $this->db->where("c.corporation_id = a.corporation_id");
        $this->db->where("c.status",3);
        $this->db->where('a.is_on_sale',1);
        $this->db->where('a.is_delete',0);
        $this->db->where('a.is_mc',0);
        $this->db->where('a.app_id',$app_id);
        
        $this->db->order_by("sales_count","desc");//默认销量最高
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
    
    /**
     * 获取商品
     * 将B端产品复制到C端
     *
     */
    function loadprotoc($id){
        $this->db->select('*');
        $this->db->where('id',$id);
        $this->db->from('product');
        $query = $this->db->get()->row_array();
        return $query;
    }
    function loadskutoc($id){
        $this->db->select('*');
        $this->db->where('product_id',$id);
        $this->db->from('product_sku');
        $query = $this->db->get()->result_array();
        return $query;
    }
    function loadsku_valuetoc($id){
        $this->db->select("*");
        $this->db->where('id',$id);
        $this->db->from('product_sku_value');
        $query = $this->db->get()->row_array();
        return $query;
    }
    
    function loadattrtoc($id){
        $this->db->select("*");
        $this->db->where('product_id',$id);
        $this->db->from('product_attr_value');
        $query = $this->db->get()->result_array();
        return $query;
    }
    function loadimgtoc($id){
        $this->db->select('*');
        $this->db->where('product_id',$id);
        $this->db->from('product_image');
        $query = $this->db->get()->result_array();
        return $query;
    }

    
    //--------------------------新版搜索（锋）----------------------------------
    /**
     * 关键词模糊查询分类名称
     * @param array $keyword 搜索关键词
     */
    public function get_class($keyword){
        $catid = array();
        //搜索关键词查询分类
        $this->db->select('id');
        $this->db->from('product_cat');
        
        //拼接sql
        $where = '(';
        foreach ($keyword as $k => $v){
                if ($k == 0) {
                    $where .= "upper(name) like upper('%".$v."%')";
                } else {
                    $where .= " OR upper(name) like upper('%".$v."%')";
                }
        }
        $where .= ')';
        $this->db->where($where);
        
        $query = $this->db->get();
        foreach ($query->result_array() as $v){
            $catid[] = $v['id'];
        }
        return $catid;


    }
    
    //------------------------------------------------------------------------------------
    
    /**
     * 查询子分类id
     * @param array $catid 父级分类id
     */
    function get_son_cateid($catid){
        $this->db->select('id');
        $this->db->from('product_cat');  
        
        //拼接sql
        $where = "(";
        foreach ($catid as $k => $v){
            if($k==0){
                $where .= "FIND_IN_SET($v,path ) ";
            }else{
                $where .= " OR FIND_IN_SET($v,path )";
            }
        }
        $where .= ")";
        $this->db->where($where);
        $this->db->order_by("id");
        $query = $this->db->get();
        $son_cateid = array();
        foreach ($query->result_array() as $v){
            $son_cateid[] = $v['id'];
        }
        return $son_cateid;   
    }
    
    //------------------------------------------------------------------------------------
     /**
     * 模式1：只有分类模式：系统将忽略关键字内容，并且深度查询分类，排除仅部落显示的商品
     * @param array $catid 分类id
     * @param int $type 类型
     * @param string $longitude 经度
     * @param string $latitude 纬度
     */
    function get_productOne($catid,$limit=null,$offset=null,$type=null,$longitude=null,$latitude=null){
        if(!$catid){
            return array();
        }
        $appid = $this->session->userdata('app_info')['id'];
        $this->db->select('a.id,a.cat_id,a.name,a.short_desc,a.vip_price,a.goods_thumb,a.tribe_price,group_concat(b.tribe_id) as tribe_id');
        $this->db->from("product as a");
        $this->db->join("product_tribe as b","a.id = b.product_id","left");
        $this->db->where_in('a.cat_id',$catid);
        $this->db->where('a.is_on_sale',1);
        $this->db->where('a.is_delete',0);
        $this->db->where('a.is_mc',0);
        $this->db->where("a.is_reveal",0);
        if($appid){
            $this->db->where_in('a.app_id',array(0,$appid));
        }
        
        $this->_product_sort($type,$longitude,$latitude);//搜索商品私有方法，根据不同状态排序商品
        $this->db->group_by("a.id");
        $this->db->order_by('a.id','desc');
        if($limit){
            $this->db->limit($limit,$offset);
            return $this->db->get()->result_array();
        }else{
            return  $this->db->get()->num_rows();
        }

    }

    
    
    
    /**
     * 模式2：关键字搜索商品+关键词搜索分类,并且深度查询分类模式：排序关键词商品－>分类商品，系统将显示分类列表，以及整个产品库查询，排除仅部落显示的商品
     * @param array $keyword 搜索关键词
     * @param array $catid 分类id
     * @param int $type 类型
     * @param string $longitude 经度
     * @param string $latitude 纬度
     */
    function get_productTow($keyword,$catid=0,$limit=null,$offset=0,$type=null,$longitude=null,$latitude=null){
        $appid = $this->session->userdata('app_info')['id'];
        $this->db->select('a.id,a.cat_id,a.name,a.short_desc,a.vip_price,a.goods_thumb,a.tribe_price,group_concat(b.tribe_id) as tribe_id');
        $this->db->from("product as a");
        $this->db->join("product_tribe as b","a.id = b.product_id","left");
        //拼接sql
        $where = "(";
        foreach ($keyword as $k => $v){
            if ($k == 0) {
                $where .= "(upper(a.name) like upper('%".$v."%')";
            } else {
                $where .= " OR upper(a.name) like upper('%".$v."%')";
            }
        }
        $where .= ")";
        if($catid){
            foreach ($catid as $k => $v){
                if ($k == 0) {
                    $where .= " OR a.cat_id in ( '$v'";
                } else {
                    $where .= ",'$v'";
                }
            }
            $where .= ")";
        }
        $where .= ")";
        $this->db->where($where);
        
        $this->db->where('a.is_on_sale',1);
        $this->db->where('a.is_delete',0);
        $this->db->where('a.is_mc',0);
        $this->db->where("a.is_reveal",0);
        if($appid){
            $this->db->where_in('a.app_id',array(0,$appid));
        }
        

        $this->_product_sort($type,$longitude,$latitude);//搜索商品私有方法，根据不同状态排序商品

        $this->db->group_by("a.id");
        $this->db->order_by('a.id','desc');
        if($limit){
            $this->db->limit($limit,$offset);
            return  $this->db->get()->result_array();
        }else{
            return  $this->db->get()->num_rows();
        }
    }
    
    
    /**
     * 模式3：有关键字和有分类,并且深度查询分类模式：系统将根据关键字和分类清晰定位数据，筛选显示属性，排除仅部落显示的商品
     * @param array $keyword 搜索关键词
     * @param array $catid 分类id
     * @param int $type 类型
     * @param string $longitude 经度
     * @param string $latitude 纬度
     */
    function get_productThree($keyword,$catid,$limit=null,$offset=null,$type=null,$longitude=null,$latitude=null){
        $appid = $this->session->userdata('app_info')['id'];
        $this->db->select('a.id,a.cat_id,a.name,a.short_desc,a.vip_price,a.goods_thumb,a.tribe_price,group_concat(b.tribe_id) as tribe_id');
        $this->db->from("product as a");
        $this->db->join("product_tribe as b","a.id = b.product_id","left");
        //拼接sql
        foreach ($keyword as $k => $v){
            if ($k == 0) {
                $where = "(upper(a.name) like upper('%".$v."%')";
            } else {
                $where .= " OR upper(a.name) like upper('%".$v."%')";
            }
        }
        $where .= ")";
        $this->db->where($where);
        $this->db->where_in("a.cat_id",$catid);
        $this->db->where('a.is_on_sale',1);
        $this->db->where('a.is_delete',0);
        $this->db->where('a.is_mc',0);
        $this->db->where("a.is_reveal",0);
        if($appid){
            $this->db->where_in('a.app_id',array(0,$appid));
        }
        
        $this->_product_sort($type,$longitude,$latitude);//搜索商品私有方法，根据不同状态排序商品
        $this->db->group_by("a.id");
        $this->db->order_by('a.id','desc');
        if($limit){
            $this->db->limit($limit,$offset);
            return  $this->db->get()->result_array();
        }else{
            return  $this->db->get()->num_rows();
        }
    }
    
    
    
    /**
     * 模式4：根据部落id和关键词，搜索部落企业的所有的商品
     * @param array $tribe_id 部落id
     * @param array $keyword 搜索关键词
     * @param int $type 类型
     * @param string $longitude 经度
     * @param string $latitude 纬度
     */
    function get_productFour($tribe_id,$keyword,$limit=null,$offset=null,$type=null,$longitude=null,$latitude=null){
        $appid = $this->session->userdata('app_info')['id'];
        $this->db->select("a.id,a.cat_id,a.name,a.short_desc,a.vip_price,a.goods_thumb,a.tribe_price,$tribe_id as tribe_id");
        $this->db->from("product as a");
        $this->db->join("product_tribe as b","a.id = b.product_id");
        $this->db->join("product_sales_view as c","c.id=a.id");
        $this->db->where("b.tribe_id",$tribe_id);
        $this->db->where("a.is_on_sale",1);
        $this->db->where("a.is_mc",0);
        $this->db->where("a.is_delete",0);
        //拼接sql
        foreach ($keyword as $k => $v){
            if ($k == 0) {
                $where = "(upper(a.name) like upper('%".$v."%')";
            } else {
                $where .= " OR upper(a.name) like upper('%".$v."%')";
            }
        }
        $where .= ")";
        $this->db->where($where);
        
        if($appid){
            $this->db->where_in('a.app_id',array(0,$appid));
        }
        $this->_product_sort($type,$longitude,$latitude,true);
        if($type==1){
            $this->db->order_by("c.sales","desc");
        }else{
            $this->db->order_by("a.id","desc");
        }
        
        if($limit){
            $this->db->limit($limit,$offset);
            return $this->db->get()->result_array();
        }else{
            return $this->db->get()->num_rows();
        }


    }
    
    
    
    /**
     * 模式5：没有任何关键词和分类，查询整个商品库。
     */
    public function get_productFives($limit=null,$offset=null,$type=null,$longitude=null,$latitude=null){
        $this->db->select('a.id,a.cat_id,a.name,a.short_desc,a.vip_price,a.goods_thumb,a.tribe_price,group_concat(b.tribe_id) as tribe_id');
        $this->db->from("product as a");
        $this->db->join("product_tribe as b","a.id = b.product_id","left");
        $this->db->where("a.is_on_sale",1);
        $this->db->where("a.is_mc",0);
        $this->db->where("a.is_delete",0);
        $this->db->where("a.is_reveal",0);
        $this->db->limit($limit,$offset);
        $this->_product_sort($type,$longitude,$latitude);
        $this->db->group_by("a.id");
        $this->db->order_by('a.id','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
    /**
     * 模式6 APP专用
     * @param string $select  APP查询数据
     * @param string $keyword  APP查询关键词
     * @param string $search_type  APP查询关键词  0 某个分类下关键字模糊搜索  1全部商品分类关键字模糊搜索
     * @param string $corporation_id  店铺ID
     * 
     */
   public function  get_productApp($catid,$limit=null,$offset=null,$type=null,$longitude=null,$latitude=null,$keyword = null,$search_type = null,$corporation_id = null){
       if(!$search_type && !$corporation_id){
           if(!$catid){
               return array();
           }
       }
       
       $appid = $this->session->userdata('app_info')['id'];
       $this->db->select(' any_value(a.id) as id , any_value(a.cat_id) as cat_id , any_value(a.name) as name, any_value(a.market_price) as market_price, any_value(a.vip_price) as vip_price, any_value(a.is_hot) as is_hot, any_value(a.is_new) as is_new, any_value(a.is_commend) as is_commend, any_value(a.goods_thumb) as goods_thumb, any_value(a.longitude) as longitude, any_value(a.latitude) as latitude');
       $this->db->from("product as a");
       $this->db->where('a.is_on_sale',1);
       $this->db->where('a.is_delete',0);
       $this->db->where('a.is_mc',0);
       $this->db->where("a.is_reveal",0);
       if($appid){
           $this->db->where_in('a.app_id',array(0,$appid));
       }
       if(!$search_type && !$corporation_id){
           $this->db->where_in('a.cat_id',$catid);
       }
       if($corporation_id){
           $this->db->where('a.corporation_id',$corporation_id);
       }
       if($keyword){
           $this->db->like('a.name',$keyword);
       }
       
       $this->_product_sort($type,$longitude,$latitude);//搜索商品私有方法，根据不同状态排序商品
       
       $this->db->group_by('a.id');
       $this->db->order_by('a.id','desc');
       
       if($limit){
           $this->db->limit($limit,$offset);
           return $this->db->get()->result_array();
       }else{
           return  $this->db->get()->num_rows();
       }
      
   }
    
    /**
     * 搜索商品私有方法，根据不同状态排序商品
     * @param int $type 类型：1,2销量，3,4评论，5,6距离, 7,8价格
     * @param string $longitude 经度
     * @param string $latitude 纬度
     * @param int $is_tribe  识别是否部落处理
     */
    private function _product_sort($type,$longitude,$latitude,$is_tribe = false){
        switch ($type){
            case "1"://销量
            case "2":
                $this->db->select('any_value(oi.quantity) as sales');
                $this->db->join('order_item as oi','oi.product_id = a.id ','left');
                $this->db->join('order as o', 'oi.order_id = o.id and o.status in(7,9,14)','left');
                $this->db->order_by("sales",$this->sequence['sequence']);
                break;
            case "3"://评论
            case "4":
                $this->db->select('count(oc.id) as comment');
                $this->db->join('order_item as oi','oi.product_id = a.id ','left');
                $this->db->join('order_comments as oc', 'oc.orderitem_id = oi.id','left');
                $this->db->order_by("comment",$this->sequence['sequence']);
                break;
            case "5"://距离
            case "6":
                $this->db->select("round(6378.138*2*asin(sqrt(pow(sin( ('$latitude'*pi()/180-a.latitude*pi()/180)/2),2)+cos('$latitude'*pi()/180)*cos(a.latitude*pi()/180)* pow(sin( ('$longitude'*pi()/180-a.longitude*pi()/180)/2),2)))*1000) AS distance");
                $this->db->where("a.latitude >",0);
                $this->db->where("a.longitude >",0);
                $this->db->order_by("distance",$this->sequence['sequence']);
                break;
            case "7"://价格  
            case "8":
                if($is_tribe){
                    $this->db->order_by("a.tribe_price",$this->sequence['sequence']);
                }else{
                    $this->db->order_by("a.vip_price",$this->sequence['sequence']);
                }
                break;
            case "9":
                $this->db->order_by("a.updated_at",$this->sequence['sequence']);
                break;
            case "10":
                $this->db->order_by("a.sequence",$this->sequence['sequence']);
                break;
        }
    }
    
    //------------------------------------------------------------------------------------
    

    /**
     * 查询商品和sku信息
     * @param array $product_array 商品id
     * @param string $sku_string skuid
     */
    public function load_goods_sku($product_array,$sku_string){
        $this->db->select("a.*,b.id as sku_id,b.sku_name,b.stock as sku_stock,b.m_price as sku_m_price,b.special_offer,b.tribe_price as sku_tribe_price");
        $this->db->from("product as a");
        $this->db->join("(select any_value(a.product_id) as product_id ,any_value(a.sku_name) as sku_name,b.* from 9thleaf_product_sku as a join 9thleaf_product_sku_value as b on a.val_id = b.id where a.val_id in ($sku_string) group by b.id) as b","a.id=b.product_id","left");
        $this->db->where_in("a.id",$product_array);
        return $this->db->get()->result_array();
    }

    // ------------------------------------------------------------------------------------------------
    
    /**
     * 获取商品信息
     * @param int $product_id 商品id
     * @param int $sku_id sku_id
     */
    public function get_id_sku($product_id,$sku_id){
        $this->db->select("a.tribe_price,a.corporation_id,a.name,a.goods_thumb,a.is_special_price,a.special_price_start_at,a.special_price_end_at");
        $this->db->select("c.stock,c.m_price as vip_price,c.special_offer as special_price");
        $this->db->select("group_concat(concat_ws(':',d.attr_name,b.sku_name) separator '；') as sku");
        $this->db->from("product as a");
        $this->db->join("product_sku as b","a.id=b.product_id and b.val_id = $sku_id");
        $this->db->join("product_sku_value as c","b.val_id = c.id");
        $this->db->join("product_attr as d","b.attr_id = d.id");
        $this->db->where("a.id",$product_id);
        $this->db->where("a.is_mc", 0);
        $this->db->where("a.is_on_sale", 1);
        $this->db->where("a.is_delete", 0);
        $this->db->group_by("a.id");
        $query = $this->db->get();
        return $query->row_array();
    
    }
    
    // ------------------------------------------------------------------------------------------------
    
    /**
     * 获取购物车商品信息
     * @param array $data 商品信息集合
     */
    public function getShoppingCart($data){
        $sql = "";
        foreach ($data as $v){
            if($v["sku_id"]){
                $select = "a.id,a.name,a.is_on_sale,a.is_special_price,a.special_price_start_at,a.special_price_end_at,a.is_delete,a.goods_thumb,";
                $select .= "c.stock,c.m_price as vip_price,c.special_offer as special_price,b.val_id as sku_id,c.tribe_price";
                $sql .= "select $select from 9thleaf_product as a
                        left join 9thleaf_product_sku as b on a.id = b.product_id and b.val_id = ".$v["sku_id"]."
                        left join 9thleaf_product_sku_value as c on b.val_id = c.id
                        where a.id = ".$v["product_id"]."
                        group by a.id
                        union all ";
            }else{
                $sql .= "select id,name,is_on_sale,is_special_price,special_price_start_at,special_price_end_at,is_delete,goods_thumb,stock,vip_price,special_price,0 as sku_id,tribe_price from 9thleaf_product  where id = ".$v["product_id"]." union all ";
            }
        }
        $sql = trim($sql,"union all ");
        return $this->db->query($sql)->result_array();
    
    
    }   
        

}